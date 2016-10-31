<?php
/* @var $this AppBrandsGoodsController */

$this->breadcrumbs=array(
	Yii::t('AppBrandsGoods', '品牌馆')=> array('AppBrands/admin'),
	Yii::t('AppBrandsGoods', '品牌馆商品列表')
);
Yii::app()->clientScript->registerScript('search', "
$('#AppBrandsGoods-form').submit(function(){
	$('#AppBrandsGoods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 //$this->renderPartial('_search',array('model'=>$model));
 ?>
 <?php if (Yii::app()->user->checkAccess('AppBrandsGoods.AddGoods')): ?>
    <a class="regm-sub" href="<?php  echo Yii::app()->createAbsoluteUrl('/AppBrandsGoods/AddGoods',array("brands_id"=>$brands_id)) ?>">添加商品</a> 
 <?php endif; ?>
 <?php
$this->widget('GridView', array(
		'id' => 'AppBrandsGoods-grid',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				'id',
				'goodId',
				'goodName',
				'sequence',
				array(
						//'headerHtmlOptions' => array('width' => '15%'),
						'name' => 'thumbnail',
						'value' => 'empty($data->thumbnail)?"无":AppTopicHouse::showRealImg($data->thumbnail,$data->id)',
				),
				array(
						'class' => 'CButtonColumn',
						'header' => Yii::t('home', '操作'),
						'template' => '{goods}{delete}',
						'updateButtonImageUrl' => false,
						'deleteButtonImageUrl' => false,
						'buttons' => array(
// 								'dateils' => array(
// 									'label' => Yii::t('user', '详情'),
// 									'url'=>'Yii::app()->createUrl("AppTopicHouse/AddGoodsDateils",array("Gid"=>$data->goodId,"id"=>$data->id))',
// 									'visible' => "Yii::app()->user->checkAccess('AppTopicHouse.AddGoodsDateils')"
// 								),
								'goods'=>array(
									'label'	=>Yii::t('AppBrandsGoods','排序'),
									'click' => 'function(){addRemark(this)}',
									'visible' => "Yii::app()->user->checkAccess('AppBrandsGoods.UpdateSequence')"
								),
								'delete'=>array(
										'label' => Yii::t('user', '删除'),
										//'url'=>'Yii::app()->createUrl("AppTopicHouse/Delete",array("id"=>$data->id))',
										'visible' => "Yii::app()->user->checkAccess('AppBrandsGoods.Delete')"
								),
						)
				)
		),
));
?>
<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th>
                    请选择排序号（数字小靠前）：</th>
                <td><select id="AppBrandsGoods_sequence">
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    function addRemark(obj){
       // var Gid = obj.parentNode.parentNode.children[0].innerHTML;
        var id = obj.parentNode.parentNode.children[0].innerHTML;;
        art.dialog({
            title: '<?php echo '修改排序' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
                //数据检验
                var options = $("#AppBrandsGoods_sequence option:selected");  //获取选中的项
                var remarkContent = options.val();   //拿到选中项的值
                //发送ajax验证
                var url = '<?php echo $this->createAbsoluteUrl('/AppBrandsGoods/UpdateSequence') ?>';
                $.post('<?php echo CHtml::normalizeUrl(array('/AppBrandsGoods/UpdateSequence')); ?>', {'id': id, 'sequence':remarkContent,'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                    if(data){
                        alert('修改成功!');
                        window.location.reload();
                    }else{
                        alert('修改失败！');
                        window.location.reload();
                    }
                });

            }
        })
    }

</script>

