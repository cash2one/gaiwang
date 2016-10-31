<?php

/**
 * This is the model class for table "{{app_brands}}".
 *
 * The followings are the available columns in table '{{app_brands}}':
 * @property string $id
 * @property string $title
 * @property string $img
 * @property string $description
 * @property integer $sort
 * @property integer $status
 * @property integer $admin
 * @property string $create_time
 * @property string $update_time
 */
class AppBrands extends CActiveRecord
{
	
    public $enTer;
    public $enTerTit;
    public $goods;
    public $goodsTit;
	
	const IS_PUBLISH_TRUE = 1;                                 //已发布
	const IS_PUBLISH_FALSE = 0;                                 //未发布
	
	
	
	/**
	 * 是否发布
	 * @param null $key
	 * @return array
	 */
	public static function getPublish($key = null){
		$data = array(
				self::IS_PUBLISH_FALSE => Yii::t('AppBrands','未发布'),
				self::IS_PUBLISH_TRUE => Yii::t('AppBrands','发布'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	/**
	 * 商家ID和商家名称分类
	 * @var unknown
	 */
	const ENTER_ID = 1;
	const ENTER_GW = 2;
	public static function getEnterType($key = null){
		$data = array(
				self::ENTER_ID => '商家ID',
				self::ENTER_GW => '商家GW号',
		);
	
		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}
	/**
	 * 商品ID和商品名称分类
	 * @var unknown
	 */
	const GOODS_ID = 1;
	const GOODS_NAME = 2;
	public static function getGoodsType($key = null){
		$data = array(
				self::GOODS_ID => '商品ID',
				self::GOODS_NAME => '商品名称',
		);
	
		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_brands}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description,sort,status', 'required'),
			array('sort, status, admin', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>10),
			array('description', 'length', 'max'=>255),
			array('img', 'length', 'max'=>128),
			array('img','required','on'=>'create'),
			array('create_time, update_time', 'length', 'max'=>11),
			array('img', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024*1024*0.5, 'tooLarge' => Yii::t('AppBrands', '文件大于500K，上传失败！请上传小于500K的文件！'), 'allowEmpty' => true, 'safe' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, img, description, sort, status, admin, create_time, update_time', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'img' => '图片',
			'description' => '描述',
			'sort' => '排序',
			'status' => '状态',
			'admin' => '创建人',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
			'enTerName' => '商家查询',
			'goods' => '商品查询',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('status',$this->status);
		$criteria->compare('admin',$this->admin);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppBrands the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
