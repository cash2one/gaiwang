<?php

/**
 * 商品属性值控制器(添加,修改,删除,管理)
 * @author binbin.liao  <277250538@qq.com>
 */
class AttributeValueController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    //创建
    public function actionCreate($attr_id) {
        $model = new AttributeValue;
//        //传入属性id
//        if($this->getParam('attr_id'))
//            $attr_id=  $this->getParam ('attr_id');

        $this->performAjaxValidation($model);

        if (isset($_POST['AttributeValue'])) {
            $model->attributes = $_POST['AttributeValue'];
            $model->attribute_id = $attr_id;
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."添加商品属性值：{$model->name}");
            	$this->redirect(array('admin', 'attr_id' => $attr_id));
            }else{
            	@SystemLog::record(Yii::app()->user->name."添加商品属性值：{$model->name} 失败");
            }
                
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    //修改
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['AttributeValue'])) {
            $model->attributes = $_POST['AttributeValue'];
            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."更新商品属性值：{$model->name}");
            	$this->redirect(array('admin', 'attr_id' => $model->attribute_id));
            }else{
            	@SystemLog::record(Yii::app()->user->name."更新商品属性值：{$model->name} 失败");
            }
                
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    //删除
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
		@SystemLog::record(Yii::app()->user->name."删除商品属性值：{$id}");
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    //管理
    public function actionAdmin() {
        $model = new AttributeValue('search');
        $model->unsetAttributes();
        //传递属性id
        if ($this->getParam('attr_id'))
            $model->attribute_id = $this->getParam('attr_id');
        if (isset($_GET['AttributeValue']))
            $model->attributes = $_GET['AttributeValue'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
