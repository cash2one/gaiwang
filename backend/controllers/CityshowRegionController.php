<?php

/**
 * 城市馆大区 控制器（列表、增、删、改）
 * @author zhenjun.xu
 */
class CityshowRegionController extends Controller
{


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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CityshowRegion;

        $this->performAjaxValidation($model);

        if (isset($_POST['CityshowRegion'])) {
            $model->attributes = $this->getPost('CityshowRegion');
            if ($model->save()) {
                $this->setFlash('success', '操作成功');
                @SystemLog::record(Yii::app()->user->name . "创建城市馆大区" . $model->id);
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', '操作失败');
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['CityshowRegion'])) {
            $model->attributes = $this->getPost('CityshowRegion');
            if ($model->save()) {
                $this->setFlash('success', '操作成功');
                @SystemLog::record(Yii::app()->user->name . "修改城市馆大区" . $id);
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', '操作失败');
            }
        }

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
        @SystemLog::record(Yii::app()->user->name . "删除城市馆大区" . $id);
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new CityshowRegion('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CityshowRegion']))
            $model->attributes = $_GET['CityshowRegion'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
