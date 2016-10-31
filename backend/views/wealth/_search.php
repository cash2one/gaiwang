<?php
/* @var $this WealthController */
/* @var $model Wealth */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','拥有者'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'gai_number',array('class'=>'text-input-bj  least')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','备注'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'content',array('class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','积分'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'score',array('class'=>'text-input-bj least')); ?>
            </td>
            <td>
                -
            </td>
            <td>
                <?php echo $form->textField($model,'endScore',array('class'=>'text-input-bj least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','金额'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'money',array('class'=>'text-input-bj least')); ?>
            </td>
            <td>
                -
            </td>
            <td>
                <?php echo $form->textField($model,'endMoney',array('class'=>'text-input-bj least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','拥有者类型'); ?>：
            </th>
            <td id="tdOwner">
                <?php echo $form->radioButtonList($model,'owner',$model::getOwner(),
                    array('separator'=>'','empty'=>Yii::t('wealth','全部'))); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','收入类型'); ?>：
            </th>
            <td id="tdIncomeType">
                <?php
                $typeArr = $model::getType();
                $typeArr = array_reverse($typeArr,true);
                $typeArr[''] = Yii::t('wealth','全部');
                $typeArr = array_reverse($typeArr,true)
                ?>
                <?php echo $form->radioButtonList($model,'type_id',$typeArr,array('separator'=>'')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" style="width:100%; height:auto; clear:both" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','积分来源'); ?>：
            </th>
            <td style="width:100%; text-align:left;white-space: normal; line-height:25px;" id="tdIncomeSource">
                <?php
                $sourceArr = $model::getSource();
                $sourceArr = array_reverse($sourceArr,true);
                $sourceArr[''] = Yii::t('wealth','全部');
                $sourceArr = array_reverse($sourceArr,true)
                ?>
                <?php echo $form->radioButtonList($model,'source_id',$sourceArr,array('separator'=>'')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th>
                <?php echo Yii::t('wealth','状态'); ?>：
            </th>
            <td id="tdStatus">
                <?php
                $statusArr = $model::getStatus();
                $statusArr = array_reverse($statusArr,true);
                $statusArr[''] = Yii::t('wealth','全部');
                $statusArr = array_reverse($statusArr,true)
                ?>
                <?php echo $form->radioButtonList($model,'status',$statusArr,array('separator'=>'')); ?>
            </td>
        </tr>
        </tbody></table>
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton(Yii::t('wealth','搜索'),array('class'=>'reg-sub')) ?>
</div>
<?php $this->endWidget() ?>