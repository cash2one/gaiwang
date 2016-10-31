<?php
/* @var $this CityshowController */
/* @var $model Cityshow */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>
    <div class="border-info clearfix">
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right">
                    <?php echo Yii::t('cityshow', '城市馆名称'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model, 'title', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right">
                    <?php echo Yii::t('cityshow', '审核状态'); ?>：
                </th>
                <td>
                    <?php echo $form->dropDownList($model, 'status', Cityshow::getStatus(),array( 'prompt'=>'全部','class' => 'text-input-bj')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right">
                    <?php echo Yii::t('source_type', '适用平台'); ?>：
                </th>
                <td>
                    <?php echo $form->dropDownList($model, 'source_type', Cityshow::getSourceType(),array('prompt'=>'全部','class' => 'text-input-bj')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right">
                    <?php echo Yii::t('cityshow', '大区'); ?>：
                </th>
                <td>
                    <?php echo $form->dropDownList($model, 'region', CityshowRegion::getShowCityRegion(null),array( 'prompt'=>'全部','class' => 'text-input-bj')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
                <th>
                    <?php echo $form->label($model,'日期'); ?>：
                </th>
                <td>
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'create_time',
                    ));
                    ?>  -  <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'end_time',
                    ));
                    ?>
                </td>
            </tr>
            </tbody></table>
        <?php echo CHtml::submitButton(Yii::t('cityshow', '搜索'), array('class' => 'reg-sub')) ?>
    </div>

<?php $this->endWidget(); ?>