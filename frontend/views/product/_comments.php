<div class="tabCon"  id="tabCon_ul_4">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id' => 'commentLists',
        'dataProvider' => $dataProvider,
        'itemView' => 'commentview',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'comments',
        'template' => '{items}{pager}',
        'pagerCssClass' => 'CommentsPager pageList',
        'emptyText' => Yii::t('goods', '对不起，目前还没有相关评论信息！'),
        'cssFile' => false,
        'htmlOptions' => array('class' => ''),
        'pager' => array(
            'cssFile' => false,
            'header' => '',
            'firstPageLabel' => Yii::t('goods', '首页'),
            'lastPageLabel' => Yii::t('goods', '末页'),
            'prevPageLabel' => Yii::t('goods', '上一页'),
            'nextPageLabel' => Yii::t('goods', '下一页'),
//            'pages' => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'htmlOptions' => array(
                'class' => 'yiiPageer'
            )
        ),
    ));
    ?>
</div>