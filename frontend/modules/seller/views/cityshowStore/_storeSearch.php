<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */

?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route,array('csid'=>$this->csid)),
    'method' => 'get',
        ));
?>
<div class="seachToolbar" style="margin-right: 750px">

    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('cityShow', '日期'); ?>：</th>
                <td width="30%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
                        'options' => array(
                            'dateFormat' => Yii::t('cityShow','yy-mm-dd'),
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
							'style' => 'width:35%',
                        )
                    ));
                    ?>  -  <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'end_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => Yii::t('cityShow','yy-mm-dd'),
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
							'style' => 'width:35%',
                        )
                    ));
                    ?>
                </td>
                <th width="20%"><?php echo Yii::t('cityShow', '商家查询'); ?>：
                  <select class="inputtxt1" name="type">
                      <option <?php if($this->getParam('type')==CityshowStore::TYPE_GW):?> selected=selected <?php endif;?> value="<?php echo CityshowStore::TYPE_GW?>"><?php echo Yii::t('cityShow', '商家GW号'); ?></option>
                      <option <?php if($this->getParam('type')==CityshowStore::TYPE_NAME):?> selected=selected <?php endif;?> value="<?php echo CityshowStore::TYPE_NAME?>"><?php echo Yii::t('cityShow', '商家名称'); ?></option>
                   </select>
                </th>
                <td width="18%">
                   <?php //echo $form->textField($model, 'name', array('style' => 'width:90%', 'class' => "inputtxt1")); ?>
                    <input type="text" value="<?php echo $this->getParam('name')?>" name='name' class='inputtxt1'>
                </td>       
                <td width="26%"> <?php echo CHtml::submitButton(Yii::t('cityShow', '搜索'), array('class' => 'sellerBtn06')); ?> &nbsp;&nbsp;
            </tr>
        </tbody>
    </table>

</div>
<?php $this->endWidget(); ?>