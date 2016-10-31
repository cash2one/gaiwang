<div class="productSort">
    <div class="notbg">
        <i class="ico_hotsell"></i>
        <h1><?php echo Yii::t('category','火热销量')?></h1>
        <b>Hot sales</b>
    </div>
    <div class="items">
        <ul class="hotList">
            <?php foreach ($sales as $v):?>
            <li>
                <div class="clearfix">                    
                    <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_60,w_60'), $v['name'], array('width' => 60, 'height' => 60)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'img_m left', 'title' => $v['name'])); ?>
                    <div class="htitle">
                        <a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="" target="_blank">
                            <?php echo $v['name']?>                               </a>
                        <p class="integral">换购积分：<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($v['price']); ?></span></p>
                    </div>
                </div>
                <p class="price"><?php echo HtmlHelper::formatPrice($v['price']); ?></p>
            </li>      
            <?php endforeach;?>
        </ul> 
    </div>
</div>