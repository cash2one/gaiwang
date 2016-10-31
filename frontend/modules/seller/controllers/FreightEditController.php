<?php

/**
 * 运费编辑控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class FreightEditController extends Controller {

    public function actionCreate() {
        $this->layout = 'dialog';
        $id = $this->getParam('orderId');
        $condition = '`pay_status` = ' . Order::PAY_STATUS_NO . ' AND `status` = ' . Order::STATUS_NEW;
        $order = Order::model()->findByPk($id, $condition);
        if ($order) {
            $model = new FreightEdit;
            $model->old_freight = $order->freight;
            $model->code = $order->code;
            $model->order_id = $order->id;
            $this->performAjaxValidation($model);
            if (isset($_POST['FreightEdit'])) {
                $model->attributes = $this->getPost('FreightEdit');
                if ($model->validate()) {
                    // 运费编辑信息
                    $freightEdit['old_freight'] = $model->old_freight;
                    $freightEdit['new_freight'] = $model->new_freight;
                    $freightEdit['create_time'] = time();
                    $freightEdit['code'] = $model->code;
                    $freightEdit['order_id'] = $model->order_id;

                    // 订单运费修改
                    $order['freight'] = $model->new_freight;
                    if ($model->old_freight > $model->new_freight) {
                        //如果 旧的运费 大于 新的运费，支付的金额中要减去 旧运费-新运费 的差额
                        $order['pay_price'] = $order['real_price']  = $order->pay_price - ($model->old_freight - $model->new_freight);
                        $order['original_price'] = $order->original_price - ($model->old_freight - $model->new_freight);
                    } elseif ($model->old_freight < $model->new_freight) {
                        //如果 旧的运费 小于 新的运费，支付的金额中要加 新运费-旧运费 的差额
                        $order['pay_price'] = $order['real_price']  = $order->pay_price + ($model->new_freight - $model->old_freight);
                        $order['original_price'] = $order->original_price + ($model->new_freight - $model->old_freight);
                    }
                    $flag = true;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        Yii::app()->db->createCommand()->update('{{order}}', $order, 'id=:id', array(':id' => $order->id));
                        Yii::app()->db->createCommand()->insert('{{freight_edit}}', $freightEdit);
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $frag = false;
                    }
                    if ($flag)
                        $this->setFlash('success', Yii::t('sellerFreightEdit', '运费修改成功'));
                    else
                        $this->setFlash('success', Yii::t('sellerFreightEdit', '运费修改失败，请稍候再试！'));
                    echo '<script> var success = "True";</script>';
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        }
    }

}
