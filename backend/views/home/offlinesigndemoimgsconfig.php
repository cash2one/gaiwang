<?php $form = $this->beginWidget('CActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); 
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    
    <tr>
        <th><?php echo $form->labelEx($model, 'license_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'license_image_demo'); ?>
            <?php if ( $model->license_image_demo): ?>
                <a href="<?php echo IMG_DOMAIN . '/' . $model->license_image_demo ?>" target="_blank">
                    <img src="<?php echo IMG_DOMAIN . '/' . $model->license_image_demo ?>" style="height:100px;width:auto" />
                </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'license_image_demo'); ?>
        </td>
    </tr>
     <tr>
        <th><?php echo $form->labelEx($model, 'tax_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'tax_image_demo'); ?>
            <?php if ( $model->tax_image_demo): ?>
                <a href="<?php echo IMG_DOMAIN . '/' . $model->tax_image_demo ?>" target="_blank">
                    <img src="<?php echo IMG_DOMAIN . '/' . $model->tax_image_demo ?>" style="height:100px;width:auto" />
                </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'tax_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'identity_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'identity_image_demo'); ?>
            <?php if ( $model->identity_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->identity_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->identity_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'identity_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'bank_permit_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'bank_permit_image_demo'); ?>
            <?php if ( $model->bank_permit_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->bank_permit_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->bank_permit_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'bank_permit_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'bank_account_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'bank_account_image_demo'); ?>
            <?php if ( $model->bank_account_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->bank_account_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->bank_account_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'bank_account_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'entrust_receiv_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'entrust_receiv_image_demo'); ?>
            <?php if ( $model->entrust_receiv_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->entrust_receiv_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->entrust_receiv_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'entrust_receiv_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'payee_identity_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'payee_identity_image_demo'); ?>
            <?php if ( $model->payee_identity_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->payee_identity_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->payee_identity_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'payee_identity_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'recommender_apply_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'recommender_apply_image_demo'); ?>
            <?php if ( $model->recommender_apply_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->recommender_apply_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->recommender_apply_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'recommender_apply_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'store_banner_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'store_banner_image_demo'); ?>
            <?php if ( $model->store_banner_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->store_banner_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->store_banner_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'store_banner_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'store_inner_image_demo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'store_inner_image_demo'); ?>
            <?php if ( $model->store_inner_image_demo): ?>
            <a href="<?php echo IMG_DOMAIN . '/' . $model->store_inner_image_demo ?>" target="_blank">
                <img src="<?php echo IMG_DOMAIN . '/' . $model->store_inner_image_demo ?>" style="height:100px;width:auto" />
            </a>
            <?php endif; ?>  
            <?php echo $form->error($model, 'store_inner_image_demo'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('brand', '提交'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>