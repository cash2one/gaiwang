<?php
/* @var $this ProductController */
/* @var $model Product */
SeckillCategory::getCategory();
$this->breadcrumbs = array('活动商品' => array('admin'), '列表');
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
<?php $this->renderPartial('_searchActive', array('model' => $model)); ?>
<?php
    $searches = $model->search();
    $up = $model->up == 'desc' ? 'asc' : 'desc';
?>
<div>
    <b style="font-size:16px;">商品排序</b>:
    <input  type="button" value="审核时间" class="regm-sub" style="<?php if($model->sort != 'examine_time') echo 'background:#ccc' ?>" onclick="location.href = '<?php echo $this->createUrl("product/activeAdmin",array("sort"=>"examine_time","up"=>$up))?>'">
    <input  type="button" value="开始时间" class="regm-sub" style="<?php if($model->sort != 'date_start') echo 'background:#ccc'?>" onclick="location.href = '<?php echo $this->createUrl("product/activeAdmin",array("sort"=>"date_start","up"=>$up))?>'">
    <input  type="button" value="销量" class="regm-sub" style="<?php if($model->sort != 'sales_volume') echo 'background:#ccc'?>" onclick="location.href = '<?php echo $this->createUrl("product/activeAdmin",array("sort"=>"sales_volume","up"=>$up))?>'">
    <input  type="button" value="价格" class="regm-sub" style="<?php if($model->sort != 'price') echo 'background:#ccc'?>" onclick="location.href = '<?php echo $this->createUrl("product/activeAdmin",array("sort"=>"price","up"=>$up))?>'">
</div>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'product-grid',
    'dataProvider' => $searches,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        array(
            'selectableRows' => 2,
            'footer' => '<button type="button"  onclick="getAuditActive(1);" class="regm-sub">批量通过</button>' .
            '<button type="button"  onclick="getAuditActive(2);" class="regm-sub">批量不通过</button>' ,
            'class' => 'CheckBoxColumn',
            'headerHtmlOptions' => array('width' => '33px'),
            'footerHtmlOptions' => array('colspan' => 3),
            'checkBoxHtmlOptions' => array('name' => 'ids[]'),
            'value'=>'$data->id',
            'relation_id' => '$data->sid',
        ),
        array(
            'name'=> 'product_id',
            'value'=>'$data->product_id',
            'type'=>'raw',
        ),
        array(
            'name' => 'product_name',
            'value' => 'CHtml::link($data->product_name, DOMAIN."/JF/".$data->product_id.".html",array("target"=>"_blank"))',
            'type' => 'raw',
        ),
////        'code',
        array(
            'name' => 'seller_name',
            'value' => '!empty($data->seller_name)?$data->seller_name:""'
        ),
        array(
            'type'=>'raw',
            'name' => '商城分类',
            'value' => 'Category::getCategoryName($data->g_category_id)'
        ),
////        'market_price',
        array(
            'type' => 'raw',
            'name' => '盖网售价',
            'value' => 'Product::showPrice($data->gai_sell_price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'price',
            'value' => 'Product::showPrice($data->price)'
        ),
        array(
            'type' => 'raw',
            'name' => '库存',
            'value' => '$data->stock'
        ),
        array(
            'type' => 'raw',
            'name' => '销量',
            'value' => '$data->sales_volume'
        ),
        array(
            'name'=>'活动日期',
            'value' => '$data->date_start . " 至 " .$data->date_end'
        ),
        array(
            'name'=>'活动名称',
            'value'=>'$data->name',
            'type' => 'raw'
        ),
////        array(
////            'type' => 'raw',
////            'name' => 'gai_price',
////            'value' => 'Product::showPrice($data->gai_price)'
////        ),
////        array(
////            'type' => 'raw',
////            'name' => 'is_publish',
////            'value' => 'Product::showPublished($data->is_publish, $data->create_time)'
////        ),
////        array(
////            'type' => 'raw',
////            'name' => 'stock',
////            'value' => 'Product::showStock($data->stock)'
////        ),
////        'sales_volume',
//        // array(
//        //     'name'=>'activity_tag_id',
//        //     SeckillProductRelation
//        //     'value'=>'$data->active_status ? ActivityTag::getName($data->active_status) : "无"',
//        // ),
        array(
            'type' => 'raw',
            'name' => '商品审核状态',
            'value' => 'Product::showNewStatus($data->g_status, $data->reviewer, $data->audit_time, $data->product_id)."<br/>".CHtml::link("审核记录",array("product/audit","goods_id"=>$data->product_id),array("class"=>"audit"))'
        ),
        array(
            'name'=>'status',            
            'value'=>'isset($data->status) ? SeckillProductRelation::showActiveAudit($data->product_id,$data->rules_seting_id) : "未参加活动"',
            'type'=>'raw',
        ),
////        array(
////            'type' => 'raw',
////            'name' => 'sort',
////            'value' => '$data->sort'
////        ),
////        array(
////            'type' => 'raw',
////            'name' => 'show',
////            'value' => 'Product::showHome($data->id, $data->show)'
////        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonLabel' => Yii::t('home', '编辑'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("product/update",array("id"=>$data->product_id))',
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

    
    function getAuditActive(status){
        var ids = {};
        $("#product-grid input[name='ids[]']").each(function(index,value){
            if($(this).prop('checked')){
                if($(this).attr('relation_id') != undefined)
                    ids[$(this).val()] = $(this).attr('relation_id');
            }
        });
        var isEmpty = true;
        //检查对象是否为{}对象
        for(var name in ids){
            isEmpty = false;
        }
        if(isEmpty){
            alert('请选择商品');
            return false;
        }
        $.ajax({
            type:'POST',
            url: '<?php echo $this->createAbsoluteUrl('product/auditActive')?>',
            data:{ids:ids,YII_CSRF_TOKEN:'<?php echo Yii::app()->request->csrfToken;?>',status:status},
            dateType:'json',
            success:function(data){
                var ret = $.parseJSON(data);
                if (ret != null && ret.result != null && ret.result) {
                    window.location.reload();
                }
            }
        })
    }
    /*]]>*/
</script>
<?php
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>