<?php

/**
 *  购物车模型
 * @author binbin.liao  <277250538@qq.com>
 * The followings are the available columns in table '{{cart}}':
 * @property string $id
 * @property string $member_id
 * @property string $store_id
 * @property string $goods_id
 * @property string $spec_id
 * @property string $price
 * @property string $quantity
 * @property string $create_time
 */
class Cart extends CActiveRecord
{

    public function tableName()
    {
        return '{{cart}}';
    }

    public function rules()
    {
        return array(
            array('member_id, store_id, goods_id, spec_id, price, quantity, create_time', 'required'),
            array('member_id, store_id, goods_id, spec_id, quantity, create_time', 'length', 'max' => 11),
            array('price', 'length', 'max' => 14),//要考虑小数点，不能限制到11位
            array('id, member_id, store_id, goods_id, spec_id, price, quantity, create_time', 'safe', 'on' => 'search'),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 将购物车session中的数据合并到数据库
     * @param array $goodsList 原来的数据库的数据
     * @param array $newList 新的，合并后的数据，合并后的数据，肯定是 >= 原来的数据
     */
    public function sync(Array $goodsList, Array $newList)
    {
        //取差集,多维数组，需要用@屏蔽 notice
        $diffGoods = @array_diff_assoc($newList, $goodsList);

        foreach ($diffGoods as $v) {
            $data = $v;
            $data['create_time'] = time();
            $data['member_id'] = Yii::app()->user->id;
            Yii::app()->db->createCommand()->insert(self::tableName(), $data);
        }

    }

    /**
     * 添加商品到购物车
     * @param $goodsData
     * @return int
     */
    public function add(array $goodsData)
    {
        $data = $goodsData;
        $data['create_time'] = time();
        $data['member_id'] = Yii::app()->user->id;
        return Yii::app()->db->createCommand()->insert(self::tableName(), $data);
    }

    /**
     * 更新购物车
     * @param array|null $goodsData
     * @return bool|int
     */
    public function update($goodsData=null)
    {
        if(!$goodsData) return false;
        return Yii::app()->db->createCommand()->update(self::tableName(),
            array('quantity' => $goodsData['quantity']),
            'goods_id=:goods_id and member_id=:member_id and spec_id=:spec_id', array(
                'goods_id' => $goodsData['goods_id'],
                'member_id' => Yii::app()->user->id,
                'spec_id' => $goodsData['spec_id'],
            ));
    }

    /**
     * 删除指定的购物车商品
     * @param array $goods
     * @return int
     */
    public function del($goods)
    {
        return Yii::app()->db->createCommand()->delete(self::tableName(),
            'goods_id=:goods_id and member_id=:member_id and spec_id=:spec_id',
            array(
                'goods_id' => $goods['goods_id'],
                'member_id' => Yii::app()->user->id,
                'spec_id' => $goods['spec_id'],
            )
        );
    }


    /**
     * 获取会员购物车的所有商品,用于计算购物车的增删改
     * @param $member_id
     * @return array
     */
    public function goodsList($member_id)
    {
        $goodsList = Yii::app()->db->createCommand()->from($this->tableName())
            ->where('member_id=:mid', array(':mid' => $member_id))->queryAll();
        if (!empty($goodsList)) {
            $newGoodsList = array();
            foreach ($goodsList as $v) {
                $newGoodsList[$v['goods_id'] . '-' . $v['spec_id']] = array(
                    'goods_id' => $v['goods_id'],
                    'spec_id' => $v['spec_id'],
                    'quantity' => $v['quantity'],
                    'price' => $v['price'],
                    'store_id' => $v['store_id'],
                );
            }
            return $newGoodsList;
        } else {
            return array();
        }
    }

    /**
     * 获取购物车商品详细信息
     * @param array $goodsSelect 过滤商品,不包含
     * @param string $forUpdate 加 for update 查询
     * @return array
     * @throws Exception
     */
    public static function getCartInfo($goodsSelect=null,$forUpdate='')
    {
        $sql = 'SELECT
                    c.id,
                    c.goods_id,
                    c.spec_id,
                    c.price AS oldPrice,
                    g.price,
                    c.quantity,
                    g.thumbnail,
                    g.`name`,
                    g.gai_income,
                    g.gai_price,
                    g.freight_payment_type,
                    g.freight_template_id,
                    g.size,
                    g.weight,
                    c.store_id,
                    g.status,
                    g.is_publish,
                    g.life,
                    g.fee,
                    g.ratio,
                    g.category_id AS g_category_id,
                    g.gai_sell_price,
                    g.activity_tag_id,
                    g.join_activity,
                    g.activity_ratio,
                    g.jf_pay_ratio,
                    g.seckill_seting_id,
                    f.valuation_type,
                    s.`name` AS store_name,
                    et.signing_type
                FROM
                    gw_cart AS c
                LEFT JOIN gw_goods AS g ON g.id = c.goods_id
                LEFT JOIN gw_freight_template AS f ON g.freight_template_id = f.id
                LEFT JOIN gw_store AS s ON s.id = c.store_id
                LEFT JOIN gw_member AS m ON s.member_id = m.id
                LEFT JOIN gw_enterprise AS et ON m.enterprise_id = et.id
                WHERE
                    c.member_id =:mid';
        $data = Yii::app()->db->createCommand($sql)->bindValue(':mid', Yii::app()->user->id)->queryAll();
        $cartInfo = array(); //重新格式化、按照店铺id组装数据
        $freightInfo = array(); //运费模板信息
        if (!$data) return array('goodsCount' => 0, 'cartInfo' => array(), 'freightInfo' => array());
        $goodsCount = 0; //商品个数统计
        $specialTopicNum= SpecialTopic::effectiveTopicNum(); //当前未结束的专题个数
        
	$nowTime = time();
	foreach ($data as &$v) {
            //查找库存相关
            $sql = 'select spec_name,spec_value,stock from gw_goods_spec where id=:id';
            $goodsSpec = Yii::app()->db->createCommand($sql.$forUpdate)->bindValue(':id',$v['spec_id'])->queryRow();
            if($goodsSpec){
                $v = array_merge($v,$goodsSpec);
            }else{
//                throw new Exception(Yii::t('cart','查找商品库存失败,请删除购物车商品后，再重新添加 {0}',array('{0}'=>'['.$v['name'].']')));
                $v['status'] = Goods::STATUS_AUDIT;
                $v['spec_value'] = $v['spec_name'] = null;
                $v['stock'] = 0;
            }
            $goodsKey = $v['goods_id'] . '-' . $v['spec_id'];
            //过滤商品
            if(!empty($goodsSelect)){
                if(!in_array($goodsKey,$goodsSelect)) continue;
            }
            $goodsCount++;
            //反序列化规格数据
            !empty($v['spec_name']) && $v['spec_name'] = unserialize($v['spec_name']);
            !empty($v['spec_value']) && $v['spec_value'] = unserialize($v['spec_value']);
            //处理已有错误数据的规格
            if(is_array($v['spec_name']) && is_array($v['spec_value']) && count($v['spec_name'])!=count($v['spec_value'])){
                if(count($v['spec_name'])>count($v['spec_value'])){
                    $v['spec_name'] = array_slice($v['spec_name'],0,count($v['spec_value']));
                }else{
                    $v['spec_value'] = array_slice($v['spec_value'],0,count($v['spec_name']));
                }
                //有错误数据的商品不能购买
                $v['is_publish'] = Goods::PUBLISH_NO;
            }
            $spec = is_array($v['spec_name']) && is_array($v['spec_value']) ? array_combine($v['spec_name'], $v['spec_value']) : array();
            $v['spec'] = '';
            foreach ($spec as $ks => $vs) {
                $v['spec'] .= $ks . ':' . $vs . ' ';
            }
            //该商品是否有参与优惠活动,如果有，则使用优惠活动的价格
            if($specialTopicNum){
                $special = SpecialTopicGoods::hasActive($v['goods_id']);
                if ($special) {
                    $v = array_merge($v, $special);
                }
            }
            
            $isRed = 0;
            $aprice = $v['price'];//应节性活动和红包活动的价格
            if($v['seckill_seting_id']>0){//应节性活动价格处理
                $seting   = ActivityData::getActivityRulesSeting($v['seckill_seting_id']);
		$relation = ActivityData::getRelationInfo($v['seckill_seting_id'], $v['goods_id']);
                if( isset($seting) && isset($relation) && $seting['category_id']==2 && $relation['status']==1 && strtotime($seting['end_dateline'])>=$nowTime ){//参加了应节活动,并且通过了审核
                    if($seting['discount_rate'] > 0){//打折
			$aprice = number_format($v['price']*$seting['discount_rate']/100, 2, '.', '');
		    }else{//固定价格
			$aprice = number_format($seting['discount_price'], 2, '.', '');
		    }
                    $v['price']          = $aprice;
                    $v['gai_price']      = $aprice;
                    $v['original_price'] = $aprice;
                }
                
                //如果是红包活动 修改下面的价格 李文豪 2015-06-17
		if( isset($seting) && isset($relation) && $seting['category_id']==1 && $relation['status']==1 && strtotime($seting['end_dateline'])>=$nowTime ){//参加了红包活动,并且通过了审核
                    if($seting['discount_rate'] > 0){//打折
			$aprice = number_format($v['price']*(100-$seting['discount_rate'])/100, 2, '.', '');
                        //$v['original_price'] = $aprice;
                        //$v['price']          = $aprice;
                        //$v['gai_price']      = $aprice;       
                        $isRed = 1;
                    }
                }
            }

            $v['special_goods'] = in_array($v['goods_id'],ShopCart::checkSpecialGoods()) ? true : false;           
            $v = array_merge($v,array('original_price'=>$v['price']));
 
            //该商品是否有参与红包活动,如果有,则使用盖网提供的售价 (第一版没有盖网售价 2015-06-10 李文豪)
            /*if($v['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($v['activity_tag_id']) && $v['at_status'] == ActivityTag::STATUS_ON){
                $v=array_merge($v,array('price'=>$v['gai_sell_price']));
            }*/
            
            //if($isRed==1){//红包活动,修改这两个价格
                //店铺商品(原始价格)、不包含运费
                //$cartInfo[$v['store_id']]['originalPrice'][$goodsKey] = $aprice*$v['quantity'];
                //店铺商品价格集合、不包含运费
                //$cartInfo[$v['store_id']]['storeAllPrice'][$goodsKey] = $v['price']*$v['quantity'];//$aprice*$v['quantity'];
            //}else{
                //店铺商品(原始价格)、不包含运费
                $cartInfo[$v['store_id']]['originalPrice'][$goodsKey] = $v['price']*$v['quantity'];
                //店铺商品价格集合、不包含运费
                $cartInfo[$v['store_id']]['storeAllPrice'][$goodsKey] = $v['price']*$v['quantity'];
            //}
            //返还积分
            $v['returnScore'] = Common::convertReturn($v['gai_price'], $v['price'], $v['gai_income'] / 100)*$v['quantity'];
            //店铺名称
            $cartInfo[$v['store_id']]['storeName'] = $v['store_name'];
            //签约类型
            $cartInfo[$v['store_id']]['serviceType'] = $v['signing_type'];
            //店铺商品集合
            $cartInfo[$v['store_id']]['goods'][$goodsKey] = $v;

            //店铺商品返还积分集合
            $cartInfo[$v['store_id']]['storeAllReturn'][$goodsKey] = $v['returnScore'];
            //所有的运费模板
            if ($v['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE) {
                $freightInfo[] = array(
                    'goods_id' => $v['goods_id'],
                    'size' => $v['size'],
                    'weight' => $v['weight'],
                    'quantity' => $v['quantity'],
                    'freight_template_id' => $v['freight_template_id'],
                    'valuation_type' => $v['valuation_type'],
                    'spec_id' => $v['spec_id'],
                    'store_id' => $v['store_id'],
                );
            }
        }
        return array('cartInfo' => $cartInfo, 'freightInfo' => $freightInfo, 'goodsCount' => $goodsCount);
    }

    /**
     * 删除会员指定的商品
     * @param int $member_id
     * @param array $goods_select
     * @return int
     */
    public static function delCart($member_id, array $goods_select)
    {
        foreach ($goods_select as $v) {
            $tmpKey = explode('-', $v);
            Yii::app()->db->createCommand()
                ->delete('{{cart}}', 'member_id=:mid and goods_id=:goods_id and spec_id=:spec_id',
                    array(':mid' => $member_id, ':goods_id' => $tmpKey[0], ':spec_id' => $tmpKey[1]));
        }
        return true;
    }

}
