<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class AppTopicGoodsDetails extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{app_topic_goods_details}}';
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
            array('id, goods_id, dateils', 'safe', 'on'=>'search'),
        	array('label',"checkLabel"),
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
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'dateils' => '商品详情',
            'label' => '标签',
        );
    }
    /*
     * 查询是否存在商品
     * */
    public static function checkGodos($Gid){
        $goods = Yii::app()->db->createCommand()
            ->select('id')
            ->from(self::model()->tableName())
            ->where('goods_id = :goods_id', array(':goods_id' => $Gid))
            ->queryScalar();
        if(empty($goods)){
            $temp = Yii::app()->db->createCommand()->insert(AppTopicGoodsDetails::model()->tableName(),array('goods_id'=>$Gid));
            $goods = Yii::app()->db->getLastInsertID();
        }
        $extendModel = AppTopicGoodsDetails::model()->findByPk($goods);
        return $extendModel;

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
    
    public function checkLabel($attribute,$params){
    	$Label = $this->label;
    	$labelArr = explode("|", $Label);
    	foreach ($labelArr as $val){
    		if(mb_strlen($val,'utf-8') > 5 ){
    			$this->addError('label',"每个标签的字数不可超过5个");
    			break;
    		}
    	}
    }
}