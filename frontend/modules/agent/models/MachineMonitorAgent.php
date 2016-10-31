<?php

/**
 * This is the model class for table "{{machine_monitor}}".
 *
 * The followings are the available columns in table '{{machine_monitor}}':
 * @property string $id
 * @property integer $machine_id
 * @property string $path
 * @property string $create_time
 * @property integer $status
 * @property string $ip
 */
class MachineMonitorAgent extends CActiveRecord
{       
        const STATUS_NORMAL = 1;		//状态正常
	const STATUS_UNUSUAL = 2;		//状态异常
	
        public $agent_ss;//代理商地区session
        public $create_time_end, $machine_name,$level;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_monitor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('create_time_end,machine_name,machine_id, path, create_time, status, ip','safe'),
                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, machine_id, path, create_time, status, ip, machine_name,create_time_end,level', 'safe', 'on' => 'search'),
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
			'machine_id' => '盖机ID',
                        'machine_name' => Yii::t('Machine','盖机名称'),
			'path' => '图片路径',
			'create_time' => Yii::t('Machine','监控时间'),
			'status' => 'Status',
			'ip' => 'Ip',
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

		$criteria = new CDbCriteria;
		if($this->machine_name)
		{
			$sql = "select id from ".MachineAgent::model()->tableName()." where name like '%".$this->machine_name."%'";
			$result = Yii::app()->gt->createCommand($sql)->queryAll();
			$machine_id = "";
			foreach($result as $row=>$key){
				$machine_id .= $machine_id == "" ? $key['id'] : ",".$key['id'];
			}
			if ($machine_id != "") {
				$criteria->addCondition(" m.id in ($machine_id)");
			}
			
			$criteria->select = 't.path,t.create_time,t.status,m.name as machine_name,"2" as level';
		}
		else 
		{	
                    $criteria->select = 't.path as path,t.create_time as create_time,t.status as status,m.name as machine_name,"1" as level';
                    $sql='SELECT max(id) as id FROM {{machine_monitor}} GROUP BY machine_id,status';
                    $result = Yii::app()->gt->createCommand($sql)->queryAll();
                    $id = "";
                    foreach($result as $row=>$key){
				$id .= $id == "" ? $key['id'] : ",".$key['id'];
			}
			if ($id != "") {
				$criteria->addCondition(" t.id in ($id)");
			}
		}
        
                $criteria->join = 'left join {{machine}} m on m.id=t.machine_id';
                
                
                $agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
                
                $sql = "";
                if($agent_region['provinceId']!="")$sql.= "m.province_id in(".$agent_region['provinceId'].")";
                if($agent_region['cityId']!=""){
                    $sql.= $sql==""?"m.city_id in(".$agent_region['cityId'].")":" or m.city_id in(".$agent_region['cityId'].")";
                }
                if($agent_region['districtId']!=""){
                    $sql.= $sql==""?"m.district_id in(".$agent_region['districtId'].")":" or m.district_id in(".$agent_region['districtId'].")";
                }
               if($sql!='')$criteria->addCondition ("(".$sql.")");
                
                
//                $criteria->compare('m.name',$this->machine_name,true);
                $criteria->compare('t.create_time', '>=' . strtotime($this->create_time));
                if($this->create_time_end)
                $criteria->compare('t.create_time', '<' . (strtotime($this->create_time_end) + 86400));
                if ($this->status != 0) {
                    $criteria->compare('t.status', $this->status);
                }

                $criteria->order = 'create_time desc';
                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
	}
        
        
        public function search2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		if($this->machine_name)
		{
			$criteria->select = 't.machine_id,t.path,t.create_time,t.status,m.name as machine_name,"2" as level';
		}
		else 
		{
			$criteria->select = 'max(t.path) as path,max(t.create_time) as create_time,m.run_status as status,m.name as machine_name';
			$criteria->group = 'machine_name,status';
			
		}
        
                $criteria->join = 'left join {{machine}} m on m.id=t.machine_id';
                $criteria->addCondition('machine_id='.$this->machine_id);
                $criteria->compare('m.name',$this->machine_name,true);
                $criteria->compare('t.create_time', '>=' . strtotime($this->create_time));
                if($this->create_time_end)
                $criteria->compare('t.create_time', '<' . (strtotime($this->create_time_end) + 86400));
                if ($this->status != 0) {
                    $criteria->compare('t.status', $this->status);
                }

                $criteria->order = 'create_time desc';
                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineMonitorAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
