<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<div class="main">
    <div class="toolbarSign">
        <h3>温馨提示：<span class="red">若选择未通过审核，请勾选并填写未通过原因，再点击提交！</span></h3>
    </div>
    <div class="c10"></div>
    <form id="auditing_form"  method="post">
        <div class="audit-type clearfix">
            <div><span>新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type) ?></div>
            <div><span>企业名称</span><?php echo OfflineSignStoreExtend::getEnterpriseNameByApplyType($extendModel->apply_type,$extendModel->old_member_franchisee_id)?></div>
        </div>

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
        <div class="audit-tableTitle">附件信息</div>
        <div class="audit-bargain clearfix">
            <ul>
                <?php if(!empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
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
        <!--audit-party 附件信息 end-->

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




