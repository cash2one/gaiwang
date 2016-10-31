<?php
/* @var CommentController */
/* @var Comment */
/* @var $orderModel */
/* @var $form CActiveForm */
?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/raty/lib/jquery.raty.min.js'); ?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div class="mbRight">
    <div class="mbRcontent">
        <div class="mgtop20 upladBox ">
            <h3 class="mgleft14"><?php echo Yii::t('memberComment', '对商品进行评价'); ?></h3>
            <p class="integaralbd pdbottom10">
                <span class="mgleft14 "><?php echo Yii::t('memberComment', '对商品的描述相符、卖家服务、物流速度进行统一的评价'); ?></span>
            </p>
        </div>
        <?php $this->renderPartial('_store', array('store'=>$store, 'orderModel' => $orderModel,'form'=>$form)) ?>
        <div class="mbshopBox">
            <h3><?php echo Yii::t('memberComment', '我的评价'); ?></h3>
            <div class="mbshopbox_1">
                <?php foreach ($orderModel->orderGoods as $k => $v): ?>
                    <dl class="clearfix">
                        <dt>
                        <span class="fl"><?php echo CHtml::image(IMG_DOMAIN . '/' . $v['goods_picture'], '', array('width' => '130', 'height' => '130')) ?></span>
                        <span class="fr">
                            <span class="name"><?php echo CHtml::link($v['goods_name'], Yii::app()->createAbsoluteUrl('/goods/' . $v['goods_id'])) ?></span>
                            <span class="mbshopDate">
                                <p>
                                    <?php if (!empty($v['spec_value'])): ?>
                                        <?php foreach (unserialize($v['spec_value']) as $ksp => $vsp): ?>
                                            <?php echo $ksp . ': ' . $vsp ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </p>
                                <p><?php echo Yii::t('memberComment', '数量') ?>：<?php echo $v['quantity'] ?></p>
                                <p><?php echo Yii::t('memberComment', '价格') ?>：<font>￥ <?php echo $v['unit_price'] ?></font></p>
                            </span>
                        </span>
                        </dt>
                        <dd>
                            <div class="top">
                                <ul>
                                    <li>
                                        <font><?php echo Yii::t('memberComment', '商品评分') ?>：</font>
                                        <span id="star_0<?php echo $k; ?>" title="good" style="width: 100px;"></span>
                                        <a class="txtBox_4 target_<?php echo $k ?>" title="<?php echo Yii::t('memberComment', "3星 一般")?>"></a>
                                        <?php echo $form->error($model, "[$k]score") ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="bottom">
                                <?php echo $form->textArea($model, "[$k]content", array('class' => 'textArea01')) ?>
                                <span class="inputName"><?php echo Yii::t('memberComment', '商品评价') ?></span>
                            </div>
                            <?php echo $form->error($model, "[$k]content") ?>
                        </dd>
                    </dl>
                    <script>
                        $('#star_0<?php echo $k; ?>').raty({
                            scoreName: '<?php echo "Comment[$k][score]"; ?>',
                            path: '<?php echo DOMAIN . '/js/raty/lib/img/' ?>',
                            hints: ['<?php echo Yii::t('memberComment', "很不满意") ?>',
                                '<?php echo Yii::t('memberComment', "不满意") ?>',
                                '<?php echo Yii::t('memberComment', "一般") ?>',
                                '<?php echo Yii::t('memberComment', "满意") ?>',
                                '<?php echo Yii::t('memberComment', "非常满意") ?>'],
                            target: '.target_<?php echo $k; ?>',
                            targetKeep: true,
                            score: 3,
                            mouseover:function(s,e){
                                var a = $(this).siblings('a'),text = a.text();
                                a.attr('title',s + '星 ' + text);
                            }
                        });

                    </script>
                    <?php echo $form->hiddenField($model, "[$k]goods_id", array('value' => $v['goods_id'])) ?>
                    <?php echo $form->hiddenField($model, "[$k]spec_value", array('value' => Tool::authcode($v['spec_value']))) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <span class="prevaluationBtnBox"><?php echo CHtml::submitButton(Yii::t('memberComment', '提交评价'), array('class' => 'prevaluationBtn')) ?></span>
    </div>
    <?php $this->endWidget(); ?>
</div>

