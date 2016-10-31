<?php
/**
 * 利润分配
 * @author qinghao.ye <qinghaoye@sina.com>
 * allocation
  'onConsume' => '50'  消费者
  'onRef' => '15' 推荐者
  'onAgent' => '20' 代理
  'onGai' => '4' 盖网
  'onFlexible' => '3' 机动
  'onWeightAverage' => '8' 推荐商家会员 
  'gaiIncome' => '50' 盖网进账
 * 
 * type
  1 => '0.45' 'default' => '0.45' 消费会员
  'defaultType' => '1' 消费会员类型
  2 => '0.90' 'official' => '0.90' 正式会员
  'officialType' => '2' 正式会员类型
 */
class Online {

    const GAI = 'gai';//盖网
    const MEMBER = 'member';//会员
    const MEMBER_REFERRAL = 'memberReferral';//会员推荐者
    const BUSINESS = 'business';//商家
    const BUSINESS_REFERRAL = 'businessReferral';//商家推荐者
    const MOVE = 'move';//机动
    const AGENT_DISTRICT = 'agentDistrict';//区代理
    const AGENT_CITY = 'agentCity';//市代理
    const AGENT_PROVINCE = 'agentProvince';//省代理
    const GAI_DISTRICT = 'gaiDistrict';//区代理公共账号
    const COMMON_CITY = 'commonCity';//市公共账号

    /**
     * 分配流程(消费者,供货商 这里没有做分配)
     */
    public static function _assignFlow($member,$order,$orderGoods,$signOrder=false){
        $storeAll = Store::model()->with(array('province','city','district'))->findAll('t.id=:id',array(":id"=>$order['store_id']));
        $store = $storeAll[0]->attributes;
        $commonAccount = self::createCommonAccount($storeAll[0]);
        
        $rules = Common::getConfig('allocation');
        $memberRate             = bcdiv($rules['onConsume'],100,3);      //消费者
        $memberReferralRate     = bcdiv($rules['onRef'],100,3);          //推荐者
        $agentRate              = bcdiv($rules['onAgent'],100,3);        //代理
        $gaiRate                = bcdiv($rules['onGai'],100,3);          //盖网
        $moveRate               = bcdiv($rules['onFlexible'],100,3);     //机动
        $businessReferralRate   = bcdiv($rules['onWeightAverage'],100,3);//商家推荐会员
        $gaiIncomeRate          = bcdiv($rules['gaiIncome'],100,3);      //盖网进账收益比率
        
        $money = 0;
        foreach ($orderGoods as $value) {
            $money += (($value['unit_price'] - $value['gai_price']) * $value['quantity']);
        }
        $enableMoney            = bcmul($money, bcsub(1, $gaiIncomeRate, 3), 3);// 可分配利润
        /**
         * 分配公式,算出各个角色的分配金额
         * -----------------------------------------------------------------------------------------------------------------------
         */
        $memberAssign           = self::memberAssign($member, $enableMoney ,$memberRate);//消费者(这里不作分配)
        $businessAssign         = self::businessAssign($orderGoods);//供货商(这里不作分配)
        $gaiIncome              = self::gaiIncome($money, $gaiIncomeRate);//盖网收益
        // 分配
        $gaiAssign              = self::gaiAssign($enableMoney, $gaiRate);//盖网分配
        $moveAssign             = self::moveAssign($enableMoney, $moveRate);//机动分配
        $agentAssign            = self::agentsAssign($enableMoney, $agentRate, $store['district_id']);//代理分配
        $memberReferralAssign   = self::memberReferralAssign($member, $enableMoney, $memberReferralRate);//会员推荐者分配
        $businessReferralAssign = self::businessReferralAssign($enableMoney, $businessReferralRate, $store['referrals_id']);//商家推荐者分配
        
        // 剩余金额
        $surplus = $memberAssign[self::GAI]['cash'] + $businessAssign[self::GAI]['cash'] + $moveAssign[self::GAI]['cash'] + 
                $agentAssign[self::GAI_DISTRICT]['cash'] + $memberReferralAssign[self::GAI]['cash'] + $businessReferralAssign[self::GAI]['cash'];
        
        /**
         * 组装数组,用于 member, common_account, wealth, common_account_agent_dist
         * -----------------------------------------------------------------------------------------------------------------------
         */
        # 公共账号
        // 盖网公共账号资产: 本金 + 盖网收益 + 盖网分配 + 分配的剩余金额(2.5.)
        if($gaiIncome[self::GAI]['cash']){
            @$updateCommon[$commonAccount[self::GAI]['id']]['cash'] = $commonAccount[self::GAI]['cash']+ $gaiIncome[self::GAI]['cash'] + $gaiAssign[self::GAI]['cash'] + $surplus;
        }
        // 区代理公共账号资产: 本金 + 区公共代理分配(4.)
        if($agentAssign[self::GAI_DISTRICT]['cash']){
            @$updateCommon[$commonAccount[self::GAI_DISTRICT]['id']]['cash'] += $commonAccount[self::GAI_DISTRICT]['cash']+ $agentAssign[self::GAI_DISTRICT]['cash'];
        }
        // 机动公共账号资产: 本金 + 机动分配(6.)
        if($moveAssign[self::MOVE]['cash']){
            @$updateCommon[$commonAccount[self::MOVE]['id']]['cash'] += $commonAccount[self::MOVE]['cash']+ $moveAssign[self::MOVE]['cash'];
        }
        
        # 会员账号
        // 商家 外面分配(1.)
//        if($businessAssign[self::BUSINESS]['cash'] && $store['member_id']){
//            @$findAry[$store['member_id']] += $businessAssign[self::BUSINESS]['cash'];
//        }
        // 区代理(4.)
        if($agentAssign[self::AGENT_DISTRICT]['cash'] && $agentAssign[self::AGENT_DISTRICT]['memberId']){
            @$findAry[$agentAssign[self::AGENT_DISTRICT]['memberId']] += $agentAssign[self::AGENT_DISTRICT]['cash'];
        }
        // 市代理(4.)
        if($agentAssign[self::AGENT_CITY]['cash'] && $agentAssign[self::AGENT_CITY]['memberId']){
            @$findAry[$agentAssign[self::AGENT_CITY]['memberId']] += $agentAssign[self::AGENT_CITY]['cash'];
        }
        // 省代理(4.)
        if($agentAssign[self::AGENT_PROVINCE]['cash'] && $agentAssign[self::AGENT_PROVINCE]['memberId']){
            @$findAry[$agentAssign[self::AGENT_PROVINCE]['memberId']] += $agentAssign[self::AGENT_PROVINCE]['cash'];
        }
        // 推荐会员(3.)
        if($memberReferralAssign[self::MEMBER_REFERRAL]['cash'] && $memberReferralAssign[self::MEMBER_REFERRAL]['memberId']){
            @$findAry[$memberReferralAssign[self::MEMBER_REFERRAL]['memberId']] += $memberReferralAssign[self::MEMBER_REFERRAL]['cash'];
        }
        // 推荐商家(7.)
        if($businessReferralAssign[self::BUSINESS_REFERRAL]['cash'] && $businessReferralAssign[self::BUSINESS_REFERRAL]['memberId']){
            @$findAry[$businessReferralAssign[self::BUSINESS_REFERRAL]['memberId']] += $businessReferralAssign[self::BUSINESS_REFERRAL]['cash'];
        }
        // 加上原有金额
        foreach ($findAry as $findId => $addVal) {
            $cash = Yii::app()->db->createCommand()->select(array('account_expense_cash'))->from('{{member}}')->where('id=:id',array(':id'=>$findId))->queryScalar();
            if($cash == false) $cash = 0;
            $updateMember[$findId] = array('account_expense_cash' => $addVal + $cash);
        }
        
        # 日志记录
        $insertCommonAgent[] = self::agentDistLog($commonAccount[self::GAI_DISTRICT]['id'], $agentAssign);
        $insertWealth[] = self::agentLog($order, $member, $commonAccount[self::GAI_DISTRICT], $agentAssign);
        $insertWealth[] = self::businessReferralLog($order, $member, $commonAccount, $store, $businessReferralAssign);
        $insertWealth[] = self::gaiLog($order, $member, $commonAccount[self::GAI], $gaiAssign, $gaiIncome, $surplus);
        $insertWealth[] = self::memberReferralLog($order, $member, $commonAccount[self::GAI], $memberReferralAssign);
        $insertWealth[] = self::moveLog($order, $member, $commonAccount[self::MOVE], $moveAssign);
        
        var_dump(
                $enableMoney,
                $businessAssign,
                $gaiIncome,
                $gaiAssign,
                $moveAssign,
                $agentAssign,
                $memberReferralAssign,
                $businessReferralAssign,$memberAssign
                );
        echo "<br/><hr><br/>";
        var_dump($commonAccount,$updateCommon,$updateMember,$insertWealth,$insertCommonAgent);
        
        # 事务操作
//        return self::_runTrans($updateCommon,$updateMember,$insertWealth,$insertCommonAgent,$signOrder);
    }
    /**
     * 运行事务
     * @param array $array
     * @return boolean
     */
    public static function _runTrans($updateCommon, $updateMember, $insertWealth, $insertCommonAgent, $orderId = false){
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 签收订单
            if($orderId){
                Yii::app()->db->createCommand()->update('{{order}}', array('delivery_status' => Order::DELIVERY_STATUS_RECEIVE, 'status' => Order::STATUS_COMPLETE, 'sign_time' => time()),'id=:id', array(':id'=>$orderId));
            }
            // 更新公共账号
            foreach ($updateCommon as $cpk => $cval){
                Yii::app()->db->createCommand()->update('{{common_account}}', $cval,'id=:id', array(':id'=>$cpk));
            }
            // 更新会员账号
            foreach ($updateMember as $mpk => $mval){
                Yii::app()->db->createCommand()->update('{{member}}', $mval,'id=:id', array(':id'=>$mpk));
            }
            
            // 新增日志
            foreach ($insertWealth as $wval){
                Yii::app()->db->createCommand()->insert('{{wealth}}', $wval);
            }
            // 新增代理分配日志
            foreach ($insertCommonAgent as $aval){
                Yii::app()->db->createCommand()->insert('{{common_account_agent_dist}}', $aval);
            }
            
            $transaction->commit();
            return TRUE;
        } catch (Exception $e) {
            $transaction->rollBack();
            return FALSE;
        }
    }
    
    /**
     * 创建公共账号
     * @param CModel $store
     */
    public static function createCommonAccount($store) {
        $final = $gai = $move = $agent = array();
        // 判断区代理是否存在
        $agent = Yii::app()->db->createCommand()
                        ->select('id, name, cash')
                        ->from('{{common_account}}')
                        ->where('city_id=:cityId and type=:type', array(
                            ':cityId' => $store->district_id,
                            ':type' => CommonAccount::TYPE_AGENT
                        ))->queryRow();
        // 判断市机动账号是否存在
        $move = Yii::app()->db->createCommand()
                        ->select('id, name, cash')
                        ->from('{{common_account}}')
                        ->where('city_id=:cityId and type=:type', array(
                            ':cityId' => $store->city_id,
                            ':type' => CommonAccount::TYPE_MOVE
                        ))->queryRow();
        // 判断市盖网账号是否存在
        $gai = Yii::app()->db->createCommand()
                        ->select('id, name, cash')
                        ->from('{{common_account}}')
                        ->where('city_id=:cityId and type=:type', array(
                            ':cityId' => $store->city_id,
                            ':type' => CommonAccount::TYPE_GAI
                        ))->queryRow();
        // 不存在区代理，创建
        if (!$agent) {
            $agentTmp = array(
                'name' => $store->province->name . $store->city->name . $store->district->name . '代理',
                'type' => CommonAccount::TYPE_AGENT,
                'city_id' => $store->district_id,
                'cash' => 0
            );
            if(Yii::app()->db->createCommand()->insert('{{common_account}}', $agentTmp)){
                $agentTmp['id'] = Yii::app()->db->getLastInsertID();
                $agent = $agentTmp;
            }
        }
        $final[self::GAI_DISTRICT] = $agent;
        // 不存在市机动，创建
        if (!$move) {
            $moveTmp = array(
                'name' => $store->province->name . $store->city->name . '机动',
                'type' => CommonAccount::TYPE_MOVE,
                'city_id' => $store->city_id,
                'cash' => 0
            );
            if(Yii::app()->db->createCommand()->insert('{{common_account}}', $moveTmp)){
                $agentTmp['id'] = Yii::app()->db->getLastInsertID();
                $move = $agentTmp;
            }
        }
        $final[self::MOVE] = $move;
        // 不存在市盖网，创建
        if (!$gai) {
            $gaiTmp = array(
                'name' => $store->province->name . $store->city->name . '盖网',
                'type' => CommonAccount::TYPE_GAI,
                'city_id' => $store->city_id,
                'cash' => 0
            );
            if(Yii::app()->db->createCommand()->insert('{{common_account}}', $gaiTmp)){
                $gaiTmp['id'] = Yii::app()->db->getLastInsertID();
                $gai = $gaiTmp;
            }
        }
        $final[self::GAI] = $gai;
        return $final;
    }
    
    /**
     * 公式
     **********************************************************************************************************************************
     */

    /**
     * 盖网收入
     * 计算出盖网进账 
     * @param float $money 总收益
     * @param float $rate 盖网收入比率
     * @return array
     */
    public static function gaiIncome($money, $rate) {
        $final = array();
        $final[self::GAI]['cash'] = bcmul($money, $rate, 2);
        return $final;
    }

    /**
     * 机动帐号分配
     * 
     * 计算出机动帐号分配的金额
     * 如果$move有值，表示此机动帐号是原来存在
     * 算出的机动账号返还的金额+原帐号上的金额
     * 否则$move没有值是新建帐号，返还金额=当前算出的金额
     * 
     * @param float $money 收益的金额（除去盖网进账）
     * @param float $rate 机动账号返还比率
     */
    public static function moveAssign($money, $rate) {
        $final = array();
        $final[self::MOVE]['cash'] = bcmul($money, $rate, 2);
        $final[self::GAI]['cash'] = 0;
        return $final;
    }

    /**
     * 盖网市级公共帐号分配
     * 计算出盖网帐号分配的金额
     * @param float $money 收益的金额（除去盖网进账）
     * @param float $rate 盖网账号返还比率
     */
    public static function gaiAssign($money, $rate) {
        $final = array();
        $final[self::GAI]['cash'] = bcmul($money, $rate, 2);
        return $final;
    }

    /**
     * 商家推荐分配
     * @param float $money 收益的金额（除去盖网进账）
     * @param float $rate  盖网账号返还比率
     * @param int $referMemberId 推荐人id
     * @return array
     */
    public static function businessReferralAssign($money, $rate, $referMemberId=0) {
        $final = array();
        $cash = bcmul($money, $rate, 2);
        $final[self::GAI]['cash'] = $cash;
        $final[self::BUSINESS_REFERRAL]['cash'] = 0;
        $final[self::BUSINESS_REFERRAL]['memberId'] = 0;
        //判断是否为商家会员
        if($referMemberId){
            $referrals = Yii::app()->db->createCommand()->from('{{member}}')->where('id=:id',array(':id'=>$referMemberId))->queryRow();
            if(!empty($referrals) && $referrals['is_enterprise']){
                $final[self::GAI]['cash'] = 0;
                $final[self::BUSINESS_REFERRAL]['memberId'] = $referrals['id'];
                $final[self::BUSINESS_REFERRAL]['type_id'] = $referrals['type_id'];
                $final[self::BUSINESS_REFERRAL]['gai_number'] = $referrals['gai_number'];
            }
        }
        return $final;
    }
    
    /**
     * 供货商分配
     * @param array $orderGoods 订单商品
     * @return array
     */
    public static function businessAssign($orderGoods){
        $final = array();
        $totalMoney = $cash = 0;
        foreach ($orderGoods as $val){
            $money = bcmul($val['gai_price'], $val['quantity'], 2);
            $totalMoney += $money;//总金额
            $rate = $val['rate'] ? $val['rate'] : 0;
            $cash += bcmul($money, bcdiv($rate, 100, 4), 2);//总手续费
        }
        $final[self::GAI]['cash'] = $cash;
        $final[self::BUSINESS]['cash'] = $totalMoney - $cash;
        return $final;
    }
    
    
    /**
     * 代理
     * 省: 0.4x - (0.37 - 0.34)y - 0.34z
     * 市: (0.37 - 0.34)y
     * 区: 0.34z
     * @param float $money
     * @param float $rate
     * @param int $district_id
     * @return array
     */
    public static function agentsAssign($money, $rate, $district_id){
        $final = array();
        $enableMoney = bcmul($money, $rate, 4);
        $memberIdDistrict = $memberIdCity = $memberIdProvince = 
        $agentDistrict = $agentCity = $agentProvince = 0;
        $districtRate   = bcdiv(Common::getConfig('agentdist', 'district'), 100, 3);    //区代理的比例
        $cityRate       = bcdiv(Common::getConfig('agentdist', 'city'), 100, 3);        //市代理的比例
        $provinceRate   = bcdiv(Common::getConfig('agentdist', 'province'), 100, 3);    //省代理的比例
        // 区
        $district = Yii::app()->db->createCommand()->from('{{region}}')->where('id='.$district_id)->queryRow();
        if(!empty($district)){
            if($district['member_id'] != FALSE){
                $agentDistrict = $districtRate;
                $memberIdDistrict = $district['member_id'];
            }
            // 市
            $city = Yii::app()->db->createCommand()->from('{{region}}')->where('id='.$district['parent_id'])->queryRow();
            if(!empty($city)){
                if($city['member_id'] != FALSE){
                    $agentCity = $cityRate - $districtRate;
                    $memberIdCity = $city['member_id'];
                }
                // 省
                $province = Yii::app()->db->createCommand()->from('{{region}}')->where('id='.$city['parent_id'])->queryRow();
                if(!empty($province)){
                    if($province['member_id'] != FALSE){
                        $agentProvince = $provinceRate - $cityRate - $districtRate;
                        $memberIdProvince = $province['member_id'];
                    }
                }
            }
        }
        // 区代理
        $final[self::AGENT_DISTRICT]['cash'] = bcmul($enableMoney, $agentDistrict, 2);
        $final[self::AGENT_DISTRICT]['memberId'] = $memberIdDistrict;
        $final[self::AGENT_DISTRICT]['id'] = $district_id;
        $final[self::AGENT_DISTRICT]['realRate'] = $agentDistrict;
        // 市代理
        $final[self::AGENT_CITY]['cash'] = bcmul($enableMoney, $agentCity, 2);
        $final[self::AGENT_CITY]['memberId'] = $memberIdCity;
        $final[self::AGENT_CITY]['id'] = $city['id'];
        $final[self::AGENT_CITY]['realRate'] = $agentCity;
        // 省代理
        $final[self::AGENT_PROVINCE]['cash'] = bcmul($enableMoney, $agentProvince, 2);
        $final[self::AGENT_PROVINCE]['memberId'] = $memberIdProvince;
        $final[self::AGENT_PROVINCE]['id'] = $province['id'];
        $final[self::AGENT_PROVINCE]['realRate'] = $agentProvince;
        // 剩余
        $final[self::GAI_DISTRICT]['cash'] = $enableMoney - $final[self::AGENT_DISTRICT]['cash'] - $final[self::AGENT_CITY]['cash'] - $final[self::AGENT_PROVINCE]['cash'];
        return $final;
    }
    
    
    /**
     * 消费者推荐分配
     * @param array $member 消费者
     * @param float $money  收益的金额（除去盖网进账）
     * @param float $rate 消费者推荐返还比率
     * @return array
     */
    public static function memberReferralAssign($member, $money, $rate) {
        $typeRate = MemberType::fileCache();
        $officalCash = $cash = 0;
        $referrals = $final = array();
        // 先计算出以正式会员的所属的积分，作为基准
        $officalCash = bcmul($money, $rate, 2);
        if($member['referrals_id']) 
            $referrals = Yii::app()->db->createCommand()->from('{{member}}')->where('id=:id',array(':id'=>$member['referrals_id']))->queryRow();
        $final[self::MEMBER_REFERRAL]['cash'] = 0;
        $final[self::MEMBER_REFERRAL]['memberId'] = 0;
        $final[self::GAI]['cash'] = 0;
        if(!empty($referrals)){
            // 正式会员，全部进账
            $final[self::MEMBER_REFERRAL]['cash'] = $officalCash;
            $final[self::MEMBER_REFERRAL]['memberId'] = $referrals['id'];
            $final[self::MEMBER_REFERRAL]['type_id'] = $referrals['type_id'];
            $final[self::MEMBER_REFERRAL]['gai_number'] = $referrals['gai_number'];
            // 消费会员，进账部分，其余进盖网
            if ($referrals['type_id'] != MemberType::MEMBER_OFFICAL) {
                $cash = bcmul( bcdiv($officalCash, $typeRate[MemberType::MEMBER_OFFICAL], 3), $typeRate[$referrals['type_id']], 2);
                $final[self::MEMBER_REFERRAL]['cash'] = $cash;
                $final[self::GAI]['cash'] = $officalCash - $cash;
            }
        }else{
            // 没有推荐会员，直接入账到盖网账号
            $final[self::GAI]['cash'] = $officalCash;
        }
        return $final;
    }

    /**
     * 消费者 是在支付成功后就要 获得分配金额
     * @param array $member
     * @param float $money
     * @param float $rate
     * @return array
     */
    public static function memberAssign($member, $money ,$rate) {
        $final = array();
        $typeRate = MemberType::fileCache();
        $enableMoney = bcmul($money, $rate, 2); //消费者要分配的金额
        if($member['type_id'] == MemberType::MEMBER_OFFICAL){
            $final[self::MEMBER]['cash'] = $enableMoney;
            $final[self::GAI]['cash'] = 0;
        }else{
            //把消费者分配的金额 以正式会员的比率做为基准转换为积分作为消费会员分配的基准,正式会员不受此限制
            //消费会员分配的金额 等于 基准积分乘以会员的比率
            $cash = bcmul( bcdiv($enableMoney, $typeRate[MemberType::MEMBER_OFFICAL], 3), $typeRate[$member['type_id']], 2);
            $final[self::MEMBER]['cash'] = $cash;
            $final[self::GAI]['cash'] = $enableMoney - $cash;
        }
        return $final;
    }

    /**
     * 日志
     **********************************************************************************************************************************
     */
    
    /**
     * 会员推荐者分配记录日志
     * @param array $order
     * @param array $member
     * @param array $common 盖网公共账号
     * @param array $assign 分配
     */
    public static function memberReferralLog($order, $member, $common, $assign) {//消费者的会员编号
        $wealth = array();
        $memberGaiNumber = $member['gai_number'];
        $memberTypeId = $member['type_id'];
        
        //如果存在推荐会员
        if ($assign[self::MEMBER_REFERRAL]['memberId']) {
            $referrals = $assign[self::MEMBER_REFERRAL];
            $wealth['owner'] = Wealth::OWNER_MEMBER;
            $wealth['member_id'] = $referrals['memberId'];//
            $wealth['gai_number'] = $referrals['gai_number'];//
            $wealth['type_id'] = Wealth::TYPE_GAI;
            $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
            $wealth['target_id'] = $order['id'];
            $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
            $wealth['status'] = Wealth::STATUS_YES;
            $wealth['money'] = $referrals['cash'];//
            if ($referrals['type_id'] == MemberType::MEMBER_OFFICAL) {
                $wealth['score'] = Common::convertSingle($referrals['cash'], $referrals['type_id']);
                $wealth['content'] = WealthLog::getContent(WealthLog::RECOMMEND_RETURN, 
                        array($order['code'], $memberGaiNumber, Common::convertSingle($order['pay_price'], $memberTypeId), $wealth['score']));
            } else {
                $wealth['score'] = Common::convertSingle($referrals['cash'], $referrals['type_id']);
                $wealth['content'] = WealthLog::getContent(WealthLog::RECOOMEND_RETURN_NO_OFFICAL, 
                        array($order['code'], $memberGaiNumber, Common::convertSingle($order['pay_price'], $memberTypeId), $wealth['score'], $assign[self::GAI]['cash'] ));
            }
        } else {
            //推荐会员不存在,记录到盖网日志
            $wealth['owner'] = '';
            $wealth['member_id'] = $common['id'];////盖网公共账号//OnlineIssue::getModel(CommonAccount::TYPE_GAI, $cityId)->id;//CommonAccount
            $wealth['gai_number'] = $common['name'];////盖网公共账号名称
            $wealth['type_id'] = Wealth::TYPE_GAI;
            $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
            $wealth['target_id'] = $order['id'];
            $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
            $wealth['status'] = Wealth::STATUS_YES;
            $wealth['money'] = $assign[self::GAI]['cash'];//不存在消费者推荐会员的返还金额
            $wealth['score'] = '0.00';
            $wealth['content'] = WealthLog::getContent(WealthLog::NO_RECOMMEND, array($order['code'], $memberGaiNumber, Common::convertSingle($order['pay_price'],$memberTypeId), $wealth['money']));
        }
        return $wealth;
    }
    
    /**
     * 机动分配日志
     * @param array $order
     * @param array $member
     * @param array $common 机动公共账号
     * @param array $assign 分配
     * @return array
     */
    public static function moveLog($order, $member, $common, $assign) {
        $wealth = array();
        $wealth['owner'] = 0;
        $wealth['member_id'] = $common['id'];//
        $wealth['gai_number'] = $common['name'];//
        $wealth['type_id'] = Wealth::TYPE_CASH;
        $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
        $wealth['target_id'] = $order['id'];
        $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
        $wealth['status'] = Wealth::STATUS_YES;
        $wealth['score'] = 0.00;
        $wealth['money'] = $assign[self::MOVE]['cash'];
        $wealth['content'] = WealthLog::getContent(WealthLog::MOVE_RETURN, array($order['code'], $member['gai_number'], Common::convertSingle($order['pay_price'],$member['type_id']), $wealth['money']));
        return $wealth;
    }
    
    /**
     * 代理分配日志
     * @param array $order
     * @param array $member
     * @param array $common 代理公共账号
     * @param array 分配
     */
    public static function agentLog($order, $member, $common, $assign) {
        $wealth = array();
        $wealth['owner'] = 0;
        $wealth['member_id'] = $common['id'];//
        $wealth['gai_number'] = $common['name'];//
        $wealth['type_id'] = Wealth::TYPE_CASH;
        $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
        $wealth['target_id'] = $order['id'];
        $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
        $wealth['status'] = Wealth::STATUS_YES;
        $wealth['score'] = 0.00;
        $wealth['money'] = $assign[self::AGENT_DISTRICT]['cash'] + $assign[self::AGENT_CITY]['cash'] + $assign[self::AGENT_PROVINCE]['cash'];
        $wealth['content'] = WealthLog::getContent(WealthLog::AGENT_RETURN, array($order['code'], $member['gai_number'], Common::convertSingle($order['pay_price'],$member['type_id']), $wealth['money']));
        return $wealth;
    }
    
    /**
     * 商家推荐会员分配日志
     * @param array $order
     * @param array $member
     * @param array $common 机动公共账号 和 盖网公共账号
     * @param array $store 供货商家
     * @param array $assign 分配
     * @return array
     */
    public static function businessReferralLog($order, $member, $common, $store, $assign) {
        $referrals = $assign[self::BUSINESS_REFERRAL];
        $wealth = array();
        $wealth['owner'] = 0;
        $wealth['member_id'] = $common[self::MOVE]['id'];//机动公共账号
        $wealth['gai_number'] = $common[self::MOVE]['name'];//
        $wealth['type_id'] = Wealth::TYPE_GAI;
        $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
        $wealth['target_id'] = $order['id'];
        $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
        $wealth['status'] = Wealth::STATUS_YES;
        if ($referrals['memberId']) {
            $wealth['money'] = $referrals['cash'];
            $wealth['content'] = WealthLog::getContent(WealthLog::MERCHANTREFERRAL, 
                array($order['code'], $member['gai_number'], Common::convertSingle($order['pay_price'],$member['type_id']), $store['name'], $order['pay_price'], Common::convertSingle($wealth['money'],$referrals['type_id'])));
        } else {
            //商家推荐会员不存在,记录到盖网日志
            $wealth['owner'] = '';
            $wealth['member_id'] = $common[self::GAI]['id'];//盖网公共账号
            $wealth['gai_number'] = $common[self::GAI]['name'];//
            $wealth['type_id'] = Wealth::TYPE_CASH;
            $wealth['score'] = '0.00';
            $wealth['money'] = $assign[self::GAI]['cash'];
            $wealth['content'] = WealthLog::getContent(WealthLog::NO_REC_ENTERPRISE, 
                    array($order['code'], $member['gai_number'], Common::convertSingle($order['pay_price'],$member['type_id']), $wealth['money']));
        }
        return $wealth;
    }
    
    /**
     * 盖网分配日志
     * @param array $order
     * @param array $member
     * @param array $common 盖网公共账号
     * @param array $assign 分配
     * @param array $gaiIncome 收益
     * @param array $surplus 剩余
     * @return array
     */
    public static function gaiLog($order, $member, $common, $assign, $gaiIncome, $surplus) {
        $wealth = array();
        $wealth['owner'] = 0;
        $wealth['member_id'] = $common['id'];//盖网公共账号
        $wealth['gai_number'] = $common['name'];//
        $wealth['type_id'] = Wealth::TYPE_CASH;
        $wealth['source_id'] = Wealth::SOURCE_ONLINE_ORDER;
        $wealth['target_id'] = $order['id'];
        $wealth['ip'] = Tool::ip2int(Tool::getClientIP());
        $wealth['status'] = Wealth::STATUS_YES;
        $wealth['score'] = 0.00;
        $wealth['money'] = $assign[self::GAI]['cash'] + $gaiIncome[self::GAI]['cash'] + $surplus; //盖网的这一个订单的总收入
        $wealth['content'] = WealthLog::getContent(WealthLog::GAI_ALL, 
                array($order['code'], $member['gai_number'], Common::convertSingle($order['pay_price'],$member['type_id']), $gaiIncome[self::GAI]['cash'], $assign[self::GAI]['cash'], $surplus, $wealth['money']));
        return $wealth;
    }

    /**
     * 代理详细分配记录
     * @param type $commonId 公共账号id
     * @param type $assign 分配
     * @return array 
     */
    public static function agentDistLog($commonId, $assign) {
        $district = $assign[self::AGENT_DISTRICT];
        $city = $assign[self::AGENT_CITY];
        $province = $assign[self::AGENT_DISTRICT];
//        Yii::app()->db->createCommand()->insert('{{common_account_agent_dist}}', array(
        return array(
            'common_account_id' => $commonId,//区代理id
            'dist_money' => $assign[self::GAI_DISTRICT]['cash'] + $district['cash'] + $city['cash'] + $province['cash'],
            'remainder_money' => $assign[self::GAI_DISTRICT]['cash'],
            // 省
            'province_id' => $province['id'],
            'province_member_id' => $province['memberId'],
            'province_money' => $province['cash'],
            'province_ratio' => $province['realRate'],
            // 市
            'city_id' => $city['id'],
            'city_member_id' => $city['memberId'],
            'city_money' => $city['cash'],
            'city_ratio' => $city['realRate'],
            // 区
            'district_id' => $district['id'],
            'district_member_id' => $district['memberId'],
            'district_money' => $district['cash'],
            'district_ratio' => $district['realRate'],
            'create_time' => time(),
        );
    }
    
}
