<?php

/**
 * This is the model class for table "{{vending_machine}}".
 *
 * The followings are the available columns in table '{{vending_machine}}':
 * @property integer $id
 * @property string $code
 * @property string $activation_code
 * @property string $name
 * @property integer $status
 * @property integer $is_activate
 * @property string $symbol
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $address
 * @property integer $user_id
 * @property string $user_ip
 * @property integer $franchisee_id
 * @property string $setup_time
 * @property string $remark
 * @property string $private_key
 * @property string $public_key
 * @property string $create_time
 * @property string $update_time
 */
class VendingMachine extends CActiveRecord
{
	public $isExport;   //是否导出excel
	public $exportPageName = 'page'; //导出excel起始
	public $exportLimit = 5000; //导出excel长度
	public $biz_name;
	
	const VSHOPKEEPER = 1;				//掌柜接口版本号
	
	const OS_TYPE_ANDROID = 1;
	const OS_TYPE_IOS = 2;
	
	//状态
	const STATUS_APPLY = 0;   //申请
	const STATUS_ENABLE = 1;  //启用
	const STATUS_DISABLE = 2; //禁用
	public static function getStatus($key = null)
	{
		$data = array(
			self::STATUS_APPLY => Yii::t('VendingMachine', '申请'),
			self::STATUS_ENABLE => Yii::t('VendingMachine', '启用'),
			self::STATUS_DISABLE => Yii::t('VendingMachine', '禁用'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	//是否激活
	const IS_ACTIVATE_YES = 1;
	const IS_ACTIVATE_NO = 0;
	public static function getIsActivate($key = null)
	{
		$data = array(
			self::IS_ACTIVATE_YES => Yii::t('Shopkeeper', '是'),
			self::IS_ACTIVATE_NO => Yii::t('Shopkeeper', '否'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	//币种类型
	const RENMINBI = "RMB";
	const HONG_KONG_DOLLAR = "HKD";
	const DOLLAR = "USD";					
	const EN_DOLLAR = "EN";
    public static function getMoney($key = null){
		$data = array(
			self::RENMINBI => Yii::t('Machine', '人民币'),
			self::HONG_KONG_DOLLAR => Yii::t('Machine', '港币'),
			self::EN_DOLLAR => Yii::t('Machine', '英镑'),
		);
		return $key === null ? $data : $data[$key];
    }
	
    
    public function getDbConnection() {
    	return Yii::app()->gt;
    }
    
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vending_machine}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, activation_code, name, status, is_activate, province_id, city_id, district_id, address, user_id, user_ip, franchisee_id, setup_time, remark, private_key, public_key, create_time, update_time', 'required'),
			array('status, is_activate, country_id, province_id, city_id, district_id, user_id, franchisee_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>12),
			array('activation_code', 'length', 'max'=>50),
			array('name,biz_name', 'length', 'max'=>128),
			array('symbol', 'length', 'max'=>20),
			array('address', 'length', 'max'=>225),
			array('user_ip', 'length', 'max'=>11),
			array('setup_time, create_time, update_time', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, activation_code, name, status, is_activate, symbol, country_id, province_id, city_id, district_id, address, user_id, user_ip, franchisee_id, setup_time, remark, private_key, public_key, create_time, update_time,biz_name', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => '装机编码，由系统自动生成,12位数字组成',
			'activation_code' => '系统生成的激活码',
			'name' => '售货机名称',
			'status' => '状态（0、申请 1、启用 2、禁用）',
			'is_activate' => '是否激活（0未激活、1已激活）',
			'symbol' => '币种(RMB、HKD)',
			'country_id' => '国家id',
			'province_id' => '省份id',
			'city_id' => '城市id',
			'district_id' => '区县id',
			'address' => '地址',
			'user_id' => '管理员id',
			'user_ip' => '管理员ip',
			'franchisee_id' => '加盟商id',
			'setup_time' => '安装时间',
			'remark' => '备注',
			'private_key' => '私钥',
			'public_key' => '公钥',
			'create_time' => '创建时间',
			'update_time' => '修改时间',
			'biz_name' => Yii::t('machine','加盟商名称'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('activation_code',$this->activation_code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_activate',$this->is_activate);
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('franchisee_id',$this->franchisee_id);
		$criteria->compare('setup_time',$this->setup_time,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('private_key',$this->private_key,true);
		$criteria->compare('public_key',$this->public_key,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		
		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => $pagination,
		));
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
	public function backendSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
		$criteria->select = "t.id,t.name,t.province_id,t.city_id,t.district_id,f.name as biz_name,r.name as city_name";
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.franchisee_id";
		$criteria->join.= " left join gaiwang.gw_region r on r.id = t.province_id";
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('t.activation_code',$this->activation_code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.is_activate',$this->is_activate);
		$criteria->compare('t.symbol',$this->symbol,true);
		$criteria->compare('t.country_id',$this->country_id);
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->compare('t.address',$this->address,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.user_ip',$this->user_ip,true);
		$criteria->compare('t.franchisee_id',$this->franchisee_id);
		$criteria->compare('t.setup_time',$this->setup_time,true);
		$criteria->compare('t.remark',$this->remark,true);
		$criteria->compare('t.private_key',$this->private_key,true);
		$criteria->compare('t.public_key',$this->public_key,true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);

		$criteria->compare('f.name', $this->biz_name, true);
	
		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => $pagination,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shopkeeper the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
