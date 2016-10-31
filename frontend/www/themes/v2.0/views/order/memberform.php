<link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/help.css" rel="stylesheet" type="text/css" />
    <?php
		  $form = $this->beginWidget('ActiveForm', array(
			  'id' => 'order-member-form',
			  'enableAjaxValidation' => true,
			  'enableClientValidation' => true,
			  'clientOptions' => array(
				  'validateOnSubmit' => false, //客户端验证
			  ),
			  //'action' => '/address/index',
		  	  'htmlOptions' => array('enctype' => 'multipart/form-data'),
		  ));
		  ?>
<div class="zt-wrap" id="dataBody">			
		<div class="aviation-resign-01">
			<div class="zt-con">
				<div class="resign-wrap">
					<div class="form-group">
						<input type="text" name="member" value="<?php echo $this->getUser()->gw;?>" readonly/>
						<input type="text" name="code" value="<?php echo $code;?>" readonly/>
						<a href="javascript:void(0)" class="btn verify">校验</a>
					</div>
					<div class="data-warp">
						<div class="step">
							<span>1</span>
							<span class="contact_line"></span>
							<a href="javascript:void(0)" class="icon"><i></i></a>
							<div class="clear"></div>
						</div>
						<div class="form-group info-wrap">
							<div class="fl customer_name">
								<label>姓名</label>
								<input type="text" name="OrderMember[1][name]" placeholder="姓名">
							</div>
							<div class="fr customer_sex">
								<label>性别</label>
								<a href="javascript:void(0)" data-sex="1" class="btn fl" data-attr="1">男</a>
								<a href="javascript:void(0)" data-sex="1" class="btn fr" data-attr="2">女</a>
							    <input type="hidden" id="sexData_1" name="OrderMember[1][sex]">
							</div>
							<div class="clear"></div>
							<div class="customer_id">
								<label>身份证号码</label>
								<input type="text" name="OrderMember[1][identity_number]" placeholder="440***************"/>
							</div>
							<div class="idCard idCard_1">
								<label>身份证正面</label>
								<div class="btn-group fl">
									<a href="javascript:void(0)" class="btn uploadBtn fl">上传
										<input type="file" name="identityImg_front_img_1" class="uploadImage"/>
									</a>
									<div class="img_preview"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="idCard idCard_2">
								<label>身份证反面</label>
								<div class="btn-group fl">
									<a href="javascript:void(0)" class="btn fl uploadBtn">上传
										<input type="file" name="identityImg_back_img_1" class="uploadImage"/>
									</a>
									<div class="img_preview"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="contacts">
								<label>联系方式</label>
								<input type="text" name="OrderMember[1][mobile]" placeholder="电话号码"/>
								<label>联系地址</label>
								<input type="text" name="OrderMember[1][street]" placeholder="具体地址"/>
								<!-- 
								<label>特殊说明</label>
								<input type="text" name="OrderMember[1][remark]" placeholder="特殊说明"/>
							   -->
							</div>
						</div>
					</div>
					<div class="submit-group">
						<a href="javascript:void(0)" class="btn submit_btn fl">提交</a>
						<a href="javascript:void(0)" class="btn save_add fr">新增</a>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<img src="<?php echo $this->theme->baseUrl.'/'; ?>images/ordermem/aviation-resign.png"/ alt="飞天航空">
		</div>
<?php $this->endWidget(); ?>
		<div class="layer"></div>
		<!-- 校验订单号时提示信息 -->
		<div class="error_tips error_nopay">
			<p>订单未支付，请先支付订单</p>
			<p>订单支付完成，才可填写资料</p>
			<a href="<?php echo $this->createUrl('order/payv2', array('code' => $this->getParam('code')));?>" class="btn go_buy">去支付</a>
			<a href="javascript:void(0)" class="btn cancel">关闭</a>
		</div>
		<div class="error_tips error_nocode">
			<p>订单不存在，请到商城购买产品</p>
			<p>支付完成后，才可填写资料</p>
			<a href="http://zt.g-emall.com/site/aviation" class="btn go_buy">马上购</a>
			<a href="javascript:void(0)" class="btn cancel">关闭</a>
		</div>
		<!-- END -->
		<!-- 提交成功时提示信息 -->
		<div class="success_tips success_return">
			<div class="success_logo"></div>
			<p id="returnMsg">已提交成功！</p>
			<a href="javascript:void(0)" class="cancel">返回</a>
		</div>
		<!-- END -->	
	<!--提交订单时客户端验证提示信息  -->	
		<div class="success_tips msg_tips">
			<div class="success_logo"></div>
			<p id="msg_tips">请将信息补充完整！</p>
			<a href="javascript:void(0)" class="cancel">返回</a>
		</div>
	<!-- END -->
	</div>   
   <!--------------主体 End------------>
<!-- 返回顶部 end-->
<script type="text/javascript">
$(function(){
	function contact_line(){
		$('.contact_line').css({width:'100%'});
		var oWidth = $('.contact_line').width();
		$('.contact_line').css({width:oWidth-68});
	}
	contact_line();
	$(window).resize(function(){
		contact_line();
	})
	//性别选项
	$(document).on('click','.customer_sex .btn',function(){
		$(this).siblings().removeClass('active');
		$(this).toggleClass('active');
		var sex=$(this).attr("data-attr");
		var data=$(this).attr("data-sex");
		$("#sexData_"+data).val(sex);
	})
	//身份证缩略图
	$(document).on("change",".uploadImage", function(){
    // Get a reference to the fileList
	    var files = !!this.files ? this.files : [];	 
	    // If no files were selected, or no FileReader support, return
	    if (!files.length || !window.FileReader) return; 
	    // Only proceed if the selected file is an image
	    if (/^image/.test( files[0].type)){ 
	        // Create a new instance of the FileReader
	        var reader = new FileReader(); 
	        // Read the local file as a DataURL
	        reader.readAsDataURL(files[0]);	 
	        // When loaded, set image data as background of div
	        var _this = $(this);
	        reader.onloadend = function(){
	       		_this.parent('.uploadBtn').siblings('.img_preview').css({"background-image":"url("+this.result+")","background-size":"100%"});        
	        }	 
	    }	 
	})
	//内容信息展开收起
	$(document).on('click','.icon',function(){
		//收起--展开
		if($(this).hasClass('unfold')){
			$('.icon').addClass('unfold');
			$(this).removeClass('unfold');
			$('.info-wrap').slideUp();
			$(this).parents('.step').siblings('.info-wrap').slideDown();
		}
		//展开--收起
		else{
			//$('.icon').addClass('unfold');
			$(this).addClass('unfold');
			$(this).parents('.step').siblings('.info-wrap').slideUp();
		}
	})
	//保存并添加
	$(document).on('click','.save_add',function(){
		$('.info-wrap').slideUp();
		$('.icon').addClass('unfold');
		var stepLen = $('.step').length;
		var dataLen=stepLen+1;
		var ohtml = 	'<div class="data-warp">'+
							'<div class="step">'+
								'<span>'+dataLen+'</span>'+
								'<span class="contact_line"></span>'+
								'<a href="javascript:void(0)" class="icon"><i></i></a>'+
								'<div class="clear"></div>'+
							'</div>'+
							'<div class="form-group info-wrap">'+
								'<div class="fl customer_name">'+
									'<label>姓名</label>'+
									'<input type="text" name="OrderMember['+dataLen+'][name]" placeholder="姓名">'+
								'</div>'+
								'<div class="fr customer_sex">'+
									'<label>性别</label>'+
									'<a href="javascript:void(0)" data-sex='+dataLen+' class="btn fl" data-attr="1">男</a>'+
									'<a href="javascript:void(0)" data-sex='+dataLen+' class="btn fr" data-attr="2">女</a>'+
									'<input type="hidden" id="sexData_'+dataLen+'" name="OrderMember['+dataLen+'][sex]">'+
								'</div>'+
								'<div class="clear"></div>'+
								'<div class="customer_id">'+
									'<label>身份证号码</label>'+
									'<input type="text" name="OrderMember['+dataLen+'][identity_number]" placeholder="440***************"/>'+
								'</div>'+
								'<div class="idCard idCard_1">'+
									'<label>身份证正面</label>'+
									'<div class="btn-group fl">'+
										'<a href="javascript:void(0)" class="btn uploadBtn fl">上传'+
											'<input type="file" name="identityImg_front_img_'+dataLen+'" class="uploadImage"/>'+
										'</a>'+
										'<div class="img_preview"></div>'+
									'</div>'+
									'<div class="clear"></div>'+
								'</div>'+
								'<div class="idCard idCard_2">'+
									'<label>身份证反面</label>'+
									'<div class="btn-group fl">'+
										'<a href="javascript:void(0)" class="btn fl uploadBtn">上传'+
											'<input type="file" name="identityImg_back_img_'+dataLen+'" class="uploadImage"/>'+
										'</a>'+
										'<div class="img_preview"></div>'+
									'</div>'+
									'<div class="clear"></div>'+
								'</div>'+
								'<div class="contacts">'+
									'<label>联系方式</label>'+
									'<input type="text" name="OrderMember['+dataLen+'][mobile]" placeholder="电话号码"/>'+
									'<label>联系地址</label>'+
									'<input type="text" name="OrderMember['+dataLen+'][street]" placeholder="具体地址"/>'+	
								'</div>'+
							'</div>'+
						'</div>';
		$('.submit-group').before(ohtml);
		contact_line();
	})
	$('.data-warp').hide();
	//校验按钮
	$('.verify').click(function(){
		var checkUrl = "<?php echo $this->createAbsoluteUrl('order/checkOrderMem',array('code'=>$code));?>";
		 $.ajax({
			 type:'get',
             url: checkUrl,
             dataType:'json',
             success: function (data) {
                 if (data.errorCode == 3){
                	 $('.data-warp').show();
          			 $('.submit-group').show(); 
                 }else if(data.errorCode == 1){
                	 $('.layer').show();
          			 $('.error_nocode').show();
                   }else{
                	 $('.layer').show();
          			 $('.error_nopay').show();
                }
             }
         });
	})
	//错误提示--关闭
	$('.error_tips .cancel').click(function(){
		$('.error_tips').hide();
		$('.layer').hide();
	})
	//提交按钮
	var validateForm = function () {
            var valid = true;
            $('#dataBody [name*="OrderMember"]').each(function (i, ele) {
                if (!$(ele).val()) {
                	$('.layer').show();
                	$('#msg_tips').html("请将信息补充完整");
            		$('.msg_tips').show();
                    valid = false;
                }    
            });
            $('#dataBody [name*="identity_number"]').each(function (i, ele) {
                var code=$(ele).val();
                	if(!code || !/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/.test(code)){
                		$('.layer').show();
                    	$('#msg_tips').html("身份证号有误，请重新输入！");
                		$('.msg_tips').show();
                        valid = false;
                    }
            });
            $('#dataBody [name*="mobile"]').each(function (i, ele) {
            	var mobile=$(ele).val();
            	if(!mobile || !/(^1[34578]{1}\d{9}$)|(^852\d{8}$)/.test(mobile)){
            		$('.layer').show();
                	$('#msg_tips').html("手机号码有误，请重新输入！");
            		$('.msg_tips').show();
                    valid = false;
                }    
            });    
            $('#dataBody [name*="identityImg_"]').each(function (i, ele) {
                if (!$(ele).val()) {
                	$('.layer').show();
                	$('#msg_tips').html("请上传身份证件！");
            		$('.msg_tips').show();
                    valid = false;
                }    
            });   
            return valid;
        };
        
	$('.submit_btn').click(function(){
		if (!validateForm()) {
            return false;
        }else{
		   $("#order-member-form").submit();
        }
	})
	//提交成功--返回
	$('.success_tips .cancel').click(function(){
		$('.success_tips').hide();
		$('.layer').hide();
	})
	var tips="<?php echo $this->getParam('tips');?>";	
	if(tips==2){
		$('.layer').show();
		$('.success_return').show();
	}else if(tips==1){
		$('.layer').show();
		$("#returnMsg").html("数据提交失败！");
		$('.success_return').show();
    }else{
    	$('.layer').hide();
		$('.success_return').hide();
      }
})
</script>
</body>
</html>