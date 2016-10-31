<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberHotelOrder', '买入管理') => '',
    Yii::t('memberHotelOrder', '我的酒店订单'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberHotelOrder', '我的酒店订单') ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox "><h3 class="mgleft14"><?php echo Yii::t('memberHotelOrder', '我的酒店订单') ?></h3><p class="integaralbd pdbottom10 "><span class="mgleft14"><?php echo Yii::t('memberHotelOrder', '查找过去的酒店订单记录。') ?></span></p></div>
                <div class="upladaapBoxBg mgtop20 ">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createAbsoluteUrl($this->route),
                        'method' => 'get',
                    ));
                    ?>
                    <div class="upladBox_1">
                        <b class="mgleft14"> <?php echo Yii::t('memberHotelOrder', '订单编号') ?>： </b>
                        <?php echo $form->textField($model, 'code', array('class' => 'integaralIpt4 mgright15')) ?>
                        <b><?php echo Yii::t('memberHotelOrder', '酒店名称') ?>： </b>
                        <?php echo $form->textField($model, 'hotel_name', array('class' => 'integaralIpt4 mgright15')) ?>
                        <b><?php echo Yii::t('memberHotelOrder', '下单时间') ?>： </b>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'startTime',
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
                        - 
                        <?php
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
                        <?php echo CHtml::submitButton(Yii::t('memberHotelOrder', '搜索'), array('class' => 'searchBtn searchBtnright')); ?>
                    </div>
                    <div class="upladBox_1 mgtop5">
                        <b class="mgleft30"><?php echo Yii::t('memberHotelOrder', '状态') ?>：</b>
                        <?php echo $form->radioButtonList($model, 'status', HotelOrder::getOrderStatus(), array('empty' => '全部', 'class' => 'mgleft14 mgright5', 'separator' => '', 'checked' => 'cheked')); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <table width="890" cellspacing="0" cellpadding="0" border="0" class="integralTab purchaseOrder mgtop10">
                    <tbody><tr>
                            <td width="250" height="40" align="center" class="tdBg"><b> <?php echo Yii::t('memberHotelOrder', '酒店及客房名称') ?></b></td>
                            <td width="100" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberHotelOrder', '总金额') ?></b></td>
                            <td width="190" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberHotelOrder', '入住时间') ?></b></td>
                            <td width="110" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberHotelOrder', '支付状态') ?></b></td>
                            <td width="120" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberHotelOrder', '订单状态') ?></b></td>
                            <td width="120" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberHotelOrder', '操作') ?></b></td>
                        </tr>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data->getData() as $val): ?>
                                <tr>
                                    <td valign="middle" align="left" class="bgE5" colspan="6"><b><?php echo Yii::t('memberHotelOrder', '订单编号') ?>：<?php echo $val->code ?></b><?php echo Yii::t('memberHotelOrder', '下单时间') ?>：<?php echo date('Y-m-d H:i:s', $val->create_time) ?>&nbsp; &nbsp; &nbsp;

                                        <?php if ($val->status == HotelOrder::STATUS_SUCCEED): ?>
                                            <?php echo Yii::t('memberHotelOrder', '返还积分') ?>：<?php echo Common::convertSingle($val->amount_returned); ?><?php echo Yii::t('memberHotelOrder', '盖网积分') ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr class="bgF4">
                                    <td valign="middle" align="center" class="tit">
                                        <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $val->hotel->thumbnail, 'c_fill,h_32,w_32')) ?>
                                        <p>
                                            <a title="<?php echo $val->hotel_name ?> - <?php echo $val->room_name ?>" href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $val->hotel_id)); ?>"><b><?php echo $val->hotel_name ?> - <?php echo $val->room_name ?></b></a>
                                        </p>
                                    </td>
                                    <td valign="middle" align="center"><b class="red"><?php echo HtmlHelper::formatPrice($val->total_price) ?></b></td>
                                    <td valign="middle" align="center"><?php echo date('Y-m-d', $val->settled_time) ?> - <?php echo date('Y-m-d', $val->leave_time) ?></td>
                                    <td valign="middle" align="center"><b><?php echo HotelOrder::getPayStatus($val->pay_status) ?></b></td>
                                    <td valign="middle" align="center"><b><?php echo HotelOrder::getOrderStatus($val->status) ?></b></td>
                                    <td valign="middle" align="center" class="controlList">
                                        <?php if ($val->status == HotelOrder::STATUS_NEW): ?>
                                            <?php if ($val->pay_status == HotelOrder::PAY_STATUS_NO): ?>
                                                <?php echo CHtml::link(Yii::t('memberHotelOrder', '支付'), $this->createAbsoluteUrl('/hotel/order/pay', array('code' => $val->code))) ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($val->status == HotelOrder::STATUS_SUCCEED): ?>
                                            <?php if ($val->score == HotelOrder::IS_COMMENT_NO): ?>
                                                <?php echo CHtml::link(Yii::t('memberHotelOrder', '评价'), $this->createAbsoluteUrl('/member/hotelOrder/view', array('id' => $val->id))) ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo CHtml::link(Yii::t('memberHotelOrder', '订单详情'), $this->createAbsoluteUrl('/member/hotelOrder/view', array('id' => $val->id))) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td valign="middle" height="35" align="center" class="bgF4" colspan="7">
                                    <div class="pagination">
                                        <?php
                                        $this->widget('CLinkPager', array(
                                            'header' => '',
                                            'cssFile' => false,
                                            'firstPageLabel' => Yii::t('page', '首页'),
                                            'lastPageLabel' => Yii::t('page', '末页'),
                                            'prevPageLabel' => Yii::t('page', '上一页'),
                                            'nextPageLabel' => Yii::t('page', '下一页'),
                                            'maxButtonCount' => 5,
                                            'pages' => $data->pagination,
                                        ));
                                        ?>  
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
