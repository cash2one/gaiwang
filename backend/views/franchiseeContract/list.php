<?php
/* @var $this FranchiseeController */
/* @var $model Franchisee */
$this->breadcrumbs = array(Yii::t('franchiseecontract', '协议用户列表') => array('list-agreement'), Yii::t('franchiseecontract', '列表'));
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    var temp = $(this);
    $(temp).find('[name=\"r\"]').remove();
    $('.search-form #exportSearch').attr('href','/?r=".$exportPage->route."&grid_mode=export&exportType=Excel5&'+$(temp).serialize());

	$('#franchiseecontract-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<style type="text/css">
#franchiseecontract-grid_c5{
    padding: 0px 8px;
}
</style>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeContract.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/franchisee-contract/create') ?>"><?php echo Yii::t('franchiseecontract', '添加协议用户') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchiseecontract-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('franchisee', '盖网编号'),
            'value' => '!empty($data->member->gai_number)?$data->member->gai_number:""'
        ),
        array(
            'name' => Yii::t('franchisee', '用户名'),
            'value' => '!empty($data->member->username)?$data->member->username:""'
        ),
        'protocol_no',
        'number',
        array(
            'name' => Yii::t('contract', '合同类型'),
            'value' => '!empty($data->contract)?Contract::showType($data->contract->type):""'
        ),
        array(
            'name' => Yii::t('contract', '版本'),
            'value' => 'Contract::showVersion($data->contract->version,$data->contract->type)',
        ),
        array(
            'name' => 'status',
            'value' => 'FranchiseeContract::getConfirmStatu($data->status)',
            'id' => 'confirm_statu',
        ),
        array(
            'name' => 'confirm_time',
            'value' => '!empty($data->confirm_time)?date("Y-m-d H:i:s",$data->confirm_time):""',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('franchiseecontract', '操作'),
            'template' => '{update}{views}{prevois}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('franchiseecontract', '编辑'),
                    'visible' => 'FranchiseeContract::checkAccessUpdate($data->status)',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'views' => array(
                    'label' => Yii::t('franchiseecontract', '查看'),
                    'visible' =>  'FranchiseeContract::checkAccessView($data->status)',
                    'url' => 'Yii::app()->createUrl("franchisee-contract/view",array("id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'prevois' => array(
                    'label' => Yii::t('franchiseecontract', '预览'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeContract.view')",
                    'url'  => 'FranchiseeContract::createPrevoisvUrl($data->id)',
                    'options' => array('class' => 'regm-sub','target'=>'_blank', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'delete' => array(
                    'label' => Yii::t('franchiseecontract', '删除'),
                    'visible' => 'FranchiseeContract::checkAccessDelete($data->status)',
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


