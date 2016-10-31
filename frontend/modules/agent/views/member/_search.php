<?php 
    $form = $this->beginWidget('CActiveForm',array(
            'id' => 'agentmember-search-form',
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
                <?php echo Yii::t('Member','会员列表')?>(<?php echo $model->search()->totalItemCount?>)
                <?php //echo CHtml::button(Yii::t('Member','添加普通会员'),array('class'=>'btn1 btn_large13','onclick'=>"location.href='".$this->createUrl('Member/memberEdit')."'"))?>
                <?php //echo CHtml::button(Yii::t('Member','申请添加企业会员'),array('class'=>'btn1 btn_large13','onclick'=>"location.href='".$this->createUrl('Member/storeEdit')."'"))?>
            </td>
        </tr>
        <tr>
            <td colspan="8" class="table_search">
                <div class="form_search">
                    <label for="textfield">
                    </label>
                    <p><?php echo Yii::t('Member','会员名')?>：</p>
                    <?php echo $form->textField($model,'username',array('class'=>'search_box3'));?>
                    <p><?php echo Yii::t('Member','会员编码')?>：</p>
                    <?php echo $form->textField($model,'gai_number',array('class'=>'search_box3'));?>
                    <p><?php echo Yii::t('Member','手机号')?>：</p>
                    <?php echo $form->textField($model,'mobile',array('class'=>'search_box3'));?>
                    <?php echo CHtml::submitButton('',array('class'=>'search_button3'))?>
                </div>
            </td>
        </tr>
    </table>

<?php $this->endWidget();?>