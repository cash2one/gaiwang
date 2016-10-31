<?php

/**
 * 行政区控制器
 * Class DistrictController
 */
class DistrictController extends TController
{
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'ajaxGetDistrict';
    }

    /**
     * ajax 获取城市
     */
    public function actionAjaxGetDistrict()
    {
        if($this->isAjax() && isset($_POST['city_code'])) {
            $data = District::model()->findAll(array('select' => 'name,code', 'condition' => 'city_code=:city_code', 'params' => array(':city_code' => $this->getParam('city_code'))));
            $data = CHtml::listData($data, 'code', 'name');
            $dropDownDistrict = CHtml::dropDownList('', '', $data, array('empty' => '全部'));

            echo CJSON::encode(array(
                'dropDownDistrict' => $dropDownDistrict,
            ));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new District('search');
        $model->unsetAttributes();
        if (isset($_GET['District']))
            $model->attributes = $this->getParam('District');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new District();
        $this->performAjaxValidation($model);
        if (isset($_POST['District'])) {
            $model->attributes = $this->getParam('District');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加行政区：{$model->name}成功！");
                $this->setFlash('success', '添加行政区：' . $model->name . '成功！');
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
        if (isset($_POST['District'])) {
            $model->attributes = $this->getParam('District');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新行政区：{$model->name}成功！");
                $this->setFlash('success', '更新行政区：' . $model->name . '成功！');
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
            $this->setFlash('success', '删除行政区成功');
        } else
            $this->setFlash('error', '删除行政区失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
} 