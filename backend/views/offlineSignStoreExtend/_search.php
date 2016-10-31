<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <?php echo CHtml::hiddenField("role",$model->role,array('id'=>'role'))?>
            <?php echo CHtml::hiddenField("role_audit_status",$model->role_audit_status,array('id'=>'role_audit_status'))?>
            <?php echo CHtml::hiddenField("apply_type",$model->apply_type,array('id'=>'apply_type'))?>
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
               <!-- <td>
                    <?php /*if(Yii::app()->user->checkAccess('OfflineSignStore.ImportExcel')):*/?>
                        <a href="<?php /*echo Yii::app()->controller->createUrl("importExcel",array('role'=>$this->role))*/?>"><?php /*echo CHtml::button('导入EXCEL',array('class'=>'regm-sub'))*/?></a>
                    <?php /*endif;*/?>
                </td>-->
                <?php if($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER || $role == OfflineSignAuditLogging::ROLE_REGIONAL_SALES || $role == OfflineSignAuditLogging::ROLE_REGION_AUDIT || $role == OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER || $role == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS):?>
                <td>
                    <?php if(Yii::app()->user->checkAccess('OfflineSignStore.ExportExcel')):?>
                        <?php echo CHtml::button('导出EXCEL',array('class'=>'regm-sub','id'=>'export-but','url'=>Yii::app()->controller->createUrl("exportExcel",array('role'=>$this->role)) ))?>
                    <?php endif;?>
                </td>
                <?php endif;?>
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
                hideDiv.find('input:first').val("<?php if($model->role == OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_DONE){echo 'offline-sign-store-extend/finishAdmin';}else{echo 'offline-sign-store-extend/admin';}?>")
            })
        })
    </script>