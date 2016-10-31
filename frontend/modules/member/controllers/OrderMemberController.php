<?php

/**
 * 订单用户控制器 
 * @author  wyee<yanjie.wang@g-emall.com>
 */
class OrderMemberController extends MController {

	/**
	 * 订单用户列表
	 */
    public function actionIndex() {
        $this->pageTitle = Yii::t('ordrMember', '用户订单信息_用户中心_') . Yii::app()->name;
        $model = new OrderMember();
        $dataProvider=$model->getAllCodeByMid($this->getUser()->id);
        $orderMemberData=$dataProvider->getData();
        $pager=$dataProvider->getPagination();
        $this->render('index', array(
            'orderMember' => $orderMemberData,
        	'pager'=>$pager
        )); 
    }

    /**
     * dialog 添加订单用户
     */
    public function actionAdd(){
        $this->layout = false;
        $model = new OrderMember();
        $this->performAjaxValidation($model);
        if (isset($_POST['OrderMember'])) {
               $model->attributes =$this->getPost('OrderMember');
               $code=$model->code;
               $street=$model->street; 
               $codeArr=OrderMember::checkCode($code, $this->getUser()->id);
               if(empty($codeArr)){
               	 $this->setFlash('error', Yii::t('OrderMember', '订单信息有误，不可添加用户信息！'));
               	 $this->redirect(array('index'));
               		  
               }
               $model->create_time=time();
               $model->member_id=$this->getUser()->id;
               $model->code=$code;
               $model->street=$street;
               $saveDir = 'orderMember' . '/' . date('Y/n/j');
               $model = UploadedFile::uploadFile($model, 'identity_front_img', $saveDir);
               $model = UploadedFile::uploadFile($model, 'identity_back_img', $saveDir);
               try{
                    if($model->save()) { 
                    	UploadedFile::saveFile('identity_front_img', $model->identity_front_img);
                    	UploadedFile::saveFile('identity_back_img', $model->identity_back_img);
                        $this->setFlash('success', Yii::t('OrderMember', '添加订单用户信息成功！'));
                    }else{
                        $this->setFlash('error', Yii::t('OrderMember', '添加订单用户信息失败！'));
                    }  
                } catch (CException $e) {   
                    $this->setFlash('error', Yii::t('OrderMember', '添加订单用户信息失败！'));
            }
        }
        if($this->isAjax()){
            $add = $this->renderPartial('add',array('model'=>$model),true,true);
            exit(json_encode(array('add'=>$add)));
        } else {
        	$this->redirect(array('index'));
        }
    }

}
