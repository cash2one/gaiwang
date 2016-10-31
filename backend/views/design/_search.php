<?php
/* @var $this DesignController */
/* @var $model Design */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th><?php echo Yii::t('design', '店铺名称'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'store_id', array('class' => 'text-input-bj middle')); ?>
                </td>
                <th><?php echo Yii::t('design', '会员名'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'username', array('class' => 'text-input-bj middle')); ?>
                </td>
                <th><?php echo Yii::t('design', '盖网账号'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'gw', array('class' => 'text-input-bj least')); ?>
                </td>
                <th>
                    <?php echo Yii::t('design', '审核状态'); ?>：
                </th>
                <td id="status">
                    <?php
                    $status = $model::status();
                    $status = array_reverse($status, true);
                    $status[''] = Yii::t('design', '全部');
                    $status = array_reverse($status, true);
                    ?>
<?php echo $form->radioButtonList($model, 'status', $status, array('separator' => '  '))
?>
                </td>
            </tr>
            <tr>
                <th><?php echo Yii::t('design', '创建时间'); ?>：</th>
                <td colspan="3">
<?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'create_time')); ?>
<?php echo Yii::t('design', '到'); ?>
<?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'end_time')); ?>
                </td>
                <th><?php echo Yii::t('design', '手机号码'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj least')); ?>
                </td>
            </tr>
            <tr>
                <th>
<?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')) ?>
                </th>
                <td colspan="3">
                </td>
            </tr>
        </thead>
    </table>
</div>
<?php $this->endWidget(); ?>
<?php if(Yii::app()->user->checkAccess("Design.BatchOperate")): ?>
<input type="button" onclick="batchPass()" value="<?php echo Yii::t('design', '批量通过'); ?>" class="regm-sub"/>
<input type="button" onclick="batchNotPass()" value="<?php echo Yii::t('design', '批量不通过'); ?>" class="regm-sub"/>
<?php endif; ?>
<div class="c10"></div>
<script>
    var getChecked = function() {
        var ids = '';
        $('.design_id:checked').each(function(i, ele) {
            ids += $(ele).val();
            ids += ',';
        });
        if (ids.length > 0) {
            ids = ids.substring(0, ids.length - 1);
        }
        if (!ids) {
            alert('<?php echo Yii::t('design', '请选择商铺'); ?>');
            return false;
        }
        return ids;
    };
    var batchUrl = "<?php echo $this->createAbsoluteUrl('/design/batchOperate') ?>";
    /**
     * 批量审核通过
     * @returns {boolean}
     */
    function batchPass() {
        var ids = getChecked();
        if (!ids)
            return false;
        $.post(batchUrl, {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', ids: ids, pass: 'yes'}, function(msg) {
            if (msg) {
                alert(msg);
            } else {
                location.reload();
            }
        });
        return false;
    }
    /**
     * 批量审核不通过
     * @returns {boolean}
     */
    function batchNotPass() {
        var ids = getChecked();
        if (!ids)
            return false;
        $.post(batchUrl, {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', ids: ids, pass: 'no'}, function(msg) {
            if (msg) {
                alert(msg);
            } else {
                location.reload();
            }
        });
        return false;
    }

</script>