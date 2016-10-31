<table>
    <tr>
        <th width="15%"><?php echo Yii::t('auction', '状态');?></th>
        <th width="15%"><?php echo Yii::t('auction', '竞拍人');?></th>
        <th width="45%"><?php echo Yii::t('auction', '价格');?></th>
        <th width="25%"><?php echo Yii::t('auction', '时间');?></th>
    <tr>
</table>
<?php
    $this->widget('zii.widgets.CListView', array(
        'id' => 'recordLists',
        'dataProvider' => $dataProvider,
        'itemView' => 'recordView',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'comments',
        'template' => '{items}{pager}',
        'pagerCssClass' => 'CommentsPager pageList',
        'emptyText' => '<span style="padding-left: 25px;">'.Yii::t('auction', '对不起，目前还没有出价记录！').'</span>',
        'cssFile' => false,
        'htmlOptions' => array('class' => ''),
        'pager' => array(
            'cssFile' => false,
            'header' => '',
            'firstPageLabel' => Yii::t('auction', '首页'),
            'lastPageLabel' => Yii::t('auction', '末页'),
            'prevPageLabel' => Yii::t('auction', '上一页'),
            'nextPageLabel' => Yii::t('auction', '下一页'),
    //            'pages' => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'htmlOptions' => array(
                'class' => 'yiiPageer'
            )
        ),
    ));
?>

