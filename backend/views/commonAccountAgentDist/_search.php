<div class="border-info clearfix">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
			'id' => 'common-account-agent-dist-form',
		)); ?>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tr>
                <td>
                    <?php echo $form->label($model,'common_account_id'); ?>：
                </td>
                <td>
                    <?php echo $form->textField($model,'common_account_id',array('class'=>'text-input-bj  least')); ?>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tr>
                <td>
                    <?php echo $form->label($model, 'dist_money'); ?>：
                </td>
                <td>
                    <?php echo $form->textField($model,'dist_money',array('class'=>'text-input-bj  least')); ?>-
                    <?php echo $form->textField($model,'endDistMoney',array('class'=>'text-input-bj  least')); ?>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tr>
                <td><?php echo $form->label($model, 'create_time'); ?></td>
                <td><?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'create_time')); ?>
                -                     
                <?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'endTime')); ?></td>
            </tr>
            
        </table>
        
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tr>
                <td><?php echo CHtml::submitButton(Yii::t('home', '搜索'), array('class' => 'reg-sub')); ?></td>
            </tr>
        </table>
        
        
        <?php $this->endWidget(); ?>
</div>
<div class="c10"></div>