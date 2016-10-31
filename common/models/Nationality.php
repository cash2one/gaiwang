<?php

/**
 * 国籍
 * This is the model class for table "{{nationality}}".
 *
 * The followings are the available columns in table '{{nationality}}':
 * @property string $id
 * @property string $name
 * @property integer $sort
 */
class Nationality extends CActiveRecord
{
	/**
	 * @return string 相关数据库表名
	 */
	public function tableName()
	{
		return '{{nationality}}';
	}

	/**
	 * @return array 验证规则
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name,sort', 'unique'),
			array('sort', 'numerical', 'integerOnly'=>true),
            array('sort', 'compare', 'operator' => '<=', 'compareValue' => 255, 'message' => Yii::t('nationality', '{attribute}值不在范围内')),
			array('name', 'length', 'max'=>128),
			array('id, name, sort', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关系规则
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array 自定义属性标签
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('nationality','编号'),
			'name' => Yii::t('nationality','国家名称'),
			'sort' => Yii::t('nationality','排序'),
		);
	}

	/**
	 *
	 * @return CActiveDataProvider 可以返回的数据提供程序模型
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'sort DESC, id DESC',
            ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
