<?php
$this->breadcrumbs = array(
    Yii::t('member', '批量生成普通会员'),
);

?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<div  class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'method' => 'get',
    ));
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <thead>
            <tr style="height: 50px">
                <td colspan="4">
                    <?php echo Yii::t('member', '请输入生成数量'); ?> :
                    <?php echo CHtml::textField('number','50',array('class' => 'text-input-bj middle','maxlength'=>3)); ?>
                    <br/><br/>
                    <?php echo Yii::t('member', '请输入初始密码'); ?> :
                    <?php echo CHtml::textField('password','123456',array('class' => 'text-input-bj middle')); ?>
                    (留空则随机生成6位数字密码)
                    <br/><br/>
                    <?php echo CHtml::submitButton(Yii::t('member', '生成'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('member', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    var btnCancelClick = function() {
        art.dialog.close();
    }

    $('#yw0').submit(function(){
        if (!$('#number').val()) {
            alert('<?php echo Yii::t('member', '请输入生成数量');?>');
            return false;
        }
        if ($('#password').val().length<6 && $('#password').val().length>0) {
            alert('<?php echo Yii::t('member', '密码长度不小于6位');?>');
            return false;
        }
	});

</script>

