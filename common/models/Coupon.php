<?php

/**
 * This is the model class for table "{{coupon}}".
 *
 * The followings are the available columns in table '{{coupon}}':
 * @property string $id
 * @property string $member_id
 * @property string $store_id
 * @property string $money
 * @property string $condition
 * @property string $surplus_money
 * @property string $valid_start
 * @property string $valid_end
 * @property integer $status
 * @property integer $mode
 * @property integer $type
 * @property string $create_time
 * @property string $use_time
 * @property integer $source
 * @property string $activity_id
 * @property string is_compensate
 * The followings are the available model relations:
 * @property Activity $activity
 */
class Coupon extends CActiveRecord
{

    //红包模式
    const COUPON_MODE_RED = 1; //红包模式
    const COUPON_MODE_COUPON = 2; //盖惠券模式

    //红包类型
    const RED_TYPE_REGISTER = 1; //注册
    const RED_TYPE_SHARE = 2; //分享

    //状态(0未使用、1已使用)
    const RED_IS_NOT_USE = 0;
    const RED_IS_USE = 1;

    //来源(1是盖网，2是盖通)
    const SOURCE_GAIWANG = 1;
    const SOURCE_GT = 2;

    //是否红包补偿
    const COMPENSATE_NO = 0;
    const COMPENSATE_YES = 1;

    //自定属性，红包补偿使用
    public $gai_number;
    public $mobile; //会员手机号
    public $sms_content; //发送短信内容
    public $choice_sms; //自定义发送内容
    public $valid_end_time;//红包过期时间
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coupon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, store_id, money, condition, surplus_money, valid_start, valid_end, status, mode, type, create_time, use_time, source, activity_id', 'required'),
			array('status, mode, type, source, is_compensate', 'numerical', 'integerOnly'=>true),
			array('member_id, store_id, condition, valid_start, valid_end, create_time, use_time, activity_id', 'length', 'max'=>11),
            array('sms_content','length','max'=>1000,'on'=>'compensation,batchCompensation'),
			array('money, surplus_money', 'length', 'max'=>15),
            array('gai_number','required','on'=>'compensation'),
            array('gai_number','match','pattern'=>'/^GW[0-9]{8}$/','on'=>'compensation,batchCompensation','message'=>'请输入正确的GW号！'),
            array('gai_number','checkGaiNumber','allowEmpty'=>true, 'on' => 'batchCompensation'),
            array('member_id,choice_sms', 'numerical', 'integerOnly'=>true, 'on'=>'compensation,batchCompensation'),
            array('gai_number, mobile','length','max'=>20,'on'=>'compensation,batchCompensation'),
            array('gai_number','checkGaiNumber','on'=>'compensation'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, store_id, money, condition, surplus_money, valid_start, valid_end, status, mode, type, create_time, use_time, source, activity_id, gai_number, mobile', 'safe', 'on'=>'search'),
		);
	}

    /**
     * 验证gw号或者手机号
     * @param $attribute
     * @param $params
     */
    public function checkGaiNumber($attribute,$params){
        if($this->$attribute) {
            $id = self::getGaiNumber($this->$attribute);
            if (!$id) {
                $this->addError($attribute, Yii::t('Coupon', 'GW号不存在'));
            }else{
                $this->member_id = $id;
            }
        }
    }

    /**
     * 红包补偿获取member_id
     * @param $str
     * @return array
     */
    public static function  getGaiNumber($str){
        $str = Yii::app()->getController()->magicQuotes($str);
        if(preg_match('/^GW[0-9]{8}$/',$str)){
            $id= Yii::app()->db->createCommand()->select('id')->from('{{member}}')
                ->where('(status=:status_no or status=:status_yes ) and gai_number=:gai_number',array(':status_no'=>Member::STATUS_NO_ACTIVE,':status_yes'=>Member::STATUS_NORMAL,':gai_number'=>$str))
                ->queryScalar();
            return $id ? $id : '';
        }else {
            return '';
        }
    }


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
            'member' => array(self::BELONGS_TO,'Member','member_id','select'=>'gai_number,mobile'), //红包补偿使用
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'member_id' => '所属会员',
			'store_id' => '所属店铺',
			'money' => '面值',
			'condition' => '使用条件',
			'surplus_money' => '剩余金额',
			'valid_start' => '有效时间（开始）',
			'valid_end' => '有效时间（结束）',
			'status' => '状态',
			'mode' => '模式（1积分红包、2盖惠券）',
			'type' => '类型',
			'create_time' => '领取时间',
			'use_time' => '使用时间',
			'source' => '来源（1商城、2盖网通）',
			'activity_id' => '所属活动',
            'is_compensate' => '是否是补偿的红包',
            'gai_number' => 'GW号',
            'mobile' => '手机号',
            'sms_content' => '短信内容',
            'valid_end_time'=>'红包过期时间',
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
        $criteria->with ='member';
        $criteria->compare('member.gai_number',$this->gai_number);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('money',$this->money);
		$criteria->compare('condition',$this->condition);
		$criteria->compare('valid_start',$this->valid_start);
		$criteria->compare('valid_end',$this->valid_end);
		$criteria->compare('status',$this->status);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('use_time',$this->use_time);
		$criteria->compare('is_compensate',$this->is_compensate);
		$criteria->compare('activity_id',$this->activity_id);

        $criteria->select = 't.*,m.valid_end AS valid_end_time';
        $criteria->join='LEFT JOIN {{member_account}} m ON t.member_id =m.member_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 红包补偿搜索
     * @return CActiveDataProvider
     */
    public function compensationSearch(){
        $criteria=new CDbCriteria;
        $criteria->with ='member';
        $criteria->compare('member.gai_number',$this->gai_number);
        $criteria->compare('member.mobile',$this->mobile);
        $criteria->compare('mode',self::COUPON_MODE_RED);
        $criteria->compare('type',$this->type);
        $criteria->compare('is_compensate',self::COMPENSATE_YES);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


    /**
     * 会员中心,红包列表清单
     * @param $memberId
     * @author binbin.liao
     * @return CActiveDataProvider the data provider that can return the models
     */
    public function searchList($memberId){
        $criteria=new CDbCriteria;
        $criteria->select='money,id,member_id,`type`,create_time';

        $criteria->compare('member_id',$memberId);
        $criteria->compare('mode',Activity::ACTIVITY_MODE_RED);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coupon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * 获取已经领取的红包总额
     */
    public static function getSentTotalMoney()
    {
        $sentTotalAmount = Yii::app()->db->createCommand()
            ->select('sum(money)')
            ->from('{{coupon}}')
            ->where('mode=:mode',array(':mode'=>self::COUPON_MODE_RED))
            ->queryScalar();
        return $sentTotalAmount ? $sentTotalAmount : 0;
    }

    /**
     * 获取红包送出量
     * @return int|mixed
     */
    public static function getCountCoupon($type=null){
        $command = Yii::app()->db->createCommand()
            ->select('sum(sendout) as send')
            ->from('{{activity}}')
            ->where('mode=:mode',array(':mode'=>Activity::ACTIVITY_MODE_RED));
        if($type){
            $command = $command->andWhere('type=:type',array(':type'=>$type));
        }
        $send = $command ->queryScalar();
        return $send;
    }

}
