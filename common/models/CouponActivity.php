<?php

/**
 * This is the model class for table "{{coupon_activity}}".
 *
 * The followings are the available columns in table '{{coupon_activity}}':
 * @property string $id
 * @property string $name
 * @property string $price
 * @property string $condition
 * @property string $valid_start
 * @property string $valid_end
 * @property string $sendout
 * @property string $excess
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $start_time
 * @property string $thumbnail
 * @property string $store_id
 * @property string $state
 *
 * The followings are the available model relations:
 * @property Coupon[] $coupons
 * @property Store $store
 */
class CouponActivity extends CActiveRecord
{
	public $gaiMoney,$shopMoney;		//授权金额，商家创建金额
	
	//盖惠券面值，写死
	const COUPON_PRICE_3 = 3;
	const COUPON_PRICE_5 = 5;
	const COUPON_PRICE_8 = 8;
	const COUPON_PRICE_10 = 10;
	const COUPON_PRICE_20 = 20;
	const COUPON_PRICE_30 = 30;
	const COUPON_PRICE_50 = 50;
	const COUPON_PRICE_60 = 60;
	const COUPON_PRICE_80 = 80;
	const COUPON_PRICE_100 = 100;
	const COUPON_PRICE_200 = 200;
	const COUPON_PRICE_300 = 300;
	
	//盖惠券使用条件，写死
	const COUPON_CONDITION_30 = 30;
	const COUPON_CONDITION_40 = 40;
	const COUPON_CONDITION_50 = 50;
	const COUPON_CONDITION_60 = 60;
	const COUPON_CONDITION_80 = 80;
	const COUPON_CONDITION_100 = 100;
	const COUPON_CONDITION_200 = 200;
	const COUPON_CONDITION_300 = 300;
	const COUPON_CONDITION_400 = 400;
	const COUPON_CONDITION_500 = 500;
	const COUPON_CONDITION_600 = 600;
	const COUPON_CONDITION_800 = 800;
	const COUPON_CONDITION_1000 = 1000;
	const COUPON_CONDITION_2000 = 2000;
	const COUPON_CONDITION_3000 = 3000;
	
	//获取盖惠券面值
	public static function getCouponPrice($key = null){
		$arr = array(
			self::COUPON_PRICE_3 => 3,
			self::COUPON_PRICE_5 => 5,
			self::COUPON_PRICE_8 => 8,
			self::COUPON_PRICE_10 => 10,
			self::COUPON_PRICE_20 => 20,
			self::COUPON_PRICE_30 => 30,
			self::COUPON_PRICE_50 => 50,
			self::COUPON_PRICE_60 => 60,
			self::COUPON_PRICE_80 => 80,
			self::COUPON_PRICE_100 => 100,
			self::COUPON_PRICE_200 => 200,
			self::COUPON_PRICE_300 => 300,
		);
		return $key == null ? $arr : $arr[$key];
	}
	
	//获取盖惠券使用条件
	public static function getCouponCondition($key = null){
		$arr = array(
			self::COUPON_CONDITION_30 => 30,
			self::COUPON_CONDITION_40 => 40,
			self::COUPON_CONDITION_50 => 50,
			self::COUPON_CONDITION_60 => 60,
			self::COUPON_CONDITION_80 => 80,
			self::COUPON_CONDITION_100 => 100,
			self::COUPON_CONDITION_200 => 200,
			self::COUPON_CONDITION_300 => 300,
			self::COUPON_CONDITION_400 => 400,
			self::COUPON_CONDITION_500 => 500,
			self::COUPON_CONDITION_600 => 600,
			self::COUPON_CONDITION_800 => 800,
			self::COUPON_CONDITION_1000 => 1000,
			self::COUPON_CONDITION_2000 => 2000,
			self::COUPON_CONDITION_3000 => 3000,
		);
		return $key == null ? $arr : $arr[$key];
	}
	
	//活动状态：0=>审核中, 1=>审核通过, 2=>审核不通过
	const COUPON_STATUS_NEW = 0;
	const COUPON_STATUS_PASS = 1;
	const COUPON_STATUS_FAIL = 2; 
	
	//获取盖惠券活动状态
	public static function getCouponStatus($key = null){
		$arr = array(
			'' => Yii::t('Public', '全部'), 
			self::COUPON_STATUS_NEW => Yii::t('sellerCouponActivity', '审核中'),
			self::COUPON_STATUS_PASS => Yii::t('sellerCouponActivity', '审核通过'),
			self::COUPON_STATUS_FAIL => Yii::t('sellerCouponActivity', '审核不通过'),
		);
		return $key == null ? $arr : $arr[$key];
	}
	
	//是否开启领取红包：0=>否, 1=>是, 2=>已领完（2只使用与查询，不参与其它）
	const COUPON_STATE_NO = 0;		
	const COUPON_STATE_YES = 1;
	const CONPON_STATE_OVER = 2;

	//获取是否开启领取红包
	public static function getCouponState($key = null){
		$arr = array(
			self::COUPON_STATE_NO => Yii::t('sellerCouponActivity', '暂停领取'),
			self::COUPON_STATE_YES => Yii::t('sellerCouponActivity', '领取中'),
			self::CONPON_STATE_OVER => Yii::t('sellerCouponActivity', '已领完'),
		);
		return $key == null ? $arr : $arr[$key];
	}
	
	//先将经营类型定义为常量，后期根据实际情况看是存缓存还是怎么处理
	const COUPON_TYPE_1 = 1;
	const COUPON_TYPE_2 = 2;
	const COUPON_TYPE_3 = 3;
	const COUPON_TYPE_4 = 4;
	const COUPON_TYPE_5 = 5;
	const COUPON_TYPE_6 = 6;
	const COUPON_TYPE_7 = 7;
	const COUPON_TYPE_8 = 8;
	const COUPON_TYPE_9 = 9;
	const COUPON_TYPE_10 = 10;
	const COUPON_TYPE_11 = 11;
	const COUPON_TYPE_12 = 12;
	
	//获取经营名称
	public static function getCouponType($key = null){
		$arr = array(
			self::COUPON_TYPE_1 => Yii::t('Public', '家用电器'),
			self::COUPON_TYPE_2 => Yii::t('Public', '服饰鞋帽'),
			self::COUPON_TYPE_3 => Yii::t('Public', '个护化妆'),
			self::COUPON_TYPE_4 => Yii::t('Public', '手机数码'),
			self::COUPON_TYPE_5 => Yii::t('Public', '电脑办公'),
			self::COUPON_TYPE_6 => Yii::t('Public', '运动健康'),
			self::COUPON_TYPE_7 => Yii::t('Public', '家居家装'),
			self::COUPON_TYPE_8 => Yii::t('Public', '饮料食品'),
			self::COUPON_TYPE_9 => Yii::t('Public', '礼品箱包'),
			self::COUPON_TYPE_10 => Yii::t('Public', '珠宝首饰'),
			self::COUPON_TYPE_11 => Yii::t('Public', '汽车用品'),
			self::COUPON_TYPE_12 => Yii::t('Public', '母婴用品'),
		);
		return $key == null ? $arr : $arr[$key];
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coupon_activity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price, condition, valid_start, valid_end, sendout, start_time, thumbnail', 'required'),
			array('status, excess, create_time, update_time, store_id, state', 'safe'),
			array('price,condition','checkPriceCondition'),			//验证使用情况
			array('valid_start,valid_end','checkVlidDate'),			//验证有效日期
			array('price,sendout','checkTotalMoney'),				//验证盖惠券金额
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, valid_start, valid_end, status, state,storeName', 'safe', 'on'=>'search'),
		);
	}

	//判断盖惠券使用条件是否设定正确
	public function checkPriceCondition($attribute,$params){
		if($this->price == '' | $this->condition == '')return true;
		
		$minCondition = $this->price * 10;		//最小使用情况
		$maxPrice = $this->condition / 10;
		if ($this->condition < $minCondition) {
			$error = $attribute == 'price' ? Yii::t('sellerCouponActivity','当前使用条件必须设定面值不大于').'{'.$maxPrice.'}!' : Yii::t('sellerCouponActivity','当前盖惠券面值必须设定使用条件不小于').'{'.$minCondition.'}!';
			$this->addError($attribute,$error);
		}
	}
	
	//验证有效日期
	public function checkVlidDate($attribute,$params){
		if($this->valid_start == '' | $this->valid_end == '')return true;
		
		if ($this->valid_start >= $this->valid_end) {
			$error = $attribute == 'valid_start' ? Yii::t('sellerCouponActivity','开始日期不能大于结束日期') : Yii::t('sellerCouponActivity','结束如期不能小于开始日期');
			$this->addError($attribute,$error);
		}
	}
	
	//验证盖惠券金额
	public function checkTotalMoney($attribute,$params){
		if($this->price == '' | $this->sendout == '')return true;
		
		if ($this->price * $this->sendout > 100000) {
			$this->addError($attribute,Yii::t('sellerCouponActivity','当前设定面值与发行量所用总额大于盖惠券授权总金额'));
		}
	}
	
	//gridview输出盖惠券图片
	public static function thumbnailHtml($thumbnail){
		$path = IMG_DOMAIN.'/'.$thumbnail;
		echo '<a href="'.$path.'" onclick="return _showBigPic(this)" ><img src="'.$path.'" style="width:50px;height:50px;"/></a>';
	}
	
	//gridview输出面值
	public static function priceHtml($price){
		echo '￥'.$price;
	}
	
	//gridview输出使用条件
	public static function conditionHtml($condition){
		echo Yii::t('Public','满').' ￥'.$condition;
	}
	
	//gridview输出有效日期
	public static function validHtml($data){
		echo date('Y-m-d', $data->valid_start) . ' 至 ' . date('Y-m-d', $data->valid_end);
	}
	
	//gridview输出发行量
	public static function numHtml($data){
		echo $data->sendout.'/'.$data->excess;
	}
	
	//gridview输出状态：领取 > 审核
	public static function statusHtml($data){
		if ($data->state == self::COUPON_STATE_YES) {		//先判断是不是处于开启领取了
			if ($data->excess == 0 ) {
				echo self::getCouponState(self::CONPON_STATE_OVER);
			} else {
				echo self::getCouponState(self::COUPON_STATE_YES);
			}
		} else {
			echo self::getCouponStatus($data->status);
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'coupons' => array(self::HAS_MANY, 'Coupon', 'coupon_activity_id'),
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('sellerCouponActivity', '盖惠券名称'),
			'price' => Yii::t('sellerCouponActivity', '面值'),
			'condition' => Yii::t('sellerCouponActivity', '使用条件'),
			'valid_start' => Yii::t('sellerCouponActivity', '有效日期'),
			'valid_end' => Yii::t('sellerCouponActivity', '有效日期'),
			'sendout' => Yii::t('sellerCouponActivity', '总发行量'),
			'excess' => Yii::t('sellerCouponActivity', '剩余量'),
			'update_time' => Yii::t('sellerCouponActivity', '更新时间'),
			'status' => Yii::t('sellerCouponActivity', '状态'),
			'num' => Yii::t('sellerCouponActivity', '总发行量 / 剩余量'),
			'thumbnail' => Yii::t('sellerCouponActivity', '盖惠券图片'),
			'start_time' => Yii::t('sellerCouponActivity', '活动开始时间'),
			'storeName' => Yii::t('sellerCouponActivity', '店铺名称'),
		);
	}

    /** @var  string $storeName 店铺名称，搜索用 */
    public $storeName;
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

		$criteria->select = 't.id,t.update_time,t.`name`,t.price,t.`condition`,t.valid_start,t.valid_end,t.sendout,excess,t.`status`,t.thumbnail,t.state,s.name as storeName';
        if($this->id) $criteria->compare('t.store_id',$this->id);

		$criteria->compare('t.name',$this->name,true);
		
		$criteria->compare('t.valid_start','>='.strtotime($this->valid_start));
		$criteria->compare('t.valid_end','<='.strtotime($this->valid_end));
		
		$criteria->compare('t.status',$this->status);
		
		if ($this->state == self::CONPON_STATE_OVER) {
			$criteria->addCondition('t.excess = 0');
		} else {
			$criteria->compare('t.state',$this->state);
		}
        //店铺优惠券显示
        $storeId = Yii::app()->user->getState('storeId');
        if($storeId){
            $criteria->compare('t.store_id',$storeId);
        }
        $criteria->join = 'left join gw_store as s on s.id=t.store_id';
        $criteria->compare('s.name',$this->storeName);
        $criteria->order = 't.create_time DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>10,
			    ),
		));
	}
	
	/**
	 * 前台优惠券列表也查询
	 * 找到状态为审核通过，并且结束时间在当前时间之后的优惠券
	 */
	public function searchForWebList($pagesize = 5, $where = '1 = 1')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

//		$criteria=new CDbCriteria;
//
//		$criteria->select = 't.id,t.price,t.`condition`,t.valid_start,t.valid_end,t.thumbnail,s.name';
//		$criteria->join = 'left join '.Store::model()->tableName().' s on s.id = t.store_id';
//		
//		$criteria->addCondition('t.valid_end >= ' . time());
//		$criteria->addCondition('t.status = ' . self::COUPON_STATUS_PASS);
//
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//			'pagination'=>array(
//			        'pageSize'=>$pagesize,
//			    ),
//		));

		$page = 0;
		$where = 't.valid_end >= :valid_end and t.status = '.self::COUPON_STATUS_PASS.' and '.$where.' limit '.$page.','.$pagesize;
		return Yii::app()->db->createCommand()
			->select('t.id,t.price,t.condition,t.valid_start,t.valid_end,t.thumbnail,s.name,s.category_id')
			->from(self::model()->tableName().' t')
			->leftJoin(Store::model()->tableName().' s', 's.id = t.store_id')
			->where($where, array(':valid_end' => time()))
			->queryAll();
	}
	
	/**
	 * 根据类型获取盖惠券列表，因为css不好弄，所以写成用foreach方式输出界面，分页
	 * @param int $type 类型
	 * @param boolean $getCount 是否获取记录数 
	 * @param string $conditions
	 */
	public function searchCouponList($type,$getCount = false,$conditions = '', $params = array()){
		if (strpos(trim($conditions),"limit") === 0){
			$conditions = 't.valid_end >= :valid_end and t.status = :status and s.category_id = :category_id '.$conditions;	
		} else {
			$conditions = $conditions == '' ? 't.valid_end >= :valid_end and t.status = :status and s.category_id = :category_id' : $conditions;
		}
		$params = array_merge(array(':valid_end' => time(),':status' => self::COUPON_STATUS_PASS,':category_id' => $type), $params);
		if ($getCount){
			return Yii::app()->db->createCommand()
			->select('count(1)')
			->from(self::model()->tableName().' t')
			->leftJoin(Store::model()->tableName().' s', 's.id = t.store_id')
			->where($conditions,$params)
			->queryScalar();
		}
		return Yii::app()->db->createCommand()
			->select('t.id,t.price,t.condition,t.valid_start,t.valid_end,t.thumbnail,s.name,s.category_id')
			->from(self::model()->tableName().' t')
			->leftJoin(Store::model()->tableName().' s', 's.id = t.store_id')
			->where($conditions,$params)
			->queryAll();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CouponActivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 保存之后事件
	 */
	public function beforeSave(){
		if (parent::beforeSave()) {
			$this->update_time = time();
			if ($this->isNewRecord == true) {
				$this->valid_start = strtotime($this->valid_start);
				$this->valid_end = strtotime($this->valid_end);
				$this->create_time = time();
				$this->start_time = strtotime($this->start_time);
				$this->excess = $this->sendout;
			}
			return true;
		}
		return true;
	}
}
