<?php
// 编辑加盟商视图
$this->breadcrumbs = array(
		Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    	Yii::t('sellerFranchisee', '盖网机列表') => array('/seller/franchisee/machineList'),
		Yii::t('sellerFranchisee', '盖网机积分消费信息'),
);
?>

<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchisee', '盖网机积分消费信息');?></b>
	<span><?php echo Yii::t('sellerFranchisee','盖网机积分消费信息。');?></span>
</div>


<?php $this->renderPartial('_machine_search',array('model'=>$model));?>


<div class="seachToolbar">
<input type="button" onclick="javascript:history.go(-1);" class="sellerBtn06" value="<?php echo Yii::t('sellerFranchisee','返回');?>">
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody>
		<tr>
			<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee','盖机名称');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','会员编号');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','会员手机号');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','对账状态');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','消费金额');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','消费时间');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','分配金额');?></th>
			<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','操作');?></th>
			
		</tr>
		
		<?php foreach ($lists_data as $data):?>
		
		<?php 
			if ($data->symbol == 'HKD'){
				$spend_money = "HK$".Tool::currency($data->spend_money);
				$distribute_money = "HK$".Tool::currency($data->distribute_money);
			}else{
				$spend_money = "￥".$data->spend_money;
				$distribute_money = "￥".$data->distribute_money;
			}
		?>
		<tr class="even">
			<td class="ta_c"><?php echo $m_info->name;?></td>
			<td class="ta_c"><?php echo !empty($data->member)?$data->member->gai_number:'';?></td>
			<td class="ta_c"><?php echo !empty($data->member)?$data->member->mobile:'';?></td>
			<td class="ta_c"><?php echo FranchiseeConsumptionRecord::getCheckStatus($data->status);?></td>
			<td class="ta_c"><?php echo $spend_money;?></td>
			<td class="ta_c"><?php echo date('Y-m-d G:i:s',$data->create_time);?></td>
			<td class="ta_c"><?php echo $distribute_money;?></td>
			
			<td class="ta_c">
				<a onclick="openInfoDialog(<?php echo $data->id?>)" href="javascript:"><?php echo Yii::t('sellerFranchisee', '【查看详情】')?></a>
			</td>
		</tr>
		
		
		<?php endforeach;?>
		
		
</tbody></table>
<div class="page_bottom clearfix">
	<div class="pagination">

		
<?php
  $this->widget('CLinkPager',array(   //此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
    'header'=>'',
    'prevPageLabel' => Yii::t('page','上一页'),
    'nextPageLabel' => Yii::t('page','下一页'),
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

<script>

function openInfoDialog(id){
	var myDialog = art.dialog({'id': 'consumptionRecordInfo', title: '<?php echo Yii::t('sellerFranchisee','消费详细');?>', lock: true});// 初始化一个带有loading图标的空对话框
	jQuery.ajax({
	    url: '<?php echo Yii::app()->createUrl('/seller/franchisee/machineConsumptionRecordInfo/');?>?id='+id,
	    success: function (data) {
	        myDialog.content(data);// 填充对话框内容
	    }
	});
}
</script>









