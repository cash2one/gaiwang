<?php
if($pagination){
    $pager = new CPagination;
    $pager->setCurrentPage($pagination['currentPage']-1);
    $pager->setItemCount($pagination['count']);
    $pager->setPageSize($pagination['pageSize']);
    $this->widget('SLinkPager', array(
        'cssFile' => false,
        'header' => '',
        'firstPageLabel' => Yii::t('category', '首页'),
        'lastPageLabel' => Yii::t('category', '末页'),
        'prevPageLabel' => Yii::t('category', '上一页'),
        'nextPageLabel' => Yii::t('category', '下一页'),
        'pages'=> $pager,
        'maxButtonCount' => 5,
        'htmlOptions' => array(
            'class' => 'yiiPageer',
        )
    ));
}
?>