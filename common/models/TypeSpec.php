<?php

/**
 *  类型与规格的索引表
 * @author binbin.liao  <277250538@qq.com>
 * @property string $type_id
 * @property string $spec_id
 */
class TypeSpec extends CActiveRecord {

    public function tableName() {
        return '{{type_spec}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('type_id, spec_id', 'required'),
            array('type_id, spec_id', 'length', 'max' => 11),
            array('type_id, spec_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'type_id' => Yii::t('typeSpec', '类型'),
            'spec_id' => Yii::t('typeSpec', '规格'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 查询类型与规格关联数据
     * @param int $type_id 类型id
     * @return array
     */
    public static function type_spec($type_id){
        $data = Yii::app()->db->createCommand()
                        ->select('a.type_id, b.name, b.id, b.type')
                        ->from('{{type_spec}}  a')
                        ->leftJoin('{{spec}} b', 'a.spec_id = b.id')
                        ->where('a.type_id = :tid')->bindValue(':tid',$type_id)->queryAll();
        return $data;
    }
    /**
     * 
     * 再根据typeSPec方法查询的关联数据，查出规格下的规格值，组合成二维数组
     * @param array $typeSpecValue 类型与规格关联的数据
     * @return array
     */
    public static function specValue($typeSpecValue) {
        foreach ($typeSpecValue as &$v) {
            $value = Yii::app()->db->createCommand()
                            ->select('name, id,thumbnail')
                            ->from('{{spec_value}}')
                            ->where('spec_id=' . $v['id'])->queryAll();
            $v['spec_value_data'] = $value;
        }
        return $typeSpecValue;
    }
}
