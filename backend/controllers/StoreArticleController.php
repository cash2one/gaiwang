<?php

/**
 * 店铺文章控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class StoreArticleController extends Controller {

    /**
     * 修改店铺文章
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreArticle'])) {
            $model->attributes = $_POST['StoreArticle'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改店铺文章：".$model->title);
                Yii::app()->user->setFlash('success', Yii::t('storeArticle', '数据编辑成功'));
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error',CHtml::errorSummary($model));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除店铺文章
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除店铺文章：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    /**
     * 修改店铺管理
     */
    public function actionAdmin() {
        $model = new StoreArticle('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreArticle']))
            $model->attributes = $_GET['StoreArticle'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
