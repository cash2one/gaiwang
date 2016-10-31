<?php

/**
 * 商家店铺广告控制器
 * {操作：添加店铺广告图片、更新店铺广告图片、删除店铺广告、店铺广告图片列表}
 * @author jianlin.lin <hayeslam@163.com>
 */
class SlideController extends SController {

    public $layout = 'seller';
    public $defaultAction = 'admin';

    /**
     * 添加店铺广告图片
     */
    public function actionCreate() {
        $model = new Slide;
        $count = $model->count('store_id = :cid', array(':cid' => $this->storeId));
        if ($count == 6) {
            $this->setFlash('success', Yii::t('sellerSlide', '抱歉，广告条数已满，请正对现有广告删除或更新！'));
            $this->redirect(array('/seller/slide/admin'));
        }
        $this->performAjaxValidation($model);
        $model = UploadedFile::uploadFile($model, 'picture', 'goods_ad');  // 上传广告图片
        if (isset($_POST['Slide'])) {
            $model->attributes = $this->getPost('Slide');
            $model->store_id = $this->storeId;
            if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture);  // 保存广告图片
                $this->setFlash('success', Yii::t('sellerSlide', '添加广告成功！'));
                
                //添加操作日志
	    		@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeInsert,0,'添加店铺广告图片');
                
                $this->redirect(array('/seller/slide/admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 更新店铺广告图片
     * @param int $id  ID
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->checkAccess($model->store_id);   // 检查是否有权限
        $this->performAjaxValidation($model);
        if (isset($_POST['Slide'])) {
            $model->attributes = $this->getPost('Slide');
            $oldFile = $model->picture;
            $model = UploadedFile::uploadFile($model, 'picture', 'goods_ad');  // 上传广告图片
            if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture, $oldFile, true);  // 保存并删除广告图片
                $this->setFlash('success', Yii::t('sellerSlide', '添加广告成功！'));
                
                //添加操作日志
	    		@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'更新店铺广告图片');
                $this->redirect(array('/seller/slide/admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除店铺广告
     * 删除图片
     * @param int $id  ID
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $this->checkAccess($model->store_id);   // 检查是否有权限
        $oldFile = $model->picture;
        if ($model->delete()){
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $oldFile);
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            
            //添加操作日志
	    	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeDel,$id,'删除店铺广告');
            
    }

    /**
     * 店铺广告图片列表
     */
    public function actionAdmin() {
        $criteria = new CDbCriteria(array(
            'condition' => 'store_id = :cid',
            'params' => array(':cid' => $this->storeId),
            'order' => 'sort DESC, id DESC',
            'limit' => 6,
        ));
        $slide = Slide::model()->findAll($criteria);
        $this->render('admin', array(
            'slide' => $slide,
        ));
    }

}
