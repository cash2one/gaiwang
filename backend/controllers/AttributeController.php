<?php

/**
 * 商品属性控制器(添加,修改,删除,管理)
 * @author binbin.liao <277250538@qq.com>
 */
class AttributeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    //创建
    public function actionCreate($type_id) {
        $model = new Attribute;
        //$type_id = $this->getParam('type_id'); //类型id
        $this->performAjaxValidation($model);

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            $model->type_id = $type_id;
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."添加商品属性：{$model->name}");
            	$this->redirect(array('admin', 'type_id' => $type_id));
            }else{
            	@SystemLog::record(Yii::app()->user->name."添加商品属性：{$model->name} 失败");
            }
                
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    //编辑
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            $model->show = $_POST['Attribute']['show'];
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."更新商品属性：{$model->name}");
            	$this->redirect(array('admin', 'type_id' => $model->type_id));
            }else{
            	@SystemLog::record(Yii::app()->user->name."更新商品属性：{$model->name} 失败");
            }
                
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    //删除
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
		@SystemLog::record(Yii::app()->user->name."删除商品属性：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    //管理
    public function actionAdmin() {
        $model = new Attribute('search');
        $model->unsetAttributes();  // clear any default values
        if ($this->getParam('type_id'))
            $model->type_id = $this->getParam('type_id');
        if (isset($_GET['Attribute']))
            $model->attributes = $_GET['Attribute'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
