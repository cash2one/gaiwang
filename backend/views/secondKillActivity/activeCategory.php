<?php
/* @var $this SecondKillActivityController */
/* @var $model SecKillRulesSeting */
/* @var $form CActiveForm */

$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    )
));
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
        <tr>
            <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', '商品类别选择'); ?></th>
        </tr>
        <tr>
            <th><?php echo Yii::t('secondKillActivity','参加商品类别')?></th>
            <td id="category_td">
                <?php
                $pcidArray   = ArrayHelper::array_column_Ex($model->getConfigCategory(), 'id');
                $allCategory = $model->getProductCategory();
                foreach($allCategory as $v){?>
                    <input type="checkbox" name="category[]" value="<?php echo $v['id'];?>" <?php if(in_array($v['id'], $pcidArray)){ echo 'checked="checked"';}?> /><?php echo $v['name'];?>
                <?php }?>
                <div id="ActiveCategoryForm_category_em_" class="errorMessage" style="display:none"></div>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('secondKillActivity','全选/不选')?></th>
            <td>
                <input type="checkbox" id="checkAll" name="checkAll" onclick="selectAll();">
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input type="submit" onclick="return checkForm();" value="<?php echo Yii::t('secondKillActivity', '提交');?>" class="reg-sub" />
            </td>
        </tr>
    </table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function selectAll(){
        var check = $('#checkAll').is(':checked');
        $('#category_td').find("input[type='checkbox']").prop('checked', check);
    }

    function checkForm(){
        var length = $('#category_td').find("input[type='checkbox']:checked").length;

        if(length<1){
            $('#ActiveCategoryForm_category_em_').html('参加商品类别 请选择商品类别');
            $('#ActiveCategoryForm_category_em_').css('display', '');
            return false;
        }else{
            $('#ActiveCategoryForm_category_em_').css('display', 'none');
        }

        return true;
    }

    $(document).ready(function(){
        $('#category_td').on('click', 'input', function(){
            var len = $('#category_td').find("input[type='checkbox']:checked").length;

            if(len > 0){
                $('#ActiveCategoryForm_category_em_').css('display', 'none');
            }else{
                $('#ActiveCategoryForm_category_em_').html('参加商品类别 请选择商品类别');
                $('#ActiveCategoryForm_category_em_').css('display', '');
            }
        })

        var length = $('#category_td').find("input[type='checkbox']:checked").length;
        var lengthDefault = '<?php echo count($allCategory);?>';
        if(length == parseInt(lengthDefault)){
             $('#checkAll').prop('checked', true);
        }
    });
</script>
