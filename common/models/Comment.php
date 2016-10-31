<?php

/**
 * 商品评分模型
 * @author wanyun.liu <wanyun_liu@163.com>
 *
 * @property string $id
 * @property string $order_id
 * @property string $store_id
 * @property string $goods_id
 * @property string $member_id
 * @property string $score
 * @property string $content
 * @property string $create_time
 * @property integer $status
 */
class Comment extends CActiveRecord
{

    //连表查询使用
    public $description_math;
    public $service_attitude;
    public $speed_of_delivery;
    public $goods_name;
    
    public $endTime;

    //（0关闭，1显示）
    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;
    //(0未修改，1已修改)
    const EDIT_TRUE = 1;
    const EDIT_FALSE = 0;

    /* 评论买家8种印象 */
    const IMPRESS_NONE = 0; //无印象
    const IMPRESS_FIRST = 1;
    const IMPRESS_SECOND = 2;
    const IMPRESS_THIRD = 3;
    const IMPRESS_FORTH = 4;
    const IMPRESS_FIFTH = 5;
    const IMPRESS_SIXTH = 6;
    const IMPRESS_SEVEN = 7;
    const IMPRESS_EIGHTH = 8;

    /**
     * 评论可见性状态
     * @param $k
     * @return array|null
     */
    public static function status($k = null)
    {
        $arr = array(
            self::STATUS_HIDE => Yii::t('comment', '不可见'),
            self::STATUS_SHOW => Yii::t('comment', '可见'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 获取买家的某种印象或者全部印象
     * @param int 
     * @return array 返回单条或者多条印象 
     * @author qiuye.xu
     */
    public static function getImpress($impress_id = array()) {
        $impress = array(
            self::IMPRESS_FIRST => array('type'=>1, 'name'=> Yii::t('memberComment', '物美价廉')),
            self::IMPRESS_SECOND => array('type'=>1, 'name' => Yii::t('membercomment', '性价比高')),
            self::IMPRESS_THIRD => array('type'=>1, 'name' => Yii::t('membercomment', '好看')),
            self::IMPRESS_FORTH => array('type'=>1, 'name' => Yii::t('membercomment', '质量好')),
            self::IMPRESS_FIFTH => array('type'=>1, 'name' => Yii::t('membercomment', '正品')),
            self::IMPRESS_SIXTH => array('type'=>1, 'name' => Yii::t('membercomment', '服务态度好')),
            self::IMPRESS_SEVEN => array('type'=>0, 'name' => Yii::t('membercomment', '商品有瑕疵')),
            self::IMPRESS_EIGHTH=> array('type'=>0, 'name' => Yii::t('membercomment', '质量不好'))
        );
        if (!empty($impress_id)) {
            $minpress = array();
            foreach ($impress_id as $i) {
                $minpress[$i] = $impress[$i]['name'];
            }
            return $minpress;
        }
        return $impress;
    }

    public function tableName()
    {
        return '{{comment}}';
    }

    public function rules()
    {
        return array(
            array('order_id, store_id, goods_id, member_id, score, content, create_time', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('score', 'in', 'range' => array(1, 2, 3, 4, 5)),
            array('store_id, goods_id, member_id, create_time', 'length', 'max' => 11),
            array('id, order_id, store_id, goods_id, member_id, score, content, create_time, status,goods_name', 'safe', 'on' => 'search'),
            array('order_id, create_time', 'safe', 'on' => 'searchList'),
            array('endTime,order_id, store_id, goods_id, member_id, content,score,img_path,spec_value,is_anonymity', 'safe'),
//            array('content', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
//            array('img_path','file','types'=>array('jpg','png','gif','bmp','jpeg'),'maxSize'=>1)
        );
    }

    public function relations()
    {
        return array(
            'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'orderGoods' => array(self::BELONGS_TO, 'OrderGoods', '', 'on'=>'t.order_id=orderGoods.order_id and t.goods_id=orderGoods.goods_id'),
            'goods' => array(self::BELONGS_TO, 'Goods', 'goods_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'store' => array(self::BELONGS_TO,'Store','store_id')
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'order_id' => '所属订单',
            'store_id' => '所属商家',
            'goods_id' => Yii::t('comment', '商品'),
            'member_id' => '评分会员',
            'score' => '评分',
            'content' => '评价内容',
            'create_time' => '评价时间',
            'status' => '状态', //（0关闭，1显示）
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('score', $this->score, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('g.name', $this->goods_name, true);
        $criteria->compare('t.status', $this->status);

        //连表查询
        $criteria->select = 't.*, y.code as order_id,c.name as store_id,g.name as goods_name,
        m.gai_number as member_id';
        $criteria->join = 'left join {{order}} as y on t.order_id=y.id';
        $criteria->compare('y.code', $this->order_id, true);

        $criteria->join .= ' left join {{store}} as c on t.store_id=c.id';
        $criteria->compare('c.name', $this->store_id, true);

        $criteria->join .= ' left join {{goods}} as g on t.goods_id=g.id';
        $criteria->compare('c.name', $this->goods_id, true);

        $criteria->join .= ' left join {{member}} as m on t.member_id=m.id';
        $criteria->compare('m.gai_number', $this->member_id, true);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);

        $criteria->order = 't.create_time DESC';

        return $criteria;
    }

    /**
     * 会员中心列表
     * @limit int 每页个数
     * @return \CActiveDataProvider
     */
    public function searchList($limit=25)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('order.code', $this->order_id);
        $criteria->addCondition('t.member_id = ' . Yii::app()->user->id);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);

        $criteria->with = array(
            'order' => array(
                'select' => 'order.id, order.code, order.create_time',
            ),
            'goods' => array(
                'select' => 'goods.name, goods.id, goods.thumbnail, goods.price,goods.activity_tag_id,goods.join_activity,goods.gai_sell_price,at.status AS at_status',
                'join' => 'LEFT JOIN {{activity_tag}} AS at ON goods.activity_tag_id=at.id'
            ),
            'orderGoods' => array(
                'select' => 'orderGoods.rules_setting_id, orderGoods.unit_price'
            ),
            'store' => array(
                'select'=>'store.name,store.id'
            )
        );
        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $limit,
                ),
                'sort' => array(
                    'defaultOrder' => 't.create_time DESC',
                )
            )
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
