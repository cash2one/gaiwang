<?php

/**
 * This is the model class for table "{{offline_role_relation}}".
 *
 * The followings are the available columns in table '{{offline_role_relation}}':
 * @property string $id
 * @property string $member_id
 * @property integer $role_id
 * @property integer $machine_id
 * @property integer $region_id
 * @property string $admin_id
 * @property string $update_time
 */
class OfflineRoleRelation extends CActiveRecord
{
	public $name;					//名称
	public $depth;					//地区级别
	public $gai_number;				//会员编号
	public $username;				//代理用户名
	public $mobile;					//代理手机号
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{offline_role_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, machine_id, region_id,record_type', 'numerical', 'integerOnly'=>true),
			array('member_id, admin_id, update_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, role_id, machine_id, region_id, admin_id, update_time,record_type', 'safe', 'on'=>'search'),
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
			'member_id' => Yii::t('offlineRoleRelation','会员ID'),
			'role_id' => Yii::t('offlineRoleRelation','角色ID'),
			'machine_id' => Yii::t('offlineRoleRelation','盖机ID'),
			'region_id' => Yii::t('offlineRoleRelation','地区ID'),
			'admin_id' => Yii::t('offlineRoleRelation','管理员ID'),
			'update_time' => Yii::t('offlineRoleRelation','更新时间'),
			'record_type' => Yii::t('offlineRoleRelation','机器类型'),
			'name' => Yii::t('offlineRoleRelation','名称'),						//名称
			'depth' => Yii::t('offlineRoleRelation','地区级别'),				//地区级别
			'gai_number' => Yii::t('offlineRoleRelation','会员编号'),			//会员编号
			'username;' => Yii::t('offlineRoleRelation','代理用户名'),			//代理用户名
			'mobile' => Yii::t('offlineRoleRelation','代理手机号'),				//代理手机号
				
		);
	}
	
	/**
	 * 根据gai_number判断会员是否存在
	 */
	public static function isMember($gai_number){
		$data = Yii::app()->db->createCommand()->select('id')->from('{{member}}')
		->where('gai_number=:gai_number', array(':gai_number' => $gai_number))->queryRow();
		if(empty($data))
			return false;
		else return $data;
	}
	
	/**
	 * 查找是否存在记录，如果存在，则修改，不存在则插入
	 * @param string $query  类似于 'region_id = 4' 用于判断记录是否存在
	 */
	public static function createOrUpdateInfo($query){
		$offRoleRe = self::model()->tableName();
		$data = Yii::app()->db->createCommand()->select('id,member_id')->from($offRoleRe)->where($query)->queryRow();
		return $data;
	}
	
	/**
	 * 获取盖机的各项GW
	 */
	public static function machineRoleRelation($id,$record_type){
		$data = Yii::app()->db->createCommand()->select('m.gai_number,t.role_id')
												->from(self::model()->tableName() ." as t")
												->leftJoin(Member::model()->tableName() .' m', 't.member_id = m.id')
												->where('t.machine_id = '.$id. ' and region_id = 0 and record_type = '.$record_type)
												->queryAll();
		if(!empty($data)){
			$arr = array();
			$roleKey = OfflineRole::getOfflineRoleKey();
			foreach ($data as $value){
				$arr[$roleKey[$value['role_id']]] = $value['gai_number'];
			}
			return $arr;
		}
	}

	/**
	 * 总后台代理列表-生成操作按钮
	 */
	public static function createButtons($id,$agent_gai_number) {
		$string = '';
		if (Yii::app()->user->checkAccess('OfflineRoleRelation.AjaxUpdateAgent'))
			$string .= '<a href="javascript:do_Edit(' . $id . ')">【更新代理】</a>';
		if (Yii::app()->user->checkAccess('OfflineRoleRelation.RemoveAgent') && !empty($agent_gai_number))
			$string .= '<a href="javascript:do_Remove(' . $id . ')">【移除代理】</a>';
		return $string;
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
		$criteria=new CDbCriteria;
		$criteria->select = 't.id ,r.name,r.depth,m.gai_number,m.username ,m.mobile';
		$criteria->join .= 'left join {{region}} r on t.region_id = r.id ';
		$criteria->join .= 'left join {{member}} m on t.member_id = m.id ';
		$criteria->compare('r.name',$this->name,true);
		$criteria->compare('m.gai_number',$this->gai_number,true);
		$criteria->compare('m.mobile',$this->mobile,true);
		$pagination = array(
				'pageSize' => 25
		);
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => $pagination,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineRoleRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
