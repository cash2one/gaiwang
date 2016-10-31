<?php

/**
 * This is the model class for table "{{franchisee_consume_recon}}".
 *
 * The followings are the available columns in table '{{franchisee_consume_recon}}':
 * @property string $id
 * @property string $member_id
 * @property string $franchisee_id
 * @property string $start_time
 * @property string $end_time
 * @property string $total_amount
 * @property string $record_ids
 * @property string $create_time
 * @property integer $user_id
 * @property string $user_ip
 */
class FranchiseeConsumeRecon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_consume_recon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, franchisee_id, start_time, end_time, total_amount, record_ids, create_time, user_id, user_ip', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('member_id, franchisee_id, start_time, end_time, create_time, user_ip', 'length', 'max'=>11),
			array('total_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, franchisee_id, start_time, end_time, total_amount, record_ids, create_time, user_id, user_ip', 'safe', 'on'=>'search'),
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
			'member_id' => '会员id',
			'franchisee_id' => '加盟商id',
			'start_time' => '对账开始时间',
			'end_time' => '对账结束时间',
			'total_amount' => '金额',
			'record_ids' => 'gw_franchisee_consumption_record账单的记录id（61,78,139,148,152）',
			'create_time' => '创建时间',
			'user_id' => '管理员id',
			'user_ip' => '管理员ip',
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
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('record_ids',$this->record_ids,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_ip',$this->user_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeConsumeRecon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
