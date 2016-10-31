<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/plugins/iframeTools.js', CClientScript::POS_END);
?>
<style>
    .regm-sub{
        border:1px solid #ccc;
        background: #fff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }
    .activeinfo{
        width:100%;
        height:auto;
        /*display: none;*/
    }
    .activeinfo dl{
        position: relative;
        top: 0px;
        width: 100%;
        height: 98%;
    }

    .activeinfo dl dt, .activeinfo dl dd{
        margin-left: 10px;
        background: #e6e6e6;
        height: 20px;
        height: 20px;
        border: 0px;
        line-height: 20px;
        font-size: 17px;
        text-align: center;
        margin-top: 5px;
    }
    .activeinfo dl dd{
        width:12%; text-align:left; font-family:"微软雅黑"; font-size:14px;
    }

    .activeinfo dl dt{
        width: 76%;
        text-align: start; font-size:13px;
    }

    .activeinfo p{
        display: block; padding-left:18px; font-size:12px;
    }
    .showRules{
        /*display: none; */
    }
    .showRules_a{
        width:100%;
        height: 100%;
        display: inline-block;
    }

    .activeinfo_content{
        width: 100%; max-height:215px; overflow:auto; min-height:96px;word-break:break-all;
    }
</style>
<div class="toolbar">
    <b><?php echo Yii::t('sellerGoods', '我要卖'); ?></b>
    <span><?php echo Yii::t('sellerGoods', '添加新的宝贝信息资料'); ?>。</span>
</div>
<div class="proAddStep">
    <ul class="s2">
        <li><?php echo Yii::t('sellerGoods', '选择商品所在分类'); ?></li>
        <li><?php echo Yii::t('sellerGoods', '填写商品详细信息'); ?></li>
        <li><?php echo Yii::t('sellerGoods', '商品发布成功'); ?></li>
    </ul>
</div>
<div class="proAddStepTwo">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <h3 class="title"><?php echo Yii::t('sellerGoods', '参加活动'); ?></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
        <input type="hidden" name="product_category" value="<?php echo SeckillCategory::getTopParentId($_GET['cate_id']) ?>">
        <tr>
            <th width="10%">请选择活动类型：</th>
            <td width="90%">
                <select onmousewheel="return false" class="inputtxt1" name="category_id" id="category_id" style="width:150px;">
                    <option value="0">不参与</option>
					
                    <?php foreach($CategoryList as $key => $value){?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                    <?php }?>

                </select>
            </td>
        </tr>
         <tr id="ative_name">
             <th>请选择活动名称：</th>
            <td>
                <select onmousewheel="return false" class="inputtxt1" id="rules_id" name="Goods[seckill_seting_id]" style="width:150px;">

                </select>

            </td>
        </tr>

        <tr class="seckill" style="display: none;">
            <th>请选择活动日期：</th>
            <td>
                <select onmousewheel="return false" class="inputtxt1" id="date" name="rules_id" >

                </select>

            </td>
        </tr>
        <tr class="seckill_time" style="display: none;">
            <th >请选择活动时间：</th>
            <td>
                <select onmousewheel="return false" class="inputtxt1" id="time" name="Goods[seckill_seting_id]" >

                </select>

            </td>
        </tr>

        <tr class="showInfoDiv" style="display: none;">
			 <th>
				 <p class="showRules"><a class="showRules_a" href="#">活动细则：</a></p>
			</th>
			<td>
				 <div class="activeinfo">
					<div>	
						 <dd>活动日期：
						 <span id="start_date"></span></dd>
						 <dd>活动时间：
						 <span id="active_times"></span></dd>
                         <dd>报名开始时间：
						 <span id="singup_start_time"></span></dd>
                         <dd>报名截止时间：
						 <span id="singup_end_time"></span></dd>
						 <dd>产品数量：
						 <span id="product_nums"></span>
						 <span style="color: red;display: none" id="num_text">活动参与的商品数量即将满额，请尽快上传</span>
						 </dd>
						 <dd>
						 <span id="condition"></span>
						 <span id="discount"></span>
						 </dd>
					</div>
				 </div>
			 </td>
		 </tr>
		 
		 <tr class="showInfoDiv" style="display: none;">
			 <th>
				 <p class="showRules"><a class="showRules_a" href="#"><span id="active_name"></span>活动协议：</a></p>
			</th>
			<td>
				 <div class="activeinfo">
					<div class="activeinfo_content" >
						 <span id="rules_content"></span>
					 </div>
				 </div>
			 </td>
		 </tr>

    </table>

    <h3 class="title"><?php echo Yii::t('sellerGoods', '基本信息'); ?></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
        <tr>
            <th><?php echo $form->labelEx($model, 'category_id'); ?></th>
            <td>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'homeLink' => false,
                    'separator' => ' > ',
                    'links' => Tool::categoryBreadcrumb($this->getParam('cate_id')),
                    'activeLinkTemplate' => '<a href="{url}" class="">{label}</a>',
                ));
                echo CHtml::link(Yii::t('sellerGoods', '编辑'), $this->createUrl('selectCategory'));
                ?>
            </td>
        </tr>
        <tr>
            <th width="10%"> <?php echo $form->labelEx($model, 'name'); ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'name', array('class' => 'inputtxt1', 'style' => 'width:320px;')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th width="10%"> <?php echo $form->labelEx($model, 'labels'); ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'labels', array('class' => 'inputtxt1', 'style' => 'width:320px;')); ?>
				<?php echo Yii::t('sellerGoods', '该标签用于SEO优化,建议填写四个且标签之间用空格分开'); ?>
                <?php echo $form->error($model, 'labels'); ?>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'code', array('size' => 60, 'maxlength' => 64, 'class' => 'inputtxt1', 'style' => 'width:125px;')); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'weight'); ?></th>
            <td>
                <?php echo $form->textField($model, 'weight', array('size' => 8, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => 'width:125px;')); ?>
                <?php echo $form->error($model, 'weight'); ?>
                <span  class="gray">(<?php echo Yii::t('sellerGoods', '单位为kg,只保留两位小数'); ?>)</span>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'size'); ?></th>
            <td>
                <?php echo $form->textField($model, 'size', array('size' => 8, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => 'width:125px')); ?>
                <?php echo $form->error($model, 'size'); ?>
                <span  class="gray">(<?php echo Yii::t('sellerGoods', '单位为m³(立方米),只保留两位小数'); ?>)</span>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'stock'); ?></th>
            <td>
                <?php echo $form->textField($model, 'stock', array('size' => 8, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => 'width:125px')); ?>
                <?php echo $form->error($model, 'stock'); ?>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'brand_id'); ?></th>
            <td>
                <?php
                echo $form->hiddenField($model, 'brand_id');
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'brand_name',
                    'source' => $this->createAbsoluteUrl('/seller/goods/suggestBrands'),
                    'htmlOptions' => array('size' => 20, 'style' => '', 'class' => 'inputtxt1', 'id' => 'brand_id'),
                    'options' => array(
                        'minLength' => '1',
                        'select' => 'js:function( event, ui ) {
                        $("#Goods_brand_id").val( ui.item.id );
                        $("#brand_id").attr("readonly","readonly");
                        return true;
                      }',
                    ),
                ));
                ?>(<?php echo Yii::t('sellerGoods', '输入品牌关键词会自动关联出店铺的相关品牌，如没有请创建'); ?>)
                <?php echo $form->error($model, 'brand_id'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0">
                <?php
                $this->renderPartial('_createSpec', array(
                    'spec' => TypeSpec::specValue($typeSpec), //规格值数据,给视图中的循环选择规格用,
                    'typeSpec' => $typeSpec,
                ))
                ?>
                <dl class="spec-bg">
                    <dt></dt>
                    <dd><?php echo $form->error($model, 'spec_picture') ?></dd>
                </dl>
                <div class="spec-tips" style="height:25px; border:solid 1px #e1e1e1; overflow: hidden; clear: both; margin-left: 10px;">
                    <span><?php echo Yii::t('sellerGoods', '您需要选择所有的销售属性,才能组合成完整的规格信息.'); ?></span></div>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model, 'scategory_id'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'scategory_id', Scategory::model()->showAllSelectCategory($this->getSession('storeId'), Yii::t('category', Scategory::SHOW_SELECT))); ?>
                <?php echo $form->error($model, 'scategory_id'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <b class="red">*</b><?php echo Yii::t('sellerGoods', '描述（建议上传宽度为750像素的图片）'); ?>：
            </th>
            <td>
                <?php
                $this->widget('ext.editor.WDueditor', array(
                    'model' => $model,
                    'base_url' => 'http://seller.' . SHORT_DOMAIN,
                    'attribute' => 'content',
                    'save_path' => 'uploads/files', //默认是'attachments/UE_uploads'
                    'url' => IMG_DOMAIN . '/files' //默认是ATTR_DOMAIN.'/UE_uploads'
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'thumbnail'); ?></th>
            <td>
                <?php
                $this->widget('seller.widgets.CUploadPic', array(
                    'attribute' => 'thumbnail',
                    'model' => $model,
                    'form' => $form,
                    'num' => 1,
                    'btn_value' => Yii::t('sellerGoods', '封面图片'),
                    'render' => '_upload',
                    'folder_name' => 'files',
                    'include_artDialog' => false,
                ));
                ?>
                <?php echo $form->error($model, 'thumbnail'); ?>
                &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods', '建议上传750*750像素的图片'); ?>)</span>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($imgModel, 'path'); ?></th>
            <td>
                <?php
                $this->widget('seller.widgets.CUploadPic', array(
                    'attribute' => 'path',
                    'model' => $imgModel,
                    'form' => $form,
                    'num' => 6,
                    'btn_value' => Yii::t('sellerGoods', '上传图片'),
                    'render' => '_upload',
                    'folder_name' => 'files',
                    'include_artDialog' => false,
                ));
                ?>
                <?php echo $form->error($imgModel, 'path') ?>
                &nbsp;<span class="gray">(<?php echo Yii::t('sellerGoods', '建议上传750*750像素的图片,最多6张'); ?>)</span>
            </td>
        </tr>

        <tr>
            <th><?php echo Yii::t('sellerGoods', '商品属性'); ?></th>
            <td>
                <?php foreach ($attribute as $v): ?>
                    <div class="row">
                        <label><?php echo $v['name'] ?>:</label>
                        <select  name="attr[<?php echo $v['id'] ?>]">
                            <?php foreach ($v->attributeData as $v2): ?>
                                <option value="<?php echo $v2->id ?>"><?php echo $v2->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
    <h3 class="title"><?php echo Yii::t('sellerGoods', '重要信息'); ?></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
        <tr style="display: none;">
            <th width="10%"> <?php echo $form->labelEx($model, 'market_price'); ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'market_price', array('size' => 11, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => '125px')), HtmlHelper::formatPrice(''); ?>
                <?php echo $form->error($model, 'market_price'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'price'); ?></th>
            <td>
                <?php echo $form->textField($model, 'price', array('size' => 11, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => '125px')); ?>
                <?php echo $form->error($model, 'price') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'gai_price'); ?></th>
            <td>
                <div id="gai_price_area">0.00</div>
            </td>
        </tr>
        <tr>
            <th rowspan="3"><?php echo Yii::t('sellerGoods', '运输方式'); ?><b class="red">*</b></th>
            <td>
                <?php
                $freightArray = $model::freightPayType();
                unset($freightArray[Goods::FREIGHT_TYPE_CASH_ON_DELIVERY]); //不再支持运费到付
                echo $form->radioButtonList($model, 'freight_payment_type', $freightArray, array('separator' => ' '))
                ?>
                <?php echo $form->error($model, 'freight_payment_type') ?>
                <div id="templateSelect" style="display: none">　　　
                    <?php echo Yii::t('sellerGoods', '选择运费模板'); ?>：
                    <?php
                    echo $form->dropDownList($model, 'freight_template_id', CHtml::listData(
                    FreightTemplate::model()->findAllByAttributes(array('store_id' => $this->storeId)), 'id', 'name'
                    ), array('class' => 'selectTxt1', 'empty' => Yii::t('sellerGoods', '请选择')))
                    ?>
                    <?php echo $form->error($model, 'freight_template_id') ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->checkBox($model, 'is_publish') ?>
                <?php echo $form->label($model, 'is_publish') ?>
                <?php echo $form->error($model, 'is_publish'); ?>
            </td>
        </tr>
    </table>

    <h3 class="title"><?php echo Yii::t('sellerGoods', 'SEO优化搜索信息'); ?></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">

        <tr>
            <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 128, 'class' => 'inputtxt1', 'style' => 'width:615px')); ?>
            </td>
        </tr>
        <tr>
            <th> <?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 5)); ?>
            </td>
        </tr>
    </table>
    <div class="next">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerGoods', '提交') : Yii::t('sellerGoods', '保存'), array('class' => 'sellerBtn06', 'id' => 'submitBtn'));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    commonData = {
        skuTips: "<?php echo Yii::t('sellerGoods', '请完善库存配置输入！'); ?>",
        selectTips: "<?php echo Yii::t('sellerGoods', '请完善商品规格选择，如：图片，颜色'); ?>"
    };
</script>
<script type="text/javascript" src="<?php echo DOMAIN ?>/js/sellerGoods.js"></script>
<script>
    $("#Goods_price").change(function() {
        var price = $(this).val();
        var cat_id = '<?php echo $model->category_id; ?>';
        $.getJSON("<?php echo Yii::app()->createUrl('/seller/goods/getGaiPrice/'); ?>",
                "price=" + price + "&cat_id=" + cat_id,
                function(data) {
                    if (data.status == 'success') {
                        $("#gai_price_area").html(data.gai_price);
                    }
                }
        );
    });
    // 显示入网协议
    function showProtocol() {
        var url = "<?php echo Yii::app()->createAbsoluteUrl('/seller/goods/showProtocol')?>";
        art.dialog.open(url, {title: '红包协议', lock: true});
    }
    var token = "<?php echo Yii::app()->request->csrfToken;?>";
    var cate_id = <?php echo $_GET['cate_id']?>;
    var rules_id = $('#rules_id');//活动专题筛选
    $('.showRules_a').toggle(function(){
            $('.activeinfo').css('display','none');
        },
        function(){
            $('.activeinfo').css('display','block');
        }
    );
    $('#ative_name').css('display','none');

    //展示活动规则信息介绍
    function showResultInfo(data){
        console.log(data);
        var jsonData = JSON.parse(data);
        if(jsonData.status != 0){
            //检查是否超过活动限制
            if(jsonData.data.seller <= jsonData.data.count){
                $('#time,#rules_id').children('option[value=0]').attr('selected','selected')
                art.dialog.alert('您报名此活动商品数已满,请选择其他活动!');
                return false;
            }
//            style="max-height:215px; min-height:96px; overflow:auto;"
            $('#active_name').html(jsonData.data.name);
            $('#rules_content').html(jsonData.data.description);
            $('#start_date').html(jsonData.data.date_start+'--'+jsonData.data.date_end);
            //$('#end_date').html(jsonData.data.date_end);
            $('#product_nums').html(jsonData.data.limit_num+' 款');
            $('#active_times').html(jsonData.data.start_time+'---'+jsonData.data.end_time);
			$('#singup_start_time').html(jsonData.data.singup_start_time);
				$('#singup_end_time').html(jsonData.data.singup_end_time);
            if(jsonData.data.discount_rate == 0){
                $('#condition').html('限定价格：');
                $('#discount').html(jsonData.data.discount_price+' 元');
            }else{
                $('#condition').html('活动商品折扣：');
                $('#discount').html(jsonData.data.discount_rate+' %');
            }
            $('.showInfoDiv').css('display','');
            $('.showRules').css('display','block');
            $('.activeinfo').css('display','block');
        }
    }


    function changeRules(category_id_val){
        $('.seckill_time').css('display','none');

            $('#date').empty();

            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getSeckillRulesList/'); ?>",
                {'category_id':category_id_val,'YII_CSRF_TOKEN':token,'cate_id':cate_id},
                function(data){
                    var jsonData = JSON.parse(data);
                    if(category_id_val == 3){    //判断是秒杀活动类型
                        var html = '<option value="0">请选择日期</option><br/>';
                        if(jsonData.status != 0 ){
                            $.each(jsonData.data,function(i){
                                html += "<option value='"+jsonData.data[i]['id']+"'>"+jsonData.data[i]['date_start']+'--'+jsonData.data[i]['date_end']+"</option><br/>";
                            });
                        }else{
                            $('.showRules').css('display','none');
                        }
                        $('.activeinfo').css('display','none');
                        $('#date').append(html);
                        $('.seckill').css('display','');

                    }else{
                        var html = '<option value="0">请选择专题</option><br/>';
                        if(jsonData.status != 0 ){
                            $.each(jsonData.data,function(i){
                                html += "<option value='"+jsonData.data[i]['seting_id']+"'>"+jsonData.data[i]['name']+"</option><br/>";
                            });
                        }else{
                            $('.showRules').css('display','none');
                        }
                        $('.activeinfo').css('display','none');
                        $('#rules_id').append(html);

                        $('#ative_name').css('display','');
                    }

                }
            )

    }

    $('#category_id').change(function(){
        //隐藏对应表单清空信息
        $('#rules_id').empty();
        $('.showInfoDiv').css('display','none');
        $('.showRules').css('display','none');
        $('.activeinfo').css('display','none');
        $('.seckill').css('display','none');
        $('#ative_name').css('display','none');
        $('#rules_id').html('');
        $('.seckill_time').css('display','none');
        var category_id_val = $(this).val();
        if(category_id_val != 0 ){
            changeRules(category_id_val);
        }else{

        }
    });


    $('#date').change(function(){
        $('#time').empty();
        $('.showInfoDiv').css('display','none');

        if($(this).val() != 0) {
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getSeckillSeting/'); ?>",
                {'id': $(this).val(),'cate_id':<?php echo $_GET['cate_id'] ?>, 'YII_CSRF_TOKEN': token},
                function (data) {
                    var jsonData = JSON.parse(data);
                    var html = '<option value="0">请选择时间段</option>';
                    if (jsonData.status != 0) {
                        $.each(jsonData.data, function (i) {
                            html += "<option value='" + jsonData.data[i]['id'] + "'>" + jsonData.data[i]['start_time'] + '---' + jsonData.data[i]['end_time'] + "</option><br/>";
                        });
                        $('#time').append(html);
                        $('.seckill_time').css('display','');
                    } else {
                        $('.showRules').css('display', 'none');
                    }
                    $('.activeinfo').css('display', 'none');

                })
        }else{
            $('.seckill_time').css('display','none');
        }
    });

    $('#time').change(function(){
        if($(this).val() != 0){
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getOneSeckllInfo/'); ?>",
                {'id':$(this).val(),'YII_CSRF_TOKEN':token},
                function(data){
                    showResultInfo(data);
                })

            $.post("<?php echo Yii::app()->createUrl('/seller/goods/countContrasts/'); ?>",
                {'id':$(this).val(),'YII_CSRF_TOKEN':token},
                function(data){
                    if(data == 1){
                        $('#num_text').css('display','inline-block');
                    }else{
                        $('#num_text').css('display','none');
                    }
                }
            )
        }else{
            $('.activeinfo').css('display','none');
        }
    });
    $('#rules_id').change(function(){
        if($(this).val() != 0){
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getOneSeckllInfo/'); ?>",
                {'id':$(this).val(),'YII_CSRF_TOKEN':token},
                function(data){
                    showResultInfo(data);
                })

            $.post("<?php echo Yii::app()->createUrl('/seller/goods/countContrasts/'); ?>",
                {'id':$(this).val(),'YII_CSRF_TOKEN':token},
                function(data){
                    if(data == 1){
                        $('#num_text').css('display','inline-block');
                    }else{
                        $('#num_text').css('display','none');
                    }
                }
            )
        }else{
            $('.showInfoDiv').css('display','none');
            $('.activeinfo').css('display','none');
        }
    });
    $('#Goods_price').mouseout(function(){
        if($(this).val() < 0 ){
            $(this).focus();
            $('#submitBtn').attr('disabled','disabled');
        }else{
            $('#submitBtn').removeAttr('disabled');
        }
    })
</script>