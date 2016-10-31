<?php

/**
 * 酒店等级控制器
 * 操作(新建,更新,删除,列表)
 * @author binbin.liao <277250538@qq.com>
 */
class HotelLevelController extends Controller {

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
                    'table' => '{{hotel_level}}',
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
     * 酒店等级创建
     */
    public function actionCreate() {
        $model = new HotelLevel;
        $this->performAjaxValidation($model);

        if (isset($_POST['HotelLevel'])) {
            $model->attributes = $this->getParam('HotelLevel');
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加酒店等级：".$model->name);
                $this->setFlash('success', Yii::t('hotelLevel', '添加成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 酒店等级跟新
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelLevel'])) {
            $model->attributes = $this->getParam('HotelLevel');
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改酒店等级：".$model->name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 酒店等级删除
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除酒店等级：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 酒店等级列表
     */
    public function actionAdmin() {
        $model = new HotelLevel('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelLevel']))
            $model->attributes = $this->getParam('HotelLevel');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
