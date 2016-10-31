<?php
/* @var $this Goods */
/* @var $model Goods */
/* @var $form CActiveForm */
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
));
?>

<div class="seachToolbar">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
        <tr>
            <th width="7%" class="ta_r"><?php echo $form->label($model,'name'); ?>：</th>
            <td width="18%">
            <?php echo $form->textField($model,'name',array('class'=>'inputtxt1','style'=>'width:90%')); ?>
            </td>
            <th width="7%"><?php echo $form->label($model,'price'); ?>：</th>
            <td width="13%">
                <input type="text" style="width:30%;" name="price_start" value="<?php echo Yii::app()->request->getParam('price_start')?>" class="inputtxt1"/>&nbsp;-&nbsp;
                <input type="text" style="width:30%;" name="price_end" value="<?php echo Yii::app()->request->getParam('price_end')?>" class="inputtxt1"/>
            </td>
            <th width="7%"><?php echo $form->label($model,'stock'); ?>：</th>
            <td width="13%">
                <input type="text" style="width:30%;" name="stock_start" value="<?php echo Yii::app()->request->getParam('stock_start')?>" class="inputtxt1"/>&nbsp;-&nbsp;
                <input type="text" style="width:30%;" name="stock_end" value="<?php echo Yii::app()->request->getParam('stock_end')?>" class="inputtxt1"/>
            </td>
            <th width="7%"><?php echo $form->label($model,'gai_price'); ?>：</th>
            <td width="13%">
                <input type="text" style="width:30%;" name="gai_price_start" value="<?php echo Yii::app()->request->getParam('gai_price_start')?>" class="inputtxt1"/>&nbsp;-&nbsp;
                <input type="text" style="width:30%;" name="gai_price_end" value="<?php echo Yii::app()->request->getParam('gai_price_end')?>" class="inputtxt1"/>
            </td>
            <th width="7%"><?php echo $form->label($model,'id'); ?>：</th>
            <td width="13%">
                <?php echo $form->textField($model,'id',array('class'=>'inputtxt1','style'=>"width:80%;")); ?>
            </td>
        </tr>
        <tr>
            <th class="ta_r"><?php echo Yii::t('sellerGoods','参与活动名称'); ?>：</th>
            <td>
                <?php echo $form->textField($model,'categoryName',array('class'=>'inputtxt1','style'=>"width:90%;")); ?>
            </td>
                <th class="ta_r"><?php echo Yii::t('sellerGoods','活动类型'); ?>：</th>
            <td>
                <?php $active = SeckillCategory::getCategory();?>
                <?php echo $form->dropDownList($model, 'active_category', $active,array(
                    'empty'=>Yii::t('sellerGoods','全部'),
                    'separator'=>' ',
                    'class'=>'inputtxt1'
                ))?>
            </td>
            <th><?php echo $form->label($model,'status'); ?>：</th>
            <td colspan="2">
                <?php echo $form->radioButtonList($model,'status',$model::getStatus(),array(
                    'empty'=>Yii::t('sellerGoods','全部'),
                    'separator'=>' '
                )) ?>
            </td>
            <th  class="ta_r"><?php echo Yii::t('sellerGoods','是否上架'); ?>：</th>
            <td colspan="4">
                <?php echo $form->radioButtonList($model,'is_publish',$model::publishStatus(),array( 'separator'=>' ','empty'=>Yii::t('sellerGoods','全部'))) ?>
            </td>
        </tr>
        <tr>
            <th><?php echo '活动审核状态'; ?>：</th>
            <td colspan="6">
                <?php echo $form->radioButtonList($model, 'active_status', SeckillProductRelation::showStatus(),array(
                    'empty'=>Yii::t('sellerGoods','全部'),
                    'separator'=>' '
                )) ?>
            </td>
            <td>
                <?php echo CHtml::submitButton(Yii::t('sellerGoods','搜索'),array('class'=>'sellerBtn06')) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>