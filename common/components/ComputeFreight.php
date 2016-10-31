<?php
/**
 * 运费计算
 */
class ComputeFreight
{
    /**
     * 查询缓存
     */
    /** @var  查询运输方式 */
    private static  $freightTypes;
    /** @var 区域运费  */
    private static  $freightAreas;
    /**
     * 计算运费
     * @param int $tmpId freight_template_id  运费模板id
     * @param float $size 体积
     * @param float $weight 重量
     * @param int $city_id 购买者所在的城市id
     * @param int $valuation_type 计费方式 1按件数，2按重量，3按体积
     * @param int $quantity 商品数量
     * @return array Array (
     *                   [1] => Array ( [name] => 快递 [fee] => 210 )
     *                  [3] => Array ( [name] => 平邮 [fee] => 64 )
     *                  [2] => Array ( [name] => EMS [fee] => 0 ) )
     */
    public static function compute($tmpId, $size, $weight, $city_id, $valuation_type, $quantity = 1)
    {
        if(isset(self::$freightTypes[$tmpId])){
            $freightTypes = self::$freightTypes[$tmpId];
        }else{
            $freightTypes = FreightType::getFreightType($tmpId);
            self::$freightTypes[$tmpId] = $freightTypes;
        }
        /** @var $v  FreightType */
        $typeIds = array(); //运费类型id
        foreach ($freightTypes as $k => $v) {
            $typeIds[$k] = $v['id'];
        }
        $typeIdsKey = md5(json_encode($typeIds));
        if(isset(self::$freightAreas[$typeIdsKey])){
            $freightAreas = self::$freightAreas[$typeIdsKey];
        }else{
            $freightAreas = FreightArea::getFreightType($typeIds);
            self::$freightAreas[$typeIdsKey] = $freightAreas;
        }
        $areaArr = array(); //每种货运方式对应的城市计费方式
        if ($freightAreas) {
            foreach ($freightAreas as $v) {
                if ($v['location_id'] == $city_id) {
                    $areaArr[] = $v;
                }
            }
        }
        //合并地区运费计算模板
        foreach ($freightTypes as &$v) {
            if (!empty($areaArr)) {
                foreach ($areaArr as $v2) {
                    if ($v2['freight_type_id'] == $v['id']) {
                        $v2['mode'] = $v['mode'];
                        $v = $v2;
                    }
                }
            }
        }
        //var_dump($freightTypes);
        //计算各种运输方式的运费
        $freight = array();
        foreach ($freightTypes as $v3) {
            switch ($valuation_type) {
                case FreightTemplate::VALUATION_TYPE_BULK: //按体积
                    $freight[$v3['mode']] = array(
                        'name' => FreightType::mode($v3['mode']),
                        'fee' => self::computeDetail($size*$quantity, $v3['default'], $v3['default_freight'], $v3['added'], $v3['added_freight'])
                    );
                    break;
                case FreightTemplate::VALUATION_TYPE_WEIGHT: //按重量
                    $freight[$v3['mode']] = array(
                        'name' => FreightType::mode($v3['mode']),
                        'fee' => self::computeDetail($weight*$quantity, $v3['default'], $v3['default_freight'], $v3['added'], $v3['added_freight'])
                    );
                    break;
                case FreightTemplate::VALUATION_TYPE_NUM: //按件数
                    $freight[$v3['mode']] = array(
                        'name' => FreightType::mode($v3['mode']),
                        'fee' => self::computeDetail($quantity, $v3['default'], $v3['default_freight'], $v3['added'], $v3['added_freight'])
                    );
                    break;
            }
        }
        ksort($freight);
        return $freight;
    }


    /**
     * 具体的运费计算
     * @param float $var 总量： 重量、体积、件数
     * @param float $default 首量
     * @param float $default_freight 首费
     * @param float $added 续量
     * @param float $added_freight 续费
     * @return float
     */
    public static function computeDetail($var, $default, $default_freight, $added, $added_freight)
    {
        $added = ($added==0.00 ||$added==0) ? 1 : $added;
        //如果 总量 <= 首量，费用 = 首费
        if ($var <= $default) {
            return $default_freight;
        } else {
            //首费 + ((总量-首量)/续量) * 续费
            return sprintf('%0.0f',$default_freight + (($var - $default) / $added) * $added_freight);
        }
    }

} 