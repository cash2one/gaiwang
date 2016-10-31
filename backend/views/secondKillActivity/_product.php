<div id="second-kill-grid" class="grid-view">
  <table class="tab-reg">
    <thead>
      <tr>
        <th><?php echo $labels['product_name'];?></th>
        <th><?php echo $labels['product_id'];?></th>
        <th><?php echo $labels['seller_name'];?></th>
        <th><?php echo $labels['price'];?></th>
        <th><?php echo $labels['stock'];?></th>
      </tr>
    </thead>
    
    <tbody>
    <?php if($dataProvider){
	  foreach($dataProvider as $k=>$v){
		  $activity  = $model->getPriceStock($v['rules_seting_id'], $v['product_id']);
          $class = ($k%2 == 0) ? 'odd' : 'even';
	?>
    <tr class="<?php echo $class;?>">
      <td title="<?php echo $v['product_name'];?>"><a href="<?php echo DOMAIN.'/JF/'.$v['product_id'].'.html';?>" target="_blank"><?php echo $model->cutstr($v['product_name'], 26);?></a></td>
      <td><?php echo $v['product_id'];?></td>
      <td title="<?php echo $v['seller_name'];?>"><?php echo $model->cutstr($v['seller_name'], 24);?></td>
      <td><?php echo $activity['price'];?></td>
      <td><?php echo $activity['stock'];?></td>
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
    <div class="summary">共<?php echo $pages->pageCount;?>页/跳转到 <input onkeydown="if(event.keyCode==13) {window.location='<?php echo Yii::app()->createUrl('secondKillActivity/product'.$model->categoryId, array('category_id'=>$model->categoryId, 'rules_seting_id'=>$model->rulesSetingId));?>&page='+this.value; return false;}" title="输入要跳转的页数,然后回车" size="3"> 页</div>
  <?php }?>
  </div> 
</div>