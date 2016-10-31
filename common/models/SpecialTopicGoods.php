<?php

/**
 * 专题商品模型
 * @author jianlin_lin <hayeslam@163.com>
 * {{special_topic_goods}} 模型
 *
 * The followings are the available columns in table '{{special_topic_goods}}':
 * @property string $id
 * @property string $special_topic_category_id
 * @property string $goods_id
 * @property string $special_price
 * @property string $special_topic_id
 */
class SpecialTopicGoods extends CActiveRecord {

    public function tableName() {
        return '{{special_topic_goods}}';
    }

    /**
     * @return array 模型属性的验证规则
     */
    public function rules() {
        return array(
            array('special_topic_category_id, goods_id, special_price, special_topic_id', 'required'),
            array('special_topic_category_id, goods_id', 'length', 'max' => 11),
            array('special_price', 'length', 'max' => 10),
            array('id, special_topic_category_id, goods_id, special_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array 关系规则
     */
    public function relations() {
        return array(
            'specialTopic' => array(self::BELONGS_TO, 'SpecialTopic', 'special_topic_id'),
            'specialTopicCategory' => array(self::BELONGS_TO, 'SpecialTopicCategory', 'special_topic_category_id'),
            'goods' => array(self::BELONGS_TO, 'Goods', 'goods_id', 'select' => 'id, name, gai_price, price, thumbnail',
                'condition' => 'status = :status AND is_publish = :push and life=:life',
                'params' => array(
                    ':status' => Goods::STATUS_PASS,
                    ':push' => Goods::PUBLISH_YES,
                    ':life'=>Goods::LIFE_NO
                )
            ),
        );
    }

    /**
     * @return array 自定义属性标签(名称= >标签)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('specialTopicGoods', '主键'),
            'special_topic_category_id' => Yii::t('specialTopicGoods', '所属专题分类'),
            'goods_id' => Yii::t('specialTopicGoods', '所属商品'),
            'special_price' => Yii::t('specialTopicGoods', '活动价格'),
            'special_topic_id' => Yii::t('specialTopicGoods', '所属专题'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('specialTopicCategory', 'goods');
        $criteria->compare('t.special_topic_category_id', $this->special_topic_category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, // 分页
            ),
            'sort' => array(
                'defaultOrder' => 't.special_price DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /**
     * 该商品是否有参与优惠活动
     * @param int $goodsId
     * @return array
     */
    public static function hasActive($goodsId) {
        $sql = 'SELECT
                    `t`.`special_price` AS `price`,
                    `t`.`special_topic_category_id`,
                    `st`.`name` AS `special_name`,
                    st.start_time,
                    st.end_time,
                    st.id as special_topic_id,
                    stc.integral_ratio
                FROM
                    `{{special_topic_goods}}` `t`
                LEFT JOIN `{{special_topic}}` `st` ON t.special_topic_id = st.id
                LEFT JOIN  `{{special_topic_category}}` AS `stc` ON stc.id = t.special_topic_category_id
                WHERE
                    t.goods_id = :id
                AND st.start_time <= :time
                AND st.end_time >= :time';
        return Yii::app()->db1->createCommand($sql)->bindValues(array(':id'=>$goodsId,':time'=>time()))->queryRow();
    }
}
