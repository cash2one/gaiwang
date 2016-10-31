<?php
class MobileRange extends CActiveRecord{
	
	public $un_province_id;                                     //省份ID
	public $province_id;                                     
	public $number_prefix;                                      //号码段
	public $un_city_number;                                     //区号
	public $un_city_name;                                       //城市名称
	public $operator;                                           //号码运营商
    public $un_province_name;                                    //省份
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{eptok_mobile_range}}';
	}
	
	public function attributeLabels(){
		return array(
				'un_province_id'=>yii::t('MobileRange','省份ID'),
				'number_prefix'=>yii::t('MobileRange','号码段'),
				'un_city_number'=>yii::t('MobileRange','区号'),
				'un_city_name'=>yii::t('MobileRange','城市名称'),
				'operator'=>yii::t('MobileRange','运营商(1移动,2联通,3电信)'),
				'un_province_name'=>yii::t('MobileRange','省份')
		);

	}
	
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('un_province_id', $this->un_province_id);
		$criteria->compare('number_prefix', $this->number_prefix, true);
		$criteria->compare('un_city_number', $this->un_city_number, true);
		$criteria->compare('un_city_name', $this->un_city_name,true);
		$criteria->compare('operator', $this->operator, true);
		$criteria->compare('province_id', $this->province_id);
		$criteria->compare('un_province_name', $this->un_province_name, true);
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}
}