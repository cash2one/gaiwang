<?php

/**
 * 微商城 广告位控制器
 * @author wyee <yanjie.wang@g-emall.com>
 */
class MshopAdvertController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new Advert('search');
        $model->unsetAttributes();
        if (isset($_GET['Advert']))
            $model->attributes = $this->getParam('Advert');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate() {
        $model = new Advert('create');
        $model->is_mshop=2;
        $this->performAjaxValidation($model);
        if (isset($_POST['Advert'])) {
            $model->attributes = $_POST['Advert'];
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "添加广告位：" . $model->name);
                $this->setFlash('success', Yii::t('advert', '添加广告位成功：') . $model->name);
                $this->redirect(array('admin'));
            }
        }
        $model->direction = 0;
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 更新
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Advert'])) {
            $model->attributes = $this->getPost('Advert');
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改广告位：" . $model->name);
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     * @param type $id
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
        SystemLog::record($this->getUser()->name . "删除广告位：" . $model->name);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 生成所有广告缓存
     */
    public function actionGenerateAllAdvertCache() {
        Tool::cache(Advert::CACHEDIR)->flush();  // 清除所有广告缓存
        Advert::generateAllAdvertCache();
        SystemLog::record($this->getUser()->name . "生成所有广告缓存");
        $this->setFlash('success', Yii::t('advert', '成功生成所有广告缓存文件'));
        $this->redirect(array('admin'));
    }
    
    /**
     * 不使用继承的Controller通用方法
     * @see Controller::loadModel()
     */
   public function loadModel($id){
		$model=Advert::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'请求的页面不存在');
		return $model;
	}

}
