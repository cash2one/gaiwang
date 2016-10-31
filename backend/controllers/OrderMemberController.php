<?php

/**
 * 订单用户详情
 * 操作(增加，编辑，删除，查找)
 * @author wyee<yanjie.wang@g-emall.com>
 */
class OrderMemberController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 订单用户列表
     */
    public function actionAdmin() {
        $this->breadcrumbs = array(Yii::t('order', '订单用户管理 '), Yii::t('order', '订单用户列表'));
        $model = new OrderMember('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderMember'])) {
            $model->attributes = $_GET['OrderMember'];
            $model->create_time = $_GET['OrderMember']['create_time'];
            $model->end_time = $_GET['OrderMember']['end_time'];
        }

        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'orderMember/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', array(
                'model' => $model,
                'exportPage' => $exportPage,
                'totalCount' => $totalCount,
        ));
    }

    /**
     * 导出订单用户
     */
    public function actionAdminExport() {
        set_time_limit(3600);
        @ini_set('memory_limit', '1048M');
        $model = new OrderMember('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderMember'])) {
            $model->attributes = $_GET['OrderMember'];
        }
        @SystemLog::record(Yii::app()->user->name . "导出订单用户列表");
        $model->isExport = 1;
        $this->render('adminExport', array(
                'model' => $model,
        ));
    }

    /**
     * 添加订单用户信息
     */

    public function actionCreate(){
        $model = new OrderMember();
        $this->performAjaxValidation($model);

        if (isset($_POST['OrderMember'])) {
            $model->attributes = $this->getPost('OrderMember');
            $model->member_id=$model->getMemberId($model->member_id);
            $orderArr=OrderMember::checkCode($model->code, $model->member_id);
            if(empty($orderArr)){
            	$this->setFlash('error', Yii::t('OrderMember', '添加订单用户失败,请确认该用户已支付过该订单!'));
            }else{
	            $model->create_time=time();
	            $saveDir = 'orderMember' . '/' . date('Y/n/j');
	            $model = UploadedFile::uploadFile($model, 'identity_front_img', $saveDir);  // 上传图片
	            $model = UploadedFile::uploadFile($model, 'identity_back_img', $saveDir);
            if ($model->save()) {
                UploadedFile::saveFile('identity_front_img', $model->identity_front_img);  // 保存图片
                UploadedFile::saveFile('identity_back_img', $model->identity_back_img);
                SystemLog::record($this->getUser()->name . "添加订单用户信息：" . $model->code.$model->member->gai_number);
                $this->setFlash('success', Yii::t('OrderMember', '添加订单用户信息') . '"' . $model->code.'/'.$model->member->gai_number . '"' . Yii::t('orderMember', '成功'));
             }
          }
           $this->redirect(array('admin'));
        }

        $this->render('create',array(
                'model'=>$model,
        ));
    }

    /**
     * 编辑订单用户信息
     * @param unknown $id
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->member_id=$model->member->gai_number;
        $this->performAjaxValidation($model);
        if (isset($_POST['OrderMember'])) {
            $model->attributes = $this->getPost('OrderMember');
            $model->member_id=OrderMember::getMemberId($model->member_id);
            $orderArr=OrderMember::checkCode($model->code, $model->member_id);
            if(empty($orderArr)){
                $this->setFlash('error', Yii::t('OrderMember', '修改订单用户失败,请确认该用户已支付过该订单!'));
            }else{
            $oldFrontImg = $this->getPost('oldFrontImg');  // 旧图
            $oldBackImg = $this->getPost('oldBackImg');
            $saveDir = 'orderMember'. DS  .date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'identity_front_img', $saveDir);  // 上传图片
            $model = UploadedFile::uploadFile($model, 'identity_back_img', $saveDir);  // 上传图片
            if ($model->save()) {
                UploadedFile::saveFile('identity_front_img', $model->identity_front_img, $oldFrontImg, true); // 更新图片
                UploadedFile::saveFile('identity_back_img', $model->identity_back_img, $oldBackImg, true);
                SystemLog::record($this->getUser()->name . "修改订单用户信息：" . $model->code.$model->member->gai_number);
                $this->setFlash('success', Yii::t('orderMember', '修改订单用户信息') . '"' . $model->code.$model->member->gai_number . '"' . Yii::t('orderMember', '成功'));
            }else{
                $this->setFlash('error', Yii::t('orderMember', '修改订单用户信息') . '"' . $model->code.$model->member->gai_number . '"' . Yii::t('orderMember', '失败'));
                }
           }
           $this->redirect(array('admin'));
        }
        $this->render('update', array(
                'model' => $model,
        ));
    }

    /**
     * 查看订单用户详情
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * 删除订单用户信息
     */
    public function actionDelete($id) {
    	$this->loadModel($id)->delete();
    	if(!isset($_GET['ajax']))
    	    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    }



}
