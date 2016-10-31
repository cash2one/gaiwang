<?php

/**
 * This is the model class for table "{{auth_assignment}}".
 *
 * The followings are the available columns in table '{{auth_assignment}}':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 */
class AuthAssignment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{auth_assignment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max'=>64),
			array('bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::HAS_MANY ,'User',array('id' => 'userid'),'joinType'=>'LEFT JOIN'),
			'role' => array(self::HAS_ONE,'AuthItem',array('name'=>'itemname'),'joinType'=>'JOIN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => 'Itemname',
			'userid' => 'Userid',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
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
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getAllGroupUid(){
    	$sql = " select concat(userid,'_') as userid,GROUP_CONCAT(description) as roles from ".self::tableName()." t ".
    			" left join ".AuthItem::model()->tableName()." role ON role.name = t.itemname group by userid ";
    	$res = Yii::app()->db->createCommand($sql)->queryAll();
    	$res = empty($res) ? array() : ArrayHelper::array_column_Ex($res,'userid','roles');
    	return $res;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function primaryKey(){
		return "userid";
	}
}
