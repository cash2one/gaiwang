<?php

class CustomFunAgent extends CActiveRecord
{
	const STATUS_WAITCONFIRM = 0;		//待审核
	const STATUS_CONFIRMPASS = 1;		//审核通过
	const STATUS_CONFIRMFAIL = 2;		//审核未通过
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;
	public $machine_id;
        
	public static function getStatus($key = NULL){
		$status = array(
			self::STATUS_WAITCONFIRM => Yii::t('CustomFun', '待审核'),	
			self::STATUS_CONFIRMPASS => Yii::t('CustomFun', '审核通过'),	
			self::STATUS_CONFIRMFAIL => Yii::t('CustomFun', '审核未通过'),	
		);
		return $key === NULL ? $status : $status[$key];
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{custom_fun}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, related_url, status, sort', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			array('enabled,is_full_screen','in','range' => array(self::STATUS_ENABLE,self::STATUS_DISABLE)),
			array('remark', 'length', 'max'=>500),
			array('name','length','min' => '1','max' => '20','message'=>Yii::t('CustomFun', '功能名称最少为一个字，最多为20个字')),
			array('name','unique'),
			array('related_url','length','min' => '1','max' => '49','message'=>Yii::t('CustomFun', '关联地址最少为一个字，最多为49个字')),
			array('related_url','url'),
			array('activity_start_time,activity_end_time','safe'),
//			array('activity_start_time','compare','compareAttribute'=>'activity_end_time','operator'=>'<=','message'=>'活动开始时间不能大于活动结束时间'),
			array('activity_start_time', 'compareActivityTime'),
			array('name, status, activity_start_time, activity_end_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * 自定义验证活动时间的方法
	 * @param unknown_type $attribute	包含验证的实行
	 * @param unknown_type $params
	 */
	public function compareActivityTime($attribute,$params){
		if($this->activity_end_time!=''&&strtotime($this->activity_start_time)-strtotime($this->activity_end_time)>0)
			$this->addError($attribute, Yii::t('CustomFun', '活动开始时间不能大于活动结束时间'));
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
			'name' => Yii::t('CustomFun', '功能名称'),
			'related_url' => Yii::t('CustomFun', '关联地址'),
			'status' => Yii::t('CustomFun', '状态'),
			'sort' => Yii::t('CustomFun', '排序'),
			'is_full_screen' => Yii::t('CustomFun', '是否全屏'),
			'enabled' => Yii::t('CustomFun', '是否可用'),
			'activity_start_time' => Yii::t('CustomFun', '活动开始时间'),
			'activity_end_time' => Yii::t('CustomFun', '活动结束时间'),
			'remark' => Yii::t('CustomFun', '备注')
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

		if($this->status!=='all'){		//如果状态不等于all的时候才加入状态的查询
			$criteria->compare('status',$this->status);
		}
		$criteria->compare('name',$this->name,true);
		$criteria->compare('activity_start_time','>='.strtotime($this->activity_start_time));
		$criteria->compare('activity_start_time','<='.strtotime($this->activity_end_time));
		$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>15,
		    ),
				
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomFun the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function afterFind(){
		parent::afterFind();
		$this->activity_start_time = $this->activity_start_time==0?"":date('Y-m-d H:i',$this->activity_start_time);
		$this->activity_end_time = $this->activity_end_time==0?"":date('Y-m-d H:i',$this->activity_end_time);
	}
}
