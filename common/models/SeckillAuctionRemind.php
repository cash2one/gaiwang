<?php

/**
 * This is the model class for table "{{seckill_auction_remind}}".
 *
 * The followings are the available columns in table '{{seckill_auction_remind}}':
 * @property integer $id
 * @property integer $rules_setting_id
 * @property integer $goods_id
 * @property integer $member_id
 * @property string $send_mobile
 * @property integer $mobile_is_send
 * @property integer $mobile_template
 * @property integer $send_message
 * @property integer $message_is_send
 * @property string $dateline
 * @property integer $all_is_send
 */
class SeckillAuctionRemind extends CActiveRecord
{
	
	const MSG_SEND_NO = 0;//不发送站内信
    const MSG_SEND_YES = 1;//发送站内信
	public $mobile;
	public $mobileVerifyCode;
	public $new_mobile;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seckill_auction_remind}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, rules_setting_id, goods_id, member_id, mobile_is_send, mobile_template, send_message, message_is_send, all_is_send', 'numerical', 'integerOnly'=>true),
			array('send_mobile', 'length', 'max'=>50),
			array('dateline', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rules_setting_id, goods_id, member_id, send_mobile, mobile_is_send, mobile_template, send_message, message_is_send, dateline, all_is_send', 'safe', 'on'=>'search'),
			 //验证手机号码
            array('new_mobile,mobileVerifyCode', 'required'),
            array('mobileVerifyCode', 'comext.validators.mobileVerifyCode', 'on'=>'remainAdd'),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码')),
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
			'id' => '主键自增',
			'rules_setting_id' => '活动规则表id',
			'goods_id' => '商品id',
			'member_id' => '会员id',
			'send_mobile' => '接收短信手机号(如果没设置则留空)',
			'mobile_is_send' => '手机短信是否已发送 0未发送 1已发送',
			'mobile_template' => '手机短信模板',
			'send_message' => '设置发送站内短信 0不发送 1发送',
			'message_is_send' => '站内短信是否已发送 0未发送 1已发送',
			'dateline' => '创建时间',
			'all_is_send' => '手机短信和站内短信都已发送',
		);
	}

	/**
     * 获取站内信发送提醒
     * @return array 返回状态数组
     */
    public static function getRemindStatus($key = null)
    {
        $arr = array(
            self::MSG_SEND_NO => '关闭',
            self::MSG_SEND_YES => '开启',
        );
        return $key !== null ? (isset($arr[$key]) ? $arr[$key] : '未知状态') : $arr;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('rules_setting_id',$this->rules_setting_id);
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('send_mobile',$this->send_mobile,true);
		$criteria->compare('mobile_is_send',$this->mobile_is_send);
		$criteria->compare('mobile_template',$this->mobile_template);
		$criteria->compare('send_message',$this->send_message);
		$criteria->compare('message_is_send',$this->message_is_send);
		$criteria->compare('dateline',$this->dateline,true);
		$criteria->compare('all_is_send',$this->all_is_send);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeckillAuctionRemind the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
