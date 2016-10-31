<?php $this->pageTitle='盖象商城-中西厨房大PK'; ?>
<style>
/*=====
    @Date:2016-08-30
    @content:中西厨房大PK
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden; position: relative;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.kitchen-2-01{height:210px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-2/kitchen-2-01.jpg) top center no-repeat;}
.kitchen-2-02{height:210px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-2/kitchen-2-02.jpg) top center no-repeat;}
.kitchen-2-03{height:210px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-2/kitchen-2-03.jpg) top center no-repeat;}
.kitchen-2-04{height:210px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-2/kitchen-2-04.jpg) top center no-repeat;}
.kitchen-2-05{height:210px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-2/kitchen-2-05.jpg) top center no-repeat;}

.kitchen-2-04 a{ width:340px; height:100px; top:32px;}
.kitchen-2-04 .a1{left:-36px;}
.kitchen-2-04 .a2{left:590px;}
.layer{width: 100%; height: 100%; position: absolute; left: 0px; top: 0px; background-color: rgba(0,0,0,0.6); z-index: 100; display: none;}
.layer .vote_success{
	width: 340px; height: 248px;
	background-color: #2c373b; padding: 20px;
	position: absolute; left: 50%; top: 50%; margin-left: -170px; margin-top: -124px;
}
.vote_success p{color: #fff;}
.vote_success .vote_result{font-size: 60px; text-align: right; font-weight: bold;}
.vote_success .vote_tips{font-size: 40px; text-align: center; display: none;}
.vote_success .vote_tips span{color: #fe0000;}
.vote_success a{display: block; width: 260px; height: 60px; line-height: 60px; font-size: 28px; text-align: center; color: #fff; background-color: #971c1e; position: absolute; left: 50%; margin-left: -130px; bottom: 40px;}

</style>
	
	<div class="zt-wrap">			
		<div class="kitchen-2-01"></div>
		<div class="kitchen-2-02"></div>
		<div class="kitchen-2-03"></div>
		<div class="kitchen-2-04">
			<div class="zt-con">
				<a href="javascript:void(0)" data-attr="<?php echo Vote::VOTE_CANDIDATE_CH;?>" class="a1" id="chinese"></a>
				<a href="javascript:void(0)" data-attr="<?php echo Vote::VOTE_CANDIDATE_EN;?>" class="a2" id="western"></a>
			</div>
		</div>
		<div class="kitchen-2-05"></div>
		<div class="layer">
			<div class="vote_success">
				<p class="vote_result"></p>
				<p class="vote_tips"></p>
				<a href="javascript:void(0)"></a>
			</div>
		</div>
		
		
	</div>   
   <!--------------主体 End------------>
<script type="text/javascript">
$(function(){
	$('.kitchen-2-04 a').click(function(){
		var candidateId=$(this).attr('data-attr');
		$.ajax({
            type: "POST", 
            url: "<?php echo $this->createUrl('vote/zxPkVotes') ?>",
            data: {
            	candidateId: candidateId, 
                YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',
            },
            dataType:"json",
            success: function(data) {
            	$('.layer').show();
        		$('.vote_success a').show();
                if(data.status==1){
                	$('.vote_result').html('投票成功！');
        			$('.vote_tips').show().html('立即送<span>99元红包</span>');
        			$('.vote_success a').html('出发买买买').attr('href','http://active.g-emall.com/festive/detail/244')
                 }else{
                	 $(".vote_result").html('投票失败！');
                   if(data.status==2){
                	  $('.vote_success a').html(data.msg).attr('href','<?php echo $this->createAbsoluteUrl('/member/home/login');?>');
                	}else{
                	  $('.vote_success a').html(data.msg)
                    }
                 }  
               },
            error:function(msg){
                  alert(data.msg);
                }
          });

		$('.vote_success a').click(function(){
			$('.layer,.vote_tips').hide();
			$(this).hide();
		})
	})
})
</script>