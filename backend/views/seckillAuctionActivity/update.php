<?php

/* @var $this SeckillAuctionActivityController */
/* @var $model SecKillRulesSeting */
$adminAct = 'SeckillAuctionAdmin';

if(!$this->getUser()->checkAccess('SeckillAuctionActivity.SeckillAuctionUpdate')){
	$this->setFlash('error', Yii::t('seckillAuctionActivity','您没有被授权执行该操作。') );
	$this->redirect(array($adminAct, 'category_id'=>$model->categoryId, 'rules_id'=>$model->rulesId));
}

$rules = $model->getRulesMain($model->rulesId);

	$this->breadcrumbs = array(
		Yii::t('seckillAuctionActivity', '活动管理') => array($adminAct, 'category_id'=>$model->categoryId),
		Yii::t('seckillAuctionActivity','拍卖活动规则管理')
	);


?>
<?php $this->renderPartial('save', array('model' => $model, 'labels'=>$labels, 'dataProvider'=>$dataProvider)); ?>
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
		var startTime     = $('#SeckillRulesSeting_start_time').val();
		var endTime       = $('#SeckillRulesSeting_end_time').val();

		if($('#SeckillRulesSeting_start_time').val()==""){
			$('#SeckillRulesSeting_start_time_em_').html('开始时间 不可为空白.');
			$('#SeckillRulesSeting_start_time_em_').css('display', '');
			return false;
		}
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
			$('#SeckillRulesSeting_discount_price_em_').css('display', 'none');
		}

		$.ajax({
			url: '<?php echo Yii::app()->createUrl('seckillAuctionActivity/checkCreate');?>',
			type: 'post',
			dataType: "json",
			data:{'post':1, 'startTime':startTime, 'endTime':endTime,'name':name, 'seckillSort':seckillSort, 'categoryId':categoryId, 'rulesId':rulesId, 'rulesSetingId':rulesSetingId},
			cache: false,
			timeout: 1000,
			error: function(){},
			success: function(data){
				if(data.success){
					isbool = 1;
					//$('input[type="submit"]').removeAttr('onclick');
					$('#seckillAuctionActivity-form').submit();
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