<script type="text/javascript">
      //ajax 签收订单
$(".confirmOrder").click(function() {
	       var order_code = $(this).attr("data_code");
	               $.ajax({
	                   type: "POST",
	                   url: "<?php echo $this->createAbsoluteUrl('order/sign') ?>",
	                   data:{
	                       "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
	                       "code": order_code
	                   },
	                   success: function(msg) {
	                       alert(msg);
	                       location.reload();
	                   },
	                    error: function(msg) {
	                    	alert('签收订单失败');
	                    	location.reload();
	                   },
	               }); 
	   });
   </script>