<?php
Yii::import ( 'zii.widgets.CWidget' );
class GTUploadPic extends CWidget {
	public $num = 1;				//允许选中的图片的个数
	public $upload_height = 0;		//规定上传图片的高度
	public $upload_width = 0;		//规定上传图片的宽度
	public $model = NULL;			//模型对象
	public $attribute = '';			//模型属性
	public $form = NULL;			//表单类
	public $classify = FileManageAgent::FILETYPE_PD;	//图片分类
	
	public function run() {
		$imgData = array();
		$model = $this->model;
		$attr = $this->attribute;
		$val = '';
		$val = str_replace(";",",",str_replace("|",",",$model->$attr));
		if($val!=''){
			$sql = "select id,path from {{file_manage}} where id in ($val)";
			$imgData = Yii::app()->gt->createCommand($sql)->queryAll();
		}
		$this->render('view',array(
			'num'=>$this->num,
			'height'=>$this->upload_height,
			'width'=>$this->upload_width,
			'imgData'=>$imgData,
			'model'=>$this->model,
			'attribute'=>$this->attribute,
			'form'=>$this->form,
			'classify'=>$this->classify,
		));
	}
}
