<?php

/**
 * This is the model class for table "{{feedback}}".
 *
 * The followings are the available columns in table '{{feedback}}':
 * @property integer $id
 * @property string $content
 * @property string $username
 * @property string $gai_number
 * @property string $picture
 * @property string $mobile
 * @property integer $created
 * @property integer $ip
 */
class Feedback extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{feedback}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, username, gai_number, mobile, created, ip', 'required'),
			array('created, ip', 'numerical', 'integerOnly'=>true),
			array('username, mobile', 'length', 'max'=>30),
            array('content', 'length','max'=>500),
			array('gai_number, mobile', 'length', 'max'=>20),
			array('picture', 'length', 'max'=>400),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, content, username, gai_number, picture, mobile, created, ip', 'safe', 'on'=>'search'),
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
			'content' => Yii::t('Feedback','反馈意见'),
			'username' => Yii::t('Feedback','联系人'),
			'gai_number' => '盖网编号',
			'picture' => Yii::t('Feedback','上传相关图片'),
			'mobile' => Yii::t('Feedback','联系方式'),
			'created' => '反馈时间',
			'ip' => 'Ip',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('gai_number',$this->gai_number,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('ip',$this->ip);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'id DESC', //设置默认排序
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
