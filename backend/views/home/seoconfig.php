<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo Yii::t('home', 'SEO配置'); ?>
            </th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'author'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'author', array('class' => 'text-input-bj', 'cols' => 60)); ?>
                <?php echo $form->error($model, 'author'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'index'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'title'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'title', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'keyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'keyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'keyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'description'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'cat'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'catTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'catTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'catTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'catKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'catKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'catKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'catDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'catDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'catDescription'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'jf'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jfTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jfTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jfTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jfKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jfKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jfKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jfDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jfDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jfDescription'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'jms'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jmsTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jmsTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jmsTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jmsKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jmsKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jmsKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'jmsDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'jmsDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'jmsDescription'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'hotel'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'hotelTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'hotelTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'hotelKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'hotelKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'hotelDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'hotelDescription'); ?>
            </td>
        </tr>
       
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'zt'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ztTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'ztTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'ztTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ztKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'ztKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'ztKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'ztDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'ztDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'ztDescription'); ?>
            </td>
        </tr>
        <!--优品汇-->
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo $form->labelEx($model, 'active'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'activeTitle'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'activeTitle', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'activeTitle'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'activeKeyword'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'activeKeyword', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'activeKeyword'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'activeDescription'); ?>
            </th>
            <td>
                <?php echo $form->textArea($model, 'activeDescription', array('class' => 'text-input-bj', 'cols' => 60)) ?>
                <?php echo $form->error($model, 'activeDescription'); ?>
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