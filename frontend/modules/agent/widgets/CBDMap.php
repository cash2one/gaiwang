<?php
Yii::import('zii.widgets.CWidget');

class CBDMap extends CWidget{
	public $lng;		//经度
	public $lat;		//纬度
	public $cityname;	//城市名称
	public $type = 'show';
	public $level = 14;  //最大18
	public $title = '地理位置';  //a标签的titile
	
	public $form = NULL;	//表单
	public $model = null;	//模型
	public $attr_lng = '';	//经度属性
	public $attr_lat = '';	//纬度属性
	public $showClass = 'move_right_a1 fl';		//显示按钮样式
	public $useClass = 'input_box';		//操作控件样式
	public $buttonClass = 'button_07';	//按钮样式
	public function run(){
		$apiAK = Yii::app()->params['mapApiAK'];
		$this->render('map',array(
			'lng'=>$this->lng,
			'lat'=>$this->lat,
			'cityname'=>$this->cityname,
			'type'=>$this->type,
			'api'=>$apiAK,
			'level'=>$this->level,
			'title'=>$this->title,
		
			'form'=>$this->form,
			'model'=>$this->model,
			'attr_lng'=>$this->attr_lng,
			'attr_lat'=>$this->attr_lat,
			'showClass'=>$this->showClass,
			'useClass'=>$this->useClass,
			'buttonClass'=>$this->buttonClass,
			)
		);
	}
}