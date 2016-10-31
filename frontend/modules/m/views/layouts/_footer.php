<?php if ($this->footer): ?>
      <div class="footer" style="position:static;bottom:0px;z-index:0;">
          <p class="copyright mgbot30 mgtop20">客户端 <br/>
                 Copyright © m.g-emall.com 版权所有<br/>
                                                   珠海横琴新区盖网通传媒有限公司<br/>
           <a href="<?php echo $this->createAbsoluteUrl('site/about'); ?>">公司简介</a>/
           <a href="<?php echo $this->createAbsoluteUrl('site/contact'); ?>">联系我们</a><br/>
          </p>
        </div>
    </div>

    <!-- Float Navigation -->
    <div class="floatNav">
        <a class="floatCart item" href="<?php echo $this->createAbsoluteUrl('cart/index'); ?>">购物车</a>
        <a class="floatTop item" href="javascript:void(0)">返回顶部</a>
    </div>
<?php endif; ?>

<?php
//cnzz 统计
$cs = new Cs(1254128071);
echo '<img src="'.$cs->trackPageView().'" width="0" height="0"/>';
?>
