<?php
/* @var $this CityshowController */
/* @var $model Cityshow */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>
<script>
    $(function(){
        $(".pic").fancybox();
        $(".pic img").css('display','inline');
    });
</script>
<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'cityshow-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
//array('class' => 'text-input-bj middle')
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center">基本信息</td>
    </tr>
	<tr>
		<th style="width:220px"><?php echo $form->labelEx($model, 'title'); ?></th>
		<td>
			<?php echo $model->title; ?>
			<?php echo $form->error($model, 'title'); ?>
		</td>
	</tr>

	<tr>
		<th><?php echo $form->labelEx($model, 'subtitle'); ?></th>
		<td>
			<?php echo $model->subtitle; ?>
			<?php echo $form->error($model, 'subtitle'); ?>
		</td>
	</tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'encode'); ?></th>
        <td>
            <?php echo $model->encode; ?>
            <?php echo $form->error($model, 'encode'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'region'); ?></th>
        <td>
            <?php echo $model->cityshowRegion->name; ?>
            <?php echo $form->error($model, 'region'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'province'); ?></th>
        <td>
            <?php echo Region::getRegionName($model->province),' ',Region::getRegionName($model->city); ?>
            <?php echo $form->error($model, 'region'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'background_img'); ?></th>
        <td>
            <?php $imgSrc= IMG_DOMAIN .'/'. $model->background_img; ?>
            <a class="pic blue" href="<?php echo $imgSrc ?>">
                <img width="80" src="<?php echo $imgSrc ?>" >
                (<?php echo Yii::t('enterprise','预览') ?>)
            </a>
            <span class="tips">注：建议上传1200*100尺寸的图片</span>
            <?php echo $form->error($model, 'background_img'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="title-th even" align="center">顶部焦点图</td>
    </tr>
    <?php foreach ($model->top_banner as $k => $v): ?>
        <tr>
            <th><?php echo $form->labelEx($model, '焦点图') . ($k + 1); ?></th>
            <td>
                <?php $imgSrc = IMG_DOMAIN . '/' . $v['ImgUrl']; ?>
                <a class="pic blue" href="<?php echo $imgSrc ?>">
                    <img width="80" src="<?php echo $imgSrc ?>">
                    (<?php echo Yii::t('enterprise', '预览') ?>)
                </a>
                <span class="tips">注：建议上传1893x460尺寸的图片</span>
                <?php echo $form->error($model, 'background_img'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, '焦点图链接').($k+1); ?></th>
            <td>
                <?php echo $v['Link'] ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" class="title-th even" align="center">主题</td>
    </tr>
    <?php if(!empty($model->themes)): ?>
    <?php foreach($model->themes as $k=> $v): ?>
    <tr>
        <th><?php echo $form->labelEx($model, '主题名称').($k+1); ?></th>
        <td>
            <?php echo $v->name; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    <tr>
        <th><?php echo $form->labelEx($model, '城市馆页面链接'); ?></th>
        <td>
            <?php echo DOMAIN.'/city/'.$model->encode; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td >
            <?php echo CHtml::link("预览",DOMAIN.'/city/preview?id='.base64_encode(Tool::authcode($model->encode,'ENCODE',DOMAIN,300)),array('class'=>'reg-sub','target'=>'_blank')) ?>
        </td>
    </tr>
    <tr>
		<th><?php echo $form->labelEx($model, 'source_type'); ?></th>
		<td>
			<?php echo $form->dropDownList($model, 'source_type', Cityshow::getSourceType()); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo $form->labelEx($model, 'status'); ?></th>
		<td>
			<?php echo $form->radioButtonList($model, 'status', Cityshow::getStatus(), array('separator' => '')); ?>
		</td>
	</tr>
    <tr>
        <th><?php echo $form->labelEx($model, '审核不通过原因'); ?></th>
        <td>
            <?php echo $form->textArea($model,'reason',array('rows'=>'3','cols'=>'20','class'=>'text-input-bj  text-area valid')); ?>
        </td>
    </tr>
	<tr>
		<th></th>
		<td colspan="2">
			<?php echo CHtml::submitButton(Yii::t('brand', '提交'), array('class' => 'reg-sub')); ?>
            <?php echo $form->error($model, 'reason'); ?>
		</td>
	</tr>
</table>

<?php $this->endWidget(); ?>
<script>
    $(":input[type='submit']").click(function () {
        var status = $("#Cityshow_status input:checked").val();
        var reason = $("#Cityshow_reason").val();
        if (status ==<?php echo $model::STATUS_NOPASS ?>) {
            if (reason == "") {
                alert("<?php echo Yii::t('cashHistory','请填写原因信息'); ?>");
                return false;
            }
        }
        return true;
    });
</script>