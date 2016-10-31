<?php

/**
 * 酒店热门地址控制器(添加,修改,删除,管理)
 * @author binliao <277250538@qq.com>
 */
class HotelAddressController extends Controller {
    
    // 默认经纬度为广州
    public $lng = '113.3065'; // 经度
    public $lat = '23.121113'; // 纬度

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
                    'table' => '{{hotel_address}}',
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
     * 酒店热门地址创建
     */
    public function actionCreate() {
        $model = new HotelAddress;
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelAddress'])) {
            $model->attributes = $this->getParam('HotelAddress');
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."创建酒店热门地址：".$model->name);
            	$this->setFlash('success', Yii::t('hotelAddress', '数据保存成功'));
            }
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 酒店热门地址更新
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelAddress'])) {
            $model->attributes = $this->getParam('HotelAddress');
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."修改酒店热门地址：".$model->name);
            	$this->setFlash('success', Yii::t('hotelAddress', '数据编辑成功'));
            }
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 酒店热门地址删除
     * @param $id
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除酒店热门地址：".$id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 酒店热门地址列表
     */
    public function actionAdmin() {
        $model = new HotelAddress('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelAddress']))
            $model->attributes = $this->getParam('HotelAddress');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
