<?php

/**
 * 加盟商线下商品控制器
 * 操作 添加线下商品分类，更新线下商品，分类缓存
 * @author csj
 */
class FranchiseeGoodsCategoryController extends SFController {


    /**
     * 添加商家商品分类
     */
    public function actionCreate() {

        $model = new FranchiseeGoodsCategory();
        $model->franchisee_id = $this->curr_franchisee_id;


        $pid = $this->getParam('pid');
        if (isset($pid)) {
            $model->parent_id = $pid;
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeGoodsCategory'])) {
            $model->attributes = $this->getPost('FranchiseeGoodsCategory');
            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeInsert, 0, '添加线下商品分类');
                $this->setFlash('success', Yii::t('sellerFranchisee', '添加分类') . '"' . $model->name . '"' . Yii::t('sellerFranchisee', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        	'franchisee_id'=>$this->curr_franchisee_id,
        ));
    }

    /**
     * 修改商家商品分类
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeGoodsCategory'])) {
            $model->attributes = $this->getPost('FranchiseeGoodsCategory');
            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $id, '修改商家商品分类');
                $this->setFlash('success', Yii::t('sellerFranchiseeGoodsCategory', '修改分类') . '"' . $model->name . '"' . Yii::t('sellerFranchiseeGoodsCategory', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        	'franchisee_id'=>$this->curr_franchisee_id,
        ));
    }

    /**
     * 商家商品分类管理
     */
    public function actionAdmin() {
        $model = new FranchiseeGoodsCategory('search');

        $model->unsetAttributes();
        if (isset($_GET['FranchiseeGoodsCategory']))
            $model->attributes = $this->getQuery('FranchiseeGoodsCategory');
        $model->franchisee_id = $this->curr_franchisee_id;

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 删除分类
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $flag = true;
        if (!empty($model->childClass)) {
            $flag = false;
            $this->setFlash('error', Yii::t('sellerFranchiseeGoodsCategory', '删除分类') . '"' . $model->name . '"' . Yii::t('sellerFranchiseeGoodsCategory', '失败，该分类存在子分类'));
        }
        if ($flag == true && Goods::model()->count('scategory_id = :cid', array(':cid' => $model->id)) > 0) {
            $flag = false;
            $this->setFlash('error', Yii::t('sellerFranchiseeGoodsCategory', '删除分类') . '"' . $model->name . '"' . Yii::t('sellerFranchiseeGoodsCategory', '失败，该分类存在商品'));
        }
        if ($flag == true && $model->delete()) {
            // 记录操作日志
            @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeDel, $model->id, '删除商家商品分类');
            $this->setFlash('success', Yii::t('sellerFranchiseeGoodsCategory', '成功删除分类') . "$model->name");
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * 获取表格分类数据
     */
    public function actionGetTreeGridData() {
        $id = $this->getParam('id');
        
        $data = array();
        if (is_numeric($id)) {
            $model = new FranchiseeGoodsCategory;
            $data = $model->getTreeData($id, $this->curr_franchisee_id);
        }
        echo CJSON::encode($data);
    }

    public function loadModel($id) {
        $model = FranchiseeGoodsCategory::model()->findByPk(intval($id), 'franchisee_id=:franchiseeId', array(
            ':franchiseeId' => $this->curr_franchisee_id
        ));
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在');
        return $model;
    }
	
	
	
	
	
	
    
}
