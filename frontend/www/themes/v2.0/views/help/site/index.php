<!--主体start-->
<div class="gx-main" style="padding-top:40px;padding-bottom:50px;">
    <div class="help-contain">
        <div class="help-category">
            <div class="help-category-top">常用自助服务</div>
            <ul class="auto-service clearfix">
                <li>
                    <i class="icons icon-01"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'order'))?>" class="service-name">订单查询</a>
                        <p class="service-description">快速查看订单详情、物流情况、确认收货等。</p>
                    </div>
                </li>
                <li>
                    <i class="icons icon-02"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'join'))?>" class="service-name">商家入驻</a>
                        <p class="service-description">方便快速查看商家入驻流程、联系方式等</p>
                    </div>
                </li>
                <li>
                    <i class="icons icon-03"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'machine'))?>" class="service-name">盖网终端机</a>
                        <p class="service-description">快速了解盖网终端机的业务、功能、作用等信息。</p>
                    </div>
                </li>
                <li>
                    <i class="icons icon-04"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'gai score'))?>" class="service-name">盖网积分</a>
                        <p class="service-description">查看盖网积分的定义、作用、好处等内容。</p>
                    </div>
                </li>
                <li>
                    <i class="icons icon-05"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'get score'))?>" class="service-name">积分充值</a>
                        <p class="service-description">快速了解积分的来源</p>
                    </div>
                </li>
                <li>
                    <i class="icons icon-06"></i>
                    <div class="service-info">
                        <a href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => 'forgot password'))?>" class="service-name">账户安全</a>
                        <p class="service-description">修改登录密码、支付密码、手机绑定以提高您的账户安全等。</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="help-category">
            <div class="help-category-top">联系我们</div>
            <ul class="contact-us clearfix">
                <li>
                    <i class="icons qq"></i>
                    <p class="contact-name">在线客服</p>
                    <p class="contact-tip">推荐您首先选择在线客服进行在线咨询，方便更快捷。</p>
                    <a href="<?php echo $this->createAbsoluteUrl('/contact')?>" class="consult">点击咨询</a>
                </li>
                <li>
                    <i class="icons phone"></i>
                    <p class="contact-name">客服热线</p>
                    <p class="contact-phone"><?php echo Tool::getConfig('site','phone') ?></p>
                </li>
                <li>
                    <i class="icons partner"></i>
                    <p class="contact-name">广告合作</p>
                    <p class="contact-phone"><?php echo Tool::getConfig('site','phone') ?></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 主体end -->
