<?php

/**
 * This is the model class for table "gw_pay_agreement".
 *
 * The followings are the available columns in table 'gw_pay_agreement':
 * @property string $id
 * @property string $gw
 * @property integer $pay_type
 * @property string $card_type
 * @property string $bank
 * @property integer $bank_num
 * @property string $mobile
 * @property string $pay_agreement_id
 * @property string $busi_agreement_id
 * @property string $create_time
 */
class PayAgreement extends CActiveRecord
{

    public $messageId;//短信验证码
    public $messageCode; //高汇通短信流水号


    /**
     * 支付平台
     */
    const PAY_TYPE_UM = 1;
    const PAY_TYPE_GHT =2;
    const STATUS_TRUE = 1;
    const STATUS_FALSE = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pay_agreement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('gw, card_type, bank, bank_num, mobile, pay_agreement_id, busi_agreement_id,create_time,id_card,cardname,cvn,able_time','required'),
                        array('bank_num,mobile,certificateNo,accountName,mobile,messageId','required','on'=>'bindCard'), //绑卡
                        array('certificateType','safe','on'=>'bindCard'),
                        array('bank_num','length','max'=>19,'min'=>16,'on'=>'bindCard'),
                        array('accountName','length','max'=>10,'on'=>'bindCard'),
                        array('certificateNo','length','max'=>18,'min'=>18,'on'=>'bindCard'),
                        array('bank_num,cvn2,valid,mobile,messageId','required','on'=>'bindcredit'),
                        array('mobile','comext.validators.isMobile','on'=>'bindcredit,bindCard','errMsg'=>  Yii::t('payagreement','请输出正确的手机号码')),
                        array('valie','length','max'=>4,'on'=>'bindcredit'),
                        array('cvn2','length','max'=>3,'min'=>3,'message'=>  Yii::t('payAgreement','CVN2码是三位数字'),'on'=>'bindcredit'),
//                        array('messageId,mssageCode','safe','on'=>'bindCard'),
			array('pay_type, bank_num', 'numerical', 'integerOnly'=>true),
//			array('gw, mobile', 'length', 'max'=>32),
			array('card_type', 'length', 'max'=>16),
			array('bank', 'length', 'max'=>10),
			array('pay_agreement_id, busi_agreement_id', 'length', 'max'=>64),
			array('create_time,mobile', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gw, pay_type, card_type, bank, bank_num, mobile, pay_agreement_id, busi_agreement_id, create_time', 'safe', 'on'=>'search'),
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
                    'pay_type' => '支付类型（1联动优势）',
                    'card_type' => '卡片类型(CREDITCARD(信用卡)DEBITCARD(借记卡))',
                    'bank' => '银行类型（大写字母）',
                    'bank_num' => '银行卡号',
                    'mobile' => '银行预留手机号',
                    'pay_agreement_id' => '支付协议号',
                    'busi_agreement_id' => '用户业务协议号',
                    'create_time' => '绑定时间',
                    'accountName' => '持卡人姓名',
                    'certificateNo' => '身份证号码',
                    'cvn2' => 'CVN2码',
                    'valid' => '有效期',
                    'messageId'=>'验证码'
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
		$criteria->compare('gw',$this->gw,true);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('bank_num',$this->bank_num);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('pay_agreement_id',$this->pay_agreement_id,true);
		$criteria->compare('busi_agreement_id',$this->busi_agreement_id,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * 获取用户绑定的卡列表
     * @param $gw
     * @param int $payType
     * @return CActiveRecord[]
     */
    public static function getCardList($gw,$payType=self::PAY_TYPE_UM){
        return self::model()->findAllByAttributes(array('gw'=>$gw,'pay_type'=>$payType,'status'=> self::STATUS_TRUE),array('order'=>'card_type DESC'));
    }
    
    /**
     * 查看是否存在卡 
     * @param number $cardNum
     * @return mixed false|$model
     */
    public static function hasCard($cardNum,$payType=self::PAY_TYPE_GHT){
        return self::model()->findByAttributes(array('bank_num'=>$cardNum,'pay_type'=>$payType));
    }
    
    /**
     * 获取卡片类型
     * @param null $name
     * @return array|string
     */
    public static function getCardType($name=null)
    {
        $arr = array(
            'DEBITCARD'=>'储蓄卡',
            'CREDITCARD'=>'信用卡',
        );
        if(empty($name)) return $arr;
        return isset($arr[$name]) ? $arr[$name] :'未知';
    }
}
