<div class="c10"></div>
<div id="special-topic-grid" class="grid-view">
  <table class="tab-reg">
    <thead>
      <tr>
        <th><?php echo $labels['name'];?></th>
        <th><?php echo $labels['date'];?></th>
        <th><?php echo $labels['time'];?></th>
        <th><?php echo $labels['singup_start_time'];?></th>
        <th><?php echo $labels['singup_end_time'];?></th>
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
      <td><?php echo $model->getRulesTime($v['id']);?></td>
      <td><?php echo $model->getRulesTime($v['id'],1);?></td>
      <td><?php echo $v['singup_start_time']?></td>
      <td><?php echo $v['singup_end_time'];?></td>
      <td style="color:#000;">
        <?php if ($this->getUser()->checkAccess('SecondKillActivity.Seting')){ ?>
        <a class="update" href="<?php echo Yii::app()->createUrl('secondKillActivity/SeckillAdmin', array('rules_id'=>$v['id'], 'category_id'=>$model->categoryId, 'status'=>$model->status));?>"><?php echo Yii::t('home', '活动详情');?></a>
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
    <div class="summary">共<?php echo $pages->pageCount;?>页/跳转到 <input onkeydown="if(event.keyCode==13) {window.location='<?php echo Yii::app()->createUrl('secondKillActivity/SeckillAdmin', array('id'=>$v['id'], 'category_id'=>$model->categoryId, 'status'=>$model->status));?>&page='+this.value; return false;}" title="输入要跳转的页数,然后回车" size="3"> 页</div>
  <?php }?>
  </div> 
</div>