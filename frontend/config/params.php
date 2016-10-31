<?php

return array(
    'maxAddress' => 12,
    'customCUButton' => array(
        'class' => 'CButtonColumn',
        'header' => Yii::t('home', '操作'),
        'template' => '{update}{delete}',
        'updateButtonLabel' => Yii::t('home', '编辑'),
        'updateButtonImageUrl' => false,
        'deleteButtonLabel' => Yii::t('home', '删除'),
        'deleteButtonImageUrl' => false,
    ),
    'mapApiAK' => '6a44bc81286909b138b53e291b97aa19',
);
