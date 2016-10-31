<?php

/**
 * This is the model class for table "{{app_pay_manage}}".
 *
 * The followings are the available columns in table '{{app_pay_manage}}':
 * @property string $id
 * @property integer $type
 * @property integer $status
 */
class AppPayManage extends CActiveRecord
{
	
	const APP_PAY_TYPE_JF = 1;
	const APP_PAY_TYPE_JFANDCASH = 2;
	const APP_PAY_TYPE_CASH = 3;

	
	const APP_PAY_TYPE_STATUS_YES = 1; //启用
	const APP_PAY_TYPE_STATUS_NO = 0;  //停用
	
	/**
	 * 分类
	 * @param null $key
	 * @return array
	 */
	public static function getAppPayType($key = null){
		$data = array(
				self::APP_PAY_TYPE_JF => Yii::t('AppPayManage','积分'),
				self::APP_PAY_TYPE_JFANDCASH => Yii::t('AppPayManage','积分+现金'),
				self::APP_PAY_TYPE_CASH => Yii::t('AppPayManage','现金'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	/**
	 * 状态
	 * @param null $key
	 * @return array
	 */
	public static function getAppPayTypeStatus($key = null,$type = true){
		$data = array(
				self::APP_PAY_TYPE_STATUS_YES => Yii::t('AppPayManage','是'),
				self::APP_PAY_TYPE_STATUS_NO => Yii::t('AppPayManage','否'),
		);
		return $key === null ? $data : $data[$key];
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_pay_manage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, status', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, status', 'safe', 'on'=>'search'),
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
			'type' => '支付类型 1积分 2积分+现金 3现金',
			'status' => '状态 0关闭 1开启',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppPayManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
