<?php

/**
 * 省份，城市，区县控制器类
 * 操作（实现省市区三级联动数据调用）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class RegionController extends Controller {

    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'updateProvince, updateCity, updateArea, regionTree,UpdateProvinceSign';
    }

    public function actionUpdateProvinceSign() {
        if ($this->isPost()) {
            $area_id = isset($_POST['area_id']) ? (int) $_POST['area_id'] : "9999999";
            if ($area_id) {
                $data = Region::getProvinceByAreaId($area_id);
            }
            $dropDownProvinces = "<option value=''>" . Yii::t('region', '选择省份') . "</option>";
            if (isset($data)) {
                foreach ($data as $value => $name)
                    $dropDownProvinces .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
//			var_dump($dropDownProvinces);die;
            $dropDownCitys = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownProvinces' => $dropDownProvinces,
                'dropDowncitys' => $dropDownCitys,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new Region('search');
        $model->unsetAttributes();
        if (isset($_GET['Region']))
            $model->attributes = $this->getParam('Region');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 创建地区
     */
    public function actionCreate() {
        $model = new Region;
        $this->performAjaxValidation($model);
        if (isset($_POST['Region'])) {
            $model->attributes = $this->getPost('Region');
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "创建地区：" . $model->name);
                $this->setFlash('success', Yii::t('region', '添加地区') . $model->name . Yii::t('region', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * 编辑地区
     * @param int $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Region'])) {
            $model->attributes = $this->getPost('Region');
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改地区：" . $model->name);
                $this->setFlash('success', Yii::t('Region', '修改地区') . $model->name . Yii::t('Region', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除地区
     * @param int $id
     */
    public function actionDelete($id) {
        if ($this->isAjax()) {
            $childrens = Region::model()->count('parent_id=:pid', array(':pid' => $id));
            if ($childrens == 0) {
                $model = $this->loadModel($id);
                $model->delete();
                SystemLog::record($this->getUser()->name . "删除地区：" . $model->name);
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else
                throw new CHttpException(400, Yii::t('region', '无法删除，此地区下包含子级，请先删除所有子级！'));
        }
    }

    public function actionRegionTree() {
        $data = array();
        $model = new Region();
        $data = Tool::treeDataFormat($model->getTreeData());
        array_unshift($data, array('id' => 0, 'text' => '顶级分类')); // 加入顶级分类选项数据
        $data = CJSON::encode($data);
        $this->render('regiontree', array(
            'data' => $data,
        ));
    }
    public function actionUpdateAreaProvince() {
        if ($this->isPost()) {
            $area_id = isset($_POST['area_id']) ? (int) $_POST['area_id'] : "9999999";
            if ($area_id) {
                $data = Region::getProvinceByAreaId($area_id);
            }
            $dropDownProvinces = "<option value=''>" . Yii::t('region', '选择省份') . "</option>";
            if (isset($data)) {
                foreach ($data as $value => $name)
                    $dropDownProvinces .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
//			var_dump($dropDownProvinces);die;
            $dropDownCitys = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownProvinces' => $dropDownProvinces,
                'dropDowncitys' => $dropDownCitys,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }
    /**
     * 三级联动之获取省份
     */
    public function actionUpdateProvince() {
        if ($this->isAjax() && $this->isPost()) {
            $countriesId = $this->getPost('countries_id');
            $countriesId = $countriesId ? (int) $countriesId : "1000000000";
            $province = Region::model()->findAll(array(
                'select' => 'id, name',
                'condition' => 'parent_id=:pid',
                'params' => array(':pid' => $countriesId)));



            $cities = CHtml::listData($province, 'id', 'name');
            $dropDownProvinces = "<option value=''>" . Yii::t('region', '选择省份') . "</option>";
            if (!empty($cities)) {
                foreach ($cities as $id => $name)
                    $dropDownProvinces .= CHtml::tag('option', array('value' => $id), $name, true);
            }

            $dropDownCities = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownProvinces' => $dropDownProvinces,
                'dropDownCities' => $dropDownCities,
                'dropDownCounties' => $dropDownCounties,
            ));
        }
    }

    /**
     * 三级联动之获取城市
     */
    public function actionUpdateCity() {
        if ($this->isAjax() && $this->isPost()) {
            $provinceId = $this->getPost('province_id');
            $provinceId = $provinceId ? (int) $provinceId : "1000000000";
            $regions = Region::model()->findAll(array(
                'select' => 'id, name',
                'condition' => 'parent_id=:pid',
                'params' => array(':pid' => $provinceId)));
            $cities = CHtml::listData($regions, 'id', 'name');
            $dropDownCities = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
            if (!empty($cities)) {
                foreach ($cities as $id => $name)
                    $dropDownCities .= CHtml::tag('option', array('value' => $id), $name, true);
            }
            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownCities' => $dropDownCities,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }

    /**
     * 三级联动之获取区、县
     */
    public function actionUpdateArea() {
        if ($this->isAjax() && $this->isPost()) {
            $cityId = $this->getPost('city_id');
            $cityId = $cityId ? (int) $cityId : "1000000000";
            $regions = Region::model()->findAll(array(
                'select' => 'id, name',
                'condition' => 'parent_id=:pid',
                'params' => array(':pid' => $cityId)));
            $districts = CHtml::listData($regions, 'id', 'name');
            echo "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            if (!empty($districts)) {
                foreach ($districts as $id => $name)
                    echo CHtml::tag('option', array('value' => $id), $name, true);
            }
        }
    }

}
