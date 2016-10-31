<!--Region::getAreaNameById(Region::getAreaIdByProvinceId($contract_model->province_id))-->
    <div class="main">
            <div class="toolbarSign">
                <h3>温馨提示：<span class="red">若选择未通过审核，请勾选有误位置 / 字段，并填写未通过原因，再点击提交。</span></h3>
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
                    <li>
                        <span class="party-name"><i class="red">*</i>加盟商开发方</span>
                        <span class="party-con"><?php echo OfflineSignStoreExtend::getFranchiseeDeveloper($extendModel->franchisee_developer) ?></span>
                    </li>
                    <li>
                        <span class="party-name"><i class="red">*</i>机器归属方</span>
                        <span class="party-con"><?php echo OfflineSignStoreExtend::getMachineBelongTo($extendModel->machine_belong_to); ?></span>
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
                    <li id="e.enterprise_type">
                        <span class="party-name"><i class="red">*</i>企业类型</span>
                        <span class="party-con"><?php echo OfflineSignEnterprise::getEnterType($enterprise_model->enterprise_type) ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业类型','field'=>'e.enterprise_type'))?></span>
                    </li>
                    <li id="e.b_name">
                        <span class="party-name"><i class="red">*</i>营业执照注册名称</span>
                        <span class="party-con"><?php echo $enterprise_model->name ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'企业名称','field'=>'e.b_name'))?></span>
                    </li>
                    <li id="e.enterprise_license_number">
                        <span class="party-name"><i class="red">*</i>营业执照注册号</span>
                        <span class="party-con"><?php echo $enterprise_model->enterprise_license_number ?></span>
                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'营业执照注册号','field'=>'e.enterprise_license_number'))?></span>
                    </li>





                    <li id="e.tax_id">
                        <span class="party-name">税务登记证号</span>
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
                    </ul>
                </div>
                <div class="c10"></div>
                <div class="party-prcShow">
                    <div id="preview" class="spec-preview">
                            <span class="jqzoom">
                                <img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->license_image) ;?>" />
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


                        <li id="e.account_pay_type">
                            <span class="party-name"><i class="red">*</i>结算账户类型</span>
                            <span class="party-con"><?php  echo OfflineSignEnterprise::getAccountPayType($enterprise_model->account_pay_type) ?></span>
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
                                <li id="e.entrust_receiv_image">
                                    <p class="prcList-name"><span>*</span>委托收款授权书电子版</p>
                                    <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($enterprise_model->entrust_receiv_image);?>" /></p>
                                    <p class="prcList-cho">
                                        <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'委托收款授权书电子版','field'=>'e.entrust_receiv_image'))?></span>
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

            <?php  foreach($storeData as $key=>$model):?>
                <div class="audit-tableTitle">店铺信息--<?php echo $key+1;?></div>
        <div class="audit-party clearfix">
                <div class="left">
                    <ul>
                        <li  id="s.<?php echo $model->id?>franchisee_name">
                            <span class="party-name"><i class="red">*</i>加盟商名称</span>
                            <span class="party-con"><?php echo  $model->franchisee_name ?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':加盟商名称','field'=>'s'.($model->id).'.franchisee_name'))?></span>
                        </li>

                    </ul>
                </div>
        </div>
        <!--audit-party 店铺信息 end-->
            <div class="audit-tableTitle">优惠约定</div>
            <div class="audit-party clearfix">
                <div class="left">
                    <ul>
                        <li  id="s.<?php echo $model->id?>member_discount">
                            <span class="party-name"><i class="red">*</i>盖网会员结算折扣(%)</span>
                            <span class="party-con"><?php  echo $model->member_discount ?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网会员结算折扣','field'=>'s'.($model->id).'.member_discount'))?></span>
                        </li>
                        <li id="s.<?php echo $model->id?>discount">
                            <span class="party-name"><i class="red">*</i>折扣差(%)</span>
                            <span class="party-con"><?php  echo $model->discount ?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':折扣差','field'=>'s'.($model->id).'.discount'))?></span>
                        </li>
                        <li id="s.<?php echo $model->id?>gai_discount">
                            <span class="party-name"><i class="red">*</i>盖网公司结算折扣(%)</span>
                            <span class="party-con"><?php  echo $model->gai_discount ?></span>
                            <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖网公司结算折扣','field'=>'s'.($model->id).'.gai_discount'))?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--audit-party 优惠约定 end-->
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
        <!--audit-party 盖机推荐者绑定信息 end-->
            <?php endforeach;?>

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
        <div class="c10"></div>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th>未通过审核原因
                    <span class="red">选择不通过审核时必填：</span>
                </th>
            </tr>
            <tr>
                <td>
                    <textarea name="content" id="content" class="textareatxt" disabled ></textarea>
                    <input type="hidden" name="contentHidden" value="" id="contentHidden">
                </td>
            </tr>

            </tbody>
        </table>
            <div class="c10"></div>

        <div class="audit-btn">
            <input type="hidden" name="status" id="status" value=""/>
            <input type="hidden" name="errorField" id="errorField" value=""/>

            <input type="button" value="通过审核" id="btnSignSubmit"
                   class="btnSignSubmit"/>&nbsp;&nbsp;
            <input type="button" value="不通过审核" id="btnSignBack"
                   class="btnSignBack"/>
        </div>
            <div class="c10"></div>
            <div class="grid-view" id="article-grid"></div>
        </form>
</div>



<script>
    $(document).ready(function(){

        <?php foreach($storeData as $num=>$model):?>
        <?php if(isset($model) && $model->error_field):?>
        <?php $modelError = json_decode($model->error_field,true);?>
        <?php foreach($modelError as $value):?>
        <?php $strArr = explode('.',$value);$value = $strArr[0].'.'.$model->id.$strArr[1];?>
        $("li[id='<?php echo $value?>']").addClass('red');
        <?php endforeach;?>
        <?php endif;?>
        <?php endforeach;?>


        <?php if(isset($enterpriseModel->license_image) && $enterpriseModel->error_field):?>
        <?php $modelError = json_decode($enterpriseModel->error_field,true);?>
        <?php  foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        <?php endforeach;?>
        <?php endif;?>

        <?php if(isset($contractModel->number) && $contractModel->error_field):?>
        <?php $modelError = json_decode($contractModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        <?php endforeach;?>
        <?php endif;?>


        <?php if(isset($extendModel) && $extendModel->error_field):?>
        <?php $modelError = json_decode($extendModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        <?php endforeach;?>
        <?php endif;?>
    });
</script>



