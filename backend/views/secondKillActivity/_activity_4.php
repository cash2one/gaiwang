<?php
if(!$this->getUser()->checkAccess('SecondKillActivity.Seting')){
	$this->setFlash('error', Yii::t('secondKillActivity','您没有被授权执行该操作。') );
	$this->redirect(array('SeckillAdmin', 'category_id'=>$model->categoryId));
}
?>
<div id="special-topic-grid" class="grid-view">
  <table class="tab-reg">
    <thead>
      <tr>
        <th><?php echo $labels['time'];?></th>
        <th><?php echo $labels['mp'];?></th>
        <th><?php echo $labels['buy_limit'];?></th>
        <th><select id="search_status" onchange="changeStatus(this.value, <?php echo $model->rulesId;?>);"><option value="0">全部状态</option>
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
          $class    = ($k%2 == 0) ? 'odd' : 'even';
		  $discount = $v['discount_rate']>0 ? "商品打折： ".number_format($v['discount_rate']/10,1,'.','')."折" : "限定价格： ". number_format($v['discount_price'],2,'.','')."元"; 
	?>
    <tr class="<?php echo $class;?>">
      <td><?php echo $v['start_time'].' - '.$v['end_time'];?></td>
      <td><?php echo $discount;?></td>
      <td><?php echo $v['buy_limit']>0 ? $v['buy_limit'] : '不限';?></td>
      <td><?php echo $model->getStatusArray($v['status']);?></td>
      <td style="color:#000;">
      <?php if ($this->getUser()->checkAccess('SecondKillActivity.Product3')){ ?>  
        <a href="<?php echo Yii::app()->createUrl('secondKillActivity/product3', array('category_id'=>$model->categoryId, 'rules_seting_id'=>$v['rules_seting_id'], 'rules_id'=>$v['id']));?>"><?php echo $labels['product_number'];?>(<?php echo $model->getRulesProductNumber($v['rules_seting_id']);?>/<?php echo $v['limit_num'];?>)</a> <br/>
      <?php }?>
        
      <?php if ($this->getUser()->checkAccess('SecondKillActivity.Update3')){ ?>
        <a class="update" href="<?php echo Yii::app()->createUrl('secondKillActivity/update3', array('rules_id'=>$v['id'], 'category_id'=>$model->categoryId, 'rules_seting_id'=>$v['rules_seting_id']));?>"><?php echo Yii::t('home', '秒杀设置');?></a><br/> 
      <?php }?>
        
		<?php if($v['status'] ==1 && $this->getUser()->checkAccess('SecondKillActivity.Start3')){?>
        <a href="javascript:;" onclick="showConfirmDiv(0, <?php echo $v['rules_seting_id'];?>);"><?php echo $labels['start_activity'];?></a>
        <?php }else if(($v['status'] == 2 || $v['status'] == 3) && $this->getUser()->checkAccess('SecondKillActivity.Stop3')){?>
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
    <div class="summary">共<?php echo $pages->pageCount;?>页/跳转到 <input onkeydown="if(event.keyCode==13) {window.location='<?php echo Yii::app()->createUrl('secondKillActivity/SeckillAdmin', array('id'=>$v['id'], 'category_id'=>$model->categoryId, 'status'=>$model->status, 'rules_id'=>$model->rulesId));?>&page='+this.value; return false;}" title="输入要跳转的页数,然后回车" size="3"> 页</div>
  <?php }?>
  </div> 
</div>