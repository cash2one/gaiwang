<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="main">
    <div class="toolbarSign">
        <h3><span class="red"></span></h3>
    </div>
    <div class="c10"></div>
    <div class="audit-type clearfix">
        <div><span>新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($extendInfoModel->apply_type) ?></div>
        <div><span>企业名称</span><?php echo $enterpriseInfoModel->name ?></div>
    </div>
    <div class="audit-tableTitle">归属方信息</div>
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span class="party-name"><i class="red">*</i>加盟商开发方</span>
                    <span class="party-con"><?php echo OfflineSignStoreExtend::getFranchiseeDeveloper($extendInfoModel->franchisee_developer) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>机器归属方</span>
                    <span class="party-con">
                    <input class="input  ml" readonly="readonly" style="background:#eee;"
                     id="machine_belong_to" type="text" value="<?php echo OfflineSignStoreExtend::getMachineBelongTo($extendInfoModel->machine_belong_to) ?>">
                    <input type="hidden" name="OfflineSignStore[machine_belong_to]" id = 'OfflineSignStore_machine_belong_to' value="<?php echo $extendInfoModel->machine_belong_to ?>">
                     <!--只有 大区经理、销售总监、大区审核 这三个角色可以编辑机器归属方-->
                        <?php
                            if(OfflineSignStore::checkAccessModifyMachineBelong($role)){
                             echo CHtml::button('修改', array( 'class'=>'reg-sub','id' => 'set-machine_belong_to'));
                        }
                        ?>
                    </span>
                </li>
           </ul>
       </div>

    </div>
    <div class="audit-tableTitle <?php echo !empty($enterpriseInfoModel->error_field)?'red':''?>">企业信息<a class="upda" href="<?php echo $this->createAbsoluteUrl("/offlineSignStoreExtend/update",array('role'=>$role,'id'=>$extendInfoModel->id,'enterprise'=>'enterprise'))?>">编辑</a><a class="check">展开</a></div>
    <div class="sign-list" style="display: none">
    <div class="audit-party clearfix">
        <div class="left">
            <ul>
                <li>
                    <span class="party-name"><i class="red">*</i>企业名称</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->name ?></span>
                </li>
                <li>
                    <span class="party-name">是否连锁</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getIsChain($enterpriseInfoModel->is_chain) ?></span>
                </li>
                <?php if($enterpriseInfoModel->is_chain):?>
                    <li>
                        <span class="party-name">企业连锁形态</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getChainType($enterpriseInfoModel->chain_type)?></span>
                    </li>
                    <li>
                        <span class="party-name">连锁数量</span>
                        <span class="party-con"><?php echo $enterpriseInfoModel->chain_number ?></span>
                    </li>
                <?php endif;?>
                <li>
                    <span class="party-name"><i class="red">*</i>企业联系人姓名</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->linkman_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业联系人职位</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->linkman_position ?></span>
                </li>
                <li>
                    <span class="party-name">企业联系人微信</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->linkman_webchat ?></span>
                </li>
                <li>
                    <span class="party-name">企业联系人QQ</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->linkman_qq ?></span>
                </li>
                <li>
                    <span class="party-name">推广地区</span>
                            <span class="party-con">
                            <?php $ids = $contractInfoModel['p_province_id'] . "," . $contractInfoModel['p_city_id'] .','. $contractInfoModel['p_district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>企业类型</span>
                    <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterpriseInfoModel->enterprise_type) ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册名称</span>
                    <span class="party-con"><?php echo $contractInfoModel->b_name ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->enterprise_license_number ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册地区</span>
                            <span class="party-con">
                            <?php $ids = $contractInfoModel['province_id'] . "," . $contractInfoModel['city_id'] .','. $contractInfoModel['district_id']; ?>
                            <?php $ids = Region::getNameArray($ids); ?>
                            <?php $ids = implode('     ',$ids) ;?>
                            <?php echo $ids; ?>
                            </span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业执照注册地址</span>
                    <span class="party-con"><?php echo $contractInfoModel->address ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>成立时间</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->registration_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业期限开始日期</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->license_begin_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>营业期限结束日期</span>
                    <span class="party-con"><?php echo ($enterpriseInfoModel->license_end_time == 0)? '长期': $enterpriseInfoModel->license_end_time ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>法人代表</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->legal_man ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>法人身份证号</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->legal_man_identity ?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>税务登记证号</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->tax_id ?></span>
                </li>
            </ul>
        </div>
        <div class="right">
            <div class="party-prcList clearfix">
                <ul>
                    <li>
                        <p class="prcList-name"><br /><span style="width: 1px">*</span>营业执照电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->license_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><br /><span style="width: 1px">*</span>税务登记证电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->tax_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                    <li>
                        <p class="prcList-name"><br /><span style="width: 1px">*</span>法人身份证电子版</p>
                        <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->identity_image);?>" /></p>
                        <p class="prcList-cho">
                        </p>
                    </li>
                </ul>
            </div>
            <div class="c10"></div>
            <div class="party-prcShow">
                <div id="preview" class="spec-preview">
                            <span class="jqzoom">
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->license_image);?>" />
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
                    <span class="party-con"><?php echo OfflineSignEnterprise::getAccountPayType($enterpriseInfoModel->account_pay_type)?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>收款人身份证号</span>
                    <span class="party-con"><?php echo $enterpriseInfoModel->payee_identity_number?></span>
                </li>
                <li>
                    <span class="party-name"><i class="red">*</i>开户行区域</span>
                            <span class="party-con">
                            <?php $ids = $enterpriseInfoModel['bank_district_id']; ?>
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
                    <?php if($enterpriseInfoModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC):?>
                        <li>
                            <p class="prcList-name"><span style="width: 1px">*</span>开户许可证（或对公账户证明）电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_permit_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                    <?php endif;?>
                    <?php if($enterpriseInfoModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                        <li>
                            <p class="prcList-name"><span style="width: 1px">*</span>银行卡复印件（只限对私账）电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_account_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                        <li>
                            <p class="prcList-name"><span style="width: 1px">*</span>委托收款授权书电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->entrust_receiv_image);?>" /></p>
                            <p class="prcList-cho">
                            </p>
                        </li>
                        <li class="switch">
                            <p class="prcList-name"><span style="width: 1px">*</span>收款人身份证电子版</p>
                            <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->payee_identity_image);?>" /></p>
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
                            <?php if($enterpriseInfoModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC) :?>
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_permit_image);?>" />
                            <?php elseif($enterpriseInfoModel->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE):?>
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_account_image);?>" />
                            <?php endif;?>
                        </span>
                </div>
            </div>
        </div>
    </div>
        </div>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'offline-sign-info-update-form',
    'action' => '/?r=offline-sign-store-extend/update&role='.$role.'&id='.$extendInfoModel->id,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
));
?>
<?php foreach($storeInfoModel as $num=>$val):?>
    <?php
    //店铺信息
    $this->renderPartial('_update_sign_store_info_old',array(
        'storeInfoModel'=>$val,
        'demoImgs'=>$demoImgs,
        'form' =>$form,
        'uploadUrl' => $uploadUrl,
        'num'=>$num,
        'role' => $role,
        'extendInfoModel'=>$extendInfoModel,
    ));?>
<?php endforeach;?>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function(){
        <?php if(isset($extendInfoModel) && $extendInfoModel->error_field):?>
        <?php $modelError = json_decode($extendInfoModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        var str = '<?php echo $value?>';
        str = str.replace('ex.','');
        str = '#' + str;
        $(str).addClass('red');
        $(str).parent().prev().addClass('red');
        <?php endforeach;?>
        <?php endif;?>

        $('#OfflineSignEnterprise_payee_identity_number').on('change',function(){
            var manId = $('#OfflineSignEnterprise_legal_man_identity');
            if($(this).val() == manId.val()){
                $('.switch').hide();
            }else{
                $('.switch').show();
            }
        });

        $('#OfflineSignEnterprise_payee_identity_number').change();
    });
</script>



