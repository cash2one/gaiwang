<?php
/* @var $this FreightTemplateController */
/* @var $model FreightTemplate */
/* @var $addressModel StoreAddress */
/* @var $form CActiveForm */
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerFreightTemplate', '运费模版编辑'); ?></h3>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'name', array('class' => 'inputtxt1', 'style' => 'width:140px')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'store_address_id'); ?></th>
            <td>

                <?php echo $form->dropDownList($model,'store_address_id',StoreAddress::getAddressList()) ?>

                &nbsp;&nbsp;&nbsp;
                <?php echo CHtml::link(Yii::t('sellerFreightTemplate', '修改地址'), array('/seller/storeAddress'));
                ?>
                <?php echo $form->error($model, 'store_address_id'); ?>

            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'valuation_type'); ?></th>
            <td>
                <div style="line-height:16px;">
                    <?php echo $form->radioButtonList($model, 'valuation_type', FreightTemplate::valuationType(), array('separator' => ' ')); ?>
                    <?php echo $form->error($model, 'valuation_type'); ?>
                </div>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerFreightTemplate', '运送方式'); ?></th>
            <td style="padding:0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT3">
                    <tbody>
                        <tr>
                            <th width="30%"><?php echo Yii::t('sellerFreightTemplate', '运送方式'); ?></th>
                            <th width="30%"><?php echo Yii::t('sellerFreightTemplate', '启用'); ?></th>
                            <th width="40%"><?php echo Yii::t('sellerFreightTemplate', '操作'); ?></th>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('sellerFreightTemplate', '快递'); ?></td>
                            <td class="close">
                                <?php
                                $mFlag1 = in_array(FreightType::MODE_FASTMAIL, $modeArray);
                                echo !$mFlag1 ? Yii::t('sellerFreightTemplate', '否') : Yii::t('sellerFreightTemplate', '是 ').(count($modeArray)>1 ? CHtml::link(Yii::t('sellerFreightTemplate', '关闭'),'#',
                                        array('data-mode'=>FreightType::MODE_FASTMAIL,'data-id'=>$model->id)):'');
                                ?>
                            </td>
                            <td>
                                <a data-mode="<?php echo FreightType::MODE_FASTMAIL ?>" class="sellerBtn04">
                                    <span><?php echo Yii::t('sellerFreightTemplate', '运费详情'); ?></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('sellerFreightTemplate', 'EMS'); ?></td>
                            <td class="close">
                                <?php
                                $mFlag1 = in_array(FreightType::MODE_EMS, $modeArray);
                                echo !$mFlag1 ? Yii::t('sellerFreightTemplate', '否') : Yii::t('sellerFreightTemplate', '是 ').(count($modeArray)>1 ? CHtml::link(Yii::t('sellerFreightTemplate', '关闭'),'#',
                                        array('data-mode'=>FreightType::MODE_EMS,'data-id'=>$model->id)):'');
                                ?>
                            </td>
                            <td>
                                <a data-mode="<?php echo FreightType::MODE_EMS ?>" class="sellerBtn04">
                                    <span><?php echo Yii::t('sellerFreightTemplate', '运费详情'); ?></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('sellerFreightTemplate', '平邮'); ?></td>
                            <td class="close">
                                <?php
                                $mFlag1 = in_array(FreightType::MODE_SURFACEMAIL, $modeArray);
                                echo !$mFlag1 ? Yii::t('sellerFreightTemplate', '否') : Yii::t('sellerFreightTemplate', '是 ').(count($modeArray)>1 ? CHtml::link(Yii::t('sellerFreightTemplate', '关闭'),'#',
                                        array('data-mode'=>FreightType::MODE_SURFACEMAIL,'data-id'=>$model->id)):'');
                                ?>
                            </td>
                            <td>
                                <a data-mode="<?php echo FreightType::MODE_SURFACEMAIL ?>" class="sellerBtn04">
                                    <span><?php echo Yii::t('sellerFreightTemplate', '运费详情'); ?></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<?php echo CHtml::hiddenField('mode') ?>
<div class="profileDo mt15">
    <?php if(!$model->isNewRecord): ?>
    <a id="submit" class="sellerBtn03"><span><?php echo Yii::t('sellerFreightTemplate','保存'); ?></span></a>&nbsp;&nbsp;
    <?php else: ?>
        <strong><?php echo Yii::t('sellerFreightTemplate','请选择运费详情'); ?></strong>　　　
    <?php endif; ?>
    <?php echo CHtml::link('<span>'.Yii::t('sellerFreightTemplate','返回').'</span>', array('/seller/freightTemplate'), array('class' => 'sellerBtn01')); ?>
</div>
<?php $this->endWidget(); ?>

<script>
    //运费详情
    $(".sellerBtn04").click(function() {
        $("#mode").val($(this).attr('data-mode'));
        $('form').submit();
    });

    $("#submit").click(function(){
        $('form').submit();
    });
    //关闭运送方式
    $(".close a").click(function(){
        if(confirm('<?php echo Yii::t('sellerFreightTemplate','关闭操作将删除该运送方式的配置，不可恢复，是否继续？'); ?>')){
            var data = {
                YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken ?>",
                mode:$(this).attr('data-mode'),
                freightTmp:$(this).attr('data-id')
            };
            $.post("<?php echo $this->createAbsoluteUrl('/seller/freightType/close') ?>",data,function(msg){
                if(msg=='ok') document.location.reload();
            });
        }
        return false;
    });
</script>