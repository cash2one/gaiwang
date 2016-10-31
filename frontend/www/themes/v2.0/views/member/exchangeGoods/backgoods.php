<!--主体start-->

<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('member', '您的位置')?>：</span>
        <a href="<?php echo Yii::app()->createAbsoluteUrl('/member/site/index') ?>"><?php echo Yii::t('member', '首页')?></a>
        <span>&gt</span>
        <a href="<?php echo Yii::app()->createAbsoluteUrl('/member/exchangeGoods/admin') ?>">售后服务</a>
        <span>&gt</span>
        <a href="#"><?php echo Yii::t('member', '退换货申请')?></a>
    </div>
    <div class="returns-product">
        <div class="returns-product">
            <div class="returns-top">
                <p class="returns-title cover-icon"><?php echo Yii::t('member', '售后服务详情')?></p>
                <div class="returns-process clearfix">
                    <div class="returns-process-item on">
                        <p class="number">1</p>
                        <p class="txtle"><?php echo Yii::t('member', '买家 提交申请')?></p>
                        <span class="returns-backdrop on"></span>
                    </div>

                    <div class="returns-process-item">
                        <p class="number">2</p>
                        <p class="txtle"><?php echo Yii::t('member', '商家 处理申请')?></p>
                        <span class="returns-backdrop"></span>
                    </div>

                    <div class="returns-process-item">
                        <p class="number">3</p>
                        <p class="txtle"><?php echo Yii::t('member', '完成')?></p>
                    </div>
                </div>
                <div class="returns-refund">
                    <p class="refund-title"><?php echo Yii::t('member', '请选择售后申请类型')?></p>
                    <a class="a1" href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/returnGoods', array('code'=>$this->getParam('code'))); ?>"><?php echo Yii::t('member', '我要退货')?></a>
                    <?php if($orderType != Order::SOURCE_TYPE_AUCTION):?>
                        <a class="a2"href="<?php echo Yii::app()->createAbsoluteUrl('/member/exchangeGoods/returnNullGoods',array('code'=>$this->getParam('code'))) ?>"><?php echo Yii::t('member', '我要退款')?><span><?php echo Yii::t('member', '无需退货')?></span></a>
                    <?php endif;?>
                </div>
            </div>

            <?php $this->renderPartial('_orderinfo',array('orderInfo'=>$this->orderInfo)); ?>
        </div>
    </div>
</div>
<!-- 主体end -->