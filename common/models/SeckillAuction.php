<?php

/**
 * 拍卖商品管理模型
 * @author_id 
 *
 */
class SeckillAuction extends CActiveRecord{

    public static $menu2 = array();
    public $rules_setting_id;
   // public $store_id;
    public $price_markup;
    public $goods_name;
    public $seller_name;
    public $rules_name;
    public $active_status;
    public $goods_id;
    public $start_time;
    public $end_time;
	public $is_force;
	public $reserve_price;
	public $gds_id;

    const STATUS_NO = 0;//关闭
    const STATUS_YES = 1;//开启

    public function tableName() {
        return '{{seckill_auction}}';
    }

    public function rules() {
        return array(
            array('goods_id,start_price,price_markup,status,category_id,rules_setting_id,create_time,create_user', 'required'),
            array('goods_id,status,rules_setting_id', 'numerical', 'integerOnly'=>true, 'on'=>'add,update'),
            array('start_price,price_markup', 'numerical', 'on'=>'update'),
            array('start_price,price_markup', 'compare', 'operator' => '>', 'compareValue' => 0, 'except' => 'general'), // 必须大于 0
            );
    }

    public function attributeLabels() {
        return array(
            'id' => '编号',
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'seller_name' => '商家名称',
            'start_price' =>  '起拍价',
            'price_markup' => '加价幅度',
            'stock' => '商品库存',
            'status' => '状态',
            'category_id' =>  '活动类别ID',
            'rules_setting_id' =>  '活动规则表ID',
            'rules_name' =>  '所属活动',
            'create_time' =>  '创建时间',
            'create_user' =>  '创建者',
            );
    }
    
    public function relations(){   
        return array(
            'goodsId'   => array(self::HAS_ONE,'goods', array('id' => 'goods_id'),'alias'=>'g','joinType'=>'JOIN'),
            'storeId'   => array(self::HAS_MANY,'store', array('id' => 'store_id'),'alias'=>'s','joinType'=>'JOIN'),
            //'storeId'   => array(self::HAS_MANY,'store', array('id' => 'store_id'),'alias'=>'s','joinType'=>'JOIN'),
            'rulesId'   => array(self::HAS_ONE,'SeckillRulesSeting', array('id' => 'rules_setting_id'),'alias'=>'srs','joinType'=>'JOIN'),
            'auctionPrice' => array(self::HAS_ONE,'SeckillAuctionPrice',array('rules_setting_id'=>'rules_setting_id'),'alias'=>'sar','joinType'=>'JOIN'),
        );
    }   

    /**
     * 获取活动状态
     * @return array 返回状态数组
     */
    public static function getStatusArray($key = null)
    {
        $arr = array(
            self::STATUS_NO => '关闭',
            self::STATUS_YES => '开启',
        );
        return $key !== null ? (isset($arr[$key]) ? $arr[$key] : '未知状态') : $arr;
    }
    /**
     * 删除拍卖商品操作
     * @param type $id  拍卖商品的主键id
     * @return boolean
     */
    public function del($id) {
        $model = $this->findByPk($id);
        $res = $model->delete();
        if($res){
            return TRUE;
        }
    }
    

   public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('goods_id', $this->goods_id, true);
        //$criteria->compare('goods_name', $this->goods_name, true);
        $criteria->compare('start_price', $this->start_price);
        $criteria->compare('price_markup', $this->price_markup, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('rules_setting_id', $this->rules_setting_id, true);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('create_user', $this->create_user);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
                ),
            'sort' => array(
                'defaultOrder' => 'id ASC',
                ),
            ));
    }

   public static function model($className = __CLASS__) {
        return parent::model($className);
   }
}
