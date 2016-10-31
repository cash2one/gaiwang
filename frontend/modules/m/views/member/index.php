<?php
/** @var $model Member */
$model = $this->model;

?>
<div class="main memberMain memberMain2">
    <table class="memberList">
        <tr class="memberInfo">
            <td>
                <a href="#">
	    				<span class="memberInfoImg fl">
	    					<?php if ($model->head_portrait): ?>
                                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_128,w_128'), '头像', array('width' => 60)); ?>
                            <?php else: ?>
                                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_128,w_128'), '头像', array('width' => 60)); ?>
                            <?php endif; ?>
                            <span class="memberInfoGrade">
	    						<span class="GradeLeft fl">v</span>
	    						<span class="GradeRight fl">3</span>
	    						<span class="clear"></span>
	    					</span>
	    				</span>
                    <span class="memberInfoName fl"><?php echo $model->username; ?></span>
                    <span class="memberInfoPhone fr"><?php echo substr_replace($model->mobile, '****', 3, 4); ?></span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="#">
                    <span class="menberLeft fl">盖网余额</span>
                    <span class="menberRight fr"><?php echo HtmlHelper::formatPrice($this->account['money']); ?></span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo $this->createAbsoluteUrl('member/wallet'); ?>">
                    <span class="menberLeft fl">我的钱包(new)</span>
                    <span class="menberRight fr">
                        <img width="8" src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc5.png"/>
                    </span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
         
        <tr>
            <td>
                <a href="<?php echo $this->createAbsoluteUrl('member/bankCard'); ?>">
                    <span class="menberLeft fl">我的银行卡</span>
                    <span class="menberRight fr">
                        <img width="8" src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc5.png"/>
                    </span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
         
        <?php  $code = rawurlencode(Tool::lowEncrypt($model->gai_number,'encrypt'));?>

        <tr class="memberBanner">
            <td>
                <a href="javascript:void(0)" onclick="postData(this)">
                    <img src="<?php echo DOMAIN; ?>/images/m/bg/m_img2.png"/>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo $this->createAbsoluteUrl('order/index'); ?>">
                    <span class="menberLeft fl">商城订单</span>
                    <span class="menberRight fr">
                        <img width="8" src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc5.png"/>
                    </span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo $this->createAbsoluteUrl('address/index'); ?>">
                    <span class="menberLeft fl">收货地址</span>
                    <span class="menberRight fr">
                        <img width="8" src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc5.png"/>
                    </span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo $this->createAbsoluteUrl('home/setpassword'); ?>">
                    <span class="menberLeft fl">更改登录密码</span>
                    <span class="menberRight fr"></span>
                    <span class="clear"></span>
                </a>
            </td>
        </tr>
    </table>
    <input type="button" value="退出账户" class="loginSub" onclick="location.href='/home/logout'"/>

    <div id="mebHelp">
        <span>注册送红包说明：</span><br/>
        1、每位新用户只奖励一个注册红包；<br/>
        2、注册获得的红包是盖网红包，可在购物结算时使用;<br/>
        3、符合赠送条件的用户，红包会自动发放到红包账户；<br/>
        4、红包可以在盖象商城购物时使用；<br/>
        5、红包最终解释权归盖网所有，如有任何疑问请咨询盖 网客服。<br/>
        <img class="mebHelpClose" width="20" src="<?php echo DOMAIN; ?>/images/m/bg/m_help_close.png"/>
    </div>
</div>
<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/alertJs.js"></script>
<script>
    function postData(th){
        //使用js post传递flag值给领取红包页面
        var obj = $(th);
        var html = '<form id="ShareForm" action="<?php echo $this->createUrl('home/receiveRedBag',array('code' => $code));?>" method="post"><input type="hidden" id="flag" name="flag" value="share"><input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>"/></form>';
        obj.after(html);
        $('#ShareForm').submit();
    }
</script>
