<?php
/* @var $this StoreController */
/* @var $model Store */
/* @var $form CActiveForm */
$this->breadcrumbs = array(Yii::t('store', '店铺') => array('admin'), Yii::t('store', '设置推荐人'));
?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
//        'afterValidate' => 'js:submit_check'
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr><th colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('store', '设置推荐人'); ?></th></tr>
        <tr>
            <th style="width: 220px" class="odd"><?php echo $form->labelEx($model, 'referrals_id'); ?></th>
            <td class="odd">
                <?php echo $form->hiddenField($model, 'referrals_id') ?>
                <input class="text-input-bj  middle" name="RefMemberUsername" id="RefMemberUsername" readonly="readonly" type="text" value="<?php if (!empty($model->referrals_id)) echo Member::model()->findByPk($model->referrals_id)->username; ?>" />
                <input type="button" value="<?php echo Yii::t('store', '搜索'); ?>" id="seachRefMem"  class="reg-sub" />
                <input type="button" value="<?php echo Yii::t('store', '清空'); ?>" id="clearRefMem"  class="reg-sub" />
                <?php echo $form->error($model, 'referrals_id') ?>
                <script type="text/javascript">
                    $("#clearRefMem").click(function() {
                        $("#RefMemberUsername").val('');
                        $("#Store_referrals_id").val('');
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td class="even"></td>
            <td colspan="2">
                <?php echo CHtml::submitButton('提交', array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    $('#seachRefMem').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser/isc/' . Member::ENTERPRISE_YES) . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})
 var doClose = function() {
                if (null != dialog) {
                    dialog.close();
                }
            };
 var onSelectBizPMember = function(pid) {};
 var onSelectMemeber = function (uid) {
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/member/getUserName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Store_referrals_id').val(uid);
                $('#RefMemberUsername').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>