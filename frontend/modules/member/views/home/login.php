<style type="text/css">
    /*登陆弹窗*/
    .loginWindowBox{display:none;width:100%; height:505px;position:absolute;top:0px;_top:0px;left:0;z-index:97; background:none;}
	.onlineSer { display:none;}
</style>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/jquery.placeholder.js'); ?>
<!--处理IE6中透明图片兼容问题-->
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo DOMAIN ?>/js/DD_belatedPNG.js" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('.loginBox01,.loginBox02,.loginBox01 .loginForm .loginbutton,.loginbgPic');
</script>
<![endif]-->
<script>
    document.domain = "<?php echo substr(DOMAIN, 11) ?>";
    $(function() {
        $(".inputtxt, .inputtxtCode").placeholder();
    });
</script>
<div class="loginbox login">
    <!-- 登陆弹窗 begin-->
    <div class="loginWindowBox" id="loginWindowBox">
        <div class="loginBox01">
            <div class="loginTit"><img src="<?php echo DOMAIN; ?>/images/bg/loginbgtit1.gif" width="245" height="35"/></div>
            <div class="loginForm">
                <?php
                /** @var CActiveForm $form */
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'home-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <span class="userNameSpan">
                    <?php
                    echo $form->textField($model, 'username', array('class' => 'inputtxt01',
                        'placeholder' => Yii::t('memberHome', '会员编号 / 用户名 /公司名称 /手机号'),
                        'onkeyup' => "this.value=this.value.replace(/(^\s+)|(\s+$)/g,'')",
                    ));
                    if(!empty($users)){
                        echo CHtml::label(
                            Yii::t('memberHome', '{mobile}绑定了多个盖网编号，请选择',array('{mobile}'=>$model->username)),
                            'gai_number',array('style'=>'color:##FF0000;background:#FFFFC0;padding:2px 1px;'));
                        echo CHtml::dropDownList('gai_number','',$users,array('style'=>'width:235px;'));
                    }
                    ?>
                    <?php echo $form->error($model, 'username'); ?>
                </span>
                <span class="passWordSpan">
                    <?php
                    echo $form->passwordField($model, 'password', array(
                        'class' => 'inputtxt02',
                    ));
                    ?>
                    <?php echo $form->error($model, 'password'); ?>

                </span>
                <?php if (LoginForm::captchaRequirement()): ?>
                    <span class="mgt">
                        <?php
                        echo $form->textField($model, 'verifyCode', array(
                            'class' => 'inputtxtCode',
                            'placeholder' => Yii::t('memberHome', '验证码:'),
                        ));
                        ?>
                        &nbsp;
                        <i class="changeCode" onclick="changeVeryfyCode()">
                            <?php
                            $this->widget('CCaptcha', array(
                                'showRefreshButton' => false,
                                'clickableImage' => true,
                                'id' => 'verifyCodeImg',
                                'imageOptions' => array('alt' => Yii::t('memberHome', '点击换图'), 'title' => Yii::t('memberHome', '点击换图'))
                            ));
                            ?>
                        </i>
                        <?php echo $form->error($model, 'verifyCode'); ?>
                        <script>
        //点击旁边的刷选验证码
        function changeVeryfyCode() {
            jQuery.ajax({
                url: "<?php echo Yii::app()->createUrl('/member/home/captcha/refresh/1') ?>",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    jQuery('#verifyCodeImg').attr('src', data['url']);
                    jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                }
            });
            return false;
        }
                        </script>
                    </span>
                <?php endif; ?>
                <span class="mgb">
                    <?php echo $form->checkBox($model, 'rememberMe'); ?><?php echo $form->label($model, 'rememberMe') ?>&nbsp;|
                    <?php echo CHtml::link(Yii::t('memberHome', '忘记密码'), array('/member/home/resetPassword'), array('target' => '_blank')) ?>&nbsp;
                </span>
				<div class="lg_coagent">
					<div class="lg_font1">使用合作网站账号登录盖象：</div>
					<ul class="lg_list">
						<li>
							<a href="<?php echo DOMAIN.'/sociallogin/duimian'?>">
							  <img src="<?php echo DOMAIN ?>/images/bgs/duimian.png" alt="对面登陆"/>
							</a>
							<span>|</span>
						</li>
						<li>
							<a href="<?php echo DOMAIN.'/sociallogin/weibo'?>">
							  <img src="<?php echo DOMAIN ?>/images/bgs/weibo.png" alt="微博登陆"/>
							</a>
							<span>|</span>
						</li>
						<li>
							<a href="<?php echo DOMAIN.'/sociallogin/qq'?>">
							  <img src="<?php echo DOMAIN ?>/images/bgs/qq.png" alt="QQ登陆"/>
							</a>
							<!-- <span>|</span>-->
						</li>
						<!--  
						 <li>
							<script type="text/javascript">
								$(document).ready(function(){
									
									$(".lg_list dl").hover(function(){
										$(this).find("dd").show();
										$(this).addClass("lg_sel_dl");
									},function(){
										$(this).find("dd").hide();
										$(this).removeClass("lg_sel_dl");
										})
								})
							</script>
							
							<dl>
								<dt>其他<b></b></dt>
								<dd>
									<a href="#" title="">人人</a>	
									<a href="#" title="">网易</a>
									<a href="#" title="">支付宝</a>
									<a href="#" title="">新浪微博</a>
									<a href="#" title="">豆瓣</a>
									<a href="#" title="">搜狐</a>
									<a href="#" title="">开心网</a>
									<a href="#" title="">奇虎360</a>
									
									<div class="c"></div>
								</dd>
							</dl>    		
						</li>
						 -->
					</ul>
				</div>
                <span>
                    <?php echo CHtml::linkButton(Yii::t('memberHome', '登录'), array('class' => 'loginbutton', 'id' => 'login')) ?>
                </span>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="loginBox02">
            <div class="loginTit">
                <?php echo CHtml::image(DOMAIN . '/images/bg/loginbgtit2.gif') ?>
                <p><?php echo Yii::t('site', '注册即享受在线选座，轻松购票！'); ?></p>
                <p><?php echo Yii::t('site', '注册得积分，抵票价！'); ?></p>
                <?php echo CHtml::link(Yii::t('site', Yii::t('site', '>>我要注册')), $this->createAbsoluteUrl('/member/home/register'), array('title' => Yii::t('site', '我要注册'))); ?>
            </div>
            <a class="loginbgPic"> </a>
        </div>
    </div>
    <div class="blackOverlay blackOverlax" id="fade"></div>


    <script type="text/javascript">

        document.onkeydown = function(event) {
            // alert(event);
            e = event ? event : (window.event ? window.event : null);
            if (e.keyCode == 13) {
                $('#home-form').submit();
            }
        }
    </script>
    <script>
        <?php
            /** @var $this Controller */
            if(!$this->getSession('activation')):
        ?>
        //判断登陆状态,如果登陆成功,就跳转到会员中心页面.因为某些浏览器第一次不会跳转到会员中心页面
        window.countTime = 0;
        si = setInterval(function(){
            countTime++;
            if(countTime>3) clearInterval(si);
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createAbsoluteUrl('/member/home/checkLogin') ?>",
                dataType:'json',
                data: {
                    "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>"
                },
                success:function(data){
                    if(data.status){
                        window.location.href="<?php echo $this->createAbsoluteUrl('/member') ?>";
                    }
                }
            });
        },3000);
        <?php else: ?>
        art.dialog({
            content: '<strong>您当前为首次登录盖象商城<br/>请激活盖象商城帐号</strong>',
            ok: function(){
                document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/activation')?>";
            },
            okVal:'<?php echo Yii::t('member','登录并激活') ?>',
            title:'<?php echo Yii::t('member','消息提示') ?>',
            lock:true,
            esc:false,
            cancel:function(){
                document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/logout')?>";
            },
            cancelVal:"<?php echo Yii::t('member','取消') ?>",
            width:420,
            height:210
        });
        <?php endif; ?>
    </script>

</div>
<!-- 登陆弹窗 end-->