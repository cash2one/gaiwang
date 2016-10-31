<?php

/**
 * This is the model class for table "{{member_register_number_limit}}".
 *
 * The followings are the available columns in table '{{member_register_number_limit}}':
 * @property string $id
 * @property string $number_start
 * @property string $number_end
 * @property integer $status
 * @property integer $create_admin_id
 * @property integer $create_time
 * @property integer $update_admin_id
 * @property integer $update_time
 */
class MemberRegisterNumberLimit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_register_number_limit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number_start, number_end, create_admin_id, create_time,status', 'required'),
			array('status, create_admin_id, create_time, update_admin_id, update_time,number_start,number_end', 'numerical', 'integerOnly'=>true),
			array('number_start, number_end', 'length', 'max'=>8),
			array('number_start,number_end', 'Check'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number_start, number_end, status, create_admin_id, create_time, update_admin_id, update_time', 'safe', 'on'=>'search'),
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
			'number_start' => '开始账号',
			'number_end' => '结束账号',
			'status' => '状态',
			'create_admin_id' => 'Create Admin',
			'create_time' => 'Create Time',
			'update_admin_id' => 'Update Admin',
			'update_time' => 'Update Time',
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
		$criteria->compare('number_start',$this->number_start,true);
		$criteria->compare('number_end',$this->number_end,true);
		//$criteria->compare('status',true);
		$criteria->compare('create_admin_id',$this->create_admin_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_admin_id',$this->update_admin_id);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberRegisterNumberLimit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function Check($attribute,$params){
		if($this->number_start >= $this->number_end){
			$this->addError('number_start',Yii::t('MemberRegisterNumberLimit','开始账号小于结束账号')."!");
		}
	}
}
