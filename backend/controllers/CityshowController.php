<?php

/**
 * 城市馆审核列表
 * @author zhenjun_xu <412530435@qq.com>
 * DateTime 2016/4/21 11:51
 * Class CityshowController
 */
class CityshowController extends Controller
{
    public $showBack;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights'
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /** @var Cityshow $model */
        $model = $this->loadModel($id);

        if (isset($_POST['Cityshow'])) {
            $model->attributes = $this->getPost('Cityshow');
            if ($model->save()) {
                $this->setFlash('success', '审核成功');
                @SystemLog::record(Yii::app()->user->name . "审核城市馆" . $id);
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', '审核失败');
            }
        }
        if ($model->top_banner) $model->top_banner = unserialize($model->top_banner);

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除城市馆" . $id);
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Cityshow('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cityshow']))
            $model->attributes = $_GET['Cityshow'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 修改排序
     * @param $id
     */
    public function actionSort($id)
    {
        $this->layout = false;
        /** @var Cityshow $model */
        $model = $this->loadModel($id);
        if (isset($_POST['Cityshow'])) {
            $model->attributes = $this->getPost('Cityshow');
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "修改城市馆排序" . $id);
                echo "<script>var success = true;</script>";
            }
        }
        $this->render('sort', array('model' => $model));
    }

    /**
     * 修改排序
     * @param $id
     */
    public function actionThemeSort($id)
    {
        $this->layout = false;
        /** @var CityshowTheme $model */
        $model = CityshowTheme::model()->findByPk($id);
        if (isset($_POST['CityshowTheme'])) {
            $model->attributes = $this->getPost('CityshowTheme');
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "修改城市馆主题排序" . $id);
                echo "<script>var success = true;</script>";
            }
        }
        $this->render('themeSort', array('model' => $model));
    }
    /**
     * 修改发布状态
     */
    public function actionChangeShow()
    {
        /**
         * @var $model Cityshow
         */
        $model = $this->loadModel($this->getPost('id'));
        if ($model->is_show == $model::SHOW_YES) {
            $model->is_show = $model::SHOW_NO;
        } else {
            $model->is_show = $model::SHOW_YES;
        }
        $model->save(false);
        @SystemLog::record(Yii::app()->user->name . "修改城市馆发布状态" . $model->id);
    }

    /**
     * 城市馆入驻商家
     * @param $id
     * @throws CHttpException
     */
    public function actionStore($id)
    {
        /**
         * @var $model Cityshow
         */
        $model = $this->loadModel($id);
        $this->showBack = true;
        $cityshowStore = new CityshowStore('search');
        $cityshowStore->unsetAttributes();  // clear any default values
        $cityshowStore->cityshow_id = $id;
        if (isset($_GET['CityshowStore']))
            $cityshowStore->attributes = $_GET['CityshowStore'];

        $this->render('store', array('model' => $model, 'cityshowStore' => $cityshowStore));
    }

    /**
     * 城市馆入驻商家的商品列表
     * @throws Exception
     */
    public function actionGoods()
    {
        $model = new CityshowGoods('search');
        $model->unsetAttributes();
        $id = $this->getParam('id');
        if($id){
            $model->store_id = $id;
            $cityshowStore = CityshowStore::model()->findByPk($id);
            if (!$cityshowStore) throw new Exception("CityshowStore null");
            $cityshow = Cityshow::model()->findByPk($cityshowStore->cityshow_id);
            if (!$cityshow) throw new Exception("cityshow null");
            $theme = null;
        }else{
            $theme_id = $this->getParam('theme_id');
            $cityshow =  Cityshow::model()->findByPk($this->getParam('cityshow_id'));
            $model->theme_id = $theme_id;
            $cityshowStore = null;
            $theme = CityshowTheme::model()->findByPk($theme_id);
        }
        if(isset($_GET['CityshowGoods'])){
            $model->attributes = $_GET['CityshowGoods'];
        }
        $this->render('goods', array('model' => $model, 'cityshowStore' => $cityshowStore, 'cityshow' => $cityshow,'theme'=>$theme));
    }

    /**
     * 修改入驻商家状态
     * @throws Exception
     */
    public function actionChangeStore(){
        /** @var CityshowStore $cityshowStore */
        $cityshowStore = CityshowStore::model()->findByPk($this->getPost('id'));
        if(!$cityshowStore) throw new Exception('找不到数据');
        if ($cityshowStore->status == CityshowStore::STATUS_YES) {
            $cityshowStore->status = CityshowStore::STATUS_DEL;
        } else {
            $cityshowStore->status = CityshowStore::STATUS_YES;
        }
        $cityshowStore->save(false);
        @SystemLog::record(Yii::app()->user->name . "修改入驻商家状态" . $cityshowStore->id);
    }

    /**
     * 删除入驻商家
     * @param $id
     * @throws CDbException
     * @throws Exception
     */
    public function actionDeleteStore($id){
        $cityshowStore = CityshowStore::model()->findByPk($id);
        if(!$cityshowStore) throw new Exception('找不到数据');
        @SystemLog::record(Yii::app()->user->name . "删除入驻商家" . $cityshowStore->id);
        $cityshowStore->delete();
    }

    /**
     * 城市馆主题
     * @param $id
     * @throws Exception
     */
    public function actionTheme($id){
        $model =Cityshow::model()->findByPk($id);
        $theme = new CityshowTheme('search');
        $theme->cityshow_id = $id;
        if(!$model) throw new Exception('找不到数据');
        if(isset($_GET['CityshowTheme'])){
            $theme->attributes = $this->getParam('CityshowTheme');
        }
        $this->render('theme',array('theme'=>$theme,'model'=>$model));
    }
}
