<?php

/**
 * This is the model class for table "{{prepaid_card_batch_record}}".
 *
 * The followings are the available columns in table '{{prepaid_card_batch_record}}':
 * @property integer $id
 * @property string $mobile
 * @property string $money
 * @property integer $status
 * @property integer $create_time
 */
class PrepaidCardBatchRecord extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{prepaid_card_batch_record}}';
    }
    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,batch_number,create_time,author_ip,author_id,author_name','numerical', 'integerOnly'=>true),
            array('mobile', 'length', 'max'=>32),
            array('card_number,card_pwd,author_name','length','max'=>128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mobile, money, status, batch_number,card_number,card_pwd,author_ip,author_id,author_name, create_time', 'safe', 'on'=>'search'),
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
            'mobile' => '手机号码',
            'money' => '积分',
            'create_time' => '申请时间',
            'card_number' => '充值卡号',
            'author_ip' => '创建者IP',
            'author_id' => '创建者',
            'author_name' => '创建者名称',
            'batch_number' => '批号'
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
        $criteria->compare('mobile',$this->mobile,true);
        $criteria->compare('money',$this->money,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('create_time',$this->create_time);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ImportRechargeRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}