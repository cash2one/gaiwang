<?php
// 编辑加盟商视图
$this->breadcrumbs = array(
		Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    	Yii::t('sellerFranchisee', '盖网机列表') => array('/seller/franchisee/machineList'),
		Yii::t('sellerFranchisee', '盖网机签到记录'),
);

?>

<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchisee', '盖网机签到记录');?></b>
	<span><?php echo Yii::t('sellerFranchisee', '盖网机签到记录。');?></span>
</div>

<?php $this->renderPartial('_machine_search',array('model'=>$model));?>


<div class="seachToolbar">
<input type="button" onclick="javascript:history.go(-1);" class="sellerBtn06" value="<?php echo Yii::t('sellerFranchisee', '返回');?>">
</div>


<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody>
		<tr>
			<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee', '盖机名称');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '会员编号');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '签到时间');?></th>
			<th class="bgBlack" width="10%">IP</th>
		</tr>
		
		
		<?php foreach ($lists_data as $data):?>
		
		
		<tr class="even">
			<td class="ta_c"><?php echo $m_info->name;?></td>
			<td class="ta_c"><?php echo !empty($data->member)?$data->member->gai_number:'';?></td>
			<td class="ta_c"><?php echo date(Yii::t('sellerFranchisee','Y-m-d G:i:s'),$data->create_time);?></td>
			<td class="ta_c"><?php echo Tool::number2ip($data->ip);?></td>
		</tr>
		
		
		<?php endforeach;?>
		
		
</tbody></table>
<div class="page_bottom clearfix">
	<div class="pagination">

		
<?php
  $this->widget('CLinkPager',array(   //此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
    'header'=>'',
    'prevPageLabel' => Yii::t('page', '上一页'),
    'nextPageLabel' => Yii::t('page', '下一页'),
    'pages' => $pager,       
    'maxButtonCount'=>10,    //分页数目
    'htmlOptions'=>array(
       'class'=>'paging',   //包含分页链接的div的class
     )
  )
  );
?>
		
	</div>
</div>

