<?php

/**
 *  运费编辑模型
 * @author csj
 *
 * @property string $id
 * @property string $order_id
 * @property string $code
 * @property string $old_freight
 * @property string $new_freight
 * @property string $create_time
 *
 */
class FreightEdit extends CActiveRecord {

    public function tableName() {
        return '{{freight_edit}}';
    }

    public function rules() {
        return array(
            array('code, order_id, new_freight', 'required'),
            array('new_freight', 'match', 'pattern' => '/^(?:[1-9]\d*|0)(?:\.\d{1,2})?$/', 'message' => Yii::t('freightEdit', '运费的格式不正确')),
            array('id, order_id, code, create_time', 'safe', 'on' => 'search'),
            array('new_freight','check_freight')
        );
    }

    public function relations() {
        return array(
            'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_id' => Yii::t('FreightEdit', '所属订单'),
            'code' => Yii::t('FreightEdit', '订单编号'),
            'old_freight' => Yii::t('FreightEdit', '旧运费'),
            'new_freight' => Yii::t('FreightEdit', '新运费'),
            'create_time' => Yii::t('FreightEdit', '创建时间'),
        );
    }

    public function check_freight($attribute, $params) {
        $id = $this->order_id;
       
        $condition = '`pay_status` = ' . Order::PAY_STATUS_NO . ' AND `status` = ' . Order::STATUS_NEW;
        $order = Order::model()->findByPk($id, $condition);
        $order['freight'] = $this->new_freight;
        if ($this->old_freight > $this->new_freight) {
            //如果 旧的运费 大于 新的运费，支付的金额中要减去 旧运费-新运费 的差额
            $order['pay_price'] = $order['real_price'] = $order->pay_price - ($this->old_freight - $this->new_freight);
            $order['original_price'] = $order->original_price - ($this->old_freight - $this->new_freight);
        } elseif ($this->old_freight < $this->new_freight) {
            //如果 旧的运费 小于 新的运费，支付的金额中要加 新运费-旧运费 的差额
            $order['pay_price'] = $order['real_price'] = $order->pay_price + ($this->new_freight - $this->old_freight);
            $order['original_price'] = $order->original_price + ($this->new_freight - $this->old_freight);
        }
        if ($order['pay_price'] > 99999999.99) {
//            echo '<script>alert("所输入的运费金额过大，已造成支付金额大于最高支付限额！")</script>';
//            $this->setFlash('success', Yii::t('sellerFreightEdit', '运费修改失败，请稍候再试！'));
            $this->addError($attribute, '所输入的运费金额过大!');
        }
       if ($this->new_freight > 99999999.99) {
            $this->addError($attribute, '所输入的运费金额过大!');
        }
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->order = 'create_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFullInfo() {
        $criteria = new CDbCriteria;
        $criteria->select = ' * ';
        $criteria->join = ' LEFT JOIN {{order}} as o ON t.order_id = o.id ';
        $criteria->compare('t.id', $this->id);

        $cadp = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
        return $cadp->getData();
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->create_time = time();
            return true;
        }
        else
            return false;
    }

}
