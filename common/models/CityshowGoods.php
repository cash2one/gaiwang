<?php

/**
 * This is the model class for table "{{cityshow_goods}}".
 *
 * The followings are the available columns in table '{{cityshow_goods}}':
 * @property string $id
 * @property integer $store_id
 * @property integer $goods_id
 * @property integer $theme_id
 * @property integer $sort
 * @property string $create_time
 */
class CityshowGoods extends CActiveRecord
{


    public $name;//商品名称
    public $gw;//商家GW号
    public $publish; //商品状态
    public $g_status; //商品状态
    public $life;//商品删除状态
    public $thumbnail;//商品图片

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cityshow_goods}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_id, goods_id, theme_id, sort, create_time', 'required'),
            array('store_id, goods_id, theme_id, sort', 'numerical', 'integerOnly' => true),
            array('create_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, store_id, goods_id, theme_id, sort, create_time,name', 'safe', 'on' => 'search'),
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
            'theme'=>array(self::BELONGS_TO,'CityshowTheme','theme_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'store_id' => '商家id',
            'goods_id' => '商品id',
            'theme_id' => '主题id',
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

        $criteria = new CDbCriteria;
        $criteria->select = 't.*,g.name,g.thumbnail,g.is_publish as g_status,m.gai_number AS gw';
        $criteria->join = 'LEFT JOIN {{goods}} AS g ON t.goods_id=g.id LEFT JOIN {{store}} AS s ON g.store_id=s.id LEFT JOIN {{member}} AS m ON s.member_id=m.id';

        $criteria->compare('t.store_id', $this->store_id);
        $criteria->compare('t.goods_id', $this->goods_id);
        $criteria->compare('t.theme_id', $this->theme_id);
        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('g.name',$this->name);
        $criteria->addCondition('g.id > 0');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
	 * @param int $sid 城市馆ID
	 * @return CActiveDataProvider
	 */
	public function getCityShowGoodsList($csid=NULL,$sid=NULL,$tid=NULL)
	{
	    $criteria = new CDbCriteria;
	    $criteria->select ='t.*,g.name,g.thumbnail,g.is_publish as publish,g.status AS g_status,g.life AS life,m.gai_number AS gw';
	    $criteria->join ='LEFT JOIN {{goods}} AS g ON t.goods_id=g.id LEFT JOIN {{store}} AS s ON g.store_id=s.id LEFT JOIN {{member}} AS m ON s.member_id=m.id';
	    $criteria->compare('g.id','>0');
	    if($sid!==null){
	        $criteria->compare('t.store_id',$sid);
	    }
	    if($csid!==null){
	    	$thmem=new CityshowTheme();
	    	$csidArr=$thmem->getCityShowTheme($csid);
	    	$themeArr = array_map('reset',$csidArr);
	        $criteria->compare('t.theme_id',$themeArr);
	    }
	    if($tid!==null){
	        $criteria->compare('t.theme_id',$tid);
	    }
	    if(isset($_GET['name'])){
	        $name=$_GET['name'];
	        $type=$_GET['type'];
	        if($type==1){
	          $criteria->compare('t.goods_id',$name,true);
	        }else if($type==2){
	          $criteria->compare('g.name',$name,true);
	        }else{
	          $criteria->compare('m.gai_number',$name,true);
	        }
	    }
	    
	    return new CActiveDataProvider($this, array(
	            'criteria' =>$criteria,
	            'pagination' => array(
	                    'pageSize' =>10,
	            ),
	            'sort' => array(
	                    'defaultOrder' => 't.sort DESC,t.goods_id DESC'
	            ),
	    ));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CityshowGoods the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 得到商家的参加的城市馆的商品数目
     * @param string $field
     * @return array
     */
    public static function getGoodsNum($field = 'store_id',$csid=NULL)
    {
    	$retArr = array();
    	$command=Yii::app()->db->createCommand();
    	 if(!empty($csid)){
    		$thmem=new CityshowTheme();
    		$csidArr=$thmem->getCityShowTheme($csid);
    		$themeArr = array_map('reset',$csidArr);	
    		if(!empty($themeArr))
    		  $command->where(array('in', 'theme_id', $themeArr));
    	   }
         $res =$command->select('count(*) AS goods_count,' . $field)
                      ->from('{{cityshow_goods}}')
                      ->group($field)
                      ->queryAll();
        foreach ($res as $v) {
            $retArr[$v[$field]]['goods_count'] = $v['goods_count'];
        }
        return $retArr;
    }

    /**
     * 根据主题跟商家主键取出商品ID
     * @param array $sid 城市馆商家ID主键
     * @return array
     */
    public static function getGoodsIdByTidSid($sid)
    {
        $retArr = array();
       if(empty($sid)) return  $retArr;
        $res = Yii::app()->db->createCommand()
            ->select('goods_id')
            ->from('{{cityshow_goods}}')
            ->where(array('in', 'store_id', $sid))
            ->queryAll();
        foreach ($res as $k => $v) {
            $retArr[] = $v['goods_id'];
        }
        return $retArr;
    }

    /**
     * 统计商家参与参加的城市馆的商品数目
     * @param int $store_id gw_cityshow_store id| theme_id
     * @param string $field
     * @return mixed
     */
    public static function countGoods($store_id,$field='store_id')
    {
        return Yii::app()->db
            ->createCommand('SELECT count(*) FROM gw_cityshow_goods WHERE `'.$field.'`=:sid')
            ->bindValues(array(':sid' => $store_id))->queryScalar();
    }
    
    /**
     * 城市馆内页的主题商品列表
     * @param int $csid 城市馆ID
     */
    public static function getCityViewGoods($csid){
        $data = Yii::app()->db->createCommand()
        ->select('t.*,g.price,g.name AS goods_name,g.thumbnail,s.id AS store_id,s.name AS store_name,cst.name AS theme_name,cst.id AS cst_id')
        ->from('{{cityshow_goods}} t')
        ->leftJoin('{{goods}} g', ' t.goods_id=g.id')
        ->leftJoin('{{store}} s', ' g.store_id=s.id')
        ->leftJoin('{{cityshow_theme}} cst', ' cst.id=t.theme_id')
        ->leftJoin('{{cityshow_store}} css', ' css.id=t.store_id')
        ->where('css.status=:css_st AND cst.cityshow_id=:csid AND g.is_publish=:gp AND g.status=:gs AND g.life=:life', array(':csid' => $csid, ':gp' => Goods::PUBLISH_YES,':gs'=>Goods::STATUS_PASS,':life'=>Goods::LIFE_NO,':css_st'=>CityshowStore::STATUS_YES))
        ->order('cst.sort DESC,t.sort DESC,t.goods_id DESC')
        ->queryAll();
        $retArr=array();
        foreach($data as $k => $v){
            $retArr[$v['theme_id']]['theme_name']=$v['theme_name'];
            $retArr[$v['theme_id']]['theme_goods'][]=$v;
        }
        return $retArr;
    }
    
    /**
     *查找主题是否已存在商品
     * @param int $themeId 主题ID
     * @param int $goodsId 商品ID
     * @return bool
     */
    public static function themeGoodsIsExist($themeId,$goodsId){
        return CityshowGoods::model()->exists(array(
                'condition'=>'goods_id=:g AND theme_id=:tid',
                'params'=>array(':g'=>$goodsId,':tid'=>$themeId)
        ));  
    }
}
