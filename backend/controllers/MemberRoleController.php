<?php

/**
 * 会员角色管理控制器
 * 操作(列表，创建，修改，删除)
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class MemberRoleController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 会员角色列表
     */
    public function actionAdmin() {
        $model = new MemberRole('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberRole']))
            $model->attributes = $_GET['MemberRole'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 创建会员角色
     */
    public function actionCreate() {
        $model = new MemberRole('create');
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberRole'])) {
            $model->attributes = $_POST['MemberRole'];
            $model = UploadedFile::uploadFile($model, 'thumbnail', 'role', Yii::getPathOfAlias('att'));
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加会员角色：".$model->name);
                UploadedFile::saveFile('thumbnail', $model->thumbnail);
                $this->setFlash('success', Yii::t('memberRole', '添加角色成功，名称：') . $model->name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员角色
     * @param int $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $oldPic = $model->thumbnail;
        if (isset($_POST['MemberRole'])) {
            $model->attributes = $_POST['MemberRole'];
            $model = UploadedFile::uploadFile($model, 'thumbnail', 'role', Yii::getPathOfAlias('att'));
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改会员角色：".$model->name);
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldPic, true);
                $this->setFlash('success', Yii::t('memberRole', '修改角色成功，名称：') . $model->name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array('model' => $model));
    }

    /**
     * 删除会员角色
     * @param int $id
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除会员角色：".$id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

}
