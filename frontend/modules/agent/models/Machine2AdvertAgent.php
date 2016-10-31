<?php

/**
 * This is the model class for table "{{machine_2_advert}}".
 *
 * The followings are the available columns in table '{{machine_2_advert}}':
 * @property integer $machine_id
 * @property integer $advert_id
 * @property integer $user_id
 * @property string $user_ip
 * @property string $create_time
 * @property integer $sort
 */
class Machine2AdvertAgent extends ActiveRecord
{       
        public $name;
	public $address;
	public $biz_name;
	public $run_status;
        public $agent_ss;


        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_2_advert}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('machine_id, advert_id, user_id, user_ip, create_time, sort', 'safe', 'on'=>'search'),
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
			'machine_id' => '盖机编号',
			'machine_name' => Yii::t('Machine','盖机名称'),
			'advert_id' => '广告编号',
			'user_id' => '管理员',
			'user_ip' => '管理员ip',
			'create_time' => '创建时间',
			'sort' => '排序',
			'machine_status' => Yii::t('Machine','盖机状态'),
			'machine_address' => Yii::t('Machine','盖机地址'),
			'machine_area' => Yii::t('Machine','盖机地区'),
			'machine_service' => Yii::t('Machine','线下服务商')
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
		$criteria->select = "t.sort,t.machine_id,machine.name,machine.run_status,machine.address,f.name as biz_name";
		$criteria->compare('t.advert_id',$this->advert_id);			//广告id
		$criteria->join = " left join ".  MachineAgent::model()->tableName()." machine on (machine.id = t.machine_id and machine.status = ".  MachineAgent::STATUS_ENABLE.")";
		$criteria->join.= " left join gaiwang.gw_franchisee f on f.id = machine.biz_info_id ";
                
        $agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
		$sql = "";
		if($agent_region['provinceId']!=""){
		$sql.= $sql==""?"machine.province_id in(".$agent_region['provinceId'].")":"";
		}
                
		if($agent_region['cityId']!=""){
			$sql.= $sql==""?"machine.city_id in(".$agent_region['cityId'].")":" or machine.city_id in(".$agent_region['cityId'].")";
		}
		
		if($agent_region['districtId']!=""){
			$sql.= $sql==""?"machine.district_id in(".$agent_region['districtId'].")":" or machine.district_id in(".$agent_region['districtId'].")";
		}
		if($sql!='')$criteria->addCondition ("(".$sql.")");
          
                
		$criteria->order = "t.sort desc";
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>9,
			    ),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}
        
        /**
	 * grid里面显示状态
	 */
	public static function runStatus($status){
		if($status==  MachineAgent::RUN_STATUS_OPERATION){
			 return '<span class="online">'.  MachineAgent::getRunStatus($status).'</span>';
		}else if($status==  MachineAgent::RUN_STATUS_STOP){
			 return '<span class="offline">'.  MachineAgent::getRunStatus($status).'</span>';
		}else{
			 return '<span class="uninstall">'.  MachineAgent::getRunStatus($status).'</span>';
		}
	}
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Machine2AdvertAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
