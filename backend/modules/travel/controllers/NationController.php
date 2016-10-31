<?php

/**
 * 国家控制器
 * Class NationController
 */
class NationController extends TController
{
    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new Nation('search');
        $model->unsetAttributes();
        if (isset($_GET['Nation']))
            $model->attributes = $this->getParam('Nation');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new Nation();
        $this->performAjaxValidation($model);
        if (isset($_POST['Nation'])) {
            $model->attributes = $this->getParam('Nation');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加国家：{$model->name}成功！");
                $this->setFlash('success', '添加国家：'. $model->name . '成功！');
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('_form', array(
            'model' => $model,
        ));
    }


    /**
     * 更新
     * @param int $id
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Nation'])) {
            $model->attributes = $this->getParam('Nation');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新国家：{$model->name}成功！");
                $this->setFlash('success', Yii::t('advertPicture', '更新国家：') . $model->name . '成功！');
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('_form', array(
            'model' => $model,
        ));
    }


    /**
     * 删除
     * @param int $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            @SystemLog::record(Yii::app()->user->name . "删除国家：{$id}");
            $this->setFlash('success', '删除国家成功');
        } else
            $this->setFlash('error', '删除国家失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}