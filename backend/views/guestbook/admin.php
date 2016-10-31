<?php
/* @var $this GuestbookController */
/* @var $model Guestbook */

$this->breadcrumbs = array(
    Yii::t('guestbook', '商品咨询管理 ') => array('admin'),
    Yii::t('guestbook', '产品咨询列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#guestbook-grid').yiiGridView('update', {
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

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'guestbook-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'gai_number',
        array(
            'type' => 'raw',
            'name' => 'goodsName',
            'value' => 'CHtml::link(isset($data->goods) ? $data->goods->name : "",  DOMAIN . "/JF/$data->owner_id.html", array("target" => "_black"))',
        ),
        'description',
        array(
            'name' => 'status',
            'value' => 'Guestbook::status($data->status)',
        ),
        array(
            'name' => 'reply',
            'value' => 'Guestbook::isReply(!$data->reply_content ? Guestbook::UNREPLY : Guestbook::REPLY)',
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('guestbook', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Guestbook.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('guestbook', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Guestbook.Delete')"
                ),
            )
        )
    ),
));
?>
