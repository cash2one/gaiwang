<?php

/**
 * 商品规格控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class SpecController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加商品规格
     */
    public function actionCreate() {
        $model = new Spec;
        $model->type = 1;

        $this->performAjaxValidation($model);

        if (isset($_POST['Spec'])) {
            $model->attributes = $_POST['Spec'];
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."添加商品规格：".$model->name);
            	$this->setFlash('success', Yii::t('spec', '添加商品规格') . $model->name . Yii::t('spec', '成功'));
            }
                
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商品规格
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Spec'])) {
            $model->attributes = $_POST['Spec'];
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."修改商品规格：".$model->name);
            	$this->setFlash('success', Yii::t('spec', '编辑商品规格') . $model->name . Yii::t('spec', '成功'));
            }
                
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除商品规格
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name."删除商品规格：".$id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 商品规格管理
     */
    public function actionAdmin() {
        $model = new Spec('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Spec']))
            $model->attributes = $_GET['Spec'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
