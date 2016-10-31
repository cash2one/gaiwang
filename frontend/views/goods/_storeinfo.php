<div class="prodSec">
    <div class="tit">
        <p class="secSeller"><?php echo Yii::t('goods', '安全认证商家'); ?></p>
        <p class="secSellerEn">Safety CE business</p></div>
    <div class="sellerAbout">
        <p class="compName"><?php echo $this->store['name'] ?></p>
        <ul class="evaluate clearfix">
            <li class="like"><?php //echo (int)($this->store['description_match']) && (int)($this->store['comments']) ? sprintf('%.2f', $this->store['description_match'] / $this->store['comments']) : 0 ?></li>
            <li class="like2"><?php //echo (int)($this->store['serivice_attitude']) && (int)($this->store['comments']) ? sprintf('%.2f', $this->store['serivice_attitude'] / $this->store['comments']) : 0 ?></li>
            <li class="like3"><?php //echo (int)($this->store['speed_of_delivery']) && (int)($this->store['comments']) ? sprintf('%.2f', $this->store['speed_of_delivery'] / $this->store['comments']) : 0 ?></li>
        </ul>
        <ul class="der clearfix">
            <li><?php echo Yii::t('goods', '描述相符'); ?></li>
            <li><?php echo Yii::t('goods', '服务态度'); ?></li>
            <li class="margRig"><?php echo Yii::t('goods', '发货速度'); ?></li>
        </ul>

        <span id="star1"></span>
        <strong id="store_score">  <?php //echo $this->store->avg_score ?>分</strong>

        <script>
            //$('#star1').raty({readOnly: true, path: '<?php //echo DOMAIN ?>/js/raty/lib/img/', score: <?php //echo $this->store->avg_score ?>});
        </script>
        <dl class="QQservice">
            <dt><?php echo Yii::t('goods', 'QQ在线客服'); ?>：</dt>
            <?php if (isset($design['CustomerData'])): ?>
                <?php foreach ($design['CustomerData'] as $v): ?>
                    <dd>
                        <?php echo Yii::t('sellerDesign',$v['ContactPrefix']) ?>:
                        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                           class="qqon" target="_blank">
                               <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                        </a>
                    </dd>
                <?php endforeach; ?>
            <?php else: ?>
                <dd><p><?php echo Yii::t('goods', '商家未提供在线客服'); ?></p></dd>
            <?php endif; ?>
        </dl>
        <div class="workDat">
            <strong><?php echo Yii::t('goods', '工作时间'); ?>：</strong>
            <?php if (isset($design['CustomerWorkTime'])): ?>
                <?php foreach ($design['CustomerWorkTime'] as $v): ?>
                    <p><?php echo Yii::t('sellerDesign',$v['MinDate']) ?><?php echo Yii::t('sellerDesign','到')?><?php echo Yii::t('sellerDesign',$v['MaxDate']) ?>：<?php echo $v['MinTime'] ?>-<?php echo $v['MaxTime'] ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo Yii::t('goods', '商家暂未提供工作时间'); ?></p>
            <?php endif; ?>
        </div>
        <div class="goShop">
            <?php echo CHtml::link(Yii::t('goods', '进入店铺'), Yii::app()->createAbsoluteUrl('shop/' . $this->store['id']), array('class' => 'inShop')); ?>
            <!--<a href="#" class="keepShop">收藏店铺</a>-->
        </div>
    </div>
</div>