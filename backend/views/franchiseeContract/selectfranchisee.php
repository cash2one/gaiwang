<?php
$this->breadcrumbs = array(
    Yii::t('franchisee', '商户搜索'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
        if (!$('#Franchisee_name').val()) {
            alert('" . Yii::t('franchisee', '请输入加盟商名称/所属会员编码/手机号码') . "');
            return false;
        }
	$('#franchisee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    var btnOKClick = function(obj) {
        var id = obj.hash.replace('#', '');
        if (!id) {
            alert(<?php echo Yii::t('franchiseecontract', "请选择商户"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectBizPMember) {
            p.onSelectBizPMember(id);
        }
        p.doClose();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<div  class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <thead>
            <tr style="height: 50px">
                <td colspan="4">
                    <?php echo Yii::t('franchiseecontract', '请输入加盟商名称/所属会员编码/手机号码'); ?> :
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
                    <?php echo CHtml::submitButton(Yii::t('franchiseecontract', '搜索'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('franchiseecontract', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-grid',
    'dataProvider' => $model->getFranchisee(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => '选择',
                    'url' => '"#".$data->id', 
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => "btnOKClick(this)",
                    ),
                ),
            ),
        ),
        'name',
        array(
            'name'  => Yii::t('franchiseecontract','所属会员'),
            'value' => '$data->member->gai_number',
        ),
        'mobile',
        'street',
    ),
));
?>