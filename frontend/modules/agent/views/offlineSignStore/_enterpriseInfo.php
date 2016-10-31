<div class="sign-tableTitle">企业信息<a class="check">查看</a></div>
<div class="sign-list" style="display:none;">
    <div class="audit-party clearfix">
    <div class="left">
        <ul>
            <li id="e.name">
                <span class="party-name"><i class="red">*</i>企业名称</span>
                <span class="party-con"><?php echo $enterpriseModel->name?></span>
            </li>
            <li id="e.is_chain">
                <span class="party-name">是否连锁</span>
                <span class="party-con"><?php echo OfflineSignEnterprise::getIsChain($enterpriseModel->is_chain)?></span>
            </li>
            <?php if($enterpriseModel->is_chain):?>
                <li id="e.chain_type">
                    <span class="party-name">企业连锁形态</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getChainType($enterpriseModel->chain_type)?></span>
                </li>
                <li id="e.chain_number">
                    <span class="party-name">连锁数量</span>
                    <span class="party-con"><?php echo $enterpriseModel->chain_number;?></span>
                </li>
            <?php endif;?>
            <li id="e.linkman_name">
                <span class="party-name"><i class="red">*</i>企业联系人姓名</span>
                <span class="party-con"><?php echo $enterpriseModel->linkman_name?></span>
            </li>
            <li id="e.linkman_position">
                <span class="party-name"><i class="red">*</i>企业联系人职位</span>
                <span class="party-con"><?php echo $enterpriseModel->linkman_position?></span>
            </li>
            <li id="e.linkman_webchat">
                <span class="party-name">企业联系人微信</span>
                <span class="party-con"><?php echo $enterpriseModel->linkman_webchat?></span>
            </li>
            <li id="e.linkman_qq">
                <span class="party-name">企业联系人QQ</span>
                <span class="party-con"><?php echo $enterpriseModel->linkman_qq?></span>
            </li>
            <li id="e.enterprise_type">
                <span class="party-name"><i class="red">*</i>企业类型</span>
                <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterpriseModel->enterprise_type)?></span>
            </li>
            <li id="e.enterprise_license_number">
                <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                <span class="party-con"><?php echo $enterpriseModel->enterprise_license_number?></span>
            </li>
            <li id="e.registration_time">
                <span class="party-name">成立日期</span>
                <span class="party-con"><?php echo $enterpriseModel->registration_time ?></span>
            </li>
            <li id="e.license_begin_time">
                <span class="party-name"><i class="red">*</i>营业期限开始日期</span>
                <span class="party-con"><?php echo $enterpriseModel->license_begin_time ?></span>
            </li>
            <li id="e.license_end_time">
                <span class="party-name"><i class="red">*</i>营业期限结束日期</span>
                <?php if($enterpriseModel->license_is_long_time):?>
                <span class="party-con"><?php echo '长期'?>
                    <?php else:?>
                        <span class="party-con"><?php echo $enterpriseModel->license_end_time ?></span>
                    <?php endif;?>
            </li>
            <li id="e.legal_man">
                <span class="party-name"><i class="red">*</i>法人代表</span>
                <span class="party-con"><?php echo $enterpriseModel->legal_man?></span>
            </li>
            <li id="e.legal_man_identity">
                <span class="party-name"><i class="red">*</i>法人身份证号</span>
                <span class="party-con"><?php echo $enterpriseModel->legal_man_identity?></span>
            </li>
            <li id="e.tax_id">
                <span class="party-name"><i class="red">*</i>税务登记证</span>
                <span class="party-con"><?php echo $enterpriseModel->tax_id?></span>
            </li>
        </ul>
    </div>
    <div class="right">
        <div class="party-prcList clearfix">
            <ul>
                <li id="e.license_image">
                    <p class="prcList-name"><span style="width: 1px">*</span>营业执照电子版</p>
                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->license_image);?>" /></p>
                </li>
                <li id="e.tax_image">
                    <p class="prcList-name"><br /><span style="width: 1px">*</span>税务登记证电子版</p>
                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->tax_image);?>" /></p>
                </li>
                <li id="e.identity_image">
                    <p class="prcList-name"><br /><span style="width: 1px">*</span>法人身份证电子版</p>
                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->identity_image);?>" /></p>
                </li>
            </ul>
        </div>
        <div class="c10"></div>
        <div class="party-prcShow">
            <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->license_image);?>" /></span> </div>
        </div>
    </div>
    </div>
</div>

<br/>
<!--audit-party 企业信息补充 end-->

<div class="sign-tableTitle">会员与帐号信息<a class="check">查看</a></div>
<div class="sign-list" style="display:none;">
<div class="audit-party clearfix">
    <div class="left">
        <ul>
            <li id="c.enterprise_proposer">
                <span class="party-name"><i class="red">*</i>企业GW号开通人</span>
                <span class="party-con"><?php echo $contractModel->enterprise_proposer?></span>
            </li>

            <li id="c.mobile">
                <span class="party-name"><i class="red">*</i>企业GW号开通手机</span>
                <span class="party-con"><?php echo $contractModel->mobile?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>结算账户类型</span>
                <span class="party-con"><?php echo OfflineSignEnterprise::getAccountPayType($enterpriseModel->account_pay_type)?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>账户名称</span>
                <span class="party-con"><?php echo $contractModel->account_name ?></span>
            </li>

            <li>
                <span class="party-name"><i class="red">*</i>开户银行名称</span>
                <span class="party-con"><?php echo $contractModel->bank_name ?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>银行账号</span>
                <span class="party-con"><?php echo $contractModel->account ?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>收款人身份证号</span>
                <span class="party-con"><?php echo $enterpriseModel->payee_identity_number?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>开户行区域</span>
                            <span class="party-con">
                            <?php $ids = $enterpriseModel['bank_district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('               ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
            </li>
        </ul>
    </div>
    <div class="right">
        <div class="party-prcList clearfix">
            <ul>
                <?php if($enterpriseModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC):?>
                    <li>
                        <p class="prcList-name"><span style="width: 1px">*</span>开户许可证（或对公账户证明）电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->bank_permit_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                <?php endif;?>
                <?php if($enterpriseModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                    <li>
                        <p class="prcList-name"><span style="width: 1px">*</span>银行卡复印件（只限对私账）电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->bank_account_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><span style="width: 1px">*</span>委托收款授权书电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->entrust_receiv_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><span style="width: 1px">*</span>收款人身份证电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->payee_identity_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                <?php endif;?>
            </ul>
        </div>
        <div class="c10"></div>
        <div class="party-prcShow">
            <div id="preview" class="spec-preview">
                        <span class="jqzoom">
                            <?php if($enterpriseModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC) :?>
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->bank_permit_image);?>" />
                            <?php elseif($enterpriseModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterpriseModel->bank_account_image);?>" />
                            <?php endif;?>
                        </span>
            </div>
        </div>
    </div>
</div>
</div>
<!--audit-party 账号补充信息 end-->
