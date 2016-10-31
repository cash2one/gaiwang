<?php

/**
 *  {{attribute_index}} 模型
 *
 * The followings are the available columns in table '{{attribute_index}}':
 * @property string $goods_id
 * @property string $category_id
 * @property string $type_id
 * @property string $attribute_id
 * @property string $attribute_value_id
 */
class AttributeIndex extends CActiveRecord
{
	public function tableName()
	{
		return '{{attribute_index}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('goods_id, category_id, type_id, attribute_id, attribute_value_id', 'required'),
			array('goods_id, category_id, type_id, attribute_id, attribute_value_id', 'length', 'max'=>11),
			array('goods_id, category_id, type_id, attribute_id, attribute_value_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'goods_id' => Yii::t('attributeIndex','所属商品'),
			'category_id' => Yii::t('attributeIndex','所属分类'),
			'type_id' => Yii::t('attributeIndex','所属类型'),
			'attribute_id' => Yii::t('attributeIndex','所属属性'),
			'attribute_value_id' => Yii::t('attributeIndex','所属属性值'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('goods_id',$this->goods_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('attribute_id',$this->attribute_id,true);
		$criteria->compare('attribute_value_id',$this->attribute_value_id,true);

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
