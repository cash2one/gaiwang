<link rel="stylesheet" type="text/css" href="/css/reg.css" />
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
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
$this->breadcrumbs = array(Yii::t('AppTopic', '佳品'), Yii::t('AppTopicHouse', '商品列表'));

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/jqtransform.css');
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
    <div>&nbsp;</div>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/appTopicHouse/AddGoods',array('id'=>$Hid)) ?>"><?php echo Yii::t('AppTopicHouse', '添加商品') ?></a>
    <div id="dListTable" class="ctxTable">
        <?php
        $this->widget('GridView',array(
            'id' => 'machine-grid',
            'selectableRows' => 2,
            'itemsCssClass' => 'tab-reg',
            'dataProvider' => $model->search(),
            'htmlOptions' => array('class' => 'listTable', 'cellpadding' => 0, 'border' => 0, 'cellspacing = 0'),
            'columns' => array(
                array(
                    'headerHtmlOptions' => array('width' => '10%'),
                    'name' => '商品ID',
                    'value' => '$data->goods_id',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '10%'),
                    'name' => 'sequence',
                    'value' => '$data->sequence',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '23%'),
                    'name' => 'gName',
                    'value' => '$data->gName',
                ),
                array(
                    'headerHtmlOptions' => array('width' => '15%'),
                    'name' => 'thumbnail',
                    'value' => 'empty($data->thumbnail)?"无":AppTopicHouse::showRealImg($data->thumbnail,$data->id)',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'header' => Yii::t('AppTopic', '操作'),
                    'updateButtonImageUrl' => false,
                    'deleteButtonImageUrl' => false,
                    'template' => '{addgoodsdetails}{addgoods}{delet}',
                    'buttons' => array(
                        'addgoodsdetails' => array(
                            'label' => Yii::t('AppHotCategory', '详情'),
                            'url' => 'Yii::app()->controller->createUrl("appTopicHouse/AddGoodsDateils", array("Gid"=>$data->goods_id))',
                        ),
                        'addgoods' => array(
                            'label' => Yii::t('AppHotCategory', '排序'),
                            'click' => 'function(){addRemark(this)}',
                        ),
                        'delet' => array(
                            'label' => Yii::t('AppHotCategory', '删除'),
                            'visible' => "Yii::app()->user->checkAccess('AppTopicHouse.Delete')",
                            'url' => 'Yii::app()->controller->createUrl("appTopicHouse/deleteGoods", array("Gid"=>$data->goods_id,"Hid"=>$data->house_id))',
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
                <td><select id="AppTopicHouseGoods_sequence">
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
        var Gid = obj.parentNode.parentNode.children[0].innerHTML;
        var Hid = <?php echo $Hid;?>;
        art.dialog({
            title: '<?php echo '修改排序' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
                //数据检验
                var options = $("#AppTopicHouseGoods_sequence option:selected");  //获取选中的项
                var remarkContent = options.val();   //拿到选中项的值
                //发送ajax验证
                var url = '<?php echo $this->createAbsoluteUrl('/appTopicHouse/addSequence') ?>';
                $.post('<?php echo CHtml::normalizeUrl(array('/appTopicHouse/addSequence')); ?>', {'Gid': Gid, 'Hid':Hid,'sequence':remarkContent,'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                    if(data){
                        alert('修改成功!');
                        window.location.reload()
                    }else{
                        alert('修改失败！');
                        window.location.reload()
                    }
                });

            }
        })
    }

</script>