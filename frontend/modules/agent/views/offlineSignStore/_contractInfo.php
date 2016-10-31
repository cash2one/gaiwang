<div class="sign-tableTitle">合同信息<a class="check">查看</a></div>
<div class="sign-list" style="display:none;">
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li id="c.number">
                    <span class="party-name">合同编号</span>
                    <span class="party-con"><?php echo $contractModel->number; ?></span>
                </li>

                <li id="c.a_name">
                    <span class="party-name">甲方</span>
                    <span class="party-con"><?php echo $contractModel->a_name?></span>
                </li>

                <li id="c.b_name">
                    <span class="party-name">乙方</span>
                    <span class="party-con"><?php echo $contractModel->b_name?></span>
                </li>
                <li id="c.contract_term">
                    <span class="party-name"><i class="red">*</i>合同合作期限</span>
                    <span class="party-con"><?php echo $contractModel->contract_term > 12 ? $contractModel->contract_term/12 . "年" : $contractModel->contract_term . "月"?></span>
                </li>

                <li id="c.begin_time">
                    <span class="party-name"><i class="red">*</i>合作期限起始日期</span>
                    <?php $contractModel->begin_time = date('Y-m-d',$contractModel->begin_time)?>
                    <?php $contractModel->begin_time =$contractModel->begin_time=='1970-01-01'?"":$contractModel->begin_time;?>
                    <span class="party-con"><?php echo $contractModel->begin_time?></span>
                </li>

                <li id="c.end_time">
                    <span class="party-name"><i class="red">*</i>合作期限结束日期</span>
                    <?php if(isset($contractModel->end_time)) $contractModel->end_time = date('Y-m-d',$contractModel->end_time)?>
                    <span class="party-con"><?php echo $contractModel->end_time?></span>
                </li>

                <li id="c.sign_type">
                    <span class="party-name"><i class="red">*</i>签约类型</span>
                    <span class="party-con"><?php echo OfflineSignContract::getSignType($contractModel->sign_type) ?></span>
                </li>

                <li id="c.sign_time">
                    <span class="party-name"><i class="red">*</i>合同签订日期</span>
                    <span class="party-con"><?php echo $contractModel->sign_time?></span>
                </li>

                <li id="c.machine_developer">
                    <span class="party-name"><i class="red">*</i>销售开发人</span>
                    <span class="party-con"><?php echo $contractModel->machine_developer ?></span>
                </li>

                <li id="c.contract_linkman">
                    <span class="party-name"><i class="red">*</i>合同跟进人</span>
                    <span class="party-con"><?php echo $contractModel->contract_linkman ?></span>
                </li>
            </ul>
        </div>
    </div>
    <!--audit-party 合同信息 end-->

    <div class="audit-tableTitle">商户管理费缴纳标准</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="c.operation_type">
                        <span class="party-name">合作方式</span>
                        <span class="party-con" style="width: 70px"><?php echo OfflineSignContract::getOperationType($contractModel->operation_type); ?></span>
                    </li>
                    <?php if($contractModel->operation_type == OfflineSignContract::OPERATION_TYPE_ONE) :?>
                        <li>
                            <div class="party-box" style="width: 450px;" >
                                <p>3小时高峰广告时间段</p>
                                <p class="clearfix">
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_hour?></span>时<span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_minute?></span>分
                                    至
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_end_time_hour?></span>时<span class="red" style="float: none;width: 0px"> <?php echo $contractModel->ad_end_time_minute?></span>分
                                </p>
                                <p>广告时间段收益的<span style="float: none;width: 12px">15%</span></p>
                            </div>
                        </li>
                    <?php elseif($contractModel->operation_type == OfflineSignContract::OPERATION_TYPE_TWO) :?>
                        <li>
                            <div class="party-box" style="width: 450px;" >
                                <p>支付三年的技术服务费 人民币 <span  class="red" style="float:none">贰万伍仟元整（￥25000）</span></p>
                                <p>3小时高峰广告时间段</p>
                                <p class="clearfix">
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_hour?></span>时<span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_minute?></span>分
                                    至
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_end_time_hour?></span>时<span class="red" style="float: none;width: 0px"> <?php echo $contractModel->ad_end_time_minute?></span>分
                                </p>
                                <p>广告时间段收益的<span style="float: none;width: 12px">25%</span></p>
                            </div>
                        </li>
                    <?php  elseif($contractModel->operation_type == OfflineSignContract::OPERATION_TYPE_THREE) :?>
                        <li>
                            <div class="party-box" style="width: 530px;" >
                                <p>支付一年的技术服务费 人民币 <span class="red" style="float:none">壹万元整（￥10000）</span></p>
                                <p><input size="64" value="以后每年均须在与本合同签订日相同日期一次性等额支付年度技术服务费" disabled/></p>
                                <p>3小时高峰广告时间段</p>
                                <p class="clearfix">
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_hour?></span>时<span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_begin_time_minute?></span>分
                                    至
                                    <span class="red" style="float: none;width: 0px"><?php echo $contractModel->ad_end_time_hour?></span>时<span class="red" style="float: none;width: 0px"> <?php echo $contractModel->ad_end_time_minute?></span>分
                                </p>
                                <p>广告时间段收益的<span style="float: none;width: 12px">25%</span></p>
                            </div>
                        </li>
                    <?php endif ;?>
                </ul>
            </div>
    </div>
</div>