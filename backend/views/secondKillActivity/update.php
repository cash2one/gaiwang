<?php

/* @var $this SecondKillActivityController */
/* @var $model SecKillRulesSeting */
$adminAct = $model->categoryId == 1 ? 'RedAdmin' : ( $model->categoryId == 2 ? 'FestiveAdmin' :'SeckillAdmin');

if(!$this->getUser()->checkAccess('SecondKillActivity.Update'.$model->categoryId)){
	$this->setFlash('error', Yii::t('secondKillActivity','您没有被授权执行该操作。') );
	$this->redirect(array($adminAct, 'category_id'=>$model->categoryId, 'rules_id'=>$model->rulesId));
}

$setingLabels = array(1=>'红包活动规则管理', 2=>'应节活动规则管理', 3=>'秒杀设置');
$rules = $model->getRulesMain($model->rulesId);

if($model->categoryId == 3){
	$this->breadcrumbs = array(
		Yii::t('secondKillActivity', '活动管理') => array($adminAct, 'category_id'=>$model->categoryId),
		Yii::t('secondKillActivity', $rules['name']) => array($adminAct, 'category_id'=>$model->categoryId, 'rules_id'=>$model->rulesId),
		Yii::t('secondKillActivity', $setingLabels[$model->categoryId])
	);
}else{
	$this->breadcrumbs = array(
		Yii::t('secondKillActivity', '活动管理') => array($adminAct, 'category_id'=>$model->categoryId),
		Yii::t('secondKillActivity', $setingLabels[$model->categoryId])
	);
}

?>
<?php $this->renderPartial('_update_'.$model->categoryId, array('model' => $model, 'labels'=>$labels, 'dataProvider'=>$dataProvider)); ?>

<script language="javascript">
var isbool = 0;

/**检查修改记录的表单*/
function checkUpdateForm(){
    var name          = $('#SeckillRulesSeting_name').val();
	var seckillSort   = discountRate = discountPrice = 0;
	var categoryId    = '<?php echo $model->categoryId;?>';
	var rulesId       = '<?php echo $model->rulesId;?>';
	var rulesSetingId = '<?php echo $model->rulesSetingId;?>';
	var description   = $('#SeckillRulesSeting_description').val().length;
	var limitNum      = $('#SeckillRulesSeting_limit_num').val();
	var buyLimit      = $('#SeckillRulesSeting_buy_limit').val();
	var linkUrl       = $('#SeckillRulesSeting_link').val();
	var startTime     = $('#SeckillRulesSeting_start_time').val();
	var endTime       = $('#SeckillRulesSeting_end_time').val();
	var singupStart   = $('#SeckillRulesSeting_singup_start_time').val();
	var singupEnd     = $('#SeckillRulesSeting_singup_end_time').val();
        var sellerLimit = $("#SeckillRulesSeting_seller").val();
        
	if(categoryId != 3){ 
	    seckillSort = $('#SeckillRulesSeting_sort').val(); 
	    if(seckillSort<0 || seckillSort>10000){
		    $('#SeckillRulesSeting_sort_em_').html('活动排序 请填写0-10000的数');
			$('#SeckillRulesSeting_sort_em_').css('display', '');
			return false;	
		}
	}
	
	if(categoryId == 1){
		var gift = $('#SeckillRulesSeting_gift').val();
		
		if(gift<0.01 || gift>100){
			$('#SeckillRulesSeting_gift_em_').html('红包消费支持比例 请填写0.01-100之间的数,小数点后保留二位');
			$('#SeckillRulesSeting_gift_em_').css('display', '');
			return false;
		}else{
			$('#SeckillRulesSeting_gift_em_').css('display', 'none');
		}
    }else{
		var discount      = $('input[name="SeckillRulesSeting[discount]"]:checked').val();
	    var discountRate  = $('#SeckillRulesSeting_discount_rate').val();
		var discountPrice = $('#SeckillRulesSeting_discount_price').val();
		
		if(discount == 1){
			$('#SeckillRulesSeting_discount_price').val('0');
		    if(discountRate<=0 || discountRate>10){
				$('#SeckillRulesSeting_discount_rate_em_').html('商品打折 请填写0.1-10的数,小数点后保留一位');
			    $('#SeckillRulesSeting_discount_rate_em_').css('display', '');
				$('#SeckillRulesSeting_discount_price_em_').css('display', 'none');
			    return false;
			}else{
				$('#SeckillRulesSeting_discount_rate_em_').css('display', 'none');
			}
		}else if(discount == 2){
			$('#SeckillRulesSeting_discount_rate').val('0');
			if(discountPrice<0.01 || discountPrice>1000){
				$('#SeckillRulesSeting_discount_price_em_').html('限定价格 请填写0.01-1000的数,小数点后保留两位位');
			    $('#SeckillRulesSeting_discount_price_em_').css('display', '');
				$('#SeckillRulesSeting_discount_rate_em_').css('display', 'none');
			    return false;
			}else{
				$('#SeckillRulesSeting_discount_price_em_').css('display', 'none');
			}
		}else{
			alert('请选择商品优惠幅度');
			return false;
		}
	}
        if(jQuery.trim(sellerLimit) == ''){
            alert('请合适的单店商家限制数');
            return false;
        }
	if(parseInt(limitNum) < parseInt(sellerLimit)){
            alert('单店商品限报商品不能大于商品限制参与数');
            return false;
        }
        
	if(limitNum<1 || limitNum>1000){
		alert('活动商品限制参与数不能小于1或者大于1000');
		return false;
	}
	
	if(description>10000){
		$('#SeckillRulesSeting_description_em_').css('display', '');
		$('#SeckillRulesSeting_description_em_').html('活动说明与协议 文字不能超过10000字');
		return false;
	}else{
		$('#SeckillRulesSeting_discount_price_em_').css('display', 'none');
	}
	
	if(linkUrl && !urlValid(linkUrl)){
	    alert('链接的格式不正确.');
		return false;	
	}
	
	$.ajax({
	    url: '<?php echo Yii::app()->createUrl('secondKillActivity/checkCreate');?>',
		type: 'post',
		dataType: "json",
		data:{'post':1, 'startTime':startTime, 'endTime':endTime, 'singupStart':singupStart, 'singupEnd':singupEnd, 'name':name, 'seckillSort':seckillSort, 'categoryId':categoryId, 'rulesId':rulesId, 'rulesSetingId':rulesSetingId, 'limitNum':limitNum,'buyLimit':buyLimit,sellerLimit :sellerLimit },
		cache: false,
		timeout: 1000,
		error: function(){},
		success: function(data){
			if(data.success){
			    isbool = 1;
				//$('input[type="submit"]').removeAttr('onclick');
				$('#secondKillActivity-form').submit();
			}else{
				isbool = 0;
			    alert(data.message);
			}
	    }
    });
	
	return isbool==1 ? true : false;
}


function urlValid(url){
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url)
}
</script>