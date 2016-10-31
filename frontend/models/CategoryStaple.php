<?php

/**
 * 店铺常用分类  模型
 *
 *   @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{category_staple}}':
 * @property string $id
 * @property string $name
 * @property string $category_id
 * @property string $type_id
 * @property string $store_id
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Type $type
 * @property Store $store
 */
class CategoryStaple extends CActiveRecord
{
	public function tableName()
	{
		return '{{category_staple}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, category_id, type_id, store_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('category_id, type_id, store_id', 'length', 'max'=>11),
			array('id, name, category_id, type_id, store_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'type' => array(self::BELONGS_TO, 'Type', 'type_id'),
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('categoryStaple','主键'),
			'name' => Yii::t('categoryStaple','名称'),
			'category_id' => Yii::t('categoryStaple','所属分类'),
			'type_id' => Yii::t('categoryStaple','所属类型'),
			'store_id' => Yii::t('categoryStaple','所属店铺'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('store_id',$this->store_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
