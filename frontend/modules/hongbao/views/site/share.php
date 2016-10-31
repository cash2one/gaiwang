<?php
Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/ZeroClipboard.min.js");
Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/artDialog/jquery.artDialog.js?skin=aero");
?>
<div class="positionWrap pt10">
    <div class="position"><a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>"><?php echo Yii::t('hongbaoSite', '盖象商城') ?></a>&nbsp;&gt;&nbsp;<a href="<?php echo $this->createAbsoluteUrl('index') ?>"><?php echo Yii::t('hongbaoSite', '盖网红包') ?></a>&nbsp;&gt;&nbsp;<b><?php echo Yii::t('hongbaoSite', '分享奖红包') ?></b></div>
</div>
<style type="text/css">		
	/* colockbox */
	.bg01{overflow:hidden;}
	.colockbox{width:500px;height:123px;position:absolute;right:-60px;top:370px;z-index:5;background:url(/images/bgs/jjopenbg.png) no-repeat;}
	.colockbox span{float:left;font-family:Arial, Helvetica, sans-serif;display:inline-block;width:98px;height:100px;line-height:100px;font-size:80px;text-align:center;color:#ffffff;}		
	.day{margin-left:15px;} 
	.hour{margin-left:6px;}
	.minute{margin-left:52px;}
	.second{margin-left:47px;}	
</style>
<div class="redEnvShare">
    <div class="bg01">
	<div style="width:1200px;margin:0 auto;position:relative;">
		<a style="display:block;width:415px;height:120px;float:right;margin:165px 25px 0 0;" href="<?php echo $this->createAbsoluteUrl('/active/festive/detail',array('id'=>41)); ?>" title="有钱就是任性，马上到红包专场逛一逛！"></a>
		<div class="colockbox" id="demo01">
			<!-- <span class="day">-</span> -->
			<span class="hour">-</span>
			<span class="minute">-</span>
			<span class="second">-</span>
		</div>
	</div>
	</div>
    <div class="bg02">
        <div class="pcon">
            <!--未登录-->
            <?php if (Yii::app()->user->isGuest): ?>
                <div class="unLogin">
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('member/site/index') ?>" title="<?php echo Yii::t('hongbaoSite', '登录分享') ?>" class="icon_v_h loginBtn"><?php echo Yii::t('hongbaoSite', '登录分享') ?></a>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('member/site/index') ?>" title="" class="tipLogin"><?php echo Yii::t('hongbaoSite', '点我登录哦！') ?></a>
                    <i class="icon_v_h arrow"></i>
                </div>
            <?php else: ?>
                <!--已登录分享-->
                <div class="share">
                    <?php $shareUrl = Yii::app()->createAbsoluteUrl('hongbao/site/registerCoupon', array('code' => rawurlencode(Tool::lowEncrypt($model->gai_number, 'encrypt')))) ?>
                    <div  class="bdshare_b left" >
                        <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style" onmouseover="shareMouesOver()">
                            <a class="jiathis_button_qzone"></a>
                            <a class="jiathis_button_tsina"></a>
                            <a class="jiathis_button_tqq"></a>
                            <a class="jiathis_button_weixin"></a>
                            <a class="jiathis_button_renren"></a>
                            <a class="jiathis_button_xiaoyou"></a>
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                        </div>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                        <script type="text/javascript">
                            var shareMouesOver = function() {
                                jiathis_config = {
                                    url: '<?php echo $shareUrl ?>',
                                    title: '520红包等您！约吗？'
                                }
                            };
                        </script>
                        <!-- JiaThis Button END -->
                    </div>
                </div>				
                <!--			<div class="login">-->
                <!--				<textarea class="shareLink">--><?php //echo $shareUrl     ?><!--</textarea>-->
                <!--				<span href="#" title="" class="tipLogin">--><?php //echo Yii::t('hongbaoSite','点此分享！')     ?><!--</span>-->
                <!--				<a href="javascript:;" class="btnCopy">复制</a>-->
                <!--				<i class="icon_v_h arrow"></i>-->
                <!--			</div>-->
                <div class="shareLinks clearfix login">
                    <input type="text" id ="fe_text" class="shareAddr shareLink" value="<?php echo $shareUrl ?>" disabled="true" />
                    <span href="#" title="" class="tipLogin"><?php echo Yii::t('hongbaoSite', '点此分享！') ?></span>
                    <input type="button" id="d_clip_button" class="clip_button btnCopy"  value="<?php echo Yii::t('hongbaoSite', '复制'); ?>" />
                    <i class="icon_v_h arrow"></i>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="bg03"></div>
    <div class="bg04"></div>
    <div class="bg05">
        <div class="pcon">
            <h3><?php echo Yii::t('hongbaoSite', '活动说明：') ?> </h3>
            <div class="desRule">
                <p><?php echo Yii::t('hongbaoSite', '1、用户分享的次数不设上限，同一个分享链接新注册数量不设上限，赠送的红包数量不设上限；') ?></p>
                <p><?php echo Yii::t('hongbaoSite', '2、符合赠送条件的用户，红包会自动发放到红包账户中；') ?></p>
                <p><?php echo Yii::t('hongbaoSite', '3、红包可以在盖象商城购物时使用；') ?></p>
                <p><?php echo Yii::t('hongbaoSite', '4、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服；') ?></p>
            </div>
        </div>
    </div>	
</div>
<script type="text/javascript">
    var client = new ZeroClipboard($('#d_clip_button'));
    client.on('ready', function(event) {
        client.on('copy', function(event) {
            event.clipboardData.setData('text/plain', $('#fe_text').val());
        });
        client.on('aftercopy', function(event) {
            myArtDialog();
        });
    });
    client.on('error', function(event) {
        ZeroClipboard.destroy();
    });
    function myArtDialog() {
        art.dialog({
            icon: 'succeed',
            time: 2,
            content: '复制成功！',
            height: '80px',
            width: '160px'
        });
    }
</script>
<script type="text/javascript" src="http://www.g-emall.com/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		countDown("2015/1/26 21:13:14","#demo01 .day","#demo01 .hour","#demo01 .minute","#demo01 .second");
	});
	
	function countDown(time,day_elem,hour_elem,minute_elem,second_elem){
		//if(typeof end_time == "string")
		var end_time = new Date(time).getTime(),//月份是实际月份-1
		//current_time = new Date().getTime(),
		sys_second = (end_time-new Date().getTime())/1000;
		var timer = setInterval(function(){
			if (sys_second > 0) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				day_elem && $(day_elem).text(day);//计算天
				$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
				$(minute_elem).text(minute<10?"0"+minute:minute);//计算分
				$(second_elem).text(second<10?"0"+second:second);// 计算秒
			} else { 
				clearInterval(timer);
			}
		}, 1000);
	}
</script>	