<?php
/**
 * @var $model AccountFlow
 * @var $form CActiveForm
 */

?>
<div class="upladaapBoxBg mgtop20 ">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createAbsoluteUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <div class="upladBox_1">
        <b class="mgleft20"><?php echo Yii::t('memberWealth', '关键词'); ?>：</b><?php echo $form->textField($model, 'remark', array('class' => 'integaralIpt4 mgright15')); ?>
        <b><?php echo Yii::t('memberWealth', '起止时期'); ?>：</b>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'create_time',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'class' => 'integaralIpt5',
            )
        ));
        ?>  -  <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'endTime',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'class' => 'integaralIpt5 mgright15',
            )
        ));
        ?>
        <?php echo CHtml::submitButton(Yii::t('memberWealth','搜索'), array('class' => 'searchBtn searchBtnright')); ?>
    </div>
    <div class="upladBox_1 mgtop10 mgleft20">
        <dt><?php echo Yii::t('memberWealth', '明细来源'); ?>：</dt>
        <dd>
            <?php
            $sourceArr = $model::getOperateType();
            $sourceArr = array_reverse($sourceArr,true);
            $sourceArr[''] = Yii::t('memberWealth','全部');
            $sourceArr = array_reverse($sourceArr,true)
            ?>
            <?php echo $form->radioButtonList($model, 'operate_type', $sourceArr, array('separator' => '', 'class' => 'mgleft14')); ?>
        </dd>
    </div>
    <?php $this->endWidget(); ?>
</div>