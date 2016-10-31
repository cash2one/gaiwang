<?php 
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs = Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	$cs->registerScriptFile(AGENT_DOMAIN. "/agent/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile(AGENT_DOMAIN. "/agent/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
?>
<?php
//Yii::app()->clientScript->registerScript('search', "
//$('.form_search form').submit(function(){
//	$('#franchisee-agent-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<style>
.tablestore { font-size:12px; color:#646464; line-height:20px; background-color:#f7f7f7;width:100%;}
.tablestore td,.tablestore th { border:1px solid #cdcdcd; padding:10px 0 10px 5px; }
a {display: inline-block;;text-decoration: none;}
</style>

<script type="text/javascript">
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
</script>
<div class="account_right">
    <div style="margin: 10px" class="line table_white">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table1">
            <tr bgcolor="#fcfcfc" class="table1_title" style="background-color: rgb(238, 238, 238);">
                <td colspan="8">
                    <?php echo Yii::t('Franchisee', '加盟商列表')?>(<?php echo $model->search()->totalItemCount?>)
                </td>
            </tr>
            <tr bgcolor="#fcfcfc">
                <td class="table_search" colspan="8">
                    <?php $this->renderPartial('_search',array('model'=>$model));?>
                </td>
            </tr>
        </table>
        <?php 
        $this->widget('application.modules.agent.widgets.grid.GridView',array(
            'id'=>'franchisee-agent-grid',
            'itemsCssClass' => 'tablestore',
            'dataProvider' => $model->search(),
            'pagerCssClass' => 'line pagebox',
        	'template' => '{items}{pager}',
            'columns' => array(
                array(  //加盟商名称
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'name',
                    'value' => '$data->name',
                ),
                array(  //加盟商编号
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'code',
                    'value' => '$data->code',
                ),
                array(  //所属会员
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Franchisee','所属会员'),
                    'value' => '$data->username',
                ),
                array(  //会员编号
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Franchisee','会员编号'),
                    'value' => '$data->gai_number',
                ),
                array(  //父加盟商
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Franchisee','父加盟商'),
                    'value' => '$data->parentname',
                ),
                array(  //加盟商电话
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'mobile',
                    'value' => '$data->mobile',
                ),
                array(  //最大绑定盖机数
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'max_machine',
                    'value' => '$data->max_machine',
                ),
                array(  //操作
                    'class'=>'CButtonColumn',
                    'header' => Yii::t('Franchisee','操作'),
                	'template'=>'{updatebase} {updatekey} {look}',
//                	'template'=>'{updateconfirm}',
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width'=>'275'),
                    'htmlOptions' => array('class' => 'tc'),
                    'buttons'=>array(
//                        'updateconfirm' => array(		//编辑已经审核通过的
//                            'label' => '<span color="#FF7F00">【查看】</span>',
//                            'url' => 'Yii::app()->controller->createUrl("updateConfirm", array("id"=>$data->primaryKey))',
//                            'imageUrl' => false
//                        ),
                        'updatebase' => array(
                            'label' => Yii::t('Franchisee','【基本信息】'),
                			'options' => array('class'=>'orange'),
                            'url' => 'Yii::app()->controller->createUrl("listUpdateBase", array("id"=>$data->primaryKey))',
                            'imageUrl' => false,
                			'visible'=>'false',
                        ),
                        'updatekey' => array(
                            'label' => Yii::t('Franchisee','【关键信息】'),
                        	'options' => array('class'=>'orange'),
                            'url' => 'Yii::app()->controller->createUrl("listUpdateKey", array("id"=>$data->primaryKey))',
                            'imageUrl' => false,
                        	'visible'=>'false',
                        ),
                        'look' => array(
                            'label' => Yii::t('Franchisee','【查看】'),
                        	'options' => array('class'=>'green'),
                            'url' => 'Yii::app()->controller->createUrl("listLook", array("id"=>$data->primaryKey))',
                            'imageUrl' => false
                        ),
                    ),
                ),
            )
        ));
    ?>
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