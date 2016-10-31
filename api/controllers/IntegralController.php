<?php

/**
 * 盖网通积分接口
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class IntegralController extends Controller {
    const EPORT_NOT_PAY_STATUS =1;
    const EPORT_IS_PAY_STATUS =2;

    /**
     * 积分消费接口
     */
    public function actionDeduct() {
        try{
            $this->addLog('apiGwt', "\r\n<hr><hr>1.post", $_POST);
            $this->actionType = '';
            $this->checkRequest();
            $rsa = new RSA();
            $checkCode = $rsa->decrypt($this->checkParam('CheckCode'));    //验证码
            $this->addLog('apiGwt', "\r\n 2.checkCode: " . $checkCode);
            // 检查验证码
            $this->checkVerifyCode($checkCode);
    
           // $userPhone = $this->checkParam('UserPhone');    //用户手机号
            $money = $this->checkParam('Money');    //消费金额
            $franchiseeId = $this->checkParam('FranchiseeId');    //加盟商id
            $machineId = $this->checkParam('MachineId');    //盖网机id
           // $machineName = $this->checkParam('MachineName');    //盖网机的名称
            $machineSN = $this->checkParam('MachineSN');    //盖网机生成的本次消费的流水号
        	if (!is_numeric($money) || $money<1){
    			$this->errorEndXml('金额必须为数字并且至少大于等于1');
    		}
    		
    		$machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('id=:params', array(':params' => $machineId))->queryRow();
    		$symbol = $machine['symbol'];
    		if (empty($machine)){
    			$this->errorEndXml("盖机不存在");
    		}
    		
            // 消费金额转换成人民币
            if ($symbol == Symbol::RENMINBI || $symbol == Symbol::EN_DOLLAR) {
                $basePrice = 100;
                $symbol = Symbol::RENMINBI;
            } elseif ($symbol == Symbol::HONG_KONG_DOLLAR && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                $this->errorEndXml('币种错误');
            }
            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($money, bcdiv($basePrice, 100, 5), 2);
    
            $gaiNumber = $this->getPost('Name'); //用户账号
            if ($gaiNumber != false) {
                $member = ApiMember::getMemberByGainumber($gaiNumber);
                if (empty($member))
                    $this->errorEndXml('账号不存在');
                $userPhone = $member['mobile'];
            }else {
                $userPhone = $this->checkParam('UserPhone');    //用户手机号
                $member = $this->findMemberByPhone($userPhone);
                if (empty($member))
                    $this->errorEndXml('账号不存在');
            }
            /** 积分限额消费 zhaoxiang.liu*/
           $payPrice = $moneyRMB;
           $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            $pointData = MemberPoint::getMemberPoint($member['id'], $totalMoney);
            
            $memberPointResult = self::CheckMemberPoint($member,$payPrice,$pointData);
            if(!$memberPointResult["result"]){
            	if ($symbol == Symbol::HONG_KONG_DOLLAR){
            		$memberPointResult["monthPoint"] = bcdiv($memberPointResult["monthPoint"], bcdiv($basePrice, 100, 5), 2);
            		$memberPointResult["dayPoint"] = bcdiv($memberPointResult["dayPoint"], bcdiv($basePrice, 100, 5), 2);
            		$memberPointResult["monthPoint"] = "HK$".$memberPointResult["monthPoint"];
            		$memberPointResult["dayPoint"] = "HK$".$memberPointResult["dayPoint"];
            	}else{
	            	$memberPointResult["monthPoint"] = "￥".$memberPointResult["monthPoint"];
	            	$memberPointResult["dayPoint"] = "￥".$memberPointResult["dayPoint"];
            	}
            	$this->errorEndXml("亲爱的会员,目前您当月剩余可消费余额为{$memberPointResult["monthPoint"]},当日剩余可消费余额为{$memberPointResult["dayPoint"]}，此次消费已超过额度,请使用银行卡支付");
            }
            /** 积分限额消费 zhaoxiang.liu*/

          
            $accountFlowTable = AccountFlow::monthTable();
    
            // 获取加盟商信息
            $franchisee = ApiFranchisee::getFranchisee($franchiseeId);
            if (empty($franchisee)) {
                throw new ErrorException(Yii::t('Machine', '不存在该商家'), 400);
            }
            
        
            //盖网通接口加入了折扣设定验证，这里也加入，为了防止截取url直接访问这边。
            if ($franchisee['member_discount'] == 0 || $franchisee['gai_discount'] == 0) {
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            } else if($franchisee['gai_discount'] > $franchisee['member_discount']){
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            }
            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                                ->select('id,gai_number,status')
                                ->from('{{member}}')
                                ->where('id=:id',array(':id'=>$franchisee['member_id']))
                                ->queryRow();
            if(empty($franchiseeMember)) $this->errorEndXml(Yii::t('MachineForGt', '商家的账号不存在!'));
            if($franchiseeMember['status'] > Member::STATUS_NORMAL)$this->errorEndXml(Yii::t('MachineForGt', '商家的账号已被禁用或删除!')); 
            if($franchisee['member_id'] == $member['id'])$this->errorEndXml('您作为商家，不能在本店消费');
            
            // 人民币转换为积分
            $score = Common::convertSingle($moneyRMB, $member['type_id']);
            $recordId = "";
    		$data = array(
    			'moneyRMB' => $moneyRMB,
    			'basePrice' => $basePrice,
    			'symbol' => $symbol,
    			'machineSN' => $machineSN,
    			'accountFlowTable' => $accountFlowTable,
    			'money' => $money,
                'record_type'=> FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
    		);
    		
            $resule = IntegralOfflineNew::offlineConsume($franchisee, $machine, $member, $data, $recordId);
            if ($resule !== true) {
                $this->errorEndXml($resule);
            }
    
            $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            $frozen = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_RETURN);
    
            // 发送短信
            $ApiSmsLog = new ApiSmsLog();
            $ApiSmsLog->sendSms_gtDeduct($member, $franchisee['name'], $money, $score, $userPhone, $symbol, $totalMoney, $recordId, 1);
    
                       /**积分限额zhaoxiang.liu**/
            self::UpdateMemberPoint($member, $payPrice, $pointData);
            /**积分限额zhaoxiang.liu**/
            
            // 历史记录
            $historys = Yii::app()->db->createCommand()
                            ->select(array('t.spend_money', 't.create_time', 'f.name as fname', 't.symbol', 't.base_price', 't.entered_money'))
                            ->from('{{franchisee_consumption_record}} t')
                            ->leftJoin('{{franchisee}} f', 't.franchisee_id=f.id')
                            ->where('t.member_id=:mid and t.`status`<:status', array(':mid' => $member['id'], ':status' => FranchiseeConsumptionRecord::STATUS_REBACK))
                            ->order('t.id desc')->limit('3')->queryAll();
            $historyXml = '';
            if (!empty($historys)) {
                $historyXml = '<Historys>';
                foreach ($historys as $value) {
                    $value['fname'] = htmlspecialchars($value['fname']);
    				$historyMoney = $value['entered_money'];
                    $hostoryTime = date('Y-m-d H:i:s', $value['create_time']);
                    $historyXml .= "<History><ShopID></ShopID><ShopName>{$value['fname']}</ShopName><Money>{$historyMoney}</Money><MoneyType>{$value['symbol']}</MoneyType><Time>{$hostoryTime}</Time></History>";
                    
                }
                $historyXml .= '</Historys>';
            }
            
            $points = Common::convertSingle($totalMoney, $member['type_id']);
            $discount = 0;
            $frozen = Common::convertSingle($frozen, $member['type_id']);
            if ($basePrice != 100)
                $totalMoney = bcdiv($totalMoney, bcdiv($basePrice, 100, 5), 2);
            $xml = '<Detail>';
            $xml.= '<Free>'.$points.'</Free>';
            $xml.= '<Discount>'.$discount.'</Discount>';
            $xml.= '<Freeze>'.$frozen.'</Freeze>';
            $xml.= '<Money>'.$totalMoney.'</Money>';
            $xml.= '<GaiNumber>'.$member['gai_number'].'</GaiNumber>';
            $xml.= $historyXml;
            $xml.= '</Detail>';
            echo $this->exportXml($xml);
        }catch (Exception $e){
            echo  $this->errorEndXml($e->getMessage());
        }
    }

    /**
     * 积分录入接口
     */
    public function actionIncome() {
        $this->addLog('apiGwt', "\r\n<hr><hr>1.post", $_POST);
        $this->actionType = '';
        $this->checkRequest();
       // $userPhone = $this->checkParam('UserPhone');    //用户手机号
        $cardNum = $this->checkParam('CardNum');    //充值卡号
        $symbol = $this->checkParam('Symbol');    //金额的币种	RMB或HKD
        // 消费金额转换成人民币
        if ($symbol == 'RMB') {
            $basePrice = 100;
        } elseif ($symbol == 'HKD' && $hkRate = $this->getConfig('rate', 'hkRate')) {
            $basePrice = $hkRate;
        } else {
            $this->errorEndXml('币种错误');
        }
        $rsa = new RSA();
        $cardPwd = $rsa->decrypt($this->checkParam('CardPwd'));    //充值卡密码（需加密）

        $gaiNumber = $this->getPost('Name'); //用户账号
        if ($gaiNumber != false) {
            $member = ApiMember::getMemberByGainumber($gaiNumber);
            if (empty($member))
                $this->errorEndXml('账号不存在');
            $userPhone = $member['mobile'];
        }else {
            $userPhone = $this->checkParam('UserPhone');    //用户手机号
            $member = $this->findMemberByPhone($userPhone);
        }

       // $member = $this->findMemberByPhone($userPhone);
        $this->addLog('apiGwt', "2.member", $member);
        if (empty($member)) {
            $this->errorEndXml('账号不存在或已失效');
        }

        /*         * --------新整理---------* */
        $card = Yii::app()->db->createCommand()->from('{{prepaid_card}}')
                ->where('number=:number', array(':number' => $cardNum))
                ->queryRow();
        $this->addLog('apiGwt', "3.card", $card);
        if (empty($card)) {
            $this->errorEndXml('卡号错误');
        } elseif(Tool::authcode($card['password'],'DECODE') != $cardPwd){
            $this->errorEndXml('密码错误');
        } elseif ($card['status'] != PrepaidCard::STATUS_UNUSED) {
            $this->errorEndXml('抱歉,此充值卡已被使用');
        }
        $memberType = MemberType::fileCache();
        if ($memberType === null)
            $this->errorEndXml('意外出错');
        $restult = PrepaidCardUse::recharge($card, $member, $memberType, true, false);
        if ($restult == false) {
            $this->errorEndXml('操作失败');
        }
        /*         * -----------------* */
        /*
          $card = $this->transactionIncome($cardNum,$cardPwd,$member['id'],$member['type_id']);
          if(empty($card)){
          $this->errorEndXml('操作失败');
          }
          // 记录
          ApiWealth::addWealth_gtIncome($member, $cardNum, $card);
         */
        $ApiMember = new ApiMember();
        $memberNow = $ApiMember->findByPk($member['id']);

        if (empty($memberNow)) {
            $this->errorEndXml('该账户不存在');
        }
        $totalCreditTodayMony = AccountBalance::getAccountAllBalance($memberNow['gai_number'], AccountBalance::TYPE_CONSUME);   //新旧消费账户总余额
        $totalFrozenMony = AccountBalance::getAccountAllBalance($memberNow['gai_number'], AccountBalance::TYPE_RETURN);   //新旧冻结账户总余额
        $money = $totalCreditTodayMony;
        $points = Common::convertSingle($money, $memberNow['type_id']);
        $frozen = Common::convertSingle($totalFrozenMony, $memberNow['type_id']);
        if ($basePrice != 100)
            $money = bcdiv($money, bcdiv($basePrice, 100, 5), 2);
        // 短信
        $ApiSmsLog = new ApiSmsLog();
        $ApiSmsLog->sendSms_gtIncome($userPhone, $memberNow['gai_number'], $cardNum, $card, $points, 1);
        $this->addLog('apiGwt', "<hr>end<hr>\r\n\r\n");
        $xml = "<Free>$points</Free><Discount>0</Discount><Freeze>$frozen</Freeze><Money>$money</Money><GaiNumber>" . $member['gai_number'] . "</GaiNumber>";
        echo $this->exportXml($xml);
    }

    /**
     * 
     */
    public function actionList() {
        $this->addLog('apiGwt', "1.post: ", $_POST);
        $this->actionType = '';
        $this->checkRequest();
       // $userPhone = $this->checkParam('UserPhone');    //用户手机号
        $checkCode = $this->checkParam('CheckCode');    //验证码
        $symbol = $this->checkParam('Symbol');    //金额的币种	RMB或HKD
        // 消费金额转换成人民币
        if ($symbol == 'RMB') {
            $basePrice = 100;
        } elseif ($symbol == 'HKD' && $hkRate = $this->getConfig('rate', 'hkRate')) {
            $basePrice = $hkRate;
        } else {
            $this->errorEndXml('币种错误');
        }
        // 解密
        $rsa = new RSA();
        $checkCode = $rsa->decrypt($checkCode);

        // 检查验证码
        if (!$this->checkVerifyCode($checkCode)) {
            $this->errorEndXml('验证码错误');
        }
        $this->addLog('apiGwt', "2.checked: ");
        // 获取会员id
        $gaiNumber = $this->getPost('Name'); //用户账号
        if ($gaiNumber != false) {
            $memberData = ApiMember::getMemberByGainumber($gaiNumber);
            if (empty($memberData))
                $this->errorEndXml('账号不存在');
            $userPhone = $memberData['mobile'];
        }else {
            $userPhone = $this->checkParam('UserPhone');    //用户手机号
            $memberData = $this->findMemberByPhone($userPhone);
        }
       // $memberData = $this->findMemberByPhone($userPhone);
        $this->addLog('apiGwt', "3.member", $memberData);
        if (empty($memberData)) {
            $this->errorEndXml('该用户不存在');
        }

        $newAccountConsume = AccountBalance::getTodayAmountByGaiNumber($memberData['gai_number']);  //新账户消费余额
        $oldAccountConsume = AccountBalanceHistory::getTodayAmountByGaiNumber($memberData['gai_number']);  //旧账户消费余额
        $newAccountFreeze = AccountBalance::getTodayAmountByGaiNumber($memberData['gai_number'], AccountBalance::TYPE_RETURN);    //新账户冻结余额
        $oldAccountFreeze = AccountBalanceHistory::getTodayAmountByGaiNumber($memberData['gai_number'], AccountBalance::TYPE_RETURN);   //旧账户冻结余额
        $totalAccountConsume = $newAccountConsume + $oldAccountConsume;
        $totalAccountFreeze = $newAccountFreeze + $oldAccountFreeze;
        $mony = $totalAccountConsume;

        $totalAccountConsume = Common::convertSingle($totalAccountConsume, $memberData['type_id']);
        $totalAccountFreeze = Common::convertSingle($totalAccountFreeze, $memberData['type_id']);
        if ($basePrice != 100)
            $mony = bcdiv($mony, bcdiv($basePrice, 100, 5), 2);
        $this->addLog('apiGwt', "4.data", $memberData);
        // 历史记录
        $sql = "select m.name,e.recharge_number,e.pay_money entered_money ,e.create_time,e.recharge_value from {{eptok_recharge_order}} e left join gaitong.gt_machine m on e.machine_id = m.id where e.member_id = ".$memberData['id']." and e.pay_status = ".self::EPORT_IS_PAY_STATUS." ORDER by e.id desc limit 3";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $offline = Yii::app()->db->createCommand()
            ->select(array('t.spend_money', 't.create_time', 'f.name as fname', 't.symbol', 't.base_price', 't.entered_money'))
            ->from('{{franchisee_consumption_record}} t')
            ->leftJoin('{{franchisee}} f', 't.franchisee_id=f.id')
            ->where('t.member_id=:mid and t.`status`<:status', array(':mid' => $memberData['id'], ':status' => FranchiseeConsumptionRecord::STATUS_REBACK))
            ->order('t.id desc')->limit('3')->queryAll();
        $mobileOrder = array();
        if(isset($result)){
            foreach ($result as $k => $v) {
                $v['fname'] = $v['name'].' - '.$v['recharge_number'].' - '.$v['recharge_value'];
                $v['symbol'] = 'RMB';
                $mobileOrder[] =$v;
            }
        }
        $historys = array_merge($mobileOrder,$offline);

        foreach ($historys as $k => $v) {
            $createTime[$k]=$v['create_time'];
        }
        if(empty($createTime)){
            $createTime =array();
        }
        if(empty($historys)){
            $historys =array();
        }
        array_multisort($createTime, SORT_DESC, $historys);
        $historys = array_slice($historys,0,3);
        $historyXml = '';
        if (!empty($historys)) {
            $historyXml = '<Historys>';
            foreach ($historys as $value) {
                $value['fname'] = htmlspecialchars($value['fname']);

                $historyMoney = $value['entered_money'];
                $hostoryTime = date('Y-m-d H:i:s', $value['create_time']);
                $historyXml .= "<History><ShopID></ShopID><ShopName>{$value['fname']}</ShopName><Money>{$historyMoney}</Money><MoneyType>{$value['symbol']}</MoneyType><Time>{$hostoryTime}</Time></History>";
                
            }
            $historyXml .= '</Historys>';
        }
        $dataXml = '<Detail><Free>' . $totalAccountConsume . '</Free>
                    <Discount>0</Discount>
                    <Freeze>' . $totalAccountFreeze . '</Freeze><Money>' . $mony . '</Money>' . $historyXml . '</Detail>';
        echo $this->exportXml($dataXml);
    }

    /**
     * 充值操作
     * 事务处理
     * 更新会员不可兑现积分
     * 更新当前充值卡信息，标识已用
     * @param int $cardNum
     * @param int $cardPwd
     * @param int $memberId
     * @param int $typeId
     * @return boolean
     */
    public function transactionIncome($cardNum, $cardPwd, $memberId, $typeId) {
        $card = Yii::app()->db->createCommand()->from('{{prepaid_card}}')
                ->where('number=:number and password=:password', array(':number' => $cardNum, ':password' => $cardPwd))
                ->queryRow();
        $this->addLog('apiGwt', "3.card", $card);
        if (empty($card)) {
            $this->errorEndXml('卡号或密码错误');
        } elseif ($card['status'] != PrepaidCard::STATUS_UNUSED) {
            $this->errorEndXml('抱歉,此充值卡已被使用');
        }
        $type = MemberType::fileCache();

        // 更新充值卡信息
        $updateCard['status'] = PrepaidCard::STATUS_USED;
        $updateCard['use_time'] = time();
        $updateCard['user_ip'] = Tool::ip2int(Yii::app()->request->userHostAddress);
        $updateCard['member_id'] = $memberId;

        // 积分返还卡
        if ($card['type'] == PrepaidCard::TYPE_GENERAL) {
            $value = sprintf("%.2f", $card['value'] * $type[$typeId]);
            $updateCard['money'] = $value;
        }

        // 充值卡
        elseif ($card['type'] == PrepaidCard::TYPE_SPECIAL) {
            $value = sprintf("%.2f", $card['value'] * $type['official']);
        }
        $this->addLog('apiGwt', "4.value: " . $value);
        if ($value <= 0) {
            $this->errorEndXml('不能充值');
        }
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 查询消费金额
            $nocash = Yii::app()->db->createCommand()
                    ->select(array('account_expense_nocash'))->from('{{member}}')->where('id=:id', array(':id' => $memberId))
                    ->queryScalar();
            $this->addLog('apiGwt', "5.nocash: " . $nocash);
            // 更新充值消费金额
            $updateMember = array('account_expense_nocash' => $nocash + $value);
            // 更新等级
            if ($card['type'] == PrepaidCard::TYPE_SPECIAL) {
                $updateMember['type_id'] = $type['officialType'];
            }
            Yii::app()->db->createCommand()
                    ->update('{{member}}', $updateMember, 'id=:id', array(':id' => $memberId));
            $this->addLog('apiGwt', "6.updateMember", $updateMember);

            // 使用充值卡
            Yii::app()->db->createCommand()->update('{{prepaid_card}}', $updateCard, 'id=' . $card['id']);
            $this->addLog('apiGwt', "7.updateCard", $updateCard);
            $transaction->commit();
            return array('cardId' => $card['id'], 'money' => $value, 'score' => $card['value']);
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * 格子铺消费接口
     */
    public function actionConsume() {
    	die;
        $this->actionType = '';
        $this->checkRequest();
        $rsa = new RSA();
        $checkCode = $rsa->decrypt($this->checkParam('CheckCode'));    //验证码
        // 检查验证码
        if (!$this->checkVerifyCode($checkCode)) {
            $this->errorEndXml('验证码错误');
        }
        $userPhone = $rsa->decrypt($this->checkParam('UserPhone'));    //用户手机号
        $machineId = $this->checkParam('MachineId');    //盖网机id
        $franchiseeId = $this->checkParam('FranchiseeId');    //加盟商id
        $payType = $this->checkParam('PayType');    //盖网机id
        $ip = $this->checkParam('IP');    //盖网机id
        $productId = $this->checkParam('ProductId');    //盖网机id
        $quantity = $this->checkParam('Quantity');    //盖网机id
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $GtApiProduct = new GtApiProduct();
            $goods = $GtApiProduct->findByPk($productId, array('id', 'name', 'market_price', 'price', 'back_rate', 'gt_rate', 'return_score', 'stock', 'thumbnail_id', 'status', 'activity_end_time'));
            if (empty($goods)) {
                $this->errorEndXml('请输选择商品!');
            } elseif ($goods['status'] != GtApiProduct::STATUS_PASS) {
                $this->errorEndXml('商品审核未通过!');
            } elseif ($goods['stock'] < 1) {
                $this->errorEndXml('商品库存不足!');
            }
            $moneyRMB = $goods['price'] * $quantity;    //消费金额
            if ($moneyRMB < 0.01) {
                $this->errorEndXml('商品价格有误!');
            }
            $symbol = 'RMB';    //金额的币种	RMB或HKD
            //盖网机的名称
            $GtApiMachine = new GtApiMachine();
            $machine = $GtApiMachine->findByPk($machineId, array('name', 'symbol'));
            if (empty($machine)) {
                $this->errorEndXml('盖网机不存在!');
            }
            $machineName = $machine['name'];
            $symbol = $machine['symbol'];
            // 消费金额转换成人民币
            if ($symbol == 'RMB') {
                $basePrice = 100;
            } elseif ($symbol == 'HKD' && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                $this->errorEndXml('币种错误');
            }
       // $moneyRMB = bcmul($money, bcdiv($basePrice, 100, 5), 2);

            $member = $this->findMemberByPhone($userPhone);
            if (empty($member)) {
                $this->errorEndXml('找不到用户');
            } elseif (($moneyRMB - $member['account_expense_nocash']) > 0) {
                $this->errorEndXml('积分不足');
            }
            // 加盟商
            $ApiFranchisee = new ApiFranchisee();
            $franchisee = $ApiFranchisee->findByPk($franchiseeId, array('name as franchisee_name', 'gai_discount', 'member_discount', 'city_id', 'district_id', 'street'));
            if (empty($franchisee)) {
                $this->errorEndXml('找不到商家');
            }

            $orderCode = Tool::buildOrderNo();
            $consumeCode = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . substr(time(), 8, 2);
            //执行消费  author：lc
            $orderDetialId = MachineOrder::consume($franchisee, $member, $userPhone, $moneyRMB, $goods, $payType, $franchiseeId, $quantity, $ip, $symbol, $basePrice, $machineId, $machineName, $consumeCode, $orderCode);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->errorEndXml('处理失败');
        }

        // 发短信并添加记录
        $ApiSmsLog = new ApiSmsLog();
        $money = $moneyRMB;
        if ($basePrice != 100)
            $money = bcdiv($moneyRMB, bcdiv($basePrice, 100, 5), 2);
        $ApiSmsLog->sendSmsMachineOrderConsume($member, $franchisee, $orderCode, $orderDetialId, $machineName, $goods, $quantity, $money, $userPhone, $consumeCode, $symbol, 1);

        // 商品库存是否更新?
        $member04 = ApiMember::getMemberGW4($member['gai_number']);
        $money = $member['account_expense_nocash'] - $moneyRMB;
        $money += $member04['account_expense_nocash'];
        $points = Common::convertSingle($money, $member['type_id']);
        $discount = Common::convertSingle($member['account_discount'] + $member04['account_discount'], $member['type_id']);
        $frozen = Common::convertSingle($member['account_frozen'] + $member04['account_frozen'], $member['type_id']);
        if ($basePrice != 100)
            $money = bcdiv($money, bcdiv($basePrice, 100, 5), 2);
        $xml = "<Detail><Free>$points</Free><Discount>$discount</Discount><Freeze>$frozen</Freeze><Money>$money</Money></Detail>";
        echo $this->exportXml($xml);
    }
    
    /**
     * 刷卡支付
     */
    public function actionConsumebypos()
    {
        try {
            //由于太长 所以分拆几行
           $this->encrypt_field = array(
                        'ShopID','Name','Money','Uptime',
                        'UserPhone','CardNum','Amount',
                        //'TransactionID',
                        'TransactionSerialNum','BusinessNum','DeviceNum',
                        'ShopName','Operator','DocNum',
                        'BatchNum','CardValidDate','TransactionDate','TransactionTime',
                        'TransactionType','SendCardBank','ReceiveBank','ClearAccountDate','SystemNumber','CardType');
            $post = $this->_decrypt($_POST);
            
            if(!PosInformation::checkCardNum($post['CardNum']))$this->errorEndXml('不是合法的卡号');
            if(!is_numeric($post['Amount']) || $post['Amount']<=0)$this->errorEndXml('输入金额请大于0的数字');
            
            $amount = $post['Amount'];
            
            $machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('machine_code =:machine_code', array(':machine_code' => $post['ShopID']))->queryRow();
            $symbol = $machine['symbol'];
            if (empty($machine)){
                $this->errorEndXml("盖机不存在");
            }
            
            // 消费金额转换成人民币
            if ($symbol == Symbol::RENMINBI || $symbol == Symbol::EN_DOLLAR) {
                $basePrice = 100;
                $symbol = Symbol::RENMINBI;
            } elseif ($symbol == Symbol::HONG_KONG_DOLLAR && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                $this->errorEndXml('币种错误');
            }
            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($amount, bcdiv($basePrice, 100, 5), 2);
            
            $gaiNumber = $post['Name'];
            
            if ($gaiNumber != false) {
                $member = ApiMember::getMemberByGainumber($gaiNumber);
                if (empty($member))
                    $this->errorEndXml('账号不存在');
                $userPhone = $member['mobile'];
            }
            
            $accountFlowTable = AccountFlow::monthTable();
            
            // 获取加盟商信息
            $franchisee = ApiFranchisee::getFranchisee($machine['biz_info_id']);
            if (empty($franchisee)) {
                throw new ErrorException(Yii::t('Machine', '不存在该商家'), 400);
            }
            
            
            //盖网通接口加入了折扣设定验证，这里也加入，为了防止截取url直接访问这边。
            if ($franchisee['member_discount'] == 0 || $franchisee['gai_discount'] == 0) {
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            } else if($franchisee['gai_discount'] > $franchisee['member_discount']){
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            }
            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                                ->select('id,gai_number,status')
                                ->from('{{member}}')
                                ->where('id=:id',array(':id'=>$franchisee['member_id']))
                                ->queryRow();
            if(empty($franchiseeMember)) $this->errorEndXml(Yii::t('MachineForGt', '商家的账号不存在!'));
            if($franchiseeMember['status'] > Member::STATUS_NORMAL)$this->errorEndXml(Yii::t('MachineForGt', '商家的账号已被禁用或删除!'));
            if($franchisee['member_id'] == $member['id'])$this->errorEndXml('您作为商家，不能在本店消费');
            
            // 人民币转换为积分
            $score = Common::convertSingle($moneyRMB, $member['type_id']);
            $recordId = "";
            $order_id = 'SNt'.Tool::buildOrderNo();

            //针对post消费，二次补录订单号，追加"-BL"后缀
            // ----------- modify by xuegang.liu@gmail.com   2016-04-11 15:28:32 -----------------------
            $order_id = (isset($post['isSupply']) && !empty($post['isSupply']) ) ? $order_id."-BL" : $order_id;
            //--------------------------------------- modify end --------------------------------------
            
            $data = array(
                    // ''=>
                    'moneyRMB' => $moneyRMB,
                    'basePrice' => $basePrice,
                    'symbol' => $symbol,
                    'machineSN' => !empty($post['TransactionID'])?$post['TransactionID']:'',//原本是TransactionSerialNum
                    'accountFlowTable' => $accountFlowTable,
                    'money' => $amount,
                    'serial_number'=>$order_id,
                    'pay_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POS,
                    'record_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
            );
            
            
            if(empty($member))$this->errorEndXml('盖网号没有对应的该盖网会员');
            $time = time();
            $pay_time = strtotime($post['TransactionDate'].$post['TransactionTime']);

            $pos_info = Yii::app()->db->createCommand()
                        ->select("id")
                        ->from(PosInformation::model()->tableName())
                        ->where("machine_id = :mid and card_num = :card_num  and transaction_time = :transaction_time and amount = :amount",
                        // ->where("machine_id = ':mid' and serial_num = ':serial_num' and doc_num = ':doc_num' and batch_num = ':batch_num'",
                                array(
                                    ':mid'=>(string)$machine['id'],
                                    ':card_num'=>(string)$post['CardNum'],
                                    ':transaction_time'=>111,
                                    ':amount'=>$amount,
                                )
                        )
                        ->queryRow();
            if(!empty($pos_info))$this->errorEndXml('已经提交过此订单，请重新下单');
            // 当月的流水表 在开启事务之前创建
            $monthTable = AccountFlow::monthTable();
            //开启事务
            $transaction = Yii::app()->db->beginTransaction();
            
            $posInformation_mod = new PosInformation();
            $posInformation_mod->is_supply = (isset($post['isSupply']) && !empty($post['isSupply'])) ? $post['isSupply'] : 0;
            $posInformation_mod->machine_id = $machine['id'];
            $posInformation_mod->machine_serial_num = $post['TransactionID'];
            $posInformation_mod->member_id = $member['id'];
            $posInformation_mod->phone = $post['UserPhone'];
            $posInformation_mod->card_num = $post['CardNum'];
            $posInformation_mod->amount = $amount;
            $posInformation_mod->serial_num = $post['TransactionSerialNum'];
            $posInformation_mod->transaction_time = $pay_time;
            $posInformation_mod->business_num = $post['BusinessNum'];
            $posInformation_mod->device_num = $post['DeviceNum'];
            $posInformation_mod->shopname = $post['ShopName'];
            $posInformation_mod->operator = isset($post['Operator'])?$post['Operator']:'';
            $posInformation_mod->doc_num = $post['DocNum'];
            $posInformation_mod->batch_num = $post['BatchNum'];
            $posInformation_mod->card_valid_date = strtotime($post['CardValidDate']);
            $posInformation_mod->transaction_type = $post['TransactionType'];
            $posInformation_mod->send_card_bank = isset($post['SendCardBank'])?$post['SendCardBank']:'';
            $posInformation_mod->receive_bank = isset($post['ReceiveBank'])?$post['ReceiveBank']:'';
            $posInformation_mod->clear_account_date = isset($post['ClearAccountDate'])?strtotime($post['ClearAccountDate']):'';
            $posInformation_mod->system_number = isset($post['SystemNumber'])?$post['SystemNumber']:'';
            $posInformation_mod->card_type = isset($post['CardType'])?$post['CardType']:'';
            
            if(!$posInformation_mod->save()) throw new ErrorException('保存失败');

            $ratio = Yii::app()->db->createCommand()
                    ->select("ratio")
                    ->from("{{member_type}}")
                    ->where("id = {$member['type_id']}")
                    ->queryScalar();

            $score = bcdiv($amount,$ratio,2);
            //插入recharge 因为冲突不能用save
            Yii::app()->db->createCommand()->insert(Recharge::tableName(),
                array(
                'member_id' => $member['id'],
                'code' =>$order_id,
                'ratio' => $ratio,
                'score'=>$score,
                'money' =>  $amount,
                'create_time' =>  $time,
                'pay_time' =>$pay_time,
                'status' => Recharge::STATUS_SUCCESS,
                'description' => '通过盖网通'.$post['ShopID'].'pos刷卡充值消费',
                'pay_type' => Recharge::PAY_TYPE_POS,
                'pay_mode' => 1,
                'by_gai_number' =>$member['gai_number'],
                'ip' => Tool::getIP(),
            ));
            $recarge_id = Yii::app()->db->getLastInsertID();

            // 会员余额表记录创建
            $arr = array(
                    'account_id'=>$member['id'],
                    'type'=>AccountBalance::TYPE_CONSUME,
                    'gai_number'=>$member['gai_number']
            );
            $memberAccountBalance = AccountBalance::findRecord($arr);
            
            // 会员充值流水 贷 +
            $MemberCredit = array(
                    'account_id' => $memberAccountBalance['account_id'],
                    'gai_number' => $memberAccountBalance['gai_number'],
                    'card_no' => $memberAccountBalance['card_no'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => $amount,
                    'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
                    'order_id' =>  $recarge_id,
                    'order_code' => $order_id,
                    'remark' => '使用POS机刷卡充值消费,金额为￥'.$amount,
                    'node' => AccountFlow::BUSINESS_NODE_EBANK_POS,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'by_gai_number' => $member['gai_number'],
            );
            // 会员账户余额表更新
            AccountBalance::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);
            // 借贷流水1.按月
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($MemberCredit));
            
            $transaction->commit();

            //判断 post消费 一个自然日内指定商店补录是否大于等于5条
            //  检查补录消费是否需要进行自动对账【分配处理】
            $extends = array();
            if($posInformation_mod->is_supply && PosInformation::checkSupplyCustomIsAutoCheck($machine['id'])){
                $extends = array('auto_check_fail'=>'post-bulu');
            }
            $resule = IntegralOfflineNew::offlineConsume($franchisee, $machine, $member, $data, $recordId,$extends);
            
            if ($resule !== true) {
                $this->errorEndXml($resule);
            }
            
            $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            $points = Common::convertSingle($totalMoney, $member['type_id']);
            $frozen = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_RETURN);

            // 发送短信
            $ApiSmsLog = new ApiSmsLog();
            $ApiSmsLog->sendSms_gtDeduct($member, $franchisee['name'], $amount, $score, $userPhone, $symbol, $totalMoney, $recordId, 1);
            
            
            // 历史记录
            $historys = Yii::app()->db->createCommand()
                        ->select(array('t.spend_money', 't.create_time', 'f.name as fname', 't.symbol', 't.base_price', 't.entered_money'))
                        ->from('{{franchisee_consumption_record}} t')
                        ->leftJoin('{{franchisee}} f', 't.franchisee_id=f.id')
                        ->where('t.member_id=:mid and t.`status`<:status', array(':mid' => $member['id'], ':status' => FranchiseeConsumptionRecord::STATUS_REBACK))
                        ->order('t.id desc')->limit('3')->queryAll();
                        $historyXml = '';
            if (!empty($historys)) {
                $historyXml = '<Historys>';
                foreach ($historys as $value) {
                    $historyMoney = $value['entered_money'];
                    $hostoryTime = date('Y-m-d H:i:s', $value['create_time']);
                    $historyXml .= "<History><ShopID></ShopID><ShopName>".htmlspecialchars($value['fname'])."</ShopName><Money>{$historyMoney}</Money><MoneyType>{$value['symbol']}</MoneyType><Time>{$hostoryTime}</Time></History>";
            
                }
                $historyXml .= '</Historys>';
            }
            
            
            $xml = '<Detail>';
            $xml.= '<Free>'.$points.'</Free>';
            $xml.= '<Discount>0</Discount>';
            $xml.= '<Freeze>'.$frozen.'</Freeze>';
            $xml.= '<Money>'.$totalMoney.'</Money>';
            $xml.= $historyXml;
            $xml.= '</Detail>';
            echo $this->exportXml($xml);
            
        }catch (Exception $e) {
            if(isset($transaction) && $transaction->getActive())$transaction->rollBack();
            $this->errorEndXml($e->getMessage());
            return false;
        }
    }
    /**
     * 刷卡支付
     */
    public function actionBLConsumebypos()
    {
        try {
            //由于太长 所以分拆几行
            $this->encrypt_field = array(
                'ShopID','Name','Money','Uptime',
                'UserPhone','CardNum','Amount',
                //'TransactionID',
                'TransactionSerialNum','BusinessNum','DeviceNum',
                'ShopName','Operator','DocNum',
                'BatchNum','CardValidDate','TransactionDate','TransactionTime',
                'TransactionType','SendCardBank','ReceiveBank','ClearAccountDate','SystemNumber','CardType');
            $post = $this->_decrypt($_POST);

            if(!PosInformation::checkCardNum($post['CardNum']))$this->errorEndXml('不是合法的卡号');
            if(!is_numeric($post['Amount']) || $post['Amount']<=0)$this->errorEndXml('输入金额请大于0的数字');

            $amount = $post['Amount'];

            $machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('machine_code =:machine_code', array(':machine_code' => $post['ShopID']))->queryRow();
            $symbol = $machine['symbol'];
            if (empty($machine)){
                $this->errorEndXml("盖机不存在");
            }

            // 消费金额转换成人民币
            if ($symbol == Symbol::RENMINBI || $symbol == Symbol::EN_DOLLAR) {
                $basePrice = 100;
                $symbol = Symbol::RENMINBI;
            } elseif ($symbol == Symbol::HONG_KONG_DOLLAR && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                $this->errorEndXml('币种错误');
            }
            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($amount, bcdiv($basePrice, 100, 5), 2);

            $gaiNumber = $post['Name'];

            if ($gaiNumber != false) {
                $member = ApiMember::getMemberByGainumber($gaiNumber);
                if (empty($member))
                    $this->errorEndXml('账号不存在');
                $userPhone = $member['mobile'];
            }
            $time = strtotime($post['TransactionDate'].$post['TransactionTime']);
            $pay_time = strtotime($post['TransactionDate'].$post['TransactionTime']);
            $accountFlowTable = PosAudit::monthTable($pay_time);

            // 获取加盟商信息
            $franchisee = ApiFranchisee::getFranchisee($machine['biz_info_id']);
            if (empty($franchisee)) {
                throw new ErrorException(Yii::t('Machine', '不存在该商家'), 400);
            }

            //盖网通接口加入了折扣设定验证，这里也加入，为了防止截取url直接访问这边。
            if ($franchisee['member_discount'] == 0 || $franchisee['gai_discount'] == 0) {
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            } else if($franchisee['gai_discount'] > $franchisee['member_discount']){
                $this->errorEndXml(Yii::t('MachineForGt', '盖机参数设定异常，无法消费'));
            }
            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                ->select('id,gai_number,status')
                ->from('{{member}}')
                ->where('id=:id',array(':id'=>$franchisee['member_id']))
                ->queryRow();
            if(empty($franchiseeMember)) $this->errorEndXml(Yii::t('MachineForGt', '商家的账号不存在!'));
            if($franchiseeMember['status'] > Member::STATUS_NORMAL)$this->errorEndXml(Yii::t('MachineForGt', '商家的账号已被禁用或删除!'));
            if($franchisee['member_id'] == $member['id'])$this->errorEndXml('您作为商家，不能在本店消费');

            // 人民币转换为积分
            $score = Common::convertSingle($moneyRMB, $member['type_id']);
            $recordId = "";
            $order_id = 'SNt'.Tool::buildOrderNo();
            //针对post消费，二次补录订单号，追加"-BL"后缀
            // ----------- modify by xuegang.liu@gmail.com   2016-04-11 15:28:32 -----------------------
            $order_id = (isset($post['isSupply']) && !empty($post['isSupply']) ) ? $order_id."-BL" : $order_id;
            //--------------------------------------- modify end --------------------------------------

            $data = array(
                // ''=>
                'moneyRMB' => $moneyRMB,
                'basePrice' => $basePrice,
                'symbol' => $symbol,
                'machineSN' => !empty($post['TransactionID'])?$post['TransactionID']:'',//原本是TransactionSerialNum
                'accountFlowTable' => $accountFlowTable,
                'money' => $amount,
                'serial_number'=>$order_id,
                'pay_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POS,
                'record_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
            );

            if(empty($member))$this->errorEndXml('盖网号没有对应的该盖网会员');
            // 当月的流水表 在开启事务之前创建
            $monthTable = PosAudit::monthTable($pay_time);
            //开启事务
            $transaction = Yii::app()->db->beginTransaction();

            $posInformation_mod = new PosInformation();
            $posInformation_mod->is_supply = (isset($post['isSupply']) && !empty($post['isSupply'])) ? $post['isSupply'] : 0;
            $posInformation_mod->machine_id = $machine['id'];
            $posInformation_mod->machine_serial_num = $post['TransactionID'];
            $posInformation_mod->member_id = $member['id'];
            $posInformation_mod->phone = $post['UserPhone'];
            $posInformation_mod->card_num = $post['CardNum'];
            $posInformation_mod->amount = $amount;
            $posInformation_mod->serial_num = $post['TransactionSerialNum'];
            $posInformation_mod->transaction_time = $pay_time;
            $posInformation_mod->business_num = $post['BusinessNum'];
            $posInformation_mod->device_num = $post['DeviceNum'];
            $posInformation_mod->shopname = $post['ShopName'];
            $posInformation_mod->operator = isset($post['Operator'])?$post['Operator']:'';
            $posInformation_mod->doc_num = $post['DocNum'];
            $posInformation_mod->batch_num = $post['BatchNum'];
            $posInformation_mod->card_valid_date = strtotime($post['CardValidDate']);
            $posInformation_mod->transaction_type = $post['TransactionType'];
            $posInformation_mod->send_card_bank = isset($post['SendCardBank'])?$post['SendCardBank']:'';
            $posInformation_mod->receive_bank = isset($post['ReceiveBank'])?$post['ReceiveBank']:'';
            $posInformation_mod->clear_account_date = isset($post['ClearAccountDate'])?strtotime($post['ClearAccountDate']):'';
            $posInformation_mod->system_number = isset($post['SystemNumber'])?$post['SystemNumber']:'';
            $posInformation_mod->card_type = isset($post['CardType'])?$post['CardType']:'';

            if(!$posInformation_mod->save()) throw new ErrorException('保存失败');
            $ratio = Yii::app()->db->createCommand()
                ->select("ratio")
                ->from("{{member_type}}")
                ->where("id = {$member['type_id']}")
                ->queryScalar();

            $score = bcdiv($amount,$ratio,2);
            //插入recharge 因为冲突不能用save
            Yii::app()->db->createCommand()->insert(Recharge::model()->tableName(),
                array(
                    'member_id' => $member['id'],
                    'code' =>$order_id,
                    'ratio' => $ratio,
                    'score'=>$score,
                    'money' =>  $amount,
                    'create_time' =>  $time,
                    'pay_time' =>$pay_time,
                    'status' => Recharge::STATUS_SUCCESS,
                    'description' => '通过盖网通'.$post['ShopID'].'pos刷卡充值消费',
                    'pay_type' => Recharge::PAY_TYPE_POS,
                    'pay_mode' => 1,
                    'by_gai_number' =>$member['gai_number'],
                    'ip' => Tool::getIP(),
                ));
            $recarge_id = Yii::app()->db->getLastInsertID();

            // 会员余额表记录创建
            $arr = array(
                'account_id'=>$member['id'],
                'type'=>AccountBalance::TYPE_CONSUME,
                'gai_number'=>$member['gai_number']
            );
            $memberAccountBalance = AccountBalance::findRecord($arr,false,$pay_time);

            // 会员充值流水 贷 +
            $MemberCredit = array(
                'account_id' => $memberAccountBalance['account_id'],
                'gai_number' => $memberAccountBalance['gai_number'],
                'card_no' => $memberAccountBalance['card_no'],
                'type' => AccountFlow::TYPE_CONSUME,
                'credit_amount' => $amount,
                'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
                'order_id' =>  $recarge_id,
                'order_code' => $order_id,
                'remark' => '使用POS机刷卡充值消费,金额为￥'.$amount,
                'node' => AccountFlow::BUSINESS_NODE_EBANK_POS,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                'by_gai_number' => $member['gai_number'],
            );
            // 会员账户余额表更新
            AccountBalance::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);
            // 借贷流水1.按月
            Yii::app()->db->createCommand()->insert($monthTable,
                AccountFlow::mergeField($MemberCredit,$pay_time));
            $transaction->commit();

            $resule = IntegralOfflineNew::offlineConsumePos($franchisee, $machine, $member, $data, $recordId,array(),$pay_time);
            if ($resule !== true) {
                $this->errorEndXml($resule);
            }

            $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            $points = Common::convertSingle($totalMoney, $member['type_id']);
            $frozen = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_RETURN);
            file_put_contents("txt.php",var_export($totalMoney,true));
            // 发送短信
            $ApiSmsLog = new ApiSmsLog();
            $ApiSmsLog->sendSms_gtRecord($member, $franchisee['name'], $amount, $score, $userPhone, $symbol, $totalMoney, $recordId, 1,$pay_time);

            // 历史记录
            $historys = Yii::app()->db->createCommand()
                ->select(array('t.spend_money', 't.create_time', 'f.name as fname', 't.symbol', 't.base_price', 't.entered_money'))
                ->from('{{franchisee_consumption_record}} t')
                ->leftJoin('{{franchisee}} f', 't.franchisee_id=f.id')
                ->where('t.member_id=:mid and t.`status`<:status', array(':mid' => $member['id'], ':status' => FranchiseeConsumptionRecord::STATUS_REBACK))
                ->order('t.id desc')->limit('3')->queryAll();
            $historyXml = '';
            if (!empty($historys)) {
                $historyXml = '<Historys>';
                foreach ($historys as $value) {
                    $historyMoney = $value['entered_money'];
                    $hostoryTime = date('Y-m-d H:i:s', $value['create_time']);
                    $historyXml .= "<History><ShopID></ShopID><ShopName>".htmlspecialchars($value['fname'])."</ShopName><Money>{$historyMoney}</Money><MoneyType>{$value['symbol']}</MoneyType><Time>{$hostoryTime}</Time></History>";

                }
                $historyXml .= '</Historys>';
            }

            $xml = '<Detail>';
            $xml.= '<Free>'.$points.'</Free>';
            $xml.= '<Discount>0</Discount>';
            $xml.= '<Freeze>'.$frozen.'</Freeze>';
            $xml.= '<Money>'.$totalMoney.'</Money>';
            $xml.= $historyXml;
            $xml.= '</Detail>';
            echo $this->exportXml($xml);

        }catch (Exception $e) {
            if(isset($transaction) && $transaction->getActive())$transaction->rollBack();
            $this->errorEndXml($e->getMessage());
            return false;
        }
    }
    /**
     * 刷卡支付
     */
    public function actionPosCheck()
    {
        try {
            $this->encrypt_field = array(
//                'TransactionID',//盖网通流水号
//                'MachineID',
//                'ShopID',
            );
            $post = $this->_decrypt($_POST);
            $post['TransactionID'] = str_replace("\\","",$post['TransactionID']);
            $sn = $post['TransactionID'];
            $AccountStr = json_decode($sn,true);
            $return = '';
            if(!empty($AccountStr)) {
                foreach ($AccountStr as $val) {
                    if(empty($val['transactionTime']) || empty($val['spend']) || empty($val['cardNum'])) continue;
                    $pay_time = strtotime($val['transactionDate'].$val['transactionTime']);
                    $amount = $val['spend'];
                    $card_num = $val['cardNum'];
                    $sql = "select id from {{pos_information}} where transaction_time = {$pay_time} and amount = {$amount} and card_num = "."'"."{$card_num}"."'";
                    Yii::log($sql);
                    $pos_info = Yii::app()->db->createCommand($sql)->queryScalar();
                    if (empty($pos_info)) {
                        $return .= $val['transactionID'] . '|';
                    }
                }
            }
            if (!empty($return)) {
                $return = rtrim($return, '|');
            }
            echo $this->exportXml('<Data>'.$return.'</Data>');
        }catch (Exception $e) {
            $this->errorEndXml($e->getMessage());
        }
    }
    
    /**
     * 刷卡支付
     */
    public function actionTransfer()
    {
        try {
            //由于太长 所以分拆几行
            $this->encrypt_field = array(
                    'ShopID',
                    'ReceiveName',
                    'UserPhone',
                    'PayName',
                    'Money',
                    'Uptime',
                    'TransactionID',
                    );
            $post = $this->_decrypt($_POST);
            
            if(!is_numeric($post['Money']) && $post['Money']<=0.01)
                $this->errorEndXml('价格金额必须大于0.01元');
            
            $receiveMember = ApiMember::getMemberByGainumber($post['ReceiveName']);
            if (empty($receiveMember))
                $this->errorEndXml('转账账号不存在或者状态异常');
            
            $payMember = ApiMember::getMemberByGainumber($post['PayName']);
            if (empty($payMember))
                $this->errorEndXml('付款人账号不存在或者状态异常');
            if($payMember['mobile']!=$post['UserPhone'])
                $this->errorEndXml('付款人手机号错误');
            
            /** 积分限额消费 zhaoxiang.liu*/
            $payPrice = $post['Money'];
            $totalMoney = AccountBalance::getAccountAllBalance($payMember['gai_number'], AccountBalance::TYPE_CONSUME);
            $pointData = MemberPoint::getMemberPoint($payMember['id'], $totalMoney);
            
            $memberPointResult = self::CheckMemberPoint($payMember,$payPrice,$pointData);
            if(!$memberPointResult["result"]){
            	$this->errorEndXml("亲爱的会员,目前您当月剩余可转账余额为￥{$memberPointResult["monthPoint"]},当日剩余可转账余额为￥{$memberPointResult["dayPoint"]}，此次转账已超过额度");
            }
            /** 积分限额消费 zhaoxiang.liu*/
            //获取能转账的余额
            
            $accountNew = AccountBalanceHistory::getTodayAmountByGaiNumber($payMember['gai_number'], AccountBalance::TYPE_CONSUME);
            
            if($accountNew<$post['Money'])
                $this->errorEndXml(Yii::t('MachineForGt','转账金额不足，能转账的金额为￥').$accountNew);
            
            $amount = bcmul($post['Money'], 1,2);
            $order_num = Tool::buildOrderNo();
            $time = time();

            // 当月的流水表 在开启事务之前创建
            $monthTable = AccountFlowHistory::monthTable();

            $db = Yii::app()->db;
            $transFerOrderTable = TransferOrder::model()->tableName();
            $order = $db->createCommand()
                    ->select('id')
                    ->from($transFerOrderTable)
                    ->where('machine_sn = :machine_sn',array(':machine_sn'=>$post['TransactionID']))
                    ->queryRow();
            if(!empty($order))
                $this->errorEndXml('该单已存在，请勿重复提交');
            $transaction = $db->beginTransaction();
            
            $insertData = array(
                    'order_num'=>$order_num,
                    'machine_sn'=>$post['TransactionID'],
                    'machine_id'=>$post['machineId'],
                    'source_type'=>TransferOrder::SOURCE_TYPE_GT,
                    'account'=>$amount,
                    'pay_id'=>$payMember['id'],
                    'receive_id'=>$receiveMember['id'],
                    'create_time'=>$time,
                    );
            $db->createCommand()->insert($transFerOrderTable, $insertData);
            $transferOrderId = $db->getLastInsertID();
            
            // 会员旧余额表记录创建
            $arr = array(
                    'account_id'=>$payMember['id'],
                    'type'=>AccountBalance::TYPE_CONSUME,
                    'gai_number'=>$payMember['gai_number']
            );
            $payMemberAccountBalance = AccountBalanceHistory::findRecord($arr);
            
            // 旧会员流水 贷 +
            $payMemberCredit = array(
                    'account_id' => $payMemberAccountBalance['account_id'],
                    'gai_number' => $payMemberAccountBalance['gai_number'],
                    'card_no' => $payMemberAccountBalance['card_no'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'debit_amount' => $amount,
                    'operate_type' => AccountFlow::OPERATE_TYPE_TRANSFER_MONEY,
                    'order_id' =>  $transferOrderId,
                    'order_code' => $order_num,
                    'remark' => '余额转账,金额为￥'.$amount,
                    'node' => AccountFlow::MEMBER_HISTORY_BALANCE_TRANSFER,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_TRANSFER,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'flag'=>AccountFlow::FLAG_SPECIAL,
            );
            // 旧会员账户余额表更新
            AccountBalanceHistory::calculate(array('today_amount' => -$amount), $payMemberAccountBalance['id']);
            // 旧借贷流水1.按月
            $db->createCommand()->insert($monthTable, AccountFlow::mergeField($payMemberCredit,$time));
            
            // 旧会员余额表记录创建
            $arr = array(
                    'account_id'=>$receiveMember['id'],
                    'type'=>AccountBalance::TYPE_CONSUME,
                    'gai_number'=>$receiveMember['gai_number']
            );
            $receiveAccountBalance = AccountBalanceHistory::findRecord($arr);
            
            // 旧会员充值流水 贷 +
            $receiveMemberCredit = array(
                    'account_id' => $receiveAccountBalance['account_id'],
                    'gai_number' => $receiveAccountBalance['gai_number'],
                    'card_no' => $receiveAccountBalance['card_no'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => $amount,
                    'operate_type' => AccountFlow::OPERATE_TYPE_TRANSFER_MONEY,
                    'order_id' =>  $transferOrderId,
                    'order_code' => $order_num,
                    'remark' => '余额转账,金额为￥'.$amount,
                    'node' => AccountFlow::MEMBER_HISTORY_BALANCE_TRANSFER_INTO,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_TRANSFER,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'flag'=>AccountFlow::FLAG_SPECIAL,
            );
            // 旧会员账户余额表更新
            AccountBalanceHistory::calculate(array('today_amount' => $amount), $receiveAccountBalance['id']);
            // 贷流水.按月
            $db->createCommand()->insert($monthTable, AccountFlow::mergeField($receiveMemberCredit,$time));
            
            $transaction->commit();
           
            /**积分限额zhaoxiang.liu**/
            self::UpdateMemberPoint($payMember, $payPrice, $pointData);
            /**积分限额zhaoxiang.liu**/
            
            //发送短信
            $smsConfig = $this->getConfig('smsmodel');
            $smsContent = '尊贵的客户'.$payMember['gai_number'].',您成功向'.$receiveMember['gai_number'].'转账了金额'.$amount.'元，请您核实。';
            $datas = array($payMember['gai_number'],$receiveMember['gai_number'],$amount);
            $tmpId = $smsConfig['roolOutMoneyId'];
//            $smsRes = SmsLog::addSmsLog($payMember['mobile'], $smsContent, $transferOrderId, SmsLog::TYPE_TRANSFER_ORDER);
            $smRes = SmsLog::addSmsLog($payMember['mobile'], $smsContent, 0,  SmsLog::TYPE_TRANSFER_ORDER,null, true,$datas, $tmpId);
            $smsContent2 = '尊贵的客户'.$receiveMember['gai_number'].',您的账户收到来自'.$payMember['gai_number'].'转账的金额'.$amount.'元，请您核实。';
//            $smsRes = SmsLog::addSmsLog($receiveMember['mobile'], $smsContent, $transferOrderId, SmsLog::TYPE_TRANSFER_ORDER);
            $datas2 =  array($receiveMember['gai_number'], $payMember['gai_number'], $amount);
            $tmpId2 = $smsConfig['roolInMoneyId'];
             $smRes = SmsLog::addSmsLog($receiveMember['mobile'], $smsContent2, 0,SmsLog::TYPE_TRANSFER_ORDER,null, true,$datas2, $tmpId2);
            
            
            $count = 3;
            $orderHistory = $db->createCommand()
                            ->select('ma.name,m.gai_number receiveName,tr.account,tr.create_time')
                            ->from($transFerOrderTable.' as tr')
                            ->leftjoin('gaitong.gt_machine as ma','ma.id = tr.machine_id')
                            ->leftjoin(Member::model()->tableName().' as m','m.id = tr.receive_id')
                            ->where('tr.pay_id = '.$payMember['id'])
                            ->order('tr.id desc')
                            ->offset(0)
                            ->limit($count)
                            ->queryAll();
            
            if (!empty($orderHistory)) {
                $historyXml = '<Historys>';
                foreach ($orderHistory as $value) {
                    $historyTime = date('Y-m-d H:i:s', $value['create_time']);
                    $historyXml .= "<History><ShopName>".htmlspecialchars($value['name'])."</ShopName><ReceiveName>{$value['receiveName']}</ReceiveName><Money>{$value['account']}</Money><MoneyType>RMB</MoneyType><Time>{$historyTime}</Time></History>";
                }
                $historyXml .= '</Historys>';
            }
            echo $this->exportXml($historyXml);
        }catch (Exception $e) {
            if(isset($transaction) && $transaction->getActive())$transaction->rollBack();
            $this->errorEndXml($e->getMessage());
            return false;
        }
    }
    
    
    /**
     * 判断积分额度够不够消费
     * array $member 会员信息
     * int $payPrice 消费金额
     * array $pointData 会员的消费级别
     */
    public static function CheckMemberPoint($member,$payPrice,$pointData){
    	if($pointData){
    		$dayLimitMoney=$pointData['dayLimitMoney'];
    		if($dayLimitMoney < $payPrice){
    			$dayPoint =  $pointData['flag'] ? $pointData['info']['day_limit_point'] : $pointData['info']['day_usable_point'];
    			$monthPoint =  $pointData['flag'] ? $pointData['info']['month_limit_point'] : $pointData['info']['month_usable_point'];
    			return array("result"=>false,"dayPoint"=>$dayPoint,"monthPoint"=>$monthPoint);
    			//$this->errorEndXml("亲爱的会员,目前您当月剩余可消费积分为{$monthPoint},当日剩余可消费积分为{$dayPoint}，此次消费已超过额度,请使用银行卡支付");
    		}else{
    			return array("result"=>true);
    		}
    	}else{
    		return array("result"=>true);
    	}
    }
    
    /**
     * 消费成功后更新会员限额积分
     * array $member 会员信息
     * int $payPrice 消费金额
     * array $pointData 会员的消费级别
     */
    public static function UpdateMemberPoint($member,$payPrice,$pointData){
    	if($pointData){
    		$dataArr=array();
    		$dayMoney='';
    		$mouthMoney='';
    		if( !$pointData['flag'] ){
    			$dayMoney=bcsub($pointData['info']['day_usable_point'],$payPrice,2);
    			$mouthMoney=bcsub($pointData['info']['month_usable_point'],$payPrice,2);
    			$dataArr['member_id']=$member['id'];
    			$dataArr['grade_id']=$pointData['info']['id'];
    			$dataArr['day_limit_point']=$dayMoney;
    			$dataArr['month_limit_point']=$mouthMoney;
    			$dataArr['day_point']=$pointData['info']['day_usable_point'];
    			$dataArr['month_point']=$pointData['info']['month_usable_point'];
    			$dataArr['create_time']=time();
    			$dataArr['update_time']=time();
    			Yii::app()->db->createCommand()->insert('{{member_point}}', $dataArr);
    		}else{
    			$dayMoney=bcsub($pointData['info']['day_limit_point'],$payPrice,2);
    			$mouthMoney=bcsub($pointData['info']['month_limit_point'],$payPrice,2);
    			Yii::app()->db->createCommand()->update('{{member_point}}', array(
    			'day_limit_point' => $dayMoney,
    			'month_limit_point' => $mouthMoney,
    			'update_time' => time(),
    			), 'member_id=:mid', array(':mid' => $member['id']));
    		}
    	}
    }
}
