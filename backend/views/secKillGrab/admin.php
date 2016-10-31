<?php
/* @var $this ArticleController */
/* @var $model Article */
$this->breadcrumbs = array(
    Yii::t('article', '当前今日必抢商品') => array('admin'),
    );
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
       $('#secKillGrab-grid').yiiGridView('update', {
          data: $(this).serialize()
      });
return false;
});
");
?>
<?php if ($this->getUser()->checkAccess('secKillGrab.AddProduct')) { ?>
<input style="float: left;margin-left: 5px;" id="Btn_Add" type="button" value="添加必抢商品" class="regm-sub" >
 <?php } ?>
 <?php if ($this->getUser()->checkAccess('SecKillGrab.UpdateAll')) { ?>
<a class="regm-sub" style="float: left;margin-left: 25px;" href="<?php echo Yii::app()->createAbsoluteUrl("/secKillGrab/UpdateAll"); ?>">更新所有商品</a>
 <?php } ?>

<p style="float: left;margin-left: 25px;line-height: 27px;font-weight: 700;">当前展示：第<?php echo $curNum; ?>个</p>
<p style="float: left;margin-left:25px;line-height: 27px;font-weight: 700;">已添加:<?php echo $num; ?>个</p>
<p style="float: left;margin-left: 25px;line-height: 27px;font-weight: 700;">还可以添加：<?php echo 20 - $num; ?>个</p>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'secKillGrab-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => FALSE,
    'columns' => array(
        array(
            'name' => 'sort',
            'value' => '!empty($data->sort) ? $data->sort : ""',
            ),
        array(
            'name' => 'product_name',
            'value' => '!empty($data->product_name) ? $data->product_name : ""',
            ),
        array(
            'name' => 'product_id',
            'value' => '!empty($data->product_id) ? $data->product_id: ""',
            ),
        array(
            'name' => 'seller_name',
            'value' => '!empty($data->seller_name) ? $data->seller_name : ""',
            ),
        array(
            'name' => 'product_price',
            'value' => '!empty($data->product_price) ? $data->product_price : ""',
            ),
        array(
            'name' => 'product_stock',
            'value' => ' $data->product_stock ',
            ),
        array(
            'name' => 'rules_name',
            'value' => '!empty($data->rules_name) ? $data->rules_name : ""',
            ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'delete' => array(
                    'label' => Yii::t('user', '移除'),
                   'visible' => "Yii::app()->user->checkAccess('SecKillGrab.Delete')",
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
    </style>    
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>

            <tr id="confirmTR" >
                <th class="even">
                    商品ID：
                </th>
                <td class="even" >
                    <!--                    <textarea name="confirmReason" id="confirmReason" cols="50" rows="3" style="width: 95%;border:solid 1px #eee;" class="text-input-bj  text-area"></textarea>-->
                    <input id="product_id" style="float: left;margin-left: 5px;width:200px;height: 20px;" type="text" name="product_id" value="">
                    <input id="secKillSearch" onclick="searchProduct();" type="button" value="搜索" style="float: left;margin-left: 5px;" />
                </td>
            </tr>

            <tr id="confirmTR" style="background:#FFF;">
                <th class="even"  style=" float:left;">

                    商品名称：
                </th>
                <td class="even" >                   
                    <!--                    <input id="product_name" style="margin-left: 5px;width:300px;height: 20px;" type="text" name="product_name" disabled="true" value="">-->

                    <p id="product_name"  style="width:250px; word-break:break-all;"></p>

                </td>
            </tr>
            <tr id="confirmTR" >
                <th class="even">
                    商家名称：
                </th>
                <td class="even" >                   
                    <!--                    <input id="seller_name" style="margin-left: 5px;width:300px;height: 20px;" type="text" name="seller_name" disabled="true" value="">-->
                    <input id="hidden_num" type="hidden" value="<?php echo $num; ?>"/>
                    <p id="seller_name"  style="width:250px; word-break:break-all;"></p>
                </td>
            </tr>
            <script>
                function check_product(code, url, id) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: url,
                        data: {code: code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', id: id},
                        success: function(data) {  
                            if (data.success) {
                                $("#product_name").empty();
                                $("#seller_name").empty();
                                $("#product_name").html(data.goodsname);
                                $("#seller_name").html(data.storename);
                            } else {
                                $("#product_name").empty();
                                $("#seller_name").empty();
                                // var dialog = art.dialog({icon: 'error', content: data.error});
                                alert(data.error);
                               
                            }
                            $('#secKillSearch').removeAttr('disabled');
                        }
                    });
                }
                
     
                function searchProduct(){
                    var code = $(this).attr("data-code");
                    var url = '<?php echo Yii::app()->createAbsoluteUrl('/secKillGrab/chechkProductId') ?>';
                    var id = $("#product_id").val();
                    $('#secKillSearch').attr('disabled', 'disabled');
                    check_product(code, url, id);
                }
            </script>
        </tbody>
    </table>

</div>
<script>
    //关闭订单
    $("#Btn_Add").click(function() {       
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/secKillGrab/addProduct') ?>';
        var num = $("#hidden_num").val();
        if (num >= 20) {
            alert('今日必抢商品已添加20件,请先移除后再重新添加！');
            return false;
        }
        art.dialog({
            title: '<?php echo Yii::t('sellerOrder', '添加必抢商品') ?>',
            okVal: '<?php echo Yii::t('sellerOrder', '确定') ?>',
            cancelVal: '<?php echo Yii::t('sellerOrder', '取消') ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function() {
                var id = $("#product_id").val();
                var product_name = $("#product_name").html();
                var seller_name = $("#seller_name").html();

                if (id.length == 0 && status != 'transfering') {
                    alert("<?php echo Yii::t('sellerOrder', '请填写商品ID'); ?>");
                    return false;
                }
                if (!product_name && !seller_name) {
                    alert("<?php echo Yii::t('sellerOrder', '请点击搜索后再进行添加！'); ?>");
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', id: id},
                    success: function(data) {
                        if (data.success) {

                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else {

                                alert(data.error);
                            // art.dialog({icon: 'error', content: data.error});
                        }
                    }
                });
            }
        });
return false;
});
</script>


