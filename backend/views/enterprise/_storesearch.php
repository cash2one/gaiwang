<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('enterprise', '时间'); ?>：
            </th>
            <td colspan="2">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'create_time',
                    'select'=>'date',
                ));
                ?> -
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'end_create_time',
                    'select'=>'date'
                ));
                ?>
            </td>
        </tr>
        </tbody></table>
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'store_name'); ?></th>
                <td><?php echo $form->textField($model, 'store_name', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('enterprise', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
    <div style="width:500px;margin:20px 0 0 20px;">
        当前共有 <strong id="total"></strong> 家店铺，待开店
        <a style="color:red;font-size: large" id="wait"
           href="<?php echo $this->createAbsoluteUrl('enterprise/storeAdmin',
               array('Enterprise[store_status]'=>Store::STATUS_APPLYING,'Enterprise_page'=>1)) ?>"></a> 家，
        已开店 <strong id="open"></strong> 家，
        已关店 <strong id="close"></strong> 家
    </div>
</div>
<script>
    $(function(){
        var url = "<?php echo $this->createAbsoluteUrl('enterprise/storeStatistical') ?>";
        $.getJSON(url,function(data){
            $("#total").html(data.total);
            $("#wait").html(data.wait);
            $("#open").html(data.open);
            $("#close").html(data.close);
        });
    });
</script>