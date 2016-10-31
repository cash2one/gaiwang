<?php // $data  ?>
<?php if (!empty($data)): ?>
<div class="sliderBox">
    <div class="notbg">
        <i class="ico_hotsell"></i>
        <h1><?php echo Yii::t('goods','火热销量');?></h1>
        <b>Hot sales</b>
    </div>
    <div class="items">
        <ul class="hotList">
            <?php foreach ($data as $k => $d): $k++; ?>
            <li>
				<div class="clearfix">
					<a href="<?php echo Yii::app()->createAbsoluteUrl('goods/view', array('id' => $d->id)); ?>" title="<?php $d->name; ?>"  class="w60x60 img_m left">
                        <?php echo CHtml::image(IMG_DOMAIN.'/'.Tool::showImg($d->thumbnail, 'c_fill,h_60,w_60'),
                            $d->name,array('height' => '60', 'width' => '60')) ?>
						<span class="ico_hlist"><?php echo $k; ?></span>
					</a>
					<div class="htitle">
						<a href="<?php echo Yii::app()->createAbsoluteUrl('goods/view', array('id' => $d->id)); ?>" title="<?php $d->name; ?>" target="_blank"><?php echo Tool::truncateUtf8String($d->name.$d->name, 22, '..'); ?></a>
						<p class="integral"><?php echo Yii::t('goods','换购积分');?>：<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($d->price); ?></span></p>
					</div>
				</div>
                <p class="price"><?php echo HtmlHelper::formatPrice($d->price); ?></p>
            </li>
            <?php endforeach; ?>
        </ul> 
    </div>
</div>
<?php endif; ?>