<?php

/**
 * 盖网通盖机模型
 * @author wanyun_liu <wanyun_liu@163.com>
 * 
 * @property integer $id
 * @property string $machine_code
 * @property string $name
 * @property string $password
 * @property double $loc_lng
 * @property double $loc_lat
 * @property integer $status
 * @property integer $run_status
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $address
 * @property integer $user_id
 * @property string $user_ip
 * @property string $create_time
 * @property string $update_time
 * @property integer $biz_info_id
 * @property string $biz_name
 * @property string $ip_address
 * @property string $setup_time
 * @property string $last_open_time
 * @property string $auto_open_time
 * @property string $auto_shutdown_time
 * @property string $remark
 * @property integer $sys_volume
 * @property string $intro_member_id
 * @property string $mac_address
 * @property string $activation_code
 * @property integer $machine_version
 */
class Machine extends CActiveRecord {

	public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel起始
    public $exportLimit = 5000; //导出excel长度
    public $biz_name;
    public $gai_number;
    public $intro_member_id;    //推荐人
    public $install_member_id;   //铺机人
    public $operate_member_id;   //运维人
    
    //盖机状态
	const STATUS_APPLY = 0;   //申请
	const STATUS_ENABLE = 1;  //启用
	const STATUS_DISABLE = 2; //禁用
    const STATUS_CANCEL = 3;  //已注销
	
	//盖机运行状态
	const RUN_STATUS_UNINSTALL = 3;
	const RUN_STATUS_OPERATION = 1;
	const RUN_STATUS_STOP = 2;
    const RUN_STATUS_UNSTAR = 0;  //未激活
	
    public function tableName() {
        return '{{machine}}';
    }

    /**
     * 取盖机的状态（0、申请 1、启用 2、禁用 3、已注销）
     */
    public static function getMachineStatus($key = null)
    {
        $data = array(
            self::STATUS_APPLY => Yii::t('Machine', '申请'),
            self::STATUS_ENABLE => Yii::t('Machine', '启用'),
            self::STATUS_DISABLE => Yii::t('Machine', '禁用'),
            self::STATUS_CANCEL => Yii::t('Machine', '已注销')
        );
        return $key === null ? $data : $data[$key];
    }

    /*
     * 取盖机运行状态（）
     */

    public static function getRunStatus($key = null)
    {
        $data = array(
            self::RUN_STATUS_UNINSTALL => Yii::t('Machine', '卸载'),
            self::RUN_STATUS_STOP => Yii::t('Machine', '停止'),
            self::RUN_STATUS_OPERATION => Yii::t('Machine', '运行'),
            self::RUN_STATUS_UNSTAR => Yii::t('Machine', '未激活'),
        );
        return $key === null ? $data : $data[$key];
    }

    public function rules() {
        return array(
            array('intro_member_id', 'required','on'=>'create'),
            array('status, run_status, country_id, province_id, city_id, district_id, user_id, biz_info_id, sys_volume, machine_version', 'numerical', 'integerOnly' => true),
            array('intro_member_id', 'safe'),
            array('loc_lng, loc_lat', 'numerical'),
            array('machine_code', 'length', 'max' => 12),
            array('name, password, biz_name', 'length', 'max' => 128),
            array('create_time, update_time, setup_time, last_open_time', 'length', 'max' => 10),
            array('address', 'length', 'max' => 225),
            array('user_ip, ip_address', 'length', 'max' => 11),
            array('auto_open_time, auto_shutdown_time', 'length', 'max' => 5),
            array('remark', 'length', 'max' => 200),
            array('intro_member_id, activation_code', 'length', 'max' => 50),
            array('mac_address', 'length', 'max' => 100),
            array('id, machine_code, name, password, loc_lng, loc_lat, status, run_status, country_id, province_id, city_id, district_id, address, user_id, user_ip, create_time, update_time, biz_info_id, biz_name, ip_address, setup_time, last_open_time, auto_open_time, auto_shutdown_time, remark, sys_volume, intro_member_id, mac_address, activation_code, machine_version', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'machine_code' => '盖机编码，由系统自动生成,12位数字组成',
            'name' => Yii::t('machine','盖网通名称'),
            'password' => '终端机管理密码,由一定规则生成的加密串，可以解密',
            'loc_lng' => '经度',
            'loc_lat' => '纬度',
            'status' => '盖机的状态（0、申请 1、启用 2、禁用）',
            'run_status' => '盖网通的运行状态（1、运行 2、停止 3、卸载 ）',
            'country_id' => '国家id',
            'province_id' => Yii::t('machine','盖网通省份'),
            'city_id' => '城市',
            'district_id' => '区县',
            'address' => '盖机地址',
            'user_id' => '管理员id',
            'user_ip' => '管理员ip',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'biz_info_id' => '加盟商id',
            'biz_name' => Yii::t('machine','加盟商名称'),
            'ip_address' => '盖机的ip地址',
            'setup_time' => '安装时间',
            'last_open_time' => '最近开机时间',
            'auto_open_time' => '每天自动开机时间(例如：05:30)',
            'auto_shutdown_time' => '每天自动关机时间(例如：05:30)',
            'remark' => '备注（记录机器比较重要的动作（例如：2013/7/3 16:21:35：已经打开终端显示系统））',
            'sys_volume' => '系统音量（0-100）默认30',
            'intro_member_id' => Yii::t('machine','推荐者'),   //管理该机器的盖网编号（GW....）
            'mac_address' => '机器的mac地址',
            'activation_code' => '系统生成的激活码',
            'machine_version' => '盖机的版本（1、在线版 2、离线版）',
        );
    }

    public function search() {	
        $criteria = new CDbCriteria;
        $criteria->select = "t.id,t.name,t.biz_info_id,t.intro_member_id,t.province_id,t.city_id,t.district_id,f.name as biz_name,m.gai_number as intro_member_id,r.name as city_name,t.status";
		$criteria->join = "left join gaiwang.gw_franchisee f on f.id = t.biz_info_id";
		$criteria->join.= " left join gaiwang.gw_member m on m.id = t.intro_member_id";
        $criteria->join.= " left join gaiwang.gw_region r on r.id = t.province_id";
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.machine_code', $this->machine_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.password', $this->password, true);
        $criteria->compare('t.loc_lng', $this->loc_lng);
        $criteria->compare('t.loc_lat', $this->loc_lat);
        $criteria->compare('t.status', '<>'.self::STATUS_DISABLE);
        $criteria->compare('t.run_status', $this->run_status);
        $criteria->compare('t.country_id', $this->country_id);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.district_id', $this->district_id);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.user_ip', $this->user_ip, true);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.biz_info_id', $this->biz_info_id);
        $criteria->compare('f.name', $this->biz_name, true);
        $criteria->compare('t.ip_address', $this->ip_address, true);
        $criteria->compare('t.setup_time', $this->setup_time, true);
        $criteria->compare('t.last_open_time', $this->last_open_time, true);
        $criteria->compare('t.auto_open_time', $this->auto_open_time, true);
        $criteria->compare('t.auto_shutdown_time', $this->auto_shutdown_time, true);
        $criteria->compare('t.remark', $this->remark, true);
        $criteria->compare('t.sys_volume', $this->sys_volume);
        $criteria->compare('m.gai_number', $this->intro_member_id, true);
        $criteria->compare('t.mac_address', $this->mac_address, true);
        $criteria->compare('t.activation_code', $this->activation_code, true);
        $criteria->compare('t.machine_version', $this->machine_version);

        
    	$pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        	'pagination' => $pagination,
        ));
    }

    /**
     * 连接盖网通的数据库
     * 获取盖网机数据
     * @return 数据库连接
     */
    public function getDbConnection() {
        return Yii::app()->gt;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
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
        $code = $date.$mt[$a].$mt[$b].$mt[$c].$mt[$d];
        if(self::validateMachineCode($code) !== false)
        {
            $code = self::createMachineCode();
        }
        return $code;
    }

    /**
     * 检测生成的编号是否重复
     * @author lc
     */
    public static function validateMachineCode($machine_code)
    {
        $machineTable = self::model()->tableName();
        $sql = "select id from $machineTable where machine_code = '".$machine_code."'";
        $data = Yii::app()->gt->createCommand($sql)->queryScalar();
        return $data;
    }

    /*
     * 生成激活码
     */
    public static function createActivationCode($machine_code)
    {
        $prime_num = array(2,3,5,7,11,13,17,19,23,29);
        $machine_code = substr($machine_code, 2);
        $len = strlen($machine_code);
        $b_code = 1;
        for($i = 0;$i<$len;$i++)
        {
            $n = $prime_num[$machine_code[$i]];
            $b_code *= round($n*$n/2);
        }
        $b_code = substr($b_code,0,6);
        $b_code = str_replace(".", "", $b_code);
        return $b_code;
    }
}
