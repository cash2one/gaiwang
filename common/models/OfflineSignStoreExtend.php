<?php

/**
 * This is the model class for table "{{offline_sign_store_extend}}".
 *
 * The followings are the available columns in table '{{offline_sign_store_extend}}':
 * @property string $id
 * @property string $offline_sign_contract_id
 * @property string $offline_sign_enterprise_id
 * @property string $enterprise_id
 * @property integer $role_1_audit_status
 * @property integer $role_2_audit_status
 * @property integer $role_3_audit_status
 * @property integer $role_4_audit_status
 * @property integer $role_5_audit_status
 * @property integer $role_6_audit_status
 * @property integer $role_7_audit_status
 * @property integer $extend_area_id
 * @property string $agent_id
 * @property integer $apply_type
 * @property integer $is_import
 * @property string $old_member_franchisee_id
 * @property integer $status
 * @property integer $audit_status
 * @property integer $upload_contract
 * @property integer $upload_contract_img
 * @property integer $repeat_audit
 * @property integer $repeat_application
 * @property string $create_time
 * @property string $update_time
 */
class OfflineSignStoreExtend extends CActiveRecord
{
	public $createTimeStart ;
	public $createTimeEnd ;
    public $lookData;

	public $role;			//当前进行各项操作的角色
	public $role_audit_status; //当前角色审核状态
	public $role_audit_status_2_all_sign; //全部签约 指定使用的审核状态标记
    public $role_status;
    public $create_time_start;//创建时间开始
    public $create_time_end;//创建时间结束
    public $event;          //审核进度

	public $is_import;
	public $enTerName;						//企业名
	const IS_IMPORT_NO_AGETNT = 1;  //非导入，代理商
	const IS_IMPORT_YES = 2; //内部员工

	/**
	 * 是否来源于内部人员导入
	 */
	public static function getIsImport($key = null)
	{
		$data = array(
			self::IS_IMPORT_NO_AGETNT => Yii::t('OfflineSignStore','代理商'),
			self::IS_IMPORT_YES => Yii::t('OfflineSignStore','内部员工'),
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}
	const SIGN_TYPE_FIRST = 1;						//首次签约
	const SIGN_TYPE_RENEW = 2;						//续约
	const SIGN_TYPE_UPDATE = 3;						//改签合同

	/**
	 * 获取签约类型
	 * @param null $key
	 * @return array|string
	 */
	public static function getSignType($key = null){
		$data = array(
			self::SIGN_TYPE_FIRST => '首次签约',
			self::SIGN_TYPE_RENEW => '续约',
			self::SIGN_TYPE_UPDATE => '改签合同',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const APPLY_TYPE_NEW_FRANCHIESE = 1;		//申请类型---->新增商户
	const APPLY_TYPE_OLD_FRANCHIESE = 2;		//申请类型---->原有会员新增加盟商
//	const APPLY_TYPE_RENEW_FRANCHIESE = 3;		//申请类型---->原有商户续约

	/**
	 * 获取申请类型
	 * @param null $key
	 * @return array
	 */
	public static function getApplyType($key = null)
	{
		$data = array(
			self::APPLY_TYPE_NEW_FRANCHIESE => Yii::t('OfflineSignStore','新商户'),
			self::APPLY_TYPE_OLD_FRANCHIESE => Yii::t('OfflineSignStore','原有会员新增加盟商'),
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const STATUS_NOT_SUBMIT = 0;			//未提交
	const STATUS_PEND_AUDIT = 1;			//审核中
	const STATUS_NOT_BY = 2;				//未通过
	const STATUS_NOT_BY_CONTRACT = 3;		//上传合同未通过
	const STATUS_NO_QUALIFICATION = 4;		//未提交资质
	const STATUS_HAS_PASS = 5;				//通过审核

	/**
	 * 获取状态 （店铺状态）
	 * @param null $key
	 * @return array
	 */
	public static function getStatus($key = null)
	{
		$data = array(
			self::STATUS_NOT_SUBMIT => '未提交',
			self::STATUS_PEND_AUDIT => '审核中',
			self::STATUS_NOT_BY => '未通过',
			self::STATUS_NOT_BY_CONTRACT => '上传合同未通过',
			self::STATUS_NO_QUALIFICATION => '未提交资质',
			self::STATUS_HAS_PASS => '通过审核',
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const AUDIT_STATUS_NOT_SUBMIT = 0;			//未提交
	const AUDIT_STATUS_SUB_ELECTR = 1;			//提交资质电子档，未上传合同
	const AUDIT_STATUS_PRI_UPLOAD = 2;			//提交电子档，并打印、盖章上传资质合同
	const AUDIT_STATUS_EXA_CONTRA = 3;			//审核资质合同
	const AUDIT_STATUS_EXA_SUCCES = 4;			//资质审核成功
	/**
	 * 获取审核状态 （审核状态）
	 * @param null $key
	 * @return array
	 */
	public static function getAuditStatus111($key = null)
	{
		$data = array(
			self::AUDIT_STATUS_SUB_ELECTR => Yii::t('OfflineSignStore','提交资质电子档'),
			self::AUDIT_STATUS_PRI_UPLOAD => Yii::t('OfflineSignStore','打印、盖章并上传资质合同'),
			self::AUDIT_STATUS_EXA_CONTRA => Yii::t('OfflineSignStore','审核资质合同'),
			self::AUDIT_STATUS_EXA_SUCCES => Yii::t('OfflineSignStore','资质审核成功'),
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const  REPEAT_APPLICATION_NO = 0 ; // 否
	const  REPEAT_APPLICATION_YES = 1; //是

	/**
	 * 是否重复申请
	 * @param null $key
	 * @return array
	 */
	public static function getISRepeatApplication($key = null)
	{
		$data = array(
			self::REPEAT_APPLICATION_YES => Yii::t('OfflineSignStore','是'),
			self::REPEAT_APPLICATION_NO => Yii::t('OfflineSignStore','否'),
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const REPEAT_AUDIT_YES = 1; //是
	const REPEAT_AUDIT_NO = 0;  //否

	/**
	 * 重复审核
	 * @param null $key
	 * @return array|string
	 */
	public static function getIsRepeatAudit($key = null)
	{
		$data = array(
			self::REPEAT_AUDIT_YES => Yii::t('OfflineSignStore','是'),
			self::REPEAT_AUDIT_NO => Yii::t('OfflineSignStore','否'),
		);
		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	/**
	 * 根据登录的用户，返回用户的角色（审核的7个角色 不存在则认为为“大区经理”  处理admin权限问题）
	 */
	public static function getRoleByUser(){
		$user_id = Yii::app()->user->id;
		$userRoleData = Yii::app()->db->createCommand()
			->select('itemname')
			->from(AuthAssignment::model()->tableName())
			->where('userid=:id',array(':id'=>$user_id))
			->queryColumn();
		$role = array();
		if(!empty($userRoleData)){
			$roleKeyArr = OfflineSignAuditLogging::getRoleKey();
			$roleData = OfflineSignAuditLogging::getRoleData();
			foreach($userRoleData as $value){
				//存在这个角色
				if(isset($roleKeyArr[$value])){
					if($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_REGIONAL_SALES){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_REGIONAL_SALES];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_REGION_AUDIT){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_REGION_AUDIT];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION];
					}elseif($roleKeyArr[$value] == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER){
						$role[] = $roleData[OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER];
					}
				}elseif($value == 'Admin'){
					$role = $roleData;//admin账户默认拥有7个角色
					break;
				}
			}
		}
		return $role;
	}

	/**
	 * 显示当前审核状态【仅供显示使用】
	 * 	 tips:只正对角色审核 和 审核通过
	 *
	 * @param  integer   $auditStatus     审核总进度状态
	 * @param  integer   $roleAuditStatus 每个角色审核状态
	 * @return string
	 */
	public static function getAuditStatusEx($roleAuditStatus=null,$auditStatus=null,$status=null){

		$roleAuditStatusMap = OfflineSignStoreExtend::getAuditStatus();
		$roleAuditStatusMap[self::AUDIT_STATUS_EXA_SUCCES] = Yii::t('OfflineSignStore','已完成');

		//审核通过
		if($status==self::STATUS_HAS_PASS && $auditStatus==self::AUDIT_STATUS_EXA_SUCCES){
			return $roleAuditStatusMap[self::AUDIT_STATUS_EXA_SUCCES];
		}

		if($roleAuditStatus===null && $auditStatus===null && $status===null) return $roleAuditStatusMap;
		return isset($roleAuditStatusMap[$roleAuditStatus]) ?  $roleAuditStatusMap[$roleAuditStatus] :  Yii::t('OfflineSignStore','未知');
	}

    public static function getAuditStatusExtend($role = null,$ExtendId = null){
        if(!empty($role) && !empty($ExtendId)){
            $Status = self::AuditStatusExtend($role,$ExtendId);
            return $Status != self::ROLE_ALL_SIGN_AUDIT_STATUS_DONE ? self::getAuditStatus($Status):self::getAllSignAuditStatus($Status);
        }
    }
    public static function AuditStatusExtend($role = null,$ExtendId = null){
        if(!empty($role) && !empty($ExtendId)){
            $Field = "role_".$role."_audit_status";
            $a_name = Yii::app()->db->createCommand()
                ->select($Field.',role_7_audit_status')
                ->from(self::model()->tableName())
                ->where('id = :id' , array(':id' => $ExtendId))
                ->queryRow();

            if(!empty($a_name)){
                if($a_name['role_7_audit_status'] == self::ROLE_AUDIT_STATUS_PASS) {
                    return self::ROLE_ALL_SIGN_AUDIT_STATUS_DONE;
                }
                return $a_name["role_".$role."_audit_status"];
            }
        }
    }

	const ROLE_AUDIT_STATUS_INIT	=	0;	//默认值
	const ROLE_AUDIT_STATUS_WAITING	=	1;	//待审核
	const ROLE_AUDIT_STATUS_PASS	=	2;	//流程审核中，本角色审核通过
	const ROLE_AUDIT_STATUS_NO_PASS	=	3;	//审核不通过，打回

	//全部签约列表专用【审核状态】
	const ROLE_ALL_SIGN_AUDIT_STATUS_AGNET						=	-1; //打回(代理商)
	const ROLE_ALL_SIGN_AUDIT_STATUS_REGIONAL_SALES				=	1; //流程审核中(大区经理)
	const ROLE_ALL_SIGN_AUDIT_STATUS_DIRECTOR_OF_SALES			=	2; //流程审核中(销售总监)
	const ROLE_ALL_SIGN_AUDIT_STATUS_REGION_AUDIT				=	3; //打回(大区审核)
	const ROLE_ALL_SIGN_AUDIT_STATUS_THE_AUDIT_TEAM_LEADER		=	4; //打回(审核组长)
	const ROLE_ALL_SIGN_AUDIT_STATUS_DIRECTOR_OF_OPERATIONS		=	5; //打回(运营总监)
	const ROLE_ALL_SIGN_AUDIT_STATUS_AUDIT_OPERATIONS_REGION	=	6; //打回(运作部大区审核)
	const ROLE_ALL_SIGN_AUDIT_STATUS_OPERATIONS_MANAGER			=	7; //打回(运作部经理)
	const ROLE_ALL_SIGN_AUDIT_STATUS_DONE						=	8; //已完成

	/**
	 * 生成资质信息
	 * @param int $applyType 新增类型，默认为新商户
	 * @param int $oldMemberId 如果类型为老商户时的会员Id
	 * @return int|string
	 */
	public static function createExtend($cid,$applyType = OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE,$oldMemberId = 0){
		$model = new OfflineSignStoreExtend();
		$model->offline_sign_contract_id = $cid;
		$model->agent_id = Yii::app()->user->id;
		$model->apply_type = $applyType;
		$model->extend_area_id = self::getAgentAreaId($model->agent_id);
		$model->old_member_franchisee_id = $oldMemberId;
        $model->franchisee_developer = Yii::app()->user->id;
        $model->machine_belong_to = OfflineSignMachineBelong::createBelong(Yii::app()->user->name);
		$model->is_import = OfflineSignStoreExtend::IS_IMPORT_NO_AGETNT;
		$model->create_time = time();
		$model->update_time = time();
		if($model->save(false))
			return $model->id;
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

	/**
	 * 根据申请类型，生成对应编辑电签 url
	 *
	 * @param  interge  $applyType  申请类型
	 * @param  interge  $contractId 合同id
	 * @param  interge  $extendId   资质id
	 * @return string
	 */
	public static function getUpdateUrl($applyType,$contractId,$extendId){

		$action = $applyType==self::APPLY_TYPE_NEW_FRANCHIESE
			? 'offlineSignContract/newFranchiseeUpdate' : 'offlineSignStore/OldFranchiseeUNLL';

		$id = $extendId;
		return Yii::app()->controller->createUrl($action, array("id"=>$id));
	}
    /**
     * 根据申请类型，生成对应继续编辑电签 url
     *
     * @param  interge  $applyType  申请类型
     * @param  interge  $contractId 合同id
     * @param  interge  $extendId   资质id
     * @return string
     */
    public static function getContinueUpdateUrl($applyType,$contractId,$extendId){

        $action = $applyType==self::APPLY_TYPE_OLD_FRANCHIESE
            ? 'offlineSignStore/OldFranchiseeUNLL' : 'OfflineSignStoreExtend/continueUpdate';

        $id = $extendId;
        return Yii::app()->controller->createUrl($action, array("id"=>$id));
    }

	/**
	 * 拉取数据后，格式化处理
	 */
	protected function afterFind(){
		parent::afterFind();
		if($this->offline_sign_enterprise_id){
			$model = OfflineSignEnterprise::model()->findByPk($this->offline_sign_enterprise_id);
			if($model)
				$this->enTerName = $model->name;
		}
		return true;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return self::getTableName();
	}

	public static function getTableName(){
		return '{{offline_sign_store_extend}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('offline_sign_contract_id, agent_id, apply_type, is_import, create_time, update_time', 'required'),
			array('role_1_audit_status, role_2_audit_status, role_3_audit_status, role_4_audit_status, role_5_audit_status, role_6_audit_status, role_7_audit_status, apply_type, is_import, status, audit_status, repeat_audit, repeat_application', 'numerical', 'integerOnly'=>true),
			array('offline_sign_contract_id, offline_sign_enterprise_id, enterprise_id, agent_id, old_member_franchisee_id,extend_area_id,upload_contract', 'length', 'max'=>11),
			array('create_time, update_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, offline_sign_contract_id, offline_sign_enterprise_id, enterprise_id, role_1_audit_status, role_2_audit_status, role_3_audit_status, role_4_audit_status, role_5_audit_status, role_6_audit_status, role_7_audit_status, agent_id, apply_type,upload_contract_img,upload_contract,is_import, old_member_franchisee_id, status, audit_status, repeat_audit, repeat_application, create_time, update_time,extend_area_id,enTerName,role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'offline_sign_contract_id' => '合同表id',
			'offline_sign_enterprise_id' => '企业表id',
			'enterprise_id' => 'Enterprise',
			'role_1_audit_status' => '大区经理审核状态',
			'role_2_audit_status' => '销售总监审核状态',
			'role_3_audit_status' => '大区审核审核状态',
			'role_4_audit_status' => '审核组长审核状态',
			'role_5_audit_status' => '运营总监审核状态',
			'role_6_audit_status' => '运营部大区审核审核状态',
			'role_7_audit_status' => '运营部经理审核状态',
			'extend_area_id' => '该条资质所属的大区',
			'enTerName' => '企业名称',
			'agent_id' => '签约申请人',
			'apply_type' => '新增类型',
			'is_import' => '申请者类型',
			'old_member_franchisee_id' => 'Old Member Franchisee',
			'status' => '审核状态',
			'audit_status' => '审核流程状态',
			'upload_contract' => '联盟商户合同',
			'upload_contract_img' => '盖网通铺设场所及优惠约定',
			'repeat_audit' => '是否重复审核',
			'repeat_application' => '是否重复申请',
			'create_time' => '申请提交时间',
			'update_time' => '更新时间',
            'event' => '审核进度',
		);
	}

	/**
	 * 初始化
	 * @param  integer $storeId 店铺id
	 * @return CActiveRecord|OfflineSignStoreExtend
	 * @throws Exception
	 */
	public static function initData($storeId){
		
		//角色审核信息存在，且被第一角色打回后，初次进行编辑时，重置角色审核信息
		$model = self::model()->find('offline_sign_store_id=:storeId',array('storeId'=>$storeId));
		if(!empty($model) ){
			
			if($model->role_1_audit_status != self::ROLE_AUDIT_STATUS_NO_PASS) return $model;

			$model->role_1_audit_status = self::ROLE_AUDIT_STATUS_WAITING;
			if(!$model->save(false)) throw new Exception("重置角色1审核状态失败", 1);
			return $model;
		}
		
		$model = new self();
		$model->offline_sign_store_id = $storeId;
		$model->role_1_audit_status = self::ROLE_AUDIT_STATUS_WAITING;
		if(!$model->save())  throw new Exception("审核扩展表初始化失败", 1);
		return $model;
	}

	/**
	 * 获取角色审核相关字段
	 * 
	 * @return array
	 */
	public static function getRoleFields(){
		return array(
			'role_1_audit_status' => '大区经理审核状态',
			'role_2_audit_status' => '销售总监审核状态',
			'role_3_audit_status' => '大区审核审核状态',
			'role_4_audit_status' => '审核组长审核状态',
			'role_5_audit_status' => '运营总监审核状态',
			'role_6_audit_status' => '运营部大区审核审核状态',
			'role_7_audit_status' => '运营部经理审核状态',
		);
	}

	/**
	 * 获取审核状态值
	 * 
	 * @param  integer  $auditStatus 角色审核状态
	 * @return mixed
	 */
	public static function getAuditStatus($auditStatus=null){

		$auditStatusMap = array(
			self::ROLE_AUDIT_STATUS_WAITING	=>	'待审核',
			self::ROLE_AUDIT_STATUS_PASS	=>	'流程审核中',
			self::ROLE_AUDIT_STATUS_NO_PASS	=>	'打回',
		);

		if($auditStatus===null) return $auditStatusMap;
		return isset($auditStatusMap[$auditStatus]) ? $auditStatusMap[$auditStatus] : '未知审核状态';
	}


	/**
	 * 全部签约列表专用【审核状态】
	 * 
	 * @param  string  $key 
	 * @return mixed
	 */
	public static function getAllSignAuditStatus($key=null){

		$data = array(
			self::ROLE_ALL_SIGN_AUDIT_STATUS_AGNET					 => '打回(代理商)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_REGIONAL_SALES			 => '流程审核中(大区经理)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_DIRECTOR_OF_SALES		 => '流程审核中(销售总监)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_REGION_AUDIT			 => '流程审核中(大区审核)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_THE_AUDIT_TEAM_LEADER	 => '流程审核中(审核组长)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_DIRECTOR_OF_OPERATIONS	 => '流程审核中(运营总监)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_AUDIT_OPERATIONS_REGION => '流程审核中(运作部大区审核)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_OPERATIONS_MANAGER		 => '流程审核中(运作部经理)',
			self::ROLE_ALL_SIGN_AUDIT_STATUS_DONE					 => '已完成',
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知审核状态';
	}

	/**
	 * 根据角色获取对应角色审核字段
	 * @param integer $role 角色
	 * @return mixed
	 * @throws Exception
	 */
	public static function getRole2Field($role){

		$roleFieldMap = array(
			OfflineSignAuditLogging::ROLE_REGIONAL_SALES => array(
				'currenRole' => "role_1_audit_status",
				'nextRole' => "role_2_audit_status",
			),
			OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES => array(
				'lastRole' => "role_1_audit_status",
				'currenRole' => "role_2_audit_status",
				'nextRole' => "role_3_audit_status",
			),
			OfflineSignAuditLogging::ROLE_REGION_AUDIT => array(
				'lastRole' => "role_2_audit_status",
				'currenRole' => "role_3_audit_status",
				'nextRole' => "role_4_audit_status",
			),
			OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER => array(
				'lastRole' => "role_3_audit_status",
				'currenRole' => "role_4_audit_status",
				'nextRole' => "role_5_audit_status",
			),
			OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS => array(
				'lastRole' => "role_4_audit_status",
				'currenRole' => "role_5_audit_status",
				'nextRole' => "role_6_audit_status",
			),
			OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION => array(
				'lastRole' => "role_5_audit_status",
				'currenRole' => "role_6_audit_status",
				'nextRole' => "role_7_audit_status",
			),
			OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER => array(
				'lastRole' => "role_6_audit_status",
				'currenRole' => "role_7_audit_status",
			),
		);
		if(!isset($roleFieldMap[$role])){
			throw new Exception("内部错误", 500);
		}
		return $roleFieldMap[$role];
	}

	/**
	 * 根据角色，更新审核状态
	 *
	 * @param  integer  $storeId 店铺id
	 * @param  integer  $role    角色
	 * @param  boolean  $isPass  审核是否通过 
	 *         true:通过审核，false:不通过审核 默认true
	 *         
	 * @return boolean
	 */
	public static function updateAuditStatus($storeId,$role,$isPass=true){

		return $isPass ? self::passAudit($storeId,$role) : self::noPassAudit($storeId,$role);
	}

	/**
	 * 审核通过，根据角色，更新审核状态
	 * @param integer $storeId 店铺id
	 * @param integer $role 角色
	 * @return bool
	 * @throws Exception
	 */
	public static function passAudit($storeId,$role){

		$field = self::getRole2Field($role);
		$model = self::findByStoreId($storeId);
		
		$model->$field['currenRole'] = self::ROLE_AUDIT_STATUS_PASS;  //当前角色审核状态为 流程审核中

		//下个角色状态为 待审核 (如果是最后一个角色，更新is_pass_all_audit)
		if(!isset($field['nextRole'])){
			OfflineSignStoreExtend::updateAuditStatusExtend($storeId);
		}else{
            if($model->$field['nextRole'] == self::ROLE_AUDIT_STATUS_NO_PASS) {
                $model->repeat_audit = self::REPEAT_AUDIT_YES;
                $model->$field['nextRole'] = self::ROLE_AUDIT_STATUS_WAITING;
            }else{
                $model->$field['nextRole'] = self::ROLE_AUDIT_STATUS_WAITING;
            }
		}
        $model->update_time = time();
		if(!$model->save()){
			throw new Exception("更新审核状态失败", 1);
		}
		return true;
	}

	/**
	 * 审核不通过，根据角色，更新审核状态
	 * @param integer $storeId 店铺id
	 * @param integer $role 角色
	 * @return bool
	 * @throws Exception
	 */
	public static function noPassAudit($storeId,$role){

		$field = self::getRole2Field($role);
		$model = self::findByStoreId($storeId);

		//上个角色审核状态为待审中(如果是第一个角色，更新当前角色为0)
		if(!isset($field['lastRole'])){
            $model = OfflineSignStoreExtend::updateAuditStatusExtend($storeId,false);
		}else{
			$model->$field['lastRole'] = self::ROLE_AUDIT_STATUS_WAITING;
		}
        $model->$field['currenRole'] = self::ROLE_AUDIT_STATUS_NO_PASS; //当前角色审核状态为打回
        $model->update_time = time();
		if(!$model->save()){
			throw new Exception("更具审核状态失败", 1);
		}
		return true;
	}
    /*
     * 未通过原因
     * */
    public static function NoPassExtend($ExtendId){
        $sign_audit_logging = '';
        if(!empty($ExtendId)) {
            $sign_audit_logging = Yii::app()->db->createCommand()
                ->select('remark')
                ->from(OfflineSignAuditLogging::model()->tableName())
                ->where('extend_id = :extend_id and status = :status and audit_role = :audit_role', array(':extend_id' => $ExtendId, ':status' => OfflineSignAuditLogging::STATUS_NO_PASS, ':audit_role' => OfflineSignAuditLogging::ROLE_REGIONAL_SALES))
                ->order('id desc')
                ->queryScalar();
        }
        return empty($sign_audit_logging)?'没有原因！':$sign_audit_logging;
    }
    /**
     * 更新状态和审核状态，
     *
     * @param  integer  $storeId 店铺id
     * @param  boolean  $isPass  是否通过审核
     * @return boolean
     */
    public static function updateAuditStatusExtend($ExtendId,$isPass=true){

        $model = self::model()->findByPk($ExtendId);
        $reKey = false;
        $sign_audit_logging = Yii::app()->db->createCommand()
            ->select('error_field')
            ->from(OfflineSignAuditLogging::model()->tableName())
            ->where('extend_id = :extend_id and status = :status and audit_role = :audit_role',array(':extend_id'=>$ExtendId,':status'=>OfflineSignAuditLogging::STATUS_NO_PASS,':audit_role'=>OfflineSignAuditLogging::ROLE_REGIONAL_SALES))
            ->order('id desc')
            ->queryScalar();
        if(!empty($sign_audit_logging)) {
            $error_all = explode(',', $sign_audit_logging);
            if(is_array($error_all)){
                foreach($error_all as $val){
                    $Prefix = explode('.',$val);
                    if(preg_match('/c|s\d+|e$/', $Prefix[0])){
                        $reKey = true;
                        break;
                    }
                }
            }
        }

        if(empty($model))  throw new Exception("店铺信息表不存在此条记录", 1);

        if($isPass){
            $model->status = self::STATUS_HAS_PASS; //已通过
            $model->audit_status = self::AUDIT_STATUS_EXA_SUCCES;  //资质审核成功
        }else{
            //如果只是上传合同审核失败，进行特殊处理
            if($reKey){
                $model->status = self::STATUS_NOT_BY; //电子档案未通过
                $model->audit_status = self::AUDIT_STATUS_NOT_SUBMIT;  //提交资质电子档
            }else{
                $model->status = self::STATUS_NOT_BY_CONTRACT; //上传合同未通过
                $model->audit_status = self::AUDIT_STATUS_SUB_ELECTR;  //重新上传合同
            }
            $model->repeat_audit = self::REPEAT_AUDIT_YES;
            $model->repeat_application = self::REPEAT_APPLICATION_YES;
        }
        if(!$model->save(false,array('status','audit_status','repeat_audit','repeat_application'))){
            throw new Exception("更新状态失败11", 1);
        }
        return $model;
    }


	/**
	 * 代理商后台列表页搜索
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->select = 't.id,t.update_time,e.name as enTerName,t.apply_type,t.status,t.agent_id,t.audit_status';
		$criteria->join = 'left join ' . OfflineSignEnterprise::model()->tableName() . ' as e on e.id = t.offline_sign_enterprise_id';
		$criteria->compare('t.agent_id',Yii::app()->user->id);
		$criteria->compare('e.name',$this->enTerName,true);
        $criteria->compare('t.apply_type',$this->apply_type);
        $criteria->compare('t.status',$this->status);
        $sort = new CSort();
        $sort->attributes = array(
            'update_time'=>array(
                'asc'=>'`update_time`','desc'=>'`update_time` desc','default' => 'desc',
            ),
        );
        $sort->defaultOrder = array(
            'update_time'=>'desc',
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
	 * 红色后台资质列表使用的查询
	 * @param int $role
	 * @return CActiveDataProvider
	 */
	public function searchManage($role=OfflineSignAuditLogging::ROLE_REGIONAL_SALES){
		$criteria=new CDbCriteria;
		$criteria->select = 't.id,t.franchisee_developer,t.machine_belong_to,t.update_time,t.create_time,e.name as enTerName,t.audit_status,t.apply_type,t.status,t.repeat_audit,t.repeat_application,t.agent_id,t.is_import,' .$role." as role";
		$criteria->join = 'left join ' . OfflineSignEnterprise::model()->tableName() . ' as e on e.id = t.offline_sign_enterprise_id';
		$this->_appendRegionFilter($role,$criteria);   //针对大区审核、运作部大区审核两种角色，添加地区过滤
		$this->_appendAuditingFilters($role,$criteria); //针对不通角色，添加审核状态过滤条件
		$this->_appendRoleAuditStatusFilter($role,$criteria);	//追加状态过滤条件（对【状态为已完成和角色为审核完毕】的进行特殊处理）
		$this->_appendRoleAuditStatusFilter2AllSign($criteria);	//针对全部签约，审核状态筛选进行特殊处理
        $this->_appendRoleAuditStatusSelect($role,$criteria);	//针对搜索状态查询
		$sort = new CSort();
		$sort->attributes = array(
			'update_time'=>array(
				'asc'=>'`update_time`','desc'=>'`update_time` desc','default' => 'desc',
			),
			'create_time'=>array(
				'asc'=>'`create_time`','desc'=>'`create_time` desc','default' => 'desc',
			),
		);
        $sort->defaultOrder = array(
            'update_time'=>'desc',
        );
        $criteria->compare('t.apply_type',$this->apply_type);
        $criteria->compare('e.name',$this->enTerName,true);
        $criteria->compare('t.repeat_audit',$this->repeat_audit);
        $criteria->compare('t.repeat_application',$this->repeat_application);
        $searchCreateDate = Tool::searchDateFormat($this->createTimeStart, $this->createTimeEnd);
        $criteria->compare('t.create_time', ">=" . $searchCreateDate['start']);
        $criteria->compare('t.create_time', "<=" . $searchCreateDate['end']);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 10
			),
			'sort' =>$sort,
		));
	}
    public function _appendRoleAuditStatusSelect($role,&$criteria){
        if($this->role_status==OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_DONE){
            return $criteria->compare('t.role_7_audit_status',OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS);
        }
        if($this->role_status==OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS){
            $criteria->compare('t.role_'.$this->role.'_audit_status',$this->role_status);
            $criteria->compare('t.role_7_audit_status <',self::ROLE_AUDIT_STATUS_WAITING);
            return true;
        }
        return $criteria->compare('t.role_'.$this->role.'_audit_status',$this->role_status);
    }
	public function _setStatusAndAuditStatus($action='subElectr'){

		switch ($action) {
			//针对上传合同，status & audit_status进行重置处理
			case 'upload':
				if($this->audit_status == OfflineSignStoreExtend::AUDIT_STATUS_SUB_ELECTR){
					$this->audit_status = OfflineSignStoreExtend::AUDIT_STATUS_EXA_CONTRA;
				}
				break;

			//正对提交电子档，status & audit_status进行重置处理
			case 'subElectr':
				if($this->audit_status == OfflineSignStoreExtend::AUDIT_STATUS_NOT_SUBMIT){
					$this->audit_status = OfflineSignStoreExtend::AUDIT_STATUS_SUB_ELECTR;
				}
				break;
			default:
				throw new Exception("参数错误", 1);
				break;
		}

		// 当状态为上传合同未通过时，上传合同后直重置为待审核
		if($this->audit_status==OfflineSignStoreExtend::AUDIT_STATUS_EXA_CONTRA){
			$this->status = OfflineSignStoreExtend::STATUS_PEND_AUDIT;
            $this->role_1_audit_status = OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING;
		}elseif($this->audit_status==OfflineSignStoreExtend::AUDIT_STATUS_SUB_ELECTR){
            $this->status = OfflineSignStoreExtend::STATUS_NO_QUALIFICATION;
        }
	}

	/**
	 * 针对全部签约，审核状态筛选进行特殊处理
	 * @param  Object $criteria 查询对象
	 * @return bool
	 * @throws Exception
	 */
	private function _appendRoleAuditStatusFilter2AllSign(&$criteria){

		if(empty($this->role_audit_status_2_all_sign)) return true;

		//打回（代理商）
		if($this->role_audit_status_2_all_sign==OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_AGNET){
			return $criteria->addCondition('t.role_1_audit_status = '.OfflineSignStoreExtend::ROLE_AUDIT_STATUS_NO_PASS);
		}
		//已完成
		if($this->role_audit_status_2_all_sign==OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_DONE){
			return $criteria->addCondition('t.role_7_audit_status = '.OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS);
		}

		$fieldArr = OfflineSignStoreExtend::getRole2Field($this->role_audit_status_2_all_sign);
		$field = $fieldArr['currenRole'];
		return $criteria->addCondition("t.{$field} = ".OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING);
	}

	/**
	 * 追加状态过滤条件（对【状态为已完成和角色为审核完毕】的进行特殊处理）
	 * @param int $role 当前审核人员的角色
	 * @param object $criteria 查询对象
	 * @return bool
	 * @throws Exception
	 */
	private function _appendRoleAuditStatusFilter($role,&$criteria){
		if(empty($this->role_audit_status)) return true;
		//状态为已完成，进行特殊处理
		if($this->role_audit_status==self::AUDIT_STATUS_EXA_SUCCES){
			return $criteria->addCondition('t.role_7_audit_status = '.OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS);
		}
		if($role==OfflineSignAuditLogging::PASS_AUDIT){
			return $criteria->addCondition('2 = 1');
		}
		$fieldArr = OfflineSignStoreExtend::getRole2Field($role);
		$field = $fieldArr['currenRole'];
		$criteria->addCondition('t.audit_status != '.self::AUDIT_STATUS_EXA_SUCCES);
		return $criteria->compare("t.{$field}",$this->role_audit_status);
	}

	/**
	 * 针对大区审核、运作部大区审核两种角色，添加地区过滤
	 * @param int $role 当前审核人员的角色
	 * @param object $criteria 查询对象
	 * @author xuegang.liu@g-emall.com
	 * @return bool
	 */
	private function _appendRegionFilter($role,&$criteria){

		//要求过滤地区的角色列表
		$requireRegionFilterRoles = array(
			OfflineSignAuditLogging::ROLE_REGIONAL_SALES,  //审核角色（大区经理）
			OfflineSignAuditLogging::ROLE_REGION_AUDIT,  //审核角色（大区审核）
			OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION, //审核角色（运作部大区审核）
		);

		if(!in_array($role, $requireRegionFilterRoles)) return true;
        $adminName = Yii::app()->user->name;
        if(strtolower($adminName) == 'admin') return true;
		$criteria->join .= ' left join '.RegionManageRelation::getTableName().' as rmr on rmr.region_manage_id = t.extend_area_id';

		$criteria->addCondition('rmr.user_id = '.Yii::app()->user->id);
		return true;
	}

	/**
	 * 针对不通角色，添加审核状态过滤条件
	 *
	 * @param  integer  $role      角色
	 * @param  integer  &$criteria object
	 * @return boolean
	 * @author xuegang.liu@g-emall.com
	 * @since  2016-01-14T10:25:27+0800
	 */
    private function _appendAuditingFilters($role,&$criteria){
        //审核通过
        if($role==OfflineSignAuditLogging::PASS_AUDIT){
            $criteria->addCondition('t.role_7_audit_status = '.OfflineSignStoreExtend::ROLE_AUDIT_STATUS_PASS);
            return true;
        }

        //全部签约（第三步 提交了资质 上传合同了）
        if($role==OfflineSignAuditLogging::ALL_SIGN){
            $criteria->addCondition('t.role_1_audit_status >= '.OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING);
            return true;
        }
        $fieldArr = OfflineSignStoreExtend::getRole2Field($role);
        $field = $fieldArr['currenRole'];
        $criteria->select .= ",t.{$field} as role_audit_status ";
        $where = "t.{$field} >= ".OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING;//.' and t.audit_status = '.self::AUDIT_STATUS_PRI_UPLOAD;
        $criteria->addCondition($where);
        return true;
    }
	/**
	 * 红色后台7个角色列表页返回操作按钮
	 * @param int $id 店铺id
	 * @param int $role 当前操作的角色
	 * @return string	返回按钮
	 */

    public static function createButton($role = null,$id = null){
        $roleAuditStatus = self::AuditStatusExtend($role,$id);
        $string = "";
        if ( $roleAuditStatus == OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING && Yii::app()->user->checkAccess('OfflineSignStoreExtend.QualificationAudit')){

            $string .='<a title="审核" class="regm-sub" style="width:83px;" href="'.Yii::app()->controller->createUrl("OfflineSignStoreExtend/qualificationAudit", array("id"=>$id,"role"=>$role)).'">审核</a>';
        }

        if ( $roleAuditStatus == OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING && Yii::app()->user->checkAccess('OfflineSignStoreExtend.Update')){
            $string .='<a title="编辑" class="regm-sub" style="width:83px;" href="'.Yii::app()->controller->createUrl("OfflineSignStoreExtend/update", array("id"=>$id,"role"=>$role)).'">编辑</a>';
        }

        if ($roleAuditStatus == OfflineSignStoreExtend::ROLE_AUDIT_STATUS_WAITING && Yii::app()->user->checkAccess('OfflineSignAuditLogging.AddRemarks')){
            $string .= '<a class="regm-sub" style="width:83px;" href="javascript:addRemark('.$id.','.$role.')">添加备注</a>';
        }

        if(Yii::app()->user->checkAccess('OfflineSignAuditLogging.ShowRemarks')) {
            $string .= '<a title="查看备注" class="regm-sub" style="width:83px;" href="javascript:showRemarks(' . $id . ')">查看备注</a>';
        }

        if (Yii::app()->user->checkAccess('OfflineSignAuditLogging.AuditSchedule')) {
            $string .= '<a title="审核进度" class="regm-sub" style="width:83px;" href="javascript:AuditSchedule(' . $id . ')">审核进度</a>';
        }

        if (Yii::app()->user->checkAccess('OfflineSignStoreExtend.DetailsView')) {
            $url = Yii::app()->controller->createUrl("OfflineSignStoreExtend/detailsView", array("id" => $id));
            if($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER || $role == OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION){
                $url = Yii::app()->controller->createUrl("OfflineSignStoreExtend/operationDetailsView", array("id" => $id));
            }
            $string .= '<a title="查看详情" class="regm-sub" style="width:83px;" href="' . $url . '">查看详情</a>';
        }

        return $string;
    }

	/**
	 * 红色后台“审核完成”和“全部签约”列表页返回操作按钮
	 * @param int $id 店铺id
	 * @return string 返回按钮
	 */
	public static function createButtonsOther($id){
		$string = "";
		if(Yii::app()->user->checkAccess('OfflineSignAuditLogging.ShowRemarks'))
			$string .='<a title="查看备注" class="regm-sub" style="width:83px;" href="javascript:showRemarks('.$id.')">查看备注</a>';
		if (Yii::app()->user->checkAccess('OfflineSignAuditLogging.AuditSchedule'))
			$string .='<a title="审核进度" class="regm-sub" style="width:83px;" href="javascript:AuditSchedule('.$id.')">审核进度</a>';
		if (Yii::app()->user->checkAccess('OfflineSignStoreExtend.DetailsView'))
			$string .='<a title="查看详情" class="regm-sub" style="width:83px;" href="'.Yii::app()->controller->createUrl("offlineSignStoreExtend/detailsView", array("id"=>$id)).'">查看详情</a>';
		return $string;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignStoreExtend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 根据店铺id拉取审核表模型
	 * @param integer $storeId 店铺Id
	 * @return object CActiveRecord|OfflineSignStoreExtend
	 * @throws Exception
	 */
	public static function findByStoreId($storeId){

		if(empty($storeId)){
			throw new Exception("参数错误，更新审核状态失败", 1);
		}

		$model = self::model()->find('id=:storeId',array('storeId'=>$storeId));
		return $model ? $model : self::initData($storeId);
	}
    /**
     * 获取会员信息
     */
    public static function getCreateInfo($model,$storeModel){
        if($model->audit_status == self::AUDIT_STATUS_EXA_SUCCES && $model->status == self::STATUS_HAS_PASS){
            $data = array();
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,register_time')
                ->from(Member::model()->tableName())
                ->where('enterprise_id = :id',array(':id'=>$model->enterprise_id))
                ->queryRow();
            foreach($storeModel as $key=>$val) {
                $franchisee = Yii::app()->db->createCommand()
                    ->select('id,code,member_id,create_time')
                    ->from(Franchisee::model()->tableName())
                    ->where('id = :id',array(':id'=>$val->franchisee_id))
                    ->queryRow();
                $machine = Yii::app()->gt->createCommand()
                    ->select('id,machine_code,activation_code,biz_info_id,create_time')
                    ->from(Machine::model()->tableName())
                    ->where('id = :id', array(':id' => $val->machine_id))
                    ->queryRow();
                $data['code'][$key] =$franchisee['code'];
                $data['create_timeF'][$key] = date('Y-m-d',$franchisee['create_time']);
                $data['machine_code'][$key] = $machine['machine_code'];
                $data['activation_code'][$key] = $machine['activation_code'];
                $data['create_timeM'][$key] = date('Y-m-d', $machine['create_time']);
            }
            $data['gai_number'] = $member['gai_number'];
            $data['register_time'] = date('Y-m-d',$member['register_time']);
        }else{
            $data = array(
                'gai_number' => '',
                'register_time' => '',
            );
            foreach($storeModel as $key=>$val) {
                $data['code'][$key] ='';
                $data['create_timeF'][$key] = '';
                $data['machine_code'][$key] = '';
                $data['activation_code'][$key] = '';
                $data['create_timeM'][$key] = '';
            }
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
    public static function allSignAuditStatus($ExtendId = null){
        $roleAuditStatusMap = OfflineSignStoreExtend::getAllSignAuditStatus();
        $allRoleStatus = Yii::app()->db->createCommand()
            ->select('role_1_audit_status,role_2_audit_status,role_3_audit_status,role_4_audit_status,role_5_audit_status,role_6_audit_status,role_7_audit_status')
            ->from(self::model()->tableName())
            ->where('id = :id' , array(':id' => $ExtendId))
            ->queryRow();

        $roleAuditDetail = array_values($allRoleStatus);
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
    //获取加盟商开发方名称
 public static function getFranchiseeDeveloper($franchisee_developer_id=null){
        if(!empty($franchisee_developer_id)){
            $franchisee_developer_name = Yii::app()->db->createCommand()
                ->select('username')
                ->from(Member::model()->tableName())
                ->where('id = :id' , array(':id' => $franchisee_developer_id))
                ->queryScalar();
        }
     return !empty($franchisee_developer_name)?$franchisee_developer_name:'';
    }
    //获取机器归属方
    public static function getMachineBelongTo($machine_id=null){
        if(!empty($machine_id)){
            $belong_to = Yii::app()->db->createCommand()
                ->select('belong_to')
                ->from(OfflineSignMachineBelong::model()->tableName())
                ->where('id = :id' , array(':id' => $machine_id))
                ->queryScalar();
        }
        return !empty($belong_to)?$belong_to:'';
    }

    /**
     * 根据申请类型，返回企业名称（加盟商后台）
     * @param int $applyType 申请类型
     * @param int $offlineSignEnterpriseId 原有会员新增加盟商的企业id
     * @param String $enterpriseName 新商户的企业名
     * @return String mixed 企业名
     */
    public static function getEnterpriseNameByApplyType($applyType,$offlineSignEnterpriseId,$enterpriseName=''){
        $name = '';
        switch($applyType){
            case self::APPLY_TYPE_NEW_FRANCHIESE:
                $name = $enterpriseName;
                break;
            case self::APPLY_TYPE_OLD_FRANCHIESE:
                $name = Yii::app()->db->createCommand()
                    ->select('username')
                    ->from(Member::model()->tableName())
                    ->where('id=:id',array(':id'=>$offlineSignEnterpriseId))
                    ->queryScalar();
                break;
        }
        return $name;
    }
    /*
     * 获取资质所以加盟商
     * */
    public static function getAllStoreId($extend_id){
        $storeId = Yii::app()->db->createCommand()
            ->select('id')
            ->from(OfflineSignStore::model()->tableName())
            ->where('extend_id = :extend_id' , array(':extend_id' => $extend_id))
            ->queryAll();
        return !empty($storeId)?$storeId:'';
    }
    /*
     * 获取资质所以加盟商
     * */
    public static function getAllStoreData($extend_id){
        $select = implode(',',self::getStore());
        $storeData = Yii::app()->db->createCommand()
            ->select($select.',machine_id')
            ->from('{{offline_sign_store}} t')
            ->leftJoin('{{franchisee}} f', 't.franchisee_id=f.id')
            ->where('extend_id = :extend_id' , array(':extend_id' => $extend_id))
            ->queryAll();
        if(!empty($storeData)){
            foreach($storeData as $key=>$val){
                if($val['machine_id']) {
                    $machine = Yii::app()->gt->createCommand()
                        ->select('id,machine_code,activation_code,biz_info_id,create_time')
                        ->from(Machine::model()->tableName())
                        ->where('id = :id', array(':id' => $val['machine_id']))
                        ->queryRow();
                    if (!empty($storeData)) {
                        $storeData[$key]['machine_code'] = $machine['machine_code'];
                        $storeData[$key]['activation_code'] = $machine['activation_code'];
                        $storeData[$key]['create_timeM'] = $machine['create_time'];
                    }
                }else{
                    $storeData[$key]['machine_code'] = '';
                    $storeData[$key]['activation_code'] = '';
                    $storeData[$key]['create_timeM'] = '';
                }
            }
        }
        return !empty($storeData)?$storeData:'';
    }
    /**
     * 用于导入数据
     * 		tips : 隐含性能隐患，勿用!!!
     *
     * @author xuegang.liu@g-emall.com
     * @since  2016-01-21T17:57:40+0800
     * @return [type]                   [description]
     */
    public function searchManageExport($role,$offset=-1,$limit=-1){

        $query = $this->buildExportQuery($role);
        $select = implode(',',self::getSelectTitle());
        $query->setSelect($select);
        $query->setOffset($offset);
        $query->setLimit($limit);
        $data = $query->queryAll();
        return !empty($data) ? $data : array();
    }
    /**
     * 统计可以被导出记录总条数
     *
     * @param  integer $role
     * @return integer
     */
    public function countSearchManageExport($role){

        $query = $this->buildExportQuery($role);
        $query->setSelect('count(t.id)');
        $totalNum = $query->queryScalar();
        return !empty($totalNum) ? (int)($totalNum) : 0;
    }
    /**
     * [buildExportQuery description]
     *
     * @param  integer   $role [description]
     * @return object    CDbCommand
     */
    public function buildExportQuery($role){
        $criteria = new CDbCriteria;
        $criteria->join .= ' left join '.OfflineSignEnterprise::getTableName().' as e on e.id = t.offline_sign_enterprise_id';
        $criteria->join .= ' left join '.OfflineSignContract::getTableName().' as c on c.id = t.offline_sign_contract_id';
        $criteria->join .= ' left join '.Member::model()->tableName().' as m on m.enterprise_id = t.enterprise_id';
        $searchCreateDate = Tool::searchDateFormat($this->createTimeStart, $this->createTimeEnd);
        $criteria->compare('t.create_time', ">=" . $searchCreateDate['start']);
        $criteria->compare('t.create_time', "<=" . $searchCreateDate['end']);
        $criteria->compare('t.apply_type',$this->apply_type);
        $criteria->compare('e.name',$this->enTerName,true);
        $criteria->compare('t.repeat_audit',$this->repeat_audit);
        $criteria->compare('t.repeat_application',$this->repeat_application);
        $this->_appendRegionFilter($role,$criteria);   //针对大区审核、运作部大区审核两种角色，添加地区过滤
        $this->_appendAuditingFilters($role,$criteria); //针对不通角色，添加审核状态过滤条件
        $this->_appendRoleAuditStatusSelect($role,$criteria);	//针对搜索状态查询
        $query = Yii::app()->db->createCommand();
        $query->from(self::getTableName()." as t ");
        $query->setJoin($criteria->join);
        return $query->where($criteria->condition, $criteria->params);
    }


    /**
     * 获取需要查询的字段
     */
    public static function getSelectTitle(){
        return
            array(
                '申请类型' => 't.apply_type',
                '大区' => "t.extend_area_id as extend_area_id ",
                '加盟商开发方' => "t.franchisee_developer as franchisee_developer ",
                '机器归属方' => "t.machine_belong_to",
                '企业名称' => "e.name",
                '是否连锁' => "e.is_chain",
                '企业连锁形态' => "e.chain_type",
                '连锁数量' => "e.chain_number",
                '企业类型' => "e.enterprise_type",
                '企业联系人姓名' => "e.linkman_name",
                '企业联系人职位' => "e.linkman_position",
                '企业联系人微信'=>"e.linkman_webchat",
                '企业联系人QQ'=>"e.linkman_qq",
                '营业执照注册名称' => "e.name as '营业执照注册名称'",
                '营业执照注册号' => "e.enterprise_license_number",
                '成立日期' => "e.registration_time",
                '营业期限开始日期' => "e.license_begin_time",
                '营业期限结束日期' => "e.license_end_time",
                '是否长期' => "e.license_is_long_time",
                '法人代表' => "e.legal_man",
                '法人身份证号' => "e.legal_man_identity",
                '会员GW号' => " m.gai_number as '会员GW号' ",
                '会员名称' => " e.name as '会员名称' ",
                'GW号生成日期' => " m.register_time as GWtime ",
                'GW号开通人' => "c.enterprise_proposer",
                'GW号开通手机' => "c.mobile",
                '结算账户类型' => "e.account_pay_type",
                '收款人身份证号' => "e.payee_identity_number",
                '开户许可证区域（省)' => "e.bank_province_id",
                '开户许可证区域（市）' => "e.bank_city_id",
                '开户许可证区域（区）' => "e.bank_district_id",
                '合同编号' => "c.number",
                '甲方' => "c.a_name",
                '乙方' => "c.b_name",
                '营业执照注册地区（省）' => "c.province_id",
                '营业执照注册地区（市）' => "c.city_id",
                '营业执照注册地区（县/区）' => "c.district_id",
                '营业执照注册地址' => "c.address",
                '推广地区（省）' => 'c.p_province_id',
                '推广地区（市）' => 'c.p_city_id',
                '推广地区（县/区）' => 'c.p_district_id',
                '签约类型' => "c.sign_type",
                '合同签订日期' => "c.sign_time",
                '合同合作期限' => "c.contract_term",
                '合同期限起始日期' => "c.begin_time",
                '合同期限结束日期' => "c.end_time",
                '合同跟进人' => "c.contract_linkman",
                '收费方式' => 'c.operation_type',
                '3小时高峰广告开始时间（时）' => 'c.ad_begin_time_hour',
                '3小时高峰广告开始时间（钟）' => 'c.ad_begin_time_minute',
                '3小时高峰广告结束时间（时）'=> 'c.ad_end_time_hour',
                '3小时高峰广告结束时间（分）' => 'c.ad_end_time_minute',
                '开户行名称' => 'c.bank_name',
                '账户名称' => 'c.account_name',
                '银行账号' => 'c.account',
                '资质id' => 't.id',
            );
    }
    /**
     * 获取需要查询的字段
     */
    public static function getNULLData(){
        return
            array(
                '申请类型' => '',
                '大区' => "",
                '加盟商开发方' => "",
                '机器归属方' => "",
                '企业名称' => "",
                '是否连锁' => "",
                '企业连锁形态' => "",
                '连锁数量' => "",
                '企业类型' => "",
                '企业联系人姓名' => "",
                '企业联系人职位' => "",
                '企业联系人微信'=>"",
                '企业联系人QQ'=>"",
                '营业执照注册名称' => "",
                '营业执照注册号' => "",
                '成立日期' => "",
                '营业期限开始日期' => "",
                '营业期限结束日期' => "",
                '是否长期' => "",
                '法人代表' => "",
                '法人身份证号' => "",
                '会员GW号' => "",
                '会员名称' => "",
                'GW号生成日期' => "",
                'GW号开通人' => "",
                'GW号开通手机' => "",
                '结算账户类型' => "",
                '收款人身份证号' => "",
                '开户许可证区域（省)' => "",
                '开户许可证区域（市）' => "",
                '开户许可证区域（区）' => "",
                '合同编号' => "",
                '甲方' => "",
                '乙方' => "",
                '营业执照注册地区（省）' => "",
                '营业执照注册地区（市）' => "",
                '营业执照注册地区（县/区）' => "",
                '营业执照注册地址' => "",
                '推广地区（省）' => '',
                '推广地区（市）' => '',
                '推广地区（县/区）' => '',
                '签约类型' => "",
                '合同签订日期' => "",
                '合同合作期限' => "",
                '合同期限起始日期' => "",
                '合同期限结束日期' => "",
                '合同跟进人' => "",
                '收费方式' => '',
                '3小时高峰广告开始时间（时）' => '',
                '3小时高峰广告开始时间（钟）' => '',
                '3小时高峰广告结束时间（时）'=> '',
                '3小时高峰广告结束时间（分）' => '',
                '开户行名称' => '',
                '账户名称' => '',
                '银行账号' => '',
            );
    }
    /*
     * 获取需要查询的字段
     * */
    public static function getStore(){
        return array(
            '加盟商名称' => "t.franchisee_name",
            '加盟商编号' => "f.code",
            '加盟商编号生成日期' => "f.create_time as create_timeF",
            '加盟商区域（大区）' => "t.install_area_id",
            '加盟商区域（省）' => "t.install_province_id",
            '加盟商区域（市）' => "t.install_city_id",
            '加盟商区域（区）' => "t.install_district_id",
            '加盟商详细地址' => "t.install_street",
            '盖网通管理员名称' => 't.machine_administrator',
            '盖网通管理员移动电话' => 't.machine_administrator_mobile',
            '店面固定电话' => "t.store_phone",
            '店面移动电话' => "t.store_mobile",
            '所在商圈' => "t.store_location",
            '商家联系人' => "t.store_linkman",
            '商家联系人职位' => "t.store_linkman_position",
            '商家联系人微信' => "t.store_linkman_webchat",
            '商家联系人QQ' => "t.store_linkman_qq",
            '商家联系人邮箱' => "t.store_linkman_email",
            '经营类别一' => "t.franchisee_category_id as fci1",
            '经营类别二' => "t.franchisee_category_id as fci2",
            '营业开始时间' => "t.open_begin_time",
            '营业结束时间' => "t.open_end_time",
            '是否存在会员制' => "t.exists_membership",
            '会员折扣方式' => "t.member_discount_type",
            '会员折扣' => "t.store_disconunt",
            '装机编号'  => 't.store_disconunt as machine_code',
            '装机编码生成日期'  => 't.store_disconunt as create_timeM',
            '激活码'  => 't.store_disconunt as activation_code',
            '盖网会员结算折扣' => "t.member_discount",
            '折扣差' => "t.discount",
            '盖网公司结算折扣' => "t.gai_discount",
            '会员结算备注' => "t.clearing_remark",
            '铺设机型' => "t.machine_install_type",
            '样式' => "t.machine_install_style",
            '盖机数量' => 't.machine_number',
            '尺寸' => "t.machine_size",
            '联盟商户运维方名称' => 't.franchisee_operate_name',
            '运维方GW号' => 't.franchisee_operate_id',
            '企业会员名称(代理商)' => "t.enterprise_member_name_agent",
            '推荐者GW会员号（代理商）' => "t.recommender_member_id_agent",
            '推荐者手机号码（代理商）' => "t.recommender_mobile",
            '联系人（代理商）' => "t.recommender_linkman",
            '推荐者GW会员号（会员）' => "t.recommender_member_id_member",
            '推荐者手机号码（会员）' => "t.recommender_mobile_member",
        );
    }

    /**
     * 获取导出表头
     */
    public static function getExportTitle(){
        return
            array(
                '申请类型' => 't.apply_type',
                '大区' => "t.extend_area_id as extend_area_id ",
                '加盟商开发方' => "t.franchisee_developer as franchisee_developer ",
                '机器归属方' => "t.machine_belong_to",
                '企业名称' => "e.name",
                '是否连锁' => "e.is_chain",
                '企业连锁形态' => "e.chain_type",
                '连锁数量' => "e.chain_number",
                '企业类型' => "e.enterprise_type",
                '企业联系人姓名' => "e.linkman_name",
                '企业联系人职位' => "e.linkman_position",
                '企业联系人微信'=>"e.linkman_webchat",
                '企业联系人QQ'=>"e.linkman_qq",
                '营业执照注册名称' => "e.name as '营业执照注册名称'",
                '营业执照注册号' => "e.enterprise_license_number",
                '成立日期' => "e.registration_time",
                '营业期限开始日期' => "e.license_begin_time",
                '营业期限结束日期' => "e.license_end_time",
                '是否长期' => "e.license_is_long_time",
                '法人代表' => "e.legal_man",
                '法人身份证号' => "e.legal_man_identity",
                '会员GW号' => " m.gai_number as '会员GW号' ",
                '会员名称' => " e.name as '会员名称' ",
                'GW号生成日期' => " m.register_time as GWtime ",
                'GW号开通人' => "c.enterprise_proposer",
                'GW号开通手机' => "c.mobile",
                '结算账户类型' => "e.account_pay_type",
                '收款人身份证号' => "e.payee_identity_number",
                '开户许可证区域（省)' => "e.bank_province_id",
                '开户许可证区域（市）' => "e.bank_city_id",
                '开户许可证区域（区）' => "e.bank_district_id",
                '合同编号' => "c.number",
                '甲方' => "c.a_name",
                '乙方' => "c.b_name",
                '营业执照注册地区（省）' => "c.province_id",
                '营业执照注册地区（市）' => "c.city_id",
                '营业执照注册地区（县/区）' => "c.district_id",
                '营业执照注册地址' => "c.address",
                '推广地区（省）' => 'c.p_province_id',
                '推广地区（市）' => 'c.p_city_id',
                '推广地区（县/区）' => 'c.p_district_id',
                '签约类型' => "c.sign_type",
                '合同签订日期' => "c.sign_time",
                '合同合作期限' => "c.contract_term",
                '合同期限起始日期' => "c.begin_time",
                '合同期限结束日期' => "c.end_time",
                '合同跟进人' => "c.contract_linkman",
                '收费方式' => 'c.operation_type',
                '3小时高峰广告开始时间（时）' => 'c.ad_begin_time_hour',
                '3小时高峰广告开始时间（钟）' => 'c.ad_begin_time_minute',
                '3小时高峰广告结束时间（时）'=> 'c.ad_end_time_hour',
                '3小时高峰广告结束时间（分）' => 'c.ad_end_time_minute',
                '开户行名称' => 'c.bank_name',
                '账户名称' => 'c.account_name',
                '银行账号' => 'c.account',
                '加盟商名称' => "t.franchisee_name",
                '加盟商编号' => "f.code",
                '加盟商编号生成日期' => "f.create_time as create_timeF",
                '加盟商区域（大区）' => "t.install_area_id",
                '加盟商区域（省）' => "t.install_province_id",
                '加盟商区域（市）' => "t.install_city_id",
                '加盟商区域（区）' => "t.install_district_id",
                '加盟商详细地址' => "t.install_street",
                '盖网通管理员名称' => 't.machine_administrator',
                '盖网通管理员移动电话' => 't.store_mobile',
                '店面固定电话' => "t.store_phone",
                '店面移动电话' => "t.store_mobile",
                '所在商圈' => "t.store_location",
                '商家联系人' => "t.store_linkman",
                '商家联系人职位' => "t.store_linkman_position",
                '商家联系人微信' => "t.store_linkman_webchat",
                '商家联系人QQ' => "t.store_linkman_qq",
                '商家联系人邮箱' => "t.store_linkman_email",
                '经营类别一' => "t.franchisee_category_id",
                '经营类别二' => "t.franchisee_category_id as fi",
                '营业开始时间' => "t.open_begin_time",
                '营业结束时间' => "t.open_end_time",
                '是否存在会员制' => "t.exists_membership",
                '会员折扣方式' => "t.member_discount_type",
                '会员折扣' => "t.store_disconunt",
                '装机编号'  => 't.store_disconunt as machine_code',
                '装机编码生成日期'  => 't.store_disconunt as create_timeM',
                '激活码'  => 't.store_disconunt as activation_code',
                '盖网会员结算折扣' => "t.gai_discount",
                '折扣差' => "t.discount",
                '盖网公司结算折扣' => "t.member_discount",
                '会员结算备注' => "t.clearing_remark",
                '铺设机型' => "t.machine_install_type",
                '样式' => "t.machine_install_style",
                '盖机数量' => 't.machine_number',
                '尺寸' => "t.machine_size",
                '联盟商户运维方名称' => 't.franchisee_operate_name',
                '运维方GW号' => 't.franchisee_operate_id',
                '企业会员名称(代理商)' => "t.enterprise_member_name_agent",
                '推荐者GW会员号（代理商）' => "t.recommender_member_id_agent",
                '推荐者手机号码（代理商）' => "t.recommender_mobile",
                '联系人（代理商）' => "t.recommender_linkman",
                '推荐者GW会员号（会员）' => "t.recommender_member_id_member",
                '推荐者手机号码（会员）' => "t.recommender_mobile_member",
            );
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
    /**
     * 根据id拉取指定字段信息
     *
     * @param  interge  $id  member_id
     * @param  string   $fields
     * @return mix
     */
    public static function getMemberInfoById($id,$fields='*'){

        $result =  Yii::app()->db->createCommand()->select($fields)->from("{{member}}")->where('id=:id',array(':id'=>$id))->queryScalar();
        return $result;
    }

    /*
     * 审核界面打回错误标识
     * */
    public static function getAuditError($extendId,$role){
        if(!empty($extendId) && !empty($role)) {
            $sign_audit_logging = Yii::app()->db->createCommand()
                ->select('error_field')
                ->from(OfflineSignAuditLogging::model()->tableName())
                ->where('extend_id = :extend_id and status = :status and audit_role = :audit_role', array(':extend_id' => $extendId, ':status' => OfflineSignAuditLogging::STATUS_NO_PASS, ':audit_role' => $role+1))
                ->order('id desc')
                ->queryScalar();
        }
        return !empty($sign_audit_logging)?$sign_audit_logging:'';
    }
    /*
     * 检测资质有没有成功设置大区，如果大区extend_area_id = 0，则重新获取代理商大区，来设置资质大区
     * */
    public static function setExtendAreaId($Extend_model){
        if(!empty($Extend_model) && $Extend_model->extend_area_id == 0) {
            $user_id = Yii::app()->user->id;
            $ExtendAreaId = self::getAgentAreaId($user_id);
            $Extend_model->extend_area_id = $ExtendAreaId;
            $Extend_model->save(false);
        }
    }
}