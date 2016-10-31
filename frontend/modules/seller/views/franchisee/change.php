<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '切换加盟商') => array('/seller/franchisee/change')
);
?>
<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchisee', '切换加盟商');?></b>
	<span><span class="red"><?php echo Yii::t('sellerFranchisee', '当前加盟商：');?><?php echo $curr_franchiess['name']?></span></span>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th width="20%" class="bgBlack"><?php echo Yii::t('sellerFranchisee', '名称');?></th>
			<th width="30%" class="bgBlack"><?php echo Yii::t('sellerFranchisee', '编号');?></th>
			<th width="30%" class="bgBlack"><?php echo Yii::t('sellerFranchisee', '电话');?></th>
			<th width="20%" class="bgBlack"><?php echo Yii::t('sellerFranchisee', '操作');?></th>
		</tr>
		
		<?php $i = 1; ?>
		<?php foreach ($franchisees as $franchisee): ?>
		
		<tr <?php if ($i % 2 == 0): ?>class="even"<?php endif; ?>>
			<td class="ta_c"><?php echo $franchisee['name'];?></td>
			<td class="ta_c"><?php echo $franchisee['code'];?></td>
			<td class="ta_c"><?php echo $franchisee['mobile'];?></td>
			<td class="ta_c">
			<?php if ($franchisee['id']==$curr_franchiess['id']):?>
				<b class="red"><?php echo Yii::t('sellerFranchisee', '当前选定加盟商');?></b>								
			<?php else: ?>
				<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/change',array('franchisee_id'=>$franchisee['id']));?>" class="sellerBtn03"><span><?php echo Yii::t('sellerFranchisee', '切换');?></span></a>
			<?php endif;?>
			</td>
		</tr>
		<?php $i++; ?>
		<?php endforeach;?>
		
</tbody></table>

			