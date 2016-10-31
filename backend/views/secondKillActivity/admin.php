<style>
.pop-box{clear: both;z-index: 1000; display: none; position: absolute; background-color:#fff; border:3px solid #f82525; border-radius:5px;}
.pop-box-head{height:30px; line-height:30px; background-color:#f6f6f6;}
.pop-box-head .hl{height:30px; line-height:30px;float:left; text-indent:10px; color:#000; font-size:14px; font-weight:bold; vertical-align:middle;}
.pop-box-head .hr{height:30px; line-height:30px;float:right; width:60px; text-align:right; margin-right:5px;}
.pop-box-head .hd img{ border:0; vertical-align:middle;}
.pop-box-body{padding-bottom:5px;}
.pop-box-body ul{ height:28px; line-height:28px; vertical-align:middle;}
.pop-box-body #vc{ padding:10px 0; text-align:center; font-size:14px;}
.pop-box-body #yzm{text-align:center; font-size:14px;}
.pop-box-body #vnum{ border: 1px solid #000; display: inline-block; height: 22px; line-height: 22px; margin-left: 10px; width: 50px;}
.span_close{ border:1px solid #F00; color:#000; height:26px; line-height:26px; width:40px; display:inline-block; vertical-align:middle; cursor:pointer; text-align:center; margin-top:2px;}
.pop-box-body .spname{ width:100px; display:inline-block; text-align:right;padding-right: 5px;}
.pop-box-body input[type="text"]{ border:1px solid #6BC3F3; width:150px; height:22px; text-indent:3px; vertical-align:middle;}
.pop-box-bottom{ height:36px; line-height:36px; vertical-align:middle; text-align:center; background-color:#f6f6f6;}
.span_msg{ height:30px; line-height:30px; vertical-align:middle; font-size:14px; font-weight:bold;}
#msg_content{line-height:24px; vertical-align:middle; text-align:center; color:#F00; text-indent:2em; font-size:14px; padding:5px;}
.mask-pop{ background:#000; width:100%; height:100%; top:0; left:0;opacity:0.3;filter:Alpha(opacity=30); position:absolute; z-index:500;}
.pop_message{z-index:500; display: none; position: absolute;background:#333;opacity:0.8;filter:Alpha(opacity=80); color:#fff; padding:5px; border-radius:5px;}
</style>

<?php
    $adminAct = $model->categoryId == 1 ? 'RedAdmin' : ( $model->categoryId == 2 ? 'FestiveAdmin' :'SeckillAdmin');

    if ($model->categoryId == 3) {
		if($model->rulesId){
			$rules = $model->getRulesMain($model->rulesId);
	?>
      <table cellspacing="0" cellpadding="0"  style=" margin-bottom:10px;">
        <tbody><tr>
          <th>活动名称：</th>
            <td style="font-size:14px; font-weight:bold;"><?php echo $rules['name'];?></td>
        </tr>
        <tr>
          <th>活动日期：</th>
            <td style="font-size:14px; font-weight:bold;"><?php echo $rules['date_start'].'——'.$rules['date_end'];?></td>
        </tr>
        <tr><th></th><td></td></tr>  
        </tbody>
      </table>
    <?php
			echo '<a class="regm-sub" href="'. Yii::app()->createUrl('secondKillActivity/'.$adminAct, array('category_id'=>$model->categoryId, 'status'=>$model->status)).'">返回上一级</a>&nbsp;&nbsp;';  
			if ($this->getUser()->checkAccess('SecondKillActivity.Create'.$model->categoryId)) {
				echo '<a class="regm-sub" href="'.Yii::app()->createAbsoluteUrl('/SecondKillActivity/create'.$model->categoryId.'/category_id/'.$model->categoryId.'/rules_id/'.$model->rulesId).'">新建秒杀设置</a> &nbsp;&nbsp;';
			}
			echo '正在进行的活动数： '.$model->getActivityNumber($model->categoryId,$model->rulesId).'个';
		}else{
			if ($this->getUser()->checkAccess('SecondKillActivity.CreateDate')) {
		        echo '<a style=" margin-left:5px;float:left;" class="regm-sub" href="javascript:;" onclick="popupDiv(\'date-div\');">新建活动日期</a>';	
			}
		}
	}else{
		if ($this->getUser()->checkAccess('SecondKillActivity.Create'.$model->categoryId)) {
?>
  <a style=" margin-left:5px; float:left;" class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/SecondKillActivity/create'.$model->categoryId.'/category_id/'.$model->categoryId) ?>"><?php echo Yii::t('SecondKillActivity', $model->categoryId == 1 ? '新建红包活动' : '新建应节活动'); ?></a>&nbsp;&nbsp;<span style="float: left;margin-left: 25px;line-height:27px;font-weight: 700;">正在进行的活动数： <?php echo $model->getActivityNumber($model->categoryId);?> 个</span>
<?php }} ?>

<?php
$formpage = ($model->categoryId==3 && $model->rulesId) ? '_activity_4' : '_activity_'.$model->categoryId;
$this->renderPartial($formpage, array( 'model' => $model, 'dataProvider'=>$dataProvider, 'labels'=>$labels, 'pages'=>$pages));
?>

<div id="pop-div" class="pop-box" > 
  <div class="pop-box-head"><div class="hr">
    <span class="span_close" onclick="hideDiv('pop-div');" title="关闭">关闭</span></div>
    <div class="hl"><span id="ae"></span></div>
  </div>  
  <div class="pop-box-body" style="width:450px;">
    <ul id="vc"></ul>
    <ul id="yzm">请输入验证码：<input type="text" id="vcode" value="" maxlength="4" style="width:60px;" /><span id="vnum"></span></ul>
    <ul id="msg_content"></ul>
  </div>
  <div class="pop-box-bottom">
    <input type="button" id="submit" class="reg-sub" onclick="" value="确 定" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" id="cancel" class="reg-sub" onclick="hideDiv('pop-div');" value="取 消" />
  </div>
</div>

<div id="date-div" class="pop-box" > 
  <div class="pop-box-head"><div class="hr">
    <span class="span_close" onclick="hideDiv('date-div');" title="关闭">关闭</span></div>
    <div class="hl">新建活动日期</div>
  </div>  
  <div class="pop-box-body" style="width:450px;">
    <ul style="height:40px; line-height:40px;"><span class="spname"><font color="#FF0000">*</font>秒杀活动名称: </span> <input type="text" id="SeckillRulesSeting_name" name="SeckillRulesSeting[name]" class="text-input-bj  middle" placeholder="请填写活动的名称" value="" maxlength="10" /></ul>
    <ul style="height:40px; line-height:40px;"><span class="spname"><font color="#FF0000">*</font>开始时间: </span> 
    <?php  
	$this->widget('comext.timepicker.timepicker', array(
		'model' => $model,
		'name' => 'start_time',
		'select' => 'date',
		'options' => array(
		    'dateFormat'=>'yy-mm-dd',
			'showHour' => false,
			'showMinute' => false,
			'showSecond'=>false,
			'minDate' => date('Y-m-d'),
		),
		'htmlOptions' => array(
			'class' => 'datefield text-input-bj middle hasDatepicker',
		)
	));
	?>
    </ul>
    <ul style="height:40px; line-height:40px;"><span class="spname"><font color="#FF0000">*</font>结束时间: </span> 
    <?php  
	$this->widget('comext.timepicker.timepicker', array(
		'model' => $model,
		'name' => 'end_time',
		'select' => 'date',
		'options' => array(
		    'dateFormat'=>'yy-mm-dd',
			'showHour' => false,
			'showMinute' => false,
			'showSecond'=>false,
			'minDate' => date('Y-m-d'),
		),
		'htmlOptions' => array(
			'class' => 'datefield text-input-bj middle hasDatepicker',
		)
	));
	?>
    </ul>
    <ul style="height:40px; line-height:40px;"><span class="spname"><font color="#FF0000">*</font>报名开始时间: </span>
    <?php  
	$this->widget('comext.timepicker.timepicker', array(
		'model' => $model,
		'name' => 'singup_start_time',
		'select' => 'datetime',
		'options' => array(
		    'dateFormat'=>'yy-mm-dd',
			'timeFormat' => 'hh:mm:ss',
			'minDate' => date('Y-m-d'),
		),
		'htmlOptions' => array(
			'class' => 'datefield text-input-bj middle hasDatepicker',
		)
	));
	?>
    </ul>
    <ul style="height:40px; line-height:40px;"><span class="spname"><font color="#FF0000">*</font>报名截止时间: </span>
    <?php  
	$this->widget('comext.timepicker.timepicker', array(
		'model' => $model,
		'name' => 'singup_end_time',
		'select' => 'datetime',
		'options' => array(
		    'dateFormat'=>'yy-mm-dd',
			'timeFormat' => 'hh:mm:ss',
			'minDate' => date('Y-m-d'),
		),
		'htmlOptions' => array(
		    'readonly' => "readonly",
			'class' => 'datefield text-input-bj middle hasDatepicker',
		)
	));
	?>
    </ul>
    <ul><span class="spname"></span><span id="msg_date" style="color:#F00; font-size:14px;"></span></ul>
  </div>
  <div class="pop-box-bottom">
    <input type="button" id="submit" class="reg-sub" onclick="return createDate();" value="确 定" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" id="cancel" class="reg-sub" onclick="hideDiv('date-div');" value="取 消" />
  </div>
</div>

<script language="javascript">

    var vcode = ''; 
	$(document).ready(function() {
		$('#second-kill-grid a.delete').click(function (){
			if(!confirm('确定要删除这条数据吗?')) return false;
			
			var url = $(this).attr('href');
			
			$.ajax({
				url: url,
				type: 'POST',
				data:{},
				dataType: 'json',
				timeout: 1000,
				error: function(){},
				success: function(data){
					window.location.href = data.url;
				}
			});
			return false;
		});
	});
	
	/**修改活动规则的状态 id为seting表id*/
	function setActivityStatus(id, v){
		var postUrl = '';
		
		if(v){
		    var code = $('#vcode').val();
			
			if(code != vcode ){
			    $('#msg_content').html('请填写正确的验证码.');
				return false;	
			}
		}
		
		if(v){//结束活动
		    postUrl = '<?php echo Yii::app()->createUrl('/SecondKillActivity/stop'.$model->categoryId);?>';
		}else{//正在进行
			postUrl = '<?php echo Yii::app()->createUrl('/SecondKillActivity/start'.$model->categoryId);?>';
		}
		
		$.ajax({
			url: postUrl,
			type: 'POST',
			data:{'id':id, 'status':v},
			dataType: 'json',
			timeout: 1000,
			error: function(){},
			success: function(data){
				if(data.success){ alert('操作成功');window.location.reload();}else{ $('#msg').html(data.message);}
			}
		});
		return false;
	}
	
	/**展示操作确认窗口 k=0为开启活动 1为结束活动 id为seting表的id*/
	function showConfirmDiv(k, id){
		$('#msg_content').html('');
		
		$('#vcode').val('');
		if(k){/*强制结束要输验证码*/
			$('#ae').html('强制结束');
			$('#vc').html('确定强制结束当前活动？');
			$('#yzm').css('display', '');
			
			vcode = _getRandomString();
			$('#vnum').html(vcode);
			
			$('#submit').attr('onclick', 'return setActivityStatus('+id+', '+k+')');
		}else{/*开始活动*/
			$('#ae').html('开启活动');
			$('#vc').html('确定开启当前活动？');
			$('#yzm').css('display', 'none');
			$('#submit').attr('onclick', 'return setActivityStatus('+id+', '+k+')');
		}
		
		popupDiv('pop-div');	
	}
	
	/**创建秒杀活动日期*/
	function createDate(){
		var name        = $('#SeckillRulesSeting_name').val();
		var startTime   = $('#yw1').val();
		var endTime     = $('#yw2').val();
		var categoryId  = '<?php echo $model->categoryId;?>';
		var singupStart = $('#yw3').val();
		var singupEnd   = $('#yw4').val();
		
		if($.trim(name) == '' || startTime =='' || endTime == '' || singupStart == '' || singupEnd == ''){
			$('#msg_date').html('请把内容填写完整.');
			return false;
		}
		
		$('#msg_date').html('');
		if(!confirm('日期创建后将不能更改,确认创建?')) return false;
		
		$.ajax({
			url: '<?php echo Yii::app()->createUrl('/SecondKillActivity/createDate');?>',
			type: 'POST',
			data:{'name':name, 'start_time':startTime, 'end_time':endTime, 'category_id':categoryId, 'singup_start_time':singupStart, 'singup_end_time':singupEnd},
			dataType: 'json',
			timeout: 1000,
			error: function(){},
			success: function(data){
				if(data.success){ alert('新建活动日期成功.');window.location.reload();}else{ $('#msg_date').html(data.message);}
			}
		});
	}
	
	/**弹出层*/
	function popupDiv(id) { 
		var div_obj = $("#"+id); 
		var windowWidth = document.documentElement.clientWidth; 
		var windowHeight = document.documentElement.clientHeight; 
		var popupHeight = div_obj.height(); 
		var popupWidth = div_obj.width(); 
	
		/**添加并显示遮罩层*/ 
		$("<div id='mask-pop'></div>").addClass("mask-pop") 
			.width(windowWidth) 
			.height(windowHeight) 
			.click(function() {hideDiv(id); }) 
			.appendTo("body") 
			.fadeIn(200); 
		div_obj.css({"position": "absolute"}) .animate({left: windowWidth/2-popupWidth/2, 
			 top: windowHeight/2-popupHeight/2, opacity: "show" }, "slow"); 
	}
	
	/**生成随机字符串*/
	function _getRandomString() {  
		len = 4;  
		var $chars = '1234567890';
		var maxPos = $chars.length;  
		var number = '';  
		for (i = 0; i < len; i++) {  
			number += $chars.charAt(Math.floor(Math.random() * maxPos));  
		}  
		return number;  
	}  
	
	/**关闭弹出层*/
	function hideDiv(id) {
		$("#mask-pop").remove(); 
		$("#"+id).animate({left: 0, top: 0, opacity: "hide" }, "slow"); 
	}
	
	/**按状态条件来查询记录*/
	function changeStatus(v, rules_id){
		window.location.href = "<?php echo Yii::app()->createUrl('/SecondKillActivity/'.$adminAct);?>&category_id=<?php echo $model->categoryId;?>&status="+v+'&rules_id='+rules_id;
	}
</script>

