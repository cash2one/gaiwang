<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contract-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<style type="text/css">

</style>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr> <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('Contract', '添加补充协议模板(代理版)'); ?></th></tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'type'); ?></th>
            <td>
            	<input class="text-input-bj  middle disabled" disabled='disabled' value="<?php 
            	echo Yii::t('contract',$model->type==Contract::CONTRACT_TYPE_AGENCY ? '代理版':'直营版');
            	?>" name="Contract-type-ex" id="Contract_type-ex" type="text">
                <?php echo $form->hiddenField($model, 'type', array('value' => $model->type)); ?>
                <?php echo $form->error($model, 'type'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'is_current'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'is_current', Contract::getCurrent(), array('class' => 'text-input-bj')); ?>
                <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'is_current'); ?> 
                </div>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'content'); ?></th>
            <td  id="contend_td"> 
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'width' => 890,
                    'model' => $model,
                    'attribute' => 'content',
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
                <div style="padding:15px"></div>
                <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#contend_td").mouseout(function() {
                        var str = $("#baidu_editor_0").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#Contract_content").html(str);
                        $("#Contract_content").blur();

                    });
                </script>
            </td>
        </tr>
         <tr>
            <th></th>
            <td><?php 
            	$butName = $model->isNewRecord ? '创建' : '编辑';
            	echo CHtml::submitButton(Yii::t('contract', $butName), array('class' => 'reg-sub')); 
            ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>








