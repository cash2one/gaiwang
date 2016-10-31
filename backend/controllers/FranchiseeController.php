<?php

/**
 * 加盟商控制器
 * 操作(创建加盟商,修改加盟商,删除加盟商,加盟商列表)
 * @author jianlin_lin <hayeslam@163.com>
 */
class FranchiseeController extends Controller {

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
        return 'getParentFranchisee, getParentName';
    }

    /**
     * 创建加盟商
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionCreate() {
        $model = new Franchisee;
        $this->performAjaxValidation($model);
        if (isset($_POST['Franchisee'])) {
            $dataAll = $this->getPost('Franchisee');
            $model->attributes = $dataAll;
            $model->categoryId = empty($dataAll['categoryId']) ? '' : $dataAll['categoryId'];
            $model = $this->_attrDispose($model);
            $model = UploadedFile::uploadFile($model, 'logo', 'franchisee');
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save())
                    throw new Exception;
                if(!empty($model->categoryId)){
                    foreach ($model->categoryId as $value)
                        Yii::app()->db->createCommand()->insert('{{franchisee_to_category}}', array(
                            'franchisee_id' => $model->id,
                            'franchisee_category_id' => $value
                        ));
                }
                UploadedFile::saveFile('logo', $model->logo);
                SystemLog::record($this->getUser()->name . "创建加盟商：" . $model->name);
                $this->setFlash('success', Yii::t('franchisee', '添加加盟商') . $model->name . Yii::t('franchisee', '成功'));
                $transaction->commit();
                $this->redirect(array('admin'));
            } catch (Exception $e) {
                $this->setFlash('error', $e->getMessage());
            }
        }
        $model->status = Franchisee::STATUS_DISABLED;
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 编辑加盟商
     * （基本信息｝
     * @param int $id
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $model = $this->_attrDispose($model);
        $model->unsetAttributes(array('password'));
        $this->performAjaxValidation($model);
        if (isset($_POST['Franchisee'])) {
            $dataAll = $this->getPost('Franchisee');
            $model->attributes = $dataAll;
            $model->categoryId = empty($dataAll['categoryId']) ? '' : $dataAll['categoryId'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save())
                    throw new Exception;
                FranchiseeToCategory::model()->deleteAll('franchisee_id=:fid', array(':fid' => $model->id));
                if(!empty($dataAll['categoryId'])){
                    foreach ($model->categoryId as $value)
                        Yii::app()->db->createCommand()->insert('{{franchisee_to_category}}', array(
                            'franchisee_id' => $model->id,
                            'franchisee_category_id' => $value
                        ));
                }
                SystemLog::record($this->getUser()->name . "修改加盟商：" . $model->name);
                $this->setFlash('success', Yii::t('franchisee', '修改加盟商') . $model->name . Yii::t('franchisee', '的基本信息成功'));
                $transaction->commit();
                $this->redirect(array('admin'));
            } catch (Exception $e) {
                $this->setFlash('error', $e->getMessage());
            }
        }
        //百度编辑器会在已经转义了的双引号外层,额外加上双引号
        $model->featured_content = str_replace(array('\"',"\'"),array('"',"'"),$model->featured_content);
        $model->description = str_replace(array('\"',"\'"),array('"',"'"),$model->description);

        $this->render('update', array(
//            'arrName' => $arrName,
            'model' => $model,
        ));
    }

    /**
     * 编辑加盟商
     * （重要信息）
     * @author wanyun.liu <wanyun_liu@163.com>
     * @param type $id
     */
    public function actionUpdateImportant($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'updateImportant';
        $model = $this->_attrDispose($model);
        $model->unsetAttributes(array('password'));
        $this->performAjaxValidation($model);
        if (isset($_POST['Franchisee'])) {
            $model->attributes = $this->getPost('Franchisee');
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改加盟商：" . $model->name . '重要信息');
                $this->setFlash('success', Yii::t('franchisee', '修改加盟商') . $model->name . Yii::t('franchisee', '的重要信息成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('updateimportant', array(
            'model' => $model,
        ));
    }

    /**
     * 修改加盟商  图片管理
     */
    public function actionUpdateImgs($id) {
        $model = $this->loadModel($id);
        $model = $this->_attrDispose($model);
        $model->unsetAttributes(array('password'));
        $this->performAjaxValidation($model);

        $model->scenario = 'updateImgs';


        if (isset($_POST['Franchisee'])) {
            $oldLogo = $this->getParam('oldLogo');
            $oldLogo2 = $this->getParam('oldLogo2');
            $oldThumbnail = $this->getParam('oldThumbnail');

            $tag = true;
            //检查图片大小
            if (isset($_FILES['Franchisee']['tmp_name']['logo']) && $_FILES['Franchisee']['tmp_name']['logo'] != '') {
                $imageinfo = getimagesize($_FILES['Franchisee']['tmp_name']['logo']);
                $width = $imageinfo[0];
                $height = $imageinfo[1];
                if ($width != 340 && $height != 170) {
                    $tag = false;
                    $this->setFlash('error', Yii::t('franchisee', '请上传340*170大小的logo图！'));
                }
            }

            if (isset($_FILES['Franchisee']['tmp_name']['logo2']) && $_FILES['Franchisee']['tmp_name']['logo2'] != '') {
                $imageinfo = getimagesize($_FILES['Franchisee']['tmp_name']['logo2']);
                $width = $imageinfo[0];
                $height = $imageinfo[1];
                if ($width != 170 && $height != 170) {
                    $tag = false;
                    $this->setFlash('error', Yii::t('franchisee', '请上传170*170大小的logo2图！'));
                }
            }

            if (isset($_FILES['Franchisee']['tmp_name']['thumbnail']) && $_FILES['Franchisee']['tmp_name']['thumbnail'] != '') {
                $imageinfo = getimagesize($_FILES['Franchisee']['tmp_name']['thumbnail']);
                $width = $imageinfo[0];
                $height = $imageinfo[1];
                if ($width != 1200 && $height != 400) {
                    $tag = false;
                    $this->setFlash('error', Yii::t('franchisee', '请上传1200*400大小的代表图！'));
                }
            }

            if ($tag) {
                $saveDir = 'franchisee/' . date('Y/n/j');
                $model = UploadedFile::uploadFile($model, 'logo', $saveDir); // 上传文件
                $model = UploadedFile::uploadFile($model, 'logo2', $saveDir); // 上传文件        
                $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);

                if (isset($_REQUEST['Franchisee'])) {
                    $model->id = $id;
                    $form = $_REQUEST['Franchisee'];
                    $model->attributes = $form;
                }

                if ($model->save()) {
                    SystemLog::record($this->getUser()->name . "修改加盟商图片：" . $model->name);
                    UploadedFile::saveFile('logo', $model->logo, $oldLogo, true); // 保存并删除旧文件
                    UploadedFile::saveFile('logo2', $model->logo2, $oldLogo2, true);
                    UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldThumbnail, true);
                    $this->setFlash('success', Yii::t('franchisee', '修改加盟商') . $model->name . Yii::t('franchisee', '成功'));
                    $this->redirect(array('admin'));
                } else {
                    $this->setFlash('error', Yii::t('franchisee', '修改加盟商') . $model->name . Yii::t('franchisee', '失败') . ':' . CHtml::errorSummary($model));
                }
            }
        }


        //处理路径
        $pics = FranchiseePicture::model()->findAll("franchisee_id={$model->id}");
        $pic_arr = array();
        foreach ($pics as $val) {
            $pic_arr[] = $val->path;
        }
        $model->path = implode('|', $pic_arr);

        $this->render('imgsupdate', array(
            'model' => $model,
        ));
    }

    /**
     * 删除加盟商
     * @param type $id
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $file = $model->logo;
        if ($model->delete())
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $file);
        SystemLog::record($this->getUser()->name . "删除加盟商：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 加盟商列表
     */
    public function actionAdmin() {
        $model = new Franchisee('search');
        $model->unsetAttributes();
        if (isset($_GET['Franchisee'])){
            $model->attributes = $this->getParam('Franchisee');
        }
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'franchisee/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('admin', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    /**
     * 加盟商列表   导出操作
     */
    public function actionAdminExport() {
        $model = new Franchisee('search');
        $model->unsetAttributes();
        if (isset($_GET['Franchisee']))
            $model->attributes = $this->getParam('Franchisee');
        SystemLog::record($this->getUser()->name . "导出加盟商列表");
        $model->isExport = 1;
        $this->render('adminexport', array(
            'model' => $model,
        ));
    }
    
       /**
     * 异常商户列表   导出操作
     */
    public function actionAbnormalExport() {
        $model = new AbnormalMerchants();
        $model->unsetAttributes();
        if (isset($_GET['AbnormalMerchants'])){
            $data = $this->getParam('AbnormalMerchants');
            $model->name = $data['name'];           
            $model->gai_number = $data['gai_number'];
        }
        SystemLog::record($this->getUser()->name . "导出异常商户列表");
        $model->isExport = 1;
        $this->render('abnormalexport', array(
            'model' => $model,
        ));
    }

    public function actionGetParentFranchisee() {
        $model = new Franchisee('search');
        $model->unsetAttributes();
        if (isset($_GET['Franchisee']))
            $model->attributes = $_GET['Franchisee'];

        $this->render('parentfranchisee', array(
            'model' => $model,
        ));
    }

    /**
     * 获取父类名称
     * @param type $id
     */
    public function actionGetParentName($id) {
        if ($this->isAjax()) {
            $model = Franchisee::model()->find('id = :id', array('id' => $id));
            if (!is_null($model))
                echo CJSON::encode($model->name);
            else
                echo CJSON::encode(null);
        }
    }

    /**
     * 属性处理
     * @param type $model
     * @return type
     */
    private function _attrDispose($model) {
        if ($model->parent_id) {
            $fModel = $model->find('id = :pid', array('pid' => $model->parent_id));
            $model->parentName = $fModel->name;
        }
        /*
          if ($model->member_id) {
          $mModel = Member::model()->find('id = :id', array('id' => $model->member_id));
          $model->memberName = $mModel->username;
          } */
        return $model;
    }

    /**
     * 盖网通商城订单
     * @author rdj
     */
    public function actionMachineOrderList() {

        $model = new MachineProductOrder();
        if (isset($_REQUEST['MachineProductOrder'])) {
            $model->attributes = $_REQUEST['MachineProductOrder'];
            $model->min_price = $_GET['MachineProductOrder']['min_price'];
            $model->max_price = $_GET['MachineProductOrder']['max_price'];
            $model->fnum = $_GET['MachineProductOrder']['fnum']; //加盟商编号
            $model->fname = $_GET['MachineProductOrder']['fname']; //加盟商名称
            $model->province_id = $_GET['MachineProductOrder']['province_id'];
            $model->city_id = $_GET['MachineProductOrder']['city_id'];
            $model->district_id = $_GET['MachineProductOrder']['district_id'];
            $model->gai_numbers = $_GET['MachineProductOrder']['gai_numbers'];
        }



        $this->render('machineorderlist', array(
            'model' => $model,
        ));
    }

    /**
     * 盖网通商城订单详情
     * @author rdj
     */
    public function actionMachineOrderDetail($id) {

        $model = MachineProductOrder::model()->findByPk($id);
        $model->is_read = MachineProductOrder::READ_YES;
        $model->save();
        $this->render('machineorderdetail', array(
            'model' => $model
        ));
    }

    /**
     * 盖网通商城订单详情--重发短信
     * @author LC
     */
    public function actionResendSms($id) {

        $model = MachineProductOrderDetail::model()->findByPk($id);
        if ($this->isAjax()) {
            $smsModel = SmsLog::model()->findByPk($model->sms_id);
            $result = Sms::send($smsModel->phone, $smsModel->msg);
            // Tool::pr($result);
            $smsModel->unsetAttributes(array('id'));
            $smsModel->attributes = $result;
            $smsModel->send_count = 1;
            $smsModel->setIsNewRecord(true);
            $smsModel->save();
            if ($result['send_status'] == SmsLog::STATUS_SUCCESS) {
                echo 1;
            } else {
                echo 0;
            }
        }
        Yii::app()->end();
    }

    /**
     * 盖网通商城订单详情--验证消费
     * @author LC
     */
    public function actionVerifyConsumed($id) {
        if ($this->isAjax()) {
            $model = MachineProductOrderDetail::model()->findByPk($id);
            $verify_code = $this->getParam('verify_code');
            $rs = MachineOrder::distribution($id, $verify_code);
//                    if($model->is_consumed == MachineProductOrderDetail::IS_CONSUMED_NO&&$verify_code == $model->verify_code)
//                    {
//                            $model->is_consumed = MachineProductOrderDetail::IS_CONSUMED_YES;
//                            $model->consume_time = time();
//                            $model->machineProductOrder->status = MachineProductOrder::STATUS_COMPLETE;
//                            $model->machineProductOrder->is_read = MachineProductOrder::READ_YES;
//                            $model->machineProductOrder->consume_status = MachineProductOrder::CONSUME_STATUS_YES;
//
//                            $model->machineProductOrder->consume_time = time();
//                            $transaction = Yii::app()->db->beginTransaction();
//                        try {
//                        	$consumer_money = IntegralOffline::machineProductOrderDetailDistribution($model);
//	            			$model->return_money = $consumer_money;
//	            			if($model->save() && $model->machineProductOrder->save())
//	            			{
//	            				$transaction->commit(); //提交事务会真正的执行数据库操作
//	            			}
//                            else 
//                            {
//                            	throw new ErrorException('error', 400);
//                            }
//                            //$this->_saveLog(SellerLog::logMachineProductOrderDetailVerify, SellerLog::logTypeUpdate, $model->id);
//                            SystemLog::record($this->getUser()->name."验证消费：".$model->product_name);
//                        //发送短信提示
//			                $machineOrderConsumeAfterVerify = $this->getConfig('smsmodel', 'machineOrderConsumeAfterVerify');
//			                $machineOrderConsumeAfterVerify = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}'), array($model->machineProductOrder->member->gai_number, IntegralOffline::conversionDate($model->machineProductOrder->pay_time), $model->machineProductOrder->franchisee->name, $model->product_name, $model->quantity),$machineOrderConsumeAfterVerify);
//			                $smsRes = Sms::send($model->machineProductOrder->phone, $machineOrderConsumeAfterVerify);
//				            if(!empty($smsRes)){
//					            $smsRes['source_id'] = SmsLog::SOURCE_MACHINE_ORDER_SUCCESS;
//			            		$smsRes['msg_key'] = SmsLog::MSG_KEY_MACHINE_PRODUCT_CONSUME;
//					            Yii::app()->db->createCommand()->insert('{{sms_log}}', $smsRes);
//					        }
//                            echo 1;
//                        } catch (Exception $e) {
//                            $transaction->rollback(); //如果操作失败, 数据回滚
//                            echo 0;
//                        }
//                    }
//                    else
//                    {
//                            echo 2;
//                    }
            if ($rs === true) {
                SystemLog::record($this->getUser()->name . "验证消费：" . $model->product_name);
                //发送短信提示
                $machineOrderConsumeAfterVerify = $this->getConfig('smsmodel', 'machineOrderConsumeAfterVerify');
                $machineOrderConsumeAfterVerify = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}'), array($model->machineProductOrder->member->gai_number, IntegralOffline::conversionDate($model->machineProductOrder->pay_time), $model->machineProductOrder->franchisee->name, $model->product_name, $model->quantity), $machineOrderConsumeAfterVerify);
                $smsRes = Sms::send($model->machineProductOrder->phone, $machineOrderConsumeAfterVerify);
                if (!empty($smsRes)) {
                    $smsRes['source_id'] = SmsLog::SOURCE_MACHINE_ORDER_SUCCESS;
                    $smsRes['msg_key'] = SmsLog::MSG_KEY_MACHINE_PRODUCT_CONSUME;
                    Yii::app()->db->createCommand()->insert('{{sms_log}}', $smsRes);
                }
                echo 1;
            } elseif ($rs === 102) {
                echo 2;
            } else {
                echo 0;
            }
        }
        Yii::app()->end();
    }

    /*
     * 异常商户列表
     */
    public function actionAbnormal(){
        $model = new AbnormalMerchants();   
        $model->unsetAttributes();
        if (isset($_GET['AbnormalMerchants'])){
            $data = $this->getParam('AbnormalMerchants');
            $model->name = $data['name'];           
            $model->gai_number = $data['gai_number'];
        }
        $this->showExport = true;
        $this->exportAction = 'abnormalExport';
        $totalCount = $model->getData()->getTotalItemCount();
       
        $exportPage = new CPagination($totalCount);
        
        $exportPage->route = 'franchisee/abnormalExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('abnormal', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }
    /**
     * 拉进异常商户
     * @param type $id
     */
    public function actionPullInto($id){
          if ($this->isAjax()) {
        $data=$this->loadModel($id);
        $model = new AbnormalMerchants();
        $abnormal = AbnormalMerchants::model()->find('merchants_id=:mid',array(':mid'=>$id));
        if(empty($abnormal)){
        $model->merchants_id = $data->id;
        $model->type = AbnormalMerchants::TYPE_OFFLINE;
        if($model->save()){
              SystemLog::record($this->getUser()->name . "拉进异常加盟商：" .$data['name'].', id:'.$id );
              echo true;
        }
        }else{
           echo false;
        }
          }
    }
    
    /**
     * 移出异常商户
     * @param type $id
     */
    public function actionRemove($id){

     $model = AbnormalMerchants::model()->findByPk($id);
     if($model->delete()){
           SystemLog::record($this->getUser()->name . "移除异常加盟商：" . $id);
            $this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '移出异常列表成功!'));
            $this->redirect(array('franchisee/abnormal'));
     }
    }
       /**
      * 获取商户数据
      */
     public function actionGetFranchisee(){
        $model = new Franchisee();
        $model->unsetAttributes();
        if (isset($_GET['Franchisee']))
            $model->attributes = $this->getParam('Franchisee');

        $this->render('franchisee', array(
            'model' => $model,
        ));
     }
}
