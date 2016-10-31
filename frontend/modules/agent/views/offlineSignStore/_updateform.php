<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $form CActiveForm */
?>
<style>
    /*表单错误提示调整*/
    span{
        float: left;
    }
    input{float: left;}
    .errorMessage{float: left;}
    select{float: left;}
</style>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'offline-sign-store-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>
<div class="c10"></div>
<div class="sign-conten">
    <!--盖机推荐者绑定信息-->
    <div class="sign-list">
        <ul>
            <li>
                <span><i class="red">*</i>加盟商名称</span>
                <?php echo $form->textField($model,'franchisee_name',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'franchisee_name')?>
            </li>
            <li>
                <span><i class="red">*</i>加盟商区域</span>
                <?php echo $form->dropDownList($model,'install_area_id',Region::getFranchiseeArea(),array(
                    'class' => 'sign-select',
                    'prompt' => Yii::t('Public','选择大区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('region/updateProvince'),
                        'dataType' => 'json',
                        'data' => array(
                            'area_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
									$("#OfflineSignStore_install_province_id").html(data.dropDownProvinces);
									$("#OfflineSignStore_install_city_id").html(data.dropDowncitys);
									$("#OfflineSignStore_install_district_id").html(data.dropDownCounties);
								}',
                    )));?>
                <?php echo $form->error($model,'install_area_id'); ?>
                <?php echo $form->dropDownList($model, 'install_province_id',Region::getProvinceByAreaId($model->install_area_id), array(
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
									$("#OfflineSignStore_install_city_id").html(data.dropDownCities);
									$("#OfflineSignStore_install_district_id").html(data.dropDownCounties);
								}',
                    )));?>
                <?php echo $form->error($model,'install_province_id'); ?>
                <?php echo $form->dropDownList($model, 'install_city_id', Region::getRegionByParentId($model->install_province_id), array(
                    'prompt' => Yii::t('machine', '选择城市'),
                    'class' => 'sign-select ml10',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('region/updateArea'),
                        'update' => '#OfflineSignStore_install_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                    )));?>
                <?php echo $form->error($model,'install_city_id'); ?>
                <?php echo $form->dropDownList($model, 'install_district_id', Region::getRegionByParentId($model->install_city_id), array(
                    'class' => 'sign-select ml10',
                    'prompt' => Yii::t('Public','选择区/县'),
                ));?>
                <?php echo $form->error($model,'install_district_id'); ?>
            </li>
            <li>
                <span><i class="red">*</i>加盟商详细地址</span>
                <?php echo $form->textField($model,'install_street',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'install_street'); ?>
            </li>
            <li>
                <span><i class="red">*</i>盖网通管理人姓名</span>
                <?php echo $form->textField($model,'machine_administrator',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'machine_administrator')?>
                <span><i class="red">*</i>盖网通管理人移动电话</span>
                <?php echo $form->textField($model,'machine_administrator_mobile',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'machine_administrator_mobile')?>
            </li>
            <li>
                <span><i class="red">*</i>店面固定电话</span>
                <?php echo $form->textField($model,'store_phone',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'store_phone'); ?>
                <span><i class="red">*</i>店面移动电话</span>
                <?php echo $form->textField($model,'store_mobile',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'store_mobile'); ?>
            </li>
            <li>
                <span><i class="red">*</i>盖网通数量</span>
                <?php echo $form->textField($model,'machine_number',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'machine_number'); ?>
                <span><i class="red">*</i>尺寸</span>
                <?php echo $form->dropDownList($model,'machine_size',OfflineSignStore::getMachineSize(),array('prompt' => '请选择','class' => 'sign-select ml'));?>
                <?php echo $form->error($model,'machine_size'); ?>
            </li>
            <li>
                <span><i class="red">*</i>所在商圈</span>
                <?php echo $form->textField($model,'store_location',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'store_location'); ?>
                <span><i class="red">*</i>商家联系人</span>
                <?php echo $form->textField($model,'store_linkman',array('class' => 'input ml'));?>
                <?php echo $form->error($model,'store_linkman'); ?>
            </li>
            <li>
                <span>商家联系人职位</span>
                <?php echo $form->textField($model,'store_linkman_position',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'store_linkman_position')?>
                <span>商家联系人微信</span>
                <?php echo $form->textField($model,'store_linkman_webchat',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'store_linkman_webchat')?>
            </li>
            <li>
                <span>商家联系人QQ</span>
                <?php echo $form->textField($model,'store_linkman_qq',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'store_linkman_qq')?>
                <span>商家联系人邮箱</span>
                <?php echo $form->textField($model,'store_linkman_email',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'store_linkman_email')?>
            </li>
            <li>
                <span><i class="red">*</i>经营类别（级别一）</span>
                <?php
                $_class = get_class($model);
                echo $form->dropDownList($model, 'depthZero', OfflineSignStore::getChildCategory(), array(
                    'class'=>'sign-select ml fl',
                    'prompt' => '经营类别（级别一）',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('offlineSignStore/depthCategory'),
                        'dataType' => 'json',
                        'data' => array(
                            'pid' => 'js:this.value',
                            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
									$("#OfflineSignStore_depthOne").html(data.dropDownCategory);
								}',
                    )));
                ?>
                <?php echo $form->error($model,'depthZero')?>
                <span>经营类别（级别二）</span>
                <?php
                $depthOne_data = ($model->depthZero)?OfflineSignStore::getChildCategory($model->depthZero):array();
                echo $form->dropDownList($model, 'depthOne', $depthOne_data, array(
                    'prompt' => '经营类别（级别二）',
                    'class'=>'sign-select ml fl'
                ));?>
            </li>
            <li><span><i class="red">*</i>营业开始时间</span>
                <div class="enterDate">
                    <?php echo $form->textField($model,'open_begin_time',array('class'=>'dateTxt input ml','onfocus' => 'WdatePicker({dateFmt:"HH:mm"})','readonly'=>"true"))?>
                </div>
                <?php echo $form->error($model,'open_begin_time')?>
                <span><i class="red">*</i>营业结束时间</span>
                <div class="enterDate">
                    <?php echo $form->textField($model,'open_end_time',array('class'=>'dateTxt input ml','onfocus' => 'WdatePicker({dateFmt:"HH:mm"})','readonly'=>"true"))?>
                </div>
                <?php echo $form->error($model,'open_end_time')?>
            </li>
            <li>
                <span id='isMemberShip'>商家有否存在会员制</span>
                <?php echo $form->dropDownList($model,'exists_membership',OfflineSignStore::getExistsMembership(),array('class'=>'sign-select ml fl'))?>
            </li>
            <li>
                <span class="membership">会员折扣方式</span>
                <?php echo $form->dropDownList($model,'member_discount_type',OfflineSignStore::getDiscountType(),array('class'=>'sign-select ml fl membership'))?>
                <span class="membership">会员折扣(%)</span>
                <?php echo $form->textField($model,'store_disconunt',array('class'=>'input ml membership'))?>
                <?php echo $form->error($model,'store_disconunt')?>
            </li>
            <li class="clearfix">
                <span><i class="red">*</i>带招牌的店铺门面照片</span>
                <div class="sign-upload">
                    <p>
                        <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                               onclick="uploadPicture(
                                   this,
                                   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1131))?>',
                                   'OfflineSignStore_store_banner_image',
                               <?php echo isset($model->id) ? $model->id : '0' ?>)">
                        <?php echo $form->hiddenField($model,'store_banner_image')?>
                        <span class="prc-line" style="width: auto"><?php echo empty($model->store_banner_image) ? '未上传文件' : OfflineSignFile::getOldName($model->store_banner_image)?></span>
                        <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->store_banner_image) ? '#' : OfflineSignFile::getfileUrl($model->store_banner_image)?>">预览</a>
                    </p>
                    <p>
                        请正面拍摄店铺门面照并确保图片清晰
                        <a onclick="return _showBigPic(this)" href="<?php echo IMG_DOMAIN."/".$demoImgs['store_banner_image_demo'] ?>">示例</a>
                    </p>
                    <?php echo $form->error($model,'store_banner_image')?>
                </div>
                <span><i class="red">*</i>店铺内部照片</span>
                <div class="sign-upload">
                    <p>
                        <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                               onclick="uploadPicture(
                                   this,
                                   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1132))?>',
                                   'OfflineSignStore_store_inner_image',
                               <?php echo isset($model->id) ? $model->id : '0' ?>)">
                        <?php echo $form->hiddenField($model,'store_inner_image')?>
                        <span class="prc-line" style="width: auto"><?php echo empty($model->store_inner_image) ? '未上传文件' : OfflineSignFile::getOldName($model->store_inner_image)?></span>
                        <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->store_inner_image) ? '#' : OfflineSignFile::getfileUrl($model->store_inner_image)?>">预览</a>
                    </p>
                    <p>
                        请大范围拍摄店铺内部照片并确保图片清晰
                        <a onclick="return _showBigPic(this)" href="<?php echo IMG_DOMAIN."/".$demoImgs['store_inner_image_demo'] ?>">示例</a>
                    </p>
                    <?php echo $form->error($model,'store_inner_image')?>
                </div>
            </li>
        </ul>
    </div>

    <!--优惠约定-->
    <div class="sign-tableTitle">优惠约定</div>
    <div class="sign-list">
        <ul>
            <li>
                <span><i class="red">*</i>盖网会员结算折扣(%)</span>
                <?php echo $form->textField($model,'member_discount',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'member_discount'); ?>
            </li>
            <li>
                <span><i class="red">*</i>折扣差(%)</span>
                <?php echo $form->textField($model,'discount',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'discount'); ?>
                <span><i class="red">*</i>盖网公司结算折扣(%)</span>
                <?php echo $form->textField($model,'gai_discount',array('class'=>'input ml','disabled' => "true"))?>
                <?php echo $form->error($model,'gai_discount'); ?>
            </li>
            <li>
                <span>盖网会员结算折扣备注</span>
                <?php echo $form->textField($model,'clearing_remark',array('class'=>'input xl'))?>
                <?php echo $form->error($model,'clearing_remark'); ?>
            </li>
        </ul>
    </div>
    <!--机器信息-->
    <div class="sign-tableTitle">机器信息</div>
    <div class="sign-list">
        <ul>
            <li>
                <span><i class="red">*</i>铺设类型</span>
                <?php echo $form->dropDownList($model,'machine_install_type',OfflineSignStore::getInstallType(),array('prompt' => '请选择','class'=>'sign-select ml'))?>
                <?php echo $form->error($model,'machine_install_type'); ?>
                <span><i class="red">*</i>样式</span>
                <?php echo $form->dropDownList($model,'machine_install_style',OfflineSignStore::getInstallStyle(),array('prompt' => '请选择','class'=>'sign-select ml'))?>
                <?php echo $form->error($model,'machine_install_style'); ?>
            </li>
        </ul>
    </div>
    <!--盖网通推荐者绑定信息-->
    <div class="sign-tableTitle">盖网通推荐者绑定信息</div>
    <div class="sign-list">
        <ul>
            <li>
                <span><i class="red">*</i>企业会员名</span>
                <input class="input ml" value="<?php echo 5555; ?>" disabled/>

                <span><i class="red">*</i>加盟商名</span>
                <input class="input ml" value="" id="franName" disabled/>

            </li>
            <li>
                <span><i class="red">*</i>联盟商户运维方名称</span>
                <?php echo $form->textField($model,'franchisee_operate_name',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'franchisee_operate_name'); ?>
                <span><i class="red">*</i>运维方GW号</span>
                <?php echo $form->textField($model,'franchisee_operate_gai_number',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'franchisee_operate_gai_number'); ?>
            </li>
            <li>
                <span><i class="red">*</i>企业会员名(代理商)</span>
                <?php echo $form->textField($model,'enterprise_member_name_agent',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'enterprise_member_name_agent'); ?>
                <span><i class="red">*</i>推荐者GW号(代理商)</span>
                <?php echo $form->textField($model,'recommender_agent_gai_number',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'recommender_agent_gai_number'); ?>
            </li>
            <li>
                <span><i class="red">*</i>推荐者手机号码(代理商)</span>
                <?php echo $form->textField($model,'recommender_mobile',array('class'=>'input ml'))?>
                <?php  echo $form->error($model,'recommender_mobile')?>
                <span><i class="red">*</i>联系人(代理商)</span>
                <?php echo $form->textField($model,'recommender_linkman',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'recommender_linkman')?>
            </li>
            <li>
                <span><i class="red">*</i>推荐者手机号码(会员)</span>
                <?php echo $form->textField($model,'recommender_mobile_member',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'recommender_mobile_member')?>
                <span><i class="red">*</i>推荐者GW号(会员)</span>
                <?php echo $form->textField($model,'recommender_member_gai_number',array('class'=>'input ml'))?>
                <?php echo $form->error($model,'recommender_member_gai_number')?>
            </li>
            <li>
                <span><i class="red">*</i>盖机推荐者绑定申请</span>
                <div class="sign-upload">
                    <p>
                        <input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
                               onclick="uploadPicture(
                                   this,
                                   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1133))?>',
                                   'OfflineSignStore_recommender_apply_image',
                               <?php echo isset($model->id) ? $model->id : '0' ?>)">
                        <?php echo $form->hiddenField($model,'recommender_apply_image')?>
                        <span class="prc-line" style="width: auto"><?php echo empty($model->recommender_apply_image) ? '未上传文件' : OfflineSignFile::getOldName($model->recommender_apply_image) ?></span>
                        <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->recommender_apply_image) ? '#' : OfflineSignFile::getfileUrl($model->recommender_apply_image) ?>">预览</a>
                    </p>
                    <p>请确保图片清晰，并加盖公章</p>
                    <?php echo $form->error($model,'recommender_apply_image'); ?>
                </div>
            </li>
        </ul>
    </div>
</div>

    <?php echo $form->hiddenField($model,'step')?>
    <?php echo $form->hiddenField($model,'id')?>
    <div class="sign-clear"></div>
    <div class="c10"></div>
    <div class="sign-btn">
        <input type="submit" value="保存" class="btn-sign" id="addFranchisee">
        <input type="button" value="返回" class="btn-sign" onclick="returnHref()">
    </div>

<?php $this->endWidget(); ?>
<?php
    $url = $_GET['apply_type'] == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE?$this->createUrl('offlineSignStore/update',array('storeExtendId'=>$_GET['extendId'])):$this->createUrl('offlineSignStore/OldFranchiseeUNLL',array('id'=>$_GET['extendId']))
?>
<script type="text/javascript">
    function returnHref(){
        var extendId = <?php echo $_GET['extendId']?>;
        window.location.href ='<?php echo $url;?>'
    }
    $(document).ready(function(){
        //点击的是上一步还是提交资料
        var step = $('#OfflineSignStore_step');
        var lastStep = $('#lastStep');
        var nextStep = $('#nextStep');
        var addFranchisee = $('#addFranchisee');
        lastStep.click(function(){
            step.val(<?php echo OfflineSignStore::LAST_STEP?>);
            $('div.errorMessage').attr({style: 'display:none;'}).text('');
            $('#offline-sign-store-form').yiiactiveform({
                'validateOnSubmit':false
            });
            $('#offline-sign-store-form').submit();
        });
        nextStep.click(function(){
            step.val(<?php echo OfflineSignStore::NEXT_STEP?>);
        });
        addFranchisee.click(function () {
            step.val(<?php echo OfflineSignStore::ADDFRANCHISEE?>);
        });
    });

    /**
     * 检查分类，最少选择一个顶级分类
     */
    function categoryCheck(){
        var categoryVal = $('#OfflineSignStore_depthZero').val();
        if(categoryVal.length <= 0){
            art.dialog({
                icon: 'warning',
                content: '至少选择一个分类',
                lock:true,
                ok:function(){
                    $('#OfflineSignStore_depthZero').focus();
                }
            });
            return false;
        }
        return true;
    }
</script>
<script>
    /**
     * 红色显示错误字段
     */
    $(document).ready(function(){
        <?php if(isset($model) && $model->error_field):?>
        <?php $modelError = json_decode($model->error_field,true);?>
        <?php foreach($modelError as $value):?>
        var str = '<?php echo $value?>';
        str = str.replace('s.','');
        str = '#OfflineSignStore_' + str;
        if((str == '#OfflineSignStore_store_banner_image') || (str == '#OfflineSignStore_store_inner_image') || (str == '#OfflineSignStore_recommender_apply_image')){
            $(str).parent().parent().prev().addClass('red');
        }else if(str == '#OfflineSignStore_open_begin_time' || str == '#OfflineSignStore_open_end_time'){
            $(str).addClass('red');
            $(str).parent().prev().addClass('red');
        }else if(str == '#OfflineSignStore_install_province_id'){
            $(str).addClass('red');
            $(str).prev().prev().addClass('red');
            $(str).next().next().addClass('red');
            $(str).next().parent().children().addClass('red');
        }else{
            $(str).addClass('red');
            $(str).prev().addClass('red');
        }
        <?php endforeach;?>
        <?php endif;?>
    });
</script>

<script type="application/javascript">
    /**
     * 商家是否存在会员制
     */
    $(document).ready(function(){
        var membership =$('.membership');
        var orx = $('#OfflineSignStore_exists_membership');
        if(orx.val() == 1){
            membership.show();
        }else{
            membership.hide();
        }
        orx.change(function(){
            if(orx.val() == 1){
                membership.show();
            }else{
                membership.hide();
            }
        })
    });

</script>

<script>
    $(document).ready(function(){

        //盖网折扣
        var discount = $('#OfflineSignStore_discount');
        discount.change(function(){
            var discountVal = parseInt(discount.val());
            var memDiscount = parseInt($('#OfflineSignStore_member_discount').val());
            $('#OfflineSignStore_gai_discount').val(memDiscount - discountVal);
        });

        $('#OfflineSignStore_franchisee_name').change(function(){
            $('#franName').val($('#OfflineSignStore_franchisee_name').val());
        });
        $('#franName').val($('#OfflineSignStore_franchisee_name').val());
    });

</script>