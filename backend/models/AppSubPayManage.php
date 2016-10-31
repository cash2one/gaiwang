<?php

/**
 * This is the model class for table "{{app_sub_pay_manage}}".
 *
 * The followings are the available columns in table '{{app_sub_pay_manage}}':
 * @property string $id
 * @property string $name
 * @property integer $sort
 * @property integer $pay_manage_id
 * @property integer $type
 * @property integer $status
 */
class AppSubPayManage extends CActiveRecord
{
	
	public  $status; 
	public  $payType;//积分+现金  现金
	const APP_PAY_TYPE_UNION= 1;
	const APP_PAY_TYPE_WEIXIN = 2; 
	const APP_PAY_TYPE_GHT = 3;
	//const APP_PAY_TYPE_CASH = 3;
	
	
	const PAY_TYPE_STATUS_YES = 1; //启用
	const PAY_TYPE_STATUS_NO = 0;  //停用
	
	/**
	 * 分类
	 * @param null $key
	 * @return array
	 */
	public static function getAppPayType($key = null){
		$data = array(
				self::APP_PAY_TYPE_WEIXIN => Yii::t('AppSubPayManage','微信'),
				self::APP_PAY_TYPE_UNION => Yii::t('AppSubPayManage','银联'),
				self::APP_PAY_TYPE_GHT => Yii::t('AppSubPayManage','高汇通'),
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
				self::PAY_TYPE_STATUS_YES => Yii::t('AppSubPayManage','开启'),
				self::PAY_TYPE_STATUS_NO => Yii::t('AppSubPayManage','关闭'),
		);
		return $key === null ? $data : $data[$key];
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_sub_pay_manage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sort, type, status_cash,status_jfandcash', 'required'),
			array('sort, type, status_cash,status_jfandcash', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('prompt', 'length', 'max'=>6),
			array('img', 'length', 'max'=>225),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,prompt, sort, type,img, status_cash,status_jfandcash', 'safe', 'on'=>'search'),
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
			'name' => '支付名称',
			'sort' => '排序',
			'type' => '支付渠道',
			'status' => '状态',
			'payType'=>'支付类型',
			'prompt'=>'提示语',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('img',$this->img);
		$criteria->compare('prompt',$this->prompt);
		$criteria->compare('type',$this->type);
		$criteria->order = 'sort';
		//$criteria->compare('status_cash',$this->status_cash);
		//$criteria->compare('status_jfandcash',$this->status_jfandcash);
		//var_dump($criteria);die();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppSubPayManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
