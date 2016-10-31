<?php

/**
 *  订单商品表 模型
 *
 * @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{order_goods}}':
 * @property string $id
 * @property string $goods_id
 * @property string $order_id
 * @property string $quantity
 * @property string $unit_score
 * @property string $total_score
 * @property string $gai_price
 * @property string $unit_price
 * @property string $total_price
 * @property string $gai_income
 * @property string $spec_value
 * @property string $target_id
 * @property integer $mode
 * @property string $freight
 * @property string $freight_payment_type
 * @property string $goods_name
 * @property string $goods_picture
 */
class OrderGoods extends CActiveRecord {

    public function tableName() {
        return '{{order_goods}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('goods_id, order_id, quantity, unit_score, total_score, gai_price, unit_price,
             total_price, gai_income, mode, freight, freight_payment_type', 'required'),
            array('mode', 'numerical', 'integerOnly' => true),
            array('goods_id, order_id, quantity, gai_income, target_id, freight_payment_type', 'length', 'max' => 11),
            array('unit_score, total_score, gai_price, unit_price, total_price, freight', 'length', 'max' => 10),
            array('id, goods_id, order_id, quantity, unit_score, total_score, gai_price, unit_price,
             total_price, gai_income, target_id, mode, freight, freight_payment_type,
             spec_value,goods_name,goods_picture', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'goods' => array(self::BELONGS_TO, 'Goods', 'goods_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('orderGoods', '主键'),
            'goods_id' => Yii::t('orderGoods', '所属商品'),
            'order_id' => Yii::t('orderGoods', '所属订单'),
            'quantity' => Yii::t('orderGoods', '数量'),
            'unit_score' => Yii::t('orderGoods', '单品积分（单品消费积分）'),
            'total_score' => Yii::t('orderGoods', '总积分'),
            'gai_price' => Yii::t('orderGoods', '供货价'),
            'unit_price' => Yii::t('orderGoods', '单价（促销价）'),
            'total_price' => Yii::t('orderGoods', '总价'),
            'gai_income' => Yii::t('orderGoods', '盖网收入'),
            'spec_value' => Yii::t('orderGoods', '所属规格'),
            'target_id' => Yii::t('orderGoods', '所属对象'),
            'mode' => Yii::t('orderGoods', '运送方式（1快递，2EMS，3平邮）'),
            'freight' => Yii::t('orderGoods', '邮费'),
            'freight_payment_type' => Yii::t('orderGoods', '运输方式（1包邮，2运输方式，3运费模板）'), //Goods中有定义
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('goods_id', $this->goods_id, true);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('unit_score', $this->unit_score, true);
        $criteria->compare('total_score', $this->total_score, true);
        $criteria->compare('gai_price', $this->gai_price, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('gai_income', $this->gai_income, true);
        $criteria->compare('store_id', $this->store_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 组装插入订单商品数据
     * @param int $order_id 订单id
     * @param int $store_id 商家id
     */
    public static function buildOrderGoods($order_id, $store_id, $freight, $selectMod) {
        $member_id = Yii::app()->user->id;
        $cartData = Yii::app()->db->createCommand()->select('c.*,g.name,g.thumbnail,g.price AS g_price,g.gai_price,g.gai_income,g.freight_template_id,g.freight_payment_type')
                ->from('{{cart}} c')
                ->join('{{goods}} g', 'c.goods_id=g.id')
                ->where('c.member_id=' . $member_id . ' AND c.store_id=' . $store_id)
                ->queryAll();
        $newData = array();
        foreach ($cartData as $k => $v) {
//            $goodsInfo = Goods::getGoodsData($v['goods_id'], array('thumbnail','name','price', 'gai_price', 'gai_income', 'freight_template_id', 'freight_payment_type'));
            $default_freight = FreightTemplate::getFreightInfo($v['freight_template_id'], 'default_freight');
            $mode = FreightTemplate::getFreightInfo($v['freight_template_id'], 'mode'); //运送方式（1快递，2EMS，3平邮）
            $freight_payment_type = $v['freight_payment_type'];
            $newData[$order_id . '-' . $v['spec_id']]['goods_id'] = $v['goods_id'];
            $newData[$order_id . '-' . $v['spec_id']]['order_id'] = $order_id;
            $newData[$order_id . '-' . $v['spec_id']]['quantity'] = $v['quantity'];
            $newData[$order_id . '-' . $v['spec_id']]['unit_score'] = Common::convert($v['g_price']); //单个积分
            $newData[$order_id . '-' . $v['spec_id']]['total_score'] = $v['quantity'] * Common::convert($v['g_price']); //总积分
            $newData[$order_id . '-' . $v['spec_id']]['gai_price'] = $v['gai_price']; //供货价
            $newData[$order_id . '-' . $v['spec_id']]['unit_price'] = $v['g_price']; //促销价对应字段 price
            $newData[$order_id . '-' . $v['spec_id']]['total_price'] = $v['g_price'] * $v['quantity'];
            $newData[$order_id . '-' . $v['spec_id']]['gai_income'] = $v['gai_income']; //盖网收入

            $newData[$order_id . '-' . $v['spec_id']]['goods_name'] = $v['name'];
            $newData[$order_id . '-' . $v['spec_id']]['goods_thumbnail'] = $v['thumbnail'];
            $newData[$order_id . '-' . $v['spec_id']]['spec_id'] = $v['spec_id'];
            $newData[$order_id . '-' . $v['spec_id']]['spec_value'] = GoodsSpec::buildSpec($v['goods_id']);
            $newData[$order_id . '-' . $v['spec_id']]['freight'] = empty($freight[$store_id][$k]) ? 0.00 : $freight[$store_id][$k];
            $newData[$order_id . '-' . $v['spec_id']]['freight_payment_type'] = $v['freight_payment_type'];
            $newData[$order_id . '-' . $v['spec_id']]['mode'] = empty($selectMod[$store_id][$k]) ? 0 : $selectMod[$store_id][$k];
        }
//         Tool::pr($newData);
        self::addOrderGoods($newData);
    }

    /**
     * 插入到订单对应表
     * @param type $data
     */
    public static function addOrderGoods($data = array()) {
        foreach ($data as $key => $value) {
            Yii::app()->db->createCommand()->insert('{{order_goods}}', array(
                'goods_id' => $value['goods_id'],
                'order_id' => $value['order_id'],
                'quantity' => $value['quantity'],
                'unit_score' => $value['unit_score'],
                'total_score' => $value['total_score'],
                'gai_price' => $value['gai_price'],
                'unit_price' => $value['unit_price'],
                'total_price' => $value['total_price'],
                'gai_income' => $value['gai_income'],
                'spec_value' => $value['spec_value'],
                'spec_id' => $value['spec_id'],
                'freight' => $value['freight'],
                'freight_payment_type' => $value['freight_payment_type'],
                'mode' => $value['mode'],
                'goods_name' => $value['goods_name'],
                'goods_picture' => $value['goods_thumbnail'],
            ));
        }
    }

    /**
     * 查询指定订单id 下的订单商品信息
     * @param int $orderId
     * @return type
     */
    public static function getOrderByOrderId($orderId) {
        $data = Yii::app()->db->createCommand()->select('goods_id,quantity')
                ->from('{{order_goods}}')
                ->where('order_id=:orderId', array(':orderId' => $orderId))
                ->queryAll();
        return $data;
    }

    /**
     * 计算此订单要支付商家的金额
     * @param type $orderId
     */
    public static function CountgaiPrice($orderId) {
        $data = Order::orderDetail($orderId);
        $gai_price = 0; //供货价
        $freight = 0; //运费
        $cash = 0; //总共要支付给商家的钱
//        Tool::pr($data);

        foreach ($data['goods'] as $val) {
            $gai_price+=$val['gai_price'];
            $freight+=$val['freight'];
        }
        return $cash = $gai_price + $freight;
    }

    /**
     * 获取多个订单商品
     * @param array $order_ids
     * @return array
     */
    public static function getOrderGoodsIn(Array $order_ids) {
        return Yii::app()->db->createCommand()
                        ->select('t.*,g.name as goods_name,g.thumbnail,g.is_publish,s.spec_name,s.spec_value')
                        ->from('{{order_goods}} as t')
                        ->leftJoin('{{goods}} as g', 'g.id=t.goods_id')
                        ->leftJoin('{{goods_spec}} as s', 's.id=t.spec_id')
                        ->where(array('in', 't.order_id', $order_ids))
                        ->queryAll();
    }

    //商品详细页分页使用到一下属性
    public $gai_number;             //盖网会员编号
    public $sign_time;             //签收时间

    /**
     * 获取商品成交记录数据
     */
    public static function getCompletes($goods_id) {
        $criteria = new CDbCriteria;
        $criteria->select = "o.sign_time,t.total_price, t.quantity, t.goods_name,m.gai_number";
        $criteria->join = 'left join {{order}} as o on o.id=t.order_id';
        $criteria->join .= ' left join {{member}} as m on m.id=o.member_id';
        $criteria->addCondition('t.goods_id = ' . $goods_id);
        $criteria->addCondition('o.status = ' . Order::STATUS_COMPLETE);

        return new CActiveDataProvider('OrderGoods', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
            'sort' => array('defaultOrder' => 'o.sign_time DESC'),
        ));
    }

    /**
     * 获取评论
     * @return CActiveRecord
     */
    public function getComment() {
        $comment = Comment::model()->find(array(
            'condition' => 'order_id = :oid AND goods_id = :gid',
            'params' => array(':oid' => $this->order_id, ':gid' => $this->goods_id)
        ));
        return $comment;
    }
    
    public static function getGoodNumberByOrderId($orderId)
    {
        return self::model()->find(array(
            'select'=>'sum(quantity) as quantity',
            'condition'=> 'order_id=:orderId', 
            'params' => array(':orderId'=>$orderId) 
        ));
    }
}
