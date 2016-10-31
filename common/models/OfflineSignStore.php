<?php

/**
 * This is the model class for table "{{offline_sign_store}}".
 *
 * The followings are the available columns in table '{{offline_sign_store}}':
 * @property string $id
 * @property string $extend_id
 * @property string $franchisee_id
 * @property string $machine_id
 * @property string $franchisee_name
 * @property string $install_area_id
 * @property string $install_province_id
 * @property string $install_city_id
 * @property string $install_district_id
 * @property string $install_street
 * @property string $machine_administrator
 * @property string $machine_administrator_mobile
 * @property string $store_phone
 * @property string $store_mobile
 * @property string $machine_number
 * @property integer $machine_size
 * @property string $store_location
 * @property string $store_linkman
 * @property string $store_linkman_position
 * @property string $store_linkman_webchat
 * @property string $store_linkman_qq
 * @property string $store_linkman_email
 * @property string $franchisee_category_id
 * @property string $open_begin_time
 * @property string $open_end_time
 * @property integer $exists_membership
 * @property integer $member_discount_type
 * @property integer $store_disconunt
 * @property string $store_banner_image
 * @property string $store_inner_image
 * @property integer $discount
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $clearing_remark
 * @property integer $machine_install_type
 * @property integer $machine_install_style
 * @property string $franchisee_operate_name
 * @property string $franchisee_operate_id
 * @property string $enterprise_member_name_agent
 * @property string $recommender_member_id_agent
 * @property string $recommender_mobile
 * @property string $recommender_linkman
 * @property string $recommender_mobile_member
 * @property string $recommender_member_id_member
 * @property string $recommender_apply_image
 * @property string $error_field
 * @property string $create_time
 * @property string $update_time
 */
class OfflineSignStore extends CActiveRecord
{
	public $step;					//用户点击的是上一步 还是下一步
	const LAST_STEP = 1;			//上一步
	const ADDFRANCHISEE = 3;		//添加加盟商
	const NEXT_STEP = 2;			//提交资料

	public $offline_sign_contract_id;			//合同id

	public $depthZero;							//加盟商分类顶级分类
	public $depthOne;							//加盟商分类二级分类
	public $recommender_member_gai_number;		//推荐者GW号
    public $franchisee_operate_gai_number;      //运维方GW号
    public $recommender_agent_gai_number;       //推荐者GW号
	public $enterprise_name;					//企业名称
	public $b_name;								//合同表中乙方（认为他是企业名字）
	public $event;								//审核进度
    public $application_type;					//申请者类型
    public $repeat_audit;						//是否重复审核
    public $repeat_application ; 				//是否重复申请
    public $sign_time;
    public $sign_type;
    public $recommender_member_id;

    public $old_franchisee_name;
    public $roleAuditDetail; //所有角色审核状态信息，concat拼接成字符串

 	const MACHINE_SIZE_FORTY_TWO = 1;			//尺寸---42寸
	const MACHINE_SIZE_THIRTY_TWO = 2;			//32寸

	public $role;			//当前进行各项操作的角色
	public $role_audit_status; //当前角色审核状态
	public $role_audit_status_2_all_sign; //全部签约 指定使用的审核状态标记

	/**
	 * 通过数组值获取数组键（一维）
	 * @param string $value
	 * @param array $array
	 */
	public static function getArrKeyByValue($value,$array){
		$key = array_search($value,$array);
		if($key !== false)
			return $key;
		else
			return false;
	}


	/**
	 * 获取尺寸
	 * @param null $key
	 * @return array
	 */
	public static function getMachineSize($key = null){
		$data = array(
            self::MACHINE_SIZE_THIRTY_TWO => '32寸',
			self::MACHINE_SIZE_FORTY_TWO => '42寸',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const INSTALL_STYLE_VERTICAL = 1;			//铺设样式---立式
	const INSTALL_STYLE_HANGING = 2;			//铺设样式---挂式

	/**
	 * 获取铺设样式
	 * @param null $key
	 * @return array
	 */
	public static function getInstallStyle($key = null){
		$data = array(
			self::INSTALL_STYLE_VERTICAL => '立式',
			self::INSTALL_STYLE_HANGING => '挂式',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const INSTALL_TYPE_CSMP = 1;				//铺设类型---消费机
	const INSTALL_TYPE_TXBN = 2;				//展示机
	const INSTALL_TYPE_TEST = 3;				//测试机

	/**
	 * 获取铺设类型
	 * @param null $key
	 * @return array
	 */
	public static function getInstallType($key = null){
		$data = array(
			self::INSTALL_TYPE_CSMP => '消费机',
			self::INSTALL_TYPE_TXBN => '展示机',
			self::INSTALL_TYPE_TEST => '测试机',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

    const DISCOUNT_TYPE_MEMBER = 1;				//会员优惠折扣
    const DISCOUNT_TYPE_RECHAR = 2;				//充值优惠折扣

	/**
	 * 获取会员折扣方式
	 * @param null $key
	 * @return array
	 */
	public static function getDiscountType($key = null){
		$data = array(
			self::DISCOUNT_TYPE_MEMBER => '会员优惠折扣',
			self::DISCOUNT_TYPE_RECHAR => '充值优惠折扣',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}


	const EXISTS_MEMBERSHIP_YES = 1;			//存在会员制
	const EXISTS_MEMBERSHIP_No = 0;				//不存在会员制

	/**
	 * 获得是否存在会员制
	 * @param null $key
	 * @return array
	 */
	public static function getExistsMembership($key = null){
		$data = array(
            self::EXISTS_MEMBERSHIP_YES => '是',
			self::EXISTS_MEMBERSHIP_No => '否',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}



	const APPLICATION_TYPE_AGENT = 0;  //代理商
	//const APPLICATION_TYPE_INTERIOR = 1;  //内部员工
	/*
	 * 获取签约申请者
	 *  @param null $key
	 *  @return array
	 */
	public static function getApplicationType($key = null)
	{
		$data = array(
			self::APPLICATION_TYPE_AGENT => Yii::t('OfflineSignStore','代理商'),
		//	self::APPLICATION_TYPE_INTERIOR => Yii::t('OfflineSignStore','内部员工'),
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}



    /**
     * 获取会员信息
     */
    public static function getCreateInfo($model){
        if($model->audit_status == self::AUDIT_STATUS_EXA_SUCCES && $model->status == self::STATUS_HAS_PASS){
            $data = array();
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,register_time')
                ->from(Member::model()->tableName())
                ->where('enterprise_id = :id',array(':id'=>$model->enterprise_id))
                ->queryRow();
            $franchisee = Yii::app()->db->createCommand()
                ->select('id,code,member_id,create_time')
                ->from(Franchisee::model()->tableName())
                ->where('id = :id',array(':id'=>$model->franchisee_id))
                ->queryRow();
            $machine = Yii::app()->gt->createCommand()
                ->select('id,machine_code,activation_code,biz_info_id,create_time')
                ->from(Machine::model()->tableName())
                ->where('id = :id',array(':id'=>$model->machine_id))
                ->queryRow();
            $data['gai_number'] = $member['gai_number'];
            $data['register_time'] = date('Y-m-d',$member['register_time']);
            $data['code'] =$franchisee['code'];
            $data['create_timeF'] = date('Y-m-d',$franchisee['create_time']);
            $data['machine_code'] =$machine['machine_code'];
            $data['activation_code'] =$machine['activation_code'];
            $data['create_timeM'] =date('Y-m-d',$machine['create_time']);
        }else{
            return $data = array(
               'gai_number' => '',
               'register_time' => '',
               'code' => '',
               'create_timeF' => '',
               'machine_code' => '',
               'activation_code' => '',
                'create_timeM'=> '',
            );
        }
        return $data;
    }



	/**
	 * 全部签约（第三步 提交了资质 上传合同了）
	 * 
	 * @author xuegang.liu@g-emall.com
	 * @since  2016-02-18T14:26:56+0800
	 * @param  string  $roleAuditDetail 
	 * @return string  
	 */
	public static function allSignAuditStatus($roleAuditDetail){

		$roleAuditStatusMap = OfflineSignStoreExtend::getAllSignAuditStatus();
		$roleAuditDetail = str_split($roleAuditDetail);
		if(count($roleAuditDetail)!=7) return Yii::t('OfflineSignStore','未知');

		//第一个角色打回，用户需重新申请
		if($roleAuditDetail[0]==OfflineSignStoreExtend::ROLE_AUDIT_STATUS_NO_PASS){ 
			$key = OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_AGNET;
		}else if($roleAuditDetail[6] == OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS){ //审核通过
			$key = OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_DONE;
		}else{
			$key = array_search(OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING,$roleAuditDetail);
			if($key === false) return Yii::t('OfflineSignStore','未知');
			$key = $key + 1;
		}

		return isset($roleAuditStatusMap[$key]) ? $roleAuditStatusMap[$key] : Yii::t('OfflineSignStore','未知');
	}

	/**
	 * 根据父类ID获取加盟商分类子级分类
	 * @param int $parentId 父级id，不传取顶级分类
	 * @return array
	 */
	public static function getChildCategory($parentId = 0){
		$childCategory = Yii::app()->db->createCommand()
								->select('id,name,parent_id')
								->from(FranchiseeCategory::model()->tableName())
								->where('parent_id = ' .$parentId . ' and status='.FranchiseeCategory::STATUS_ENABLE)
								->queryAll();
		if(!empty($childCategory)){
			$list = array();
			foreach($childCategory as $key => $val){
				$list[$val['id']] = $val['name'];
			}
			return $list;
		}else
			return array('无下级分类');
	}


	/**
	 * 根据盖网号，返回GWid
	 * @param string $GWNo 盖网号
	 * @return bool|mixed
	 */
	public static function getGaiIdByGaiNumber($GWNo){
		if(!empty($GWNo)){
			$result = Yii::app()->db->createCommand()
								->select('id')
								->from(Member::model()->tableName())
								->where('gai_number = :GWNo' , array(':GWNo' => $GWNo))
								->queryScalar();
			if(!empty($result)) return $result;
			else return '';
		}else return '';
	}

	/**
	 * 根据企业id，生成店铺信息
	 * @param int $enterpriseId 企业id
	 * @return string 合同id
	 */
	public static function createStoreByEnterpriseId($enterpriseId){
		$result = Yii::app()->db->createCommand()->insert(self::model()->tableName(),array(
			'franchisee_developer' =>OfflineSignContract::getEnterpriseName(),
			'machine_belong_to' =>OfflineSignContract::getEnterpriseName(),
			'create_time' => time(),
			'update_time' => time(),
			'agent_id'=>Yii::app()->user->id,
			'offline_sign_enterprise_id'=>$enterpriseId,
			'status'=>self::STATUS_NOT_SUBMIT,
			'audit_status'=>self::AUDIT_STATUS_NOT_SUBMIT,
		));
		if($result){
			$storeId = Yii::app()->db->getLastInsertID();
			// OfflineSignStoreExtend::initData($storeId); //审核扩展表初始化
			return $storeId;
		}
		else return '';
	}

	/**
	 * 获取当前登录的用户的企业姓名
	 * @param string $memberId 会员id，如果不传，默认为当前登录用户
	 * @return mixed
	 */
	public static function getEnterpriseName($memberId = ''){
		if(!$memberId)
			$memberId = Yii::app()->user->id;
		$a_name = Yii::app()->db->createCommand()
							->select('e.name')
							->from(Member::model()->tableName() . ' as m')
							->leftJoin(Enterprise::model()->tableName() . ' as e' , ' m.enterprise_id = e.id')
							->where('m.id = :id' , array(':id' => $memberId))
							->queryScalar();
		return $a_name;
	}

	/**
	 * 根据id获取所有的上级分类id()
	 */
	public static function getParentCategory($category_id,&$result){

		$categoryModel = FranchiseeCategory::getCategoryById($category_id);
		if(empty($categoryModel)) return ;
		$result[] = $categoryModel['id'];
		if($categoryModel['parent_id'] != 0){
			self::getParentCategory($categoryModel['parent_id'],$result);
		}
		return;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return self::getTableName();
	}

	public static function getTableName(){
		return '{{offline_sign_store}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('recommender_member_gai_number,franchisee_operate_gai_number,recommender_agent_gai_number','isLegal'),
			array('store_location,store_linkman,open_begin_time,open_end_time,store_banner_image,store_inner_image,machine_install_type,machine_install_style,
				machine_size,,depthZero,franchisee_name,install_area_id,install_province_id,install_city_id,install_district_id,install_street,machine_administrator,store_phone,store_mobile,
				machine_administrator_mobile,machine_number,discount,member_discount,franchisee_operate_name,franchisee_operate_gai_number,enterprise_member_name_agent,recommender_agent_gai_number,recommender_mobile_member,recommender_member_gai_number,recommender_apply_image,recommender_mobile,recommender_linkman','required','on'=>'create,update,OldFranchisee'),

            array('open_end_time', 'comext.validators.compareDateTime', 'compareAttribute' => 'open_begin_time', 'allowEmpty' => true,
				'operator' => '>','message' => '营业结束时间 必须大于 营业开始时间'),
			array('discount,member_discount,store_disconunt','numerical', 'integerOnly'=>true,'min'=>0,'max'=>100,'message'=>'请填写正整数'),
            array('discount', 'compare', 'compareAttribute' =>'member_discount', 'operator' => '<'),
			array('open_begin_time, open_end_time, sign_time, create_time, update_time', 'length', 'max'=>10),
			array('store_mobile,recommender_mobile,machine_administrator_mobile,recommender_mobile_member', 'comext.validators.isMobile', 'errMsg' => '请输入正确的移动电话'),
			array('store_linkman_qq','match','pattern'=>'/^[1-9][0-9]{4,10}$/','message'=>'QQ号格式错误'),
			array('store_linkman_email','email','pattern'=>'/[a-z]/i','message'=>'必须为电子邮箱'),
			array('install_area_id,install_province_id, install_city_id, install_district_id', 'required','message' => '请选择 {attribute}','on'=>'OldFranchisee'),
			array('store_mobile,recommender_mobile', 'comext.validators.isMobile', 'errMsg' => '请输入正确的移动电话'),
			array('store_phone', 'match', 'pattern' => '/^\d{3,4}-\d{7,8}(-\d{3,4})?$/', 'message' => '固话格式错误，请输入如0777-4783550'),
			array('machine_size,machine_number, exists_membership, member_discount_type, store_disconunt, discount, member_discount, machine_install_type, machine_install_style', 'numerical', 'integerOnly'=>true),
			array('extend_id, franchisee_id, machine_id, install_area_id, install_province_id, install_city_id, install_district_id, machine_number, franchisee_category_id, store_banner_image, store_inner_image, recommender_member_id_agent, recommender_apply_image', 'length', 'max'=>11),
			array('franchisee_name, store_location, store_linkman, store_linkman_position, store_linkman_webchat, store_linkman_qq, store_linkman_email, recommender_linkman, recommender_member_id_member', 'length', 'max'=>128),
			array('install_street, clearing_remark', 'length', 'max'=>255),
			array('machine_administrator, machine_administrator_mobile, store_phone, store_mobile, franchisee_operate_name, franchisee_operate_id, enterprise_member_name_agent, recommender_mobile, recommender_mobile_member', 'length', 'max'=>32),
			array('open_begin_time, open_end_time, create_time, update_time', 'length', 'max'=>10),
			array('deepthOne,depthOne,recommender_member_gai_number,store_disconunt,clearing_remark,step,enterprise_name,role_audit_status,roleAuditDetail,role_audit_status_2_all_sign,sign_type,depthZero','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, extend_id, franchisee_id, machine_id, franchisee_name, install_area_id, install_province_id, install_city_id, install_district_id, install_street, machine_administrator, machine_administrator_mobile, store_phone, store_mobile, machine_number, machine_size, store_location, store_linkman, store_linkman_position, store_linkman_webchat, store_linkman_qq, store_linkman_email, franchisee_category_id, open_begin_time, open_end_time, exists_membership, member_discount_type, store_disconunt, store_banner_image, store_inner_image, discount, gai_discount, member_discount, clearing_remark, machine_install_type, machine_install_style, franchisee_operate_name, franchisee_operate_id, enterprise_member_name_agent, recommender_member_id_agent, recommender_mobile, recommender_linkman, recommender_mobile_member, recommender_member_id_member, recommender_apply_image, error_field, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * 检测gw号是否存在
	 */
	public function isLegal($attribute, $params) {
		if (!is_string($this->$attribute)){
			$this->addError($attribute,'GW号不存在');
		}
		$memberInfo = Member::getUserInfoByGw($this->$attribute,'id');
		if(empty($memberInfo)){
			return $this->addError($attribute,'GW号不存在');
		}
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'agent_id'=>'签约申请人',
			'enterprise_id' => Yii::t('OfflineSignStore','企业id'),//'Enterprise',
			'franchisee_id' => Yii::t('OfflineSignStore','加盟商id'),//'Franchisee',
			'machine_id' => Yii::t('OfflineSignStore','盖机id'),//'Franchisee',
			'offline_sign_enterprise_id' => Yii::t('OfflineSignStore',''),//'Offline Sign Enterprise',
			'apply_type' => Yii::t('OfflineSignStore','新增类型'),//'Apply Type',
			'is_import' => Yii::t('OfflineSignStore','申请者类型'),
			'old_member_franchisee_id'=>'原有会员新增加盟商时企业id',
			'franchisee_name' => Yii::t('OfflineSignStore','加盟商姓名'),//'Franchisee Name',
            'machine_administrator_mobile'=>Yii::t('OfflineSignStore','盖网通管理人移动电话'),
            'machine_administrator'=>Yii::t('OfflineSignStore','盖网通管理人姓名'),
            'machine_number'=>Yii::t('OfflineSignStore','盖网通数量'),
			'recommender_name' => Yii::t('OfflineSignStore','推荐者会员姓名'),//'Recommender Name',
			'install_area_id' => '大区',
			'install_province_id' => Yii::t('OfflineSignStore','省'),//'Install Province',
			'install_city_id' => Yii::t('OfflineSignStore','市'),//'Install City',
			'install_district_id' => Yii::t('OfflineSignStore','区'),//'Install District',
			'install_street' => Yii::t('OfflineSignStore','详细地址'),//'Install Street',
			'store_location' => Yii::t('OfflineSignStore','所在商圈'),//'Store Location',
			'store_linkman' => Yii::t('OfflineSignStore','商家联系人'),//'Store Linkman',
			'store_linkman_position' => Yii::t('OfflineSignStore','商家联系人职位'),//'Store Linkman Position',
			'store_linkman_webchat' => Yii::t('OfflineSignStore','商家联系人微信'),//'Store Linkman Webchat',
			'store_linkman_qq' => Yii::t('OfflineSignStore','商家联系人qq'),//'Store Linkman Qq',
			'store_linkman_email' => Yii::t('OfflineSignStore','商家联系人邮箱'),//'Store Linkman Email',
			'store_phone' => '店面固定电话',
			'store_mobile' => '店面移动电话',
            'clearing_remark' => '会员结算备注',
			'discount' => '折扣差',
			'gai_discount' => '盖网公司结算折扣',
			'member_discount' => '盖网会员结算折扣',
			'store_disconunt' => '会员折扣',
			'franchisee_category_id' => Yii::t('OfflineSignStore','所属加盟商分类'),//'Franchisee Category',
			'open_begin_time' => Yii::t('OfflineSignStore','营业开始时间'),//'Open Begin Time',
			'open_end_time' => Yii::t('OfflineSignStore','营业结束时间'),//'Open End Time',
			'exists_membership' => Yii::t('OfflineSignStore','是否存在会员制'),//'Exists Membership',
			'member_discount_type' => Yii::t('OfflineSignStore','会员折扣方式'),//'Member Discount Type',
			'store_banner_image' => Yii::t('OfflineSignStore','带招牌的店铺门面照片'),//'Store Banner Image',
			'store_inner_image' => Yii::t('OfflineSignStore','店铺内部照片'),//'Store Inner Image',
			'machine_install_type' => Yii::t('OfflineSignStore','铺设类型'),//'Machine Install Type',
			'machine_install_style' => Yii::t('OfflineSignStore','铺设样式'),//'Machine Install Style',
			'machine_size' => Yii::t('OfflineSignStore','尺寸'),//'Machine Size',
			'sign_type' => Yii::t('OfflineSignStore','签约类型'),//'Sign Type',
			'sign_time' => Yii::t('OfflineSignStore','签约日期'),//'Sign Time',
			'machine_developer' => Yii::t('OfflineSignStore','销售开发人'),//'Machine Developer',
			'contract_linkman' => Yii::t('OfflineSignStore','合同跟进人'),//'Contract Linkman',
			'remark' => Yii::t('OfflineSignStore','备注'),//'Remark',
			'machine_belong_to'=>Yii::t('OfflineSignStore','机器归属方'),
			'franchisee_developer'=>Yii::t('OfflineSignStore','加盟商开发方'),
			'status' => Yii::t('OfflineSignStore','状态'),//'Status',
			'audit_status' => Yii::t('OfflineSignStore','审核状态'),//'Audit Status',
			'upload_contract' => Yii::t('OfflineSignStore','纸质合同'),
			'create_time' => Yii::t('OfflineSignStore','申请提交时间'),//'Create Time',
			'update_time' => Yii::t('OfflineSignStore','更新时间'),//'Update Time',
			'error_field' => Yii::t('OfflineSignStore',''),//'Error Field',
			'enterprise_name' => Yii::t('OfflineSignStore','企业名称'),//'企业名称'
			'b_name' =>Yii::t('OfflineSignStore','企业名称'),//'企业名称'
			'event' => Yii::t('OfflineSignStore','审核进度'),
            'application_type' => Yii::t('OfflineSignStore','签约申请者'),
            'repeat_audit' => Yii::t('OfflineSignStore','重复审核'),
            'repeat_application'=> Yii::t('OfflineSignStore','重复申请'),
            'depthZero'=> Yii::t('OfflineSignStore','经营类别(级别一)'),
			'role'=>'当前角色',
			'role_audit_status'=> Yii::t('OfflineSignStore','审核状态'),
            'franchisee_operate_name'=>'联盟商户运维方名称',
            'franchisee_operate_gai_number'=>'联盟商户运维方GW号',
            'franchisee_operate_id'=>'联盟商户运维方GW号',
            'enterprise_member_name_agent'=>'企业会员名称(代理商)',
            'recommender_member_id_agent'=>'推荐者GW号（代理商）',
            'recommender_agent_gai_number'=>'推荐者GW号（代理商）',
            'recommender_member_gai_number'=>'推荐者GW号（会员）',
            'recommender_mobile' =>'推荐者手机号（代理商）',
            'recommender_linkman'=>'联系人（代理商）',
            'recommender_mobile_member'=>'推荐者手机号码（会员）',
            'recommender_apply_image'=>'盖机推荐者绑定申请',
            'recommender_member_id_member'=>'推荐者GW号（会员）',
		);
	}

	/**
	 * beforeValidate
	 */
	protected function beforeValidate(){

		if(!parent::beforeValidate()) return false;
		if($this->isNewRecord){
			$this->create_time = time();
		}
		$this->gai_discount = $this->member_discount - $this->discount;
		$this->open_begin_time = empty($this->open_begin_time) ? null : strtotime($this->open_begin_time);
		$this->open_end_time = empty($this->open_end_time) ? null :  strtotime($this->open_end_time);
		$this->update_time = time();
        if($this->exists_membership == OfflineSignStore::EXISTS_MEMBERSHIP_No){
            $this->member_discount_type = '';
            $this->store_disconunt = 0;
        }
		return true;
	}

	/**
	 * 检验之后方法，把营业时间还原。。。。。
	 * 还是写在模型中，不然要在每个需要调用验证的action中处理
	 * @return bool
	 */
	protected function afterValidate(){
		$this->open_begin_time = empty($this->open_begin_time) ? null : date('H:i',$this->open_begin_time);
		$this->open_end_time = empty($this->open_end_time) ? null :  date('H:i',$this->open_end_time);
		$this->sign_time = empty($this->sign_time) ? null :  date('Y-m-d',$this->sign_time);
		return true;
	}

	/**
	 * beforesave
	 */
	protected function beforeSave()
	{
		if(!parent::beforeSave()) return false;
		self::beforeValidate();				//调用检验之前方法，格式化时间
		if($this->recommender_member_gai_number){
			$memberInfo = Member::getUserInfoByGw($this->recommender_member_gai_number,'id');
			if(empty($memberInfo)) return false;
			$this->recommender_member_id_member = $memberInfo['id'];
		}
        if($this->franchisee_operate_gai_number){
            $memberInfoF = Member::getUserInfoByGw($this->franchisee_operate_gai_number,'id');
            if(empty($memberInfoF)) return false;
            $this->franchisee_operate_id = $memberInfoF['id'];
        }
        if($this->recommender_agent_gai_number){
            $memberInfoA = Member::getUserInfoByGw($this->recommender_agent_gai_number,'id');
            if(empty($memberInfoA)) return false;
            $this->recommender_member_id_agent = $memberInfoA['id'];
        }
        $this->gai_discount = $this->member_discount - $this->discount;
		$this->agentId2InstallAreaId();
		return true;
	}

//	protected function afterSave(){
//		if($this->status==self::STATUS_PEND_AUDIT && $this->audit_status==self::AUDIT_STATUS_PRI_UPLOAD){
//			OfflineSignStoreExtend::initData($this->id); //审核扩展表初始化,若果存在则更新角色1审核状态
//		}
//	}

	/**
	 * 拉取数据后，格式化处理
	 */
	protected function afterFind(){

		parent::afterFind();
		$memberInfo = Member::getInfoById($this->recommender_member_id_member,'gai_number');
		if(isset($memberInfo['gai_number'])){
			$this->recommender_member_gai_number = $memberInfo['gai_number'];
		}
        $memberInfoF = Member::getInfoById($this->franchisee_operate_id,'gai_number');
        if(isset($memberInfoF['gai_number'])){
            $this->franchisee_operate_gai_number = $memberInfoF['gai_number'];
        }
        $memberInfoA = Member::getInfoById($this->recommender_member_id_agent,'gai_number');
        if(isset($memberInfoF['gai_number'])){
            $this->recommender_agent_gai_number = $memberInfoA['gai_number'];
        }

		$this->open_begin_time = empty($this->open_begin_time) ? null :  date('H:i',$this->open_begin_time);
		$this->open_end_time = empty($this->open_end_time) ? null :   date('H:i',$this->open_end_time);

		$this->_restoreCategory();
		return true;
	}

	/**
	 * 还原deepZero deepthOne信息
	 */
	private function _restoreCategory(){

		$categoryInfos = FranchiseeCategory::getCategoryById($this->franchisee_category_id);
		if(!empty($categoryInfos)){
			$this->depthZero = $categoryInfos['parent_id']==0 ? $categoryInfos['id'] : $categoryInfos['parent_id'];
			$categoryInfos['parent_id']!=0 && $this->depthOne = $categoryInfos['id'];
		}
		return true;
	}

	/**
	 * 根据agent_id，查所在大区id
	 */
	protected function agentId2InstallAreaId()
	{
		if(empty($this->agent_id)){
			return true;	
		} 

		$areaId = Region::getAreaIdByUserId($this->agent_id);
		if(empty($areaId)){
			$areaId = 0;
			// throw new Exception("系统内部错误", 1);
		}
		$this->install_area_id = $areaId;
		return true;
	}

	public function searchView(){
		$criteria=new CDbCriteria;
		$criteria->compare('extend_id',$this->extend_id);
		return $criteria;
	}
    public function searchFranchiseeView($extend_id){
        $criteria=new CDbCriteria;
        $criteria->compare('extend_id',$extend_id);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10
            ),
        ));
    }

	/**
     * 代理商后台使用的查询
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'c.b_name,t.id,t.create_time,t.agent_id,t.old_member_franchisee_id,t.audit_status,'.
							'e.offline_sign_contract_id,t.update_time,e.name as enterprise_name,t.apply_type,oe.name as old_franchisee_name,'.
							't.status,t.repeat_application,t.repeat_audit';
		$criteria->join = ' left join ' . OfflineSignEnterprise::model()->tableName() . ' as e on t.offline_sign_enterprise_id = e.id';
		$criteria->join .= ' left join ' . OfflineSignContract::model()->tableName() . ' as c on e.offline_sign_contract_id = c.id';
		$criteria->join .= ' left join ' . Enterprise::getTableName() . ' as oe on t.old_member_franchisee_id = oe.id';

        !empty($this->enterprise_name) 
        && $criteria->addCondition("e.name like '%".$this->enterprise_name."%' or oe.name like '%".$this->enterprise_name."%' ");

		// $criteria->compare('e.name',$this->enterprise_name,true);
		$criteria->compare('t.apply_type',$this->apply_type);
		$criteria->compare('t.status',$this->status);

		
		//只显示由该加盟商创建的商户
		$criteria->addCondition('t.agent_id = ' . Yii::app()->user->id);
		$criteria->order = "t.create_time desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 10
			),
		));
	}

	/**
	 * 原有会员新增加盟商 判断该会员是否是通过电签生成
	 * @param Int $enterpriseId 企业id
	 * @return bool|mixed
	 */
	public static function enterIsByOffline($enterpriseId){
		$data = Yii::app()->db->createCommand()
			->select('id,offline_sign_contract_id,offline_sign_enterprise_id,upload_contract_img,upload_contract,franchisee_developer,machine_belong_to')
			->from(OfflineSignStoreExtend::model()->tableName())
			->where('enterprise_id =:id',array(':id'=>$enterpriseId))
			->queryRow();
		if($data)
			return $data;
		else return false;
	}

	/**
	 * 检测用户当前角色是否拥有修改归属方信息权限
	 * 
	 * @param  integer $role 
	 * @return boolean
	 */
	public static function checkAccessModifyMachineBelong($role){

		//要求过滤地区的角色列表
    	$allowModityRoles = array(
    		OfflineSignAuditLogging::ROLE_REGIONAL_SALES,  //审核角色（大区经理）
    		OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES,  //审核角色（销售总监）
    		OfflineSignAuditLogging::ROLE_REGION_AUDIT, //审核角色（大区审核）
    	);

    	return in_array($role, $allowModityRoles);
	}

	/**
	 * 红色后台使用的查询
	 * @param string $role 不传默认为大区经理
	 * @return CActiveDataProvider
	 */
	public function searchManage($role=OfflineSignAuditLogging::ROLE_REGIONAL_SALES)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select = 't.is_import,t.old_member_franchisee_id,t.id,t.audit_status,t.agent_id,e.offline_sign_contract_id,t.create_time,'.
					't.update_time,e.name as enterprise_name,oe.name as old_franchisee_name,t.apply_type,t.status,t.repeat_application,t.repeat_audit,'.$role." as role";

		$criteria->join = ' left join ' . OfflineSignEnterprise::model()->tableName() . ' as e on t.offline_sign_enterprise_id = e.id';
		$criteria->join .= ' left join ' . Enterprise::getTableName() . ' as oe on t.old_member_franchisee_id = oe.id';


		$this->_appendRegionFilter($role,$criteria);   //针对大区审核、运作部大区审核两种角色，添加地区过滤
		$this->_appendAuditingFilter($role,$criteria); //针对不通角色，添加审核状态过滤条件

		//根据企业名称进行筛选时，同时兼容原有会员筛选
        !empty($this->enterprise_name) 
        && $criteria->addCondition("e.name like '%".$this->enterprise_name."%' or oe.name like '%".$this->enterprise_name."%' ");

        $criteria->compare('t.apply_type',$this->apply_type);
        $criteria->compare('t.is_import',$this->is_import);
        $criteria->compare('t.audit_status',$this->audit_status);
		$criteria->compare('t.repeat_audit',$this->repeat_audit);
		$criteria->compare('t.repeat_application',$this->repeat_application);
		$this->_appendRoleAuditStatusFilter($role,$criteria);
		$this->_appendRoleAuditStatusFilter2AllSign($criteria);

        $searchCreateDate = Tool::searchDateFormat($this->createTimeStart, $this->createTimeEnd);
        $criteria->compare('t.create_time', ">=" . $searchCreateDate['start']);
        $criteria->compare('t.create_time', "<=" . $searchCreateDate['end']);
        $criteria->order = "t.update_time desc";
        $sort = new CSort();
        $sort->attributes = array(
            'update_time'=>array(
                'asc'=>'`update_time`','desc'=>'`update_time` desc'
            ),
            'create_time'=>array(
                'asc'=>'`create_time`','desc'=>'`create_time` desc'
            ),
        );
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10
            ),
            'sort' =>$sort,
        ));
    }

	/**
	 * 更新状态和审核状态，
	 * 
	 * @param  integer  $storeId 店铺id
	 * @param  boolean  $isPass  是否通过审核
	 * @return boolean
	 */
	public static function updateAuditStatus($storeId,$isPass=true){

		$model = self::model()->findByPk($storeId);
		if(empty($model))  throw new Exception("店铺信息表不存在此条记录", 1);

		if($isPass){
			$model->status = self::STATUS_HAS_PASS; //已通过
			$model->audit_status = self::AUDIT_STATUS_EXA_SUCCES;  //资质审核成功
		}else{
			//如果只是上传合同审核失败，进行特殊处理
			$errorFieldArr = json_decode($model->error_field,true);
			if(count($errorFieldArr)==1 && in_array('s.upload_contract', $errorFieldArr) ){
				$model->status = self::STATUS_NOT_BY_CONTRACT; //上传合同未通过
				$model->audit_status = self::AUDIT_STATUS_SUB_ELECTR;  //提交资质电子档
			}else{
				$model->status = self::STATUS_NOT_BY; //电子档案未通过
				$model->audit_status = self::AUDIT_STATUS_NOT_SUBMIT;  //提交资质电子档
			}
          	$model->repeat_audit = self::REPEAT_AUDIT_YES;
          	$model->repeat_application = self::REPEAT_APPLICATION_YES;
		}

		if(!$model->save(false,array('status','audit_status','repeat_audit','repeat_application'))){
			throw new Exception("更新状态失败11", 1);
		}
		return true;
	}
    /*
     * 查询资质表是否存在商店
     * */
    public static function checkShore($extend_id){
        $checkStore = self::model()->find('extend_id=:extend_id',array(':extend_id'=>$extend_id));
        return empty($checkStore)?'':$checkStore;
    }
    /**
     * 生成资质信息
     * @param int $applyType 新增类型，默认为新商户
     * @param int $oldMemberId 如果类型为老商户时的会员Id
     * @return int|string
     */
    public static function createExtend($eid='',$cid='',$applyType = OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE,$enterprise_id,$oldMemberId = 0){
        $model = new OfflineSignStoreExtend();
        $model->offline_sign_enterprise_id = $eid;
        $model->offline_sign_contract_id = $cid;
        $model->enterprise_id = $enterprise_id;
        $model->agent_id = Yii::app()->user->id;
        $model->apply_type = $applyType;
        $model->franchisee_developer = Yii::app()->user->id;
        $model->machine_belong_to = OfflineSignMachineBelong::createBelong(Yii::app()->user->name);
        $model->extend_area_id = self::getAgentAreaId($model->agent_id);
        $model->old_member_franchisee_id = $oldMemberId;
        $model->is_import = OfflineSignStoreExtend::IS_IMPORT_NO_AGETNT;
        $model->create_time = time();
        $model->update_time = time();
        if($model->save(false)) {
            //点击下一步，进入审核记录页面
            return $model;
        }
        else return 0;
    }
    /*
     * 获取代理商大区
     * */
    public static function getAgentAreaId($id){
        $manageIdArray = Yii::app()->db->createCommand()
            ->select('manage_id,parent_id,tree')
            ->from(Region::model()->tableName())
            ->where('member_id = :id',array(':id'=>$id))
            ->queryAll();
        if(!empty($manageIdArray)){
            foreach($manageIdArray as $manage){
                if($manage['manage_id'] != 0) return $manage['manage_id'];
            }
        }
        foreach($manageIdArray as $manage){
            if($manage['parent_id'] > 1){
                $manageSheng = explode('|',$manage['tree']);
                $parent_manage_id = Yii::app()->db->createCommand()
                    ->select('manage_id')
                    ->from(Region::model()->tableName())
                    ->where('id = :id', array(':id' => $manageSheng['1']))
                    ->queryScalar();
                if(!empty($parent_manage_id) && $parent_manage_id != 0) {
                    return $parent_manage_id;
                }
            }
        }
    }
    /*
     * 获取商店所有字段
     * */
    public static function getStoreField(){
       return array(
            "s.franchisee_name",
            "s.install_province_id",
            "s.install_street",
            "s.machine_administrator",
            "s.machine_administrator_mobile",
            "s.machine_number",
            "s.machine_size",
            "s.store_location",
            "s.store_linkman",
            "s.store_linkman_position",
            "s.store_linkman_webchat",
            "s.store_linkman_qq",
            "s.store_linkman_email",
            "s.store_phone",
            "s.store_mobile",
            "s.depthZero",
            "s.depthOne",
            "s.open_begin_time",
            "s.open_end_time",
            "s.exists_membership",
            "s.member_discount_type",
            "s.store_disconunt",
            "s.store_banner_image",
            "s.store_inner_image",
            "s.member_discount",
            "s.discount",
            "s.gai_discount",
            "s.clearing_remark",
            "s.machine_install_type",
            "s.machine_install_style",
            "s.franchisee_operate_name",
            "s.franchisee_operate_gai_number",
            "s.enterprise_member_name_agent",
            "s.recommender_agent_gai_number",
            "s.recommender_mobile",
            "s.recommender_linkman",
            "s.recommender_mobile_member",
            "s.recommender_member_gai_number",
            "s.recommender_apply_image"
        );
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
