<?php

/**
 * 文章控制器 
 * 操作 (添加,修改,删除)
 * @author  binbin.liao <277250538@qq.com>
 */
class ArticleCategoryController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionCreate() {
        $model = new ArticleCategory;
        $this->performAjaxValidation($model);
        if (isset($_POST['ArticleCategory'])) {
            $model->attributes = $_POST['ArticleCategory'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加文章分类：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('articleCategory', '数据保存成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."添加文章分类：{$model->name} 失败");
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['ArticleCategory'])) {
            $model->attributes = $_POST['ArticleCategory'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."更新文章分类：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('articleCategory', '数据更新成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."更新文章分类：{$model->name} 失败");
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除文章分类：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionAdmin() {
        $model = new ArticleCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['ArticleCategory']))
            $model->attributes = $_GET['ArticleCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
