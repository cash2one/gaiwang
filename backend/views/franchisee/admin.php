<?php
/* @var $this FranchiseeController */
/* @var $model Franchisee */
$this->breadcrumbs = array(Yii::t('franchisee', '加盟商管理') => array('admin'), Yii::t('franchisee', '列表'));
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    var temp = $(this);
    $(temp).find('[name=\"r\"]').remove();
    $('.search-form #exportSearch').attr('href','/?r=".$exportPage->route."&grid_mode=export&exportType=Excel5&'+$(temp).serialize());

	$('#franchisee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Franchisee.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/franchisee/create') ?>"><?php echo Yii::t('franchisee', '添加加盟商') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'code',
        array(
            'name' => Yii::t('franchisee', '所属会员'),
//            'value' => '!empty($data->member)?(!empty($data->member->username)?$data->member->username:$data->member->gai_number):"null"'
            'value' => '!empty($data->member)?$data->member->gai_number:"null"'
        ),
        'mobile',
        'gai_discount',
        'member_discount',
        'max_machine',
        array(
            'name' => 'status',
            'value' => 'Franchisee::showStatus($data->status)'
        ),
        array(
            'name' => 'is_recommend',
            'value' => 'Franchisee::getRecommend($data->is_recommend)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('franchisee', '操作'),
            'template' => '{update_imgs}{update}{updateImportant}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update_imgs' => array(
                    'label' => Yii::t('franchisee', '图片'),
                    'visible' => "Yii::app()->user->checkAccess('Franchisee.UpdateImgs')",
                    'url' => 'Yii::app()->createUrl("franchisee/updateImgs", array("id"=>$data->id))',
                ),
                'update' => array(
                    'label' => Yii::t('franchisee', '基本信息'),
                    'visible' => "Yii::app()->user->checkAccess('Franchisee.Update')",
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'updateImportant' => array(
                    'label' => Yii::t('franchisee', '重要信息'),
                    'visible' => "Yii::app()->user->checkAccess('Franchisee.UpdateImportant')",
                    'url' => 'Yii::app()->createUrl("franchisee/updateImportant",array("id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'delete' => array(
                    'label' => Yii::t('franchisee', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Franchisee.Delete')"
                ),
            )
        )
    ),
));
?>

<?php
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>

