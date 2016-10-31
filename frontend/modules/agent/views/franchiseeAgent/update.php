<?php
if ($model->apply_type==Auditing::APPLY_TYPE_BIZ_BASE){//基本信息
	$this->renderPartial('_baseform',array('model'=>$model));
}else if($model->apply_type==Auditing::APPLY_TYPE_BIZ_GUANJIAN){
	$this->renderPartial('_keyform',array('model'=>$model));
}else{
	$this->renderPartial('_form',array('model'=>$model));
}