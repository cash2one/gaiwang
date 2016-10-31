<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewSpotController
 *
 * @author Administrator
 */
class ViewSpotController extends TController
{
//    //put your code here
//     /**
//     * 外部操作
//     * @return array
//     */
//    public function actions()
//    {
//        return array(
//            'ajaxUpdateSort' => array(
//                'class' => 'CommonAction',
//                'method' => 'ajaxUpdateSort',
//                'params' => array(
//                    'db' => 'tr',
//                    'table' => '{{viewspot}}',
//                ),
//            ),
//        );
//    }


    public function actionAdmin($cityCardId)
    {
        $model =new ViewSpot;      
        $model->findAll($cityCardId);
        $model->unsetAttributes();
        if (isset($_GET['ViewSpot']))
            $model->attributes = $this->getParam('ViewSpot');
        $this->render('admin', array(
            'model' => $model,
            'cityCardId' => $cityCardId,
        ));
    }

    public function actionCreate()
    {
        $model = new ViewSpot;
        if ($this->isAjax() && $_POST['ajax'] === $this->id . '-form') {
            $business = $this->getSurroundingBusinesses();
            $err = CActiveForm::validate($model);
            $bErr = CActiveForm::validate($business);
            $err = array_merge(CJSON::decode($err, true), CJSON::decode($bErr, true));
            echo CJSON::encode($err);
            Yii::app()->end();
        } else {
            $business = array(new SurroundingBusinesses());
        }

        if (isset($_POST['ViewSpot']) && isset($_POST['SurroundingBusinesses'])) {
            $model->attributes = $this->getParam('ViewSpot');
            $model->city_card_id = $this->getParam('cityCardId');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();

            $business = $this->getSurroundingBusinesses($model->city_card_id);
            $valid = $model->validate();
            $trans = Yii::app()->tr->beginTransaction();
            try {
                if($valid && $model->save(false)){
                    $viewSpotId = $model->id;
                    foreach ($business as $i => $b) {
                        $business[$i]->view_spot_id = $viewSpotId;
                        $business[$i]->creater = Yii::app()->user->name;
                        $business[$i]->created_at = time();

                        $bv = $business[$i]->validate();
                        if (!$bv) {
                            $valid = $bv;
                        }
                    }
                    if ($valid) {
                        foreach($business as $v){
                            $v->save(false);
                        }
                        $trans->commit();
                        Yii::app()->user->setFlash('success', '添加成功');
                        $this->redirect($this->createAbsoluteUrl('viewSpot/admin', array('cityCardId' => $model->city_card_id)));
                    }else{
                        throw new Exception('验证失败');
                    }
                }
            }catch (Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model).CHtml::errorSummary($business));
            }

        }
        $this->render('create', array('model' => $model, 'business' => $business,'id'=>$model->id));
    }

    public function getSurroundingBusinesses()
    {
        $bs = $this->getParam('SurroundingBusinesses');
        $count = count($bs);
        $business = array();
        foreach ($bs as $k => $v) {
            $b = new SurroundingBusinesses();
            $b->attributes = $v;
            $business[] = $b;
        }
        return $business;
    }
    
    /*
     * 编辑景点
     */
    public function actionUpdate($id){
       $model = $this->loadModel($id);   
       $city_card_id = $model->findAll($id);
       $city_card_id=$model->city_card_id;     
       $this->performAjaxValidation(array($model));
       $s = new SurroundingBusinesses();
       $business = $s ->findAll('view_spot_id=:id',array(':id'=>$id));
       if(isset($_POST['ViewSpot']) && isset($_POST['SurroundingBusinesses'])){
           $model->attributes = $this->getParam('ViewSpot');
            $model->city_card_id = $city_card_id;
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            $creater=SurroundingBusinesses::model()->findAll(array('select'=>'created_at,creater','condition'=>'view_spot_id=:id','params'=>array(':id'=>$id)));
            SurroundingBusinesses::model()->deleteAll('view_spot_id=:id',array(':id'=>$id));
           
             $business = $this->getSurroundingBusinesses($model->city_card_id);
            $valid = $model->validate();
            $trans = Yii::app()->tr->beginTransaction();
            try {
                if($valid && $model->save(false)){
                    $viewSpotId = $model->id;
                    foreach ($business as $i => $b) {
                        $business[$i]->view_spot_id = $viewSpotId;
                        $business[$i]->updater = Yii::app()->user->name;
                        $business[$i]->updated_at = time();
                        $business[$i]->creater = $creater[0]['creater'];
                        $business[$i]->created_at = $creater[0]['created_at'];

                        $bv = $business[$i]->validate();
                        if (!$bv) {
                            $valid = $bv;
                        }
                    }
                    if ($valid) {
                        foreach($business as $v){
                            $v->save(false);
                        }
                        $trans->commit();
                        Yii::app()->user->setFlash('success', '编辑成功');
                        $this->redirect($this->createAbsoluteUrl('viewSpot/admin', array('cityCardId' => $model->city_card_id)));
                    }else{
                        throw new Exception('验证失败');
                    }
                }
            }catch (Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model).CHtml::errorSummary($business));
            }
       }
       $this->render('update',array('model'=>$model,'business'=>$business));
    }
    
    /*
     * 删除景点
     */
    public function actionDelete($id){
        $this->loadModel($id)->delete();     
        SurroundingBusinesses::model()->deleteAll('view_spot_id=:id',array(':id'=>$id));        
        @SystemLog::record(Yii::app()->user->name . "删除景点：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}
