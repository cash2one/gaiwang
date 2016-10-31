<?php

/**
 * This is the model class for table "{{common_account_log}}".
 *
 * The followings are the available columns in table '{{common_account_log}}':
 * @property string $id
 * @property string $money
 * @property string $total_money
 * @property string $real_name
 * @property string $username
 * @property string $create_time
 * @property string $common_account_id
 *
 * The followings are the available model relations:
 * @property CommonAccount $commonAccount
 */
class CommonAccountLog extends CActiveRecord
{

    public $beginCreateTime;
    public $toCreateTime;

	public function tableName()
	{
		return '{{common_account_log}}';
	}

	public function rules()
	{
		return array(
			array('money, total_money, real_name, username, create_time, common_account_id', 'required'),
			array('money, total_money', 'length', 'max'=>10),
			array('real_name, username', 'length', 'max'=>128),
			array('create_time, common_account_id', 'length', 'max'=>11),
			array('id, money, total_money, real_name, username, create_time,beginCreateTime,toCreateTime', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'commonAccount' => array(self::BELONGS_TO, 'CommonAccount', 'common_account_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'money' => '冲入金额',
			'total_money' => '总金额',
			'real_name' => '操作人',
			'username' => '操作人姓名',
			'create_time' => '创建时间',
			'common_account_id' => '所属公共帐户',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('money',$this->money);
		$criteria->compare('total_money',$this->total_money);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('username',$this->username,true);
        // 创建时间
        $searchDate = Tool::searchDateFormat($this->beginCreateTime, $this->toCreateTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<=" . $searchDate['end']);
		$criteria->compare('common_account_id',$this->common_account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 获取cashlog最后价格 (总共投资了多少钱)
     * @return number
     */
    public static function getTotalMoney()
    {
        $TotalAmount = Yii::app()->db->createCommand()
            ->select('total_money')
            ->from('{{common_account_log}}')
            ->order('id desc')
            ->limit('1')
            ->queryScalar();
        return $TotalAmount?$TotalAmount:0;
    }

}
