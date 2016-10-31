<?php 
    $form = $this->beginWidget('CActiveForm',array(
            'id' => 'agentMaintenance-search-form',
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
        )
    );
?>
<style>
    .search_button3{float:'';display:inline;}
</style>
<table width="100%" cellspacing="0" cellpadding="0" class="table1">
        <tr class="table1_title">
            <td colspan="11">
                <?php echo Yii::t('AgentMaintenance','运维人员列表')?>(<?php echo $model->search()->totalItemCount?>)
<!--                --><?php //echo CHtml::button(Yii::t('AgentMaintenance','绑定运维人员'),array('id'=>'bindMember','class'=>'btn1 btn_large13','onclick'=>"location.href='".$this->createUrl('AgentMaintenance/create')."'"))?>
                <?php echo CHtml::button(Yii::t('AgentMaintenance','绑定运维人员'),array('id'=>'bindMember','class'=>'btn1 btn_large13'))?>
            </td>
        </tr>
        <tr>
            <td colspan="8" class="table_search">
                <div class="form_search">
                    <label for="textfield">
                    </label>
                    <p><?php echo $form->label($model,'GWnumber')?>：</p>
                    <?php echo $form->textField($model,'GWnumber',array('class'=>'search_box3'));?>
                    <p><?php echo $form->label($model,'username')?>：</p>
                    <?php echo $form->textField($model,'username',array('class'=>'search_box3'));?>
                    <p><?php echo $form->label($model,'mobile')?>：</p>
                    <?php echo $form->textField($model,'mobile',array('class'=>'search_box3'));?>
                    <?php echo CHtml::submitButton(Yii::t('Public', '搜索'), array('class'=>'button_04','style'=>'margin-left: 40px;')); ?>
                </div>
            </td>
        </tr>
    </table>

<?php $this->endWidget();?>