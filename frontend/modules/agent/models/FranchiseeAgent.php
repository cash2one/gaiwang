<?php

/**
 * This is the model class for table "{{franchisee}}".
 *
 * The followings are the available columns in table '{{franchisee}}':
 * @property string $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property string $password
 * @property string $salt
 * @property string $alias_name
 * @property integer $category_id
 * @property string $logo
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $description
 * @property string $qq
 * @property string $url
 * @property string $lng
 * @property string $lat
 * @property string $fax
 * @property string $zip_code
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $mobile
 * @property string $member_id
 * @property integer $max_machine
 * @property string $main_course
 * @property string $summary
 * @property string $notice
 * @property string $keywords
 * @property string $parent_id
 * @property string $thumbnail
 * @property string $background
 * @property string $banner
 * @property string $country_id
 * @property integer $status
 * @property string $code
 */
class FranchiseeAgent extends CActiveRecord
{
	const STATUS_DISABLED = 0;
    const STATUS_ENABLE = 1;
    
    // 加盟商编码长度
    const FRANCHISEE_CODE_LENGTH = 11;
    
	public $gai_number;
	public $province_name,$city_name,$district_name;
	public $machine_num,$country_name;
	public $parentname;
	public $password2;		//确认密码
	public $path;
	public $categoryname;
	public $username;
        public $agent_ss;
    
        public $category_id;
        public $gai_discount;
        public $member_discount;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee}}';
	}

	/**
	 * 获取状态
	 */
	public static function getStatus($key=NULL){
		$arr = array(
			self::STATUS_ENABLE => Yii::t('franchiseeAgent', '已审核'),
			self::STATUS_DISABLED => Yii::t('franchiseeAgent', '未审核'),
		);
		return $key==NULL?$arr:$arr[$key];
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
			array('name,alias_name,member_id,max_machine,gai_discount,member_discount,province_id,city_id,district_id,street,summary,category_id,mobile,description,logo,path','required'),		
			array('name,alias_name','length','min'=>3,'max'=>100),
//			array('password','compare','compareAttribute'=>'password2','operator'=>'=','message'=>Yii::t('franchiseeAgent','密码与确认密码不匹配'.'!'),'on'=>'create'),
			array('parent_id,max_machine','numerical','integerOnly'=>true),
			array('gai_discount,member_discount','numerical','min'=>0,'max'=>100),
			array('main_course','length','min'=>1,'max'=>100),
			array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('franchiseeAgent', '请输入正确的您的手机号码')),
			array('qq,fax', 'length', 'min'=>5, 'max'=>100),
			array('url', 'url'),
			array('url', 'length' ,'min'=>5, 'max'=>200),
			array('keywords', 'length' ,'min'=>5, 'max'=>255),
			array('zip_code', 'length' ,'min'=>5, 'max'=>20),
			array('notice', 'length' ,'min'=>1, 'max'=>255),
			array('id, create_time, update_time, name, password, salt, alias_name, category_id, logo, province_id, city_id, district_id, street, description, qq, url, lng, lat, fax, zip_code, gai_discount, member_discount, mobile, member_id, max_machine, main_course, summary, notice, keywords, parent_id, thumbnail, background, banner, country_id, status, code, gai_number', 'safe'),
			
//			array('password,password2','required','on'=>'create'),
			
			array('member_id','checkgainum'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, create_time, update_time, name, password, salt, alias_name, category_id, logo, province_id, city_id, district_id, street, description, qq, url, lng, lat, fax, zip_code, gai_discount, member_discount, mobile, member_id, max_machine, main_course, summary, notice, keywords, parent_id, thumbnail, background, banner, country_id, status, code, gai_number', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * 验证填写的会员编号所对应的会员是否为企业会员
	 */
	public function checkgainum($attribute,$params){
		$tableName = MemberAgent::model()->tableName();
		$sql = "select is_enterprise from $tableName where status = ".MemberAgent::STATUS_NORMAL." and gai_number = '".$this->member_id."' and referrals_id = ".Yii::app()->user->id;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		if($result['is_enterprise']==""){
			$this->addError($attribute, Yii::t('FranchiseeAgent', '该会员编号不存在').'!');
		}else if ($result['is_enterprise']=="0") {
			$this->addError($attribute, Yii::t('FranchiseeAgent', '不是企业会员').'!');
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
			'name' => Yii::t('Franchisee','加盟商名称'),
			'password' => '密码',
			'salt' => '密钥',
			'alias_name' => Yii::t('Franchisee','商家英文名'),
			'category_id' => Yii::t('Franchisee','分类'),
			'logo' => 'LOGO',
			'province_id' => Yii::t('Franchisee','省份'),
			'city_id' => Yii::t('Franchisee','城市'),
			'district_id' => Yii::t('Franchisee','区/县'),
			'street' => Yii::t('Franchisee','详细地址'),
			'description' => Yii::t('Franchisee','介绍'),
			'qq' => 'QQ',
			'url' => Yii::t('Franchisee','网址'),
			'lng' => '经度',
			'lat' => '纬度',
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
			'status' => '状态',
			'code' => Yii::t('Franchisee', '加盟商编号'),
			'password2' => Yii::t('franchiseeAgent','确认密码'),
			'gai_number' => Yii::t('Franchisee', '会员编号'),
			'path'=>'图片列表'
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
	 * 加盟商管理里面加盟商列表使用到
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$memberTableName = MemberAgent::model()->tableName();
		$criteria=new CDbCriteria;
		$criteria->select = 't.id,t.name,t.code,t.max_machine,t.mobile,m.username,m.gai_number,
		(case when t.parent_id = 0 then "" else (select p.name from '.self::tableName().' p where p.id = t.parent_id) end) as parentname';
		
		$criteria->join = ",$memberTableName m";				//加盟商所属会员的推荐人必须是登陆人
		$criteria->addCondition("m.referrals_id =".Yii::app()->user->id);
		$criteria->addCondition("t.member_id = m.id");
		
		$criteria->compare('t.name',trim($this->name),true);
		
		if (strlen(trim($this->gai_number))==10) {
			$criteria->compare('m.gai_number',trim($this->gai_number));
		}else{
			$criteria->compare('m.gai_number',trim($this->gai_number),true);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>9,
		    ),
			'sort' => array(
                'defaultOrder' => 't.id desc',
                'attributes' => array(''),
            ),
		));
	}
	
	/**
	 * 查询加盟商(汇入使用)
	 */
	public function searchBiz()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 't.id,t.name,p.name as province_name,c.name as city_name,d.name as district_name,t.street';
		$criteria->join = 'LEFT JOIN {{region}} p ON p.id=t.province_id LEFT JOIN {{region}} c ON c.id=t.city_id LEFT JOIN {{region}} d ON d.id=t.district_id';
		$criteria->compare('t.name',$this->name,true);
		
		$agent_region = $this->agent_ss;  //控制器传过来的代理商地区session
		$sql = "";
		if($agent_region['provinceId']!="")$sql.= $sql==""?"t.province_id in(".$agent_region['provinceId'].")":"";
		if($agent_region['cityId']!="")$sql.= $sql==""?"t.city_id in(".$agent_region['cityId'].")":" or t.city_id in(".$agent_region['cityId'].")";
		if($agent_region['districtId']!="")$sql.= $sql==""?"t.district_id in(".$agent_region['districtId'].")":" or t.district_id in(".$agent_region['districtId'].")";
		if($sql!='')$criteria->addCondition ("(".$sql.")");
                
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.district_id',$this->district_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
			'sort' => array(
                'defaultOrder' => 'id desc',
                'attributes' => array(
                    'name',
                    'province_name' => array(
                        'asc' => 'province_name',
                        'desc' => 'province_name desc'
                    ),
                    'city_name' => array(
                        'asc' => 'city_name',
                        'desc' => 'city_name desc'
                    ),
                    'district_name' => array(
                        'asc' => 'district_name',
                        'desc' => 'district_name desc'
                    ),
                )
            ),
		));
	}
	
	public function searchByName()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria=new CDbCriteria;
		$FranchiseeCategory = FranchiseeCategory::model()->tableName();
		$memberTableName = MemberAgent::model()->tableName();
		
		$criteria->select = "t.id,t.name,t.create_time,t.author_name,t.status,
		(select name from $FranchiseeCategory where id = t.category_id) as categoryname";
		
		$criteria->join = ",$memberTableName m";				//加盟商所属会员的推荐人必须是登陆人
		$criteria->addCondition("m.referrals_id =".Yii::app()->user->id);
		$criteria->addCondition("t.member_id = m.id");
		
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.status',$this->status);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>9,
		    ),
			'sort' => array(
                'defaultOrder' => 't.id desc',
                'attributes' => array('')
            ),
		));
	}
	
	
	
	/**
     * 生成唯一编码
     * @return string
     */
    private function generateUniqueCode() {
        $code = str_pad(mt_rand(), self::FRANCHISEE_CODE_LENGTH, '0', STR_PAD_LEFT);
        if ($this->exists('code = :code', array('code' => $code)))
            $this->generateUniqueCode();
        return $code;
    }
    
    /**
     * 生成的密码哈希.
     * @param string $password
     * @return string $hash
     */
    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password . $this->salt);
    }
    
 	public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->salt = Tool::generateSalt();
                $this->password = $this->hashPassword($this->password);
                $this->code = $this->generateUniqueCode();
                $this->create_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
                $this->author_id = Yii::app()->user->id;
                $this->author_name = Yii::app()->user->name;
               	$this->create_time = time();
               	$this->status = self::STATUS_DISABLED;
            } else {
                if (!empty($this->password)){
//                	$this->salt = Tool::generateSalt();
                	$this->password = $this->hashPassword($this->password);
                }else{
                    $this->password = $this->find('id = :id', array('id' => $this->id))->password;
                }
                $this->update_time = time();
                $this->update_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
            }
            
            //替换正式会员主键号
            $sql = "select id from ".Member::model()->tableName()." where gai_number = '".$this->member_id."' limit 1";
            $member = Yii::app()->db->createCommand($sql)->queryRow();
            $this->member_id = $member['id'];
               	
            //保存缩略图
//            $paths = explode('|',$this->path);
//            if (!empty($paths)) {
//             	//删除旧的缩略图关系
//				if (!$this->isNewRecord) FranchiseePicture::model()->deleteAll("target_id={$this->id}");
//                foreach($paths as $path){
//                		$fp = new FranchiseePicture();
//                		$fp->target_id = $this->id;
//                		$fp->path = $path;
//                		$fp->save();
//                }
//            }
            
            return true;
        } else
            return false;
    }
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Franchisee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public static function getBizInfo($id)
	{   
		$tn = self::model()->tableName();
		$sql = "select t.*,m.gai_number from $tn t left join ".Member::model()->tableName()." m on m.id=t.member_id where t.id=$id";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		return $data;
	}
}
