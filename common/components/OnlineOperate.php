<?php

/**
 * 线上订单操作动作父类
 *
 */
class OnlineOperate
{
    /**
     * 订单交易失败后,还原库存
     * @param $oid 订单id
     */
    public static function ReductionInventory($oid)
    {
        $orderGoods = Yii::app()->db->createCommand()
            ->select('quantity,spec_id,goods_id,rules_setting_id')
            ->from('{{order_goods}}')
            ->where('order_id = :oid', array(':oid' => $oid))
            ->queryAll();
        foreach ($orderGoods as $v) {
            /**
             * 检查订单商品表的规格是否还存在于商品对应的规格表里.
             * 有可能在等待支付期间,商品的规格改变了,库存也改变了,对这种订单退款,或者退货的时候,就不操作还原库存了.
             */
            $data = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{goods_spec}}')
                ->where('id=:id', array(':id' => $v['spec_id']))
                ->queryRow();
            if (!isset($data['id'])) {
                continue;
            }


            if($v['rules_setting_id'] > 0){ //判断所退货的订单商品是否参加活动
                $one = Yii::app()->db->createCommand()->select('seckill_seting_id')->from("{{goods}}")
                    ->where('id=:id', array(':id' => $v['goods_id']))->queryRow();
                if($one['seckill_seting_id'] > 0 && $one['seckill_seting_id'] == $v['rules_setting_id']){ //判断所退订单商品的活动与当前商品的活动是否统一，如果不统一就不刷缓存，因为不是同一个活动。
                    ActivityData:: cleanCache($one['seckill_seting_id'],$v['goods_id']);
                }
            }

            $arr = array('stock' => $v['quantity']);
            Goods::model()->updateCounters($arr, 'id = :id', array(':id' => $v['goods_id']));
            GoodsSpec::model()->updateCounters($arr, 'id = :id', array(':id' => $v['spec_id']));
        }

    }

    /**
     * 取得会员账户信息
     * @param array|Member $member 会员数据
     * @param int $type 会员类型(消费,代理,商家...)
     * @param bool $isTrans 是否事务
     * @return array
     */
    public static function getMemberAccountInfo($member, $type, $isTrans = true)
    {
        $arr = array('account_id' => $member['id'], 'type' => $type, 'gai_number' => $member['gai_number']);
        return AccountBalance::findRecord($arr, $isTrans);
    }

    /**
     * 收回红包或者其它的优惠金额
     * @param $flowTableName 表名
     * @param array $order 订单数据
     * @param array $arr 日志数据
     * @throws Exception
     */
    public static function callOtherPrice($flowTableName, $order,array $arr=array())
    {
        //红包金额
        $money = $order['other_price'];
        //红包池总账户
        $balanceRed = CommonAccount::getHongbaoAccount();
        //红包收回日志
        $flowLog = AccountFlow::mergeFlowData($order, $balanceRed, $arr);
        Yii::app()->db->createCommand()->insert($flowTableName, $flowLog);

        //把红包加回到红包池
        if (!AccountBalance::calculate(array('today_amount' => $money), $balanceRed['id'])) {
            throw new Exception('UPDATE REDACCOUNT ERROR');
        }
    }

}
