<?php

/**
 * 公有账号模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property string $city_id
 * @property string $cash
 */
class CommonAccount extends CActiveRecord {

    public $maxMoney;
    public $level;
    public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel起始
    public $exportLimit = 5000; //导出excel长度
    public $yesterday_amount;
    public $today_amount;

    public function tableName() {
        return '{{common_account}}';
    }

    public function rules() {
        return array(
            array('name, type, city_id, cash', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('city_id', 'length', 'max' => 11),
            array('cash', 'length', 'max' => 18),
            array('name, type, cash, maxMoney', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'dis' => array(self::BELONGS_TO, 'Region', 'city_id')
        );
    }

    const TYPE_ONLINE_TOTAL = 1; // 线上公共总帐户
    const TYPE_OFFLINE_TOTAL = 2; // 线下公共总帐户
    const TYPE_GAI_INCOME = 3; // 盖网通收益帐户
    const TYPE_GAI_HONGBAO = 4; // 线上红包池帐户
    const TYPE_GAME_INCOME = 5;	//游戏收益账户
    const TYPE_OFF_MANEUVER =6 ; //盖网通机动
    const TYPE_OFF_CITY = 7; //区域资金池（省，市，区）
    const TYPE_OFF_MANAGE = 8;  //大区账户

    public static function getType() {
        return array(
            self::TYPE_ONLINE_TOTAL => '线上公共总帐户',
            self::TYPE_OFFLINE_TOTAL => '线下公共总帐户',
            self::TYPE_GAI_INCOME => '收益总帐户',
            self::TYPE_GAI_HONGBAO => '红包池帐户',
        	self::TYPE_GAME_INCOME => '游戏收益账户',
            self::TYPE_OFF_MANEUVER=>'机动',
            self::TYPE_OFF_CITY=>'区域资金池',
                self::TYPE_OFF_MANAGE=>'大区账户'
        );
    }

    public static function showType($key) {
        $type = self::getType();
        return isset($type[$key]) ? $type[$key] : '类型不存在';
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'name' => '名称',
            'type' => '类型',
            'city_id' => '地区（省/市/区）',
            'cash' => '金额',
            'gai_number' => '盖网通编号',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
//        $criteria->compare('cash', ">=" . $this->cash);
//        $criteria->compare('cash', "<" . $this->maxMoney);


        $pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
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
    
    public function searchBalance(){
    	$criteria = new CDbCriteria;
    	$criteria->select = "t.name,t.type,b.today_amount,b.yesterday_amount";
    	$criteria->join = "left join account.gw_account_balance as b ON t.gai_number = b.gai_number";
    	$criteria->compare('name', $this->name, true);
    	$criteria->compare('t.type', $this->type);
    	//var_dump($criteria);die();
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    	));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function showMoney($model) {
        return '<span class="jf">¥' . number_format($model->cash, 2) . '</span>';
    }

    /**
     * 总后台管理-代理列表-代理账户列表  生成操作按钮
     * @author LC
     */
    public static function createButton($id) {
        if (Yii::app()->user->checkAccess('CommonAccountAgentDist.Create'))
            return CHtml::link('【' . Yii::t('commonAccount', '分配金额') . '】', array('commonAccountAgentDist/create', 'id' => $id));
        return '';
    }

    /**
     * 获取某类型的账户，没有则创建
     * @param int $type 账户类型
     * @param int $accountType  AccountInfo 中的账户类型，是 6 or 9
     * @param string $name
     * @param int $targetId
     * @param bool $isTrans 是否使用事务
     * @return array
     */
    public static function getAccount($type, $accountType, $name = '', $targetId = 0, $isTrans = false) {
        $array = array('type' => $accountType);
        $commonAccount = Yii::app()->db->createCommand()->select()->from('{{common_account}}')
                        ->where('type=:type AND city_id=:cid', array(':type' => $type, ':cid' => $targetId))->queryRow();
        $accountName = $name ? $name . (self::showType($type)) : (self::showType($type));
        if (empty($commonAccount)) {
            $gaiNumber = self::generateGaiNumber();
            Yii::app()->db->createCommand()->insert('{{common_account}}', array(
                'type' => $type, 'city_id' => $targetId, 'name' => $accountName, 'gai_number' => $gaiNumber));
            $array['account_id'] = Yii::app()->db->lastInsertID;
            $array['gai_number'] = $gaiNumber;
        } else {
            $array['account_id'] = $commonAccount['id'];
            $array['gai_number'] = $commonAccount['gai_number'];
        }
        $balanceInfo = AccountBalance::findRecord($array, $isTrans);
        return $balanceInfo;
    }

    /**
     * 生成gw号
     * @param type $length
     * @return type
     */
    public static function generateGaiNumber($length = 7) {
        $chars = '0123456789';
        $number = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $number .= $chars[mt_rand(0, $max)];
        $res = Yii::app()->db->createCommand()->select('id')->from('{{common_account}}')
                        ->where('gai_number=:gw', array(':gw' => 'GW' . $number))->queryScalar();
        if ($res)
            return self::generateGaiNumber($length);
        return 'GW' . $number;
    }

    /**
     * 获取线上总账户
     */
    public static function getOnlineAccount() {
        return self::getAccount(CommonAccount::TYPE_ONLINE_TOTAL, AccountInfo::TYPE_TOTAL);
    }

    /**
     * 获取线下总账户
     */
    public static function getOfflineAccount() {
        return self::getAccount(CommonAccount::TYPE_OFFLINE_TOTAL, AccountInfo::TYPE_TOTAL);
    }

    /**
     * 获取收益账户
     */
    public static function getEarningsAccount() {
        return self::getAccount(CommonAccount::TYPE_GAI_INCOME, AccountInfo::TYPE_COMMON);
    }

    /**
     * 获取红包池帐户
     */
    public static function getHongbaoAccount() {
        return self::getAccount(CommonAccount::TYPE_GAI_HONGBAO, AccountInfo::TYPE_COMMON);
    }

    /**
     * 获取线上总账户（隐帐）
     */
    public static function getOnlineAccountForHistory() {
        return self::getAccountForHistory(CommonAccount::TYPE_ONLINE_TOTAL, AccountInfo::TYPE_TOTAL);
    }

    /**
     * 获取某类型的账户，没有则创建（隐帐）
     * @param int $type 账户类型
     * @param int $accountType  AccountInfo 中的账户类型，是 6 or 9
     * @param string $name
     * @param int $targetId
     * @param bool $isTrans 是否使用事务
     * @return array
     */
    public static function getAccountForHistory($type, $accountType, $name = '', $targetId = 0, $isTrans = false) {
        $array = array('type' => $accountType);
        $commonAccount = Yii::app()->db->createCommand()->select()->from('{{common_account}}')
            ->where('type=:type AND city_id=:cid', array(':type' => $type, ':cid' => $targetId))->queryRow();
        $accountName = $name ? $name . (self::showType($type)) : (self::showType($type));
        if (empty($commonAccount)) {
            $gaiNumber = self::generateGaiNumber();
            Yii::app()->db->createCommand()->insert('{{common_account}}',
                array('type' => $type, 'city_id' => $targetId, 'name' => $accountName, 'gai_number' => $gaiNumber));
            $array['account_id'] = Yii::app()->db->lastInsertID;
            $array['gai_number'] = $gaiNumber;
        } else {
            $array['account_id'] = $commonAccount['id'];
            $array['gai_number'] = $commonAccount['gai_number'];
        }
        $balanceInfo = AccountBalanceHistory::findRecord($array, $isTrans);
        return $balanceInfo;
    }
}
