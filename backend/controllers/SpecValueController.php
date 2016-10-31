<?php

/**
 * 商品规格值控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class SpecValueController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加商品规格值
     */
    public function actionCreate($spec_id) {
        $model = new SpecValue;
        $this->performAjaxValidation($model);
        $model->spec_id = $this->getParam('spec_id');
        if (isset($_POST['SpecValue'])) {
            $model->attributes = $_POST['SpecValue'];
            $model = UploadedFile::uploadFile($model, 'thumbnail', 'specValue'); // 上传文件
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail); // 保存文件
                SpecValue::setSpecValue($model);
            }
            @SystemLog::record(Yii::app()->user->name."添加商品规格值：".$model->name);
            $this->setFlash('success', Yii::t('specValue', '添加规格值') . $model->name . Yii::t('specValue', '成功'));
            $this->redirect(array('admin', 'spec_id' => $model->spec_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商品规格
     */
    public function actionUpdate($id) {
        $model = new SpecValue;
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['SpecValue'])) {
            $oldImg = $this->getParam('oldImg');
            $model->attributes = $_POST['SpecValue'];
            $model = UploadedFile::uploadFile($model, 'thumbnail', 'specValue'); // 上传文件
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改商品规格值：".$model->name);
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 保存并删除旧文件
                SpecValue::setSpecValue($model);
                $this->setFlash('success', Yii::t('specValue', '编辑规格值') . $model->name . Yii::t('specValue', '成功'));
                $this->redirect(array('admin', 'spec_id' => $model->spec_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除商品规格值
     */
    public function actionDelete($id) {
        $spec_id = $this->getParam('spec_id');
        $type = $this->getParam('type');

        $model = $this->loadModel($id);
        $file = $model->thumbnail;

        if ($model->delete())
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $file); // 删除文件
            
        @SystemLog::record(Yii::app()->user->name."删除商品规格值：".$id);

        SpecValue::setSpecValue($model);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'spec_id' => $model->spec_id, 'type' => $model->type));
    }

    /**
     * 商品规格值管理
     */
    public function actionAdmin() {
        $model = new SpecValue('search');
        $model->unsetAttributes();
        if (isset($_GET['SpecValue']))            
            $model->attributes = $_GET['SpecValue'];
            $model->spec_id = $this->getParam('spec_id');
        
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
