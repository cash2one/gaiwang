<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class RegionManage extends CActiveRecord
{
	
	public $real_name;
	public $city_id;
	public $member_gw;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{region_manage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, member_id', 'required'),
			array('name', 'length', 'max'=>120),
			array('member_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, member_id', 'safe', 'on'=>'search'),
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
			'id' => '主键id',
			'name' => '大区名称',
			'member_id' => '所属会员',
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
        $criteria->select = 't.id,t.name,m.real_name';
        $criteria->join = " left join ".Member::model()->tablename()." m on(m.id = t.member_id and m.status = ".Member::STATUS_NORMAL.")";
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('member_id',$this->member_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegionManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
