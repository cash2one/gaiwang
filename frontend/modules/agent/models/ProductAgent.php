<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $category_id
 * @property string $name
 * @property string $market_price
 * @property string $price
 * @property integer $back_rate
 * @property integer $gt_rate
 * @property integer $gw_rate
 * @property string $stock
 * @property string $sales_volume
 * @property string $thumbnail_id
 * @property string $activity_start_time
 * @property string $activity_end_time
 * @property string $content
 * @property integer $biz_info_id
 * @property string $biz_name
 * @property string $image_list_id
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $status
 */
class ProductAgent extends ActiveRecord
{
	public $category_pid;			//类型父节点
	public $machine_id;				//绑定的盖机的编号
	
	public $provinceStr,$cityStr,$districtStr;

	public $gw_rate;
	
	public static $GWIncomeRate;	//盖网收益
	public static $buyerIncomeRate;	//消费者收益
	//商品状态
	const STATUS_0 = 0;				//   0、待审核 1、审核已通过 2、审核未通过3、删除
	const STATUS_1 = 1;   
	const STATUS_2 = 2;   
        const STATUS_DEL = 3;
        
	/**
 	 * 数据连接
	 * @return type
	 * @throws CDbException
	 */
 	public function getDbConnection()
    {
        return Yii::app()->gt;
    }
	
	public static function getStatus($key = null)
	{
		$data = array(
			self::STATUS_0=>Yii::t('Product','待审核'),
			self::STATUS_1=>Yii::t('Product','审核已通过'),
			self::STATUS_2=>Yii::t('Product','审核未通过'),
		);
		return $key===null ? $data : $data[$key];
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product}}';
	}
	
    /**
     * 类型表
     */
    public function tableNameCategory(){
        return '{{category}}';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,number,price,back_rate,gt_rate,stock,category_id,biz_name,sort,activity_start_time,activity_end_time,thumbnail_id,image_list_id','required'),
			array('name,number','length','min'=>1,'max'=>49),
			array('thumbnail_id','numerical','min'=>1),
			array('price,market_price','numerical','min'=>0,'max'=>99999999),
			array('back_rate,gt_rate','numerical','integerOnly'=>true,'min'=>1,'max'=>100),
			array('gw_rate,use_status,biz_info_id,content,country_id,province_id,city_id,district_id','safe'),
			array('gt_rate','checkGtRate'),
			array('return_score,create_time,user_id,user_ip','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_id, name, activity_start_time, activity_end_time, country_id, province_id, city_id, district_id, status', 'safe', 'on'=>'search'),
		);
	}
	
	public function checkGtRate($attribute, $params) {
		$max_gt_rate = Tool::getConfig('allocation', 'offMachineIncome');
		if($this->$attribute > $max_gt_rate)
		{
			$this->addError($attribute, '盖机收益不能超过'.$max_gt_rate);
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
			'category' => array(self::BELONGS_TO,'CategoryAgent','category_id'),
			'thumbnail' => array(self::BELONGS_TO,'FileManageAgent','thumbnail_id'),
			'file' => array(self::BELONGS_TO,'FileManageAgent','image_list_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => '类别',
			'name' => '商品名称',
			'number' => '商品编号',
			'market_price' => '市场价',
			'price' => '零售价',
			'back_rate' => '返佣率（存1-100的整数）',
			'gt_rate' => '盖机收益率（存1-100的整数）',
			'gw_rate' => '盖网收益率（存1-100的整数）',
			'stock' => '库存',
			'sales_volume' => '销量',
			'activity_start_time' => '活动开始时间',
			'activity_end_time' => '活动结束时间',
			'content' => '产品详情',
			'biz_info_id' => '加盟商id',
			'biz_name' => '加盟商名称',
			'thumbnail_id' => '封面图',
			'image_list_id' => '图片列表',
			'country_id' => '国家id',
			'province_id' => '省份id',
			'city_id' => '城市id',
			'district_id' => '区县id',
			'status' => '审核状态',
			'sort' => '排序',
			'use_status' => '是否可用',
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
	 * 商品管理列表页使用，(如果有其它页面也使用，请注明)
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "t.id,t.name,t.status,t.activity_end_time,t.activity_start_time,t.stock,t.price,t.content";
		$criteria->compare('t.name',$this->name,true);
		
		$criteria->compare('t.activity_start_time',">=".$this->activity_start_time);
		$criteria->compare('t.activity_end_time',"<=".$this->activity_end_time);
		
		//限制省市如
		$sql = "";
		if ($this->provinceStr!="")$sql.= "t.province_id in (".$this->provinceStr.")";
		if ($this->cityStr!=""){
			$sql.= $sql==""?"t.city_id in (".$this->cityStr.")":" or t.city_id in (".$this->cityStr.")";
		}
		if ($this->districtStr!=""){
			$sql.= $sql==""?"t.district_id in (".$this->districtStr.")":" or t.district_id in (".$this->districtStr.")";
		}
		if ($sql!="")$criteria->addCondition("(".$sql.")");
		
		
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		$criteria->compare('t.status',$this->status);
		
		$criteria->with = array(
			'category' => array('select'=>'name'),
			'thumbnail' => array('select'=>'path'),
		);
		
		$criteria->addCondition('t.status <>'.self::STATUS_DEL);
		
		$criteria->compare('t.category_id',$this->category_id);
		
		if($this->category_pid!=''){
//			$criteria->join = ",".$this->tableNameCategory()." category";
//			$criteria->addCondition('category.id = t.category_id');
			$criteria->addCondition('category.pid = '.$this->category_pid);
//			$criteria->compare('t.category_id',$this->category_id);
		}

		$criteria->order = 't.sort desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
/**
	 * 保存之前执行的事件
	 */
	public function beforeSave(){
		if(parent::beforeSave()){
			$this->activity_start_time = strtotime($this->activity_start_time);
			$this->activity_end_time = strtotime($this->activity_end_time);
			
			$GWIncomeRate = Tool::getConfig('allocation', 'gaiIncome');
			$BuyerIncomeRate = Tool::getConfig('allocation', 'offConsume');
			$returnMoney = $this->price*$this->back_rate/100*(1-$GWIncomeRate/100)*(1-$this->gt_rate/100)*$BuyerIncomeRate/100;
			$this->return_score = Common::convertSingle($returnMoney, 'official');
			if($this->isNewRecord)
			{
				$this->create_time = time();
			}
			$this->user_id = Yii::app()->user->id;
			$this->user_ip = Tool::ip2int(Tool::getClientIP());
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 查找之后的事件
	 */
	public function afterFind(){
		parent::afterFind();		//先执行父类的afterfind事件
		$this->activity_start_time = date('Y-m-d H:i:s',$this->activity_start_time);
		$this->activity_end_time = date('Y-m-d H:i:s',$this->activity_end_time);
	}
        
        
       
	/**
	 * 盖网通管理那边使用，用于绑定产品
	 */
	public function searBingProduct(){
		$criteria=new CDbCriteria;
                
//                $sql = "";
//		if ($this->provinceStr!="")$sql.= "province_id in (".$this->provinceStr.")";
//		if ($this->cityStr!=""){
//			$sql.= $sql==""?"city_id in (".$this->cityStr.")":" or city_id in (".$this->cityStr.")";
//		}
//		if ($this->districtStr!=""){
//			$sql.= $sql==""?"district_id in (".$this->districtStr.")":" or district_id in (".$this->districtStr.")";
//		}
//                
//		if ($sql!="")$criteria->addCondition("(".$sql.")");
//                {   
//			$criteria->compare('province_id',$this->province_id);
//			$criteria->compare('city_id',$this->city_id);
//			$criteria->compare('district_id',$this->district_id);
//		}
                
                
		$criteria->distinct = true;
		$criteria->select = "t.*,p.machine_id";
		$criteria->join = "";
		if($this->category_pid!=''){
			$criteria->join.= " left join ".CategoryAgent::model()->tableName()." category on t.category_id = category.id";
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		//盖机管理那边会使用
		
		$criteria->addCondition('t.status <>'.self::STATUS_DEL);
		
		$mainTable = Machine2ProductAgent::model()->tableName();
		
		$criteria->join.= " left join ".$mainTable." p on p.product_id = t.id";
		$criteria->addCondition("p.machine_id=".$this->machine_id);  
		
		//$criteria->addCondition('status = '.self::STATUS_0);  
		
		//$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>15,
			    ),
		));
	}
        
        
        /**
	 * 盖网通管理那边添加广告使用 产品管理
	 */
	public function searchAdd(){
		$criteria=new CDbCriteria;

		$criteria->compare('t.name',$this->name,true);
		
		$criteria->compare('t.activity_start_time',">=".$this->activity_start_time);
		$criteria->compare('t.activity_end_time',"<=".$this->activity_end_time);
		
		$sql = "";
		if ($this->provinceStr!="")$sql.= "t.province_id in (".$this->provinceStr.")";
		if ($this->cityStr!=""){
			$sql.= $sql==""?"t.city_id in (".$this->cityStr.")":" or t.city_id in (".$this->cityStr.")";
		}
		if ($this->districtStr!=""){
			$sql.= $sql==""?"t.district_id in (".$this->districtStr.")":" or t.district_id in (".$this->districtStr.")";
		}
		if ($sql!="")$criteria->addCondition("(".$sql.")");
		
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);

		if($this->category_pid!=''){
			$criteria->with = 'category';
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		//$criteria->addCondition('status = '.self::ADVERT_STATUS);
		  
		$criteria->compare('t.status',$this->status);
		$criteria->addCondition('t.status <>'.self::STATUS_DEL);
		
		//$criteria->order = 'update_time desc';
                $leftTable = Machine2ProductAgent::model()->tableName();
		$sql = "select product_id from $leftTable where machine_id = ".$this->machine_id;
		$resArr = Yii::app()->gt->createCommand($sql)->queryAll();
		$extstsId = "";
		foreach ($resArr as $row){
			$extstsId.= $extstsId==""?$row['product_id']:",".$row['product_id'];
		}
                if ($extstsId!=""){
			$criteria->addCondition("t.id not in($extstsId)");
		}
                $criteria->order = 't.sort desc';
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>15,
			    ),
		));
	}
        
        
        
        /**
	 * 只有盖机广告排序使用到这个 产品管理
	 */
	public function searchSort(){
		$criteria=new CDbCriteria;
		$criteria->select = "t.*,(select file.path from ".  FileManageAgent::model()->tableName()." file where file.id = t.thumbnail_id) as path";
		if($this->category_pid!=''){
			$criteria->join.= ",".  CategoryAgent::model()->tableName()." category ";
			$criteria->addCondition('t.category_id = category.id');
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		$criteria->join.= ",". Machine2ProductAgent::model()->tableName()." b ";
		$criteria->addCondition("b.product_id = t.id");
		$criteria->addCondition("b.machine_id = ".$this->machine_id);
		//$criteria->addCondition('status = '.self::ADVERT_STATUS);  
		$criteria->addCondition('t.status <>'.self::STATUS_DEL);
		
		$criteria->order = 't.sort desc';
                return $criteria;
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//			'pagination'=>array(
//			        'pageSize'=>999,
//			    ),
//		));
	}

	/**
	 * 得到盖网收益
	 * @author LC
	 */
	public static function getGWIncomeRate()
	{
		if(self::$GWIncomeRate!==null)
		{
			return self::$GWIncomeRate;
		}
		$GWIncomeRate = Tool::getConfig('allocation', 'gaiIncome');
		self::$GWIncomeRate = $GWIncomeRate;
		return self::$GWIncomeRate;	
	}
	
	/**
	 * 得到消费者的分配比例
	 * @author LC
	 */
	public static function getBuyerIncomeRate()
	{
		if(self::$buyerIncomeRate!==null)
		{
			return self::$buyerIncomeRate;
		}
		$BuyerIncomeRate = Tool::getConfig('allocation', 'offConsume');
		self::$buyerIncomeRate = $BuyerIncomeRate;
		return self::$buyerIncomeRate;
	}
}
