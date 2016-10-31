<?php
/**
 * 店铺评论类
 * @author qiuye.xu
 */
class  StoreComment extends CActiveRecord
{
    /**
     * 表名
     * @return string  表名
     */
    public function tableName() {
        return '{{store_comment}}';
    }
    /**
     * 字段规则
     */
    public function rules() {
        return array(
            array('description_match,serivice_attitude,speed_of_delivery,id,store_id,impress_id,order_id', 'safe'),
            array('description_match,serivice_attitude,speed_of_delivery','numerical', 'max' => 5,'min'=>1,'on'=>'comment'),
            array('description_match,serivice_attitude,speed_of_delivery', 'required','on'=>'comment')
        );
    }
    
    /**
     * 属性label
     */
    public function attributeLabels(){
        return array(
            'id' => '主键',
            'order_id' => '订单ID',
            'store_id' => '店铺ID',
            'description_match' => '描述相符',
            'serivice_attitude' => '服务态度',
            'speed_of_delivery' => '发货速度'
        );
    }

    /**
     * 与描述相符店铺
     * @param int $storeId 店铺ID
     * @return float|int 与描述相符平均
     */
    public static function getDescriptionMatch($storeId)
    {
        if(is_numeric($storeId)){
            return self::model()->find(array(
                'select'=> 'AVG(description_match) as description_match',
                'condition' => 'store_id = :store_id',
                'params' => array(':store_id'=>$storeId)
            ));
        }
        return false;
    }
    /**
     * 返回店铺各项评分
     * @param int $storeId 店铺ID
     * @return boolean|object
     */
    public static function getStoreComment($storeId)
    {
        if(is_numeric($storeId)){
            return self::model()->find(array(
                'select' => 'AVG(description_match) as description_match,AVG(serivice_attitude) as serivice_attitude,AVG(speed_of_delivery) as speed_of_delivery',
                'condition' => 'store_id=:store_id',
                'params' => array(':store_id'=>$storeId)
            ));
        }
        return false;
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
