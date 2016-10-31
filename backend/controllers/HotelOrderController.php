<?php

/**
 * 酒店订单控制器
 * 操作：{酒店订单查询列表、酒店新订单列表、酒店已确认订单列表、酒店订单对账列表、查看订单、确认酒店订单
 * 异步取消订单、完成订单、批量对账}
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelOrderController extends Controller {

    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'deductFactorage, roomChange, newHotelOrder, addFollow, viewFollow';
    }

    /**
     * 酒店订单查询列表
     */
    public function actionAdmin() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        $dataProvider = $model->search(); // 数据
        // 导出 Excel 
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        $totalCount = $dataProvider->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/hotelOrder/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('admin', compact('model', 'dataProvider', 'exportPage', 'totalCount'));
    }

    /**
     * 酒店订单查询列表导出 Excel
     */
    public function actionAdminExport() {
        set_time_limit(3600);
        @ini_set('memory_limit', '512M');
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        @SystemLog::record(Yii::app()->user->name . "导出酒店订单查询列表");
        $model->isExport = 1;
        $this->render('adminexport', array('model' => $model));
    }


    /**
     * 酒店新订单列表
     */
    public function actionNewList() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        if ($this->getParam('msg'))
            $this->setFlash('success', Yii::t('hotelOrder', $this->getParam('msg')));
        $this->render('newlist', array('model' => $model));
    }

    /**
     * 酒店待确认订单列表
     */
    public function actionNoVerifyList(){
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        if ($this->getParam('msg'))
            $this->setFlash('success', Yii::t('hotelOrder', $this->getParam('msg')));
        $this->render('noVerifyList', array('model' => $model));
    }

    /**
     * 酒店已确认订单列表
     */
    public function actionVerifyList() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        $this->render('verifylist', array('model' => $model));
    }

    /**
     * 酒店订单核对列表
     */
    public function actionCheckList() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        if ($this->getParam('msg'))
            $this->setFlash('success', Yii::t('hotelOrder', $this->getParam('msg')));
        $dataProvider = $model->search(); // 数据
        // 导出 Excel
        $this->showExport = true;
        $this->exportAction = 'checkListExport';
        $totalCount = $dataProvider->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/hotelOrder/checkListExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('checklist', compact('model', 'dataProvider', 'exportPage', 'totalCount'));
    }

    /**
     * 酒店订单核对列表导出 Excel
     */
    public function actionCheckListExport() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        @SystemLog::record(Yii::app()->user->name . "导出酒店订单核对列表");
        $model->isExport = 1;
        $this->render('checklistexport', array('model' => $model));
    }

    /**
     * 酒店订单对账列表
     */
    public function actionCheckingList() {
        $model = new HotelOrder('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
            $model->attributes = $this->getParam('HotelOrder');
        $this->render('checkinglist', array('model' => $model));
    }

    /**
     * 查看订单
     * @param integer $id
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $sms = Yii::app()->db->createCommand()
        ->select('content,status,mobile,create_time')
        ->from('{{sms_log}}')
        ->where('target_id = :tid And type = :type', array(':tid' => $id, ':type' => SmsLog::TYPE_HOTEL_ORDER))
        ->queryAll();
        $this->render('view', array('model' => $model, 'sms' => $sms));
    }

    /**
 * 新订单列表取消订单
 * @param $id
 * @throws CHttpException
 */
    public function actionCancelNewOrder($id){
        $this->cancelOrder($id);
    }

    /**
     * 待确认订单列表取消订单
     * @param integer $id 酒店订单ID
     * @throws CHttpException
     */
    public function actionCancelOrder($id) {
        $this->cancelOrder($id);
    }

    protected function cancelOrder($id){
        if (Yii::app()->request->isAjaxRequest) {
            $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And status = :status FOR UPDATE";
            /** @var HotelOrder $model */
            $model = HotelOrder::model()->findBySql($sql, array(':id' => (int) $id, ':status' => HotelOrder::STATUS_NEW));
            if ($model === null) {
                throw new CHttpException(404, Yii::t('hotelOrder', '请求的页面不存在.'));
            }
            if ($model->pay_status == HotelOrder::PAY_STATUS_YES) {
                $flag = HotelCancle::execute($model->attributes);
            } else {
                // 如果订单未支付，则直接更新订单状态为关闭，不做其他操作
                $array = array('status' => HotelOrder::STATUS_CLOSE, 'cancle_time' => time());
                $res = Yii::app()->db->createCommand()->update('{{hotel_order}}', $array, 'id = :id', array(':id' => $model->id));
                $flag = $res == true ? true : false;
            }
            $msg = Yii::t('hotelOrder', '订单{code}取消失败', array('{code}' => $model->code));
            if ($flag === true) {
                @SystemLog::record($this->getUser()->name . "取消酒店订单：" . $model->code);
                $msg = Yii::t('hotelOrder', '订单{code}已取消', array('{code}' => $model->code));
            }
            echo CJSON::encode(array('status' => $flag, 'msg' => $msg));
        }
    }


    /**
     * 取消确认订单
     * @param integer $id 酒店订单ID
     * @throws CHttpException
     */
    public function actionCancelVerifyOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And status = :status AND pay_status = :ps And is_recon = :recon FOR UPDATE";
            /** @var HotelOrder $model */
            $model = HotelOrder::model()->findBySql($sql, array(
                ':id' => (int) $id, ':status' => HotelOrder::STATUS_VERIFY, ':ps' => HotelOrder::PAY_STATUS_YES, ':recon' => HotelOrder::IS_RECON_NO)
            );
            if ($model === null) {
                throw new CHttpException(404, Yii::t('hotelOrder', '请求的页面不存在.'));
            }
            $deduct = $this->getParam('deduct') == 'true' ? true : false;
            $flag = HotelCancle::execute($model->attributes, $deduct);
            $msg = Yii::t('hotelOrder', '订单{code}取消失败', array('{code}' => $model->code));
            if ($flag === true) {
                @SystemLog::record($this->getUser()->name . "取消酒店订单：" . $model->code);
                $msg = Yii::t('hotelOrder', '订单{code}已取消', array('{code}' => $model->code));
            }
            echo CJSON::encode(array('status' => $flag, 'msg' => $msg));
        }
    }

    /**
     * 扣除手续费
     * @param integer $id 酒店订单ID
     */
    public function actionDeductFactorage($id) {
        $this->layout = false;
        $this->render('fee', array('id' => $id));
    }

    /**
     * 确认酒店订单
     * @param integer $id 酒店订单ID
     * @throws CHttpException
     */
    public function actionVerifyOrder($id) {
        $this->checkPostRequest(); // 检查重复提交
        $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And status = :status And pay_status = :payStatus FOR UPDATE";
        /** @var HotelOrder $model */
        $model = HotelOrder::model()->findBySql($sql, array(':id' => (int) $id, ':status' => HotelOrder::STATUS_NEW, ':payStatus' => HotelOrder::PAY_STATUS_YES));
        if ($model === null) {
            throw new CHttpException(404, Yii::t('hotelOrder', '请求的页面不存在.'));
        }
        $model->setScenario('orderVerify');
        $rawOrder = clone $model;
        $model->attributes = $this->getParam('HotelOrder');
        // 如果换房，获取客房最新单价
        if ($rawOrder->room_id != $model->room_id) {
            $command = Yii::app()->db->createCommand();
            $model->unit_price = $command->select('unit_price')->from('{{hotel_room}}')->where('id = :id', array(':id' => $model->room_id))->queryScalar();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
            echo CActiveForm::validate($model, null, false);
            Yii::app()->end();
        }
        if (isset($_POST['HotelOrder'])) {
            if ($model->validate()) {
                $model->settled_time = strtotime($model->settled_time);
                $model->leave_time = strtotime($model->leave_time);
                $flag = HotelVerify::verify($model->attributes, $rawOrder);
                $message = Yii::t('hotelOrder', "订单号：{code}异常，确认失败", array('{code}' => $model->code));
                if ($flag === true) {
                    @SystemLog::record(Yii::app()->user->name . "确认酒店订单：" . $id);
                    $message = Yii::t('hotelOrder', "订单号：{code}已确认", array('{code}' => $model->code));
                }
                $this->setFlash($flag === true ? 'success' : 'error', $message);
                $this->redirect(array($flag === true ? 'verifyList' : 'newList', 'HotelOrder[code]' => $model->code));
            }
        }
        $this->render('verify', array(
            'model' => $model,
            'hotelScope' => CJSON::encode($this->_hotelChangeData($model)) // 可换酒店范围
        ));
    }

    /**
     * 核对订单
     * @param $id   酒店订单ID
     * @throws CHttpException
     */
    public function actionOrderCheck($id) {
        $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And status = :status And pay_status = :payStatus And is_check = :check And is_recon = :recon FOR UPDATE";
        /** @var HotelOrder $model */
        $model = HotelOrder::model()->with(array('hotel', 'room'))->findBySql($sql, array(
            ':id' => (int) $id, ':status' => HotelOrder::STATUS_VERIFY, ':payStatus' => HotelOrder::PAY_STATUS_YES, ':check' => HotelOrder::IS_CHECK_NO, ':recon' => HotelOrder::IS_RECON_NO
        ));
        if ($model === null) {
            throw new CHttpException(404, Yii::t('hotelOrder', '请求的页面不存在.'));
        }
        $model->setScenario('orderCheck');
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelOrder'])) {
            $model->attributes = $this->getParam('HotelOrder');
            $model->is_check = HotelOrder::IS_CHECK_YES;
            $model->check_user = Yii::app()->getUser()->name;
            $model->check_time = time();
            $flag = false;
            $message = Yii::t('hotelOrder', '订单号：{code}异常，核对失败', array('{code}' => $model->code));
            if ($model->save()) {
                $flag = true;
                $message = Yii::t('hotelOrder', '订单号：{code}已核对', array('{code}' => $model->code));
                @SystemLog::record(Yii::app()->user->name . "核对酒店订单：" . $id);
            }
            $this->setFlash($flag === true ? 'success' : 'error', $message);
            $this->redirect(array($flag === true ? 'checkList' : 'verifyList', 'HotelOrder[code]' => $model->code));
        }
        $this->render('check', array('model' => $model));
    }

    /**
     * 完成订单
     * @param $id   酒店订单ID
     * @throws CHttpException
     */
    public function actionOrderComplete($id) {
        $this->checkPostRequest(); // 检查重复提交
        $sql = "
            SELECT * FROM {{hotel_order}}
            WHERE id = :id And status = :status And pay_status = :pstatus And is_check = :check And is_recon = :recon
            FOR UPDATE
        ";
        /** @var HotelOrder $model */
        $model = HotelOrder::model()->findBySql($sql, array(
            ':id' => $id,
            ':status' => HotelOrder::STATUS_VERIFY,
            ':pstatus' => HotelOrder::PAY_STATUS_YES,
            ':check' => HotelOrder::IS_CHECK_YES,
            ':recon' => HotelOrder::IS_RECON_YES,
        ));
        if ($model === null) {
            throw new CHttpException(404, '请求的页面不存在.');
        }
        $model->setScenario('orderComplete');
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelOrder'])) {
            $model->attributes = $this->getParam('HotelOrder');
            if ($model->validate()) {
                $flag = HotelComplete::execute($model->attributes);
                $message = Yii::t('hotelOrder', "订单号：{code}异常，未完成", array('{code}' => $model->code));
                if ($flag === true) {
                    @SystemLog::record(Yii::app()->user->name . "完成酒店订单：" . $id);
                    $message = Yii::t('hotelOrder', "订单号：{code}已完成", array('{code}' => $model->code));
                }
                $this->setFlash($flag === true ? 'success' : 'error', $message);
                $this->redirect(array('checkingList', 'HotelOrder[code]' => $model->code));
            }
        }
        $this->render('complete', array(
            'model' => $model,
        ));
    }

    /**
     * 订单对账
     * @param $id
     * @throws CHttpException
     */
    public function actionOrderChecking($id) {
        $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And status = :status And pay_status = :payStatus And is_check = :check And is_recon = :recon FOR UPDATE";
        /** @var HotelOrder $model */
        $model = HotelOrder::model()->findBySql($sql, array(
            ':id' => (int) $id, ':status' => HotelOrder::STATUS_VERIFY, ':payStatus' => HotelOrder::PAY_STATUS_YES, ':check' => HotelOrder::IS_CHECK_YES, ':recon' => HotelOrder::IS_RECON_NO)
        );
        if ($model === null) {
            throw new CHttpException(404, Yii::t('hotelOrder', '请求的页面不存在.'));
        }
        $model->is_recon = HotelOrder::IS_RECON_YES;
        $model->recon_user = Yii::app()->getUser()->name;
        $model->recon_time = time();
        $flag = false;
        $message = Yii::t('hotelOrder', '订单号：{code}异常，对账失败', array('{code}' => $model->code));
        if ($model->save()) {
            $flag = true;
            $message = Yii::t('hotelOrder', '订单号：{code}已对账', array('{code}' => $model->code));
            @SystemLog::record(Yii::app()->user->name . "酒店订单对账：" . $id);
        }
        $this->setFlash($flag === true ? 'success' : 'error', $message);
        $this->redirect(array($flag === true ? 'checkingList' : 'checkList', 'HotelOrder[code]' => $model->code));
    }

    /**
     * 可换酒店范围数据
     * @param object $model 该酒店信息对象
     * @return array
     */
    private function _hotelChangeData($model) {
        $price = $model->total_price / HotelCalculate::getQuantity($model->attributes);
        $criteria = new CDbCriteria(array(
            'select' => 't.id, t.name',
            'condition' => 't.id = :id OR t.status = :status AND t.city_id = :city',
            'params' => array(':id' => $model->hotel_id, ':status' => Hotel::STATUS_PUBLISH, ':city' => $model->hotel->city_id),
            'order' => 'min_price ASC',
            'with' => array(
                'room' => array(
                    'select' => 'room.id, room.name, room.unit_price, room.estimate_price',
                    'condition' => 'room.id = :id OR room.unit_price <= :price',
                    'params' => array(':id' => $model->room_id, ':price' => $price,),
                    'order' => 'unit_price ASC',
                ),
            ),
        ));
        $hotels = Hotel::model()->findAll($criteria);
        $data = array();
        $i = 0;
        foreach ($hotels as $v) {
            $i = !$i ? $i : count($data);
            $data[$i]['flag'] = 0;
            $data[$i]['id'] = $v->id;
            $data[$i]['name'] = $v->name;
            $data[$i]['price'] = 0;
            $j = count($data);
            foreach ($v->room as $r) {
                $data[$j]['flag'] = $v->id;
                $data[$j]['id'] = $r->id;
                $data[$j]['name'] = $r->name;
                $data[$j]['price'] = ($r->id != $model->room_id) ? $r->unit_price : $model->unit_price;
                $data[$j]['estimatePrice'] = $r->estimate_price;
                $j++;
            }
            $i++;
        }
        return $data;
    }

    /**
     * 酒店订单数据变化
     * @param integer $id 酒店ID
     * @author jianlin.lin
     */
    public function actionRoomChange($id) {
        if ($this->isAjax()) {
            /** @var HotelOrder $model */
            $model = $this->loadModel($id);
            $rawOrder = clone $model;
            $model->attributes = $this->getParam('HotelOrder');
            $model->settled_time = strtotime($model->settled_time);
            $model->leave_time = strtotime($model->leave_time);
            $model->unit_price = $rawOrder->room_id == $model->room_id ? $rawOrder->unit_price : $model->room->unit_price;
            $model->gai_income = $rawOrder->room_id == $model->room_id ? $rawOrder->gai_income : $model->room->gai_income;
            $difference = HotelCalculate::difference($model->attributes, $rawOrder->attributes);
            $ratio = CJSON::decode($model->distribution_ratio); // 订单各角色分配比率
            $member = Yii::app()->db->createCommand()->select('type_id')->from('{{member}}')->where('id = :id', array(':id' => $model->member_id))->queryRow();
            $memberType = MemberType::fileCache();  // 会员类型
            $orderResult = HotelCalculate::orderIncome($model->attributes); // 算出订单待分配结果
            $memberResult = HotelCalculate::memberAssign($orderResult['surplusAssign'], $member, $ratio, $memberType);  // 算出会员分配金额
            $incomeIntegral = Common::convertSingle($memberResult['memberIncome'], $member['type_id']);
            $array = array(
                'hotel_id' => $model->hotel_id,
                'room_id' => $model->room_id,
                'integeal' => $incomeIntegral,
                'hotel_data' => $this->_hotelChangeData($model),
            );
            exit(CJSON::encode(array_merge($difference, $array)));
        }
    }

    /**
     * 未处理订单
     */
    public function actionNewHotelOrder() {
        $sql = "SELECT COUNT(*) FROM {{hotel_order}} WHERE status = :status";
        $count = Yii::app()->db->createCommand($sql)->queryScalar(array(':status' => HotelOrder::STATUS_NEW));
        echo $count;
    }

    /**
     * 获取状态颜色
     * @param integer $value 状态值
     * @return string
     */
    public static function getStatusColor($value) {
        $colorClass = '';
        if (HotelOrder::STATUS_NEW == $value)
            $colorClass = 'textColor_blue';
        elseif (HotelOrder::STATUS_VERIFY == $value)
            $colorClass = 'textColor_fuchsia';
        elseif (HotelOrder::STATUS_SUCCEED == $value)
            $colorClass = 'textColor_green';
        elseif (HotelOrder::STATUS_CLOSE == $value)
            $colorClass = 'textColor_red';
        return $colorClass;
    }

    /**
     * 获取支付状态颜色
     * @param integer $value 支付状态值
     * @return string
     */
    public static function getPayStatusColor($value) {
        $colorClass = '';
        if (HotelOrder::PAY_STATUS_NO == $value)
            $colorClass = 'textColor_red';
        elseif (HotelOrder::PAY_STATUS_YES == $value)
            $colorClass = 'textColor_green';
        return $colorClass;
    }

    /**
     * 添加跟进记录
     * @param $orderId
     */
    public function actionAddFollow($orderId){
        $model = new HotelOrderFollow();
        if($this->isPost()) {
            $model->attributes = $this->getPost('HotelOrderFollow');
            $order = HotelOrder::model()->findByPk($orderId);
            if ($order) {
                /** @var HotelOrder $order */
                $model->order_id = $orderId;
                $model->status = $order->status;
                $model->creater = Yii::app()->user->name;
                $model->create_time = time();
                if ($model->save()) {
                    echo '<script> var success = true; </script>';
                } else {
                    $this->setFlash('error', '添加失败');
                }
            }
            else{
                $this->setFlash('error', '订单不存在');
            }
        }
        $this->render('follow_form', array(
            'model' => $model,
        ));
    }

    /**
     * 查看订单跟进详情
     * @param $orderId
     */
    public function actionViewFollow($orderId){
        $follows = HotelOrderFollow::model()->findAllByAttributes(array(),'order_id=:orderId',array(':orderId'=>$orderId));
        $this->render('follow_view', array(
            'follows' => $follows,
        ));
    }

    /**
     * 酒店订单签收
     * @param $id
     */
    public function actionSign($id){
        $order = HotelOrder::model()->findByAttributes(array(),'id=:id and pay_status=:pay and is_sign=:sign',array(':id'=>$id,':pay'=>HotelOrder::PAY_STATUS_YES,':sign'=>HotelOrder::IS_SIGN_NO));
        $order->setScenario('orderSign');
        if($this->isPost()){
            $order->attributes = $this->getPost('HotelOrder');
            /** @var HotelOrder  $order */
            $order->is_sign = HotelOrder::IS_SIGN_YES;
            $order->sign_user = Yii::app()->user->name;
            $order->sign_time = time();
            if($order->save()) {
                $this->setFlash('success', '订单签收成功');
                $this->redirect(array('hotelOrder/noVerifyList'));
            }else{
                $this->setFlash('error', '订单签收失败,'. CHtml::errorSummary($order) );
            }
        }
        $this->render('sign', array('model' => $order));
    }

}
