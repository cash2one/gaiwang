<?php
/* @var $this HosSellOrderController */

$this->breadcrumbs=array(
		Yii::t('HosSellOrder', '商城热卖'),
		Yii::t('HosSellOrder', '热卖管理')=>array('HosSellOrder/index'));
?>

<?php $this->renderPartial('_search',array('model'=>$model));
$click = "function() {  
    if(!confirm('是否改变状态?当状态为<隐藏>时前端不显示,需状态为<显示>时前端才呈现入口!')){
        return false;
}}";?>
<?php //if (Yii::app()->user->checkAccess('HosSellOrder.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/HosSellOrder/create/') ?>"><?php echo Yii::t('HosSellOrder', '添加') ?></a>
<?php // endif; 

?>
<?php $this->widget('GridView', array(
    'id' => 'HosSellOrder-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'name',
            'value'=>'$data->name',
        ),
    	array(
    		'headerHtmlOptions' => array('width' => '10%'),
    		'name'=>'sequence',
    		'value'=>'$data->sequence',
    	),
    	array(
    		'headerHtmlOptions' => array('width' => '10%'),
    		'name'=>'type',
    		'value'=>'HosSellOrder::getHotSellType($data->type)',
    	),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'status',
            'value'=>'HosSellOrder::getHotSellStatus($data->status)',
        ),
    	array(
    		'headerHtmlOptions' => array('width' => '10%'),
    		'name' => 'logo',
    		'value' => 'empty($data->logo)?"无":HosSellOrder::showRealImg($data->logo,50,50)',
    	),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('HosSellOrder', '操作'),
            'headerHtmlOptions' => array('width' => '40%'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
        	//'changeButtonImageUrl' => false,
            'template' => '{update}{change}{delete}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('HosSellOrder', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HosSellOrder.Update')",
                    'url' => 'Yii::app()->createUrl("HosSellOrder/Update",array("id"=>$data->id))',
                	
                ),
                'change' => array(
                    'label' => Yii::t('HosSellOrder', "改变状态"),
                    'visible' => "Yii::app()->user->checkAccess('HosSellOrder.Change')",
                	'url' => 'Yii::app()->createUrl("HosSellOrder/Change",array("id"=>$data->id))',
                	'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                	'click'=>$click,
                ),
            	'delete' => array(
            		'label' => Yii::t('HosSellOrder', '删除'),
            		'visible' => "Yii::app()->user->checkAccess('HosSellOrder.Delete')",
            		'url' => 'Yii::app()->createUrl("HosSellOrder/Delete",array("id"=>$data->id))',
            	),
            )
        )
    ),
)); ?>
