<?php

/**
 * 历史余额表模型类
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
 * @property string $create_time
 */
class AccountBalanceHistory extends CActiveRecord {

    public static $logfile = 'runtime/account.log';   //异常账号

    public function tableName() {
        return '{{account_balance_history}}';
    }

    public function rules() {
        return array(
            array('account_id, gai_number, card_no, debit_today_amount, debit_yesterday_amount, today_amount, credit_yesterday_amount, type, last_update_time, create_time', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('account_id, last_update_time, create_time', 'length', 'max' => 11),
            array('gai_number, card_no', 'length', 'max' => 32),
            array('debit_today_amount, debit_yesterday_amount, today_amount, credit_yesterday_amount', 'length', 'max' => 18),
            array('remark', 'safe'),
            array('id, account_id, gai_number, card_no, debit_today_amount, debit_yesterday_amount, today_amount, credit_yesterday_amount, type, last_update_time, remark, create_time', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '账户卡号',
            'today_amount' => '今天余额',
            'yesterday_amount' => '昨天余额',
            'type' => '类型', // （1商家、2代理、3消费、4待返还、5冻结、6、盖网公共、9总账户）
            'last_update_time' => '最后更新时间',
            'remark' => '备注',
            'create_time' => '创建时间',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('account_id', $this->account_id, true);
        $criteria->compare('gai_number', $this->gai_number, true);
        $criteria->compare('card_no', $this->card_no, true);
        $criteria->compare('today_amount', $this->today_amount, true);
        $criteria->compare('yesterday_amount', $this->yesterday_amount, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('last_update_time', $this->last_update_time, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('create_time', $this->create_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDbConnection() {
        return Yii::app()->ac;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 生成字符串类型的卡号-用于账号的初始化
     * @author LC
     */
    public static function createCardNo($type, $count) {
        //初始的卡号
        $card_no = array();
        $card_no[1] = 10000000000;  //商家卡号的初始值
        $card_no[2] = 20000000000;  //代理卡号的初始值
        $card_no[3] = 30000000000;  //消费卡号的初始值

        $len = strlen($count);
        $i = 5 - $len;
        while ($i > 0) {
            $card_no[$type] .= 0;
            $i--;
        }
        $card_no[$type] .= $count;
        return $card_no[$type];
    }

    /**
     * 取账户余额
     */
    public static function getTodayAmountByGaiNumber($gnumber, $type = AccountBalance::TYPE_CONSUME) {
        if (empty($gnumber))
            return false;
        $rs = self::model()->find(" gai_number = '{$gnumber}' AND type=" . $type . " ORDER BY id DESC ");
        if (empty($rs))
            return 0;
        return $rs->today_amount * 1;
    }

    /**
     * 余额表更新操作
     * @param array $records 更新的数组 array('money' => 300, 'value' => -500);
     * @param int $param 主键
     * @throws CDbException
     * @throws Exception
     * @return boolean
     */
    public static function calculate($records, $param) {
        if (!empty($records) && $param) {
            $condition = '';
            foreach ($records as $key => $value)
                $condition .= '`' . $key . '` = `' . $key . '` ' . ($value < 0 ? $value : ('+ ' . $value)) . ',';
            $condition = rtrim($condition, ',');
            $time = time();
            $account = Yii::app()->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance_history where id=:id for update')->bindValue(':id',$param)->queryRow();
            if(empty($account['amount_salt'])){
                AccountBalance::addHashLog('金额密钥不能为空 old',$account);
                throw new Exception("金额密钥不能为空 old");
            }else{
                //消费账户做余额检查
                if($account['type']==AccountBalance::TYPE_CONSUME){
                    //如果历史余额不小于0，操作后也不能小于0
                    if($account['today_amount'] >=0 && bcadd($account['today_amount'],$records['today_amount'],2)<0){
                        throw new Exception("账户金额不足支付");
                    }
                }

                //校验金额
                $data = array($account['gai_number'],$account['account_id'],$account['today_amount'],$account['amount_salt'],AMOUNT_SIGN_KEY);
                $hash = sha1(implode('',$data));
                if($account['amount_hash']!=$hash){
                    AccountBalance::addHashLog('更新余额时金额校验失败 old '.$hash,$account);
                    throw new Exception("更新余额时金额校验失败 old");
                }
            }
            //新的hash
            $data = array($account['gai_number'],$account['account_id'],sprintf('%0.2f',$account['today_amount']+$records['today_amount']),$account['amount_salt'],AMOUNT_SIGN_KEY);
            $newHash = sha1(implode('',$data));
            $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance_history}}" . ' SET ' . $condition . ',last_update_time='.$time.',amount_hash="'.$newHash.'" WHERE id = ' . $param;
            return Yii::app()->db->createCommand($sql)->execute();
        } else
            return false;
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
    public static function findRecord($array, $doTransaction = false) {
        if (isset($array['account_id']) && isset($array['type']) && isset($array['gai_number'])) {
            $balanceTable = self::model()->tableName();
            $forUpdate = in_array($array['type'], array(AccountBalance::TYPE_COMMON, AccountBalance::TYPE_TOTAL)) ? "" : " FOR UPDATE";  //只行锁非盖网帐号
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
                $balance['create_time'] = $info['create_time'] = time();
                $balance['card_no'] = $info['card_no'] = AccountInfo::createCardNo($array['type']);
                $balance['yesterday_amount'] = '0.00';
                $balance['today_amount'] = '0.00';
                $balance['amount_salt'] = md5(uniqid());
                $balance['last_update_time'] = 0;
                $data = array($balance['gai_number'],$balance['account_id'],$balance['today_amount'],$balance['amount_salt'],AMOUNT_SIGN_KEY);
                $balance['amount_hash'] =  sha1(implode('',$data));
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

}
