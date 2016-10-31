<?php

/**
 * This is the model class for table "{{franchisee_goods_order_detail}}".
 *
 * The followings are the available columns in table '{{franchisee_goods_order_detail}}':
 * @property string $id
 * @property string $name
 * @property string $seller_price
 * @property integer $discount
 * @property string $member_price
 * @property string $thumbnail
 * @property string $content
 * @property string $price
 * @property integer $status
 * @property string $franchisee_goods_order_id
 * @property integer $type
 * @property string $target_id
 * @property string $quantity
 *
 * The followings are the available model relations:
 * @property FranchiseeGoodsOrder $franchiseeGoodsOrder
 */
class FranchiseeGoodsOrderDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_goods_order_detail}}';
	}
	
	const STATUS_NOT_PAY = 0;						//未支付
	const STATUS_PAYED = 1;							//支付成功
	const STATUS_REFUND_PENDING = 2;		//申请退款
	const STATUS_REFUND_SUCCESS = 3;		//退款成功
	const STATUS_REFUND_FAILURE = 4;		//退款失败
	const STATUS_REFUND_DISPUTE = 5;		//维权中
	
	public static  function getStatus($key=null){
		$arr = array(
				self::STATUS_NOT_PAY=>Yii::t('franchiseeGoodsOrderDetail', '未支付'),
				self::STATUS_PAYED=>Yii::t('franchiseeGoodsOrderDetail', '支付成功'),
				self::STATUS_REFUND_PENDING=>Yii::t('franchiseeGoodsOrderDetail', '申请退款'),
				self::STATUS_REFUND_SUCCESS=>Yii::t('franchiseeGoodsOrderDetail', '退款成功'),
				self::STATUS_REFUND_FAILURE=>Yii::t('franchiseeGoodsOrderDetail', '退款失败'),
				self::STATUS_REFUND_DISPUTE=>Yii::t('franchiseeGoodsOrderDetail', '维权中'),
		);
		return $key===null?$arr:$arr[$key];
	}
	
	const TYPE_GOODS= 1;						//商品
	const TYPE_GROUPBUY= 2;						//团购
	
	public static  function getType($key=null){
		$arr = array(
				self::TYPE_GOODS=>Yii::t('franchiseeGoodsOrderDetail', '商品'),
				self::TYPE_GROUPBUY=>Yii::t('franchiseeGoodsOrderDetail', '团购'),
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
			array('name, seller_price, discount, member_price, thumbnail, content, price, status, franchisee_goods_order_id, type, target_id, quantity', 'required'),
			array('discount, status, type', 'numerical', 'integerOnly'=>true),
			array('name, thumbnail', 'length', 'max'=>128),
			array('seller_price, member_price, price', 'length', 'max'=>18),
			array('franchisee_goods_order_id, target_id, quantity', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, seller_price, discount, member_price, thumbnail, content, price, status, franchisee_goods_order_id, type, target_id, quantity', 'safe', 'on'=>'search'),
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
			'franchiseeGoodsOrder' => array(self::BELONGS_TO, 'FranchiseeGoodsOrder', 'franchisee_goods_order_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'name' => '商品名称',
			'seller_price' => '售价',
			'discount' => '折扣',
			'member_price' => '会员价',
			'thumbnail' => '商品主图片',
			'content' => '商品简介',
			'price' => '支付金额',
			'status' => '支付状态',
			'franchisee_goods_order_id' => '订单id',
			'type' => '明细类型',
			'target_id' => '关联id',
			'quantity' => '数量',
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
		$criteria->compare('seller_price',$this->seller_price,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('member_price',$this->member_price,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('franchisee_goods_order_id',$this->franchisee_goods_order_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('target_id',$this->target_id,true);
		$criteria->compare('quantity',$this->quantity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGoodsOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
