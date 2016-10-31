<?php

/* @var $this StoreArticleController */
/* @var $model StoreArticle */
$title = Yii::t('storeArticle', '店铺文章');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerStore', '店铺管理') => array('index'),
    $title,
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>