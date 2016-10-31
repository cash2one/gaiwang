<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember','账户管理')=>'',
    Yii::t('memberMember',' 推荐链接'),
);
?>

<div class="main-contain">
      
  <div class="accounts-box">
      <p class="accounts-title"><?php echo Yii::t('memberMember','推荐链接'); ?></p>
      <div class="featured-box">
          <table class="featured-linka" width="970" border="0">
            <tr class="featured-top">
              <td class="featured-left" style="width:170px;"><?php echo Yii::t('memberMember','普通会员注册链接'); ?></td>
              <td class="featured-right"><?php echo $memberUrl = $this->createAbsoluteUrl('/m/home/register',array('code'=>$code)); ?></td>
            </tr>
            <tr>
              <td class="featured-left"><?php echo Yii::t('memberMember','普通会员注册二维码'); ?></td>
              <td>
                  <div class="share-logo">
                      <?php $this->widget('comext.QRCodeGenerator',array(
                            'data' => $memberUrl,
                            'size'=>3.5,
                        )) ?>
                  </div>
                  <div class="share-link">
                       <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style LinkShare" onmouseover="memberMouesOver()">
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jialike" style="width:60px;" target="_blank">
                                <img  src="http://v3.jiathis.com/code_mini/images/btn/v1/jialike1.gif" border="0" />
                            </a>
                        </div>
                        <!-- JiaThis Button END -->
                  </div>
              </td>
            </tr>
          </table>
          
          <table class="featured-linkb" width="970" border="0">
            <tr class="featured-top">
              <td class="featured-left" style="width:170px;"><?php echo Yii::t('memberMember','企业会员注册链接'); ?></td>
              <td class="featured-right"><?php echo $storeUrl = $this->createAbsoluteUrl('/member/home/registerEnterprise', array('code'=>$code)) ?></td>
            </tr>
            <tr>
              <td class="featured-left"><?php echo Yii::t('memberMember','企业会员注册二维码'); ?></td>
              <td>
                  <div class="share-logo">
                      <?php $this->widget('comext.QRCodeGenerator',array(
                            'data' => $storeUrl,
                            'size'=>3.5,
                        )) ?>
                  </div>
                  <div class="share-link">
                      <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style LinkShare" onmouseover="storeMouesOver()">
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jialike" style="width:60px;" target="_blank">
                                <img  src="http://v3.jiathis.com/code_mini/images/btn/v1/jialike1.gif" border="0" />
                            </a>
                        </div>
                        <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js?uid=1352099433536227" charset="utf-8"></script>
                        <!-- JiaThis Button END -->
                  </div>
              </td>
            </tr>
          </table>

      </div>
  </div>
  
  
</div>

<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
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