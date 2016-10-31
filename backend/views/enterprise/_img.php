<?php if(!isset($tr)): ?><tr id="<?php if(get_class($model)=='BankAccount'){echo 'bankImage';}else{echo $field;} ?>"><?php endif; ?>
    <th>
        <?php echo $model->getAttributeLabel($field); ?>：
        <?php $imgSrc= ATTR_DOMAIN .'/'. $model->$field; ?>
        <a class="pic blue" href="<?php echo $imgSrc ?>">
            <img width="80" src="<?php echo $imgSrc ?>" >
            (<?php echo Yii::t('enterprise','预览') ?>)
        </a>
    </th>
<?php if(!isset($tr)): ?></tr><?php endif; ?>