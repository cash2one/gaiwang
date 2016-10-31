  <!--------------主体 begin---------->
	<div class="offLineNav02">
		<a name="offLineIndexBox" id="offLineIndexBox"></a>
		<div class="indexBox">
			<div class="indexCon clearfix">
				<div class="tipMsg fl"><?php echo Yii::t('jms','Hi，欢迎来到盖网通的世界，请尽情享受盖网O2O模式为你带来的全新服务体验！')?></div>

				<form action="">
				<div class="searchBar fr">
					<input type="hidden" name="city" value="<?php echo $city_id ?>"/>
					<input type="hidden" name="cat" value="<?php echo $cat ?>"/>
					<input id="offLineKeyword" class="skeyWord" type="text" name="keyword" value="<?php echo $keyword ?>"/><input class="submit" type="submit" value="<?php echo Yii::t('jms','搜索')?>"/>
					</div>				
				</form>
			</div>
		</div>
		
		<div class="navBox clearfix">
			<ul class="clearfix">
				<li><a  href="<?php echo $this->createAbsoluteUrl('index')?>" title="<?php echo Yii::t('jms','盖网通联盟商户类别')?>" target="_blank"><?php echo Yii::t('jms','盖网通联盟商户类别')?></a></li>
				<?php foreach ($categorys as $category):?>
				<li><a <?php echo ($cat == $category['id'])? 'class="curr"':'' ?> href="<?php echo $this->createAbsoluteUrl('list',array('cat'=>$category['id'],'city'=>$city_id))?>" title="<?php echo Yii::t('jms',$category['name'])?>" ><?php echo Yii::t('jms',$category['name'])?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		
	</div>
    
	<div class="slashLinebg"></div>
		<div id="barMenuBtn" class="clearfix">
				<div class="storeMenu" id="storeMenu">
				<div class="storeCategory" id="storeCate">
				<div class="storeSort">
					<h2><?php echo Yii::t('jms','商户分类')?></h2>
					<ul>
					<?php foreach ($categorys as $category):?>
						<li><a <?php echo ($cat == $category['id'])? 'class="curr"':'' ?> href="<?php echo $this->createAbsoluteUrl('list',array('cat'=>$category['id'],'city'=>$city_id)) ?>" title="<?php echo Yii::t('jms',$category['name'])?>"><?php echo Yii::t('jms',$category['name'])?></a></li>
					<?php endforeach;?>			
					</ul>
				</div>
				<div class="storeArea">
					<h2><?php echo Yii::t('jms','商户地域')?></h2>
					<ul class="clearfix">
					<?php foreach($offlineCity as $fcity): ?>
						<li><a <?php echo ($city_id == $fcity['city_id'])? 'class="curr"':'' ?> href="<?php echo $this->createAbsoluteUrl('list',array('city'=>$fcity['city_id'],'cat'=>$cat)) ?>" title="<?php echo $fcity['name']?>"><?php echo substr($fcity['name'],0,6)?></a></li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>
	</div>	
	<div class="offLineMain clearfix" >
		<div class="offLineMainbar fl">
		<?php if($cityName||$categoryName):?>
			<div class="mainbarTit"><hr/><h1><?php echo ($cityName?Yii::t('jms',$cityName):"").($categoryName&&$cityName?".":"") ; echo ($categoryName?Yii::t('jms',$categoryName):"") ?></h1>

			</div>
		<?php endif;?>
			<div class="servicesList">
				<ul  class="clearfix" id="result">
					<?php foreach ($franchisees as $franchisee):?>
					<li class="clearfix">
						<div class="liTit fl">
							<div class="storeLogo"><img height=120px src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $franchisee['logo'], 'h_120,w_240')?>" alt="<?php echo $franchisee['name']?>"/></div>
							<div class="storeCount"><p class="name"><?php echo $franchisee['name']?></p><span class="discount"><?php echo $franchisee['member_discount']/10 ?><?php echo Yii::t('jms','折')?></span></div>
						</div>
						<div class="liImg fr"><a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$franchisee['id']))?>" title="<?php echo $franchisee['name']?>" target="_blank"><img  src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $franchisee['thumbnail'], 'h_200,w_600') ?>" alt="<?php echo $franchisee['name']?>"/></a></div>						
					</li>
					<?php endforeach;?>					
				</ul>
			</div>
		</div>
		<div class="offLineSidebar fr">
			<div class="sidebarTit"><h2><?php echo Yii::t('jms','盖网推荐')?></h2></div>
			<div class="sidebarList">
				<ul class="clearfix">
				<?php foreach ($recommends as $recommend):?>
					<li><a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$recommend['id']))?>" title="<?php echo $recommend['name']?>" target="_blank"><img width="223" height="190" class="lazy" src="<?php if(!empty($recommend['logo'])) {
                                echo ATTR_DOMAIN . '/'.$recommend['logo'];
                            }else{
                                echo DOMAIN.'/images/bgs/seckill_product_bg.png';
                            }  ?>" alt="<?php echo $recommend['name'] ?>"/><p><span class="red"><?php echo $recommend['member_discount']/10?></span><?php echo Yii::t('jms','折')?></p></a></li>
				<?php endforeach;?>	
				</ul>
			</div>
		</div>
			
		<div class="loader" id="loader" style="display:none"><img src="../images/bg/loading.gif" alt="<?php echo Yii::t('jms','加载更多')?>"></div>
		<?php if(!(count($franchisees)< $size)):?>
		<div class="getMore clearfix" id="getMore"><span><?php echo Yii::t('jms','点击查看更多')?></span></div>
		<?php endif;?>	
		<div id="offOffset" style="display:none"><?php echo $size ?></div>
		
		<script type="text/javascript">
			$('#getMore').click(function(){
				$('#loader').show();
				var offset =  parseInt($('#offOffset').html());
				var ajaxCat = '<?php echo $cat ?>';
				var ajaxCity =  '<?php echo $city_id ?>';
				var ajaxKeyword =  '<?php echo $keyword ?>';
				
				$.post("<?php echo $this->createAbsoluteUrl('list') ?>",{'offset':offset,'ajaxCat':ajaxCat,'ajaxCity':ajaxCity,'ajaxKeyword':ajaxKeyword,YII_CSRF_TOKEN:'<?php echo Yii::app()->request->csrfToken ?>'}, function(data){
		  			var data_arr = jQuery.parseJSON(data);  
		  			if(data_arr.length< <?php echo $size ?>){
						$('#getMore').hide();
				  	} 		  			
		  			var str = '';		  			
		  			$.each(data_arr,function(index,item){str+='<li class="clearfix"> \
		  				<div class="liTit fl"> \
		  					<div class="storeLogo"><img height=120 src='+data_arr[index].logo+' alt="'+data_arr[index].name+'"/></div> \
		  					<div class="storeCount"><p class="name">'+data_arr[index].name+'</p><span class="discount">'+(data_arr[index].member_discount/10)+'折</span></div> \
		  				</div> \
		  				<div class="liImg fr"><a href="'+data_arr[index].id+'" title="'+data_arr[index].name+'" target="_blank"><img  src="'+data_arr[index].thumbnail+'" alt="'+data_arr[index].name+'"/></a><p class="category"><span>'+data_arr[index].c_name+'</span></p></div> \
		  				</li>';			  			
		  			});
		  			$('#offOffset').html(offset+<?php echo $size ?>);
		  			$('#result').append(str);
		  			$('#result').css('height','auto');		  			
				 });
				$('#loader').hide();
			});
		</script>
		
	</div>
	<!--------------主体 End------------>
<script type="text/javascript">

	$(document).ready(function(){
		$("#offLineKeyword").focus();
		window.location.hash="offLineIndexBox";
		$("#offLineKeyword").focus();
	});
	
</script>