<?php
/** 经营类目
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2014/12/19
 * Time: 18:31
 */
/** @var $enterprise Enterprise */
/** @var $enterpriseData EnterpriseData */
/** @var $form CActiveForm */
if(!$enterprise->isNewRecord){
    $log = Yii::app()->db->createCommand()->select('error_field')->from('{{enterprise_log}}')->where('id='.$enterprise->last_log_id)->queryScalar();
}
?>
    <script>
        $(function(){
            var errorField = "<?php echo $log; ?>";
            if($.trim(errorField).length>0){
                errorField = errorField.split(',');
                for(var i=0;i<errorField.length;i++){
                    $("#"+errorField[i]).children().attr('style','background:orange !important;');
                }
            }
        })
    </script>
    <tr>
        <td height="50" align="center" class="dtffe" colspan="3">
            <b>
                <?php echo Yii::t('enterpriseData','经营类目信息') ?>
            </b>
        </td>
    </tr>
    <tr id="category_id">
        <td width="140" height="25" align="center" class="dtEe">
            <?php echo $form->labelEx($store, 'category_id') ?>：
        </td>
        <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
            <?php
            $category = Category::getTopCategory();
            echo $form->radioButtonList($store, 'category_id', CHtml::listData($category, 'id', 'name'),
                array(
                    'class' => 'checkboxItem',
                    'separator' => '&nbsp;',
                    'template' => '<span>{input} {label}</span>',
                )) ?>
            <?php echo $form->error($store, 'category_id') ?>
        </td>
    </tr>

<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'threec_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'cosmetics_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'food_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'jewelry_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <tr>
        <td width="140" height="25" align="center" class="dtEe">
            <?php echo $form->labelEx($enterpriseData, 'exists_imported_goods') ?>：
        </td>
        <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
            <?php
            if($enterpriseData->isNewRecord) $enterpriseData->exists_imported_goods = EnterpriseData::EXISTS_IMPORTED_GOODS_NO;
            ?>
            <?php echo $form->radioButtonList($enterpriseData,'exists_imported_goods',EnterpriseData::existsImportedGoods(),array('separator'=>' ')) ?>
        </td>
    </tr>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'declaration_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'report_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
<?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'brand_image', 'form' => $form)); ?>