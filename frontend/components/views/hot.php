<?php
//销量排行
/** @var $v Goods */
?>
<div class="proArrange02 editor" id="sliderList01">
    <div class="title">
        <span
            class="en"><?php echo $model['title'] ? Yii::t('goods', $model['title']) : Yii::t('goods', '火热销量'); ?></span>

        <h3><?php echo $model['childTitle'] ? $model['childTitle'] : ''; ?></h3>
    </div>

    <ul class="content">
        <?php foreach ($model['goods'] as $k => $v): ?>
            <li class="clearfix" >

                    <a  title="<?php echo $v['name'] ?>" class="img"
                       href="<?php echo Yii::app()->createAbsoluteUrl('goods/' . $v['id']) ?>">
                        <img width="60" height="60" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_60,w_60') ?>">
                    </a>

                    <div class="detail">
                        <?php echo CHtml::link($v['name'], Yii::app()->createAbsoluteUrl('goods/' . $v['id']),array('class'=>'name')); ?>
                        <p class="price"><?php echo HtmlHelper::formatPrice($v['price']); ?></p>
                        <p><?php echo Yii::t('shop','已售出{num}笔',array('{num}'=>$v['sales_volume'])) ?></p>
                    </div>

            </li>
        <?php endforeach; ?>
    </ul>

</div>