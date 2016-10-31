<?php

/**
 *  会员与角色对应表 模型
 *  @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{member_to_role}}':
 * @property string $id
 * @property string $member_id
 * @property string $member_role_id
 * @property string $service_start_time
 * @property string $service_end_time
 */
class MemberToRole extends CActiveRecord
{
	public function tableName()
	{
		return '{{member_to_role}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('member_id, member_role_id, service_start_time, service_end_time', 'required'),
			array('member_id, member_role_id, service_start_time, service_end_time', 'length', 'max'=>11),
			array('id, member_id, member_role_id, service_start_time, service_end_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'MemberRole'=>array(self::BELONGS_TO,'MemberRole','member_role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('memberToRole','主键'),
			'member_id' => Yii::t('memberToRole','所属会员'),
			'member_role_id' => Yii::t('memberToRole','所属角色'),
			'service_start_time' => Yii::t('memberToRole','服务开始时间'),
			'service_end_time' => Yii::t('memberToRole','服务结束时间'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('member_role_id',$this->member_role_id,true);
		$criteria->compare('service_start_time',$this->service_start_time,true);
		$criteria->compare('service_end_time',$this->service_end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
