<?php
// 网站地图视图文件
/* @var $this Controller */
?>
<div class="appwapper">
    <div class="siteMapBox">
        <?php $i = 1; ?>
        <?php foreach ($category as $c): ?>
            <dl <?php if ($i % 4 != 0): ?>class="bdright"<?php endif; ?>>
                <dt class="siteIcon_<?php echo $i; ?>"></dt>
                <dd>
                    <h3><?php echo Yii::t('category',$c['name']); ?></h3>
                    <?php if (isset($c['childClass'])): ?>
                        <?php foreach ($c['childClass'] as $child): ?>
                            <?php echo CHtml::link(Yii::t('category',$child['name']), $this->createAbsoluteUrl('/category/view', array('id' => $child['id']))); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </dd>
            </dl>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
<!--    <div class="siteMapBox_1">
        <dl>
            <dt class="siteIcon_15"></dt>
            <dd>
                <h3>关于盖网</h3>
                <a href="" title="公司简介">公司简介</a>
                <a href="" title="公司文化">公司文化</a>
                <a href="" title="盖网优势">盖网优势</a>
            </dd>

        </dl>
        <dl class="mgleft18">
            <dt class="siteIcon_16"></dt>
            <dd>
                <h3>帮助中心</h3>
                <a href="" title="新手指引">新手指引</a>
                <a href="" title="购物指南">购物指南</a>
                <a href="" title="积分说明">积分说明</a>
                <a href="" title="用户服务">用户服务</a>
                <a href="" title="商城服务">商城服务</a>
            </dd>

        </dl>
        <dl class="mgleft18">
            <dt class="siteIcon_17"></dt>
            <dd>
                <h3>联系客服</h3>
            </dd>
        </dl>
    </div>-->
</div>