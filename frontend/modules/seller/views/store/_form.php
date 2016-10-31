<?php
/** @var $model Store */
/** @var $this StoreController */
/** @var $form CActiveForm */
?>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerStore', '基本信息'); ?></h3>
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
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php if ($model->isNewRecord): ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'inputtxt1')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                <?php else: ?>
                    <?php echo $model->name ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'thumbnail'); ?>：
            </th>
            <td>
                <?php echo $form->fileField($model, 'thumbnail') ?>
                <?php if (!$model->isNewRecord && !empty($model->thumbnail)): ?>
                    <a class="delImgdata_thumbnail" onclick='DeletePic(this)' target="_blank">
                        <img src="<?php echo ATTR_DOMAIN . '/' . $model->thumbnail ?>" width="60" height="60"/>
                    </a>
                     <a class="deleteImg delImgdata_thumbnail" data-attr="thumbnail" data-src=<?php echo ATTR_DOMAIN . '/' . $model->thumbnail ?>>删除图片</a>
                <?php endif; ?> 
                                          （建议：宽*高: 135*45像素,小于1M）   
                <?php echo $form->error($model, 'thumbnail'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'logo'); ?>：
            </th>
            <td>
                <?php echo $form->fileField($model, 'logo') ?>
                <?php if (!$model->isNewRecord && !empty($model->logo)): ?>
                    <a class="delImgdata_logo" onclick='return _showBigPic(this)' target="_blank">
                        <img src="<?php echo ATTR_DOMAIN . '/' . $model->logo ?>" width="60" height="60"/>
                    </a>
                    <a class="deleteImg delImgdata_logo" data-attr="logo" data-src=<?php echo ATTR_DOMAIN . '/' . $model->logo ?> >删除图片</a>
                <?php endif; ?>
                                           （建议：宽*高: 295*85像素,小于1M）
                <?php echo $form->error($model, 'logo'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'slogan'); ?>：
            </th>
            <td>
                <?php echo $form->fileField($model, 'slogan') ?>
                <?php if (!$model->isNewRecord && !empty($model->slogan)): ?>
                    <a class="delImgdata_slogan" onclick='return _showBigPic(this)' target="_blank">
                        <img src="<?php echo ATTR_DOMAIN . '/' . $model->slogan ?>" width="60" height="60"/>
                    </a>
                     <a class="deleteImg delImgdata_slogan" data-attr="slogan" data-src="<?php echo ATTR_DOMAIN . '/' . $model->slogan ?>">删除图片</a>
                <?php endif; ?>
                                          （建议：宽*高: 1200*90像素,小于1M）
                <?php echo $form->error($model, 'slogan'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" class="even">
                <?php echo $form->labelEx($model, 'bg_color'); ?>
            </th>
            <td class="even">
                <?php
                $this->widget('comext.colorpicker.EColorPicker', array(
                    'model' => $model,
                    'attribute' => 'bg_color',
                    'mode' => 'selector',
                    'selector' => 'colorSelector',
                    'value' => $model->bg_color,
                    'fade' => false,
                    'slide' => false,
                    'curtain' => true,
                        )
                );
                ?>
                <?php echo $form->error($model, 'bg_color'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'referrals_id'); ?></th>
            <td>
                <?php if ($model->referrals_id): ?>
                    <?php echo $model->referrals_id ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerStore', '所在地区'); ?><b class="red">*</b></th>
            <td>
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('sellerStore', '选择省份'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Store_city_id").html(data.dropDownCities);
                            $("#Store_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('sellerStore', '选择城市'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateArea'),
                        'update' => '#Store_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('sellerStore', '选择区/县'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>


                <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'district_id'); ?> 
                    <?php echo $form->error($model, 'city_id'); ?>
                    <?php echo $form->error($model, 'province_id'); ?>

                </div>

            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'street'); ?></th>
            <td>
                <?php echo $form->textField($model, 'street', array('class' => 'inputtxt1', 'style' => 'width:340px')); ?>
                <?php echo $form->error($model, 'street'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
            <td>
                <?php if ($model->isNewRecord): ?>
                   <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt1','style' => 'width:125px')); ?>
                   <?php echo $form->error($model, 'mobile'); ?>  
                <?php else: ?>
                   <?php echo $model->mobile ?>
                   <?php echo $form->hiddenField($model, 'mobile');?>
                <?php endif; ?>
            </td>        
        </tr>
         <tr>
            <th><?php echo $form->labelEx($model, 'email'); ?></th>
            <td>
                <?php echo $form->textField($model, 'email', array('class' => 'inputtxt1', 'style' => 'width:125px')); ?>
                <?php echo $form->error($model, 'email'); ?>
                (注:<span style="color:red;">请填写店铺管理人员的联系邮箱</span>,店铺状态及新订单提醒将发到该邮箱。)
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'order_reminder'); ?></th>
            <td>
                <?php echo $form->textField($model, 'order_reminder', array('class' => 'inputtxt1', 'style' => 'width:125px;')); ?>
                &nbsp;<b class="red"><?php echo Yii::t('sellerStore', '单位：小时'); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="notice" name="not_notice" <?php if ($model->order_reminder == null) echo 'checked'; ?> />&nbsp;
                <?php echo Yii::t('sellerStore', '不通知'); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textField($model, 'keywords', array('class' => 'inputtxt1', 'style' => 'width:340px;')); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'description', array('class' => 'textareaTxt1', 'style' => 'width:80%; height:80px;')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="profileDo mt15">
    <a href="#" class="sellerBtn03" id="submitBtn">
        <span><?php echo Yii::t('sellerStore', '保存'); ?></span></a>&nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('view') ?>" class="sellerBtn01">
        <span><?php echo Yii::t('sellerStore', '返回'); ?></span></a>
</div>

<?php $this->endWidget() ?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<script>
    $(function() {
        if ($("#notice").get(0).checked) {
            $("#Store_order_reminder").attr('disabled', 'disabled').val('');
        }
    });
    $("#notice").click(function() {
        if (this.checked) {
            $("#Store_order_reminder").attr('disabled', 'disabled').val('');
        } else {
            $("#Store_order_reminder").removeAttr('disabled').val(0)
        }
    });
    $("#submitBtn").click(function() {
        $('form').submit();
    });
    $(".deleteImg").each(function() {
        $(this).click(function(){
                var detype=$(this).attr("data-attr");
                var storeId="<?php echo $model->id;?>";
                var imgsrc=$(this).attr("data-src");
                var yiicrs="<?php echo Yii::app()->request->csrfToken?>";
                var imgUrl = "<?php echo $this->createAbsoluteUrl('/seller/store/deleteImg')?>";
                $.ajax({
               	    type:"POST",
                	url:imgUrl,
                	data:{deData:detype,stord_id:storeId,imgsrc:imgsrc,YII_CSRF_TOKEN:yiicrs},
                    //dataType:'json',
                    success:function(data){
                        //成功样式的dialog弹窗提示
                        art.dialog({
                            icon: 'succeed',
                            content: data,
                            ok: true,
                            okVal:'<?php echo Yii::t('member','确定') ?>',
                            title:'<?php echo Yii::t('member','消息') ?>'
                        });
                          $(".delImgdata_"+detype).css('display','none');
                     },
                    error: function(){
                    	art.dialog({
                            icon: 'succeed',
                            content: '提交失败',
                            ok: true,
                            okVal:'<?php echo Yii::t('member','确定') ?>',
                            title:'<?php echo Yii::t('member','消息') ?>'
                        });
                     }         
             }) 
        })  
    });
    
</script>