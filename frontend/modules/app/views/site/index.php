<div class="appBannerbg">
    <div class="banCon">
        <p><?php echo CHtml::link(Yii::t('site','马上体验'), "", array('class'=>"btnGoto",'target'=>"_blank",'title'=>Yii::t('site','马上体验')))?></p>
        <p>
            <?php echo CHtml::link(Yii::t('site','安卓版下载'), $url_android, array('class'=>"btn Android",'target'=>"_blank",'title'=>Yii::t('site','安卓版下载')))?>
            <?php echo CHtml::link(Yii::t('site','苹果版下载(即将开放)'), "", array('class'=>"btn iphone",'target'=>"_blank",'title'=>Yii::t('site','苹果版下载')))?>
        </p>
    </div>
</div>
<div class="appWechatbg clearfix">
    <div class="appWechat">
        <div class="wechatCode">
            <p class="clearfix"><?php echo Yii::t('site','手机扫描二维码可立即下载安装');?>：</p>
            <?php if($url_android):?>
            <span>
                <?php
                $this->widget('comext.QRCodeGenerator', array(
                    'data' => $url_android,
                    'size' => 3.5,
                ));
                ?>
                <em><?php echo Yii::t('site','安卓版');?></em>
            </span>
            <?php else:?>
            <span><img src="<?php echo DOMAIN; ?>/images/bg/APP_wechat02.gif" alt="<?php echo Yii::t('site','手机版二维码');?>" width="112" height="112"/><em><?php echo Yii::t('site','安卓版');?></em></span>
            <?php endif;?>
            <span><img src="<?php echo DOMAIN; ?>/images/bg/APP_wechat02.gif" alt="<?php echo Yii::t('site','手机版二维码');?>" width="112" height="112"/><em><?php echo Yii::t('site','苹果版');?></em></span>
        </div>
        <span class="wechatIco"><?php echo Yii::t('site','手机网页版请访问');?>:<?php echo CHtml::link('app.'.SHORT_DOMAIN, $this->createAbsoluteUrl('/app')); ?></span>
    </div>
</div>
<div class="appwrapper">
    <ul class="appList clearfix">
        <li class="li01">
            <div class="libox">
                <h2><?php echo Yii::t('site','智能搜索');?></h2>
                <em>Intelligent search </em>
                <p><?php echo Yii::t('site','精准的搜索筛选最有价值的信息');?></p>
            </div>
        </li>
        <li class="li02">
            <div class="libox">
                <h2><?php echo Yii::t('site','积分商城');?></h2>
                <em>Integral mall </em>
                <p><?php echo Yii::t('site','使用积分换购商品，新颖购物方式引领时尚潮流');?></p>
            </div>
        </li>
        <li class="li03">
            <div class="libox">
                <h2><?php echo Yii::t('site','酒店预定');?></h2>
                <em>Hotel reservation </em>
                <p><?php echo Yii::t('site','随时随地预定酒店，方便、快捷');?></p>
            </div>
        </li>
        <li class="li04">
            <div class="libox">
                <h2><?php echo Yii::t('site','商品分类');?></h2>
                <em>Classification of goods</em>
                <p><?php echo Yii::t('site','一目了然的分类导航，让你逛得舒心，买得放心');?></p>
            </div>
        </li>
        <li class="li05">
            <div class="libox">
                <h2><?php echo Yii::t('site','精品推荐');?></h2>
                <em>Products recommended </em>
                <p><?php echo Yii::t('site','最实惠最热门的精品推荐，挖掘您最感兴趣的宝贝');?></p>
            </div>
        </li>
        <li class="li06">
            <div class="libox">
                <h2><?php echo Yii::t('site','订单跟踪');?></h2>
                <em>Order tracking </em>
                <p><?php echo Yii::t('site','随时随地查看订单，实时掌握订单状态');?></p>
            </div>
        </li>
    </ul>
</div>