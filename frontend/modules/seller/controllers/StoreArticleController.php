<?php

/**
 * 商家店铺文章控制器
 * @author wencong.lin  <183482670@qq.com>
 */
class StoreArticleController extends SController {

    /**
     * 添加商家店铺文章
     */
    public function actionCreate() {
        $model = new StoreArticle;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->is_publish = StoreArticle::IS_PUBLISH_YES;
        if (isset($_POST['StoreArticle'])) {
            $model->attributes = $this->getPost('StoreArticle');
            $model->content=stripslashes($model->content);//将字符串进行处理
            $model->store_id = $this->storeId;
            $model->create_time = time();
            if ($model->save()){
                $this->setFlash('success', Yii::t('sellerStoreArticle', '添加文章') . $model->title . Yii::t('sellerStoreArticle', '成功'));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商家店铺文章
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreArticle'])) {
            $model->attributes = $this->getPost('StoreArticle');
            $model->content=stripslashes($model->content);//将字符串进行处理
            if ($model->save())
                $this->setFlash('success', Yii::t('sellerStoreArticle', '修改文章') . $model->title . Yii::t('sellerStoreArticle', '成功'));

            $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除商家店铺文章
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * 商家店铺文章列表
     */
    public function actionIndex() {
        $model = new StoreArticle;
        $model->store_id = $this->storeId;
        $criteria = new CDbCriteria;
        if (isset($_POST['StoreArticle'])) {
            $model->attributes = $this->getPost('StoreArticle');
            $criteria->compare('title', $model->title, true);
        }
        $criteria->compare('store_id', $model->store_id);
        $criteria->compare('is_publish', $model->is_publish);
        $criteria->compare('status', $model->status);
        $criteria->order = 'sort DESC';

        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
        $pager->applyLimit($criteria);
        $articleInfo = StoreArticle::model()->findAll($criteria);
        $model->search();

        $this->render('index', array(
            'pages' => $pager,
            'articleInfo' => $articleInfo,
            'model' => $model
        ));
    }

    public function loadModel($id) {
        $model = StoreArticle::model()->findByPk(intval($id), 'store_id=:storeId', array(
            ':storeId' => $this->storeId
        ));
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在');
        return $model;
    }

}
