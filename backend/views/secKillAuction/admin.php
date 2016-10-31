<style type ="text/css">
    .reg-suba {
        background: #1E90FF;
        border: 1px solid #999;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        letter-spacing: 2px;
        line-height: 1;
        margin-left: 15px;
        overflow: visible;
        padding: 6px 8px;
        text-align: center;
        text-shadow: -1px -1px 1px #1c6a9e;
        transition: box-shadow 0.2s linear 0s;
        width:42px;
        height:24px;
        text-shadow:none;
        font-size:12px;
        font-family: "微软雅黑";
    }
	.page-but{
		border: 1px solid #dfdfdf;
        height: 25px;
        width: 50px;
        margin-left: 5px;
        color: #666;
        background: #efefef;
        cursor: pointer;
	}
</style>
<?php
$this->breadcrumbs = array(
    Yii::t('article', '当前拍卖商品') => array('admin'),
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
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php if ($this->getUser()->checkAccess('SecKillAuction.Add')) :?>
    <input style="float: left;margin-left: 5px;" id="Btn_Add" type="button" value="添加拍卖商品" class="regm-sub" >
<?php endif ?>

<?php if(!empty($data)):?>
<div class="c10"></div>
<div id="second-kill-grid" class="grid-view">
    <table class="tab-reg">
        <thead>
        <tr>
            <th><?php echo $labels['id'];?></th>
            <th><?php echo $labels['goods_name'];?></th>
            <th><?php echo $labels['goods_id'];?></th>
            <th><?php echo $labels['seller_name'];?></th>
            <th><?php echo $labels['start_price'];?></th>
            <th><?php echo $labels['price_markup'];?></th>
			<th><?php echo Yii::t('auction','保留价');?></th>
            <th><?php echo $labels['rules_name'];?></th>
            <th><?php echo $labels['status'];?></th>
            <th><?php echo $labels['create_user'];?></th>
            <th><?php echo $labels['create_time'];?></th>
            <th><?php echo Yii::t('auction','操作');?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $v):?>
	    <tr>
            <td title="<?php echo $v['id'];?>"><?php echo $v['id'];?></td>
            <td title="<?php echo $v['goods_name'];?>"><?php echo Tool::truncateUtf8String($v['goods_name'],20);?></td>
            <td title="<?php echo $v['gds_id'];?>"><?php echo $v['gds_id'];?></td>
            <td title="<?php echo $v['seller_name'];?>"><?php echo Tool::truncateUtf8String($v['seller_name'],20);?></td>
            <td title="<?php echo $v['start_price'];?>">￥<?php echo $v['start_price']; ?></td>
            <td title="<?php echo $v['price_markup'];?>">￥<?php echo $v['price_markup']; ?></td>
			<td title="<?php echo $v['reserve_price'];?>"><?php if(($v['reserve_price'])==0.00):?><?php echo Yii::t('auction','无保留价');?><?php else:?>￥<?php echo $v['reserve_price']; ?><?php endif ?></td>
            <td title="<?php echo $v['rules_name'];?>"><?php echo $v['rules_name'];?></td>
            <td title="<?php echo $model->getStatusArray($v['status']) ;?>"><?php echo $model->getStatusArray($v['status']) ;?></td>
            <td title="<?php echo $v['create_user'];?>"><?php echo $v['create_user'];?></td>
            <td title="<?php echo $v['create_time'];?>"><?php echo $v['create_time'];?></td>
            <td>
            <?php if ($this->getUser()->checkAccess('SecKillAuction.Delete')) :?><!--检查删除权限 begin-->
                 <?php if ($v['end_time'] >= date("Y-m-d H:i:s") && $v['start_time'] <= date("Y-m-d H:i:s") && $v['is_force'] ==0):?><!--正在进行中的活动 未强制结束-->
                    <a href="javascript:void(0)" onclick="delete_running()"><?php echo Yii::t('auction','删除');?></a>
				<?php elseif ($v['end_time'] >= date("Y-m-d H:i:s") && $v['start_time'] <= date("Y-m-d H:i:s") && $v['is_force'] ==1):?><!--正在进行中的活动 强制结束-->
				    <a href="javascript:void(0)" onclick="delete_over()"><?php echo Yii::t('auction','删除');?></a>
                <?php elseif ($v['end_time'] < date("Y-m-d H:i:s")):?><!--已结束活动-->
                    <a href="javascript:void(0)" onclick="delete_over()"><?php echo Yii::t('auction','删除');?></a>
                <?php elseif ($v['start_time'] > date("Y-m-d H:i:s")):?><!--未开启与未开始活动-->
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('secKillAuction/delete', array('id'=>$v['id']));?>" onclick="return confirm('确实要删除吗？')"><?php echo Yii::t('auction','删除');?></a>
                <?php endif ?>
            <?php endif ?><!--检查删除权限 end-->
	    
            <?php if ($this->getUser()->checkAccess('SecKillAuction.Update')) : ?><!--检查编辑权限 begin-->
                <a href="<?php echo Yii::app()->createAbsoluteUrl('secKillAuction/update', array('id'=>$v['id']));?>" ><?php echo Yii::t('auction','修改');?></a>
            <?php endif ?><!--检查编辑权限 end-->
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <div class="pager">
    <?php
	    $this->widget('SLinkPager', array(
		    'header' => '',
		    'cssFile' => Yii::app()->baseUrl."/css/reg.css",
		    'firstPageLabel' => Yii::t('page', '首页'),
		    'lastPageLabel' => Yii::t('page', '末页'),
		    'prevPageLabel' => Yii::t('page', '上一页'),
		    'nextPageLabel' => Yii::t('page', '下一页'),
		    'maxButtonCount' => 10,
		    'pages' => $pages,
		    'htmlOptions' => array(
			'class' => 'yiiPageer'
		    )
	    ));
    ?>  
    </div>
</div>

<?php else:?>
<div class="c10"></div>
<div id="second-kill-grid" class="grid-view">
    <table class="tab-reg">
        <thead>
        <tr>
            <th><?php echo $labels['id'];?></th>
            <th><?php echo $labels['goods_name'];?></th>
            <th><?php echo $labels['goods_id'];?></th>
            <th><?php echo $labels['seller_name'];?></th>
            <th><?php echo $labels['start_price'];?></th>
            <th><?php echo $labels['price_markup'];?></th>
			<th><?php echo Yii::t('auction','保留价');?></th>
            <th><?php echo $labels['rules_name'];?></th>
            <th><?php echo $labels['status'];?></th>
            <th><?php echo $labels['create_user'];?></th>
            <th><?php echo $labels['create_time'];?></th>
            <th><?php echo Yii::t('auction','操作');?></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div style ="text-align:center;margin-top:10px;"><?php echo Yii::t('auction','暂无记录');?></div>
</div>
<?php endif ?>
<!--增加开始-->
<div style="display: none" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
    </style>
    <?php 
     $form = $this->beginWidget('ActiveForm', array(
          'id' => $this->id . '-form',
          'enableAjaxValidation' => true,
          'enableClientValidation' => true,
      ));
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>

            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','商品ID');?>
                </th>
                <td class="even" >
                    <input id="goods_id" style="float: left;margin-left: 5px;width:200px;height: 20px;" type="text" name="goods_id" value="">
                    <input id="secKillSearch" onclick="searchProduct();" type="button" value="搜索" class="reg-suba" />
                </td>
            </tr>

            <tr id="confirmTR" style="background:#FFF;">
                <th class="even"  style=" float:left;">
                    <?php echo Yii::t('auction','商品名称');?>
                </th>
                <td class="even" >                   
                   <p id="goods_name"  style="width:250px; word-break:break-all;"></p>
                </td>
            </tr>
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','商家名称');?>
                </th>
                <td class="even" >                                
                    <p id="seller_name"  style="width:250px; word-break:break-all;"></p>
                </td>
            </tr>
             
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','起拍价');?>
                </th>
                <td class="even" >
                   <?php echo $form->textField($model, 'start_price',array('id'=>'start_price')); ?>
                   <?php echo $form->error($model, 'start_price'); ?>
                </td>
            </tr>
           
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','加价幅度');?>
                </th>
                <td class="even" >
                   <?php echo $form->textField($model, 'price_markup',array('id'=>'price_markup')); ?>
                   <?php echo $form->error($model, 'price_markup'); ?>
                </td>
            </tr>
			
			<tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','保留价');?>
                </th>
                <td class="even" >
                   <input type="text" name="reserve_price" id="reserve_price" >
                </td>
            </tr>
			
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','状态');?>
                </th>
                <td class="even" >
                   <?php echo $form->dropDownList($model, 'status', $model->getStatusArray(), array('class' => 'listbox','id'=>'status')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </td>
            </tr>
           
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('auction','所属活动');?>
                </th>
                <td class="even" >
                   <?php echo $form->dropDownList($model, 'rules_setting_id', CHtml::listData($rules,'rules_seting_id','name'),array('class' => 'listbox','id'=>'rules_setting_id')); ?>
                    <?php echo $form->error($model, 'rules_setting_id'); ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>

</div>
<!--增加结束-->

<script type="text/javascript">
    function check_product(code, url, id) {
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: url,
          data: {code: code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', id: id},
          success: function(data) {  
              if (data.success) {
                  $("#goods_name").empty();
                  $("#seller_name").empty();
                  $("#start_price").empty();
                  $("#goods_name").html(data.goodsname);
                  $("#seller_name").html(data.storename);
                  $("#start_price").val(data.startprice);
              } else {
                  $("#goods_name").empty();
                  $("#seller_name").empty();
                  $("#start_price").empty();
                  alert(data.error);
                 
              }
              $('#secKillSearch').removeAttr('disabled');
          }
      });
    }
     
    function searchProduct(){
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/secKillAuction/checkProductId') ?>';
        var id = $("#goods_id").val();
        $('#secKillSearch').attr('disabled', 'disabled');
        check_product(code, url, id);
    }
 
    //添加拍卖商品
    $("#Btn_Add").bind('click',function() {     
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/secKillAuction/add') ?>';
        art.dialog({
            title: '<?php echo Yii::t('sellerOrder', '添加拍卖商品') ?>',
           // okVal: '<?php echo Yii::t('sellerOrder', '确定') ?>',
		    button: [{name: '确定', callback: function () {
				var goods_id = $("#goods_id").val();
                var product_name = $("#goods_name").html();
                var seller_name = $("#seller_name").html();
                var price_markup = $("#price_markup").val();
                var status = $("#status").val();
                var rules_setting_id = $("#rules_setting_id").val();
                var start_price = $("#start_price").val();
				var reserve_price = $("#reserve_price").val();
                var number = parseFloat(document.getElementById('price_markup').value);
                var pnumber = parseFloat(document.getElementById('start_price').value);
				var snumber = parseFloat(document.getElementById('reserve_price').value);

                if (goods_id.length == 0 && status != 'transfering') {
                    alert("<?php echo Yii::t('sellerOrder', '请填写商品ID！'); ?>");
                    return false;
                }
                if (!product_name && !seller_name) {
                    alert("<?php echo Yii::t('sellerOrder', '请点击搜索后再进行添加！'); ?>");
                    return false;
                }
				if (!start_price) {
                    alert("<?php echo Yii::t('sellerOrder', '起拍价不能为空！'); ?>");
					document.getElementById("start_price").focus();
                    return false;
                }
				
                if(isNaN(document.getElementById('start_price').value)){
                  alert("起拍价只能为数字！");
                  document.getElementById("start_price").focus();
                   return false;
                }
                if (pnumber<0) {
                  alert("起拍价不能为负数！");
                  document.getElementById("start_price").focus();
                   return false;
                }
                if (pnumber==0) {
                    alert("起拍价不能为0！");
                    document.getElementById("start_price").focus();
                    return false;
                }
				if (pnumber>99999999) {
                    alert("起拍价已达上限！");
                    document.getElementById("start_price").focus();
                    return false;
                }
                if (!price_markup) {
                    alert("<?php echo Yii::t('sellerOrder', '加价幅度不能为空！'); ?>");
					document.getElementById("price_markup").focus();
                    return false;
                }
                if(isNaN(document.getElementById('price_markup').value)){
                  alert("加价幅度只能为数字！");
                  document.getElementById("price_markup").focus();
                   return false;
                }
                if (number<0) {
                  alert("加价幅度不能为负数！");
                  document.getElementById("price_markup").focus();
                   return false;
                }
                if (number==0) {
                    alert("加价幅度不能为0！");
                    document.getElementById("price_markup").focus();
                    return false;
                }
				if (number>99999999) {
                    alert("加价幅度已达上限！");
                    document.getElementById("price_markup").focus();
                    return false;
                }
				if(isNaN(document.getElementById('reserve_price').value)){
                  alert("保留价只能为数字！");
                  document.getElementById("reserve_price").focus();
                   return false;
                }
                if (snumber<0) {
                  alert("保留价不能为负数！");
                  document.getElementById("reserve_price").focus();
                   return false;
                }
                if (snumber==0) {
                    alert("保留价不能为0！");
                    document.getElementById("reserve_price").focus();
                    return false;
                }
				if (snumber<pnumber) {
                    alert("保留价不能小于起拍价！");
                    document.getElementById("reserve_price").focus();
                    return false;
                }
				if (!rules_setting_id) {
                    alert("<?php echo Yii::t('sellerOrder', '请新建所属活动！'); ?>");
                    return false;
                }
                
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', goods_id: goods_id,price_markup: price_markup,status: status,rules_setting_id: rules_setting_id,start_price: start_price,reserve_price:reserve_price},
                    success: function(data) {
                        if (data.success) {

                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else if(data.is_error) {

                                alert(data.is_error);
                                location.reload();
                            // art.dialog({icon: 'error', content: data.error});
                        } else {
                            alert(data.error);
                        }
                    }
                });
				this
				.button({
                    id: 'button-disabled',
					name: '确定',
                    disabled: true,//防止网络卡而造成重复添加拍卖商品
                });
				return false;
			    }
			
			}] ,
            cancelVal: '<?php echo Yii::t('sellerOrder', '取消') ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
			init: function (){
				$('#goods_id').focus();
			},
           
        });
        return false;
    });
	
    function delete_running(){
        alert("该活动正在进行中,无法删除！")
    }
	
    function delete_over(){
        alert("该活动已结束，无法删除！")
    }
</script>


