<?php

/**
 * 兴趣爱好控制器
 * 操作(创建兴趣爱好,修改兴趣爱好,删除兴趣爱好,兴趣爱好列表)
 * @author jianlin_lin <hayeslam@163.com>
 */
class InterestController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建兴趣爱好
     */
    public function actionCreate() {
        $model = new Interest;
        $this->performAjaxValidation($model);

        if (isset($_POST['Interest'])) {
            $model->attributes = $_POST['Interest'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."创建兴趣爱好：".$model->name);
                $this->setFlash('success', Yii::t('interest', '添加爱好') . $model->name . Yii::t('interest', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改兴趣爱好
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Interest'])) {
            $model->attributes = $_POST['Interest'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改兴趣爱好：".$model->name);
                $this->setFlash('success', Yii::t('interest', '修改爱好') . $model->name . Yii::t('interest', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除兴趣爱好
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除兴趣爱好：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 兴趣爱好列表
     */
    public function actionAdmin() {
        $model = new Interest('search');
        $model->unsetAttributes();
        if (isset($_GET['Interest']))
            $model->attributes = $_GET['Interest'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
