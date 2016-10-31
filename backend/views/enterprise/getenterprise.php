<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#enterprise-grid').yiiGridView('update', {
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
        if (p && p.onSelectMemeberInfo) {
            p.onSelectMemeberInfo(id);
        }
        p.doClose();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<div  class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <td>
                    <?php echo $form->label($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?>
                </td>
                <td>
                    <?php echo CHtml::submitButton(Yii::t('hotelProvider', '搜索'), array('class' => 'reg-sub')); ?>
                </td>    
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'enterprise-grid',
    'dataProvider' => $model->getHotelEnterprise(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => Yii::t('member', '选择'),
                    'url' => '"#".$data->id',
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => 'btnOKClick(this)',
                    ),
                ),
            ),
        ),
        'name',
        array(
            'name' => 'member_id',
            'value' => 'isset($data->member_id) ? $data->member->gai_number : ""'
        )
    ),
));
?>