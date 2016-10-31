<?php

/**
 * This is the model class for table "gw_third_payment".
 *
 * The followings are the available columns in table 'gw_third_payment':
 * @property string $id
 * @property string $gw
 * @property string $reqMsgId
 * @property integer $third_type
 * @property string $bank_type
 * @property string $account_no
 * @property string $account_name
 * @property string $mobile
 * @property string $create_time
 */
class ThirdPayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
    public $endTime;
    public $startTime;
    public $exportLimit = 10000; //导出excel的每页数
    public $isExport; // 是否导出excel
    public $bankType;//银联号
    public $cardId;//身份证号
    
    const PAY_MONEY = 1; //代付
    const PAY_COLLECT = 2; //代收
    
	public function tableName()
	{
		return '{{third_payment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_code, account_no, mobile,cardId,payment_type,amout, account_name', 'required'),
			array('third_type', 'numerical', 'integerOnly'=>true),
			array('gw, req_id, mobile,bankType', 'length', 'max'=>32),
			array('bank_code, account_name', 'length', 'max'=>64),
			array('account_no', 'length', 'max'=>19),
			array('create_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('req_id,endTime,startTime,third_type,bankType,payment_type,amount, bank_code, account_no, account_name, mobile, create_time', 'safe', 'on'=>'search'),
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
			'gw' => '盖网编号',
			'req_id' => '代收流水号',
			'third_type' => '第三方类型，1是高汇通',
			'bank_code' => '银行类别',
			'account_no' => '开户账号',
			'account_name' => '开户姓名',
		    'amout' => '金额',
			'mobile' => '银行预留手机号',
			'create_time' => '代收时间',
		    'payment_type' => '代收类别',
		    'bankType'=>'银行联号',
		    'cardId'=>'身份证号'
		);
	}
	
	/**
	 * 代收付类别
	 * @param null }int $key
	 * @return array|null
	 */
	public static function getPaymentType($key = null) {
	    $arr = array(
	            self::PAY_MONEY => Yii::t('member', '代付'),
	            self::PAY_COLLECT => Yii::t('member', '代收'),
	    );
	    if (is_numeric($key)) {
	        return isset($arr[$key]) ? $arr[$key] : null;
	    } else {
	        return $arr;
	    }
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
		$searchDate = Tool::searchDateFormat($this->startTime, $this->endTime);
		$criteria->compare('t.create_time', ">=" . $searchDate['start']);
		$criteria->compare('t.create_time', "<" . $searchDate['end']);	
		$criteria->compare('req_id',$this->req_id,true);
		$criteria->compare('bank_code',$this->bank_code,true);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('account_name',$this->account_name,true);
		if($this->payment_type){
		$criteria->compare('payment_type',$this->payment_type,true);
		}
		// 导出excel
		$pagination = array();
		if (!empty($this->isExport)) {
		    $pagination['pageVar'] = 'page';
		    $pagination['pageSize'] = $this->exportLimit;
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'pagination' => $pagination,
		));
	}

	/**
	 * 银行列表
	 */
	public static function bankList($key=''){
	    $bankList=array(
	            '102'=>'中国工商银行',
	            '103'=>'中国农业银行',
	            '105'=>'中国建设银行',
	            '104'=>'中国银行',
	            '308' =>'招商银行',
	            '303' =>'中国光大银行',
	            '301'=>'交通银行',
	            '302'=> '中信银行',
	            '304' =>'华夏银行',
	            '305' =>'中国民生银行',
	            '306' =>'广东发展银行',
	            '307' =>'深圳发展银行',
	            '309' =>'兴业银行',
	            '310' =>'上海浦东发展',
	    );
	    if($key){
	        return $bankList[$key];
	    }else{
	      return $bankList;
	    }
	}
	
}
