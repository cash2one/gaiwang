<?php
$this->breadcrumbs = array(
    Yii::t('offlineSignStore', '电子化签约审核列表') => array('offlineSignStoreExtend/admin'),
    Yii::t('offlineSignStore', '查看详情'),
);
?>

<div class="main">
    <div class="c10"></div>
    <div class="audit-type clearfix">
            <div><span>新增类型</span><?php  echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type);?></div>
            <div><span>企业名称</span><?php echo $enterprise_model->name ?></div>
    </div>
    <div class="c10"></div>
    <div class="audit-tableTitle">归属方信息</div>
    <div class="audit-party clearfix">
        <ul>
            <li>
                <span class="party-name"><i class="red">*</i>加盟商开发方</span>
                <span class="party-con"><?php echo OfflineSignStoreExtend::getFranchiseeDeveloper($extendModel->franchisee_developer) ?></span>
            </li>
            <li>
                <span class="party-name"><i class="red">*</i>机器归属方</span>
                <span class="party-con"><?php echo OfflineSignStoreExtend::getMachineBelongTo($extendModel->machine_belong_to) ?></span>
            </li>
        </ul>
    </div>
    <!-- 归属方信息 end!-->
    <div class="c10"></div>

    <div class="audit-tableTitle">企业信息</div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span class="party-name"><i class="red">*</i>企业名称</span>
                    <span class="party-con"><?php echo $enterprise_model->name ?></span>
                </li>
                <li>
                    <span class="party-name">是否连锁</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getIsChain($enterprise_model->is_chain) ?></span>
                </li>
                <?php if($enterprise_model->is_chain):?>
                    <li>
                        <span class="party-name">企业连锁形态</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getChainType($enterprise_model->chain_type)?></span>
                    </li>
                    <li>
                        <span class="party-name">连锁数量</span>
                        <span class="party-con"><?php echo $enterprise_model->chain_number ?></span>
                    </li>
                <?php endif;?>
                <li>
                    <span class="party-name"><i class="red">*</i>企业联系人姓名</span>
                    <span class="party-con"><?php echo $enterprise_model->linkman_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业联系人职位</span>
                    <span class="party-con"><?php echo $enterprise_model->linkman_position ?></span>
                </li>
                <li>
                    <span class="party-name">企业联系人微信</span>
                    <span class="party-con"><?php echo $enterprise_model->linkman_webchat ?></span>
                </li>
                <li>
                    <span class="party-name">企业联系人QQ</span>
                    <span class="party-con"><?php echo $enterprise_model->linkman_qq ?></span>
                </li>
                <li>
                    <span class="party-name">推广地区</span>
                            <span class="party-con">
                            <?php $ids = $contract_model['p_province_id'] . "," . $contract_model['p_city_id'] .','. $contract_model['p_district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业类型</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterprise_model->enterprise_type) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册名称</span>
                    <span class="party-con"><?php echo $contract_model->b_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                    <span class="party-con"><?php echo $enterprise_model->enterprise_license_number ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册地区</span>
                            <span class="party-con">
                            <?php $ids = $contract_model['province_id'] . "," . $contract_model['city_id'] .','. $contract_model['district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册地址</span>
                    <span class="party-con"><?php echo $contract_model->address ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>成立时间</span>
                    <span class="party-con"><?php echo $enterprise_model->registration_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业期限开始日期</span>
                    <span class="party-con"><?php echo $enterprise_model->license_begin_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业期限结束日期</span>
                    <span class="party-con"><?php echo ($enterprise_model->license_end_time == 0)? '长期': $enterprise_model->license_end_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>法人代表</span>
                    <span class="party-con"><?php echo $enterprise_model->legal_man ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>法人身份证号</span>
                    <span class="party-con"><?php echo $enterprise_model->legal_man_identity ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>税务登记证号</span>
                    <span class="party-con"><?php echo $enterprise_model->tax_id ?></span>
                </li>
            </ul>
        </div>
        <div class="right">
            <div class="party-prcList clearfix">
                <ul>
                    <li>
                        <p class="prcList-name"><br /><span>*</span>营业执照电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->license_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><br /><span>*</span>税务登记证电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->tax_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><br /><span>*</span>法人身份证电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->identity_image);?>" /></p>
                        <p class="prcList-cho">
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
                <li>
                    <span class="party-name"><i class="red">*</i>企业GW编号</span>
                    <span class="party-con"><?php echo $data['gai_number'] ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业GW号生成日期</span>
                    <span class="party-con"><?php echo $data['register_time'] ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业GW号开通人</span>
                    <span class="party-con"><?php echo $contract_model->enterprise_proposer ?></span>
                </li>
                <li>
                    <span class="party-name">企业GW号开通手机</span>
                    <span class="party-con"><?php echo $contract_model->mobile ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>结算账户类型</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getAccountPayType($enterprise_model->account_pay_type)?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>账户名称</span>
                    <span class="party-con"><?php echo $contract_model->account_name ?></span>
                </li>

                <li>
                    <span class="party-name"><i class="red">*</i>开户银行名称</span>
                    <span class="party-con"><?php echo $contract_model->bank_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>银行账号</span>
                    <span class="party-con"><?php echo $contract_model->account ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>收款人身份证号</span>
                    <span class="party-con"><?php echo $enterprise_model->payee_identity_number?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>开户行区域</span>
                            <span class="party-con">
                            <?php $ids = $enterprise_model['bank_district_id']; ?>
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
                    <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC):?>
                        <li>
                            <p class="prcList-name"><span>*</span>开户许可证（或对公账户证明）电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_permit_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                    <?php endif;?>
                    <?php if($enterprise_model->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                        <li>
                            <p class="prcList-name"><span>*</span>银行卡复印件（只限对私账）电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->bank_account_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                        <?php if(!empty($enterprise_model->entrust_receiv_image)):?>
                        <li>
                            <p class="prcList-name"><span>*</span>委托收款授权书电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->entrust_receiv_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                            <?php endif;?>
                        <li>
                            <p class="prcList-name"><span>*</span>收款人身份证电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->payee_identity_image);?>" /></p>
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
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商名称</span>
                        <span class="party-con"><?php echo $model->franchisee_name ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商编号</span>
                        <span class="party-con"><?php echo $data['code'][$key];?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商生成日期</span>
                        <span class="party-con"><?php echo $data['create_timeF'][$key]; ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商区域</span>
                            <span class="party-con">
<?php $ids = $model['install_province_id'] . "," . $model['install_city_id'] .','. $model['install_district_id']; ?>
<?php $ids = Region::getNameArray($ids); ?>
<?php $ids = implode('               ',$ids) ;?>
<?php echo Region::getAreaNameById($model->install_area_id).' '.$ids; ?>
                            </span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商详细地址</span>
                        <span class="party-con"><?php echo $model->install_street;?></span>
                    </li>
                    <li id="s.machine_administrator">
                        <span class="party-name">盖网通管理人姓名</span>
                        <span class="party-con"><?php echo $model->machine_administrator?></span>
                    </li>

                    <li id="s.machine_administrator_mobile">
                        <span class="party-name">盖网通管理人移动电话</span>
                        <span class="party-con"><?php echo $model->machine_administrator_mobile?></span>
                    </li>

                    <li id="s.machine_number">
                        <span class="party-name">盖网通数量</span>
                        <span class="party-con"><?php echo $model->machine_number?></span>
                    </li>

                    <li id="s.machine_size">
                        <span class="party-name">尺寸</span>
                        <span class="party-con"><?php echo OfflineSignStore::getMachineSize($model->machine_size)?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>所在商圈</span>
                        <span class="party-con"><?php echo $model->store_location;?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>商家联系人</span>
                        <span class="party-con"><?php echo $model->store_linkman?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>商家联系人职位</span>
                        <span class="party-con"><?php echo $model->store_linkman_position?></span>
                    </li>
                    <li>
                        <span class="party-name">商家联系人微信</span>
                        <span class="party-con"><?php echo $model->store_linkman_webchat?></span>
                    </li>
                    <li>
                        <span class="party-name">商家联系人QQ</span>
                        <span class="party-con"><?php echo $model->store_linkman_qq?></span>
                    </li>
                    <li>
                        <span class="party-name">商家联系人邮箱</span>
                        <span class="party-con"><?php echo $model->store_linkman_email?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>店面固定电话</span>
                        <span class="party-con"><?php echo $model->store_phone?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>店面移动电话</span>
                        <span class="party-con"><?php echo $model->store_mobile?></span>
                    </li>
                    <?php $aa = array()?>
                    <?php OfflineSignStore::getParentCategory($model->franchisee_category_id,$aa);?>
                    <?php if(count($aa) == 1):?>
                        <li>
                            <span class="party-name"><i class="red">*</i>经营类别（级别一）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[0])?></span>
                        </li>
                        <li>
                            <span class="party-name">经营类别（级别二）</span>
                            <span class="party-con"></span>
                        </li>
                    <?php elseif((count($aa) == 2)):?>
                        <li>
                            <span class="party-name"><i class="red">*</i>经营类别（级别一）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[1])?></span>
                        </li>
                        <li>
                            <span class="party-name">经营类别（级别二）</span>
                            <span class="party-con"><?php echo FranchiseeCategory::getFanchiseeCategoryName($aa[0])?></span>
                        </li>
                    <?php endif;?>
                    <li>
                        <span class="party-name"><i class="red">*</i>营业开始时间</span>
                        <span class="party-con"><?php echo $model->open_begin_time ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>营业结束时间</span>
                        <span class="party-con"><?php echo $model->open_end_time ?></span>

                    </li>
                    <li>
                        <span class="party-name">是否存在会员制</span>
                        <span class="party-con"><?php  echo OfflineSignStore::getExistsMembership($model->exists_membership) ?></span>
                    </li>
                    <?php if($model->exists_membership):?>
                        <li>
                            <span class="party-name">会员折扣方式</span>
                            <span class="party-con"><?php  echo OfflineSignStore::getDiscountType($model->member_discount_type) ?></span>
                        </li>
                        <li>
                            <span class="party-name">会员折扣(%)</span>
                            <span class="party-con"><?php  echo $model->store_disconunt ?></span>
                        </li>
                    <?php endif ;?>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <li id="s.store_banner_image">
                            <p class="prcList-name"><span>*</span>带招牌的店铺门面照片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->store_banner_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                        <li id="s.store_inner_image">
                            <p class="prcList-name"><br /><span>*</span>店铺内部图片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->store_inner_image);?>" /></p>
                            <p class="prcList-cho">
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
                    <li>
                        <span class="party-name"><i class="red">*</i>折扣差(%)</span>
                        <span class="party-con"><?php echo $model->discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>盖网公司结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->gai_discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>盖网会员结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->member_discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name" style="width: 180px;">盖网会员结算折扣备注</span>
                        <span class="party-con"  style="width: 240px;"><?php echo $model->clearing_remark ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 折扣与管理费缴纳信息 end-->

        <div class="audit-tableTitle">机器信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li>
                        <span class="party-name"><i class="red">*</i>装机编码</span>
                        <span class="party-con"><?php echo  $data['machine_code'][$key]; ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>装机编码生成日</span>
                        <span class="party-con"><?php  echo  $data['create_timeM'][$key]; ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>激活码</span>
                        <span class="party-con"><?php  echo $data['activation_code'][$key]; ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>铺设类型</span>
                        <span class="party-con"><?php echo  OfflineSignStore::getInstallType($model->machine_install_type) ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>样式</span>
                        <span class="party-con"><?php echo OfflineSignStore::getInstallStyle($model->machine_install_style) ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 机器信息 end-->
        <div class="audit-tableTitle">盖网通推荐者绑定信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li id="s.enterprise_member_name_agent">
                        <span class="party-name">企业会员名称</span>
                        <span class="party-con"><?php echo $model->enterprise_member_name_agent ?></span>
                    </li>

                    <li id="s.franchisee_name">
                        <span class="party-name">加盟商名</span>
                        <span class="party-con"><?php  echo $model->franchisee_name ?></span>
                    </li>

                    <li id="s.franchisee_operate_name">
                        <span class="party-name">联盟商户运维方名称</span>
                        <span class="party-con"><?php echo $model->franchisee_operate_name ?></span>
                    </li>

                    <li id="s.franchisee_operate_id">
                        <span class="party-name">运维方GW号</span>
                        <span class="party-con"><?php echo $model->franchisee_operate_gai_number ?></span>
                    </li>

                    <li id="s.enterprise_member_name_agent">
                        <span class="party-name">企业会员名称(代理商)</span>
                        <span class="party-con"><?php echo $model->enterprise_member_name_agent ?></span>
                    </li>

                    <li id="s.recommender_member_id_agent">
                        <span class="party-name">推荐者GW号（代理商）</span>
                        <span class="party-con"><?php echo $model->recommender_agent_gai_number ?></span>
                    </li>

                    <li id="s.recommender_mobile">
                        <span class="party-name">推荐者手机号码(代理)</span>
                        <span class="party-con"><?php echo $model->recommender_mobile ?></span>
                    </li>

                    <li id="s.recommender_linkman">
                        <span class="party-name">联系人（代理商）</span>
                        <span class="party-con"><?php echo $model->recommender_linkman ?></span>
                    </li>

                    <li id="s.recommender_mobile_member">
                        <span class="party-name">推荐者手机号码（会员）</span>
                        <span class="party-con"><?php echo $model->recommender_mobile_member ?></span>
                    </li>

                    <li id="s.recommender_member_id_member">
                        <span class="party-name">推荐者GW号（会员）</span>
                        <span class="party-con"><?php echo $model->recommender_member_gai_number ?></span>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="party-prcList clearfix">
                    <ul>
                        <li id="s.recommender_apply_image">
                            <p class="prcList-name"><span>*</span>盖机推荐者绑定申请照片</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->recommender_apply_image);?>" /></p>
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
    <div class="audit-tableTitle">商户管理费缴纳标准</div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
            <li>
                <span class="party-name"><strong>商户管理费缴纳标准</strong></span>
                <span class="party-con">......................................</span>
            </li>
            <li style="height: 80px;">
                <span class="party-name"><i class="red">*</i>收费方式</span>
                <span class="party-con"><?php echo OfflineSignContract::getOperationType($contract_model->operation_type)  ?></span>
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
                        <p><input size="62" value="以后每年均须在与本合同签订日相同日期一次性等额支付年度技术服务费" disabled/></p>
                        <p>3小时高峰广告时间段</p>
                        <p class="clearfix">
                            <span class="red"> <?php echo $contract_model->ad_begin_time_hour?></span>时<span class="red"> <?php echo $contract_model->ad_begin_time_minute?> </span>分
                            至
                            <span class="red"> <?php echo $contract_model->ad_end_time_hour?></span>时<span class="red"> <?php echo $contract_model->ad_end_time_minute?> </span>分
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
    <div class="audit-tableTitle">合同信息</div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span class="party-name">合同编号</span>
                    <span class="party-con"><?php  echo $contract_model->number ?></span>
                </li>
                <li>
                    <span class="party-name">甲方</span>
                    <span class="party-con"><?php  echo $contract_model->a_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>乙方</span>
                    <span class="party-con"><?php  echo $contract_model->b_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>签约类型</span>
                    <span class="party-con"><?php  echo OfflineSignStoreExtend::getSignType($contract_model->sign_type) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>合同签订日期</span>
                    <span class="party-con"><?php echo $contract_model->sign_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>合同合作期限</span>
                    <span class="party-con"><?php echo OfflineSignContract::getContractTerm($contract_model->contract_term) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>合作期限起始日期</span>
                    <span class="party-con"><?php echo date('Y-m-d',$contract_model->begin_time) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>合作期限结束日期</span>
                    <span class="party-con"><?php echo date('Y-m-d',$contract_model->end_time) ?></span>
                </li>
                <li>
                    <span class="party-name">合同跟进人</span>
                    <span class="party-con"><?php  echo $contract_model->contract_linkman?></span>
                </li>
            </ul>
        </div>
    </div>
    <!--audit-party 合同信息 end-->

    <div class="audit-tableTitle">附件信息</div>
    <div class="audit-bargain clearfix">
        <ul>
            <li>
                <p class="bargain-cho">联盟商户合同
                </p>
                <p class="bargain-pdf">
                    <?php echo OfflineSignFile::getOldName($extendModel->upload_contract) ?>
                    <a  onclick="return _showContract(this)" href="<?php echo OfflineSignFile::getfileUrl($extendModel->upload_contract) ?>">查看</a>
                </p>
            </li>
            <?php $storeNum = count($storeData); if($storeNum > 1 && !empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                <?php for($i=0;$i <$num;$i++):?>
                    <li>
                        <p class="bargain-cho">盖网通铺设场所及优惠约定-附件 <?php echo $i+1;?>
                        </p>
                        <p class="bargain-pdf">
                            <?php echo OfflineSignFile::getOldName($upload_img_arr[$i]) ?>
                            <a  onclick="return _showBigPic(this)" href="<?php echo OfflineSignFile::getfileUrl($upload_img_arr[$i]) ?>">查看</a>
                        </p>
                    </li>
                <?php endfor;?>
            <?php endif;?>
        </ul>
    </div>

    <div class="audit-tableTitle">审核历史记录</div>
        <div class="sellerWebSignProgress">

    <?php
    $this->widget('GridView',array(
        'dataProvider' => $auditLogging_model->seachAuditSchedule($id,'2001'),
        'itemsCssClass' => 'tab-reg4',
        'template' => '{items}{pager}',
        'columns' => array(
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'create_time',
                'value' => 'date("Y-m-d H:i:s",$data->create_time)',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'audit_role',
                'value' => 'OfflineSignAuditLogging::getRoleValue($data->audit_role)',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => '审核人员',
                'value' => '$data->auditor',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'status',
                'value' => 'OfflineSignAuditLogging::getStatus($data->status)',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange','width' => '50%'),
                'name' => '未通过原因',
                'value' => '$data->remark',
            ),
        )
    ));
    ?>
      </div>