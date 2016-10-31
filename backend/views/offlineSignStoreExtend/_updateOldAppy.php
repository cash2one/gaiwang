<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="main">
    <div class="toolbarSign">
        <h3><span class="red"></span></h3>
    </div>
    <div class="c10"></div>
    <div class="audit-type clearfix">
        <div><span>新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($extendInfoModel->apply_type) ?></div>
        <div><span>企业名称</span><?php echo OfflineSignStoreExtend::getEnterpriseNameByApplyType($extendInfoModel->apply_type,$extendInfoModel->old_member_franchisee_id)?></div>
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
   <!-- --><?php
/*        //折扣与管理费缴纳信息
        $this->renderPartial('_update_sign_discount_management_info_old',array(
            'storeInfoModel'=>$storeInfoModel,
            'demoImgs'=>$demoImgs,
            'form' =>$form,
            'uploadUrl' => $uploadUrl,
        ))
    ;*/?>

   <!-- <div class="audit-tableTitle">附件信息<a class="check on">收起</a></div>
    <div class="audit-bargain clearfix">
        <ul>
            <li>
                <p class="bargain-cho">盖网通铺设场所及优惠约定<span class="cho"></p>
                <p class="bargain-pdf">
                    <?php /*echo OfflineSignFile::getOldName($extendInfoModel->upload_contract_img)*/?>
                    <a  onclick="return _showBigPic(this)" href="<?php /*echo OfflineSignFile::getfileUrl($extendInfoModel->upload_contract_img) */?>">查看</a>
                </p>
            </li>
        </ul>
    </div>-->
    <div class="c10"></div>
    <div class="c10"></div>
    <div class="grid-view" id="article-grid"></div>

    <?php $this->endWidget(); ?>
</div>



