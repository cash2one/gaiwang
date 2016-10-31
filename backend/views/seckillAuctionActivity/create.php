<?php

/* @var $this SeckillAuctionActivityController */
/* @var $model SecKillRulesSeting */
$adminAct ="SeckillAuctionAdmin";

if(!$this->getUser()->checkAccess('SeckillAuctionActivity.SeckillAuctionCreate')) {
	$this->setFlash('error', Yii::t('seckillAuctionActivity','您没有被授权执行该操作。') );
    $this->redirect(array($adminAct, 'category_id'=>$model->categoryId));
}

$setingLabels = array(1=>'红包活动规则管理', 2=>'应节活动规则管理', 3=>'秒杀设置',4=>'拍卖设置');
$rules = $model->getRulesMain($model->rulesId);


$this->breadcrumbs = array(
	Yii::t('seckillAuctionActivity', '活动管理') => array($adminAct, 'category_id'=>$model->categoryId),
	Yii::t('seckillAuctionActivity', $setingLabels[$model->categoryId])
);


?>
<?php $this->renderPartial('insert', array('model' => $model, 'labels'=>$labels)); ?>
<script language="javascript">
	var isbool = 0;

	/**检查添加记录的表单*/
	function checkCreateForm(){
		var name        = $('#SeckillRulesSeting_name').val();
		var seckillSort = discountRate = 0;
		var categoryId  = '<?php echo $model->categoryId;?>';
		var rulesId     = '<?php echo $model->rulesId;?>';
		var description = $('#SeckillRulesSeting_description').val().length;
		var startTime   = $('#SeckillRulesSeting_start_time').val();
		var endTime     = $('#SeckillRulesSeting_end_time').val();

		if(categoryId != 3){
			seckillSort = $('#SeckillRulesSeting_sort').val();
			if(seckillSort<0 || seckillSort>10000){
				$('#SeckillRulesSeting_sort_em_').html('活动排序 请填写0-10000的数');
				$('#SeckillRulesSeting_sort_em_').css('display', '');
				return false;
			}
		}

		if(description>10000){
			$('#SeckillRulesSeting_description_em_').css('display', '');
			$('#SeckillRulesSeting_description_em_').html('活动说明与协议 文字不能超过10000字');
			return false;
		}else{
			$('#SeckillRulesSeting_description_em_').css('display', 'none');
		}

		//$('#add').attr('disabled','disabled');
		$.ajax({
			url: '<?php echo Yii::app()->createUrl('seckillAuctionActivity/checkCreate');?>',
			type: 'post',
			dataType: "json",
			data:{'post':1, 'startTime':startTime, 'endTime':endTime,'name':name, 'seckillSort':seckillSort, 'categoryId':categoryId, 'rulesId':rulesId},
			error: function(){},
			success: function(data){
				if(data.success){
					isbool = 1;
					//$('input[type="submit"]').removeAttr('onclick');
					$('#seckillAuctionActivity-form').submit();
				}else{
					isbool = 0;
					//$('#add').removeAttr("disabled");
					alert(data.message);
				}
			}
		});

		return isbool==1 ? true : false;
	}

	$(document).ready(function(e) {
		var cid  = '<?php echo $model->categoryId;?>';
		if(cid!=1){
			$('input[type="radio"]').click(function(i,v){
				val = $(this).val();
				if(val==2){$('#SeckillRulesSeting_discount_rate').val('');}else{$('#SeckillRulesSeting_discount_price').val('');}
			});
		}
	});

	function dealPoint(v){

		var idx = v.indexOf('.');
		var arr = v.match(/\./g);
		var len = arr ? arr.length : 0;
		if(idx<0){
			return v.replace(/[^\d.]/g,'');
		}else if(idx==0){
			return '';
		}else if(idx>0 && len>1){//出现两次以上
			return v.substr(0, v.length-1).replace(/[^\d.]/g,'');
		}else{
			return v.replace(/[^\d.]/g,'');
		}
	}


	function urlValid(url){
		return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url)
	}
</script>