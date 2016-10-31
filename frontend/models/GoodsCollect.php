<?php

/**
 * This is the model class for table "{{goods_collect}}".
 *
 * The followings are the available columns in table '{{goods_collect}}':
 * @property string $id
 * @property string $good_id
 * @property string $member_id
 * @property integer $create_time
 */
class GoodsCollect extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{goods_collect}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('good_id, member_id, create_time', 'required'),
            array('create_time', 'numerical', 'integerOnly'=>true),
            array('good_id, member_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, good_id, member_id, create_time', 'safe', 'on'=>'search'),
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
            'good_id' => 'Good',
            'member_id' => 'Member',
            'create_time' => 'Create Time',
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
        $criteria->compare('good_id',$this->good_id,true);
        $criteria->compare('member_id',$this->member_id,true);
        $criteria->compare('create_time',$this->create_time);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * 前台会员中心收藏商品列表
     * @param $member_id 会员id
     * @return CDbCriteria
     */
    public function searchGoods($member_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.member_id=:member_id');
        $criteria->params = array(':member_id' => $member_id);
        //商品搜索
        if (!empty($this->goods_name)) {
            $criteria->join = 'LEFT JOIN {{order_goods}} as o ON o.order_id=t.id';
            $criteria->compare('o.goods_name', $this->goods_name, true);
        }
    
        //$criteria->goodscollect = 't.create_time DESC';
        return $criteria;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GoodsCollect the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
