<?php
/**
 * 游戏商铺商品模型
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/11/19 11:29
 * The followings are the available columns in table '{{game_store_items}}':
 * @property integer $id
 * @property integer $store_id
 * @property string $item_name
 * @property integer $item_number
 * @property integer $item_status
 * @property string $item_description
 * @property string $store_description
 * @property  string $start_date
 * @property  string $end_date
 * @property  string $start_time
 * @property  string $end_time
 * @property  integer $limit_per_time
 * @property  integer $bees_number
 * @property  integer $create_time
 * @property  integer $update_time
 */
class GameStoreItems extends CActiveRecord
{
    //商品状态
    const STATUS_ONLINE = 1;   //上架
    const STATUS_OFFLINE = 2;   //下架

    //特殊商品
    const FLAG_ITEMS_NO = 0;  //否
    const FLAG_ITEMS_YES = 1; //是

    public function tableName()
    {
        return '{{game_store_items}}';
    }

    /*
     * 特殊商品
     * @param int $key
     */
    public static function flagItems($key = null){
        $arr = array(
            self::FLAG_ITEMS_NO => Yii::t('gameStoreItems', '否'),
            self::FLAG_ITEMS_YES => Yii::t('gameStoreItems', '是'),
        );
        if(is_numeric($key)){
            return isset($arr[$key]) ? $arr[$key] : null;
        }else{
            return $arr;
        }
    }

    /**
     * 普通商品产品
     */
    public static function ordinary($goods){
        $items = array(
            '柚子' => '柚子',
            '橙子' => '橙子',
            '蓝莓' => '蓝莓',
            '芒果' => '芒果',
            '苹果' => '苹果',
            '青枣' => '青枣',
            '石榴' => '石榴',
            '火龙果' => '火龙果',
            '枇杷' => '枇杷',
            '纽荷尔' => '纽荷尔',
            '干枣' => '干枣',
            '释迦' => '释迦',
            '碰柑' => '碰柑',
        );
        if(!empty($goods)){
            foreach($goods as $v){
                unset($items[$v]);
            }
        }
        return $items;
    }

    /**
     * 特殊商品产品
     */
    public static function special($goods){
        $items = array(
            '赣花野山茶油' => '赣花野山茶油',
            '金丝楠木佛珠手串（黑色）' => '金丝楠木佛珠手串（黑色）',
            '金丝楠木佛珠手串（银色）' => '金丝楠木佛珠手串（银色）',
            '梨园祥丽雅阁酒店免费入住劵' => '梨园祥丽雅阁酒店免费入住劵',
            '名仁大酒店免费入住劵' => '名仁大酒店免费入住劵',
            '盖网定制版手机微软LUMIA950XL' => '盖网定制版手机微软LUMIA950XL',
            '一份芒果' => '一份芒果',
        );
        if(!empty($goods)){
            foreach($goods as $v){
                unset($items[$v]);
            }
        }
        return $items;
    }

    public function rules(){
        return array(
            array('item_name,item_number,item_status,limit_per_time,start_date,end_date,start_time,end_time,bees_number,probability','required'),
//            array('bees_number','required','on'=>'Create'),
//            array('bees_number','required','on'=>'update'),
//            array('probability','required','on'=>'Createflag'),
//            array('probability','required','on'=>'updateflag'),
            array('item_number,bees_number,limit_per_time,probability','numerical', 'integerOnly'=>true),
            array('item_number,limit_per_time','compare', 'compareValue'=>'0', 'operator'=>'>', 'message'=>Yii::t('gameStoreItems', '必须大于0')),
            array('bees_number,probability','compare', 'compareValue'=>'0', 'operator'=>'>=', 'message'=>Yii::t('gameStoreItems', '不能小于0')),
            array('bees_number','compare', 'compareValue'=>'9', 'operator'=>'<=', 'message'=>Yii::t('gameStoreItems', '不能大于9')),
            array('probability','compare', 'compareValue'=>'1000000', 'operator'=>'<=', 'message'=>Yii::t('gameStoreItems', '不能大于1000000')),
            array('start_date','checkDate'),
            array('store_description','length','max' => 10),
            array('item_description','length','max' => 20),
            array('item_name','length','max'=>20),
            array('item_number','length','max'=>9),
            array('item_name','checkItemName','on' => 'Create'),
            array('item_name','checkItemName','on' => 'Createflag'),
            array('id,store_id, item_name,item_number, item_status,item_description, store_description,start_date,end_date,start_time,end_time,
            limit_per_time,bees_number,create_time, update_time, probability', 'safe'),
        );
    }

    public function checkItemName() {
        $exists = $this->exists('store_id = :sid AND item_name = :name', array(':sid' => $this->store_id, ':name' => $this->item_name));
        if ($exists) {
            $this->addError('item_name',  $this->getAttributeLabel('item_name') . '不可重复！');
        }
    }

    public function checkDate(){
        $start_date = strtotime($this->start_date);
        $end_date = strtotime($this->end_date);
        $start_time = strtotime($this->start_time);
        $end_time = strtotime($this->end_time);
        if($start_date > $end_date){
            $this->addError('start_date',Yii::t('GameStoreItems', '开始日期不能大于结束时间'));
            $this->addError('end_date',Yii::t('GameStoreItems', '结束日期不能少于开始时间'));
        }
        if($start_time > $end_time){
            $this->addError('start_time',Yii::t('GameStoreItems', '开抢时间不能大于结束时间'));
            $this->addError('end_time',Yii::t('GameStoreItems', '结束时间不能少于开抢时间'));
        }
    }

    public function relations(){
        return array(

        );
    }

    /**
     * 商品状态
     * @param $key
     * @return array|null
     */
    public static function status($key = null) {
        $arr = array(
            self::STATUS_ONLINE => Yii::t('gameStoreItems', '上架'),
            self::STATUS_OFFLINE => Yii::t('gameStoreItems', '下架'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'store_id' => '店铺',
            'item_name' => '商品名称',
            'item_number' => '每日提供数量',
            'item_status' => '商品状态',
            'item_description' => '商品描述',
            'store_description' => '商家描述',
            'start_date' => '活动开始日期',
            'end_date' => '活动结束日期',
            'start_time' => '每日开始时间',
            'end_time' => '每日结束时间',
            'limit_per_time' => '用户单次获得数量',
            'bees_number' => '蜜蜂数量',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'probability' => '概率'
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('item_status', $this->item_status, true);
        $criteria->compare('item_description', $this->item_description, true);
        $criteria->compare('store_description', $this->store_description, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('end_time', $this->end_time, true);
        $criteria->compare('limit_per_time', $this->limit_per_time, true);
        $criteria->compare('bees_number', $this->bees_number, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}