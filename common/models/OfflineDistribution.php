<?php

/**
 * This is the model class for table "{{offline_distribution}}".
 *
 * The followings are the available columns in table '{{offline_distribution}}':
 * @property string $id
 * @property string $machine_id
 * @property string $distribution
 * @property integer $record_type
 */
class OfflineDistribution extends CActiveRecord
{
	
	//盖网折扣收益分配(new)
	public $offConsumeNew;   //消费者
	public $offRefNew;       //推荐者
	public $offRegion;    //大区
	public $offProvince;  //省份
	public $offCity;      //市级
	public $offDistrict;  //区/县级
	public $offMachineLine;  //铺机者
	public $offMachineOperation; //运维人
	public $gateMachineRef;  //盖网通推荐者
	public $offManeuver;     //机动
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{offline_distribution}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('machine_id, distribution, record_type', 'required'),
			//array('record_type', 'numerical', 'integerOnly'=>true),
			//array('machine_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
		//	array('id, machine_id, distribution, record_type', 'safe', 'on'=>'search'),
// 			array('offConsume, offRef,
//             	offRegion, offProvince, offCity, offDistrict, offMachineLine,
//             	offMachineOperation, gateMachineRef, offManeuver', 'required'),
		    array('offConsumeNew, offRefNew,
            	offRegion, offProvince, offCity, offDistrict, offMachineLine,
            	offMachineOperation, gateMachineRef, offManeuver', 'numerical', 'integerOnly' => true, 
		    	'min' => 0, 'max' => 100),
			//盖网折扣收益分配(new)
			array('offConsumeNew', 'checkoffnew'),
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
			'machine_id' => '盖机id',
			'distribution' => '机器的分配规则，如果不存在则按默认的规则进行分配（存json格式）',
			'record_type' => '属于线下什么机器',
			//盖网折扣收益分配(new)
			'offConsumeNew' => Yii::t('OfflineDistribution', '消费者'),
			'offRefNew' => Yii::t('OfflineDistribution', '推荐者'),
			'offRegion' => Yii::t('OfflineDistribution', '大区'),
			'offProvince' => Yii::t('OfflineDistribution', '省级'),
			'offCity' => Yii::t('OfflineDistribution', '市级'),
			'offDistrict' => Yii::t('OfflineDistribution', '区/县级'),
			'offMachineLine' => Yii::t('OfflineDistribution', '推荐者(代理商)'),
			'offMachineOperation' => Yii::t('OfflineDistribution', '运维方'),
			'gateMachineRef' => Yii::t('OfflineDistribution', '推荐者(会员)'),
			'offManeuver' => Yii::t('OfflineDistribution', '机动'),
				
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('machine_id',$this->machine_id,true);
		$criteria->compare('distribution',$this->distribution,true);
		$criteria->compare('record_type',$this->record_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineDistribution the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function checkoffnew($attribute, $params) {
		if($this->offConsumeNew != 0 || $this->offRefNew != 0 || $this->offRegion != 0 || $this->offProvince != 0 || $this->offCity != 0 || $this->offDistrict != 0 || $this->offMachineLine != 0 || $this->offMachineOperation != 0 || $this->gateMachineRef != 0 || $this->offManeuver != 0){
			$total = $this->offConsumeNew + $this->offRefNew + $this->offRegion + $this->offProvince + $this->offCity +
			$this->offDistrict + $this->offMachineLine + $this->offMachineOperation + $this->gateMachineRef + $this->offManeuver;
			if ($total > 100) {
				$this->addError($attribute, Yii::t('OfflineDistribution', '线下分配和不可以大于100%，修改失败！或者全部设置为空'));
			}
		}
		
	}

}
