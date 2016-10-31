<div class="picturesShow clearfix">
    <ul id="etalage" class="clearfix">
        <?php if (!empty($gallery)): ?>
            <?php foreach ($gallery as $v): ?>
                <li>
                    <img class="etalage_thumb_image"
                         src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_380,w_400'); ?>"/>
                    <img class="etalage_source_image"
                         src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_800,w_800'); ?>"/>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>
                <img class="etalage_thumb_image" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $goods['thumbnail'], 'c_fill,h_380,w_400'); ?>" />
                <img class="etalage_source_image" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $goods['thumbnail'], 'c_fill,h_800,w_800'); ?>" />
            </li>
        <?php endif; ?>
    </ul>
</div>