<?php

/**
 * 酒店供应商控制器(添加,修改,删除,管理)
 * @author binliao <277250538@qq.com>
 */
class HotelProviderController extends Controller {

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
                    'table' => '{{hotel_provider}}',
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
        $model = new HotelProvider;
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelProvider'])) {
            $model->attributes = $this->getParam('HotelProvider');
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "创建酒店供应商：" . $model->name);
                $this->setFlash('success', Yii::t('hotelProvider', '供应商创建成功'));
            }
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 更新
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelProvider'])) {
            $model->attributes = $this->getParam('HotelProvider');
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "修改酒店供应商：" . $model->name);
                $this->setFlash('success', Yii::t('hotelProvider', '供应商修改成功'));
            }
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除酒店供应商：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 管理
     */
    public function actionAdmin() {
        $model = new HotelProvider('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelProvider']))
            $model->attributes = $this->getParam('HotelProvider');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
