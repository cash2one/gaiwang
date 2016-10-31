<?php

/**
 * This is the model class for table "{{payment_batch}}".
 *
 * The followings are the available columns in table '{{payment_batch}}':
 * @property string $id
 * @property string $batch_number
 * @property string $remark
 * @property string $author_ip
 * @property string $author_id
 * @property string $auditor_ip
 * @property string $auditor_id
 * @property integer $status
 * @property string $create_time
 * @property string $audit_time
 */
class PaymentBatch extends CActiveRecord
{
	
	public $endTime;
	
	//0待审核，1审核通过，2审核不通过，3转账完成，4转账失败
	
	const STATUS_BEFORE = 0; // 待审核
	const STATUS_PASS = 1; // 审核通过
	const STATUS_NOPASS = 2; // 审核不通过
	const STATUS_PAYING=3;  //转账中
	const STATUS_SUCCESS = 4; // 执行完成
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{payment_batch}}';
	}

	/**
	 * 活动状态
	 * @param null $k
	 * @return array|null
	 */
	public static function getStatus($k = null)
	{
	    $arr = array(
	            self::STATUS_BEFORE => Yii::t('paymentBatch', '待审核'),
	            self::STATUS_PASS => Yii::t('paymentBatch', '审核通过'),
	    		self::STATUS_NOPASS => Yii::t('paymentBatch', '审核不通过'),
	    		self::STATUS_PAYING => Yii::t('paymentBatch', '转账中'),
	    		self::STATUS_SUCCESS => Yii::t('paymentBatch', '执行完成'),
	    );
	    return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
	}
	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('batch_number, remark, author_ip, author_id, auditor_ip, auditor_id, create_time, audit_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('batch_number, author_ip, author_id, auditor_ip, auditor_id, create_time, audit_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, batch_number, remark, author_ip, author_id, auditor_ip, auditor_id, status, create_time, audit_time', 'safe', 'on'=>'search'),
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
			'id' => '主键',
			'batch_number' => '批次号',
			'remark' => '备注',
			'author_ip' => '创建者IP',
			'author_id' => '创建者ID',
			'auditor_ip' => '审核者IP',
			'auditor_id' => '审核者ID',
			'status' => '状态',
			'create_time' => '创建时间',
			'audit_time' => '审核时间',
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
		$criteria->compare('batch_number',$this->batch_number,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('author_ip',$this->author_ip,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('auditor_ip',$this->auditor_ip,true);
		$criteria->compare('auditor_id',$this->auditor_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('audit_time',$this->audit_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwPaymentBatch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
