<?php
/* @var $this Controller */
$infos = Article::helpInfo();
?>
<div class="sliderWrap left">
    <div class="help">
        <span class="fl">
            <h3><?php echo Yii::t('help','帮助中心');?></h3>
            <p>HELP CENTER</p>
        </span>
        <span class="hlepIcon_1"></span>
    </div>
    <div class="hlepitems">
        <?php $i = 0; ?>
        <?php foreach ($infos as $v): ?>
            <dl <?php if (isset($article) && ($article['category_id'] == $v['id'])): ?>class="cur"<?php elseif (($this->id == 'site') && $i == 0): ?>class="cur"<?php endif; ?>>
                <dt><a onclick="showHide(this, 'items<?php echo $i; ?>');" class="on"><?php echo Yii::t('help', $v['name']) ?></a></dt>
                <dd id="items<?php echo $i; ?>" style="display: block;">
                    <ul>
                        <?php foreach ($v['child'] as $c): ?>
                            <li>
                                <?php echo CHtml::link(isset($article) && $article['alias'] == $c['alias'] ? '<font class="over">' . Yii::t('help', $c['title']) . '</font>' : Yii::t('help', $c['title']) , $this->createAbsoluteUrl('/help/article/view', array('alias' => $c['alias']))); ?>
                            </li> 
                        <?php endforeach; ?>
                    </ul>
                </dd>
            </dl>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    <!--在线客服 start-->
    <div class="OnlineService">
        <span class="onlineSvIcon_1"></span>
        <span class="fr"><p><?php echo Yii::t('help','在线客服');?></p><span><?php echo Yii::t('help','有什么问题或建议可以联系我们');?></span></span>
    </div>
    <!--在线客服End-->
    <!--在线电话 start-->
    <div class="onlineTelephone">
        <span class="onlineTeleIcon_1"></span>
        <span class="fl"><p><?php echo Yii::t('help','在线电话');?></p><b><?php echo Tool::getConfig('site','phone') ?></b></span>
    </div>
    <!--在线电话 end-->
</div>   