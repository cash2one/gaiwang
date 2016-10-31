<?php

/**
 *  商家的会员信息表 模型
 * @author zhenjun.xu<412530435@qq.com>
 * The followings are the available columns in table '{{enterprise}}':
 * @property string $id
 * @property string $member_id
 * @property integer $category_id
 * @property string $name
 * @property string $short_name
 * @property string $license
 * @property string $license_photo
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
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
 * @property string $cash
 * @property string $recon_cycle
 * @property string $min_apply
 */
class EnterpriseAgent extends CActiveRecord {

    const DEPARTMENT_OTHER = 0;
    const DEPARTMENT_OFFICE = 1;
    const DEPARTMENT_MARKET = 2;
    const DEPARTMENT_PURCHASE = 3;
    const DEPARTMENT_TECHNOLOGY = 4;
    const DEPARTMENT_HR = 5;
    
    public $categoryname;

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
            self:: AUDITING_NO => Yii::t('enterprise', '未审核'),
            self::AUDITING_YES => Yii::t('enterprise', '已审核'),
            self::AUDITING_NO_PASS => Yii::t('enterprise', '审核未通过'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{enterprise}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name,short_name,category_id,license,license_photo,province_id,city_id,district_id,street,link_man,department,mobile,service_start_time,service_end_time','required'),
            array('name,','length','max'=>50),
            array('short_name,license','length','max'=>20),
            array('street','length','max'=>255),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('enterprise', '请输入正确的您的手机号码')),
            array('mobile', 'length', 'max' => 16),
            array('email', 'email'),
            array('service_end_time','comext.validators.compareDateTime','compareAttribute'=>'service_start_time','allowEmpty'=>true,
                'operator'=>'>','message'=>Yii::t('member','服务结束时间 必须大于 服务开始时间')),
//            array('license_photo', 'file', 'types' => 'jpg,gif,png,bmp', 'maxSize' => 1024 * 1024 * 2,
//                'tooLarge' => Yii::t('enterprise', '文件大于2M，上传失败！请上传小于2M的文件！')),
            
            array('id, member_id, category_id, name, short_name, license, license_photo, province_id, city_id,
                district_id, street, link_man, link_phone, mobile, email, department, service_start_time,
                service_end_time, create_time, auditing, cash, recon_cycle,min_apply', 'safe', 'on'=>'search'),
            );
	}

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (!empty($this->service_start_time))
                $this->service_start_time = strtotime($this->service_start_time);
            if (!empty($this->service_end_time))
                $this->service_end_time = strtotime($this->service_end_time);
            return true;
        }
        return false;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('enterprise','主键'),
			'member_id' => Yii::t('enterprise','所属会员'),
			'category_id' => Yii::t('Member','所属分类'),
			'name' => Yii::t('Member','公司名称'),
			'short_name' => Yii::t('Member','公司简称'),
			'license' => Yii::t('Member','营业执照'),
			'license_photo' => Yii::t('Member','执照图片'),
			'province_id' => Yii::t('enterprise','省份'),
			'city_id' => Yii::t('enterprise','城市'),
			'district_id' => Yii::t('enterprise','区/县'),
			'street' => Yii::t('Member','详细地址'),
			'link_man' => Yii::t('Member','联系人'),
			'link_phone' => Yii::t('enterprise','固话'),
			'mobile' => Yii::t('Member','手机号码'),
			'email' => Yii::t('Member','邮箱'),
			'department' => Yii::t('Member','所属部门'),
			'service_start_time' => Yii::t('Member','服务开始时间'),
			'service_end_time' => Yii::t('Member','服务结束时间'),
			'create_time' => Yii::t('enterprise','创建时间'),
			'auditing' => Yii::t('enterprise','审核状态'),
			'cash' => Yii::t('enterprise','金额'),
			'recon_cycle' => Yii::t('enterprise','RECON_CYCLE'),
			'min_apply' => Yii::t('enterprise','最小提现金额'),
		);
	}

    /**
	 * 查询企业会员申请列表
	 */
	public function search(){
		$criteria=new CDbCriteria;

		$categoryTableName = StoreCategory::model()->tableName();
		$memberTableName = MemberAgent::model()->tableName();
		
        $criteria->select = "(select c.name from $categoryTableName c where c.id = t.category_id) as categoryname,t.name,t.create_time,t.auditing";
        $criteria->compare('name', $this->name, true);
        $criteria->addCondition('m.referrals_id='.Yii::app()->user->id);
        $criteria->addCondition('m.id= t.member_id');
        $criteria->join = ",$memberTableName m";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 9, //分页
            ),
            'sort' => false,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
                $this->auditing = self::AUDITING_NO;
                $this->cash = 0;
            }
            return true;
        }
        return false;
    }
}
