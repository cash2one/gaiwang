<?php

/**
 * 充值卡控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class PrepaidCardController extends MController {

    // 验证码
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '45',
                'width' => '60',
                'minLength' => 4,
                'maxLength' => 4,
                'testLimit' => 50,
            ),
        );
    }

    // 充值卡充值
    public function actionUse() {
        $model = new PrepaidCardForm;
        $this->performAjaxValidation($model);
        if (isset($_POST['PrepaidCardForm'])) {
            $model->attributes = $this->getPost('PrepaidCardForm');
            if ($model->validate()) {
                $result = $model->recharge();
                if ($result === true) {
                    $this->setFlash('success', Yii::t('prepaidCard', '充值成功'));
                    $this->redirect(array('use'));
                }
            } else
                $this->setFlash('error', Yii::t('prepaidCard', '错误的充值卡或密码！'));
        }

        $this->pageTitle = Yii::t('memberRecharge', '积分充值') . Yii::t('memberRecharge', '_用户中心_') . Yii::app()->name;
        $this->render('use', array('model' => $model));
    }

}
