<?php

/**
 *  商品属性模型
 * @author binbin.liao  <277250538@qq.com>
 * The followings are the available columns in table '{{attribute}}':
 * @property string $id
 * @property string $name
 * @property string $type_id
 * @property integer $show
 * @property integer $sort
 */
class Attribute extends CActiveRecord {

    const TYPE_SHOW = 1; //显示
    const TYPE_HIDE = 0; //不显示

    //规格类型

    public static function type() {
        return array(
            self::TYPE_HIDE => Yii::t('attribute', '不显示'),
            self::TYPE_SHOW => Yii::t('attribute', '显示'),
        );
    }

    //获取规格类型
    public static function getType($type = 1) {
        $arr = self::type();
        return isset($arr[$type]) ? $arr[$type] : Yii::t('attribute', '未知');
    }

    public function tableName() {
        return '{{attribute}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'safe'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('id, name, type_id, show, sort', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'typename' => array(self::BELONGS_TO, 'Type', 'type_id'),
            'attributeData'=>array(self::HAS_MANY,'AttributeValue','attribute_id','order'=>'sort DESC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('attribute', '主键'),
            'name' => Yii::t('attribute', '名称'),
            'type_id' => Yii::t('attribute', '所属类型'),
            'show' => Yii::t('attribute', '显示'),
            'sort' => Yii::t('attribute', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type_id', $this->type_id, true);
        $criteria->compare('show', $this->show);
        $criteria->compare('sort', $this->sort);

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
     * 把关联的数据一并删除
     */
    public function afterDelete() {
        parent::afterDelete();
        AttributeValue::model()->deleteAll('attribute_id IN(' . $this->id . ')'); //删除对应的属性值数据
    }

    /**
     * 查询类型关联的属性数据
     * @param int $type_id 类型id
     * @deprecated
     */
    public static function getAttributeData($type_id) {
        $typeAttribute = self::model()->findAll('type_id=' . $type_id);
        return $typeAttribute;
    }

    /**
     * 把属性与属性值关联,组合成一个新的二维数组
     * 给视图里选择属性用
     * @param object $typeAttribute 类型与属性关联的数据
     * @deprecated
     */
    public static function att2attval($typeAttribute) {
        $attribute = array();
        foreach ($typeAttribute as $k => $v) {
            $value = AttributeValue::model()->findAll('attribute_id=' . $v->id);
            $attribute[$k]['attr_name'] = $v->name;
            $attribute[$k]['id'] = $v->id;
            $attribute[$k]['attrValue'] = $value;
        }
        return $attribute;
    }

    /**
     * 根据提交过来的属性数据,查询属性名称和属性值名称
     * 并组合成新的数组. 并生成序列化数据
     * @param array $att POST提交过来的数据
     * @deprecated
     */
    public static function serializeArr($att) {
        $serializeArr = array();
        foreach ($att as $k => $v) {
            $att2 = Yii::app()->db->createCommand()->select('a.name,b.name AS value')
                            ->from('{{attribute}}  a')
                            ->leftJoin('{{attribute_value}} b', 'a.id=b.attribute_id')
                            ->where('a.id=' . $k . ' AND b.id=' . $v[0])->queryAll();
            $serializeArr[$k]['name'] = $att2[0]['name'];
            $serializeArr[$k]['value'] = $att2[0]['value'];
        }
        return $serializeArr;
    }

    /**
     * 根据提交过来的属性数据,查询属性名称和属性值名称
     * @param array $attr
     * @return array
     */
    public static function attrValueData(Array $attr){
        $serializeArr = array();
        foreach ($attr as $k => $v) {
            $att2 = Yii::app()->db->createCommand()->select('a.name,b.name AS value')
                ->from('{{attribute}}  a')
                ->leftJoin('{{attribute_value}} b', 'a.id=b.attribute_id')
                ->where('a.id=' . $k . ' AND b.id=' . $v)->queryRow();
            $serializeArr[$k]['name'] = $att2['name'];
            $serializeArr[$k]['value'] = $att2['value'];
        }
        return $serializeArr;
    }

}
