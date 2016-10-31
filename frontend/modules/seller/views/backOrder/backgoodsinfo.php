<link href="<?php echo $this->theme->baseUrl; ?>/styles/seller.css" rel="stylesheet" type="text/css" />

<?php 
$phone      = '400-620-6899';
$expressUrl = Express::getExpressUrl();
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '退换货管理 '),
    Yii::t('sellerGoods', '退换货申请详情')
);
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerOrder','退换货申请详情') ?></h3>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
  <tr>
    <th width="10%"><?php echo Yii::t('sellerOrder','退换货编号'); ?>：</th>
    <td width="30%"><?php echo $order['orderInfo']['exchange_code']; ?></td>
  </tr>
  <tr>
    <th width="10%"><?php echo Yii::t('sellerOrder','订单编号'); ?>：</th>
    <td width="30%"><?php echo $order['orderInfo']['code']; ?></td>
  </tr>
  <tr>
    <th><?php echo Yii::t('sellerOrder','退换货类型'); ?>：</th>
    <td><?php echo $order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN ? '退货' : '退款不退货'; ?></td>
  </tr>
  <tr>
    <th><font color="#FF0000">*</font><?php echo Yii::t('sellerOrder','退款原因'); ?>：</th>
    <td><?php if($order['orderInfo']['exchange_reason'] > 0){
            echo Order::exchangeReason($order['orderInfo']['exchange_reason']);
        }else{
            echo $order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN ? $order['orderInfo']['return_reason'] : $order['orderInfo']['refund_reason'];
        } ?>
    </td>
  </tr>
  <tr>
    <th><font color="#FF0000">*</font><?php echo Yii::t('sellerOrder','退款金额'); ?>：</th>
    <td><font color="#FF0000"><?php echo $order['orderInfo']['exchange_money']; ?></font> <?php echo Yii::t('sellerOrder','元'); ?></td>
  <tr>
  <tr>
    <th><font color="#FF0000">*</font><?php echo Yii::t('sellerOrder','退款说明'); ?>：</th>
    <td><?php echo $order['orderInfo']['exchange_description']; ?></td>
  </tr>
  <tr>
    <th><?php echo Yii::t('sellerOrder','上传凭证'); ?>：</th>
    <td id="uploadimg">
      <div class="th-imgs"><ul>					
        <?php if(!empty($order['orderInfo']['exchange_images'])){
            foreach($order['orderInfo']['exchange_images'] as $key => $value){
        ?>
                <li><img class="uploadimg" src="<?php echo ATTR_DOMAIN.'/'.$value ?>" width="80" height="80" /></li>
        <?php }} ?>
      </ul>
          <div class="th-yt">
              <img title="<?php echo Yii::t('sellerOrder','点击收起'); ?>"  src=""/>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <?php foreach($order['goodsList'] as $key => $value){ 
	    $spec = $value['spec_value'] != '' ? unserialize($value['spec_value']) : array();
	?>
      <div class="th-cp clearfix">
          <img width="80" height="80" src="<?php echo IMG_DOMAIN.'/'.$value['goods_picture'] ?>"/>
          <div class="th-cp-mid">
              <?php echo $value['name'] ?><br/>
              <p><?php foreach($spec as $k=>$v){ echo $k.':'.$v.' ';}?></p>
          </div>
          <div class="th-cp-right">
              <?php echo Yii::t('sellerOrder','单价'); ?>：<?php echo $value['unit_price'] ?><br/>
              <?php echo Yii::t('sellerOrder','数量'); ?>：<?php echo $value['quantity'] ?><br/>
          </div>
      </div>
    <?php } ?>
    <div style="padding-left:170px; font-size:14px;"><?php echo Yii::t('sellerOrder','实付款'); ?>：<?php echo sprintf("%.2f",$order['orderInfo']['pay_price']);?></div>
    </td>  
  </tr> 
  <tr>
    <th><?php echo Yii::t('sellerOrder','买家名称'); ?>：</th>
    <td><?php echo $order['orderInfo']['consignee']; ?></td>
  </tr>
  <tr>
    <th><?php echo Yii::t('sellerOrder','买家地址'); ?>：</th>
    <td><?php echo $order['orderInfo']['address']; ?></td>
  </tr>
  <tr>
    <th><?php echo Yii::t('sellerOrder','买家电话'); ?>：</th>
    <td><?php echo $order['orderInfo']['mobile']; ?></td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="th-schedule clearfix">
        <span class="th-f1"><?php echo Yii::t('sellerOrder','进度说明'); ?>：</span>
       
        <?php if($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_WAITING){//审核中 ======================================================================================= ?>
        
          <?php echo Yii::t('sellerOrder','亲爱的卖家，请审核以上所示服务单信息。请在'); ?> <span id="ddtime" style="color: red" ></span> <?php echo Yii::t('sellerOrder','内处理审核，逾期将可能受到买家的投诉。如需客服介入，致电'),$phone; ?><br/>
          <?php if($order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){ ?>
            <input type="button" id="pass" value="<?php echo Yii::t('sellerOrder','审核通过'); ?>" class="th-btn"/>
          <?php }else{ ?>
            <input type="button" id="pass" value="<?php echo Yii::t('sellerOrder','审核通过并退款'); ?>" class="th-btn"/>
          <?php } ?>
          <input type="button" id="faile" value="<?php echo Yii::t('sellerOrder','审核不通过'); ?>" class="th-btn"/>
        
        
        <?php }elseif($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_NO){//审核不通过 ======================================================================================= ?>
        
          <?php echo $order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN ? Yii::t('sellerOrder','退换货申请不通过，申请失败，') : Yii::t('sellerOrder','退款申请不通过，申请失败，'); ?>
          <?php echo Yii::t('sellerOrder','如需客服介入，致电'),$phone; ?>
          
        
        <?php }elseif($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_RETURN){//等待买家退货 ======================================================================================= ?>
        
          <?php echo Yii::t('sellerOrder','亲爱的卖家，请等待买家退货给您，'); ?><br/>
          <?php echo Yii::t('sellerOrder','提示：如果买家在'); ?> <span class="th-col1" id="ddtime"></span><?php echo Yii::t('sellerOrder','内未退货，系统将会自动取消该退换货申请。'); ?><br/>
          <?php echo Yii::t('sellerOrder','如需客服介入，致电'),$phone; ?>
        
        
        <?php }elseif($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_REFUND){//等待商家退款 ======================================================================================= ?>
        
          <?php echo Yii::t('sellerOrder','亲爱的卖家，请等待买家退货给您'); ?>：<br/>
          <?php echo Yii::t('sellerOrder','买家退货说明'); ?>：<?php echo $order['orderInfo']['exchange_description'];?><br/>
          <?php echo Yii::t('sellerOrder','提示：如果您在'); ?> <span class="th-col1" id="ddtime"></span> <?php echo Yii::t('sellerOrder','内未确认收货，系统将在您的保证金内扣取商品款项，并退款给买家。'); ?>
          <?php echo Yii::t('sellerOrder','如需客服介入，致电'),$phone; ?>
            <?php if(!empty($order['orderInfo']['logistics_company'])){ ?>
          <div class="th-logisticsInfo">
              <span class="th-f1"><?php echo Yii::t('sellerOrder','物流信息'); ?></span>
              <?php echo Yii::t('sellerOrder','快递公司'); ?>： <?php echo $order['orderInfo']['logistics_company'];?> 
              <span class="th-f2"><?php echo Yii::t('sellerOrder','运单号'); ?>： <?php echo $order['orderInfo']['logistics_code'];?></span> 
              <a href="<?php echo $expressUrl[$order['orderInfo']['logistics_company']];?>" target="_blank"><?php echo Yii::t('sellerOrder','点击进入自助查询'); ?></a><br/>
              <span id="express_p"></span>
          </div>
                <?php } ?>
          
          <?php
		  /** @var CActiveForm $form */
		  $form = $this->beginWidget('ActiveForm', array(
			  'id' => 'home-form',
			  'enableAjaxValidation' => false,
			  'enableClientValidation' => true,
			  'clientOptions' => array(
				  'validateOnSubmit' => true,
			  ),
		  ));
		  ?>
          <dl class="th-yz clearfix">
              <dd><span class="th-col1">*</span><?php echo Yii::t('backOrder', '验证码'); ?>：</dd>
              <dd>
              <?php
                echo $form->textField($model, 'verifyCode', array(
                    'class' => 'th-inp1',
                    'placeholder' => Yii::t('backOrder', '输入验证码'),
                ));
              ?>
              </dd>
              <dd><span class="code-num">
                <?php
				  $this->widget('CCaptcha', array(
					  'showRefreshButton' => false,
					  'clickableImage' => true,
					  'id' => 'verifyCodeImg',
					  'imageOptions' => array('alt' => Yii::t('backOrder', '点击换图'), 'title' => Yii::t('backOrder', '点击换图'),'style' => "width:100px;height:30px;")
				  ));
				?>
              </span></dd>
              <dd><span style="padding-left:15px;" onclick="changeVeryfyCode()"> <?php echo Yii::t('sellerOrder','看不清？点击图片更换验证码'); ?></span></dd>
              <dd><?php echo $form->error($model, 'verifyCode',array('class'=>'lg-error')); ?></dd>
          </dl>
          <input type="button" id="trueback" value="<?php echo Yii::t('sellerOrder','确认收货并退款'); ?>" class="th-btn"/>
          <?php $this->endWidget(); ?>
          
          
        <?php }elseif($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_CANCEL){//取消退换货 ======================================================================================= ?>
        
          <?php echo $order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN ? Yii::t('sellerOrder','退货申请已取消，本次服务结束，') : Yii::t('sellerOrder','退款申请已取消，本次服务结束，') ?>
          <?php echo Yii::t('sellerOrder','如需客服介入，致电'),$phone; ?>
        
        
        <?php }elseif($order['orderInfo']['exchange_status'] == Order::EXCHANGE_STATUS_DONE){//完成退换货 ======================================================================================= ?>
          
          <?php
          if($order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){
			  echo Yii::t('sellerOrder','退货成功。退款金额：'.$order["orderInfo"]["exchange_money"].'元。');
		  }else{
			  echo Yii::t('sellerOrder','退款成功。退款金额：'.$order["orderInfo"]["exchange_money"].'元。');
		  } 
		  echo Yii::t('sellerOrder','如需客服介入，致电'),$phone; 
		  if($order['orderInfo']['exchange_type'] == Order::EXCHANGE_TYPE_RETURN && !empty($order['orderInfo']['logistics_company'])){//退货显示物流信息
		  ?>
          <div class="th-logisticsInfo">
              <span class="th-f1"><?php echo Yii::t('sellerOrder','物流信息');?></span>
              <?php echo Yii::t('sellerOrder','快递公司');?>：<?php echo $order['orderInfo']['logistics_company'];?>
              <span class="th-f2"><?php echo Yii::t('sellerOrder','运单号');?>：<?php echo $order['orderInfo']['logistics_code'];?></span>
              <a href="<?php echo $expressUrl[$order['orderInfo']['logistics_company']];?>" target="_blank"><?php echo Yii::t('sellerOrder','点击进入自助查询');?></a><br/>
              <span id="logistics"></span>
              <!--<a href="<?php echo $this->createAbsoluteUrl('backGoodsInfo/lookupExpress', array('code' => $order['orderInfo']['code']));?>" target="_blank"><?php echo Yii::t('sellerOrder','更多物流信息');?></a>-->
          </div>
          <?php }//显示物流结束 ?>
        <?php }?>
      </div>
    </td>
  </tr>
</table>


<!--弹窗开始-->
<div class="popup-bg pop-success">
    <div class="popup-overlay"></div>
    <div class="popup-box">
        <h3><?php echo Yii::t('sellerOrder','信息提示'); ?><i></i></h3>
        <p class="message"><?php echo Yii::t('sellerOrder','提交成功，本次退货服务已通过审核！'); ?></p>
        <p class="determine"><a class="sellerBtn05"><span><?php echo Yii::t('sellerOrder','确定'); ?></span></a></p>
    </div>
</div>
<div class="popup-bg pop-failure">
    <div class="popup-overlay"></div>
    <div class="popup-box" id="popup-box">
        <h3><?php echo Yii::t('sellerOrder','不通过原因'); ?><i></i></h3>
        <p class="input-box"><textarea id="back_reason" class="sellerBtn15" placeholder="<?php echo Yii::t('sellerOrder','2-200汉字。请具体和如实地说明不通过审核原因'); ?>"></textarea></p>
        <p class="determine"><a class="sellerBtn05" id="submit"><span><?php echo Yii::t('sellerOrder','提交'); ?></span></a>
            <a class="sellerBtn05" id="button_cancel"><span><?php echo Yii::t('sellerOrder','取消'); ?></span></a>
        </p>
    </div>
</div>
<!--弹窗结束-->
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');?>
<script language="javascript">
    var token = "<?php echo Yii::app()->request->csrfToken;?>";
    function msg(result){
        art.dialog({
            icon: result['type'],
            content: result['content'],
            ok: true,
            okVal:'<?php echo Yii::t('backOrder','确定'); ?>',
            title:'<?php echo Yii::t('backOrder','消息'); ?>'
        });
        $('.aui_close').click(function(){
            $('.popup-bg').css('display','none');
        })
        $('.aui_state_highlight').click(function(){
            $('.popup-bg').css('display','none');
            if(result['url'] != '') window.location.href=result['url'];
        })
    }
	
	//点击旁边的刷选验证码
	function changeVeryfyCode() {
		jQuery.ajax({
			url: "<?php echo Yii::app()->createUrl('/backOrder/captcha/refresh/1'); ?>",
			dataType: 'json',
			cache: false,
			success: function(data) {
				jQuery('#verifyCodeImg').attr('src', data['url']);
				jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
			}
		});
		return false;
	}
	
	function showHide01(m,objname,n){
		for(var i=0;i<=n;i++){
			$("#"+objname+i).css('display','none');
		}
		$("#"+objname+m).css('display','block');
	}
	
    $(function(){


        $('#trueback').click(function(){
            $('.popup-bg').css('display','block');
            $('.popup-box').css('display','none');
            var verifyCode = $('#Order_verifyCode').val();
            if(verifyCode.length < 4){
                art.dialog({
                    icon: 'warning',
                    content: "<?php echo  Yii::t('backOrder','验证码不能为空，且长度是4位数！'); ?>",
                    ok: true,
                    okVal:'<?php echo Yii::t('backOrder','确定') ?>',
                    title:'<?php echo Yii::t('backOrder','消息') ?>'
                });
                return false;
            };

            $.ajax({
                type:'POST',
                url:"<?php echo $this->createAbsoluteUrl('/seller/backOrder/methodback'); ?>",
                data:{'order_id':<?php echo $order['orderInfo']['id'] ?>,'exchange_type':<?php echo $order['orderInfo']['exchange_type']; ?>,'pass_status':1,'YII_CSRF_TOKEN':token,'refund_status':<?php echo $order['orderInfo']['refund_status']; ?>,'return_status':<?php echo $order['orderInfo']['exchange_status']; ?>,'verify_code':verifyCode},
                dataType : 'json',
                success : function(result){
                    msg(result)
                }
            })

        })

        $('#pass').click(function(){
            $('.popup-bg').css('display','block');
            $('.popup-box').css('display','none');
            $.ajax({
                type:'POST',
                url:"<?php echo $this->createAbsoluteUrl('/seller/backOrder/methodback'); ?>",
                data:{'order_id':<?php echo $order['orderInfo']['id'] ?>,'exchange_type':<?php echo $order['orderInfo']['exchange_type']; ?>,'pass_status':1,'YII_CSRF_TOKEN':token,'refund_status':<?php echo $order['orderInfo']['refund_status']; ?>,'return_status':<?php echo $order['orderInfo']['exchange_status']; ?>},
                dataType : 'json',
                success : function(result){
                    msg(result)
                }
            })
        })
        $('#submit').click(function(){
            var reason = $('#back_reason').val();
            if(reason.length < 2 ){
                $(".pop-failure").css("display","none");
                art.dialog({
                    icon: 'warning',
                    content: '<?php echo Yii::t('backOrder','2-200汉字。请具体和如实地说明不通过审核原因'); ?>',
                    ok: true,
                    okVal:'<?php echo Yii::t('backOrder','确定'); ?>',
                    title:'<?php echo Yii::t('backOrder','消息'); ?>'
                });
                return false;
            }

            $.ajax({
                type:'POST',
                url:"<?php echo $this->createAbsoluteUrl('/seller/backOrder/methodback'); ?>",
                data:{'order_id':<?php echo $order['orderInfo']['id']; ?>,'exchange_type':<?php echo $order['orderInfo']['exchange_type']; ?>,'pass_status':2,'YII_CSRF_TOKEN':token,'refund_status':<?php echo $order['orderInfo']['refund_status']; ?>,'return_status':<?php echo $order['orderInfo']['exchange_status']; ?>,'back_reason':reason},
                dataType : 'json',
                success : function(result){
                    $(".pop-failure").css("display","none");
                    msg(result)
                }
            })
        })
        $('#faile').click(function(){
            $(".pop-failure").css("display","block");
        })
        $('#button_cancel').click(function(){
            $(".pop-failure").css("display","none");
        })
    });
	
	$(function(){
		var height = parseInt($(document).height())-81;
		$("#menu").css('height',height);
		$(".th-imgs ul li img").click(function(){
			$(".th-yt").show();
			var imgSrc=$(this).attr("src");
			$(".th-yt").find("img").attr("src",imgSrc);
		});
		$(".th-yt img").click(function(){
			$(".th-yt").hide();
		});
	})

</script>

<?php
$status = $order['orderInfo']['exchange_status'];
if( $status == Order::EXCHANGE_STATUS_REFUND || $status == Order::EXCHANGE_STATUS_RETURN || $status == Order::EXCHANGE_STATUS_WAITING){ 
$times = 0;

if($status == Order::EXCHANGE_STATUS_REFUND){//等待卖家退款 10天
	$times = $order['orderInfo']['exchange_examine_time'] + 3600*24*10 - time();
}else if($status == Order::EXCHANGE_STATUS_RETURN){//等待买家退货 七天
	$times = $order['orderInfo']['exchange_examine_time'] + 3600*24*7 - time();
}else if($status == Order::EXCHANGE_STATUS_WAITING){//审核中 七天
	$times = $order['orderInfo']['exchange_apply_time'] + 3600*24*7 - time();
}
?>
<script language="javascript">
    function GetRTime(times,Element){
        var t = times;
        var d=Math.floor(t/60/60/24);
        var h=Math.floor(t/60/60%24);
        var m=Math.floor(t/60%60);
        var s=Math.floor(t%60);
        Element.html(d + " 天 " + h + " 时 "+ m + " 分 " +  s + " 秒 ");

    }
    $(function(){

        var num = 1;
        var times = <?php echo $times; ?>;
        setInterval(function(){
            $('#ddtime').each(function(){
                GetRTime(times-num,$(this))
                num++
            })
        },1000);
    })
	
</script>
<?php } ?>


<script language="javascript">

    /*$('.popup-overlay').click(function(){
        $('.pop-failure').css('display','none');
    })*/

    <?php if($order['orderInfo']['logistics_company']!='' && $order['orderInfo']['logistics_code']!=''){?>
    $(document).ready(function(e) {
        var url = "<?php echo $this->createUrl('backOrder/getExpressStatus', array('store_name'=>$order['orderInfo']['logistics_company'], 'code'=>$order['orderInfo']['logistics_code'], 'time'=>time(),'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken)); ?>";

        $.getJSON(url, function(data) {
            if (data.status != 200) {
                $("#express_p,#logistics").after('<p>'+data.message+'</p>');
            } else {
                var html = '';
                var icon = '';
                $.each(data.data, function(i, item) {
                    html += ' <span>'+item.time+'  '+item.context+'</span></p>';
                });

                html += '<p class="log-tip"><?php echo Yii::t('backOrder', '注：以上部分信息来自第三方');?></p>';
                $("#express_p,#logistics").after(html);
            }
        });
    });

    <?php }?>
</script>