<?php

/**
 * 商家商品分类控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class ScategoryController extends SController {

    /**
     * 添加商家商品分类
     */
    public function actionCreate() {

        $model = new Scategory;
        $model->store_id = $this->storeId;


        $pid = $this->getParam('pid');
        if (isset($pid)) {
            $model->parent_id = $pid;
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['Scategory'])) {
            $model->attributes = $this->getPost('Scategory');
            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeInsert, 0, '添加商家商品分类');
                $this->setFlash('success', Yii::t('sellerScategory', '添加分类') . '"' . $model->name . '"' . Yii::t('sellerScategory', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商家商品分类
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Scategory'])) {
            $model->attributes = $this->getPost('Scategory');
            if($model->id==$model->parent_id){
                $this->setFlash('error','不能将分类添加到自身');
                $this->refresh();
            }
            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $id, '修改商家商品分类');
                $this->setFlash('success', Yii::t('sellerScategory', '修改分类') . '"' . $model->name . '"' . Yii::t('sellerScategory', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 商家商品分类管理
     */
    public function actionAdmin() {
        $model = new Scategory('search');

        $model->unsetAttributes();
        if (isset($_GET['Scategory']))
            $model->attributes = $this->getQuery('Scategory');
        $model->store_id = $this->storeId;

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
            $this->setFlash('error', Yii::t('sellerScategory', '删除分类') . '"' . $model->name . '"' . Yii::t('sellerScategory', '失败，该分类存在子分类'));
        }
        if ($flag == true && Goods::model()->count('scategory_id = :cid and life=:life', array(':cid' => $model->id,'life'=>Goods::LIFE_NO)) > 0) {
            $flag = false;
            $this->setFlash('error', Yii::t('sellerScategory', '删除分类') . '"' . $model->name . '"' . Yii::t('sellerScategory', '失败，该分类存在商品'));
        }
        if ($flag == true && $model->delete()) {
            // 记录操作日志
            @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeDel, $model->id, '删除商家商品分类');
            $this->setFlash('success', Yii::t('sellerScategory', '成功删除分类') . "$model->name");
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * ajax异步设置商家商品分类显示状态
     */
    public function actionSetStatus($id, $status) {
        $status = $status == 1 ? 0 : 1;
        $model = new Scategory;
        if ($model->updateByPk($id, array('status' => $status))) {
            //添加操作日志
            @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $id, '设置商家商品分类显示状态');
            Scategory::generateScategoryInfo($model->store_id);
            echo true;
        }
        echo false;
    }

    /**
     * 获取表格分类数据
     */
    public function actionGetTreeGridData() {
        $id = $this->getParam('id');
        $store_id = $this->storeId;

        $data = array();
        if (is_numeric($id)) {
            $model = new Scategory;
            $data = $model->getTreeData($id, $store_id);
        }
        echo CJSON::encode($data);
    }

    public function loadModel($id) {
        $model = Scategory::model()->findByPk(intval($id), 'store_id=:storeId', array(
            ':storeId' => $this->storeId
        ));
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在');
        return $model;
    }

}
