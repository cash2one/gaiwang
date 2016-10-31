<?php

/**
 *  商家的会员信息表 模型
 * @author zhenjun.xu<412530435@qq.com>
 * The followings are the available columns in table '{{enterprise}}':
 * @property string $id
 * @property string $name
 * @property string $short_name
 * @property string $street
 * @property string $link_man
 * @property string $link_phone
 * @property string $mobile
 * @property string $email
 * @property integer $department
 * @property string $service_start_time
 * @property string $service_end_time
 * @property string $create_time
 * @property integer $auditing
 * @property integer $signing_type
 * @property string $service_id  招商人员服务编号
 * @property int $enterprise_type  商户类型(0:企业，1:个体工商户)
 * @property int $flag
 * @property int $apply_cash_limit  申请提现状态
 */
class Enterprise extends CActiveRecord {

    //总冻结金额，搜索用
    public $total_freeze_money;
    public $end_total_freeze_money;
    public $gai_number;
    public static $oldModelData;
    public $member_id;
    public $end_create_time;
    public $au_time;
    public $cat_name;
    public $agree;
    public $progress;
    public $store_id;
    public $el_status;  //审核记录的审核状态
    public $store_name;  //店铺名称
    public $store_status;  //店铺状态
    public $mode;  //网店是否收费

    const MIN_APPLY = 100; //默认的最小提现金额
    const DEPARTMENT_OTHER = 0;
    const DEPARTMENT_OFFICE = 1;
    const DEPARTMENT_MARKET = 2;
    const DEPARTMENT_PURCHASE = 3;
    const DEPARTMENT_TECHNOLOGY = 4;
    const DEPARTMENT_HR = 5;
    const AUDITING_ROLE_ZHAOSHANG = 1;  //审核角色招商
    const AUDITING_ROLE_FAWU = 2;   //审核角色法务
    /**
     * 商户类型(0:企业，1:个体工商户)
     */
    const TYPE_ENTERPRISE = 0;
    const TYPE_INDIVIDUAL = 1;

    /**
     * 标记，区分线下、线上。线上的商家需要网签，线下的可以在后台添加企业会员
     */
    const FLAG_OFFLINE = 1; //线下
    const FLAG_ONLINE = 2;  //线上

    /**
     * 提现限制
     */
    const APPLY_CASH_LIMIT_YES = 1;
    const APPLY_CASH_LIMIT_NO = 0;

    /**
     * @param null $k
     * @return array|null
     */
    public static function getApplyCashList($k=null){
        $arr = array(
            self::APPLY_CASH_LIMIT_NO => Yii::t('enterprise', '开启'),
            self::APPLY_CASH_LIMIT_YES => Yii::t('enterprise', '禁止'),
        );
        if ($k == null)
            return $arr;
        return isset($arr[$k]) ? $arr[$k] : null;
    }

    /**
     * 商户类型
     * @param null $k
     * @return array|null
     */

    public static function getEnterpriseType($k = null) {
        $arr = array(
            self::TYPE_ENTERPRISE => Yii::t('enterprise', '企业'),
            self::TYPE_INDIVIDUAL => Yii::t('enterprise', '个体工商户'),
        );
        if ($k == null)
            return $arr;
        return isset($arr[$k]) ? $arr[$k] : null;
    }

    /**
     * 所属部门
     * @param null $key
     * @return array|null
     */
    public static function departmentArr($key = null) {
        $arr = array(
            self::DEPARTMENT_OFFICE => Yii::t('enterprise', '办公室'),
            self::DEPARTMENT_MARKET => Yii::t('enterprise', '市场部'),
            self::DEPARTMENT_PURCHASE => Yii::t('enterprise', '采购部'),
            self::DEPARTMENT_TECHNOLOGY => Yii::t('enterprise', '技术部'),
            self::DEPARTMENT_HR => Yii::t('enterprise', '人力资源'),
            self::DEPARTMENT_OTHER => Yii::t('enterprise', '其它'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const AUDITING_NO = 1;
    const AUDITING_YES = 2;
    const AUDITING_NO_PASS = 3;

    /**
     * 审核状态数组
     * @param $key
     * @return array|null
     */
    public static function auditingArr($key = null) {
        $arr = array(
            self::AUDITING_NO => Yii::t('enterprise', '未审核'),
            self::AUDITING_YES => Yii::t('enterprise', '已审核'),
            self::AUDITING_NO_PASS => Yii::t('enterprise', '审核未通过'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const SIGNING_TYPE_OLD = 1;
    const SIGNING_TYPE_SERVICE_FEE = 0;

    /**
     * 审核状态数组
     * @param $key
     * @return array|null
     */
    public static function getSigningType($key = null) {
        $arr = array(
            self::SIGNING_TYPE_OLD => Yii::t('enterprise', '以旧形式签约'),
            self::SIGNING_TYPE_SERVICE_FEE => Yii::t('enterprise', '服务费形式签约'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return self::getTableName();
    }

    public static function getTableName(){
        return '{{enterprise}}';
    }

    /**
     * @return array validation rules for model attributes.
     * 场景说明：
     * register：企业注册
     * updateEnterprise：网签
     */
    public function rules() {
        return array(
            array('service_id', 'match', 'pattern' => '/^G[0-9]{6,15}$/'),
            array('name,street,
        	link_phone,department,service_start_time,service_end_time,auditing,
        	signing_type', 'required', 'on' => 'create,update'),
            //array('category_id','required','on'=>'register','message'=>'经营类目必选'),
            array('department,mobile,street', 'required',
                'on' => 'enterpriseCreate'),
            array('department,mobile,street,signing_type', 'required',
                'on' => 'enterpriseUpdate'),
            array('province_id, city_id, district_id', 'required',
                'on' => 'enterpriseCreate,enterpriseUpdate,update_base,update,create',
                'message' => Yii::t('enterprise', Yii::t('enterprise', '请选择 {attribute}'))),
            array('email', 'email'),
            array('link_man', 'length', 'max' => 50, 'min' => 2),
            array('link_man', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\s]+$/u',
                'message' => Yii::t('enterprise', '{attribute} 只能由中文、英文、数字及下划线、空格组成')),
            array('link_phone', 'match', 'pattern' => '/^\d{3,4}-\d{7,8}(-\d{3,4})?$/',
                'message' => Yii::t('enterprise', '固话格式错误，请输入如0777-4783550'), 'on' => 'enterpriseCreate'),
            array('mobile', 'comext.validators.isMobile',
                'on' => 'enterpriseCreate,enterpriseUpdate,update_base',
                'errMsg' => Yii::t('enterprise', '请输入正确的您的手机号码')),
            array('short_name', 'length', 'max' => 20),
            //后台企业会员添加
            array('name', 'required', 'on' => 'enterpriseCreate,enterpriseUpdate'),
            array('service_start_time,service_end_time', 'required', 'on' => 'enterpriseCreate,enterpriseUpdate'),
            array('service_end_time', 'comext.validators.compareDateTime', 'compareAttribute' => 'service_start_time', 'allowEmpty' => true,
                'operator' => '>', 'on' => 'enterpriseCreate,enterpriseUpdate', 'message' => Yii::t('member', '服务结束时间 必须大于 服务开始时间')),
            //会员中心修改
            array('short_name,province_id,city_id, district_id,street,link_man,department', 'required', 'on' => 'update_base'),
            array('department, auditing', 'numerical', 'integerOnly' => true),
            array('province_id, city_id, district_id, create_time', 'length', 'max' => 11),
            array('name, street, link_man, email', 'length', 'max' => 128),
            array('link_phone, mobile', 'length', 'max' => 32),
            array('name, create_time, auditing', 'safe', 'on' => 'search'),
            array('total_freeze_money,end_total_freeze_money,gai_number', 'safe'),
            //网签
            array('name', 'unique'),          
            array('name','comext.validators.isGaiNumber','message'=>'公司名称不能使用GW号','isGaiNumber'=>false),  //网签公司名称不能使用GW号
            array('name,link_phone,link_man,province_id,city_id,district_id,street', 'required', 'on' => 'enterpriseLog'),
            array('name,link_phone,end_create_time,service_start_time,service_end_time,province_id,city_id,district_id,street,agree,progress', 'safe'),
            array('agree', 'required', 'on' => 'enterpriseLog', 'message' => Yii::t('member', '未同意盖象商城管理规定')),
            array('store_name,store_status,apply_cash_limit', 'safe'),
            array('name,street,link_man,link_phone', 'filter', 'filter' => array('CHtml', 'encode')),
        );
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (!empty($this->service_start_time) && !is_numeric($this->service_start_time))
                $this->service_start_time = strtotime($this->service_start_time);
            if (!empty($this->service_end_time) && !is_numeric($this->service_end_time))
                $this->service_end_time = strtotime($this->service_end_time);

            if (!empty($this->license_start_time) && !is_numeric($this->license_start_time))
                $this->license_start_time = strtotime($this->license_start_time);
            if (!empty($this->license_end_time) && !is_numeric($this->license_end_time))
                $this->license_end_time = strtotime($this->license_end_time);

            return true;
        }
        return false;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'member' => array(self::HAS_ONE, 'Member', 'enterprise_id'),
            'enterpriseData' => array(self::HAS_ONE, 'EnterpriseData', 'enterprise_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('enterprise', '主键'),
            'name' => Yii::t('enterprise', '公司名称'),
            'short_name' => Yii::t('enterprise', '公司简称'),
            'license' => Yii::t('enterprise', '营业执照号码'),
            'license_photo' => Yii::t('enterprise', '营业执照号电子版'),
            'province_id' => Yii::t('enterprise', '省份'),
            'city_id' => Yii::t('enterprise', '城市'),
            'district_id' => Yii::t('enterprise', '区/县'),
            'street' => Yii::t('enterprise', '详细地址'),
            'link_man' => Yii::t('enterprise', '联系人'),
            'link_phone' => Yii::t('enterprise', '固话'),
            'mobile' => Yii::t('enterprise', '手机号码'),
            'email' => Yii::t('enterprise', '邮箱'),
            'department' => Yii::t('enterprise', '所属部门'),
            'service_start_time' => Yii::t('enterprise', '服务开始时间'),
            'service_end_time' => Yii::t('enterprise', '服务结束时间'),
            'create_time' => Yii::t('enterprise', '创建时间'),
            'auditing' => Yii::t('enterprise', '审核状态'),
            'signing_type' => Yii::t('enterprise', '签约类型'),
            'member_id' => Yii::t('enterprise', '所属会员'),
            'business_scope' => Yii::t('enterprise', '法定经营范围'),
            'organization' => Yii::t('enterprise', '组织机构代码'),
            'organization_image' => Yii::t('enterprise', '组织机构代码证电子版'),
            'tax_id' => Yii::t('enterprise', '税务登记证号'),
            'taxpayer_id' => Yii::t('enterprise', '纳税人识别号'),
            'tax_image' => Yii::t('enterprise', '税务登记证电子版'),
            'license_start_time' => Yii::t('enterprise', '营业执照有效期'),
            'license_end_time' => Yii::t('enterprise', '营业执照有效期'),
            'agree' => Yii::t('member', '同意《盖象商城管理规定》'),
            'last_log_id' => Yii::t('enterprise', '对应最新的审核进度的id'),
            'store_name' => Yii::t('enterprise', '店铺名称'),
            'store_status' => Yii::t('enterprise', '店铺状态'),
            'service_id' => Yii::t('enterprise', '招商人员服务编号'),
            'enterprise_type' => Yii::t('enterprise', '商户类型'),
            'apply_cash_limit' => Yii::t('enterprise', '申请提现状态'),
        );
    }


    /**
     * 后台列表
     * @return \CActiveDataProvider
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('auditing', $this->auditing);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    /**
     * 后台列表   电子版审核列表
     * @return \CActiveDataProvider
     */
    public function searchDzb($role = self::AUDITING_ROLE_ZHAOSHANG) {
        $criteria = new CDbCriteria;
        $criteria->compare('s.name', $this->store_name, true);
        $criteria->compare('el.status', $this->auditing);
        $criteria->compare('s.id','>0');
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
        $criteria->compare('el.create_time', ">=" . $searchDate['start']);
        $criteria->compare('el.create_time', "<" . $searchDate['end']);


        $criteria->select = ' t.*,el.create_time as au_time,el.status as el_status,el.progress ,s.category_id,
        cat.name as cat_name,s.name as store_name,s.mode';
        $criteria->join = ' LEFT JOIN {{enterprise_log}} AS el ON t.last_log_id=el.id ';
        $criteria->join .= ' LEFT JOIN {{member}} AS m ON m.enterprise_id=t.id ';
        $criteria->join .= ' LEFT JOIN {{store}} AS s ON m.id=s.member_id ';
        $criteria->join .= ' LEFT JOIN {{category}} AS cat ON s.category_id=cat.id ';

        if ($role == self::AUDITING_ROLE_ZHAOSHANG) {
            $criteria->compare('el.progress', EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG);
        } elseif ($role == self::AUDITING_ROLE_FAWU) {
            $criteria->compare('el.progress', EnterpriseLog::PROCESS_CHECK_INFO_FAWU);
        }

        $criteria->group = 't.id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 'el.id DESC',
            ),
        ));
    }

    /**
     * 后台列表   纸质版审核列表
     * @return \CActiveDataProvider
     */
    public function searchZzb($role = self::AUDITING_ROLE_ZHAOSHANG) {
        $criteria = new CDbCriteria;
        $criteria->compare('s.name', $this->store_name, true);
        $criteria->compare('s.id','>0');
        $criteria->compare('el.status', $this->auditing);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
        $criteria->compare('el.create_time', ">=" . $searchDate['start']);
        $criteria->compare('el.create_time', "<" . $searchDate['end']);


        $criteria->select = ' t.*,el.create_time as au_time,el.status as el_status,el.progress ,s.category_id,
        cat.name as cat_name,s.name as store_name,s.mode';
        $criteria->join = ' LEFT JOIN {{enterprise_log}} AS el ON t.last_log_id=el.id ';
        $criteria->join .= ' LEFT JOIN {{member}} AS m ON m.enterprise_id=t.id ';
        $criteria->join .= ' LEFT JOIN {{store}} AS s ON m.id=s.member_id ';
        $criteria->join .= ' LEFT JOIN {{category}} AS cat ON s.category_id=cat.id ';

        if ($role == self::AUDITING_ROLE_ZHAOSHANG) {
            $criteria->compare('el.progress', EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG);
        } elseif ($role == self::AUDITING_ROLE_FAWU) {
            $criteria->compare('el.progress', EnterpriseLog::PROCESS_CHECK_PAPER_FAWU);
        }

        $criteria->group = 't.id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 'el.id DESC',
            ),
        ));
    }

    /**
     * 后台列表   纸质版审核列表
     * @return \CActiveDataProvider
     */
    public function searchFinish() {
        $criteria = new CDbCriteria;
        $criteria->compare('s.name', $this->store_name, true);
        $criteria->compare('t.auditing', $this->auditing);
        $criteria->compare('s.id','>0');
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
        $criteria->compare('el.create_time', ">=" . $searchDate['start']);
        $criteria->compare('el.create_time', "<" . $searchDate['end']);


        $criteria->select = ' t.*,el.create_time as au_time,el.status as el_status,el.progress ,s.category_id,
        cat.name as cat_name,s.name as store_name,s.mode';
        $criteria->join = ' LEFT JOIN {{enterprise_log}} AS el ON t.last_log_id=el.id ';
        $criteria->join .= ' LEFT JOIN {{member}} AS m ON m.enterprise_id=t.id ';
        $criteria->join .= ' LEFT JOIN {{store}} AS s ON m.id=s.member_id ';
        $criteria->join .= ' LEFT JOIN {{category}} AS cat ON s.category_id=cat.id ';

        $criteria->compare('el.progress', EnterpriseLog::PROCESS_LAST_OK);

        $criteria->group = 't.id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 'el.id DESC',
            ),
        ));
    }

    /**
     * 后台列表   开店管理列表
     * @return \CActiveDataProvider
     */
    public function searchStore() {
        $criteria = new CDbCriteria;
        $criteria->compare('s.name', $this->store_name, true);
        $criteria->compare('t.auditing', $this->auditing);
        $criteria->compare('t.link_man', $this->link_man);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
        $criteria->compare('el.create_time', ">=" . $searchDate['start']);
        $criteria->compare('el.create_time', "<" . $searchDate['end']);
        $criteria->compare('s.status', $this->store_status);

        $criteria->select = 't.id,t.name,t.link_man,t.enterprise_type,el.create_time as au_time,el.status as el_status,el.progress ,
        s.category_id,cat.name as cat_name,s.mobile,s.name as store_name,s.status as store_status,mode';
        $criteria->join = ' LEFT JOIN {{enterprise_log}} AS el ON t.last_log_id=el.id ';
        $criteria->join .= ' LEFT JOIN {{member}} AS m ON m.enterprise_id=t.id ';
        $criteria->join .= ' LEFT JOIN {{store}} AS s ON m.id=s.member_id ';
        $criteria->join .= ' LEFT JOIN {{category}} AS cat ON s.category_id=cat.id ';


        $criteria->addCondition('el.progress>=' . EnterpriseLog::PROCESS_CHECK_INFO_FAWU_OK.' and s.id>0');


        $criteria->group = 't.id';



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 'el.id DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->signing_type = self::SIGNING_TYPE_SERVICE_FEE; // 凡新注册的企业会员，均为服务费签约类型
                $this->create_time = time();
                if (empty($this->auditing))
                    $this->auditing = self::AUDITING_NO;
            } else {
                if ($this->getScenario() == 'enterpriseUpdate' &&
                        self::$oldModelData->signing_type == self::SIGNING_TYPE_SERVICE_FEE
                ) {
                    $this->signing_type = self::SIGNING_TYPE_SERVICE_FEE;
                }
                // 编辑企业会员将签约类型依照老类型，待开放再去掉 2014/06/24 jianlin
                //////$this->signing_type = self::SIGNING_TYPE_OLD;
            }
            return true;
        }
        return false;
    }

    public function afterSave() {
        parent::afterSave();
        // 如果旧的数据签约类型不相等
        $oldModel = self::$oldModelData;
        if (!empty($oldModel) && $oldModel->signing_type != self::SIGNING_TYPE_SERVICE_FEE && $oldModel->signing_type != $this->signing_type) {
            // 下架该商家的所有商品
            if ($this->revocationAllGoods()) {
                $typeText = self::getSigningType($this->signing_type);
                @SystemLog::record(Yii::app()->user->name . "修改商家{$this->name}签约类型为{$typeText}，该商家所有商品下架！");
            }
        }
    }

    /**
     * 商家所有商品下架
     */
    private function revocationAllGoods() {
        $sql = "SELECT id FROM  {{store}} where member_id=:mid ";
        $enterpriseRow = Yii::app()->db->createCommand($sql)->bindValue(':mid', $this->member->id)->queryColumn();
        if (!empty($enterpriseRow)) {
            $criteria = new CDbCriteria();
            if (count($enterpriseRow) > 1) {
                $criteria->addInCondition('store_id', $enterpriseRow);
            } else {
                $criteria->compare('store_id', $enterpriseRow[0]);
            }
            return Goods::model()->updateAll(array('is_publish' => Goods::PUBLISH_NO, 'status' => Goods::STATUS_NOPASS), $criteria);
        }
    }

    /**
     * 通过会员id  获取企业会员信息id
     * @return type
     */
    public static function getEnterpriseId($orderId) {
        //查询商家id
        $enterprise_id = Order::model()->find(array('select' => 'enterprise_id', 'condition' => 'id=' . $orderId))->enterprise_id;
        $member_id = Member::model()->find(array('select' => 'id', 'condition' => 'enterprise_id=' . $enterprise_id))->id;
        $enterpriseId = self::model()->find(array('select' => 'id', 'condition' => 'member_id =' . $member_id));
        return !$enterpriseId ? '' : $enterpriseId->id;
    }

    /**
     * 把要支付的金额转给商家
     * @param type $orderId
     */
    public static function payGaiPrice($orderId) {
        $cash = OrderGoods::CountgaiPrice($orderId);
        $enterpriseId = self::getEnterpriseId($orderId);
        $trans = Yii::app()->db->beginTransaction();
        try {
            $enterprise = new Enterprise;
            if (!$enterprise->updateByPk($enterpriseId, array('cash' => 'cash' + $cash)))
                throw new Exception('转账失败');
            $trans->commit(); //事务提交 
            return true;
        } catch (Exception $e) {
            $trans->rollback(); //回滚
            return false;
        }
    }

    /**
     * @var float 账户余额，冻结金额用
     */
    public $cash;

    /**
     * 冻结金额搜索
     * @return CActiveDataProvider
     */
    public function searchFreeze() {
        $c = new CDbCriteria;
        $c->compare('t.name', $this->name, true, 'or');
        $c->compare('m.gai_number', $this->name, true, 'or');
        $c->compare('total_freeze_money', '>=' . $this->total_freeze_money);
        $c->compare('total_freeze_money', '<=' . $this->end_total_freeze_money);

        $c->select = 't.id,m.gai_number,m.mobile,t.name,ifnull(b.cash,0.00) as cash, ifnull(f.total_freeze_money,0.00) as total_freeze_money';
        $c->join = 'left join {{member}} AS m ON t.member_id = m.id';
        $c->join .= ' left join ( SELECT sum(money) AS total_freeze_money, enterprise_id FROM {{freeze}} WHERE
         `status` = ' . Freeze::STATUS_FREEZE . ' GROUP BY enterprise_id ) AS f ON f.enterprise_id = t.id';
        $c->join .= ' left join (select sum(today_amount) as cash,account_id from account.gw_account_balance
          where `type` in(' . AccountBalance::TYPE_AGENT . ',' . AccountBalance::TYPE_MERCHANT . ')) as b on b.account_id=t.member_id';

        return new CActiveDataProvider($this, array(
            'criteria' => $c,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public function getHotelEnterprise() {
//        $memberIdArr = Yii::app()->db->createCommand()
//                ->select('member_id')
//                ->from('{{hotel_provider}}')
//                ->queryColumn();
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,t.name,m.id as member_id';
        $criteria->join = 'left join {{member}} m on t.id = m.enterprise_id';
        $criteria->condition = 'm.status=:status';
        $criteria->params = array(':status' => Member::STATUS_NORMAL);
//        $criteria->addNotInCondition('m.id', $memberIdArr);
        if ($this->name) {
            $criteria->compare('t.name', $this->name, true);
            $criteria->compare('m.gai_number', $this->name, true, 'OR');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, // 分页
            ),
        ));
    }

    //获取推荐者会员号
    public static function getReferrals($referralsId) {
        $referrals = Member::model()->find('id=:referrals_id', array(':referrals_id' => $referralsId));
        return !$referrals ? '无推荐者' : $referrals->gai_number;
    }

    /**
     * 获取企业信息
     *     tips : 电子化签约专用
     * 
     * @param  interge   $enterpriseId 企业id
     * @return mixed
     */
    public static function getEnterpriseInfo($enterpriseId){

        $enterpriseInfo = Yii::app()->db->createCommand()
            ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,ed.organization')
            ->from(Enterprise::model()->tableName() . ' as e')
            ->leftJoin(EnterpriseData::model()->tableName() . ' as ed','e.id = ed.enterprise_id')
            ->where('e.id=:id',array(':id'=>$enterpriseId))->queryRow();

        return empty($enterpriseInfo) ? null : $enterpriseInfo;
    }

}
