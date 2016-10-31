<?php
/* @var $this SpecialTopicGoodsController */
/* @var $model SpecialTopicGoods */

$this->breadcrumbs = array(
    '专题管理' => array('/specialTopic/admin'),
    '专题分类' => array('/specialTopicCategory/admin', 'specialId' => $this->specialId),
    '专题商品'
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#special-topic-goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if (Yii::app()->user->hasFlash('tip_success')): ?>
    <div class="tip success">
        <?php echo Yii::app()->user->getFlash('tip_success'); ?>
        操作成功！
    </div>
<?php endif; ?>
<?php if ($this->getUser()->checkAccess('SpecialTopicGoods.AddGoods')): ?>
    <?php echo CHtml::link(Yii::t('specialTopicGoods', '添加商品'), 'javascript:;', array('id' => 'AddGoods', 'class' => 'regm-sub')) ?>
    <div class="c10"></div>
<?php endif; ?>
<?php
    $gridViewFooter = '';
    if ($this->getUser()->checkAccess('SpecialTopicGoods.BatchDelete')):
        $gridViewFooter .= '<a class="regm-sub" href="javascript:;" onClick="batchOperate(\'delete\');">批量删除</a>';
    endif;
    if ($this->getUser()->checkAccess('SpecialTopicGoods.BatchUpdate')):
        $gridViewFooter .= '<a class="regm-sub" href="javascript:;" onClick="batchOperate(\'update\');">批量更新</a>';
    endif;
?>
<?php
$this->widget('GridView', array(
    'id' => 'special-topic-goods-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'header' => '全选',
            'headerTemplate' => '全选{item}',
            'selectableRows' => 2,
            'footer' => $gridViewFooter,
            'class' => 'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array('name' => 'selectdel[]'),
            'value' => '($data->id)."|". $data->special_price',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'name' => 'special_topic_id',
            'value' => '$data->specialTopic->name'
        ),
        array(
            'name' => 'special_topic_category_id',
            'value' => '$data->specialTopicCategory->name'
        ),
        array(
            'name' => 'goods_id',
            'value' => '!$data->goods ? "" : $data->goods->name'
        ),
        array(
            'header' => Goods::model()->getAttributeLabel('gai_price'),
            'value' => '!$data->goods ? "" : $data->goods->gai_price'
        ),
        array(
            'header' => Goods::model()->getAttributeLabel('price'),
            'value' => '!$data->goods ? "" : $data->goods->price'
        ),
        array(
            'type' => 'raw',
            'name' => 'special_price',
            'value' => 'CHtml::textField("SpecialPrice", "$data->special_price", array("class" => "text-input-bj least", "onChange" => "PriceChange(this, ". $d = (!$data->goods) ? "" : $data->goods->gai_price.")"))'
        ),
    ),
));
?>
<script src="/js/iframeTools.js" type="text/javascript"></script>
<?php
Yii::app()->clientScript->registerScript('addGoods', "
    var doClose = function() {
        if (null != dialog) {
            dialog.close();
        }
    };
    var dialog = null;
    jQuery(function($) {
        // 搜索专题商品
        $('#AddGoods').click(function() {
            var url = '" . $this->createAbsoluteUrl('/specialTopicGoods/SelectGoods', array('categoryId' => $this->specialCatId)) . "';
            dialog = art.dialog.open(url , {'id': 'selectGoods', title: '添加" . $this->specialTopicCategory->specialTopic->name . "专题商品', width: '900px', height: '600px', lock: true, 'window' : 'top'});
        })
    })

    var refreshPage = function() {
        $('#special-topic-goods-grid').yiiGridView('update', {
                data: $(this).serialize()
        });
        return false;
    };
    
    // 活动价格修改
    var PriceChange = function (e, gaiPrice) {
        var checkEle = $(e).parents('tr').children().eq(0).children('input');
        var checkValue = checkEle.val().split('|');
        var newCheckValue = checkValue[0] + '|';
        if (parseInt(e.value) < gaiPrice) {
            alert('促销价必须大于等于供货价！');
            e.value = gaiPrice;
        }
        newCheckValue += +e.value;
        checkEle.val(newCheckValue);
        checkEle.attr('checked', 'true')
    }

", CClientScript::POS_HEAD);
?>
<script type='text/javascript'>
    /*<![CDATA[*/
    var batchOperate = function(operate, options) {
        if (operate == 'update' || operate == 'delete') {
            var text = operate == 'update' ? '更新' : '删除';
            var data = new Array();
            $("input:checkbox[name='selectdel[]']").each(function() {
                if ($(this).attr("checked") == 'checked') {
                    data.push($(this).val());
                }
            });
            if (data.length > 0) {
                if (!confirm('确定要' + text + '选中的数据吗?'))
                    return false;
                var icon, msg = '';
                var route = operate == 'update' ? '/specialTopicGoods/batchUpdate' : '/specialTopicGoods/batchDelete';
                var url = "<?php echo Yii::app()->createAbsoluteUrl('"+route+"', array('categoryId' => $this->specialCatId)); ?>";
                $.post(url, {'selectdel[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                    if (data == 'true') {
                        $.fn.yiiGridView.update('special-topic-goods-grid');
                        icon = 'succeed';
                        msg = operate == 'update' ? '更新成功！' : '删除成功！';
                    } else {
                        icon = 'error';
                        msg = '操作失败！';
                    }
                    art.dialog({
                        icon: icon,
                        content: msg,
                        ok: true
                    });
                }, 'json');
            } else {
                alert("请选商品!");
            }
        }
    }
    /*]]>*/
</script>
