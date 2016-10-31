<?php

/**
 * 友情链接控制器
 * 操作(创建,修改,删除,批量删除,列表)
 * @author jianlin_lin <hayeslam@163.com>
 */
class LinkController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建友情链接
     */
    public function actionCreate() {
        $model = new Link;
        $model->position = Link::POSITION_DEFAULT;
        $this->performAjaxValidation($model);
        if (isset($_POST['Link'])) {
            $model->attributes = $_POST['Link'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加友情链接：".$model->name);
                $this->setFlash('success', Yii::t('link', '添加友情链接') . $model->name . Yii::t('link', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改友情链接
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Link'])) {
            $model->attributes = $_POST['Link'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改友情链接：".$model->name);
                $this->setFlash('success', Yii::t('link', '修改友情链接') . $model->name . Yii::t('link', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除友情链接
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除友情链接：".$id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 友情链接列表管理
     */
    public function actionAdmin() {
        $model = new Link('search');
        $model->unsetAttributes();
        if (isset($_GET['Link']))
            $model->attributes = $_GET['Link'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
