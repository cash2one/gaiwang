<?php 
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs = Yii::app()->clientScript;
			
	$cs->registerCoreScript('jquery');
	$cs->registerScriptFile($baseUrl. "/js/map/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile($baseUrl. "/js/map/artDialog.iframeTools.js");				//弹出框调用远程文件插件
	$cs->registerScriptFile($baseUrl. "/js/map/map.js");                             //一些通用js方法

	if($type=='show'){//如果只是展示地图
		
		$url = Yii::app()->createUrl('/agent/mapAgent/show');
		echo CHtml::link('','javascript:;',array(
			'class'=>$showClass,
			'title'=>$title,
			'onclick'=>"_doMap('$lng','$lat','$type','$cityname',$level,'$url','$api')"
		));
	}else{
		$modelClass = get_class($model)."_";
		$url = Yii::app()->createUrl('/agent/mapAgent/use');
		
		echo $form->textField($model,$attr_lng,array('class'=>$useClass,'readonly'=>true));
		
		echo $form->textField($model,$attr_lat,array('class'=>$useClass,'readonly'=>true));
		
		echo CHtml::button(Yii::t('Public','选择位置'),array(
		'class'=>$buttonClass,
		'onclick'=>"_doMap('$modelClass$attr_lng','$modelClass$attr_lat','$type','$cityname',$level,'$url','$api')",
		));
	 
		echo $form->error($model,$attr_lng);
		echo $form->error($model,$attr_lat);
	}
?>