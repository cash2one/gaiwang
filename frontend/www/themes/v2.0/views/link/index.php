<link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/help.css" rel="stylesheet" type="text/css" />
<div class="friendly-link">
    <div class="caption"><?php echo Yii::t('link','友情链接');?></div>
    <div class="link-list">
        <?php if(!empty($links)): ?>
          <?php $i = 0;?>
          <?php foreach($links as $v):?>
              <?php if($i == 0):?>
                  <div class="row clearfix">
              <?php endif;?>
              <?php if($i%5 == 0 && $i != 0):?>
                  </div>
                  <div class="row clearfix">
                      <a href="<?php echo $v['url']?>" target="_blank" title="<?php echo Yii::t('link',$v['name']);?>"><?php echo Yii::t('link',$v['name']);?></a>
              <?php else:?>
                  <a href="<?php echo $v['url']?>" target="_blank" title="<?php echo Yii::t('link',$v['name']);?>"><?php echo Yii::t('link',$v['name']);?></a>
              <?php endif;?>
              <?php $i++;?>
          <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</div>
<div class="apply-link">
    <div class="caption"><?php echo Yii::t('link','申请友情链接');?></div>
    <div class="clearfix">
        <div class="instruction">
            <h3><?php echo Yii::t('link','申请步骤');?></h3>
            <div class="details">
                <div class="item">
                    1.<?php echo Yii::t('link','首先请先在贵站做好盖象商城的文字链接');?>。
                    <p class="sub-item"><?php echo Yii::t('link','链接文字');?>：<?php echo Yii::t('link','盖象商城');?></p>
                    <p class="sub-item"><?php echo Yii::t('link','链接地址');?>：<a href="http://www.g-emall.com" title="<?php echo Yii::t('link','盖象商城');?>">http://www.g-emall.com</a></p>
                </div>
                <div class="item">2.<?php echo Yii::t('link','做好链接后,请按照右边的联系方式及时联系我们，盖象商城只接受申请文字友情链接');?>。</div>
                <div class="item">3.<?php echo Yii::t('link','已经开通我站友情链接且内容键康,符合本站友情链接要求的网站');?>：<?php echo Yii::t('link','百度权重');?>≥4，<?php echo Yii::t('link','谷歌pr值');?>≥2，<?php echo Yii::t('link','经盖象商城管理员审核后，可以显示在此友情链接页面');?>。</div>
            </div>
        </div>
        <div class="contact">
            <h3><?php echo Yii::t('link','申请联系方式');?></h3>
            <p class="item">1.<?php echo Yii::t('link','联系QQ');?>：3020854499</p>
            <p class="item">2.<?php echo Yii::t('link','联系邮箱');?>：SEO.guangzhou@g-emall.com</p>
        </div>
    </div>
</div>