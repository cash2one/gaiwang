<?php if (isset($data->member)): ?>
    <li>
        <div class="cn1">
            <a class="imgbox" href="javascript:void(0);">
                <?php if (!empty($data->member->head_portrait)): ?>
                    <img src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $data->member->head_portrait, 'c_fill,h_60,w_60'); ?>" width="60" height="60" />
                <?php else: ?>
                    <?php echo CHtml::image(DOMAIN . '/images/bg/gatedefault_130X130.jpg', '', array('width' => 60, 'height' => 60)); ?>
                <?php endif; ?>
            </a><?php echo substr($data->member->gai_number, 0, 3) . '****' . substr($data->member->gai_number, -3); ?>
        </div>
        <div class="cn2">
            <h2>[<?php echo Yii::t('hotelSite','客户评价');?>]:</h2>
            <p class="comtxt">[<?php echo !$data->room ? '' : $data->room->name; ?>] <?php echo $data->comment; ?></p>
            <p class="pingf">
            <u title="<?php echo Yii::t('hotelSite','用户评分');?><?php echo $data->score; ?>" class="pingcons"><em style="width:<?php echo 20 * $data->score; ?>%"></em></u>
            <u class="color_gray"><?php echo $data->score; ?>分</u>
        </p>
        <p class="comtime">
            <?php if ($data->comment_time): ?>
                <?php echo date('Y-m-d H:i:s', $data->comment_time); ?>
            <?php endif; ?>
        </p>
    </div>
    </li>
<?php endif; ?>