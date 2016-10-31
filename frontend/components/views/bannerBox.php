<?php
//<!--广告盒子-->,店铺首页
?>
<div class="bannerBox editor clearfix" id="probanner">
        <?php foreach ($data as $k => $v): ?>
            <a href="<?php echo $v['Link'] ?>" title="<?php echo $v['Title'] ?>" target="_blank"
               class="items <?php echo $k == 2 ? 'last' : '' ?>">
                <?php
                $imgUrl = substr($v['ImgUrl'],0,5)=='files'?$v['ImgUrl']:'files/'.$v['ImgUrl'];
                ?>
                <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $imgUrl, 'c_fill,h_145,w_390'), $v['Title']) ?>
            </a>
        <?php endforeach; ?>
</div>