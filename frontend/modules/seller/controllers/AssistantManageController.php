<?php
/**
 * 店小二管理
 *
 * 操作(修改密码)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class AssistantManageController extends SController
{

    public function init() {
        $this->pageTitle = Yii::t('sellerAssistantManage', '_卖家平台_') . Yii::app()->name;
    }
    /**
     * 店小二信息，登录后默认的显示页面
     */
    public function actionDefaultShow(){
        $this->pageTitle = Yii::t('sellerAssistantManage','欢迎店小二登录').$this->pageTitle;
        $logs = SellerLog::model()->findAllByAttributes(array(
            'member_id'=>$this->getSession('assistantId'),
            'is_admin'=>SellerLog::ADMIN_NO),array('limit'=>'10','order'=>'id DESC'));
        $this->render('defaultshow',array('logs'=>$logs));
    }

    /**
     * 修改密码
     */
    public function actionChangePw(){
        $this->pageTitle = Yii::t('sellerAssistantManage','修改密码').$this->pageTitle;
        /** @var $model Assistant */
        $model = Assistant::model()->findByPk($this->getSession('assistantId'));
        $model->scenario = 'changePw';

        $this->performAjaxValidation($model);

        if(isset($_POST['Assistant'])){
            $model->attributes = $this->getPost('Assistant');

            if(!$model->validatePassword($model->oldPassword)){
                $model->addError('oldPassword',Yii::t('sellerAssistantManage','旧密码不正确'));
            }
            if($model->validate(null,false) && $model->save()){
                $this->setFlash('success','修改密码成功');
                SellerLog::create(SellerLog::CAT_MEMBERS,SellerLog::logTypeUpdate,$model->id,'修改密码');
                $this->refresh();
            }else{
                $this->setFlash('error',Yii::t('sellerAssistantManage','修改密码失败'));
            }
        }
        $this->render('changepw',array('model'=>$model));
    }




}
