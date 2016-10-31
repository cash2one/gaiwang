<?php

/**
 * This is the model class for table "{{auth_item_child}}".
 *
 * The followings are the available columns in table '{{auth_item_child}}':
 * @property string $parent
 * @property string $child
 */
class AuthItemChild extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{auth_item_child}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('parent, child', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'role'   => array(self::BELONGS_TO,'AuthItem', array('parent' => 'name'),'joinType'=>'JOIN'),
		);
	}

	public function primaryKey(){
		return "parent";
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'parent' => 'Parent',
			'child' => '权限值',
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
		$criteria->with = array(
			'role'   => array(
				'select'=>'name',
				'with'=>array(
					'assigments' => array(
							'select'=>'itemname,userid',
							'with' => array('user' => array('select'=>'username'))
					),
				),
			),
		);

        $criteria->select = 't.*';
        $criteria->compare('t.child',$this->child);
        $pagination = array(
          'pageSize' => 50,
        );

        return new CActiveDataProvider($this, array(
          'criteria'=>$criteria,
          'pagination' => $pagination,
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthItemChild the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
