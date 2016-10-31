<?php
/** @var $this SellerLogController */
/** @var $model  SellerLog */
$this->breadcrumbs = array(
    Yii::t('sellerLog', '店小二管理'),
    Yii::t('sellerLog', '操作日志'),
);
?>
<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo Yii::t('sellerLog','系统操作日志'); ?></h3>
    </div>
    <div class="seachToolbar">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
        )); ?>
        <table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
            <tbody>
            <tr>

                <td>
                    <th width="8%"><?php echo Yii::t('sellerLog','会员名称'); ?>：</th>
                <td>
                    <?php echo $form->textField($model,'member_name',array('style'=>'width:230px;','class'=>'inputtxt1')); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo CHtml::submitButton(Yii::t('sellerLog','搜索'),array('class'=>'sellerBtn06')) ?>
                </td>
                </td>
            </tr>
            </tbody>
        </table>
        <?php $this->endWidget(); ?>

    </div>

    <?php
    $memberId = $this->getSession('assistantId') ? $this->getSession('assistantId') : $this->getUser()->id;
    $this->widget('GridView', array(
        'id'=>'assistant-grid',
        'dataProvider'=>$model->search($memberId),
        'itemsCssClass' => 'mt15 sellerT3 goodsIndex',
        'cssFile'=>false,
        'pager'=>array(
            'class'=>'LinkPager',
            'htmlOptions'=>array('class'=>'pagination'),
        ),
        'pagerCssClass'=>'page_bottom clearfix',
        'columns'=>array(
            'member_name',
            'title',
            array('name'=>'type_id','value'=>'SellerLog::showType($data->type_id)'),
            array('name'=>'create_time','type'=>'dateTime'),
        ),
    )); ?>

</div>