<?php
Yii::import ( 'zii.widgets.CWidget' );
class CUploadPic extends CWidget {
	public $id;					//控件id，保存选中的图片的在表中对应的id的控件所对应的id
	public $num = 1;			//允许选中的图片的个数
	public $imgpath;			//选中的图片在表中对应的路径
	public $imgid = '';			//图片id			eg：1;2;3;
	public $classify = 0;		//图片类型：0-广告图片
	public $upload_height = 0;	//规定上传图片的高度
	public $upload_width = 0;	//规定上传图片的宽度
	public function run() {
		$imgData = '';
		if ($this->imgid!=''&&$this->imgpath==''){
			$this->imgid = str_replace(";",",",str_replace("|",",",$this->imgid));
			$sql = "select id,path from ".FileManage::tableName()." where id in (".$this->imgid.")";
			$imgData = FileManage::model()->findAllBySql($sql);
		}
		
		//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/artDialog.iframeTools.js");
		$this->render('view2',array(
			'id'=>$this->id,
			'num'=>$this->num,
			'imgpath'=>$this->imgpath,
			'classify'=>$this->classify,
			'height'=>$this->upload_height,
			'width'=>$this->upload_width,
			'imgData'=>$imgData,
			'imgid'=>$this->imgid
		));
	}
}
