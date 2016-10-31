<?php
/* @var $this GoodsController */
/* @var $model Goods */
?>
<div class="toolbar">
    <b><?php echo Yii::t('sellerGoods','我要卖'); ?></b>
    <span><?php echo Yii::t('sellerGoods','添加新的宝贝信息资料'); ?>。</span>
</div>
<div class="proAddStep">
    <ul class="s3">
        <li><?php echo Yii::t('sellerGoods','选择商品所在分类'); ?></li>
        <li><?php echo Yii::t('sellerGoods','填写商品详细信息'); ?></li>
        <li><?php echo Yii::t('sellerGoods','商品发布成功'); ?></li>
    </ul>
</div>
<div class="proAddStepThree clearfix">
    <i class="iconSuccess"></i>
    <div class="txt">
        <h2><?php echo Yii::t('sellerGoods','恭喜您，成功发布新宝贝！'); ?></h2>
        <p>
            <?php echo CHtml::link(Yii::t('sellerGoods','查看该宝贝>>'),$this->createAbsoluteUrl('goods/updateBase',
                array('id'=>$this->getParam('goods_id')))); ?>
            &nbsp;&nbsp;
            <?php echo CHtml::link(Yii::t('sellerGoods','继续发布新宝贝>>'),$this->createAbsoluteUrl('goods/create',
                array('type_id'=>$this->getParam('type_id'),'cate_id'=>$this->getParam('cate_id')))); ?>
        </p>
    </div>
</div>
