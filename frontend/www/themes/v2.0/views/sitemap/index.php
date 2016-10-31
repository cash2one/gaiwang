<?php
// 网站地图视图文件
/* @var $this Controller */
?>
<link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/help.css" rel="stylesheet" type="text/css"/>
<div class="gx-main">
    <div class="gx-content">
        <div class="pt15">
            <div class="map-contain">
                <div class="map-title"><?php echo Yii::t('map', '网站地图')?></div>
                 <ul class="clearfix">
                 <?php
                 $i = 0;
                 $b = 1;
                 ?>
                 <?php foreach ($category as $c): ?>
                    <li <?php if($b % 4 != 0):?>class="map-item clearfix" <?php else:?> class="map-item clearfix no-bdright" <?php endif;?>>
                        <i class="site-map-icon icon<?php echo $i;?>"></i>
                        <div class="map-item-des">
                            <p class="category"><?php echo Yii::t('category',$c['name']); ?></p>
                             <?php if (isset($c['childClass'])): ?>
                                 <?php foreach ($c['childClass'] as $child): ?>
                                   <?php echo CHtml::link(Yii::t('category',$child['name']), $this->createAbsoluteUrl('/category/view', array('id' => $child['id'])),array('class'=>'sub-category')); ?>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                        </div>
                    </li>
                      <?php
                     $i++;
                     $b++;
                     ?>
                  <?php endforeach; ?>
                    </ul>
             </div> 
        </div>
     </div>
</div>              