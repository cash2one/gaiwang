<?php

/**
 * 推广渠道统计
 * @author wyee<yanjie.wang@g-emall.com>
 *
 */

class PromotionStatisticsController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    
    public function actionAdmin() { 
        $model = new PromotionChannels('search');
        $model->unsetAttributes();
        if (isset($_GET['PromotionChannels']))
            $model->attributes = $_GET['PromotionChannels'];
        $this->render('admin',array('model'=>$model));
    }
    
    /**
     * 增加渠道信息
     */
    public function actionCreate(){
        $model = new PromotionChannels;
        $model->number=$this->generateTgNumber();
        $this->performAjaxValidation($model);
        if (isset($_POST['PromotionChannels'])) {
            $model->attributes = $_POST['PromotionChannels'];
            $model->create_time=time();
            if ($model->save(false)) {
                @SystemLog::record(Yii::app()->user->name."添加统计渠道：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('promotionStatistics', '数据保存成功'));
                $this->redirect(array('admin'));
            }else{
                @SystemLog::record(Yii::app()->user->name."添加统计渠道：{$model->name} 失败");
                Yii::app()->user->setFlash('error', Yii::t('promotionStatistics', '数据保存失败'));
                $this->redirect(array('admin'));
            }
        }  
        $this->render('create', array(
                'model' => $model,
        ));
    }
    
    /**
     * 查看渠道
     */
    public function actionView($id) {
        $model = $this->getModel($id);
        $this->render('view',array('model' => $model));
    }
    
    /**
     * 查看渠道
     */
    public function actionUpdate($id) {
        $model = $this->getModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['PromotionChannels'])) {
            $model->attributes = $_POST['PromotionChannels'];
            $model->update_time=time();
            if ($model->save(false)) {
                @SystemLog::record(Yii::app()->user->name."更新推广渠道：{$model->name} 成功");
                Yii::app()->user->setFlash('success', Yii::t('PromotionChannels', '推广渠道更新成功'));
                $this->redirect(array('admin'));
            }else{
                @SystemLog::record(Yii::app()->user->name."更新推广渠道：{$model->name} 失败");
                Yii::app()->user->setFlash('error', Yii::t('PromotionChannels', '推广渠道更新失败'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update',array('model' => $model));
    }
    
    /**
     * 删除渠道信息
     */
    public function actionDelete($id) {
        $model = $this->getModel($id);
        $model->delete();
        @SystemLog::record(Yii::app()->user->name."删除推广渠道：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    
    /**
     * 查看新会员数
     */
    public function actionMember() {
        $model = new Member('searchPromotionMem');
        $model->unsetAttributes();
        $id=$this->getParam('id');
        $model->promotion_id=$id;
        if (isset($_GET['Member']))
        $model->attributes = $_GET['Member'];
        $promotionInfo=$this->getModel($id);
        $this->render('member',array('model' => $model,'promotionInfo'=>$promotionInfo));
    }
    
    /**
     * 会员登录日志
     */
    public function actionMemberLog($id){
        $memberLogModel = new MemberLoginLog('search');
        $memberLogModel->member_id=$id;
        $memInfo=Member::getPositionMemInfo($id);
        $this->render('memberLog',array('model' => $memberLogModel,'memInfo'=>$memInfo));
    }

    /**
     * 生成唯一的推广编号 TG+6位数字
     * @return string
     */
    public function generateTgNumber() {
        $number = str_pad(mt_rand('1', '999999'), 6 , mt_rand(99999, 999999));
        return 'TG' . $number;
    }
    
    /**
     * 不使用继承的Controller通用方法
     * @see Controller::loadModel()
     */
    public function getModel($id){
        $model=PromotionChannels::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'请求的页面不存在');
        return $model;
    }
}
