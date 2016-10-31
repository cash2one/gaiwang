<?php
$title = Yii::t('storeAddress', '添加属下商家');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('storeAddress', '属下商家列表 '),
    $title,
);

?>
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>/css/reg.css">
<div class="toolbar">
    <h3><?php echo Yii::t('storeAddress','添加属下商家'); ?></h3>
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
    
    <tr>
        <th><?php echo $form->labelEx($model,'设置属下商家'); ?></th>
        <td>
          <?php echo $form->hiddenField($model,'under_id') ?>
          <input class="text-input-bj middle" style="width:320px;" size="60" maxlength="128" name="MemberUsername" id="MemberUsername" readonly="readonly" type="text" value="" />
            <?php echo $form->error($model,'under_id'); ?>
                <input type="button" value="<?php echo Yii::t('store', '搜索'); ?>" id="seachParterMem"  class="reg-sub" />
                <input type="button" value="<?php echo Yii::t('store', '清空'); ?>" id="clearParterMem"  class="reg-sub" />
                <?php echo $form->error($model, 'under_id') ?>
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
    <script type="text/javascript">
        $("#clearParterMem").click(function() {
            $("#MemberUsername").val('');
            $("#Store_under_id").val('');
        });
    </script>
 <script type="text/javascript" src="<?php echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero"></script>
 <script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<?php
$sid=$this->getParam('id');
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    $('#seachParterMem').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('middleAgent/getAgent',array('id'=>$sid)) . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
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
            url:'" . $this->createUrl('middleAgent/getUserName') . "?id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Store_under_id').val(uid);
                $('#MemberUsername').val(name);
            }
        })  
    }
};
", CClientScript::POS_HEAD);
?>