<?php
/**
 * 会员模型
 */
class ApiMember extends ApiModel{

    public $tableName = '{{member}}';
    public $primaryKey = 'id';
    
    /**
     * 用户密码验证
     * @param string $inputPassword
     * @param array $member
     * @return bool
     */
    public static function verifyPwd($inputPassword,$member){
        return CPasswordHelper::verifyPassword($inputPassword . $member['salt'], $member['password']);
    }
    /**
     * 利用盖网编号获取用户信息
     * @param string $gaiNumber
     * @return array
     */
    public static function getMemberByGainumber($gaiNumber){
        return Yii::app()->db->createCommand()->from('{{member}}')
                    ->where('gai_number=:params and status<=:status', array(
                            ':params' => $gaiNumber,':status'=>Member::STATUS_NORMAL))->queryRow();
    }

    /**
     * 获取会员线下消费账户
     * @param string $gaiNumber(父编号)
     * @return array
     */
    public static function getMemberGW4($gaiNumber){
    	$member = Yii::app()->db->createCommand()->from('{{member}}')
                    ->where('pgw=:params and role=:role and status<=:status', array(
                            ':params' => $gaiNumber,':role'=>Member::ROLE_OFFLINE_CONSUMER,':status'=>Member::STATUS_NORMAL))->queryRow();
                    
		if(empty($member)){		//如果该账户不存在则创建
			$newGaiNumber = str_replace('GW', 'GW04', $gaiNumber);
			$sql = "INSERT INTO {{member}} (gai_number,referrals_id,type_id,grade_id,is_enterprise,member_type,pid,pgw,role)
			SELECT '".$newGaiNumber."',referrals_id,type_id,grade_id,0,member_type,id,gai_number,".Member::ROLE_OFFLINE_CONSUMER."
			FROM {{member}} WHERE gai_number = '".$gaiNumber."'";
			Yii::app()->db->createCommand($sql)->execute();
			
			$member = self::getMemberByGainumber($newGaiNumber);
		}
		
		return $member;
    }
    
    /**
     * 通过手机获取账号
     * @param int $userPhone
     * @return array
     */
    public static function getMultipleMember($userPhone){
        return Yii::app()->db->createCommand()->from('{{member}}')
                    ->where('mobile=:params and status<=:status', array(
                            ':params' => $userPhone,':status'=>Member::STATUS_NORMAL))->queryAll();
    }
    /**
     * 获取会员折扣率
     */
    public static function getMemberDiscount($memberTypeId){
        return Yii::app()->db->createCommand()->select(array('discount'))->from('{{member_type}}')
                            ->where('id=:id', array(':id'=>$memberTypeId))->queryScalar();
    }

    /**
     * 通过电话号码获取用户账号信息
     * @param int $userPhone 用户电话号码
     * @return string|array
     */
    public static function getMemberByPhone($userPhone){
        $return = array();
        $whereStr = 'mobile=:mobile and is_master_account=:ima and `status`<=:status';
        $whereParam = array(':mobile' => $userPhone , ':ima'=>'1', ':status'=> Member::STATUS_NORMAL);
        //计算主账号个数
        $masterCount = Yii::app()->db->createCommand()
                    ->select(array('count(1) as num'))
                    ->from('{{member}}')
                    ->where($whereStr, $whereParam)
                    ->queryScalar();
        if($masterCount){
            if($masterCount == 1){
                $return = Yii::app()->db->createCommand()
                    ->from('{{member}}')
                    ->where($whereStr, $whereParam)
                    ->queryRow();
            }else{
                // 提示设置主账号
                $return = '主账号只能设置一个,请重新设置主账号!';
            }
        }else{
            // 查找非主账号
            $whereParam[':ima'] = '0';
            $count = Yii::app()->db->createCommand()
                    ->select(array('count(1) as num'))
                    ->from('{{member}}')
                    ->where($whereStr, $whereParam)
                    ->queryScalar();
            if($count){
                if($count == 1){
                    $return = Yii::app()->db->createCommand()
                            ->from('{{member}}')
                            ->where($whereStr, $whereParam)
                            ->queryRow();
                }else{
                    // 提示设置主账号
                    $return = '您有多个账号存在,请设置一个主账号!';
                }
            }else{
                // 没有账号
                $return = '账号不存在!';
            }
        }
        return $return;
    }
    
    /**
     * 电话号码的账号数量
     * @param int $userPhone
     */
    public static function getMemberCountByMobile($userPhone){
        $count = Yii::app()->db->createCommand()
                ->select(array('count(1) as num'))->from('{{member}}')->where('mobile=:mobile', array(':mobile' => $userPhone))
                ->queryScalar();
        return $count;
    }
    
    /**
     * 添加用户(手机的)
     * @param int $userPhone
     * @param string $password
     * @param string $gaiNumber
     * @param int $bizId
     * @return bool
     */
    public static function AddMember_gt($userPhone,$password,$gaiNumber,$machineId,$referrals_id='0', $smsContent='',$smsType='0',$datas=null,$tmpId=null)
    {
        $salt = Tool::generateSalt();
        $defaultVal = MemberType::fileCache();

        $time = time();
        $data = array(
            'password' => CPasswordHelper::hashPassword($password . $salt),
            'salt' => $salt,
            'register_time' => $time,
            'gai_number' => $gaiNumber,
            'type_id' => $defaultVal['defaultType'],
            'mobile' => $userPhone,
            'status' => Member::STATUS_NORMAL,
            'is_master_account' => '0',//主账号
            'register_type'=>  Member::REG_TYPE_MACHINE,
            'referrals_id'=>$referrals_id,
            'referrals_time'=>$time
        );
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            Yii::app()->db->createCommand()->insert('{{member}}', $data);
            $memberId = Yii::app()->db->getLastInsertID();
            
            //往盖网通注册表里面插入一条记录
	        $sql = "insert into gaitong.gt_machine_register(machine_id,member_id,register_time) values(:machine_id,:member_id,:register_time)";
            if(!Yii::app()->db->createCommand($sql)->execute(array(":machine_id"=>$machineId,":member_id"=>$gaiNumber,":register_time"=>time())))
            {
                throw new ErrorException('插入数据失败');
            }
            
            $transaction->commit();
            SmsLog::addSmsLog($userPhone, $smsContent,$memberId, SmsLog::TYPE_OTHER,null,true,$datas,$tmpId);
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return false;
    }
    
    /**
     * 添加用户(手机的)
     * @param int $userPhone
     * @param string $password
     * @param string $gaiNumber
     * @param int $bizId
     * @return bool
     */
    public static function AddMember_gt_Name($name,$password,$gaiNumber,$machineId,$referrals_id='0', $smsContent='',$smsType='0')
    {
        $salt = Tool::generateSalt();
        $defaultVal = MemberType::fileCache();
    
        $time = time();
        $data = array(
                'password' => CPasswordHelper::hashPassword($password . $salt),
                'salt' => $salt,
                'register_time' => $time,
                'gai_number' => $gaiNumber,
                'type_id' => $defaultVal['defaultType'],
                'username' => $name,
                'status' => Member::STATUS_NO_ACTIVE,
                'is_master_account' => '0',//主账号
                'register_type'=>  Member::REG_TYPE_MACHINE,
                'referrals_id'=>$referrals_id,
                'referrals_time'=>$time
        );
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            Yii::app()->db->createCommand()->insert('{{member}}', $data);
            $memberId = Yii::app()->db->getLastInsertID();
    
            //往盖网通注册表里面插入一条记录
            $sql = "insert into gaitong.gt_machine_register(machine_id,member_id,register_time) values(:machine_id,:member_id,:register_time)";
            if(!Yii::app()->db->createCommand($sql)->execute(array(":machine_id"=>$machineId,":member_id"=>$gaiNumber,":register_time"=>time())))
            {
                throw new ErrorException('插入数据失败');
            }
    
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return false;
    }
    
    /**
     * 生成GW02
     * @param int $memberId
     * @return int
     */
    public static function createGw02($memberId) {
        $sql = "INSERT INTO gw_member (
                    gai_number,
                    referrals_id,
                    type_id,
                    grade_id,
                    is_enterprise,
                    member_type,
                    pid,
                    pgw,
                    role
                ) SELECT
                    CONCAT('GW04', RIGHT(gai_number, 8)),
                    referrals_id,
                    type_id,
                    grade_id,
                    0,
                    member_type,
                    id,
                    gai_number,
                    :role
                FROM gw_member WHERE role = 0 AND id = :id AND NOT EXISTS ( SELECT id FROM gw_member WHERE role = :role AND pid = :id )";
        return Yii::app()->db->createCommand($sql)->bindValues(array(':id'=>$memberId,':role'=>Member::ROLE_AGENT))->execute();
    }
    
    /**
     * 生成唯一的会员编号 GW+8位数字
     * @return string
     */
    public static function makeGaiNumber() {
        $number = str_pad(mt_rand('1', '99999999'), 8, mt_rand(99999, 999999));
        $gaiNumber = "GW" . $number;
        $count = Yii::app()->db->createCommand()
                ->select(array('count(1) as num'))->from('{{member}}')->where('gai_number=:gai_number', array(':gai_number' => $gaiNumber))
                ->queryScalar();
        if ($count) {
            $gaiNumber = self::makeGaiNumber();
        }
        return $gaiNumber;
    }
    
    public static function getSigninCountToday($memberId,$machineId){
        $day = strtotime(date("Y-m-d"));
        $signed = Yii::app()->db->createCommand()
                ->select('count(1) as num')->from('{{signin}}')
                ->where('member_id=:mid and create_date=:today and machine_id=:machine_id', array(':mid'=>$memberId, ':today'=>$day,':machine_id'=>$machineId))
                ->queryScalar();
        return $signed;
    }
    
    public static function signin($member, $machineId, $ipAddress){
        $memberId = $member['id'];
        $day = strtotime(date("Y-m-d"));
        $now = time();
        // 最多每个会员每天记录一行记录
        $signLog = array(
            'member_id' => $memberId,
            'create_date' => $day,
            'create_time' => $now,
            'ip' => $ipAddress,
            'machine_id' => $machineId,
            'type' => '2',
        );
        
        
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
        	//签到表加签到次数
            Yii::app()->db->createCommand()->insert('{{signin}}', $signLog);
            
            //会员表签到次数+1
            Yii::app()->db->createCommand()
                    ->update('{{member}}', array('signins'=>$member['signins']+1), 'id=:id', array(':id'=>$memberId));
                    
           	//获取会员签到账户余额1
            $signAccountBalance = AccountBalance::findRecord(array('account_id'=>$member['id'],'type'=>AccountBalance::TYPE_SIGN,'gai_number'=>$member['gai_number']));
        	$result = $result = AccountBalance::calculate(array('today_amount' => 1), $signAccountBalance['id']);

        	if (!$result)throw ErrorException(Yii::t("Public","签到失败"),400);
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}

?>