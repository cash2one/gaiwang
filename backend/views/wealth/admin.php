<?php
/** @var $this WealthController */
/** @var $wealth CActiveDataProvider */
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>

<div class="c10">
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-reg">
    <thead>
        <tr class="tab-reg-title">
            <th>
                <?php echo Yii::t('wealth', '拥有者'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '拥有者类型'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '收入类型'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '积分'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '金额'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '积分来源'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '状态'); ?>
            </th>
            <th>
                <?php echo Yii::t('wealth', '创建时间'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php /** @var $v Wealth */ ?>
        <?php foreach ($wealth->getData() as $v): ?>
            <tr>
                <td>
                    <?php echo $v->gai_number ?>
                </td>
                <td>
                    <?php echo $v::getOwner($v->owner) ?>
                </td>
                <td>
                    <?php echo $v::showType($v->type_id) ?>
                </td>
                <td>
                    <span class="jf"><?php echo $v->score ?></span>
                </td>
                <td>
                    <span class="jf">&#165; <?php echo $v->money ?></span>
                </td>
                <td>
                    <?php echo $v::showSource($v->source_id) ?>
                </td>
                <td>
                    <?php echo $v::getStatus($v->status) ?>
                </td>
                <td>
                    <?php echo $this->format()->formatDatetime($v->create_time) ?>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <?php echo $v->content ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="8" style="text-align: center" class="pag">
                <div class="pager">
                    <?php
                    /** @var $pages CPagination */
                    $summaryText = '第 {start}-{end} 条 / 共 {count} 条 / {pages} 页';
                    $summaryText = strtr($summaryText, array(
                        '{start}' => $wealth->pagination->offset + 1,
                        '{end}' => ($wealth->pagination->currentPage + 1) * $wealth->pagination->limit,
                        '{count}' => $wealth->pagination->itemCount,
                        '{pages}' => $wealth->pagination->pageCount,
                    ));
                    ?>
                    <?php echo $summaryText ?>
                    <?php
                    $this->widget('LinkPager', array(
                        'pages' => $wealth->pagination,
                        'jump' => false,
                    ))
                    ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>


<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>