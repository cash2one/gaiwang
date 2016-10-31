<?php

/**
 * This is the model class for table "{{hos_sell_order}}".
 *
 * The followings are the available columns in table '{{hos_sell_order}}':
 * @property string $id
 * @property string $name
 * @property string $logo
 * @property integer $type
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $create_user
 * @property string $update_user
 */
class HosSellOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hos_sell_order}}';
	}
	//热卖专场类别
	const HOT_SELL_TYPE_NEWCAR = 1;
	const HOT_SELL_TYPE_LIFE = 2;
	const HOT_SELL_TYPE_HOUSE = 3;
	const HOT_SELL_TYPE_CITESHOW = 4;
	const HOT_SELL_TYPE_GAIXIANHUI = 5;
	const HOT_SELL_TYPE_SHANGLV = 6;
	const HOT_SELL_TYPE_BRANDS = 7;
	const HOT_SELL_TYPE_ALL = 8;
	const HOT_SELL_TYPE_WEB_APP = 9;    
	
	//热卖专场状态
	const HOT_SELL_STATUS_YES = 1; //启用
	const HOT_SELL_STATUS_NO = 0;  //停用
	/**
	 * 热卖分类
	 * @param null $key
	 * @return array
	 */
	public static function getHotSellType($key = null){
		$data = array(
				self::HOT_SELL_TYPE_NEWCAR => Yii::t('HosSellOrder','新动'),
				self::HOT_SELL_TYPE_LIFE => Yii::t('HosSellOrder','臻致生活'),
				self::HOT_SELL_TYPE_HOUSE => Yii::t('HosSellOrder','仕品'),
				self::HOT_SELL_TYPE_CITESHOW => Yii::t('HosSellOrder','城市馆'),
				self::HOT_SELL_TYPE_GAIXIANHUI => Yii::t('HosSellOrder','盖鲜汇'),
				self::HOT_SELL_TYPE_SHANGLV => Yii::t('HosSellOrder','至优商旅'),
				self::HOT_SELL_TYPE_BRANDS => Yii::t('HosSellOrder','品牌馆'),
				self::HOT_SELL_TYPE_ALL => Yii::t('HosSellOrder','全部分类'),
				self::HOT_SELL_TYPE_WEB_APP => Yii::t('HosSellOrder','WebApp'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	/**
	 * 热卖状态
	 * @param null $key
	 * @return array
	 */
	public static function getHotSellStatus($key = null,$type = true){
		$data = array(
				self::HOT_SELL_STATUS_YES => Yii::t('HosSellOrder','显示'),
				self::HOT_SELL_STATUS_NO => Yii::t('HosSellOrder','隐藏'),
		);
	//	self::model('HosSellOrder')->status = self::HOT_SELL_STATUS_YES ? self::HOT_SELL_STATUS_NO : self::HOT_SELL_STATUS_YES;
		//var_dump(self::model('HosSellOrder')->status);die();
		//用于修改状态按钮
// 		if(!$type){
// 			var_dump(1111);die();
// 			$data = array(
// 					self::HOT_SELL_STATUS_YES => Yii::t('HosSellOrder','停用'),
// 					self::HOT_SELL_STATUS_NO => Yii::t('HosSellOrder','启用'),
// 			);
// 		}
		return $key === null ? $data : $data[$key];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, status,type,sequence', 'required'),
			array('type, status,sequence', 'numerical', 'integerOnly'=>true),
			array('logo','required','on'=>'create'),
			array('name', 'unique'),
			array('type', 'CheckType','on'=>'create'),
			array('type', 'CheckTypeUpdate'),
			array('name', 'length', 'max'=>4),
			array('logo', 'length', 'max'=>255),
			array('create_time, update_time, create_user, update_user', 'length', 'max'=>11),
			array('link', 'length', 'max'=>128),
			array('link', 'url'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('logo', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024*1024*0.5, 'tooLarge' => Yii::t('hossellorder', '文件大于500K，上传失败！请上传小于500K的文件！'), 'allowEmpty' => true, 'safe' => true),
			array('id, name, logo, type, status, link,create_time,sequence, update_time, create_user, update_user', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名称',
			'logo' => '图标',
			'type' => '类型',
			'status' => '状态',
			'link' => '链接',
			'create_time' => '创建时间',
			'update_time' => '编辑时间',
			'create_user' => '创建者',
			'update_user' => '修改者',
			'sequence'=>'排序',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('type',$this->type);
		//$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user',$this->create_user,true);
		$criteria->compare('update_user',$this->update_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HosSellOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function CheckType($attribute,$params){
		if($this->type != self::HOT_SELL_TYPE_WEB_APP){
			$sql = "SELECT * FROM ".HosSellOrder::model()->tableName()." where type = '{$this->type}' and status = '".self::HOT_SELL_STATUS_YES."' ";
			$result = Yii::app()->db->createCommand($sql)->queryRow();
			if($result) $this->addError('type',"已存在正在使用的入口类型,请先将此类入口类型状态改变为隐藏");
		}
	}
	
	public function CheckTypeUpdate($attribute,$params){
		if($this->type != self::HOT_SELL_TYPE_WEB_APP){
			$sql = "SELECT * FROM ".HosSellOrder::model()->tableName()." where type = '{$this->type}' and status = '".self::HOT_SELL_STATUS_YES."' and id != '{$this->id}'";
			$result = Yii::app()->db->createCommand($sql)->queryRow();
			if($result) $this->addError('type',"已存在正在使用的入口类型,请先将此类入口类型状态改变为隐藏");
		}
	}
	
	/**
	 * 输出图片，点击图片显示真是图片
	 * @param string $path	图片路径(可能是略缩图)
	 * @param int $maxwidth	宽度
	 * @param int $maxheight	高度
	 * ,'onmouseover'=>'showDelImg()','onmouseout'=>'hideDelImg()'
	 */
	public static function showRealImg($path,$maxwidth = 0, $maxheight = 0){
		$html='';
		//$html .= "<a href='".ATTR_DOMAIN .DS. $path."' onclick='return _showBigPic(this)'>";
		if($maxwidth == 0 && $maxheight == 0){
			$html.= "<img src='".ATTR_DOMAIN .'/'. $path."' />";
		}else{
			$html.= "<img src='".ATTR_DOMAIN .'/'. $path."' width='".$maxwidth."' height = '".$maxheight."'/>";
		}
		$html.="</a>";
		echo $html;
	}
}
