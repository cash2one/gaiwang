<div class="border-info clearfix search-form">
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'hotel-brand-form',
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'name'); ?></th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?></td>
                <td><?php echo CHtml::submitButton(Yii::t('hotelBrand', '搜索'), array('class' => 'regm-sub')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>