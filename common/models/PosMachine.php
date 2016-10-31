<?php

/**
 * This is the model class for table "{{pos_machine}}".
 *
 * The followings are the available columns in table '{{pos_machine}}':
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
class PosMachine extends CActiveRecord
{       
        public $franchiseeName;//加盟商名称
        public $record_type; //类型
    
    
    
	//状态
	const STATUS_APPLY = 0;   //申请
	const STATUS_ENABLE = 1;  //启用
	const STATUS_DISABLE = 2; //禁用
	public static function getStatus($key = null)
	{
		$data = array(
			self::STATUS_APPLY => Yii::t('PosMachine', '申请'),
			self::STATUS_ENABLE => Yii::t('PosMachine', '启用'),
			self::STATUS_DISABLE => Yii::t('PosMachine', '禁用'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	//是否激活
	const IS_ACTIVATE_YES = 1;
	const IS_ACTIVATE_NO = 0;
	public static function getIsActivate($key = null)
	{
		$data = array(
			self::IS_ACTIVATE_YES => Yii::t('PosMachine', '是'),
			self::IS_ACTIVATE_NO => Yii::t('PosMachine', '否'),
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
	
        
        public static function getStatusUpdate($key = null)
	{
		$data = array(
			//self::STATUS_APPLY => Yii::t('VendingMachine', '申请'),
			self::STATUS_ENABLE => Yii::t('PosMachine', '启用'),
			self::STATUS_DISABLE => Yii::t('PosMachine', '禁用'),
		);
		return $key === null ? $data : $data[$key];
	}
        
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pos_machine}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, province_id, city_id, district_id, address, franchisee_id', 'required'),
                        array('status','required','on'=>'update'),
			array('status, is_activate, country_id, province_id, city_id, district_id, user_id, franchisee_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>12),
			array('activation_code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>128),
			array('symbol', 'length', 'max'=>20),
			array('address', 'length', 'max'=>225),
			array('user_ip', 'length', 'max'=>11),
			array('setup_time, create_time, update_time', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, activation_code, name, status, is_activate, symbol, country_id, province_id, city_id, district_id, address, user_id, user_ip, franchisee_id, setup_time, remark, private_key, public_key, create_time, update_time', 'safe', 'on'=>'search'),
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
			'code' => '装机编码',
			'activation_code' => '激活码',
			'name' => 'POS名称',
			'status' => '状态',
			'is_activate' => '是否激活',
			'symbol' => '币种',
			'country_id' => '国家id',
			'province_id' => '省份id',
			'city_id' => '城市id',
			'district_id' => '区县id',
			'address' => '地址',
			'user_id' => '管理员id',
			'user_ip' => '管理员ip',
			'franchisee_id' => '加盟商',
			'setup_time' => '安装时间',
			'remark' => '备注',
			'private_key' => '私钥',
			'public_key' => '公钥',
			'create_time' => '创建时间',
			'update_time' => '修改时间',
                        'franchiseeName'=>'线下加盟商',
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
		
		$criteria->select = "t.*,f.name as franchiseeName";
		
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.franchisee_id";
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('f.name',$this->franchiseeName,true);
		$criteria->compare('t.code', $this->code,true);
                
		$criteria->order = 't.id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
		    'sort' => false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VendingMachine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * 根据ID查找加盟商名称
         * @param type $id 
         */
        public static function getFranchiseeName($id){
            return Yii::app()->gw->createCommand()->select(array('name'))->from("{{franchisee}}")->where('id=:id',array(':id'=>$id))->queryScalar();
        }
        
        public function beforeSave() {
             if (parent::beforeSave()) {
	            if ($this->isNewRecord) {
	                $this->create_time = time();
                        $this->user_id = Yii::app()->User->id;
	            }
		    $this->update_time = time();
                    $this->user_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
	            return true;
	     }
	        else
	            return false;
        }
}
