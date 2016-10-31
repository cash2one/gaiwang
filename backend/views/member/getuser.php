<?php
$this->breadcrumbs = array(
    Yii::t('member', '会员搜索'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
        if (!$('#Member_searchKeyword').val()) {
            alert('" . Yii::t('member', '请输入会员名/会员编码/手机号') . "');
            return false;
        }
	$('#member-grid').yiiGridView('update', {
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
            alert(<?php echo Yii::t('member', "请选择所属会员"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectMemeber) {
            p.onSelectMemeber(id);
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
                    <?php echo Yii::t('member', '请输入会员名/会员编码/手机号'); ?> :
                    <?php echo $form->textField($model, 'searchKeyword', array('class' => 'text-input-bj middle')); ?>
                    <?php echo CHtml::submitButton(Yii::t('member', '搜索'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('member', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->getUserSearch(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => Yii::t('member','选择'),
                    'url' => '"#".$data->id', 
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => "btnOKClick(this)",
                    ),
                ),
            ),
        ),
        'username',
        'gai_number',
    ),
));
?>