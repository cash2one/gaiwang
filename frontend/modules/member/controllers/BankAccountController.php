<?php

/**
 * 银行账户控制器
 * 操作(显示，修改)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class BankAccountController extends MController {

    public function actionIndex() {
        exit;//不让用户修改了
        $this->pageTitle = Yii::t('memberBankAccount', '银行账户设置_用户中心_') . Yii::app()->name;
        $model = BankAccount::model()->findByAttributes(array('member_id' => $this->getUser()->id));
        if (!$model)
            $model = new BankAccount();
        $memberModel = $this->model;
        $model->account_name = $memberModel->real_name;
        $this->performAjaxValidation($model);
        if (isset($_POST['BankAccount'])) {
            $model->attributes = $this->getPost('BankAccount');
            $model->member_id = $memberModel->id;
            if ($model->save()) {
                $this->setFlash('success', Yii::t('memberBankAccount', '恭喜您，修改成功！'));
            } else {
                $this->setFlash('error', Yii::t('memberBankAccount', '很抱歉，修改失败！'));
            }
        }
        $this->render('index', array('model' => $model, 'memberModel' => $memberModel));
    }

}
