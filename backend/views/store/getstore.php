<?php
$this->breadcrumbs = array(Yii::t('store', '选择店铺'));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#store-grid').yiiGridView('update', {
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
            alert(<?php echo Yii::t('store', "请选择加盟商"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectStore) {
            p.onSelectStore(id);
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
                    <?php echo $form->label($model, 'member_id'); ?>
                    <?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  least')); ?>
                    <?php echo $form->label($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->label($model, 'status'); ?>
                    <?php echo $form->radioButtonList($model, 'status', Store::status(), array('separator' => '')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->label($model, 'create_time'); ?>
                    <?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'create_time')); ?>
                    <?php echo $form->label($model, 'endTime'); ?>
                    <?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'endTime')); ?>
                    <?php echo CHtml::submitButton(Yii::t('user', '搜索'), array('class' => 'reg-sub')); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'store-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
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
        array(
            'name' => 'member_id',
            //'value' => '$data->member_id ? $data->member->gai_number : ""'
            'value' => '$data->username'
        ),
        'name',
        'mobile',
        array(
            'name' => 'status',
            'value' => 'Store::status($data->status)'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y/m/d H:i:s", $data->create_time)'
        ),
    ),
));
?>