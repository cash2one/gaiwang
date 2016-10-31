<?php

/**
 *  地区运费 模型
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{freight_area}}':
 * @property string $freight_type_id
 * @property string $location_id
 * @property string $default
 * @property string $default_freight
 * @property string $added
 * @property string $added_freight
 */
class FreightArea extends CActiveRecord
{
    //计费默认参数
    const PARAM_DEFAULT = 1;
    const PARAM_DEFAULT_FREIGHT = 0.00;
    const PARAM_ADDED = 1;
    const PARAM_ADDED_FREIGHT = 0.00;

	public function tableName()
	{
		return '{{freight_area}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('freight_type_id, location_id, default, default_freight, added, added_freight', 'required'),
			array('freight_type_id, location_id', 'length', 'max'=>11),
			array('default, default_freight, added, added_freight', 'length', 'max'=>9),
            array('default_freight,added_freight','compare','compareValue'=>'0','operator'=>'>=','message'=>'必须大于0'),//首费,续费不能为负数
			array('freight_type_id, location_id, default, default_freight, added, added_freight', 'safe', 'on'=>'search'),
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
			'freight_type_id' => Yii::t('freightArea','所属运费类型'),
			'location_id' => Yii::t('freightArea','地区'),
			'default' => Yii::t('freightArea','首量'),
			'default_freight' => Yii::t('freightArea','首费'),
			'added' => Yii::t('freightArea','续量'),
			'added_freight' => Yii::t('freightArea','续费'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('freight_type_id',$this->freight_type_id,true);
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('default',$this->default,true);
		$criteria->compare('default_freight',$this->default_freight,true);
		$criteria->compare('added',$this->added,true);
		$criteria->compare('added_freight',$this->added_freight,true);

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
     * 区域运费分组，根据运费类型id获取
     * @param $id 运费类型id
     * @return array
     */
    public static function groupArea($id){
        $sql = "SELECT
                    GROUP_CONCAT(location_id) AS location_ids,
                    `default`,
                    default_freight,
                    added,
                    added_freight
                FROM
                    {{freight_area}}
                WHERE
                    freight_type_id = '$id'
                GROUP BY
                    `default`,
                    default_freight,
                    added,
                    added_freight";
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }

    public static $area;
    /**
     * 检查地区是否被使用,用于view中判断
     * @param $type_id 运费类型id
     * @param $location_id 地区id
     * @return bool
     */
    public static function  checkAreaUse($type_id,$location_id){
        if(empty(self::$area)){
            self::$area = FreightArea::model()->findAllByAttributes(array('freight_type_id'=>$type_id));
        }
        foreach(self::$area as $v){
            if($v->location_id==$location_id) return true;
        }
        return false;
    }

    /**
     * 根据运费类型id数组，获取数据
     * @param array $idArr
     * @return array
     */
    public static function getFreightType($idArr)
    {
        return Yii::app()->db->createCommand()->from('{{freight_area}}')->where(array('in','freight_type_id',$idArr))->queryAll();
    }
}
