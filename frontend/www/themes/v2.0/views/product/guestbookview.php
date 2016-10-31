<li>
    <dl class="pdtab4-item clearfix">
        <dt><span class="pdtab4-item-font1"><?php echo Yii::t('goods', '盖网会员') ?></span></dt>
        <dd><span class="pdtab4-item-font1"><?php echo substr($data['gai_number'], 0, 3) . '****' . substr($data['gai_number'], -3); ?></span></dd>
    </dl>
    <dl class="pdtab4-item clearfix">
        <dt><?php echo Yii::t('goods', '咨询内容') ?>：</dt>
        <dd class="pdtab4-item-dd2"><?php echo $data['content']; ?> </dd>
        <dd class="pdtab4-item-dd3"><span class="pdtab4-item-font1"><?php echo date('Y-m-d H:i:s', $data['create_time']) ?></span></dd>
    </dl>
    <?php if (!empty($data['reply_content'])): ?>
    <dl class="pdtab4-item clearfix">
        <dt><?php echo Yii::t('goods', '客服回复') ?>：</dt>
        <dd class="pdtab4-item-dd2"><span> <?php echo $data['reply_content']; ?></span></dd>
        <dd class="pdtab4-item-dd3"><span class="pdtab4-item-font1"><?php echo date('Y-m-d H:i:s', $data['reply_time']) ?></span></dd>
    </dl>
    <?php endif; ?>
</li>