<?php

/**
 * This is the model class for table "{{member_good_number}}".
 *
 * The followings are the available columns in table '{{member_good_number}}':
 * @property string $number
 * @property integer $status
 */
class MemberGoodNumber extends CActiveRecord
{
	public $type; //生成靓号的类型 2位，3位或4位
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_good_number}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('number, status', 'safe', 'on'=>'search'),
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
			'number' => '靓号',
			'status' => '状态',
			'type' => '类型'
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
		$criteria->select = "number,case status when 0 then '未注册' when 1 then '已注册' when 2 then '预留' else 'Unkonw' end as status,type";
		$criteria->compare('number',$this->number,true);
		//$criteria->compare('status',$this->status);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberGoodNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
