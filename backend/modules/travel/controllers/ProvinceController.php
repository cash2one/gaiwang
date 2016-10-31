<?php

class ProvinceController extends TController
{
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'ajaxGetProvince';
    }

    /**
     * ajax 获取省份
     */
    public function actionAjaxGetProvince()
    {
        if ($this->isAjax() && isset($_POST['nation_id'])) {
            $data = Province::model()->findAll(array('select' => 'name,code', 'condition' => 'nation_id=:nation_id', 'params' => array(':nation_id' => $this->getParam('nation_id'))));

            $data = CHtml::listData($data, 'code', 'name');
            $dropDownProvince = CHtml::dropDownList('empty', '', $data, array('empty' => Yii::t('member', '全部')));

            echo CJSON::encode(array(
                'dropDownProvinces' => $dropDownProvince,
            ));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new Province('search');
        $model->unsetAttributes();
        if (isset($_GET['Province']))
            $model->attributes = $this->getParam('Province');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new Province();
        $this->performAjaxValidation($model);
        if (isset($_POST['Province'])) {
            $model->attributes = $this->getParam('Province');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加省份：{$model->name}成功！");
                $this->setFlash('success', '添加省份：' . $model->name . '成功！');
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
        if (isset($_POST['Province'])) {
            $model->attributes = $this->getParam('Province');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新省份：{$model->name}成功！");
                $this->setFlash('success', '更新省份：' . $model->name . '成功！');
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
            @SystemLog::record(Yii::app()->user->name . "删除省份：{$id}");
            $this->setFlash('success', '删除省份成功');
        } else
            $this->setFlash('error', '删除省份失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}
