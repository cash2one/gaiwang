<?php
/* @var $this GoodsController */
/* @var $model Goods */
$title = Yii::t('sellerGoods', '我要卖');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '宝贝管理') => array('index'),
    $title,
);
?>
<link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css" />
<?php $this->renderPartial('_form',array(
    'model'=>$model,
    'typeSpec'=>$typeSpec,
    'imgModel'=>$imgModel,
    'attribute'=>$attribute,
    'CategoryList'  => $CategoryList,
)) ?>