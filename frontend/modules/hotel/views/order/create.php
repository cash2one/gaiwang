<?php
/**
 * @var $model HotelOrder
 */
Yii::app()->clientScript->registerCss('style', "
    .bookingMsg .bMIntro dl dd .errorMessage {z-index: 0;}
");
?>

<div class="main">
    <div class="clear mgtop10"></div>
    <div class="hotelBookingStepbg hbStep01">
        <span class="curr"><?php echo Yii::t('hotelOrder', '预订填写酒店信息'); ?></span>
        <span><?php echo Yii::t('hotelOrder', '支付该订单'); ?></span>
        <span><?php echo Yii::t('hotelOrder', '成功支付'); ?></span>
    </div>

    <!-- 酒店预订流程 begin -->
    <?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('ActiveForm', array(
        'id' => $this->id . '-form',
        'action' => Yii::app()->createAbsoluteUrl($this->route, array('id' => $room['id'])),
        'method' => 'post',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true, //客户端验证
        ),
    ));
    CHtml::$beforeRequiredLabel = CHtml::$afterRequiredLabel;
    CHtml::$afterRequiredLabel = '';
    ?>

    <!-- 酒店信息 begin -->
    <div class="hotelContain bookingMsg">
        <span class="bMTit"><i class="ico_txt"></i><?php echo Yii::t('hotelOrder', '预订酒店信息'); ?></span>
        <div class="bMIntro">
            <div class="bM01">
                <div class="hMsg">
                    <?php
                    echo CHtml::link(
                    CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $room['hotel_thumb'], 'c_fill,h_42,w_42'), $room['hotel_name'], array('width' => 42, 'height' => 42)), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $room['hotel_id'])), array('class' => 'imgbox', 'title' => $room['hotel_name']));
                    ?>
                    <h2><i class="ico_hotels"></i><?php echo $room['hotel_name'] ?><b>[<?php echo $room['hotel_name'] ?>]</b></h2>
                    <p>
                        <i class="ico_htaddr"></i><?php echo Yii::t('hotelOrder', '地址'); ?>：<?php echo $room['province_name'] . $room['city_name'] . $room['street']; ?>
                    </p>
                </div>
                <div class="hotelService clearfix">
                    <div class="hsIcon"><h3 class="no1"><?php echo Yii::t('hotelOrder', '品质之选'); ?></h3></div>
                    <div class="hsIcon"><h3 class="no2"><?php echo Yii::t('hotelOrder', '丰富之选'); ?></h3></div>
                    <div class="hsIcon"><h3 class="no3"><?php echo Yii::t('hotelOrder', '安心之选'); ?></h3></div>
                    <div class="hsIcon no4 clearfix">
                        <div class="hSTime fl">
                            <p><?php echo Yii::t('hotelOrder', '咨询服务时间'); ?>:<?php echo $this->getConfig('hotelparams', 'hotelServiceTime') ?></p>
                            [<?php echo Yii::t('hotelOrder', '本公司酒店房源由第三方提供'); ?>]
                        </div>
                        <div class="hSPhone fl">
                            <p class="phoneIco"><?php echo Yii::t('hotelOrder', '预订咨询电话'); ?></p><?php echo $this->getConfig('hotelparams', 'hotelServiceTel') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bM02">
                <span class="hotelTh">
                    <i class="w245"><?php echo Yii::t('hotelOrder', '房间类型'); ?></i>
                    <i class="w145"><?php echo Yii::t('hotelOrder', '房间数量'); ?></i>
                    <i class="w320"><?php echo Yii::t('hotelOrder', '包含服务'); ?></i>
                    <i class="w145"><?php echo Yii::t('hotelOrder', '预估返赠'); ?></i>
                    <i class="w145"><?php echo Yii::t('hotelOrder', '单价（元）'); ?></i>
                    <i class="w145"><?php echo Yii::t('hotelOrder', '小计（元）'); ?></i>
                </span>
                <ul>
                    <li class="clearfix">
                        <span class="wfl w245">
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $room['thumbnail'], 'c_fill,h_50,w_50'), $room['name'], array('class' => 'imgbox', 'width' => 50, 'height' => 50)); ?>
                            <p>
                                <b><?php echo $room['name'] ?></b><br>
                                <?php echo CHtml::link(Yii::t('hotelOrder', '查看详情'), $this->createAbsoluteUrl('/hotel/site/view/', array('id' => $room['hotel_id']))); ?>
                            </p>
                        </span>
                        <span class="wfl w145">
                            <div class="addinput">
                                <span class="downBtn"><a href="javascript:checkingIn(-1)" class="downBtn">-</a></span>
                                <?php
                                echo $form->textField($model, 'rooms', array(
                                    'id' => 'RoomCount',
                                    'class' => 'addninput',
                                    'onchange' => 'checkingIn()',
                                    'value' => $model->rooms,
                                    'autocomplete' => 'off',
//                                    'onkeyup' => "value = value.replace(/[^\d]/g, '')"
                                    )
                                );
                                ?>
                                <span class="aapBtn"><a href="javascript:checkingIn(1)" class="aapBtn">+</a></span>
                            </div>
                            <div><?php echo $form->error($model, 'rooms', array('inputID' => 'RoomCount')); ?></div>
                        </span>
                        <span class="wfl w320"><?php echo $room['content'] ?></span>
                        <span class="wfl w145">
                            <span class="ico_fan">
                                <i id="estimate_back_credits"><?php echo $room['estimate_back_credits'] ?><?php echo Yii::t('hotelOrder', '分'); ?></i>
                            </span>
                        </span>
                        <span class="wfl w145"><?php echo HtmlHelper::formatPrice('') ?>
                            <b id="price">
                                <?php if (HotelRoom::isActivity($room['activities_start'], $room['activities_end'])): ?>
                                    <?php echo Common::rateConvert($room['activities_price']) ?>
                                <?php else: ?>
                                    <?php echo Common::rateConvert($room['unit_price']) ?>
                                <?php endif; ?>
                            </b>
                        </span>
                        <span class="wfl w145"><?php echo HtmlHelper::formatPrice('') ?>
                            <b id="total" class="red">
                                <?php if (HotelRoom::isActivity($room['activities_start'], $room['activities_end'])): ?>
                                    <?php echo Common::rateConvert($room['activities_price']) ?>
                                <?php else: ?>
                                    <?php echo Common::rateConvert($room['unit_price']) ?>
                                <?php endif; ?>
                            </b>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <span class="totalPrice"><?php echo Yii::t('hotelOrder', '应付总额'); ?>： <?php echo HtmlHelper::formatPrice('') ?>
            <b id="totalPay"><?php echo Common::rateConvert($room['unit_price']) ?></b>
        </span>
    </div>
    <!-- 酒店信息 end -->

    <div class="hotelContain bookingMsg">
        <span class="bMTit"><i class="ico_txt"></i><?php echo Yii::t('hotelOrder', '入住信息'); ?>
            <em><?php echo Yii::t('hotelOrder', '（请填写入住人证件上的姓名，以便酒店快速帮您办理入住手续。）'); ?></em>
        </span>
        <div class="bMIntro btable">
            <dl class="clearfix">
                <dt><?php echo $form->label($model, 'settled_time', array('required' => true)); ?>：</dt>
                <dd>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'settled_time',
                        'language' => 'zh_cn',
                        'options' => array(
//                            'defaultDate' => '+1w',
                            'dateFormat' => 'yy-mm-dd',
                            'numberOfMonths' => 2,
                            'changeMonth' => true,
                            'minDate' => date('Y-m-d'),
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt',
                            'onchange' => 'checkingIn()',
                        )
                    ));
                    ?>
                </dd>
                <dd> <?php echo $form->error($model, 'settled_time'); ?></dd>
                <dt><?php echo $form->label($model, 'leave_time', array('required' => true)); ?>：</dt>
                <dd>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'leave_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'defaultDate' => '+1w',
                            'dateFormat' => 'yy-mm-dd',
                            'numberOfMonths' => 2,
                            'changeMonth' => true,
                            'minDate' => date('Y-m-d', strtotime('+1day')),
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt',
                            'onchange' => 'checkingIn()',
                        )
                    ));
                    ?>
                </dd>
                <dd><?php echo $form->error($model, 'leave_time'); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt><?php echo $form->label($model, 'TimeOfArrival', array('required' => true)); ?>：</dt>
                <dd>
                    <?php echo $form->dropDownList($model, 'earliest_time', array(), array('prompt' => Yii::t('hotelOrder', '请选择'), 'onchange' => 'startChange()')); ?>
                    &mdash;
                    <?php echo $form->dropDownList($model, 'latest_time', array(), array('prompt' => Yii::t('hotelOrder', '请选择'))); ?>
                </dd>
                <dd><em> &nbsp;<?php echo Yii::t('hotelOrder', '最早最晚时间相隔不可超过3小时'); ?></em></dd>
                <dd><?php echo $form->error($model, 'earliest_time'); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt><?php echo $form->label($model, 'contact', array('required' => true)); ?>：</dt>
                <dd><?php echo $form->textField($model, 'contact', array('class' => 'inputtxt')) ?></dd>
                <dd><?php echo $form->error($model, 'contact'); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt><?php echo $form->label($model, 'mobile', array('required' => true)); ?>：</dt>
                <dd><?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt')) ?></dd>
                <dd><?php echo $form->error($model, 'mobile'); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt><?php echo $form->labelEx($model, 'peoples'); ?>：</dt>
                <dd><?php echo $form->dropDownList($model, 'peoples', array(), array('id' => 'PersonCount', 'onChange' => 'getPersonInfo();')); ?></dd>
                <dd> <?php echo $form->error($model, 'peoples', array('inputID' => 'PersonCount'), false); ?></dd>
            </dl>
            <?php if (!empty($pastGuests)): ?>
                <dl class="clearfix" id="history_lodger_box">
                    <dt><?php echo CHtml::label(Yii::t('hotelOrder', '住客信息'), ''); ?>：</dt>
                    <dd>
                        <?php $lodgerJs = array(); ?>
                        <?php foreach ($pastGuests as $key => $guests): ?>
                            <?php echo CHtml::checkBox('past_guests', false, array('id' => "lodger_$key", 'value' => $guests->name, 'data-id' => $guests->id)); ?>
                            <?php echo CHtml::label($guests->name, "lodger_$key") ?>
                            <?php $lodgerJs[$guests->id] = array_merge(array('id' => $guests->id), $guests->dataCompound()); ?>
                        <?php endforeach; ?>
                    </dd>
                    <?php
                    // 将住客信息生成JSON数据
                    Yii::app()->clientScript->registerScript("lodgerJs", "var LodgerData = " . json_encode($lodgerJs) . "", CClientScript::POS_HEAD);
                    ?>
                </dl>
            <?php endif; ?>
            <div class="fillRule">
                <p>
                    <?php echo Yii::t('hotelOrder', '请填写入住人姓名，所填姓名需与入住时所持证件一致。'); ?>
                <div id="showRule"><?php echo Yii::t('hotelOrder', '填写规则') ?>
                    <div class="ruleMsg">
                        <?php echo Yii::t('hotelOrder', '中文填写如：王小花') ?></br>
                        <?php echo Yii::t('hotelOrder', '英文填写需要在名与姓间加“/”如：wang/xiaohua') ?>
                    </div>
                </div>
                <script type="text/javascript">
                    $('#showRule .ruleMsg').css('display', 'none');
                    $('#showRule').hover(function(e) {
                        $(this).find('.ruleMsg').stop().slideDown();
                    }, function() {
                        $(this).find('.ruleMsg').stop().slideUp();
                    });
                </script>
                </p>
            </div>
            <div id="lodger_html_copy_box" style="display: none;">
                <?php $lodgerCopy = new LodgerInfo; ?>
                <dl class="clearfix">
                    <dt><?php echo $form->labelEx($lodgerCopy, "[lodger][replace]name", array('for' => "LodgerInfo_replace_name")); ?>：</dt>
                    <dd><?php echo $form->textField($lodgerCopy, "[lodger][replace]name", array('class' => 'inputtxt w140', 'id' => "LodgerInfo_replace_name", 'value' => '')) ?></dd>
                    <dt><?php echo $form->labelEx($lodgerCopy, "[lodger][replace]nationality", array('for' => "LodgerInfo_replace_nationality")); ?>：</dt>
                    <dd>
                        <?php
                        echo $form->dropDownList($lodgerCopy, "[lodger][replace]nationality", CHtml::listData(Nationality::model()->findAll(), 'name', 'name'), array('prompt' => Yii::t('hotelOrder', '请选择'), 'id' => "LodgerInfo_replace_nationality")
                        );
                        ?>
                    </dd>
                    <dd><?php echo $form->hiddenField($lodgerCopy, "[lodger][replace]id"); ?></dd>
                </dl>
            </div>
            <div class="person-area" id="curr_lodger_box">
                <?php foreach ($lodgerModels as $i => $lodger): ?>
                    <dl class="clearfix">
                        <dt><?php echo $form->labelEx($lodger, "[lodger][$i]name", array('for' => "LodgerInfo_{$i}_name")); ?>：</dt>
                        <dd><?php echo $form->textField($lodger, "[lodger][$i]name", array('class' => 'inputtxt w140', 'id' => "LodgerInfo_{$i}_name")) ?></dd>
                        <dd><?php echo $form->error($lodger, "[lodger][$i]name", array('inputID' => "LodgerInfo_{$i}_name"), isset($_POST['LodgerInfo']), false); ?></dd>

                        <dt><?php echo $form->labelEx($lodger, "[lodger][$i]nationality", array('for' => "LodgerInfo_{$i}_nationality")); ?>：</dt>
                        <dd>
                            <?php
                            echo $form->dropDownList($lodger, "[lodger][$i]nationality", CHtml::listData(Nationality::model()->findAll(), 'name', 'name'), array('prompt' => Yii::t('hotelOrder', '请选择'), 'id' => "LodgerInfo_{$i}_nationality", 'options' => array('selection' => $lodger['nationality']))
                            );
                            ?>
                        </dd>
                        <dd><?php echo $form->error($lodger, "[lodger][$i]nationality", array('inputID' => "LodgerInfo_{$i}_nationality"), isset($_POST['LodgerInfo']), false); ?></dd>
                        <dd><?php echo $form->hiddenField($lodger, "[lodger][$i]id"); ?></dd>
                    </dl>
                <?php endforeach; ?>
            </div>
            <?php if ($room['bed'] == HotelRoom::BED_BIG_BOTH): ?>
                <dl class="clearfix">
                    <dt><?php echo $form->label($model, 'bed', array('required' => true)); ?>：</dt>
                    <dd><?php echo $form->dropDownList($model, 'bed', HotelRoom::getBedRequireArr(), array('prompt' => Yii::t('hotelOrder', '请选择'))); ?></dd>
                    <dd><?php echo $form->error($model, 'bed'); ?></dd>
                </dl>
            <?php endif; ?>
            <dl class="clearfix">
                <dt><?php echo $form->labelEx($model, 'remark'); ?>：</dt>
                <dd class="textdd">
                    <?php echo $form->textArea($model, 'remark', array('class' => 'inputtxt')); ?>
                    <em> <?php echo Yii::t('hotelOrder', '请在左侧方框填写您的其它需要，您的需要将尽量安排，视酒店实际情况。此方框内容不能保证都满足。'); ?></em>
                </dd>
                <dd><?php echo $form->error($model, 'remark'); ?></dd>
            </dl>
            <dl class="clearfix">
                <dt><?php echo $form->labelEx($model, 'cancel_clause'); ?>：</dt>
                <dd>
                    <?php echo $form->checkBox($model,'cancel_clause', array('value'=>1) );?>
                    <b style="color: #ff0000">  <?php echo Yii::t('hotelOrder', '此房即订即保，一旦预订不可修改和取消。'); ?></b>
                </dd>
                <dd><?php echo $form->error($model, 'cancel_clause'); ?></dd>
            </dl>
            <div class="do">
                <?php echo CHtml::hiddenField('peoples_hidd', $model->peoples); ?>
                <?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交订单'), array('class' => 'hbtnSubmit')); ?>
            </div>

            <div class="tips">
                <i class="ico_tip"></i>
                <h2><?php echo Yii::t('hotelOrder', '温馨提示'); ?>：</h2>
                <!--<p><?php /*echo Yii::t('hotelOrder', '1、如您需要修改或取消预订，请致电客服申请，最终申请结果以客服回复为准。') */?></p>-->
                <p><?php echo Yii::t('hotelOrder', '1、当日入住预订时间为当日的') ?><b class="red"><?php echo Tool::getConfig('hotelparams', 'latestStayTime') ?></b><?php echo Yii::t('hotelOrder', '以前，如有不便之处敬请谅解，谢谢。') ?></p>
                <p><?php echo Yii::t('hotelOrder', '2、在您提交订单后，并不意味着您的订房已获确认，只有当您收到盖网发给您的确认短信，您的订房才算得到最终的确认。') ?></p>
                <p><?php echo Yii::t('hotelOrder', '3、每日房价会有轻微浮动，请留意。可联系') ?><b class="red"><?php echo $this->getConfig('hotelparams', 'hotelServiceTel') ?></b></p>
                <p class="red"><?php echo Yii::t('hotelOrder', '最终解释权归盖网所有'); ?></p>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    //页面初始化
    $(document).ready(function() {
        getCheckInTime();
        getPersonCount(false);
    });

    //入住、离店时间、房间数量操作
    var checkingIn = function(flag) {
        var RoomsLimit = parseInt("<?php echo $room['num'] ?>");
        var RoomCount = parseInt($("#RoomCount").val());
        var settled_time = $("#HotelOrder_settled_time").val();
        var leave_time = $("#HotelOrder_leave_time").val();
        // 客房数量判断
        if (RoomCount > RoomsLimit && (flag == 1 || typeof flag == 'undefined')) {
            alert('<?php echo Yii::t('hotelOrder', '限制预定房间数量为'); ?>：' + RoomsLimit + '<?php echo Yii::t('hotelOrder', '间'); ?>');
            RoomCount = 1;
        } else {
            if (isNaN(RoomCount) && RoomCount > RoomsLimit) {
                RoomCount = 1;
            } else {
                if (typeof flag != 'undefined') {
                    RoomCount = flag == 1 ? (RoomCount + 1) : ((RoomCount > 1) ? (RoomCount - 1) : 1);
                    if(RoomCount > RoomsLimit){
                        alert('<?php echo Yii::t('hotelOrder', '限制预定房间数量为'); ?>：' + RoomsLimit + '<?php echo Yii::t('hotelOrder', '间'); ?>');
                    }
                }
            }
        }

        // 获取客房入住费用
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl('/hotel/order/checkingInDetail') ?>",
            type: "GET",
            dataType: "json",
            data: {settled_time: settled_time, leave_time: leave_time, room_count: RoomCount, room_id: "<?php echo base64_encode($room['id']); ?>"},
            success: function(result) {
                if (result.result == 'succeed') {
                    $("#RoomCount").val(result.room_count);
                    $("#total").html(result.total_price);
                    $("#totalPay").html(result.total_price);
                    $("#total_price").val(result.total_price);
                    $("#HotelOrder_settled_time").val(result.settled_time);
                    $("#HotelOrder_leave_time").val(result.leave_time);
                    $("#estimate_back_credits").html(result.refund);
                    getPersonCount(true);
                }
            },
            error: function() {
                alert('<?php echo Yii::t('hotelOrder', '请求失败'); ?>');
                location.reload();
                return;
            },
            cache: false
        });
    }

    /** 入住人数列表 **/
    var getPersonCount = function(flag) {
        var count = parseInt($("#RoomCount").val());
        var peoples = parseInt($('#peoples_hidd').val());
        var options = [];
        var RoomsLimit = parseInt("<?php echo $room['num'] ?>");
        if (count > RoomsLimit) {
            count = 1;
            $("#RoomCount").val(count);
        }

        for (var i = count; i <= count * 2; i++) {
            if (i == peoples) {
                options.push('<option selected="selected" value ="' + i + '">' + i + '</option>');
            } else {
                options.push('<option value ="' + i + '">' + i + '</option>');
            }
            $('#PersonCount').html(options.join(''));
        }

        if (flag === true)
            getPersonInfo();
        delete options;
        options = null;
    };

    /** 生成入住信息表单元素 **/
    var getPersonInfo = function() {

        var Persons = $('#PersonCount').val(),
                CurrLodger = $('#curr_lodger_box'),
                HasSelected = CurrLodger.find('dl').length,
                Copyobject = $('#lodger_html_copy_box').html(),
                Html = '';

        if (Persons >= HasSelected) {
            var arr = [];
            for (var i = HasSelected; i < Persons; i++) {
                Html += Copyobject.replace(/\[replace\]/g, '[' + i + ']').replace(/_replace_/g, '_' + i + '_');
                arr.push(i);
            }
            CurrLodger.append(Html);
        } else {
            for (var i = HasSelected - 1; i >= Persons; i--) {
                var removeObject = CurrLodger.find('.inputtxt').eq(i);
                var key = removeObject.attr('data-curr');
                if (typeof key != 'undefined') {
                    $("#history_lodger_box input[data-id = '" + key + "']").attr('checked', false);
                }
                removeObject.parents('dl').remove();
            }
        }
        $('#peoples_hidd').val(Persons);
    };

    var tsArra = '';
    var getCheckInTime = function() {
        tsArra = new Array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30",
                "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30", "00:00");
        var options = [];
        for (var i = 0; i < tsArra.length - 6; i++) {
            options.push('<option value ="' + tsArra[i] + '">' + tsArra[i] + '</option>');
        }
        $('#HotelOrder_earliest_time').append(options.join('')).attr('style', 'zoom:1').val('<?php echo $model->earliest_time ?>');
<?php if (isset($_POST)): ?>startChange();
            return;<?php endif; ?>
        var endOptions = [];
        for (var i = 0; i < 7; i++) {
            endOptions.push('<option value="' + tsArra[i] + '">' + tsArra[i] + '</opton>');
        }
        $('#HotelOrder_latest_time').append(endOptions.join('')).attr('style', 'zoom:1');
    };

    var startChange = function() {
        var selectedValue = $('#HotelOrder_earliest_time').val();
        for (var i = 0; i < tsArra.length; i++) {
            if (selectedValue == tsArra[i]) {
                var endOptions = [];
                for (var j = 0; j < 7; j++) {
                    endOptions.push('<option value="' + tsArra[j + i] + '">' + tsArra[j + i] + '</opton>');
                }
                $('#HotelOrder_latest_time').html(endOptions.join('')).attr('style', 'zoom:1').val('<?php echo $model->latest_time ?>');
                break;
            }
        }
    };

    /**
     * 选中填充数据
     */
    $('#history_lodger_box input').click(function() {
        var HistoryLodger = $(this),
                HistoryLodgerLen = $(this).length,
                CurrLodger = $('#curr_lodger_box'),
                CurrLodgerLen = CurrLodger.find('input').length,
                SelectedId = $(this).attr('data-id');

        var exist = $(CurrLodger).find("input[data-curr = '" + SelectedId + "']");
        if (exist.length > 0) {
            exist.val('')
            exist.removeAttr('data-curr');
            exist.parents('dl').find('select').val('');
            exist.parents('dl').find('input[type = "hidden"]').val('');
            return;
        }

        $(CurrLodger).find('input[type="text"]').each(function(i) {
            var curr = $(this).attr('data-curr');
            if (typeof curr == 'undefined' || $(this).val() == '') {
                if (typeof LodgerData[SelectedId] != 'undefined') {
                    $(this).attr('data-curr', SelectedId);
                    $(this).val(LodgerData[SelectedId]['name']);
                    CurrLodger.find('select').eq(i).val(LodgerData[SelectedId]['nationality']);
                    CurrLodger.find('input[type = "hidden"]').eq(i).val(LodgerData[SelectedId]['id']);
                    HistoryLodger.attr('checked', true);
                    return false;
                }
            } else {
                HistoryLodger.attr('checked', false);
            }
        })
    })
</script>