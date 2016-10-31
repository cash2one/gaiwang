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
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => "js:function(form, data, hasError){
                        return validateForm();}
                    ",
    ),
));
?>
    <script type="text/javascript">
        //限制个数
        var rowCount = '1';
        var addRow = function () {
            if ($('#storeId tr').length > 9) {
                artDialog.alert("<?php echo Yii::t('cityShow','一次最多只能添加十个商家'); ?>", null, "warning-red");
                return;
            }
            var rowId = 'storeId_' + rowCount;
            var html = '';
            html +='<tr id="' + rowId + '">';
            html +='<th width="10%"><label class="required" for="CityshowTheme_name"><?php echo Yii::t('cityShow','商家GW号'); ?></label></th>';
            html +='<td><input type="text" maxlength="50" id="Cityshowstore_gw_'+rowCount+'" name="storeName[]" class="inputtxt1" placeholder="请输入商家GW号并检测">';
            html +='<div class="errorMessage" style="display:none"><?php echo Yii::t('cityShow','商家GW号不能为空'); ?></div>';
            html +='&nbsp;&nbsp;&nbsp;&nbsp;';
            html +='<input type="button" style="padding: 5px;" value="<?php echo Yii::t('cityShow','检测'); ?>" onclick="verifyRow(' + rowCount + ')" class="regm-sub" />&nbsp;&nbsp;&nbsp';
            html +='<input type="button" style="padding: 5px;" value="<?php echo Yii::t('cityShow','删除'); ?>" onclick="doDeleteRow(' + rowCount + ')" class="regm-sub" />';
            html +='<br /><span id="Cityshowstore_name_'+rowCount+'"></span>';
            html +='</td></tr>';
            $('#storeId').append(html);
            rowCount++;
        };
        var doDeleteRow = function (rowid) {
            $('#storeId_' + rowid).hide(500, function () {
                $('#storeId_' + rowid).remove();
            });
        };
        var verifyRow = function (rowid) {
        	var gw=$("#Cityshowstore_gw_"+rowid).val();
        	var url="<?php echo Yii::app()->createAbsoluteUrl('seller/cityshowStore/verifyStoreGw');?>";
        	$.ajax({  
        		type: "post",  
        		url: url,  
        		dataType: "json",  
        		data: {"gw":gw,"csid":<?php echo $this->csid?>,"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>"},  
        		success: function(data){
                	 $("#Cityshowstore_name_"+rowid).html(data.msg);
                  }
             })
        };
    </script>
<script type="text/javascript">
        var validateForm = function () {
            var valid = true;
            $('#storeId [name*="themeName"]').each(function (i, ele) {
                if (!$(ele).val()) {
                    $(ele).siblings('.errorMessage').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).siblings('.errorMessage').css('display', 'none');
                }
            }); 
            return valid;
        };
    </script>
<style>
    .regm-sub{
        border:1px solid #ccc;
        background: #fff;
        /*padding: 5px;*/
        border-radius: 3px;
        cursor: pointer;
    }
</style>
<h5 class="mt15 tableTitle" style="line-height: 1.5">
提示：提交信息前请先检测商家信息
</h5>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody id="storeId">
    <input class="regm-sub" style="padding: 5px;" type="button" onClick="addRow()" value="<?php echo Yii::t('cityShow','添加商家'); ?>"> 
        <tr>
            <th width="10%"><?php echo Yii::t('cityShow', '商家GW号'); ?></th> 
            <td>
                 <input type="text" maxlength="50" id="Cityshowstore_gw_0" name="storeName[]" class="inputtxt1" placeholder="请输入商家GW号并检测">
                 <input type="button" style="padding: 5px;" value="<?php echo Yii::t('cityShow','检测'); ?>" onclick="verifyRow(0)" class="regm-sub" />
                  <br />
                  <span id="Cityshowstore_name_0"></span>
            </td>   
        </tr>
    </tbody>
</table>
<div class="profileDo mt15">
 <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerGoods', '提交') : Yii::t('sellerGoods', '保存'), array('class' => 'sellerBtn06', 'id' => 'submitBtn'));
        ?>
</div>

<?php $this->endWidget() ?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<script>
$("#submitBtn").click(function() {
    $('form').submit();
});
</script>