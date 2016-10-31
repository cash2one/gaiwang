<?php
/* @var $this AppHotCategoryController */
/* @var $model AppHotCategory */
$this->breadcrumbs = array(Yii::t('AppHotCategory', '添加热卖商品') => array('admin'), Yii::t('AppHotCategory', '热卖商品列表'));
Yii::app()->clientScript->registerScript('search', "
$('#AppHotCategory-form').submit(function(){
	$('#AppHotCategory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('AppHotCategory.Create')): ?>
    <input class="regm-sub" id="addHotGoods" type="button" value="<?php echo Yii::t('AppHotGoods', '绑定商品') ?>">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'AppHotCategory-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '25%'),
            'name'=>'name',
            'value'=>'$data->name',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'order',
            'value'=>'$data->order',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'type',
            'value'=>'AppHotGoods::getType($data->type)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'storeName',
            'value'=>'$data->storeName',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'categoryName',
            'value'=>'$data->categoryName',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'price',
            'value'=>'$data->price',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'stock',
            'value'=>'$data->stock',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'sales_volume',
            'value'=>'$data->sales_volume',
        ),
        array(
            'name' => Yii::t('AppHotCategory', '操作'),
            'type' => 'raw',
            'value' => 'AppHotGoods::createButtons($data->id)',
        ),
    ),
));
?>

<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
    </style>
    <?php $typeArr = AppHotGoods::getType()?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
            <tr class="confirmTR" >
                <th class="even">商品ID：</th>
                <td class="even" >
                    <input id="goods_id" style="float: left;margin-left: 5px;width:200px;height: 20px;" type="text" name="goods_id" value=""/>
                    <input id="goodsSearch" onclick="goodsSearch();" type="button" value="搜索" style="float: left;margin-left: 5px;" />
                </td>
            </tr>
            <tr class="confirmTR" style="background:#FFF;">
                <th class="even"  style=" float:left;">类型：</th>
                <td class="even" >
                    <select id="type" name="type">
                        <?php foreach($typeArr as $key=>$val):?>
                        <?php if($key == 1){?>
                        <option value="<?php echo $key?>"><?php echo $val;?></option>
                         <?php }?>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr class="confirmTR" style="background:#FFF;">
                <th class="even"  style=" float:left;">排序：</th>
                <td class="even" >
                    <input id="order" type="text" name="order" value="1"/>
                </td>
            </tr>
            <tr class="confirmTR" style="background:#FFF;">
                <th class="even"  style=" float:left;">商品名称：</th>
                <td class="even" ><p id="name"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
            <tr class="confirmTR" >
                <th class="even">商家名称：</th>
                <td class="even" ><p id="storeName"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
            <tr class="confirmTR" >
                <th class="even">所属分类：</th>
                <td class="even" ><p id="categoryName"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
            <tr class="confirmTR" >
                <th class="even">商品售价：</th>
                <td class="even" ><p id="price"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
            <tr class="confirmTR" >
                <th class="even">商品库存：</th>
                <td class="even" ><p id="stock"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
            <tr class="confirmTR" >
                <th class="even">商品销量：</th>
                <td class="even" ><p id="sales_volume"  style="width:250px; word-break:break-all;"></p></td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function _error(error) {
        art.dialog({
            icon: 'error',
            content: error,
            ok: true
        });
    }
    function _success(suss) {
        art.dialog({
            icon: 'succeed',
            content: suss,
            ok: true
        });
    }
    //添加商城热卖商品和商务小礼
    $("#addHotGoods").click(function() {
        var code = $(this).attr("data-code");
        var url = '<?php echo $this->createAbsoluteUrl('/AppHotGoods/create') ?>';
        art.dialog({
            title: '<?php echo Yii::t('AppHotGoods', '添加热门推荐') ?>',
            okVal: '<?php echo Yii::t('AppHotGoods', '确定') ?>',
            cancelVal: '<?php echo Yii::t('AppHotGoods', '取消') ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function() {
                var id = $("#goods_id").val();
                var type = $("#type").val();
                var order = $("#order").val();
                var name = $("#name").html();
                var storeName = $("#storeName").html();

                if (id.length == 0 && status != 'transfering') {
                    art.dialog({
                        icon: 'warning',
                        content: '<?php echo Yii::t('AppHotGoods', '请填写商品ID')?>',
                        lock:true,
                        ok:function(){
                            $('#goods_id').focus();
                        }
                    });
                    return false;
                }
                if (!name && !storeName) {
                    art.dialog({
                        icon: 'warning',
                        content: '<?php echo Yii::t('AppHotGoods', '请点击搜索后再进行添加！')?>',
                        lock:true,
                        ok:function(){
                            $('#goodsSearch').focus();
                        }
                    });
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', id: id,order:order,type:type},
                    success: function(data) {
                        if (data.success) {
                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else {
                            art.dialog({
                                icon: 'warning',
                                content: data.error,
                                lock:true,
                                ok:function(){
                                    $('#order').focus();
                                }
                            });
                        }
                    }
                });
            }
        });
        return false;
    });

    /**
     *检测商品ID对用的商品是否合格
     */
    function check_goods(code, url, id,type) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: {code: code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', id: id,type:type},
            success: function(data) {
                if (data.success) {
                    $("#name").empty();
                    $("#storeName").empty();
                    $("#categoryName").empty();
                    $("#price").empty();
                    $("#stock").empty();
                    $("#sales_volume").empty();
                    $("#name").html(data.name);
                    $("#storeName").html(data.storeName);
                    $("#categoryName").html(data.categoryName);
                    $("#price").html(data.price);
                    $("#stock").html(data.stock);
                    $("#sales_volume").html(data.sales_volume);
                } else {
                    $("#name").empty();
                    $("#storeName").empty();
                    $("#categoryName").empty();
                    $("#price").empty();
                    $("#stock").empty();
                    $("#sales_volume").empty();

                    art.dialog({
                        icon: 'warning',
                        content: data.error,
                        lock:true,
                        ok:function(){
                            $('#goods_id').focus();
                        }
                    });
                }
                $('#goodsSearch').removeAttr('disabled');
            }
        });
    }

    /**
     * 通过商品id搜索商品信息
     */
    function goodsSearch(){
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/appHotGoods/checkGoodsID') ?>';
        var id = $("#goods_id").val();
        var type = $("#type").val();
        $('#goodsSearch').attr('disabled', 'disabled');
        check_goods(code, url, id, type);
    }

    /**
     * 删除商城热卖/商务小礼
     * @returns {boolean}
     */
    function do_Remove(id) {
        art.dialog({
            icon: 'question-red',
            content: '确定要删除该商品吗？',
            ok: function() {
                jQuery.ajax({
                    type: "get", async: false, dataType: "json", timeout: 5000,
                    url: "<?php echo $this->createUrl('remove') ?>",
                    data: "id=" + id,
                    error: function(request) {
                        alert(request.responseText);
                    },
                    success: function(data) {
                        if (data) {
                            if (data.error == 0) {
                                _success(data.content);
                                location.reload();
                            }
                            else {
                                _error(data.content);
                            }
                        } else {
                            _error('删除失败');
                        }

                    }
                });

            },
            cancel: true
        });
    }

    /**
     *更新商城热卖/商务小礼
     */
    function do_Edit(id){
        //1.ajax 获取数据（用于显示）
        $.ajax({
                type: "get", async: false, dataType: "json", timeout: 5000,
                url: "<?php echo $this->createUrl('getHotGoods') ?>",
                data:"id="+id,
                error:function(){

                },
                success:function(data){
                    $("#goodsSearch").hide();
                    $("#goods_id").attr('value',data.goods_id);
                    $("#goods_id").attr('disabled',true);
                    $("#type").attr('vale',data.type);
                    $("select option[value='"+data.type+"']").attr("selected", "selected");
                    $("select").attr('disabled',true);
                    $("#order").attr('value',data.order);
                    $("#name").html(data.name);
                    $("#storeName").html(data.storeName);
                    $("#categoryName").html(data.categoryName);
                    $("#price").html(data.price);
                    $("#stock").html(data.stock);
                    $("#sales_volume").html(data.sales_volume);
                }
            }
        );

        var old_order = $("#order").val();
        //Ajax修改数据
        art.dialog({
            icon: 'question-red',
            content: $("#confirmArea").html(),
            ok: function() {
                var order = $("#order").val();
                if(order == old_order){
                    _success("没有任何修改");
                }

                if (order.length == 0 && status != 'transfering') {
                    art.dialog({
                        icon: 'warning',
                        content: '<?php echo Yii::t('AppHotGoods', '请填写排序')?>',
                        lock:true,
                        ok:function(){
                            $('#order').focus();
                        }
                    });
                    return false;
                }

                $.ajax({
                    type: "post", async: false, dataType: "json", timeout: 5000,
                    url: "<?php echo $this->createUrl('update') ?>",
                    data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', id: id,order:order},
                    success: function(data) {
                        if (data.success) {
                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else {
                            art.dialog({
                                icon: 'warning',
                                content: data.error,
                                lock:true,
                                ok:function(){
                                    $('#order').focus();
                                }
                            });
                        }
                    }
                });
                location.reload();
            },
            cancel: function(){
                location.reload();
            }
        });

    }

</script>