<?php

/**
 * 兴趣爱好分类控制器
 * 操作(创建兴趣爱好分类,修改兴趣爱好分类,删除兴趣爱好分类,兴趣爱好分类列表)
 * @author jianlin_lin <hayeslam@163.com>
 */
class InterestCategoryController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建兴趣爱好分类
     */
    public function actionCreate() {
        $model = new InterestCategory;
        $this->performAjaxValidation($model);

        if (isset($_POST['InterestCategory'])) {
            $model->attributes = $_POST['InterestCategory'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."创建兴趣爱好分类：".$model->name);
                $this->setFlash('success', Yii::t('translateIdentify', '添加分类') . $model->name . Yii::t('translateIdentify', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改兴趣爱好分类
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['InterestCategory'])) {
            $model->attributes = $_POST['InterestCategory'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改兴趣爱好分类：".$model->name);
                $this->setFlash('success', Yii::t('translateIdentify', '修改分类') . $model->name . Yii::t('translateIdentify', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除兴趣爱好分类
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除兴趣爱好分类：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 兴趣爱好分类列表
     */
    public function actionAdmin() {
        $model = new InterestCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['InterestCategory']))
            $model->attributes = $_GET['InterestCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
