<?php
/** @var $model Member */
$model = $this->model;
$account = $this->account;
$onWaitReceipt = Order::onWaitReceipt();
$onWaitComment = Order::onWaitComment();
//$total_cash_new = $this->model->getTotalNoCashNew();
?>
<div class="mbDate">
    <div class="mbDate_t"></div>
    <div class="mbDate_c clearfix">
        <div class="mbDate_c_l">
            <dl class="clearfix">
                <dt>
                    <a href="javascript:;" class="mbPic">
                        <?php if ($model->head_portrait): ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_102,w_102'), '头像', array('width' => 102, 'height' => 102)); ?>
                        <?php else: ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_102,w_102'), '头像', array('width' => 102, 'height' => 102)); ?>
                        <?php endif; ?>
                    </a>
                    <?php echo CHtml::link(Yii::t('member','更换头像'), $this->createAbsoluteUrl('member/avatar')); ?>
                </dt>
                <dd>
                    <div class="mgtop10 clearfix">
                        <h3><?php $this->renderPartial('/home/_hello'); ?><?php echo $model->username; ?></h3>
                        <span class="userIcon1"></span><span class="userIcon2"></span><span class="userIcon3"></span>
                        <span class="userJf"><?php echo Yii::t('member','我的积分');?>：<font class="red"><?php echo $account['integral']; ?></font></span>
                        <span class="userJf"><?php echo Yii::t('member','金额');?>：
                            <?php echo HtmlHelper::formatPrice($account['money'],'font',array('class'=>'red')) ?>
                        </span>
<!--                        <span class="userJf">--><?php //echo Yii::t('member','我的红包积分');?><!--：-->
<!--                            <font class="red">--><?php //echo $account['red']; ?><!--</font></span>-->
<!--                        </span>-->
                        <hr/>
                        <a href="<?php echo Yii::app()->createUrl('/member/order/admin',array('Order[delivery_status]'=>3,'Order[status]'=>1,'on'=>'wait'));?>"><?php echo Yii::t('member','待收货');?>(<?php echo $onWaitReceipt; ?>)</a>
                        <a href="<?php echo Yii::app()->createUrl('/member/order/admin',array('Order[is_comment]'=>0,'Order[status]'=>2,'on'=>'comment'));?>"><?php echo Yii::t('member','待评价');?> (<?php echo $onWaitComment?>)</a>
                    </div>
                    <div class="mgtop10"><?php echo Yii::t('member','基本信息条');?>：</div>
                    <div class="progress_container">
                        <div class="progress_bar tip" title="<?php echo $model->infoPercent(); ?>%"></div>
                    </div>
                    <div class="gay95"><?php echo Yii::t('member','提示:您的个人资料目前完成了 {p}%, 您的个人资料不对外显示',array('{p}'=>$model->infoPercent()));?></div>
                </dd>
            </dl>
        </div>
        <div class="mbDate_c_r">
            <div class="userJd">
                <p class="time"><?php echo Yii::t('member',Tool::getWeek()); ?></p>
                <p align="center"><?php echo date('Y-m-d'); ?></p>
                <p style="margin: 10px 0 0 5px;">
                <?php
                $language = Yii::app()->language;
                $language = $language=='zh_cn' ? 'zh-CHS':($language=='zh_tw' ? 'zh-CHT' : 'en');
                ?>
                <iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=U704700475&cid=CHBJ000000&l=<?php echo $language ?>&p=SMART&a=1&u=C&s=7&m=0&x=0&d=1&fc=&bgc=&bc=&ti=0&in=0&li=&ct=iframe" frameborder="0" scrolling="no" width="220" height="20" allowTransparency="true"></iframe>
                </p>
            </div>
        </div>
        <?php if($this->getSession('enterpriseId')): ?>
		<a href="<?php echo $this->createAbsoluteUrl('/seller') ?>" title="进入卖家平台" class="enterSellerCenter"></a>
        <?php endif; ?>
    </div>
    <div class="mbDate_b"></div>
</div>
