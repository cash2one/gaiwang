<style>
    .errorMessage{ display:block; margin-top: 40px; margin-left:-100px;}
</style>
    <div class="audit-tableTitle <?php if(!empty($storeInfoModel->error_field)) echo 'red';?>">店铺信息--<?php echo $num+1;?><a href="<?php echo $this->createAbsoluteUrl("/offlineSignStoreExtend/saveOldFranchisee",array('role'=>$role,'id'=>$storeInfoModel->id,'num'=>$num+1))?>" class="upda" id="<?php echo $storeInfoModel->id;?>">编辑</a><a class="check">展开</a></div>
<div class="sign-list"  style="display: none">
<div class="audit-party clearfix">
    <div class="left">
        <ul>
            <li id="s.franchisee_name">
                <span class="party-name">加盟商名称</span>
                <span class="party-con"><?php echo $storeInfoModel->franchisee_name?></span>
            </li>

            <li id="s.install_area_id,s.install_province_id,s.install_city_id,s.install_district_id">
                <span class="party-name"><i class="red">*</i>加盟商区域</span>
                <?php $ids = $storeInfoModel->install_province_id . "," . $storeInfoModel->install_city_id . ",". $storeInfoModel->install_district_id;?>
                <?php $ids = Region::getNameArray($ids); ?>
                <?php $ids = implode('',$ids) ;?>
                <span class="party-con"><?php echo Region::getAreaNameById($storeInfoModel->install_area_id) .' '. $ids?></span>
            </li>

            <li id="s.install_street">
                <span class="party-name">加盟商详细地址</span>
                <span class="party-con"><?php echo $storeInfoModel->install_street?></span>
            </li>


            <li id="s.store_phone">
                <span class="party-name">店面固定电话</span>
                <span class="party-con"><?php echo $storeInfoModel->store_phone?></span>
            </li>


            <li id="s.store_location">
                <span class="party-name"><i class="red">*</i>所在商圈</span>
                <span class="party-con"><?php echo $storeInfoModel->store_location?></span>
            </li>

            <li id="s.store_linkman">
                <span class="party-name"><i class="red">*</i>商家联系人</span>
                <span class="party-con"><?php echo $storeInfoModel->store_linkman?></span>
            </li>

            <li id="s.store_linkman_position">
                <span class="party-name">商家联系人职位</span>
                <span class="party-con"><?php echo $storeInfoModel->store_linkman_position?></span>
            </li>
            <li id="s.store_linkman_webchat">
                <span class="party-name">商家联系人微信</span>
                <span class="party-con"><?php echo $storeInfoModel->store_linkman_webchat?></span>
            </li>
            <li id="s.store_linkman_qq">
                <span class="party-name">商家联系人QQ</span>
                <span class="party-con"><?php echo $storeInfoModel->store_linkman_qq?></span>
            </li>
            <li id="s.store_linkman_email">
                <span class="party-name">商家联系人邮箱</span>
                <span class="party-con"><?php echo $storeInfoModel->store_linkman_email?></span>
            </li>
            <?php
            $categoryInfos = array();
            OfflineSignStore::getParentCategory($storeInfoModel->franchisee_category_id,$categoryInfos);
            $categoryInfos = array_reverse($categoryInfos);
            ?>
            <li>
                <span class="party-name"><i class="red">*</i>经营类别（级别一）</span>
                <span class="party-con"><?php if(!empty($categoryInfos)) echo FranchiseeCategory::getFanchiseeCategoryName($categoryInfos[0])?></span>
            </li>
            <?php if(count($categoryInfos) > 1 ){ ?>
                <li>
                    <span class="party-name">经营类别（级别二）</span>
                    <span class="party-con"><?php if(!empty($categoryInfos)) echo FranchiseeCategory::getFanchiseeCategoryName($categoryInfos[1])?></span>
                </li>
            <?php } ?>

            <li id="s.open_begin_time">
                <span class="party-name"><i class="red">*</i>营业开始时间</span>
                <span class="party-con"><?php echo $storeInfoModel->open_begin_time ?></span>
            </li>

            <li id="s.open_end_time">
                <span class="party-name"><i class="red">*</i>营业结束时间</span>
                <span class="party-con"><?php echo $storeInfoModel->open_end_time ?></span>
            </li>

            <li id="s.exists_membership">
                <span class="party-name">商家有否存在会员制</span>
                <span class="party-con"><?php echo OfflineSignStore::getExistsMembership($storeInfoModel->exists_membership)?></span>
            </li>
            <?php if($storeInfoModel->exists_membership):?>
                <li id="s.member_discount_type">
                    <span class="party-name">会员折扣方式</span>
                    <span class="party-con"><?php echo OfflineSignStore::getDiscountType($storeInfoModel->member_discount_type)?></span>
                </li>

                <li id="s.store_disconunt">
                    <span class="party-name">会员折扣(%)</span>
                    <span class="party-con"><?php echo $storeInfoModel->store_disconunt?></span>
                </li>
            <?php endif;?>
        </div>
    <div class="right">
        <div class="party-prcList clearfix">
            <ul>
                <li id="s.store_banner_image">
                    <p class="prcList-name"><span style="width: 1px">*</span>带招牌的店铺门面照片</p>
                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($storeInfoModel->store_banner_image);?>" /></p>
                </li>
                <li id="s.store_inner_image">
                    <p class="prcList-name"><br /><span style="width: 1px">*</span>店铺内部图片</p>
                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($storeInfoModel->store_inner_image);?>" /></p>
                </li>
            </ul>
        </div>
        <div class="c10"></div>
        <div class="party-prcShow">
            <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?php echo OfflineSignFile::getfileUrl($storeInfoModel->store_banner_image);?>" /></span> </div>
        </div>
    </div>
    </div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span style="font: "微软雅黑", "宋体"">优惠约定</span>
                </li>
                <li id="s.discount">
                    <span class="party-name">折扣差（%）</span>
                    <span class="party-con"><?php echo $storeInfoModel->discount?></span>
                </li>

                <li id="s.gai_discount">
                    <span class="party-name">盖网公司结算折扣（%）</span>
                    <span class="party-con"><?php echo $storeInfoModel->gai_discount?></span>
                </li>

                <li id="s.member_discount">
                    <span class="party-name">盖网会员结算折扣（%）</span>
                    <span class="party-con"><?php echo $storeInfoModel->member_discount?></span>
                </li>

                <li id="s.clearing_remark">
                    <span class="party-name">盖网会员结算折扣备注</span>
                    <span class="party-con"><?php echo $storeInfoModel->clearing_remark?></span>
                </li>
            </ul>
        </div>
        <div class="right"></div>
    </div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span>机器信息</span>
                </li>
                <li id="s.machine_install_type">
                    <span class="party-name">铺设类型</span>
                    <span class="party-con"><?php echo OfflineSignStore::getInstallType($storeInfoModel->machine_install_type)?></span>
                </li>

                <li id="s.machine_install_style">
                    <span class="party-name">样式</span>
                    <span class="party-con"><?php echo OfflineSignStore::getInstallStyle($storeInfoModel->machine_install_style)?></span>
                </li>

            </ul>
        </div>
    </div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li id="s.enterprise_member_name_agent">
                    <span class="party-name">企业会员名称</span>
                    <span class="party-con"><?php echo $storeInfoModel->enterprise_member_name_agent ?></span>
                </li>

                <li id="s.franchisee_name">
                    <span class="party-name">加盟商名</span>
                    <span class="party-con"><?php echo $storeInfoModel->franchisee_name ?></span>
                </li>

                <li id="s.franchisee_operate_name">
                    <span class="party-name">联盟商户运维方名称</span>
                    <span class="party-con"><?php echo $storeInfoModel->franchisee_operate_name ?></span>
                </li>

                <li id="s.franchisee_operate_id">
                    <span class="party-name">运维方GW号</span>
                    <span class="party-con"><?php echo $storeInfoModel->franchisee_operate_gai_number ?></span>
                </li>

                <li id="s.enterprise_member_name_agent">
                    <span class="party-name">企业会员名称(代理商)</span>
                    <span class="party-con"><?php echo $storeInfoModel->enterprise_member_name_agent ?></span>
                </li>

                <li id="s.recommender_member_id_agent">
                    <span class="party-name">推荐者GW号（代理商）</span>
                    <span class="party-con"><?php echo $storeInfoModel->recommender_agent_gai_number ?></span>
                </li>

                <li id="s.recommender_mobile">
                    <span class="party-name">推荐者手机号码（代理商）</span>
                    <span class="party-con"><?php echo $storeInfoModel->recommender_mobile ?></span>
                </li>

                <li id="s.recommender_linkman">
                    <span class="party-name">联系人（代理商）</span>
                    <span class="party-con"><?php echo $storeInfoModel->recommender_linkman ?></span>
                </li>

                <li id="s.recommender_mobile_member">
                    <span class="party-name">推荐者手机号码（会员）</span>
                    <span class="party-con"><?php echo $storeInfoModel->recommender_mobile_member ?></span>
                </li>

                <li id="s.recommender_member_id_member">
                    <span class="party-name">推荐者GW号（会员）</span>
                    <span class="party-con"><?php echo $storeInfoModel->recommender_member_gai_number ?></span>
                </li>
            </ul>
        </div>
        <div class="right">
            <div class="party-prcList clearfix">
                <ul>
                    <li id="s.recommender_apply_image">
                        <p class="prcList-name"><span style="width: 1px">*</span>盖机推荐者绑定申请照片</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($storeInfoModel->recommender_apply_image);?>" /></p>
                    </li>
                </ul>
                <div class="c10"></div>
                <div class="party-prcShow">
                    <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?php echo OfflineSignFile::getfileUrl($storeInfoModel->recommender_apply_image);?>" /></span> </div>
                </div>
            </div>
        </div>
    </div>


</div>
    <!--audit-party 店铺信息 end-->
