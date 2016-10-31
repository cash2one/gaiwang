<?php

/**
 *  商品审核日志 模型
 *
 * The followings are the available columns in table '{{goods_audit}}':
 * @property string $id
 * @property string $user_id
 * @property string $goods_id
 * @property string $content
 * @property float $price
 * @property string $created
 * @property string $add_time
 * @property int $status
 */
class GoodsAudit extends CActiveRecord
{
    
    const AUDIT_TYPE_PRODUCT = 0; //产品类型
    const AUDIT_TYPE_ACTIVE = 1; //活动类型
    
    public function tableName()
    {
        return '{{goods_audit}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, goods_id, created,price', 'required'),
            array('user_id, goods_id, created', 'length', 'max' => 10),
            array('content', 'length', 'max' => 200),
            array('id, user_id, goods_id, content, created,status,add_time,price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::HAS_ONE, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('goodsAudit', 'ID'),
            'user_id' => Yii::t('goodsAudit', '审核人id'),
            'goods_id' => Yii::t('goodsAudit', '商品id'),
            'content' => Yii::t('goodsAudit', '审核结果'),
            'created' => Yii::t('goodsAudit', '审核时间'),
            'add_time' => Yii::t('goodsAudit', '提交时间'),
            'status' => Yii::t('goodsAudit', '审核状态'),
            'price' => Yii::t('goodsAudit', '价格'),
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('goods_id', $this->goods_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('price', $this->price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取商品的审核记录
     * @param int $goodsId
     * @return array
     */
    public static function getGoodsAudit($goodsId)
    {
        $sql = 'select a.*,u.username
				from gw_goods_audit as a LEFT JOIN gw_user as u ON u.id=a.user_id
				where a.goods_id=:gid';
        return Yii::app()->db->createCommand($sql)->bindParam(':gid', $goodsId)->queryAll();
    }
}
