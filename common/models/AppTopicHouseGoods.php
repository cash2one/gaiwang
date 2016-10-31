<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class AppTopicHouseGoods extends CActiveRecord
{
    public $title;
    public $name;//商品名称
    public $thumbnail;
    public $gName;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{app_topic_house_goods}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
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
            'id' => '主键id',
            'gName' => '商品名称',
            'thumbnail'=> '商品图片',
            'sequence'=>'商品排序',
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

        $criteria = new CDbCriteria;
        $criteria->select = 't.*,g.name as gName,g.thumbnail as thumbnail';
        $criteria->join .= ' left join ' . Goods::model()->tableName() . ' as g on g.id = t.goods_id';
        $criteria->compare('t.house_id', $this->house_id);
        $sort = new CSort();
        $sort->attributes = array(
            'sequence' => array(
                'asc' => '`sequence`', 'desc' => '`sequence` desc', 'default' => 'desc',
            ),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10
            ),
            'sort' => $sort,
        ));
    }
    /*
     * 判断有没有绑定商品
     * */
    public static function checkBondGoods($houseId,$goodsId){
        $check = Yii::app()->db->createCommand()
            ->select('id')
            ->from(self::model()->tableName())
            ->where('house_id = :house_id and goods_id = :goods_id', array(':house_id' => $houseId, ':goods_id' => $goodsId))
            ->order('id desc')
            ->queryScalar();
        return empty($check)?'':$check;
    }
    
    /**
     * 判断商品是否参加了商城活动
     * @param unknown $goodsId
     */
    public static function checkBindActive($goodsId){
    	$activeId = Yii::app()->db->createCommand()
    	->select("id")->from(Goods::model()->tableName())->where("id = {$goodsId} and seckill_seting_id = 0")
    	->queryScalar();
    	return empty($activeId)?true:false;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegionManage the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}