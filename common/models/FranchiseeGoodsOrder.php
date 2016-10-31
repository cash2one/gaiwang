<?php

/**
 * This is the model class for table "{{franchisee_goods_order}}".
 *
 * The followings are the available columns in table '{{franchisee_goods_order}}':
 * @property string $id
 * @property string $code
 * @property string $mobile
 * @property integer $open_type
 * @property string $book_time
 * @property string $open_time
 * @property integer $pay_type
 * @property string $pay_time
 * @property string $seller_price
 * @property string $pay_price
 * @property integer $status
 * @property string $member_id
 * @property string $franchisee_id
 * @property string $franchisee_table_id
 * @property string $award
 * @property integer $is_comment
 * @property string $distribution_ratio
 * @property string $franchisee_staff_id
 * @property string $franchisee_statement_staff_id
 * @property string $parent_code
 *
 * The followings are the available model relations:
 * @property FranchiseeGoodsComment[] $franchiseeGoodsComments
 * @property Franchisee $franchisee
 * @property FranchiseeStaff $franchiseeStaff
 * @property FranchiseeTable $franchiseeTable
 * @property Member $member
 * @property FranchiseeGoodsOrderDetail[] $franchiseeGoodsOrderDetails
 * @property FranchiseeGoodsOrderToCallInfo[] $franchiseeGoodsOrderToCallInfos
 */
class FranchiseeGoodsOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_goods_order}}';
	}


	const OPEN_TYPE_NOW = 1;			//开单方式
	const OPEN_TYPE_BOOK = 2;
	
	public static  function getOpentype($key=null){
		$arr = array(
				self::OPEN_TYPE_NOW=>Yii::t('franchiseeGoodsOrder', '现开'),
				self::OPEN_TYPE_BOOK=>Yii::t('franchiseeGoodsOrder', '预定'),
		);
	
		return $key===null?$arr:$arr[$key];
	}
	
	const PAY_TYPE_MEMBER = 1;		//支付方式
	const PAY_TYPE_NOT_MEMBER = 2;
	
	public static  function getPaytype($key=null){
		$arr = array(
				self::PAY_TYPE_MEMBER=>Yii::t('franchiseeGoodsOrder', '会员支付'),
				self::PAY_TYPE_NOT_MEMBER=>Yii::t('franchiseeGoodsOrder', '非会员支付(现金)'),
		);
	
		return $key===null?$arr:$arr[$key];
	}
	
	const STATUS_BOOK = 0;			//状态
	const STATUS_TABLE_OPENED= 1;			//状态
	const STATUS_PAYED= 2;			//状态
	
	public static  function getStatus($key=null){
		$arr = array(
				self::STATUS_BOOK=>Yii::t('franchiseeGoodsOrder', '预定'),
				self::STATUS_TABLE_OPENED=>Yii::t('franchiseeGoodsOrder', '已开台'),
				self::STATUS_PAYED=>Yii::t('franchiseeGoodsOrder', '已支付'),
		);
	
		return $key===null?$arr:$arr[$key];
	}
	
	const COMMENT_HASNT = 0;			//未评价
	const COMMENT_HAS = 1;			//已评价
	
	public static  function getHasComment($key=null){
		$arr = array(
				self::COMMENT_HASNT=>Yii::t('franchiseeGoodsOrder', '未评价'),
				self::COMMENT_HAS=>Yii::t('franchiseeGoodsOrder', '已评价'),
		);
	
		return $key===null?$arr:$arr[$key];
	}
	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, mobile, book_time, open_time, pay_type, pay_time, seller_price, pay_price, status, member_id, franchisee_id, franchisee_table_id, award, is_comment, distribution_ratio, franchisee_staff_id, franchisee_statement_staff_id, parent_code', 'required'),
			array('open_type, pay_type, status, is_comment', 'numerical', 'integerOnly'=>true),
			array('code, parent_code', 'length', 'max'=>45),
			array('mobile', 'length', 'max'=>20),
			array('book_time, open_time, pay_time, member_id, franchisee_id, franchisee_staff_id, franchisee_statement_staff_id', 'length', 'max'=>11),
			array('seller_price, pay_price, award', 'length', 'max'=>18),
			array('franchisee_table_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, mobile, open_type, book_time, open_time, pay_type, pay_time, seller_price, pay_price, status, member_id, franchisee_id, franchisee_table_id, award, is_comment, distribution_ratio, franchisee_staff_id, franchisee_statement_staff_id, parent_code', 'safe', 'on'=>'search'),
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
			'franchiseeGoodsComments' => array(self::HAS_MANY, 'FranchiseeGoodsComment', 'franchisee_goods_order_id'),
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
			'franchiseeStaff' => array(self::BELONGS_TO, 'FranchiseeStaff', 'franchisee_staff_id'),
			'franchiseeTable' => array(self::BELONGS_TO, 'FranchiseeTable', 'franchisee_table_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'franchiseeGoodsOrderDetails' => array(self::HAS_MANY, 'FranchiseeGoodsOrderDetail', 'franchisee_goods_order_id'),
			'franchiseeGoodsOrderToCallInfos' => array(self::HAS_MANY, 'FranchiseeGoodsOrderToCallInfo', 'franchisee_goods_order_id'),
		);
	}


	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'code' => '商品订单编号',
			'mobile' => '购买人的手机号码',
			'open_type' => '开单方式（1现开、2预定）',
			'book_time' => '预定时间',
			'open_time' => '开台时间',
			'pay_type' => '支付方式（1、会员支付    2、非会员支付--直接给现金）',
			'pay_time' => '支付时间',
			'seller_price' => '销售总价',
			'pay_price' => '支付总价',
			'status' => '状态（0预定 1已开台 2已支付）',
			'member_id' => '购买者的会员id',
			'franchisee_id' => '加盟商id',
			'franchisee_table_id' => '台号id',
			'award' => '会员的奖励',
			'is_comment' => '是否评价（0未评价、1已评价）',
			'distribution_ratio' => '订单生成的时候保存分配比率',
			'franchisee_staff_id' => '开单人所属店员id',
			'franchisee_statement_staff_id' => '结单人',
			'parent_code' => '网银流水号',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('open_type',$this->open_type);
		$criteria->compare('book_time',$this->book_time,true);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('pay_time',$this->pay_time,true);
		$criteria->compare('seller_price',$this->seller_price,true);
		$criteria->compare('pay_price',$this->pay_price,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('franchisee_table_id',$this->franchisee_table_id,true);
		$criteria->compare('award',$this->award,true);
		$criteria->compare('is_comment',$this->is_comment);
		$criteria->compare('distribution_ratio',$this->distribution_ratio,true);
		$criteria->compare('franchisee_staff_id',$this->franchisee_staff_id,true);
		$criteria->compare('franchisee_statement_staff_id',$this->franchisee_statement_staff_id,true);
		$criteria->compare('parent_code',$this->parent_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	/**
	 * 根据订单编码获取订单详细信息
	 * @param unknown $code
	 */
	public static function getDetails($code){
		$criteria=new CDbCriteria;
		$criteria->with = array(
				'member'=>array(
					'select'=>'gai_number,username',
				),
				'franchiseeGoodsOrderDetails'
		);
		$criteria->compare('code', $code);
		return self::model()->find($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGoodsOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
