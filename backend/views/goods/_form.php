<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goods-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr> <th class="title-th even" colspan="2" style="text-align: center;"> 商品基本信息 </th> </tr>


    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="odd">
            <?php echo $model->name; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="even">
            <?php echo $model->code; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'weight'); ?>：
        </th>
        <td class="odd">
            <?php echo $model->weight; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'size'); ?>：
        </th>
        <td class="even">
            <?php echo $model->size; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'stock'); ?>：
        </th>
        <td class="odd">
            <?php echo $model->stock; ?>
        </td>
    </tr>
     <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'stock'); ?>：
        </th>
        <td class="even">
            <?php echo $model->stock; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'brand_id'); ?>：
        </th>
        <td class="odd">
            <?php echo Brand::model()->findByPk($model->brand_id)->name; ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'category_id'); ?>：
        </th>
        <td class="even">
            <?php echo Category::model()->findByPk($model->category_id)->name; ?>
        </td>
    </tr>
    <tr>
        <th class='odd'><?php echo $form->labelEx($model, 'content'); ?></th>
        <td class='odd'>
        <?php
        $this->widget('comext.wdueditor.WDueditor', array(
            'model' => $model,
            'base_url' => '',
            'attribute' => 'content',
        ));
        ?>
     </td>
        <?php echo $form->error($model, 'content'); ?>
    </tr>  

     <tr>
        <th class='even'><?php echo $form->labelEx($model, 'thumbnail'); ?></th>
        <td class='even'>
        <?php
            echo CHtml::image(IMG_DOMAIN.'/'.$model->thumbnail, '', array('width'=>50,'height'=>50));
        ?>
      </td>
    </tr>    
    
    <tr>
        <th class='odd'>图片列表:</th>
        <td class='odd'>
             <ul class="imgList">
                <?php
                               // Tool::dump($imgModelPic);exit();
                    foreach ($imgModelPic as $p):
                        ?>
                        <li id="img_<?php echo $p->id; ?>">
                            <img src="<?php echo IMG_DOMAIN.'/'.$p->path; ?>" width="80"/>
                            <a href='javascript:uploadifyRemove("<?php echo $p->id; ?>", "img_")'>删除</a>
                            <input name="imageList[fileId][]" type="hidden" value="<?php echo $p->id; ?>">
                            <input name="imageList[file][]" type="hidden" value="<?php echo $p->path; ?>">
                        </li>
                        <?php endforeach; ?>
            </ul>
        </td>
    </tr>  
     <tr> <th class="title-th even" colspan="2" style="text-align: center;"> 重要信息 </th> </tr>
     <tr>
         <th width="120px" align="right" class="odd">
             <?php echo $form->labelEx($model, 'market_price'); ?>：
         </th>
         <td class="odd">
             <?php echo $form->textField($model,'market_price',array('class'=>'text-input-bj'))?>
             <?php echo $form->error($model, 'market_price'); ?>
         </td>
     </tr>
      <tr>
         <th width="120px" align="right" class="even">
             <?php echo $form->labelEx($model, 'gai_price'); ?>：
         </th>
         <td class="even">
             <?php echo $form->textField($model,'gai_price',array('class'=>'text-input-bj'))?>
             <?php echo $form->error($model, 'gai_price'); ?>
         </td>
      </tr>
      <tr>
          <th width="120px" align="right" class="odd">
              <?php echo $form->labelEx($model, 'price'); ?>：
          </th>
          <td class="odd">
              <?php echo $form->textField($model, 'price', array('class' => 'text-input-bj')) ?>
              <?php echo $form->error($model, 'price'); ?>
          </td>
      </tr>
       <tr>
          <th width="120px" align="right" class="even">
              <?php echo $form->labelEx($model, 'gai_income'); ?>：
          </th>
          <td class="even">
              <?php echo $form->textField($model, 'gai_income', array('class' => 'text-input-bj')) ?>%
              <?php echo $form->error($model, 'gai_income'); ?>
          </td>
      </tr>
       <tr>
          <th width="120px" align="right" class="odd">
              <?php echo $form->labelEx($model, 'return_score'); ?>：
          </th>
          <td class="odd">
              <?php echo $form->textField($model, 'return_score', array('class' => 'text-input-bj')) ?>
              <?php echo $form->error($model, 'return_score'); ?>
          </td>
      </tr>
      <tr>
          <th width="120px" align="right" class="even">
              <?php echo $form->labelEx($model, 'discount'); ?>：
          </th>
          <td class="even">
              <?php echo $form->textField($model, 'discount', array('class' => 'text-input-bj')) ?>
              <?php echo $form->error($model, 'discount'); ?>
          </td>
      </tr>
      <tr>
          <th width="120px" align="right" class="odd">
              <?php echo $form->labelEx($model, 'sign_integral'); ?>：
          </th>
          <td class="odd">
              <?php echo $form->textField($model, 'sign_integral', array('class' => 'text-input-bj')) ?>
              <?php echo $form->error($model, 'sign_integral'); ?>
          </td>
      </tr>
       <tr>
          <th width="120px" align="right" class="even">
              
          </th>
          <td class="even">
              <?php echo $form->checkBox($model, 'is_score_exchange', array('class' => 'text-input-bj')) ?>是否参加积分兑换 *
              <?php echo $form->error($model, 'is_score_exchange'); ?>
          </td>
      </tr>
      <tr>
          <th width="120px" align="right" class="odd">
              
          </th>
          <td class="odd">
              <?php echo $form->checkBox($model, 'is_publish') ?>是否发布
              <?php echo $form->error($model, 'is_publish'); ?>
          </td>
      </tr>
       <tr>
          <th width="120px" align="right" class="even">
              
          </th>
          <td class="even">
              <?php echo $form->checkBox($model, 'show') ?>是否在首页显示
              <?php echo $form->error($model, 'show'); ?>
          </td>
      </tr>
      <tr>
          <th width="120px" align="right" class="odd">
              <?php echo $form->labelEx($model, 'sort'); ?>：
          </th>
          <td class="odd">
              <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')) ?>* (数字越大在商城中排序越靠前)
              <?php echo $form->error($model, 'sort'); ?>
          </td>
      </tr>
        <tr> <th class="title-th even" colspan="2" style="text-align: center;"> 审核信息  </th> </tr>
         <tr>
          <th width="120px" align="right" class="odd">
              <?php echo $form->labelEx($model, 'status'); ?>：
          </th>
          <td class="odd">
              <?php echo $form->radioButtonList($model, 'status', array('0' => '未通过', '1' => '通过','2'=>'审核中'), array('separator' => '&nbsp;&nbsp;')) ?>
              <?php echo $form->error($model, 'status'); ?>
          </td>
      </tr>
    <tr>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotel', '新增') : Yii::t('hotel', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->

