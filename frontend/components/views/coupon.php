<?php
//优惠券显示
?>
<?php if(!empty($data)):
    $format = Yii::app()->format;
    ?>
<div class="busiCoupon">
    <div class="title"><span class="txt"><?php echo Yii::t('shop','先领券再购物') ?></span></div>
    <ul class="content clearfix">
        <?php foreach($data as $k => $v): ?>
        <li class="icon_v_h <?php echo $k%4==0 ? 'last':''; ?>">
            <?php echo CHtml::link(Yii::t('shop','立即领取'),array('/hongbao/site/detail','id'=>$v['id']),array('class'=>'btnGet')); ?>
            <p class="price"><?php echo HtmlHelper::formatPrice('') ?><span class="num"><?php echo $v['price'] ?></span></p>
            <p><?php echo Yii::t('shop','满{num}使用',array('{num}'=>$v['condition'])) ?></p>
            <p> <?php echo $format->formatDate($v['valid_start']),'-',$format->formatDate($v['valid_end']) ?> </p>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php echo CHtml::link(Yii::t('shop','更多优惠卷'),array('/hongbao/site/index'),array('class'=>'icon_v more')) ?>
</div>
<?php endif; ?>