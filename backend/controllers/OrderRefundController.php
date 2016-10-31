<?php

/**
 * 订单金额退款到银行卡
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2016/1/27 0027
 * Time: 18:22
 */
class OrderRefundController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

    //列表
    public function actionAdmin()
    {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '退款金额到银行卡列表'));
        $model = new OrderRefund('search');
        $model->unsetAttributes();
        if (isset($_GET['OrderRefund']))
            $model->attributes = $_GET['OrderRefund'];
        $this->render('admin', array('model' => $model));
    }

    //添加，将扣除用户积分，线下银行转账到银行卡
    public function actionAdd($code)
    {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '新增退款金额到银行卡'));
        /** @var Order $order */
        $order = Order::model()->findByAttributes(array('code' => $code, 'status' => Order::STATUS_CLOSE, 'refund_status' => Order::REFUND_STATUS_SUCCESS));
        if (!$order) throw new CHttpException(404, '找不到符合的订单');
        $model = new OrderRefund('create');
        if ($model->findByAttributes(array('code' => $code))) throw new CHttpException(503, '该订单已经退款');
        $returnMoney = Yii::app()->db->createCommand('select exchange_money from gw_order_exchange where order_id=:oid')->bindValue(':oid',$order->id)->queryScalar();
        if($returnMoney){
            $model->money = $returnMoney;
            $model->maxMoney = $returnMoney;
        }else{
            $model->money = bcsub($order->pay_price,$order->jf_price,2);
            $model->maxMoney = $model->money;
            $returnMoney = $order->pay_price;
        }
        $model->code = $order->code;
        $model->member_id = $order->member_id;
        $model->gai_number = $order->member->gai_number;
        $this->performAjaxValidation($model);
        if (isset($_POST['OrderRefund'])) {
            $this->checkPostRequest();
            $model->attributes = $_POST['OrderRefund'];
            $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
            $flowTableNameHistory = AccountFlowHistory::monthTable(); //流水按月分表日志表名
            $trans = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save()) {
                    throw new Exception('添加失败:' . var_export($model->getErrors(), true));
                }
                $model->addFlow($order,$flowTableName,$flowTableNameHistory);
                $trans->commit();
                $this->setFlash('success', '新增成功');
                $this->redirect(array('orderRefund/admin'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', $e->getMessage());
            }
        }
        $this->render('add', array('model' => $model, 'order' => $order,'returnMoney'=>$returnMoney));
    }

}