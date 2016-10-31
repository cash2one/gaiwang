<?php

/**
 *  红包活动商品标签
 * @author ling.wu
 */
class RedActivityTagController extends Controller
{


    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 红包活动商品标签列表
     */
    public function actionAdmin()
    {
        $model = new ActivityTag('search');
        $model->unsetAttributes();
        if (isset($_GET['ActivityTag']))
            $model->attributes = $this->getParam('ActivityTag');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 创建红包活动商品标签
     * @author ling.wu
     */
    public function actionCreate()
    {
        $model = new ActivityTag();
        $this->performAjaxValidation($model);

        if (isset($_POST['ActivityTag'])) {
            $model -> attributes = $this->getPost('ActivityTag');
            $model -> create_time = time();
            $model -> status = ActivityTag::STATUS_OFF;
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "添加红包活动商品标签：{$model->name}");
                $this->setFlash('success', Yii::t('Activity', "添加{$model->name}成功！"));
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', Yii::t('Activity', "添加{$model->name}失败！"));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 红包活动标签状态修改
     * @param int $id
     * @param int $status
     */
    public function actionStatusChange($id, $status)
    {
        $status = intval($status);
        if (!in_array($status, array(ActivityTag::STATUS_OFF,ActivityTag::STATUS_ON)))
            $this->setFlash('error', Yii::t('activityTag', '参数错误!'));
        if (Yii::app()->db->createCommand()->update('{{activity_tag}}',array('status'=>$status),'id=:id',array(':id'=>$id))) {
            @SystemLog::record(Yii::app()->user->name . "更改状态成功");
        } else {
            Yii::app()->user->setFlash('error', Yii::t('redActivityTag', '更改状态失败'));
        }
        $this->redirect(array('admin'));
    }

    /**
     * 更新红包消费起始比例
     * @param $id
     */

    public function ActionUpdateRatio($id)
    {
        $model = ActivityTag::model()->find(array('select'=>'id,ratio','condition'=>'id=:id','params'=>array(':id'=>$id)));
        if(!$model)
            $this->setFlash('error', Yii::t('activityTag', '活动不存在!'));
        $this->performAjaxValidation($model);

        if (isset($_POST['ActivityTag'])) {
            $model->attributes = $this->getParam('ActivityTag');
            if ($model->save(true,array('ratio'))) {
                @SystemLog::record(Yii::app()->user->name . "更新红包消费起始比例成功");
                $this->setFlash('success', Yii::t('RedEnvelopeActivity', '更新红包消费起始比例成功'));
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error',CHtml::errorSummary($model).Yii::t('RedEnvelopeActivity', '更新红包消费起始比例失败'));
            }
        }
        $this->render('updateRatio', array(
            'model' => $model,
        ));
    }

    /**
     * 标签重命名
     * @param $id
     */
    public function ActionUpdateName($id)
    {
        $model = ActivityTag::model()->find(array('select'=>'id,name','condition'=>'id=:id','params'=>array(':id'=>$id)));
        if(!$model)
            $this->setFlash('error', Yii::t('activityTag', '活动不存在!'));
        $this->performAjaxValidation($model);

        if (isset($_POST['ActivityTag'])) {
            $model->attributes = $this->getParam('ActivityTag');
            if ($model->save(true,array('name'))) {
                @SystemLog::record(Yii::app()->user->name . "标签重命名成功");
                $this->setFlash('success', Yii::t('RedEnvelopeActivity', '标签重命名成功'));
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error',CHtml::errorSummary($model).Yii::t('RedEnvelopeActivity', '标签重命名失败'));
            }
        }
        $this->render('updateName', array(
            'model' => $model,
        ));
    }
}
