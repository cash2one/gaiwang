<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" cellpadding="0" cellspacing="0" class="searchT01">
        <tr>
            <th width="6%"><?php echo $form->label($model, 'member_name'); ?>：</th>
            <td width="9%"><?php echo $form->textField($model, 'member_name', array('class' => 'text-input-bj  middle', 'style' => 'width:100%')); ?></td>
            
            <th width="6%"><?php echo $form->label($model, 'gai_number'); ?>：</th>
            <td width="9%"><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle', 'style' => 'width:100%')); ?></td>
    
            <th width="6%"><?php echo $form->label($model, 'protocol_no'); ?>：</th>
            <td width="9%"><?php echo $form->textField($model, 'protocol_no', array('class' => 'text-input-bj  middle', 'style' => 'width:100%')); ?></td>

            <th width="6%"><?php echo $form->label($model, 'number'); ?>：</th>
            <td width="9%"><?php echo $form->textField($model, 'number', array('class' => 'text-input-bj  middle', 'style' => 'width:100%')); ?></td>
        </tr>
        <tr>
       		<th width="6%"><?php echo $form->label($model, 'contract_type'); ?>：</th>
            <td width="7%"><?php echo $form->dropDownList($model, 'contract_type', Contract::showType(), array('class' => 'text-input-bj ', 'style' => 'width:100%', 'prompt' => '请选择')); ?></td>

            <th width="6%"><?php echo $form->label($model, 'status'); ?>：</th>
            <td width="7%"><?php echo $form->dropDownList($model, 'status', FranchiseeContract::getConfirmStatu(), array('class' => 'text-input-bj ', 'style' => 'width:100%', 'prompt' => '请选择')); ?></td>
        	
        	<th width="6%" class='ta_c'><?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?></th>
        	<td width="1%"></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
<style>
    #yw1{width: 100px;}
    #yw2{width: 100px;}
</style>