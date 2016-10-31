<div  class="tabCon" id="tabCon_ul_5">
    <?php if ($cd = $dataProvider->getData()): ?>
        <div class="recordTitle">
            <span class="rT01"><?php echo Yii::t('goods', '买家'); ?></span>
            <span class="rT02"><?php echo Yii::t('goods', '商品名称'); ?></span>
            <span class="rT03"><?php echo Yii::t('goods', '总价'); ?></span>
            <span class="rT04"><?php echo Yii::t('goods', '购买数量'); ?></span>
            <span class="rT05"><?php echo Yii::t('goods', '成交时间'); ?></span>
            <span class="rT06"><?php echo Yii::t('goods', '状态'); ?></span>
        </div>
    <?php endif; ?>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id' => 'completeLists',
        'dataProvider' => $dataProvider,
        'itemView' => 'completeview',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'record',
        'template' => '{items}{pager}',
        'pagerCssClass' => 'CommentsPager pageList',
        'emptyText' => Yii::t('goods', '对不起，目前还没有相关成交记录信息！'),
        'cssFile' => false,
        'htmlOptions' => array('class' => ''),
        'pager' => array(
            'cssFile' => false,
            'header' => '',
            'firstPageLabel' => Yii::t('goods', '首页'),
            'lastPageLabel' => Yii::t('goods', '末页'),
            'prevPageLabel' => Yii::t('goods', '上一页'),
            'nextPageLabel' => Yii::t('goods', '下一页'),
            'pages' => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'htmlOptions' => array(
                'class' => 'yiiPageer'
            )
        ),
    ));
    ?>
</div>