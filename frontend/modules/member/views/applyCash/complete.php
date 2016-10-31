<?php
/* @var $this ApplyCashController */
$this->breadcrumbs = array(
    Yii::t('memberApplyCash', '积分管理'),
    Yii::t('memberApplyCash', '兑现完成'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span>兑现完成</span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox "><h3> <?php echo Yii::t('memberApplyCash', '兑现完成'); ?></h3></div>
                <div class="upladBox">
                    <span class="integralCnTxt1"><?php echo Yii::t('memberApplyCash', '1.申请兑现'); ?></span>
                    <span class="integralCnTxt2"><?php echo Yii::t('memberApplyCash', '2.确认兑现'); ?></span>
                    <span class="integralCnTxt3"><?php echo Yii::t('memberApplyCash', '3.兑现完成'); ?></span>
                </div>
                <div class="upladBox mgtop20 mgbottom20">
                    <a class="integralBg"></a>
                    <span class="integralCnIcon1"></span>
                    <span class="integralCnIcon2" style=" background-position: -799px -86px;"></span>
                    <span class="integralCnIcon3" style=" background-position: -799px -86px;"></span>
                </div>
                <div class="clearfix"></div>
                <span class="successicon">
					<dl>
                        <dt>
                            <img src="<?php echo DOMAIN ?>/images/bg/seller_iconSuccess.gif" width="71" height="70">
                        </dt>
                        <dd>
                            <p class="name"><?php echo Yii::t('memberApplyCash','您的积分兑换现金申请已经成功递交!'); ?></p>
                            <p class="txt"><?php echo Yii::t('memberApplyCash','如果您的银行卡信息设置不正确导致兑换失败，
                            用于兑换的积分会自动返回您的账户。祝您在盖网购物愉快~'); ?></p>
                        </dd>
                    </dl>
				</span>

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
