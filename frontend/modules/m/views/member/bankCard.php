	
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>member.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>global.css" type="text/css"/>
	</div>
	</div>
	    <div class="main">
	    	<div class="coupnNum">您有<span><?php echo count($model);?></span>张银行卡</div>
	    	<div class="payMethodList">
	    	<ul class="couponList">
	    	<?php foreach($model as $k => $v):?>
	    		<li>
                            <div class="<?php echo $v->bank;?> PMImg"></div>
                            <div class="PMNum">****<?php echo substr($v->bank_num,-4);?></div>
                            <div class="PMType"><?php echo PayAgreement::getCardType($v->card_type)?></div>
                            <div class="clear"></div>
                            <div class="PMInfo">预留手机号码<span><?php echo substr_replace($v->mobile, '****', 3, 6); ?></span></div>
                            <div class="bank-close mBankClose clearfix">				
                                <div class="validate mValidate">
                                    <input type="text" class="inputCode" id="validateCode" name="validateCode" />
                                    <button class="mButton validate-code" data-id="<?php echo $v->mobile;?>">短信验证码</button>
                                    <button class="mButton validate-cancel">取消</button>
                                    <button class="mButton validate-submit" data-id="<?php echo $v->id?>">确定解绑</button>
                                    <input type="hidden" name="reqMsgId" id="reqMsgId" value="<?php echo Tool::buildOrderNo(19,'G');?>">
                                </div>
                                <a href="javascript:;" class="PMClo"  data-id="<?php echo $v->id;?>">关闭快捷支付</a>
                            </div>
	    		</li>
          <?php endforeach;?>
				
               <?php 
//                    $umCode=$this->getParam('code') ? $this->getParam('code') : '1';
//                    $param['gw']=$this->model->gai_number;
//                    $param['retUrl']=$this->createAbsoluteUrl('member/bindCard',array('code'=>$umCode));
//                    $url=OnlineWapPay::bindUm($param);
                 ?>					
                <li style="height:50px">
                    <a class="plusBankCard" href="<?php echo $this->createAbsoluteUrl('member/bindList');?>"></a>	
		</li>
	    	</ul>
	    </div>
	    </div>
	  </div>
  </body>
        <?php if(Yii::app()->user->hasFlash('msg')): ?>
           <script type="text/javascript">
                 alert('<?php echo $this->getFlash('msg'); ?>');
           </script>
        <?php endif;?>  
  <script type="text/javascript" src="<?php echo DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero'?>"></script>
  <?php Yii::app()->ClientScript->registerScriptFile(Yii::app()->theme->baseUrl .'/js/layer/layer.js');?>
  <?php if (Yii::app()->user->hasFlash('tips')):?>
    <script>
        //成功样式的dialog弹窗提示
        art.dialog({
            icon: 'succeed',
            content: '<?php echo Yii::app()->user->getFlash('tips'); ?>',
            ok: true,
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>
  
  <script>
//    $(".PMClo").click(function(){
//        var id = $(this).attr('data-id');
//        art.dialog({
//            title:"关闭快捷支付",
//            content:'您确定要关闭这张银行卡的快捷支付吗？',
//            ok:function(){
//                $.ajax({
//                    type:"POST",
//                    url:"<?php //echo $this->createAbsoluteUrl('/m/member/removeBank') ?>",
//                    data:{id:id,YII_CSRF_TOKEN:"<?php //echo Yii::app()->request->csrfToken;?>"},
//                    success:function(){
//                        this.content = '解绑成功';
//                        location.reload();
//                    }
//                });
//            },
//            cancel:true
//        });
//    });
//    $(document).ajaxStart(function () {
//        if(window.unreadMessageNum) return false;
//        art.dialog({
//            lock: true,
//            content: '<?php //echo Yii::t('sellerOrder', '正在提交请求，请稍后……'); ?>'
//        });
//    });
//    $(document).ajaxError(function () {
//        art.dialog({
//            content: "<?php //echo Yii::t('sellerOrder', '操作失败，请重试'); ?>",
//            ok: function () {
//                document.location.reload();
//            }});
//    });
    var token_csrf = '<?php echo Yii::app()->request->csrfToken; ?>';
    $('.bank-close .validate-cancel').on('click',function(){
       $(this).parent('.validate').hide().siblings('.PMClo').fadeIn(500);
    });
    $(".PMClo").click(function(){
        $(this).hide().siblings('.validate').fadeIn(500);
    });
    var time=59,index;
    $('.bank-close .validate-code').on('click',function(){
        var $this = $(this);
        var mobile = $(this).attr('data-id');
        var reqid=$("#reqMsgId").val();
        $this.text('发送中...').attr('disabled','disabled');
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createAbsoluteUrl('/m/orderConfirm/sendMobileCode') ?>',
            data:{mobile:mobile,reqid:reqid,YII_CSRF_TOKEN:token_csrf},
            dataType:'json',
            success:function(data){
                index = setInterval(function(){
                    if(time < 0){ //倒计时完毕
                        $this.removeAttr('disabled').removeAttr('style').text('再发送...');
                        clearInterval(index);
                        time = 59;
                    } else{
                        if(time<10) time = time;
                        $this.text('发送('+time+')').css('font-size','10px');
                        time--;
                    }
                },1000);
            }
        })
    });
    $('.bank-close .validate-submit').on('click',function(){
        var code = $('#validateCode').val();
        if(jQuery.trim(code) == '') {
            layer.alert("<?php echo Yii::t('sellerOrder', '验证码不能为空');?>",{icon:7});
            return false;
        }
        var reqMsgId = $('#reqMsgId').val();
        var id = $(this).attr('data-id');
        var loader = layer.load();
        $.ajax({
            type:'post',
            url:'<?php echo $this->createAbsoluteUrl('member/unbind')?>',
            data:{reqMsgId:reqMsgId,code:code,id:id,YII_CSRF_TOKEN:token_csrf},
            dataType: 'json',
            success:function(data){
            	layer.confirm(data.tips, {
        			btn: ['<?php echo Yii::t('member','确定') ?>']
        		}, function(){
       			 location.reload();
        		});
            },
            error:function(){
                
            }
        })
    })
    function check(loader,id){
        if(time == 0 ){
            clearInterval(index);
            layer.close(loader);
        } else {
            console.log(time);
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createAbsoluteUrl('member/check')?>',
                data:{id:id,YII_CSRF_TOKEN:token_csrf},
                dataType:'json',
                success:function(data){
                    console.log(data);
                }
            });
            time -= 1;
        }
    }
</script>
</html>
