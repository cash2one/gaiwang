<div class="main">
    <div class="position">
        <?php echo CHtml::link(Yii::t('zt', '盖象商城'), DOMAIN) ?> &gt; <b><?php echo Yii::t('zt', '专题首页'); ?></b>
    </div>
    <?php $data = $dataProvider->getData(); ?>
    <?php if (!empty($data)): ?>
        <div class="specialList">
            <ul class="items clearfix">
                <?php foreach ($data as $special): ?>
                    
                    <li<?php echo ($special->end_time <= time()) ? '' : ' class="hotting"'; ?>>
                        <?php
                        echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $special->thumbnail, 'c_fill,h_128,w_347'), $special->name, array(
                            'width' => '347', 'height' => '128')), $this->createAbsoluteUrl('view', array('id' => $special->id)), array('class' => 'img', 'target' => '_blank'));
                        ?>
                        <?php echo CHtml::link($special->name, $this->createAbsoluteUrl('view', array('id' => $special->id)), array('class' => 'name', 'target' => '_blank')); ?>
                        <span class="date">
                            <?php echo Yii::t('zt', '活动日期') . '：';
                            echo date("Y-m-d", $special->start_time) . ' ' . Yii::t('zt', '至') . ' ' . date("Y-m-d", $special->end_time) ?>
                        </span>
                        <span class="logoIcon"></span>
                    </li>
    <?php endforeach; ?>
            </ul>
        </div>
        <div class="pageList">
            <?php
            $this->widget('SLinkPager', array(
                'cssFile' => false,
                'header' => '',
                'firstPageLabel' => Yii::t('page', '首页'),
                'lastPageLabel' => Yii::t('page', '末页'),
                'prevPageLabel' => Yii::t('page', '上一页'),
                'nextPageLabel' => Yii::t('page', '下一页'),
                'pages' => $dataProvider->pagination,
                'maxButtonCount' => 5,
                'htmlOptions' => array(
                    'class' => 'yiiPageer'
                )
            )
            );
            ?>
        </div>
<?php endif; ?>
</div>