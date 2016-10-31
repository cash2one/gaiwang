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
	
    //盖机状态
    const STATUS_APPLY = 0;   //申请
    const STATUS_ENABLE = 1;  //启用
    const STATUS_DISABLE = 2; //禁用
    const STATUS_CANCEL = 3;  //已注销
    
    //盖机运行状态
    const RUN_STATUS_UNINSTALL = 3;   //卸载
    const RUN_STATUS_STOP = 2;  //停止
    const RUN_STATUS_OPERATION = 1;  //运行
    const RUN_STATUS_UNSTAR = 0;  //未激活
    
    
    public function tableName() {
        return '{{machine}}';
    }

    public function rules() {
        return array(
            array('intro_member_id', 'required','on'=>'create'),
            array('status, run_status, country_id, province_id, city_id, district_id, user_id, biz_info_id, sys_volume, machine_version', 'numerical', 'integerOnly' => true),
            array('intro_member_id', 'safe'),
            array('loc_lng, loc_lat', 'numerical'),
            array('machine_code', 'length', 'max' => 12),
            array('name, password', 'length', 'max' => 128),
            array('create_time, update_time, setup_time, last_open_time', 'length', 'max' => 10),
            array('address', 'length', 'max' => 225),
            array('user_ip, ip_address', 'length', 'max' => 11),
            array('auto_open_time, auto_shutdown_time', 'length', 'max' => 5),
            array('remark', 'length', 'max' => 200),
            array('intro_member_id, activation_code', 'length', 'max' => 50),
            array('mac_address', 'length', 'max' => 100),
            array('id, machine_code, name, password, loc_lng, loc_lat, status, run_status, country_id, province_id, city_id, district_id, address, user_id, user_ip, create_time, update_time, biz_info_id, ip_address, setup_time, last_open_time, auto_open_time, auto_shutdown_time, remark, sys_volume, intro_member_id, mac_address, activation_code, machine_version', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        	'franchisee' => array(self::BELONGS_TO,'Franchisee','biz_info_id'),
        	'intro_member' => array(self::BELONGS_TO,'Member','intro_member_id'),	//盖机推荐者
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
            'province_id' => Yii::t('machine','盖网通地区'),
            'city_id' => '城市id',
            'district_id' => '区县id',
            'address' => '盖机地址',
            'user_id' => '管理员id',
            'user_ip' => '管理员ip',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'biz_info_id' => '加盟商id',
            //'biz_name' => Yii::t('machine','加盟商名称'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('machine_code', $this->machine_code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('loc_lng', $this->loc_lng);
        $criteria->compare('loc_lat', $this->loc_lat);
        $criteria->compare('status', $this->status);
        $criteria->compare('run_status', $this->run_status);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_ip', $this->user_ip, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('biz_info_id', $this->biz_info_id);
        //$criteria->compare('biz_name', $this->biz_name, true);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('setup_time', $this->setup_time, true);
        $criteria->compare('last_open_time', $this->last_open_time, true);
        $criteria->compare('auto_open_time', $this->auto_open_time, true);
        $criteria->compare('auto_shutdown_time', $this->auto_shutdown_time, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('sys_volume', $this->sys_volume);
        $criteria->compare('intro_member_id', $this->intro_member_id, true);
        $criteria->compare('mac_address', $this->mac_address, true);
        $criteria->compare('activation_code', $this->activation_code, true);
        $criteria->compare('machine_version', $this->machine_version);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

}
