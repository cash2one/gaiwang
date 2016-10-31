<?php

/**
 * This is the model class for table "{{common_account_agent_dist}}".
 *
 * The followings are the available columns in table '{{common_account_agent_dist}}':
 * @property string $id
 * @property string $common_account_id
 * @property string $dist_money
 * @property string $remainder_money
 * @property string $province_id
 * @property string $province_member_id
 * @property string $province_money
 * @property integer $province_ratio
 * @property string $city_id
 * @property string $city_member_id
 * @property string $city_money
 * @property integer $city_ratio
 * @property string $district_id
 * @property string $district_member_id
 * @property string $district_money
 * @property integer $district_ratio
 * @property string $create_time
 */
class CommonAccountAgentDist extends CActiveRecord {

    public $endTime, $endDistMoney;
    
    public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel时的分页参数名
    public $exportLimit = 5000; //导出excel长度

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{common_account_agent_dist}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('common_account_id, dist_money, remainder_money, province_id, province_member_id, province_money, province_ratio, city_id, city_member_id, city_money, city_ratio, district_id, district_member_id, district_money, district_ratio,manage_id,manage_member_id,manage_money,manage_ratio,create_time', 'required'),
            array('province_ratio, city_ratio, district_ratio,manage_ratio', 'numerical', 'integerOnly' => true),
            array('common_account_id, province_id, province_member_id, city_id, city_member_id, district_id, district_member_id,manage_id,manage_member_id, create_time', 'length', 'max' => 11),
            array('dist_money, remainder_money, province_money, city_money, district_money, manage_money', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, common_account_id, dist_money, remainder_money, province_id, province_member_id, province_money, province_ratio, city_id, city_member_id, city_money, city_ratio, district_id, district_member_id, district_money, district_ratio,manage_id,manage_member_id,manage_money,manage_ratio, create_time, endTime, endDistMoney', 'safe', 'on' => 'search,searchExport'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'common_account' => array(self::BELONGS_TO, 'CommonAccount', 'common_account_id'),
            'member_province' => array(self::BELONGS_TO, 'Member', 'province_member_id'),
            'member_city' => array(self::BELONGS_TO, 'Member', 'city_member_id'),
            'member_district' => array(self::BELONGS_TO, 'Member', 'district_member_id'),
            'member_manage'=>array(self::BELONGS_TO,'Member','manage_member_id'),
            'province' => array(self::BELONGS_TO, 'Region', 'province_id'),
            'city' => array(self::BELONGS_TO, 'Region', 'city_id'),
            'district' => array(self::BELONGS_TO, 'Region', 'district_id'),
            'manage'=>array(self::BELONGS_TO,'RegionManage','manage_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '主键',
            'common_account_id' => Yii::t('commonAccountAgentDist', '帐号名称'),
            'dist_money' => '分配金额',
            'remainder_money' => '剩余金额',
            'province_id' => '省份',
            'province_member_id' => '省代理的id',
            'province_money' => '省代理分配的金额',
            'province_ratio' => '省代理的实际分配比率',
            'city_id' => '市',
            'city_member_id' => '市代理的id',
            'city_money' => '市代理分配的金额',
            'city_ratio' => '市代理的实际分配比率',
            'district_id' => '区',
            'district_member_id' => '区代理的id',
            'district_money' => '区代理分配的金额',
            'district_ratio' => '区代理的实际分配比率',
            'manage_id'=>'大区',
            'manage_member_id'=>'大区代理的id',
            'manage_money'=>'大区代理分配的金额',
            'manage_ratio'=>'大区代理的实际分配比率',
            'create_time' => Yii::t('commonAccountAgentDist', '分配时间'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.dist_money,t.remainder_money,t.create_time,t.province_money,t.province_member_id,t.province_ratio,t.city_money,t.city_member_id,t.city_ratio,t.district_money,t.district_member_id,t.district_ratio,t.manage_money,t.manage_ratio,t.manage_member_id';
        $criteria->with = array(
            'common_account' => array('select' => 'name'),
            'member_province' => array('select' => 'gai_number'),
            'member_city' => array('select' => 'gai_number'),
            'member_district' => array('select' => 'gai_number'),
            'member_manage'=>array('select'=>'gai_number'),
            'province' => array('select' => 'name'),
            'city' => array('select' => 'name'),
            'district' => array('select' => 'name'),
            'manage'=>array('select'=>'name'),
        );

//        $criteria->addCondition('common_account.type=' . CommonAccount::TYPE_AGENT);
        $criteria->compare('common_account.name', $this->common_account_id, true);
        $criteria->compare('t.dist_money', '>=' . $this->dist_money);
        $criteria->compare('t.dist_money', '<=' . $this->endDistMoney);
        $start_time = strtotime($this->create_time);
        $end_time = strtotime($this->endTime);
        $criteria->compare('t.create_time', '>=' . $start_time);
        $criteria->compare('t.create_time', '<=' . $end_time);

        $criteria->order = 'create_time desc';

        return $criteria;
    }
    
    
    
	public function searchExport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.dist_money,t.remainder_money,t.create_time,t.province_money,t.province_member_id,t.province_ratio,t.city_money,t.city_member_id,t.city_ratio,t.district_money,t.district_member_id,t.district_ratio,t.manage_money,t.manage_ratio,t.manage_member_id';
        $criteria->with = array(
            'common_account' => array('select' => 'name'),
            'member_province' => array('select' => 'gai_number'),
            'member_city' => array('select' => 'gai_number'),
            'member_district' => array('select' => 'gai_number'),
              'member_manage'=>array('select'=>'gai_number'),
            'province' => array('select' => 'name'),
            'city' => array('select' => 'name'),
            'district' => array('select' => 'name'),
              'manage'=>array('select'=>'name'),
        );

//        $criteria->addCondition('common_account.type=' . CommonAccount::TYPE_AGENT);
        $criteria->compare('common_account.name', $this->common_account_id, true);
        $criteria->compare('t.dist_money', '>=' . $this->dist_money);
        $criteria->compare('t.dist_money', '<=' . $this->endDistMoney);
        $start_time = strtotime($this->create_time);
        $end_time = strtotime($this->endTime);
        $criteria->compare('t.create_time', '>=' . $start_time);
        $criteria->compare('t.create_time', '<=' . $end_time);

        $criteria->order = 'create_time desc';

        $pagination = array(
            'pageSize' => 10, //分页
        );
        
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }
    

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CommonAccountAgentDist the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 总后台-代理管理-代理列表-生成操作按钮
     */
    public static function createButtons($id) {
        $string = '';
        if (Yii::app()->user->checkAccess('CommonAccountAgentDist.AjaxUpdateAgent'))
            $string .= '<a href="javascript:do_Edit(' . $id . ')">【更新代理】</a>';
        if (Yii::app()->user->checkAccess('CommonAccountAgentDist.RemoveAgent'))
            $string .= '<a href="javascript:do_Remove(' . $id . ')">【移除代理】</a>';
        return $string;
    }

    /**
     * 后台-代理管理-代理账户列表-获取分配的信息
     */
    public static function distribute($model) {
        $agent_dist_info = array();  //保存代理分配
        $agentConfig_district = self::getAgentConfig('district');  //区代理的比例
        $agentConfig_city = self::getAgentConfig('city');    //市代理的比例
        $agentConfig_province = self::getAgentConfig('province');  //省代理的比例

        $agentEnterprise = array();
        self::getAgentInfo($model->city_id, $agentEnterprise);

        $agentConfig_district__real = 0;
        if (isset($agentEnterprise[3]) && $agentEnterprise[3]['gai_number'] != '') {
            $agentConfig_district__real = $agentConfig_district;
            $agentEnterprise[3]['ratio'] = $agentConfig_district__real;
        }

        $agentConfig_city__real = 0;
        if (isset($agentEnterprise[2]) && $agentEnterprise[2]['gai_number'] != '') {
            $agentConfig_city__real = $agentConfig_city - $agentConfig_district__real;
            $agentEnterprise[2]['ratio'] = $agentConfig_city__real;
        }

        $agentConfig_province__real = 0;
        if (isset($agentEnterprise[1]) && $agentEnterprise[1]['gai_number'] != '') {
            $agentConfig_province__real = $agentConfig_province - $agentConfig_city__real - $agentConfig_district__real;
            $agentEnterprise[1]['ratio'] = $agentConfig_province__real;
        }

        if (isset($agentEnterprise[1]))
            $agent_dist_info[] = $agentEnterprise[1];
        if (isset($agentEnterprise[2]))
            $agent_dist_info[] = $agentEnterprise[2];
        if (isset($agentEnterprise[3]))
            $agent_dist_info[] = $agentEnterprise[3];
        return $agent_dist_info;
    }

	/**
     * 后台-代理管理-代理账户列表-分配金额-正式分配
     */
    public static function distributeSure($id, $money) {
    	if ($money<=0){
    		$result['error'] = 1;
            $result['content'] = Yii::t('commonAccountAgentDist', '分配失败：分配金额错误！');
            return $result;
    	}
    	$transaction = Yii::app()->db->beginTransaction();
    	try {
	        $model = CommonAccount::model()->findByPk($id);
	        $result = array('error' => 0, 'content' => Yii::t('commonAccountAgentDist', '分配成功'));
	        if ($money > $model->cash) {
	            $result['error'] = 1;
	            $result['content'] = Yii::t('commonAccountAgentDist', '分配失败：分配金额错误！');
	            return $result;
	        } else {
	        	//初始化公共表
	        	$accountFlowTable = AccountFlow::model()->tableName();							//流水记录表
	        	$commonAccountAgentDistTable = CommonAccountAgentDist::model()->tableName();	//代理分配记录表 
	        	$region_table = Region::model()->tableName();									//区域表
	        	$member_table = Member::model()->tableName();									//会员表
	        	$wealthTable = Wealth::model()->tableName();									//旧日志表
	        	
	        	//初始化变量数据
	        	$time = time();
	        	$ip = Tool::getIP();
	        	
	        	//初始化配置数据
	        	$offConsume = IntegralOfflineNew::getConfig('offConsume')/100;		//消费者
	        	$official_rate = IntegralOfflineNew::$member_type_rate['official'];
				$default_rate = IntegralOfflineNew::$member_type_rate['default'];
				$default_type = IntegralOfflineNew::$member_type_rate['defaultType'];
		
	        	$agent_district_money = 0;
				$agent_city_money = 0;
				$agent_province_money = 0;
				
				$agentConfig_district = IntegralOfflineNew::getAgentConfig('district');		//区代理的比例
				$agentConfig_city = IntegralOfflineNew::getAgentConfig('city');				//市代理的比例
				$agentConfig_province = IntegralOfflineNew::getAgentConfig('province');		//省代理的比例
				
        		//区
			    $sql = "select t.id,t.parent_id,t.member_id,t.name,pm.username,m.gai_number,pm.type_id 
			    from $region_table t 
			    left join $member_table m on m.id = t.member_id 
			    left join $member_table pm on pm.id = m.pid 
			    where t.id = ".$model->city_id;
			    $agent_district = Yii::app()->db->createCommand($sql)->queryRow();
			    $agent_district['member_id'] = $agent_district['member_id'] == "" ? 0 : $agent_district['member_id'];
			    //市
			    $sql = "select t.id,t.parent_id,t.member_id,t.name,pm.username,m.gai_number,pm.type_id 
			    from $region_table t 
			    left join $member_table m on m.id = t.member_id 
			    left join $member_table pm on pm.id = m.pid 
			    where t.id = ".$agent_district['parent_id'];
			    $agent_city = Yii::app()->db->createCommand($sql)->queryRow();
			    $agent_city['member_id'] = $agent_city['member_id'] == "" ? 0 : $agent_city['member_id'];
			    //省
			    $sql = "select t.id,t.member_id,t.name,m.username,m.gai_number,m.type_id 
			    from $region_table t 
			    left join $member_table m on m.id = t.member_id 
			    left join $member_table pm on pm.id = m.pid 
			    where t.id = ".$agent_city['parent_id'];
			    $agent_province = Yii::app()->db->createCommand($sql)->queryRow();
			    $agent_province['member_id'] = $agent_province['member_id'] == "" ? 0 : $agent_province['member_id'];
        
        		
			    //获取比例
				$agentConfig_district = $agent_district['member_id'] == 0 ? 0 : $agentConfig_district;
				$agentConfig_city = $agent_city['member_id'] == 0 ? 0 : $agentConfig_city - $agentConfig_district;
				$agentConfig_province = $agent_province['member_id'] == 0 ? 0 : $agentConfig_province - ($agentConfig_city + $agentConfig_district);
					
				//获取金额
				$agent_district_money = IntegralOfflineNew::getNumberFormat($money * $agentConfig_district / 100);			//区代理金额
				$agent_city_money = IntegralOfflineNew::getNumberFormat($money * $agentConfig_city / 100);					//市代理金额
				$agent_province_money = IntegralOfflineNew::getNumberFormat($money * $agentConfig_province / 100);			//省代理金额
				$agent_less_money = $money - ($agent_district_money + $agent_city_money + $agent_province_money);			//盖网代理金额
					
	        	//设定代理公共帐号信息
	        	$agent_data['id'] = $model->id;
				$agent_data['name'] = $model->name;
	
	        	//插入代理分配记录表,获取插入记录编号
				$agents_total = array(
					'common_account_id'=>$model->id,
					'dist_money'=>$money,
					'remainder_money'=>$agent_less_money,
					'province_id'=>$agent_province['id'],
					'province_member_id'=>$agent_province['member_id'],
					'province_money'=>$agent_province_money,
					'province_ratio'=>$agentConfig_province,
					'city_id'=>$agent_city['id'],
					'city_member_id'=>$agent_city['member_id'],
					'city_money'=>$agent_city_money,
					'city_ratio'=>$agentConfig_city,
					'district_id'=>$agent_district['id'],
					'district_member_id'=>$agent_district['member_id'],
					'district_money'=>$agent_district_money,
					'district_ratio'=>$agentConfig_district,
					'create_time'=>$time,
				);
				
				Yii::app()->db->createCommand()->insert($commonAccountAgentDistTable, $agents_total);
				$commont_account_dist_table_insert_id = Yii::app()->db->getLastInsertID();			//代理分配记录编号
				$serial_number = 'AD'.time().$commont_account_dist_table_insert_id;					//流水号
				
				//--------------------------------------------代理公共账户扣钱用于分配-------------------------------------------
				//获取公共账户余额
				$agentBalance = AccountBalance::findAccountBalance(array(
		    		'account_id'=>$model->id,
					'name'=>$model->name,
		    		'owner_type'=>AccountFlow::OWNER_COMMON_ACCOUNT
		    	));
		    	
		    	//更新公共账户余额
				$newAgentBalance = AccountBalance::updateAccountBalance($agentBalance,$money,AccountBalance::OFFLINE_COMMON_ACOUNT_DEDUCT);	
				
				$agentRemark = "代理公共账户分配扣减金额：$money";
				
		    	//插入流水表数据
		    	$accountFlowData = array(
		    		'account_id'=>$agentBalance['account_id'],
		    		'account_name'=>$agentBalance['name'],
		    		'credit_amount'=>$money,	
		    		'create_time'=>$time,
		    		'debit_previous_amount_cash'=>$agentBalance['debit_today_amount_cash'],
		    		'credit_previous_amount_cash'=>$agentBalance['credit_today_amount_cash'],
		    		'debit_current_amount_cash'=>$newAgentBalance['debit_today_amount_cash'],
		    		'credit_current_amount_cash'=>$newAgentBalance['credit_today_amount_cash'],
		    		'debit_previous_amount_nocash'=>$agentBalance['debit_today_amount_nocash'],
		    		'credit_previous_amount_nocash'=>$agentBalance['credit_today_amount_nocash'],
		    		'debit_current_amount_nocash'=>$newAgentBalance['debit_today_amount_nocash'],
		    		'credit_current_amount_nocash'=>$newAgentBalance['credit_today_amount_nocash'],
		    		'debit_previous_amount'=>$agentBalance['debit_today_amount'],
		    		'credit_previous_amount'=>$agentBalance['today_amount'],
		    		'debit_current_amount'=>$newAgentBalance['debit_today_amount'],
		    		'credit_current_amount'=>$newAgentBalance['today_amount'],
		    		'debit_previous_amount_frezee'=>$agentBalance['debit_today_amount_frezee'],
		    		'credit_previous_amount_frezee'=>$agentBalance['credit_today_amount_frezee'],
		    		'debit_current_amount_frezee'=>$newAgentBalance['debit_today_amount_frezee'],
		    		'credit_current_amount_frezee'=>$newAgentBalance['credit_today_amount_frezee'],
		    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
		    		'target_id'=>$commont_account_dist_table_insert_id,
		    		'owner_type'=>$agentBalance['owner_type'],
		    		'income_type'=>AccountFlow::TYPE_CASH,
		    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
		    		'remark'=>$agentRemark,	
		    		'serial_number'=>$serial_number,
		    	);
		    	//插入流水表
		    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
		    	
				//插入旧的日志
				$wealthData = array(
					'owner'=>AccountFlow::OWNER_COMMON_ACCOUNT,
					'member_id'=>$agentBalance['id'],
					'gai_number'=>$agentBalance['name'],
					'type_id'=>AccountFlow::TYPE_CASH,
					'score'=>0,
					'money'=>$money,
					'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
					'target_id'=>$commont_account_dist_table_insert_id,
					'content'=>$agentRemark,
					'create_time'=>$time,			//是$data['create_time']  还是time()
					'ip'=>$ip,
					'status'=>Wealth::STATUS_YES,
				);
				Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
	            //-----------------------------------------代理公共账户扣钱用于分配（结束）--------------------------------------------------
	            
				//-----------------------------------------代理暂存账户扣钱-----------------------------------------------
				//获取代理暂存账户
				$agentDis = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_AGENT_TEMP,$model->city_id);
				//获取公共账户余额
				$agentDisBalance = AccountBalance::findAccountBalance(array(
		    		'account_id'=>$agentDis['id'],
					'name'=>$agentDis['name'],
		    		'owner_type'=>AccountFlow::OWNER_COMMON_ACCOUNT
		    	));
		    	
		    	//更新公共账户余额
				$newAgentDisBalance = AccountBalance::updateAccountBalance($agentDisBalance,$money,AccountBalance::OFFLINE_COMMON_ACOUNT_DEDUCT);	
				
				$agentRemark = "代理公共账户分配扣减金额：$money";
				
		    	//插入流水表数据
		    	$accountFlowData = array(
		    		'account_id'=>$agentDisBalance['account_id'],
		    		'account_name'=>$agentDisBalance['name'],
		    		'debit_amount'=>$money,	
		    		'create_time'=>$time,
		    		'debit_previous_amount_cash'=>$agentDisBalance['debit_today_amount_cash'],
		    		'credit_previous_amount_cash'=>$agentDisBalance['credit_today_amount_cash'],
		    		'debit_current_amount_cash'=>$newAgentDisBalance['debit_today_amount_cash'],
		    		'credit_current_amount_cash'=>$newAgentDisBalance['credit_today_amount_cash'],
		    		'debit_previous_amount_nocash'=>$agentDisBalance['debit_today_amount_nocash'],
		    		'credit_previous_amount_nocash'=>$agentDisBalance['credit_today_amount_nocash'],
		    		'debit_current_amount_nocash'=>$newAgentDisBalance['debit_today_amount_nocash'],
		    		'credit_current_amount_nocash'=>$newAgentDisBalance['credit_today_amount_nocash'],
		    		'debit_previous_amount'=>$agentDisBalance['debit_today_amount'],
		    		'credit_previous_amount'=>$agentDisBalance['today_amount'],
		    		'debit_current_amount'=>$newAgentDisBalance['debit_today_amount'],
		    		'credit_current_amount'=>$newAgentDisBalance['today_amount'],
		    		'debit_previous_amount_frezee'=>$agentDisBalance['debit_today_amount_frezee'],
		    		'credit_previous_amount_frezee'=>$agentDisBalance['credit_today_amount_frezee'],
		    		'debit_current_amount_frezee'=>$newAgentDisBalance['debit_today_amount_frezee'],
		    		'credit_current_amount_frezee'=>$newAgentDisBalance['credit_today_amount_frezee'],
		    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
		    		'target_id'=>$commont_account_dist_table_insert_id,
		    		'owner_type'=>$agentDisBalance['owner_type'],
		    		'income_type'=>AccountFlow::TYPE_CASH,
		    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
		    		'remark'=>$agentRemark,	
		    		'serial_number'=>$serial_number,
		    	);
		    	//插入流水表
		    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
		    	
				//插入旧的日志
				$wealthData = array(
					'owner'=>AccountFlow::OWNER_COMMON_ACCOUNT,
					'member_id'=>$agentDisBalance['id'],
					'gai_number'=>$agentDisBalance['name'],
					'type_id'=>AccountFlow::TYPE_CASH,
					'score'=>0,
					'money'=>$money,
					'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
					'target_id'=>$commont_account_dist_table_insert_id,
					'content'=>$agentRemark,
					'create_time'=>$time,			//是$data['create_time']  还是time()
					'ip'=>$ip,
					'status'=>Wealth::STATUS_YES,
				);
				Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
				//-----------------------------------------代理暂存账户扣钱(结束)-----------------------------------------------
				
				//-----------------------------------------代理暂存帐号加钱------------------------------------------
				//获取公共账户余额
				$agentDisBalance = AccountBalance::findAccountBalance(array(
		    		'account_id'=>$agentDis['id'],
					'name'=>$agentDis['name'],
		    		'owner_type'=>AccountFlow::OWNER_COMMON_ACCOUNT
		    	));
		    	
		    	//更新公共账户余额
				$newAgentDisBalance = AccountBalance::updateAccountBalance($agentDisBalance,$money,AccountBalance::OFFLINE_COMMON_ACOUNT);	
				
				$agentDisRemark = "代理分配金额，代理暂存账户加钱：$money";
				
		    	//插入流水表数据
		    	$accountFlowData = array(
		    		'account_id'=>$agentDisBalance['account_id'],
		    		'account_name'=>$agentDisBalance['name'],
		    		'debit_amount'=>$money,	
		    		'create_time'=>$time,
		    		'debit_previous_amount_cash'=>$agentDisBalance['debit_today_amount_cash'],
		    		'credit_previous_amount_cash'=>$agentDisBalance['credit_today_amount_cash'],
		    		'debit_current_amount_cash'=>$newAgentDisBalance['debit_today_amount_cash'],
		    		'credit_current_amount_cash'=>$newAgentDisBalance['credit_today_amount_cash'],
		    		'debit_previous_amount_nocash'=>$agentDisBalance['debit_today_amount_nocash'],
		    		'credit_previous_amount_nocash'=>$agentDisBalance['credit_today_amount_nocash'],
		    		'debit_current_amount_nocash'=>$newAgentDisBalance['debit_today_amount_nocash'],
		    		'credit_current_amount_nocash'=>$newAgentDisBalance['credit_today_amount_nocash'],
		    		'debit_previous_amount'=>$agentDisBalance['debit_today_amount'],
		    		'credit_previous_amount'=>$agentDisBalance['today_amount'],
		    		'debit_current_amount'=>$newAgentDisBalance['debit_today_amount'],
		    		'credit_current_amount'=>$newAgentDisBalance['today_amount'],
		    		'debit_previous_amount_frezee'=>$agentDisBalance['debit_today_amount_frezee'],
		    		'credit_previous_amount_frezee'=>$agentDisBalance['credit_today_amount_frezee'],
		    		'debit_current_amount_frezee'=>$newAgentDisBalance['debit_today_amount_frezee'],
		    		'credit_current_amount_frezee'=>$newAgentDisBalance['credit_today_amount_frezee'],
		    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
		    		'target_id'=>$commont_account_dist_table_insert_id,
		    		'owner_type'=>$agentDisBalance['owner_type'],
		    		'income_type'=>AccountFlow::TYPE_CASH,
		    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
		    		'remark'=>$agentDisRemark,	
		    		'serial_number'=>$serial_number,
		    	);
		    	//插入流水表
		    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
		    	
				//插入旧的日志
				$wealthData = array(
					'owner'=>AccountFlow::OWNER_COMMON_ACCOUNT,
					'member_id'=>$agentDisBalance['id'],
					'gai_number'=>$agentDisBalance['name'],
					'type_id'=>AccountFlow::TYPE_CASH,
					'score'=>0,
					'money'=>$money,
					'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
					'target_id'=>$commont_account_dist_table_insert_id,
					'content'=>$agentDisRemark,
					'create_time'=>$time,			//是$data['create_time']  还是time()
					'ip'=>$ip,
					'status'=>Wealth::STATUS_YES,
				);
				Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
				//-----------------------------------------代理暂存帐号加钱（结束）------------------------------------------
				
				//-----------------------------------------给代理省市区加钱------------------------------------------------
		        //代理余额
		        if ($agent_less_money > 0){
		        	//查看是否存在代理账号余额信息，没有就创建
					$agentBalance = AccountBalance::findAccountBalance(array(
			    		'account_id'=>$model->id,
						'name'=>$model->name,
			    		'owner_type'=>AccountFlow::OWNER_COMMON_ACCOUNT
			    	));
					
					$newAgentBalance = AccountBalance::updateAccountBalance($agentBalance,$agent_less_money,AccountBalance::OFFLINE_COMMON_ACOUNT);	
					
					//向账目流水表中插入记录
					$remark = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_CONTENT, array(
                        $model->name, $money, $agent_less_money, $money - $agent_less_money
            		));
			    	//插入流水表数据
			    	$accountFlowData = array(
			    		'account_id'=>$agentBalance['account_id'],
			    		'account_name'=>$agentBalance['name'],
			    		'credit_amount'=>$agent_less_money,	
			    		'create_time'=>$time,
			    		'debit_previous_amount_cash'=>$agentBalance['debit_today_amount_cash'],
			    		'credit_previous_amount_cash'=>$agentBalance['credit_today_amount_cash'],
			    		'debit_current_amount_cash'=>$newAgentBalance['debit_today_amount_cash'],
			    		'credit_current_amount_cash'=>$newAgentBalance['credit_today_amount_cash'],
			    		'debit_previous_amount_nocash'=>$agentBalance['debit_today_amount_nocash'],
			    		'credit_previous_amount_nocash'=>$agentBalance['credit_today_amount_nocash'],
			    		'debit_current_amount_nocash'=>$newAgentBalance['debit_today_amount_nocash'],
			    		'credit_current_amount_nocash'=>$newAgentBalance['credit_today_amount_nocash'],
			    		'debit_previous_amount'=>$agentBalance['debit_today_amount'],
			    		'credit_previous_amount'=>$agentBalance['today_amount'],
			    		'debit_current_amount'=>$newAgentBalance['debit_today_amount'],
			    		'credit_current_amount'=>$newAgentBalance['today_amount'],
			    		'debit_previous_amount_frezee'=>$agentBalance['debit_today_amount_frezee'],
			    		'credit_previous_amount_frezee'=>$agentBalance['credit_today_amount_frezee'],
			    		'debit_current_amount_frezee'=>$newAgentBalance['debit_today_amount_frezee'],
			    		'credit_current_amount_frezee'=>$newAgentBalance['credit_today_amount_frezee'],
			    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
			    		'target_id'=>$commont_account_dist_table_insert_id,
			    		'owner_type'=>$agentBalance['owner_type'],
			    		'income_type'=>AccountFlow::TYPE_CASH,
			    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
			    		'remark'=>$remark,	
			    		'serial_number'=>$serial_number,
			    	);
			    	//插入流水表
			    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
					
					//插入旧的日志
					$wealthData = array(
						'owner'=>AccountFlow::OWNER_COMMON_ACCOUNT,
						'member_id'=>$agentBalance['id'],
						'gai_number'=>$agentBalance['name'],
						'type_id'=>AccountFlow::TYPE_CASH,
						'score'=>0,
						'money'=>$money,
						'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
						'target_id'=>$commont_account_dist_table_insert_id,
						'content'=>$remark,
						'create_time'=>$time,
						'ip'=>$ip,
						'status'=>Wealth::STATUS_YES,
					);
					Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
		        }
		            
			    //区代理
			    if ($agent_district['member_id']&& $agent_district_money > 0){
			    	$agent_district_ratio = $agent_district['type_id'] == $default_type ? $default_rate : $official_rate;
			    	$agent_district_integral = IntegralOfflineNew::getNumberFormat($agent_district_money / $agent_district_ratio);
			    	//查看是否存在代理账号余额信息，没有就创建
			    	$agentBalance = AccountBalance::findAccountBalance(array(
			    		'account_id'=>$agent_district['member_id'],
						'gai_number'=>$agent_district['gai_number'],
						'name'=>$agent_district['username'],
			    		'owner_type'=>AccountFlow::OWNER_MEMBER
			    	));
					
					$newAgentBalance = AccountBalance::updateAccountBalance($agentBalance,$agent_district_money,AccountBalance::OFFLINE_TYPE_ADD,1);	//修改余额表中的余额和原表中的金额，同时要返回剩余余额
					
					$remark = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $model->name, $money, Region::getAgentLevel(3), $agent_district_integral
                	));
                	//插入流水表数据
			    	$accountFlowData = array(
			    		'account_id'=>$agentBalance['account_id'],
			    		'account_name'=>$agentBalance['name'],
			    		'gai_number'=>$agentBalance['gai_number'],
			    		'credit_amount'=>$agent_district_money,	
			    		'create_time'=>$time,
			    		'debit_previous_amount_cash'=>$agentBalance['debit_today_amount_cash'],
			    		'credit_previous_amount_cash'=>$agentBalance['credit_today_amount_cash'],
			    		'debit_current_amount_cash'=>$newAgentBalance['debit_today_amount_cash'],
			    		'credit_current_amount_cash'=>$newAgentBalance['credit_today_amount_cash'],
			    		'debit_previous_amount_nocash'=>$agentBalance['debit_today_amount_nocash'],
			    		'credit_previous_amount_nocash'=>$agentBalance['credit_today_amount_nocash'],
			    		'debit_current_amount_nocash'=>$newAgentBalance['debit_today_amount_nocash'],
			    		'credit_current_amount_nocash'=>$newAgentBalance['credit_today_amount_nocash'],
			    		'debit_previous_amount'=>$agentBalance['debit_today_amount'],
			    		'credit_previous_amount'=>$agentBalance['today_amount'],
			    		'debit_current_amount'=>$newAgentBalance['debit_today_amount'],
			    		'credit_current_amount'=>$newAgentBalance['today_amount'],
			    		'debit_previous_amount_frezee'=>$agentBalance['debit_today_amount_frezee'],
			    		'credit_previous_amount_frezee'=>$agentBalance['credit_today_amount_frezee'],
			    		'debit_current_amount_frezee'=>$newAgentBalance['debit_today_amount_frezee'],
			    		'credit_current_amount_frezee'=>$newAgentBalance['credit_today_amount_frezee'],
			    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
			    		'target_id'=>$commont_account_dist_table_insert_id,
			    		'owner_type'=>$agentBalance['owner_type'],
			    		'income_type'=>AccountFlow::TYPE_GAI,
			    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
			    		'ratio'=>$agent_district_ratio,
			    		'remark'=>$remark,	
			    		'serial_number'=>$serial_number,
			    	);
			    	//插入流水表
			    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
			    	
			    	$wealthData = array(
						'owner'=>AccountFlow::OWNER_MEMBER,
						'member_id'=>$agent_district['member_id'],
						'gai_number'=>$agent_district['gai_number'],
						'type_id'=>AccountFlow::TYPE_GAI,
						'score'=>$agent_district_integral,
						'money'=>$agent_district_money,
						'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
						'target_id'=>$commont_account_dist_table_insert_id,
						'content'=>$remark,
						'create_time'=>$time,
						'ip'=>$ip,
						'status'=>Wealth::STATUS_YES,
					);
					Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
			    }
			    	
			    //市代理
				if ($agent_city['member_id'] && $agent_city_money > 0){
					$agent_city_ratio = $agent_city['type_id'] == $default_type ? $default_rate : $official_rate;
				   	$agent_city_integral = IntegralOfflineNew::getNumberFormat($agent_city_money / $agent_city_ratio);
			    	//查看是否存在代理账号余额信息，没有就创建
			    	$agentBalance = AccountBalance::findAccountBalance(array(
			    		'account_id'=>$agent_city['member_id'],
						'gai_number'=>$agent_city['gai_number'],
						'name'=>$agent_city['username'],
			    		'owner_type'=>AccountFlow::OWNER_MEMBER
			    	));
					
					$newAgentBalance = AccountBalance::updateAccountBalance($agentBalance,$agent_city_money,AccountBalance::OFFLINE_TYPE_ADD,1);	//修改余额表中的余额和原表中的金额，同时要返回剩余余额
					
					$remark = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $model->name, $money, Region::getAgentLevel(2), $agent_city_integral
                	));
                	//插入流水表数据
			    	$accountFlowData = array(
			    		'account_id'=>$agentBalance['account_id'],
			    		'account_name'=>$agentBalance['name'],
			    		'gai_number'=>$agentBalance['gai_number'],
			    		'credit_amount'=>$agent_city_money,	
			    		'create_time'=>$time,
			    		'debit_previous_amount_cash'=>$agentBalance['debit_today_amount_cash'],
			    		'credit_previous_amount_cash'=>$agentBalance['credit_today_amount_cash'],
			    		'debit_current_amount_cash'=>$newAgentBalance['debit_today_amount_cash'],
			    		'credit_current_amount_cash'=>$newAgentBalance['credit_today_amount_cash'],
			    		'debit_previous_amount_nocash'=>$agentBalance['debit_today_amount_nocash'],
			    		'credit_previous_amount_nocash'=>$agentBalance['credit_today_amount_nocash'],
			    		'debit_current_amount_nocash'=>$newAgentBalance['debit_today_amount_nocash'],
			    		'credit_current_amount_nocash'=>$newAgentBalance['credit_today_amount_nocash'],
			    		'debit_previous_amount'=>$agentBalance['debit_today_amount'],
			    		'credit_previous_amount'=>$agentBalance['today_amount'],
			    		'debit_current_amount'=>$newAgentBalance['debit_today_amount'],
			    		'credit_current_amount'=>$newAgentBalance['today_amount'],
			    		'debit_previous_amount_frezee'=>$agentBalance['debit_today_amount_frezee'],
			    		'credit_previous_amount_frezee'=>$agentBalance['credit_today_amount_frezee'],
			    		'debit_current_amount_frezee'=>$newAgentBalance['debit_today_amount_frezee'],
			    		'credit_current_amount_frezee'=>$newAgentBalance['credit_today_amount_frezee'],
			    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
			    		'target_id'=>$commont_account_dist_table_insert_id,
			    		'owner_type'=>$agentBalance['owner_type'],
			    		'income_type'=>AccountFlow::TYPE_GAI,
			    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
			    		'ratio'=>$agent_city_ratio,
			    		'remark'=>$remark,	
			    		'serial_number'=>$serial_number,
			    	);
			    	//插入流水表
			    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
			    	
			    	$wealthData = array(
						'owner'=>AccountFlow::OWNER_MEMBER,
						'member_id'=>$agent_city['member_id'],
						'gai_number'=>$agent_city['gai_number'],
						'type_id'=>AccountFlow::TYPE_GAI,
						'score'=>$agent_city_integral,
						'money'=>$agent_city_money,
						'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
						'target_id'=>$commont_account_dist_table_insert_id,
						'content'=>$remark,
						'create_time'=>$time,
						'ip'=>$ip,
						'status'=>Wealth::STATUS_YES,
					);
					Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
				}
			    	
			    //省代理
			    if ($agent_province['member_id'] && $agent_province_money > 0){	
			    	$agent_province_ratio = $agent_province['type_id'] == $default_type ? $default_rate : $official_rate;
				   	$agent_province_integral = IntegralOfflineNew::getNumberFormat($agent_province_money / $agent_province_ratio);
			    	//查看是否存在代理账号余额信息，没有就创建
			    	$agentBalance = AccountBalance::findAccountBalance(array(
			    		'account_id'=>$agent_province['member_id'],
						'gai_number'=>$agent_province['gai_number'],
						'name'=>$agent_province['username'],
			    		'owner_type'=>AccountFlow::OWNER_MEMBER
			    	));
					
					$newAgentBalance = AccountBalance::updateAccountBalance($agentBalance,$agent_province_money,AccountBalance::OFFLINE_TYPE_ADD,1);	//修改余额表中的余额和原表中的金额，同时要返回剩余余额
					
					$remark = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $model->name, $money, Region::getAgentLevel(1), $agent_province_integral
                	));
                	//插入流水表数据
			    	$accountFlowData = array(
			    		'account_id'=>$agentBalance['account_id'],
			    		'account_name'=>$agentBalance['name'],
			    		'gai_number'=>$agentBalance['gai_number'],
			    		'credit_amount'=>$agent_province_money,	
			    		'create_time'=>$time,
			    		'debit_previous_amount_cash'=>$agentBalance['debit_today_amount_cash'],
			    		'credit_previous_amount_cash'=>$agentBalance['credit_today_amount_cash'],
			    		'debit_current_amount_cash'=>$newAgentBalance['debit_today_amount_cash'],
			    		'credit_current_amount_cash'=>$newAgentBalance['credit_today_amount_cash'],
			    		'debit_previous_amount_nocash'=>$agentBalance['debit_today_amount_nocash'],
			    		'credit_previous_amount_nocash'=>$agentBalance['credit_today_amount_nocash'],
			    		'debit_current_amount_nocash'=>$newAgentBalance['debit_today_amount_nocash'],
			    		'credit_current_amount_nocash'=>$newAgentBalance['credit_today_amount_nocash'],
			    		'debit_previous_amount'=>$agentBalance['debit_today_amount'],
			    		'credit_previous_amount'=>$agentBalance['today_amount'],
			    		'debit_current_amount'=>$newAgentBalance['debit_today_amount'],
			    		'credit_current_amount'=>$newAgentBalance['today_amount'],
			    		'debit_previous_amount_frezee'=>$agentBalance['debit_today_amount_frezee'],
			    		'credit_previous_amount_frezee'=>$agentBalance['credit_today_amount_frezee'],
			    		'debit_current_amount_frezee'=>$newAgentBalance['debit_today_amount_frezee'],
			    		'credit_current_amount_frezee'=>$newAgentBalance['credit_today_amount_frezee'],
			    		'operate_type'=>AccountFlow::OPERATE_TYPE_AGENT_DIS,
			    		'target_id'=>$commont_account_dist_table_insert_id,
			    		'owner_type'=>$agentBalance['owner_type'],
			    		'income_type'=>AccountFlow::TYPE_GAI,
			    		'score_source'=>AccountFlow::SOURCE_AGENT_ASSIGN,
			    		'ratio'=>$agent_province_ratio,
			    		'remark'=>$remark,	
			    		'serial_number'=>$serial_number,
			    	);
			    	//插入流水表
			    	Yii::app()->db->createCommand()->insert($accountFlowTable,$accountFlowData);
			    	
			    	$wealthData = array(
						'owner'=>AccountFlow::OWNER_MEMBER,
						'member_id'=>$agent_province['member_id'],
						'gai_number'=>$agent_province['gai_number'],
						'type_id'=>AccountFlow::TYPE_GAI,
						'score'=>$agent_province_integral,
						'money'=>$agent_province_money,
						'source_id'=>AccountFlow::SOURCE_AGENT_ASSIGN,
						'target_id'=>$commont_account_dist_table_insert_id,
						'content'=>$remark,
						'create_time'=>$time,
						'ip'=>$ip,
						'status'=>Wealth::STATUS_YES,
					);
					Yii::app()->db->createCommand()->insert($wealthTable,$wealthData);
			    }
			    //-----------------------------------代理省市区加钱结束----------------------------------
	        }
			$transaction->commit(); //提交事务会真正的执行数据库操作
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			return false;
		}

        $rs_content = $model->name . '账户分配金额¥' . $money . '成功！';
        $result['error'] = 0;
        $result['content'] = $rs_content;
        return $result;
    }
    
    /**
     * 后台-代理管理-代理账户列表-分配金额-正式分配
     */
    public static function distributeSure_bak($id, $money) {
        $model = CommonAccount::model()->findByPk($id);
        $result = array('error' => 0, 'content' => Yii::t('commonAccountAgentDist', '分配成功'));
        if ($money > $model->cash) {
            $result['error'] = 1;
            $result['content'] = Yii::t('commonAccountAgentDist', '分配失败：分配金额错误！');
            return $result;
        } else {
            $wealth_table = Wealth::model()->tableName();   //分配记录表
            $member_table = Member::model()->tableName();   //会员表
            $agentConfig_district = self::getAgentConfig('district');  //区代理的比例
            $agentConfig_city = self::getAgentConfig('city');    //市代理的比例
            $agentConfig_province = self::getAgentConfig('province');  //省代理的比例
            $user_ip = Tool::ip2int(Tool::getClientIP());
            $distribute = CommonAccountAgentDist::distribute($model);
            $moneyArr = CommonAccountAgentDist::getAgentMoney($distribute, $money);
            if ($moneyArr['remainder'] == $money) {
                $result['error'] = 1;
                $result['content'] = Yii::t('commonAccountAgentDist', '分配失败：代理会员不存在！');
                return $result;
            }
            $member_type_rate = MemberType::fileCache();
            $sql = "";
            $common_account_agent_dist = new CommonAccountAgentDist();
            $common_account_agent_dist->common_account_id = $model->id;
            $common_account_agent_dist->dist_money = $money;
            $common_account_agent_dist->remainder_money = $moneyArr['remainder'];
            $common_account_agent_dist->create_time = time();
            foreach ($distribute as $item) {
                if (isset($item['ratio']) && $item['ratio'] > 0) {
                    //增加积分
                    $member_integral = $moneyArr[$item['depth']] / $member_type_rate[$item['type_id']];
                    $member_integral = IntegralOffline::getNumberFormat($member_integral);
                    $member_dist_content = IntegralOffline::getContent(IntegralOffline::AGENT_DIST_MEMBER_CONTENT, array(
                                $model->name, $money, Region::getAgentLevel($item['depth']), $member_integral
                    ));
                    $sql .= "insert into $wealth_table(`owner`,`member_id`,`gai_number`,`type_id`,`score`,`money`,`source_id`,`target_id`,`content`,`create_time`,`ip`,`status`)value(";
                    $sql .= "'" . Wealth::OWNER_MEMBER . "','" . $item['member_id'] . "','" . $item['gai_number'] . "','" . Wealth::TYPE_GAI . "','" . $member_integral . "','" .
                            $moneyArr[$item['depth']] . "','" . Wealth::SOURCE_AGENT_ASSIGN . "','" . $model->id . "','" . $member_dist_content . "','" . time() . "','" . $user_ip . "','" . Wealth::STATUS_YES . "'";
                    $sql .= ");";  //插入分配记录
                    $sql .= "update $member_table set account_expense_cash = account_expense_cash+" . $moneyArr[$item['depth']] . " where id=" . $item['member_id'] . ";"; //给代理会员增加可提现金额
                }
                if ($item['depth'] == 1) { //省级
                    $common_account_agent_dist->province_id = $item['id'];
                    if (isset($item['member_id']))
                        $common_account_agent_dist->province_member_id = $item['member_id'];
                    $common_account_agent_dist->province_money = $moneyArr[$item['depth']];
                    if (isset($item['ratio']))
                        $common_account_agent_dist->province_ratio = $item['ratio'];
                }
                if ($item['depth'] == 2) { //市级
                    $common_account_agent_dist->city_id = $item['id'];
                    if (isset($item['member_id']))
                        $common_account_agent_dist->city_member_id = $item['member_id'];
                    $common_account_agent_dist->city_money = $moneyArr[$item['depth']];
                    if (isset($item['ratio']))
                        $common_account_agent_dist->city_ratio = $item['ratio'];
                }
                if ($item['depth'] == 3) { //区县级
                    $common_account_agent_dist->district_id = $item['id'];
                    if (isset($item['member_id']))
                        $common_account_agent_dist->district_member_id = $item['member_id'];
                    $common_account_agent_dist->district_money = $moneyArr[$item['depth']];
                    if (isset($item['ratio']))
                        $common_account_agent_dist->district_ratio = $item['ratio'];
                }
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $common_account_agent_dist->save(false);
                //将剩余金额插入到代理公共账户
                $model->cash = $model->cash - $money + $moneyArr['remainder'];  //代理公共账户金额
                $model->update();
                $transaction->commit(); //提交事务会真正的执行数据库操作
            } catch (Exception $e) {

                $transaction->rollback(); //如果操作失败, 数据回滚
                return false;
            }

            $agent_dist_content = IntegralOffline::getContent(IntegralOffline::AGENT_DIST_CONTENT, array(
                        $model->name, $money, $moneyArr['remainder'], $money - $moneyArr['remainder']
            ));
            $sql .= "insert into $wealth_table(`owner`,`member_id`,`gai_number`,`type_id`,`score`,`money`,`source_id`,`target_id`,`content`,`create_time`,`ip`,`status`)value(";
            $sql .= "'0','" . $model->id . "','" . $model->name . "','" . Wealth::TYPE_CASH . "','0','" .
                    ($moneyArr['remainder'] - $money) . "','" . Wealth::SOURCE_AGENT_ASSIGN . "','" . $common_account_agent_dist->id . "','" . $agent_dist_content . "','" . time() . "','" . $user_ip . "','" . Wealth::STATUS_YES . "'";
            $sql .= ");";  //插入分配记录
            Yii::app()->db->createCommand($sql)->execute();
            $rs_content = $model->name . '账户分配金额¥' . $money . '成功！';
            $result['error'] = 0;
            $result['content'] = $rs_content;
            return $result;
        }
    }

    /**
     * 后台-代理管理-代理账户列表-分配金额-得到各级代理的分配金额和剩余金额
     */
    public static function getAgentMoney($arr, $money) {
        $moneyArr = array();
        $dist_money = 0;
        foreach ($arr as $item) {
            $ratio = isset($item['ratio']) ? $item['ratio'] : 0;
            $moneyArr[$item['depth']] = IntegralOffline::getNumberFormat($money * $ratio / 100);
            $dist_money += $moneyArr[$item['depth']];
        }
        $moneyArr['remainder'] = $money - $dist_money;
        return $moneyArr;
    }

    /**
     * 获取代理分配值
     */
    public static $agentConfig;

    public static function getAgentConfig($key = null) {
        if (self::$agentConfig !== null) {
            return $key === null ? self::$agentConfig : self::$agentConfig[$key];
        }
        self::$agentConfig = Tool::getConfig($name = 'agentdist');
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'agentdist.config.inc';
//        self::$agentConfig = unserialize(base64_decode(file_get_contents($file)));
        return $key === null ? self::$agentConfig : self::$agentConfig[$key];
    }

    /**
     * 根据id获取代理的信息
     */
    public static function getAgentInfo($city_id, &$info = array()) {
        $tn = Region::model()->tableName();
        $member_table = Member::model()->tableName();
        $sql = "select t.id,t.parent_id, t.name, t.depth,m.id as member_id,m.gai_number,m.username,m.mobile,m.type_id from $tn t left join $member_table m on m.id=t.member_id where t.id=$city_id";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        $info[$rs['depth']] = $rs;
        if ($rs['depth'] > 1) {
            self::getAgentInfo($rs['parent_id'], $info);
        }
    }

}
