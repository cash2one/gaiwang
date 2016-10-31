<link rel="stylesheet" type="text/css" href="/css/reg.css" />
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript">
    /**
     * 页面动画效果
     */
    $(document).ready(function(){
        $("#overlayer").ajaxStart(function(a){
            $(this).show();
        });
        $("#overlayer").ajaxStop(function(){
            $(this).hide();
        });

        $('.tab').click(function() {
            $('.adClassList .tab').removeClass('selected');
            $(this).addClass('selected');
        });
    });

    $(document).ready(function () {
        $('.listTable').each(function () {
            $(this).find('tr:even').addClass('even');
            $(this).find('tr').not(':first').mouseout(function () {
                $(this).removeClass('hover');
            });
            $(this).find('tr').not(':first').mouseover(function () {
                $(this).addClass('hover');
            });
        });
    });

    function subPageJump(obj){
        var n=$(obj).children("input").val();
        n = parseInt(n);
        if(n>0) $(obj).parent().prev("li").children("a").attr("href",$(obj).parent().attr("jumpUrl")+n)[0].click();
    }

</script>
<div class="t-sub">
    <a class="regm-sub" href="javascript:history.back()">返回列表</a>                                            </div>
<?php
$this->breadcrumbs = array(Yii::t('AppTopic', '商品列表'), Yii::t('AppTopicHouse', '添加商品'));
//给查询视图一个ajax事件
Yii::app()->clientScript->registerScript('searchBind', "
$('.search-form form').submit(function(){
	$('#machine-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="ctx">
    <?php  $this->renderPartial('_searchgoods', array('appBrandsModel' => $appBrandsModel,'brandsId'=>$appBrandsModel->id)); ?>
    <div>&nbsp;</div>
    <a class="regm-sub" onclick="return getRecommend()" href="###"><?php echo Yii::t('AppTopicHouse', '批量添加商品') ?></a>
    <div id="dListTable" class="ctxTable">
        <?php
        $this->widget('GridView',array(
            'id' => 'machine-grid',
            'selectableRows' => 2,
            'itemsCssClass' => 'tab-reg',
            'dataProvider' => $goodModel->searchAppBrands($appBrandsModel->id),
            'htmlOptions' => array('class' => 'listTable', 'cellpadding' => 0, 'border' => 0, 'cellspacing = 0'),
            'columns' => array(
                array(
                    'htmlOptions' => array('width' => '3%'),
                    'headerHtmlOptions' => array('width' => '3%'),
                    'class' => 'zii.widgets.grid.CCheckBoxColumn',
                    'checkBoxHtmlOptions' => array(
                        'name' => 'id[]',
                    )
                ),
                array(
                    'headerHtmlOptions' => array('width' => '23%'),
                    'name' => 'id',
                    'value' => '$data->id',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '23%'),
                    'name' => '商城分类',
                    'value' => 'Category::getCategoryName($data->category_id)',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '23%'),
                    'name' => 'name',
                    'value' => '$data->name',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '23%'),
                    'name' => 'thumbnail',
                    'value' => 'empty($data->thumbnail)?"无":AppTopicHouse::showRealImg($data->thumbnail,$data->id)',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'header' => Yii::t('AppTopic', '操作'),
                    'updateButtonImageUrl' => false,
                    'deleteButtonImageUrl' => false,
                    'template' => '{addgoods}',
                    'buttons' => array(
                        'addgoods' => array(
                            'label' => Yii::t('AppHotCategory', '添加'),
                            'click'=>'function(){getRecommend();}'
                        ),
                        'view' => array(
                            'visible' => 'false'
                        )
                    )
                )
            )
        ));
        ?>
    </div>
</div>
<script>

    var getRecommend = function() {

        var brandsId = <?php echo $appBrandsModel->id;?>;
        var data = new Array();
        var id = '';
        $(".ctxTable .listTable input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        
        $(document.getElementById('dListTable')).find("input[name='id[]']").each(function(){
            if($(this)[0].checked){
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/AppBrandsGoods/AjaxAddGoods')); ?>', {'ids[]': data, 'brandsId':brandsId,'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                    if(data){
                        alert('添加成功!');
                        window.location.reload()
                    }else{
                        alert('添加失败！');
                        window.location.reload()
                    }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
</script>