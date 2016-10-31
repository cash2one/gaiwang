<?php

class NationalityController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 外部操作
     * @return array
     * @author jianlin.lin
     */
    public function actions() {
        return array(
            'ajaxUpdateSort' => array(
                'class' => 'CommonAction',
                'method' => 'ajaxUpdateSort',
                'params' => array(
                    'table' => '{{nationality}}',
                ),
            ),
        );
    }

    /**
     * 不受权限控制的动作
     * @return string
     * @author jianlin.lin
     */
    public function allowedActions() {
        return 'ajaxUpdateSort';
    }

    /**
     * 创建
     */
    public function actionCreate() {
        $model = new Nationality;
         $this->performAjaxValidation($model);
        if (isset($_POST['Nationality'])) {
            $model->attributes = $this->getParam('Nationality');
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name . "创建国籍：{$model->name}");
                $this->setFlash('success', Yii::t('nationality', '创建国籍') . $model->name . Yii::t('nationality', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 跟新
     * @param integer $id 模型的ID
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Nationality'])) {
            $model->attributes = $this->getParam('Nationality');
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name . "更新国籍：{$model->name}");
                $this->setFlash('success', Yii::t('nationality', '更新国籍') . $model->name . Yii::t('nationality', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     * @param integer $id 模型的ID
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除国籍：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new Nationality('search');
        $model->unsetAttributes();
        if (isset($_GET['Nationality']))
            $model->attributes = $this->getParam('Nationality');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
