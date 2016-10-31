<?php 
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs = Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	$cs->registerScriptFile($baseUrl. "/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
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
    <div class="line table_white" style="margin: 10px">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
            <tr class="table1_title">
                <td colspan="8"><?php echo Yii::t('Franchisee','申请列表')?>(<?php echo $model->searchApply()->totalItemCount?>)</td>
            </tr>
            <tr>
                <td colspan="8" class="table_search">
                	<div class="form_search">
                	<?php
						Yii::app()->clientScript->registerScript('search', "
						$('#franchiseeAgent-applylist-search').submit(function(){
							$('#franchisee-agent-grid').yiiGridView('update', {
								data: $(this).serialize()
							});
							return false;
						});
						");
					?>
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id' => 'franchiseeAgent-applylist-search',
						'action'=>$this->createUrl($this->route),
						'method'=>'get',
					)); ?>
					      <label for="textfield"></label>
					      <p><?php echo $form->label($model, 'apply_name')?>：</p>
					      <?php echo $form->textField($model, 'apply_name', array('class' => 'search_box3'))?>
					      <?php echo CHtml::submitButton('',array('class'=>'search_button3'));?>
					<?php $this->endWidget(); ?>
					</div>
                </td>
            </tr>
        </table>
        
        <?php		//申请列表里面只能查询暂存的 
				        $this->widget('application.modules.agent.widgets.grid.GridView',array(
				            'id'=>'franchisee-agent-grid',
				            'itemsCssClass' => 'tablestore',
				            'dataProvider' => $model->searchApply(),
				            'pagerCssClass' => 'line pagebox',
				        	'template' => '{items}{pager}',
				            'columns' => array(
				                array(  //申请类型
				                    'htmlOptions' => array('class' => 'tc'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'name' => 'apply_type',
				                    'value' => 'Auditing::getApplyType($data->apply_type)',
				                	'type' => 'raw',
				                ),
				                array(  //加盟商名称
				                    'htmlOptions' => array('class' => 'tc'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'name' => 'apply_name',
				                    'value' => '$data->apply_name',
				                ),
				                array(  // 创建时间
				                    'htmlOptions' => array('class' => 'tc'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'name' => 'create_time',
				                    'value' => 'date("Y-m-d H:i:s",$data->create_time)',
				                ),
				                array(  //  申请时间
				                    'htmlOptions' => array('class' => 'tc'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'name' => Yii::t('Franchisee','申请时间'),
				                    'value' => 'date("Y-m-d H:i:s",$data->create_time)',
				                ),
				                array(  // 申请状态
				                    'htmlOptions' => array('class' => 'tc'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'name' => 'status',
				                    'value' => 'Auditing::getStatus($data->status)',
				                	'type' => 'raw',
				                ),
				                array(  //操作
				                    'class'=>'CButtonColumn',
                                	'template'=>'{update}',
				                    'header' => Yii::t('Franchisee','操作'),
				                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
				                    'htmlOptions' => array('class' => 'tc'),
				                    'buttons'=>array(
				                		'update' => array(
				                            'label' => Yii::t('Franchisee','【查看】'),
				                			'options' => array('class'=>'orange'),
				                            'url' => 'Yii::app()->controller->createUrl($data->status==Auditing::STATUS_WAIT?"update":"look", array("id"=>$data->primaryKey))',
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