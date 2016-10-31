<?php
/** @var $model SmsApiConfigForm */
/** @var $form CActiveForm */
?>
<style>.tab-come th {
        text-align: center;
    }</style>
<div class='form'>
    <?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>

    <table width='100%' border='0' class='tab-come' cellspacing='1' cellpadding='0'>
        <tbody>
        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '香港易通讯短信接口'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytAccountNo'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytAccountNo', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'ytAccountNo'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytPwd'); ?>
            </th>
            <td>
                <?php echo $form->passwordField($model, 'ytPwd', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'ytPwd'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytSendUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytSendUrl', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'ytSendUrl'); ?>
            </td>
        </tr>

        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '易信短信接口'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'yxCorpID'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'yxCorpID', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'yxCorpID'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'yxLoginName'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'yxLoginName', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'yxLoginName'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'yxPassword'); ?>
            </th>
            <td>
                <?php echo $form->passwordField($model, 'yxPassword', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'yxPassword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'yxSendUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'yxSendUrl', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'yxSendUrl'); ?>
            </td>
        </tr>

        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '短信通接口'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'dxtZh'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'dxtZh', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'dxtZh'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'dxtMm'); ?>
            </th>
            <td>
                <?php echo $form->passwordField($model, 'dxtMm', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'dxtMm'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'dxtSendUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'dxtSendUrl', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'dxtSendUrl'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'dxtDxlbid'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'dxtDxlbid', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'dxtDxlbid'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'dxtExtno'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'dxtExtno', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'dxtExtno'); ?>
            </td>
        </tr>

        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '吉信通短信接口'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtLoginName'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'jxtLoginName', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtLoginName'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtPassword'); ?>
            </th>
            <td>
                <?php echo $form->passwordField($model, 'jxtPassword', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtPassword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtSendUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'jxtSendUrl', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtSendUrl'); ?>
            </td>
        </tr>
        
        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '吉信通短信接口(广告)'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtadvertLoginName'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'jxtadvertLoginName', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtadvertLoginName'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtadvertPassword'); ?>
            </th>
            <td>
                <?php echo $form->passwordField($model, 'jxtadvertPassword', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtadvertPassword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jxtadvertSendUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'jxtadvertSendUrl', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'jxtadvertSendUrl'); ?>
            </td>
        </tr>
        <tr>
            <th colspan='2' class='title-th even'>
                <?php echo Yii::t('home', '容联云通讯'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytxSid'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytxSid', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'ytxSid'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytxToken'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytxToken', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'ytxToken'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytxUrl'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytxUrl', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'ytxUrl'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytxAppId'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'ytxAppId', array('class' => 'text-input-bj  longest valid')); ?>
                <?php echo $form->error($model, 'ytxAppId'); ?>
            </td>
        </tr>

        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ytxVoiceVerify'); ?>
            </th>
            <td>
                <?php echo $form->radioButtonList($model, 'ytxVoiceVerify', $model::voiceVerifyStatus(), array('separator' => ' ')) ?>
                <?php echo $form->error($model, 'ytxVoiceVerify'); ?>
            </td>
        </tr>

        <tr>
            <th colspan="2" class="title-th even">
                <?php echo Yii::t('home', '当前大陆使用接口配置'); ?>
            </th>
        </tr>
        <tr>
            <th class="even">
                <?php echo Yii::t('home', '当前大陆使用接口') ?>：
            </th>
            <td class="even">
                <?php echo $form->radioButtonList($model, 'currentAPI', $model::APIEnum(), array('separator' => ' ')) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
        </tbody>
    </table>

    <?php $this->endWidget(); ?>
</div>