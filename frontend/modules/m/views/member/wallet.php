<?php
/* @var $this RedEnvelopeController */
/* @var $model RedEnvelope */
//获取会员红包账户过期时间
$validEnd = Yii::app()->db->createCommand()
    ->select('valid_end')
    ->from('{{member_account}}')
    ->where('member_id=:member_id',array(':member_id'=>$this->model->id))
    ->queryScalar();
?>
</div>
</div>
	    <div class="main wmMain">
	    	<div class="qbItem2 qbItem3">
		    	<div class="fl">
    				<span>我的余额</span>
    			</div>
    			<div class="fr"><?php echo HtmlHelper::formatPrice($this->account['money']);?></div>
    			<div class="clear"></div>
		    </div>
	    	<div class="qbItem1">
	    		<div class="fl mwLeft">
    				<a href="<?php echo $this->createAbsoluteUrl('member/red');?>" ><span>我的红包</span></a>
    				<span id="clock"></span>
    				<img class="mebHelp" width="20" src="<?php echo DOMAIN; ?>/images/m/bg/m_help.png"/>
    			</div>
    			<div class="fr qbIoc"><?php echo HtmlHelper::formatPrice($this->account['red']);?></div>
    			<div class="clear"></div>
	    	</div>
            <?php  $code = rawurlencode(Tool::lowEncrypt($this->model->gai_number,'encrypt'));?>
            <div class="memberBanner">
                <a href="javascript:void(0)" onclick="postData(this)">
                    <img src="<?php echo DOMAIN; ?>/images/m/bg/m_img2.png"/>
                </a>
            </div>
		     <div id="mebHelp">
				<span>有效期时间说明：</span><br/>
				红包的余额是有使用的有效期，当有效期时间变为0时，红包余额清零。
				<img class="mebHelpClose" width="20" src="<?php echo DOMAIN; ?>/images/m/bg/m_help_close.png"/>
			</div>
	    </div>
  <script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
  <script src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
  <?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');?>
  
  <script>
  //ajax 红包充值
  function recharge(id) {
      $.ajax({
          type: "POST",
          url: "<?php echo $this->createAbsoluteUrl('redEnvelope/getRed') ?>",
          dataType: 'json',
          data: {
              "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
              "id": id
          },
          success: function(msg) {
              art.dialog({
                  icon: 'succeed',
                  lock: true,
                  content: msg.tip,
                  okVal: '<?php echo Yii::t('member', '确定') ?>',
                  title: '<?php echo Yii::t('member', '消息') ?>',
                  ok: function() {
                      location.reload();
                  }
              });
          }
      });
  }

  /*时间倒计时*/
    var validEnd = '<?php echo date('Y/m/d H:i:s',$validEnd)?>';
    var redMoney='<?php echo $this->account['red'];?>';
    if(redMoney="" || redMoney=="0.00"){
         $('#clock').css("display","none");
      }
    $('#clock').countdown(validEnd, function(event) {
        $(this).html(event.strftime('有效期还剩：<br /> %D 天 %H:%M:%S'));
    });

    function postData(th){
        //使用js post传递flag值给领取红包页面
        var obj = $(th);
        var html = '<form id="ShareForm" action="<?php echo $this->createUrl('home/receiveRedBag',array('code' => $code));?>" method="post"><input type="hidden" id="flag" name="flag" value="share"><input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>"/></form>';
        obj.after(html);
        $('#ShareForm').submit();
    }
</script>
