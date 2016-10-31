<?php

/**
 * This is the model class for table "{{third_login}}".
 *
 * The followings are the available columns in table '{{third_login}}':
 * @property string $member_id
 * @property string $third_id
 * @property integer $type
 * @property string $create_time
 */
class ThirdLogin extends CActiveRecord
{
    
    const TYPE_DUIMIAN = 0;//对面
    const TYPE_WEIBO = 1;//微博
    const TYPE_QQ = 2;//QQ
    
    /**
     * 第三方类型
     * @return array
     */
    public static function ThirdType($type) {
        $arr= array(
                self::TYPE_DUIMIAN => Yii::t('thirdLogin', '对面'),
                self::TYPE_WEIBO => Yii::t('thirdLogin', '微博'),
                self::TYPE_QQ => Yii::t('thirdLogin', 'qq'),
        );
        if (is_numeric($type)) {
            return isset($arr[$type]) ? $arr[$type] : null;
        } else {
            return $arr;
        }
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{third_login}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('member_id', 'length', 'max'=>11),
			array('third_id', 'length', 'max'=>64),
			array('create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, third_id, type, create_time', 'safe', 'on'=>'search'),
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
			'member_id' => '盖网会员id',
			'third_id' => '第三方登录Id',
			'type' => '第三方登录平台(0.对面,1.weibo,2.qq,3.微信)',
			'create_time' => '创建时间',
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

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('third_id',$this->third_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwThirdLogin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
