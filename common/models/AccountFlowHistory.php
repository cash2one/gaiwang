<?php

/**
 * 历史流水表模型类
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $account_id
 * @property string $gai_number
 * @property string $card_no
 * @property string $date
 * @property string $create_time
 * @property integer $type
 * @property string $debit_amount
 * @property string $credit_amount
 * @property integer $operate_type
 * @property string $trade_spec
 * @property integer $trade_terminal_id
 * @property string $ratio
 * @property string $order_id
 * @property string $order_code
 * @property string $area_id
 * @property string $remark
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property integer $week
 * @property integer $week_day
 * @property string $ip
 * @property integer $hour
 * @property integer $moved
 * @property string $node
 * @property string $franchisee_id
 * @property integer $recharge_type
 * @property string $distribution_ratio
 * @property integer $transaction_type
 * @property string $parent_id
 * @property string $prepaid_card_no
 * @property string $current_balance
 * @property integer $flag
 */
class AccountFlowHistory extends CActiveRecord {

    private static $_baseTableName = '{{account_flow_history}}';
    public $month;
    
    const GWNUM='GW60360255';
    const OPERATE='33';
    
    public function tableName() {
        $month = Yii::app()->user->getState('accountFlowHistoryMonth');
        if (empty($month))
            return self::monthTable();
        $this->month = $month;
        return self::$_baseTableName . '_' . str_replace('-', '', $month);
    }

    public function rules() {
        return array(
            array('account_id, gai_number, card_no, date, create_time, type, debit_amount, credit_amount, operate_type, trade_terminal_id, ratio, order_id, order_code, area_id, province_id, city_id, district_id, week, week_day, ip, hour, node, franchisee_id, recharge_type, distribution_ratio, transaction_type, parent_id, prepaid_card_no, current_balance, flag', 'required'),
            array('type, operate_type, trade_terminal_id, week, week_day, hour, moved, recharge_type, transaction_type, flag', 'numerical', 'integerOnly' => true),
            array('account_id, create_time, order_id, area_id, province_id, city_id, district_id, ip, franchisee_id', 'length', 'max' => 11),
            array('gai_number, card_no, order_code, node,by_gai_number', 'length', 'max' => 32),
            array('debit_amount, credit_amount, current_balance', 'length', 'max' => 18),
            array('trade_spec', 'length', 'max' => 45),
            array('ratio', 'length', 'max' => 3),
            array('distribution_ratio', 'length', 'max' => 5),
            array('parent_id, prepaid_card_no', 'length', 'max' => 64),
            array('remark', 'safe'),
            array('by_gai_number,id, account_id, gai_number, card_no, date, create_time, type, debit_amount, credit_amount, operate_type, trade_spec, trade_terminal_id, ratio, order_id, order_code, area_id, remark, province_id, city_id, district_id, week, week_day, ip, hour, moved, node, franchisee_id, recharge_type, distribution_ratio, transaction_type, parent_id, prepaid_card_no, current_balance, flag', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'month' => '月份',
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '卡号',
            'date' => '日期',
            'create_time' => '创建时间',
            'type' => '类型', //（1商家、2代理、3消费、4待返还、5冻结、6、盖网公共、9总账户）
            'debit_amount' => '借方发生额',
            'credit_amount' => '贷方发生额',
            'operate_type' => '交易类型', //（1、线上订单支付2、线上订单签收3、线上订单退款4、线上订单退货5、线上订单关闭6、线上订单评论7、线上订单维权8、酒店订单支付9、酒店订单确认10、酒店订单完成11、酒店订单评论12、酒店订单取消13、网银充值14、卡充值15、申请提现16、撤消提现17、线下订单支付18、线下订单撤消19、线下订单对账20、提现成功）
            'trade_spec' => '地点',
            'trade_terminal_id' => '所属终端',
            'ratio' => '比率',
            'order_id' => '订单ID',
            'order_code' => '订单编号',
            'area_id' => '区域类型',
            'remark' => '备注',
            'province_id' => '省份',
            'city_id' => '城市',
            'district_id' => '区/县',
            'week' => '第几周',
            'week_day' => '星期几',
            'ip' => '客户IP',
            'hour' => '小时',
            'moved' => '是否搬送', //（0否、1是）
            'node' => '业务节点',
            'franchisee_id' => '加盟商ID',
            'recharge_type' => '充值类型',
            'distribution_ratio' => '分配比率',
            'transaction_type' => '事务类型',
            'parent_id' => 'Parent',
            'prepaid_card_no' => '充值卡编号',
            'current_balance' => '当前余额',
            'flag' => '标识', //（0无、1特殊）1特殊是代扣的流水，不在前台显示给会员看
        	'by_gai_number' => '来自GW号',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('gai_number', $this->gai_number, true);
        $criteria->compare('card_no', $this->card_no, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('operate_type', $this->operate_type);
        $criteria->compare('order_code', $this->order_code, true);
        $criteria->compare('node', $this->node, true);
        $criteria->compare('transaction_type', $this->transaction_type);

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

    /**
     * 按月创建表
     * @return string
     */
    public static function monthTable($timeS = null) {
        if($timeS === null)
            $timeS = time();
        $time = date('Ym', $timeS);
        $table = self::$_baseTableName . '_' . $time;
        $baseTable = self::$_baseTableName;

        $exist = Yii::app()->ac->createCommand("SHOW TABLES LIKE '$table'")->queryScalar();
        if( $exist === false ) {
            $sql = "CREATE TABLE IF NOT EXISTS $table LIKE $baseTable;";
            Yii::app()->ac->createCommand($sql)->execute();
        }
        return ACCOUNT . '.' . $table;
    }

}
