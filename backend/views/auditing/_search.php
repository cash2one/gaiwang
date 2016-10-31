<div class="border-info clearfix">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
			'id' => 'auditing-form',
		)); ?>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tr>
                <td>
                    <?php echo Yii::t('auditing', '加盟商名称'); ?>：
                </td>
                <td>
                    <?php echo $form->textField($model,'apply_name',array('class'=>'text-input-bj  least')); ?>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tr>
                <td>
                    <?php echo Yii::t('auditing', '申请会员编号'); ?>：
                </td>
                <td>
                    <?php echo $form->textField($model,'author_name',array('class'=>'text-input-bj  least')); ?>
                </td>
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