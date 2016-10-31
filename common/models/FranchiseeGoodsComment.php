<?php

/**
 * This is the model class for table "{{franchisee_goods_comment}}".
 *
 * The followings are the available columns in table '{{franchisee_goods_comment}}':
 * @property string $id
 * @property string $content
 * @property string $score
 * @property string $service_score
 * @property string $quality_score
 * @property string $create_time
 * @property string $member_id
 * @property string $franchisee_id
 * @property string $franchisee_goods_id
 * @property string $franchisee_goods_order_id
 *
 * The followings are the available model relations:
 * @property Franchisee $franchisee
 * @property FranchiseeGoods $franchiseeGoods
 * @property FranchiseeGoodsOrder $franchiseeGoodsOrder
 * @property Member $member
 */
class FranchiseeGoodsComment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_goods_comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, score, service_score, quality_score, create_time, member_id, franchisee_id, franchisee_goods_id, franchisee_goods_order_id', 'required'),
			array('score, service_score, quality_score', 'length', 'max'=>2),
			array('create_time, member_id, franchisee_id, franchisee_goods_id, franchisee_goods_order_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, content, score, service_score, quality_score, create_time, member_id, franchisee_id, franchisee_goods_id, franchisee_goods_order_id', 'safe', 'on'=>'search'),
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
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
			'franchiseeGoods' => array(self::BELONGS_TO, 'FranchiseeGoods', 'franchisee_goods_id'),
			'franchiseeGoodsOrder' => array(self::BELONGS_TO, 'FranchiseeGoodsOrder', 'franchisee_goods_order_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => '评价内容',
			'score' => '综合评分',
			'service_score' => '商家服务评分',
			'quality_score' => '商品质量评分',
			'create_time' => '评论时间',
			'member_id' => '会员id',
			'franchisee_id' => '加盟商id',
			'franchisee_goods_id' => '线下商品id',
			'franchisee_goods_order_id' => '线下订单id',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('service_score',$this->service_score,true);
		$criteria->compare('quality_score',$this->quality_score,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('franchisee_goods_id',$this->franchisee_goods_id,true);
		$criteria->compare('franchisee_goods_order_id',$this->franchisee_goods_order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGoodsComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
