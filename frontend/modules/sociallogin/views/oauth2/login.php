<?php
/** @var $this Oauth2Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo $this->pageTitle ?>">
    <meta name="description" content="<?php echo $this->pageTitle ?>">
    <title><?php echo $this->pageTitle ?></title>
    <link rel="stylesheet" href="<?php echo DOMAIN ?>/css/sociallogin.css" type="text/css">

</head>
<body>
<div class="unite_layout">
    <div class="unite_box">
        <a href="<?php echo DOMAIN ?>" class="logo fl" id="log_"><img src="<?php echo DOMAIN ?>/images/bgs/logo.png" alt="<?php echo Yii::app()->name; ?>"/></a>
        <div class="go_to">
            <p>
                直接用<em><?php echo Yii::app()->name ?></em>帐号登录<em><?php echo $this->getUser()->getState('thirdName') ?></em>，无需反复注册.
            </p>
        </div>
        <?php
        /** @var CActiveForm $form */
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'home-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="login_box">
            <table>
                <tbody>
                <tr>
                    <th><label for="username">帐号：</label></th>
                    <td>
                        <span id="useremail_box" class="suggest_box input_layout">
                            <?php
                            echo $form->textField($model, 'username', array('class' => 'urs_login_input',
                                'placeholder' => Yii::t('memberHome', '会员编号 / 用户名 / 手机号'),
                                'onkeyup' => "this.value=this.value.replace(/(^\s+)|(\s+$)/g,'')",
                            ));
                            if(!empty($users)){
                                echo CHtml::label(
                                    Yii::t('memberHome', '{mobile}绑定了多个盖网编号，请选择',array('{mobile}'=>$model->username)),
                                    'gai_number',array('style'=>'color:##FF0000;background:#FFFFC0;padding:2px 1px;'));
                                echo CHtml::dropDownList('gai_number','',$users,array('style'=>'width:235px;'));
                            }
                            ?>
                            <?php echo $form->error($model, 'username'); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th><label for="password">密码：</label></th>
                    <td>
                        <span class="input_layout">
                             <?php
                             echo $form->passwordField($model, 'password', array(
                                 'class' => 'urs_login_input',
                             ));
                             ?>
                             <?php echo $form->error($model, 'password'); ?>
                        </span>
                    </td>
                </tr>
                <?php if (LoginForm::captchaRequirement()): ?>
                <tr>
                    <th><label for="password"></label></th>
                    <td>
                        <span class="input_layout">
                              <?php
                              echo $form->textField($model, 'verifyCode', array(
                                  'class' => 'urs_login_input inputtxtCode',
                                  'placeholder' => Yii::t('memberHome', '验证码:'),
                              ));
                              ?>
                            &nbsp;
                        <i class="changeCode" onclick="changeVeryfyCode()">
                            <?php
                            $this->widget('CCaptcha', array(
                                'showRefreshButton' => false,
                                'clickableImage' => true,
                                'id' => 'verifyCodeImg',
                                'imageOptions' => array('alt' => Yii::t('memberHome', '点击换图'), 'title' => Yii::t('memberHome', '点击换图'))
                            ));
                            ?>
                        </i>
                            <?php echo $form->error($model, 'verifyCode'); ?>
                            <script>
                                //点击旁边的刷选验证码
                                function changeVeryfyCode() {
                                    jQuery.ajax({
                                        url: "<?php echo Yii::app()->createUrl('/sociallogin/oauth2/captcha/refresh/1') ?>",
                                        dataType: 'json',
                                        cache: false,
                                        success: function(data) {
                                            jQuery('#verifyCodeImg').attr('src', data['url']);
                                            jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                                        }
                                    });
                                    return false;
                                }
                            </script>
                        </span>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th class="normalTd">&nbsp;</th>
                    <td><span class="share_mail">
                        <a href="<?php echo $this->createAbsoluteUrl('/member/home/register') ?>" target="_blank" class="forget_link">
                            <em>注册</em>&nbsp;&nbsp;
                        </a>
                        <a href="<?php echo $this->createAbsoluteUrl('/member/home/resetPassword') ?>" target="_blank" class="forget_link">忘记密码？</a>
                    </td>
                </tr>
                <tr>
                    <th class="normalTd">&nbsp;</th>
                    <td>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="btn_area"><input class="blue_btn" value="登录" type="submit"></p>

        </div>
        <?php $this->endWidget(); ?>
    </div>
    <p class="tips">提示：为保障帐号安全，请认准本页URL地址必须以 <?php echo DOMAIN ?> 开头</p>
</div>
</body>
</html>