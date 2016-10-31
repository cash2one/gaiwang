<?php
/* @var $this RegionController */
/* @var $model Region */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'region-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<script src="/js/iframeTools.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php if ($model->isNewRecord): ?>
                    <?php echo Yii::t('region', '添加地区'); ?>
                <?php else: ?>
                    <?php echo Yii::t('region', '修改地区'); ?>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'parentName'); ?></th>
            <td>
                <?php if ($model->isNewRecord): ?>
                    <?php echo $form->hiddenField($model, 'parent_id'); ?>
                <?php endif; ?>
                <?php echo CHtml::textField('Region[parentName]', Region::getRegionName($model->parent_id), array('id' => 'parentName', 'readonly' => 'true', 'class' => 'text-input-bj  least')) ?>
                <?php if ($model->isNewRecord): ?>
                    <?php echo CHtml::button(Yii::t('region', '选择父级'), array('id' => 'searchRegion', 'class' => 'regm-sub')); ?>
                    <?php echo $form->error($model, 'parentName'); ?>
                    <?php Yii::app()->clientScript->registerScript('categoryTree', "
			var dialog = null;
			jQuery(function($) {
			    var url = '" . $this->createAbsoluteUrl('/region/regionTree') . "';
			    $('#searchRegion').click(function() {
			        dialog = art.dialog.open(url, {'id': 'searchRegion', title: '地区', width: '400px', height: '400px', lock: true});
			    })
			})
			var onSelectedCat = function(id, name) {
			    $('#parentName').val(name);
				$('#Region_parent_id').val(id);
			};
			var doClose = function() {
			    if (null != dialog) {
			        dialog.close();
			    }
			};
			", CClientScript::POS_HEAD);
                    ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'pinyin'); ?></th>
            <td>
                <?php echo $form->textField($model, 'pinyin', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'pinyin'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('region', '经纬度'); ?></th>
            <td>
                <?php echo $form->labelEx($model, 'lat'); ?>
                <?php echo $form->textField($model, 'lat', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->labelEx($model, 'lng'); ?>
                <?php echo $form->textField($model, 'lng', array('class' => 'text-input-bj  middle')); ?>
                <?php echo CHtml::button(Yii::t('region', '选择经纬度'), array('class' => 'regm-sub', 'onclick' => 'markClick()')); ?>
                <?php echo $form->error($model, 'lng'); ?>
                <?php echo $form->error($model, 'lat'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'zip_code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'zip_code', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'zip_code'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'phone_code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'phone_code', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'phone_code'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile_code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'mobile_code', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'mobile_code'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj', 'cols' => 50)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('map', '新增') : Yii::t('map', '保存'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript">
    var markClick = function() {
        var url = '<?php echo $this->createAbsoluteUrl('/map/show') ?>';
        url += '&lng=' + $('#Region_lng').val() + '&lat=' + $('#Region_lat').val();
        dialog = art.dialog.open(url, {
            'title': '设定经纬度',
            'lock': true,
            'window': 'top',
            'width': 740,
            'height': 670,
            'border': true
        });
    };
    var onSelected = function(lat, lng) {
        $('#Region_lng').val(lng);
        $('#Region_lat').val(lat);
    };
    var doClose = function() {
        if (null != dialog) {
            dialog.close();
        }
    };
</script>
