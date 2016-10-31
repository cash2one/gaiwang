<?php

/**
 * 酒店品牌控制器
 * 操作(新建,更新,删除,列表,批量删除)
 * @author binbin.liao <277250538@qq.com>
 */
class HotelBrandController extends Controller {

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
                    'table' => '{{hotel_brand}}',
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
     * 酒店品牌创建
     */
    public function actionCreate() {
        $model = new HotelBrand;
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelBrand'])) {
            $model->attributes = $this->getParam('HotelBrand');
            $saveDir = 'brand/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir);  // 上传图片
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "添加酒店品牌：" . $model->name);
                UploadedFile::saveFile('logo', $model->logo); // 保存文件
                $this->setFlash('success', Yii::t('hotelBrand', '添加品牌') . $model->name . Yii::t('hotelBrand', '成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 酒店品牌更新
     * @param $id
     * @author jianlin.lin
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelBrand'])) {
            $model->attributes = $this->getParam('HotelBrand');
            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'brand/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'logo', $saveDir);  // 上次图片
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "修改酒店品牌：" . $model->name);
                UploadedFile::saveFile('logo', $model->logo, $oldImg, true); // 更新图片
                $this->setFlash('success', Yii::t('hotelBrand', '修改品牌') . $model->name . Yii::t('hotelBrand', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除酒店品牌
     * @param $id
     * @author jianlin.lin
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除酒店品牌：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 酒店品牌列表
     * @author jianlin.lin
     */
    public function actionAdmin() {
        $model = new HotelBrand('search');
        $model->unsetAttributes();
        if (isset($_GET['HotelBrand']))
            $model->attributes = $this->getParam('HotelBrand');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
