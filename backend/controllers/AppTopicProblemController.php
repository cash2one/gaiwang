<?php

class AppTopicProblemController extends Controller
{


	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AppTopicProblem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AppTopicProblem']))
		{
			$model->attributes=$_POST['AppTopicProblem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdate($id,$life_topic_id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->problem = mb_convert_encoding(rawurldecode($model->problem), "UTF-8","auto");
		if(isset($_POST['AppTopicProblem']))
		{
			$model->attributes=$_POST['AppTopicProblem'];
			$model->problem = rawurlencode($model->problem);
			if($model->save(false))
				$this->redirect(array('admin','life_topic_id'=>$life_topic_id));
		}

		$this->render('update',array(
			'model'=>$model,
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AppTopicProblem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($life_topic_id)
	{

		$model= new AppTopicProblem();
		$model->unsetAttributes();  // clear any default values
        $model->life_topic_id =$life_topic_id;
        $model->parent_id = 0;
		if(isset($_GET['AppTopicProblem'])){
			//var_dump($_GET['AppTopicProblem']);
			$model->attributes=$_GET['AppTopicProblem'];
			$model->end_create_time = strtotime($_GET['AppTopicProblem']['end_create_time']);
			$model->create_time = strtotime($_GET['AppTopicProblem']['create_time']);
			if($_GET['AppTopicProblem']['name'] != ""){
				$sql = "SELECT id FROM `gw_member` `t` WHERE username like '{$_GET['AppTopicProblem']['name']}%' union 
				 SELECT id FROM `gw_member` `t` WHERE gai_number like '{$_GET['AppTopicProblem']['name']}%'";
				$data = Yii::app()->db1->Createcommand($sql)->queryColumn();
				if($data){
					$model->member_id = implode(",", $data);
				}else{
					$model->member_id = "";
				}
			}
		}
			

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /*
     * 二级评论 (回复者)
     */
    public function actionReplyPeople($parent_id){
        $model = new AppTopicProblem();
        $model->unsetAttributes();

        $model->parent_id =$parent_id;

        if(isset($_GET['AppTopicProblem']))
            $model->attributes=$_GET['AppTopicProblem'];

        $this->render('replyPeople',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateReplyPeople($id,$life_topic_id,$parent_id)
    {

        $model=$this->loadModel($id);
        $model->life_topic_id = $life_topic_id;
        $model->parent_id = $parent_id;
        $model->problem = rawurldecode($model->problem);
        if(isset($_POST['AppTopicProblem']))
        {
            $model->attributes=$_POST['AppTopicProblem'];
            $model->problem = rawurlencode($model->problem);
            if($model->save())
                $this->redirect(array('replyPeople','parent_id'=>$model->parent_id));

        }

        $this->render('updateReplyPeople',array(
            'model'=>$model,
            'life_topic_id'=>$life_topic_id,
            'parent_id'=>$parent_id,
        ));
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AppTopicProblem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AppTopicProblem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AppTopicProblem $model the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='app-topic-problem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
