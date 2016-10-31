<?php
// 编辑加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '编辑加盟商') => array('/seller/franchisee/update')
);
?>

<script type="text/javascript" src="/js/swf/js/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/js/swf/js/artDialog.iframeTools.js"></script>
<script type="text/javascript" src="/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<div class="toolbar">
	<h3> <?php echo $model->name;?> <?php echo Yii::t('sellerFranchisee', '编辑'); ?></h3>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th width="10%"><?php echo Yii::t('sellerFranchisee', '商家名称'); ?></th>
			<td width="90%"> <?php echo $model->name;?></td>
		</tr>
		<tr>
			<th><?php echo $form->labelEx($model, 'alias_name'); ?></th>
			<td>
				<?php echo $form->textField($model, 'alias_name', array('class' => 'inputtxt1')); ?>
                <?php echo $form->error($model, 'alias_name'); ?>
			</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'gai_discount'); ?></th>
		<td><?php echo $model->gai_discount; ?>%</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'member_discount'); ?></th>
		<td><?php echo $model->member_discount; ?>%</td>
	</tr>
	<tr>
		<th class="even"><?php echo Yii::t('sellerFranchisee', '地区'); ?></th>
            <td class="even">
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('sellerFranchisee', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Franchisee_city_id").html(data.dropDownCities);
                            $("#Franchisee_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php echo $form->error($model, 'province_id'); ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('sellerFranchisee', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateArea'),
                        'update' => '#Franchisee_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($model, 'city_id'); ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('sellerFranchisee', '选择地区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($model, 'district_id'); ?> 
            </td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'street'); ?></th>
		<td>
			<?php echo $form->textField($model, 'street', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'street'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'summary'); ?></th>
		<td>
			<?php echo $form->textField($model, 'summary', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'summary'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'main_course'); ?></th>
		<td>
			<?php echo $form->textField($model, 'main_course', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'main_course'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo Yii::t('sellerFranchisee', '行业'); ?><?php echo $form->labelEx($model, 'categoryId'); ?></th>
		<td>
		<?php $categoryData = FranchiseeCategory::model()->findAll();?>
                
                <?php foreach($categoryData as $v):?>
                <input type="checkbox" name="Franchisee[categoryId][]" value="<?php echo $v->id;?>" <?php if(in_array($v->id,  Franchisee::findCategoryId($model->id))):?> checked="true" <?php endif;?>/> <?php echo $v->name;?>
                <?php endforeach;?>
            <?php echo $form->error($model, 'categoryId'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'logo'); ?><span class="required">*</span></th>
		<td>
			<p><a href="javascript:void(0);" onclick="show_upload()" class="sellerBtn02"><span><?php echo Yii::t('sellerFranchisee', '设置LOGO'); ?></span></a>
			<?php echo CHtml::activeFileField($model, 'logo',array('id'=>'upfile','style'=>'display:none;')); ?> 
			&nbsp;&nbsp;
			<a href="javascript:void(0);" class="sellerBtn02" onclick="reset_upload()"><span><?php echo Yii::t('sellerFranchisee', '重置'); ?></span></a>
			&nbsp;&nbsp;<span class="gray"><?php echo Yii::t('sellerFranchisee', '(请上传230*60像素的图片)'); ?></span></p>
			<p class="mt10">
			<?php 
			echo CHtml::hiddenField('oldLogo', $model->logo);
//            echo "<br>";
			
			echo CHtml::image(IMG_DOMAIN . DS . $model->logo, $model->name, array('width' => '120px', 'height' => '120px'));
			?>
			</p>
			
			<script>
				function show_upload(){
					$("#upfile").show();

			    }

			    function reset_upload(){
			    	$("#upfile").val('');
			    	$("#upfile").hide();
				}
			
			</script>
			
		</td>
	</tr>
	<tr>
		<th><?php echo Yii::t('sellerFranchisee', '图片列表'); ?></th>
		<td>
		
		<?php 
           $this->widget('seller.widgets.CUploadPic',array(
            	'form' => $form,
            	'model' => $model,
            	'attribute' => 'path',
//            	'upload_width' => 730,
//            	'upload_height' => 280,
            	'num' => 5,
            	'folder_name' => 'files',
           ));
      	?>
		
		
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'mobile'); ?></th>
		<td>
			<?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'mobile'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'qq'); ?></th>
		<td>
			<?php echo $form->textField($model, 'qq', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'qq'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'fax'); ?></th>
		<td>
			<?php echo $form->textField($model, 'fax', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'fax'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'zip_code'); ?></th>
		<td>
			<?php echo $form->textField($model, 'zip_code', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'zip_code'); ?>
		</td>
	</tr>
	<tr>
		<th> <?php echo Yii::t('sellerFranchisee', '盖网机');?><?php echo $form->labelEx($model, 'notice'); ?></th>
		<td>
			<?php echo $form->textArea($model, 'notice', array('class' => 'textareaTxt1','style'=>'width:330px; height:80px;')); ?>
            <?php echo $form->error($model, 'notice'); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'description'); ?></th>
		<td>
			<?php echo $form->textField($model, 'description', array('class' => 'inputtxt1','style'=>'width:330px;')); ?>
            <?php echo $form->error($model, 'description'); ?>
		</td>
		</tr>
</tbody></table>
<div class="profileDo mt15">
	<a href="#" class="sellerBtn03" onclick="javascript:$('#franchisee-form').submit();"><span style="color:white"><?php echo Yii::t('sellerFranchisee', '保存'); ?></span></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/info/')?>" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee', '返回'); ?></span></a>
</div>

<?php $this->endWidget(); ?>
