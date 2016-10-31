<?php

/**
 * 城市控制器
 * Class CityController
 */
class CityController extends TController
{
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'ajaxGetCity';
    }

    /**
     * ajax 获取城市
     */
    public function actionAjaxGetCity()
    {
        if($this->isAjax() && isset($_POST['province_code'])) {
            $data = City::model()->findAll(array('select' => 'name,code', 'condition' => 'province_code=:province_code', 'params' => array(':province_code' => $this->getParam('province_code'))));

            $data = CHtml::listData($data, 'code', 'name');
            $dropDownCity = CHtml::dropDownList('', '', $data, array('empty' => '全部'));

            echo CJSON::encode(array(
                'dropDownCities' => $dropDownCity,
            ));
        }
    }

    /**
     * 获取商业区和行政区
     */
    public function actionAjaxGetDisAndBus(){
        if($this->isAjax() && isset($_POST['city_code'])) {
            $data = District::model()->findAll(array('select' => 'name,code', 'condition' => 'city_code=:city_code', 'params' => array(':city_code' => $this->getParam('city_code'))));
            $data = CHtml::listData($data, 'code', 'name');
            $dropDownDistrict = CHtml::dropDownList('', '', $data, array('empty' => '全部'));

            $data = Business::model()->findAll(array('select' => 'name,code', 'condition' => 'city_code=:city_code', 'params' => array(':city_code' => $this->getParam('city_code'))));
            $data = CHtml::listData($data, 'code', 'name');
            $dropDownBusiness = CHtml::dropDownList('', '', $data, array('empty' => '全部'));

            echo CJSON::encode(array(
                'dropDownDistrict' => $dropDownDistrict,
                'dropDownBusiness' => $dropDownBusiness,
            ));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new City('search');
        $model->unsetAttributes();
        if (isset($_GET['City']))
            $model->attributes = $this->getParam('City');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new City();
        $this->performAjaxValidation($model);
        if (isset($_POST['City'])) {
            $model->attributes = $this->getParam('City');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "添加城市：{$model->name}成功！");
                $this->setFlash('success', '添加城市：' . $model->name . '成功！');
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
        if (isset($_POST['City'])) {
            $model->attributes = $this->getParam('City');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record(Yii::app()->user->name . "更新城市：{$model->name}成功！");
                $this->setFlash('success', '更新城市：' . $model->name . '成功！');
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        // 城市、地区下来选项的数据
        $model->nation_id = Province::model()->find(array('select' => 'nation_id', 'condition' => 'code=:code', 'params' => array(':code' => $model->province_code)))->nation_id;

        $province = CHtml::listData(Province::model()->findAll('code = :code', array(':code' => $model->province_code)), 'code', 'name');
        $this->render('_form', array(
            'model' => $model,
            'province' => $province,
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
            @SystemLog::record(Yii::app()->user->name . "删除城市：{$model->name}");
            $this->setFlash('success', '删除城市成功');
        } else
            $this->setFlash('error', '删除城市失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
} 