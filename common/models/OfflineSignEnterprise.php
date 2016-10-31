<?php

/**
 * This is the model class for table "{{offline_sign_enterprise}}".
 *
 * The followings are the available columns in table '{{offline_sign_enterprise}}':
 * @property string $id
 * @property string $name
 * @property integer $is_chain
 * @property integer $chain_type
 * @property integer $chain_number
 * @property string $linkman_name
 * @property string $linkman_position
 * @property string $linkman_webchat
 * @property string $linkman_qq
 * @property integer $enterprise_type
 * @property string $enterprise_license_number
 * @property string $registration_time
 * @property string $license_begin_time
 * @property string $license_is_long_time
 * @property string $license_end_time
 * @property string $legal_man
 * @property string $legal_man_identity
 * @property string $tax_id
 * @property string $license_image
 * @property string $tax_image
 * @property string $identity_image
 * @property integer $account_pay_type
 * @property string $payee_identity_number
 * @property string $bank_province_id
 * @property string $bank_city_id
 * @property string $bank_district_id
 * @property string $bank_permit_image
 * @property string $bank_account_image
 * @property string $entrust_receiv_image
 * @property string $payee_identity_image
 * @property string $create_time
 * @property string $update_time
 * @property string $error_field
 */
class OfflineSignEnterprise extends CActiveRecord
{

	public $step;					//用户点击的是上一步 还是
	const LAST_STEP = 1;			//上一步
	const NEXT_STEP = 2;			//下一步

	CONST LONG_TIME_YES = 1;
	CONST LONG_TIME_NO = 0;

	public static function getLongTime($key = null){
		$data = array(
			self::LONG_TIME_NO => '否',
			self::LONG_TIME_YES => '是',
		);

		if($key==null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	//结算账户类型
	const ACCOUNT_PAY_TYPE_PUBLIC = 1;		//对公
	const ACCOUNT_PAY_TYPE_PRIVATE = 2;		//对私

	/**
	 * 获取结算账户类型
	 * @param null $key
	 * @return array
	 */
	public static function getAccountPayType($key = null){

		$data = array(
			self::ACCOUNT_PAY_TYPE_PUBLIC => '对公',
			self::ACCOUNT_PAY_TYPE_PRIVATE => '对私',
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	//企业类型
	const ENTER_TYPE_IIACH = 1;		//个体工商户
	const ENTER_TYPE_ELPER = 2;		//企业法人
	const ENTER_TYPE_OBTWP = 3;		//全民所有制
	const ENTER_TYPE_FPWRK = 4;		//农民专业工作社
	const ENTER_TYPE_GADIS = 5;		//事业单位

	/**
	 * 获取企业类型
	 * @param null $key
	 * @return array
	 */
	public static function getEnterType($key = null){

		$data = array(
			self::ENTER_TYPE_IIACH => '个体工商户',
			self::ENTER_TYPE_ELPER => '企业法人',
			self::ENTER_TYPE_OBTWP => '全民所有制',
			self::ENTER_TYPE_FPWRK => '农民专业工作社',
			self::ENTER_TYPE_GADIS => '事业单位',
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	//企业连锁形态
	const CHAIN_TYPE_DIRECT = 1;	//直营
	const CHAIN_TYPE_FRANCHIS = 2;	//加盟
	const CHAIN_TYPE_MIXED = 3;		//混合

	/**
	 * 获取企业连锁形态
	 * @param null $key
	 */
	public static function getChainType($key = null){

		$data = array(
			self::CHAIN_TYPE_DIRECT => '直营',
			self::CHAIN_TYPE_FRANCHIS => '加盟',
			self::CHAIN_TYPE_MIXED => '混合型',
		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}

	const IS_CHAIN_NO = 0;			//不是连锁
	const IS_CHAIN_YES = 1;			//是连锁

	/**
	 * 是否连锁
	 * @param null $key
	 */
	public static function getIsChain($key = null){

		$data = array(
            self::IS_CHAIN_YES => '是',
			self::IS_CHAIN_NO => '否',

		);

		if($key===null) return $data;
		return isset($data[$key]) ? $data[$key] : '未知';
	}


	/**
	 * 根据合同id，生成企业信息
	 * @param int $contractId 合同id
	 * @return string 企业id
	 */
	public static function createEnterpriseByContractId($contractId){
		$result = Yii::app()->db->createCommand()->insert(self::model()->tableName(),array(
			'offline_sign_contract_id'=>$contractId,
			'create_time'=>time()
		));
		if($result)
			return Yii::app()->db->getLastInsertID();
		else return '';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		// return '{{offline_sign_enterprise}}';
		return self::getTableName();
	}

	public static function getTableName(){
		return '{{offline_sign_enterprise}}';	
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('legal_man_identity','filter','filter'=>'trim'),
			array('name, linkman_name, linkman_position, enterprise_type, enterprise_license_number, registration_time, license_begin_time,
				legal_man,legal_man_identity, tax_id, license_image, tax_image, identity_image, account_pay_type, update_time', 'required'),
			
			array('chain_number', 'numerical', 'integerOnly'=>true,'min'=>0,'message'=>'请填写正整数'),
            array('linkman_qq','match','pattern'=>'/^[1-9][0-9]{4,10}$/','message'=>'QQ号格式错误'),
			array('bank_province_id, bank_city_id, bank_district_id', 'required',
				'message' => Yii::t('enterprise', Yii::t('enterprise', '请选择 {attribute}'))),
			array('license_end_time', 'comext.validators.compareDateTime', 'compareAttribute' => 'license_begin_time', 'allowEmpty' => true,
				'operator' => '>','message' => '营业期限结束时间 必须大于 营业期限开始时间'),

			//对私
			array(
				'account_pay_type', 'comext.validators.YiiConditionalValidator',
				'if'=>array(array('account_pay_type', 'compare', 'compareValue'=>self::ACCOUNT_PAY_TYPE_PRIVATE)),
				'then'=>array(array('payee_identity_number,bank_account_image,payee_identity_image', 'required'))
			),

			//对公
			array(
				'account_pay_type', 'comext.validators.YiiConditionalValidator',
				'if'=>array(array('account_pay_type', 'compare', 'compareValue'=>self::ACCOUNT_PAY_TYPE_PUBLIC)),
				'then'=>array(array('bank_permit_image', 'required'))
			),
			array('entrust_receiv_image','reciveRequired'),

			//当没有勾选 长期 ，则营业期限必填  *需关闭客户端验证'enableClientValidation' => false,*
			array(
				'license_end_time', 'comext.validators.YiiConditionalValidator',
				'if'=>array(array('license_is_long_time', 'compare', 'compareValue'=>self::LONG_TIME_NO, 'allowEmpty'=>false)),
				'then'=>array(array('license_end_time', 'required'))
			),

			/*当选择了连锁，则连锁数量必填*/
			array('chain_number','comext.validators.YiiConditionalValidator','if'=>array(
				array('is_chain','compare','compareValue'=>1),
			),'then'=>array(
				array('chain_number','required'),
			)),
			array('bank_province_id, bank_city_id, bank_district_id, license_image, tax_image,
				identity_image, bank_permit_image, bank_account_image, payee_identity_image,entrust_receiv_image', 'length', 'max'=>11),
			array('name, linkman_name, linkman_position, linkman_webchat, linkman_qq, enterprise_license_number, legal_man, tax_id, payee_identity_number', 'length', 'max'=>128),

			array('registration_time, license_begin_time, license_end_time, create_time, update_time', 'length', 'max'=>10),
			// array('legal_man_identity', 'length', 'max'=>32),
			array('legal_man_identity,payee_identity_number','isCreditId'),
			array('payee_identity_number','match','pattern'=>'/^\d{17}[\dX]$/','message'=>'格式不合法','allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, is_chain, chain_type, chain_number, linkman_name, linkman_position, linkman_webchat,
				linkman_qq, enterprise_type, enterprise_license_number, registration_time, license_begin_time, license_end_time, legal_man,
				legal_man_identity, tax_id, license_image, tax_image, identity_image, account_pay_type, payee_identity_number, bank_province_id, 
				bank_city_id, bank_district_id, bank_permit_image, bank_account_image, payee_identity_image, create_time, update_time, entrust_receiv_image,
				error_field', 'safe', 'on'=>'search'),
            array('id, name, is_chain, chain_type, chain_number, linkman_name, linkman_position, linkman_webchat,
				linkman_qq, enterprise_type, enterprise_license_number, registration_time, license_begin_time, license_end_time, legal_man,
				legal_man_identity, tax_id, license_image, tax_image, identity_image, account_pay_type, payee_identity_number, bank_province_id,
				bank_city_id, bank_district_id, bank_permit_image, bank_account_image, payee_identity_image, create_time, update_time, entrust_receiv_image,
				error_field,step,license_is_long_time', 'safe'),
		);
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
    public function isCreditId($attribute,$params){
        if(OfflineSignEnterprise::isCredit($this->legal_man_identity)){
            return true;
        }
            return $this->addError($attribute,'身份证格式不对');
    }
    /**
     * 验证身份证号
     * @param $vStr
     * @return bool
     */
    public static function  isCredit($idcard){

        // 只能是18位
        if(strlen($idcard)!=18){
            return false;
        }

        // 取出本体码
        $idcard_base = substr($idcard, 0, 17);

        // 取出校验码
        $verify_code = substr($idcard, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0','X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for($i=0; $i<17; $i++){
            $total += substr($idcard_base, $i, 1)*$factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if($verify_code == $verify_code_list[$mod]){
            return true;
        }else{
            return false;
        }

    }

    /**
	 * beforeValidata
	 */
	protected function beforeValidate()
	{
		if(!parent::beforeValidate()) return false;
		$this->registration_time = empty($this->registration_time) ? null : strtotime($this->registration_time);
		$this->license_begin_time = empty($this->license_begin_time) ? null : strtotime($this->license_begin_time);
		$this->license_end_time = empty($this->license_end_time) ? null : strtotime($this->license_end_time);
		$this->update_time = time();
        if($this->is_chain == OfflineSignEnterprise::IS_CHAIN_NO){
            $this->chain_number = 0;
            $this->chain_type = '';
        }
		return true;
	}

	/**
	 * beforeSave
	 */
	protected function beforeSave()
	{
		if(!parent::beforeSave()) return false;
		if($this->license_is_long_time){
			$this->license_end_time = null;
		}
        if($this->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE){
            $this->bank_permit_image = '';
        }else{
            $this->payee_identity_number = '';
            $this->bank_account_image = '';
            $this->payee_identity_image = '';
        }
		return true;
	}

	/**
	 * afterFind
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->registration_time = empty($this->registration_time) ? null : date('Y-m-d',$this->registration_time);
 		$this->license_begin_time = empty($this->license_begin_time) ? null : date('Y-m-d',$this->license_begin_time);
 		$this->license_end_time = empty($this->license_end_time) ? null : date('Y-m-d',$this->license_end_time);
        if($this->account_pay_type == OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PRIVATE){
            $this->bank_permit_image = '';
        }else{
            $this->payee_identity_number = '';
            $this->bank_account_image = '';
            $this->payee_identity_image = '';
        }
 		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '企业名称',
			'is_chain' => '是否连锁',
			'chain_type' => '企业连锁形态',
			'chain_number' => '连锁数量',
			'linkman_name' => '企业联系人姓名',
			'linkman_position' => '企业联系人职位',
			'linkman_webchat' => '企业联系人微信',
			'linkman_qq' => '企业联系人QQ',
			'enterprise_type' => '企业类型',
			'enterprise_license_number' => '营业执照注册号',
			'registration_time' => '成立日期',
			'license_begin_time' => '营业期限开始日期',
			'license_is_long_time' => '营业期限是否长期',
			'license_end_time' => '营业期限结束时间',
			'legal_man' => '法人代表',
			'legal_man_identity' => '法人身份证号',
			'tax_id' => '税务登记证',
			'license_image' => '营业执照电子版',
			'tax_image' => '税务登记证电子版',
			'identity_image' => '法人身份证电子版',
			'account_pay_type' => '结算账户类型',
			'payee_identity_number' => '收款人身份证号码',
			'bank_province_id' => '开户行区域 省',
			'bank_city_id' => '开户行区域 省',
			'bank_district_id' => '开户行区域 区',
			'bank_permit_image' => '开户许可证电子版',
			'bank_account_image' => '银行卡复印件（只限对私账）电子版',
			'entrust_receiv_image' => '委托收款授权书电子版',
			'payee_identity_image' => '收款人身份证电子版',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'error_field' => 'Error Field',
		);
	}
    public static function getErrorEnter(){
        return array(
                "e.name",
                "e.is_chain",
                "e.chain_type",
                "e.chain_number",
                "e.linkman_name",
                "e.linkman_position",
                "e.linkman_webchat",
                "e.linkman_qq",
                "e.enterprise_type",
                "e.b_name",
                "e.enterprise_license_number",
                "e.registration_time",
                "e.license_begin_time",
                "e.license_end_time",
                "e.legal_man",
                "e.legal_man_identity",
                "e.tax_id",
                "e.license_image",
                "e.tax_image",
                "e.identity_image",
                "e.account_pay_type",
                "e.payee_identity_number",
                "e.bank_district_id",
                "e.bank_account_image",
                "e.payee_identity_image"
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
		$criteria->compare('offline_sign_contract_id',$this->offline_sign_contract_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_chain',$this->is_chain);
		$criteria->compare('chain_type',$this->chain_type);
		$criteria->compare('chain_number',$this->chain_number);
		$criteria->compare('linkman_name',$this->linkman_name,true);
		$criteria->compare('linkman_position',$this->linkman_position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignEnterprise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
