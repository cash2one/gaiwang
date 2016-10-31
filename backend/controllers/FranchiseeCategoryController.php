<?php

/**
 * 商家分类控制器
 * 操作(创建商家分类,删除商家分类,管理商家分类)
 * @author jianlin_lin <hayeslam@163.com>
 */
class FranchiseeCategoryController extends Controller {

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
        return 'getCityTreeGrid';
    }

    /**
     * 创建商家分类
     */
    public function actionCreate($parent_id = null) {
        $model = new FranchiseeCategory;
        if (isset($parent_id)) { // 以该ID作为父类
            $model->parent_id = $parent_id;
            $model->parentName = $model->find('id = :pid', array('pid' => $parent_id))->name;
        }
        $this->performAjaxValidation($model);
        if (isset($_POST['FranchiseeCategory'])) {
            $model->attributes = $this->getPost('FranchiseeCategory');
            $model = UploadedFile::uploadFile($model, 'thumbnail', 'franchisee'); // 上传图片
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."创建商家分类：".$model->name);
                UploadedFile::saveFile('thumbnail', $model->thumbnail);  // 保存图片
                $this->setFlash('success', Yii::t('franchiseeCategory', '添加商家分类') . $model->name . Yii::t('franchiseeCategory', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商家分类
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $parentRec = $model->find('id = :parent_id', array('parent_id' => $model->parent_id));
        $model->parentName = is_null($parentRec) ? '' : $parentRec->name;
        $this->performAjaxValidation($model);
        if (isset($_POST['FranchiseeCategory'])) {
            $model->attributes = $this->getPost('FranchiseeCategory');
            if($model->validate()){
                $oldThumbnail = $model->thumbnail;  // 旧图
                $model = UploadedFile::uploadFile($model, 'thumbnail', 'franchisee');  // 上传图片
                if ($model->save()) {
                    @SystemLog::record(Yii::app()->user->name."修改商家分类：".$model->name);
                    UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldThumbnail, true); // 更新图片
                    $this->setFlash('success', Yii::t('franchiseeCategory', '修改商家分类') . $model->name . Yii::t('franchiseeCategory', '成功'));
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除商家分类
     * @param type $id
     */
    public function actionDelete($id) {
        $data = FranchiseeCategory::model()->find(array(
            'select' => 'parent_id',
            'condition' => 'id = :id',
            'params' => array(':id' => $id)
        ));
        if(intval($data['parent_id']) !== 0){
            $this->loadModel($id)->delete();
            $this->setFlash('success', Yii::t('franchiseeCategory', '删除商家分类成功'));
            @SystemLog::record(Yii::app()->user->name."删除商家分类：".$id);
        }else{
            $childData =  FranchiseeCategory::model()->findAll(array(
                'select' => 'id,name',
                'condition' => 'parent_id = :id',
                'params' => array(':id' => $id)
            ));
            if(count($childData) >= 1){
                $this->setFlash('error', Yii::t('franchiseeCategory', '删除商家分类失败，请先删除子分类'));
            }else{
                $this->loadModel($id)->delete();
                $this->setFlash('success', Yii::t('franchiseeCategory', '删除商家分类成功'));
                @SystemLog::record(Yii::app()->user->name."删除商家分类：".$id);
            }
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 管理商家分类
     */
    public function actionAdmin() {
        $this->render('admin');
    }

    /**
     * 获取城市分类数据
     */
    public function actionGetCityTreeGrid() {
        $id = $this->getParam('id');
        $data = array();
        if (is_numeric($id)) {
            $model = new FranchiseeCategory;
            $data = $model->getTreeData($id);
        }
        echo CJSON::encode($data);
    }

    /**
     * 分类树列表
     */
    public function actionCategoryTree() {
        $data = array();
        $pid = $this->getParam('pid');
        $pid = isset($pid) ? $this->getParam('pid') : null;
        $model = new FranchiseeCategory;
        $data = Tool::treeDataFormat($model->getTreeData($pid));
        array_unshift($data, array('id' => 0, 'text' => '顶级分类')); // 加入顶级分类选项数据
        $data = CJSON::encode($data);
        $this->render('categorytree', array(
            'data' => $data,
        ));
    }

    public function actionGenerateAllCategoryCache() {
        Tool::cache(FranchiseeCategory::CACHEDIR)->flush();
        FranchiseeCategory::generateCategoryCacheFiles();
        $this->setFlash('success', Yii::t('category', '成功生成所有分类缓存文件'));
        $this->redirect(array('admin'));
    }

}
