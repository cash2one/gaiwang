<?php
/* @var $this GameStoreItemsController */
/* @var $model GameStoreItems */
/* @var $form CActiveForm */
?>
<div class="seachToolbar">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT5">
        <tr >
            <th width="15%" ><p style="width:115px;text-align:center;" ><?php echo Yii::t('GameStoreItems', '查询日期：')?></p></th>
            <td width="30%">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                    'model' => $model,
//                    'attribute' => 'create_time',
                    'name'=>'time',
                    'value' => $time,
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                        'class' => 'inputtxt1',
                        'style' => 'width:45%'
                    )
                ));
                ?></td>
            <td width="55%"><?php echo CHtml::submitButton(Yii::t('GameStoreItems', '搜索'), array('class' => 'sellerBtn06')); ?></td>
        </tr>
        <tr style="line-height: 43px; height: 43px;">
            <th style="width: 15%;text-align:center;"><?php echo Yii::t('GameStore', '当前日期:')?>&nbsp;<span><?php echo $searchTime;?></span></th>
            <td style="width: 30%; color: #313131;font-size: 12px; font-weight: bold;"><?php echo Yii::t('GameStore', '当天总流水：')?>&nbsp;<span><?php echo !empty($todayFlow) ? $todayFlow : 0;?></span></td>
            <td style="width: 55%;color: #313131;font-size: 12px; font-weight: bold;"><?php echo Yii::t('GameStore', '当月总流水：')?>&nbsp;<span><?php echo !empty($monthFlow) ? $monthFlow : 0;?></span></td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>
</div>