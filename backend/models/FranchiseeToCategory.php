<?php

/**
 * This is the model class for table "{{franchisee_to_category}}".
 *
 * The followings are the available columns in table '{{franchisee_to_category}}':
 * @property string $franchisee_category_id
 * @property string $franchisee_id
 *
 * The followings are the available model relations:
 * @property Franchisee $franchisee
 * @property FranchiseeCategory $franchiseeCategory
 */
class FranchiseeToCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_to_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('franchisee_category_id, franchisee_id', 'required'),
			array('franchisee_category_id, franchisee_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('franchisee_category_id, franchisee_id', 'safe', 'on'=>'search'),
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
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
			'franchiseeCategory' => array(self::BELONGS_TO, 'FranchiseeCategory', 'franchisee_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'franchisee_category_id' => '加盟商分类',
			'franchisee_id' => '加盟商',
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

		$criteria->compare('franchisee_category_id',$this->franchisee_category_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeToCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
