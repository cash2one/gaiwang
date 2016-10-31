<?php

/**
 * This is the model class for table "{{offline_role}}".
 * 线下角色管理
 * The followings are the available columns in table '{{offline_role}}':
 * @property integer $role_id
 * @property string $role_name
 * @property string $rate
 * @property string $admin_id
 * @property string $update_time
 */
class OfflineRole extends CActiveRecord
{	
	const ROLE_AGENT_PROVINCE = 1;				//省代理
	const ROLE_AGENT_CITY = 2;				    //市代理
	const ROLE_AGENT_DISTRICT = 3;				//区代理
	const ROLE_CUSTOMER = 4;				    //消费者
	const ROLE_CUSTOMER_REFEREE = 5;			//消费者推荐人
	const ROLE_GAIWANG = 6;				        //盖网
	const ROLE_MACHINE_REFEREES = 9;			//盖网通推荐人

	public static function getId2Name(){
		$role = Yii::app()->db->createCommand()->select('role_id ,role_name')->from(self::model()->tableName())->queryAll();
		$data = array();
		if (!empty($role))
			foreach ($role as $value)
				$data[$value['role_id']] = $value['role_name'];
		return $data;
	}

	public $username;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{offline_role}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role_id', 'numerical', 'integerOnly'=>true),
            array('role_name', 'length', 'max'=>200),
            array('rate', 'length', 'max'=>5),
            array('admin_id, update_time', 'length', 'max'=>11),
            array('role_id, role_name, rate, admin_id, update_time', 'safe', 'on'=>'search'),
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
            'role_id' => 'Role',
            'role_name' => Yii::t('offlineRole','角色名称'),
            'rate' => Yii::t('offlineRole','分配比率'),
            'admin_id' => Yii::t('offlineRole','管理员'),
            'update_time' => Yii::t('offlineRole','修改时间'),
        	'username' => Yii::t('offlineRole','管理员'),
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
		$criteria->select = 't.role_id,t.role_name,t.rate,u.username,t.update_time';
		$criteria->join .= 'left join {{user}} u on t.admin_id = u.id ';
		$criteria->compare('t.role_name',$this->role_name,true);
		$criteria->compare('t.rate',$this->rate,true);
		
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
     * @return OfflineRole the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取角色
     * @param null $roleId
     * @return bool
     */
    public static function getRole($roleId = null){
        $data = Yii::app()->db->createCommand()->select('role_id,role_name,rate')->queryAll();
        foreach($data as $val){
            $role[$val['role_id']] = array('role_name'=>$val['role_name'],'rate'=>$val['rate']);
        }
        return $roleId ? (isset($role[$roleId]) ? $role[$roleId] : false) : $role;
    }

    public static function getAgent($role_id, $region_id, $record_type){
        $sql = "select m.id,m.gai_number,
        ofr.rate
        r.area
        from {{offline_role_relation}} as orr
        inner join {{offline_role}} as ofr on ofr.role_id=orr.role_id
        inner join {{member}} as m on m.id=orr.member_id
        inner join {{region}} as r on r.id=orr.region_id
        where orr.role_id =$role_id and region_id=$region_id and orr.record_type=$record_type";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;

    }
}