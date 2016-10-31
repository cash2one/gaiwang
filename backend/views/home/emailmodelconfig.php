<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
  <script type="text/javascript" src="/js/EMSwitchBox.js"></script>
    <script type="text/javascript">
 $(document).ready(
     function () {
         $('.show-checkbox').EMSwitchBox({ onLabel: '开', offLabel: '关' });
     });
    </script>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
<!--        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
        <?php echo Yii::t('home', '邮件模板配置'); ?>
            </th>
        </tr>-->

        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'shop'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'kdtheme'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'kdtheme', array('class' => 'text-input-bj ', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'kdtheme'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'kdcontent'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'kdcontent', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'kdcontent'); ?>
            </td>
        </tr>      
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'order'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'xdtheme'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'xdtheme', array('class' => 'text-input-bj ', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'xdtheme'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'xdcontent'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'xdcontent', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'xdcontent'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'verdifyEmail'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'esubject'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'esubject', array('class' => 'text-input-bj ', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'esubject'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'econtent'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'econtent', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'econtent'); ?>
            </td>
        </tr> 
           <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'isRedis');?>
                </th>
                <td>
                   <?php echo $form->checkBox($model,'isRedis',array('class' => 'show-checkbox'))?>
                    <?php echo $form->error($model,'isRedis');?>
                </td>
            </tr>
        <tr>
            <th></th>
            <td>
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
