<?php

/**
 * This is the model class for table "{{app_hot_goods}}".
 *
 * The followings are the available columns in table '{{app_hot_goods}}':
 * @property string $id
 * @property string $goods_id
 * @property string $order
 * @property integer $type
 * @property integer $status
 */
class AppHotGoods extends CActiveRecord
{
    public $storeName;                                              //商家名
    public $categoryName;                                           //分类名
    public $price;                                                  //价格
    public $stock;                                                  //库存
    public $sales_volume;                                           //销量
    public $name;                                                   //商品名

    const TYPE_HOT_GOODS = 1;                                       //热门推荐
    const TYPE_BIS_GIFTS = 2;                                       //品质至上

    /**
     * 类型
     * @param null $key
     * @return array
     */
    public static function getType($key = null){
        $data = array(
            self::TYPE_HOT_GOODS => Yii::t('AppHotGoods','热门推荐'),
            self::TYPE_BIS_GIFTS => Yii::t('AppHotGoods','品质至上'),
        );
        return $key === null ? $data : $data[$key];
    }

    /**
     * 类型值
     * @param null $key
     * @return array
     */
    public static function getTypeKey($key = null){
        $data = array(
            self::TYPE_HOT_GOODS=>'TYPE_HOT_GOODS',
            self::TYPE_BIS_GIFTS=>  'TYPE_BIS_GIFTS',
        );
        return $key === null ? $data : $data[$key];
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_hot_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goods_id, order', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('goods_id, order', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, goods_id, order, type, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'goods_id' => 'Goods',
			'order' => Yii::t('AppHotGoods', '排序'),
			'type' => Yii::t('AppHotGoods', '类型'),
			'status' => 'Status',
            'storeName' => Yii::t('AppHotGoods', '商家'),
            'categoryName' => Yii::t('AppHotGoods', '分类'),
            'price' => Yii::t('AppHotGoods', '价格'),
            'stock' => Yii::t('AppHotGoods', '库存'),
            'sales_volume' => Yii::t('AppHotGoods', '销量'),
            'name' => Yii::t('AppHotGoods', '商品'),
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
        $criteria->select = 't.id,g.name,c.name as categoryName ,t.type,t.order,s.name as storeName ,g.price,g.stock,g.sales_volume';
        $criteria->join  = ' left join ' . Goods::model()->tableName() . ' as g on t.goods_id = g.id';
        $criteria->join .= ' left join ' . Store::model()->tableName() . ' as s on g.store_id = s.id';
        $criteria->join .= ' left join ' . Category::model()->tableName() . ' as c on g.category_id = c.id';
//        $criteria->order = 't.order desc';
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('g.name',$this->name,true);
        $criteria->compare('t.type',$this->type);
		$criteria->compare('s.name',$this->storeName,true);
		$criteria->compare('c.name',$this->categoryName,true);
		$criteria->compare('status',$this->status);

        /*为了满足测试部点击绑定商品菜单栏：商品、排序、类型、价格、销量.....等列能排序的奇葩需求*/
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => 'order desc',
            'order'=>array(
                'asc'=>'`order`','desc'=>'`order` desc'
            ),
            'name'=>array(
                'asc'=>'name','desc'=>'name desc'
            ),
            'type'=>array(
                'asc'=>'type','desc'=>'type desc'
            ),
            'storeName'=>array(
                'asc'=>'storeName','desc'=>'storeName desc'
            ),
            'categoryName'=>array(
                'asc'=>'categoryName','desc'=>'categoryName desc'
            ),
            'price'=>array(
                'asc'=>'price','desc'=>'price desc'
            ),
            'stock'=>array(
                'asc'=>'stock','desc'=>'stock desc'
            ),
            'sales_volume'=>array(
                'asc'=>'sales_volume','desc'=>'sales_volume desc'
            ),
        );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'sort' =>$sort,
        ));
	}

    /**
     *通过商品id返回商品信息（创建热卖商品时使用）
     */
    public static function searchGoodsInfo($id){
    	$where = 'g.life = ' . Goods::LIFE_NO;
    	$where.= ' and g.is_publish = ' . Goods::PUBLISH_YES;
    	$where.= ' and g.status = ' . Goods::STATUS_PASS;
    	$where.= ' and c.status = ' . Category::STATUS_ENABLE;
    	$where.= ' and g.id = ' . $id;
        $goodInfo = Yii::app()->db->createCommand()
                                ->select('g.name,c.name as categoryName ,s.name as storeName ,g.price,g.stock,g.sales_volume')
                                ->from(Goods::model()->tableName() . ' as g')
                                ->join(Store::model()->tableName() . ' as s', ' g.store_id = s.id')
                                ->join(Category::model()->tableName() . ' as c' , ' g.category_id = c.id')
                                ->where($where)
                                ->queryRow();
        if(!empty($goodInfo))
        	return $goodInfo;
        else return array();
        
    }

    /**
     * 通过热卖商品id返回信息（更新热卖商品时使用）
     */
    public static function searchHotGoodsInfo($id){
        $hotGoodsInfo = Yii::app()->db->createCommand()
        						->select('t.id,t.goods_id,g.name,c.name as categoryName ,t.type,t.order,s.name as storeName ,g.price,g.stock,g.sales_volume')
        						->from(self::model()->tableName() . ' as t')
        						->leftJoin(Goods::model()->tableName() . ' as g', 't.goods_id = g.id')
        						->leftJoin(Store::model()->tableName() . ' as s', 'g.store_id = s.id')
        						->leftJoin(Category::model()->tableName() . ' as c', 'g.category_id = c.id')
        						->where('t.id='.$id)
        						->queryRow();
        return json_encode($hotGoodsInfo);
    }

    /**
     *判断该商品id是否添加到商城热卖或商务小礼中
     */
    public static function isAddHotGoods($id,$type){
        $result = Yii::app()->db->createCommand()
                                ->select('id')
                                ->from(self::model()->tableName())
                                ->where('goods_id=' . $id . ' and type = ' .$type)
                                ->queryScalar();
       return $result;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppHotGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 创建删除、更新按钮
     */
    public static function createButtons($id) {
        $string = "";
        if (Yii::app()->user->checkAccess('AppHotGoods.update'))
            $string .= "<a class='regm-sub' href='javascript:do_Edit(" . $id . ")'>【更新】</a>";
        if (Yii::app()->user->checkAccess('AppHotGoods.remove'))
            $string .= "<a class='regm-sub' href='javascript:do_Remove(" . $id . ")'>【删除】</a>";
        return $string;
    }
}
