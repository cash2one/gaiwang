<?php
$this->breadcrumbs = array(
    Yii::t('goods','宝贝管理') => array('goods/index'),
     Yii::t('goods','导入数据包')
);
    $form = $this->beginWidget('CActiveForm',array(
        'id'=>$this->id . '-form',
        'action'=> '/goodsImport/stepTwo',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions'=>array(
            'enctype'=>'multipart/form-data',
        ),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )));
?>
<div class="toolbar">
    <b><?php echo Yii::t('goods', '导入数据包')?></b>
    <span><?php echo Yii::t('goods','导入第三方商城提供的商品数据包')?></span>
</div>
<!--step1-->
<div id="export-step1">
    <div style="width:1002px;margin: 25px auto 0;height: 26px;padding-top: 6px" class="tips">
        <?php echo sprintf(Yii::t('goods','提示：您每日最多可以导入<span class="red">%d</span>条产品，今天已经导入<span class="red">%d</span>条，还可以导入<span class="red">%d</span>条'),$total,$store->upload_total,($total-$store->upload_total));?>
    </div> 
<div class="importProgressBar">
    <div class="importProgress_step1"></div>
</div>
<div class="importData step1"> 
    <table class="sellerT5">
        <tr id="select-category">
            <th>
                <b class="red">*</b><?php echo $form->label($goods, 'category_id'); ?>
            </th>
            <td>
                <select class="text-input-bj selectTxt1" id="Goods_category">
                    <option value selected="selected"><?php echo Yii::t('goods', '请选择栏目')?></option>>
                <?php 
                    if($store->category_id == 0){
                        $data = CHtml::listData(Category::model()->findAll("parent_id=:pid AND status=:s", array(':pid' => 0,':s'=>  Category::STATUS_ENABLE)), 'id', 'name');
                    } else {
                        $data = CHtml::listData(Category::model()->findAll("id = :pid AND status=:s", array(':pid' => $store->category_id,':s'=>  Category::STATUS_ENABLE)), 'id', 'name');
                    }
                    foreach ($data as $k=>$d){
                        echo '<option value='.$k.'>'.$d.'</option>';
                    }
//                    echo $form->dropDownList($store,'category_id',$data,array(
//                        'class' => 'text-input-bj selectTxt1',
//                        'prompt' => Yii::t('goods', '请选择栏目'),
//                        'ajax'=>array(
//                            'type'=>'POST',
//                            'url'=> $this->createUrl('/seller/goods/getJson'),
//                            'dataType'=> 'json',
//                            'data'=>array(
//                                'cid'=>'js:this.value',
//                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
//                            ),
//                            'success'=>'function(data){
//                                $html = "<td><select><option value>请选择栏目</option>";
//                                if(data != null){
//                                    for($i=0,len=data.length;$i<len;$i++){
//                                        $html += "<option value=\'" + data[$i].id +"\'>" + data[$i].name + "</option>"
//                                    }
//                                }
//                                $html = $html+"</select></td>"
//                               $("#select-category").append($html);
//                            }'
//                        ),
//                    ));
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>
                <b class="red">*</b><?php echo $form->label($goods,  'scategory_id'); ?>
            </th>
            <td colspan="3" width="150px">
                <?php echo $form->dropDownList($goods, 'scategory_id', Scategory::model()->showAllSelectCategory($this->getSession('storeId'), Yii::t('category', '--请选择--')),array('class'=>'text-input-bj selectTxt1')); ?>
                <?php echo $form->error($goods,'scategory_id');?>
            </td>
        </tr>
        <tr>
            <th>
                <b class="red">*</b>
                <?php echo Yii::t('goods', '运输方式'); ?>
            </th>
            <td colspan="3">
                <?php
                $freightArray = $goods::freightPayType();
                unset($freightArray[Goods::FREIGHT_TYPE_CASH_ON_DELIVERY]); //不再支持运费到付
                echo $form->radioButtonList($goods, 'freight_payment_type', $freightArray, array('separator' => ' ','template'=>'<span class="radio">{input} {label}</span> '))
                ?>
                <?php echo $form->error($goods, 'freight_payment_type') ?>  
                <span id="templateSelect" style="display:none">   
                    <?php echo Yii::t('Goods', '选择运费模板'); echo $form->dropDownList($goods, 'freight_template_id', CHtml::listData(
                    FreightTemplate::model()->findAllByAttributes(array('store_id' => $this->storeId)), 'id', 'name'
                    ), array('class' => 'selectTxt1', 'prompt' => Yii::t('goods', '请选择'),'style'=>'width:70px'))
                    ?>
                    <?php echo $form->error($goods, 'freight_template_id'); ?>
                </span>
            </td>
        </tr>
    </table>
    <?php echo CHtml::hiddenField('Goods[category_id]','',array('id'=>'Goods_category_id'))?>
    <?php echo CHtml::submitButton('下一步',array('class'=>'sellerBtn06 mt15','id'=>'submit'))?>
    <div class="importTips tips">
        <?php echo Yii::t('goods','提示：导入第三方商城提供的商品数据包，生成盖象商城商品信息，提交商城审核，审核成功即可上架。')?>
    </div> 
</div> 
</div>
<?php $this->endWidget(); ?>
<!--<div  class="importing" id="importing">
    <div class="progressBar">
        <div class="progressLine"></div>
    </div>
    <div class="progressTips">
         导入中 
        <span></span>
        <i class="importLoading"></i>努力导入中，已完成60%
         导入完 
        数据包已导入成功！
    </div>
</div>-->
<script type="text/javascript">
    /*列表显示数量下拉*/
    $(".import_list_box").toggle(function(){
        $(".import_list_num").css('display','block');
    },function(){
        $(".import_list_num").css('display','none');
    });
    /*商品信息列表全选*/
    $(".checkAll").click(function(){ 
        if(this.checked){
            $(".checkAll_sub").each(function(){
                this.checked = true;
            }); 
        }else{ 
            $(".checkAll_sub").each(function(){
                this.checked = false;
            }); 
        } 
    });
    /*重命名提示框*/
    function rename(){
        art.dialog.prompt("商品名称：", function(){
            //yesFn
        }, "");
        $(".aui_icon").css('display','none');
        $(".aui_title").text("重命名");
        $(".aui_content input").css({border:'1px solid #ccc',width:'265'}).after("<span>（限80字）</span>");
    }
    
    /*运输模板的显示与隐藏*/
    $('#Goods_freight_payment_type_0').on('click',function(){
        $('#templateSelect').hide();
    });
    $('#Goods_freight_payment_type_1').on('click',function(){
        $('#templateSelect').show();
    });
    
    ///////栏目联动
    var select = jQuery('#select-category')
        ,value
        ,category_id = jQuery('#Goods_category_id');
    select.delegate('#Goods_category','change',function(){
        value = jQuery(this).val();
        if(jQuery('#sec-select').length>0) jQuery('#sec-select').parent('td').remove();
        if(jQuery('#thired-select').length>0) jQuery('#thired-select').parent('td').remove();
        if(value == ''){
            category_id.val('');
            return false;
        }
        getCategory(value,'sec-select');
    });
    select.delegate('#sec-select','change',function(){
        value = jQuery(this).val();
        if(jQuery('#thired-select').length>0) jQuery('#thired-select').parent('td').remove();
        if(value == ''){
            category_id.val('');
            return false;
        }
        getCategory(value,'thired-select');
    });
    select.delegate('#thired-select','change',function(){
        value = jQuery(this).val();
        jQuery("#Goods_category_id_em_").remove();
        if(value) {
            category_id.val(value);
            //jQuery('#submit').removeAttr('disabled');
        } else {
            category_id.val('');
            //jQuery('#submit').attr('disabled','disabled');
        }
    });
    function getCategory(cid,grade)
    {
        console.log(jQuery("#Goods_category_id_em_"));
        jQuery("#Goods_category_id_em_").remove();
        jQuery.ajax({
            'type':'POST',
            'url': '<?php echo $this->createUrl('/seller/goods/getJson')?>',
            'dataType': 'json',
            'data':{'cid':cid, 'YII_CSRF_TOKEN':'<?php echo  Yii::app()->request->csrfToken;?>'},
            'success':function(data){
                var html = "<td><select id='"+grade+"'><option value>请选择栏目</option>";
                if(data){
                    for($i=0,len=data.length;$i<len;$i++){
                        html += "<option value=\'" + data[$i].id +"\'>" + data[$i].name + "</option>";
                    }
                    html += "</select></td>";
                    select.append(html);
                    category_id.val('');
                } 
                if(!data){
                    category_id.val(cid);
                    //jQuery('#submit').removeAttr('disabled');
                }
            }
        });
    }
    jQuery('form').submit(function(){
        value = category_id.val();
        if(value==''){
            if(!$('#Goods_category_id_em_').length) select.children('td:last-child').append('<div class="errorMessage" id="Goods_category_id_em_">商城分类不能为空</div>').show();
            return false;
        }
    })
</script>