<?php

/**
 * 行政区控制器
 * Class BusinessController
 */
class BusinessController extends TController
{
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'ajaxGetBusiness';
    }

    /**
     * ajax 获取商业区
     */
    public function actionAjaxGetBusiness()
    {
        if ($this->isAjax() && isset($_POST['city_code'])) {
            $data = Business::model()->findAll(array('select' => 'name,code', 'condition' => 'city_code=:city_code', 'params' => array(':city_code' => $this->getParam('city_code'))));
            $data = CHtml::listData($data, 'code', 'name');
            $dropDownBusiness = CHtml::dropDownList('', '', $data, array('empty' => '全部'));

            echo CJSON::encode(array(
                'dropDownBusiness' => $dropDownBusiness,
            ));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new Business('search');
        $model->unsetAttributes();
        if (isset($_GET['Business']))
            $model->attributes = $this->getParam('Business');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new Business();
        $this->performAjaxValidation($model);
        if (isset($_POST['Business'])) {
            $model->attributes = $this->getParam('Business');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加商业区：{$model->name}成功！");
                $this->setFlash('success', '添加商业区：' . $model->name . '成功！');
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
        if (isset($_POST['Business'])) {
            $model->attributes = $this->getParam('Business');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新商业区：{$model->name}成功！");
                $this->setFlash('success', '更新商业区：' . $model->name . '成功！');
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        // 城市、地区下来选项的数据
        $model->province_code = City::model()->find(array('select' => 'province_code', 'condition' => 'code=:code', 'params' => array(':code' => $model->city_code)))->province_code;
        $model->nation_id = Province::model()->find(array('select' => 'nation_id', 'condition' => 'code=:code', 'params' => array(':code' => $model->province_code)))->nation_id;

        $province = CHtml::listData(Province::model()->findAll('code = :code', array(':code' => $model->province_code)), 'code', 'name');
        $city = CHtml::listData(City::model()->findAll('code = :code', array(':code' => $model->city_code)), 'code', 'name');
        $this->render('_form', array(
            'model' => $model,
            'province' => $province,
            'city' => $city
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
            @SystemLog::record(Yii::app()->user->name . "删除商业区：{$model->name}");
            $this->setFlash('success', '删除商业区成功');
        } else
            $this->setFlash('error', '删除商业区失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
} 