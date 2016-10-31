<?php 
	$this->breadcrumbs = array(Yii::t('Franchisee','代理管理系统'),Yii::t('Franchisee','加盟商').$model->name);
?>
<?php 
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs = Yii::app()->clientScript;
	//样式
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js");			
	
	//自己写的上茶u年处理插件 
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");					
?>
<div class="line container_fluid">       
    <div class="row_fluid line">
        <div class="vip_title red">
        	<p class="unit fl"><?php echo Yii::t('Franchisee', '加盟商').'-'.$model->name?></p>
        	<?php echo CHtml::link(Yii::t("Public","返回列表"),$this->createUrl("franchiseeAgent/admin"),array('class'=>'fr mr10 return'))?>
        </div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table6" id="tab1">
                <tr>
                    <td width="100px" align="right" class="fw600"><?php echo Yii::t('Franchisee','名称')?>：</td>
                    <td width="200px"><?php echo $model->name?></td>
                    <td width="80px" align="right" class="fw600"><?php echo Yii::t('Franchisee','加盟商编号')?>：</td>
                    <td width="200px"><?php echo $model->code?></td>
                    <td width="80px" align="right" class="fw600"><?php echo Yii::t('Franchisee','加盟商LOGO')?> ：</td>
                    <td width="200px">
                    	<div class="ImgList">
                            <div class="imgbox"> 
								<div class="w_upload">
									<span class="item_box">
										<a class='imga' href='<?php echo ATTR_DOMAIN."/".$model->logo?>' onclick='return _showBigPic(this)' >
											<img src="<?php echo ATTR_DOMAIN."/".$model->logo?>" class="imgThumb" width='100px' height='100px'/>
										</a>
									</span>
								</div>
							</div>
						</div>
					</td>
                </tr>
                <tr>
<!--                    <td align="right" style="white-space:nowrap;"  class="fw600"><?php // echo Yii::t('Franchisee','英文名称')?>：</td>
                    <td><?php // echo $model->alias_name?></td>-->
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','所属会员')?>：</td>
                    <td ><?php echo $model->member_id?></td>
<!--                    <td align="right" class="fw600"><?php // echo Yii::t('Franchisee','父加盟商')?>：</td>
                    <td><?php // echo $model->parentname?></td>-->
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','主营')?>：</td>
                    <td><?php echo $model->main_course?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','类别')?>：</td>
                    <!--<td ><?php // echo FranchiseeCategory::getFanchiseeCategoryName($model->category_id)?></td>-->
                    <td ><?php echo FranchiseeCategory::getFanchiseeCategoryAllName($model->id)?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','状态')?>：</td>
                    <td><?php echo Franchisee::getStatus($model->status)?></td>
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','电话')?>：</td>
                    <td><?php echo $model->mobile?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','传真')?>：</td>
                    <td><?php echo $model->fax?></td>
                    <td align="right" class="fw600">QQ：</td>
                    <td><?php echo $model->qq?></td>
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','地址')?>：</td>
                    <td><?php echo $model->qq?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','邮编')?>：</td>
                    <td><?php echo $model->zip_code?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','网址')?>：</td>
                    <td><?php echo $model->url?></td>
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','盖网折扣')?>：</td>
                    <td><?php echo $model->gai_discount?>%</td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','会员折扣')?>：</td>
                    <td ><?php echo $model->member_discount?>%</td>
                    <td width="12%" align="right" class="fw600"><?php echo Yii::t('Franchisee','最大绑定盖机数')?>：</td>
                    <td width="20%"><?php echo $model->max_machine?><?php echo Yii::t('Franchisee','台')?></td>
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','创建时间')?>：</td>
                    <td><?php echo date('Y-m-d H:i:s',$model->create_time)?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','更新时间')?>：</td>
                    <td ><?php echo date('Y-m-d H:i:s',$model->update_time)?></td>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','关键字')?>：</td>
                    <td><?php echo $model->keywords?></td>
                </tr>
                <tr>
                    <td align="right" class="fw600"><?php echo Yii::t('Franchisee','简介')?>：</td>
                    <td colspan="5"><?php echo $model->summary?></td>
                </tr>
            </table>
	</div>
</div>
