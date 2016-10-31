<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $v Comment */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#comment-grid').yiiGridView('update', {
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

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg" id="tab1">
    <tbody>
        <tr class="tab-reg-title">
            <th>
                <?php echo Yii::t('comment', '订单号'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '商铺名称'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '商品名称'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '会员号'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '商品描述评价'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '服务态度评价'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '发货速度评价'); ?>
            </th>

            <th>
                <?php echo Yii::t('comment', '评价时间'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '可见状态'); ?>
            </th>
            <th>
                <?php echo Yii::t('comment', '操作'); ?>
            </th>
        </tr>
        <?php foreach ($comments as $v): ?>
        <tr>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->order_id ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->store_id ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo CHtml::link($v->goods_name,DOMAIN."/JF/{$v->goods_id}.html",array("target"=>'_blank'));  ?>
                <?php if (!empty($v->spec_value)): ?>(
                    <?php foreach (unserialize($v->spec_value) as $ksp => $vsp): ?>
                        <?php echo $ksp . ': ' . $vsp ?>
                    <?php endforeach; ?>)
                <?php endif; ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->member_id ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->description_math ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->service_attitude ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $v->speed_of_delivery ?>
            </td>

            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $this->format()->formatDatetime($v->create_time) ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <span style="color:<?php echo $v->status ? 'red' : '#ccc' ?>">
                    <?php echo $v::status($v->status) ?>
                </span>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php if ($this->getUser()->checkAccess('Comment.ChangeStatus')): ?>
                    <?php
                    echo CHtml::ajaxLink('[切换状态]', $this->createUrl('comment/changeStatus', array('id' => $v->id)), array(
                        'success' => 'function(){location.reload()}',
                    ))
                    ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td colspan="10" style="background: none repeat scroll 0% 0% rgb(238, 238, 238);text-align: left;padding:15px;">
                <span><?php echo Yii::t('comment', '用户评论'); ?>:&nbsp;</span>
                <?php echo CHtml::encode($v->content); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($comments)): ?>
        <tr><td class="empty" colspan="13"><span class="empty">没有找到数据.</span></td></tr>
    <?php else: ?>
        <tr>
            <td colspan="10">
                <div class="pager" >
                    <?php
                    $this->widget('LinkPager', array(
                        'ajax' => false,
                        'pages' => $pages,
                    ))
                    ?>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>


<?php
/*
  $this->widget('GridView', array(
  'id'=>'comment-grid',
  'itemsCssClass' => 'tab-reg',
  'dataProvider'=>$model->search(),
  'columns'=>array(
  array(
  'name'=>'order_id',
  'header'=>Yii::t('comment','订单号')
  ),
  array(
  'name'=>'store_id',
  'header'=>Yii::t('comment','店铺名称')
  ),
  'goods_id',

  'member_id',
  'score',
  array(
  'name'=>'content',
  'htmlOptions'=>array('colspan'=>'10')
  )

  'content',
  'create_time',
  'status',


  ),
  ));
 */
?>
