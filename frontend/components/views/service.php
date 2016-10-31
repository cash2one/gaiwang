<?php if ($this->getController()->id != 'goods'): ?>
    <div class="editor serviceTime" id="contact">
        <div class="items">
            <?php if (isset($design['CustomerData'])): ?>
                <h3><?php echo Yii::t('sellerDesign',$design['CustomerTitle']) ?></h3>
                <?php foreach ($design['CustomerData'] as $v): ?>
                    <p><?php echo $v['ContactPrefix'] ?>:
                        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                           class="qqon" target="_blank">
                            <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                        </a>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo Yii::t('goods', '商家未提供在线客服'); ?></p>
            <?php endif; ?>
            <h3 class="workTime"><?php echo Yii::t('goods', '工作时间'); ?></h3>
            <?php if (isset($design['CustomerWorkTime'])): ?>
                <?php foreach ($design['CustomerWorkTime'] as $v): ?>
                    <p><?php echo Yii::t('sellerDesign',$v['MinDate']) ?><?php echo Yii::t('sellerDesign','到')?> <?php echo Yii::t('sellerDesign',$v['MaxDate']) ?>：
                        <?php echo $v['MinTime'] ?>-<?php echo $v['MaxTime'] ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo Yii::t('goods', '商家暂未提供工作时间'); ?></p>
            <?php endif; ?>

        </div>
    </div>
<?php else: ?>

    <div class="sliderBox shopDecri">
        <div class="notbg">
            <i class="ico_sab"></i>

            <h1><?php echo Yii::t('goods', '安全认证商家'); ?></h1>
            <b>Security authentication businesses</b>
        </div>
        <div class="items">
            <h2><?php echo $this->store['name'] ?></h2>
            <span class="ico_star"><?php echo $this->store->avg_score ?><?php echo Yii::t('goods', '分'); ?></span>
            <ul class="score clearfix">
                <li><h3><?php echo Yii::t('goods', '描述相符'); ?></h3><span
                        class="decScore dS01"><?php echo $this->store['description_match'] ?></span></li>
                <li><h3><?php echo Yii::t('goods', '服务态度'); ?></h3><span
                        class="decScore dS02"><?php echo $this->store['serivice_attitude'] ?></span></li>
                <li><h3><?php echo Yii::t('goods', '发货速度'); ?></h3><span
                        class="decScore dS03"><?php echo $this->store['speed_of_delivery'] ?></span></li>
            </ul>

            <h4 class="workTime"><?php echo Yii::t('goods', '工作时间'); ?></h4>
            <?php if (isset($design['CustomerWorkTime'])): ?>
                <?php foreach ($design['CustomerWorkTime'] as $v): ?>
                    <p><?php echo $v['MinDate'] ?>到 <?php echo $v['MaxDate'] ?>：
                        <?php echo $v['MinTime'] ?>-<?php echo $v['MaxTime'] ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo Yii::t('goods', '商家暂未提供工作时间'); ?></p>
            <?php endif; ?>

            <?php if (isset($design['CustomerData'])): ?>
                <h2 class="gray"><?php echo $design['CustomerTitle'] ?></h2>
                <?php foreach ($design['CustomerData'] as $v): ?>
                    <p><?php echo $v['ContactPrefix'] ?>:
                        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                           class="qqon" target="_blank">
                            <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                        </a>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo Yii::t('goods', '商家未提供在线客服'); ?></p>
            <?php endif; ?>

            <p class="enterShopWrap">
                <?php echo CHtml::link(Yii::t('goods', '进入店铺'), Yii::app()->createAbsoluteUrl('shop/' . $this->store->id), array('class' => 'enterShop'));
                ?>
            </p>
        </div>
    </div>

<?php endif; ?>