<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember','账户管理')=>'',
    Yii::t('memberMember',' 推荐链接'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','推荐链接'); ?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
		        	<span class="titleLink">
                    	<h2><?php echo Yii::t('memberMember','推荐链接'); ?></h2>
                        <p><?php echo Yii::t('memberMember','更快地进入更多活动内容'); ?></p>
                    </span>
                <div class="tLinkCon">
                    <span class="tLC01 h40 tred" style="line-height:40px;"><?php echo Yii::t('memberMember','普通会员注册链接'); ?></span>
                    <span class="tLC02 h40">
                        <?php echo $memberUrl = $this->createAbsoluteUrl('/m/home/register',
                            array('code'=>$code)) ?>
                    </span>
                    <span class="tLC01 h145"><?php echo Yii::t('memberMember','普通会员注册二维码'); ?></span>
                    <span class="tLC02 h145 twhite">
                        <?php $this->widget('comext.QRCodeGenerator',array(
                            'data' => $memberUrl,
                            'size'=>3.5,
                        )) ?>
                        <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style LinkShare" onmouseover="memberMouesOver()">
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jialike" target="_blank">
                                <img  src="http://v3.jiathis.com/code_mini/images/btn/v1/jialike1.gif" border="0" />
                            </a>
                        </div>
                        <!-- JiaThis Button END -->
                    </span>

                    <span class="tLC01 h40 tred" style="line-height:40px;"><?php echo Yii::t('memberMember','企业会员注册链接'); ?></span>
                    <span class="tLC02 h40">
                        <?php echo $storeUrl = $this->createAbsoluteUrl('/member/home/registerEnterprise',
                            array('code'=>$code)) ?>
                    </span>
                    <span class="tLC01 h145"><?php echo Yii::t('memberMember','企业会员注册二维码'); ?></span>
                    <span class="tLC02 h145 twhite">
                        <?php $this->widget('comext.QRCodeGenerator',array(
                            'data' => $storeUrl,
                            'size'=>3.5,
                        )) ?>
                        <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style LinkShare" onmouseover="storeMouesOver()">
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jialike" target="_blank">
                                <img  src="http://v3.jiathis.com/code_mini/images/btn/v1/jialike1.gif" border="0" />
                            </a>
                        </div>
                        <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js?uid=1352099433536227"
                                charset="utf-8"></script>
                        <!-- JiaThis Button END -->
                    </span>
                </div>

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>

<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode("#sendMobileCode","#Member_mobile");
    });
</script>

<!-- JiaThis Button BEGIN -->
<script type="text/javascript">
    var jiathis_config = {
        url: '<?php echo $memberUrl ?>',
        title: "<?php echo Yii::t('memberMember','盖网普通会员注册推荐'); ?>"
    };
    var storeMouesOver = function () {
        jiathis_config = {
            url: '<?php echo $storeUrl ?>',
            title: "<?php echo Yii::t('memberMember','盖网企业会员注册推荐'); ?>"
        }
    };
    var memberMouesOver = function () {
        jiathis_config = {
            url: '<?php echo $memberUrl ?>',
            title: "<?php echo Yii::t('memberMember','盖网普通会员注册推荐'); ?>"
        }
    };

</script>
<!-- JiaThis Button END -->