<?php
class MobileMoneyRechargeConfig extends CActiveRecord{
	public $operator;              //运营商
	public $price;                 //面值
	public $pay_percent;           //盖网折扣
	public $province_id;           //省份ID
	public $un_province_id;        //盖网平台省份ID
	public $name;                   //省市名
	
	public static function model($className = __CLASS__){
		return  parent::model($className);
	}
	
	public function tablename(){
		return '{{eptok_mobile_money_recharge_config}}';
	}
	
	public function attributeLabels(){
		return array(
				'operator'=>Yii::t('MobileMoneyRechargeConfig','运营商(0未知,1移动,2联通,3电信)'),
				'price'=>Yii::t('MobileMoneyRechargeConfig','面值'),
				'pay_percent'=>Yii::t('MobileMoneyRechargeConfig','盖网折扣'),
				'province_id'=>Yii::t('MobileMoneyRechargeConfig','省份ID'),
				'un_province_id'=>Yii::t('MobileMoneyRechargeConfig','盖网平台省份ID'),
				'name'=>Yii::t('MobileMoneyRechargeConfig','省市名'),
		);
	}
	
	public function search(){
		$criteria = new CDbCriteria;
		$criteria->select = "operator,price,pay_percent,r.name";
		$criteria->join = "left join " .Region::model()->tablename()." as r on r.id = province_id";
		$criteria->compare('r.name',$this->name);
		$criteria->compare('operator',$this->operator,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('pay_percent',$this->pay_percent,true);
		$criteria->compare('province_id',$this->province_id);
		return new CActiveDataProvider($this,array(
				'criteria'=>$criteria,
		));
	}
	
}