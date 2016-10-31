<?php

/**
 * This is the model class for table "{{payment}}".
 *
 * The followings are the available columns in table '{{payment}}':
 * @property string $id
 * @property integer $member_id
 * @property integer $cash_id
 * @property integer $batch_id
 * @property string $req_id
 * @property integer $third_type
 * @property string $amount
 * @property integer $lock_status
 * @property integer $status
 * @property string $create_time
 * @property string $audit_time
 */
class Payment extends CActiveRecord
{
	
	
	public $endTime;
	public $exportLimit = 10000; //导出excel的每页数
	public $isExport; // 是否导出excel
	
	const STATUS_WAIT=0; //待转
	const STATUS_SUCCESS=1; //成功
	const STATUS_FAIL=2; //失败
	
	const STATUS_LOCK_NO=0; //活动
	const STATUS_LOCK_YES=1; //锁定
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{payment}}';
	}

	
	/**
	 * 转账状态
	 * @param null $k
	 * @return array|null
	 */
	public static function getStatus($k = null)
	{
	    $arr = array(
	            self::STATUS_WAIT => Yii::t('paymentBatch', '待转'),
	            self::STATUS_SUCCESS => Yii::t('paymentBatch', '成功'),
	            self::STATUS_FAIL => Yii::t('paymentBatch', '失败'),
	    );
	    return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
	}
	
	/**
	 * 是否可体现(活动可提，锁定则不可以)
	 * @param null $k
	 * @return array|null
	 */
	public static function getLockStatus($k = null)
	{
	    $arr = array(
	            self::STATUS_LOCK_NO => Yii::t('paymentBatch', '活动'),
	            self::STATUS_LOCK_YES => Yii::t('paymentBatch', '已锁定'),
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
			array('member_id, cash_id, batch_id, req_id, amount, create_time', 'required'),
			array('member_id, cash_id, batch_id, third_type, lock_status, status', 'numerical', 'integerOnly'=>true),
			array('req_id', 'length', 'max'=>32),
			array('amount', 'length', 'max'=>19),
			array('create_time, audit_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, cash_id, batch_id, req_id, third_type, amount, lock_status, status, create_time, audit_time', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'member_id' => '用户GW号',
			'cash_id' => '体现id',
			'batch_id' => '批次id',
			'req_id' => '代收付流水号',
			'third_type' => ' 代付渠道，1是高汇通',
			'amount' => '代付金额',
			'account_name'=>'账户名',
			'bank_name'=>'银行名称',
			'account'=>'账号',
			'lock_status' => '锁定状态',
			'status' => '结果状态',
			'create_time' => '录入时间',
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
	 * 
	 *  
	 */
	
	public $account_name;
	public $bank_name;
	public $account;
	public $applyer;
	public $apply_time;
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cash_id',$this->cash_id);
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('req_id',$this->req_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('lock_status',$this->lock_status);
		$criteria->compare('status',$this->status);
		
		$dateTime = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('t.create_time', '>=' . $dateTime['start']);
        $criteria->compare('t.create_time', '<' . $dateTime['end']); 
        $criteria->select = 't.*,b.account_name,b.bank_name,b.account,m.gai_number as member_id';
        $criteria->join = 'left join {{member}} as m ON (t.member_id=m.id)';
        $criteria->compare('m.gai_number', $this->member_id);    
        $criteria->join .= 'left join {{bank_account}} as b ON (t.member_id=b.member_id)';
        //$criteria->join .= 'left join {{cash_history}} as ch ON (t.member_id=ch.member_id)';
		$pagination = array();
		if (!empty($this->isExport)) {
		    $pagination['pageVar'] = 'page';
		    $pagination['pageSize'] = $this->exportLimit;
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 得到所有的代付信息
	 * @param int $id 代付批次表
	 */
	public static function getBatchPayment($id=NULL){
		$command= Yii::app()->db->createCommand();
		$command->where('t.lock_status = :s AND t.status=:ts AND b.status = :bs',array(':s'=>Payment::STATUS_LOCK_NO,':ts'=>Payment::STATUS_WAIT,':bs'=>PaymentBatch::STATUS_PAYING));
		if($id!==NULL){
			$command->andWhere('t.batch_id = :bid', array(':bid' =>$id));
		}
		$res=$command->select('t.id,t.cash_id,t.req_id,t.member_id,t.amount,ch.money,bc.account_name,bc.bank_code,bc.account')
            ->from('{{payment}} t')
            ->leftJoin('{{payment_batch}} b', 't.batch_id=b.id')
            ->leftJoin('{{cash_history}} ch', 't.cash_id=ch.id')
            ->leftJoin('{{bank_account}} bc', 't.member_id=bc.member_id')
            ->queryAll();
		return $res;
     }  
      
  
  
}
