<?php

/**
 * 余额表模型类
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $account_id
 * @property string $gai_number
 * @property string $card_no
 * @property string $debit_today_amount
 * @property string $debit_yesterday_amount
 * @property string $today_amount
 * @property string $credit_yesterday_amount
 * @property integer $type
 * @property string $last_update_time
 * @property string $remark
 * @property string create_time
 */
class AccountBalance extends CActiveRecord {

    const TYPE_MERCHANT = 1; // 商家
    const TYPE_AGENT = 2; // 代理
    const TYPE_CONSUME = 3; // 消费
    const TYPE_RETURN = 4; // 待返还
    const TYPE_FREEZE = 5; //  冻结
    const TYPE_COMMON = 6; // 公共
    const TYPE_SIGN = 101;	//签到积分(不记录流水)
    const TYPE_GAME = 102;	//游戏币(不记录流水)
    const TYPE_TOTAL = 9; // 总账户，充值、中转
    const TYPE_RED =7; //红包账户
    const TYPE_CASH = 8; //普通会员提现账户
    public function tableName() {
        return '{{account_balance}}';
    }

    public function rules() {
        return array(
            array('gai_number, yesterday_amount, today_amount, type', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '账户卡号',
            'yesterday_amount' => '昨天余额',
            'today_amount' => '今天余额',
            'type' => '类型', //（1商家、2代理、3消费、4待返还、5冻结、6、盖网公共、11总账户）
            'last_update_time' => '最后更新时间',
            'remark' => '备注',
            'create_time' => '创建时间'
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('gai_number', $this->gai_number, true);
        $criteria->compare('today_amount', $this->today_amount, true);
        $criteria->compare('yesterday_amount', $this->yesterday_amount, true);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public function getDbConnection() {
        return Yii::app()->ac;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getType() {
        return array(
            self::TYPE_MERCHANT => '商家',
            self::TYPE_AGENT => '代理',
            self::TYPE_CONSUME => '消费',
            self::TYPE_RETURN => '待返还',
            self::TYPE_FREEZE => '冻结',
            self::TYPE_COMMON => '公共',
            self::TYPE_SIGN => '签到积分',
            self::TYPE_GAME => '游戏币',
            self::TYPE_TOTAL => '总账户',
            self::TYPE_RED=>'红包账户',
            self::TYPE_CASH=>'普通会员提现账户',
        );
    }

    public static function showType($key) {
        $typies = self::getType();
        return $typies[$key];
    }

    /**
     * 获取用户余额的数组构建，配合 @see findRecord 使用
     * @param $member 会员对象，或会员记录属性
     * @return array
     * @author jianlin.lin
     */
    public static function getAccountBalanceArrayBuild($member) {
        return array('account_id' => $member['id'], 'gai_number' => $member['gai_number'], 'type' => AccountInfo::TYPE_CONSUME);
    }

    /**
     * 创建及获取余额表账户信息 + 创建账户信息（account_info）
     * @param  array
     * $arr = array(
     *              'account_id'=>
     *              'type'=>
     *              'gai_number'=>
     *          );
     * @param bool
     * @return array
     * @throws Exception
     */
    public static function findRecord($array, $doTransaction = false,$times = null) {
        if($times === null)
            $times = time();
        if (isset($array['account_id']) && isset($array['type']) && isset($array['gai_number'])) {
            $balanceTable = self::model()->tableName();
            $forUpdate = in_array($array['type'], array(self::TYPE_COMMON, self::TYPE_TOTAL)) ? "" : " FOR UPDATE";  //只行锁非盖网帐号
            $condition = '`account_id`=' . $array['account_id'] . ' and `type`=' . $array['type'] . ' and `gai_number`="' . $array['gai_number'] . '"' . $forUpdate;
            $accountBalance = Yii::app()->db->createCommand()->select()->from(ACCOUNT . '.' . $balanceTable)->where($condition)->queryRow();
            if ($accountBalance) {
                return $accountBalance;
            } else {
                unset($array['id']);
                $infoTable = AccountInfo::model()->tableName();
                //重新赋值，过滤掉 $array 多余的数据
                $array = array(
                    'account_id' => $array['account_id'],
                    'type' => $array['type'],
                    'gai_number' => $array['gai_number'],
                );
                $balance = $info = $array;
                $balance['create_time'] = $info['create_time'] = $times;
                $balance['card_no'] = $info['card_no'] = AccountInfo::createCardNo($array['type']);
                $balance['yesterday_amount'] = '0.00';
                $balance['today_amount'] = '0.00';
                $balance['amount_salt'] = md5(uniqid());
                $balance['last_update_time'] = 0;
                $balance['amount_hash'] =  sha1($balance['gai_number'].$balance['account_id'].$balance['today_amount'].$balance['amount_salt'].AMOUNT_SIGN_KEY);
                if ($doTransaction == true) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        // 账户表信息创建
                        Yii::app()->db->createCommand()->insert(ACCOUNT . '.' . $infoTable, $info);
                        // 余额表信息创建
                        Yii::app()->db->createCommand()->insert(ACCOUNT . '.' . $balanceTable, $balance);
                        $balance['id'] = Yii::app()->db->lastInsertID;
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        return false;
                    }
                } else {
                    // 账户表信息创建
                    Yii::app()->db->createCommand()->insert(ACCOUNT . '.' . $infoTable, $info);
                    // 余额表信息创建
                    Yii::app()->db->createCommand()->insert(ACCOUNT . '.' . $balanceTable, $balance);
                }
                return self::findRecord($array);
            }
        } else
            return false;
    }

    /**
     * 余额表更新操作
     * @param array $records 更新的数组 array('money' => 300, 'value' => -500);
     * @param int $param 主键
     * @return boolean
     */
    public static function calculate($records, $param) {
        if (!empty($records) && $param) {
            $condition = '';
            foreach ($records as $key => $value)
                $condition .= '`' . $key . '` = `' . $key . '` ' . ($value < 0 ? $value : ('+ ' . $value)) . ',';
            $condition = rtrim($condition, ',');
            $account = Yii::app()->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance where id='.$param)->queryRow();
            if(empty($account['amount_salt'])){
                self::addHashLog('金额密钥不能为空 new',$account);
                 }else if($account['type']!=self::TYPE_COMMON && $account['type']!=self::TYPE_TOTAL){ //公共账户、总账户不做检查
                //记录加行锁
                $account = Yii::app()->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance where id='.$param.' for update')->queryRow();
                //消费账户做余额检查
                if($account['type']==AccountBalance::TYPE_CONSUME){
                    //如果余额不小于0，操作后也不能小于0
                    if($account['today_amount'] >=0 && bcadd($account['today_amount'],$records['today_amount'],2)<0){
                        throw new Exception("账户金额不足支付");
                    }
                }
                //校验金额
                $hash = sha1($account['gai_number'].$account['account_id'].$account['today_amount'].$account['amount_salt'].AMOUNT_SIGN_KEY);
                if($account['amount_hash']!=$hash){
                    self::addHashLog('更新余额时金额校验失败 new '.$hash,$account);
                    throw new Exception("更新余额时金额校验失败 new-".$account['amount_hash'].'-'.$hash);
                }
            }
            //新的hash
            $data = array($account['gai_number'],$account['account_id'],sprintf('%0.2f',$account['today_amount']+$records['today_amount']),$account['amount_salt'],AMOUNT_SIGN_KEY);
            $newHash = sha1(implode('',$data));
            $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance}}" . ' SET ' . $condition .', last_update_time='.time(). ',amount_hash="'.$newHash.'"  WHERE id = ' . $param;
            return Yii::app()->db->createCommand($sql)->execute();
        } else
            return false;
    }

    /**
     * 取账户余额
     */
    public static function getTodayAmountByGaiNumber($gnumber, $type = self::TYPE_CONSUME) {
        if (empty($gnumber))
            return false;
        $rs = self::model()->find(" gai_number = '{$gnumber}' AND type=" . $type . " ORDER BY id DESC ");
        if (empty($rs))
            return 0;
        return $rs->today_amount * 1;
    }

    /**
     * 获取账号余额,返回新余额加上旧余额
     * @param string $gai_number 会员
     * @param int $type 账户类型
     * @return float
     */
    public static function getAccountAllBalance($gai_number, $type) {
        $accountNew = $accountOld = 0;
        $accountNew = self::getTodayAmountByGaiNumber($gai_number, $type);
        $accountOld = AccountBalanceHistory::model()->find(" gai_number = '{$gai_number}' AND type=" . $type . " ORDER BY id DESC ");
        $total = $accountNew ? $accountNew : 0;
        $total +=!empty($accountOld) && $accountOld['today_amount'] ? $accountOld['today_amount'] : 0;
        return $total*1;
    }

    /**
     * 获取历史代扣余额
     * @param int $member_id 会员id
     * @param string $gai_number 会员gw
     * @param float $pay 订单支付金额
     * @param int $type 会员类型
     * @return float $useMoney
     */
    public static function getHistoryUseMoney($member_id, $gai_number, $pay, $type = AccountInfo::TYPE_CONSUME) {
        //获取新余额的(消费账户)金额
        $currentMoney = Member::getCurrentPrice($type, $member_id, $gai_number);
        //获取旧余额的(消费账户)金额
        $historyMoney = Member::getHistoryPrice($type, $member_id, $gai_number);
        //要代扣的金额
        $useMoney = 0;
        if ($historyMoney) {
            if ($historyMoney >= $pay) {
                $useMoney = $pay;
            } elseif ($historyMoney < $currentMoney) {
                $useMoney = $historyMoney;
            } else {
                $useMoney = $pay - $currentMoney;
            }
        }
        return $useMoney;
    }

    /**
     * 获取可提现账户的余额，商家+代理
     * @param $memberId
     * @return mixed
     */
    public static function getWithdrawBalance($memberId) {
        $sql = 'select sum(today_amount) from ' . ACCOUNT . '.gw_account_balance
               where account_id=:mid and type in(:t1,:t2)';
        return Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':mid' => $memberId, ':t1' => self::TYPE_MERCHANT, ':t2' => self::TYPE_AGENT))
                        ->queryScalar();
    }
    
     /**
     * 获取可提现账户的余额，普通会员
     * @param $memberId
     * @return mixed
     */
    public static function getMemberBalance($memberId) {
        $sql = 'select sum(today_amount) from ' . ACCOUNT . '.gw_account_balance
               where account_id=:mid and type=:t1';
        return Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':mid' => $memberId, ':t1' => self::TYPE_CASH))
                        ->queryScalar();
    }
    

    public static function getAmountCompare() {
        return array('' => '不限', '< 0' => '小于零', '> 0' => '大于零', '= 0' => '等于零');
    }
    
    /**
     * @param $title
     * @param string $data
     */
    public static function addHashLog($title,$data=''){
        $trace = debug_backtrace();
        $action = '';
        if(!defined('IS_COMMAND')){
            $action .= Yii::app()->controller->id.'/'.Yii::app()->controller->getAction()->getId();
            $action .= PHP_EOL.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].PHP_EOL;
        }

        $function = PHP_EOL.$action.PHP_EOL.$trace[1]['class'].$trace[1]['type'].$trace[1]['function'].PHP_EOL;
        if(isset($trace[2]))$function .= $trace[2]['class'].$trace[2]['type'].$trace[2]['function'].PHP_EOL;
        if(isset($trace[3]))$function .= $trace[3]['class'].$trace[3]['type'].$trace[3]['function'].PHP_EOL;
        if(isset($trace[4]))$function .= $trace[4]['class'].$trace[4]['type'].$trace[4]['function'].PHP_EOL;

        Yii::log($title.$function.var_export($data,true),CLogger::LEVEL_ERROR,'hash');
    }
}
