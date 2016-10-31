<?php

/**
 * This is the model class for table "gw_member_login_log".
 *
 * The followings are the available columns in table 'gw_member_login_log':
 * @property string $member_id
 * @property string $login_time
 * @property string $ip
 */
class MemberLoginLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_login_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('member_id, login_time, ip', 'required'),
			array('member_id, login_time', 'length', 'max'=>11),
			array('ip', 'length', 'max'=>20),
			array('member_id, login_time, ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'member_id' => '会员主键',
			'login_time' => '登陆时间',
			'ip' => '会员IP',
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('login_time',$this->login_time,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
