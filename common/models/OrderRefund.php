<?php

/**
 *  订单金额退款到银行卡 模型
 *
 * The followings are the available columns in table '{{order_refund}}':
 * @property integer $id
 * @property string $member_id
 * @property string $code
 * @property string $money
 * @property string $user_id
 * @property string $create_time
 * @property string $remark
 */
class OrderRefund extends CActiveRecord
{
    /**
     * @var float $maxMoney 最大退款金额
     */
    public $maxMoney;

    public $gai_number;

    const ACCOUNT_TYPE_NEW = 1;
    const ACCOUNT_TYPE_OLD = 2;

    public static function accountType($k = null)
    {
        $a = array(
            self::ACCOUNT_TYPE_NEW => '新账',
            self::ACCOUNT_TYPE_OLD => '旧账',
        );
        if($k==null) return $a;
        return isset($a[$k]) ? $a[$k] : null;
    }

    public function tableName()
    {
        return '{{order_refund}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('code, money', 'required'),
            array('id', 'numerical', 'integerOnly' => true),
            array('member_id, user_id, create_time', 'length', 'max' => 10),
            array('code', 'length', 'max' => 64),
            array('money', 'length', 'max' => 13),
            array('remark', 'length', 'max' => 13),
            array('money', 'numerical', 'on' => 'create', 'min' => '0.01',
                'numberPattern' => '/^[0-9]+(.[0-9]{1,2})?$/'), //正整数、最多两位小数
            array('money', 'compare', 'compareAttribute' => 'maxMoney', 'operator' => '<='),
            array('id, member_id, code, money, user_id, create_time,maxMoney,gai_number,remark', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('orderRefund', 'ID'),
            'member_id' => Yii::t('orderRefund', '会员id'),
            'code' => Yii::t('orderRefund', '订单编号'),
            'money' => Yii::t('orderRefund', '退款金额'),
            'user_id' => Yii::t('orderRefund', '操作人id'),
            'create_time' => Yii::t('orderRefund', '操作时间'),
            'remark' => Yii::t('orderRefund', '备注'),
            'account_type' => Yii::t('orderRefund', '账户类型'),
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('member_id', $this->member_id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('money', $this->money, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        if ($this->gai_number) {
            $criteria->join = 'left join {{member}} as m on m.id=t.member_id';
            $criteria->addCondition('m.gai_number="' . $this->gai_number . '"');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->create_time = time();
            $this->user_id = Yii::app()->user->id;
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加退款流水
     * @param array $order
     * @param string $flowTableName
     * @param string $flowTableNameHistory
     * @throws Exception
     */
    public function addFlow($order, $flowTableName,$flowTableNameHistory)
    {

        $memberArray = array(
            'account_id' => $this->member_id,
            'gai_number' => $this->gai_number,
            'type' => AccountInfo::TYPE_CONSUME,
        );
        //当前会员余额
        $balance = AccountBalance::findRecord($memberArray); //会员消费账户
        $balanceHistory = AccountBalanceHistory::findRecord($memberArray); //会员历史消费账户
        $totalMoney = bcadd($balance['today_amount'], $balanceHistory['today_amount'], 2); //会员总余额
        if ($totalMoney < $this->money) {
            throw new Exception("该用户余额不够扣,余额：" . $totalMoney);
        }
        /**
         *  先扣新账户的余额，不够再使用旧账户
         */
        if ($balance['today_amount'] >= $this->money) {
            $newMoney = $this->money;
            $oldMoney = 0;
        } else {
//            if($balance['today_amount']>0){
//                $newMoney = $balance['today_amount'];
//                $oldMoney = bcsub($this->money,$balance['today_amount'],2);
//            }else{
//                $newMoney = 0;
//                $oldMoney = $this->money;
//            }
            if($balanceHistory['today_amount'] >= $this->money){
                $newMoney = 0;
                $oldMoney = $this->money;
            }else{
                throw new Exception("该用户历史余额不够扣,余额：" . $balanceHistory['today_amount']);
            }

        }
        if($newMoney > 0){
            $this->_flow($order,$balance,$flowTableName,$newMoney);
            Yii::app()->db->createCommand()->update('gw_order_refund',array('account_type'=>self::ACCOUNT_TYPE_NEW),'id='.$this->id);
        }
        if($oldMoney > 0){
            $this->_flow($order,$balanceHistory,$flowTableNameHistory,$oldMoney);
            Yii::app()->db->createCommand()->update('gw_order_refund',array('account_type'=>self::ACCOUNT_TYPE_OLD),'id='.$this->id);
        }
    }

    /**
     * 退款流水公+扣余额共代码部分
     * @param array $order
     * @param  string $balance
     * @param string $flowTableName
     * @param float $money
     * @throws Exception
     */
    private function _flow($order,$balance,$flowTableName,$money){
        $flows = AccountFlow::mergeFlowData($order, $balance, array(
            'credit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_REFUND_CASH,
            'remark' => '扣除积分，退款金额到银行卡：￥' . $money,
            'node' => AccountFlow::BUSINESS_NODE_REFUND_CASH,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
        ));
        if(strpos($flowTableName,'account_flow_history')===false){
            if (!AccountBalance::calculate(array('today_amount' => -$money), $balance['id'])) {
                throw new Exception('update memberAccount error');
            }
        }else{
            if (!AccountBalanceHistory::calculate(array('today_amount' => -$money), $balance['id'])) {
                throw new Exception('update memberHistoryAccount error');
            }
        }
        //写入流水
        Yii::app()->db->createCommand()->insert($flowTableName, $flows);
    }
}
