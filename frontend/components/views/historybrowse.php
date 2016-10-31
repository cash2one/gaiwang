<?php if (!empty($data)): ?>
    <div class="proArrange02">
        <div class="title">
            <span class="en">RECENT BROWSE</span>
            <h3><?php echo Yii::t('goods', '最近浏览'); ?></h3>
        </div>

            <ul class="content">
                <?php foreach ($data as $d): ?>
                    <li class="clearfix">
                        <?php
                        $url = Yii::app()->createAbsoluteUrl('/goods/view', array('id' => $d->id));
                        $img = CHtml::image(IMG_DOMAIN . '/' . Tool::showImg($d->thumbnail, 'c_fill,h_60,w_60'), '', array('height' => '60', 'width' => '60'));
                        echo CHtml::link($img,$url,array('class'=>'img'))
                        ?>
                        <div class="detail">
                            <?php echo CHtml::link(Tool::truncateUtf8String($d->name, 22, '..'),$url,array('class'=>'name')); ?>
                            <p class="price"><?php echo HtmlHelper::formatPrice($d->price); ?></p>
                        </div>

                    </li>
                <?php endforeach; ?>
            </ul> 

    </div>
<?php endif; ?>