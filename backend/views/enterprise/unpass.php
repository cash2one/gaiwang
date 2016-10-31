<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '列表'));
/** @var EnterpriseData $enterpriseData */
$enterpriseData = $model->enterpriseData;
?>

<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>

<div class="com-box">
			<div class="sellerWebSign sellerWebSignIcon">
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '网络店铺信息');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr>
						<th><?php echo Yii::t('enterprise', '店铺名称：');?><?php echo $store->name;?></th>
						
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '店铺所在地：');?><?php echo Region::getName($store->province_id,$store->city_id,$store->district_id);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '详细地址：');?><?php echo $store->street;?></th>
					</tr>
					</tbody>
				</table>
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '公司及联系人信息');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr>
						<th><?php echo Yii::t('enterprise', '公司名称：');?><?php echo $model->name;?></th>
						
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '固话：');?><?php echo $model->link_phone;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '公司注册地：');?><?php echo Region::getName($model->province_id,$model->city_id,$model->district_id);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '详细地址：');?><?php echo $model->street;?></th>
					</tr>
					</tbody>
				</table>
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '营业执照信息（副本）');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '营业执照号：');?><?php echo $enterpriseData->license;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '营业执照注册地：');?><?php echo Region::getName($enterpriseData->license_province_id,$enterpriseData->license_city_id,$enterpriseData->license_district_id);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '营业执照有效期：');?><?php echo date('Y-m-d',$enterpriseData->license_start_time);?> - <?php echo date('Y-m-d',$enterpriseData->license_end_time);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '法定经营范围：');?><?php echo $cat->name;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'license_photo')) ?>	</tr>			
                                        </tr>
					</tbody>
				</table>
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '组织机构代码证');?>组织机构代码证</h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '组织机构代码：');?><?php echo $enterpriseData->organization;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '组织机构代码证电子版：');?><?php echo ATTR_DOMAIN.DS.$enterpriseData->organization_image;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo ATTR_DOMAIN.DS.$enterpriseData->organization_image;?>" class="blue" target="_blank"><?php echo Yii::t('enterprise', '预览');?></a>&nbsp;&nbsp;&nbsp;&nbsp; </th>
					</tr>
					</tbody>
				</table>
				

				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开户银行许可证');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '银行开户名：');?><?php echo $bankAccount->account_name;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '公司银行账号：');?><?php echo $bankAccount->account;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '开户银行支行名称：');?><?php echo $bankAccount->bank_name;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '支行联行号：');?><?php echo $bankAccount->sister_bank_number;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '开户银行所在地：');?><?php echo Region::getName($bankAccount->province_id,$bankAccount->city_id,$bankAccount->district_id);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '开户银行许可证电子版：');?><?php echo ATTR_DOMAIN.DS.$bankAccount->licence_image;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo ATTR_DOMAIN.DS.$bankAccount->licence_image;?>" class="blue" target="_blank"><?php echo Yii::t('enterprise', '预览');?></a>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
						</th>
					</tr>
					</tbody>
				</table>
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '税务登记证');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '税务登记证号：');?><?php echo $enterpriseData->tax_id;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '纳税人识别号：');?><?php echo $enterpriseData->taxpayer_id;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th><?php echo Yii::t('enterprise', '税务登记证电子版：');?><?php echo ATTR_DOMAIN.DS.$enterpriseData->tax_image;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo ATTR_DOMAIN.DS.$enterpriseData->tax_image;?>" class="blue" target="_blank"><?php echo Yii::t('enterprise', '预览');?></a>&nbsp;&nbsp;&nbsp;&nbsp; </th>
					</tr>
					</tbody>
				</table>
				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '经营类目信息');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '经营类目：');?><?php echo $cat->name;?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
<<<<<<< .mine
                                        <?php if($store->category_id==Category::TOP_APPLIANCES): ?>
                                        <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'threec_image')) ?>
                                        <tr class="blank">
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($store->category_id==Category::TOP_COSMETICS): ?>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'cosmetics_image')) ?>
                                            <tr class="blank">
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if($store->category_id==Category::TOP_FOOD): ?>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'food_image')) ?>
                                            <tr class="blank">
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if($store->category_id==Category::TOP_JEWELRY): ?>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'jewelry_image')) ?>
                                            <tr class="blank">
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr class="">
                                            <th><?php echo $enterpriseData->getAttributeLabel('exists_imported_goods'),'：',EnterpriseData::existsImportedGoods($enterpriseData->exists_imported_goods) ?></th>
                                        </tr>
                                        <tr class="blank">
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <?php if($enterpriseData->exists_imported_goods==EnterpriseData::EXISTS_IMPORTED_GOODS_YES): ?>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'declaration_image')) ?>
                                            <tr class="blank">
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'report_image')) ?>
                                            <tr class="blank">
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if($enterpriseData->brand_image): ?>
                                            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'brand_image')) ?>
                                        <?php endif; ?>
=======
>>>>>>> .r3394
					</tbody>
				</table>

				
				<h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开店模式');?></h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr class="">
						<th><?php echo Yii::t('enterprise', '开店模式：');?><?php echo Store::getMode($store->mode);?></th>
					</tr>
					<tr class="blank">
						<td colspan="2">&nbsp;</td>
					</tr>
					</tbody>
				</table>
				
				
				<h3 class="mt15 tableTitle">&nbsp;</h3>
				<div class="c10"></div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
					<tbody>
					<tr>
						<th>审核结果：<span class="red">不通过</span></th>
					</tr>
					<tr>
						<td>
							<?php echo $log->content;?>
						</td>
					</tr>
					
					</tbody>
				</table>
				
			</div>
				   
		</div>
