<div class="main">
    <div class="linksFriend">
        <div class="position2">
<!--            <a href="#" title="">首页</a> -->
            <?php echo CHtml::link(Yii::t('link','首页'), '/', array('title' => Yii::t('link','首页'))) ?> &gt; <?php echo Yii::t('link','友情链接')?>
        </div>
        <?php //$data = $dataProvider->getData(); ?>
        <div class="linksFriendlList">
            <ul class="items clearfix">
                <?php if (!empty($links)): ?>

                    <?php foreach ($links as $val): ?>
                        <li>
                            <!--<a href="#" title="">拉手网团购</a>-->
                            <?php echo CHtml::link($val['name'], $val['url'], array('title' => $val['name'],'target'=>'_blank')) ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="pageList">
        </div>
    </div>


</div>