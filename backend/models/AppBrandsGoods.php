<?php

/**
 * This is the model class for table "{{app_brands_goods}}".
 *
 * The followings are the available columns in table '{{app_brands_goods}}':
 * @property string $id
 * @property integer $brands_id
 * @property integer $goods_id
 * @property integer $sequence
 * @property integer $type
 */
class AppBrandsGoods extends CActiveRecord
{
	public $goodName;
	public $goodId;
	public $thumbnail;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_brands_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brands_id, goods_id, sequence, type', 'required'),
			array('brands_id, goods_id, sequence, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, brands_id, goods_id, sequence, type', 'safe', 'on'=>'search'),
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
			'id' => '主键id',
			'brands_id' => '品牌馆id',
			'goods_id' => '商品id',
			'sequence' => '排序',
			'type' => '商品类型',
			'goodName' => '商品名称',
			'goodId' => '商品Id',
			'thumbnail'=>'缩略图',
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
		$criteria->select = 't.*,g.name as goodName,g.id as goodId,g.thumbnail';
		$criteria->join .= ' left join ' . Goods::model()->tableName() . ' as g on g.id = t.goods_id';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('brands_id',$this->brands_id);
		//$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('type',$this->type);
//var_dump($criteria);die();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppBrandsGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/*
	 * 判断有没有绑定商品
	 * */
	public static function checkBondGoods($brandsId,$goodsId){
		$check = Yii::app()->db1->createCommand()
		->select('id')
		->from(self::model()->tableName())
		->where('brands_id = :brands_id and goods_id = :goods_id', array(':brands_id' => $brandsId, ':goods_id' => $goodsId))
		->order('id desc')
		->queryScalar();
		return empty($check)?'':$check;
	}
}
