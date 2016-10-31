<?php

/**
 * 物流公司管理控制器
 * 操作(列表，创建，修改，删除)
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class ExpressController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 物流公司列表
     */
    public function actionAdmin() {
        $model = new Express('search');
        $model->unsetAttributes();
        if (isset($_GET['Express']))
            $model->attributes = $_GET['Express'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 创建物流公司
     */
    public function actionCreate() {
        $model = new Express('create');
        $this->performAjaxValidation($model);

        if (isset($_POST['Express'])) {
            $model->attributes = $_POST['Express'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."创建物流公司：".$model->name);
                $this->setFlash('success', Yii::t('express', '添加物流成功，名称：') . $model->name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 修改物流公司
     * @param int $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Express'])) {
            $model->attributes = $_POST['Express'];
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."更新物流公司：".$model->name);
                $this->setFlash('success', Yii::t('express', '修改成功，名称：') . $model->name);
            	$this->redirect(array('admin'));
            }
                
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除物流公司
     * @param int $id
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除物流公司：".$id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

}
