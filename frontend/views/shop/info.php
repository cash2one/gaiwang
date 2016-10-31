<?php
/** @var $this ShopController */
/** @var $store  Store */
$store = $this->store;
?>
<div class="merchantIntro">
    <div class="mIbg">
        <div class="mICon">
            <div class="mItems">
                <h1><?php echo Yii::t('shop', '店铺信息'); ?><b>STORE INFORMATION</b></h1>

                <p>
                    <span class="ico01"><?php echo Yii::t('shop', '公司名'); ?>： <?php echo $store->name ?></span>
                </p>

                <p>
                    <span class="ico02">
                        <?php echo Yii::t('shop', '公司地址'); ?>：
                        <?php echo Region::getName($store->province_id, $store->city_id, $store->district_id); ?>
                        <?php echo $store->street; ?>
                    </span>
                </p>

                <p>
                    <span class="ico03 wh320">
                        <?php echo Yii::t('shop', '创建时间'); ?>
                        ： <?php echo $this->format()->formatDatetime($store->create_time) ?></span>
                    <span class="ico04">
                        <?php echo Yii::t('shop', '在售商品'); ?> ：
                        <?php echo $goodsCount; ?>
                        <?php echo Yii::t('shop', '件'); ?>
                    </span>
                </p>
            </div>
            <div class="mItems">
                <h1><?php echo Yii::t('shop', '联系客服'); ?><b>CONTACT US</b></h1>
                <p>
                    <span class="ico05 wh320">
                        <?php echo Yii::t('shop', '工作时间'); ?>：
                        <?php if (isset($design['CustomerWorkTime'])): ?>
                            <?php foreach ($design['CustomerWorkTime'] as $v): ?>
                                <?php echo $v['MinDate'] ?>-<?php echo $v['MaxDate'] ?>：
                                <?php echo $v['MinTime'] ?>-<?php echo $v['MaxTime'] ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo Yii::t('shop', '商家暂未提供工作时间'); ?>
                        <?php endif; ?>
                    </span>
                    <span class="ico06">
                        <?php if (isset($design['CustomerData'])): ?>
                            <?php echo $design['CustomerTitle'] ?>：
                            <?php foreach ($design['CustomerData'] as $v): ?>
                                <?php echo $v['ContactPrefix'] ?>:
                                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                                   class="qqon">
                                       <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo Yii::t('shop', '商家未提供在线客服'); ?>
                        <?php endif; ?>
                    </span>
                </p>
            </div>
            <div class="mItems score">
                <h1><?php echo Yii::t('shop', '店铺评分'); ?><b>STORE RATINGS</b></h1>
                <ul>
                    <?php $fen = Yii::t('shop', '分') ?>
                    <li>
                        <span class="circle01"><p><b><?php echo (int) $store->description_match && $store->comments ? sprintf('%.2f', $store->description_match / $store->comments) : 0 ?></b><?php echo $fen; ?>
                            </p>
                            <p><?php echo Yii::t('shop', '描述相符'); ?></p></span>
                    </li>
                    <li><span class="circle02"><p><b><?php echo (int) $store->serivice_attitude && $store->comments ? sprintf('%.2f', $store->serivice_attitude / $store->comments) : 0 ?></b><?php echo $fen; ?>
                            </p>
                            <p><?php echo Yii::t('shop', '服务态度'); ?></p></span>
                    </li>
                    <li>
                        <span class="circle03"><p><b><?php echo (int) $store->speed_of_delivery && $store->comments ? sprintf('%.2f', $store->speed_of_delivery / $store->comments) : 0 ?></b><?php echo $fen; ?>
                            </p>
                            <p><?php echo Yii::t('shop', '发货速度'); ?></p></span>
                    </li>
<!--                    <li><span class="circle04"><p><b>4.86</b><?php echo Yii::t('shop', '分'); ?>
                            </p><p><?php echo Yii::t('shop', '更新速度'); ?></p></span></li>
                    <li><span class="circle05"><p><b>4.86</b><?php echo Yii::t('shop', '分'); ?>
                            </p><p><?php echo Yii::t('shop', '价格波动'); ?></p></span>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
    <div class="mIBot"></div>
</div>
