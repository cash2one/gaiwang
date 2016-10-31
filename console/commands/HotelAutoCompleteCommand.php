<?php

/**
 * 酒店自动完成脚本
 * 签收条件：
 * 支付状态为已支付、订单状态为已确认、入住时间加上自动签收时间天数小于脚本执行的时间
 * @author jianlin.lin <hayeslam@163.com>
 */
class HotelAutoCompleteCommand extends CConsoleCommand {

    /**
     * 完成订单
     */
    public function actionComplete() {
        $data = $this->getData();
        if (!empty($data)) {
            foreach ($data as $order)
                HotelComplete::execute($order);
            echo "Succeed";
        } else {
            echo 'No results found';
        }
    }

    /**
     * 自动完成测试
     */
    public function actionTest() {
        
        $data = $this->getData();
        $codes = array();
        foreach ($data as $order) {
            $codes[] = $order['code'];
        }
        echo "Row: " . count($codes);
        exit;
    }

    /**
     * 获取符合自动完成的酒店订单数据
     * @return array
     * @author jianlin.lin
     */
    public function getData() {
        $autoCompleteDay = intval(Tool::getConfig('hotelparams', 'autoComplete'));
        $autoCompleteTime = (!is_numeric($autoCompleteDay) && $autoCompleteDay <= 0 ? 1 : $autoCompleteDay) * 86400;
        $sql = "
            SELECT * FROM {{hotel_order}} WHERE status = :status AND pay_status = :pstatus AND is_check = :check
            AND is_recon = :recon AND leave_time  <= (unix_timestamp(now()) - :act)  FOR UPDATE
        ";
        $params = array(
            ':status' => HotelOrder::STATUS_VERIFY,
            ':pstatus' => HotelOrder::PAY_STATUS_YES,
            ':check' => HotelOrder::IS_CHECK_YES,
            ':recon' => HotelOrder::IS_RECON_YES,
            ':act' => $autoCompleteTime
        );
        return Yii::app()->db->createCommand($sql)->queryAll(true, $params);
    }

}

?>
