<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 合约机
 */

class HeyueCommand extends CConsoleCommand {

    /**
     * 退款或者退货或者卖家关闭成功的, 
     * 选择号码15分钟内订单未支付的,
     * 要释放号码,清除选择的信息
     */
    public function actionReturn() {
        $time = time();
        //更新数据
        $arr = array();
        $arr['is_lock'] = Heyue::NOT_LOCK;
        $arr['member_id'] = 0;
        $arr['create_time'] = 0;
        $arr['name'] = ' ';
        $arr['cardNumber'] = ' ';
        //选择号码15分钟内,还没有生成订单的.
        Heyue::model()->updateAll($arr, 'create_time < :time AND pay_status = :pay_status AND is_lock = :is_lock AND member_id <> 0',array(':time' => $time - 900, ':pay_status' => 0, ':is_lock' => Heyue::NOT_LOCK));
        //选择号码15分钟内,已经生成订单,但是没有支付的.要清除选择号码信息,并且关闭生成的订单
        $heyueDate = Yii::app()->db->createCommand()->select('id,order_id,is_lock')->from('{{heyue}}')->where('create_time < :time AND pay_status = :pay_status AND is_lock = :is_lock', array(':time' => $time - 900, ':pay_status' => 0, ':is_lock' => Heyue::LOCK))->queryAll();
        foreach ($heyueDate as $val) {
            //关闭订单
            if ($val['order_id']) {
                Yii::app()->db->createCommand()->update('{{order}}', array('status' => Order::STATUS_CLOSE), 'id = :order_id', array(':order_id' => $val['order_id']));
            }
            //清除选择号码信息
            Yii::app()->db->createCommand()->update('{{heyue}}', $arr, 'id = :id', array(':id' => $val['id']));
        }
        //支付成功后申请退款成功的
        $data = Yii::app()->db->createCommand()->select('return_status,refund_status,id')->from('{{order}}')->where('source_type = :source_type AND pay_status = :pay_status', array(':source_type' => Order::SOURCE_TYPE_HYJ, ':pay_status' => Order::PAY_STATUS_YES))->queryAll();
        foreach ($data as $v) {
            if ($v['return_status'] == Order::RETURN_STATUS_SUCCESS || $v['refund_status'] == Order::REFUND_STATUS_SUCCESS) {
                $arr['type'] = ' ';
                $arr['order_id'] = 0;
                $arr['up_status'] = 0;
                $arr['pay_status'] = 0;
                $arr['return_order'] = ' ';
                Yii::app()->db->createCommand()->update('{{heyue}}', $arr, 'order_id=' . $v['id']);
            }
        }
    }

    /**
     * 更新合约机库存
     * 两小时运行一次
     */
    public function actionPhoneStock() {
        $url = 'http://' . FEN_XIAO . "/wechat/api/mobile/GetPhoneInventory/";     //生产机
        $data = Goods::model()->findAll(array(
            'select' => 'name,id',
            'condition' => 'category_id = 887'
        ));
        if (!empty($data)) {
            foreach ($data as $value) {
                $url .= urlencode($value['name']);
                $rs = Heyue::heyueAPI($url, 'stock');
                if ($rs) {
                    $stock = $rs['stock'];
                    $id = $value['id'];
                    Yii::app()->db->createCommand()->update('{{goods}}', array('stock' => $stock), 'id = :id', array(':id' => $id));
                    //更新对应规格库存,只有默认的
                    Yii::app()->db->createCommand()->update('{{goods_spec}}', array('stock' => $stock), 'goods_id = :id', array(':id' => $id));
                }
            }
        }
    }

    /**
     * 查询推送失败订单并重新推送/更新信息不对称订单
     * 中午12点，凌晨各运行一次
     */
    public function actionCheckOrder() {
        $condition = 'h.is_lock = :is_lock AND h.pay_status = :pay_status AND h.up_status <> :up_status';
        $param = array(':is_lock' => Heyue::LOCK, ':pay_status' => Order::PAY_STATUS_YES, ':up_status' => 1);
        $heyue = Yii::app()->db->createCommand()
                ->select('h.id,h.order_id,o.code')
                ->from('{{heyue}} h')
                ->leftJoin('{{order}} o', 'h.order_id = o.id')
                ->where($condition, $param)
                ->queryAll();
        $updataArr = array();
        if (!empty($heyue)) {
            foreach ($heyue as $val) {
                $url = 'http://' . FEN_XIAO . "/wechat/api/order/statev2/{$val['code']}?token=" . HEYUE_TOKEN;   //使用盖网订单号
                $rs = Heyue::heyueAPI($url);
                if ($rs) {
                    $updataArr['up_status'] = 1;
                    $updataArr['return_order'] = $rs['number'];
                    if ($rs['number'] == 'no') {//重新推送订单到分销平台
                        $arr = Heyue::push($val['order_id']);
                        $updataArr['up_status'] = $arr['status'];
                        $updataArr['return_order'] = $arr['ddbh'];
                        if (isset($arr)) {
                            Yii::app()->db->createCommand()->update('{{heyue}}', $updataArr, 'order_id = :order_id', array(':order_id' => $val['order_id']));
                        }
                    } else {//分销平台推送成功,但是合约机本身没有更新到状态.
                        Yii::app()->db->createCommand()->update('{{heyue}}', $updataArr, 'order_id = :order_id', array(':order_id' => $val['order_id']));
                    }
                }
            }
        }
    }

}

?>
