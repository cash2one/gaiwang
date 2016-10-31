<?php

/**
 * This is the model class for table "{{franchisee_table}}".
 *
 * The followings are the available columns in table '{{franchisee_table}}':
 * @property string $id
 * @property string $name
 * @property integer $peoples
 * @property string $create_time
 * @property integer $status
 * @property string $franchisee_id
 *
 * The followings are the available model relations:
 * @property FranchiseeGoodsOrder[] $franchiseeGoodsOrders
 * @property Franchisee $franchisee
 */
class FranchiseeTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_table}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, peoples, create_time, status, franchisee_id', 'required'),
			array('peoples, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('create_time, franchisee_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, peoples, create_time, status, franchisee_id', 'safe', 'on'=>'search'),
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
			'franchiseeGoodsOrders' => array(self::HAS_MANY, 'FranchiseeGoodsOrder', 'franchisee_table_id'),
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'name' => '名称',
			'peoples' => '人数',
			'create_time' => '创建时间',
			'status' => '台号的状态（0未占用、1已占用），开台的时候更新为已占用，结账后更新为未占用',
			'franchisee_id' => '所属线下商家',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('peoples',$this->peoples);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
