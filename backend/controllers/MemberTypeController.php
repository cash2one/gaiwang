<?php

/**
 * 会员类型管理控制器
 * 操作(列表，修改)
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class MemberTypeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 会员类型列表
     */
    public function actionAdmin() {
        $model = new MemberType('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberType']))
            $model->attributes = $this->getParam('MemberType');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员类型
     * @param int $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberType'])) {
            $model->attributes = $this->getPost('MemberType');
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改会员类型：" . $model->name);
                $this->setFlash('success', Yii::t('memberType', '修改会员类型成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

}
