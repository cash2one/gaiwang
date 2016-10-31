<?php

/**
 * This is the model class for table "{{offline_sign_contract}}".
 *
 * The followings are the available columns in table '{{offline_sign_contract}}':
 * @property string $id
 * @property string $number
 * @property string $a_name
 * @property string $b_name
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $address
 * @property string $p_province_id
 * @property integer $p_city_id
 * @property integer $p_district_id
 * @property integer $contract_term
 * @property string $begin_time
 * @property string $end_time
 * @property string $sign_type
 * @property string $sign_time
 * @property string $machine_developer
 * @property string $contract_linkman
 * @property integer $operation_type
 * @property integer $ad_begin_time_hour
 * @property integer $ad_begin_time_minute
 * @property integer $ad_end_time_hour
 * @property integer $ad_end_time_minute
 * @property string $bank_name
 * @property string $account_name
 * @property string $account
 * @property string $franchisee_developer
 * @property string $machine_belong_to
 * @property string $create_time
 * @property string $update_time
 * @property string $error_field
 */
class OfflineSignContract extends CActiveRecord
{

	public $step;
	const LAST_STEP = 1;			//保存并打印合同信息
	const NEXT_STEP = 2;			//保存并进入下一步

	public $apply_type;					//新增类型
	public $enterpriseName;				//企业名称
	public $enterpriseId;
	public $storeId;

	//3种方式的开始时间段
	public $ad_begin_time_hour_one;
	public $ad_begin_time_hour_two;
	public $ad_begin_time_hour_three;
	public $ad_begin_time_minute_one;
	public $ad_begin_time_minute_two;
	public $ad_begin_time_minute_three;
	//3种方式的结束时间段
	public $ad_end_time_hour_one;
	public $ad_end_time_hour_two;
	public $ad_end_time_hour_three;
	public $ad_end_time_minute_one;
	public $ad_end_time_minute_two;
	public $ad_end_time_minute_three;

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

	/**
	 *获取小时
	 */
	public static function getAdHour($key = null){
		$arr = array();
		for($i = 0 ; $i < 24 ; $i++){
			$arr[$i] = strlen($i) ==2 ? $i : '0'. $i;
		}
		return $key === null ? $arr : $arr[$key];
	}

	/**
	 * 获取分钟
	 */
	public static function getAdMiute($key = null){
		$arr = array();
		for($i = 0 ; $i < 60 ; $i = $i + 5){
			$arr[$i] = strlen($i) ==2 ? $i : '0'. $i;
		}
		return $key === null ? $arr : $arr[$key];
	}

	//乙方权益方式
	const OPERATION_TYPE_ONE = 1;
	const OPERATION_TYPE_TWO = 2;
	const OPERATION_TYPE_THREE = 3;

	/**
	 * 获取乙方权益的方式
	 * @param null $key
	 */
	public static function getOperationType($key = null){
		$data = array(
			self::OPERATION_TYPE_ONE => '方式一',
			self::OPERATION_TYPE_TWO => '方式二',
			self::OPERATION_TYPE_THREE => '方式三',
		);
		return $key === null ? $data : $data[$key];
	}

	//合同期限  为方便计算，全部使用月份
	const CONTRACT_TERM_THREE_MONTHS = 3;			//3个月
	const CONTRACT_TERM_SIX_MONTHS = 6;				//6个月
	const CONTRACT_TERM_ONE_YEAR = 12;				//1年
	const CONTRACT_TERM_TWO_YEARS = 24;				//2年
	const CONTRACT_TERM_THREE_YEARS = 36;			//3年
	const CONTRACT_TERM_FOUR_YEARS = 48;			//4年
	const CONTRACT_TERM_FIVE_YEARS = 60;			//5年
	const CONTRACT_TERM_DECADE = 120;				//10年

	/**
	 * 获取合同期限
	 * @param null $key 期限
	 * @return array
	 */
	public static function getContractTerm($key = null){
		$data = array(
			self::CONTRACT_TERM_THREE_MONTHS => Yii::t('OfflineSignContract','3个月'),
			self::CONTRACT_TERM_SIX_MONTHS => Yii::t('OfflineSignContract','6个月'),
			self::CONTRACT_TERM_ONE_YEAR => Yii::t('OfflineSignContract','1年'),
			self::CONTRACT_TERM_TWO_YEARS => Yii::t('OfflineSignContract','2年'),
			self::CONTRACT_TERM_THREE_YEARS => Yii::t('OfflineSignContract','3年'),
			self::CONTRACT_TERM_FOUR_YEARS => Yii::t('OfflineSignContract','4年'),
			self::CONTRACT_TERM_FIVE_YEARS => Yii::t('OfflineSignContract','5年'),
			self::CONTRACT_TERM_DECADE => Yii::t('OfflineSignContract','10年'),
		);
		return $key === null ? $data : $data[$key];
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		// return '{{offline_sign_contract}}';
		return self::getTableName();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, a_name, b_name, address,contract_term, sign_type,begin_time, end_time, ad_begin_time_hour,
				ad_begin_time_minute, ad_end_time_hour, ad_end_time_minute,enterprise_proposer,mobile,
				bank_name, account_name, account, update_time,sign_time','required'),

			array('p_city_id, p_district_id, contract_term, operation_type, ad_begin_time_hour, 
				ad_begin_time_minute, ad_end_time_hour, ad_end_time_minute', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time', 'length', 'max'=>10),
			array('province_id, city_id, district_id', 'required',
				'message' => Yii::t('enterprise', Yii::t('enterprise', '请选择 {attribute}'))),
			array('number', 'length', 'max'=>20),

			array('mobile,franchisee_mobile,machine_administrator_mobile', 'comext.validators.isMobile', 'errMsg' => '请输入正确的您的手机号码'),
            array('mobile','isGWMobile'),
			array('a_name, b_name, bank_name, account_name,contract_linkman', 'length', 'max'=>128),
            array('account', 'match', 'pattern' => '/^[0-9]*[0-9]*$/'),
			array('province_id, city_id, district_id, p_province_id, begin_time, end_time', 'length', 'max'=>11),
			array('address, account', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, a_name, b_name, province_id, city_id, district_id, address, p_province_id, p_city_id, p_district_id, 
				contract_term, begin_time, end_time, operation_type, ad_begin_time_hour, ad_begin_time_minute,sign_type, contract_linkman,ad_end_time_hour,
				ad_end_time_minute, bank_name, account_name, account, create_time, update_time, error_field,franchisee_developer,machine_belong_to', 'safe', 'on'=>'search'),
			
			array('apply_type,enterpriseName,enterpriseId,storeId,step','safe'),
		);
	}
    public function isGWMobile($attribute,$params){
        $shitss = empty($this->number)?0:$this->number;
        $memberInfo = self::chectMobile($this->$attribute,$shitss);
        if($memberInfo){
            return $this->addError($attribute,$memberInfo);
        }
        return true;
    }
    public static function chectMobile($mobile,$number){
        if(empty($mobile)) return false;
        $conId = Yii::app()->db->createCommand()
            ->select('id')
            ->from(self::model()->tableName())
            ->where('mobile = :mobile and number != :number' , array(':mobile' => $mobile,':number'=>$number))
            ->queryAll();
        if(!empty($conId)) {
            foreach($conId as $val){
                $reconId = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from(OfflineSignStoreExtend::model()->tableName())
                    ->where('offline_sign_contract_id = :offline_sign_contract_id and audit_status != :audit_status ' , array(':offline_sign_contract_id' => $val['id'],':audit_status'=>OfflineSignStoreExtend::AUDIT_STATUS_EXA_SUCCES))
                    ->queryScalar();
                if(!empty($reconId)){
                    return '企业GW手机号已提交申请';
                }
            }
        }
        $b_name = Yii::app()->db->createCommand()
            ->select('mobile')
            ->from(Member::model()->tableName())
            ->where('mobile = :mobile' , array(':mobile' => $mobile))
            ->queryScalar();
        if(!empty($b_name)) return '企业GW手机号已存在';
        return false;
    }
    public function reciveRequired($attribute,$params){
        if($this->account_pay_type ==self::ACCOUNT_PAY_TYPE_PUBLIC ||  $this->payee_identity_number == $this->legal_man_identity){
            $this->$attribute = null;
            return true;
        }
        if(empty($this->$attribute)){
            return $this->addError($attribute,'委托收款授权书不能为空');
        }
        return true;
    }
	/**
	 * 检验之前方法
	 * @return bool
	 */
	protected function beforeValidate(){

		if(!parent::beforeValidate()) return false;

		if($this->isNewRecord){
			$this->create_time = time();
		}
		$this->end_time = strtotime($this->begin_time .' +'.$this->contract_term.' months');
		$this->end_time = $this->end_time - 24*60*60;
		$this->begin_time =  strtotime($this->begin_time);
		$this->update_time = time();
		return true;
	}


	/**
	 *获取当前登录的用户的企业姓名
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
	 * 生成合同号
	 * 格式G2205-L-2015000000
	 * G2205-L- (这部分所有的都一样)  + 年份 + 用0补足的6位递增序号
	 */
	public static function createContractNumber($lastNuber=null){

		static $prefix = null;
		// static $lastNuber = null;

		if($lastNuber===null ){
			$prefix = 'G2205-L-' . date('Y');
			$lastNuber = Yii::app()->db->createCommand()->select('number')
				 	->from(self::model()->tableName())->where("number != '' ")->order('id desc')->limit(1)->queryScalar();
		}
		
		if($lastNuber===false){
			$num = 1;	
		}else{
			$lastNuber = substr($lastNuber,-6);
			$num = (int)$lastNuber + 1;
		}

		$no = $prefix . str_pad($num, 6,'0',STR_PAD_LEFT);
		if(self::validateNumberCode($no)){
			$no = self::createContractNumber($lastNuber);
		}
		
		return $no;
	}

	/**
	 * 判断合同编号是否存在
	 * @param string $num 合同编号
	 */
	public static function validateNumberCode($num){
		$id = Yii::app()->db->createCommand()
							->select('id')
							->from(self::model()->tableName())
							->where('number = :num' , array(':num' => $num))
							->queryScalar();
		if(!empty($id)) return true;
		else return false;
	}

	/**
	 * @param $no
	 * 生成用0补足的6位号码
	 */
	public static function createSixNo($no){
		$length = strlen($no);
		$need = 6 - $length;
		for($i = 0 ; $i < $need ; $i++){
			$no = '0' . $no;
		}
		return $no;
	}

	/**
	 * 获取电签合同信息，企业信息，店铺信息
	 * 
	 * @param  interge $contractId 合同ID
	 * @return mix
	 */
	/*public static function getOfflineSiginInfos($id){

		if(empty($id)) return null;

		$criteria = new CDbCriteria;
		$criteria->alias = 't';
		$criteria->select = 't.*,e.id as enterpriseId,s.id as storeId,s.apply_type,e.name as enterpriseName';
		$criteria->join = ' LEFT JOIN '.OfflineSignEnterprise::getTableName().' as e ON e.offline_sign_contract_id=t.id';
		$criteria->join .= ' LEFT JOIN '.OfflineSignStore::getTableName().' as s ON s.offline_sign_enterprise_id=e.id';
		$criteria->condition = "t.id=:id";
		$criteria->params = array(':id'=>$id);

		$res = self::model()->find($criteria);
		return $res;
	}*/
    public static function getOfflineSiginInfos($id){

        if(empty($id)) return null;

        $criteria = new CDbCriteria;
        $criteria->alias = 't';
        $criteria->select = 't.*,s.apply_type,s.offline_sign_enterprise_id,e.id,e.name as enterpriseName';
        $criteria->join = ' LEFT JOIN '.OfflineSignStoreExtend::getTableName().' as s ON s.offline_sign_contract_id=t.id';
        $criteria->join .= ' LEFT JOIN '.OfflineSignEnterprise::getTableName().' as e ON e.id=s.offline_sign_enterprise_id';
        $criteria->condition = "t.id=:id";
        $criteria->params = array(':id'=>$id);

        $res = self::model()->find($criteria);
        return $res;
    }
    /**
     * afterFind
     */
    protected function afterFind()
    {
        parent::afterFind();
        $this->sign_time = empty($this->sign_time) ? null : date('Y-m-d',$this->sign_time);
        return true;
    }
    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => '合同编号',
			'a_name' => '甲方名称',
			'b_name' => '乙方名称',
			'province_id' => '省',
			'city_id' => '市',
			'district_id' => '区',
			'address' => '详细地址',
			'p_province_id' => '推广地区所在省份',
			'p_city_id' => '推广地区所在城市',
			'p_district_id' => '推广地区所在区域',
			'contract_term' => '合作期限',
			'begin_time' => '合同期限起始日期',
			'end_time' => '合同期限结束日期',
			'sign_type' => '签约类型',
			'sign_time' => '签约日期',
            'enterprise_proposer'=>'企业GW号开通人',
            'mobile'=>'企业GW号开通手机',
			'machine_developer' => '销售开发人',
			'contract_linkman' => '合同跟进人',
			'operation_type' => '合作方式',
			'ad_begin_time_hour' => '广告时间段 开始时',
			'ad_begin_time_minute' => '广告时间段 开始分',
			'ad_end_time_hour' => '广告时间段 结束时',
			'ad_end_time_minute' => '广告时间段 结束分',
			'bank_name' => '开户行名称',
			'account_name' => '账户名称',
			'account' => '银行帐号',
			'franchisee_developer' => '加盟商开发方',
			'machine_belong_to' => '机器归属方',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
			'error_field' => '错误字段',
			'ad_begin_time_hour_one' => '',
			'ad_begin_time_hour_two' => '',

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
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignContract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getTableName(){

		return '{{offline_sign_contract}}';
	}

	/**
	 * 根据广告合约类型 设置合约广告起止时间
	 * 
	 * @param  object  $model  OfflineSignContract
	 * @param  boolean
	 */
	public static function setContractAdExpires($model,$dataArr){

		$operationMap = array(
			self::OPERATION_TYPE_ONE => array('ad_begin_time_hour_one','ad_begin_time_minute_one'),
			self::OPERATION_TYPE_TWO => array('ad_begin_time_hour_two','ad_begin_time_minute_two'),
			self::OPERATION_TYPE_THREE => array('ad_begin_time_hour_three','ad_begin_time_minute_three'),
		);

		if(!isset($operationMap[$model->operation_type])) throw new Exception("数据异常", 404);
		$operationTypeInfo = $operationMap[$model->operation_type];

		$model->ad_begin_time_hour = $dataArr[$operationTypeInfo[0]];
		$model->ad_begin_time_minute = $dataArr[$operationTypeInfo[1]];
		$temp = $model->ad_begin_time_hour + 3 ;
		$model->ad_end_time_hour = $temp >= 24 ? $temp -3 : $temp;
		$model->ad_end_time_minute = $model->ad_begin_time_minute;

		return true;
	}

	/**
	 * 根据广告合约类型 格式化指定合约类型广告起止时间
	 *    tips : 设置追加属性值  eg : ad_begin_time_hour_one
	 * 
	 * @param  object  $model OfflineSignContract
	 * @return boolean
	 */
	public static function formatContractAdExpires($model){

		switch($model->operation_type){
			case self::OPERATION_TYPE_ONE:
				$model->ad_begin_time_hour_one = $model->ad_begin_time_hour;
				$model->ad_begin_time_minute_one = $model->ad_begin_time_minute;
				$model->ad_end_time_hour_one = $model->ad_end_time_hour;
				$model->ad_end_time_minute_one = $model->ad_end_time_minute;
				break;
			case self::OPERATION_TYPE_TWO:
				$model->ad_begin_time_hour_two = $model->ad_begin_time_hour;
				$model->ad_begin_time_minute_two = $model->ad_begin_time_minute;
				$model->ad_end_time_hour_two = $model->ad_end_time_hour;
				$model->ad_end_time_minute_two = $model->ad_end_time_minute;
				break;
			case self::OPERATION_TYPE_THREE:
				$model->ad_begin_time_hour_three = $model->ad_begin_time_hour;
				$model->ad_begin_time_minute_three = $model->ad_begin_time_minute;
				$model->ad_end_time_hour_three = $model->ad_end_time_hour;
				$model->ad_end_time_minute_three = $model->ad_end_time_minute;
				break;
		}
		return true;
	}
}
