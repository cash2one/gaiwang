<?php

/**
 * 文章控制器 
 * 操作 (添加,修改,删除)
 * @author  binbin.liao <277250538@qq.com>
 */
class ArticleController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionCreate() {
        $model = new Article;
        $this->performAjaxValidation($model);
        $model = UploadedFile::uploadFile($model, 'thumbnail', 'article', Yii::getPathOfAlias('att'));
        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail);
                @SystemLog::record(Yii::app()->user->name."添加文章：{$model->title}");
                Yii::app()->user->setFlash('success', Yii::t('article', '数据保存成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."添加文章：{$model->title} 失败");
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $model = UploadedFile::uploadFile($model, 'thumbnail', 'article', Yii::getPathOfAlias('att'));
        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."更新文章：{$model->title}");
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $this->getParam('oldImg'), true);
                Tool::cache('article')->set($model->alias, $model->attributes); //更新缓存
                Yii::app()->user->setFlash('success', Yii::t('article', '数据更新成功'));
                $this->redirect(array('admin'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."更新文章：{$model->title} 失败");
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除文章：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionAdmin() {
        $model = new Article('search');
        $model->unsetAttributes();
        if (isset($_GET['Article']))
            $model->attributes = $_GET['Article'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
