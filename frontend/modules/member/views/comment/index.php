<?php
/* @var $this CommentController */
$this->breadcrumbs = array(
    Yii::t('memberComment', '买入管理') => array('/member/order/admin'),
    Yii::t('memberComment', '我的评价'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/raty/lib/jquery.raty.min.js');
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberComment', '我的评价'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">
                    <h3 class="mgleft14"><?php echo Yii::t('memberComment', '我的评价'); ?></h3>
                    <p class="integaralbd pdbottom10"><span class="mgleft14"><?php echo Yii::t('memberComment', '完成交易后的商品评价'); ?>。</span>
                    </p>
                </div>
                <div class="upladBox mgtop10 mgbottom10">
                </div>
                <div class="upladaapBoxBg  bdc9Top">
                    <div class="upladBox_1">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createAbsoluteUrl($this->route),
                            'method' => 'get',
                        ));
                        ?>
                        <div class="fl">
                            <b class="mgleft20"><?php echo Yii::t('memberComment', '订单编号'); ?>：</b>
                            <?php echo $form->textField($model, 'order_id', array('class' => 'integaralIpt4 mgright30')); ?>
                            <!--<b>品牌名称：</b><input name="" type="text" class="integaralIpt4 mgright30">-->
                            <b><?php echo Yii::t('memberComment', '创建时间'); ?>：</b> <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'create_time',
                                'language' => 'zh_cn',
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => 'readonly',
                                    'class' => 'integaralIpt5',
                                )
                            ));
                            ?>  -  <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'endTime',
                                'language' => 'zh_cn',
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => 'readonly',
                                    'class' => 'integaralIpt5',
                                )
                            ));
                            ?>
                        </div>
                        <div class="fl"><?php echo CHtml::submitButton(Yii::t('memberComment', '搜索'), array('class' => 'searchBtn mgleft14')); ?></div>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="upladBox_1">
                        <!--<b class="fl mgright5 mgtop5 mgleft20">评价助手：</b><a href="" class="ceList">买家对我的评价</a><a href="" class="ceList">卖家对我的评价</a><a href="" class="ceLiCurr">给他人的评价</a>-->
                    </div>
                </div>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab purchaseOrder mgtop10">
                    <tbody>
                        <tr>
                            <td width="265" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '商品'); ?></b></td>
                            <td width="100" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '金额'); ?></b></td>
                            <td width="100" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '订单状态'); ?></b></td>
                            <td width="160" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '评价时间'); ?></b></td>
                            <td width="160" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '评价分数'); ?></b></td>
                            <td width="120" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberComment', '操作'); ?></b></td>
                        </tr>
                        <?php if ($commentData = $comments->getData()):?>
                            <?php $i = 1; ?>
                            <?php foreach ($commentData as $comment): ?>
                            <?php
                                if($comment->orderGoods->rules_setting_id>0){
                                    $price =$comment->orderGoods->unit_price;
                                }
                                elseif($comment->goods->join_activity==Goods::JOIN_ACTIVITY_YES && $comment->goods->at_status==ActivityTag::STATUS_ON && !empty($comment->goods->activity_tag_id)) {
                                    $price =$comment->goods->gai_sell_price;
                                }else{
                                    $price =$comment->goods->price;
                                }
                             ?>
                                <tr>
                                    <td colspan="6" align="left" valign="middle" class="bgE5">
                                        <b><?php echo Yii::t('memberComment', '订单编号'); ?>：<?php echo!$comment->order ? '' : $comment->order->code; ?></b><?php echo Yii::t('memberComment', '下单时间'); ?>：<?php echo !$comment->order ? '' : date('Y-m-d H:i:s', $comment->order->create_time); ?>
                                    </td>
                                </tr>
                                <tr class="bgF4">
                                    <td align="center" valign="middle" class="tit">
                                        <?php echo CHtml::image( Tool::showImg(!$comment->goods ? '' : IMG_DOMAIN.'/'.$comment->goods->thumbnail, 'c_fill,h_34,w_34'), !$comment->goods ? '' : $comment->goods->name, array('width' => 34, 'height' => 34, 'title' => !$comment->goods ? '' : $comment->goods->name)); ?>
                                        <p>
                                            <?php echo CHtml::link(!$comment->goods ? '' : $comment->goods->name, array('/goods/view', 'id' => !$comment->goods ? '' : $comment->goods->id), array('target' => '_blank')); ?>
                                        </p>
                                    </td>
                                    <td align="center" valign="middle"><b class="red"><?php echo!$comment->goods ? '' : HtmlHelper::formatPrice($price); ?></b></td>
                                    <td align="center" valign="middle"><b><?php echo Yii::t('memberComment', '交易成功'); ?></b></td>
                                    <td align="center" valign="middle"><?php echo date('Y-m-d H:i:s', $comment->create_time); ?></td>
                                    <td align="center" valign="middle">
                                        <span id="star<?php echo $i; ?>"></span>
                                        <br/>
                                        <?php echo $comment->score ?>分
                                        <script>
                                            $('#star<?php echo $i; ?>').raty({readOnly: true, path: '<?php echo DOMAIN ?>/js/raty/lib/img', score: <?php echo $comment->score ?>});
                                        </script>

                                    </td>
                                    <td align="center" valign="middle" class="controlList">
                                        <?php echo CHtml::link(Yii::t('memberComment', '订单详情'), array('/member/order/detail', 'code' => !$comment->order ? '' : $comment->order->code)); ?>
                                        <!--<a href="#">追加评价</a>-->
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td height="35" colspan="6" align="center" valign="middle" class="bgF4">
                                    <div class="pagination">
                                        <?php
                                        $this->widget('CLinkPager', array(
                                            'header' => '',
                                            'cssFile' => false,
                                            'firstPageLabel' => Yii::t('page', '首页'),
                                            'lastPageLabel' => Yii::t('page', '末页'),
                                            'prevPageLabel' => Yii::t('page', '上一页'),
                                            'nextPageLabel' => Yii::t('page', '下一页'),
                                            'maxButtonCount' => 13,
                                            'pages' => $comments->pagination
                                        ));
                                        ?>  
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan="6" class="empty"><span><?php echo Yii::t('memberComment', '没有找到数据'); ?>.</span></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
