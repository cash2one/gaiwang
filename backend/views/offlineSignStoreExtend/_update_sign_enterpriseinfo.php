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
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'offline-sign-store-extend-form',
    'enableClientValidation' => true,
    'action' => '/?r=offline-sign-store-extend/update&role='.$role.'&id='.$extendInfoModel->id,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
));
?>
<div class="audit-tableTitle">企业信息</div>
        <div class="sign-list">
            <ul>
                <li id="e.name">
                    <span class="party-name"><i class="red">*</i>企业名称</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'name',array('class'=>'input ml','placeholder'=>'请填写公司完整名称'))?>
                        <?php echo $form->error($enterpriseInfoModel,'name'); ?>
                    </span>
                </li>
                <li id="e.is_chain">
                    <span id="isChains">是否连锁</span>
                    <?php echo $form->dropDownList($enterpriseInfoModel,'is_chain',OfflineSignEnterprise::getIsChain(),array('prompt' => '请选择','class'=>'sign-select fl'))?>
                    <span class="liansuo" style="width:100px;">企业连锁形态</span>
                    <?php echo $form->dropDownList($enterpriseInfoModel,'chain_type',OfflineSignEnterprise::getChainType(),array('class'=>'sign-select fl liansuo'))?>
                    <span  class="liansuo" style="width:100px;">连锁数量</span>
                    <?php echo $form->textField($enterpriseInfoModel,'chain_number',array('class'=>'input sl liansuo'))?>
                    <?php echo $form->error($enterpriseInfoModel,'chain_number')?>
                </li>
                <li id="e.linkman_name">
                    <span class="party-name"><i class="red">*</i>企业联系人姓名</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'linkman_name',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'linkman_name'); ?>
                    </span>
                </li>
                <li id="e.linkman_position">
                    <span class="party-name"><i class="red">*</i>企业联系人职位</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'linkman_position',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'linkman_position'); ?>
                    </span>
                </li><li>
                    <span id="e.linkman_webchat">企业联系人微信</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'linkman_webchat',array('class'=>'input ml'))?>
                    </span>
                </li>
                <li id="e.linkman_qq">
                    <span class="party-name">企业联系人QQ</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'linkman_qq',array('class'=>'input ml'))?>
                    </span>
                </li>
                <li id="e.enterprise_type">
                    <span class="party-name"><i class="red">*</i>企业类型</span>
                    <span class="party-con">
                        <?php echo $form->dropDownList($enterpriseInfoModel,'enterprise_type',OfflineSignEnterprise::getEnterType(),array('class'=>'sign-select fl'))?>
                        <?php echo $form->error($enterpriseInfoModel,'enterprise_type'); ?>
                    </span>
                </li>
                <li id="e.enterprise_license_number">
                    <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'enterprise_license_number',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'enterprise_license_number'); ?>
                    </span>
                </li>
                <li id="e.registration_time">
                    <span class="party-name"><i class="red">*</i>成立时间</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'registration_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
                        <?php echo $form->error($enterpriseInfoModel,'registration_time'); ?>
                    </span>
                </li>
                <li id="e.license_begin_time">
                    <span class="party-name"><i class="red">*</i>营业期限开始日期</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'license_begin_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
                        <?php echo $form->error($enterpriseInfoModel,'license_begin_time'); ?>
                    </span>
                </li>
                <li id="e.license_end_time">
                    <span class="party-name"><i class="red">*</i>营业期限结束日期</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'license_end_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
                        </span>
                        <span>
                        <?php echo $form->checkBox($enterpriseInfoModel,'license_is_long_time')?>长期
                        <?php echo $form->error($enterpriseInfoModel,'license_end_time'); ?>
                    </span>
                </li>
                <li id="e.legal_man">
                    <span class="party-name"><i class="red">*</i>法人代表</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'legal_man',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'legal_man'); ?>
                    </span>
                </li>
                <li id="e.legal_man_identity">
                    <span class="party-name"><i class="red">*</i>法人身份证号</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'legal_man_identity',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'legal_man_identity'); ?>
                    </span>
                </li>
                <li id="e.tax_id">
                    <span class="party-name"><i class="red">*</i>税务登记证</span>
                    <span class="party-con">
                        <?php echo $form->textField($enterpriseInfoModel,'tax_id',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'tax_id'); ?>
                    </span>
                </li>

                <?php if(1):?>
                <li class="clearfix"  id="e.license_image">
                    <span><i class="red">*</i>营业执照电子版</span>
                    <div class="sign-upload">
                        <p>
                            <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                                   onclick="uploadPicture(this,
                                       '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1121))?>',
                                       'OfflineSignEnterprise_license_image',<?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                            <?php echo $form->hiddenField($enterpriseInfoModel,'license_image');?>
                            <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->license_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->license_image)?></span>
                            <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->license_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->license_image) ?>">预览</a>
                        </p>
                        <p>请确保图片清晰，并加盖公章</p>
                        <?php echo $form->error($enterpriseInfoModel,'license_image'); ?>
                    </div>
                    <span><i class="red">*</i>税务登记证电子版</span>
                    <div class="sign-upload">
                        <p>
                            <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl" onclick="
                                uploadPicture(
                                this,
                                '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1122))?>',
                                'OfflineSignEnterprise_tax_image',
                            <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                            <?php echo $form->hiddenField($enterpriseInfoModel,'tax_image')?>
                            <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->tax_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->tax_image)?></span>
                            <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->tax_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->tax_image) ?>">预览</a>
                        </p>
                        <p>请确保图片清晰，并加盖公章</p>
                        <?php echo $form->error($enterpriseInfoModel,'tax_image'); ?>
                    </div>
                </li>
                <li>
                       <span><i class="red">*</i>法人身份证电子版</span>
                    <div class="sign-upload">
                        <p>
                            <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl" onclick="
                                uploadPicture(
                                this,
                                '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1122))?>',
                                'OfflineSignEnterprise_identity_image',
                            <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                            <?php echo $form->hiddenField($enterpriseInfoModel,'identity_image')?>
                            <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->identity_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->identity_image)?></span>
                            <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->identity_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->identity_image) ?>">预览</a>
                        </p>
                        <p>请确保图片清晰，并加盖公章</p>
                        <?php echo $form->error($enterpriseInfoModel,'identity_image'); ?>
                    </div>
                </li>
                <?php endif;?>
            </ul>
        </div>
<!--audit-party 企业信息 end-->

<div class="audit-tableTitle">会员与帐号信息</div>
<div class="sign-list">
    <ul>
        <li>
            <span class="party-name"><i class="red">*</i>结算账户类型</span>

            <?php echo $form->dropDownList($enterpriseInfoModel,'account_pay_type',OfflineSignEnterprise::getAccountPayType(),array('class'=>'sign-select'))?>
            <?php echo $form->error($enterpriseInfoModel,'account_pay_type'); ?>
        </li>
        <li class="accountPrivate">
            <span class="party-name"><i class="red">*</i>收款人身份证号</span>
                    <span class="party-con">
                        <?php echo $form->telField($enterpriseInfoModel,'payee_identity_number',array('class'=>'input ml'))?>
                        <?php echo $form->error($enterpriseInfoModel,'payee_identity_number'); ?>
                    </span>
        </li>
        <li>
            <span class="party-name"><i class="red">*</i>开户行区域</span>

            <?php
            echo $form->dropDownList($enterpriseInfoModel, 'bank_province_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'class' => 'sign-select',
                'prompt' => Yii::t('Public','选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                                    $("#OfflineSignEnterprise_bank_city_id").html(data.dropDownCities);
                                    $("#OfflineSignEnterprise_bank_district_id").html(data.dropDownCounties);
                                }',
                )));
            ?>
            <?php echo $form->error($enterpriseInfoModel,'bank_province_id'); ?>
            <?php
            echo $form->dropDownList($enterpriseInfoModel, 'bank_city_id', Region::getRegionByParentId($enterpriseInfoModel->bank_province_id), array(
                'prompt' => Yii::t('machine', '选择城市'),
                'class' => 'sign-select ml10',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('region/updateArea'),
                    'update' => '#OfflineSignEnterprise_bank_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($enterpriseInfoModel,'bank_city_id'); ?>
            <?php
            echo $form->dropDownList($enterpriseInfoModel, 'bank_district_id', Region::getRegionByParentId($enterpriseInfoModel->bank_city_id), array(
                'class' => 'sign-select ml10',
                'prompt' => Yii::t('Public','选择区/县'),
            ));
            ?>
            <?php echo $form->error($enterpriseInfoModel,'bank_district_id'); ?>

        </li>
        <li class="accountPublic">
            <span><i class="red">*</i>开户许可证（或对公账户证明）电子版</span>
            <div class="sign-upload">
                <p>
                    <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                           onclick="uploadPicture(
                               this,
                               '<?php echo Yii::app()->createAbsoluteUrl('/offlineUpload/offlineIndex',array('code'=>1124))?>',
                               'OfflineSignEnterprise_bank_permit_image',
                           <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                    <?php echo $form->hiddenField($enterpriseInfoModel,'bank_permit_image')?>
                    <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->bank_permit_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->bank_permit_image)?></span>
                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->bank_permit_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_permit_image) ?>">预览</a>
                </p>
                <p>请确保图片清晰，并加盖公章</p>
                <?php echo $form->error($enterpriseInfoModel,'bank_permit_image'); ?>
            </div>
        </li>
        <li class="clearfix accountPrivate">
            <span><i class="red">*</i>银行卡复印件（只限对私账）电子版</span>
            <div class="sign-upload">
                <p>
                    <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                           onclick="uploadPicture(
                               this,
                               '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1125))?>',
                               'OfflineSignEnterprise_bank_account_image',
                           <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                    <?php echo $form->hiddenField($enterpriseInfoModel,'bank_account_image')?>
                    <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->bank_account_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->bank_account_image)?></span>
                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->bank_account_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->bank_account_image) ?>">预览</a>
                </p>
                <p>请确保图片清晰，并加盖公章</p>
                <?php echo $form->error($enterpriseInfoModel,'bank_account_image'); ?>
            </div>
            <span class='switch'><i class="red">*</i>委托收款授权书电子版</span>
            <div class="sign-upload switch1">
                <p>
                    <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                           onclick="uploadPicture(this,
                               '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1126))?>',
                               'OfflineSignEnterprise_entrust_receiv_image',
                           <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                    <?php echo $form->hiddenField($enterpriseInfoModel,'entrust_receiv_image')?>
                    <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->entrust_receiv_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->entrust_receiv_image)?></span>
                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->entrust_receiv_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->entrust_receiv_image) ?>">预览</a>
                </p>
                <p>请确保图片清晰，并加盖公章</p>
                <?php echo $form->error($enterpriseInfoModel,'entrust_receiv_image'); ?>
            </div>
        </li>
        <li class="accountPrivate">
            <span><i class="red">*</i>收款人身份证电子版</span>
            <div class="sign-upload">
                <p>
                    <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                           onclick="uploadPicture(
                               this,
                               '<?php echo Yii::app()->createAbsoluteUrl('offlineUpload/offlineIndex',array('code'=>1127))?>',
                               'OfflineSignEnterprise_payee_identity_image',
                           <?php echo isset($enterpriseInfoModel->id) ? $enterpriseInfoModel->id : '0' ?>)">
                    <?php echo $form->hiddenField($enterpriseInfoModel,'payee_identity_image')?>
                    <span class="prc-line" style="width: auto"><?php echo empty($enterpriseInfoModel->payee_identity_image) ? '未上传文件' : OfflineSignFile::getOldName($enterpriseInfoModel->payee_identity_image)?></span>
                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($enterpriseInfoModel->payee_identity_image) ? '#' : OfflineSignFile::getfileUrl($enterpriseInfoModel->payee_identity_image) ?>">预览</a>
                </p>

                <?php echo $form->error($enterpriseInfoModel,'payee_identity_image'); ?>
            </div>
        </li>

    </ul>
</div>

<div class="audit-btn">
    <input type="submit" value="保存" id="btnSignBack-s" class="btnSignSubmit"/>
    <input type="button" value="返回"  onclick="localHref()" class="btnSignBack"/>
</div>
<div class="c10"></div>
<div class="grid-view" id="article-grid"></div>

<?php $this->endWidget(); ?>
    </div>
<!--audit-party 会员与帐号信息 end-->
<script>
    function localHref(){
        window.location.href = "<?php echo Yii::app()->controller->createUrl("OfflineSignStoreExtend/update", array("id"=>$extendInfoModel->id,"role"=>$role))?>";
    }
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

        <?php if(isset($enterpriseInfoModel) && $enterpriseInfoModel->error_field):?>
        <?php $modelError = json_decode($enterpriseInfoModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        var str = '<?php echo $value?>';
        str = str.replace('e.','');
        str = '#OfflineSignEnterprise_' + str;
        if(str == '#OfflineSignEnterprise_bank_permit_image' || str == '#OfflineSignEnterprise_license_image' || str == '#OfflineSignEnterprise_tax_image' || str == '#OfflineSignEnterprise_identity_image'){
            $(str).parent().parent().prev().addClass('red');
        }else if(str == '#OfflineSignEnterprise_bank_district_id'){
            $(str).parent().children().addClass('red');
        }else if(str == '#OfflineSignEnterprise_account_pay_type' || str == '#OfflineSignEnterprise_is_chain'){
            $(str).prev().addClass('red');
            $(str).addClass('red');
        }else if(str == '#OfflineSignEnterprise_bank_account_image'|| str == '#OfflineSignEnterprise_payee_identity_image' || str == '#OfflineSignEnterprise_entrust_receiv_image'){
            $(str).parent().addClass('red');
            $(str).parent().parent().prev().addClass('red');
            $(str).prev().addClass('red');
        }else{
            $(str).addClass('red');
            $(str).parent().prev().addClass('red');
           // $(str).prev().addClass('red');
        }
        <?php endforeach;?>
        <?php endif;?>

        $('#OfflineSignEnterprise_payee_identity_number').on('change',function(){
            var manId = $('#OfflineSignEnterprise_legal_man_identity');
            if($(this).val() == manId.val()){
                $('.switch').hide();
                $('.switch1').hide();
            }else{
                $('.switch').show();
                $('.switch1').show();
            }
        });
        $('#OfflineSignEnterprise_payee_identity_number').change();
    });
</script>

<script type="application/javascript">
    $(document).ready(function(){
        var liansuo = $('.liansuo');
        var orx = $('#OfflineSignEnterprise_is_chain');
        if(orx.val() == 1){
            liansuo.show();
        }else{
            liansuo.hide();
        }
        orx.change(function(){
            if(orx.val() == 1){
                liansuo.show();
            }else {
                liansuo.hide();
            }
        });
    });
</script>