<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
 * @property string $id
 * @property string $logins
 * @property string $signins
 * @property string $gai_number
 * @property string $referrals_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $sex
 * @property string $real_name
 * @property integer $role_id
 * @property integer $type_id
 * @property integer $grade_id
 * @property string $password2
 * @property string $password3
 * @property string $birthday
 * @property string $email
 * @property string $mobile
 * @property string $country_id
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $register_time
 * @property integer $register_type
 * @property integer $is_enterprise
 * @property string $head_portrait
 * @property string $store_id
 * @property string $account_expense_cash
 * @property string $account_expense_nocash
 * @property string $account_discount
 * @property string $account_frozen
 * @property string $account_sign_in
 * @property integer $status
 * @property integer $is_internal
 * @property integer $is_master_account
 * @property integer $identity_type
 * @property string $identity_number
 * @property string $last_login_time
 * @property string $current_login_time
 * @property string $nickname
 * @property integer $member_type
 * @property string $card_num
 * @property string $area_code
 * @property string $NO
 */
class MemberAgent extends CActiveRecord
{
        public $account_expense_cash_end;           //查询使用
        public $account_expense_cash;
        public $memberType;							//会员类型
        public $defaultType,$officialType;			//正式会员消费会员
        public $enterpriseName,$enterpriseStreet,$create_time,$enterpriseMobile;    //企业会员使用     
        
        //会员类型（1消费会员，2正式会员）
        const MEMBER_USE = 1;                       //消费会员
        const MEMBER_NORMAL = 2;                    //正式会员
        
        //是否商家/企业会员（0不是，1是）
        const NOENTERPRISE = 0;                        //不是商家/企业
        const ISENTERPRISE = 1;                        //是商家/企业
        
        //证件类型（1未知，2身份证，3台胞证，4港澳证）
        const IDENTITY_TYPE_UNKNOWN = 0;            //未知证件类型
        const IDENTITY_TYPE_CARD = 1;               //身份证
        const IDENTITY_TYPE_TAIWAN = 2;             //台胞证
        const IDENTITY_TYPE_HK_MACAO = 3;           //港澳证
        
        //性别（1男，2女）
        const GENDER_MALE = 1;                      //性别男
        const GENDER_FEMALE = 2;                    //女
        
        //注册类型（1个人注册，2企业注册）
        const MEMBER_USER = 1;                      //个人会员
        const MEMBER_COMPANY = 2;                   //企业会员
        
        //会员状态(0待激活，1正常，2删除，3除名)
        const STATUS_WAIT = 0;                     
        const STATUS_NORMAL = 1;                    
        const STATUS_DEL = 2;                       
        const STATUS_CLEAR = 3;                     
        
        //注册类型（0默认，1盖网机，2盖网，3手机短信，4手机APP）
        const REG_TYPE_DEFAULT = 0;
        const REG_TYPE_MACHINE = 1;
        const REG_TYPE_WEBSITE = 2;
        const REG_TYPE_MESSAGE = 3;
        const REG_TYPE_APP = 4;

    
        
        /**
         * 获取是否是企业
         * @param int $key
         * @return string
         */
        public static function _getStoreType($key = NULL){
            $storeType =  array(
                self::NOENTERPRISE => Yii::t('Member','否'),
                self::ISENTERPRISE => Yii::t('Member','是'),
            );
            return $key === NULL ? $storeType : $storeType[$key];
        }
        
        /**
         * 获取是否是企业  用enterprise_id
         * @param int $key
         * @return string
         */
        public static function getStoreTypeNew($key=0){
            return $key==0 ? Yii::t('Member','否') : Yii::t('Member','是');
        }
        
        
        /**
         * 获取证件类型
         */
        public static function _getIdentityType($key = NULL){
            $identityType = array(
                self::IDENTITY_TYPE_UNKNOWN =>  Yii::t('Member','未知'),
                self::IDENTITY_TYPE_CARD =>  Yii::t('Member','身份证'),
                self::IDENTITY_TYPE_TAIWAN => Yii::t('Member','台胞证'),
                self::IDENTITY_TYPE_HK_MACAO => Yii::t('Member','港澳证'),
            );
            return $key === NULL ? $identityType : $identityType[$key];
        }
        
        /**
         * 性别
         * @param null}int $key
         * @return array|null
         */
        public static function _getSex($key = null) {
            $sex = array(
                self::GENDER_MALE => Yii::t('Member', '男'),
                self::GENDER_FEMALE => Yii::t('Member', '女'),
            );
            return $key === NULL ? $sex : $sex[$key];
        }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('username,mobile,identity_type,identity_number,real_name,sex,birthday','required','on'=>self::MEMBER_USER),
                        array('username,mobile,identity_number','unique','on'=>self::MEMBER_USER),
                        array('mobile', 'comext.validators.isMobile', 'errMsg' => '请输入正确的手机号码'),
                    
                        array('username,mobile','required','on'=>self::MEMBER_COMPANY),
                        array('is_master_account','safe','on'=>self::MEMBER_COMPANY),
                        array('mobile','unique'),
//                        array('mobile','checkMobile' ,'on'=>self::MEMBER_COMPANY),
                    
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logins, signins, gai_number, referrals_id, username, password, salt, sex, real_name, role_id, type_id, grade_id, password2, password3, birthday, email, mobile, country_id, province_id, city_id, district_id, street, register_time, register_type, is_enterprise, head_portrait, store_id, account_expense_cash, account_expense_nocash, account_sign_in, status, is_internal, is_master_account, identity_type, identity_number, last_login_time, current_login_time, nickname, member_type, card_num, area_code, NO', 'safe', 'on'=>'search'),
		);
	}
	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'MemberType' => array(self::BELONGS_TO, 'MemberType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键id',
			'logins' => '登录次数',
			'signins' => '签到次数',
			'gai_number' => Yii::t('Member','盖网编号'),
			'referrals_id' => '推荐人',
			'username' => Yii::t('Member','用户名'),
			'password' => '密码',
			'salt' => '唯一密钥',
			'sex' => Yii::t('Member','性别'),
			'real_name' => Yii::t('Member','真实姓名'),
			'role_id' => '角色',
			'type_id' => Yii::t('Member','类型'),
			'grade_id' => '级别',
			'password2' => '二级密码',
			'password3' => '三级密码',
			'birthday' => Yii::t('Member','生日'),
			'email' => '邮箱',
			'mobile' => Yii::t('Member','手机号码'),
			'country_id' => '国家',
			'province_id' => '省份',
			'city_id' => '城市',
			'district_id' => '区/县',
			'street' => '详细地址',
			'register_time' => '注册时间',
			'register_type' => '注册类型（0默认，1盖网机，2盖网，3手机短信，4手机APP）',
			'is_enterprise' => '是否商家（0否，1是）',
			'head_portrait' => '头像',
			'store_id' => '所属商家',
			'account_expense_cash' => '兑现金额',
			'account_expense_nocash' => '消费金额',
			'account_discount' => '折扣金额',
			'account_frozen' => '冻结金额',
			'account_sign_in' => '签到金额',
			'status' => '状态（0待激活，1正常，2删除，3除名）',
			'is_internal' => '内部会员（0否，1是）',
			'is_master_account' => '是否主账号（0否，1是）',
			'identity_type' => Yii::t('Member','证件类型'),
			'identity_number' => Yii::t('Member','证件号码'),
			'last_login_time' => '上次登录时间',
			'current_login_time' => '当前登录时间',
			'nickname' => '昵称',
			'member_type' => 'member_type',
			'card_num' => 'card_num',
			'area_code' => 'area_code',
			'NO' => '这是测试用字段，开发人员不用管理--刘万云',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $criteria->select = "t.id,t.gai_number,t.username,t.mobile,t.type_id,CONCAT(a.`name`,' ',b.`name`,' ',c.`name`) as street,t.register_time,t.enterprise_id,m.name as memberType,n.name as enterpriseName,n.mobile as enterpriseMobile,CONCAT(e.`name`,' ',f.`name`,' ',g.`name`) as enterpriseStreet,n.create_time";
        $criteria->join = "left join ".MemberType::model()->tableName()." m on m.id = t.type_id ";
        $criteria->join .= "left join ".Enterprise::model()->tableName()." n on n.id = t.enterprise_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." a on a.id = t.province_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." b on b.id = t.city_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." c on c.id = t.district_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." e on e.id = n.province_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." f on f.id = n.city_id ";
        $criteria->join.= "left join ".Region::model()->tableName()." g on g.id = n.district_id ";
        
//        $criteria->with = array(
//        	'MemberType' => array('select'=>'name')
//        );

        $criteria->addInCondition('status', array(self::STATUS_NORMAL, self::STATUS_WAIT));
        
		$criteria->compare('gai_number',trim($this->gai_number),true);
//		$criteria->compare('username',trim($this->username),true);
//		$criteria->compare('t.mobile',trim($this->mobile),true);
                if($this->mobile != ""){
                    $sqlMobile = "t.mobile like '%".trim($this->mobile)."%' or n.mobile like '%".$this->mobile."%'";
                    $criteria->addCondition($sqlMobile);
                }
                if($this->username != ""){
                    $sql = "t.username like '%".trim($this->username)."%' or n.name like '%".trim($this->username)."%'";
                    $criteria->addCondition($sql);
                }
		
		$criteria->addCondition('referrals_id='.Yii::app()->user->id);
		if($this->account_expense_cash!='' || $this->account_expense_cash_end!=''){
        	$criteria->join.= "left join ".ACCOUNT.".gw_account_balance ac on (ac.account_id = t.id and ac.type =".AccountBalance::TYPE_CONSUME.")";
		}

        $criteria->order = 'register_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
             'pagination' => array(
             'pageSize' => 10
             ),
		));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function afterFind() {
            parent::afterFind();
            $this->register_time = date('Y-m-d H:i:s',  $this->register_time);
            $this->create_time = date('Y-m-d H:i:s',  $this->create_time);
            $this->birthday = date('Y-m-d', $this->birthday);
        }
        
        /**
        * 生成唯一的会员编号 GW+8位数字
        * @return string
        */
        public function generateGaiNumber() {
            $number = str_pad(mt_rand('1', '99999999'), GAI_NUMBER_LENGTH, mt_rand(99999, 999999));
            if ($this->exists('gai_number="GW' . $number . '"')) {
                $this->generateGaiNumber();
            }
            return 'GW' . $number;
        }
       
        /**
         * 生成的密码哈希.
         * @param string $password
         * @return string $hash
         */
        public function hashPassword($password) {
            return CPasswordHelper::hashPassword($password . $this->salt);
        }
    
        public function beforeSave() {
            if (parent::beforeSave()) {
                if ($this->isNewRecord) {
                    $this->gai_number = $this->generateGaiNumber();
                    $this->register_time = time();
                    $this->salt = Tool::generateSalt();
                    $this->password = $this->hashPassword($this->password);
                    $this->type_id = self::MEMBER_USE;          //消费会员
                    $this->status = self::STATUS_NORMAL;
                    $this->register_type = self::REG_TYPE_DEFAULT;
                    $this->referrals_id = Yii::app()->user->id;	//推荐人
                }
                $this->birthday = strtotime($this->birthday);
                if ($this->scenario == self::MEMBER_COMPANY) {              //如果是企业注册
                    $this->is_enterprise = self::ISENTERPRISE;
                }
                return true;
            }
            return false;
        }
}
