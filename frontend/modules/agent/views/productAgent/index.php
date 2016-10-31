<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = $this->module->assetsUrl;
	Yii::app()->clientScript->registerCssFile($baseUrl. "/css/machine.css?v=1");
	$cs->registerScriptFile(DOMAIN. "/agent/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile(DOMAIN. "/agent/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
?>
<script type="text/javascript">
/**
 * 页面动画效果
 */
$(document).ready(function(){
	$("#overlayer").ajaxStart(function(a){
		   $(this).show();
		 });
	$("#overlayer").ajaxStop(function(){
		   $(this).hide();
		 });

	$('.tab').click(function() {
        $('.adClassList .tab').removeClass('selected');
        $(this).addClass('selected');
    });
});
/**
 * 删除指定广告
 */
function deleteAdvert(obj,title){
	art.dialog({
        icon: 'question',
        content: "<?php echo Yii::t('Public','确认删除')?><"+title+"><?php echo Yii::t('Product','这个商品')?>?",
        lock: true,
        okVal: '<?php echo Yii::t('Public','确定')?>',
        ok: function(){
			location.href=obj.href;
        },
        cancelVal: '<?php echo Yii::t('Public','取消')?>',
        cancel: function(){}
    });
    return false;
}

/**
 * 删除选中广告
 */
function deleteChoose(){
	var hasChecked = false;
	var idData = [];		//定义保存id变量
	$('.adListItem').find('input[type=checkbox]').each(function(){
		if(this.checked){
			idData.push(this.value);
			hasChecked = true;
		}
	});

	if(!hasChecked){
		art.dialog({
			icon: 'warning',
			content: "<?php echo Yii::t('Public','没有数据被选中')?>",
			lock:true,
                        okVal: '<?php echo Yii::t('Public','确定')?>',
			ok:true
		});
		return;
	}

	var myUrl = createUrl("<?php echo Yii::app()->createUrl('productAgent/delete')?>",{"id":idData});
	art.dialog({
		title: "<?php echo Yii::t('Public','删除')?>",
        icon: 'question',
        content: "<?php echo Yii::t('Product','确认删除选中商品')?>?",
        lock: true,
        okVal: '<?php echo Yii::t('Public','确定')?>',
        ok: function(){
        	jQuery.ajax({
        		type:'GET',async:false,cache:false,dataType:'html',
        		url:myUrl,
        		error:function(request,status,errorcontent){
        			alert(request.responseText);
        		},
        		success:function(data){
        			$.fn.yiiListView.update("product-list");
        			$('.dListTable').find('input[type=checkbox]').checked = false;
        			showMsg('succeed',"<?php echo Yii::t('Public','删除成功')?>!");
        		}
        	});
        },
        cancelVal: '<?php echo Yii::t('Public','取消')?>',
        cancel: function(){}
    });
}

/**
 * 分类查询
 */
function doQuery(categorypid,categoryid){
	$('#ProductAgent_category_pid').val(categorypid);		//改变广告大类的值
	$('#ProductAgent_category_id').val(categoryid);		//改变广告子类的值

	if(categorypid==''&&categoryid==''){
		$('.adClassListItem').find("ul").html('');
	}
	
	if(categorypid!=''&&categoryid==''){//如果有父节点但是没有子节点，表示点击的是父节点
		var myUrl = createUrl("<?php echo Yii::app()->createUrl('agent/productAgent/getChildType')?>",{"pid":categorypid});
		jQuery.ajax({
			type:"get",dataType:"json",cache:false,async:false,
			url:myUrl,
			error:function(request,status,error){
				alert(request.responseText);
			},
			success:function(data){
				var childHtml = '';
				for(var i=0;i<data.length;i++){
					childHtml += '<li class="" onclick="checkLi(this)"><a class="tab" href="javascript:doQuery('+data[i].pid+','+data[i].id+');"><span class="name">'+data[i].name+'</span></a></li>';
				}
				$('.adClassListItem').find("ul").html('').append(childHtml);
			}
		});
	}
	
	$('#submit_button').click();
}

/**
 * 给选中子类型添加一个样式
 */
function checkLi(obj){
	$('.adClassListItem').find("li").removeClass('selected');
	$(obj).addClass('selected');
}

/**
 * 操作选中对象：删除、审核通过、审核未通过
 */
function actionChoose(type){
	var hasChecked = false;
	var idData = [];
	$('.adListItem').find("input[type='checkbox']").each(function(){
		if(this.checked){
			idData.push(this.value);
			hasChecked = true;
		}
	});
	if(!hasChecked){
		art.dialog({
			icon: 'warning',
			content: "<?php echo Yii::t('Public','没有数据被选中')?>",
			lock:true,
                        okVal: '<?php echo Yii::t('Public','确定')?>',
			ok:true
		});
		return;
	}

	switch(type){
		case 'del':
			var myTitle = "<?php echo Yii::t('Public','删除')?>";
			var myContents = "<?php echo Yii::t('Public','确认删除选中记录')?>?";
			var myUrl = '<?php echo Yii::app()->controller->createUrl('delete')?>';
			var myShow = "<?php echo Yii::t('Product','所选商品<删除>操作成功')?>!";
			break;
		case 'pass':
			var myTitle = "<?php echo Yii::t('Public','审核通过')?>";
			var myContents = "<?php echo Yii::t('Product','确认选中商品通过审核')?>?";
			var myShow = "<?php echo Yii::t('Product','设定所选商品<通过审核>操作成功')?>!";
			var myUrl = '<?php echo Yii::app()->controller->createUrl('pass')?>';
			break;
		case 'fail':
			var myTitle = "<?php echo Yii::t('Public','审核不通过')?>";
			var myContents = "<?php echo Yii::t('Product','确认选中商品未通过审核')?>?";
			var myUrl = '<?php echo Yii::app()->controller->createUrl('fail')?>';
			var myShow = "<?php echo Yii::t('Public','设定所选商品<未通过审核>操作成功')?>!";
			break;
	}
	
	art.dialog({
		title: myTitle,
        icon: 'question',
        content: myContents,
        lock: true,
        okVal: '<?php echo Yii::t('Public','确定')?>',
        ok: function(){
        	jQuery.ajax({
        		type:'GET',async:false,cache:false,dataType:'html',
        		url:myUrl + "?id="+idData,
        		error:function(request,status,errorcontent){
        			alert(request.responseText);
        		},
        		success:function(data){
        			$.fn.yiiListView.update("product-list");
        			$('#chooseAll').attr('checked',false);   
        			check = false;
    				showMsg('succeed',myShow);
        		}
        	});
        },
        cancelVal: '<?php echo Yii::t('Public','取消')?>',
        cancel: function(){}
    });
}

artDialog.notice = function (options) {
    var opt = options || {},
        api, aConfig, hide, wrap, top,
        duration = 800;
        
    var config = {
        id: 'Notice',
        left: '99%',
        top: '99%',
        fixed: true,
        drag: false,
        resize: false,
        follow: null,
        lock: false,
        init: function(here){
            api = this;
            aConfig = api.config;
            wrap = api.DOM.wrap;
            top = parseInt(wrap[0].style.top);
            hide = top + wrap[0].offsetHeight;
            
            wrap.css('top', hide + 'px')
                .animate({top: top + 'px'}, duration, function () {
                    opt.init && opt.init.call(api, here);
                });
        },
        close: function(here){
            wrap.animate({top: hide + 'px'}, duration, function () {
                opt.close && opt.close.call(this, here);
                aConfig.close = $.noop;
                api.close();
            });
            
            return false;
        }
    };	
    
    for (var i in opt) {
        if (config[i] === undefined) config[i] = opt[i];
    };
    
    return artDialog(config);
};

function showMsg(img,myContent){
	art.dialog.notice({
	    tlock:false,//不锁屏
		title:"提示",//标题
		icon:img,//图标
		content:myContent,//提示信息
		time:3,//显示时间
		fixed:true,//定位不动
		width:225,//宽度
		height:105,//高度
		drag: false,//和resize合并起来表示禁止拖动
	    resize: false,
		left: '99%',//显示位置
	    top: '99%'
	});
}

/**
 * 全选
 */
function doChooseAll(obj,className){
	var checked = obj.checked == true?true:false;
	obj.checked = checked;
	$('.'+ className).find("input[type='checkbox']").attr("checked",checked);
}

/**
 * 生成url的js方法
 */
function createUrl(route, param)
{
	var urlFormat = "/";
	for(var key in param)
	{
		route += urlFormat+key+urlFormat+param[key]+urlFormat;
	}
	return route;
}
</script>
<div class="ctx advertMana">
	<div class="optPanel">
		<div class="toolbar img01">
			<?php
				echo Yii::t('Product','商品管理'); 
			?>
		</div>
		<?php $this->renderPartial('_search',array('model'=>$model));?>
		
		<div class="panel">
			<div class="adClassList">
				<ul>
					<li><?php echo CHtml::link(Yii::t('Public','所有分类'),'javascript:doQuery("","");',array('class'=>'tab selected'))?></li>
					<?php foreach ($typeData as $key=>$val):?>
					<li>
						<?php echo CHtml::link($val['name'],'javascript:doQuery('.$val['id'].',"");',array('class'=>'tab','style'=>'background:url(/agent/images/home.gif) no-repeat 10px 2px;'))?>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="adClassListItem"><ul></ul></div>
		</div>
	</div>
	
	<div id="myShow" class="tip succ" style="display:none"></div>
	
	<div id="dListTable" class="ctxTable">
		<div class="headerBar">
			&nbsp;&nbsp;&nbsp;<label><?php echo CHtml::checkBox("chooseAll",false,array('onclick'=>'doChooseAll(this,"adListItem")'))?><?php echo Yii::t('Public','全选')?></label>&nbsp;&nbsp;
			<?php echo CHtml::link(Yii::t('Public','批量删除'),"javascript:actionChoose('del')",array('class'=>'button_04'))?>
			<?php echo CHtml::link(Yii::t('Public','添加'),$this->createUrl('productAgent/create'),array('class'=>'button_04'))?>
		</div>
		<div class="adListItem">
			<ul class="ad-list">
				<?php 
					$this->widget('application.modules.agent.widgets.ListView', array(
						'dataProvider'=>$model->search(),
						'itemView'=>'_view',
						'id' => 'product-list'
					)); 
				?>
			</ul>
		</div>
	</div>
</div>
<?php 
	$msg_session_key = Yii::app()->params['msgSessionKey'];
	if (Yii::app()->user->hasState($msg_session_key)){
		$msg = Yii::app()->user->getState($msg_session_key);
		echo "<script>showMsg('".$msg['img']."','".$msg['content']."');</script>";
		Yii::app()->user->setState($msg_session_key,null);
	}
?>