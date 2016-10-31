<?php
// 编辑加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '文章列表') => array('/seller/franchisee/artile')
);


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-artile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>

<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchisee', '文章列表');?></b>
	<span><?php echo Yii::t('sellerFranchisee', '店铺文章页面的列表展示。');?></span>
</div>


<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
?>
<div class="seachToolbar">
	<table width="60%" border="0" cellspacing="0" cellpadding="0" class="sellerT5">
		<tr>
				<th width="10%"><?php echo $form->label($model, 'title'); ?>：</th>
				<td width="30%">
					<?php echo $form->textField($model, 'title', array('class' => 'inputtxt1','style'=>'width:90%;')); ?>
				</td>
				<td width="60%"><input type="submit" class="sellerBtn06" value="<?php echo Yii::t('sellerFranchisee', '搜索');?>"/></td>
		</tr>
	</table>
</div>
<?php $this->endWidget(); ?>

<a class="mt15 btnSellerAdd" href="<?php echo Yii::app()->createUrl('/seller/franchisee/artileAdd')?>" ><?php echo Yii::t('sellerFranchisee', '添加文章')?></a>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th class="bgBlack" width="30%"><?php echo Yii::t('sellerFranchisee', '文章标题');?></th>
			<th class="bgBlack" width="45%"><?php echo Yii::t('sellerFranchisee', '创建时间');?></th>
			<th class="bgBlack" width="25%"><?php echo Yii::t('sellerFranchisee', '操作');?></th>
		</tr>
		
		
		<?php foreach ($lists_data as $data):?>
		
		
		<tr class="even">
			<td class="ta_c"><?php echo $data->title;?></td>
			<td class="ta_c"><?php echo date('Y-m-d G:i:s',$data->create_time);?></td>
			<td class="ta_c">
				<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/artileEdit/',array('id'=>$data->id));?>" class="sellerBtn03"><span><?php echo Yii::t('sellerFranchisee', '编辑');?></span></a>
				&nbsp;&nbsp;
				<a href="javascript:void(0);" url="<?php echo Yii::app()->createUrl('/seller/franchisee/artileDel/',array('id'=>$data->id));?>" onclick="artile_del(this)" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee', '删除');?></span></a>
			</td>
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

<script>
	function artile_del(obj){
		if(confirm('<?php echo Yii::t('sellerFranchisee', '确定要删除吗？');?>')){
			window.location.href=$(obj).attr('url');
		}
	}

</script>
				
