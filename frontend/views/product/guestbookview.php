<li>
    <span class="ico_consulting"></span>
    <div class="zxcn">
        <h2>[<?php echo Yii::t('goods', '咨询内容') ?>]:
            <span class="zxtit_time"><?php echo Yii::t('goods', '盖网会员') ?>]：<?php echo substr($data['gai_number'], 0, 3) . '****' . substr($data['gai_number'], -3) ?> <?php echo date('Y-m-d H:i:s', $data['create_time']) ?></span>
        </h2>
        <p class="comtxt"><?php echo $data['content']; ?></p>
    </div>
    <?php if (!empty($data['reply_content'])): ?>
        <div class="zxcn reply">
            <span class="ico_shit"></span>
            <p class="comtxt"><?php echo $data['reply_content']; ?></p>
            <p class="comtime"><?php echo date('Y-m-d H:i:s', $data['reply_time']) ?></p>
        </div>
    <?php endif; ?>
</li>