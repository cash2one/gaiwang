<?php
class MachineAgent extends CActiveRecord
{       
        const TIME_OUT = 100000000;			//设置访问盖机连线超时最长时间
	public $last_sign_time,$country_name,$province_name,$city_name,$district_name,$stop_status_count,$machine_num,$end_time;
	public $biz_name;
	public $monitor_path;
	public $advertid,$adtype;		//外键关联的广告id和广告类型
	
	public $productid;
	public $agent_ss; //代理商地区session
	public $api;		//盖机接口变量
	//盖机运行状态
	const RUN_STATUS_UNINSTALL = 3;
	const RUN_STATUS_OPERATION = 1;
	const RUN_STATUS_STOP = 2;
	public static function getRunStatus($key = null)
	{
		$data = array(
			self::RUN_STATUS_UNINSTALL => Yii::t('Machine','卸载'),
			self::RUN_STATUS_OPERATION => Yii::t('Machine','运行'),
			self::RUN_STATUS_STOP => Yii::t('Machine','停止'),
                    
		);
		return $key === null ? $data : $data[$key];
	}
        
        //货币种类
        const RENMINBI = "RMB";
        const HONG_KONG_DOLLAR = "HKD";
        public static function getMoney($key = null)
        {
            $data = array(
			self::RENMINBI => '人民币',
			self::HONG_KONG_DOLLAR => '港币',
		);
		return $key === null ? $data : $data[$key];
        }
	
	//盖机安装的版本
	const MACHINE_VERSION_ONLINE = 1;
	const MACHINE_VERSION_OFFLINE = 2;
	public static function getMachineVersion($key = null)
	{
		$data = array(
			self::MACHINE_VERSION_ONLINE => '在线版',
			self::MACHINE_VERSION_OFFLINE => '离线版',
		);
		return $key === null ? $data : $data[$key];
	}
	
	//盖机状态
	const STATUS_APPLY = 0;   //申请
	const STATUS_ENABLE = 1;  //启用
	const STATUS_DISABLE = 2; //禁用
        
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,biz_name,biz_info_id,address,loc_lng,loc_lat,machine_version','required','on'=>'apply'),
			array('name,sys_volume,address,loc_lng,loc_lat,province_id, city_id, district_id','required','on'=>'control'),
                        array('symbol','safe'),
			array('machine_version', 'in', 'range' => array(self::MACHINE_VERSION_ONLINE,self::MACHINE_VERSION_OFFLINE)),
			array('status, run_status, country_id, province_id, city_id, district_id, user_id, biz_info_id, sys_volume', 'numerical', 'integerOnly'=>true),
			array('loc_lng, loc_lat', 'numerical'),
			array('machine_code', 'length', 'max'=>12),
			array('machine_code', 'unique'),
			array('name, password', 'length', 'max'=>128),
			array('user_ip, create_time, update_time, ip_address, setup_time, last_open_time', 'length', 'max'=>10),
			array('address', 'length', 'max'=>225),
			array('auto_open_time, auto_shutdown_time', 'length', 'max'=>5),
			array('remark', 'length', 'max'=>200),
			array('intro_member_id, activation_code', 'length', 'max'=>50),
			array('mac_address', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, machine_code, name, password, loc_lng, loc_lat, status, run_status, country_id, province_id, city_id, district_id, address, user_id, user_ip, create_time, update_time, biz_info_id,biz_name, ip_address, setup_time, last_open_time, auto_open_time, auto_shutdown_time, remark, sys_volume, intro_member_id, mac_address, activation_code,symbol', 'safe', 'on'=>'search'),
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
                    'monitor' => array(self::HAS_ONE, 'MachineMonitorAgent', 'machine_id', 'order' => 'create_time desc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'machine_code' => Yii::t('Machine','盖机编码'),
			'name' => Yii::t('Machine','盖机名称'),
			'password' => Yii::t('Machine','终端机管理密码,由一定规则生成的加密串，可以解密'),
			'loc_lng' => Yii::t('Public','经度'),
			'loc_lat' => Yii::t('Public','纬度'),
			'status' => Yii::t('Machine','盖机的状态（0、申请 1、启用 2、禁用）'),
			'run_status' => Yii::t('Machine','运行状态'),
			'country_id' => Yii::t('Machine','国家id'),
			'province_id' => Yii::t('Machine','省份id'),
			'city_id' => Yii::t('Machine','城市id'),
			'district_id' => Yii::t('Machine','区县id'),
			'address' => Yii::t('Machine','地址'),
			'user_id' => Yii::t('Machine','管理员id'),
			'user_ip' => Yii::t('Machine','管理员ip'),
			'create_time' => Yii::t('Machine','创建时间'),
			'update_time' => Yii::t('Machine','修改时间'),
			'biz_info_id' => Yii::t('Machine','加盟商id'),
			'biz_name' => Yii::t('Machine','线下加盟商'),
			'ip_address' => Yii::t('Machine','盖机的ip地址'),
			'setup_time' => Yii::t('Machine','安装时间'),
			'last_open_time' => Yii::t('Machine','最后打开时间'),
			'auto_open_time' => Yii::t('Machine','自动开机时间'),
			'auto_shutdown_time' => Yii::t('Machine','每天自动关机时间(例如：05:30)'),
			'remark' => Yii::t('Machine','备注（记录机器比较重要的动作（例如：2013/7/3 16:21:35：已经打开终端显示系统））'),
			'sys_volume' => Yii::t('Machine','系统音量'),
			'intro_member_id' => Yii::t('Machine','推荐人的盖网编号（GW....）'),
			'mac_address' => Yii::t('Machine','机器的mac地址'),
			'activation_code' => Yii::t('Machine','激活码'),
			'machine_version' => Yii::t('Machine','安装版本'),
			'symbol'=>Yii::t('Machine','入账货币'),
			'show_status' => Yii::t('Machine','盖机状态'),
			'api' => Yii::t('Machine','功能'),
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
		$criteria->select = "t.*,f.name as biz_name";
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.biz_info_id";
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.machine_code',trim($this->machine_code));
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('f.name',$this->biz_name,true);
		   
		$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
		    'sort' => false
		));
	}

	public $software_sn;				//出厂终端号
	public $i_begin_time;					//开始时间
	public $i_end_time;					//结束时间
	public $micount;					//盘点次数

	public $inventoryState;					//盘点状态
	const INVENTORY_YES = 1;				//已盘点
	const INVENTORY_NO = 2;					//未盘点

	/**
	 * 获取盘点状态
	 * @param null $key
	 * @return array
	 */
	public static function getInventory($key = null){
		$data = array(
			self::INVENTORY_YES => '已盘点',
			self::INVENTORY_NO => '未盘点'
		);
		return $key===null ? $data : $data[$key];
	}

	/**
	 * 查询盘点数据
	 */
	public function searchInventory(){
		$criteria=new CDbCriteria;
		$criteria->select = 't.id,t.name,t.machine_code,ms.software_sn,';
		if($this->i_begin_time)  $criteria->select .= "'$this->i_begin_time'" . " as i_begin_time,";
		else $criteria->select .= 0 . " as i_begin_time,";
		if($this->i_end_time) $criteria->select .= "'$this->i_end_time'" . " as i_end_time";
		else $criteria->select .= 0 . " as i_end_time";

		$begin = strtotime($this->i_begin_time);
		$end = strtotime($this->i_end_time);
		//筛选已盘点 未盘点
		$where = '1';
		$where .= $begin ? " and create_time >= ".$begin : '';
		$where .= $end ? " and create_time <= ".$end : '';
		$result = Yii::app()->gt->createCommand()
								->select('machine_id')
								->from(MachineInventory::model()->tableName())
								->where($where)
								->group('machine_id')
								->queryColumn();
		$inventoryList = implode(',',$result);
		$inventoryList = $inventoryList ? $inventoryList : 0;
		if($this->inventoryState == MachineAgent::INVENTORY_NO){
			$criteria->addCondition('t.id not in ('.$inventoryList.')');
		}elseif($this->inventoryState == MachineAgent::INVENTORY_YES){
			$criteria->addCondition('t.id in ('.$inventoryList.')');
		}
		$criteria->join = " left join gt_machine_software as ms on t.id = ms.machine_id" ;
		$criteria->addCondition('t.status = '.MachineAgent::STATUS_ENABLE);
		//开始区域过滤
		$agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
		$province_id = $agent_region['provinceId'] == ""?"":$agent_region['provinceId'];
		$city_id = $agent_region['cityId'] == ""?"":$agent_region['cityId'];
		$district_id = $agent_region['districtId'] == ""?"":$agent_region['districtId'];

		$sql = "";
		if ($province_id != "")$sql.="t.province_id in($province_id)";
		if ($city_id != "")$sql.= $sql == ""?"t.city_id in($city_id)":" or t.city_id in($city_id)";
		if ($district_id != "")$sql.= $sql == ""?"t.district_id in($district_id)":" or t.district_id in($district_id)";
		if ($sql != "")$criteria->addCondition ("(".$sql.")");
		//区域过滤结束
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.machine_code',$this->name,true,'or');
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->distinct = true;
		$criteria->order = 't.update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>12,
			),
			'sort' => false
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
	 * @return MachineAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function beforeSave() {
	        if (parent::beforeSave()) {
	            if ($this->isNewRecord) {
	                $this->create_time = time();
	            }
				$this->update_time = time();
	            return true;
	        }
	        else
	            return false;
	 }
        
        
    /*
	 * 盖机列表查询
	 */
	public function searchControll_Old()
	{
		$today = strtotime(date('Y-m-d'));
		$criteria=new CDbCriteria;
		$monitor = MachineMonitorAgent::model()->tableName();
                $regionTb = Region::model()->tableName();
                $franchiseeTb = Franchisee::model()->tableName();
		//$criteria->distinct = true;
		$criteria->addCondition('t.status = '.  MachineAgent::STATUS_ENABLE);
		$criteria->select = 't.id,t.name,t.ip_address,t.run_status,t.biz_name,t.loc_lng,t.loc_lat,t.province_id,r.name as province_name,t.city_id,c.name as city_name,t.district_id,d.name as district_name,m.path,max(m.create_time) as last_sign_time,sum(m.status = 2 and m.create_time>='.$today.') as stop_status_count,max(m.path) as monitor_path';
		$criteria->join = 'LEFT JOIN '.$monitor.' m ON m.machine_id=t.id';
		$criteria->join .= ' LEFT JOIN '.$regionTb.' r ON r.id=t.province_id';
		$criteria->join .= ' LEFT JOIN '.$regionTb.' c ON c.id=t.city_id';
		$criteria->join .= ' LEFT JOIN '.$regionTb.' d ON d.id=t.district_id';
		//$criteria->join .= ' left join '.$franchiseeTb.' f on f.id=t.biz_info_id';

                
                $agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
                $sql = "";
                if($agent_region['provinceId']!=""){
                    $sql.= $sql==""?"t.province_id in(".$agent_region['provinceId'].")":"";
                }
                
                if($agent_region['cityId']!=""){
                    $sql.= $sql==""?"t.city_id in(".$agent_region['cityId'].")":" or t.city_id in(".$agent_region['cityId'].")";
                }
                if($agent_region['districtId']!=""){
                    $sql.= $sql==""?"t.district_id in(".$agent_region['districtId'].")":" or t.district_id in(".$agent_region['districtId'].")";
                }
                if($sql!='')$criteria->addCondition ("(".$sql.")");
               
		$criteria->group = 't.id,t.name,t.run_status,t.biz_name,t.loc_lng,t.loc_lat,t.province_id,t.city_id,t.district_id,province_name,city_name,district_name';
		$criteria->compare('run_status',$this->run_status);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('biz_name',$this->biz_name,true);
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->order = 't.update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>12,
		    ),
		    'sort' => false
		));
	}
	
/*
	 * 盖机列表查询
	 */
	public function searchControll()
	{
		$today = strtotime(date('Y-m-d'));
		$criteria=new CDbCriteria;
		$criteria->addCondition('t.status = '.MachineAgent::STATUS_ENABLE);
		$criteria->select = 't.id,t.name,t.ip_address,t.run_status,f.name as biz_name,t.loc_lng,t.loc_lat,t.province_id,t.city_id,t.district_id ,m.path as monitor_path';
		$criteria->join = 'left join gaiwang.gw_franchisee f on f.id = t.biz_info_id ';
		$criteria->join.= 'LEFT JOIN '.MachineMonitorAgent::model()->tableName().' m ON m.id=t.machine_monitor_id ';
		//开始区域过滤
		$agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
		$province_id = $agent_region['provinceId'] == ""?"":$agent_region['provinceId'];
		$city_id = $agent_region['cityId'] == ""?"":$agent_region['cityId'];
		$district_id = $agent_region['districtId'] == ""?"":$agent_region['districtId'];
		
		$sql = "";
		if ($province_id != "")$sql.="t.province_id in($province_id)";
		if ($city_id != "")$sql.= $sql == ""?"t.city_id in($city_id)":" or t.city_id in($city_id)";
		if ($district_id != "")$sql.= $sql == ""?"t.district_id in($district_id)":" or t.district_id in($district_id)";
		if ($sql != "")$criteria->addCondition ("(".$sql.")");
        //区域过滤结束
        
		$criteria->compare('t.run_status',$this->run_status);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('f.name',$this->biz_name,true);
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->distinct = true;
		$criteria->order = 't.update_time desc';
		
		return $criteria;
	}
        
        /*
	  * 生成12位数字的盖网通编码
	  */
	 public static function createMachineCode()
	 {
	 		$date = date('Ymd');
	 		$mt = microtime();
	        $mtArr = explode(' ', $mt);
	        $mt = substr($mtArr[0], 2, 6);
	        $mt .= rand(100, 999);
	        $len = strlen($mt);
	        $a = rand(0,$len-1);
	        $b = rand(0,$len-1);
	        $c = rand(0,$len-1);
	        $d = rand(0,$len-1);
	        return $date.$mt[$a].$mt[$b].$mt[$c].$mt[$d];
	 }
         
         /**
          * 各城市盖机统计查询 
          **/
        public function searchCity(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('t.status = '.Machine::STATUS_ENABLE);
            $criteria->select = 'count(t.id) as machine_num,t.province_id,t.city_id,c.name as city_name';
            $criteria->join = ' LEFT JOIN '.Region::model()->tableName().' c ON c.id=t.city_id';
            $criteria->group = 't.city_id';
            $criteria->addCondition('t.city_id<>0');
            $criteria->order = 'machine_num desc';
            $criteria->limit = 22;
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
        }
        
        /**
	 * 查询广告绑定的盖机
	 */
	public function searchBind(){
		$criteria = new CDbCriteria();
		
		$criteria->select = "t.*,f.name as biz_name";
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.biz_info_id";
		
		if($this->adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO){
			$tablename = Machine2AdvertVideoAgent::model()->tableName();
		}else{
			$tablename = Machine2AdvertAgent::model()->tableName();
		}
		
		$criteria->addCondition('t.status = '. MachineAgent::STATUS_ENABLE);
		
		$agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
                $sql = "";
                if($agent_region['provinceId']!="")$sql.= "t.province_id in(".$agent_region['provinceId'].")";
                if($agent_region['cityId']!="")$sql.= $sql==""?"t.city_id in(".$agent_region['cityId'].")":" or t.city_id in(".$agent_region['cityId'].")";
                if($agent_region['districtId']!="")$sql.= $sql==""?"t.district_id in(".$agent_region['districtId'].")":" or t.district_id in(".$agent_region['districtId'].")";
                if($sql!='')$criteria->addCondition ("(".$sql.")");

		//获取广告已经绑定的盖机的编号
		$machineTable = self::tableName();
		$sql = "select a.id from $machineTable a left join $tablename b on a.id = b.machine_id where b.advert_id = ".$this->advertid;
		$resArr = Yii::app()->gt->createCommand($sql)->queryAll();
		$existsId = "";
		foreach ($resArr as $row){
			$existsId.= $existsId==""?$row['id']:",".$row['id'];
		}
		
		if ($existsId!=""){
			$criteria->addCondition("t.id not in ($existsId)");
		}
        
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->compare('t.run_status',$this->run_status);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('f.name',$this->biz_name,true);
		$criteria->order = 't.update_time desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
		    'sort' => false
		));
	}
	
        
        /**
	 * 查询商家绑定的盖机  产品管理
	 */
	public function searchBindProduct(){
		$criteria = new CDbCriteria();
		
		$criteria->select = "t.*,f.name as biz_name";
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.biz_info_id";
		//排除已经绑定的盖机
		$tablename = Machine2ProductAgent::model()->tableName();
		$sql = "select machine_id from $tablename where product_id = ".$this->productid;
		$resArr = Yii::app()->gt->createCommand($sql)->queryAll();
		$existsId = "";
		foreach ($resArr as $row){
			$existsId.= $existsId==""?$row['machine_id']:",".$row['machine_id'];
		}
		if($existsId!="")$criteria->addCondition("t.id not in ($existsId)");
		$criteria->addCondition('t.status = '.  MachineAgent::STATUS_ENABLE);
		
		//区域控制
		$agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
                $sql = "";
                if($agent_region['provinceId']!="")$sql.= "t.province_id in(".$agent_region['provinceId'].")";
                if($agent_region['cityId']!="")$sql.= $sql == ""?"t.city_id in(".$agent_region['cityId'].")":" or t.city_id in(".$agent_region['cityId'].")";
                if($agent_region['districtId']!="")$sql.= $sql==""?"t.district_id in(".$agent_region['districtId'].")":" or t.district_id in(".$agent_region['districtId'].")";
                if($sql!='')$criteria->addCondition ("(".$sql.")");
		
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->compare('t.run_status',$this->run_status);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('f.name',$this->biz_name,true);
		$criteria->order = 't.update_time desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
		    'sort' => false
		));
	}
	
	/**
	 * grid里面显示状态
	 */
	public static function runStatus($status){
		if($status==MachineAgent::RUN_STATUS_OPERATION){
			 return '<span class="online">'.MachineAgent::getRunStatus($status).'</span>';
		}else if($status==MachineAgent::RUN_STATUS_STOP){
			 return '<span class="offline">'.MachineAgent::getRunStatus($status).'</span>';
		}else{
			 return '<span class="uninstall">'.MachineAgent::getRunStatus($status).'</span>';
		}
	}
}
