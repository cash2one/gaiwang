<?php 
/**
 * 重写对账类
 * @author lhao
 */
class OfflineAccount extends IntegralOfflineNew
{
    /**
     * 对账
     * @param array $record
     * @param int $is_auto
     * @throws Exception
     * @throws ErrorException
     * @return boolean
     */
    public static function balanceAccount($record_id,$is_auto =  FranchiseeConsumptionRecord::HANDLE_CHECK)
    {
        try {
            //创建相关流水表
            $account_flow_table = AccountFlow::monthTable();
            self::$time = time();
            $time = time();
            $gw = Yii::app()->db;
            $gt = Yii::app()->gt;
            $reconrd_table = FranchiseeConsumptionRecord::model()->tableName();
            //开启事务
            $transaction =$gw->beginTransaction();
            //获取交易记录信息，行锁
            $sql_record = "select * from $reconrd_table where id = $record_id for update";
            $record = Yii::app()->db->createCommand($sql_record)->queryRow();
            
            
            if (empty($record)) {
                self::throwErrorMessage('该交易记录不存在');
            } else if ($record['status'] != FranchiseeConsumptionRecord::STATUS_NOTCHECK) {
                $error = $record['status'] == FranchiseeConsumptionRecord::STATUS_CHECKED ? "对账通过失败,该交易记录已对账" : "对账通过失败,该交易记录已撤销";
                self::throwErrorMessage($error);
            }
            if($record['spend_money']<=0)
                self::throwErrorMessage('该交易金额少于等于0');
            
            $member_table = Member::model()->tableName();
            $frachisee_table = Franchisee::model()->tableName();
            $region_table = Region::model()->tableName();//地区表表
            if(!isset($record['record_type']))
                 self::throwErrorMessage('record_type参数错误');
            
            $machine = OfflineMachines::getMachineByType($record['machine_id'], $record['record_type'],array(FranchiseeConsumptionRecord::RECORD_TYPE_POINT=>array('intro_member_id')));
            if (empty($machine)) throw new Exception(Yii::t("IntrgralOfflineNew", '该线下机器不存在，消费记录异常'));
            
            $memberData = Yii::app()->db->createCommand()
                            ->select('gai_number,type_id,mobile,referrals_id')
                            ->from($member_table)
                            ->where('id = :id', array(':id' => $record['member_id']))
                            ->queryRow();
            if (empty($memberData)) self::throwErrorMessage('未获取到消费会员信息，消费记录异常');
            
            
            //获取加盟商相关数据
            $franchiseeData = Yii::app()->db->createCommand()
                        ->select('name as franchisee_name,gai_discount,member_discount,province_id,city_id,district_id,street as address,member_id as franchisee_member_id')
                        ->from($frachisee_table)
                        ->where('id = :id', array(':id' => $record['franchisee_id']))
                        ->queryRow();
            if (empty($record))self::throwErrorMessage('未获取到线下加盟商信息，消费记录异常');
            
            //获取加盟商对应商家相关数据
            $franMemberData = Yii::app()->db->createCommand()
                                ->select('gai_number as franchisee_gai_number,mobile as franchisee_mobile')
                                ->from($member_table)
                                ->where('id = :id', array(':id' => $franchiseeData['franchisee_member_id']))
                                ->queryRow();
            if (empty($franMemberData)) self::throwErrorMessage('未获取到线下加盟商对应会员信息，消费记录异常');
            
            
            //获取盖机推荐人相关数据
            if(isset($machine['intro_member_id']))
            {
                $machine['introMemberData'] = Yii::app()->db->createCommand()
                                        ->select('type_id as machine_intro_type_id,gai_number as machine_intro_gai_number ')
                                        ->from($member_table)
                                        ->where('id = :id', array(':id' => $machine['intro_member_id']))
                                        ->queryRow();
                $machine['introMemberData'] = empty($machine['introMemberData']) ? array() : $machine['introMemberData'];
            }
            //获取区域相关数据
            $franchiseeData['area_id'] = Yii::app()->db->createCommand()
                        ->select('area')
                        ->from($region_table)
                        ->where('id = :id', array(':id' => $franchiseeData['province_id']))
                        ->queryScalar();
            if (empty($franchiseeData['area_id']))
                self::throwErrorMessage('未找到相关区域，消费记录异常');
            
            //获取消费会员推荐人相关数据
            $reMemberData = Yii::app()->db->createCommand()
                            ->select('type_id as referrals_type_id,gai_number as referrals_gai_number,mobile as referrals_mobile')
                            ->from($member_table)
                            ->where('id = :id', array(':id' => $memberData['referrals_id']))
                            ->queryRow();
            $reMemberData = empty($reMemberData) ? array() : $reMemberData;
                       
            //--------------------------------------------------如果是手动对账来更新对账申请表状态----------------------------------------------------
            if ($is_auto == FranchiseeConsumptionRecord::HANDLE_CHECK) {
                $sql_apply = "select id from " . FranchiseeConsumptionRecordConfirm::model()->tableName() . "
				where record_id = '" . $record['id'] . "'
				and status = " . FranchiseeConsumptionRecordConfirm::STATUS_AUDITI;
                $apply_id = Yii::app()->db->createCommand($sql_apply)->queryScalar();
                if (!empty($apply_id)) {
                    $update_FranchiseeConsumptionRecordConfirm = "update " . FranchiseeConsumptionRecordConfirm::model()->tableName() . "
			    		set status=" . FranchiseeConsumptionRecordConfirm::STATUS_PASS . ",
			    		agree_user_id = " . Yii::app()->user->id . ",
			    		agree_time = " . self::$time . "
			    		where id = '" . $apply_id . "'";
                    Yii::app()->db->createCommand($update_FranchiseeConsumptionRecordConfirm)->execute();
                    //写入操作记录
                    @SystemLog::record(Yii::app()->user->name . "加盟商对账申请，同意对账：{$record['id']} 成功");
                } else {
                    self::throwErrorMessage('您目前是手动对账，该交易记录并没有申请对账或已对账');
                }
            }
            $record_data = array_merge($record, $memberData, $reMemberData, $franchiseeData, $franMemberData, $machine);
            $record_data['table'] = $account_flow_table;
            unset($record_data['franchisee_member_id']);
            //根据币种设定语言
            Yii::app()->language = $record['symbol'] == 'HKD' ? 'zh_tw' : 'zh_cn';
            
            //初始化发送短信变量
            $sms = array();
            
            //开始分配
            self::distributionAmount($record_data,$sms);

//             //-----------------------------------------------------------添加加盟商对账记录--------------------------------------------------
            //插入加盟商对账记录表
            $total_money = $record['spend_money'] - $record['distribute_money'];
            $enterprise_cash_content = self::getContent(self::MEMBER_INFO_CASH_CONTENT, array(
                    $franMemberData['franchisee_gai_number'], $franchiseeData['franchisee_name'], 1, HtmlHelper::formatPrice($total_money)
            ),$record['record_type']);
            //容联云通讯不支持￥字符           
             $price = is_numeric($total_money) ? sprintf('%0.2f',$total_money):$total_money;
            $priceConvert = Yii::app()->language != 'zh_cn' ? (is_numeric($price) ? number_format(Common::rateConvert($price), 2) : $price) : $price;
            $smsdatas = array($franMemberData['franchisee_gai_number'], $franchiseeData['franchisee_name'], 1, $priceConvert);
             $tmpId = Tool::getConfig('smsmodel','offScoreBizReconId');                    
            $sms[] = self::getSmsContent($enterprise_cash_content, array(), $franMemberData['franchisee_mobile'],$smsdatas,$tmpId);
//             //------------------------------------------------------------------------------------------------------------------------------
            
            //余额表验证借贷平衡（今日）
            if (!DebitCredit::checkFlowByCode($account_flow_table, $record['serial_number'])) {
                throw new Exception('DebitCredit Error!', '010');
            }
            
            //--------------------------------------------------更新加盟商消费表中对账状态----------------------------------------------------
            $update_FranchiseeConsumptionRecord = "update $reconrd_table set
            status=" . FranchiseeConsumptionRecord::STATUS_CHECKED . ",
            is_distributed=" . FranchiseeConsumptionRecord::STATUS_CHECKED . ",
            is_auto = " . $is_auto . ",
                    distributed_time = " . self::$time . "
                    where id = '" . $record['id'] . "'";
                    $result = Yii::app()->db->createCommand($update_FranchiseeConsumptionRecord)->execute();
                                if (!$result) {
                                $error = '更新交易记录状态失败';
                                self::throwErrorMessage($error);
            }
            //--------------------------------------------------更新加盟商消费表中对账状态结束----------------------------------------------------
            
            $transaction->commit();
            //-------------------------------------最后发送短信-----------------------------------
            foreach ($sms as $key => $row) {
                if ($row['mobile']) {
                    SmsLog::addSmsLog($row['mobile'], $row['content'], $record['id'], SmsLog::TYPE_OFFLINE_ORDER,null,false,$row['data'],  $row['tmpId']);
                }
            }
            return true;
        } catch (Exception $e) {
            if(isset($transaction) && $transaction->getActive())$transaction->rollBack();
            throw new Exception('ID:'.$record_id.'----'.$e->getMessage());
            return false;
        }
    }
    
    /**
     * 加盟商对账->线下分配
     * @param $data 线下交易记录
     * @param $sms 发送的短信内容，采用地址引用
     * @param $account_flow_arr 本条交易记录需要记录流水记录使用到的流水表
     * @author hhb
     */
    public static function distributionAmount($data,&$sms) {
        //初始化相关表
        $member_table = Member::model()->tableName();
        $region_table = Region::model()->tableName();

        $accountFlowTable = $data['table'];

        //获取线下总账户
        $offlinePublicAcc = CommonAccount::getOfflineAccount();

        //总账户扣钱
        self::sourceAddMoney($data, $offlinePublicAcc, $data['spend_money'], $accountFlowTable);

        //企业会员（商家）加钱
        $enterprise_cash_add = $data['spend_money'] - $data['distribute_money'];
        self::storeAddMoney($data, $enterprise_cash_add, $accountFlowTable);


        //---------------------------------------已经分配金额从虚拟账户中扣除，那么开始分配----------------------------------------
        $distribute_money = $data['distribute_money'];
        self::getConfig();

        $dis_config = CJSON::decode($data['distribute_config']);
        //获取分配百分比
        $gaiIncome = $dis_config['allocation']['gaiIncome'] / 100;   //盖网收益率
        $offConsume = $dis_config['allocation']['offConsume'] / 100;  //消费者
        $offRef = $dis_config['allocation']['offRef'] / 100;    //会员推荐者
        $offAgent = $dis_config['allocation']['offAgent'] / 100;   //代理
        $offGai = $dis_config['allocation']['offGai'] / 100;    //盖网分配
//        $offFlexible = $dis_config['allocation']['offFlexible'] / 100;  //机动（没有这个东西了）
        $offWeightAverage = $dis_config['allocation']['offWeightAverage'] / 100; //盖网机推荐者
        $offRefMachine = $dis_config['allocation']['offRefMachine'] / 100;  //最近一次消费的加盟商
        //获取消费者分配积分
        $official_rate = self::$member_type_rate['official'];   //正式会员积分转化为金额的比例
        $default_rate = self::$member_type_rate['default'];    //消费会员积分转化为金额的比例
        $default_type = self::$member_type_rate['defaultType'];   //消费会员类型
        //盖网收益金额
        $gaiInMoney = $distribute_money * $gaiIncome;
        $gaiInMoney = self::getNumberFormat($gaiInMoney);
        
        //盖网收益账户
        $gw_acc = CommonAccount::getEarningsAccount();
        //排除盖网收益金额后的金额在进行分配
        $other_distribute_money = $distribute_money - $gaiInMoney;

        //---------------------------------------------消费会员分配金额--------------------
        $member_money = $other_distribute_money * $offConsume;   //会员所得可兑现金额
        $member_integral = $member_money / $official_rate;
        $radio = $official_rate;
        if ($data['type_id'] == $default_type) {  //如果是消费会员那么增加的可兑现金额就会改变
            $member_money = $member_integral * $default_rate;
            $radio = $default_rate;
        }
        $member_money = self::getNumberFormat($member_money);
        $member_integral = self::getNumberFormat($member_integral);
        if ($member_money > 0) {
            $sms[] = self::memberDistribute($data, $member_money, $member_integral, $radio, $accountFlowTable);
        }
        //--------------------------------------------消费会员分配结束--------------------
        //-------------------------------------------消费会员推荐人分配金额-----------------------------
        $remember_money = $other_distribute_money * $offRef;
        if ($data['referrals_id'] && isset($data['referrals_type_id'])) {
            $remember_integral = $remember_money / $official_rate;
            $remember_ratio = $official_rate;
            if ($data['referrals_type_id'] == $default_type) {  //如果消费会员推荐人是消费会员，那么增加的可兑现金额就会改变
                $remember_money = $remember_integral * $default_rate;
                $remember_ratio = $default_rate;
            }
            $remember_money = self::getNumberFormat($remember_money);
            $remember_integral = self::getNumberFormat($remember_integral);
            if ($remember_money > 0)
                $sms[] = self::reMemberDistribute($data, $remember_money, $remember_integral, $remember_ratio, $accountFlowTable);
        }else {//如果没有推荐人，那么金额就加入到盖网账户中
            $remember_money = 0;
        }
        //-------------------------------------------消费会员推荐人分配结束-----------------------------
        //-------------------------------------------代理分配金额---------------------------------
        $agent_money = $other_distribute_money * $offAgent;
        $agent_money = self::getNumberFormat($agent_money);
        if ($agent_money > 0) {
            $agent_district_money = 0;
            $agent_city_money = 0;
            $agent_province_money = 0;

            //代理扣除金额
            $agentConfig_district = $dis_config['agentDist']['district'];  //区代理的比例
            $agentConfig_city = $dis_config['agentDist']['city'];    //市代理的比例
            $agentConfig_province = $dis_config['agentDist']['province'];  //省代理的比例

            $agents = array();
            $agents['agent_name'] = $gw_acc['gai_number'];
            $agents['agent_money'] = $agent_money;

            //区
            $sql = "select t.member_id,t.name,m.username,m.gai_number,m.type_id 
		    	from $region_table t 
		    	left join $member_table m on m.id = t.member_id  
		    	where t.id = " . $data['district_id'];
           
            $agent_district = Yii::app()->db->createCommand($sql)->queryRow();
            $agent_district['member_id'] = $agent_district['member_id'] == "" ? 0 : $agent_district['member_id'];
            //市
            $sql = "select t.member_id,t.name,m.username,m.gai_number,m.type_id 
		    	from $region_table t 
		    	left join $member_table m on m.id = t.member_id 
		    	where t.id = " . $data['city_id'];
            $agent_city = Yii::app()->db->createCommand($sql)->queryRow();
            $agent_city['member_id'] = $agent_city['member_id'] == "" ? 0 : $agent_city['member_id'];
            //省
            $sql = "select t.member_id,t.name,m.username,m.gai_number,m.type_id 
		    	from $region_table t 
		    	left join $member_table m on m.id = t.member_id 
		    	where t.id = " . $data['province_id'];
            $agent_province = Yii::app()->db->createCommand($sql)->queryRow();
            $agent_province['member_id'] = $agent_province['member_id'] == "" ? 0 : $agent_province['member_id'];

            //获取比例
            $agentConfig_district = $agent_district['member_id'] == 0 ? 0 : $agentConfig_district;
            $agentConfig_city = $agent_city['member_id'] == 0 ? 0 : $agentConfig_city - $agentConfig_district;
            $agentConfig_province = $agent_province['member_id'] == 0 ? 0 : $agentConfig_province - ($agentConfig_city + $agentConfig_district);

            //获取金额
            $agent_district_money = self::getNumberFormat($agent_money * $agentConfig_district / 100);  //区代理金额
            $agent_city_money = self::getNumberFormat($agent_money * $agentConfig_city / 100);    //市代理金额
            $agent_province_money = self::getNumberFormat($agent_money * $agentConfig_province / 100);  //省代理金额
            $agent_less_money = $agent_money - ($agent_district_money + $agent_city_money + $agent_province_money);  //盖网代理金额
            //插入代理分配记录表,获取插入记录编号
            $agents_total = array(
                'common_account_id' => $gw_acc['account_id'],
                'dist_money' => $agent_money,
                'remainder_money' => $agent_less_money,
                'province_id' => $data['province_id'],
                'province_member_id' => $agent_province['member_id'],
                'province_money' => $agent_province_money,
                'province_ratio' => $agentConfig_province,
                'city_id' => $data['city_id'],
                'city_member_id' => $agent_city['member_id'],
                'city_money' => $agent_city_money,
                'city_ratio' => $agentConfig_city,
                'district_id' => $data['district_id'],
                'district_member_id' => $agent_district['member_id'],
                'district_money' => $agent_district_money,
                'district_ratio' => $agentConfig_district,
                'create_time' => $data['create_time'],
                'target_id' => $data['id'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_RECON,
            );

            $commont_account_dist_table = CommonAccountAgentDist::model()->tableName();
            Yii::app()->db->createCommand()->insert($commont_account_dist_table, $agents_total);
            $agents['target_id'] = $data['id'];

            //代理余额
            if ($agent_less_money > 0) {
                $agent_money -= $agent_less_money;
            }

            //区代理
            if ($agent_district['member_id']) {
                $agent_district_ratio = $agent_district['type_id'] == $default_type ? $default_rate : $official_rate;
                $agents['agent_area_member_id'] = $agent_district['member_id'];
                $agents['agent_area_gai_number'] = $agent_district['gai_number'];
                $agents['agent_area_username'] = $agent_district['username'];
                $agents['agent_area_name'] = $agent_district['name'];
                $agents['agent_ratio'] = $agent_district_ratio;
                $agents['agent_integral'] = self::getNumberFormat($agent_district_money / $agents['agent_ratio']);
                if ($agent_district_money > 0)
                    self::agentDistributeByCity($data, $agents, $agent_district_money, '',$accountFlowTable);
            }

            //市代理
            if ($agent_city['member_id']) {
                $agent_city_ratio = $agent_city['type_id'] == $default_type ? $default_rate : $official_rate;
                $agents['agent_area_member_id'] = $agent_city['member_id'];
                $agents['agent_area_gai_number'] = $agent_city['gai_number'];
                $agents['agent_area_username'] = $agent_city['username'];
                $agents['agent_area_name'] = $agent_city['name'];
                $agents['agent_ratio'] = $agent_city_ratio;
                $agents['agent_integral'] = self::getNumberFormat($agent_city_money / $agents['agent_ratio']);
                if ($agent_city_money > 0)
                    self::agentDistributeByCity($data, $agents, $agent_city_money,'', $accountFlowTable);
            }

            //省代理
            if ($agent_province['member_id']) {
                $agent_province_ratio = $agent_province['type_id'] == $default_type ? $default_rate : $official_rate;
                $agents['agent_area_member_id'] = $agent_province['member_id'];
                $agents['agent_area_gai_number'] = $agent_province['gai_number'];
                $agents['agent_area_username'] = $agent_province['username'];
                $agents['agent_area_name'] = $agent_province['name'];
                $agents['agent_ratio'] = $agent_province_ratio;
                $agents['agent_integral'] = self::getNumberFormat($agent_province_money / $agents['agent_ratio']);
                if ($agent_province_money > 0)
                    self::agentDistributeByCity($data, $agents, $agent_province_money,'', $accountFlowTable);
            }
        }
        //-------------------------------------------代理分配金额结束---------------------------------
        //--------------------------------------------盖机推荐者分配金额-----------------------------
        $reMachine_money = $other_distribute_money * $offWeightAverage;
        if (isset($data['intro_member_id']) && isset($data['introMemberData']['machine_intro_type_id'])) {//如果盖机有推荐人
            $reMachine_integral = $reMachine_money / $official_rate;
            $radio = $official_rate;
            if ($data['introMemberData']['machine_intro_type_id'] == $default_type) {
                $reMachine_integral = $reMachine_money / $default_rate;
                $radio = $default_rate;
            }
            $reMachine_money = self::getNumberFormat($reMachine_money);
            $reMachine_integral = self::getNumberFormat($reMachine_integral);
            if ($reMachine_money > 0)
                self::reMachineDistribute($data, $reMachine_money, $reMachine_integral, $radio, $accountFlowTable);
        }else {
            $reMachine_money = 0;
        }
        //--------------------------------------------盖机推荐者分配金额结束-----------------------------
        //--------------------------------------最近一次消费的加盟商分配金额----------------------------------
        $lastFranchisee_money = $other_distribute_money * $offRefMachine;
        if ($lastFranchisee_money > 0) {
            $tn = FranchiseeConsumptionRecord::model()->tableName();
            $franchisee_table = Franchisee::model()->tableName();
            $sql = "select t.id,m.id as member_id,m.username,m.gai_number,m.type_id 
		    	from $tn t 
		    	left join $franchisee_table f on f.id = t.franchisee_id
		    	left join $member_table m on m.id = f.member_id
		    	where t.member_id = " . $data['member_id'] . "
		    	and t.id < " . $data['id'] . "
		    	order by t.id desc limit 1";
            $lastFranchisee_data = Yii::app()->db->createCommand($sql)->queryRow();

            if ($lastFranchisee_data['member_id']) {
                $lastFranchisee = array();
                $lastFranchisee['last_member_id'] = $lastFranchisee_data['member_id'];
                $lastFranchisee['last_username'] = $lastFranchisee_data['username'];
                $lastFranchisee['last_gai_number'] = $lastFranchisee_data['gai_number'];
                $lastFranchisee_integral = $lastFranchisee_money / $official_rate;
                $ratio = $official_rate;
                if ($lastFranchisee_data['type_id'] == $default_type) {
                    $lastFranchisee_integral = $lastFranchisee_money / $default_rate;
                    $ratio = $default_rate;
                }
                $lastFranchisee_integral = self::getNumberFormat($lastFranchisee_integral);
                $lastFranchisee_money = self::getNumberFormat($lastFranchisee_money);
                if ($lastFranchisee_money > 0)
                    self::lastFranchiseeDistrubute($data, $lastFranchisee, $lastFranchisee_money, $lastFranchisee_integral, $ratio, $accountFlowTable);
            }else {
                $lastFranchisee_money = 0;
            }
        }
        //--------------------------------------最近一次消费的加盟商分配金额结束----------------------------------
        //-------------------------------------------盖网分配金额---------------------------------
        $gai_money = $distribute_money - ($member_money + $remember_money + $agent_money + $reMachine_money + $lastFranchisee_money);
        if ($gai_money > 0)
            self::gaiDistribute($data, $gai_money, $accountFlowTable, $gw_acc);
        //-------------------------------------------盖网分配金额结束---------------------------------
        return true;
    }
    
    /**
     * 线下消费自动对账
     * 计算总的消费金额时不计算当前这条记录
     */
    public static function autoRecon($data)
    {
        //判断是否为新分配单
         $dis_config = CJSON::decode($data['distribute_config']);
        if(!isset($dis_config['allocation'])){
             self::saveAutoReconFailMemo($data, '新分配单，对账失败');
            return false;
        }
        if ($data['spend_money'] <=0 ) {
            self::saveAutoReconFailMemo($data, '交易金额少于等于0，不能自动对账，对账失败');
            return false;
        }
        
        $config = Tool::getConfig('check', null);
        $mim_money = isset($config['minMoney']) ? $config['minMoney'] : 1000;
        $total_count = isset($config['totalCount']) ? $config['totalCount'] : 50;
        $days = isset($config['days']) ? $config['days'] : 30;
        $max_money = isset($config['maxMoney']) ? $config['maxMoney'] : 5000;
        $max_ratio = isset($config['maxRatio']) ? $config['maxRatio'] : 5; //这里先写死，待配置文件做好后进行替换
    
        $yiiDb = Yii::app()->db;
        $end_time = $data['create_time'];
        $start_time = strtotime("-$days days", $end_time);
           /**
         * 判断商户是否异常
         */
        $franchiess = $data['franchisee_id'];
        $abnormal = AbnormalMerchants::model()->find('merchants_id=:mid',array(':mid'=>$franchiess));
        if(!empty($abnormal)){
             $auto_check_fail = "异常商户,不能进行自动对账!" ;
            self::saveAutoReconFailMemo($data, $auto_check_fail);
            return false;
        }
        /**
         * 先判断是否是重复消费(同一个消费者在同一台盖机消费同一个金额)
        */
        $repeat_end_time = $data['create_time'];
        $repeat_time = 600;
        $repeat_start_time = $repeat_end_time - $repeat_time;
        $tn = FranchiseeConsumptionRecord::model()->tableName();
        $isRepeat = $yiiDb->createCommand("select id from ". $tn ."
    			where id!=" . $data['id'] . " and member_id=" .$data['member_id'] .
                " and machine_id=" . $data['machine_id'] .
                " and spend_money=" . $data['spend_money'].
                " and record_type=". $data['record_type'] .
                " and create_time between $repeat_start_time and $repeat_end_time")->queryScalar();
    
        $auto_config_info = "(最小金额:" . $mim_money . ",消费次数:" . $total_count . ",天数:" . $days . ",最大金额:" . $max_money . ",最大比例:" . $max_ratio . ",重复时间:" . $repeat_time . ")";
    
        if ($isRepeat) {
            $auto_check_fail = "重复消费,没有进行自动对账!" . $auto_config_info;
            self::saveAutoReconFailMemo($data, $auto_check_fail);
            return false;
        }
    
        //验证该盖机总共的消费次数（没有区分消费是否对账）
        $sqlCount = "select count(*) from " . $tn . " where machine_id = " . $data['machine_id'];
        $count = $yiiDb->createCommand($sqlCount)->queryScalar();
        if ($count <= $total_count) {  //如果没有超过设定的消费次数，就进行消费金额最小值比较
            //验证本次单笔消费金额是否小于最小金额
            if ( $data['spend_money'] < $mim_money) {
                $rs = self::balanceAccount($data['id'], FranchiseeConsumptionRecord::AUTO_CHECK);
                if ($rs !== true) {
                    //$reason = self::checkFailAutoRecon($id);
                    $reason = "";
                    $auto_check_fail = self::getContent(self::TRUE_ACCOUNT_FAILURE, array($count,$data['machine_id'],$data['spend_money'],'before'),$data['record_type']) . $auto_config_info . "。" .$reason;
                    self::saveAutoReconFailMemo($data, $auto_check_fail);
                    return false;
                }
                $auto_check_fail = self::getContent(self::TRUE_ACCOUNT_SUCCESS, array($count,$data['machine_id'],$data['spend_money'],'before'),$data['record_type']) . $auto_config_info;
                self::saveAutoReconFailMemo($data, $auto_check_fail);
                return true;
            }
        }
    
        if ($data['spend_money'] > $max_money) {
            $auto_check_fail = self::getContent(self::LARGE_EXPENSE_MONEY,array($count,$data['machine_id'],$max_money),$data['record_type']) . $auto_config_info;
            self::saveAutoReconFailMemo($data, $auto_check_fail);
            return false;
        }
        $member_id = $data['member_id'];  					//消费的会员id
        $franchisee_member_id = $data['franMemberId'];		//加盟商的会员id
    
        $total_amount = 0;  //商家的总金额
    
        $order_table = Order::model()->tableName();
        $store_ids = array();
        if ($franchisee_member_id) {
            $stores = Store::model()->findAllByAttributes(array('member_id' => $franchisee_member_id));
            if ($stores) {
                //计算该商家订单总额
                foreach ($stores as $store) {
                    $online_amount = $yiiDb->createCommand()->select('sum(original_price) as sum_price')->from($order_table)->where('store_id=' . $store->id . ' and status=' . Order::STATUS_COMPLETE . ' and create_time between ' . $start_time . ' and ' . $end_time)->queryScalar();
                    $total_amount += $online_amount;
                    $store_ids[] = $store->id;
                }
            }
        }
    
    
        //计算线下商家的总金额
        $franchisee_models = Franchisee::model()->findAll('member_id=:member_id', array('member_id' => $franchisee_member_id));
        $franchisee_ids = array();
        foreach ($franchisee_models as $franchisee_model) {
            $franchisee_ids[] = $franchisee_model->id;
        }
        $franchisee_id = implode(',', $franchisee_ids);
        $offline_amount = $yiiDb->createCommand()->select('sum(spend_money) as sum_price')->from($tn)->where('franchisee_id in (' . $franchisee_id . ') and create_time between ' . $start_time . ' and ' . $end_time . ' and id != ' . $data['id'])->queryScalar();
        $total_amount += $offline_amount;
        $consume_amount = 0;  //消费者的总消费额
        if (!empty($store_ids)) {
            $store_ids = implode(',', $store_ids);
            $online_consume_amount = $yiiDb->createCommand()->select('sum(original_price) as sum_price')->from($order_table)->where('member_id=' . $member_id . ' and store_id in ( ' . $store_ids . ') and status=' . Order::STATUS_COMPLETE . ' and create_time between ' . $start_time . ' and ' . $end_time)->queryScalar();
            $consume_amount += $online_consume_amount;
        }
        $offline_consume_amount = $yiiDb->createCommand()->select('sum(spend_money) as sum_price')->from($tn)->where('member_id=' . $member_id . ' and franchisee_id in (' . $franchisee_id . ') and create_time between ' . $start_time . ' and ' . $end_time . ' and id != ' . $data['id'])->queryScalar();
        $consume_amount += $offline_consume_amount;
    
        if ($total_amount != 0 && $consume_amount / $total_amount > $max_ratio) {
            $auto_check_fail = self::getContent(self::MEMBER_EXPENSE_MONEY, array($count,$data['machine_id'],$days,$max_ratio),$data['record_type']);
            self::saveAutoReconFailMemo($data, $auto_check_fail);
            return false;
        }
        $rs = self::balanceAccount($data['id'], FranchiseeConsumptionRecord::AUTO_CHECK);
        if ($rs !== true) {
            $reason = "";
            $auto_check_fail = self::getContent(self::TRUE_ACCOUNT_FAILURE, array($count,$data['machine_id'],$data['spend_money'],'end'),$data['record_type']) . $auto_config_info . "。" . $reason;
            self::saveAutoReconFailMemo($data, $auto_check_fail);
            return false;
        }
        $auto_check_fail = self::getContent(self::TRUE_ACCOUNT_SUCCESS, array($count,$data['machine_id'],$data['spend_money'],'end'),$data['record_type']) . $auto_config_info ;
        self::saveAutoReconFailMemo($data, $auto_check_fail);
        return true;
    }
    
}


?>