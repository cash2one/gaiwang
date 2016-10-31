<?php
$this->breadcrumbs = array(
    Yii::t('offlineSignStore', '电子化签约审核列表') => array('offlineSignStoreExtend/admin'),
    Yii::t('offlineSignStore', '查看详情'),
);
?>
<div class="t-sub">
    <a class="regm-sub" href="javascript:history.back()">返回列表</a>                                            </div>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>


<div class="main">
    <div class="c10"></div>
    <div class="audit-type clearfix">
        <div><span>新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type);?></div>
        <div><span>企业名称</span><?php echo $enterprise_model->name;?></div>
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
    <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE):?>
        <div class="audit-tableTitle">企业信息</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li>
                        <span class="party-name"><i class="red">*</i>企业名称</span>
                        <span class="party-con"><?php echo $enterprise_model->name ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>企业类型</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterprise_model->enterprise_type) ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>营业执照注册名称</span>
                        <span class="party-con"><?php if($contract_model) echo $contract_model->b_name ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                        <span class="party-con"><?php echo $enterprise_model->enterprise_license_number ?></span>
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
                        <span class="party-name"><i class="red">*</i>结算账户类型</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getAccountPayType($enterprise_model->account_pay_type)?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>账户名称</span>
                        <span class="party-con"><?php if($contract_model) echo $contract_model->account_name ?></span>
                    </li>

                    <li>
                        <span class="party-name"><i class="red">*</i>开户银行名称</span>
                        <span class="party-con"><?php if($contract_model) echo $contract_model->bank_name ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>银行账号</span>
                        <span class="party-con"><?php if($contract_model) echo $contract_model->account ?></span>
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
                            <li>
                                <p class="prcList-name"><span>*</span>委托收款授权书电子版</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->entrust_receiv_image);?>" /></p>
                                <p class="prcList-cho">
                                </p>
                            </li>
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
    <?php endif;?>
    <div class="audit-tableTitle">盖网通店铺、铺设概况</div>
    <?php foreach($storeData as $key=>$model):?>
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
                </ul>
            </div>
            <div class="right">
                <div class="c10"></div>
            </div>
        </div>
        <!--audit-party 店铺信息 end-->
        <div class="audit-tableTitle">优惠约定</div>
        <div class="audit-party clearfix">
            <div class="left">
                <ul>
                    <li>
                        <span class="party-name"><i class="red">*</i>盖网会员结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->member_discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>折扣差(%)</span>
                        <span class="party-con"><?php echo $model->discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>盖网公司结算折扣（%）</span>
                        <span class="party-con"><?php echo $model->gai_discount  ?></span>
                    </li>
                    <li>
                        <span class="party-name" style="width: 180px;">盖网会员结算折扣备注</span>
                        <span class="party-con"  style="width: 240px;"><?php echo $model->clearing_remark ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--audit-party 折扣与管理费缴纳信息 end-->

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
    <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE):?>
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
    <?php endif;?>
    <div class="audit-tableTitle">附件信息</div>
    <div class="audit-bargain clearfix">
        <ul>
            <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE):?>
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
            <?php endif;?>
            <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE):?>
                <?php if(!empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
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







<script>
    //图片放大镜效果
    $(function(){
        $(".jqzoom").jqueryzoom({xzoom:380,yzoom:410});
        $(".party-prcList ul li img").click(function(){
            var url=$(this).attr("src");
            $(this).parent().parent().parent().parent().parent().find("#preview img").attr("src",url);
        })
    });
</script>