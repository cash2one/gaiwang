<?php

/**
 * This is the model class for table "{{abnormal_merchants}}".
 *
 * The followings are the available columns in table '{{abnormal_merchants}}':
 * @property string $id
 * @property string $merchants_id
 * @property integer $type
 */
class AbnormalMerchants extends CActiveRecord
{
    
     public $exportLimit = 5000; //导出excel长度
     public $isExport;
     public $name; //商家名称
     public $gai_number; //所属会员
     public $mobile; //电话
      public $exportPageName = 'page'; //导出excel时的分页参数名
     const TYPE_OFFLINE = 1 ;//加盟商
     const TYPE_ONLINE = 2 ; //线上商铺

     /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{abnormal_merchants}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('merchants_id', 'required'),
            array('type', 'numerical', 'integerOnly'=>true),
            array('merchants_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, merchants_id, type', 'safe', 'on'=>'search'),
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
            'franchisee'=>array(self::BELONGS_TO,'Franchisee','merchants_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'merchants_id' => '加盟商或者店铺的id',
            'type' => '类型（1加盟商、2线上店铺）',
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
        if(!empty($this->name)){
            $c = new CDbCriteria;
            $c->compare('name',$this->name,true);
            $data = Franchisee::model()->find($c);
            $mid = $data->id;
            $criteria->compare('merchants_id',$mid);
        }elseif(!empty($this->gai_number)){
            $m = new CDbCriteria;
            $m->compare('gai_number',$this->gai_number);
            $member = Member::model()->find($m);
            $c = new CDbCriteria;
            $c->compare('member_id',$member->id,true);
            $data = Franchisee::model()->find($c);
            $mid = $data->id;
            $criteria->compare('merchants_id',$mid);
        }
        else{
            $criteria->compare('merchants_id',$this->merchants_id);
        }
        $criteria->compare('id',$this->id,true);
        
        $criteria->compare('type',$this->type);
       $criteria->with = array('franchisee');
    
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    /**
     * 获取
     * @return \CActiveDataProvider
     */
      public function getData()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        if(!empty($this->name)){
              $criteria->compare('franchisee.name',$this->name,true);
        }
        if(!empty($this->gai_number)){
             $criteria->join='left join {{franchisee}} as f on f.id=t.merchants_id left join {{member}} as m on m.id=f.member_id  ';
              $criteria->compare('m.gai_number',$this->gai_number,true);
        }
         $pagination = array(
            'pageSize' => 20, //分页
        );
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        $criteria->compare('t.merchants_id',$this->merchants_id);
        $criteria->compare('t.id',$this->id,true);
        
        $criteria->compare('t.type',$this->type);
       $criteria->with = array('franchisee');
    
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
             'pagination' => $pagination
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AbnormalMerchants the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}