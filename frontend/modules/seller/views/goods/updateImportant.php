<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
$title = Yii::t('sellerGoods', '商品重要信息编辑');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '宝贝管理') => array('index'),
    $title,
);
//多货币转换
$model->price = Common::rateConvert($model->price);
$model->gai_price = Common::rateConvert($model->gai_price);
$model->market_price = Common::rateConvert($model->market_price);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/plugins/iframeTools.js', CClientScript::POS_END);
?>
<style>
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
        /*display: none;*/
    }
    .showRules_a{
        width:100%;
        height: 100%;
        display: inline-block;
    }

    .activeinfo_content{
        width: 100%; max-height:215px; overflow:auto; min-height:96px;
    }
</style>
<div class="toolbar">
    <b><?php echo $title; ?></b>
    <span><?php echo $model->name ?>   <?php echo Yii::t('sellerGoods', '编辑'); ?></span>
</div>

<?php
//保存当前活动的rules_seting_id;
$checkid = 0;
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
<div class="proAddStepTwo">
    <h3 class="title"><?php echo Yii::t('sellerGoods', '重要信息'); ?></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
        <tr>
            <th><?php echo Yii::t('sellerGoods', '温馨提示：'); ?></th>
            <td class="red"><?php echo Yii::t('sellerGoods', '商品重要信息修改之后商品状态会变更为“审核中”，待管理员审核通过'); ?></td>
        </tr>
        <tr >
            <th width="10%"> <?php echo $form->labelEx($model, 'id'); ?></th>
            <td width="90%">
                <?php echo $model->id ?>
            </td>
        </tr>
        <tr >
            <th width="10%"> <?php echo $form->labelEx($model, 'market_price'); ?></th>
            <td width="90%">
                <?php echo HtmlHelper::formatPrice($model->market_price) ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'price'); ?></th>
            <td>
                <?php echo $form->textField($model, 'price', array('size' => 11, 'maxlength' => 8, 'class' => 'inputtxt1', 'style' => '125px')); ?>
                <?php echo $form->error($model, 'price') ?>
                (<?php echo CHtml::link(Yii::t('sellerGoods','历史价格'),'#',array('id'=>'historyPrice')) ?>)
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'gai_price'); ?></th>
            <td>
                <div id="gai_price_area"><?php echo $model->gai_price; ?></div>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model, 'discount'); ?></th>
            <td><?php
                if ($model->isNewRecord) {
                    $model->discount = 0;
                    $model->sign_integral = 0;
                }
                ?>
                <?php echo $form->textField($model, 'discount', array('size' => 11, 'maxlength' => 11, 'class' => 'inputtxt1', 'style' => '125px')); ?>
                <?php echo $form->error($model, 'discount'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sign_integral'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sign_integral', array('size' => 11, 'maxlength' => 11, 'class' => 'inputtxt1', 'style' => '125px')); ?>
                <?php echo $form->error($model, 'sign_integral'); ?>
            </td>
        </tr>
        <tr>
            <th rowspan="3"><?php echo Yii::t('sellerGoods', '运输方式'); ?><b class="red">*</b></th>
            <td>
                <?php
                $freightArray = $model::freightPayType();
                unset($freightArray[Goods::FREIGHT_TYPE_CASH_ON_DELIVERY]); //不再支持运费到付
                echo $form->radioButtonList($model, 'freight_payment_type', $freightArray, array('separator' => ' ')) ?>
                <?php echo $form->error($model, 'freight_payment_type') ?>
                <div id="templateSelect" style="display: <?php echo $model->freight_template_id ? 'block' : 'none' ?>">　　　
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
                <?php echo $form->checkBox($model, 'is_score_exchange', array('class' => 'text-input-bj')) ?>
                <?php echo $form->label($model, 'is_score_exchange') ?> *
                <?php echo $form->error($model, 'is_score_exchange'); ?>
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
    <?php
     $hasDate =SpecialTopicGoods::hasActive($model->id);
     if(empty($hasDate)){ ?>
         <h3 class="title"><?php echo Yii::t('sellerGoods', '参加活动'); ?>
                 <?php 
                    if($model->seckill_seting_id){
                        $relation = SeckillProductRelation::model()->find(array(
                                        'select'=>'status',
                                        'condition'=>'product_id=:pid AND rules_seting_id=:sid',
                                        'params'=>array(':pid'=>$model->id,':sid'=>$model->seckill_seting_id)
                                    ));
                        if($relation){
                            $status = $relation->status;
                            if($status == SeckillProductRelation::STATUS_NOPASS){
                            $audit = Yii::app()->db->createCommand()
                                ->select('t.status,goods_id,content,relation_id')
                                ->from('{{seckill_product_audit}} t')
                                ->leftJoin('{{seckill_product_relation}} s','s.status=t.status')
                                ->where('goods_id = :id and relation_id=:r_id',array(':id'=>$model->id,':r_id'=>$model->seckill_seting_id))
                                ->order('created desc')
                                ->queryRow();
                            if($audit){
                                if($audit['status'] == 2 && !empty($ActiveData)){ 
//                                    foreach($Rules as $r){
                                        if($audit['relation_id'] == $ActiveData['id']){
                                            echo "<span class='red'>{$ActiveData['name']} 活动因为“{$audit['content']}”原因未通过审核，请参照提示进行更新，也可以报名其他活动</span>";
                                        }
//                                    }
                                }
                            }
                        }}
                    }
                 ?>
         </h3>
         <input type="hidden" name="Goods[product_category]" value="<?php echo SeckillCategory::getTopParentId($model->category_id) ?>">


		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT3">
			<tr>
				<th>请选择活动类型：</th>
				<td class="red" width="90%">
					<select onmousewheel="return false" class="inputtxt1" name="Goods[seckill_category_id]" id="category_id" style="width:150px;">
							 <option value="0">不参与</option>
							 <?php foreach($CategoryList as $key => $value){?>
								 <option <?php if(isset($ActiveData['endtimes']) && time() < strtotime($ActiveData['endtimes']) && !empty($ActiveData) && $value['id'] == $ActiveData['category_id']){echo 'selected="selected"';} ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
							 <?php }?>
						 </select>
                                    <span class="cd-msg"></span>
				</td>
			</tr>

			<tr id="ative_name" <?php if(isset($ActiveData['endtimes']) && time() > strtotime($ActiveData['endtimes']) || empty($ActiveData) || (isset($ActiveData['category_id']) && $ActiveData['category_id'] == 3)){ echo 'style="display: none;"';}?>  >
				 <th>请选择活动名称：</th>
				 <td width="90%">
					 <select onmousewheel="return false" class="inputtxt1" id="Goods_rules_id" name="Goods[active_seting_id]">
                         <?php if(!empty($Rules)){
                         foreach($Rules as $key => $value){ ?>
                             <option <?php if(!empty($ActiveData) && $value['seting_id'] == $ActiveData['id'] ){ echo "selected='selected'";} ?> value="<?php if(!empty($ActiveData)) echo $value['seting_id'] ?>"><?php if(isset($value['name'])) echo $value['name'];?></option>
                         <?php } } ?>
                     </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                        <span class='red tops_messages'>
                            <?php $count=0; if(!empty($ActiveData)) : if($ActiveData['seller'] != 0):?>
                            <?php  
                                $count = SeckillProductRelation::model()->count(
                                    'seller_id=:sid AND status!=:status AND rules_seting_id=:rid', 
                                    array(':sid'=>$this->storeId,':status'=>  SeckillProductRelation::STATUS_NOPASS,':rid'=>$ActiveData['id'])
                                );
                            ?>
                                提示：各店铺最多可有<?php echo $ActiveData['seller']?>件商品参加活动，本店已参加<?php echo $count?>件商品
                            <?php endif;endif;?>
                        </span>    
				 </td>
			</tr>

			<tr class="seckill" <?php if(isset($ActiveData['endtimes']) && time() > strtotime($ActiveData['endtimes']) || empty($ActiveData) || (isset($ActiveData['category_id']) && $ActiveData['category_id'] != 3)){ echo 'style="display: none;"';}?>>
                 <th width="10%">请选择活动日期：</th>
                 <td width="90%">
                     <select onmousewheel="return false" class="inputtxt1" id="date" name="rules_id">
                         <option value="0">请选择活动日期</option>
                         <?php if(!empty($Rules)){
                             foreach($Rules as $key => $value){ ?>
                                 <option <?php if(!empty($ActiveData) && $value['id'] == $ActiveData['rules_id'] ){ echo "selected='selected'";} ?> value="<?php if(!empty($ActiveData)) echo $value['id'] ?>"><?php if(isset($value['date_start'])) echo $value['date_start'].'--'.$value['date_end']?></option>
                            <?php } } ?>
                     </select>
                 </td>
             </tr>
             <tr class="seckill_time" <?php if(isset($ActiveData['endtimes']) && time() > strtotime($ActiveData['endtimes']) || empty($ActiveData) || (!$ActiveData['category_id'] || $ActiveData['category_id'] != 3)){ echo 'style="display: none;"';}?> >
                 <th >请选择活动时间：</th>
                 <td id="Goods_times" width="90%">
                     <select onmousewheel="return false" class="inputtxt1" id="Goods_time" name="Goods[seckill_seting_id]">
                        <option value="0">请选择活动时间</option>
                         <?php if(!empty($SetingList)){
                                foreach($SetingList as $key=>$value ){ ?>
                                    <option <?php if(!empty($ActiveData) && $value['id'] == $ActiveData['id'] ){ echo "selected='selected'";} ?>  value="<?php if(!empty($ActiveData)) echo $value['id'] ?>"><?php if(isset($value['start_time'])) echo $value['start_time'].'--'.$value['end_time']?></option>
                        <?php } } ?>

                     </select>
                     &nbsp;&nbsp;&nbsp;&nbsp;<span class='red tops_messages'>
                    <?php if(!empty($ActiveData)) : if($ActiveData['seller'] != 0):?>
                    <?php  
                        $count = SeckillProductRelation::model()->count(
                            'seller_id=:sid AND status!=:status AND rules_seting_id=:rid', 
                            array(':sid'=>$this->storeId,':status'=>  SeckillProductRelation::STATUS_NOPASS,':rid'=>$ActiveData['id'])
                        );
                    ?>
                        提示：各店铺最多可有<?php echo $ActiveData['seller']?>件商品参加活动，本店已参加<?php echo $count?>件商品
                    <?php endif;endif;?>
                        </span>
                 </td>
             </tr>

             <tr class="showInfoDiv" <?php if(isset($ActiveData['endtimes']) && time() > strtotime($ActiveData['endtimes'])){echo"style='display:none'"; } ?> >
                 <th>
                     <p class="showRules"><a class="showRules_a" href="#">活动细则：</a></p>
				</th>
				<td>
                     <div class="activeinfo">
					 	<div>
                             <dd>活动日期：
                             <span id="start_date"><?php if($ActiveData) echo $ActiveData['date_start'].'--'.$ActiveData['date_end'] ?></span></dd>
                             <dd>活动时间：
                             <span id="active_times"><?php if($ActiveData) echo $ActiveData['start_time'].'--'.$ActiveData['end_time'] ?></span></dd>
                             <dd>报名开始时间：
                             <span id="singup_start_time"><?php if($ActiveData) echo $ActiveData['singup_start_time']; ?></span></dd>
                             <dd>报名截止时间：
                             <span id="singup_end_time"><?php if($ActiveData) echo $ActiveData['singup_end_time'] ?></span></dd>
                             <dd>产品数量：
                             <span id="product_nums"><?php if($ActiveData) echo $ActiveData['limit_num'] ?></span>
                            <?php
                            $display = 'display:none';
                            if($ActiveData){
                                $Contrast = floor($ActiveData['counts'] / $ActiveData['limit_num'] * 100);
                                if($Contrast > 30){
                                    $display = '';
                                }
                            }
                            ?>
                             <span style="color: red;<?php echo $display ; ?>" id="num_text">活动参与的商品数量即将满额，请尽快上传</span>
                             </dd>
							 <dd>
                             <span id="condition">
                                 <?php if($ActiveData && $ActiveData['discount_price'] == '0.00' ){?>
                                    活动商品折扣： <?php if($ActiveData) echo $ActiveData['discount_rate']?>  %
                                <?php }else{?>
                                     限定价格： <?php if($ActiveData) echo $ActiveData['discount_price']?>  元
                                <?php } ?>
                             </span>
                             <span id="discount"></span>
							 </dd>
						</div>
                     </div>
                 </td>
             </tr>

			 <tr class="showInfoDiv" <?php if(isset($ActiveData['endtimes']) && time() > strtotime($ActiveData['endtimes'])){echo"style='display:none'"; } ?> >
                 <th>
                     <p class="showRules"><a class="showRules_a" href="#"><span id="active_name"><?php if($ActiveData) echo $ActiveData['name']?></span>活动协议：</a></p>
				</th>
				<td>
                     <div class="activeinfo">
						<div class="activeinfo_content" style="max-height:215px; min-height:96px; overflow:auto;word-break:break-all;
">
                             <span id="rules_content"><?php if($ActiveData) echo $ActiveData['description']?></span>
                         </div>
                     </div>
                 </td>
             </tr>

         </table>
        <?php } ?>

    <div class="next">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerGoods', '提交') : Yii::t('sellerGoods', '保存'), array('class' => 'sellerBtn06', 'id' => 'submitBtn'));
        ?>　　　
        <a href="<?php echo $this->createAbsoluteUrl('goods/index') ?>" class="sellerBtn01">
            <span><?php echo Yii::t('sellerGoods', '返回'); ?></span></a>
    </div>
    <?php $this->endWidget(); ?>

    <script type="text/javascript">
    $(function(){
        //价格输入
        $("#Goods_market_price,#Goods_gai_price,#Goods_price,#Goods_discount,#Goods_sign_integral").keyup(function() {
            if (isNaN(this.value))
                this.value = null;
        });
        $(".spec_table input[data_type='price']").live('keyup', function() {
            if (isNaN(this.value))
                this.value = null;
        });
        $(".spec_table input[data_type='stock']").live('keyup', function() {
            if (!/^[\d]+$/.test(this.value))
                this.value = null;
        });
        //运输方式
        $("#Goods_freight_payment_type input").click(function() {
            $("#templateSelect").hide();
            $("#Goods_freight_template_id").val('');
        });
        $("#Goods_freight_payment_type input:last").click(function() {
            $("#templateSelect").show();
        });

        $("#Goods_price").change(function(){
    		var price = $(this).val();
    		var cat_id = '<?php echo $model->category_id; ?>';
    		$.getJSON("<?php echo Yii::app()->createUrl('/seller/goods/getGaiPrice/'); ?>",
    	            "price=" + price + "&cat_id=" + cat_id ,
    	            function (data) {
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
        $("#historyPrice").click(function(){
            var url = "<?php echo $this->createAbsoluteUrl('/seller/goods/goodsPrice',array('goods_id'=>$model->id)) ?>";
            art.dialog.open(url);

        });

        var token = "<?php echo Yii::app()->request->csrfToken;?>";
        var cate_id = <?php echo $model->category_id?>;
        var rules_id = $('#Goods_rules_id');//活动专题筛选
        <?php if(!empty($ActiveData)) {?>
        var old_category_id = <?php if(!empty($ActiveData))  echo $ActiveData['category_id']; ?>;
        var seting_id = <?php echo $ActiveData['id']; ?>;
        var old_rules_id = <?php echo $ActiveData['rules_id']; ?>;
        
        var checkid=<?php echo $ActiveData['id']; ?>;
        var seller = <?php echo $ActiveData['seller'];?>;
        var count = <?php echo $count;?>;
        <?php if($ActiveData['category_id'] == 3){ ?>
        $('#ative_name').css('display','none');
        <?php } ?>

        <?php }else{ ?> 
            //没有任何活动的商品增加活动
        var old_category_id = seting_id = old_rules_id = count = 0;
        var checkid=0; // 检查前后是否是同一个活动
        var seller = 0; // 允许参加个数
        $('.showInfoDiv').css('display','none');
        //$('.activeinfos').css('display','none');
        <?php } ?>


        //展示活动规则信息介绍
        function showResultInfo(data){
            var jsonData = JSON.parse(data);
            if(jsonData.status != 0){
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
                if(jsonData.data.seller != 0){ //每个商家参与活动数受限时
                    seller = jsonData.data.seller; //活动的受限数
                    count = jsonData.data.count;
                    $('.tops_messages').html('提示：各店铺最多可有'+jsonData.data.seller+'件商品参加活动，本店已参加'+jsonData.data.count+'件商品');
                }
                $('.showInfoDiv').css('display','');
                $('.showRules').css('display','block');
//                $('.activeinfos').css('display','');
            }
        }

        function changeRules(category_id_val){
            $('.seckill_time').css('display','none');
            $('.showInfoDiv').css('display','none');
            $('#date').empty();
            $('#Goods_time').empty();
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getSeckillRulesList/'); ?>",
                {'category_id':category_id_val,'YII_CSRF_TOKEN':token,'cate_id':cate_id},
                function(data){
                    var jsonData = JSON.parse(data);
                    if(category_id_val == 3){    //判断是秒杀活动类型
                        var html = '<option value="0">请选择日期</option><br/>';
                        if(jsonData.status != 0 ){
                            $.each(jsonData.data,function(i){
                                html += "<option value='" + jsonData.data[i]['id'] + "'>" + jsonData.data[i]['date_start'] + '--' + jsonData.data[i]['date_end'] + "</option><br/>";
                            });
                        }else{
                            $('.showRules').css('display','none');
                        }
                        $('.seckill_time').css('display','none');
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
                        //$('.activeinfos').css('display','none');
                        $('#Goods_rules_id').append(html);
                        if(category_id_val>0){
                            $('#ative_name').css('display','');
                        }

                    }

                }
            )

        }

        function getSeckillSeting(val){
            $('#Goods_time').empty();
            $('.showInfoDiv').css('display','none');
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getSeckillSeting/'); ?>",
                {'id': val,'cate_id':<?php echo $model['category_id'] ?>, 'YII_CSRF_TOKEN': token},
                function (data) {
                    var jsonData = JSON.parse(data);
                    var html = '<option value="0">请选择时间段</option>';
                    if (jsonData.status != 0) {
                        $.each(jsonData.data, function (i) {
                            html += "<option value='" + jsonData.data[i]['id'] + "'>" + jsonData.data[i]['start_time'] + '---' + jsonData.data[i]['end_time'] + "</option><br/>";
                        });
                    } else {
                        $('.showRules').css('display', 'none');
                    }
                    //$('.activeinfos').css('display', 'none');
                    $('#Goods_time').append(html);
                    $('.seckill_time').css('display','');
                })
        }
        


        $('#category_id').change(function(){
            $('#Goods_rules_id').empty();
            $('#ative_name').css('display','none');
            $('.showInfoDiv').css('display','none');
            $('.showRules').css('display','none');
            $('.activeinfo').css('display','none');
            $('.seckill').css('display','none');
            $('.seckill_time').css('display','none');
            $('.tops_messages').html('');
            $('#Goods_rules_id').html('');
            $('#date').empty();
            var category_id_val = $(this).children('option:selected').val();//parseInt($(this).val());            
            if(category_id_val>0){
                changeRules(category_id_val);                
            }
            setTimeout(function(){checkProduct(category_id_val)},500);
        })
        
        //检测当前商品是否有参加拍卖活动
        function checkProduct(category_id_val)
        {
            var goodsId = <?php echo $model->id?>;
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/checkProduct/'); ?>",
                {'id':goodsId,'YII_CSRF_TOKEN':token,cateId:category_id_val},
                function(data){
                    var jsonData = JSON.parse(data);
                    if(jsonData.status == 1) {
//                        alert(jsonData.message);
                        $('.cd-msg').text(jsonData.message);
                        $('#ative_name').css('display','none');
                        $('.seckill').css('display','none');
                        $('#submitBtn').css('cursor','not-allowed').prop('disabled',true);
                    } else {
                        $('.cd-msg').text('');
                        $('#submitBtn').css('cursor','pointer').removeAttr('disabled');
                    }
                }
            )
            
        }

        //活动类型名称切换结束

        $('.showRules_a').toggle(function(){
                $('.activeinfo').css('display','none');
            },
            function(){
                $('.activeinfo').css('display','block');
            });

        $('#date').change(function(){
            $('#Goods_time').empty();
            $('.showInfoDiv').css('display','none');
            $('#Goods_rules_id').empty();
            $('#Goods_times .tops_messages').text('');
            if($(this).val() != 0) {
                getSeckillSeting($(this).val());
            }else{
                $('.seckill_time').css('display','none');
            }
            //alert($('#Goods_times select option:selected').attr('value'));
        });

        function getOneSeckllInfo(val){
            $.post("<?php echo Yii::app()->createUrl('/seller/goods/getOneSeckllInfo/'); ?>",
                {'id':val,'YII_CSRF_TOKEN':token},
                function(data){
                    showResultInfo(data);
                    $('.activeinfo').css('display','');
                })

            $.post("<?php echo Yii::app()->createUrl('/seller/goods/countContrasts/'); ?>",
                {'id':val,'YII_CSRF_TOKEN':token},
                function(data){
                    if(data == 1){
                        $('#num_text').css('display','inline-block');
                    }else{
                        $('#num_text').css('display','none');
                    }
                }
            )

        }

        $('#Goods_time').change(function(){
            $('.tops_messages').html('');
            checkid = $(this).val();
            if($(this).val() != 0){
                getOneSeckllInfo($(this).val());
            }else{
                $('.showInfoDiv').css('display','none');
                $('.activeinfo').css('display','none');
            }
        });


// 这里了
        $('#Goods_rules_id').change(function(){
            $('.tops_messages').html(''); 
            checkid = $(this).val();
            if($(this).val() != 0){
                getOneSeckllInfo($(this).val());
            }else{
                $('.showInfoDiv').css('display','none');
                $('.activeinfo').css('display','none');
            }
        });

        //getOneSeckllInfo(seting_id);
        <?php if($model->join_activity == 0){ ?>
        if(old_category_id == 3){
            //getSeckillSeting(old_rules_id);
        }
        <?php } ?>

        $('#Goods_price').mouseout(function(){
            if($(this).val() < 0 ){
                $(this).focus();
                $('#submitBtn').attr('disabled','disabled');
            }else{
                $('#submitBtn').removeAttr('disabled');
            }
        })
        $('#goods-form').submit(function(){
            var active_id = $('#category_id').val();
            if(active_id != 0 && seller != 0 && parseInt(seller) <= parseInt(count)){ //是否参加活动，是否无限制，是否超过限时数 
                if(seting_id == 0 || seting_id != checkid){ 
                    art.dialog.alert('本店参与当前活动的商品数量已达上限，该商品不能再申请参与当前活动，请重新整理参与活动的商品或选择其他活动');
                    return false;
                }
            }
            return true;
        })
    })
    </script>