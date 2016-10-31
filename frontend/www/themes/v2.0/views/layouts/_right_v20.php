  <!-- 右侧浮动菜单statr -->
  <div class="gx-rightFD">
      <a href="<?php echo Yii::app()->createUrl('orderFlow');?>" class="gx-FDShopping" title="<?php echo Yii::t('site', '购物车');?>">
          <span class="gx-FDShopping-ioc01"></span>
          <?php echo Yii::t('site', '购');?></br><?php echo Yii::t('site', '物');?></br><?php echo Yii::t('site', '车');?></br>
          <span class="gx-FDShopping-num">0</span>
      </a>
      <a href="<?php echo Yii::app()->createUrl('member/goodsCollect');?>" title="<?php echo Yii::t('site', '我的收藏');?>" class="gx-collection">
          <span class="gx-collection-tc1">
              <span><?php echo Yii::t('site', '我的收藏');?></span>
          </span>
      </a>
      <span title="<?php echo Yii::t('site', '二维码');?>" class="gx-collection gx-collection2">
          <span class="gx-collection-tc2">
              <?php
              $this->widget('comext.QRCodeGenerator', array(
                  'data' => 'http://a.app.qq.com/o/simple.jsp?pkgname=com.gemall.gemallapp',
                  'size' => 3.6,
                  'imageTagOptions'=>array('width'=>71,'height'=>71),
              ));
              ?>
              盖象优选APP
              <?php
              $this->widget('comext.QRCodeGenerator', array(
                  'data' =>'http://weixin.qq.com/r/j0gpMaHEfvwBreVS9x2d',
                  'size' => 3.6,
                  'imageTagOptions'=>array('width'=>71,'height'=>71),
              ));
              ?>
              关注微信公众号
          </span>
      </span>
      <a href="javascript:goToTop();" title="<?php echo Yii::t('site', '返回顶部');?>" class="gx-collection gx-collection3">
          <span class="gx-collection-tc1">
              <span><?php echo Yii::t('site', '返回顶部');?></span>
          </span>
      </a>
      <a href="<?php echo Yii::app()->createUrl('help/feedback');?>" title="<?php echo Yii::t('site', '意见反馈');?>" class="gx-collection gx-collection4" style="display:none">
          <span class="gx-collection-tc1">
              <span><?php echo Yii::t('site', '意见反馈');?></span>
          </span>
      </a>
  </div>
  <!-- 右侧浮动菜单end -->
<script language="javascript">
function goToTop(){
    $('body,html').animate({scrollTop:0},500);
}
</script>  