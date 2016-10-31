<?php

/**
 * This is the model class for table "{{app_service}}".
 *
 * The followings are the available columns in table '{{app_service}}':
 * @property string $id
 * @property string $content
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property string $create_user
 * @property string $update_user
 */
class AppService extends CActiveRecord
{
	const CONTENT_TYPE_ORDER = 1;
	const CONTENT_TYPE_PAY = 2;
	const CONTENT_TYPE_CONSUM = 3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_service}}';
	}
	
	/**
	 * 
	 * @param null $key
	 * @return array
	 */
	public static function getPublish($key = null){
		$data = array(
				self::CONTENT_TYPE_ORDER => Yii::t('AppService','订单问题'),
				self::CONTENT_TYPE_PAY => Yii::t('AppService','支付问题'),
				self::CONTENT_TYPE_CONSUM => Yii::t('AppService','消费积分'),
		);
		return $key === null ? $data : $data[$key];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, create_time, create_user', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time, create_user, update_user', 'length', 'max'=>11),
// 			array('content', 'safe'),
// 			// The following rule is used by search().
// 			// @todo Please remove those attributes that should not be searched.
// 			array('id, content, type, create_time, update_time, create_user, update_user', 'safe', 'on'=>'search'),
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
			'content' => '内容',
			'type' => '内容类型,1订单问题,2支付问题,3消费积分',
			'create_time' => '创建时间',
			'update_time' => '编辑时间',
			'create_user' => '创建者',
			'update_user' => '修改者',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user',$this->create_user,true);
		$criteria->compare('update_user',$this->update_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
