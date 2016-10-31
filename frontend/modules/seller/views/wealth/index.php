<?php
/* @var $this WealthController */
/* @var $model Wealth */

$this->breadcrumbs = array(
    Yii::t('wealth', '交易管理'),
    Yii::t('wealth', '账单明细'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#wealth-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="mainContent">
    <div class="toolbar">
        <b><?php echo Yii::t('wealth', '账单明细');?></b>
        <span><?php echo Yii::t('wealth', '客户新订单明细列表查询。');?></span>
    </div>
    <div class="seachToolbar">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createAbsoluteUrl($this->route),
            'method' => 'get',
        ));
        ?>
        <table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
            <tbody>
                <tr>
                    <td>
                        <?php echo Yii::t('wealth', '账单时间：');?>
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
                                'class' => 'inputtxt1',
                                'style' => 'width:225px;'
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
                                'class' => 'inputtxt1',
                                'style' => 'width:225px;'
                            )
                        ));
                        ?>
                        <?php echo CHtml::submitButton(Yii::t('wealth', '搜索'), array('class' => 'sellerBtn06')); ?>
                        <!--<input type="button" class="sellerBtn07" value="导出EXCEL">-->
                    </td>
                </tr>
            </tbody>
        </table>
        <?php $this->endWidget(); ?>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
        <tbody>
            <tr>
                <th width="15%" class="bgBlack"><?php echo Yii::t('wealth', '订单号');?></th>
                <th width="15%" class="bgBlack"><?php echo Yii::t('wealth', '账单时间');?></th>
                <th width="15%" class="bgBlack"><?php echo Yii::t('wealth', '金额');?></th>
                <th width="55%" class="bgBlack"><?php echo Yii::t('wealth', '备注');?></th>
            </tr>
            <?php if ($accountFlowData = $accountFlow->getData()): ?>
                <?php $i = 1; ?>
                <?php foreach ($accountFlowData as $wealth): ?>
                    <tr <?php if ($i % 2 == 0): ?>class="even"<?php endif; ?>>
                        <td class="ta_c"><?php echo $wealth->order_code ?></td>
                        <td class="ta_c"><?php echo date('Y-m-d H:i:s', $wealth->create_time); ?></td>
                        <td class="ta_c"><b><?php echo HtmlHelper::formatPrice($wealth->credit_amount); ?></b></td>
                        <td class="ta_c"><?php echo AccountFlow::formatContent($wealth->remark); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="empty"><span><?php echo Yii::t('wealth', '没有找到数据'); ?>.</span></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="page_bottom clearfix">
        <div class="pagination">
            <?php
            $this->widget('CLinkPager', array(
                'header' => '',
                'cssFile' => false,
                'firstPageLabel' => Yii::t('page', '首页'),
                'lastPageLabel' => Yii::t('page', '末页'),
                'prevPageLabel' => Yii::t('page', '上一页'),
                'nextPageLabel' => Yii::t('page', '下一页'),
                'maxButtonCount' => 13,
                'pages' => $accountFlow->pagination
            ));
            ?>  
        </div>	
    </div>
</div>