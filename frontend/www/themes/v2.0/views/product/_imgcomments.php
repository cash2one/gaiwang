<ul>
<?php
$this->widget('zii.widgets.CListView', array(
	'id' => 'tabCon_com_22',
	'dataProvider' => $dataProvider,
	'itemView' => 'imgcommentview',
	'itemsTagName' => 'div',
	'itemsCssClass' => 'comments',
	'template' => '{items}{pager}',
	'pagerCssClass' => 'pageList mb50 clearfix',
	'emptyText' => '<span class="fontCenter">'.Yii::t('goods', '对不起，目前还没有图片相关评论信息！').'</span>',
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
</ul>
