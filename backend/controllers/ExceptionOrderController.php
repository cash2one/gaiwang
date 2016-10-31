<?php

/**
 * 处理以前跑数漏掉的异常订单 
 * 退款,退货商家主动关闭交易,会员支付的金额没有退回去的问题
 * @author binbin.liao <277250538@qq.com>
 */
class ExceptionOrderController extends Controller {

    public function actionAdmin() {
        $this->breadcrumbs = array(Yii::t('order', '异常订单管理 '), Yii::t('order', '订单列表'));
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionOperate($id) {
        $orderId = $id;
        //检查
        $data = Yii::app()->db->createCommand()->select()->from('{{order_operate_log}}')->where('order_id=:id', array(':id' => $orderId))->queryRow();
        if (!empty($data)) {
            $this->setFlash('error', '请求参数非法');
            $this->redirect(array('admin'));
        }

        $order = Yii::app()->db->createCommand()->select()->from('{{order}}')->where('id=:id', array(':id' => $orderId))->queryRow();

        $sql = "SELECT COUNT(*) FROM gw_wealth WHERE target_id={$order['id']} AND source_id=" . Wealth::SOURCE_ONLINE_ORDER;
        $count = Wealth::model()->countBySql($sql);
        if ($count >= 4) {
            $this->setFlash('success', '订单退款成功');
            $this->redirect(array('admin'));
        }

        $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username')
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
        $orderGoods = Yii::app()->db->createCommand()
                ->select('quantity,gai_price,unit_price,gai_income,order_id,fee,ratio')
                ->from('{{order_goods}}')
                ->where('order_id=:id', array(':id' => $order['id']))
                ->queryAll();
        $memberType = MemberType::fileCache();
        $ratio = CJSON::decode($order['distribution_ratio']);
        if (!isset($ratio)) {
            $ratio = array(
                'ratio' => array(
                    'move' => Tool::getConfig('allocation', 'onFlexible'), //机动
                    'member' => Tool::getConfig('allocation', 'onConsume'), //消费者
                    'mallCommon' => Tool::getConfig('allocation', 'onAgent'), //商城公共
                    'agent' => Tool::getConfig('allocation', 'onAgent'), //代理
                    'memberRefer' => Tool::getConfig('allocation', 'onRef'), //推荐者
                    'businessRefer' => Tool::getConfig('allocation', 'onWeightAverage'), //推荐商家会员
                    'gai' => Tool::getConfig('allocation', 'onGai'), //盖网
                ),
                'agentRatio' => array(
                    'province' => Tool::getConfig('agentdist', 'province'), //省代理
                    'city' => Tool::getConfig('agentdist', 'city'), //市代理
                    'district' => Tool::getConfig('agentdist', 'district'), //区/县代理
                ),
            );
        }
        $inCome = OnlineCalculate::orderIncome($order, $orderGoods);
        $return = OnlineCalculate::memberAssign($inCome['surplusAssign'], $member, $ratio['ratio'], $memberType);
        $msg = OnlineClose::operate($order, $member, $inCome, $return, $operate = 'exception');
        
        @SystemLog::record(Yii::app()->user->name."异常订单管理操作成功");
        $this->setFlash('success', $msg['info']['success']);
        $this->redirect(array('admin'));
    }

}
