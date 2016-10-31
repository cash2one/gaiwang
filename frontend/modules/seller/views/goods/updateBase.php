<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
$title = Yii::t('sellerGoods', '商品基本信息编辑');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '宝贝管理') => array('index'),
    $title,
    );
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/plugins/iframeTools.js',CClientScript::POS_END);
?>
<style>
    .regm-sub{
        border:1px solid #ccc;
        background: #fff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
<div class="toolbar">
    <b><?php echo Yii::t('sellerGoods','商品基本信息编辑'); ?></b>
    <span><?php echo $model->name ?>   <?php echo Yii::t('sellerGoods','编辑'); ?></span>
</div>

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
    <div class="proAddStepTwo">
        <h3 class="title"><?php echo Yii::t('sellerGoods','基本信息'); ?></h3>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
            <tr>
                <th><?php echo $form->labelEx($model,'category_id'); ?></th>
                <td>
                    <?php echo $form->hiddenField($model,'category_id') ?>
                    <?php

                    // Tool::p($seckillData);exit;
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'homeLink' => false,
                        'separator' => ' > ',
                        'links' => Tool::categoryBreadcrumb($model->category_id),
                        'activeLinkTemplate'=>'<a href="{url}" class="">{label}</a>',
                        ));
                    if($model['seckill_seting_id'] > 0 ){
                     $seckillData = ActivityData::getActivityRulesSeting($model['seckill_seting_id']);
                     if(strtotime($seckillData['end_dateline']) <= time()){
                        echo CHtml::link(Yii::t('sellerGoods', '编辑'), $this->createUrl('selectCategory',array('id'=>$model->id)));
                    }
                }else{
                    echo CHtml::link(Yii::t('sellerGoods', '编辑'), $this->createUrl('selectCategory',array('id'=>$model->id)));
                }
                ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model,'id'); ?></th>
            <td width="90%">
                <?php echo $model->id ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model,'name'); ?></th>
            <td width="90%">
                <?php if($model->status==$model::STATUS_PASS): ?>
                <?php echo $form->textField($model,'name',array('class'=>'inputtxt1','style'=>'width:340px','readOnly'=>'readOnly')); ?>(注意：审核通过的商品不能再修改)
                <?php else: ?>
                    <?php echo $form->textField($model,'name',array('class'=>'inputtxt1','style'=>'width:340px')); ?>
                <?php endif; ?>
                <?php echo $form->error($model,'name') ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model,'labels'); ?></th>
            <td width="90%">
                <?php echo $form->textField($model,'labels',array('class'=>'inputtxt1','style'=>'width:340px')); ?>
                <?php echo Yii::t('sellerGoods', '该标签用于SEO优化,建议填写四个且标签之间用空格分开'); ?>
                <?php echo $form->error($model,'labels') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'code'); ?></th>
            <td>
                <?php echo $form->textField($model,'code',array('class'=>'inputtxt1','style'=>'width:125px')); ?>
                <?php echo $form->error($model,'code') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'weight'); ?></th>
            <td>
                <?php echo $form->textField($model,'weight',array('class'=>'inputtxt1','style'=>'width:125px')); ?>
                <?php echo $form->error($model,'weight') ?>
                &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods','单位为kg,只保留两位小数'); ?></span>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'size'); ?></th>
            <td>
                <?php echo $form->textField($model,'size',array('class'=>'inputtxt1','style'=>'width:125px')); ?>
                <?php echo $form->error($model,'size') ?>
                &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods','单位为m³,只保留两位小数'); ?>)</span>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'stock'); ?></th>
            <td>
                <?php echo $form->textField($model,'stock',array('class'=>'inputtxt1','style'=>'width:125px')); ?>
                <?php echo $form->error($model,'stock') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'brand_id'); ?></th>
            <td>
                <?php
                echo $form->hiddenField($model, 'brand_id');
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'brand_name',
                    'source' => $this->createAbsoluteUrl('/seller/goods/suggestBrands'),
                    'htmlOptions' => array('size' => 20, 'style' => '', 'class' => 'inputtxt1','id'=>'brand_id','value'=>!$model->brand_id ? '' : $model->brand->name),
                    'options' => array(
                        'minLength'=>'1',
                        'select' => 'js:function( event, ui ) {
                            $("#Goods_brand_id").val( ui.item.id );
                            return true;
                        }',
                        'change'=>'js:function(event, ui ){
                            if(ui.item==null){
                                $("#Goods_brand_id").val("");
                            }
                        }',
                        ),
                    ));
                    ?>(<?php echo Yii::t('sellerGoods', '只要输入品牌关键词就会自动关联出此店铺的相关品牌，如没有请创建'); ?>)
                    <?php echo $form->error($model,'brand_id') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:0;">
                    <!--颜色、尺码、库存-->
                    <?php

                    $this->renderPartial('_updateSpec',array(
                        'model'=>$model,
                'spec' => $spec, //规格值数据,给视图中的循环选择规格用,
                'typeSpec' => $typeSpec,
                'goodsSpec'=>$goodsSpec
                ))

                ?>
                <div class="spec-tips" style="height:25px; border:solid 1px #e1e1e1; overflow: hidden; clear: both; margin-left: 10px;"><span><?php echo Yii::t('sellerGoods','您需要选择所有的销售属性,才能组合成完整的规格信息.')?></span></div>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model,'scategory_id'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'scategory_id',
                    Scategory::model()->showAllSelectCategory($this->getSession('storeId'), Yii::t('category',Scategory::SHOW_SELECT)),
                    array('class'=>'selectTxt1')
                    ); ?>
                    <?php echo $form->error($model, 'scategory_id'); ?>
                </td>
            </tr>
            <tr>
                <th><b class="red">*</b><?php echo Yii::t('sellerGoods','描述（请上传宽度为750像素的图片）'); ?>：</th>
                <td>
                    <?php
                    $this->widget('ext.editor.WDueditor', array(
                        'model' => $model,
                        'base_url' => 'http://seller.'.SHORT_DOMAIN,
                        'attribute' => 'content',
                'save_path' => 'uploads/files', //默认是'attachments/UE_uploads'
                'url' => IMG_DOMAIN . '/files' //默认是ATTR_DOMAIN.'/UE_uploads'
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model,'thumbnail'); ?></th>
            <td>
                <?php
                $this->widget('seller.widgets.CUploadPic', array(
                    'attribute' => 'thumbnail',
                    'model'=>$model,
                    'form'=>$form,
                    'num' => 1,
                    'btn_value'=> Yii::t('sellerGoods', '封面图片'),
                    'render' => '_upload',
                    'folder_name' => 'files',
                    'include_artDialog'=>false,
                    ));
                    ?>
                    <?php echo $form->error($model, 'thumbnail'); ?>
                    &nbsp;<span class="gray" style="color:red;">(<?php echo Yii::t('sellerGoods','请上传750*750像素的图片，更新前请点击"X"先删除旧图片'); ?>)</span>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($imgModel,'path'); ?></th>
                <td>
                    <?php
                    $this->widget('seller.widgets.CUploadPic', array(
                        'attribute' => 'path',
                        'model'=>$imgModel,
                        'form'=>$form,
                        'num' => 6,
                        'btn_value'=> Yii::t('sellerGoods', '上传图片'),
                        'render' => '_upload',
                        'folder_name' => 'files',
                        'include_artDialog'=>false,
                        ));
                        ?>
                        <?php echo $form->error($imgModel,'path') ?>
                        &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods','请上传750*750像素的图片'); ?>)</span>
                    </td>
                </tr>
                <tr>
                    <th><?php echo Yii::t('sellerGoods','商品属性'); ?></th>
                    <td>
                        <?php foreach ($attribute as $v): ?>
                            <div class="row">
                                <label><?php echo $v['name'] ?>:</label>
                                <select  name="attr[<?php echo $v['id'] ?>]">
                                    <?php foreach ($v->attributeData as $v2): ?>
                                        <option value="<?php echo $v2->id ?>"
                                            <?php echo $this->checkAttribute($model->attribute,$v['id'],$v2->name)?'selected':null ?> >
                                            <?php echo $v2->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model,'status'); ?></th>
                    <td>
                        <?php echo $model::getStatus($model->status); ?>
                        <span class="red"><?php echo Yii::t('sellerGoods','（当商品审核不通过时，再次提交会更新商品状态为“审核中”）'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model,'views'); ?></th>
                    <td>
                        <?php echo $model->views; ?>
                    </td>
                </tr>

            </table>

            <h3 class="title"><?php echo Yii::t('sellerGoods','SEO优化搜索信息'); ?></h3>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">

                <tr>
                    <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 128, 'class' => 'inputtxt1', 'style' => 'width:615px')); ?>
                    </td>
                </tr>
                <tr>
                    <th> <?php echo $form->labelEx($model, 'description'); ?></th>
                    <td>
                        <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 5)); ?>
                    </td>
                </tr>
            </table>
            <div class="next">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerGoods','提交') : Yii::t('sellerGoods','保存'),
                array('class' => 'sellerBtn06','id'=>'submitBtn')); ?>　　　
                <a href="<?php echo $this->createAbsoluteUrl('goods/index') ?>" class="sellerBtn01"><span><?php echo Yii::t('sellerGoods','返回')?></span></a>
            </div>
            <?php $this->endWidget(); ?>

            <script type="text/javascript">
                commonData = {
                    skuTips:"<?php echo Yii::t('sellerGoods', '请完善库存配置输入！'); ?>",
                    selectTips:"<?php echo Yii::t('sellerGoods', '请完善商品规格选择，如：图片，颜色'); ?>"
                };
            </script>
            <script type="text/javascript" src="<?php echo DOMAIN ?>/js/sellerGoods.js"></script>
