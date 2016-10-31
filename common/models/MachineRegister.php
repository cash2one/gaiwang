<?php

/**
 * This is the model class for table "{{machine_register}}".
 *
 * The followings are the available columns in table '{{machine_register}}':
 * @property string $id
 * @property integer $machine_id
 * @property string $member_id
 * @property string $register_time
 */
class MachineRegister extends CActiveRecord
{
	
	public $start_time,$end_time,$gai_number;		//用于搜索
	
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{machine_register}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('machine_id, member_id, register_time', 'required'),
            array('machine_id', 'numerical', 'integerOnly'=>true),
            array('member_id,gai_number', 'length', 'max'=>50),
            array('register_time', 'length', 'max'=>10),
        		array('start_time,end_time', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, machine_id, member_id, register_time,start_time,end_time,gai_number', 'safe', 'on'=>'search'),
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
            'machine_id' => '盖机id',
            'member_id' => '会员编号',
            'register_time' => '注册时间',
            'gai_number'=> Yii::t('member','会员编号'),
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
        $criteria->compare('machine_id',$this->machine_id);
        $criteria->compare('member_id',$this->member_id,true);
        $criteria->compare('register_time',$this->register_time);
        $criteria->compare('member_id',$this->gai_number,true);
        
        if($this->start_time)
        {
        	$criteria->compare('t.register_time',' >='.strtotime($this->start_time));
        }
        if($this->end_time)
        {
        	$criteria->compare('t.register_time',' <'.(strtotime($this->end_time)+86400));
        }
        

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        	'sort'=>array(
        		'defaultOrder' => 'register_time DESC',
        	),
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->gt;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MachineRegister the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}