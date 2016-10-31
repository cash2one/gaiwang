<?php
	$form = $this->beginWidget('CActiveForm', array(
	    'id' => $this->id . '-form',
	    'enableAjaxValidation' => true,
	    'enableClientValidation' => true,
	    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	    'clientOptions' => array(
	        'validateOnSubmit' => true,
	    ),
	));
	Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/plugins/iframeTools.js',CClientScript::POS_END);
?>
<style>
/*图片上传按钮样式*/
.regm-sub{ border:1px solid #ccc; background: #fff; padding: 5px; border-radius: 3px; cursor: pointer; }			
</style>
<?php if ($model->isNewRecord) {?>
<script type='text/javascript'>
//显示盖惠券
function showCoupon(){
	var couponPrice = $('#CouponActivity_price').val() == '' ? '' : $('#CouponActivity_price').find("option:selected").text();
	var couponCondition = $('#CouponActivity_condition').val() == '' ? '' : $('#CouponActivity_condition').find("option:selected").text();
	var couponStartData = $('#CouponActivity_valid_start').val();
	var couponEndData = $('#CouponActivity_valid_end').val();
	var couponThumbnail = $('#CouponActivity_thumbnail').val();

	$('#couponThumbnail')[0].src = couponThumbnail == '' ? '#' : '<?php echo IMG_DOMAIN.'/'?>' + couponThumbnail;
	$('#couponPrice')[0].textContent = couponPrice == '' ? '0' : couponPrice;
	$('#couponCondition')[0].textContent = couponCondition == '' ? '<?php echo Yii::t('Public', '购满0使用')?>' : '<?php echo Yii::t('Public','购满')?>'+couponCondition+'<?php echo Yii::t('Public','使用')?>';

	var couponDate = couponStartData == '' ? '' : couponStartData.substring(5);
	couponDate = couponEndData == '' ? couponDate : couponDate + '-' + couponEndData.substring(5);
	$('#couponDate')[0].textContent = couponDate == '' ? '<?php echo Yii::t('Public', '不限时')?>' : couponDate;
}

//检查图片JS
function checkThumbnail(){
	var couponThumbnail = $('#CouponActivity_thumbnail').val();
	if (couponThumbnail != '' ) $('#couponThumbnail')[0].src = '<?php echo IMG_DOMAIN.'/'?>' + couponThumbnail;
}

setInterval('checkThumbnail()',1000);
</script>
<?php }?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width=12%><?php echo $form->labelEx($model, 'name'); ?></th>
            <td width=75%>
            	<?php if ($model->isNewRecord) {?>
					<?php echo $form->textField($model, 'name', array('class' => 'inputtxt1', 'style' => 'width:300px' ,'onchange' => 'showCoupon()')); ?>
					<?php echo $form->error($model, 'name'); ?>
				<?php } else {?>
					<?php echo $model->name;?>
				<?php }?>
            </td>
            <td rowspan=7>
            	<?php if ($model->isNewRecord) {?>
            	<ul class="content">
            		<li>
						<i class="icon_v"></i>
						<a class="img" href="javascript:;">
							<img id="couponThumbnail" width="225" height="225" alt="" src="#">
							<span class="name"><?php echo $this->getUser()->name; ?></span>
						</a>
						<div class="clearfix">
							<div class="txt">
								<p class="price">￥<i id="couponPrice">0</i></p>
								<p class="condi" id="couponCondition"><?php echo Yii::t('Public', '购满0使用')?></p>
							</div>
							<div class="do">
								<a class="icon_v_h btnReceive" href="javascript:;"><?php echo Yii::t('Public', '立即领取')?></a>
								<p class="period" id="couponDate"><?php echo Yii::t('Public', '不限时')?></p>
							</div>
						</div>
					</li>
				</ul>
				<?php } else {?>
				<ul class="content">
            		<li>
						<i class="icon_v"></i>
						<a class="img" href="javascript:;">
							<img width="225" height="225" alt="" src="<?php echo IMG_DOMAIN.'/'.$model->thumbnail?>">
							<span class="name"><?php echo $this->getUser()->name; ?></span>
						</a>
						<div class="clearfix">
							<div class="txt">
								<p class="price">￥<i><?php echo $model->price?></i></p>
								<p class="condi" ><?php echo Yii::t('Public','购满') . $model->condition . Yii::t('Public','使用')?></p>
							</div>
							<div class="do">
								<a class="icon_v_h btnReceive" href="javascript:;"><?php echo Yii::t('Public', '立即领取')?></a>
								<p class="period"><?php echo date('m-d', $model->valid_start). '-' . date('m-d', $model->valid_end)?></p>
							</div>
						</div>
					</li>
				</ul>
				<?php }?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'price'); ?></th>
            <td>
	            <?php if ($model->isNewRecord) {?>
	                <?php
		                echo $form->dropDownList($model, 'price', CouponActivity::getCouponPrice(), 
		                		array(
				                    'prompt' => Yii::t('sellerCouponActivity', '选择面值'),
				                    'class' => 'selectTxt1',
		                			'onchange' => 'showCoupon()',
			                	)
	                		);
	                ?>
                	<?php echo $form->error($model, 'price'); ?>
                <?php } else {?>
					<?php echo '<b>' . CouponActivity::getCouponPrice((int)$model->price) . '</b> ' . Yii::t('sellerCouponActivity', '元');?>
				<?php }?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'condition'); ?>：</th>
            <td>
            	<?php echo Yii::t('sellerCouponActivity','单笔订单中此盖惠券的指定商品金额值满').' '?>
            	<?php if ($model->isNewRecord) {?>
	                <?php 
	                	echo $form->dropDownList($model, 'condition', CouponActivity::getCouponCondition(), 
		                		array(
				                    'prompt' => Yii::t('sellerCouponActivity', '选择使用条件'),
				                    'class' => 'selectTxt1',
		                			'onchange' => 'showCoupon()',
			                	)
	                		); 
					?>    
                	<?php echo $form->error($model, 'condition'); ?>
                <?php } else {?>
					<?php echo '<b>' . CouponActivity::getCouponCondition((int)$model->condition) . '</b> '  . Yii::t('sellerCouponActivity', '元');?>
				<?php }?>
            </td>
        </tr>
        <tr>
        	<th><?php echo $form->labelEx($model, 'valid_start');?>：</th>
			<td width="20%">
				<?php if ($model->isNewRecord) {?>
					<?php
	                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                        'model' => $model,
	                        'attribute' => 'valid_start',
	                        'language' => 'zh_cn',
	                        'options' => array(
	                            'dateFormat' => 'yy-mm-dd',
	                            'changeMonth' => true,
	                        ),
	                        'htmlOptions' => array(
	                            'readonly' => 'readonly',
	                            'class' => 'inputtxt1',
	                            'style' => 'width:10%',
	                            'onchange' => 'showCoupon()',
	                        )
	                    ));
					?>
					&nbsp;-
					<?php
	                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                        'model' => $model,
	                        'attribute' => 'valid_end',
	                        'language' => 'zh_cn',
	                        'options' => array(
	                            'dateFormat' => 'yy-mm-dd',
	                            'changeMonth' => true
	                        ),
	                        'htmlOptions' => array(
	                            'readonly' => 'readonly',
	                            'class' => 'inputtxt1',
	                            'style' => 'width:10%',
	                    		'onchange' => 'showCoupon()',
	                        )
	                    ));
					?>
					<?php echo $form->error($model, 'valid_start'); ?>
					<?php echo $form->error($model, 'valid_end'); ?>
				<?php } else {?>
					<?php echo date('Y-m-d', $model->valid_start) . ' 至 ' . date('Y-m-d', $model->valid_end);?>
				<?php }?>
			</td>
		</tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sendout'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sendout', array('class' => 'inputtxt1')); ?>
                <?php echo $form->error($model, 'sendout'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'start_time'); ?></th>
            <td>
            	<?php if ($model->isNewRecord) {?>
                <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'start_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'style' => 'width:10%',
                        )
                    ));
				?>
                <?php echo $form->error($model, 'start_time'); ?>
                <?php } else {?>
                <?php echo date('Y-m-d', $model->start_time);?>
				<?php }?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'thumbnail'); ?>：
            </th>
            <td>
            	<?php if ($model->isNewRecord) {?>
		            <?php
			            $this->widget('seller.widgets.CUploadPic', array(
			                'attribute' => 'thumbnail',
			                'model'=>$model,
			                'form'=>$form,
			                'btn_value'=> Yii::t('sellerGoods', '上传图片'),
			                'render' => '_upload',
			                'folder_name' => 'coupon',
			                'include_artDialog'=>false,
			            ));
		            ?>
		            <?php echo $form->error($model,'thumbnail') ?>
		            &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods','注：支持JPG、GIF、PNG格式的图片，大小不能超过1M'); ?>)</span>
	            <?php } else {?>
					<?php 
						$imgs = explode('/',$model->thumbnail);
						echo $imgs[count($imgs)-1];
					?>
				<?php }?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerCouponActivity','盖惠券创建情况'); ?>：</th>
            <td colspan=2>
            	<?php echo Yii::t('sellerCouponActivity','盖网授权总派发金额').'：￥'.$model->gaiMoney?>,&nbsp;&nbsp;&nbsp;&nbsp;
            	<?php echo Yii::t('sellerCouponActivity','目前我所创建的盖惠券金额').'：￥'.$model->shopMoney?>
            	</td>
        </tr>
    </tbody>
</table>
<div class="profileDo mt15">
	<?php echo CHtml::submitButton(Yii::t('sellerCouponActivity','确定'),array('class'=>'sellerBtn06'))?>&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::link('<span>'.Yii::t('Public','返回').'</span>',array('index'),array('class'=>'sellerBtn01'))?>
</div>

<?php $this->endWidget() ?>
