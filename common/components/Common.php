<?php

/**
 * 积分操作类
 * 积分各种转换，换算等
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class Common {

    public static function getConfig($name, $key = null) {
       $val = Tool::cache($name . 'config')->get($name);      
        if ($val) {
            $array = unserialize($val);
        } else {

            $value = WebConfig::model()->findByAttributes(array('name' => $name));
            if ($value) {
                Tool::cache($name . 'config')->add($name, $value->value);
                $array = unserialize($value->value);
            } else {
                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $name . '.config.inc';
                if (!file_exists($file)) {
                    return array();
                }
                $content = file_get_contents($file);
                $array = unserialize(base64_decode($content));
            }
        }

        return $key ? (isset($array[$key]) ? $array[$key] : '') : $array;
    }

    /**
     * 转换会员账户中的金额为积分
     * 对会员帐号中的所有金额，
     * 转换为对应的积分数值
     * 暂时是（兑现金额+消费金额）转换成积分
     * @param CModel
     * @return float 积分数额,保留两位小数,不做四舍五入
     */
    public static function convertIntegral($model) {
        /** @var $model Member */
        if ($model === null)
            return;
        $total = $model->account_expense_nocash;
        $type = MemberType::fileCache();
        return bcdiv($total, $type[$model->type_id], 2);
    }

    /**
     * 转换单个金额为积分
     * 不做四舍五入
     * @param float $price 金额
     * @param int $typeId 会员类型（正式或消费）
     * @return float 积分数额,保留两位小数,不做四舍五入 
     */
    public static function convertSingle($price, $typeId = null) {
        $type = MemberType::fileCache();
        if ($typeId)
            return bcdiv($price, $type[$typeId], 2);
        $typeId = Yii::app()->user->getState('typeId');
        return bcdiv($price, $type[$typeId], 2);
    }



    /**
     * 转换单个积分为金额
     * 不做四舍五入
     * @param float $score 积分
     * @param int $typeId 会员类型（正式或消费）
     * @return $float 金额
     */
    public static function reverseSingle($score, $typeId = null) {
        $type = MemberType::fileCache();
        if ($typeId)
//            return sprintf("%.2f", $score * $type[$typeId]); 
            return bcmul($score, $type[$typeId], 2);
        $typeId = Yii::app()->user->getState('typeId');
//        return sprintf("%.2f", $score * $type[$typeId]);
        return bcmul($score, $type[$typeId], 2);
    }

    /**
     * 商品展示中积分的兑换转换
     * 根据会员的类型下的比率转换
     * 使用的是商品的促销价除以比率，算出积分
     * @param float $price 商品的供货价
     * @param int $typeId 会员类型
     * @return int 兑换后的积分 保留两位小数,不做四舍五入
     */
    public static function convert($price) {
        $type = MemberType::fileCache();
        $typeId = Yii::app()->user->getState('typeId');
        if ($typeId)
            return bcdiv($price, $type[$typeId], 2);
        return bcdiv($price, $type['default'], 2);
    }

    /**
     * 计算各角色返还的金额
     * 现在商城商品，及酒店统一使用这个方法
     * 四舍五入
     * 线上使用
     * @param float $purchasePrice 进价
     * @param float $sellingPrice 售价
     * @param float $gaiIncome 盖网收益，如 0.5
     * @return array 各角色返还的金额
     */
    public static function calculate($purchasePrice, $sellingPrice, $gaiIncome) {
        $rules = self::getConfig('allocation');
        $poor = $sellingPrice - $purchasePrice;
        $poor = $poor - $poor * $gaiIncome;

        $result = array(
            'consumer' => $rules['onConsume'] / 100 * $poor, // 消费者
            'referrals' => $rules['onRef'] / 100 * $poor, // 消费者推荐人
            'agent' => $rules['onAgent'] / 100 * $poor, // 代理
            'gatewang' => $rules['onGai'] / 100 * $poor, // 盖网
            'flexible' => $rules['onFlexible'] / 100 * $poor, // 机动
            'merchantReferral' => $rules['onWeightAverage'] / 100 * $poor, // 商家推荐人
        );

        // 取两位小数，四舍五入
        foreach ($result as $key => $value)
            $result[$key] = sprintf("%.2f", $value);
        return $result;
    }

    const CURRENCY_RMB = 'CNY';
    const CURRENCY_HK = 'HKD';

    /**
     * 汇率转换
     * @param $price
     * @param string $to
     * @return string
     */
    public static function rateConvert($price, $to = self::CURRENCY_HK)
    {
        if (!is_numeric($price))
            return $price;
        $rate = 1;
        if(Yii::app()->language != 'zh_cn'){
            $rate = Tool::getConfig('rate', 'hkRate');
            if ($to == self::CURRENCY_HK) {
                $rate = 100 / $rate;
            } else if ($to == self::CURRENCY_RMB) {
                $rate = $rate / 100;
            }
        }
        return sprintf("%.2f", $price * $rate);
    }

    /**
     * 计算商品，酒店房间添加，修改时的返还积分值
     * 酒店房间和线上商品使用
     * @param float $purchasePrice 进货价
     * @param float $sellingPrice 销售价
     * @param float $gaiIncome 盖网收益占比，如 0.5
     * @param string $role 角色，不传至则默认为onConsume
     * @return float 最终返还的积分数
     * 消费者返还比率（ 后台配置，如50% = 0.5 ）
     * 正式会员兑换比率（ 后台有配置，如0.9或0.45 ）
     * 公式：（ 消费者返还比率 *（（销售价-供货价）-（销售价-供货价）* 盖网收入 ））/ 正式会员兑换比率
     * 保留两位小数,不做四舍五入
     */
    public static function convertReturn($purchasePrice, $sellingPrice, $gaiIncome, $role = null) {
        $type = MemberType::fileCache();
        $rules = self::getConfig('allocation');
        $role = is_null($role) ? 'onConsume' : $role;
        $poor = bcsub($sellingPrice, $purchasePrice, 2);
        $poor2 = bcmul($poor, $gaiIncome,2);
        $poor = bcsub($poor, $poor2, 2);
        $price = bcmul(bcdiv($rules[$role], 100, 2), $poor, 2);
        return bcdiv($price, $type['official'], 2);
    }

    /**
     * 计算商品，酒店房间添加，修改时的返还积分值
     * 这是复制上面方法临时修改.因为前台展示积分是四舍五入,后台是四舍为了统一下.改成高精度运算
     *
     * 公式：（ 消费者返还比率 *（（销售价-供货价）-（销售价-供货价）* 盖网收入 ））/ 正式会员兑换比率
     *       = 消费者返还比率*(销售价-供货价)*(1-盖网收入)/正式会员兑换比率
     * @param float $purchasePrice 进货价
     * @param float $sellingPrice 销售价
     * @param float $gaiIncome 盖网收益占比，如 0.5
     * @return float
     *
     */
    public static function convertReturnDiv($purchasePrice, $sellingPrice, $gaiIncome) {
        $type = MemberType::fileCache();
        $rules = self::getConfig('allocation');
        $returnRate = bcdiv($rules['onConsume'], 100, 3); //消费者返还比率
        $poor = bcsub($sellingPrice, $purchasePrice, 3); //盈利=销售价-供货价
        //return  $returnRate*$poor*(1-$gaiIncome)/$type['official'];
        return bcdiv(bcmul($returnRate,bcmul($poor,bcsub(1,$gaiIncome,3),3),3),$type['official'],2);
    }
    
    
    
    /**
     * 计算商品供货价
     * 
     * 根据售价以及分类
     * 
     */
    public static function convertProductGaiPrice($price,$cat_id){
        $criteria = new CDbCriteria();
        $criteria->select = 'fee';
        $criteria->addCondition('id=' . $cat_id * 1);
        $cat = Category::model()->find($criteria);

        $price = $price * 1;
        //零售价 - (零售价 * 分类服务费率)
        $fee = $cat->fee / 100;
        return bcsub($price,bcmul($price,$fee,2),2);
    }

}
