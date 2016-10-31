    <!--线下服务
	 
    <!--线下服务索引栏 begin
    <div class="offLineinNav mgb15">
    	<div class="indexCon">Hi，欢迎来到盖网通的世界，请尽情享受盖网O2O模式为你带来的全新服务体验！<a href="index.html" title="前往盖象商城">盖象商城</a> > <a href="#" title="线下服务">线下服务</a></div>
    </div>-->
    <!--线下服务索引栏 end-->
    
    
    <!--------------主体 begin---------->
	<div class="offLineNav02">
		<div id="indexBox" class="indexBox">
			<form action="<?php echo $this->createAbsoluteUrl('list') ?>">
			<div class="indexCon clearfix">
				<div class="tipMsg fl"><?php echo Yii::t('jms','Hi，欢迎来到盖网通的世界，请尽情享受盖网O2O模式为你带来的全新服务体验！')?></div>				
					<div class="searchBar fr">						
						<input  type="hidden" name="city" value="<?php echo $city?>"/><input class="skeyWord" type="text" name="keyword" value=""/><input class="submit" type="submit" value="<?php echo Yii::t('jms','搜索')?>"/>
					</div>				
			</div>
			</form>
		</div>
		<div class="navBox clearfix">
			<ul class="clearfix">
				<li><a class="curr" href="<?php $this->createAbsoluteUrl('index')?>" title="<?php echo Yii::t('jms','盖网通联盟商户类别')?>" target="_blank"><?php echo Yii::t('jms','盖网通联盟商户类别')?></a></li>
				<?php foreach ($categorys as $category):?>				
				<li><a href="<?php echo $this->createAbsoluteUrl('list',array('cat'=>$category['id'],'city'=>$city)) ?>" title="<?php echo Yii::t('jms',$category['name'])?>" ><?php echo Yii::t('jms',$category['name'])?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
    <div class="main">   	
        <div class="offLineStore">
			<div class="linebg"></div>
			<div class="storeShow clearfix">
				<div class="storeNews fl">
					<div class="sNewTit"><?php echo Yii::t('jms','最新商户资讯')?></div>
					<ul>
					<?php $advert = Advert::getConventionalAdCache('jms-index-news-left');  // 获取加盟商幻灯片广告缓存数据
                    $advert = isset($advert['0'])?$advert:array();
		     		if (!empty($advert)):?>
                    <?php $advert = array_slice($advert,0,3); //截取排序值较大三个?>
            		<?php foreach ($advert as $a):?>
						<li><a href="<?php echo $a['link']?>" title="<?php echo $a['title']?>" target="_blank"><img height="95px" src="<?php echo ATTR_DOMAIN . '/' . $a['picture']?>" alt=""/><p><?php echo $a['title']?></p></a></li>
					<?php endforeach;?>	
					<?php endif;?>					
					</ul>
				</div>
				<div class="storeSlider clearfix fl" id="storeSlider" >
					<ul>
					<?php $advert = Advert::getConventionalAdCache('jms-index-news-center');  // 获取加盟商幻灯片广告缓存数据
                    $advert = isset($advert['0'])?$advert:array();
		     		if (!empty($advert)):?>
            		<?php foreach ($advert as $a):?>
						<li><a href="<?php echo $a['link']?>" title="<?php echo $a['title']?>"><img height="400" alt="<?php echo $a['title']?>" src="<?php echo ATTR_DOMAIN . '/' . $a['picture']?>"></a></li>
					<?php endforeach;?>
					<?php endif;?>				
					</ul>			  
					<div class="thumb"></div>
				</div>
				<div class="storeList clearfix fr">
					<ul>
					<?php $advert = Advert::getConventionalAdCache('jms-index-news-right');  // 获取加盟商幻灯片广告缓存数据
                    $advert = isset($advert['0'])?$advert:array();
		     		if (!empty($advert)):?>
                    <?php $advert = array_slice($advert,0,4);//截取排序较大的四个?>
            		<?php foreach ($advert as $a):?>
						<li class="st1"><a href="<?php echo $a['link']?>" title="<?php echo $a['title']?>" target="_blank"><img width="285" height="195" src="<?php echo ATTR_DOMAIN . '/' . $a['picture']?>" alt="<?php echo $a['title'] ?>"/><p></p></a></li>					
					<?php endforeach;?>
					<?php endif;?>
					</ul>
				</div>
			</div>
		</div>
		<?php 		
            $advert = Advert::getConventionalAdCache('jms-index-center');  // 获取加盟商幻灯片广告缓存数据
            $advert = isset($advert['0'])?$advert:array();
            if (!empty($advert)):?>
            <div class="offLineAd"><a href="<?php echo $advert[0]['link']?>" title="<?php echo $advert[0]['title']?>" target="_blank"><img width=1200 height=182 src="<?php echo ATTR_DOMAIN . '/' . $advert[0]['picture']?>" alt="<?php echo $advert[0]['title']?>"/></a></div>
		<?php else: ?>
			<div style="width:1200px;height:182px" class="offLineAd"><a href="#" title="" target="_blank"><img width=1200 height=182 src="#" alt=""/></a></div>
		<?php endif;?>
    </div>
	<div class="slashLinebg"></div>
			<div id="barMenuBtn" class="clearfix">
				<div class="storeMenu" id="storeMenu">
				<div class="storeCategory" id="storeCate">
						<div class="storeSort">
							<h2><?php echo Yii::t('jms','商户分类')?></h2>
							<ul>
							<?php foreach ($categorys as $category):?>
								<li><a href="<?php echo $this->createAbsoluteUrl('list',array('cat'=>$category['id'],'city'=>$city)) ?>" title="<?php echo Yii::t('jms',$category['name'])?>"><?php echo Yii::t('jms',$category['name'])?></a></li>
							<?php endforeach;?>			
							</ul>
						</div>
						<div class="storeArea">
							<h2><?php echo Yii::t('jms','商户地域')?></h2>
							<ul class="clearfix">
							<?php foreach($offlineCity as $fcity): ?>
								<li><a <?php echo ($city == $fcity['city_id'])? 'class="curr"':'' ?> href="<?php echo $this->createAbsoluteUrl('list',array('city'=>$fcity['city_id'])) ?>" title="<?php echo $fcity['name']?>"><?php echo substr($fcity['name'],0,6)?></a></li>
							<?php endforeach;?>
							</ul>
						</div>
					</div>	
			    </div>
			</div>	
	<div class="offLineMain clearfix" >
		<div class="offLineMainbar fl">
			<div class="mainbarTit"><hr/><h1><?php echo Yii::t('jms','盖网通最新联盟商户')?><p><?php echo Yii::t('jms','更新时间')?> <?php echo date(Yii::t('jms','Y年m月'))?></p></h1>
		
			</div>
			<div class="servicesList">
				<ul class="clearfix" id="result">
				<?php foreach ($newsFranchisee as $franchisee):?>
					<li class="clearfix">
						<div class="liTit fl">
							<div class="storeLogo"><img height=120 src="<?php echo Tool::showImg( ATTR_DOMAIN . '/' . $franchisee['logo'], 'h_120,w_240')?>" alt="<?php echo $franchisee['name']?>"/></div>
							<div class="storeCount"><p class="name"><?php echo $franchisee['name']?></p><span class="discount"><?php echo $franchisee['member_discount']/10 ?>折</span></div>
						</div>
						<div class="liImg fr"><a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$franchisee['id'])) ?>" title="<?php echo $franchisee['name']?>" target="_blank"><img  src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $franchisee['thumbnail'], 'h_200,w_600')  ?>" alt="<?php echo $franchisee['name'] ?>"/></a><p class="category"><span><?php echo $franchisee['c_name'] ?></span></p></div>
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
					<li><a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$recommend['id']))?>" title="<?php echo $recommend['name']?>" target="_blank"><img height=65px src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $recommend['logo'], 'h_100,w_200')  ?>" alt="<?php echo $recommend['name']?>"/><p><span class="red"><?php echo $recommend['member_discount']/10?></span><?php echo Yii::t('jms','折')?></p></a></li>
				<?php endforeach;?>	
				</ul>
			</div>
		</div>
		<div class="loader" id="loader" style="display:none"><img src="../images/bg/loading.gif" alt="<?php echo Yii::t('jms','加载更多')?>"></div>
		<?php if(!(count($newsFranchisee)< $size)):?>
		<div class="getMore clearfix" id="getMore"><span><?php echo Yii::t('jms','点击查看更多')?></span></div>
		<?php endif;?>		
		<div id="offOffset" style="display:none"><?php echo $size ?></div>
		<script type="text/javascript">
			$('#getMore').click(function(){
				$('#loader').show();
				var offset =  parseInt($('#offOffset').html());
				
				$.post("<?php echo $this->createAbsoluteUrl('index') ?>",{'offset':offset,YII_CSRF_TOKEN:'<?php echo Yii::app()->request->csrfToken ?>'}, function(data){
		  			var data_arr = jQuery.parseJSON(data); 
		  			if(data_arr.length < <?php echo $size ?>){			  			
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