<?php

/**
 * This is the model class for table "{{offline_sign_audit_logging}}".
 *
 * The followings are the available columns in table '{{offline_sign_audit_logging}}':
 * @property string $id
 * @property string $extend_id
 * @property string $behavior
 * @property string $auditor
 * @property string audit_role
 * @property string $event
 * @property string $remark
 * @property string $create_time
 */
class OfflineSignAuditLogging extends CActiveRecord
{

	const STATUS_NO_PASS = 2;		//审核不通过
	const STATUS_PASS = 1;			//审核通过

	const NO_AUDIT = 0;						//未审核（刚刚提交的资质）用于列表

	const ROLE_AGENT = 0;					//代理商
	const ROLE_REGIONAL_SALES = 1;			//审核角色(大区经理)
	const ROLE_DIRECTOR_OF_SALES = 2;		//审核角色(销售总监)
	const ROLE_REGION_AUDIT =3;				//审核角色（大区审核）
	const ROLE_THE_AUDIT_TEAM_LEADER =4;	//审核角色（审核组长）
	const ROLE_DIRECTOR_OF_OPERATIONS =5;	//审核角色（运营总监）
	const ROLE_AUDIT_OPERATIONS_REGION = 6;	//审核角色（运作部大区审核）
	const ROLE_OPERATIONS_MANAGER =7;		//审核角色（运作部经理）

	const PASS_AUDIT = 8;					//审核完毕（最后一个角色审核通过）用于列表
	const ALL_SIGN = 9;						//全部签约（所有的店铺）用于列表

	/**
	 * 保存前方法，用于设置event、create_time、auditor字段值
	 */
	protected function beforeSave()
	{
		parent::beforeSave();
		$this->auditor = Yii::app()->user->name;
		$str = self::getRoleValue($this->audit_role) . $this->auditor  . self::learnCode($this->behavior);
		if($this->status){
			$str .= self::getStatus($this->status);
		}
		$this->event = $str;
		$this->create_time = time();
		return true;
	}

	/**
	 * 构造方法
	 * OfflineSignAuditLogging constructor.
	 * @param string $extend_id
	 * @param $behavior
	 * @param int $audit_role
	 */
	public function __construct($extend_id='',$behavior='',$audit_role=OfflineSignAuditLogging::ROLE_AGENT){
		parent::__construct();
		$this->extend_id = $extend_id;
		$this->behavior = $behavior;
		$this->audit_role = $audit_role;
	}

	/**
	 * 操作行为
	 * 1开头的为代理商动作
	 * 2开头的为红色后台动作
	 * @var array
	 */
	protected static $codeArr = array(
		'1101'	=> '添加了签约类型为"新增户"的"1.添加合同信息"的资质信息',
		'1102'	=> '添加了签约类型为"新增户"的"2.企业与帐号信息"的资质信息',
		'1103'	=> '添加了签约类型为"新增户"的"3.盖机与店铺信息"的资质信息',			//（第三步，添加店铺信息完成）
		'1104'	=> '修改了签约类型为"新增户"的"1.添加合同信息"的资质信息',
		'1105'	=> '修改了签约类型为"新增户"的"2.企业与帐号信息"的资质信息',
		'1106'	=> '修改了签约类型为"新增户"的"3.盖机与店铺信息"的资质信息',
		'1201'	=> '添加了签约类型为"原有会员新增加盟商"的资质信息',
		'1202'	=> '修改了签约类型为"原有会员新增加盟商"的资质信息',

		'1001'	=> '首次提交电子资质',
		'1002'	=> '提交纸质资质',					//上传合同
		'1011'	=> '再次提交电子资质店铺信息',
		'1012'	=> '修改纸质资质',

		'2001'	=> '审核',
		'2002'	=> '添加备注',
		'2003'	=> '修改资质',
		'2004'	=> '导入',
        '2005'	=> '修改加盟商信息',
        '2006'	=> '修改公司信息',
	);

	/**
	 * 翻译代码
	 * @param $code
	 * @return string
	 */
	public static function learnCode($code=''){
		$lib = self::$codeArr;
		if($code){
			if(array_key_exists($code,$lib)) return $lib[$code];
		}else
			return $lib;
	}

	/**
	 * 根据审核角名 返回审核角色键
	 * @param string $value
	 * @return array
	 */
	public static function getRoleKey($value = ''){
		$data = array(
			'ROLE_REGIONAL_SALES' => self::ROLE_REGIONAL_SALES,
			'ROLE_DIRECTOR_OF_SALES' => self::ROLE_DIRECTOR_OF_SALES,
			'ROLE_REGION_AUDIT' => self::ROLE_REGION_AUDIT,
			'ROLE_THE_AUDIT_TEAM_LEADER' => self::ROLE_THE_AUDIT_TEAM_LEADER,
			'ROLE_DIRECTOR_OF_OPERATIONS' => self::ROLE_DIRECTOR_OF_OPERATIONS,
			'ROLE_AUDIT_OPERATIONS_REGION' => self::ROLE_AUDIT_OPERATIONS_REGION,
			'ROLE_OPERATIONS_MANAGER' => self::ROLE_OPERATIONS_MANAGER,
		);
		return $value ? $data[$value] : $data;
	}

	/**
	 * 根据审核角色值，返回审核角色值
	 * @param string $key
	 * @return array
	 */
	public static function getRoleValue($key = null){
		$data = array(
			self::ROLE_AGENT => '代理商',
			self::ROLE_REGIONAL_SALES => "大区经理",
			self::ROLE_DIRECTOR_OF_SALES => "销售总监",
			self::ROLE_REGION_AUDIT => "大区审核",
			self::ROLE_THE_AUDIT_TEAM_LEADER => "审核组长",
			self::ROLE_DIRECTOR_OF_OPERATIONS => "运营总监",
			self::ROLE_AUDIT_OPERATIONS_REGION => "运作部大区审核",
			self::ROLE_OPERATIONS_MANAGER => "运作部经理",
		);
		return $key === null ? $data : $data[$key];
	}

	/**
	 * 获取角色
	 * @param string $key
	 * @return array
	 */
	public static function getRoleData($key=''){
		$data = array(
			self::ROLE_REGIONAL_SALES => array(
				'id' => self::ROLE_REGIONAL_SALES,
				'roleName' => "大区经理"),
			self::ROLE_DIRECTOR_OF_SALES => array(
				'id' => self::ROLE_DIRECTOR_OF_SALES ,
				'roleName' => '销售总监'),
			self::ROLE_REGION_AUDIT => array(
				'id' => self::ROLE_REGION_AUDIT ,
				'roleName' => '大区审核'),
			self::ROLE_THE_AUDIT_TEAM_LEADER => array(
				'id' => self::ROLE_THE_AUDIT_TEAM_LEADER ,
				'roleName' => '审核组长'),
			self::ROLE_DIRECTOR_OF_OPERATIONS => array(
				'id' => self::ROLE_DIRECTOR_OF_OPERATIONS ,
				'roleName' => '运营总监'),
			self::ROLE_AUDIT_OPERATIONS_REGION => array(
				'id' => self::ROLE_AUDIT_OPERATIONS_REGION ,
				'roleName' => '运作部大区审核'),
			self::ROLE_OPERATIONS_MANAGER => array(
				'id' => self::ROLE_OPERATIONS_MANAGER ,
				'roleName' => '运作部经理'));
		return $key ? $data[$key] : $data;
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{offline_sign_audit_logging}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('extend_id, auditor, event, remark,status, create_time', 'required'),
			array('extend_id', 'length', 'max'=>11),
			array('auditor', 'length', 'max'=>128),
			array('event, remark', 'length', 'max'=>255),
			array('create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, extend_id, auditor,audit_role,behavior, event, remark, error_field,create_time', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * 获取审核状态
	 * @param null $key
	 * @return array
	 */
	public static function getStatus($key = null){
		$data = array(
			self::STATUS_NO_PASS => '不通过',
			self::STATUS_PASS => '通过',
		);
		return $key === null ? $data : $data[$key];
	}

	/**
	 * 根据资质id获取最新的审核信息
	 * @param int $extend 店铺id
	 * @param boolean $isManager 是否为后台管理员获取审核信息
	 * @return string $str 审核信息
	 */
	public static function getNewEventByStoreId($extend,$isManager=true){
		$query = Yii::app()->db->createCommand()->select('audit_role,behavior,status')->from(OfflineSignAuditLogging::model()->tableName());

		$where = "extend_id=:id ";
		$params =  array('id'=>$extend);
		$where = $where. ' and '. self::_filterBehaviors($isManager);
		$event = $query->where($where,$params)->order('create_time desc')->limit(1)->queryRow();

		return self::_showEvent($event);
	}


	/**
	 * 代理商后台返回审核记录（屏蔽掉人员和角色）
	 * @param array $event 事件数组
	 * @return string $str
	 */
	public static function _showEvent($event){
		$str = self::getRoleValue($event['audit_role']) . self::learnCode($event['behavior']);
		if($event['status']){
			$str .= self::getStatus($event['status']);
		}
		return $str;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'extend_id' => '资质表id',
            'status' => '审核状态',
			'auditor' => '操作人',
			'audit_role' => '审核角色',
			'behavior' => '当前记录所属的操作',
			'event' => '事件',
			'remark' => '备注',
			'create_time' => '时间',
            'error_field' => '错误字段',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('extend_id',$this->extend_id,true);
		$criteria->compare('auditor',$this->auditor,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 代理商后台使用的审核记录查询
	 * @param int $storeId 店铺id
	 * @return CDbCriteria
	 */
	public function searchStore($storeId){
		$criteria=new CDbCriteria;
		$criteria->select = "create_time,event,behavior,status,remark,audit_role";
		$criteria->addCondition('extend_id='.$storeId);
		//后台人员的添加备注和修改资质记录不给代理商看
		$criteria->addCondition(self::_filterBehaviors());
		return $criteria;
	}

	/**
	 * 区分前台代理商和后台审核人员
	 * 
	 * @param  boolean  $isManager 是否为后台管理人员
	 * @return string
	 * @author xuegang.liu@g-emall.com
	 * @since  2016-02-03T13:33:46+0800
	 */
	private static function _filterBehaviors($isManager=false){

		if($isManager){
			return " 1=1 ";
		}

		$where = 'behavior != 2002 and behavior != 2003';
		return $where;
	}

	/**
	 * 红色后台查询备注
	 * @param $storeId
	 * @return CActiveDataProvider
	 */
	public function searchRemarks($storeId){
		$criteria = new CDbCriteria;
		$criteria->select = 'id,create_time,audit_role,auditor,remark,event';
		$criteria->addCondition('extend_id = ' .$storeId);
		$criteria->addCondition('behavior = 2002');
		$criteria->order = "create_time desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 红色后台查询审核进度
	 * @param $storeId
	 * @return CActiveDataProvider
	 */

	public function seachAuditSchedule($storeId,$behavior=''){
		$criteria = new CDbCriteria();
		$criteria->select = 'id,create_time,remark,event,status,behavior,auditor,audit_role';
        if($behavior)
            $criteria->addCondition('behavior='.$behavior);
		$criteria->addCondition('extend_id = ' .$storeId);
		$criteria->order = "create_time desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * 返回红色后台审核进度
	 *  @param $data
	 */
	public static function returnEvent($data){
		$str = '';
		if(($data->behavior == '2001' && $data->status == OfflineSignAuditLogging::STATUS_NO_PASS)){
			$str .= $data->event;
			$str .= "<br />-----------------------------------<br />";
			$str .= "<span class='noPass'>".$data->remark."</span>";
		}elseif($data->behavior == '2005' || $data->behavior == '2006'){
            $str .= $data->event;
            $str .= "<br />-----------------------------------<br />";
            $str .= "<span style='color:red'>".$data->remark."</span>";
        }else{
			$str .= $data->event;
		}
		return $str;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignAuditLogging the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
