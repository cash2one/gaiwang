<?php
/* @var $this ProductController */
/* @var $model Product */
$this->breadcrumbs = array('商品' => array('admin'), '列表');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
Yii::app()->clientScript->registerCoreScript('artdialog');
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php
$this->widget('GridView', array(
    'id' => 'product-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        array(
            'selectableRows' => 2,
            'footer' => '<button type="button"  onclick="getApproved();" class="regm-sub">批量通过</button>' .
            '<button type="button"  onclick="getPending();" class="regm-sub">批量不通过</button>' .
            '<button type="button"  onclick="getRecommend();" class="regm-sub">批量首页推荐</button>' .
            '<button type="button"  onclick="getUnRecommend();" class="regm-sub">取消首页推荐</button>' .
            '<button type="button"  onclick="getPublished();" class="regm-sub">批量发布</button>' .
            '<button type="button"  onclick="getUnPublished();" class="regm-sub">取消发布</button>',
            'class' => 'CCheckBoxColumn',
            'headerHtmlOptions' => array('width' => '33px'),
            'footerHtmlOptions' => array('colspan' => 5),
            'checkBoxHtmlOptions' => array('name' => 'ids[]'),
        ),
        'id',
        array(
            'name' => 'name',
            'value' => 'CHtml::link($data->life ? "<del>".$data->name."</del>" : $data->name, DOMAIN."/JF/".$data->id.".html",array("target"=>"_blank"))',
            'type' => 'raw',
        ),
        'code',
        array(
            'name' => 'store_id',
            'value' => '!empty($data->store->name)?$data->store->name:""'
        ),
        array(
            'name' => 'category_id',
            'value' => '!empty($data->category->name)?$data->category->name:""'
        ),
        'market_price',
        array(
            'type' => 'raw',
            'name' => 'gai_sell_price',
            'value' => 'Product::showPrice($data->gai_sell_price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'gai_price',
            'value' => 'Product::showPrice($data->gai_price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'price',
            'value' => 'Product::showPrice($data->price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'is_publish',
            'value' => 'Product::showPublished($data->is_publish, $data->create_time)'
        ),
        array(
            'type' => 'raw',
            'name' => 'stock',
            'value' => 'Product::showStock($data->stock)'
        ),
        'sales_volume',
        // array(
        //     'name'=>'activity_tag_id',
        //     SeckillProductRelation
        //     'value'=>'$data->active_status ? ActivityTag::getName($data->active_status) : "无"',
        // ),
//           array(
//            'name'=>'active_status',            
//            'value'=>'isset($data->active_status)?SeckillProductRelation::getStatus($data->seckill_seting_id,$data->active_status,$data->date_end,$data->end_time) : "未参加活动"',
//        ),
        array(
            'name'=>  Yii::t('goods','商家修改'),
            'value'=>'empty($data->change_field)?"否":implode(",",array_values(unserialize($data->change_field)))'
        ),
        array(
            'type' => 'raw',
            'name' => 'status',
            'value' => 'Product::showNewStatus($data->status, $data->reviewer, $data->audit_time, $data->id)."<br/>".CHtml::link("审核记录",array("product/audit","goods_id"=>$data->id),array("class"=>"audit"))'
        ),
        array(
            'type' => 'raw',
            'name' => 'sort',
            'value' => '$data->sort'
        ),
        array(
            'type' => 'raw',
            'name' => 'show',
            'value' => 'Product::showHome($data->id, $data->show)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonLabel' => Yii::t('home', '编辑'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Product.Update')"
                ),
            ),
        )
    ),
));
?>
<script type="text/javascript">
    /*<![CDATA[*/
    var getApproved = function() {
        var data = [];
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/product/approved/')); ?>', {'ids[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
//                    $.fn.yiiGridView.update('yw1');
                    window.location.reload()
                }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
    var getPending = function() {
        var data = [];
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            art.dialog({
                title:'请输入审核失败原因',
                content:'<textarea  cols="50" id="fail_reason"></textarea>(限200字内)',
                ok:function(){
                   var fail_reason = $("#fail_reason").val();
                    if($.trim(fail_reason).length==0){
                        alert("请输入审核失败原因");
                        return false;
                    }
                    if($.trim(fail_reason).length>200){
                        alert("审核失败原因限200字内");
                        return false;
                    }
                    $.post('<?php echo CHtml::normalizeUrl(array('/product/pending')); ?>', {'ids[]': data,reason:fail_reason, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                        var ret = $.parseJSON(data);
                        if (ret != null && ret.success != null && ret.success) {
                            window.location.reload()
                        }
                    });
                },
                lock:true
            });

        } else {
            alert("请选择要操作的数据!");
        }
    };
    var getRecommend = function() {
        var data = new Array();
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/product/recommend')); ?>', {'ids[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
                    window.location.reload()
                }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
    var getUnRecommend = function() {
        var data = new Array();
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/product/unRecommend')); ?>', {'ids[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
                    window.location.reload()
                }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
    var getPublished = function() {
        var data = new Array();
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/product/published')); ?>', {'ids[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
                    window.location.reload()
                }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
    var getUnPublished = function() {
        var data = new Array();
        $(".grid-view input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            $.post('<?php echo CHtml::normalizeUrl(array('/product/unPublished')); ?>', {'ids[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                var ret = $.parseJSON(data);
                if (ret != null && ret.success != null && ret.success) {
                    window.location.reload()
                }
            });
        } else {
            alert("请选择要操作的数据!");
        }
    };
    $(".audit").on('click',function(){
        art.dialog.open(this.href,{width:"700px",height:'70%',lock:true});
        return false;
    });
    /*]]>*/
</script>
<?php
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>