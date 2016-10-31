<!--店铺信息 start-->

<div class="mbshopBox">
    <h3><?php echo Yii::t('memberComment', '店铺信息'); ?></h3>
    <div class="mbshopEvBox">
        <dl class="clearfix">
            <dt class="mbshopEvlogo">
            <?php
            if (!empty($store) && !empty($store->member->head_portrait))
                echo CHtml::image(ATTR_DOMAIN . '/' . $store->member->head_portrait, '', array('width' => '113px', 'height' => '113px'));
            else
                echo CHtml::image(DOMAIN . '/images/bg/gatedefault_130X130.jpg', '', array('width' => 105, 'height' => 105));
            ?>
            </dt>
            <dd>
                <div class="top clearfix">
                    <span class="fl">
                        <h3><?php echo Yii::t('memberComment', '店铺名称'); ?>：<?php echo $orderModel->store->name ?></h3>
                        <p><?php echo Yii::t('memberComment', '创立日期'); ?>：<?php echo date('Y-m-d', $orderModel->store->create_time) ?></p>
                        <p class="mgtop10"><?php echo CHtml::link(Yii::t('memberComment', '进入店铺'), Yii::app()->createAbsoluteUrl('/shop/' . $orderModel->store_id), array('target' => '_blank')) ?></p>
                    </span>
                    <span class="fr">
                        <span class="circle01"><p><b><?php echo (int) $orderModel->store->description_match && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->description_match / $orderModel->store->comments) : 0 ?></b>分</p><p><?php echo Yii::t('memberComment', '描述相符') ?></p></span>
                        <span class="circle02"><p><b><?php echo (int) $orderModel->store->serivice_attitude && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->serivice_attitude / $orderModel->store->comments) : 0 ?></b>分</p><p><?php echo Yii::t('memberComment', '服务态度') ?></p></span>
                        <span class="circle03"><p><b><?php echo (int) $orderModel->store->speed_of_delivery && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->speed_of_delivery / $orderModel->store->comments) : 0 ?></b>分</p><p><?php echo Yii::t('memberComment', '发货速度') ?></p></span>
                    </span>
                </div>
                <div class="bottom">
                    <ul class="clearfix">
                        <li class="clearfix">
                            <font><?php echo Yii::t('memberComment', '描述相符') ?>：</font>
                            <span id="star" title="good" style="width: 100px;"></span>
                            <a class="txtBox_1" title="<?php echo Yii::t('memberComment','5星 非常满意')?>"><?php echo Yii::t('memberComment', '5星 超赞'); ?></a>
                            <?php echo $form->error($store,'description_match');?>
                        </li>
                        <li class="clearfix">
                            <font><?php echo Yii::t('memberComment', '服务态度') ?>：</font>
                            <span id="star_2" title="good" style="width: 100px;"></span>
                            <a class="txtBox_2" title="<?php echo Yii::t('memberComment','5星 非常满意')?>"><?php echo Yii::t('memberComment', '3星 满意'); ?></a>
                            <?php echo $form->error($store,'serivice_attitude');?>
                        </li>
                        <li class="clearfix">
                            <font><?php echo Yii::t('memberComment', '发货速度') ?>：</font>
                            <span id="star_3" title="good" style="width: 100px;"></span>
                            <a class="txtBox_3" title="<?php echo Yii::t('memberComment','5星 非常满意')?>"><?php echo Yii::t('memberComment', '1星 不满'); ?></a>
                            <?php echo $form->error($store,'speed_of_delivery');?>
                        </li>
                    </ul>

                </div>
            </dd>
        </dl>
    </div>
</div>
<script>
    $('#star').raty({scoreName: 'StoreRating[description_match]',
        path: '<?php echo DOMAIN . '/js/raty/lib/img/' ?>',
        hints: ['<?php echo Yii::t('memberComment', "很不满意") ?>',
            '<?php echo Yii::t('memberComment', "不满意") ?>',
            '<?php echo Yii::t('memberComment', "一般") ?>',
            '<?php echo Yii::t('memberComment', "满意") ?>',
            '<?php echo Yii::t('memberComment', "非常满意") ?>'],
        target: '.txtBox_1',
        targetKeep: true,
        score:<?php echo (int) $orderModel->store->description_match && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->description_match / $orderModel->store->comments) : 0 ?>,
        mouseover:function(s,e){
            var a = $(this).siblings('a'),text = a.text();
            a.attr('title',s + '星 ' + text);
        },
        mouseout:function(s,e)
        {
            if(s===undefined){
                $('.txtBox_1').text('0').attr('title',0);
            }
        }
    });
    $('#star_2').raty({
        scoreName: 'StoreRating[serivice_attitude]',
        path: '<?php echo DOMAIN . '/js/raty/lib/img/' ?>',
        hints: ['<?php echo Yii::t('memberComment', "很不满意") ?>',
            '<?php echo Yii::t('memberComment', "不满意") ?>',
            '<?php echo Yii::t('memberComment', "一般") ?>',
            '<?php echo Yii::t('memberComment', "满意") ?>',
            '<?php echo Yii::t('memberComment', "非常满意") ?>'],
        target: '.txtBox_2',
        targetKeep: true,
        score:<?php echo (int) $orderModel->store->serivice_attitude && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->serivice_attitude / $orderModel->store->comments) : 0 ?>,
        mouseover:function(s,e){
            var a = $(this).siblings('a'),text = a.text();
            a.attr('title',s + '星 ' + text);
        },
        mouseout:function(s,e)
        {
            if(s===undefined){
                $('.txtBox_2').text('0').attr('title',0);
            }
        }
    });
    $('#star_3').raty({scoreName: 'StoreRating[speed_of_delivery]',
        path: '<?php echo DOMAIN . '/js/raty/lib/img/' ?>',
        hints: ['<?php echo Yii::t('memberComment', "很不满意") ?>',
            '<?php echo Yii::t('memberComment', "不满意") ?>',
            '<?php echo Yii::t('memberComment', "一般") ?>',
            '<?php echo Yii::t('memberComment', "满意") ?>',
            '<?php echo Yii::t('memberComment', "非常满意") ?>'],
        target: '.txtBox_3',
        targetKeep: true,
        score:<?php echo (int) $orderModel->store->speed_of_delivery && $orderModel->store->comments ? sprintf('%.2f', $orderModel->store->speed_of_delivery / $orderModel->store->comments) : 0 ?>,
        mouseover:function(s,e){
            var a = $(this).siblings('a'),text = a.text();
            a.attr('title',s + '星 ' + text);
        },
        mouseout:function(s,e)
        {
            if(s===undefined){
                $('.txtBox_3').text('0').attr('title',0);
            }
        }
    });
</script>
<!--店铺信息 end-->