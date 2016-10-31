<?php

/**
 * This is the model class for table "{{cityshow_theme}}".
 *
 * The followings are the available columns in table '{{cityshow_theme}}':
 * @property string $id
 * @property string $name
 * @property string $goods_id
 * @property integer $status
 * @property integer $sort
 * @property string $create_time
 * @property int $cityshow_id
 */


class CityshowTheme extends CActiveRecord
{
    
    

    const STATUS_YES=1; //正常发布
    const STATUS_DEL=0; //已删除
    

    public $title; //城市馆标题
    public $s_status;//城市馆状态
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cityshow_theme}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status, sort', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>10),
			array('create_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,status, sort, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cityshow'=>array(self::BELONGS_TO,'Cityshow','cityshow_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'name' => '主题名称',
			'goods_id' => '商品id',
			'status' => '状态',
			'sort' => '排序',
			'create_time' => '创建时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('cityshow_id',$this->cityshow_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'sort asc',
            ),
        ));
    }

	/**
	 *
	 * @param int $sid 城市馆ID
	 * @return CActiveDataProvider
	 */
	public function getCityShowThemeList($cid=NULL)
	{
	    $criteria = new CDbCriteria;
	    $criteria->select ='t.*,s.title,s.status AS s_status';
	    $criteria->join ='LEFT JOIN {{cityshow}} AS s ON t.cityshow_id=s.id';
	    if($cid!==null){
	      $criteria->compare('t.cityshow_id',$cid);
	    }
	    $criteria->compare('t.status',self::STATUS_YES);
	    $criteria->compare('t.name',$this->name,true);
	    return new CActiveDataProvider($this, array(
	            'criteria' =>$criteria,
	            'pagination' => array(
	                    'pageSize' =>20,
	            ),
	            'sort' => array(
	                    'defaultOrder' => 't.sort ASC,t.create_time DESC'
	            ),
	    ));
	}

	/**
	 * 得到某一个城市馆的主题
	 * @param int $cid
	 * @return array
	 */
	public function getCityShowTheme($cid){
	    $res=Yii::app()->db->createCommand()
	    ->select('id,name')
	    ->from('{{cityshow_theme}}')
	    ->where('cityshow_id = :lid',array(':lid'=>$cid))
	    ->queryAll();
	    return $res;
	}
	
    /**
     * 根据城市馆ID得到城市馆主题数目
     * @param int $cid
     * @return Ambigous <mixed, string>
     */
	public static function getThemeCount($cid)
	{
	    $res=Yii::app()->db->createCommand()
	    ->select('count(*) AS num')
	    ->from('{{cityshow_theme}}')
	    ->where('cityshow_id = :lid',array(':lid'=>$cid))
	    ->queryScalar();
	    return $res;
	}
	/**
	 * 计算城市馆主题的商品数量
	 * @return array
	 */
	public function getThemeGoodsNum()
	{
	    $sql = 'SELECT
                t.id,
                (
                    SELECT  count(*) FROM  gw_cityshow_goods AS g WHERE g.theme_id = t.id AND g.status='.CityshowGoods::STATUS_YES.'
                ) AS goods_count 
            FROM
                `gw_cityshow_theme` `t`
            WHERE
                t.status = '.self::STATUS_YES.'
            ORDER BY
                t.`sort` DESC';
	    $res=Yii::app()->db->createCommand($sql)->queryAll();
	    return $res;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CityshowTheme the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterDelete()
	{
	    //删除主题的所有商品
	    CityshowGoods::model()->deleteAllByAttributes(array('theme_id'=>$this->id));    
	    parent::afterDelete(); // TODO: Change the autogenerated stub
	}
}
