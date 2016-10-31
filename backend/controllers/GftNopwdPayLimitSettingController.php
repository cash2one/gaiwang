<?php

/**
 * 盖付通，免密码支付额度设置
 * 
 * @author xuegang.liu@g-emall.com
 * @since  2016-05-26T16:10:23+0800
 */
class GftNopwdPayLimitSettingController extends Controller
{
	public $defaultAction = 'admin';

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * list
     */
    public function actionAdmin(){

    	$model = new GftNopwdPayLimitSetting('search');
        $model->unsetAttributes();
        if (isset($_GET['GftNopwdPayLimitSetting'])){
            $model->attributes = $this->getParam('GftNopwdPayLimitSetting');
        }

        $this->render('admin', array('model' => $model,));
    }

    /**
     * create
     */
    public function actionCreate(){

    	$model = new GftNopwdPayLimitSetting();
		$this->performAjaxValidation($model);
		
		if(isset($_POST['GftNopwdPayLimitSetting'])){
			$model->attributes=$_POST['GftNopwdPayLimitSetting'];
			try{
				if(!$model->save()) {
					$errors = (array)$model->getErrors();
					throw new Exception(implode(',',array_pop($errors)));
				}
				SystemLog::record($this->getUser()->name . "添加盖付通免密码支付额度：" );
				$this->setFlash('success',Yii::t('GftNopwdPayLimitSetting','添加成功'));
				$this->redirect(array('admin'));
			}catch(Exception $e){
				$this->setFlash('error',$e->getMessage());
			}
		}
		$this->render('create',array('model'=>$model,));
    }

    /**
     * update
     */
    public function actionUpdate($id) {

        die('编辑功能禁用');

        $model=$this->loadModel($id);
		$this->performAjaxValidation($model);

		if(isset($_POST['GftNopwdPayLimitSetting'])){
			$model->attributes=$_POST['GftNopwdPayLimitSetting'];
			try{
				if(!$model->save()) {
					$errors = (array)$model->getErrors();
					throw new Exception(implode(',',array_pop($errors)));
				}
				SystemLog::record($this->getUser()->name . "修改盖付通免密码支付额度：" );
				$this->setFlash('success',Yii::t('GftNopwdPayLimitSetting','修改成功'));
				$this->redirect(array('admin'));
			}catch(Exception $e){
				$this->setFlash('error',$e->getMessage());
			}
		}

		$this->render('update',array('model'=>$model,));
    }

    /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){

		if(!GftNopwdPayLimitSetting::model()->findByPk($id)->delete()){
			$this->setFlash('error','删除失败');
		}else{
			$this->redirect(array('admin'));	
		}
	}
}