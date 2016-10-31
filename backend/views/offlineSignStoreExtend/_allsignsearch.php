<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $form CActiveForm */
?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route,array('role'=>$role)),
        'method' => 'get',
    ));
    ?>

    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th><?php echo $form->label($model, 'enTerName'); ?>：</th>
                <td><?php echo $form->textField($model, 'enTerName', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th><?php echo $form->label($model, 'repeat_audit'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'repeat_audit',OfflineSignStoreExtend::getIsRepeatAudit(), array('empty' => Yii::t('OfflineSignStore', '请选择'), 'separator' => '')); ?></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th><?php echo $form->label($model, 'repeat_application'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'repeat_application',OfflineSignStoreExtend::getISRepeatApplication(), array('empty' => Yii::t('OfflineSignStore', '请选择'), 'separator' => '')); ?></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th><?php echo $form->label($model, 'create_time'); ?>：</th>
                <td>
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'createTimeStart',
                        'select' => 'date',
                    ));
                    ?> -
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'createTimeEnd',
                        'select' => 'date',
                    ));
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
            </tr>
            </tbody>
        </table>
        <div class="c10"></div>
        <?php echo CHtml::submitButton(Yii::t('hotelOrder', '搜索'), array('class' => 'reg-sub','id'=>'serach-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>

<script type="text/javascript">
jQuery(function($){

    //导出数据，按照筛选条件进行过滤
    $('#export-but').click(function(event) {
        var hideDiv = $('#yw0').find('div:first');
        hideDiv.find('input:first').val('offline-sign-store-extend/export-excel')
        $('#yw0').submit();
        return true;
    });

    $('#serach-btn').click(function(){
        var hideDiv = $('#yw0').find('div:first');
        hideDiv.find('input:first').val('offline-sign-store-extend/all-contract-admin')
        $('#yw0').submit();
        return true;
    })
})
</script>