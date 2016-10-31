<?php

/**
 *  {{pay_result}} 模型
 *
 * The followings are the available columns in table '{{pay_result}}':
 * @property string $id
 * @property string $code
 * @property string $pay_result
 * @property integer $pay_type
 * @property string $update_time
 * @property string $create_time
 * @property string $times
 * @property integer $order_type
 */
class PayResult extends CActiveRecord
{
	public function tableName()
	{
		return '{{pay_result}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('code, pay_result, pay_type, update_time, create_time, times, order_type', 'required'),
			array('pay_type, order_type', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>64),
			array('update_time, create_time, times', 'length', 'max'=>11),
			array('id, code, pay_result, pay_type, update_time, create_time, times, order_type', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('payResult','主键'),
			'code' => Yii::t('payResult','支付单号'),
			'pay_result' => Yii::t('payResult','结果'),
			'pay_type' => Yii::t('payResult','支付方式'),
			'update_time' => Yii::t('payResult','更新时间'),
			'create_time' => Yii::t('payResult','创建时间'),
			'times' => Yii::t('payResult','推送次数'),
			'order_type' => Yii::t('payResult','订单类型'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('pay_result',$this->pay_result,true);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('times',$this->times,true);
		$criteria->compare('order_type',$this->order_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                'defaultOrder'=>'times DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
