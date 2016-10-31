<?php

/**
 * This is the model class for table "{{redis_activity}}".
 *
 * The followings are the available columns in table '{{redis_activity}}':
 * @property string $member_id
 * @property string $activity_id
 * @property string $money
 * * @property string $source
 * @property string $uid
 */
class RedisActivity extends CActiveRecord
{
	const SOURCE_TYPE_ONLINE=1;//线上
	const SOURCE_TYPE_OFFLINE =2;//线下
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{redis_activity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, activity_id, money, source, uid', 'required'),
			array('member_id, activity_id,source', 'length', 'max'=>11),
			array('money', 'length', 'max'=>10),
			array('uid', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, activity_id, money, source, uid', 'safe', 'on'=>'search'),
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
			'member_id' => '会员ID',
			'activity_id' => '活动ID',
			'money' => '金额',
            'source' => '来源',
			'uid' => '唯一标示',
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

		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('money',$this->money);
        $criteria->compare('source',$this->source);
		$criteria->compare('uid',$this->uid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RedisActivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
