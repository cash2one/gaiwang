<?php

/**
 * 积分充值模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $member_id
 * @property string $code
 * @property string $score
 * @property string $money
 * @property string $ratio
 * @property string $create_time
 * @property string $pay_time
 * @property integer $status
 * @property string $remark
 * @property string $ip
 * @property integer $pay_type
 * @property integer $pay_mode
 * @property string $description
 */
class Recharge extends CActiveRecord {

    const STATUS_NOT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILD = 2;
    const STATUS_RECOVER = 3;

    const PAY_TYPE_HUXUN = 0;
    const PAY_TYPE_YINLIANG = 1;
    const PAY_TYPE_YI = 2;
    const PAY_TYPE_HI = 3;
    const PAY_TYPE_UM = 4;
    const PAY_TYPE_UM_QUICK = 5;
    const PAY_TYPE_POS = 6;
    const PAY_TYPE_TL = 7;
    const PAY_TYPE_GHT = 8;
    const PAY_TYPE_GHTKJ = 11;
    const PAY_TYPE_GHT_QUICK = 9;
    const PAY_TYPE_EBC = 10;
    const PAY_TYPE_WEIXIN = 101; // 微信支付方式


    public $endTime;
    public $number;
    public $endScore;
    public $verifyCode; //验证码
    public $exportLimit = 10000; //导出excel的每页数
    public $isExport; // 是否导出excel
    public $gai_number;

    /*     * *************** */

    const FLAG_ZERO = 0;    // 无
    const FLAG_ONE = 1;     // 45591特殊商品时充值标记

    public static function getStatus($k = null) {
        $arr = array(
            self::STATUS_NOT => Yii::t('recharge','未充值'),
            self::STATUS_SUCCESS => Yii::t('recharge','充值成功'),
            self::STATUS_FAILD => Yii::t('recharge','充值失败')
        );
        return isset($arr[$k]) ? $arr[$k] : $arr;
    }

    public static function showMoney($money) {
        return '<span class="jf">¥' . $money . '</span>';
    }

    public static function showScore($score) {
        return '<span class="jf">' . $score . '</span>';
    }

    public static function showStatus($key) {
        $status = self::getStatus();
        if ($key == self::STATUS_NOT)
            $string = '<span style="color: Blue">' . $status[$key] . '</span>';
        if ($key == self::STATUS_SUCCESS)
            $string = '<span style="color: green">' . $status[$key] . '</span>';
        if ($key == self::STATUS_FAILD)
            $string = '<span style="color: red">' . $status[$key] . '</span>';
        return $string;
    }

    public static function getPayType() {
        return array(
            self::PAY_TYPE_HUXUN => '环讯支付',
            self::PAY_TYPE_YINLIANG => '银联在线支付',
            self::PAY_TYPE_YI => '翼支付',
            self::PAY_TYPE_HI => '汇卡支付',
            self::PAY_TYPE_UM => '联动优势',
            self::PAY_TYPE_POS => 'POS刷卡',
            self::PAY_TYPE_UM_QUICK => '联动优势（快捷支付）',
            self::PAY_TYPE_TL => '通联支付',
            self::PAY_TYPE_GHT => '高汇通支付',
            self::PAY_TYPE_GHTKJ => '高汇通KJ支付',
            self::PAY_TYPE_GHT_QUICK => '高汇通（快捷支付）',
            self::PAY_TYPE_EBC =>'EBC钱包支付',
        	self::PAY_TYPE_WEIXIN =>'微信支付',
        );
    }

    public static function showPayType($key) {
        $type = self::getPayType();
        return isset($type[$key]) ? $type[$key] : 'no';
    }

    public function tableName() {
        return '{{recharge}}';
    }

    public function rules() {

        return array(
//            array('verifyCode', 'required', 'on' => 'insert'),
            array('gai_number,money', 'required', 'on' => 'insert'),
            array('verifyCode', 'captcha'),
            array('code, score, money', 'required'),
            array('status, pay_type, pay_mode', 'numerical', 'integerOnly' => true),
            array('pay_type','in','range'=>array(self::PAY_TYPE_HUXUN,self::PAY_TYPE_YINLIANG,self::PAY_TYPE_YI,self::PAY_TYPE_UM,self::PAY_TYPE_HI)),
//            array('money', 'numerical', 'integerOnly' => true, 'min' => 1, 'on' => 'insert'),
            array('money', 'match', 'pattern' => '/^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/', 'message' => '输入的格式不正确', 'on' => 'insert'),
            array('member_id, create_time, pay_time, ip', 'length', 'max' => 11),
            array('code', 'length', 'max' => 32),
            array('score, money, ratio', 'length', 'max' => 10),
            array('gai_number','isExist'),
            array('member_id,score,endScore, create_time, endTime, status, pay_type', 'safe', 'on' => 'search'),
            array('endTime,endScore,verifyCode,by_gai_number,gai_number', 'safe')
        );
    }

    /**
     * 验证充值者是否存在
     * @param type $attribute
     * @param type $params
     */
    public function isExist($attribute, $params) {
        if ($this->gai_number) {
            $member = Member::model()->find(array(
                'select' => 'id',
                'condition' => 'gai_number=:gw',
                'params' => array(':gw' => $this->gai_number)
            ));
            if ($member === null)
                $this->addError($attribute, Yii::t('recharge', '无效GW号'));
        }
    }

    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('recharge', '主键'),
            'member_id' => Yii::t('recharge', '所属会员'),
            'code' => Yii::t('recharge', '编号'),
            'score' => Yii::t('recharge', '充值积分'),
            'money' => Yii::t('recharge', '充值金额'),
            'ratio' => Yii::t('recharge', '比率'),
            'create_time' => Yii::t('recharge', '创建时间'),
            'pay_time' => Yii::t('recharge', '支付时间'),
            'status' => Yii::t('recharge', '状态'), //（0未充值，1充值成功，2充值失败）
            'remark' => Yii::t('recharge', '备注'),
            'ip' => Yii::t('recharge', 'IP'),
            'pay_type' => Yii::t('recharge', '支付类型'),
            'pay_mode' => Yii::t('recharge', 'Pay Mode'),
            'description' => Yii::t('recharge', '说明'),
            'number' => Yii::t('recharge', '支付业务号'),
            'verifyCode' => Yii::t('recharge', '验证码'),
        	'by_gai_number' => Yii::t('recharge', '充值人'),
            'gai_number' => Yii::t('recharge','GW号')
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('code', $this->code, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('pay_type', $this->pay_type);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);

        // 所属会员
        if ($this->member_id) {
            if ($member = Member::model()->find('gai_number=:gw', array(':gw' => $this->member_id)))
                $criteria->compare('member_id', $member->id);
            else
                $criteria->compare('member_id', 0);
        }

        // 导出excel
        $pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = 'page';
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    /**
     * 前台积分充值记录
     * @param int $member_id
     * @return CActiveDataProvider
     */
    public function searchList($member_id) {
//    	$member = Yii::app()->db->createCommand()->select('gai_number')->from('{{member}}')->where('id=:id', array(':id' => $member_id))->queryRow();
        $criteria = new CDbCriteria;
        $criteria->compare('code', $this->code, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('pay_type', $this->pay_type);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);      
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);
      	$criteria->compare('member_id',$member_id);
        $criteria->compare('score','>=' . $this->score);     
        $criteria->compare('score','<=' . $this->endScore);      
        $criteria->select = 't.*,m.gai_number as gai_number';
        $criteria->join .= 'LEFT JOIN {{member}} AS m ON t.member_id=m.id';
      
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function showNumber($string) {
        if ($string) {
            $string = CJSON::decode($string);
            return isset($string['IPSBillno']) ? $string['IPSBillno'] : null;
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
                $this->ip = Tool::ip2int($_SERVER['REMOTE_ADDR']);
                $type = MemberType::fileCache();
                $this->ratio = $type[Yii::app()->user->getState('typeId')];
                if(empty($this->member_id)) $this->member_id = Yii::app()->user->id;
                $this->status = self::STATUS_NOT;
                $this->pay_mode = 1;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取一条订单 FOR UPDATE 锁行
     * @param $code
     * @param int $status
     * @return mixed
     */
    public static function getOneByCode($code, $status = self::STATUS_NOT)
    {
        return Yii::app()->db->createCommand()
            ->from('{{recharge}}')
            ->where('code=:code and status=:status FOR UPDATE',
                array(':code' => $code, ':status' => $status))->queryRow();
    }

    /**
     * 第三方支付的时候充值
     * @param array $member
     * @param float $amount
     * @param float $ratio
     * @param string $description
     */
    public static function payPlatformRecharge($order_code,$member,$amount,$ratio,$node,$remark)
    {

        $score = bcdiv($amount,$ratio,2);
        $time = time();
        //月表
        $monthTable = AccountFlow::monthTable();
        //开启事务
        $transaction = Yii::app()->db->beginTransaction();
        //插入recharge 因为冲突不能用save
        Yii::app()->db->createCommand()->insert(Recharge::tableName(),
            array(
                'member_id' => $member['id'],
                'code' =>$order_code,
                'ratio' => $ratio,
                'score'=>$score,
                'money' =>  $amount,
                'create_time' =>  $time,
                'pay_time' =>$time,
                'status' => Recharge::STATUS_SUCCESS,
                'description' => $remark.'充值',
                'pay_type' => Recharge::PAY_TYPE_UM,
                'pay_mode' => 1,
                'by_gai_number' =>$member['gai_number'],
                'ip' => Tool::getIP(),
            ));
        $recarge_id = Yii::app()->db->getLastInsertID();

        // 会员余额表记录创建
        $arr = array(
            'account_id'=>$member['id'],
            'type'=>AccountBalance::TYPE_CONSUME,
            'gai_number'=>$member['gai_number']
        );
        $memberAccountBalance = AccountBalance::findRecord($arr);

        // 会员充值流水 贷 +
        $MemberCredit = array(
            'account_id' => $memberAccountBalance['account_id'],
            'gai_number' => $memberAccountBalance['gai_number'],
            'card_no' => $memberAccountBalance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $amount,
            'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
            'order_id' =>  $recarge_id,
            'order_code' => $order_code,
            'remark' => $remark.'充值消费'.$amount,
            'node' =>$node,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
            'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
            'by_gai_number' => $member['gai_number'],
        );
        // 会员账户余额表更新
        AccountBalance::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);
        // 借贷流水1.按月
        Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($MemberCredit));

        $transaction->commit();
    }

}
