<?php

/**
 * 线下角色管理
 * @author rihui.zhang@g-emall.com
 */
class OfflineRoleController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new OfflineRole('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineRole']))
            $model->attributes = $this->getParam('OfflineRole');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate() {
        $model = new OfflineRole('create');
        $this->performAjaxValidation($model);
        if (isset($_POST['OfflineRole'])) {
        	if($_POST['OfflineRole']['rate'] > 100 || $_POST['OfflineRole']['rate'] < 0){
        		$this->setFlash('error', Yii::t('OfflineRole', '分配比率有误'));
        		$this->redirect(array('admin'));
        	}
            $model->attributes = $this->getPost('OfflineRole');
          	$model->update_time = time();
          	$model->admin_id = Yii::app()->user->id;
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "添加线下角色：" . $model->role_name);
                $this->setFlash('success', Yii::t('OfflineRole', '添加线下角色：') . $model->role_name);
                $this->redirect(array('admin'));
            }
        }
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 更新
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['OfflineRole'])) {
        	if($_POST['OfflineRole']['rate'] > 100 || $_POST['OfflineRole']['rate'] < 0){
        		$this->setFlash('error', Yii::t('OfflineRole', '分配比率有误'));
        		$this->redirect(array('admin'));
        	}
            $model->attributes = $this->getPost('OfflineRole');
            $model->update_time = time();
            $model->admin_id = Yii::app()->user->id;
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改线下角色：" . $model->role_name);
                $this->setFlash('success', Yii::t('OfflineRole', '修改线下角色：') . $model->role_name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     * @param type $id
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
        SystemLog::record($this->getUser()->name . "删除角色：" . $model->role_name);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}
