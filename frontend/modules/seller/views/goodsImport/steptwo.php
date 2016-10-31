<?php
    $this->breadcrumbs = array(
        Yii::t('goods','宝贝管理') => array('goods/index'),
         Yii::t('goods','导入数据包')
    );
?>
<!--step2-->
<div id="export-step2">
    <div class="importProgressBar">
        <div class="importProgress_step2"></div>
    </div>
<?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => $this->id . '-form',
        'action' => '/goodsImport/goodsImport',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        )
    ));
?>
    <div class="importData step2">
        <div class="importTips">
        <?php echo Yii::t('goods','请选择数据包版本再导入数据包，目前可支持导入<b>天猫</b>、<b>淘宝</b>的商品数据包');?> 
        </div>
        <table class="sellerT5">
            <tr>
                <th>
                    <b class="red">*</b><?php echo Yii::t('goods','版本：')?>
                </th>
                <td class="choiceBox" id="choiceBox_1">
                    <label class="checked" for="type-tianmao"><?php echo Yii::t('goods','天猫数据包')?></label>
                    <input type="radio" name="datatype" id="type-tianmao" style="display: none" checked="checked" value="1">
                    <label for="type-taobao"><?php echo Yii::t('goods','淘宝数据包')?></label>
                    <input type="radio" name="datatype" id="type-taobao" style="display: none" value="2">
                </td>
            </tr>
            <tr>
                <th>
                    <b class="red">*</b><?php echo Yii::t('goods','数据包文件：')?>
                </th>
                <td>
                    <a class="uploadFile">
                        <input type="file" onchange="document.getElementById('textfield').innerHTML=this.value;document.getElementById('export-data').style.display='none'" id="filename" name="filename">
                    </a>
                    <div class="errorMessage" id="export-data" style="display: none"></div>
                    <span id="textfield"><?php echo Yii::t('goods','未选择任何文件')?></span>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <?php echo Yii::t('goods','最大上传文件大小：4MB，支持<span class="importTips"><b color="#e73232">xls</b>、<b>xlsx</b>等格式文件</span>')?>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input class="sellerBtn06" type="submit" value="导入">
                    <!--<input class="sellerBtn08" type="button" value="返回">-->
                    <input type="button" class="sellerBtn08" value="返回" onclick="window.location.href='/goodsImport/index'">
                </td>
            </tr>
        </table>
        <?php echo $form->hiddenField($model,'category_id',array('value'=>$model->category_id))?>
        <?php echo $form->hiddenField($model,'scategory_id',array('value'=>$model->scategory_id))?>
        <?php echo $form->hiddenField($model,'freight_payment_type',array('value'=>$model->freight_payment_type))?>
        <?php if($model->freight_payment_type == Goods::FREIGHT_TYPE_MODE){
           echo $form->hiddenField($model,'freight_template_id',array('value'=>$model->freight_template_id));
        };?>
    </div> 
</div>
<?php $this->endWidget();?>
<!--<div id="import-file" style="display: none;text-align: center;margin: 20px;font-size: 20px;font-weight: bold;"><?php //echo Yii::t('goods','数据包正在导入，请耐心等候...')?></div>-->
<div  class="importing" id="importing" style="display: none">
    <div class="progressBar">
        <div class="progressLine"></div>
    </div>
    <div class="progressTips">
        <!-- 导入中 -->
        <i class="importLoading"></i>努力导入中，已完成60%
        <!-- 导入完 -->
        <!--数据包已导入成功！-->
    </div>
</div>
<script type="text/javascript">
    /*选择数据包版本*/
    $("#choiceBox_1").find("label").click(function(){
        $(this).parent().children().removeClass();
        $(this).addClass("checked");
    });
    jQuery('form').submit(function(){
        var value = jQuery('#filename').val();
        if(value==''){
            jQuery('#export-data').html('请选择文件。').show(); 
            return false;
        }
//        jQuery('form').hide();
//        jQuery('#import-file').show();
    })
</script>
