<?php

/**
 *  产品与规格关联对应索引表
 *
 * The followings are the available columns in table '{{goods_spec_index}}':
 * @property string $goods_id
 * @property string $category_id
 * @property string $type_id
 * @property string $spec_id
 * @property string $spec_value_id
 * @property string $spec_value_name
 */
class GoodsSpecIndex extends CActiveRecord
{
    public function tableName()
    {
        return '{{goods_spec_index}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('goods_id, category_id, type_id, spec_id, spec_value_id, spec_value_name', 'required'),
            array('goods_id, category_id, type_id, spec_id, spec_value_id', 'length', 'max'=>11),
            array('goods_id, category_id, type_id, spec_id, spec_value_id, spec_value_name', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'goods_id' => Yii::t('goodsSpecIndex','所属商品'),
            'category_id' => Yii::t('goodsSpecIndex','所属分类'),
            'type_id' => Yii::t('goodsSpecIndex','所属类型'),
            'spec_id' => Yii::t('goodsSpecIndex','所属规格'),
            'spec_value_id' => Yii::t('goodsSpecIndex','所属规格'),
            'spec_value_name' => Yii::t('goodsSpecIndex','规格值'),
        );
    }

    public function search()
    {

        $criteria=new CDbCriteria;

        $criteria->compare('goods_id',$this->goods_id,true);
        $criteria->compare('category_id',$this->category_id,true);
        $criteria->compare('type_id',$this->type_id,true);
        $criteria->compare('spec_id',$this->spec_id,true);
        $criteria->compare('spec_value_id',$this->spec_value_id,true);
        $criteria->compare('spec_value_name',$this->spec_value_name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * 批量添加
     * @param array  $spec_val
     * @param $type_id
     * @param $cate_id
     * @param $goods_id
     * @return bool
     */
    public static function addArray(Array $spec_val,$type_id,$cate_id,$goods_id){
        if(!empty($spec_val)){
            foreach ($spec_val as $k1 => $v1) {
                foreach($v1 as $k2=>$v2){
                    Yii::app()->db->createCommand()->insert('{{goods_spec_index}}', array(
                        'goods_id' => $goods_id,
                        'category_id' => $cate_id,
                        'type_id' => $type_id,
                        'spec_id' => $k1,
                        'spec_value_id' => $k2,
                        'spec_value_name' => $v2,
                    ));
                }
            }
        }else{
            return false;
        }
        return true;
    }
}