<?php
$this->breadcrumbs = array(
    Yii::t('member', '会员搜索'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
        if (!$('#Member_searchKeyword').val()) {
            alert('" . Yii::t('member', '请输入会员名/会员编码/手机号') . "');
            return false;
        }
	$('#member-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>

<script  type="text/javascript">
var selOKClick = function(obj) {
    var ids = '';

	$.each($("input[name='cid[]']"),function(){
		if($(this).attr('checked')=='checked'){
			ids += ','+$(this).val();
		}
	});

	ids = ids.substr(1,ids.length-1);
	
	var p = artDialog.open.origin;
	p.selSearchMen(ids);
    art.dialog.close();
}

var selAll = function() {
	$("input[type=checkbox]").attr('checked','checked');
}

var selNone = function() {
	$("input[type=checkbox]").attr('checked',false);
}

</script>


<div  class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <thead>
            <tr style="height: 50px">
                <td colspan="4">
                    <?php echo Yii::t('member', '请输入会员名/会员编码/手机号'); ?> :
                    <?php echo $form->textField($model, 'searchKeyword', array('class' => 'text-input-bj middle')); ?>
                    <?php echo CHtml::submitButton(Yii::t('member', '搜索'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('member', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php $this->endWidget(); ?>
</div>


<a href="#9" title="确定" onclick="selOKClick(this)" class="regm-sub" >确定选择</a>
<a href="<?php echo Yii::app()->createUrl('message/getMember',array('getall'=>1));?>" title="显示全部"  class="regm-sub" >显示全部会员</a>
<a href="#9" title="选择全部会员"  onclick="selAll()" class="regm-sub" >选择全部</a>
<a href="#9" title="选择全部会员"  onclick="selNone()" class="regm-sub" >取消选择全部</a>
<?php
$this->widget('GridView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->getUserSearch(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(

		array(
        'name'=>'',             
        'value'=>'CHtml::checkBox("cid[]",null,array("value"=>$data->gai_number,"id"=>"cid_".$data->gai_number))',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>5),
        //'visible'=>false,
        ),

        'username',
        'gai_number',
        'mobile',
    ),
));
?>

<a href="#9" title="确定" onclick="selOKClick(this)" class="regm-sub" >确定选择</a>


