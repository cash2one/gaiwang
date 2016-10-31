<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('prepaidCard', '充值卡') => array('list'),
    Yii::t('prepaidCard', '使用记录')
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#prepaid-card-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_searchused', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        array(
            'footer' => '<button type="button" onclick="getCheckbox();" class="regm-sub">批量对账</button>',
            'header' => '<input type="checkbox" id="checkAll">',
            'htmlOptions' => array(
                'style' => 'width:5%'
            ),
            'value' => 'PrepaidCard::showCheckBox($data)',
            'type' => 'raw'

//            'selectableRows' => 2,
//            'footer' => '<button type="button" onclick="GetCheckbox();" style="width:76px">批量删除</button>',
//            'class' => 'CCheckBoxColumn',
//            'headerHtmlOptions' => array('width' => '33px'),
//            'checkBoxHtmlOptions' => array('name' => 'selectRec[]'),
        ),
        array(
            'name' => 'owner_id',
            'value' => 'PrepaidCard::showOwner($data)',
            'type' => 'raw'
        ),
        'number',
        array(
            'name' => 'value',
            'value' => 'PrepaidCard::showScore($data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'money',
            'value' => 'PrepaidCard::showMoney($data->money, $data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'member_id',
            'value' => 'isset($data->member) ? $data->member->gai_number : ""'
        ),
        array(
            'name' => 'mobile',
            'value' => 'isset($data->member) ? $data->member->mobile : ""'
        ),
        array(
            'name' => 'use_time',
            'value' => 'date("Y-m-d H:i:s", $data->use_time)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonLabel' => Yii::t('prepaidCard', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('prepaidCard', '查看'),
        			'url'=>'Yii::app()->createUrl("prepaid-card/view",array("id"=>"$data->id","action"=>"list"),"&")',
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('PrepaidCard.View')"
                ),
            )
        ),
    ),
));
?>
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(document).on('click', '#checkAll', function() {
        var checked = this.checked;
        jQuery(".grid-view input[name='selectRec[]']").each(function() {
            this.checked = checked;
        });
    });
    var getCheckbox = function() {
        var data = new Array();
        $(".grid-view input[name='selectRec[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            if (confirm('<?php echo Yii::t('prepaidCard', '确定要对账吗？对账后将不能还原哦！'); ?>')) {
                $.post('<?php echo $this->createAbsoluteUrl('/prepaidCard/recon'); ?>', {'selectRec[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                    var ret = $.parseJSON(data);
                    if (ret != null && ret.success != null && ret.success) {
                        $.fn.yiiGridView.update('prepaid-card-grid');
                    }
                });
            }
        } else {
            alert("<?php echo Yii::t('prepaidCard', "请选择要对账的充值卡!"); ?>");
        }
    }
    /*]]>*/
</script>  
<?php $this->renderPartial('//layouts/_export', array('exportPage' => $exportPage, 'totalCount' => $totalCount)); ?>