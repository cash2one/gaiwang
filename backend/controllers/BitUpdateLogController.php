<?php

/**
 * 更新日志
 * Class BitUpdateLogController
 */
class BitUpdateLogController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new BitUpdateLog;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['BitUpdateLog']))
		{
			$model->attributes=$_POST['BitUpdateLog'];
			if($model->save()){
                $this->setFlash('success','添加成功');
                $this->redirect(array('admin'));
            }else{
                $this->setFlash('error','添加失败');
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['BitUpdateLog']))
		{
			$model->attributes=$_POST['BitUpdateLog'];
            if($model->save()){
                $this->setFlash('success','添加成功');
                $this->redirect(array('admin'));
            }else{
                $this->setFlash('error','添加失败');
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BitUpdateLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BitUpdateLog']))
			$model->attributes=$_GET['BitUpdateLog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

}
