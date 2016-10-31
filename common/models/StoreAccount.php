<?php

/**
 * This is the model class for table "{{store_account}}".
 *
 * The followings are the available columns in table '{{store_account}}':
 * @property string $id
 * @property string $money
 * @property string $surplus_money
 * @property integer $ratio
 * @property string $store_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Store $store
 */
class StoreAccount extends CActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{store_account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('money, surplus_money, ratio, store_id, status', 'required'),
			array('ratio, status', 'numerical', 'integerOnly'=>true),
			array('money, surplus_money', 'length', 'max'=>10),
			array('store_id', 'length', 'max'=>11),
			array('id, money, surplus_money, ratio, store_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'money' => '总授信金额',
			'surplus_money' => '剩余授信金额',
			'ratio' => '盖网支持比例',
			'store_id' => 'Store',
			'status' => 'Status',
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
		$criteria->compare('money',$this->money,true);
		$criteria->compare('surplus_money',$this->surplus_money,true);
		$criteria->compare('ratio',$this->ratio);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StoreAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    //获取盖惠券活动状态
    public static function getStatus($key = null){
        $arr = array(
            '' => Yii::t('Public', '全部'),
            self::STATUS_ON => Yii::t('sellerCouponActivity', '盖惠券还在领取'),
            self::STATUS_OFF => Yii::t('sellerCouponActivity', '没有盖惠券'),
        );
        return $key == null ? $arr : $arr[$key];
    }
}
