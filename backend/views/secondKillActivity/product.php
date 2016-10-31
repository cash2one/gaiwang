<?php
$titleNumber = $model->getTitleNumber($model->rulesSetingId);
$adminAct = $model->categoryId == 1 ? 'RedAdmin' : ( $model->categoryId == 2 ? 'FestiveAdmin' :'SeckillAdmin');

if(!$this->getUser()->checkAccess('SecondKillActivity.Product'.$model->categoryId)) {
	$this->setFlash('error', Yii::t('secondKillActivity','您没有被授权执行该操作。') ); 
    $this->redirect(array($adminAct, 'category_id'=>$model->categoryId));
}
?>
<a class="regm-sub" href="<?php echo Yii::app()->createUrl('secondKillActivity/'.$adminAct, array('category_id'=>$model->categoryId, 'rules_id'=>$model->rulesId));?>">返回上一级</a>
<span style="font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $titleNumber['name'];?></span>
<?php if($model->categoryId==3){ echo "<span>$titleNumber[start_time] - $titleNumber[end_time]</span>"; }?>
<span style="padding-left:40px;">参与活动的商品数：<?php echo $titleNumber['product'];?> 件</span>
<span style="padding-left:40px;">参与活动的商家数：<?php echo $titleNumber['seller'];?> 家</span>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl('secondKillActivity/product'.$model->categoryId, array('category_id'=>$model->categoryId, 'rules_seting_id'=>$model->rulesSetingId)),
        'method' => 'get',
    ));
  
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'product_name'); ?>：</th>
            <td><?php echo $form->textField($model, 'product_name', array('class' => 'text-input-bj  middle', 'placeholder'=>'')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'product_id'); ?>：</th>
            <td><?php echo $form->textField($model, 'product_id', array('class' => 'text-input-bj  middle', 'placeholder'=>'')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'seller_name'); ?>：</th>
            <td><?php echo $form->textField($model, 'seller_name', array('class' => 'text-input-bj  middle', 'placeholder'=>'')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    
    <?php $this->endWidget(); ?>
</div>

<?php
$this->renderPartial('_product', array('model' => $model, 'pages'=>$pages, 'dataProvider'=>$dataProvider, 'labels'=>$labels)); 
?>

<?php
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>
