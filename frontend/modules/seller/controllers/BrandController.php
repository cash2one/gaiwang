<?php

/**
 * 品牌控制器
 * @author wencong.lin <183482670@qq.com>
 */
class BrandController extends SController {

    /**
     * 添加品牌
     */
    public function actionCreate() {
        $model = new Brand();
        $this->performAjaxValidation($model);
        if (isset($_POST['Brand'])) {
            $model->attributes = $this->getPost('Brand');
            $model->store_id = $this->storeId;
            $saveDir = 'files/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir,Yii::getPathOfAlias('uploads'));  // 上传图片

            if ($model->save()){
            	//添加操作日志
            	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeInsert,0,'添加品牌');
		     	UploadedFile::saveFile('logo', $model->logo); // 保存文件
            }
               

            $this->setFlash('success', Yii::t('sellerBrand', '添加品牌') . $model->name . Yii::t('sellerBrand', '成功'));
            $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改品牌
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Brand'])) {
            $model->attributes = $this->getPost('Brand');

            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'files/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir,Yii::getPathOfAlias('uploads'));  // 上传图片
            if ($model->save()){
            	//添加操作日志
		     	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'修改品牌');
		     	UploadedFile::saveFile('logo', $model->logo, $oldImg, true); // 更新图片
            }
                

            $this->setFlash('success', Yii::t('sellerBrand', '修改品牌') . $model->name . Yii::t('sellerBrand', '成功'));
            $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 品牌管理
     */
    public function actionIndex() {
        $model = new Brand;
        $model->store_id = $this->storeId;
        $criteria = new CDbCriteria;
        if (isset($_POST['Brand'])) {
            $model->attributes = $this->getPost('Brand');
            $criteria->compare('name', $model->name, true);
            $criteria->compare('code', $model->code, true);
        }
        $criteria->compare('store_id', $model->store_id);
        $criteria->order = 'sort DESC';

        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
        $pager->applyLimit($criteria);
        $brandInfo = Brand::model()->findAll($criteria);
        $model->search();
        $this->render('index', array(
            'pages' => $pager,
            'brandInfo' => $brandInfo,
            'model' => $model
        ));
    }

    public function loadModel($id) {
        $model = Brand::model()->findByPk(intval($id), 'store_id=:storeId', array(
            ':storeId' => $this->storeId
        ));
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在');
        return $model;
    }

}
