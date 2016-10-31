<?php

/**
 * 充值卡模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $number
 * @property string $password
 * @property string $value
 * @property integer $status
 * @property string $create_time
 * @property string $member_id
 * @property string $use_time
 * @property string $user_ip
 * @property string $author_ip
 * @property string $author_id
 * @property integer $type
 * @property string $author_name
 * @property string $money
 * @property string $owner_id
 * @property string $sale_time
 * @property string $sale_remark
 * @property integer $is_recon
 * @property string $recon_user
 * @property string $recon_time
 * @property string $version
 */
class PrepaidCard extends CActiveRecord {

    public $exportLimit = 10000; //导出excel的每页数
    public $isExport; // 是否导出excel
    public $num;
    public $unit;
    public $flag;
    public $used;
    public $endTime;
    public $maxValue;
    public $mobile;
    public $gaiNumber;

    const UNIT_ONE = 1; // 一盖网积分
    const UNIT_THOUSAND = 2; // 千盖网积分
    const STATUS_UNUSED = 0; // 未使用
    const STATUS_USED = 1; // 已使用
    const TYPE_SPECIAL = 1; // 充值卡（使用后转成正式会员）
    const TYPE_GENERAL = 2; // 积分返还充值卡（使用后不会转成正式会员）
    const RECON_NO = 0; // 未对账
    const RECON_YES = 1; // 已对账
    
    const YES_CREATE = 1;//已生成
    const NO_CREATE = 2;//未生成

    /**
     * 对账状态
     * @param return $array
     */

    public static function getRecon() {
        return array(
            self::RECON_NO => Yii::t('prepaidCard', '未对账'),
            self::RECON_YES => Yii::t('prepaidCard', '已对账')
        );
    }

    /**
     * 积分倍数
     * @return array
     */
    public static function getUnit() {
        return array(
            self::UNIT_ONE => Yii::t('prepaidCard', '一盖网积分'),
            self::UNIT_THOUSAND => Yii::t('prepaidCard', '千盖网积分')
        );
    }

    /**
     * 状态
     * @return array
     */
    public static function getStatus() {
        return array(
            self::STATUS_UNUSED => Yii::t('prepaidCard', '未使用'),
            self::STATUS_USED => Yii::t('prepaidCard', '已使用')
        );
    }

    /**
     * 显示状态
     * @param int $key
     * @return string
     */
    public static function showStatus($key) {
        $status = self::getStatus();
        return $status[$key];
    }

    /**
     * 显示对账状态
     * @param int $key
     * @return string
     */
    public static function showRecon($key) {
        $recon = self::getRecon();
        return $recon[$key];
    }

    public function tableName() {
        return '{{prepaid_card}}';
    }

    public function rules() {
        return array(
            array('num, value, unit, money, version', 'required', 'on' => 'special'),
            array('value', 'required', 'on' => 'general'),
            array('value,mobile,create_time','required','on'=>'batch'),
            array('mobile', 'match', 'pattern' =>'/^8|(1[3|4|5|8][0-9]\d{4,8})$/', 'message' => '请输入正确的手机号码','on'=>'batch'),
            array('mobile', 'match', 'pattern' =>'/^8|(1[3|4|5|8][0-9]\d{4,8})$/', 'message' => '请输入正确的手机号码','on'=>'notbatch'),
            array('value', 'match', 'pattern' =>'/^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/', 'message' => '请输入8位整数积分','on'=>'batch'),
            array('value', 'match', 'pattern' =>'/^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/', 'message' => '请输入8位整数积分','on'=>'notbatch'),
            array('type, unit, is_recon,  num', 'numerical', 'integerOnly' => true, 'on' => 'special'),
            array('num', 'match', 'pattern' => '/^[1-9]\\d*$/', 'on' => 'special', 'message' => '请输入正确的数量'),
            array('value', 'match', 'pattern' => '/^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/', 'message' => '输入的格式不正确', 'on' => 'special'),
            array('member_id', 'comext.validators.isGaiNumber', 'message' => Yii::t('prepaidCard', '输出的编号不正确'), 'on' => 'special'),
            array('money, value', 'compare', 'operator' => '>', 'compareValue' => 0, 'except' => 'general'), // 必须大于 0
            array('money', 'decimalTypeValidator', 'length' => 8),
            array('value', 'decimalTypeValidator', 'length' => 9),
            array('value', 'match', 'pattern' => '/^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/', 'message' => '输入的格式不正确', 'on' => 'general'),
            array('sale_remark, sale_time', 'required', 'on' => 'sale'),
            array('sale_remark, sale_time', 'safe', 'on' => 'sale'),
            array('num, used, money, flag, value, type, member_id, unit, owner_id, version', 'safe'),
            array('owner_id', 'checkOwner', 'on' => 'special'),
            array('gaiNumber,mobile,number, member_id, owner_id, value, status, create_time, endTime, use_time, is_recon, maxValue', 'safe', 'on' => 'search'),
            array('gaiNumber,mobile,number, value, money,maxValue, status, create_time, endTime, is_recon, maxValue, status', 'safe', 'on' => 'searchList')
        );
    }

    /**
     * 验证拥有者
     * @param type $attribute
     * @param type $params
     */
    public function checkOwner($attribute, $params) {
        if ($this->owner_id) {
            $model = Member::model()->find('gai_number=:gw', array(':gw' => $this->owner_id));
            if ($model)
                $this->owner_id = $model->id;
            else
                $this->addError($attribute, Yii::t('prepaidCard', '不是有效的会员编号'));
        }
    }

    /**
     * 小数类型的验证
     * @param string $attribute
     * @param array $params
     */
    public function decimalTypeValidator($attribute, $params)
    {
        $limit = $params['length'];
        if (strlen(intval($this->$attribute)) > $limit) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('prepaidCard', '已超出限定'));
        }
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'mobile' => '手机号码',
            'number' => Yii::t('prepaidCard', '卡号'),
            'password' => Yii::t('prepaidCard', '密码'),
            'value' => Yii::t('prepaidCard', '积分'),
            'status' => Yii::t('prepaidCard', '状态'),
            'create_time' => Yii::t('prepaidCard', '创建时间'),
            'use_time' => Yii::t('prepaidCard', '使用时间'),
            'user_ip' => Yii::t('prepaidCard', '使用者IP'),
            'author_ip' => Yii::t('prepaidCard', '创建者IP'),
            'author_id' => Yii::t('prepaidCard', '创建者'),
            'type' => Yii::t('prepaidCard', '类型'),
            'author_name' => Yii::t('prepaidCard', '创建者'),
            'money' => Yii::t('prepaidCard', '金额'),
            'owner_id' => Yii::t('prepaidCard', '拥有者'),
            'sale_time' => Yii::t('prepaidCard', '出售时间'),
            'sale_remark' => Yii::t('prepaidCard', '备注'),
            'is_recon' => Yii::t('prepaidCard', '是否对账'),
            'recon_user' => Yii::t('prepaidCard', '对账人'),
            'recon_time' => Yii::t('prepaidCard', '对账时间'),
            'num' => Yii::t('prepaidCard', '数量'),
            'unit' => Yii::t('prepaidCard', '单位'),
            'member_id' => Yii::t('prepaidCard', '使用者'),
            'version' => Yii::t('prepaidCard', '制卡版本'),
            'gaiNumber' => Yii::t('prepaidCard', '盖网账号'),
        );
    }

    public function relations() {
        return array(
            'owner' => array(self::BELONGS_TO, 'Member', 'owner_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id')
        );
    }

    /**
     * 充值卡列表（后台）
     * @return CActiveDataProvider
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('number', $this->number);

        // 充值卡列表 或 积分返还充值卡列表
        if (($this->flag == PrepaidCard::TYPE_SPECIAL || $this->flag == PrepaidCard::TYPE_GENERAL) && $this->used == true) {
            $searchDate = Tool::searchDateFormat($this->use_time, $this->endTime);
            $criteria->compare('t.use_time', ">=" . $searchDate['start']);
            $criteria->compare('t.use_time', "<" . $searchDate['end']);
        }
        // 充值卡使用记录列表 或 积分返还充值卡使用列表
        if (($this->flag == PrepaidCard::TYPE_SPECIAL || $this->flag == PrepaidCard::TYPE_GENERAL) && !$this->used) {
            $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
            $criteria->compare('t.create_time', ">=" . $searchDate['start']);
            $criteria->compare('t.create_time', "<" . $searchDate['end']);
        }

        $criteria->compare('t.value', '>=' . $this->value);
        $criteria->compare('t.value', '<' . $this->maxValue);

        $criteria->with = array(
            'owner' => array(
                'select' => 'owner.gai_number'
            ),
            'member' => array(
                'select' => 'member.gai_number,member.mobile',
            ),
            
        );

        //手机号码
        if ($this->mobile) {            
            if ($member = Member::model()->find('mobile=:m', array(':m' => $this->mobile)))
                $criteria->compare('t.member_id', $member->id);
            else
                $criteria->compare('t.member_id', 0);
        }
        
        // 拥有者
        if ($this->owner_id) {
            if ($owner = Member::model()->find('gai_number=:gw', array(':gw' => $this->owner_id)))
                $criteria->compare('t.owner_id', $owner->id);
            else
                $criteria->compare('t.owner_id', 0);
        }

        // 使用者
        if ($this->member_id) {            
            if ($member = Member::model()->find('gai_number=:gw', array(':gw' => $this->member_id)))
                $criteria->compare('t.member_id', $member->id);
            else
                $criteria->compare('t.member_id', 0);
        }
        
//        if ($this->member_id) {            
//            if ($member = Member::model()->find('gai_number=:gw', array(':gw' => $this->member_id)))
//                $criteria->compare('t.member_id', $member->mobile);
//            else
//                $criteria->compare('t.member_id', 0);
//        }

        $criteria->compare('is_recon', $this->is_recon);
        $criteria->compare('t.status', $this->status);
        if ($this->used)
            $criteria->compare('t.status', self::STATUS_USED);
        $criteria->compare('t.type', $this->flag);

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
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * 充值卡列表（商家后台）
     * @return CActiveDataProvider
     */
    public function searchList() {
        $criteria = new CDbCriteria;
        $criteria->compare('number', $this->number);
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);
        $criteria->compare('value', '>=' . $this->value);
        $criteria->compare('value', '<=' . $this->maxValue);
        $criteria->compare('is_recon', $this->is_recon);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('owner_id', $this->owner_id);
        $criteria->compare('money', $this->money);
        
         // 导出excel
        $paginationList = array();
        if (!empty($this->isExport)) {
            $paginationList['pageVar'] = 'page';
            $paginationList['pageSize'] = $this->exportLimit;
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $paginationList,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * 保存前的操作
     * 创建充值时
     * 记录充值卡的类型
     */
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->getScenario() == 'general') {
                $card = self::generateCardInfo();
                $this->author_id = Yii::app()->user->id;
                $this->author_name = Yii::app()->user->name;
                $this->author_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
                $this->create_time = time();
                $this->number = $card['number'];
                $this->password = $card['password'];
                $this->status = self::STATUS_UNUSED;
                $this->type = self::TYPE_GENERAL;
                $this->version = 'v' . date('YmdHis', time());
            } elseif ($this->getScenario() == 'sale')
                $this->sale_time = strtotime($this->sale_time);

            return true;
        } else
            return false;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 生成充值卡账号及密码
     * @return array
     */
    public static function generateCardInfo() {
        return array(
            'number' => (rand(10, 99) . substr(microtime(), 2, 9)) + rand(100000, 999999),
            'password' => Tool::authcode(rand(10000000, 99999999))
        );
    }

    /**
     * 显示积分
     * @return string
     */
    public static function showScore($value) {
        return '<span class="jf">' . $value . '</span>';
    }

    /**
     * 显示金额
     * @return string
     */
    public static function showMoney($money, $score) {
        $value = $money > 0 ? $money : $score * 0.9;
        return '<span class="jf">¥' . $value . '</span>';
    }

    /**
     * 显示拥有者
     * @return string
     */
    public static function showOwner($model) {
        $string = '';
        if (isset($model->owner)) {
            $string .= $model->owner->gai_number;
            if ($model->is_recon)
                $string .= ' ( <span style="color: green">' . Yii::t("prepaidCard", "已对账") . '</span> ) ';
            else
                $string .= ' ( <span style="color: red">' . Yii::t("prepaidCard", "未对账") . '</span> ) ';
        } else
            $string .= Yii::t('prepaidCard', '无主');

        return $string;
    }

    /**
     * 显示选择框
     */
    public static function showCheckBox($model) {
        if (!$model->is_recon && isset($model->owner))
            return '<input value="' . $model->id . '" type="checkbox" name="selectRec[]">';
    }

    /**
     * 显示充值卡号，
     * 用于导出时
     */
    public static function showNumber($number) {
        return $number . ' ';
    }

}
