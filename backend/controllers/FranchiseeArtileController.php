<?php

/**
 * 加盟商文章控制器 
 * 操作 (修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class FranchiseeArtileController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 修改加盟商文章
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeArtile'])) {
            $model->attributes = $this->getPost('FranchiseeArtile');
            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'franchiseeArtile/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('att'));  // 上传图片
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."修改加盟商文章：".$model->title);
            	UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 更新图片
            }
                
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除加盟商文章
     * @param type $id
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除加盟商文章：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 加盟商文章管理
     */
    public function actionAdmin() {
        $model = new FranchiseeArtile('search');
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeArtile']))
            $model->attributes = $this->getParam('FranchiseeArtile');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
