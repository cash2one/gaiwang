<?php

/**
 * This is the model class for table "{{machine_advert}}".
 *
 * The followings are the available columns in table '{{machine_advert}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $category_id
 * @property integer $use_status
 * @property integer $status
 * @property integer $advert_type
 * @property integer $sort
 * @property string $svc_start_time
 * @property string $svc_end_time
 * @property integer $display_count
 * @property string $coupon_start_time
 * @property string $coupon_end_time
 * @property integer $coupon_quantity
 * @property integer $coupon_use_count
 * @property string $coupon_name
 * @property string $coupon_content
 * @property string $file_id
 * @property string $thumbnail_id
 * @property double $loc_lng
 * @property double $loc_lat
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $coupon_message
 * @property integer $user_id
 * @property string $user_ip
 * @property string $create_time
 * @property string $update_time
 */
class MachineAdvertAgent extends ActiveRecord
{       
        const ADVERT_TYPE_VEDIO = 1;			//视频
	const ADVERT_TYPE_SIGN = 2;				//首页轮播
	const ADVERT_TYPE_COUPON = 3;			//广告类型：1=视频	2=首页轮播	3=优惠劵		4=投票系统首页轮播广告
	const ADVERT_TYPE_VOTE = 4;				//投票系统首页轮播广告
	const ADVERT_TYPE_LOCALVEDIO = 5;		//盖机本地视频
    const ADVERT_TYPE_PRODUCT = 10;//产品管理
    const ADVERT_TYPE_CUSTOMFUN = 6;
	const ADVERT_STATUS = 1;		//状态：1=启用	2=删除
	const ADVERT_STATUS_DEL = 2;	//状态：删除
	const ADVERT_USE = 1;			//使用
	const ADVERT_UNUSE = 0;			//未使用
	
        public $filepath; //缩略图路径 by rdj
	public $category_pid;			//类型父节点
	public $vedioname;				//视频名称
	public $machine_id;				//绑定的盖机的编号
        public $address;
        public $path;
        public $provinceStr,$cityStr,$districtStr;


        /**
	 * 获取使用状态
	 */
	public static function getUseStatus($key = NULL){
		$useStatus = array(
			self::ADVERT_USE => Yii::t('Public','可用'),
			self::ADVERT_UNUSE => Yii::t('Public','停用'),
		);
		return $key == NULL?$useStatus:$useStatus[$key];
	}
	
	/**
	 * 允许的视频类型
	 */
	public static function getVedioType(){
		return array('avi','dat','mpg','mpeg','vob','mkv','mov','wmv','asf','rm','rmvb','ram','flv','mp4','3gp','dv','qt','divx','cpk','fli','flc','m4v');
	}
	
    
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_advert}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,description, sort', 'required'),		//公共需验证属性
			array('sort', 'numerical', 'integerOnly'=>true),
			array('use_status,country_id,advert_type', 'safe'),
//			array('coupon_start_time,coupon_end_time,use_status,status,advert_type,display_count,coupon_use_count,country_id', 'safe'),
			array('price','numerical','message'=>Yii::t('MachineAdvert','价格必须为数字'),'min'=>0,'max'=>'100000000','tooSmall'=>Yii::t('MachineAdvert','价格必须大于等于0'),'tooBig'=>Yii::t('MachineAdvert','价格必须小于100000000'),'on'=>self::ADVERT_TYPE_COUPON),
                        array('price','length','max'=>12,'on'=>self::ADVERT_TYPE_COUPON),
                        array('price', 'required','on'=>self::ADVERT_TYPE_COUPON),
                        array('price', 'checkPrice','on'=>self::ADVERT_TYPE_COUPON),
			array('title,description, sort, svc_start_time, svc_end_time, file_id, province_id, city_id, district_id', 'required', 'on'=>self::ADVERT_TYPE_SIGN),//首页轮播
			
			array('title,description, sort, svc_start_time, svc_end_time, file_id, province_id, city_id, district_id', 'required', 'on'=>self::ADVERT_TYPE_VOTE),//投票系统首页轮播
			
			array('vedioname', 'required' ,'on'=>self::ADVERT_TYPE_VEDIO),//视频
			array('vedioname', 'checkOneSuffix', 'on'=>self::ADVERT_TYPE_VEDIO),
//			array('vedioname', 'checkChinese', 'on'=>self::ADVERT_TYPE_VEDIO),
			array('svc_start_time, svc_end_time', 'safe'),
			
			array('svc_start_time, svc_end_time, category_id,thumbnail_id', 'required' ,'on'=>self::ADVERT_TYPE_COUPON),//优惠劵
                    
                        array('svc_start_time','checkTimeCoupon','on'=>self::ADVERT_TYPE_COUPON),
                        array('svc_start_time','checkTimeSign','on'=>self::ADVERT_TYPE_SIGN),
                    
			array('coupon_quantity', 'numerical', 'integerOnly'=>true ,'on'=>self::ADVERT_TYPE_COUPON),
			array('title','length','min'=>'2','max'=>'50'),
			array('coupon_name', 'length', 'min'=>'1', 'max'=>50, 'on'=>self::ADVERT_TYPE_COUPON),
			//array('coupon_content', 'length', 'min'=>1, 'max'=>255, 'on'=>self::ADVERT_TYPE_COUPON),
			array('coupon_message', 'length', 'min'=>1, 'max'=>120, 'on'=>self::ADVERT_TYPE_COUPON),
			array('coupon_start_time,coupon_end_time,status,display_count,coupon_use_count, file_id,coupon_name,loc_lng, loc_lat, province_id, city_id, district_id, coupon_message,coupon_quantity', 'safe', 'on'=>self::ADVERT_TYPE_COUPON),
		);
	}
        
        /*
         * 价格验证
         */
        public function checkPrice(){
            $priceArray = explode(".", $this->price);
            if(isset($priceArray[1])){
                strlen($priceArray[1]) > 2 ? $this->addError('price', Yii::t('MachineAdvert','小数长度不能大于2')) : "";
            }
        }

        /*
         * 优惠券时间验证
         */
        public function checkTimeCoupon(){
            if($this->svc_end_time != ""){
                if($this->svc_start_time >= $this->svc_end_time){
                    $this->addError('svc_start_time', Yii::t('Advert', '开始时间必须小于结束时间'));
                }
            }
            
            if($this->svc_start_time != ""){
                if($this->svc_start_time >= $this->svc_end_time){
                   $this->addError('svc_end_time', Yii::t('Advert', '结束时间必须大于开始时间')); 
                }
            }
            
            if($this->coupon_end_time != ""){
                if($this->coupon_start_time >= $this->coupon_end_time){
                    $this->addError('coupon_start_time', Yii::t('Advert', '开始时间必须小于结束时间'));
                }
            }
            
            if($this->coupon_start_time != ""){
                if($this->coupon_start_time >= $this->coupon_end_time){
                   $this->addError('coupon_end_time', Yii::t('Advert', '结束时间必须大于开始时间')); 
                }
            }
            
        }
        
        /*
         * 首页轮播时间验证
         */
        public function checkTimeSign(){
            if($this->svc_end_time != ""){
                if($this->svc_start_time >= $this->svc_end_time){
                    $this->addError('svc_start_time', Yii::t('Advert', '开始时间必须小于结束时间'));
                }
            }
            
            if($this->svc_start_time != ""){
                if($this->svc_start_time >= $this->svc_end_time){
                   $this->addError('svc_end_time', Yii::t('Advert', '结束时间必须大于开始时间')); 
                }
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
			'file' => array(self::BELONGS_TO,'FileManageAgent','file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('','标题'),
			'description' => Yii::t('','描述'),
			'category_id' => Yii::t('','广告类别'),
			'use_status' => Yii::t('','使用情况'),
			'status' => Yii::t('Public','状态'),
			'advert_type' => '广告类型',
			'sort' => Yii::t('Public','排序'),
			'svc_start_time' => Yii::t('Public','服务开始时间'),
			'svc_end_time' => Yii::t('Public','服务结束时间'),
			'display_count' => Yii::t('Advert','展示次数'),
			'coupon_start_time' => Yii::t('Advert','格子铺开始时间'),
			'coupon_end_time' => Yii::t('Advert','格子铺结束时间'),
			'coupon_quantity' => Yii::t('Advert','格子铺数量'),
			'coupon_use_count' => Yii::t('Advert','已发送数量'),
			'coupon_name' => Yii::t('Advert','格子铺名称'),
			'coupon_content' => '优惠券内容',
			'file_id' =>  Yii::t('Advert','放大图'),
			'thumbnail_id' => Yii::t('Advert','缩略图'),
			'loc_lng' => Yii::t('Public','经度'),
			'loc_lat' => '纬度',
			'country_id' => '国家',
			'province_id' => '省',
			'city_id' => '市',
			'district_id' => '区',
			'coupon_message' => Yii::t('Advert','格子铺短信内容'),
			'user_id' => '管理员id',
			'user_ip' => '管理员ip',
			'create_time' => '创建时间',
			'update_time' => '修改时间',
			'address' => Yii::t('Public','地址'),
			'ad_img' => Yii::t('Advert','广告图片'),
			'coupon_address' => Yii::t('Advert','格子铺地址'),
			'vedioname' => Yii::t('Machine','视频名称'),
                    'price'=> Yii::t('MachineAdvert','金额'),
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

		$criteria->compare('title',$this->title,true);
		$criteria->compare('use_status',$this->use_status);
		$criteria->compare('advert_type',$this->advert_type);
		
		$criteria->compare('svc_end_time',">=".strtotime($this->svc_start_time));
		$criteria->compare('svc_end_time',"<=".strtotime($this->svc_end_time));
                $criteria->addCondition('is_line = 0');
                
		if($this->advert_type!=self::ADVERT_TYPE_VEDIO){
                    
			$sql = "";
			if ($this->provinceStr!="")$sql.= "province_id in (".$this->provinceStr.")";
			if ($this->cityStr!=""){
				$sql.= $sql==""?"city_id in (".$this->cityStr.")":" or city_id in (".$this->cityStr.")";
			}
			if ($this->districtStr!=""){
				$sql.= $sql==""?"district_id in (".$this->districtStr.")":" or district_id in (".$this->districtStr.")";
			}
	                
			if ($sql!="")$criteria->addCondition("(".$sql.")");
                    
			$criteria->compare('province_id',$this->province_id);
			$criteria->compare('city_id',$this->city_id);
			$criteria->compare('district_id',$this->district_id);
		}
		
		
		$criteria->join = "";
		if($this->category_pid!=''){
			$criteria->join.= " left join ".CategoryAgent::model()->tableName()." category on t.category_id = category.id";
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		$criteria->addCondition('status = '.self::ADVERT_STATUS);  
		
		if($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_COUPON){
			$leftJoin = "f.id=t.thumbnail_id";
		}
		if($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_SIGN){
			$leftJoin = "f.id=t.file_id";
		}
                
		$criteria->select = "t.*,f.path as filepath";
		$criteria->join .= " left join ".FileManageAgent::model()->tableName()." f on $leftJoin";
                
		$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>15,
			    ),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineAdvertAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * 盖网通管理那边使用，用于绑定广告
	 */
	public function searBingAdvert(){
		$criteria=new CDbCriteria;

//		$criteria->compare('advert_type',$this->advert_type);
//		$criteria->distinct = true;
//		$criteria->select = "t.*,advert_machine.machine_id,f.path as filepath";
		$criteria->select = "t.*,advert_machine.sort,advert_machine.machine_id";
		
                $criteria->addCondition('is_line = 0');
		$criteria->join = "";
		if($this->category_pid!=''){
			$criteria->join.= " left join ".CategoryAgent::model()->tableName()." category on category.id = t.category_id";
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		//盖机管理那边会使用
		if ($this->advert_type!=  MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
			$mainTable = Machine2AdvertAgent::model()->tableName();
			
			$criteria->select.= ",file.path as filepath";
			$fileTable = FileManageAgent::model()->tableName()." file";
			
			$imgid = $this->advert_type == self::ADVERT_TYPE_COUPON?"t.thumbnail_id":"t.file_id";
			$criteria->join.= " left join $fileTable on file.id = $imgid";
			
			$criteria->compare('advert_type',$this->advert_type);
		}else{
			$mainTable = Machine2AdvertVideoAgent::model()->tableName();
			$criteria->addCondition('t.advert_type in ('.MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO.','.MachineAdvertAgent::ADVERT_TYPE_VEDIO.')');
		}
		$criteria->join.= " left join ".$mainTable." advert_machine on advert_machine.advert_id = t.id";
		$criteria->addCondition("advert_machine.machine_id = ".$this->machine_id);  
		
		$criteria->addCondition('status = '.self::ADVERT_STATUS);
		  
        $criteria->order = 'advert_machine.sort desc,t.sort desc';        
                
                
//		if ($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_COUPON){
//			$fileColumn = "t.thumbnail_id";
//		}else{
//			$fileColumn = "t.file_id";
//		}
//		$criteria->join .= " left join ".FileManageAgent::model()->tableName()." f on f.id = $fileColumn";
//		$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>15,
			    ),
		));
	} 

	/**
	 * 盖网通管理那边添加广告使用
	 */
	public function searchAdd(){
		$criteria=new CDbCriteria;
                $criteria->select = "t.*,f.path as filepath";
		$criteria->compare('title',$this->title,true);
		$criteria->compare('use_status',$this->use_status);
		$criteria->compare('advert_type',$this->advert_type);
		
		$criteria->compare('svc_end_time',">=".strtotime($this->svc_start_time));
		$criteria->compare('svc_end_time',"<=".strtotime($this->svc_end_time));
                $criteria->addCondition('is_line = 0');
                
                if($this->advert_type!=self::ADVERT_TYPE_VEDIO){
                    $sql = "";
                    if ($this->provinceStr!=""){
                        $sql.= "province_id in (".$this->provinceStr.")";
                    }
                    if ($this->cityStr!=""){
                            $sql.= $sql==""?"city_id in (".$this->cityStr.")":" or city_id in (".$this->cityStr.")";
                    }
                    if ($this->districtStr!=""){
                            $sql.= $sql==""?"district_id in (".$this->districtStr.")":" or district_id in (".$this->districtStr.")";
                    }

                    if ($sql!=""){
                        $criteria->addCondition("(".$sql.")");
                    }
                    $criteria->compare('province_id',$this->province_id);
                    $criteria->compare('city_id',$this->city_id);
                    $criteria->compare('district_id',$this->district_id);
		}
                
		$criteria->join = "";
		if($this->category_pid!=''){
			$criteria->join.= ",".CategoryAgent::model()->tableName()." category ";
			$criteria->addCondition('t.category_id = category.id');
			$criteria->addCondition('category.pid = '.$this->category_pid);
			if($this->category_id!=''){
				$criteria->addCondition('t.category_id = '.$this->category_id);  
			}
		}
		
		$criteria->addCondition('status = '.self::ADVERT_STATUS);  
		if($this->advert_type != self::ADVERT_TYPE_VEDIO){
                    $tableName = Machine2AdvertAgent::model()->tableName();
                }else{
                    $tableName = Machine2AdvertVideoAgent::model()->tableName();
                }
                $sql = "select advert_id from $tableName where machine_id=".$this->machine_id;
                $data = Yii::app()->gt->createCommand($sql)->queryAll();
                $datas = '';
                foreach ($data as $v){
                    $datas .= $v['advert_id'].',';
                }       
                if($datas){
                    $criteria->addCondition('t.id not in('.substr($datas,0,-1).')');
                }
                
                
                if ($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_COUPON){
			$fileColumn = "t.thumbnail_id";
		}else{
			$fileColumn = "t.file_id";
		}
                
                $criteria->join .= ",".FileManageAgent::model()->tableName()." f";
                $criteria->addCondition("f.id=$fileColumn");
                
		$criteria->order = 'update_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			        'pageSize'=>15,
			    ),
		));
	}
	
	/**
	 * 只有盖机广告排序使用到这个
	 */
	public function searchSort(){
		$criteria=new CDbCriteria;
                //$criteria->distinct = true;
		$criteria->compare('advert_type',$this->advert_type);
		$criteria->select = "t.*,f.path as path";
		
                if($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_COUPON){
                    if($this->category_pid!=''){
                            $criteria->join.= ",".  CategoryAgent::model()->tableName()." category ";
                            $criteria->addCondition('t.category_id = category.id');
                            $criteria->addCondition('category.pid = '.$this->category_pid);
                            if($this->category_id!=''){
                                    $criteria->addCondition('t.category_id = '.$this->category_id);  
                            }
                    }
                }
                
		$criteria->join.= ",".  Machine2AdvertAgent::model()->tableName()." b ";
		$criteria->addCondition("b.advert_id = t.id");
		$criteria->addCondition("b.machine_id = ".$this->machine_id);
		$criteria->addCondition('status = '.self::ADVERT_STATUS);  
		
                if ($this->advert_type == MachineAdvertAgent::ADVERT_TYPE_COUPON){
			$fileColumn = "t.thumbnail_id";
		}else{
			$fileColumn = "t.file_id";
		}
                
                $criteria->join .= ",".FileManageAgent::model()->tableName()." f";
                $criteria->addCondition("f.id=$fileColumn");
                
                
                
		$criteria->order = 't.sort desc';
		if ($this->advert_type == self::ADVERT_TYPE_COUPON){		//是优惠劵就返回查询，优惠劵另作处理
			return $criteria;
		}else{

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
				        'pageSize'=>999,
				    ),
			));
		}
	}
        
        /**
	 * 自定义唯一方法,验证视频的时候，视频名称必须唯一,并且在指定的视频格式内
	 */
	public function checkOneSuffix($attribute,$params){
		$arr = explode(".",$this->vedioname);
		$suffix = strtolower($arr[count($arr)-1]);
		unset($arr[count($arr)-1]);
		$filename = implode("",$arr);
		if(in_array($suffix,self::getVedioType())){
			$fileModel = FileManageAgent::model()->find("filename = '$filename' and suffix = '$suffix'");
			if($fileModel && $fileModel->id != $this->file_id){
				$this->addError($attribute,Yii::t('MachineAdvertAgent','该视频已经存在')."!");
			}
		}else{
			$this->addError($attribute,Yii::t('MachineAdvertAgent','不允许的视频格式')."!");
		}
	}
	
	/**
	 * 验证视频名称不能为中文
	 */
	public function checkChinese($attribute,$params){
		if(!preg_match("/^([a-zA-Z0-9-]+)*\.+([a-zA-Z0-9-]+)*$/", $this->vedioname)) {  
			$this->addError($attribute,Yii::t('MachineAdvert','视频名称不能为中文')."!");          
		}  
	}
        
        /**
	 * 保存之前执行的事件
	 */
	public function beforeSave(){
		if(parent::beforeSave()){
			if($this->isNewRecord){
				$this->status = self::ADVERT_STATUS;
				$this->create_time = time();
				//$this->advert_type = self::ADVERT_TYPE_COUPON;
				$this->user_id = Yii::app()->User->id;
                                $this->is_line = 0;
			}
			$this->update_time = time();
			$this->svc_start_time = strtotime($this->svc_start_time);
			$this->svc_end_time = strtotime($this->svc_end_time);
			$this->coupon_start_time = strtotime($this->coupon_start_time);
			$this->coupon_end_time = strtotime($this->coupon_end_time);
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
		$this->svc_start_time = date('Y-m-d H:i:s',$this->svc_start_time);		//12134534654654
		$this->svc_end_time = date('Y-m-d H:i:s',$this->svc_end_time);			//1465465545454
		$this->coupon_start_time = date('Y-m-d H:i:s',$this->coupon_start_time);
		$this->coupon_end_time = date('Y-m-d H:i:s',$this->coupon_end_time);
	} 
}
