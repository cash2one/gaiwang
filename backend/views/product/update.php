<?php
/* @var $this ProductController */
/* @var $model Product */
/** @var  $form CActiveForm */

$this->breadcrumbs = array(
    '商品' => array('admin'),
    '编辑'
);
$change = unserialize($model->change_field);
if(empty($change)) $change = array();
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'beforeValidate'=>'js:function(form,data){
            if($("#seckill_status").prop("checked")){
                var content = $("#seckill_content").val();
                if(jQuery.trim(content) == "") {
                    $("#seckill_content_em").text("审核不通过，必须写原因").show();
                    return false;
                }
            }
            return true;
        }',
        'afterValidate'=>'js:function(form, data, hasError){
            if(hasError==false){
                $(".showMore:hidden").find("td").html("");
                return true;
            }
            return false;
        }',
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <tbody>

        <tr>
            <th colspan="2"></th>
        </tr>
            <?php if($model->seckill_seting_id != 0){?>
            <tr>
                <th colspan="2" class="title-th odd">参加活动</th>
            </tr>
            <tr>
                <th align="right">商品参加的活动：</th>
                <td> <?php if(isset($Active['name'])) echo $Active['name']?></td>
            </tr>


        <tr>
            <th align="right">活动日期：</th>
            <td> <?php if(isset($Active['date_start'])) echo $Active['date_start']?>---<?php if(isset($Active['date_end'])) echo $Active['date_end']?></td>
        </tr>

        <tr>
            <th align="right">活动时间：</th>
            <td> <?php if(isset($Active['start_time'])) echo $Active['start_time']?>----<?php if(isset($Active['end_time'])) echo $Active['end_time']?></td>
        </tr>

        <?php  if(isset($Active['discount_price']) && $Active['discount_price'] > 0) { ?>
        <tr>
            <th align="right" style="width: 140px;">活动期内商品价格：</th>
            <td> <?php  if(isset($Active['discount_price'])) echo $Active['discount_price']?> 元</td>
        </tr>
        <?php }else{ ?>

        <tr>
            <th align="right">活动商品折扣：</th>
            <td> <?php if(isset($Active['discount_rate'])) echo $Active['discount_rate']?> %</td>
        </tr>
        <?php } ?>

        <tr>
            <th align="right">活动商品数量：</th>
            <td> <?php  if(isset($Active['counts'])) echo $Active['counts']?>/<?php  if(isset($Active['limit_num'])) echo $Active['limit_num']?>

                <?php if(isset($Active['limit_num']) && ($Active['counts'] >= $Active['limit_num'])){ ?>
                    <span style="color:red;position: relative;left:10px;">活动商品数量已满，无法通过审核</span>
                <?php } ?>
            </td>
            <input type="hidden" value="<?php if(isset($Active['limit_num'])) echo $Active['limit_num']?>" name="seckill[limit_num]" />
        </tr>

        <tr>
            <th align="right">是否通过活动审核：</th>
            <td>
                <?php
                    $disabled = '';
                    if(isset($Active['limit_num']) && ($Active['counts'] >= $Active['limit_num'])){
                        $disabled =  "disabled=disabled; ";
                    } 
                    if(isset($Active['id'])){
                        // select audit records
                        $active_audit = Yii::app()->db->createCommand()
                                ->select('t.goods_id,t.status,p.rules_id,t.content,t.created')
                                ->from('{{seckill_product_audit}} t')
                                ->join('{{seckill_rules_seting}} p', 'p.id=t.relation_id')
                                ->where('goods_id=:goods_id AND relation_id=:relation_id', array(':goods_id' => $model->id, ':relation_id' => $Active['id']))
                                ->queryAll();
                        if ($active_audit)
                            $end = end($active_audit);
                    }
                ?>
                <input type="radio" <?php echo $disabled; if(isset($Active['statuss']) && $Active['statuss'] == 1){ echo 'checked="checked"'; } ?>  name="seckill[status]" value="1" />通过
                <input type="radio" <?php if(isset($Active['statuss']) && $Active['statuss'] == 2){ echo 'checked="checked"';} ?> id="seckill_status"  name="seckill[status]" value="2" />不通过 </td>
        </tr>
        <tr>
            <th align="right">审核未通过原因(不通过时必填):</th>
            <td>
                <textarea class="text-input-bj" cols="50" maxlength="200" name='seckill[content]' id="seckill_content" onfocus="$('#seckill_content_em').hide()"><?php echo (isset($Active['statuss']) && $Active['statuss'] == 2 && isset($end)) ? $end['content'] : '' ?></textarea>(限200字内)
                <div class="errorMessage" id="seckill_content_em" style="display:none"></div>
            </td>
        </tr>
        <?php if(isset($Active['id']) && !empty($active_audit)) :?>
        <tr>
            <th><?php echo '审核历史记录'?>:</th>
            <td>
                <?php
                     // select audit records
//                    $active_audit = Yii::app()->db->createCommand()
//                                ->select('t.goods_id,t.status,p.rules_id,t.content,t.created')
//                                ->from('{{seckill_product_audit}} t')
//                                ->join('{{seckill_rules_seting}} p','p.id=t.relation_id')
//                                ->where('goods_id=:goods_id AND relation_id=:relation_id',array(':goods_id'=>$model->id,':relation_id'=>$Active['id']))
//                                ->queryAll();
                ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
                    <tr>
                        <td class="title-th" width="15%">审核时间</td>
                        <td class="title-th" width="15%">活动名称</td>
                        <td class="title-th" width="15%">活动类型</td>
                        <td class="title-th" width="15%">审核结果</td>
                        <td class="title-th" width="40%">未通过审核原因</td>
                    </tr>
                    <?php foreach ($active_audit as $ac):?>
                    <tr>
                        <td style='text-align:center' width="15%"><?php echo date('Y-m-d H:i:s',$ac['created'])?></td>
                        <td style='text-align:center' width="15%">
                        <?php 
                            $main = SeckillRulesMainSeller::getOne($ac['rules_id']);
                            echo empty($main) ? '活动名称获取失败' : $main['name'];
                        ?></td>
                        <td style='text-align:center' width="15%">
                            <?php 
                                $cate = SeckillCategory::model()->findByPk($main['category_id']);
                                if(is_object($cate)) echo $cate->name;
                                else '无此活动';
                            ?>
                        </td>
                        <td style='text-align:center' width="15%"><?php $status = SeckillProductRelation::showStatus();echo isset($status[$ac['status']])?$status[$ac['status']]:'审核状态有误'?></td>
                        <td style='word-break: break-all' width="40%"><?php echo $ac['content']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
        <?php endif;}?>
        <tr>
            <th colspan="2" class="title-th odd">基本信息</th>
        </tr>
        <tr>
            <th style="width: 120px" align="right">
                <?php if(!empty($change) && in_array(1, $change)):?><i class="orange main02_icon">1</i><?php endif;?>
                <?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => "text-input-bj  long valid")); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'code', array('class' => "text-input-bj  long valid")); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'weight'); ?></th>
            <td>
                <?php echo $form->textField($model, 'weight', array('class' => "text-input-bj  least")); ?>
                <?php echo $form->error($model, 'weight'); ?>
                (单位为kg, 只保留两位小数)
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'size'); ?></th>
            <td>
                <?php echo $form->textField($model, 'size', array('class' => "text-input-bj  least")); ?>
                <?php echo $form->error($model, 'size'); ?>
                (单位为m³,只保留两位小数)
            </td>
        </tr>

        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'brand_name'); ?></th>
            <td>
                <?php echo $form->hiddenField($model, 'brand_id'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'brand_name',
                    'source' => $this->createAbsoluteUrl('/product/suggestBrands'),
                    'htmlOptions' => array('class' => 'text-input-bj  least', 'style' => 'width:300px;'),
                ));
                ?>
                <?php echo $form->error($model, 'brand_id'); ?>
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php if(!empty($change) && in_array(2, $change)):?><i class="orange main02_icon">2</i><?php endif;?>
                <?php echo Yii::t('product','所属类别') ?>
            </th>
            <td>
                <?php echo Category::getCategoryName($model->category_id); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'scategory_id'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'scategory_id', Scategory::model()->showAllSelectCategory($model->store_id), array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'scategory_id'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"></th>
            <td id="gilid">
                <input type="button" id="showMore" value="显示更多"/>
                (注意：如需修改显示更多的内容，请保持内容显示状态)
            </td>
        </tr>
        <tr class="showMore">
            <th align="right">
                <?php if(in_array(3, $change)):?><i class="orange main02_icon">3</i><?php endif;?>
                <?php echo $form->labelEx($model, 'stock'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'stock', array('class' => "text-input-bj  least",'id'=>'Goods_stock')); ?>
                <?php echo $form->error($model, 'stock'); ?>
            </td>
        </tr>
        <tr class="showMore">
            <th align="right">
                <?php if(!empty($change) && in_array(4, $change)):?><i class="orange main02_icon">4</i><?php endif;?>
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td colspan="2">
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'content',
                	'save_path' => 'uploads/files',
                	'url' => IMG_DOMAIN . '/files'
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr class="showMore">
            <th align="right">
                <?php if(!empty($change) && in_array(5, $change)):?><i class="orange main02_icon">5</i><?php endif;?>
                <?php echo $form->labelEx($model, 'thumbnail'); ?> <!--<span class="required">*</span>-->
            </th>
            <td>
                <?php
                $this->widget('common.widgets.CUploadPic', array(
                    'attribute' => 'thumbnail',
                    'model'=>$model,
                    'form'=>$form,
                    'num' => 1,
                    'btn_value'=> Yii::t('sellerGoods', '上传图片'),
                    'folder_name' => 'files',
                ));
                ?>
                请上传750*750像素的图片  <span id="file_label"></span>
                <?php echo $form->error($model, 'thumbnail'); ?>
                <?php
                    echo CHtml::hiddenField('oldThumbnail', $model->thumbnail);
                    echo "<br>";
                ?>
            </td>
        </tr>
        <tr class="showMore">
            <th align="right">
                <?php if(!empty($change) && in_array(6, $change)):?><i class="orange main02_icon">6</i><?php endif;?>
                图片列表：
            </th>
            <td>
                <?php
                $this->widget('common.widgets.CUploadPic', array(
                    'attribute' => 'path',
                    'model'=>$imgModel,
                    'form'=>$form,
                    'num' => 6,
                    'btn_value'=> Yii::t('sellerGoods', '上传图片'),
                    'folder_name' => 'files',
                ));
                ?>
                请上传750*750像素的图片
            </td>
        </tr>

         <!--颜色、尺码、库存-->
        <tr class="showMore">
            <td colspan="2">
                <?php
                $this->renderPartial('_updateSpec',array(
                    'model'=>$model,
                    'spec' => $spec, //规格值数据,给视图中的循环选择规格用,
                    'typeSpec' => $typeSpec,
                    'goodsSpec'=>$goodsSpec
                ))
                ?>
            </td>    
         </tr>
        <tr>
            <th colspan="2" class="title-th even">重要信息</th>
        </tr>
        <tr >
            <th align="right"><?php echo $form->labelEx($model, 'market_price'); ?></th>
            <td>
                <?php echo '￥',$model->market_price ?>
            </td>
        </tr>
        <tr style="display: none;">
            <th><?php echo $form->labelEx($model, 'gai_price'); ?></th>
            <td>
                <div id="gai_price_area"><?php echo $model->gai_price; ?></div>
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php if(!empty($change) && in_array(7, $change)):?><i class="orange main02_icon">7</i><?php endif;?>
                <?php echo $form->labelEx($model, 'price'); ?>
            </th>
            <td>
                <?php echo $form->textField($model, 'price', array('size' => 11, 'maxlength' => 8, 'class' => 'text-input-bj  least')); ?>
                <?php echo $form->error($model, 'price'); ?>
                (<?php echo CHtml::link('历史价格','#',array('id'=>'historyPrice')) ?>)
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'gai_income'); ?></th>
            <td>
                <?php echo $form->textField($model, 'gai_income', array('class' => "text-input-bj  least")); ?>%
                <?php echo $form->error($model, 'gai_income'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'discount'); ?></th>
            <td>
                <?php echo $form->textField($model, 'discount', array('class' => "text-input-bj  least")); ?>
                <?php echo $form->error($model, 'discount'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'sign_integral'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sign_integral', array('class' => "text-input-bj  least")); ?>
                <?php echo $form->error($model, 'sign_integral'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'jf_pay_ratio'); ?></th>
            <td>
                <?php echo $form->textField($model, 'jf_pay_ratio', array('class' => "text-input-bj  least")); ?>%
                <?php echo $form->error($model, 'jf_pay_ratio'); ?> （请填写0-110之间的整数，0不限制支付，大于100只能用网银支付）
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php if(!empty($change) && in_array(8, $change)):?><i class="orange main02_icon">8</i><?php endif;?>
                <?php echo $form->labelEx($model, 'freight_payment_type'); ?>
            </th>
            <td>
                <?php echo $form->radioButtonList($model, 'freight_payment_type', Goods::freightPayType(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'freight_payment_type'); ?>
                <div id="freight_payment_d" style=" <?php if ($model->freight_payment_type != Goods::FREIGHT_TYPE_MODE): ?> display: none <?php endif; ?>">
                    <?php echo Yii::t('goods', '选择运费模板'); ?>：
                    <?php
                    echo $form->dropDownList($model, 'freight_template_id', CHtml::listData(
                                    FreightTemplate::model()->findAllByAttributes(array('store_id' => $model->store_id)), 'id', 'name'
                            ), array('class' => 'selectTxt1', 'empty' => '请选择'))
                    ?>
                    <?php echo $form->error($model, 'freight_template_id') ?>            
                </div>
                <script>
                    $("input[name='Goods[freight_payment_type]']").click(function() {
                        if ($(this).val() ==<?php echo Goods::FREIGHT_TYPE_MODE ?>) {
                            $("#freight_payment_d").show();
                        } else {
                            $("#freight_payment_d").hide();
                        }
                    });
                </script>
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php if(!empty($change) && in_array(9, $change)):?><i class="orange main02_icon">9</i><?php endif;?>
            </th>
            <td>
                <?php echo $form->checkBox($model, 'is_score_exchange'); ?>
                <?php echo $form->labelEx($model, 'is_score_exchange'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"></th>
            <td>
                <?php echo $form->checkBox($model, 'is_publish'); ?>
                <?php echo $form->labelEx($model, 'is_publish'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <?php echo $form->checkBox($model, 'show'); ?>
                <?php echo $form->labelEx($model, 'show'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => "text-input-bj  least")); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
        <tr>
        <th><?php echo Yii::t('goods','商品属性'); ?></th>
        <td>
            <?php foreach ($attribute as $v): ?>
                <div class="row">
                    <label><?php echo $v['name'] ?>:</label>
                    <select  name="attr[<?php echo $v['id'] ?>]">
                        <?php foreach ($v->attributeData as $v2): ?>
                            <option value="<?php echo $v2->id ?>"
                                <?php echo $this->checkAttribute($model->attribute,$v['id'],$v2->name)?'selected':null ?> >
                                <?php echo $v2->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </td>
    </tr>

        <tr>
            <th colspan="2" class="title-th odd">
                SEO优化搜索信息
            </th>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj', 'size' => 80)); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textField($model, 'description', array('class' => 'text-input-bj', 'size' => 80)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="title-th odd">审核信息</th>
        </tr>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'status'); ?></th>
            <td id="StatusValue">
                <?php echo $form->radioButtonList($model, 'status', Goods::getStatus(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'status'); ?>
                <input type="hidden" id="status" value="<?php echo $model->status ?>"/>
            </td>
        </tr>
        <tr>
            <th align="right">审核未通过原因</th>
            <td>
                <?php $model->fail_cause = ''; ?>
                <?php echo $form->textArea($model, 'fail_cause', array('class' => 'text-input-bj', 'cols' => 50)); ?>
                (限200字内)
                <?php echo $form->error($model, 'fail_cause'); ?>
            </td>
        </tr>
        <?php if($model->life==Goods::LIFE_YES): ?>
        <tr>
            <th align="right"><?php echo $form->labelEx($model, 'life'); ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'life', Goods::deleteStatus(),array('separator'=>' ')); ?>
                <?php echo $form->error($model, 'life'); ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <th></th>
            <td>
                <?php echo CHtml::hiddenField('backUrl',$referer)?>
                <?php echo CHtml::submitButton(Yii::t('goods', '编辑'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	$("#Goods_price").change(function(){
		var price = $(this).val();
		var cat_id = '<?php echo $model->category_id; ?>';
		$.getJSON("<?php echo Yii::app()->createUrl('product/getGaiPrice/'); ?>",
	            "price=" + price + "&cat_id=" + cat_id ,
	            function (data) {
	                if (data.status == 'success') {
	                    $("#gai_price_area").html(data.gai_price);
	                }
	            }
	        );
	});
    $("#Goods_activity_tag_id").change(function(){
        var tag_id = $(this).val();
        $.get("<?php echo Yii::app()->createUrl('product/getActivityTagRatio/'); ?>",
            "id=" + tag_id,
            function (data) {
                if (data) {
                    $("#activity_tag_ratio").html(data);
                    //计算提示下限值
                    var minPrice = 0;
                    var ratio =Number(data) / 100;
                    var price = <?php echo $model->price; ?>;
                    var ratio = (1-ratio > 0) ? 1-ratio : 1;
                    minPrice = price / ratio;
                    minPrice =minPrice.toFixed(2);
                    $("#min-price").html(minPrice);
                }
            }
        );
    });

    $(function(){
        $('.showMore').hide();
        $("#showMore").toggle(function(){
            $(this).val("隐藏更多");
            $('.showMore').show();
        },function(){
            $(this).val("显示更多");
            $('.showMore').hide();
        });
        if($(".spec_stock").length>0){
            $("#Goods_stock").attr('readOnly','readOnly');
        }
    });

    setInterval(function () {
        $("#edui1").css('z-index', 1);
    }, 2000);
    /**
     * 历史价格
     */
    $("#historyPrice").click(function(){
        var url = "<?php echo $this->createAbsoluteUrl('product/goodsPrice',array('goods_id'=>$model->id)) ?>";
        artDialog.open(url);
    });
    /**
     * 慢慢买 搜索比较价格
     */
    $.get('<?php echo $this->createAbsoluteUrl('product/comparePrice',array('title'=>$model->name))  ?>',{},function(msg){
        if(msg.State==1000){
            var result = msg.searchResult;
            var html ='';
            var k = 0;
            html += '<a href="javascript:void(false)" class="moreGoods reg-sub" >更多</a>';
            for(x in result){
                k++;
                html += '<dl style="margin:5px;padding:3px;border:1px solid #ccc"><dt>'+result[x].siteName.substr(0,6)+'</dt>';
                html += '<dd style="color:red;">￥'+result[x].spprice+'</dd>';
                html += '<dd><a href="'+result[x].spurl+'" target="_blank"><img src="'+result[x].sppic+'" width="80px" title="'+result[x].spname+'"  /></a></dd>';
                html +='</dl>';
                if(k>4){
                    break;
                }
            }
            //右下角弹窗
            dialog = artDialog.notice({
                title: '价格对比',
                width: 110,
                content: html.length > 66 ? "<div style='min-height:700px;'>"+html+"</div>":html,
                padding:'5px 5px',
                drag:true
            });
            //点击更多，居中显示全部
            $(".moreGoods").on('click',function(){
                dialog.close();
                var html ='';
                var k = 0;
                var totalPrice = 0;
                for(x in result){
                    k++;
                    html += '<dl style="margin:5px;padding:3px;width:80px;height:120px;float:left;" class="goodsList"><dt>'+result[x].siteName.substr(0,6)+'</dt>';
                    html += '<dd style="color:red;">￥'+result[x].spprice+'</dd>';
                    html += '<dd><a href="'+result[x].spurl+'" target="_blank"><img src="'+result[x].sppic+'" width="80px" title="'+result[x].spname+'"  /></a></dd>';
                    html +='</dl>';
                    totalPrice += parseFloat(result[x].spprice);
                }
                html += '<dl style="margin:5px;padding:3px;width:80px;height:120px;float:left;" id="priceDL"><dt>平均价格</dt>';
                html += '<dd style="color:red;" id="avgPrice">￥'+(totalPrice/k).toFixed(2)+'</dd>';
                html += '<dd></dd>';
                html +='</dl>';
                //搜索框
                html += '<form id="searchForm" style="width: 500px;float:left;"><dl style="margin:5px;padding:3px;width:180px;height:120px;float:left;">关键词<dt></dt>';
                html += '<dd ><textarea class="text-input-bj keywords " cols="50"><?php echo  $model->name ?></textarea></dd>';
                html += '<dd><input value="搜索" type="submit" class="reg-sub" /></dd>';
                html +='</dl></form>';
                dialog = art.dialog({
                    title: '价格对比',
                    width: '700px',// 必须指定一个像素宽度值或者百分比，否则浏览器窗口改变可能导致artDialog收缩
                    content: html,
                    padding:'5px 5px'
                });
                //关键词搜索
                $("#searchForm").on('submit',function(){
                    var keywords = $(this).find('.keywords').val();
                    $.get('<?php echo $this->createAbsoluteUrl('product/comparePrice') ?>',{title:keywords},function(msg){
                        $(".goodsList").remove();
                        $("#avgPrice").html('');
                        if(msg.State==1000) {
                            var result = msg.searchResult;
                            var html ='';
                            var k = 0;
                            var totalPrice = 0;
                            for(x in result){
                                k++;
                                html += '<dl style="margin:5px;padding:3px;width:80px;height:120px;float:left;" class="goodsList"><dt>'+result[x].siteName.substr(0,6)+'</dt>';
                                html += '<dd style="color:red;">￥'+result[x].spprice+'</dd>';
                                html += '<dd><a href="'+result[x].spurl+'" target="_blank"><img src="'+result[x].sppic+'" width="80px" title="'+result[x].spname+'"  /></a></dd>';
                                html +='</dl>';
                                totalPrice += parseFloat(result[x].spprice);
                            }
                            $("#priceDL").before(html);
                            $("#avgPrice").html('￥'+(totalPrice/k).toFixed(2));
                        }
                    },'json');
                    return false;
                });
            });
        }
    },'json');

    $("input.reg-sub").click(function(){
        var checkId = $("#Goods_status input:checked").val();
        if(checkId!=$("#status").val() && checkId !="<?php echo Goods::STATUS_PASS ?>" && $.trim($("#Goods_fail_cause").val()).length<2){
            $(this).after('<div  class="errorMessage">审核不通过，必须填写原因</div>');
            return false;
        }
    });
</script>
<script type="text/javascript" src="<?php echo DOMAIN ?>/js/sellerGoods.js"></script>