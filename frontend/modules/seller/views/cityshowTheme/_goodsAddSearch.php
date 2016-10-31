<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */

?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route,array('csid'=>$this->csid,'tid'=>$tid)),
    'method' => 'get',
        ));
?>
<div class="seachToolbar">

    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
               <th width="10%"><?php echo Yii::t('cityShow', '商家查询'); ?>：</th>
                <td width="12%">
                 <select class="inputtxt1" name="storeType">
                      <option <?php if($this->getParam('storeType')==1): ?> selected=selected <?php endif;?> value="1"><?php echo Yii::t('cityShow', '商家名称'); ?></option>
                      <option <?php if($this->getParam('storeType')==2): ?> selected=selected <?php endif;?> value="2"><?php echo Yii::t('cityShow', '商家GW号'); ?></option>
                   </select>
                    <input type="text"  class="inputtxt1" name="storeName" value="<?php echo $this->getParam('storeName');?>">
                </td>       
               </tr>
               <tr> 
                <th width="10%"><?php echo Yii::t('cityShow', '商品查询'); ?>：</th>
                <td width="12%">
                  <select class="inputtxt1" name="goodsType">
                      <option <?php if($this->getParam('goodsType')==1): ?> selected=selected <?php endif;?> value="1"><?php echo Yii::t('cityShow', '商品ID'); ?></option>
                      <option <?php if($this->getParam('goodsType')==2): ?> selected=selected <?php endif;?> value="2"><?php echo Yii::t('cityShow', '商品名称'); ?></option>
                   </select>                  <input type="text"  class="inputtxt1" name="goodsName" value="<?php echo $this->getParam('goodsName');?>">
                </td>       
                <td width="26%"> <?php echo CHtml::submitButton(Yii::t('cityShow', '搜索'), array('class' => 'sellerBtn06')); ?> &nbsp;&nbsp;
            </tr>
        </tbody>
    </table>

</div>
<?php $this->endWidget(); ?>