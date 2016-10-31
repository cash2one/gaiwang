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
<style>
    .regm-sub-last{
        border:1px solid #ccc;
        background: #fff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }
    .imgArrDiv{
	           height:80px;
    }
     .sellerT3 th{
	   text-align:right;
     }
</style>
    <script type="text/javascript">
        //图片上传控件 html
        var imgUpload = function (uid) {
            var html = '';
            html += '<div id="_imgshowImgUrl_' + uid + '" class="ImgList"></div>';
            html += '<input class="regm-sub-last" type="button" value="<?php echo Yii::t('cityShow','焦点图片'); ?>"';
            html += 'onclick="_fileUpload(';
            html += '\'<?php echo Yii::app()->createUrl('/seller/upload/index', array('height' =>0, 'width' =>0, 'img_format' =>'')) ?>\',';
            html += '\'<?php echo Yii::app()->createUrl('/seller/upload/sure', array('imgarea' => 1, 'foldername' => 'files', 'isdate' => 1)) ?>\',';
            html += "1,'ImgUrl_" + uid + "',";
            html += "'<?php echo Yii::app()->request->csrfToken; ?>','<?php echo session_id() ?>')";
            html += '"  style="cursor:pointer">';
            html += '<input type="hidden" id="ImgUrl_' + uid + '" name="ImgUrl[]" value="">';
            return html;
        };
        // 限制图片状态
        var rowCount = '1';
        var addRow = function () {
            if ($('#imgId .imgArrDiv').length > 4) {
                artDialog.alert("<?php echo Yii::t('cityShow','最多只能添加五张图片'); ?>", null, "warning-red");
                return;
            }
            var rowId = 'imgArrDiv_' + rowCount;
            var html = '';
            html += '<div class=imgArrDiv id="' + rowId + '">';
            html += imgUpload(String(Math.random()).substr(3));
            html +='<div class="errorMessage" style="display:none;margin:28px 0 0 -60px"><?php echo Yii::t('cityShow','焦点图不可为空白'); ?></div>'
            html += '&nbsp;<?php echo Yii::t('cityShow','焦点图链接'); ?>：<input value="" class="inputtxt1" type="text" id="Model_' + rowCount + '_Link" name="Link[]" />';
            html += '<div class="errorMessage" style="display:none;margin:28px 0 0 -140px"><?php echo Yii::t('cityShow','请正确填写链接URL'); ?></div>'; 
            html += '<input type="button" value="<?php echo Yii::t('cityShow','删除'); ?>" onclick="doDeleteRow(' + rowCount + ')" class="regm-sub-last" />';
            $('#imgId td').append(html);
            rowCount++;
        };
        var doDeleteRow = function (rowid) {
       	 if ($('#imgId .imgArrDiv').length < 2) {
             artDialog.alert("<?php echo Yii::t('cityShow','最少上传一张图片'); ?>", null, "warning-red");
             return;
         }
            $('#imgArrDiv_' + rowid).hide(500, function () {
                $('#imgArrDiv_' + rowid).remove();
            });
        };
    </script>
 <script type="text/javascript">

        var validateForm = function () {
            var valid = true;
            $('#imgId .imgArrDiv [name*="ImgUrl"]').each(function (i, ele) {
                if (!$(ele).val()) {
                    $(ele).next('.errorMessage').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).next('.errorMessage').css('display', 'none');
                }
            }); 
            
             $('#imgId .imgArrDiv [name*="Link"]').each(function (i, ele) {
                var url=$(ele).val();
                //var matchUrl="/(((^https?:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)$/g";
                if (!url) {
                	 $(ele).next('.errorMessage').html("焦点图链接不可为空！");
                     $(ele).next('.errorMessage').css('display', 'inline');
                     valid = false;
                 }else{
                     if(!IsURL(url)){
                    	 $(ele).next('.errorMessage').css('display', 'inline');
                         valid = false;   
                      }else{
                         $(ele).next('.errorMessage').css('display', 'none');
                     }
                }
            });
            return valid;
        };

        function IsURL(str_url){
    	    var strRegex="(http[s]{0,1}|ftp)://[a-zA-Z0-9\\.\\-]+\\.([a-zA-Z]{2,4})(:\\d+)?(/[a-zA-Z0-9\\.\\-~!@#$%^&*+?:_/=<>]*)?"
    	        var re=new RegExp(strRegex); 
    	        if (re.test(str_url)){
    	            return true; 
    	        }else{ 
    	            return false; 
    	        }
    	    }
    </script>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'title'); ?>：</th>
            <td>
                 <?php echo $form->textField($model, 'title', array('class' => 'inputtxt1','maxLenght'=>'10')); ?>
                 <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'subtitle'); ?>：
            </th>
            <td>
                 <?php echo $form->textField($model, 'subtitle', array('class' => 'inputtxt1','maxLenght'=>'70')); ?>
                 <?php echo $form->error($model, 'subtitle'); ?>
            </td>
        </tr>
        
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'encode'); ?>：
            </th>
            <td>
                 <?php echo $form->textField($model, 'encode', array('class' => 'inputtxt1')); ?>
                 <?php echo $form->error($model, 'encode'); ?>
            </td>
        </tr>
        
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'region'); ?>：
            </th>
            <td>
             <?php
                echo $form->dropDownList($model,'region',CityshowRegion::getShowCityRegion(), array(
                    'prompt' => Yii::t('cityShow', '选择大区'),
                    'class' => 'selectTxt1',
                    ));
                ?> 
                 <?php echo $form->error($model, 'region'); ?>
             </td>
        </tr>     
        <tr>
            <th><?php echo Yii::t('cityShow', '所在地区'); ?><b class="red">*</b>：</th>
            <td>
                <?php
                echo $form->dropDownList($model, 'province', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('cityShow', '选择省份'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Cityshow_city").html(data.dropDownCities);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'city', Region::getRegionByParentId($model->province), array(
                    'prompt' => Yii::t('cityShow', '选择城市'),
                    'class' => 'selectTxt1', 
                ));
                ?>
               


                <div style="display:block;width:300px;float:left;margin-left:190px;">
                    <?php echo $form->error($model, 'city'); ?>
                    <?php echo $form->error($model, 'province'); ?>

                </div>

            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'background_img'); ?>：
            </th>
            <td>
              <?php
                $this->widget('seller.widgets.CUploadPic', array(
                    'attribute' => 'background_img',
                    'model' => $model,
                    'form' => $form,
                    'num' => 1,
                    'btn_value' => Yii::t('cityShow', '背景图片'),
                    'render' => '_upload',
                    'btn_class'=>'regm-sub-last',
                    'folder_name' => 'files',
                    'include_artDialog' => false,
                ));
                ?>
                <?php echo $form->error($model, 'background_img'); ?>
                &nbsp;<span class="gray"><?php echo Yii::t('cityShow', '（建议：宽*高: 1200*100像素,小于1M）'); ?></span>
            </td>
        </tr>
        <tr id="imgId">
            <th width="120px">
                <?php echo $form->labelEx($model, 'top_banner'); ?><b class="red">*</b>：
            </th>
            <td>
             <input class="regm-sub-last" type="button" onClick="addRow()" value="<?php echo Yii::t('cityShow','+添加'); ?>">
             <span class="gray"><?php echo Yii::t('cityShow', '（建议：宽*高: 1893*460像素,小于1M,&nbsp;&nbsp;&nbsp;&nbsp;焦点图链接请以“http”或者“https”开头）'); ?></span>
           
             <?php if(isset($imgArr[0]['ImgUrl'])):?>
             <?php foreach($imgArr as $k => $v):?>
               <div class='imgArrDiv' id="imgArrDiv_<?php echo $k;?>"><?php
                 $this->widget('seller.widgets.CUploadPic', array(
                    'attribute' => 'ImgUrl[]',
                    'num' => 1,
                    'value' => $v['ImgUrl'],
                    'btn_value' => Yii::t('cityShow', '焦点图片'),
                    'btn_class'=>'regm-sub-last',
                    'render' => '_upload',
                    'folder_name' => 'files',
                    'include_artDialog' => false,
                    'tag_id'=>'ImgUrl'.rand(100,999),
                ));
                ?>
                <div class="errorMessage" style="display:none;margin:28px 0 0 -60px"><?php echo Yii::t('cityShow','焦点图不可为空白'); ?>.</div>
                 <?php echo Yii::t('cityShow','焦点图链接');?>：<input class ='inputtxt1' type="text" value="<?php echo $v['Link'] ?>" name="Link[]">
                <div class="errorMessage" style="display:none;margin:28px 0 0 -140px"><?php echo Yii::t('cityShow','请正确填写链接URL'); ?></div>
             <?php if($k!=0):?>
              <input type="button" class="regm-sub-last" onclick="doDeleteRow(<?php echo $k ?>)" value="<?php echo Yii::t('sellerDesign','删除'); ?>">
              <?php endif;?>
              </div>
                <?php endforeach;?>
                <?php endif;?>
            </td>
        </tr>
        
    </tbody>
</table>
<div class="profileDo mt15">
   <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cityShow', '提交') : Yii::t('cityShow', '保存'), array('class' => 'sellerBtn06', 'id' => 'submitBtn'));?>        
</div>

<?php $this->endWidget() ?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>