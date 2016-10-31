<ul class="product-evaluate">
    <?php
    if (!empty($comment)):
        foreach ($comment as $k => $c):
            ?>
            <li>
                <span class="list-num"><?php echo $k + 1 ?></span>
                <div class="product-info clearfix">
                    <?php
                                $g = $c->orderGoods;
                    echo
                    CHtml::link(
                            CHtml::image(IMG_DOMAIN .'/'. $g->goods_picture, $g->goods_name, array('class' => 'product-img')), $this->createUrl('/goods/view', array('id' => $g->goods_id), array('title' => $g['goods_name']))
                    );
                    ?>
                    <?php echo CHtml::link($g->goods_name, $this->createUrl('/goods/view', array('id' => $g->goods_id)), array('class' => 'product-name link')); ?>
                    <span class="product-price"><?php echo HtmlHelper::formatPrice($g['unit_price']) ?></span>
                </div>
                <div class="pe-content">
                    <p class="title"><?php echo Yii::t('membercomment', '商品评价') ?></p>
                    <div class="p-eval-items">
                        <span class="item-name"><?php echo Yii::t('membercomment', '描述相符') ?>：</span>
                        <span class="p-des-star" id="star-<?php echo $g->goods_id ?>"></span>
                        <span class="p-des-hint-<?php echo $g->goods_id ?>"></span>
                        <?php echo $form->error($model, "[$k]score"); ?>
                    </div>
                    <div class="p-eval-items">
                        <span class="label-name"><?php echo Yii::t('membercomment', '评价内容') ?>：</span>
                        <?php echo $form->textArea($model, "[$k]content", array('value' => $c->content, 'placeholder' => '商品您是否满意，有什么要和其他用户分享的呢？', 'class' => 'text-area', 'maxlength' => 200)) ?>
                        <span class="word-num" id="content-<?php echo $g->goods_id . $k ?>">0/200</span>
                        <script type="text/javascript">
                            $('#Comment_' +<?php echo $k ?> + '_content').keyup(function() {
                                len = $(this).val().length > 200 ? 200 : $(this).val().length;
                                $('#content-' +<?php echo $g->goods_id . $k ?>).text(len + '/200');
                            });
                        </script>
                        <?php echo $form->error($model, "[$k]content") ?>
                    </div>
                    <div class="p-eval-items" style="padding-bottom: 50px">
                        <span class="upload-label"><?php echo Yii::t('membercomment', '上传图片') ?>：</span>
                        <div class="upload-area">
                            <i class="add-btn" title="添加图片"></i>
                            <input type="file" id="image" class="input-file" name="img_path" onchange="submitImg(this,<?php echo $k ?>);" />
                            <ul class="upload-list clearfix">
                                <?php 
                                    $count = 0;
                                    if(!empty($c->img_path)):
                                        $img = explode('|', $c->img_path);
                                        $count = count($img);
                                        foreach($img as $i):
                                ?>
                                    <li>
                                       <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN  .'/'. $i,'c_fill,h_54,w_32'),'',array('width'=>'54px','height'=>'54px'))?>
                                        <i class="delete-img" title="删除图片"></i>
                                        <?php echo CHtml::hiddenField("Comment[$k][img_path][]",$i)?>
                                    </li>
                                <?php endforeach;endif;?>
                            </ul>
                            <div class="tip-area">
                                <span class="img-num"><?php echo Yii::t('membercomment', $count.'/4图片') ?></span>
                                <p class="img-des"><?php echo Yii::t('membercomment', '图片最大支持3M，格式包括JPG，PNG，GIF') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    //商品与描述相符星级
                    $("#star-<?php echo $g['goods_id'] ?>").raty({
                        scoreName: '<?php echo "Comment[$k][score]"; ?>',
                        score: <?php echo $c->score?>,
                        target: ".p-des-hint-<?php echo $g->goods_id ?>",
                        targetText: "<b class='score'>3分</b>(商品实际可用功能与描述基本吻合，能够正常使用操作)",
                        targetKeep: true,
                        hints: [
                            "<b class='score'>1分</b>(商家描述的应有功能与商品实际可用功能不符，如某缺少功能)",
                            "<b class='score'>2分</b>(商品实际功能与商家描述的有出入、夸大，如防水深度打不到描述所说)",
                            "<b class='score'>3分</b>(商品实际可用功能与描述基本吻合，能够正常使用操作)",
                            "<b class='score'>4分</b>(商品功能使用情况与预期基本符合，设计很人性化，操作简便贴心)",
                            "<b class='score'>5分</b>(商品功能设计便捷，外观好看，使用效果非常满意)"
                        ]
                    });
                </script>
                <?php echo $form->hiddenField($model, "[$k]goods_id", array('value' => $g->goods_id)) ?>
                <?php echo $form->hiddenField($model, "[$k]spec_value", array('value' => Tool::authcode($g->spec_value))) ?>
            </li>
        <?php endforeach;
    endif; ?>
</ul>