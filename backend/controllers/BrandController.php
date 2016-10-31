<?php

/**
 * 品牌控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class BrandController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加品牌
     */
    public function actionCreate() {
        $model = new Brand;
        $this->performAjaxValidation($model);
        if (isset($_POST['Brand'])) {
            $model->attributes = $this->getPost('Brand');
            $saveDir = 'files/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir, Yii::getPathOfAlias('uploads'));
            if ($model->save()) {
                UploadedFile::saveFile('logo', $model->logo);
                SystemLog::record($this->getUser()->name . "添加品牌：" . $model->name);
                $this->setFlash('success', Yii::t('brand', '添加品牌') . $model->name . Yii::t('brand', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $model->status = Brand::STATUS_THROUGH;
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
            $oldImg = $this->getParam('oldImg');
            $saveDir = 'files/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir, Yii::getPathOfAlias('uploads'));
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改品牌：" . $model->name);
                UploadedFile::saveFile('logo', $model->logo, $oldImg, true);
                $this->setFlash('success', Yii::t('brand', '修改品牌') . $model->name . Yii::t('brand', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     */
    public function actionDelete($id) {
        if ($this->isAjax()) {
            $goods = Goods::model()->count('brand_id=:bid', array(':bid' => $id));
            if ($goods == 0) {
                $model = $this->loadModel($id);
                $model->delete();
                SystemLog::record($this->getUser()->name . "删除品牌：" . $model->name);
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else
                throw new CHttpException(400, Yii::t('brand', '该品牌下有商品，不能删除'));
        }
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new Brand('search');
        $model->unsetAttributes();
        if (isset($_GET['Brand']))
            $model->attributes = $this->getParam('Brand');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
