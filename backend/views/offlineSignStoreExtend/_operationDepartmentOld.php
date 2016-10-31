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
                    <span class="party-con"><?php echo OfflineSignStoreExtend::getMachineBelongTo($extendModel->machine_belong_to); ?></span>
                </li>
            </ul>
        </div>
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
                            <li id="s.recommender_apply_image">
                                <p class="prcList-name"><span>*</span>盖机推荐者绑定申请照片</p>
                                <p class="prcList-prc"><img src="<?php echo OfflineSignFile::getfileUrl($model->recommender_apply_image);?>" /></p>
                                <span class="party-cho"><?php echo CHtml::checkBox('errors[]',false,array('value'=>'加盟商-'.($key+1).':盖机推荐者绑定申请照片','field'=>'s.recommender_apply_image'))?></span>
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

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th>未通过审核原因
                    <span class="red">选择不通过审核时必填：</span>
                </th>
            </tr>
            <tr>
                <td>
                    <textarea name="content" id="content" class="textareatxt" disabled="disabled"></textarea>
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
    </form>
</div>
