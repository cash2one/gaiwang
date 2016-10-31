<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.form.js"></script>
<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('member', '您的位置');?>：</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>"><?php echo Yii::t('member', '首页');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/admin');?>"><?php echo Yii::t('member', '售后服务');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/backGoods', array('code'=>$data['code']));?>"><?php echo Yii::t('member', '退换货申请');?></a>
    </div> 
    <div class="returns-product">
        <div class="returns-top">
            <p class="returns-title cover-icon"><?php echo Yii::t('member', '售后服务详情');?></p>
            <div class="returns-process clearfix">
                <div class="returns-process-item on">
                    <p class="number">1</p>
                    <p class="txtle"><?php echo Yii::t('member', '买家 提交申请');?></p>
                    <span class="returns-backdrop on"></span>
                </div>
                
                <div class="returns-process-item">
                    <p class="number">2</p>
                    <p class="txtle"><?php echo Yii::t('member', '商家 处理申请');?></p>
                    <span class="returns-backdrop"></span>
                </div>
                
                <div class="returns-process-item">
                    <p class="number">3</p>
                    <p class="txtle"><?php echo Yii::t('member', '完成');?></p>
                </div>
            </div>
        </div>
        
        <div class="refund-tab">
            <span class="on"><?php echo Yii::t('member', '我要退货');?></span>
        </div>
        <?php
        $form = $this->beginWidget('ActiveForm', array(
			'id' => $this->id . '-form',
			'enableAjaxValidation' => true,
			'enableClientValidation' => true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
				'beforeValidate' => 'js:checkForm',
			),
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data',
			),
		));
        ?>
        <div class="returns-services">
            <div class="refund-tab-box">
                <div class="send-back">
                  <ul>
                    <li><span class="title"><i>*</i><?php echo Yii::t('member', '退款原因');?>：</span>
                      <?php echo $form->dropDownList($model, 'exchange_reason', $exchangeReason, array('class' => 'btn-cleck', 'empty'=>Yii::t('memberOrder', '请选择退款原因'))); ?>
                      <?php echo $form->error($model, 'exchange_reason'); ?>
                    </li>
                    <li><span class="title"><i>*</i><?php echo Yii::t('member', '退款金额');?>：</span> 
                      <?php echo $form->textField($model, 'exchange_money', array('class' => 'input-number', 'onkeypress'=>"return checkNumber(event)")); ?> <?php echo Yii::t('member', '元');?>  （<?php echo Yii::t('member', '注意，退款金额范围');?>:
                        <span id="minmoney"><?php echo HtmlHelper::formatPrice(sprintf("%.2f",($order['pay_price'] - $order['freight'])*$this->percent)); ?></span> - <span id="exmoney"><?php echo HtmlHelper::formatPrice(sprintf("%.2f",$order['pay_price'] - $order['freight']));?></span> <?php echo Yii::t('member', '元');?><?php if($order['freight'] > 0) echo Yii::t('member', '　商品已发货，退款金额范围不包含运费') ?>）<?php echo $form->error($model, 'exchange_money'); ?></li>
                    <li><span class="title"><i>*</i><?php echo Yii::t('member', '退款说明');?>：</span> 
                    <?php echo $form->textArea($model, 'exchange_description', array('class' => 'input-txtle', 'maxlength'=>'200', 'placeholder'=>Yii::t('memberOrder', '1-200汉字。请具体和如实地说明要求卖家退款的情况。如：未收到货物，货物存在严重的质量问题等'))); ?>
                    <?php echo $form->error($model, 'exchange_description'); ?>
                    </li>
                  </ul>  
                </div>
                <div class="send-upload clearfix">
                    <div class="left"><?php echo Yii::t('member', '上传凭证');?>：</div>
                    <div class="right">
                        <div class="picture clearfix">
                            <ul id="picture-ul">
                            </ul>
                            <input id="add-image" type="button" class="btn-upload cover-icon"/>
                            <input type="file" id="images" class="input-file" style="display:none;" name="img_path" onchange="submitImages();" />
                            <?php echo $form->hiddenField($model, 'exchange_images', array('class' => 'input-number',  'value'=>'')); ?>
                            <?php echo $form->error($model, 'exchange_images'); ?>
                        </div>
                        <p class="upload-message"><?php echo Yii::t('member', '为了帮助我们更好的解决问题，请您上传图片');?></p>
                        <p class="upload-fix"><?php echo Yii::t('member', '最多可上传<i>3</i>张图片，每张图片大小不超过5M，支持bmp,gif,jpg,png,jpeg格式文件');?></p>
                        <p><input type="submit" class="btn-deter" value="<?php echo Yii::t('member', '提交申请');?>" /></p>
                    </div>
                </div>
                <?php echo $form->hiddenField($model, 'code', array('class' => 'input-number', 'value'=>$data['code'])); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        
        <?php $this->renderPartial('_orderinfo',array('orderInfo'=>$this->orderInfo)); ?> 
    </div>
</div>
<script language="javascript">
var csrfToken = '<?php echo Yii::app()->request->csrfToken;?>';

function checkNumber(e) {
	var obj=e.srcElement || e.target;
	var dot=obj.value.indexOf(".");
	var  key=e.keyCode|| e.which;
	
	if(key==8 || key==9 || key==46 || (key>=37  && key<=40))//这里为了兼容Firefox的backspace,tab,del,方向键
	    return true;
	
	if (key<=57 && key>=48) { //数字
	    if(dot==-1)//没有小数点
		    return true;
		else if(obj.value.length<=dot+2)//两位小数
		    return true;
    } else if((key==46) && dot==-1){//小数点
	    return true;
	}   
	     
    return false;
}

function submitImages(){
	
	$('#exchangeGoods-form').ajaxSubmit({
		url: '<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/uploadImages')?>',
		type:'POST',
		dataType:'json',
		data:{YII_CSRF_TOKEN:csrfToken},
		success:function(data){
			var html = '';
			if(data.success){
				$('#Order_exchange_images_em_').css('display','none');
				
				html  = '<li>';
				html +=	'<p class="upload-close cover-icon"></p>';
				html +=	'<p class="upload-picture"><img src="'+data.path+'" data-path="'+data.file+'" /></p>';
				html +=	'<p class="upload-name"></p>';
				html +=	'</li>';
				$('#picture-ul').append(html);
				
				var v = $('#Order_exchange_images').val();
				    v = v=='' ? data.file : v+'|'+data.file;
				$('#Order_exchange_images').val(v);
			} else {
				layer.alert(data.message);
			}
		}
	});
	return false;
}

function checkForm(){
    var money    = parseFloat($('#exmoney').html());
	var money2   = parseFloat($('#Order_exchange_money').val());
	var images   = $('#Order_exchange_images').val();
	var minMoney = parseFloat($('#minmoney').html())
	
	if(money2 > money || money2 < minMoney){
		layer.alert('<?php echo Yii::t('member', '退款金额必须在指定范围内');?>');
		return false;	
	}
	
	if(images.split('|').length > 3){
	    layer.alert('<?php echo Yii::t('member', '最多只能上传图片3张图片');?>');
		return false;
	}
	
	return true;
}

$(document).ready(function(e) {
    $('#add-image').click(function (){
		var length = $('#picture-ul').find('li').length;
		if(length > 2){
			layer.alert('<?php echo Yii::t('member', '最多只能上传图片3张图片');?>');
			return false;
		}else{
			$('#images').click();
		}   
	});
	
	//删除图片
	$("#picture-ul").delegate('.upload-close','click',function(){
		var file = $(this).next('p').find('img').attr('data-path');
		var li   = $(this).parent();
		
		layer.confirm('<?php echo Yii::t('member', '确认删除该图片?');?>', {icon: 3}, function(index){
			layer.close(index);
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/deleteImages')?>',
				data: {'file':file, YII_CSRF_TOKEN:csrfToken},
				cache: false,
				dataType: 'json',
				success: function(data){
					layer.close();
					if(data.success){
						var v = $('#Order_exchange_images').val();
						li.remove();
						
						if(v != ''){
							arr = v.split('|');
							arr.splice($.inArray(file,arr),1);
						}
						$('#Order_exchange_images').val(arr.join('|'));
					}else{
						layer.alert(data.message);
					}
				}
			});
		});
	});
});
</script>