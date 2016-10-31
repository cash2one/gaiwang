<?php

/**
 * 价格计划
 * Class RatePlanController
 */
class RatePlanController extends TController
{


    /**
     * 价格计划列表
     * @param $hotelId
     * @param $roomId
     */
    public function actionAdmin($hotelId,$roomId)
    {
        $model = new HotelRatePlan('search');
        $model->unsetAttributes();
        $model->room_id = $roomId;
        $model->hotel_id = $hotelId;
        if (isset($_GET['HotelRatePlan']))
            $model->attributes = $this->getParam('HotelRatePlan');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加酒店
     * @param $hotelId
     * @param $roomId
     */
    public function actionCreate($hotelId,$roomId)
    {
        $model = new HotelRatePlan();
        $model->hotel_id = $hotelId;
        $model->room_id = $roomId;
        $this->performAjaxValidation($model);

        if (isset($_POST['HotelRatePlan'])) {
            $model->attributes = $this->getParam('HotelRatePlan');
            $model->rate_plan_id = HotelRatePlan::createHandRatePlanID();
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "添加价格计划：{$model->rate_plan_name}成功");
                    Yii::app()->user->setFlash('success', '添加价格计划成功！');
                    $this->redirect($this->createAbsoluteUrl('ratePlan/admin',array('hotelId'=>$model->hotel_id,'roomId'=>$model->room_id)));
                } else {
                    Yii::app()->user->setFlash('error', '添加价格计划失败！');
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('create', array(
            'model' => $model,

        ));
    }

    /**
     * 更新价格计划
     * @param $id
     */
    public function actionUpdate($id)
    {
        $model = HotelRatePlan::model()->findByPk($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['HotelRatePlan'])) {
            $model->attributes = $this->getParam('HotelRatePlan');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "更新价格计划：{$model->rate_plan_name}成功");
                    Yii::app()->user->setFlash('success', '更新价格计划成功！');
                    $this->redirect($this->createAbsoluteUrl('ratePlan/admin',array('hotelId'=>$model->hotel_id,'roomId'=>$model->room_id)));
                } else {
                    Yii::app()->user->setFlash('error', '更新价格计划失败！');
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除价格计划
     * @param $id
     */
    public function actionDelete($id)
    {
        if (!is_numeric($id)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $trans = Yii::app()->tr->beginTransaction();
        try {
            $model = HotelRatePlan::model()->findByPk($id);
            $model->delete();
            $trans->commit();
            Yii::app()->user->setFlash('success', '删除成功！');
        } catch (Exception $e) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', '删除失败！');
        }
        $this->redirect($this->createAbsoluteUrl('ratePlan/admin',array('hotelId'=>$model->hotel_id,'roomId'=>$model->room_id)));
    }

} 