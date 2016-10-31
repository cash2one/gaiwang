<?php

/**
 * 价格计划条款
 * Class HotelTermController
 */
class HotelTermController extends TController
{


    /**
     * 条款列表
     * @param $ratePlanId
     */
    public function actionAdmin($ratePlanId)
    {
        $model = new HotelTerm('search');
        $model->unsetAttributes();
        $model->rateplan_id = $ratePlanId;
        if (isset($_GET['HotelTerm']))
            $model->attributes = $this->getParam('HotelTerm');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加条款
     * @param $ratePlanId
     */
    public function actionCreate($ratePlanId)
    {
        $model = new HotelTerm();
        $model->rateplan_id = $ratePlanId;
        $this->performAjaxValidation($model);

        if (isset($_POST['HotelTerm'])) {
            $model->attributes = $this->getParam('HotelTerm');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "添加条款：{$model->term_name}成功");
                    Yii::app()->user->setFlash('success', '添加条款成功！');
                    $this->redirect($this->createAbsoluteUrl('hotelTerm/admin',array('ratePlanId'=>$model->rateplan_id)));
                } else {
                    Yii::app()->user->setFlash('error', '添加条款失败！');
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
     * 更新条款
     * @param $id
     */
    public function actionUpdate($id)
    {
        $model = HotelTerm::model()->findByPk($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['HotelTerm'])) {
            $model->attributes = $this->getParam('HotelTerm');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "更新条款：{$model->term_name}成功");
                    Yii::app()->user->setFlash('success', '更新条款成功！');
                    $this->redirect($this->createAbsoluteUrl('hotelTerm/admin',array('ratePlanId'=>$model->rateplan_id)));
                } else {
                    Yii::app()->user->setFlash('error', '更新条款失败！');
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
     * 删除条款
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
            $model = HotelTerm::model()->findByPk($id);
            $model->delete();
            $trans->commit();
            Yii::app()->user->setFlash('success', '删除成功！');
        } catch (Exception $e) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', '删除失败！');
        }
        $this->redirect($this->createAbsoluteUrl('hotelTerm/admin',array('ratePlanId'=>$model->rateplan_id)));
    }

} 