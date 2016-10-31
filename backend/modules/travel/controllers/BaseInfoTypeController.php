<?php

/**
 * 静态信息类型控制器
 * Class BaseInfoTypeController
 */
class BaseInfoTypeController extends TController
{
    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new BaseInfoType('search');
        $model->unsetAttributes();
        if (isset($_GET['BaseInfoType']))
            $model->attributes = $this->getParam('BaseInfoType');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new BaseInfoType();
        $this->performAjaxValidation($model);
        if (isset($_POST['BaseInfoType'])) {
            $model->attributes = $this->getParam('BaseInfoType');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加静态信息类型：{$model->name}成功！");
                $this->setFlash('success', '添加静态信息类型：' . $model->name . '成功！');
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
        if (isset($_POST['BaseInfoType']) && $model->creater != 'API') {
            $model->attributes = $this->getParam('BaseInfoType');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新静态信息类型：{$model->name}成功！");
                $this->setFlash('success', '更新静态信息类型：' . $model->name . '成功！');
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }else{
            $this->setFlash('error', 'API数据不能编辑！');
            $this->redirect(array('admin'));
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
        if ($model->creater != 'API' && $model->delete()) {
            @SystemLog::record(Yii::app()->user->name . "删除静态信息类型：{$model->name}");
            $this->setFlash('success', '删除静态信息类型成功');
        } else
            $this->setFlash('error', '删除静态信息类型失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
} 