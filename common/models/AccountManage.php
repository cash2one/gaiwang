<?php

/**
 * This is the model class for table "account_manage".
 *
 * The followings are the available columns in table 'account_manage':
 * @property string $id
 * @property string $gai_number
 * @property string $money
 * @property string $create_time
 * @property integer $type
 */
class AccountManage extends CActiveRecord
{
    const  ACCOUNT_MANAGE_RED = 1; //红包类型

	public function tableName()
	{
		return '{{account_manage}}';
	}


	public static  function getTableName()
	{
	    return '{{account_manage}}';
	}
	
	public function rules()
	{
		return array(
			array('gai_number, money, create_time, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
            array('type','unique'),
			array('gai_number', 'length', 'max'=>128),
			array('money', 'length', 'max'=>15),
            array('money', 'numerical'),
			array('create_time', 'length', 'max'=>11),
			array('id, gai_number, money, create_time, type', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'gai_number' => 'GW号',
			'money' => '金额',
			'create_time' => '创建时间',
			'type' => 'Type',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('gai_number',$this->gai_number,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * 红包积分总额增加
     * @param $money
     * @param $userName
     * @param $real_name
     * @return bool
     * @throws CDbException
     * @throws Exception
     */
    public function addHongBaoAmount($money, $userName, $real_name)
    {
        try {
            $flowTableName = AccountFlowHistory::monthTable(); //流水日志表名
            //获取红包账户余额信息

            $balanceRed = CommonAccount::getHongbaoAccount();
            if (!$balanceRed) {
                throw new ErrorException('公共账户创建错误');
                return false;
            }
            //增加金额记录
            $nowTotalMoney = CommonAccountLog::getTotalMoney();

            $accountLogModel= new CommonAccountLog();
            $accountLogModel->total_money = $nowTotalMoney + $money;
            $accountLogModel->username = trim($userName);
            $accountLogModel->real_name = trim($real_name);
            $accountLogModel->money = floatval($money);
            $accountLogModel->create_time = time();
            $accountLogModel->common_account_id = $balanceRed['account_id'];

            /**
             * 红包申请金额流水
             */

            //更新红包账户余额
            if(!(AccountBalance::calculate(array('today_amount' => $money), $balanceRed['id'])))
                throw new Exception(Yii::t("CommonAccountLog", '更新红包账户失败'));
            $accountLogModel->save(false);
            if(!($accountLogModel->id))
                throw new Exception(Yii::t("CommonAccountLog", '写入增加金额日志失败'));

            $order = array(
                'id' => $accountLogModel->id,
                'code' => 'HBSQ'. date('YmdHis',time()),
            );
            $accountFlowData = AccountFlow::mergeFlowData($order,$balanceRed,array(
                'credit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_HONGBAO_APPLY,
                'remark' => '红包金额申请',
                'node' => AccountFlow::BUSINESS_NODE_HONGBAO_APPLY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_HONGBAO_APPLY,
            ));

            if(!(Yii::app()->db->createCommand()->insert($flowTableName, $accountFlowData))){
                throw new Exception(Yii::t("CommonAccountLog", '写入红包金额流水失败'));
            }
            return true;
        } catch (Exception $e) {
            throw new Exception(Yii::t("CommonAccountLog", $e->getMessage()));
            return false;
        }
    }

    /**
     * 从池减金额
     * @param $money
     * @param $gai_number 红包账户
     * @return bool
     * @throws Exception
     */
    public  static function  subtractHongBaoMoney($money,$gai_number){
        $rs = self::model()->updateCounters(array('money'=>'-'.$money),'type=:type and gai_number=:gai_number',array(':type'=>self::ACCOUNT_MANAGE_RED,':gai_number'=>$gai_number));
        if(!$rs){
            throw new Exception(Yii::t("CommonAccountLog", '从帐户金额管理 减 金额失败'));
            return false;
        }
        return true;
    }

    /**
     * 检查 帐户金额管 是否有足够金额 生成红包
     * @param $money
     * @param $gai_number 红包账户gai_number
     * @return bool
     * @throws Exception
     */
    public static function  checkHasMoney($money,$gai_number){
        $totalMoney = Yii::app()->db->createCommand()
            ->select('money')
            ->from(self::getTableName())
            ->where('type=:type and gai_number=:gai_number',array(':type'=>self::ACCOUNT_MANAGE_RED,':gai_number'=>$gai_number))
            ->queryScalar();
        if($money > $totalMoney){
            return false;
        }
        return true;
    }

    /**
     * 获取红包账户剩余金额
     * @return int|mixed
     */
    public  static  function  getSurplusMoney(){
        $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
        $money = Yii::app()->db->createCommand()
            ->select('money')
            ->from(self::getTableName())
            ->where('type=:type and gai_number=:gai_number',array(':type'=>self::ACCOUNT_MANAGE_RED,':gai_number'=>$balanceRed['gai_number']))
            ->queryScalar();
        return $money?$money:0;
    }

}
