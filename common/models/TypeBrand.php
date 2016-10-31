<?php

/**
 *  类型与品牌的索引表
 *  @author binbin.liao <277250538@qq.com>
 * @property string $type_id
 * @property string $brand_id
 */
class TypeBrand extends CActiveRecord {

    public function tableName() {
        return '{{type_brand}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('type_id, brand_id', 'required'),
            array('type_id,brand_id', 'safe'),
            array('type_id, brand_id', 'length', 'max' => 11),
            array('type_id, brand_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'type_brand'=>array(self::HAS_MANY,'Brand','brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'type_id' => Yii::t('typeBrand', '类型'),
            'brand_id' => Yii::t('typeBrand', '品牌'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * 查询与类型关联的品牌数据
     */
    public static function getTypeBrand($type_id) {
        $brand = Yii::app()->db->createCommand()
                        ->select('type_id, brand_id, name')
                        ->from('{{type_brand}}')
                        ->leftJoin('{{brand}}', 'brand_id = id')
                        ->where('type_id=' . $type_id)->queryAll();
        return $brand;
    }

    /**
     * 生成与类型关联的品牌下拉列表
     * @param int $type_id 类型id
     */
    public static function selectBrand($type_id) {
        $model = self::getTypeBrand($type_id);
        return CHtml::listData($model, 'brand_id', 'name');
    }
    
    
    /**
     * 取卖家的品牌列表
     */
    /**
     * 生成与类型关联的品牌下拉列表
     * @param int $type_id 类型id
     */
    public static function selectSellerBrand($store_id) {
    	$brand = Yii::app()->db->createCommand()
                        ->select('id, name')
                        ->from('{{brand}}')
                        ->where('store_id=' . $store_id . ' AND status=1 ')->queryAll();
    	return CHtml::listData($brand, 'id', 'name');
    }

}
