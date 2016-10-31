<?php

class GuestbookController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

//        Tool::pr($_SESSION);
//        $model->status = $model::STATUS_READ;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Guestbook'])) {
            $model->attributes = $_POST['Guestbook'];

            $model->reply_content = $_POST['Guestbook']['reply_content'];
            $model->status = $_POST['Guestbook']['status'];

            if ($model->save()){
            	@SystemLog::record(Yii::app()->user->name."回复咨询 :{$model->id}|{$model->content}");
            	$this->setFlash('success', Yii::t('guestbook', '回复成功!'));
            }
                

            $this->redirect(array('admin'));
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
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
		@SystemLog::record(Yii::app()->user->name."删除咨询 :{$id}");
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Guestbook('search');
        $model->unsetAttributes();  // clear any default values
        $model->status = $model::STATUS_ALL;
        $model->reply = $model::ALL;
        if (isset($_GET['Guestbook'])) {
            $model->attributes = $_GET['Guestbook'];
            $model->goodsName = $_GET['Guestbook']['goodsName'];
            $model->reply = $_GET['Guestbook']['reply'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
