<?php

/**
 * This is the model class for table "{{auditing}}".
 *
 * The followings are the available columns in table '{{auditing}}':
 * @property string $id
 * @property integer $status
 * @property integer $apply_type
 * @property string $apply_id
 * @property string $apply_name
 * @property string $apply_content
 * @property integer $author_type
 * @property string $author_id
 * @property string $author_name
 * @property string $create_time
 * @property string $submit_time
 * @property integer $auditor_type
 * @property string $auditor_id
 * @property string $auditor_name
 * @property string $audit_opinion
 * @property string $audit_time
 * 
 * 加盟商审核、企业会员审核
 * @author LC
 */
class Auditing extends CActiveRecord
{
	public $password,$password2;
	public $alias_name,$member_id,$parent_id,$max_machine,$gai_discount,$member_discount;
	public $province_id,$city_id,$district_id,$street,$lat,$lng;
	public $summary,$main_course,$category_id,$logo,$thumbnail,$mobile,$qq,$url,$keywords,$fax,$zip_code,$notice,$description;
	public $path;
	public $parentname;
	public $gai_number;		//
	public $username;		//申请人
    
    /**
     * apply_type定义
     */
    const APPLY_TYPE_BIZ_BASE = 1;      //加盟商基本信息
    const APPLY_TYPE_BIZ_GUANJIAN = 2;  //加盟商关键信息
    const APPLY_TYPE_BIZ_ADD = 3;       //添加加盟商
    const APPLY_TYPE_COMPANY = 4;       //添加企业会员
    const APPLY_TYPE_COMPANY_UPDATE = 5;       //编辑企业会员
    public static function getApplyType($key = null)
    {
    	$data = array(
    		self::APPLY_TYPE_BIZ_BASE => '加盟商基本信息',
    		self::APPLY_TYPE_BIZ_GUANJIAN => '加盟商关键信息',
    		self::APPLY_TYPE_BIZ_ADD => '添加加盟商',
    		self::APPLY_TYPE_COMPANY => '添加企业会员',
    		self::APPLY_TYPE_COMPANY_UPDATE => '编辑企业会员',
    	);
    	return $key===null ? $data : $data[$key];
    }
    
    /**
     * author_type定义
     */
    const AUTHOR_TYPE_MEMBER = 1;
    const AUTHOR_TYPE_AGENT = 2;
    public static function getAuthorType($key = null)
    {
    	$data = array(
    		self::AUTHOR_TYPE_MEMBER => '会员',
    		self::AUTHOR_TYPE_AGENT => '代理',
    	);
    	return $key===null ? $data : $data[$key];
    }
    
    
    
    const STATUS_WAIT = 0;						//暂存
    const STATUS_APPLY = 1;						//申请中
    const STATUS_PASS = 2;						//审核通过
    const STATUS_NOPASS = 3;					//审核不通过
	
	/**
	 * 审核类型
	 */
	const AUDITOR_TYPE_ADMIN = 2;	//默认是2
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{auditing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//parent_id
			array('apply_name,alias_name,member_id,max_machine,gai_discount,member_discount,province_id,city_id,district_id,street,summary,category_id,mobile,description,logo,path,main_course','required','on'=>'create'),		
			array('apply_name,alias_name','length','min'=>3,'max'=>100),
			array('password2','compare','compareAttribute'=>'password','operator'=>'=','message'=>Yii::t('franchiseeAgent','密码与确认密码不匹配'.'!'),'on'=>'create'),
			array('parent_id,max_machine','numerical','integerOnly'=>true),
			array('gai_discount,member_discount','numerical','min'=>0,'max'=>100),
			array('main_course','length','min'=>1,'max'=>100),
			array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('franchiseeAgent', '请输入正确的您的手机号码'),'on'=>'create'),
			array('qq,fax', 'length', 'min'=>5, 'max'=>100),
			array('url', 'url'),
			array('url', 'length' ,'min'=>5, 'max'=>200),
			array('keywords', 'length' ,'min'=>5, 'max'=>255),
			array('zip_code', 'length' ,'min'=>5, 'max'=>20),
			array('notice', 'length' ,'min'=>1, 'max'=>255),
			array('id, create_time, update_time, apply_name, password, salt, alias_name, category_id, logo, province_id, city_id, district_id, street, description, qq, url, lng, lat, fax, zip_code, gai_discount, member_discount, mobile, member_id, max_machine, main_course, summary, notice, keywords, parent_id, parentname, thumbnail, background, banner, country_id, status, code, gai_number, audit_opinion', 'safe'),
			
			array('password,password2','required','on'=>'create'),
			
			array('member_id','checkgainum','on'=>'create'),
			array('apply_name, alias_name', 'checkApplyName', 'on' => 'create'),
			
			array('member_id','checkgainum','on'=>'key'),
			array('apply_name, alias_name', 'checkApplyName', 'on' => 'key'),
			array('apply_name,alias_name,member_id,gai_discount,member_discount','required','on'=>'key'),
			
			array('province_id,city_id,district_id,street,summary,category_id,logo,path,mobile,description,main_course','required','on'=>'base'),
			array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('franchiseeAgent', '请输入正确的您的手机号码'),'on'=>'base'),
			
			
//			array('province_id,city_id,district_id,street,summary,category_id,mobile,description,logo,path','required','on'=>'base'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, create_time, update_time, apply_name, password, salt, alias_name, category_id, logo, province_id, city_id, district_id, street, description, qq, url, lng, lat, fax, zip_code, gai_discount, member_discount, mobile, member_id, max_machine, main_course, summary, notice, keywords, parent_id, thumbnail, background, banner, country_id, status, code, gai_number, apply_name, author_name, audit_opinion', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * 验证填写的会员编号所对应的会员是否为企业会员
	 */
	public function checkgainum($attribute,$params){
		$tableName = Member::model()->tableName();
		$referrals_id = $this->isNewRecord?Yii::app()->user->id:$this->author_id;
		$sql = "select is_enterprise from $tableName where status in (".Member::STATUS_NORMAL.",".Member::STATUS_NO_ACTIVE.") and gai_number = '".$this->member_id."' and referrals_id = ".$referrals_id;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		if(!$result){
			$this->addError($attribute, Yii::t('FranchiseeAgent', '该会员编号不存在').'!');
		}else if ($result['is_enterprise']=="0") {
			$this->addError($attribute, Yii::t('FranchiseeAgent', '不是企业会员').'!');
		}
		
	}
	
	/**
	 * 验证加盟商名称是否唯一
	 */
	public function checkApplyName($attribute,$params)
	{
		if($this->status != Auditing::STATUS_NOPASS)
		{
			$franchiseeTable = Franchisee::model()->tableName();
			if($attribute == 'apply_name')
			{
				$sql = "select 1 from $franchiseeTable where name = '".$this->apply_name."'";
				if($this->apply_id)
				{
					$sql .= " and id <> ".$this->apply_id;
				}
				$content = Yii::t('auditing', '加盟商名称已存在').'!';
			}
			elseif ($attribute == 'alias_name')
			{
				$sql = "select 1 from $franchiseeTable where alias_name = '".$this->alias_name."'";
				if($this->apply_id)
				{
					$sql .= " and id <> ".$this->apply_id;
				}
				$content = Yii::t('auditing', '商家英文名已存在').'!';
			}
			$rs = Yii::app()->db->createCommand($sql)->queryScalar();
			if($rs)
			{
				$this->addError($attribute, $content);
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
			'member' => array(self::BELONGS_TO, 'Member', 'apply_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => Yii::t('Franchisee','申请的状态'),
			'apply_type' => Yii::t('Franchisee','申请类型'),
			'apply_id' => '申请会员编号',
			'apply_name' => Yii::t('Franchisee','加盟商名称'),
			'apply_content' => '加盟商信息，存json格式',
			'author_type' => '申请会员类型',
			'author_id' => '添加加盟商申请的人id',
			'author_name' => '申请会员编号',
			'create_time' => Yii::t('Franchisee','创建时间'),
			'submit_time' => '申请时间',
			'auditor_type' => '审核人的类型',
			'auditor_id' => '审核人的id',
			'auditor_name' => '审核人的名称',
			'audit_opinion' => '审核意见',
			'audit_time' => '审核时间',
			'password' => Yii::t('Franchisee','密码'),
			'alias_name' => Yii::t('Franchisee','商家英文名'),
			'category_id' => Yii::t('Franchisee','行业'),
			'logo' => 'LOGO',
			'province_id' => Yii::t('Public','省份'),
			'city_id' => Yii::t('Public','城市'),
			'district_id' => Yii::t('Public','区/县'),
			'street' => Yii::t('Franchisee','详细地址'),
			'description' => Yii::t('Franchisee','介绍'),
			'qq' => 'QQ',
			'url' => Yii::t('Franchisee','网址'),
			'lng' => Yii::t('Public','经度'),
			'lat' => Yii::t('Public','纬度'),
			'fax' => Yii::t('Franchisee','传真'),
			'zip_code' => Yii::t('Franchisee','邮编'),
			'gai_discount' => Yii::t('Franchisee','盖网折扣'),
			'member_discount' => Yii::t('Franchisee','会员折扣'),
			'mobile' => Yii::t('Franchisee','手机号码'),
			'member_id' => Yii::t('Franchisee','所属会员'),
			'max_machine' => Yii::t('Franchisee','最大绑定盖机数'),
			'main_course' => Yii::t('Franchisee','主营'),
			'summary' => Yii::t('Franchisee','简介'),
			'notice' => Yii::t('Franchisee','公告'),
			'keywords' => Yii::t('Franchisee','关键词'),
			'parent_id' => Yii::t('Franchisee','父级加盟商'),
			'thumbnail' => '缩略图',
			'background' => '背景图',
			'banner' => 'BANNER',
			'country_id' => '国家',
			'code' => Yii::t('member', '加盟商编号'),
			'password2' => Yii::t('Franchisee','确认密码'),
			'gai_number' => Yii::t('member', '会员编号'),
			'username' => Yii::t('member', '申请人'),
			'path' => '图片列表',
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

		$criteria->addInCondition('apply_type', array(self::APPLY_TYPE_COMPANY,self::APPLY_TYPE_COMPANY_UPDATE));
		$criteria->addCondition('status <> '.self::STATUS_PASS);
		$criteria->compare('status',$this->status);
		
		$criteria->compare('apply_name',trim($this->apply_name),true);
		$criteria->compare('gai_number',trim($this->gai_number),true);
		$criteria->compare('author_id',Yii::app()->user->Id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 代理管理系统->加盟商管理->申请列表
	 * 查询出状态为暂存、申请，申请类型为添加加盟商、加盟商关键信息
	 */
	public function searchApply()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		//申请人 （审核使用）	申请类型 		加盟商名称 	创建时间 		申请时间 		申请状态 	
		$criteria=new CDbCriteria;
		
//		$memberTable = Member::model()->tableName();
		$criteria->select = "t.id,t.apply_type,t.apply_name,t.create_time,t.submit_time,t.status,author_name as username";
		
		$criteria->addCondition("t.status in (".self::STATUS_WAIT.",".self::STATUS_APPLY.",".self::STATUS_NOPASS.")");
		$criteria->addCondition("t.apply_type in (".self::APPLY_TYPE_BIZ_GUANJIAN.",".self::APPLY_TYPE_BIZ_ADD.")");
		$criteria->compare('t.apply_name',trim($this->apply_name),true);
		$criteria->compare('t.author_id', Yii::app()->user->Id);
		$criteria->order = 't.submit_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>9,
		    ),
			'sort' => false,
		));
	}
	
	/**
	 * 加盟商审核列表
	 * 查询出状态为申请，申请类型为加盟商基本信息，所属会员的推荐人为当前登录人
	 */
	public function searchAudit()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		//申请人 （审核使用）	申请类型 		加盟商名称 	创建时间 		申请时间 		申请状态 	
		$criteria=new CDbCriteria;
		$criteria->select = "t.id,t.apply_type,t.apply_name,t.create_time,t.submit_time,t.status,t.author_name as username";
		
		$memberTable = Member::model()->tableName();
		$franchiseeTable = Franchisee::model()->tableName();
		$criteria->join = ",$memberTable m,$franchiseeTable f";
		$criteria->addCondition("f.id = t.apply_id");
		$criteria->addCondition("m.id = f.member_id");
		$criteria->addCondition("m.referrals_id = ".Yii::app()->user->Id." or t.author_id =". Yii::app()->user->Id);
		
		$criteria->addCondition("t.status = ".self::STATUS_APPLY);
		$criteria->addCondition("t.apply_type = ".self::APPLY_TYPE_BIZ_BASE);
		$criteria->compare('t.apply_name',trim($this->apply_name),true);
		$criteria->order = 't.submit_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>9,
		    ),
			'sort' => false,
		));
	}
	
	/**
	 * 会员管理->企业会员审核列表
	 */
	public function searchStoreMember(){
		//企业会员名称	申请类型		申请代理商的会员编号		申请时间		
		$criteria=new CDbCriteria;
		
		$criteria->select = "t.id,t.apply_type,t.apply_name,t.submit_time,t.author_name";
		
		$memberTable = Member::model()->tableName();
		$criteria->join = "left join $memberTable m on m.id = t.author_id";
		
		$criteria->addCondition("t.status = ".self::STATUS_APPLY);
		$criteria->addCondition("t.apply_type in (".self::APPLY_TYPE_COMPANY.",".self::APPLY_TYPE_COMPANY_UPDATE.")");
		$criteria->compare('m.gai_number',trim($this->gai_number),true);
		$criteria->compare('t.apply_name',trim($this->apply_name),true);
		$criteria->order = 't.submit_time desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>9,
		    ),
			'sort' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Auditing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 保存之前执行的事件
	 */
	public function beforeSave(){
		   if (parent::beforeSave()) {
            if ($this->isNewRecord){
                $this->create_time = time();
                $this->author_id = Yii::app()->user->id;					//添加加盟商申请的人id
                
                $memberTable = Member::model()->tableName();
                $sql = "select gai_number from $memberTable where id = ".Yii::app()->user->id;
                $memberArr = Yii::app()->db->createCommand($sql)->queryRow();
                $this->author_name = $memberArr['gai_number'];				//添加加盟商申请的人名称
            }   
            $this->submit_time = time();
            
            return true;
        } else
            return false;
	}
	
	/**
	 * 通过id得到会员的GW号
	 * @author LC
	 */
	public static function findGWNoById($id)
	{
		$member_table = Member::model()->tableName();
		$sql = "select gai_number from $member_table where id= :id";
		return Yii::app()->db->createCommand($sql)->queryScalar(array(':id'=>$id));
	}
	
	public function getApplyUrl($type,$key){
//	if($data->apply_type==Auditing::APPLY_TYPE_BIZ_BASE){"updateBase"}else if($data->apply_type==Auditing::APPLY_TYPE_BIZ_GUANJIAN){"updateKey"}else{"update"}
		echo Yii::app()->createUrl("franchiseeAgent/update", array("id"=>$key));
	}
	
	/**
	 * 总后台管理---加盟商审核列表
	 */
	public function searchFranchiseeAuditing()
	{
		$criteria=new CDbCriteria;

		$criteria->addCondition("t.apply_type in (".self::APPLY_TYPE_BIZ_BASE.",".self::APPLY_TYPE_BIZ_GUANJIAN.",".self::APPLY_TYPE_BIZ_ADD.")");
		$criteria->addCondition('status = '.self::STATUS_APPLY);
		
		$criteria->compare('apply_name',$this->apply_name,true);
		$criteria->compare('author_name',$this->author_name,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 总后台--批量通过加盟商审核
	 */
	public static function batchPassBiz($models)
	{
		foreach($models as $model)
		{
			$franchiseeArr = CJSON::decode($model->apply_content);
			$franchiseeModel = Franchisee::model()->findByPk($model->apply_id);
			if(!$franchiseeModel)
			{
				$franchiseeModel = new Franchisee();
			}
			$franchiseeModel->attributes = $franchiseeArr;
			$franchiseeModel->name = $model->apply_name;
			if(isset($franchiseeArr['password']))
			{
				$franchiseeModel->confirmPassword = $franchiseeArr['password'];
			}
			
			$franchiseeModel->logo = $franchiseeArr['logo'];
			$franchiseeModel->update_time = time();
			$franchiseeModel->country_id = 1;		//默认是中国
			if($model->status == self::STATUS_PASS)
			{
				$franchiseeModel->save(false);
				$model->update();
			}
		}
        return true;
	}
	
	/**
	 * 总后台--通过加盟商审核
	 */
	public static function passBiz($model)
	{
		$franchiseeArr = CJSON::decode($model->apply_content);
		$franchiseeModel = Franchisee::model()->findByPk($model->apply_id);
		if(!$franchiseeModel)
		{
			$franchiseeModel = new Franchisee();
		}
		$franchiseeModel->attributes = $franchiseeArr;
		$franchiseeModel->name = $model->apply_name;
		if(isset($franchiseeArr['password']))
		{
			$franchiseeModel->confirmPassword = $franchiseeArr['password'];
		}
		
		$franchiseeModel->logo = $franchiseeArr['logo'];
		$franchiseeModel->update_time = time();
		$franchiseeModel->country_id = 1;		//默认是中国
		if($model->status == self::STATUS_PASS)
		{
			$franchiseeModel->save(false);
			$model->update();
		}
        return true;
	}
}
