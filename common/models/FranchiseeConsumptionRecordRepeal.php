<?php

/**
 * This is the model class for table "{{franchisee_consumption_record_repeal}}".
 *
 * The followings are the available columns in table '{{franchisee_consumption_record_repeal}}':
 * @property string $id
 * @property string $serial_number
 * @property string $record_id
 * @property string $apply_user_id
 * @property string $apply_time
 * @property string $agree_user_id
 * @property string $agree_time
 * @property string $refuse_user_id
 * @property string $refuse_time
 * @property integer $status
 */
class FranchiseeConsumptionRecordRepeal extends CActiveRecord
{
	public $franchisee_name,$franchisee_code,$franchisee_mobile,$franchisee_province_id,$franchisee_city_id,$franchisee_district_id;
	public $fcrid,$gai_number,$gai_discount,$member_discount,$create_time,$spend_money,$distribute_money,$remark,$start_time,$end_time,$symbol,$entered_money;
	public $apply_user_name;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_consumption_record_repeal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, serial_number, record_id, apply_user_id, apply_time, agree_user_id, agree_time, refuse_user_id, refuse_time, status', 'safe', 'on'=>'search'),
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
            'Record' => array(self::BELONGS_TO, 'FranchiseeConsumptionRecord', 'record_id'),
        );
	}

	//撤销状态(0申请中 1已撤销 2已拒绝)
    const STATUS_APPLY = 0;		//申请中
    const STATUS_PASS = 1;		//已撤销
    const STATUS_REFUSE = 2;	//已拒绝
    const STATUS_AUDITI = 3; //已审核

    public static function getBackStatus($key = null) {
        $data = array(
            '' => Yii::t('franchiseeConsumptionRecord', '全部'),
            self::STATUS_APPLY => '申请中',
            self::STATUS_PASS => '已通过',
            self::STATUS_REFUSE => '已拒绝',
            self::STATUS_AUDITI => '已审核',
        );
        return $key === null ? $data : $data[$key];
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'serial_number' => 'Serial Number',
			'record_id' => 'Record',
			'apply_user_id' => 'Apply User',
			'apply_time' => 'Apply Time',
			'agree_user_id' => 'Agree User',
			'agree_time' => 'Agree Time',
			'refuse_user_id' => 'Refuse User',
			'refuse_time' => 'Refuse Time',
		
			'id' => '主键id',
            'status' => '撤销状态',
            'spend_money' => '消费金额',
            'gai_discount' => '盖网折扣',
            'gai_number' => '会员编号',
            'member_discount' => '会员折扣',
            'distribute_money' => '分配金额',
            'member_id' => '消费会员',
            'franchisee_name' => '加盟商名称',
            'franchisee_code' => '加盟商编号',
            'start_time' => '账单时间',
            'franchisee_mobile' => '加盟商电话',
            'franchisee_province_id' => '加盟商所在地区',
            'create_time' => '账单时间',
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
		$criteria->select = "t.id,t.apply_time,t.status,
							fcr.id as fcrid,fcr.gai_discount,fcr.member_discount,fcr.create_time,fcr.spend_money,fcr.distribute_money,fcr.distribute_money,fcr.remark,fcr.symbol,fcr.entered_money,
							f.code as franchisee_code,f.name as franchisee_name,
							u.username as apply_user_name,
							fm.gai_number";
		$criteria->join = " left join ".FranchiseeConsumptionRecord::model()->tableName()." fcr on fcr.id = t.record_id ";
		$criteria->join.= " left join ".Franchisee::model()->tableName()." f on fcr.franchisee_id = f.id";
		$criteria->join.= " left join ".User::model()->tableName()." u on u.id = t.apply_user_id";
		$criteria->join.= " left join ".Member::model()->tableName()." fm on fm.id = fcr.member_id";
		
		$criteria->addCondition('fcr.franchisee_id <> ""');
		$criteria->compare('fm.gai_number', $this->gai_number, true);
        $criteria->compare('f.name', $this->franchisee_name, true);
        $criteria->compare('f.code', $this->franchisee_code);
        $criteria->compare('f.mobile', $this->franchisee_mobile);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('f.province_id', $this->franchisee_province_id);
        $criteria->compare('f.city_id', $this->franchisee_city_id);
        $criteria->compare('f.district_id', $this->franchisee_district_id);
        if ($this->start_time) {
            $criteria->compare('fcr.create_time', ' >=' . strtotime($this->start_time));
        }
        if ($this->end_time) {
            $criteria->compare('fcr.create_time', ' <' . (strtotime($this->end_time)));
        }
        $criteria->addCondition("fcr.spend_money <> 0");
        $criteria->order = 't.apply_time desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=> array(
				'pageSize' => 100,
			),
		));
	}
	
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
