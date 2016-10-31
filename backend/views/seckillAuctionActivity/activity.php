<div class="c10"></div>
<div id="second-kill-grid" class="grid-view">
  <table class="tab-reg">
    <thead>
      <tr>
        <th><?php echo $labels['name'];?></th>
        <th><?php echo $labels['sort'];?></th>
        <th><?php echo $labels['start_time'];?></th>
        <th><?php echo $labels['end_time'];?></th>
        <th><select id="search_status" onchange="changeStatus(this.value,0);"><option value="0">全部状态</option>
          <?php foreach($model->getStatusArray() as $k=>$v){?>
		  <option value="<?php echo $k;?>" <?php if($model->status == $k){echo 'selected="selected"';}?>><?php echo $v;?></option>
          <?php }?>	  
		</select></th>
        <th><?php echo Yii::t('home', '操作');?></th>
      </tr>
    </thead>
    <tbody>
    <?php if($dataProvider){ 
	  foreach($dataProvider as $k=>$v){
          $class = ($k%2 == 0) ? 'odd' : 'even';
	?>
    <tr class="<?php echo $class;?>">
      <td><?php echo $v['name'];?></td>
      <td><?php echo $v['sort']==99999 ? 0 : $v['sort'];?></td>
      <td><?php echo $v['date_start'].' '.$v['start_time'];?></td>
      <td><?php echo $v['date_end'].' '.$v['end_time'];?></td>
      <td><?php echo $model->getStatusArray($v['status']);?></td>
      <td style="color:#000;">
        <?php if ($this->getUser()->checkAccess('SeckillAuctionActivity.SeckillAuctionUpdate')){ ?>
          <a class="update" href="<?php echo Yii::app()->createUrl('/seckillAuctionActivity/SeckillAuctionUpdate', array('rules_id'=>$v['id'], 'category_id'=>$model->categoryId, 'rules_seting_id'=>$v['rules_seting_id']));?>"><?php echo Yii::t('home', '查看详情');?></a><br/>
        <?php }?>

		<?php if($v['status'] ==1 && $this->getUser()->checkAccess('SeckillAuctionActivity.Start')){?>
        <a href="javascript:;" onclick="showConfirmDiv(0, <?php echo $v['rules_seting_id'];?>);"><?php echo $labels['start_activity'];?></a>
        <?php }else if(($v['status'] == 2 || $v['status'] == 3) && $this->getUser()->checkAccess('SeckillAuctionActivity.Stop')){?>
        <a href="javascript:;" onclick="showConfirmDiv(1, <?php echo $v['rules_seting_id'];?>);"><?php echo $labels['stop_activity'];?></a>
      <?php } ?>  
    </td>
    </tr>
    <?php }}?>
    </tbody>
  </table>
  
  <div class="pager">
   <?php $this->widget('CLinkPager',array('pages'=>$pages,
    'header' => '',
	'cssFile' => Yii::app()->baseUrl."/css/reg.css",
    'firstPageLabel' => '首 页',
    'lastPageLabel' => '尾 页',
    'prevPageLabel' => '上一页',
    'nextPageLabel' => '下一页',
	'maxButtonCount' => 10,  
  ));?>
  <?php if($pages->pageCount > 1){?> 
    <div class="summary">共<?php echo $pages->pageCount;?>页/跳转到 <input onkeydown="if(event.keyCode==13) {window.location='<?php echo Yii::app()->createUrl('/SeckillAuctionActivity/SeckillAuctionAdmin', array('id'=>$v['id'], 'category_id'=>$model->categoryId, 'status'=>$model->status));?>&page='+this.value; return false;}" title="输入要跳转的页数,然后回车" size="3"> 页</div>
  <?php }?>
  </div> 
</div>