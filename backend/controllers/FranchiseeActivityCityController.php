<?php

/**
 * 加盟商活动城市控制器
 * 操作(创建活动城市,修改活动城市,删除活动城市线下活动城市列表)
 * @author jianlin_lin <hayeslam@163.com>
 */
class FranchiseeActivityCityController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建线下活动城市
     */
    public function actionCreate() {
        $model = new FranchiseeActivityCity;
        $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeActivityCity'])) {
            $model->attributes = $this->getPost('FranchiseeActivityCity');
            if ($model->save()) {
                $this->_isDefault($model);
                $this->refreshCitys(false);
                @SystemLog::record(Yii::app()->user->name."添加线下活动城市：".$model->id);
                $this->setFlash('success', Yii::t('franchiseeActivityCity', '添加线下活动城市') . Region::model()->getName($model->city_id) . Yii::t('franchiseeActivityCity', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改线下活动城市
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeActivityCity'])) {
            $model->attributes = $this->getPost('FranchiseeActivityCity');
            if ($model->save()) {
                $this->_isDefault($model);
                $this->refreshCitys(false);
                @SystemLog::record(Yii::app()->user->name."修改线下活动城市：".$model->id);
                $this->setFlash('success', Yii::t('franchiseeActivityCity', '修改线下活动城市') . Region::model()->getName($model->city_id) . Yii::t('franchiseeActivityCity', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除线下活动城市
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除线下活动城市：".$id);
        $this->refreshCitys(false);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 线下活动城市列表
     */
    public function actionAdmin() {
        $model = new FranchiseeActivityCity('search');
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeActivityCity']))
            $model->attributes = $this->getParam('FranchiseeActivityCity');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 是否默认
     * @param object $model
     */
    private function _isDefault($model) {
        if ($model->default == 1)
            $model->updateAll(array('default' => '0'), 'id <> :id AND `default` = 1', array('id' => $model->id));
    }

    /**
     * 刷新城市缓存
     * @param $flag
     */
    private function refreshCitys($flag){
        FranchiseeActivityCity::fileCache($flag);
    }
}
