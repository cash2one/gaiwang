<?php

$this->widget('zii.widgets.CListView', array(
    'id' => 'commentLists',
    'dataProvider' => $dataProvider,
    'itemView' => 'commentview',
    'itemsTagName' => 'ul',
    'itemsCssClass' => 'comments',
    'template' => '{items}{pager}',
    'pagerCssClass' => 'CommentsPager pageList',
    'emptyText' => Yii::t('hotelSite', '暂无数据！'),
    'cssFile' => false,
    'htmlOptions' => array('class' => ''),
    'pager' => array(
        'cssFile' => false,
        'header' => '',
        'firstPageLabel' => Yii::t('hotelSite', '首页'),
        'lastPageLabel' => Yii::t('hotelSite', '末页'),
        'prevPageLabel' => Yii::t('hotelSite', '上一页'),
        'nextPageLabel' => Yii::t('hotelSite', '下一页'),
        'pages' => $dataProvider->pagination,
        'maxButtonCount' => 5,
        'htmlOptions' => array(
            'class' => 'yiiPageer'
        )
    ),
));
?>