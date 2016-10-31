<?php

class AppTopicCarCommentController extends Controller
{



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$topic_id)
	{

		$model=$this->loadModel($id);
		$model->content = mb_convert_encoding(rawurldecode($model->content), "UTF-8","auto");
        $model->topic_id = $topic_id;
		if(isset($_POST['AppTopicCarComment']))
		{
			$model->attributes=$_POST['AppTopicCarComment'];
			$model->content = rawurlencode($model->content);
			if($model->save())
				 $this->redirect(array('admin','topic_id'=>$model->topic_id));

		}

		$this->render('update',array(
			'model'=>$model,
            'topic_id'=>$topic_id,
		));
	}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateReplyPeople($id,$topic_id,$parent_id)
    {

        $model=$this->loadModel($id);
        $model->topic_id = $topic_id;
        $model->parent_id = $parent_id;
        $model->content = rawurldecode($model->content);
        if(isset($_POST['AppTopicCarComment']))
        {
            $model->attributes=$_POST['AppTopicCarComment'];
            $model->content = rawurlencode($model->content);
            if($model->save())
                $this->redirect(array('replyPeople','parent_id'=>$model->parent_id,'topic_id'=>$model->topic_id));

        }

        $this->render('updateReplyPeople',array(
            'model'=>$model,
            'topic_id'=>$topic_id,
            'parent_id'=>$parent_id,
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
	 * Manages all models.
	 */
	public function actionAdmin($topic_id)
	{
		$model = new AppTopicCarComment();
        $model->unsetAttributes();
        $model->topic_id = $topic_id;
        $model->parent_id = 0;
		if(isset($_GET['AppTopicCarComment'])){
			$model->attributes = $this->getParam('AppTopicCarComment');
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /*
     * 二级评论
     */
    public function actionReplyPeople($parent_id,$topic_id){
        $model = new AppTopicCarComment();
        $model->unsetAttributes();

        $model->parent_id =$parent_id;
        $model->topic_id =$topic_id;
        if(isset($_GET['AppTopicCarComment']))
            $model->attributes=$_GET['AppTopicCarComment'];

        $this->render('replyPeople',array(
            'model'=>$model,
			'topic_id'=>$topic_id,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AppTopicCarComment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AppTopicCarComment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AppTopicCarComment $model the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='app-topic-car-comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
