<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '查看订单'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <td colspan="6" class="title-th odd even"><?php echo Yii::t('translateIdentify', '订单信息'); ?></td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('code'); ?>：</th>
            <td class="odd"><?php echo $model->code; ?></td>

            <th align="right" class="odd"><?php echo $model->getAttributeLabel('hotel_name'); ?>：</th>
            <td class="odd">
                <?php echo $model->hotel_name; ?>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('room_name'); ?>：</th>
            <td class="odd">
                <?php echo $model->room_name; ?>
            </td>
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('memberNumber'); ?>：</th>
            <td class="even"><?php echo!empty($model->member) ? $model->member->gai_number : ''; ?></td>
            <th align="right" class="even"><?php echo Yii::t('hotelOrder', '会员类型'); ?>：</th>
            <td class="even"><?php echo!empty($model->member->type_id) ? MemberType::getMemberType($model->member->type_id) : ''; ?></td>
            <th align="right" class="even"><?php echo Yii::t('hotelOrder', '会员姓名'); ?>：</th>
            <td class="even"><?php echo!empty($model->member) ? $model->member->real_name : ''; ?></td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo Yii::t('hotelOrder', '会员电话'); ?>：</th>
            <td class="odd"><?php echo!empty($model->member) ? $model->member->mobile : ''; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('settled_time'); ?>：</th>
            <td class="odd"><?php echo date('Y-m-d', $model->settled_time); ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('leave_time'); ?>：</th>
            <td class="odd"><?php echo date('Y-m-d', $model->leave_time); ?></td>
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('create_time'); ?>：</th>
            <td class="even"><?php echo date('Y-m-d H:i:s', $model->create_time); ?></td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('contact'); ?>：</th>
            <td class="even"><?php echo $model->contact; ?></td>
            <th align="right" class="even"><?php echo Yii::t('hotelOrder', '联系电话'); ?>：</th>
            <td class="even"><?php echo $model->mobile; ?></td>

        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('people_infos'); ?>：</th>
            <td class="odd"><?php echo HotelOrder::analysisLodgerInfo($model->people_infos, false, '<br />'); ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('rooms'); ?>：</th>
            <td class="odd"><?php echo $model->rooms; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('peoples'); ?>：</th>
            <td class="odd"><?php echo $model->peoples; ?></td>
            
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('breakfast'); ?>：</th>
            <td class="even">
                <?php if ($model->breakfast): ?>
                    <?php echo $model->breakfast; ?>
                <?php else: ?>
                    <?php echo HotelRoom::getBreakfast($model->room->breadfast); ?>
                <?php endif; ?>
            </td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('pay_status'); ?>：</th>
            <td class="even">
                <span style=" color:Green"><?php echo HotelOrder::getPayStatus($model->pay_status); ?></span>
            </td>
            <?php if ($model->pay_status == HotelOrder::PAY_STATUS_YES): ?>
                <th align="right" class="even"><?php echo $model->getAttributeLabel('payed_price'); ?>：</th>
                <td class="even">
                    <span class="jf" style=" color:Green"><?php echo HtmlHelper::formatPrice($model->payed_price); ?></span>
                </td>
            <?php else: ?>
                <th align="right" class="even"><?php echo $model->getAttributeLabel('unpay_price'); ?>：</th>
                <td class="even">
                    <span class="jf"><?php echo HtmlHelper::formatPrice($model->unpay_price); ?></span>
                </td>
            <?php endif; ?>
            
        </tr>
         <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('pay_time'); ?>：</th>
            <td class="odd"><?php echo $model->pay_time ? date("Y-m-d H:i:s", $model->pay_time) : ''; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('unit_gai_price'); ?>：</th>
            <td class="odd">
                <span class="jf" style="color: Blue;"><b><?php echo HtmlHelper::formatPrice($model->unit_gai_price); ?></b></span>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('unit_price'); ?>：</th>
            <td class="odd">
                <span class="jf"><b><?php echo HtmlHelper::formatPrice($model->unit_price); ?></b></span>
            </td>            
            
        </tr>
        <tr>           
            <th align="right" class="even"><?php echo $model->getAttributeLabel('lottery_radio'); ?>：</th>
            <td class="even"><?php echo $model->lottery_radio; ?></td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('amount_returned'); ?>：</th>
            <td class="even">
                <span><?php echo Common::convertSingle($model->amount_returned, $model->member->type_id); ?></span>
            </td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('total_price'); ?>：</th>
            <td class="even">
                <span class="jf"><b><?php echo HtmlHelper::formatPrice($model->total_price); ?></b></span>
            </td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo Yii::t('hotelOrder', '中奖金额') ?>：</th>
            <td class="odd">
                <span><?php echo HtmlHelper::formatPrice(HotelCalculate::obtainBonus($model->attributes)); ?></span>
            </td>            
            <th align="right" class="odd"><?php echo Yii::t('hotelOrder', '返还金额') ?>：</th>
            <td class="odd">
                <span><?php echo HtmlHelper::formatPrice($model->amount_returned); ?></span>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('lottery_price'); ?>：</th>
            <td class="odd">
                <span><?php echo HtmlHelper::formatPrice($model->lottery_price); ?></span>
            </td>            
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('is_lottery'); ?>：</th>
            <td class="even">
                <span><?php echo HotelOrder::getIsLottery($model->is_lottery); ?></span>
            </td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('bed') ?>：</th>
            <td class="even"><?php echo $model->bed; ?></td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('earliest_time'); ?>：</th>
            <td class="even"><?php echo $model->earliest_time; ?></td>
            
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('latest_time'); ?>：</th>
            <td class="odd"><?php echo $model->latest_time; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('live_time'); ?>：</th>
            <td class="odd"><?php echo $model->live_time ? date('Y-m-d H:i:s', $model->live_time) : ''; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('hotel_provider_id'); ?>：</th>
            <td class="odd"><?php echo $model->hotel_provider_id ? $model->provider->name : ''; ?></td>
                               
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('price_radio'); ?>：</th>
            <td class="even"><?php echo $model->price_radio; ?></td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('unpay_price'); ?>：</th>
            <td class="even">
                <span><?php echo HtmlHelper::formatPrice($model->unpay_price); ?></span>
            </td>  
            <th align="right" class="even"><?php echo $model->getAttributeLabel('status'); ?>：</th>
            <td class="even">
                <span style=" color:Blue"><?php echo HotelOrder::getOrderStatus($model->status); ?></span>
            </td>
                        
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('sign_user'); ?>：</th>
            <td class="odd"><?php echo $model->sign_user; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('sign_time') ?>：</th>
            <td class="odd">
                <?php echo $model->sign_time ? date('Y-m-d H:i:s', $model->sign_time) : ''; ?>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('is_sign'); ?>：</th>
            <td class="odd"><?php echo HotelOrder::getIsSign($model->is_sign); ?></td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('sign_remark'); ?>：</th>
            <td class="odd" colspan="5"><?php echo $model->sign_remark; ?></td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('confirm_user'); ?>：</th>
            <td class="odd"><?php echo $model->confirm_user; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('confirm_time') ?>：</th>
            <td class="odd">
                <?php echo $model->confirm_time ? date('Y-m-d H:i:s', $model->confirm_time) : ''; ?>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('is_check'); ?>：</th>
            <td class="odd"><?php echo HotelOrder::getIsCheck($model->is_check); ?></td>
        </tr>
        <tr>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('check_user'); ?>：</th>
            <td class="even"><?php echo $model->check_user; ?></td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('check_time') ?>：</th>
            <td class="even">
                <?php echo $model->check_time ? date('Y-m-d H:i:s', $model->check_time) : ''; ?>
            </td>
            <th align="right" class="even"><?php echo $model->getAttributeLabel('is_recon'); ?>：</th>
            <td class="even"><?php echo HotelOrder::getIsRecon($model->is_recon); ?></td>
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('recon_user'); ?>：</th>
            <td class="odd"><?php echo $model->recon_user; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('recon_time') ?>：</th>
            <td class="odd">
                <?php echo $model->recon_time ? date('Y-m-d H:i:s', $model->recon_time) : ''; ?>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('complete_time') ?>：</th>
            <td class="odd">
                <?php echo $model->complete_time ? date('Y-m-d H:i:s', $model->complete_time) : ''; ?>
            </td>
                        
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('score'); ?>：</th>
            <td class="odd">
                <span><?php echo $model->score; ?></span>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('comment_time'); ?>：</th>
            <td class="odd"><?php echo $model->comment_time ? date('Y-m-d H:i:s', $model->comment_time) : ''; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('refund_radio'); ?>：</th>
            <td class="odd"><?php echo $model->refund_radio; ?></td>
                        
        </tr>
        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('refund'); ?>：</th>
            <td class="odd">
                <span><?php echo $model->refund ? HtmlHelper::formatPrice($model->refund) : '无'; ?></span>
            </td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('cancle_time'); ?>：</th>
            <td class="odd"><?php echo $model->cancle_time ? date('Y-m-d H:i:s', $model->cancle_time) : ''; ?></td>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('source'); ?>：</th>
            <td class="odd"><?php echo HotelOrder::getSource($model->source); ?></td>
                       
        </tr>

        <tr>
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('parent_code'); ?>：</th>
            <td class="odd">
                <span><?php echo $model->parent_code; ?></span>
            </td> 
            <th align="right" class="odd"><?php echo $model->getAttributeLabel('pay_type'); ?>：</th>
            <td class="odd"><?php echo OnlinePay::getPayWayList($model->pay_type); ?></td>
            <th align="right" class="odd" style="width:100px"><?php echo $model->getAttributeLabel('check_remark'); ?>：</th>
            <td class="odd" colspan="5">
                <?php echo $model->check_remark; ?>
            </td>
        </tr>
        <tr>
            <th align="right" class="odd" style="width:100px"><?php echo $model->getAttributeLabel('remark'); ?>：</th>
            <td class="odd" colspan="5"><?php echo $model->remark; ?></td>
        </tr>
        <tr>
            <th align="right" class="even" style="width:100px"><?php echo $model->getAttributeLabel('comment'); ?>：</th>
            <td class="even" colspan="5">
                <span style=" color:Green"><?php echo $model->comment; ?></span>
            </td>
        </tr>

       
        <?php foreach ($sms as $key => $val): ?>
            <tr>
                <th align="right" class="<?php echo (($key + 1) % 2 == 1) ? 'odd' : 'even'; ?>" style="width:100px"><?php echo Yii::t('hotelOrder', '短信内容'); ?>：</th>
                <td class="<?php echo (($key + 1) % 2 == 1) ? 'odd' : 'even'; ?>" colspan="5">
                    <span style=" color:Green"><?php echo $val['content'] ?></span>
                    <span style=" color:red"><?php echo SmsLog::showStatus($val['status']) ?></span>
                    <span>--手机号码：<?php echo $val['mobile'] ?></span>
                    <span>--发送时间：<?php echo date('Y-m-d H:i:s', $val['create_time']) ?></span>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <th align="right" class="even" style="width:100px">订单跟进：</th>
            <td class="even" colspan="5">
                <input id="addFollow" data-url="<?php echo $this->createAbsoluteUrl('hotelOrder/addFollow',array('orderId'=>$model->id)) ?>" type="button" value="+添加跟进" class="regm-sub" >
                <input id="viewFollow" data-url="<?php echo $this->createAbsoluteUrl('hotelOrder/viewFollow',array('orderId'=>$model->id)) ?>" type="button"  value="跟进详情" class="regm-sub" onclick="">
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<script  type="text/javascript">
    var dialog = null;
    $("#addFollow").click(function() {
        dialog = art.dialog.open($(this).attr('data-url'), { title: '添加跟进记录', width: '70%', height: '60%', lock: true});
        return false;
    });
    $("#viewFollow").click(function() {
        dialog = art.dialog.open($(this).attr('data-url'), {title: '查看跟进记录', width: '90%', height: '80%', lock: true});
        return false;
    });
    var doClose = function() {
        if (null != dialog) {
            dialog.close();
            art.dialog({
                icon: 'succeed',
                content: '添加成功',
                ok: true,
                drag:false
            });
        }
    };
</script>