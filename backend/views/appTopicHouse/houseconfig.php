
<div class="t-sub">
<a class="regm-sub" href="javascript:history.back()">返回列表</a>                                            </div>
<?php
$this->breadcrumbs = array(Yii::t('AppTopic', '商品'), Yii::t('AppTopicHouse', '添加商品详情'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-form',
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <th><?php echo $form->labelEx($model, 'dateils'); ?></th>
            <td>
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'dateils',
                ));
                ?>
                <?php echo $form->error($model, 'dateils',false); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'label'); ?></th>
            <td>
                <?php echo $form->textField($model,'label',array('class' => 'text-input-bj long valid'));?>
                <?php echo $form->error($model, 'label',false); ?>(用"|"分割)
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?></td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>