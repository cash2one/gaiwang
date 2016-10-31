<?php
    $this->widget('SLinkPager', array(
        'cssFile' => false,
        'header' => '',
        'firstPageLabel' => Yii::t('category','首页'),
        'lastPageLabel' => Yii::t('category','末页'),
        'prevPageLabel' => Yii::t('category','上一页'),
        'nextPageLabel' => Yii::t('category','下一页'),
        'pages' => $pager,
        'maxButtonCount' => 5,
        'htmlOptions' => array(
            'class' => 'yiiPageer',
        )
    ));
?>