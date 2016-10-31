<?php

/**
 * 超过规定天数10天,自动签收
 * @author binbin.liao <277250538@qq.com>
 */
class AutoSignCommand extends CConsoleCommand {

    /**
     * 自动签收,包括收益分发,积分分配.
     */
    public function actionSign() {
        $dir = Yii::getPathOfAlias('autoSign');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $sql = "SELECT
	*
FROM
	gw_order
WHERE
	(
                floor((unix_timestamp(now())-delivery_time)/86400)>=auto_sign_date 
		AND `pay_status` = " . Order::PAY_STATUS_YES . "
		AND `delivery_status` = " . Order::DELIVERY_STATUS_SEND . "
		AND `status` = " . Order::STATUS_NEW . "
		AND `sign_time` = ''
	)
AND (
	(
		`refund_status` = " . Order::REFUND_STATUS_NONE . "
		AND `return_status` = " . Order::RETURN_STATUS_NONE . "
	)
	OR (
		`refund_status` = " . Order::REFUND_STATUS_FAILURE . "
		AND `return_status` = " . Order::RETURN_STATUS_FAILURE . "
	)
	OR (
		`refund_status` = " . Order::REFUND_STATUS_FAILURE . "
		AND `return_status` = " . Order::RETURN_STATUS_NONE . "
	)
        OR(
               `refund_status` = " . Order::REFUND_STATUS_NONE . "
                AND `return_status` = " . Order::RETURN_STATUS_FAILURE . "
        )
        or(
            `refund_status` = " . Order::REFUND_STATUS_NONE . "
             AND `return_status` = " . Order::RETURN_STATUS_CANCEL . "
        )
) ";
        $command = Yii::app()->db->createCommand($sql);
        $dataReader = $command->query();

        // 重复调用 read() 直到它返回 false 
        while(($order=$dataReader->read())!==false) {

            $orderGoods = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{order_goods}}')
                ->where('order_id=:id', array(':id' => $order['id']))
                ->queryAll();
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username,referrals_id')
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
            $storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name', 'c.province_id', 'c.city_id', 'c.district_id', 'c.referrals_id','c.mobile as store_mobile');
            $store = Yii::app()->db->createCommand()->select($storeFields)->from('{{store}} c')->leftJoin('{{member}} m', 'm.id = c.member_id')->where('c.id=:id', array(':id' => $order['store_id']))->queryRow();

            $msg = OnlineSign::order($order, $orderGoods, $member, $store,false);
            echo $order['code'],$msg['info']."\r\n";
        }
    }

    /**
     * 计算发货时间距离现在的天数
     * @param type $deliverTime
     * @return type
     */
    public static function calDate($deliverTime) {
        $diffDay = floor((time() - $deliverTime) / 3600 / 24);
        return $diffDay;
    }

}

?>
