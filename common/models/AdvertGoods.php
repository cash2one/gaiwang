<?php

/**
 * This is the model class for table "{{advert_goods}}".
 * 广告商品模型
 * The followings are the available columns in table '{{advert_goods}}':
 * @property string $advert_id
 * @property string $goods_id
 * @property integer $sort
 * 
 * @author leo8705
 * 
 */
class AdvertGoods extends CActiveRecord
{
	
	public $goods_thumbnail,$goods_id,$goods_name;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advert_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('advert_id, goods_id, sort', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			array('advert_id, goods_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('advert_id, goods_id, sort', 'safe', 'on'=>'search'),
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
			'goods' => array(self::BELONGS_TO, 'Goods', 'advert_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'advert_id' => '所属广告',
			'goods_id' => '商品',
			'sort' => '排序',
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

		$criteria->compare('advert_id',$this->advert_id);
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchAll()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'g.name as goods_name,g.thumbnail as goods_thumbnail,g.id as goods_id,t.sort ,t.advert_id';
		$criteria->compare('t.advert_id',$this->advert_id);
		$criteria->compare('t.goods_id',$this->goods_id);
		$criteria->compare('t.sort',$this->sort);
		
		$criteria->join = ' LEFT JOIN {{goods}} as g ON t.goods_id = g.id';
		
		$criteria->order = 'sort';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdvertGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
