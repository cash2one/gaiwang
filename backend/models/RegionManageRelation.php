<?php

/**
 * This is the model class for table "{{region_manage_relation}}".
 *
 * The followings are the available columns in table '{{region_manage_relation}}':
 * @property integer $id
 * @property string $region_manage_id
 * @property string $user_id
 */
class RegionManageRelation extends CActiveRecord
{
	public $username;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return self::getTableName();
	}

	public static function getTableName(){

		return '{{region_manage_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_manage_id, user_id', 'required'),
			array('region_manage_id', 'length', 'max'=>120),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, region_manage_id, user_id', 'safe', 'on'=>'search'),
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
			'region_manage_id' => '大区id',
			'user_id' => '红色后台的账号id',
			'username'=>'会员账号',
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
		if(!empty($this->username)){
			$sql = "SELECT  id FROM ".User::model()->tablename()." where username like '%".$this->username."%'";
            $data = Yii::app()->db->createCommand($sql)->queryColumn();
			$criteria->addInCondition('t.user_id', $data);
		}
		$criteria->select = "t.id,u.username";
		$criteria->join = " left join ".User::model()->tablename()." as u on t.user_id = u.id";
		$criteria->addCondition("region_manage_id = ".$this->region_manage_id);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('region_manage_id',$this->region_manage_id,false);
		$criteria->compare('user_id',$this->user_id,false);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegionManageRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
