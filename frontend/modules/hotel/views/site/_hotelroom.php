<?php
$this->widget('zii.widgets.CListView', array(
    'id' => 'hotelRoomLists',
    'dataProvider' => $dataProvider,
    'itemView' => 'hotelroomview',
    'itemsTagName' => 'ul',
    'itemsCssClass' => 'room_off',
    'template' => '{items}{pager}',
    'pagerCssClass' => 'pageList',
    'emptyText' => Yii::t('hotelSite', '暂无房间！'),
    'cssFile' => false,
    'htmlOptions' => array('class' => ''),
    'ajaxUpdate' => false,
    'enablePagination' => false,
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