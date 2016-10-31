<?php
/**
 * 团购类目管理
 * @author cong.zeng <zengcong220@qq.com>
 */

class FranchiseeGroupbuyCategoryController extends Controller
{
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
        return 'getCategory, getFranchiseeGroupbuyCategory';
    }
    
    /*
     * 分类列表
     */
    public function actionAdmin() {
        $model = new FranchiseeGroupbuyCategory();
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeGroupbuyCategory']))
            $model->attributes = $this->getParam('FranchiseeGroupbuyCategory');
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    /*
     * 类目选择列表
     */
    public function actionGetFranchiseeGroupbuyCategory() {
        $model = new FranchiseeGroupbuyCategory();
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeGroupbuyCategory']))
            $model->attributes = $this->getParam('FranchiseeGroupbuyCategory');
        $this->render('selectfranchiseegroupbuycategory', array(
            'model' => $model,
        ));
    }
    

    /**
     * 获得类目名称ajax请求名称为 酒店 / 餐饮 类型
     * @param int $id
     * @return json
     */
    public function actionGetCategory($id){
        if($this->isAjax()){
            $model = FranchiseeGroupbuyCategory::model()->find('id = :id', array(':id' => $id));
            $parentName=FranchiseeGroupbuyCategory::model()->find('id=:id',array(':id'=>$model->parent_id))->name;//父类名称
            if (!is_null($model))
                echo CJSON::encode($parentName."/".$model->name);
            else
                echo CJSON::encode(null);
        }
    }
    
    /*
     * 类目添加
     */
    public function actionCreate() {
        $model = new FranchiseeGroupbuyCategory;
        $this->performAjaxValidation($model);
        
        if (isset($_POST['FranchiseeGroupbuyCategory'])) {
            $model->attributes = $this->getPost('FranchiseeGroupbuyCategory');           
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加类目：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('franchiseeGroupbuyCategory', '添加类目成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."添加类目：{$model->name} 失败");
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    /*
     * 类目重命名
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['FranchiseeGroupbuyCategory'])) {
            $model->attributes = $this->getPost('FranchiseeGroupbuyCategory');
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."重命名类目：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('franchiseeGroupbuyCategory', '类名更新成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."重命名类目：{$model->name} 失败");
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    /*
     * 类目删除
     */
    public function actionDelete($id)
    {        
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
//        Tool::pr($model);
        /**
         * 1.判断总类下是否有子类，有则给出提示，不让删除，没有就直接删除
         * 2.判断类目是否有参加团购发布，有则给出提示，不让删除，没有就直接删除
         */
        if (FranchiseeGroupbuyCategory::model()->find('parent_id = :id', array(':id' => $model->id))) {
            Yii::app()->user->setFlash('error', Yii::t('FranchiseeGroupbuyCategory', '该分类下有子分类，请先删除子分类！'));
        } else if (FranchiseeGroupbuy::model()->find('franchisee_groupbuy_category_id = :id', array(':id' => $model->id))) {
            Yii::app()->user->setFlash('error', Yii::t('FranchiseeGroupbuyCategory', '该分类参与了团购，请先删除团购信息！'));
        } else if ($model->deleteByPk($id)) {
            Yii::app()->user->setFlash('success', Yii::t('franchiseeGroupbuyCategory', '分类删除成功'));
            @SystemLog::record($this->getUser()->name . '删除' . $model->name . '分类,ID为:' . $model->id);
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    /*
     * 一二级类目联动
     */
    public function actionUpdateGroupbuyCate() {
        if ($this->isPost()) {
            $parent_id = isset($_POST['parent_id']) ? (int) $_POST['parent_id'] : "9999999";
            if ($parent_id) {
                $data = FranchiseeGroupbuyCategory::model()->findAll('parent_id=:pid', array(':pid' => $parent_id));
                $data = CHtml::listData($data, 'id', 'name');
            }
            $dropDownCities = "<option value=''>" . Yii::t('franchiseeGroupbuyCategory', '选择二级类目') . "</option>";
            if (isset($data)) {
                foreach ($data as $value => $name)
                    $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('franchiseeGroupbuyCategory', $name)), true);
            }
            $dropDownCounties = "<option value='null'>" . Yii::t('franchiseeGroupbuyCategory', '选择二级类目') . "</option>";
            echo CJSON::encode(array(
                'dropDownCities' => $dropDownCities,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }
}