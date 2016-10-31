<?php
/* @var $this CommonAccountAgentDistController */
/* @var $model CommonAccountAgentDist */

$this->breadcrumbs = array(
    Yii::t('commonAccountAgentDist', '代理管理'),
    Yii::t('commonAccountAgentDist', '代理账户分配金额记录'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#common-account-agent-dist-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<div class="grid-view">
    <table width="100%" cellspacing="1" cellpadding="0" border="0" class="tab-reg">
        <tr class="tab-reg-title">
            <th>
                <b>账户名称</b>
            </th>
            <th>
                <b>分配金额</b>
            </th>
            <th>
                <b>资金池金额</b>
            </th>
            <th>
                <b>分配时间</b>
            </th>
        </tr>
        <?php foreach ($datas as $data): ?>
            <tr>
                <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                    <?php echo $data->common_account->name ?>
                </td>
                <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);"><span class="jf">¥<?php echo $data->dist_money ?></span>
                </td>
                <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);"><span class="jf">¥<?php echo $data->remainder_money ?></span>
                </td>
                <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);"><?php echo date('Y-m-d H:i:s', $data->create_time); ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="background: none repeat scroll 0% 0% rgb(238, 238, 238);">
         
                     <?php if (!empty($data->manage_member_id) && !empty($data->manage)): ?>
                        <?php echo Yii::t('commonAccountAgentDist', '大区') ?>：<?php echo $data->manage->name ?> <?php echo Yii::t('commonAccountAgentDist', '代理会员') ?>
                        <span class="hy"><?php echo $data->member_manage->gai_number ?></span><?php echo Yii::t('commonAccountAgentDist', '获得金额') ?><span class="hy">¥<?php echo $data->manage_money ?></span> <?php echo Yii::t('commonAccountAgentDist', '实占比率') ?><?php echo $data->manage_ratio ?> %。
                    <?php endif; ?>
                    <?php if (!empty($data->province_member_id) && !empty($data->province)): ?>
                        <?php echo Yii::t('commonAccountAgentDist', '省级') ?>：<?php echo $data->province->name ?> <?php echo Yii::t('commonAccountAgentDist', '代理会员') ?>
                        <span class="hy"><?php echo $data->member_province->gai_number ?></span><?php echo Yii::t('commonAccountAgentDist', '获得金额') ?><span class="hy">¥<?php echo $data->province_money ?></span> <?php echo Yii::t('commonAccountAgentDist', '实占比率') ?><?php echo $data->province_ratio ?> %。
                    <?php endif; ?>
                    <?php if (!empty($data->city_member_id) && !empty($data->city)): ?>
                            <?php echo Yii::t('commonAccountAgentDist', '市级') ?>：<?php echo $data->city->name ?> <?php echo Yii::t('commonAccountAgentDist', '代理会员') ?>
                        <span class="hy"><?php echo $data->member_city->gai_number ?></span><?php echo Yii::t('commonAccountAgentDist', '获得金额') ?><span class="hy">¥<?php echo $data->city_money ?></span> <?php echo Yii::t('commonAccountAgentDist', '实占比率') ?><?php echo $data->city_ratio ?> %。
                    <?php endif; ?>
                    <?php if (!empty($data->district_member_id) && !empty($data->district)): ?>
                            <?php echo Yii::t('commonAccountAgentDist', '区/县级') ?>：<?php echo $data->district->name ?> <?php echo Yii::t('commonAccountAgentDist', '代理会员') ?>
                        <span class="hy"><?php echo $data->member_district->gai_number ?></span><?php echo Yii::t('commonAccountAgentDist', '获得金额') ?><span class="hy">¥<?php echo $data->district_money ?></span> <?php echo Yii::t('commonAccountAgentDist', '实占比率') ?><?php echo $data->district_ratio ?> %。
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="summary">第 <?php echo $pages->offset + 1 ?>-<?php echo ($pages->offset + 1) + $pages->pageSize - 1 ?> 条 / 共 <?php echo $pages->getItemCount() ?> 条 /  <?php echo $pages->getPageCount() ?> 页</div>
    <div class="pager">
        <?php
        $this->widget('LinkPager', array(
            'ajax' => false,
            'pages' => $pages,
                )
        );
        ?>
    </div>
</div>


<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>