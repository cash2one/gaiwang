
<div class="line container_fluid">
    <div class="row_fluid line">
    	<div class="vip_title red">
            <p class="unit fl"><?php echo Auditing::getApplyType($model->apply_type)?></p>
        </div>
        <div class="line table_white">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
			 <tr class="table1_title" bgcolor="#fcfcfc">
				<td colspan="2"><?php echo Yii::t('franchiseeAgent', '审核信息')?></td>
			</tr>
			<?php if ($model->status == Auditing::STATUS_NOPASS){?>
			<tr>
				<td width="12%" align="right"><?php echo Yii::t('franchiseeAgent','状态')?>：</td>
				<td width="88%" align="left" class="table_form_right">
					<?php echo Auditing::getStatus($model->status)?>
					<script>function update(){location.href='<?php echo $this->createUrl('franchiseeAgent/reUpdate',array('id'=>$model->id))?>';}</script>
					<?php echo CHtml::button(Yii::t('Auditing', "重新编辑"),array('id'=>'cancel','onclick'=>'update()','class'=>'btn1 btn_large13'));?>
				</td>
			</tr>
			
			<?php }else{?>
			<tr>
				<td width="12%" align="right"><?php echo Yii::t('franchiseeAgent','状态')?>：</td>
				<td width="88%" align="left" class="table_form_right">
					<?php echo Auditing::getStatus($model->status)?>
					<script>function cancel(){location.href='<?php echo $this->createUrl('franchiseeAgent/cancel',array('id'=>$model->id))?>';}</script>
					<?php echo CHtml::button(Yii::t('Auditing', "取消申请"),array('id'=>'cancel','onclick'=>'cancel()','class'=>'btn1 btn_large13'));?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td width="12%" align="right"><?php echo Yii::t('franchiseeAgent','审核意见')?>：</td>
				<td width="88%" align="left" class="table_form_right">
					<?php echo $model->audit_opinion?>
				</td>
			</tr>
<?php if ($model->apply_type==Auditing::APPLY_TYPE_BIZ_BASE){//基本信息?>
<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	//样式
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js");			
	
	//自己写的上茶u年处理插件 
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");					
		
?>
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('franchiseeAgent','加盟商基本信息')?></td>
                    </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent', '地区')?>：</td>
                            <td align="left" class="table_form_right">
                            <?php echo $model->province_id." ".$model->city_id." ".$model->district_id;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent', '详细地址')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo $model->street;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','经纬度')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo $model->lng." ".$model->lat;?>
                            </td>
                        </tr>
                        <tr>
                        	<td align="right"><?php echo Yii::t('franchiseeAgent','简介')?>：</td>
                        	<td>
								<?php echo $model->summary; ?>
                        	</td>
                        </tr>
                      
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','主营')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->main_course; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','分类')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo FranchiseeCategory::getFanchiseeCategoryName($model->category_id);?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">商家LOGO：</td>
                            <td align="left" class="table_form_right">
                            	<div class="ImgList">
	                            	<div class="imgbox"> 
										<div class="w_upload">
											<span class="item_box">
												<a class='imga' href='<?php echo ATTR_DOMAIN."/".$model->logo?>' onclick='return _showBigPic(this)' >
													<img src="<?php echo ATTR_DOMAIN."/".$model->logo?>" class="imgThumb" />
												</a>
											</span>
										</div>
									</div>
								</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"> 图片列表：</td>
                            <td align="left" class="table_form_right">
                            <div class="ImgList">
                            	<?php 
                            		$imgArr = explode("|", $model->path);
                            		foreach ($imgArr as $row){
                            	?>
                            	<div class="imgbox"> 
									<div class="w_upload">
										<span class="item_box">
											<a class='imga' href='<?php echo IMG_DOMAIN."/".$row?>' onclick='return _showBigPic(this)' >
												<img src="<?php echo IMG_DOMAIN."/".$row?>" class="imgThumb" />
											</a>
										</span>
									</div>
								</div>
								<?php }?>
								</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"></td>
                            <td id="gilid"></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','手机号码')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->mobile; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','QQ')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->qq; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','网址')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->url; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','关键词')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->keywords; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','传真')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->fax; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','邮编')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->zip_code; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','公告')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->notice; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','介绍')?>：</td>
                            <td align="left" class="table_form_right">
				            	<?php echo $model->description; ?>
                            </td>
                        </tr>
<?php }else if($model->apply_type==Auditing::APPLY_TYPE_BIZ_GUANJIAN){//关键信息?>
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('franchiseeAgent','加盟商关键信息')?></td>
                    </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','加盟商名称')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->apply_name?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','商家英文名')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->alias_name?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','所属会员')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->member_id?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','父级加盟商')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->parentname;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','最大绑定盖机数')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->max_machine;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','盖网折扣')?>：</td>
                            <td align="left" class="table_form_right">
                                <?php echo $model->gai_discount;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','会员折扣')?>：</td>
                            <td align="left" class="table_form_right">
                                <?php echo $model->member_discount;?>
                            </td>
                        </tr>
<?php }else{?>
<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	//样式
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js");			
	
	//自己写的上茶u年处理插件 
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");					
		
?>
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('franchiseeAgent','加盟商信息')?></td>
                    </tr>
                         <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','加盟商名称')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->apply_name?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','商家英文名')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->alias_name?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','所属会员')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->member_id?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','父级加盟商')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->parentname;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','最大绑定盖机数')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->max_machine;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','盖网折扣')?>：</td>
                            <td align="left" class="table_form_right">
                                <?php echo $model->gai_discount;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','会员折扣')?>：</td>
                            <td align="left" class="table_form_right">
                                <?php echo $model->member_discount;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent', '地区')?>：</td>
                            <td align="left" class="table_form_right">
                            <?php echo $model->province_id." ".$model->city_id." ".$model->district_id;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent', '详细地址')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo $model->street;?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','经纬度')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo $model->lng." ".$model->lat;?>
                            </td>
                        </tr>
                        <tr>
                        	<td align="right"><?php echo Yii::t('franchiseeAgent','简介')?>：</td>
                        	<td>
								<?php echo $model->summary; ?>
                        	</td>
                        </tr>
                      
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','主营')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->main_course; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','分类')?>：</td>
                            <td align="left" class="table_form_right">
                            	<?php echo FranchiseeCategory::getFanchiseeCategoryName($model->category_id);?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">商家LOGO：</td>
                            <td align="left" class="table_form_right">
                            	<div class="ImgList">
	                            	<div class="imgbox"> 
										<div class="w_upload">
											<span class="item_box">
												<a class='imga' href='<?php echo ATTR_DOMAIN."/".$model->logo?>' onclick='return _showBigPic(this)' >
													<img src="<?php echo ATTR_DOMAIN."/".$model->logo?>" class="imgThumb" />
												</a>
											</span>
										</div>
									</div>
								</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"> 图片列表：</td>
                            <td align="left" class="table_form_right">
                            <div class="ImgList">
                            	<?php 
                            		$imgArr = explode("|", $model->path);
                            		foreach ($imgArr as $row){
                            	?>
                            	<div class="imgbox"> 
									<div class="w_upload">
										<span class="item_box">
											<a class='imga' href='<?php echo IMG_DOMAIN."/".$row?>' onclick='return _showBigPic(this)' >
												<img src="<?php echo IMG_DOMAIN."/".$row?>" class="imgThumb" />
											</a>
										</span>
									</div>
								</div>
								<?php }?>
								</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"></td>
                            <td id="gilid"></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','手机号码')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->mobile; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','QQ')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->qq; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','网址')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->url; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','关键词')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->keywords; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','传真')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->fax; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','邮编')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->zip_code; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','公告')?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $model->notice; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('franchiseeAgent','介绍')?>：</td>
                            <td align="left" class="table_form_right">
				            	<?php echo $model->description; ?>
                            </td>
                        </tr>
<?php }?>
                </table>
		</div>
    </div>
</div>