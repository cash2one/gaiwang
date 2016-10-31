<?php

/**
 * This is the model class for table "{{signin}}".
 *
 * The followings are the available columns in table '{{signin}}':
 * @property string $member_id
 * @property string $create_date
 * @property string $create_time
 * @property string $ip
 * @property string $comment
 * @property string $machine_id
 * @property integer $type
 */
class Signin extends CActiveRecord
{
	public $gai_number,$start_time,$end_time;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{signin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_id, create_date, create_time, ip, comment', 'required'),
            array('type', 'numerical', 'integerOnly'=>true),
            array('member_id, create_date, create_time, ip, machine_id', 'length', 'max'=>11),
            array('comment', 'length', 'max'=>256),
        	array('gai_number', 'length', 'max'=>20),
        	array('start_time,end_time', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('member_id, create_date, create_time, ip, comment, machine_id, type,start_time,end_time', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'member_id' => '所属会员',
            'create_date' => '签到日期',
            'create_time' => '签到时间',
            'ip' => '会员IP',
            'comment' => '签到内容',
            'machine_id' => '所属终端机',
            'type' => '类型',
            'gai_number'=> Yii::t('member', '会员编码'),
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
        		'member'=>array('select'=>'gai_number')
        );
        
        $criteria->compare('t.member_id',$this->member_id);
        $criteria->compare('t.create_date',$this->create_date);
        $criteria->compare('t.create_time',$this->create_time);
        $criteria->compare('t.ip',$this->ip,true);
        $criteria->compare('t.comment',$this->comment,true);
        $criteria->compare('t.machine_id',$this->machine_id);
        $criteria->compare('t.type',$this->type);

        $criteria->compare('member.gai_number',$this->gai_number);
        
        if($this->start_time)
        {
        	$criteria->compare('t.create_time',' >='.strtotime($this->start_time));
        }
        if($this->end_time)
        {
        	$criteria->compare('t.create_time',' <'.(strtotime($this->end_time)+86400));
        }
        
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        	'sort'=>array(
        			'defaultOrder' => 't.create_time DESC',
        	),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Signin the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}