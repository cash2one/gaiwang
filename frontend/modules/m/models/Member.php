<?php

/**
 *  会员 模型
 * @author zhenjun.xu<412530435@qq.com>
 *
 * The followings are the available columns in table '{{member}}':
 * @property string $id
 * @property integer $logins
 * @property string $signins
 * @property string $gai_number
 * @property string $referrals_id
 * @property string $tmp_referrals_id
 * @property string $mobileVerifyCode
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $sex
 * @property string $real_name
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
 * @property string $head_portrait
 * @property string $enterprise_id
 * @property integer $status
 * @property integer $is_internal
 * @property integer $is_master_account
 * @property integer $identity_type
 * @property string $identity_number
 * @property string $last_login_time
 * @property string $current_login_time
 * @property string $referrals_time
 */
class Member extends CActiveRecord {

    public $hasReferrals; //是否有主  用于搜索  by csj
    public $searchKeyword; //用于多条件搜索  by csj
    public $isExport; //是否导出excel
    public $exportPageName = 'page'; //导出excel起始
    public $exportLimit = 5000; //导出excel长度
//	public $exportCount;		//总数
    //代理使用
    public $apply_type; //申请类型
    public $author_name; //申请人
    public $author_type; //申请人类型
    public $submit_time; //申请提交时间
    public $audit_opinion; //审核意见

    /**
     * @var string 确认密码
     */
    public $confirmPassword;

    /**
     * @var string 旧密码
     */
    public $oldPassword;
    public $verifyCode;
    public $agree;
    public $mobileVerifyCode;

    /**
     * @var string 推荐人会员号临时变量，不存数据库
     */
    public $tmp_referrals_id;
    public $cash; //可提现金额，查询使用
    public $cashUse; //消费金额 查询使用
    public $search_all = false; //标记是否搜索全部
    //修改绑定手机
    public $mobile2;
    public $mobileVerifyCode2;

//是否内部会员

    const INTERNAL_NO = 0;
    const INTERNAL = 1;
    //拆分gw后的角色
    const ROLE_ONLINE = 0; //线上、消费 默认
    const ROLE_OFFLINE = 1; //线下
    const ROLE_AGENT = 2;   //代理
    const ROLE_KW = 3; //kw 会员
    const ROLE_OFFLINE_CONSUMER = 4; //线下消费
    const CACHEDIR = 'member';

    /**
     * @return array  是否内部会员
     */
    public static function internal() {
        return array(
            self::INTERNAL_NO => Yii::t('member', '非内部会员'),
            self::INTERNAL => Yii::t('member', '内部会员')
        );
    }

//注册类型（0默认，1盖网机，2盖网，3手机短信，4手机APP）

    const REG_TYPE_DEFAULT = 0;
    const REG_TYPE_MACHINE = 1;
    const REG_TYPE_WEBSITE = 2;
    const REG_TYPE_MESSAGE = 3;
    const REG_TYPE_APP = 4;
    const REG_TYPE_ROUTER = 5;

    /** 注册类型
     * @param null|number $key
     * @return array|null
     */
    public static function registerType($key = null) {
        $arr = array(
            self::REG_TYPE_DEFAULT => Yii::t('member', '默认'),
            self::REG_TYPE_MACHINE => Yii::t('member', '盖机'),
            self::REG_TYPE_WEBSITE => Yii::t('member', '盖网通'),
            self::REG_TYPE_MESSAGE => Yii::t('member', '手机短信'),
            self::REG_TYPE_APP => Yii::t('member', '手机APP'),
            self::REG_TYPE_ROUTER => Yii::t('member', '路由'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    /**
     * @var int $is_enterprise 临时变量，判断是否企业会员
     */
    public $is_enterprise;

    const ENTERPRISE_NO = 0;
    const ENTERPRISE_YES = 1;

    /**
     * 是否商家
     * @param null|number $key
     * @return null|string|array
     */
    public static function isEnterprise($key = null) {
        $arr = array(
            self::ENTERPRISE_NO => Yii::t('member', '否'),
            self::ENTERPRISE_YES => Yii::t('member', '是'),
        );
        if ($key == null) {
            return $arr;
        } else {
            return $key > 0 ? $arr[self::ENTERPRISE_YES] : $arr[self::ENTERPRISE_NO];
        }
    }

    const IDENTITY_TYPE_UNKNOWN = 0;
    const IDENTITY_TYPE_CARD = 1;
    const IDENTITY_TYPE_TAIWAN = 2;
    const IDENTITY_TYPE_HK_MACAO = 3;
    const IDENTITY_TYPE_JUNGUAN = 4;

    /**
     * 证件类型
     * @param null|int $key
     * @return array|null
     */
    public static function identityType($key = null) {
        $arr = array(
            self::IDENTITY_TYPE_UNKNOWN => Yii::t('member', '未知'),
            self::IDENTITY_TYPE_CARD => Yii::t('member', '身份证'),
            self::IDENTITY_TYPE_TAIWAN => Yii::t('member', '台胞证'),
            self::IDENTITY_TYPE_HK_MACAO => Yii::t('member', '港澳证'),
            self::IDENTITY_TYPE_JUNGUAN => Yii::t('member', '军官证'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * 性别
     * @param null }int $key
     * @return array|null
     */
    public static function gender($key = null) {
        $arr = array(
            self::GENDER_MALE => Yii::t('member', '男'),
            self::GENDER_FEMALE => Yii::t('member', '女'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const STATUS_NO_ACTIVE = 0;
    const STATUS_NORMAL = 1;
    const STATUS_DELETE = 2;
    const STATUS_REMOVE = 3;

    /**
     * 会员状态
     * @param $key
     * @return array|null
     */
    public static function status($key = null) {
        $arr = array(
            self::STATUS_NO_ACTIVE => Yii::t('member', '待激活'),
            self::STATUS_NORMAL => Yii::t('member', '正常'),
            self::STATUS_DELETE => Yii::t('member', '删除'),
            self::STATUS_REMOVE => Yii::t('member', '除名'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const IS_MASTER_ACCOUNT = 1;
    const NO_MASTER_ACCOUNT = 0;

    /** 是否主账户
     * @param null $k
     * @return array
     */
    public static function masterAccount($k = null) {
        $arr = array(
            self::IS_MASTER_ACCOUNT => Yii::t('member', '是'),
            self::NO_MASTER_ACCOUNT => Yii::t('member', '否'),
        );
        return isset($arr[$k]) ? $arr[$k] : $arr;
    }

    public function tableName() {
        return '{{member}}';
    }

    public $rules = array(); //验证规则,用于动态修改验证规则

    /**
     * @return array validation rules for model attributes.
     */

    public function rules() {
        $rules = array(
            //array('referrals_id', 'required', 'on' => 'updateRecommend'), //修改推荐人
            array('referrals_time', 'safe', 'on' => 'updateRecommend'), //修改推荐人
            //修改绑定手机
            array('mobileVerifyCode,mobileVerifyCode2,mobile2', 'required', 'on' => 'updateMobile'),
            array('mobileVerifyCode', 'comext.validators.mobileVerifyCode', 'on' => 'updateMobile,mRegister'),
            array('mobileVerifyCode2', 'comext.validators.mobileVerifyCode2', 'on' => 'updateMobile'),
            array('mobile2', 'compare', 'compareAttribute' => 'mobile', 'operator' => '!=', 'on' => 'updateMobile'),
            array('mobile2', 'unique', 'attributeName' => 'mobile', 'on' => 'updateMobile'),
            array('mobile2', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码'), 'on' => 'updateMobile'),
//修改头像
            array('head_portrait', 'required', 'on' => 'update_avatar', 'message' => Yii::t('member', '请选择上传图片')),
            array('head_portrait', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => Yii::t('member', '文件大于5M，上传失败！请上传小于5M的文件！'), 'on' => 'update_avatar', 'allowEmpty' => true),
            //企业注册时候，使用 会员名 作为公司名称来验证
            array('username', 'required', 'on' => 'enterpriseCreate', 'message' => Yii::t('member', '公司名称 不可为空白')),
            array('username', 'unique', 'on' => 'enterpriseCreate', 'message' => Yii::t('member', '该企业名已注册！')),
            array('username', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\(\)（）]+$/u', 'on' => 'enterpriseCreate',
                'message' => Yii::t('member', '公司名称 只能由中文、英文、数字及下划线组成')),
            array('username', 'required', 'on' => 'create,update'), //不确定
//注册
            array('verifyCode', 'comext.validators.requiredExt', 'allowEmpty' => !CCaptcha::checkRequirements(),
                'message' => Yii::t('member', '{attribute} 不能为空！'), 'on' => 'register,quickRegister'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'captchaAction' => 'captcha2', 'on' => 'register'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'quickRegister'),
            array('password', 'required', 'on' => 'register,mRegister,mResetPassword'),
            array('password,confirmPassword', 'required', 'on' => 'regEnterprise'),
            array('agree', 'required', 'on' => 'regEnterprise', 'message' => Yii::t('member', '未同意盖网用户入住协议')),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'regEnterprise,resetPassword'),
            array('tmp_referrals_id', 'comext.validators.isGaiNumber', 'on' => 'register,regEnterprise,quickRegister'),
            array('tmp_referrals_id', 'exist', 'attributeName' => 'gai_number', 'className' => 'Member', 'on' => 'register,regEnterprise,quickRegister'),
            //验证手机号码
            array('mobile,mobileVerifyCode', 'required', 'on' => 'regEnterprise,registerStep2,update_base,bind,register,mRegister,mResetPassword,mSetMobile'),
            array('mobileVerifyCode', 'comext.validators.mobileVerifyCode',
                'on' => 'regEnterprise,registerStep2,update_base,bind,register,mRegister,,mResetPassword,mSetMobile'),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码'),
                'on' => 'regEnterprise,resetPassword,resetPassword2,resetPassword3,registerStep2,update_base,register,mRegister,mResetPassword,mSetMobile'),
            //快速手机号注册,重置密码
            array('mobile', 'exist', 'attributeName' => 'mobile', 'className' => 'Member', 'on' => 'resetPassword,mResetPassword',
                'message' => Yii::t('member', '{value} 没有在盖网注册使用过')),
            array('mobile,mobileVerifyCode', 'required',
                'on' => 'resetPassword,resetPassword2,resetPassword3'),
            array('mobileVerifyCode', 'comext.validators.mobileVerifyCode',
                'on' => 'resetPassword,resetPassword2,resetPassword3'),
            array('password,confirmPassword', 'required', 'on' => 'resetPassword'),
            //后台普通会员添加,前台修改基本信息
            array('mobile,identity_type,identity_number,real_name,sex,identity_type', 'required', 'on' => 'create,update'),
            array('mobile', 'required', 'on' => 'update_base'),
            //后台企业会员添加
//            array('referrals_id', 'required', 'on' => 'enterpriseCreate,enterpriseUpdate'),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码'), 'on' => 'enterpriseCreate,enterpriseUpdate,update_base,update,create,mResetPassword'),
            //修改二、三级密码
            array('password2,confirmPassword', 'required', 'on' => 'resetPassword2'),
            array('password3,confirmPassword', 'required', 'on' => 'resetPassword3'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password2', 'on' => 'resetPassword2'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password3', 'on' => 'resetPassword3'),
            array('password', 'length', 'max' => 128, 'min' => 6),
            //array('gai_number', 'unique'),
            array('mobile', 'comext.validators.mobileUnique', 'on' => 'regEnterprise,enterpriseCreate,register,create,update,update_base,enterpriseUpdate,insert,registerStep2'),
            array('email', 'email'),
            array('username,email', 'unique', 'on' => 'enterpriseCreate,register,create,update,update_base,enterpriseUpdate'),
            array('username', 'length', 'max' => 50, 'min' => 3, 'on' => 'enterpriseCreate,register,create,update,update_base,enterpriseUpdate'),
            array('username', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\(\)（）]+$/u',
                'message' => Yii::t('member', '{attribute} 只能由中文、英文、数字及下划线组成'),
                'on' => 'enterpriseCreate,quickRegister,create,update,update_base,enterpriseUpdate'),
            array('sex, type_id, grade_id, register_type, status, is_internal, is_master_account, identity_type', 'numerical', 'integerOnly' => true),
            array('logins, signins, referrals_id, birthday, province_id, city_id, district_id, register_time, enterprise_id, last_login_time, current_login_time', 'length', 'max' => 11),
            array('gai_number', 'length', 'max' => 32),
            array('username, password, salt, real_name, password2, password3, email, street, identity_number', 'length', 'max' => 128),
            array('mobile', 'length', 'max' => 16),
            array('id, logins, signins, gai_number, referrals_id, username, password, salt, sex, real_name,
             type_id, grade_id, password2, password3, birthday, email, mobile, province_id, city_id,
             district_id, street, register_time, register_type, head_portrait, enterprise_id,
              status, is_internal, is_master_account, identity_type, identity_number, last_login_time,
              current_login_time,hasReferrals,search_keyword,birthday,exportPage,exportLimit,search_all,referrals_time', 'safe', 'on' => 'search'),
            //验证证件号码
//            array('identity_number', 'check_identity_number', 'on' => 'update_base'),
            array('identity_number', 'check_identity_number', 'on' => 'update'),
            //红包列表绑定手机号码
            array('mobile','unique','message'=>Yii::t('member', '{attribute}此号码已经使用过了'),'on'=>'bind'),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码'), 'on' => 'bind'),
            //快速注册
            array('username','unique','on'=>'quickRegister'),
            array('username','required','on'=>'quickRegister'),
            array('password', 'required', 'on' => 'quickRegister'),
            //微商城绑定手机号
            array('gai_number', 'required', 'on' => 'mSetMobile'),
            //微商城注册
            array('mobile','unique','on' => 'mRegister','message' => Yii::t('member', '该手机号已被注册')),
        );
        if (!empty($this->rules)) {
            $rules = array_merge($this->rules, $rules);
        }
        return $rules;
    }

    /**
     * 检查各种证件是否正确
     * Enter description here ...
     */
    public function check_identity_number($attribute, $params) {
        $preg = '';
        switch ($this->identity_type) {
            case self::IDENTITY_TYPE_UNKNOWN:
                $preg = '/^[A-Za-z0-9]{5,20}$/';
                break;

            case self::IDENTITY_TYPE_CARD:
                $preg = '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/';
                break;

            case self::IDENTITY_TYPE_JUNGUAN:
                $preg = '/.+字第[0-9]{7,8}号/';
                break;

            case self::IDENTITY_TYPE_TAIWAN:
                $preg = '/^[a-zA-Z]([0-9]{9})$/';
                break;

            case self::IDENTITY_TYPE_HK_MACAO:
                $preg = '/^[A-Z]\d{8}$/';
                break;

            default:
                $preg = '/^[A-Za-z0-9]{5,20}$/';
                break;
        }

        if (!preg_match($preg, $this->identity_number)) {
            $this->addError($attribute, Yii::t('member', '请输入正确的证件号码'));
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'memberType' => array(self::BELONGS_TO, 'MemberType', 'type_id'),
            'enterprise' => array(self::BELONGS_TO, 'Enterprise', 'enterprise_id'),
            'bankAccount' => array(self::HAS_ONE, 'BankAccount', 'member_id'),
            'region' => array(self::HAS_MANY, 'Region', 'member_id'), //代理商，@author:lc
            'referrals' => array(self::BELONGS_TO, 'Member', 'referrals_id'), //会员的推荐者，@author:LC
//            'childagent' => array(self::HAS_ONE, 'Member', 'pid', 'on' => 'childagent.role = 2'),
//            'childoffline' => array(self::HAS_ONE, 'Member', 'pid', 'on' => 'childoffline.role = 1'),
            'franchisee' => array(self::HAS_ONE, 'Franchisee', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'confirmPassword' => Yii::t('member', '确认密码'),
            'verifyCode' => Yii::t('member', '验证码'),
            'agree' => Yii::t('member', '同意《盖网用户入驻协议》'),
            'mobileVerifyCode' => Yii::t('member', '手机验证码'),
            'id' => Yii::t('member', '主键id'),
            'logins' => Yii::t('member', '登录次数'),
            'signins' => Yii::t('member', '签到次数'),
            'gai_number' => Yii::t('member', '盖网编号'),
            'referrals_id' => Yii::t('member', '推荐人会员号'),
            'tmp_referrals_id' => Yii::t('member', '推荐人会员号'),
            'username' => Yii::t('member', '用户名'),
            'password' => Yii::t('member', '密码'),
            'salt' => Yii::t('member', '唯一密钥'),
            'sex' => Yii::t('member', '性别'),
            'real_name' => Yii::t('member', '真实姓名'),
            'type_id' => Yii::t('member', '会员类型'),
            'grade_id' => Yii::t('member', '会员级别'),
            'password2' => Yii::t('member', '二级密码'),
            'password3' => Yii::t('member', '三级密码'),
            'birthday' => Yii::t('member', '出生日期'),
            'email' => Yii::t('member', '邮箱'),
            'mobile' => Yii::t('member', '手机号码'),
            'country_id' => Yii::t('member', '国家'),
            'province_id' => Yii::t('member', '省份'),
            'city_id' => Yii::t('member', '城市'),
            'district_id' => Yii::t('member', '区/县'),
            'street' => Yii::t('member', '详细地址'),
            'register_time' => Yii::t('member', '注册时间'),
            'register_type' => Yii::t('member', '注册类型'), //（0默认，1盖网机，2盖网，3手机短信，4手机APP）
            'head_portrait' => Yii::t('member', '头像'),
            'enterprise_id' => Yii::t('member', '所属企业'),
            'status' => Yii::t('member', '状态'), //（0待激活，1正常，2删除，3除名）
            'is_internal' => Yii::t('member', '内部会员'),
            'is_master_account' => Yii::t('member', '是否主账号'), //（0否，1是）
            'identity_type' => Yii::t('member', '证件类型'),
            'identity_number' => Yii::t('member', '证件号码'),
            'last_login_time' => Yii::t('member', '上次登录时间'),
            'current_login_time' => Yii::t('member', '当前登录时间'),
            'mobile2' => Yii::t('member', '新绑定手机'),
            'mobileVerifyCode2' => Yii::t('member', '新的验证码'),
            'referrals_time' => Yii::t('member', '更新推荐人时间'),
            'nickname' => Yii::t('member', '昵称')
        );
    }

    /**
     * 本类 search() 方法 中array_filter的回调函数
     * @param $v
     * @return bool
     */
    public static function FilterEmpty($v) {
        return $v == '' ? false : true;
    }
    
    //同步注册到盖讯通
    public static function mGetRegister($gaiNumber,$password,$nickname,$mobile,$passswordKey) {
    //post方式
        $ch = curl_init ();
        $url = IP_BIT.'/backji/gwUser/userReg';//地址
        $data = 'gwAccount='.$gaiNumber.'&userPassword='.$password.'&userNickname='.$nickname.'&mobile='.$mobile.'&passwordKey='.$passswordKey;//post参数
        curl_setopt ( $ch, CURLOPT_URL, $url );//获取URL地址
        curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交        
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);//POST的内容
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );//在页面输出结果，true为不输出，false为输出
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 5 );//等待时间

        $file_contents = curl_exec ( $ch );
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close ( $ch );
//        return json_decode($file_contents,true);
        unset($ch); 
    }    
    
    //同步修改密码到盖讯通
    public static function mGetUpdatePassword($gaiNumber,$password,$passswordKey) {
        //post方式
        $ch = curl_init ();
        $url = IP_BIT.'/backji/gwUser/updatePassword';//地址
        $data = 'gwAccount='.$gaiNumber.'&password='.$password.'&passwordKey='.$passswordKey;//post参数
        curl_setopt ( $ch, CURLOPT_URL, $url );//获取URL地址
        curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交        
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);//POST的内容
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );//在页面输出结果，true为不输出，false为输出
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 5 );//等待时间

        $file_contents = curl_exec ( $ch );
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close ( $ch );
//        return json_decode($file_contents,true);
        unset($ch); 
    }

    /**
     * 会员搜索
     * @param null $auditing 审核状态过滤
     * @return CActiveDataProvider
     */
    public function search($auditing = null) {
        $criteria = new CDbCriteria;
        //▪ 会员列表 无搜索条件，则显示空白
        if ($auditing != Enterprise::AUDITING_NO) {
            if (!isset($_GET['Member']) || (isset($_GET['Member']) && array_filter($_GET['Member'], 'Member::FilterEmpty') == array())) {
                $criteria->addCondition('t.id=0');
            }
        }
        $criteria->compare('t.gai_number', $this->gai_number, true);
        $criteria->compare('t.referrals_id', $this->referrals_id, true);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.sex', $this->sex);
        $criteria->compare('t.real_name', $this->real_name, true);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.grade_id', $this->grade_id);
        $criteria->compare('t.birthday', $this->birthday, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.mobile', $this->mobile, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.district_id', $this->district_id);
        $criteria->compare('t.street', $this->street, true);
        $criteria->compare('t.register_time', $this->register_time, true);
        $criteria->compare('t.register_type', $this->register_type);
        $criteria->compare('t.head_portrait', $this->head_portrait, true);
        $criteria->compare('t.enterprise_id', $this->enterprise_id, true);

        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.is_internal', $this->is_internal);
        $criteria->compare('t.is_master_account', $this->is_master_account);
        $criteria->compare('t.identity_type', $this->identity_type);
        $criteria->compare('t.identity_number', $this->identity_number, true);
        $criteria->compare('t.last_login_time', $this->last_login_time, true);
        $criteria->compare('t.current_login_time', $this->current_login_time, true);
        //只能搜索普通会员
        $criteria->compare('t.enterprise_id','0');

        //搜索是否无主
        if ($this->hasReferrals == 'false')
            $criteria->compare('t.referrals_id', '<>0');
        if ($this->hasReferrals == 'true')
            $criteria->compare('t.referrals_id', 0);
        //连表查询 会员类型
        $criteria->select = 't.*,y.name as type_id';
        $criteria->join = 'left join {{member_type}} as y on(t.type_id=y.id)';


        $pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 'id DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 获取会员搜索列表
     * @return CActiveDataProvider
     */
    public function getUserSearch() {
        $criteria = new CDbCriteria;

        if ($this->searchKeyword) {
            //@author LC
            $criteria->addCondition("(username like '%$this->searchKeyword%' or gai_number like '%$this->searchKeyword%' or mobile like '%$this->searchKeyword%')");
        }
//        $criteria->compare('username', $this->searchKeyword, true);
//        $criteria->compare('gai_number', $this->searchKeyword, true, 'or');
//        $criteria->compare('mobile', $this->searchKeyword, true, 'or');



        if ($this->is_enterprise) {
            $criteria->addCondition('t.enterprise_id>0');
        }


        $pagination = array();
        if (!empty($this->search_all))
            false;
        if (!empty($this->search_all))
            $pagination['pageSize'] = 99999000;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
        ));
    }

    /**
     * 获取会员指定日期的注册记录
     * @author huabin_hong
     * @return CActiveDataProvider
     */
    public function getDayReg() {
        $criteria = new CDbCriteria();
        $criteria->select = "t.username,t.gai_number,t.mobile,FROM_UNIXTIME(t.register_time,'%Y-%m-%d %H:%i:%s') as register_time,
    	t.register_type,b.gai_number as referrals_id";
        $criteria->compare("t.register_time", ">=" . $this->register_time);
        $criteria->compare("t.register_time", "<=" . ($this->register_time + 86399));
        $criteria->join = " left join " . self::tableName() . " b on b.id = t.referrals_id";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 12, //分页
            ),
            'sort' => false,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->gai_number = $this->generateGaiNumber();
                $this->register_time = time();
                $this->salt = Tool::generateSalt();
                $this->password = $this->hashPassword($this->password);
                if (empty($this->type_id)) { //前台注册的，设置默认type_id
                    $defaultVal = MemberType::fileCache();
                    $this->type_id = $defaultVal['defaultType'];
                }
//根据GW盖网编号，查找推荐会员id
                if (!empty($this->tmp_referrals_id)) {
                    $result = $this->findByAttributes(array('gai_number' => $this->tmp_referrals_id));
                    if ($result) {
                        $this->referrals_id = $result->id;
                    }
                }
            }
//修改密码
            if ($this->scenario == 'updatePassword' || $this->scenario == 'enterpriseUpdate' || $this->scenario == 'resetPassword') {
                if (!empty($this->password)) {
                    //$this->salt = Tool::generateSalt();
                    $this->password = $this->hashPassword($this->password);
                } else {
                    $this->password = $this->oldPassword;
                }
            }
//修改二级密码
            if ($this->scenario == 'resetPassword2') {
                //$this->salt = Tool::generateSalt();
                $this->password2 = $this->hashPassword($this->password2);
            }
//修改二级密码
            if ($this->scenario == 'resetPassword3') {
                //$this->salt = Tool::generateSalt();
                $this->password3 = $this->hashPassword($this->password3);
            }

            //处理生日
            if (!is_int($this->birthday) && !empty($this->birthday))
                @$this->birthday = strtotime($this->birthday);

            return true;
        }
        return false;
    }

    /**
     * 生成唯一的会员编号 GW+8位数字
     * @return string
     */
    public function generateGaiNumber() {
        $number = str_pad(mt_rand('1', '99999999'), GAI_NUMBER_LENGTH, mt_rand(99999, 999999));
        if ($this->exists('gai_number="GW' . $number . '"')) {
            return $this->generateGaiNumber();
        }
        return 'GW' . $number;
    }

    /**
     * 检测输入的密码是否正确
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password . $this->salt, $this->password);
    }

    /**
     * 检测输入的二级密码是否正确
     * @param string $password
     * @return boolean
     */
    public function validatePassword2($password) {
        return CPasswordHelper::verifyPassword($password . $this->salt, $this->password2);
    }

    /**
     * 检测输入的三级密码是否正确
     * @param string $password
     * @return boolean
     */
    public function validatePassword3($password) {
        return CPasswordHelper::verifyPassword($password . $this->salt, $this->password3);
    }

    /**
     * 生成的密码哈希.
     * @param string $password
     * @return string $hash
     */
    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password . $this->salt);
    }

    /**
     * 查询会员名称
     * @param string $username 会员名称
     * @param mixed $select @use CDbCommand->select()
     * @return array 返回匹配会员名称的数据
     */
    public function queryUserName($username, $select = '*') {
        $command = Yii::app()->db->createCommand();
        $data = $command->select($select)->from('{{member}}')->where(array('OR', array('like', 'username', "%$username%"), array('like', 'real_name', "%$username%")))->queryAll();
        return $data;
    }

    /**
     * 个人资料完成程度百分比
     * @return float
     */
    public function infoPercent() {
        $infoArr = array(
            empty($this->username) ? 0 : 1,
            empty($this->sex) ? 0 : 1,
            empty($this->real_name) ? 0 : 1,
            empty($this->password2) ? 0 : 1,
            empty($this->password3) ? 0 : 1,
            empty($this->birthday) ? 0 : 1,
            empty($this->email) ? 0 : 1,
            empty($this->mobile) ? 0 : 1,
            empty($this->province_id) ? 0 : 1,
            empty($this->street) ? 0 : 1,
            empty($this->head_portrait) ? 0 : 1,
            empty($this->identity_number) ? 0 : 1,
        );
        return intval(array_sum($infoArr) / count($infoArr) * 100);
    }

    /**
     * 计算会员可支出的金额
     * @return $allCount 总共积分=提现金额+消费金额
     */
    public static function getAccount() {
        $user_id = Yii::app()->user->id;
        /** @var Member $data */
        $data = self::model()->findByPk($user_id);
//        Tool::pr($data);
        $allCount = $data->getTotalNoCashNew();
        return $allCount ? $allCount : '';
    }

    /**
     * 比较会员的 提现积分 和 消费积分
     * 优先使用提现积分支付
     * 如果提现积分少于要支付的积分.就要去判断消费积分
     * 如果消费积分也不够支付.就得判断总共是否能够支付
     * @param int $payAccount 要支付的积分
     */
    public static function compareAccount($payAccount) {
        $user_id = Yii::app()->user->id;
        $data = self::model()->findByPk($user_id);
        $amount = $data->account_expense_cash + $data->account_expense_nocash; //两个账户合计的积分
        //这是一种情况
        if ($data->account_expense_cash >= $payAccount) {
            echo '用提现积分支付';
        } else {
            if ($data->account_expense_nocash >= $payAccount) {
                echo '如果提现积分不足,而消费积分足的话,就用消费积分支付';
            } elseif ($amount >= $payAccount) {
                //如果两个账户合计的积分够支付的操作.1.优先扣除 提现积分账户 2.剩下的用消费积分补
                $account1 = $payAccount - $data->account_expense_nocash; //要补的差价
                $account2 = $data->account_expense_nocash - $account1; //在消费积分里要扣的积分
            }
        }
    }

    /**
     * 我的账户积分
     * @param Member $model
     * @return array
     */
    public static function account($model) {
        $account = array();
        $account['money'] = $model->getTotalNoCashNew();
        $account['integral'] = Common::convertSingle($account['money'], $model->type_id);
        $account['freeze'] = Common::convertSingle($model->getTotalFreezeCashNew(), $model->type_id);
        $account['red'] = RedEnvelopeTool::getRedAccount($model->id);
        return $account;
    }

    /*
     * 会员统计，每天运行一次，用于后台统计 昨天的数据
     */

    public static function staticMember() {
        $startDay = strtotime(date('Y-m-d 00:00:00')) - 86400; //昨天的开始时间
        $endDay = $startDay + 86399; //昨天的结束时间
        //当天 注册人数 新增企业会员数
        $sql = "select count(1) as num,register_type from {{member}} where register_time between $startDay and $endDay group by register_type";
        $resisterTotal = Yii::app()->db->createCommand($sql)->queryAll();

        $resisterArr = array(
            'phone' => 0, //通过手机注册
            'website' => 0, //通过网站
            'machine' => 0, //通过盖机
            'total' => 0, //总数
        );
        foreach ($resisterTotal as $row) {
            if ($row['register_type'] == self::REG_TYPE_MESSAGE) {
                $resisterArr['phone'] += $row['num'];
            }
            if ($row['register_type'] == self::REG_TYPE_WEBSITE) {
                $resisterArr['website'] += $row['num'];
            }
            if ($row['register_type'] == self::REG_TYPE_MACHINE) {
                $resisterArr['machine'] += $row['num'];
            }
            $resisterArr['total'] += $row['num'];
        }

        //昨天注册企业会员数
        $lastComSql = "select count(1) from {{member}} where register_time between $startDay and $endDay";
        $lastCom = Yii::app()->db->createCommand($lastComSql)->queryScalar();

        //会员总数 各类型会员总数
        $sql = "select count(1) as num,type_id from {{member}} group by type_id";
        $memberTotal = Yii::app()->db->createCommand($sql)->queryAll();

        $memberArr = array(
            'total' => 0, //会员总数
            'regular' => 0, //正式会员
            'consume' => 0, //消费会员
        );

        foreach ($memberTotal as $row) {
            if ($row['type_id'] == MemberType::MEMBER_EXPENSE) {
                $memberArr['consume'] += $row['num'];
            }
            if ($row['type_id'] == MemberType::MEMBER_OFFICAL) {
                $memberArr['regular'] += $row['num'];
            }
            $memberArr['total'] += $row['num'];
        }


        //企业会员总数
        $comSql = "select count(1) from {{member}} where enterprise_id>0";
        $comRes = Yii::app()->db->createCommand($comSql)->queryScalar();


        //当天登录次数，不去重复
        $sqlLogin = "select count(1) from {{member}} where last_login_time between $startDay and $endDay";
        $loginRes = Yii::app()->db->createCommand($sqlLogin)->queryScalar();

        //当天登录次数，去重复
        $sqlLogin2 = "select count(distinct id) from {{member}} where last_login_time between $startDay and $endDay";
        $loginRes2 = Yii::app()->db->createCommand($sqlLogin2)->queryScalar();


//        //前天的结束时间
//        $twoDays = $endDay - 86400*30;
//        $sql3 = "select sum(logins) from {{member}} where last_login_time <= $twoDays";
//        $res3 = Yii::app()->db->createCommand($sql3)->queryScalar();
//        $sql4 = "select sum(logins) from {{member}} where last_login_time <= $endDay";
//        $res4 = Yii::app()->db->createCommand($sql4)->queryScalar();

        $time = time();
        //插入数据表
        $insertSql = "insert into {{member_day}} values ('','" . $resisterArr['total'] . "','" . $resisterArr['phone'] . "','" . $resisterArr['website'] . "','" . $resisterArr['machine'] . "','$lastCom'," .
            " '" . $memberArr['total'] . "','$comRes','" . $memberArr['regular'] . "','" . $memberArr['consume'] . "','$loginRes','$loginRes2','$startDay','$time')";

        if (Yii::app()->st->createCommand($insertSql)->execute()) {
            echo '数据插入成功';
        }
    }

    /**
     * 根据手机号来判断会员来获取会员
     * @author lc
     */
    public static function getMemberByPhone($userPhone) {
        $return = array();
        $whereStr = 'mobile=:mobile and is_master_account=:ima and `status`<=:status';
        $whereParam = array(':mobile' => $userPhone, ':ima' => '1', ':status' => Member::STATUS_NORMAL);
        //计算主账号个数
        $masterCount = Yii::app()->db->createCommand()
            ->select(array('count(1) as num'))
            ->from('{{member}}')
            ->where($whereStr, $whereParam)
            ->queryScalar();
        if ($masterCount) {
            if ($masterCount == 1) {
                $return = Yii::app()->db->createCommand()
                    ->from('{{member}}')
                    ->where($whereStr, $whereParam)
                    ->queryRow();
            } else {
                // 提示设置主账号
                $return = Yii::t('member', '主账号只能设置一个,请重新设置主账号!');
            }
        } else {
            // 查找非主账号
            $whereParam[':ima'] = '0';
            $count = Yii::app()->db->createCommand()
                ->select(array('count(1) as num'))
                ->from('{{member}}')
                ->where($whereStr, $whereParam)
                ->queryScalar();
            if ($count) {
                if ($count == 1) {
                    $return = Yii::app()->db->createCommand()
                        ->from('{{member}}')
                        ->where($whereStr, $whereParam)
                        ->queryRow();
                } else {
                    // 提示设置主账号
                    $return = Yii::t('member', '您有多个账号存在,请设置一个主账号!');
                }
            } else {
                // 没有账号
                $return = Yii::t('member', '账号不存在!');
            }
        }
        return $return;
    }

    /**
     * 根据id取所有账号，包括子账号及父账号
     */
    public static function getAllMembers($member_id, $cache = false) {
        $enterprise = self::model()->findByPk($member_id);
        if (empty($enterprise))
            return false;

        $cache_id = self::CACHEDIR . '_m_' . $member_id;
        if ($cache) {
            //读取缓存
            $rs = Tool::cache(self::CACHEDIR)->get($cache_id);
            if (!empty($rs))
                return $rs;
        }

        $rs = array();
        $rs[$enterprise->id] = $enterprise;
//        if (!empty($enterprise->pid)) {
//            $father_info = self::model()->findByPk($enterprise->pid);
//            $rs[$father_info->id] = $father_info;
//        }
//
//        $sons_info = self::model()->findAll("pid={$member_id}");
//        if (!empty($sons_info)) {
//            foreach ($sons_info as $son) {
//                $rs[$son->id] = $son;
//            }
//        }

        if ($cache) {
            //写入缓存
            Tool::cache(self::CACHEDIR)->set($cache_id, $rs, 300);
        }

        return $rs;
    }

    /**
     * 会员中心提现时显示线下商家中未对账的订单金额总额
     * @param int $id 会员ID
     * @return float $money 待对账的订单的商家应获得的供货价金额
     * @deprecated gaiwang 后不用
     */
    public static function unreconciledCash($id) {
        $members = Yii::app()->db->createCommand()->select('id')->from('{{member}}')->where('id=:id', array(':id' => $id))->queryAll();
        if (!$members)
            return array();
        $ids = array();
        foreach ($members as $value)
            array_push($ids, $value['id']);
        array_push($ids, $id);

        $frans = Yii::app()->db->createCommand()->select('id')->from('{{franchisee}}')->where('member_id in (' . implode(',', $ids) . ')')->queryAll();
        if (!$frans)
            return array();
        $fids = array();
        foreach ($frans as $value)
            array_push($fids, $value['id']);

        $result = Yii::app()->db->createCommand()
            ->select('sum(spend_money-distribute_money) AS money')
            ->from('{{franchisee_consumption_record}}')
            ->where('franchisee_id in (' . implode(',', $fids) . ')')
            ->andWhere('status=:status', array(':status' => FranchiseeConsumptionRecord::STATUS_NOTCHECK))
            ->queryRow();

        return $result['money'];
    }

    /**
     * 取会员总金额，旧系统和新系统金额相加
     */
    public function getTotalNoCashNew() {
        if (empty($this->gai_number))
            return false;

        $new_gai_cash = AccountBalance::getTodayAmountByGaiNumber($this->gai_number);
        $old_gai_cash = AccountBalanceHistory::getTodayAmountByGaiNumber($this->gai_number);

        return $old_gai_cash * 1 + $new_gai_cash * 1;
    }

    /**
     * 取会员冻结金额，旧系统和新系统金额相加
     * @notice 这里的冻结金额是指 待返还积分， 在余额表中的冻结金额，是提现后转到的冻结账户
     */
    public function getTotalFreezeCashNew() {
        if (empty($this->gai_number))
            return false;

        $new_gai_cash = AccountBalance::getTodayAmountByGaiNumber($this->gai_number, AccountBalance::TYPE_RETURN);
        $old_gai_cash = AccountBalanceHistory::getTodayAmountByGaiNumber($this->gai_number, AccountBalance::TYPE_RETURN);
        return $old_gai_cash * 1 + $new_gai_cash * 1;
    }

    /**
     * 取商家总的可提现金额
     * @param int $memberId
     * @return string
     */
    public function getTotalCash($memberId) {
        return sprintf('%0.2f', AccountBalance::getWithdrawBalance($memberId));
    }

    /**
     * 余额表总金额计算（当前余额及历史余额相加）
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return string
     */
    public static function getTotalPrice($type, $memberId = null, $gaiNumber = null) {
        $currentPrice = self::getCurrentPrice($type, $memberId, $gaiNumber);
        $historyPrice = self::getHistoryPrice($type, $memberId, $gaiNumber);
        return sprintf('%0.2f', $currentPrice * 1 + $historyPrice * 1, 2);
    }

    /**
     * 获取历史余额
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return float
     */
    public static function getHistoryPrice($type, $memberId = null, $gaiNumber = null) {
        $memberId = isset($memberId) ? $memberId : Yii::app()->user->id;
        $gaiNumber = isset($gaiNumber) ? $gaiNumber : Yii::app()->user->gw;
        $condition = '`account_id`=' . $memberId . ' AND `gai_number`="' . $gaiNumber . '" AND `type`=' . $type;
        $historyPrice = Yii::app()->db->createCommand()->select('today_amount')->from(ACCOUNT . '.' . '{{account_balance_history}}')->where($condition)->queryScalar();
        if (empty($historyPrice)) {
            return 0;
        }
        return $historyPrice * 1;
    }

    /**
     * 获取当前余额
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return float
     */
    public static function getCurrentPrice($type, $memberId = null, $gaiNumber = null) {
        $memberId = isset($memberId) ? $memberId : Yii::app()->user->id;
        $gaiNumber = isset($gaiNumber) ? $gaiNumber : Yii::app()->user->gw;
        $condition = '`account_id`=' . $memberId . ' AND `gai_number`="' . $gaiNumber . '" AND `type`=' . $type;
        $currentPrice = Yii::app()->db->createCommand()->select('today_amount')->from(ACCOUNT . '.' . '{{account_balance}}')->where($condition)->queryScalar();
        return $currentPrice * 1;
    }

    /**
     * 后台企业会员列表
     * @return \CActiveDataProvider
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function enterprise() {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.enterprise_id > 0');
        $criteria->select = 'gai_number, username, mobile, type_id, '
            . 'referrals_id, register_time, register_type, enterprise_id, status';
        $criteria->compare('t.gai_number', $this->gai_number);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.mobile', $this->mobile);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.district_id', $this->district_id);
        $criteria->compare('t.register_type', $this->register_type);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('enterprise.name', $this->enterprise_id, true);
        $criteria->with = array(
            'enterprise' => array('select' => 'name'),
            'memberType' => array('select' => 'name'),
            'referrals' => array('select' => 'gai_number')
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

}