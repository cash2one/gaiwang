<div class="main">
    <div class="toolbarSign">
        <h3>温馨提示：<span class="red">若选择未通过审核，请勾选并填写未通过原因，再点击提交！</span></h3>
    </div>
    <div class="c10"></div>
    <form id="auditing_form"  method="post">
        <div class="audit-type clearfix">
            <div><span>新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type) ?></div>
            <div><span>企业名称</span><?php echo $enterprise_model->name ?></div>
        </div>

        <div class="audit-tableTitle">归属方信息</div>
        <div class="audit-party clearfix">
            <ul>
                <li id="ex.franchisee_developer">
                    <span class="party-name"><i class="red">*</i>加盟商开发方</span>
                    <span class="party-con"><?php echo OfflineSignStoreExtend::getFranchiseeDeveloper($extendModel->franchisee_developer) ?></span>
                    <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商开发方','field'=>'ex.franchisee_developer'))?></span>

                </li>
                <li id="ex.machine_belong_to">
                    <span class="party-name"><i class="red">*</i>机器归属方</span>
                    <span class="party-con"><?php echo OfflineSignStoreExtend::getMachineBelongTo($extendModel->machine_belong_to) ?></span>
                    <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'机器归属方','field'=>'ex.machine_belong_to'))?></span>

                </li>
            </ul>
        </div>

        <div class="audit-tableTitle">企业信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="e.name">
                        <span class="party-name"><i class="red">*</i>企业名称</span>
                        <span class="party-con"><?php echo $enterprise_model->name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业名称','field'=>'e.name'))?></span>
                    </li>
                    <li id="e.is_chain">
                        <span class="party-name">是否连锁</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getIsChain($enterprise_model->is_chain) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'是否连锁','field'=>'e.is_chain'))?></span>
                    </li>
                    <?php if($enterprise_model->is_chain):?>
                    <li id="e.chain_type">
                        <span class="party-name">企业连锁形态</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getChainType($enterprise_model->chain_type)?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业连锁形态','field'=>'e.chain_type'))?></span>
                    </li>
                    <li id="e.chain_number">
                        <span class="party-name">连锁数量</span>
                        <span class="party-con"><?php echo $enterprise_model->chain_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'连锁数量','field'=>'e.chain_number'))?></span>
                    </li>
                    <?php endif;?>
                    <li id="e.linkman_name">
                        <span class="party-name"><i class="red">*</i>企业联系人姓名</span>
                        <span class="party-con"><?php echo $enterprise_model->linkman_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业联系人姓名','field'=>'e.linkman_name'))?></span>
                    </li>
                    <li id="e.linkman_position">
                        <span class="party-name"><i class="red">*</i>企业联系人职位</span>
                        <span class="party-con"><?php echo $enterprise_model->linkman_position ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业联系人职位','field'=>'e.linkman_position'))?></span>
                    </li>
                    <li id="e.linkman_webchat">
                        <span class="party-name">企业联系人微信</span>
                        <span class="party-con"><?php echo $enterprise_model->linkman_webchat ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业联系人微信','field'=>'e.linkman_webchat'))?></span>
                    </li>
                    <li id="e.linkman_qq">
                        <span class="party-name">企业联系人QQ</span>
                        <span class="party-con"><?php echo $enterprise_model->linkman_qq ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业联系人QQ','field'=>'e.linkman_qq'))?></span>
                    </li>
                    <li id="c.p_province_id">
                        <span class="party-name">推广地区</span>
                            <span class="party-con">
                            <?php $ids = $contract_model['p_province_id'] . "," . $contract_model['p_city_id'] .','. $contract_model['p_district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'推广地区','field'=>'c.p_province_id'))?></span>
                    </li>
                    <li id="e.enterprise_type">
                        <span class="party-name"><i class="red">*</i>企业类型</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterprise_model->enterprise_type) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业类型','field'=>'e.enterprise_type'))?></span>
                    </li>
                    <li id="e.b_name">
                        <span class="party-name"><i class="red">*</i>营业执照注册名称</span>
                        <span class="party-con"><?php echo $contract_model->b_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照注册名称','field'=>'e.b_name'))?></span>
                    </li>
                    <li id="e.enterprise_license_number">
                        <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                        <span class="party-con"><?php echo $enterprise_model->enterprise_license_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照注册号','field'=>'e.enterprise_license_number'))?></span>
                    </li>
                    <li id="c.province_id">
                        <span class="party-name"><i class="red">*</i>营业执照注册地区</span>
                            <span class="party-con">
                            <?php $ids = $contract_model['province_id'] . "," . $contract_model['city_id'] .','. $contract_model['district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照注册地区','field'=>'c.province_id'))?></span>
                    </li>
                    <li id="c.address">
                        <span class="party-name"><i class="red">*</i>营业执照注册地址</span>
                        <span class="party-con"><?php echo $contract_model->address ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照注册地址','field'=>'c.address'))?></span>
                    </li>
                    <li id="e.registration_time">
                        <span class="party-name"><i class="red">*</i>成立时间</span>
                        <span class="party-con"><?php echo $enterprise_model->registration_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'成立时间','field'=>'e.registration_time'))?></span>
                    </li>
                    <li id="e.license_begin_time">
                        <span class="party-name"><i class="red">*</i>营业期限开始日期</span>
                        <span class="party-con"><?php echo $enterprise_model->license_begin_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业期限开始日期','field'=>'e.license_begin_time'))?></span>
                    </li>
                    <li id="e.license_end_time">
                        <span class="party-name"><i class="red">*</i>营业期限结束日期</span>
                        <span class="party-con"><?php echo ($enterprise_model->license_end_time == 0)? '长期': $enterprise_model->license_end_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业期限结束日期','field'=>'e.license_end_time'))?></span>
                    </li>
                    <li id="e.legal_man">
                        <span class="party-name"><i class="red">*</i>法人代表</span>
                        <span class="party-con"><?php echo $enterprise_model->legal_man ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'法人代表','field'=>'e.legal_man'))?></span>
                    </li>
                    <li id="e.legal_man_identity">
                        <span class="party-name"><i class="red">*</i>法人身份证号</span>
                        <span class="party-con"><?php echo $enterprise_model->legal_man_identity ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'法人身份证号','field'=>'e.legal_man_identity'))?></span>
                    </li>
                    <li id="e.tax_id">
                        <span class="party-name"><i class="red">*</i>税务登记证号</span>
                        <span class="party-con"><?php echo $enterprise_model->tax_id ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'税务登记证','field'=>'e.tax_id'))?></span>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <li id="e.license_image">
                            <p class="prcList-name"><br /><span>*</span>营业执照电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->license_image);?>" /></p>
                            <p class="prcList-cho">
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照电子版','field'=>'e.license_image'))?></span>
                            </p>
                        </li>
                        <li id="e.tax_image">
                            <p class="prcList-name"><br /><span>*</span>税务登记证电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->tax_image);?>" /></p>
                            <p class="prcList-cho">
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'税务登记证电子版','field'=>'e.tax_image'))?></span>
                            </p>
                        </li>
                        <li id="e.identity_image">
                            <p class="prcList-name"><br /><span>*</span>法人身份证电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->identity_image);?>" /></p>
                            <p class="prcList-cho">
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'法人身份证电子版','field'=>'e.identity_image'))?></span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="c10"></div>
                <div class="party-prcShow">
                    <div id="preview" class="spec-preview">
                            <span class="jqzoom">
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->license_image);?>" />
                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!--audit-party 企业信息 end-->

        <div class="audit-tableTitle">会员与帐号信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="c.enterprise_proposer">
                        <span class="party-name"><i class="red">*</i>企业GW号开通人</span>
                        <span class="party-con"><?php echo $contract_model->enterprise_proposer ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'GW号开通人','field'=>'c.enterprise_proposer'))?></span>
                    </li>
                    <li id="c.mobile">
                        <span class="party-name">企业GW号开通手机</span>
                        <span class="party-con"><?php echo $contract_model->mobile ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'GW号开通手机','field'=>'c.mobile'))?></span>
                    </li>
                    <li id="e.account_pay_type">
                        <span class="party-name"><i class="red">*</i>结算账户类型</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getAccountPayType($enterprise_model->account_pay_type)?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'结算账户类型','field'=>'e.account_pay_type'))?></span>
                    </li>
                    <li id="c.account_name">
                        <span class="party-name"><i class="red">*</i>账户名称</span>
                        <span class="party-con"><?php echo $contract_model->account_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'账户名称','field'=>'c.account_name'))?></span>
                    </li>

                    <li id="c.bank_name">
                        <span class="party-name"><i class="red">*</i>开户银行名称</span>
                        <span class="party-con"><?php echo $contract_model->bank_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'开户银行名称','field'=>'c.bank_name'))?></span>
                    </li>
                    <li id="c.account">
                        <span class="party-name"><i class="red">*</i>银行账号</span>
                        <span class="party-con"><?php echo $contract_model->account ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'银行账号','field'=>'c.account'))?></span>
                    </li>
                    <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                    <li id="e.payee_identity_number">
                        <span class="party-name"><i class="red">*</i>收款人身份证号</span>
                        <span class="party-con"><?php echo $enterprise_model->payee_identity_number?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'收款人身份证号','field'=>'e.payee_identity_number'))?></span>
                    </li>
                    <?php endif;?>
                    <li id="e.bank_district_id">
                        <span class="party-name"><i class="red">*</i>开户行区域</span>
                            <span class="party-con">
                            <?php $ids = $enterprise_model['bank_district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('               ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'开户行区域','field'=>'e.bank_district_id'))?></span>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC):?>
                            <li id="e.bank_permit_image">
                                <p class="prcList-name"><span>*</span>开户许可证（或对公账户证明）电子版</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_permit_image);?>" /></p>
                                <p class="prcList-cho">
                                    <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'开户许可证（或对公账户证明）电子版','field'=>'e.bank_permit_image'))?></span>
                                </p>
                            </li>
                        <?php endif;?>
                        <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                            <li id="e.bank_account_image">
                                <p class="prcList-name"><span>*</span>银行卡复印件（只限对私账）电子版</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_account_image);?>" /></p>
                                <p class="prcList-cho">
                                     <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'银行卡复印件（只限对私账）电子版','field'=>'e.bank_account_image'))?></span>
                                </p>
                            </li>
                            <?php if($enterprise_model->legal_man_identity != $enterprise_model->payee_identity_number):?>
                            <li id="e.entrust_receiv_image">
                                <p class="prcList-name"><span>*</span>委托收款授权书电子版</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->entrust_receiv_image);?>" /></p>
                                <p class="prcList-cho">
                                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'委托收款授权书电子版','field'=>'e.entrust_receiv_image'))?></span>
                                </p>
                            </li>
                                <?php endif;?>
                            <li id="e.payee_identity_image">
                                <p class="prcList-name"><span>*</span>收款人身份证电子版</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->payee_identity_image);?>" /></p>
                                <p class="prcList-cho">
                                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'收款人身份证电子版','field'=>'e.payee_identity_image'))?></span>
                                </p>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="c10"></div>
                <div class="party-prcShow">
                    <div id="preview" class="spec-preview">
                        <span class="jqzoom">
                            <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC) :?>
                            <img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_permit_image);?>" />
                            <?php elseif($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                            <img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_account_image);?>" />
                            <?php endif;?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!--audit-party 会员与帐号信息 end-->
        <div class="audit-tableTitle">盖网通店铺、铺设概况</div>
<?php  foreach($storeData as $key=>$model):?>
    <div class="audit-tableTitle">加盟商-<?php echo $key+1;?></div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li  id="s.<?php echo $model->id?>franchisee_name">
                        <span class="party-name"><i class="red">*</i>加盟商名称</span>
                            <span class="party-con"><?php echo  $model->franchisee_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':加盟商名称','field'=>'s'.($model->id).'.franchisee_name'))?></span>
                    </li>
                    <li  id="s.<?php echo $model->id?>install_province_id">
                        <span class="party-name"><i class="red">*</i>加盟商区域</span>
                            <span class="party-con">
<?php $ids = $model['install_province_id'] . "," . $model['install_city_id'] .','. $model['install_district_id']; ?>
<?php $ids = Region::getNameArray($ids); ?>
<?php $ids = implode('               ',$ids) ;?>
<?php echo Region::getAreaNameById($model->install_area_id).' '.$ids; ?>
                            </span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':加盟商区域','field'=>'s'.($model->id).'.install_province_id'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>install_street">
                        <span class="party-name"><i class="red">*</i>加盟商详细地址</span>
                        <span class="party-con"><?php echo $model->install_street?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':加盟商详细地址','field'=>'s'.($model->id).'.install_street'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>machine_administrator">
                        <span class="party-name">盖网通管理人姓名</span>
                        <span class="party-con"><?php echo $model->machine_administrator?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网通管理人姓名','field'=>'s'.($model->id).'.machine_administrator'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>machine_administrator_mobile">
                        <span class="party-name">盖网通管理人移动电话</span>
                        <span class="party-con"><?php echo $model->machine_administrator_mobile?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网通管理人移动电话','field'=>'s'.($model->id).'.machine_administrator_mobile'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>machine_number">
                        <span class="party-name">盖网通数量</span>
                        <span class="party-con"><?php echo $model->machine_number?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网通数量','field'=>'s'.($model->id).'.machine_number'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>machine_size">
                        <span class="party-name">尺寸</span>
                        <span class="party-con"><?php echo OfflineSignStore::getMachineSize($model->machine_size)?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖机尺寸','field'=>'s'.($model->id).'.machine_size'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_location">
                        <span class="party-name"><i class="red">*</i>所在商圈</span>
                        <span class="party-con"><?php echo $model->store_location?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':所在商圈','field'=>'s'.($model->id).'.store_location'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_linkman">
                        <span class="party-name"><i class="red">*</i>商家联系人</span>
                        <span class="party-con"><?php echo $model->store_linkman?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':商家联系人','field'=>'s'.($model->id).'.store_linkman'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_linkman_position">
                        <span class="party-name"><i class="red">*</i>商家联系人职位</span>
                        <span class="party-con"><?php echo $model->store_linkman_position?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':商家联系人职位','field'=>'s'.($model->id).'.store_linkman_position'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_linkman_webchat">
                        <span class="party-name">商家联系人微信</span>
                        <span class="party-con"><?php echo $model->store_linkman_webchat?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':商家联系人微信','field'=>'s'.($model->id).'.store_linkman_webchat'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_linkman_qq">
                        <span class="party-name">商家联系人QQ</span>
                        <span class="party-con"><?php echo $model->store_linkman_qq?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':商家联系人QQ','field'=>'s'.($model->id).'.store_linkman_qq'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_linkman_email">
                        <span class="party-name">商家联系人邮箱</span>
                        <span class="party-con"><?php echo $model->store_linkman_email?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':商家联系人邮箱','field'=>'s'.($model->id).'.store_linkman_email'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_phone">
                        <span class="party-name"><i class="red">*</i>店面固定电话</span>
                        <span class="party-con"><?php echo $model->store_phone?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':店面固定电话','field'=>'s'.($model->id).'.store_phone'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_mobile">
                        <span class="party-name"><i class="red">*</i>店面移动电话</span>
                        <span class="party-con"><?php echo $model->store_mobile?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':店面固定电话','field'=>'s'.($model->id).'.store_mobile'))?></span>
                    </li>
                    <?php $aa = array()?>
                    <?php OfflineSignStore::getParentCategory($model->franchisee_category_id,$aa);?>
                    <?php if(count($aa) == 1):?>
                        <li id="s.<?php echo $model->id?>depthZero">
                            <span class="party-name"><i class="red">*</i>经营类别（级别一）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[0])?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':经营类别（级别一）','field'=>'s'.($model->id).'.depthZero'))?></span>
                        </li>
                        <li id="s.<?php echo $model->id?>depthOne">
                            <span class="party-name">经营类别（级别二）</span>
                            <span class="party-con"></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':经营类别（级别二）','field'=>'s'.($model->id).'.depthOne'))?></span>
                        </li>
                    <?php elseif((count($aa) == 2)):?>
                        <li id="s.<?php echo $model->id?>depthZero">
                            <span class="party-name"><i class="red">*</i>经营类别（级别一）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[1])?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':经营类别（级别一）','field'=>'s'.($model->id).'.depthZero'))?></span>
                        </li>
                        <li id="s.<?php echo $model->id?>depthOne">
                            <span class="party-name">经营类别（级别二）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[0])?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':经营类别（级别二）','field'=>'s'.($model->id).'.depthOne'))?></span>
                        </li>
                    <?php endif;?>
                    <li id="s.<?php echo $model->id?>open_begin_time">
                        <span class="party-name"><i class="red">*</i>营业开始时间</span>
                        <span class="party-con"><?php echo $model->open_begin_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':营业开始时间','field'=>'s'.($model->id).'.open_begin_time'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>open_end_time">
                        <span class="party-name"><i class="red">*</i>营业结束时间</span>
                        <span class="party-con"><?php echo $model->open_end_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':营业结束时间','field'=>'s'.($model->id).'.open_end_time'))?></span>

                    </li>
                    <li id="s.<?php echo $model->id?>exists_membership">
                        <span class="party-name">是否存在会员制</span>
                        <span class="party-con"><?php  echo OfflineSignStore::getExistsMembership($model->exists_membership) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':是否有会员制','field'=>'s'.($model->id).'.exists_membership'))?></span>
                    </li>
                    <?php if($model->exists_membership):?>
                    <li id="s.<?php echo $model->id?>member_discount_type">
                        <span class="party-name">会员折扣方式</span>
                        <span class="party-con"><?php  echo OfflineSignStore::getDiscountType($model->member_discount_type) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':会员折扣方式','field'=>'s'.($model->id).'.member_discount_type'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>store_disconunt">
                        <span class="party-name">会员折扣(%)</span>
                        <span class="party-con"><?php  echo $model->store_disconunt ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':会员折扣','field'=>'s'.($model->id).'.store_disconunt'))?></span>
                    </li>
                    <?php endif ;?>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <li id="s.<?php echo $model->id?>store_banner_image">
                            <p class="prcList-name"><span>*</span>带招牌的店铺门面照片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->store_banner_image);?>" /></p>
                            <p class="prcList-cho">
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':带招牌的店铺门面照片','field'=>'s'.($model->id).'.store_banner_image'))?></span>
                            </p>
                        </li>
                        <li id="s.<?php echo $model->id?>store_inner_image">
                            <p class="prcList-name"><br /><span>*</span>店铺内部图片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->store_inner_image);?>" /></p>
                            <p class="prcList-cho">
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':店铺内部图片','field'=>'s'.($model->id).'.store_inner_image'))?></span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="c10"></div>
                <div class="party-prcShow">
                    <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?php echo OfflineSignFile::getfileUrl($model->store_banner_image);?>" /></span> </div>
                </div>
            </div>
        </div>
        <!--audit-party 店铺信息 end-->
        <div class="audit-tableTitle">优惠约定</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="s.<?php echo $model->id?>member_discount">
                        <span class="party-name"><i class="red">*</i>盖网会员结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->member_discount  ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网会员结算折扣','field'=>'s'.($model->id).'.member_discount'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>discount">
                        <span class="party-name"><i class="red">*</i>折扣差(%)</span>
                        <span class="party-con"><?php echo $model->discount  ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':折扣差','field'=>'s'.($model->id).'.discount'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>gai_discount">
                        <span class="party-name"><i class="red">*</i>盖网公司结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->gai_discount  ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网公司结算折扣','field'=>'s'.($model->id).'.gai_discount'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>clearing_remark">
                        <span class="party-name" style="width: 180px;">盖网会员结算折扣备注</span>
                        <span class="party-con"  style="width: 240px;"><?php echo $model->clearing_remark ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网会员结算折扣备注','field'=>'s'.($model->id).'.clearing_remark'))?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 折扣与管理费缴纳信息 end-->

        <div class="audit-tableTitle">机器信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="s.<?php echo $model->id?>machine_install_type">
                        <span class="party-name"><i class="red">*</i>铺设类型</span>
                        <span class="party-con"><?php echo  OfflineSignStore::getInstallType($model->machine_install_type) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':铺设类型','field'=>'s'.($model->id).'.machine_install_type'))?></span>
                    </li>
                    <li id="s.<?php echo $model->id?>machine_install_style">
                        <span class="party-name"><i class="red">*</i>样式</span>
                        <span class="party-con"><?php echo OfflineSignStore::getInstallStyle($model->machine_install_style) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':样式','field'=>'s'.($model->id).'.machine_install_style'))?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 机器信息 end-->
        <div class="audit-tableTitle">盖网通推荐者绑定信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li>
                        <span class="party-name">企业会员名称</span>
                        <span class="party-con"><?php echo $model->enterprise_member_name_agent ?></span>
                    </li>

                    <li>
                        <span class="party-name">加盟商名</span>
                        <span class="party-con"><?php  echo $model->franchisee_name ?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>franchisee_operate_name">
                        <span class="party-name">联盟商户运维方名称</span>
                        <span class="party-con"><?php echo $model->franchisee_operate_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':联盟商户运维方名称','field'=>'s'.($model->id).'.franchisee_operate_name'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>franchisee_operate_gai_number">
                        <span class="party-name">运维方GW号</span>
                        <span class="party-con"><?php echo $model->franchisee_operate_gai_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':运维方GW号','field'=>'s'.($model->id).'.franchisee_operate_gai_number'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>enterprise_member_name_agent">
                        <span class="party-name">企业会员名称(代理商)</span>
                        <span class="party-con"><?php echo $model->enterprise_member_name_agent ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':企业会员名称(代理商)','field'=>'s'.($model->id).'.enterprise_member_name_agent'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>recommender_agent_gai_number">
                        <span class="party-name">推荐者GW号（代理商）</span>
                        <span class="party-con"><?php echo $model->recommender_agent_gai_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':推荐者GW号（代理商）','field'=>'s'.($model->id).'.recommender_agent_gai_number'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>recommender_mobile">
                        <span class="party-name">推荐者手机号码(代理)</span>
                        <span class="party-con"><?php echo $model->recommender_mobile ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':推荐者手机号码(代理)','field'=>'s'.($model->id).'.recommender_mobile'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>recommender_linkman">
                        <span class="party-name">联系人（代理商）</span>
                        <span class="party-con"><?php echo $model->recommender_linkman ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':联系人（代理商）','field'=>'s'.($model->id).'.recommender_linkman'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>recommender_mobile_member">
                        <span class="party-name">推荐者手机号码（会员）</span>
                        <span class="party-con"><?php echo $model->recommender_mobile_member ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':推荐者手机号码（会员）','field'=>'s'.($model->id).'.recommender_mobile_member'))?></span>
                    </li>

                    <li id="s.<?php echo $model->id?>recommender_member_gai_number">
                        <span class="party-name">推荐者GW号（会员）</span>
                        <span class="party-con"><?php echo $model->recommender_member_gai_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':推荐者GW号（会员）','field'=>'s'.($model->id).'.recommender_member_gai_number'))?></span>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <li id="s.<?php echo $model->id?>recommender_apply_image">
                            <p class="prcList-name"><span>*</span>盖机推荐者绑定申请照片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->recommender_apply_image);?>" /></p>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖机推荐者绑定申请照片','field'=>'s'.($model->id).'.recommender_apply_image'))?></span>
                        </li>
                    </ul>
                    <div class="c10"></div>
                    <div class="party-prcShow">
                        <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?php echo OfflineSignFile::getfileUrl($model->recommender_apply_image);?>" /></span> </div>
                    </div>
                </div>
            </div>
            </div>
            <?php endforeach;?>
        <!--audit-party 盖机推荐者绑定信息 end-->
        <div class="audit-tableTitle">管理费缴纳信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                <li>
                    <span class="party-name"><strong>商户管理费缴纳标准</strong></span>
                    <span class="party-con">......................................</span>
                </li>
                <li style="height: 80px;"  id="c.operation_type">
                    <span class="party-name"><i class="red">*</i>收费方式</span>
                    <span class="party-con"><?php echo OfflineSignContract::getOperationType($contract_model->operation_type)  ?></span>
                    <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'收费方式','field'=>'c.operation_type'))?></span>
                </li>
                <?php if($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_ONE) :?>
                    <li>
                        <div class="party-box" style="width: 450px;" >
                            <p>3小时高峰广告时间段</p>
                            <p class="clearfix">
                                <span class="red"> <?php echo $contract_model->ad_begin_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_begin_time_minute?> </span>分
                                至
                                <span class="red"> <?php echo $contract_model->ad_end_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_end_time_minute?> </span>分
                            </p>
                            <p>广告时间段收益的<span>15%</span></p>
                        </div>
                    </li>
                <?php elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_TWO) :?>
                    <li>
                        <div class="party-box" style="width: 450px;" >
                            <p>支付三年的技术服务费 人民币 <span class="red">贰万伍仟元整（￥25000）</span></p>
                            <p>3小时高峰广告时间段</p>
                            <p class="clearfix">
                                <span class="red"> <?php echo $contract_model->ad_begin_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_begin_time_minute?> </span>分
                                至
                                <span class="red"> <?php echo $contract_model->ad_end_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_end_time_minute?> </span>分
                            </p>
                            <p>广告时间段收益的<span>25%</span></p>
                        </div>
                    </li>
                <?php  elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_THREE) :?>
                    <li>
                        <div class="party-box" style="width: 450px;" >
                            <p>支付一年的技术服务费 人民币 <span class="red">壹万元整（￥10000）</span></p>
                            <p style="color: red;">以后每年均须在与本合同签订日相同日期一次性等额支付年度技术服务费</p>
                            <p>3小时高峰广告时间段</p>
                            <p class="clearfix">
                                <span class="red"> <?php echo $contract_model->ad_begin_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_begin_time_minute?> </span>分
                                至
                                <span class="red"> <?php echo $contract_model->ad_end_time_hour?> </span>时<span class="red"> <?php echo $contract_model->ad_end_time_minute?> </span>分
                            </p>
                            <p>广告时间段收益的<span>25%</span></p>
                        </div>
                    </li>
                <?php endif ;?>
                <li>
                    <span class="party-name"><span class="red">*</span>每次缴纳金额</span>
                    <?php if($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_ONE) :?>
                        <span class="party-con">0元</span>
                    <?php elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_TWO) :?>
                        <span class="party-con">25000元</span>
                    <?php  elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_THREE):?>
                        <span class="party-con">10000元</span>
                    <?php endif ;?>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>缴纳总额</span>
                    <?php if($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_ONE) :?>
                        <span class="party-con">0元</span>
                    <?php elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_TWO) :?>
                        <span class="party-con">25000元</span>
                    <?php  elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_THREE):?>
                        <span class="party-con">10000元</span>
                    <?php endif ;?>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>广告分成比例(%)</span>
                    <?php if($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_ONE) :?>
                        <span class="party-con">15%</span>
                    <?php elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_TWO) :?>
                        <span class="party-con">25%</span>
                    <?php  elseif($contract_model->operation_type == OfflineSignContract::OPERATION_TYPE_THREE):?>
                        <span class="party-con">25%</span>
                    <?php endif ;?>
                </li>
                </ul>
            </div>
        </div>
        <!--audit-party 管理费缴纳信息 end-->
        <div class="audit-tableTitle">合同信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="c.number">
                        <span class="party-name">合同编号</span>
                        <span class="party-con"><?php  echo $contract_model->number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合同编号','field'=>'c.number')) ?></span>
                    </li>
                    <li id="c.a_name">
                        <span class="party-name">甲方</span>
                        <span class="party-con"><?php  echo $contract_model->a_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'甲方','field'=>'c.a_name'))?></span>
                    </li>
                    <li id="c.b_name">
                        <span class="party-name"><i class="red">*</i>乙方</span>
                        <span class="party-con"><?php  echo $contract_model->b_name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'乙方','field'=>'c.b_name'))?></span>
                    </li>
                    <li id="c.sign_type">
                        <span class="party-name"><i class="red">*</i>签约类型</span>
                        <span class="party-con"><?php  echo OfflineSignStoreExtend::getSignType($contract_model->sign_type) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'签约类型','field'=>'c.sign_type'))?></span>
                    </li>
                    <li id="c.sign_time">
                        <span class="party-name"><i class="red">*</i>合同签订日期</span>
                        <span class="party-con"><?php echo $contract_model->sign_time ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合同签订日期','field'=>'c.sign_time'))?></span>
                    </li>
                    <li id="c.contract_term">
                        <span class="party-name"><i class="red">*</i>合同合作期限</span>
                        <span class="party-con"><?php echo OfflineSignContract::getContractTerm($contract_model->contract_term) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合同合作期限(按月数)','field'=>'c.contract_term'))?></span>
                    </li>
                    <li id="c.begin_time">
                        <span class="party-name"><i class="red">*</i>合作期限起始日期</span>
                        <span class="party-con"><?php echo date('Y-m-d',$contract_model->begin_time) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合作期限起始日期','field'=>'c.begin_time'))?></span>
                    </li>
                    <li id="c.end_time">
                        <span class="party-name"><i class="red">*</i>合作期限结束日期</span>
                        <span class="party-con"><?php echo date('Y-m-d',$contract_model->end_time) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合作期限结束日期','field'=>'c.end_time'))?></span>
                    </li>
                    <li id="c.contract_linkman">
                        <span class="party-name">合同跟进人</span>
                        <span class="party-con"><?php  echo $contract_model->contract_linkman?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'合同跟进人','field'=>'c.contract_linkman'))?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 合同信息 end-->

        <div class="audit-tableTitle">附件信息</div>
        <div class="audit-bargain clearfix">
            <ul>
                <li id="ex.upload_contract">
                    <p class="bargain-cho">联盟商户合同
                        <span class="party-cho fr" style="margin-right: -56px;"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'联盟商户合同','field'=>'ex.upload_contract'))?></span>
                    </p>
                    <p class="bargain-pdf">
                        <?php echo OfflineSignFile::getOldName($extendModel->upload_contract) ?>
                        <a  onclick="return _showContract(this)" href="<?php echo OfflineSignFile::getfileUrl($extendModel->upload_contract) ?>">查看</a>
                    </p>
                </li>
                <?php $storeNum = count($storeData); if($storeNum > 1 && !empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                    <?php for($i = 0;$i < $num;$i++):?>
                <li id="ex.upload_contract_img<?php echo $upload_img_arr[$i]?>">
                    <p class="bargain-cho">盖网通铺设场所及优惠-附件 <?php echo $i+1;?>
                    </p>
                    <span class="party-cho fr" style="margin-right: -56px;"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'盖网通铺设场所及优惠约定-附件 '.($i+1),'field'=>'ex.upload_contract_img'.$upload_img_arr[$i]))?></span>
                    <p class="bargain-pdf">
                        <?php echo OfflineSignFile::getOldName($upload_img_arr[$i])?>
                        <a  onclick="return _showBigPic(this)" href="<?php echo OfflineSignFile::getfileUrl($upload_img_arr[$i])?>">查看</a>
                    </p>
                </li>
                <?php endfor;?>
                <?php endif;?>
            </ul>
        </div>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th>未通过审核原因
                    <span class="red">选择不通过审核时必填：</span>
                </th>
            </tr>
            <tr>
                <td>
                    <textarea name="content" id="content" class="textareatxt" disabled></textarea>
                    <input type="hidden" name="contentHidden" value="" id="contentHidden">
                </td>
            </tr>

            </tbody>
        </table>

        <div class="audit-btn">
            <input type="hidden" name="status" id="status" value=""/>
            <input type="hidden" name="errorField" id="errorField" value=""/>

            <input type="button" value="通过审核" id="btnSignSubmit"
                   class="btnSignSubmit"/>&nbsp;&nbsp;
            <input type="button" value="不通过审核" id="btnSignBack"
                   class="btnSignBack"/>
        </div>

        <div class="grid-view" id="article-grid"></div>
    </form>
</div>



