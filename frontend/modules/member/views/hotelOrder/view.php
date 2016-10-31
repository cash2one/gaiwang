<?php
/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 */
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberHotelOrder', '订单详情') ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php
                // 评论表单
                if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0):
                    $form = $this->beginWidget('ActiveForm', array(
                        'id' => $this->id . '-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    ));
                endif;
                ?>
                <div class="mgtop20 upladBox "><h3><?php echo Yii::t('memberHotelOrder', '酒店详情') ?></h3></div>
                <div class="clear"></div>
                <table width="890" cellspacing="0" cellpadding="0" border="0" class="tableBank">
                    <tbody>
						<tr><th colspan="4"><h3 class="pdbottom10 mgtop20"><?php echo Yii::t('memberHotelOrder', '入住信息') ?></h3></th></tr>
						<tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '联系人') ?>：</b></td>
                            <td width="340" height="35" class="pdleft20 bgF4"><?php echo $model->contact; ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '联系方式') ?>：</b></td>
                            <td width="296" height="35" class="pdleft20 bgF4"><?php echo $model->mobile; ?></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '入住人') ?>：</b></td>
                            <td width="340" height="35" class="pdleft20 bgF4 pdtop10 pdbottom10">
                                <?php echo HotelOrder::analysisLodgerInfo($model->people_infos, "<br />"); ?>
                                <p><?php echo Yii::t('memberHotelOrder', '共{num}人', array('{num}' => $model->peoples)); ?></p>
                            </td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '入离时间') ?>：</b></td>
                            <td width="296" height="35" class="pdleft20 bgF4">
                                <?php
                                echo Yii::t('memberHotelOrder', '{settled} 至 {leave} {night}晚', array(
                                    '{settled}' => date('Y-m-d', $model->settled_time),
                                    '{leave}' => date('Y-m-d', $model->leave_time),
                                    '{night}' => "&nbsp;&nbsp;" . HotelCalculate::liveDays($model->leave_time, $model->settled_time),
                                ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '房间数量'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20"><?php echo $model->rooms; ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '床型要求'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><?php echo $model->bed; ?></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '特殊要求'); ?>：</b> </td>
                            <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo $model->remark ? $model->remark : Yii::t('memberHotelOorder', '无'); ?></td>
                        </tr>
						
						<tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '酒店名称'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20 bgF4 pdtop10 pdbottom10">
                                <?php
                                echo CHtml::link(CHtml::image(Tool::showImg(!$model->hotel ? '' : ATTR_DOMAIN . '/' . $model->hotel->thumbnail, 'c_fill,h_100,w_100'), $model->hotel_name, array(
                                    'class' => 'fl', 'width' => '100', 'height' => '100')), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)), array('class' => 'fl mgright5', 'style' => 'border:1px solid #ccc;'));
                                ?>
                                <a title="<?php echo $model->hotel_name; ?>" class="fl" href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)) ?>"><?php echo $model->hotel_name; ?></a></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '酒店位置'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><?php echo Region::getName(!$model->hotel ? 0 : $model->hotel->province_id) ?>-<?php echo Region::getName(!$model->hotel ? 0 : $model->hotel->city_id) ?>-<?php echo!$model->hotel ? '' : $model->hotel->street; ?> </td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '客房名称'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20 bgF4 pdtop10 pdbottom10">
                                <?php
                                echo CHtml::link(CHtml::image(Tool::showImg(!$model->room ? '' : ATTR_DOMAIN . '/' . $model->room->thumbnail, 'c_fill,h_100,w_100'), $model->room_name, array(
                                    'class' => 'fl hotelOrderImg', 'width' => '100', 'height' => '100')), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)), array('class' => 'fl mgright5', 'style' => 'border:1px solid #ccc;'));
                                ?>
                                <a title="<?php echo $model->room_name; ?>" class="fl" href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)) ?>"><?php echo $model->room_name; ?></a></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '客房价格'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->unit_price); ?>/天</b></td>
                        </tr>
						<tr><th colspan="4"><h3 class="pdbottom10 mgtop20"><?php echo Yii::t('memberHotelOrder', '交易信息'); ?></h3></th></tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '订单编号'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20 "><?php echo $model->code; ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '订单总价'); ?>：</b></td>
                            <td width="296" height="35" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->total_price); ?></b></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '订单状态'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20"><?php echo HotelOrder::getOrderStatus($model->status) ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '下单时间'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><?php echo date('Y-m-d H:i:s', $model->create_time) ?></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '支付状态'); ?>：</b> </td>
                            <td width="340" height="35" class="bgF4 pdleft20"><?php echo HotelOrder::getPayStatus($model->pay_status) ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '支付时间'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><?php echo $model->pay_time ? date('Y-m-d H:i:s', $model->pay_time) : ''; ?></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '已支付'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->payed_price); ?></b></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '未支付'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->unpay_price); ?></b></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '是否抽奖'); ?>：</b></td>
                            <td width="340" height="35" class="bgF4 pdleft20"><?php echo HotelOrder::getIsLottery($model->is_lottery); ?></td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '抽奖金额'); ?>：</b> </td>
                            <td width="296" height="35" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->lottery_price); ?></b></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '中奖金额'); ?>：</b> </td>
                            <td width="340" height="35" class="bgF4 pdleft20">
                                <b class="red">
                                    <?php echo HtmlHelper::formatPrice(($model->status == HotelOrder::STATUS_SUCCEED ? HotelCalculate::obtainBonus($model->attributes) : '0.00')); ?>
                                </b>
                            </td>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '手续费'); ?>：</b></td>
                            <td width="296" height="35" colspan="3" class="bgF4 pdleft20"><b class="red"><?php echo HtmlHelper::formatPrice($model->refund); ?></b></td>
                        </tr>

                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '订单评分'); ?>：</b></td>
                            <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo $model->score; ?></td>
                        </tr>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberHotelOrder', '评价内容'); ?>：</b> </td>
                            <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo Tool::banwordReplace($model->comment, '*'); ?></td>
                        </tr>

                        <?php if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0): ?>
                            <tr>
                                <td width="500" height="35" align="center" colspan="3" class="dtEe">
                                    <div id="hlstar" class="hlstar mgtop10">
                                        <span class="fl"><?php echo Yii::t('memberHotelOrder', '我要打分'); ?></span>
                                        <ul>
                                            <li class=""><a>1</a></li>
                                            <li class=""><a>2</a></li>
                                            <li class=""><a>3</a></li>
                                            <li class=""><a>4</a></li>
                                            <li class=""><a>5</a></li>
                                        </ul>
                                        <span></span>
                                        <?php echo $form->error($model, 'score'); ?>
                                        <p style="display: none; left: 74px;"><?php echo Yii::t('memberHotelOrder', '<em><b>5</b> 分 非常满意</em>客房配置完善，与酒店描述的完全一致，很满意') ?></p>
                                    </div>
                                    <?php echo $form->textArea($model, 'comment', array('class' => 'reviewtxt')) ?>
                                    <?php echo $form->error($model, 'comment'); ?>
                                </td>
                                <td width="296" height="35" class="bgF4 pdleft20">
                                    <?php echo $form->hiddenField($model, 'score'); ?>
                                    <?php echo CHtml::submitButton(Yii::t('memberHotelOrder', '我要点评'), array('class' => 'hbtnSubmit')); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php
                // 表单结束
                if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0) {
                    $this->endWidget();
                }
                ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        var oStar = document.getElementById("hlstar");
        var aLi = oStar.getElementsByTagName("li");
        var oUl = oStar.getElementsByTagName("ul")[0];
        var oSpan = oStar.getElementsByTagName("span")[1];
        var oP = oStar.getElementsByTagName("p")[0];
        var i = iScore = iStar = 0;
        var aMsg = [
            "<?php echo Yii::t('memberHotelOrder', '很不满意|客房配置差，与酒店描述的严重不符，非常不满'); ?>",
            "<?php echo Yii::t('memberHotelOrder', '不满意|客房配置不全，与酒店描述的不符，不满意'); ?>",
            "<?php echo Yii::t('memberHotelOrder', '一般|客房配置一般，没有酒店描述的那么好') ?>",
            "<?php echo Yii::t('memberHotelOrder', '满意|客房配置不错，与酒店描述的基本一致，较满意'); ?>",
            "<?php echo Yii::t('memberHotelOrder', '非常满意|客房配置完善，与酒店描述的完全一致，很满意'); ?>"
        ]

        for (i = 1; i <= aLi.length; i++) {
            aLi[i - 1].index = i;

            //鼠标移过显示分数
            aLi[i - 1].onmouseover = function() {
                fnPoint(this.index);
                //浮动层显示
                oP.style.display = "block";
                //计算浮动层位置
                oP.style.left = oUl.offsetLeft + this.index * this.offsetWidth - 104 + "px";
                //匹配浮动层文字内容
                oP.innerHTML = "<em><b>" + this.index + "</b> 分 " + aMsg[this.index - 1].match(/(.+)\|/)[1] + "</em>" + aMsg[this.index - 1].match(/\|(.+)/)[1]
            };

            //鼠标离开后恢复上次评分
            aLi[i - 1].onmouseout = function() {
                fnPoint();
                //关闭浮动层
                oP.style.display = "none"
            };

            //点击后进行评分处理
            aLi[i - 1].onclick = function() {
                iStar = this.index;
                oP.style.display = "none";
                oSpan.innerHTML = "<strong>" + (this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")";
                $("#HotelOrder_score").val(this.index);
            }
        }

        //评分处理
        function fnPoint(iArg) {
            //分数赋值
            iScore = iArg || iStar;
            for (i = 0; i < aLi.length; i++)
                aLi[i].className = i < iScore ? "on" : "";
        }

    };
</script>