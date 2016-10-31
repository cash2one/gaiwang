<?php

/**
 * 会员级别控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class MemberGradeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加会员级别
     */
    public function actionCreate() {
        $model = new MemberGrade();

        $this->performAjaxValidation($model);

        if (isset($_POST['MemberGrade'])) {
            $model->attributes = $_POST['MemberGrade'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加会员级别：".$model->name);
                $this->setFlash('success', Yii::t('member', '添加会员级别成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员级别
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberGrade'])) {
            $model->attributes = $_POST['MemberGrade'];
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."修改会员级别：".$model->name);
                $this->setFlash('success', Yii::t('member', '修改会员级别成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 会员级别管理
     */
    public function actionAdmin() {
        $model = new MemberGrade('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberGrade']))
            $model->attributes = $_GET['MemberGrade'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
