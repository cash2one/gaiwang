<?php
/** @var $model Store */
/** @var $this StoreController */
/** @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/plugins/iframeTools.js', CClientScript::POS_END);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,  
    ),
));
?>
    <script type="text/javascript">
        //限制个数
        var rowCount = '1';
        var addRow = function () {
        	var teNum="<? echo $this->themeNum;?>";
            var MaxNum=$('#themeId tr').length+parseInt(teNum);
            if (MaxNum > 4) {
                artDialog.alert("<?php echo Yii::t('cityShow','最多只能添加五个主题'); ?>", null, "warning-red");
                return;
            }
            var rowId = 'themeId_' + rowCount;
            var html = '';
            html +='<tr id="' + rowId + '">';
            html +='<th width="10%"><label class="required" for="CityshowTheme_name"><?php echo Yii::t('cityShow','主题名称'); ?><span class="required">*</span></label></th>';
            html +='<td><input type="text" maxlength="10" id="CityshowTheme_name" name="themeName[]" class="inputtxt1">';
            html +='<div class="errorMessage" style="display:none;margin-left:55px"><?php echo Yii::t('cityShow','主题名称不能为空'); ?></div>';
            html +='&nbsp;&nbsp;&nbsp;&nbsp;';
            html +='<input type="button" value="<?php echo Yii::t('cityShow','删除'); ?>" onclick="doDeleteRow(' + rowCount + ')" class="regm-sub" />';
            html +='</td></tr>';
            $('#themeId').append(html);
            rowCount++;
        };
        var doDeleteRow = function (rowid) {
            $('#themeId_' + rowid).hide(500, function () {
                $('#themeId_' + rowid).remove();
            });
        };
    </script>
<script type="text/javascript">
        var validateForm = function () {
            var valid = true;
             $('input[name*="themeName"]').each(function (i, ele) {
                 if (!$(ele).val()) {          
                    $(ele).next('.errorMessage').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).next('.errorMessage').css('display', 'none');
                } 
            });
            return valid;
        };
    </script>
<style>
    .regm-sub-last{
        border:1px solid #ccc;
        color: #fff;
    	padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    	background: url(../images/bg/sellerBtn06.gif) no-repeat;
    }
</style>
<h5 class="mt15 tableTitle" style="line-height: 1.5">
提示：<br>
1、已添加<span style="color: red"><?php echo $this->themeNum;?></span>个主题，还能再添加<span style="color: red"><?php echo (5-$this->themeNum);?></span>个；每个主题最多输入10个字；<br>
2、主题名称提交后，需平台专员对城市馆进行再次审核，审核成功后最新内容才能更新到前台
</h5>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody id="themeId">
      <input class="regm-sub-last" type="button" onClick="addRow()" value="<?php echo Yii::t('cityShow','添加主题'); ?>">
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                 <input type="text" maxlength="10" name="themeName[]" class="inputtxt1">
                 <div class="errorMessage" style="display:none;margin-left:55px"><?php echo Yii::t('cityShow','主题名称不能为空'); ?></div>
                 &nbsp;&nbsp;&nbsp;
            </td>   
        </tr>
    </tbody>
</table>
<div class="profileDo mt15">
      <input class="sellerBtn06" onclick="return validateForm()" type="submit" value="<?php echo Yii::t('sellerGoods', '提交')?>">
</div>

<?php $this->endWidget() ?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<script>
$("#submitBtn").click(function() {
    $('form').submit();
});
</script>