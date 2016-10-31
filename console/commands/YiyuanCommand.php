<?php
/**
 * 一元购
 * @author LC
 */
class YiyuanCommand extends CConsoleCommand
{
	public static $ratio = null;
	/**
	 * 生成唯一的会员编号 GW+8位数字
	 * @return string
	 */
	private function generateGaiNumber() {
		$number = str_pad(mt_rand('1', '99999999'), GAI_NUMBER_LENGTH, mt_rand(99999, 999999));
		return 'GW' . $number;
	}
	
	/**
	 * 添加会员
	 */
	private function addMember()
	{
		$columns = array(
				'gai_number',
// 				'username',
				'type_id',
				'status',
				'member_type',		//写死10
				'flag',
				'register_time'
		);
		$gaiNumber = $this->generateGaiNumber();
		$is = Yii::app()->db->createCommand("select id from gw_member where gai_number = '".$gaiNumber."'")->queryScalar();
		if($is)
		{
			$this->addMember();
		}
		else 
		{
			$startTime = strtotime('2015-04-01');
			$endTime = strtotime('2015-04-23');
			$register_time = rand($startTime, $endTime);
			$sql = "INSERT INTO gw_member(`gai_number`,`type_id`,`status`,`member_type`,`flag`,`referrals_id`,`register_time`) VALUE ('".$gaiNumber."',2,0,10,1,0,'".$register_time."');";
			Yii::app()->db->createCommand($sql)->execute();
			return $gaiNumber;	//不存在返回true
		}
	}
	/**
	 * 生成3680个会员
	 * php yiic.php yiyuan register --count=3680
	 */
	public function actionRegister($count)
	{
		//产生不重复的GW号
		$gaiNumbers = array();
		
		for($i=0;$i<$count;$i++)
		{
			$rs = $this->addMember();
			echo $rs."\n";
		}
	}
	
	/**
	 * 导出生成会员的GW号
	 * php yiic.php yiyuan export
	 */
	public function actionExport()
	{
		$data = array(
				array('GW号','商品名称', '商品ID','下单时间','支付时间','发货时间','签收时间','收货地址','物流单号','所属物流公司'),
		);
		$goods = array(
			"景泰蓝掐丝珐琅精品画" => 10,
			"爱马仕皮带" => 100,
			"路易威登/ LV女款手提包 漆皮 光滑 拉链 M90024" => 30,
			"SUNNYTIMES凌步 STS-03城市版 36V国产锂电普通款" => 250,
			"维也图城堡优质 干红葡萄酒2010（一箱6瓶装）" => 500,
			"苹果（APPLE）iPhone 6 128G版 4G手机 白/灰" => 250,
			"佳能（Canon） EOS 60D 单反套机（EF-S 18-200/3.5-5.6 IS镜头）" => 200,
			"价值3000的国内机票" => 500,
			"安黛儿面膜（6盒装）" => 500,
			"英国万色尼古盾 万色水母戒烟健康吸烟 阻99%焦油尼古丁（3盒装）" => 200,
			"【包邮】OSIM/傲胜OS-838 豪华型天王之王零重力太空舱全身按摩沙发天王椅" => 60,
			"Midea/美的 KFR-72LW/BP2DN1Y-KH(2)(B2)大3匹变频空调" => 280,
			"【GWYK】董聊聊第三套人民币同号钞" => 300,
			"2015羊年银质纪念币（羊年扇形银币）" => 500,
		);
		
		$goodsIds = array(
				"景泰蓝掐丝珐琅精品画" => 64846,
				"爱马仕皮带" => 64595,
				"路易威登/ LV女款手提包 漆皮 光滑 拉链 M90024" => 64939,
				"SUNNYTIMES凌步 STS-03城市版 36V国产锂电普通款" => 97491,
				"维也图城堡优质 干红葡萄酒2010（一箱6瓶装）" => 98632,
				"苹果（APPLE）iPhone 6 128G版 4G手机 白/灰" => 66878,
				"佳能（Canon） EOS 60D 单反套机（EF-S 18-200/3.5-5.6 IS镜头）" => 5144,
				"价值3000的国内机票" => 87638,
				"安黛儿面膜（6盒装）" => 84230,
				"英国万色尼古盾 万色水母戒烟健康吸烟 阻99%焦油尼古丁（3盒装）" => 69511,
				"【包邮】OSIM/傲胜OS-838 豪华型天王之王零重力太空舱全身按摩沙发天王椅" => 102690,
				"Midea/美的 KFR-72LW/BP2DN1Y-KH(2)(B2)大3匹变频空调" => 101553,
				"【GWYK】董聊聊第三套人民币同号钞" => 23086,
				"2015羊年银质纪念币（羊年扇形银币）" => 73316,
		);
		$goodsData = array();
		$j = 0;
		foreach ($goods as $name=>$good)
		{
			for ($i=$j;$i<$good+$j;$i++)
			{
				$goodsData[$i] = $name;
				$goodsData[$i] = array(
					'goods_name' => $name,
					'goods_id' => $goodsIds[$name],
				);
			}
			$j = $i;
		}
		$search = Yii::app()->db->createCommand("SELECT gai_number FROM gw_member WHERE `password`='' AND member_type=10;")->queryAll();
		foreach ($search as $k=>$s)
		{
			$s['goods_name'] = $goodsData[$k]['goods_name'];
			$s['goods_id'] = $goodsData[$k]['goods_id'];
			$data[] = $s;
		}
		$fp = fopen('file.csv', 'w');
		foreach ($data as $line) {
			foreach ($line as $k=>$l)
			{
				$line[$k] = iconv('utf-8','gb2312',$l); //中文转码 
			}
			fputcsv($fp, $line);
		}
		fclose($fp);
	}
	
	/**
	 * 将运营提供的数据导入到表中
	 * php yiic.php yiyuan import
	 */
	public function actionImport()
	{
		$file = fopen("import.csv","r");
		$i = 1;
		Yii::app()->db->createCommand("TRUNCATE TABLE gw_order_import;")->execute();
		while ($row = fgetcsv($file))
		{
			
			if($i>1)
			{
				$sql = "INSERT INTO gw_order_import(`gai_number`,`register_time`,`goods_id`,`pay_price`,`create_time`,`pay_time`,`delivery_time`,`sign_time`,`shipping_address`,`shipping_code`,`express`,`consignee`,`address`,`mobile`) ";
				$row[9] = iconv('gb2312','utf-8',$row[9]);
				$row[11] = iconv('gb2312','utf-8',$row[11]);
				$row[7] = strtotime($row[7]);
				$row[8] = iconv('gb2312','utf-8',$row[8]);
				if($row[8] == '自动签收')
				{
					$row[8] = $row[7] + 10*86400;	//如果是自动签收，签收时间加10天
				}
				else 
				{
					$row[8] = strtotime($row[8]);
				}
				$sql .= "VALUE ('".$row[0]."','".strtotime($row[2])."','".$row[3]."','".$row[4]."','".strtotime($row[5])."','".strtotime($row[6])."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$row[13]."','".$row[14]."');";
				Yii::app()->db->createCommand($sql)->execute();
			}
			$i++;
		}
		
		fclose($file);
	}
	
	/**
	 * 生成订单和流水
	 * php yiic.php yiyuan order
	 */
	public function actionOrder()
	{
		$sql = "SELECT * FROM gw_order_import WHERE is_import = 0 AND create_time>0;";
		$datas = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($datas as $data)
		{
			$this->_addOrder($data);
		}
	}
	
	private function _addOrder($data)
	{
		if($this->_createOrder($data) === false)
		{
			$this->_addOrder($data);
		}
	}
	
	/**
	 * 生成订单号
	 */
	public function _buildOrderNo($time, $length = 20, $prefix = null)
	{
		$main = date('YmdHis', $time) . substr(microtime(), 2, 3) . sprintf('%02d', mt_rand(0, 99));
		return $prefix . str_pad($main, $length, mt_rand(0, 99999));
	}
	
	private static $_baseTableName = 'account.gw_account_flow';
	private static $_baseHistoryTableName = 'account.gw_account_flow_history';
	/**
	 * 产生订单并走完相关的流程
	 */
	private function _createOrder($data)
	{
// 		print_r($data);die;
		$db = Yii::app()->db;
		//检测订单号是否重复
		$orderCode = $this->_buildOrderNo($data['create_time']);
		$is_code = $db->createCommand("SELECT id FROM gw_order WHERE `code`='".$orderCode."';")->queryScalar();
		if($is_code)
		{
			return false;
		}
		
		/***查询会员所需要的数据***/
		$memberData = $db->createCommand(
			"SELECT id,gai_number,referrals_id FROM gw_member WHERE gai_number='".$data['gai_number']."';"
		)->queryRow();
		$member_id = $memberData['id'];
		$pay_type = Order::PAY_TYPE_JF;
		$mode = 1;
		$pay_price = $data['pay_price'];
		$goods = $db->createCommand("SELECT store_id,category_id,gai_income,`name`,thumbnail FROM gw_goods WHERE id='".$data['goods_id']."';")->queryRow();
		$store_id = $goods['store_id'];
		$parent_code = $this->_buildOrderNo($data['create_time'], 19, 8);
		if(self::$ratio == null)
		{
			self::$ratio = Order::getOldIssueRatio();
		}
		$ratio = self::$ratio;
		$distribution_ratio = CJSON::encode($ratio);
		$stockup_time = ($data['delivery_time']+$data['create_time'])/2;
		$time = $data['create_time'];
		$tableTime = date('Ym', $time);
		$flowTableName = self::$_baseTableName . '_' . $tableTime; //流水日志表名
		$flowHistoryTableName = self::$_baseHistoryTableName . '_' . $tableTime; //流水日志表名
		$tran = $db->beginTransaction();
		try{
			/*** 1、产生订单***/
			$sql = <<<EOT
INSERT INTO gw_order VALUE(
	'',
	'$orderCode',
	'$member_id',
	'{$data['consignee']}',
	'{$data['address']}',
	'{$data['mobile']}',
	'',
	'$pay_type',
	'$mode',
	'2',
	'4',
	'{$data['express']}',
	'{$data['shipping_code']}',
	'2',
	'2',
	'0',
	'$pay_price',
	'$pay_price',
	'0',
	'1',
	'{$data['create_time']}',
	'$store_id',
	'{$data['pay_time']}',
	'{$data['delivery_time']}',
	'{$data['sign_time']}',
	'0',
	'',
	'',
	'',
	'0',
	'1',
	'0',
	'0',
	'10',
	'5',
	'',
	'',
	'0',
	'',
	'',
	'$parent_code',
	'$distribution_ratio',
	'0',
	'',
	'1',
	'0',
	'$stockup_time',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'1',
	'0',
	'$pay_price',
	''
);			
EOT;
	$db->createCommand($sql)->execute();	
	$orderId = $db->lastInsertID;
	$unit_score = 1.11;
	//服务费率
	$fee = Category::getCategoryServiceFeeRate($goods['category_id']);
	$fee = bcdiv($fee, 100, 2);
	//计算供货价 = 商家售价 - (商家售价*服务费率)
	$gai_price = bcsub($pay_price, bcmul($pay_price, $fee, 2), 2);
	//查询商品的规格
	$goodsSpecs = $db->createCommand("SELECT * FROM gw_goods_spec WHERE goods_id=".$data['goods_id'].";")->queryAll();
	$goodsSpec = '';
	if(!empty($goodsSpecs))
	{
		$goodsSpec = $goodsSpecs[rand(0, count($goodsSpecs)-1)];
	}
	$orderGoods = array(
			'id' => '',
			'goods_id' => $data['goods_id'],
			'order_id' => $orderId,
			'quantity' => 1,
			'unit_score' => $unit_score,
			'total_score' => $unit_score,
			'gai_price' => $gai_price,
			'unit_price' => $pay_price,
			'total_price' => $pay_price,
			'gai_income' => $goods['gai_income'],				//数字需要确认
			'spec_value' => $goodsSpec == '' ? '' : $goodsSpec['spec_value'],
			'target_id' => 0,
			'mode' => 0,
			'freight' => 0,
			'freight_payment_type' => 1,
			'goods_name' => $goods['name'],
			'goods_picture' => $goods['thumbnail'],
			'activity_ratio' => 0,
			'spec_id' => $goodsSpec == '' ? '' : $goodsSpec['id'],
			'ratio' => $fee,
			'original_price' => $pay_price,
			'integral_ratio' => 100,
			'special_topic_category' => ''
			);
	$db->createCommand()->insert('gw_order_goods', $orderGoods);
			/*** 1、产生订单***/
	
	/***2、产生流水***/
	// 会员余额更新（旧）
	$member = array('account_id' => $member_id, 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $data['gai_number']);
	$memberBalance = AccountBalanceHistory::findRecord($member);
	AccountBalanceHistory::calculate(array('today_amount' => $pay_price), $memberBalance['id']);  //给旧账户充值一块钱
	
	//调拨
	$balance =AccountBalance::findRecord($member);
	$balanceHistory = AccountBalanceHistory::findRecord($member);
	self::process($time,$flowTableName,$flowHistoryTableName, $balance, $balanceHistory, $pay_price, $orderCode, $orderId);
	/**-------------------------------------------**/	
	//支付
	//线上总账户
	$balanceOnlineOrder = CommonAccount::getAccount(CommonAccount::TYPE_ONLINE_TOTAL, AccountInfo::TYPE_TOTAL);
	$memberBalance = AccountBalance::findRecord($member);
	//会员扣钱
	$debit = array(
			'account_id' => $memberBalance['account_id'],
			'gai_number' => $memberBalance['gai_number'],
			'card_no' => $memberBalance['card_no'],
			'type' => $memberBalance['type'],
			'debit_amount' => $pay_price,
			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_PAY,
			'remark' => '订单支付成功，支付金额：￥' . $pay_price,
			'ratio' => 0.9,
			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PAY,
			'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
			'order_id' => $orderId,
			'order_code' => $orderCode,
	);
	$db->createCommand()->insert($flowTableName, self::mergeField($debit,$time));
	AccountBalance::calculate(array('today_amount' => -1*$pay_price), $memberBalance['id']); 
	//暂收账加钱
	$credit = array(
			'account_id' => $balanceOnlineOrder['account_id'],
			'gai_number' => $balanceOnlineOrder['gai_number'],
			'card_no' => $balanceOnlineOrder['card_no'],
			'type' => $balanceOnlineOrder['type'],
			'credit_amount' => $pay_price,
			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_PAY,
			'remark' => '订单支付成功,暂收账入账：￥'.$pay_price,
			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_FREEZE,
			'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
			'order_id' => $orderId,
			'order_code' => $orderCode,
	);
	$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
	AccountBalance::calculate(array('today_amount' => $pay_price), $balanceOnlineOrder['id']);
	
	/**-------------------------------------------**/
	//签收
	$time = $data['sign_time'];
	$tableTime = date('Ym', $time);
	$flowTableName = self::$_baseTableName . '_' . $tableTime; //流水日志表名
	//计算分配金额
	$totalAssign = bcsub($pay_price, $gai_price, OnlineCalculate::$median);	
	//盖网首次分配
	$gaiBaseIncome = bcmul($totalAssign, bcdiv($goods['gai_income'], 100, OnlineCalculate::$median), OnlineCalculate::$median);
	//可分配金额
	$surplusAssign = bcsub($totalAssign, $gaiBaseIncome, OnlineCalculate::$median);
	
	//暂收账扣钱
	$debit = array(
			'account_id' => $balanceOnlineOrder['account_id'],
			'gai_number' => $balanceOnlineOrder['gai_number'],
			'card_no' => $balanceOnlineOrder['card_no'],
			'type' => $balanceOnlineOrder['type'],
			'debit_amount' => $pay_price,
			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
			'remark' => '线上订单签收，线上盖网总账户出账：￥' . $pay_price,
			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_CONFIRM,
			'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
			'order_id' => $orderId,
			'order_code' => $orderCode,
	);
	$db->createCommand()->insert($flowTableName, self::mergeField($debit,$time));
	AccountBalance::calculate(array('today_amount' => -1*$pay_price), $balanceOnlineOrder['id']);
	
	//消费者待返还
	$returnMoney = bcmul(($ratio['ratio']['member'] / 100), $surplusAssign, OnlineCalculate::$median);
	if($returnMoney!=0)
	{
		$balanceReturnMember = AccountBalance::findRecord(array('account_id' => $member_id, 'type' => AccountBalance::TYPE_RETURN, 'gai_number' => $data['gai_number']));
		$credit = array(
				'account_id' => $balanceReturnMember['account_id'],
				'gai_number' => $balanceReturnMember['gai_number'],
				'card_no' => $balanceReturnMember['card_no'],
				'type' => $balanceReturnMember['type'],
				'credit_amount' => $returnMoney,
				'remark' => '线上订单签收，获得返还金额：￥' . $returnMoney,
				'ratio' => 0.9,
				'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REWARD,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
				'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
				'order_id' => $orderId,
				'order_code' => $orderCode,
		);
		$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
		AccountBalance::calculate(array('today_amount' => $returnMoney), $balanceReturnMember['id']);
		$db->createCommand()->update('gw_order', array(
				'return' => $returnMoney
		),'id='.$orderId);
	}
	
	
	//消费者推荐者
	$memberRefer = $db->createCommand("select id,gai_number from gw_member where id=".$memberData['referrals_id'])->queryRow();
	$memberReferBalance = AccountBalance::findRecord(array('account_id' => $memberRefer['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $memberRefer['gai_number']));
	$memberReferMoney = bcmul(($ratio['ratio']['memberRefer'] / 100), $surplusAssign, OnlineCalculate::$median);
	if($memberReferMoney !=0)
	{
		$credit = array(
				'account_id' => $memberReferBalance['account_id'],
				'gai_number' => $memberReferBalance['gai_number'],
				'card_no' => $memberReferBalance['card_no'],
				'type' => $memberReferBalance['type'],
				'credit_amount' => $memberReferMoney,
				'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
				'remark' => '线上订单签收，消费者推荐入账：￥' . $memberReferMoney,
				'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
				'distribution_ratio' => 0 == $totalAssign ? 0 : bcdiv($memberReferMoney, $totalAssign, OnlineCalculate::$median),
				'ratio' => 0.9,
				'by_gai_number' => $member['gai_number'], // 被推荐人的GW
				'order_id' => $orderId,
				'order_code' => $orderCode,
		);
		$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
		AccountBalance::calculate(array('today_amount' => $memberReferMoney), $memberReferBalance['id']);
	}
	
	//商家供货价
	$storeData = $db->createCommand("select member_id,referrals_id from gw_store where id=".$store_id)->queryRow();
	if(empty($storeData)) throw new Exception('商家不存在');
	$storeMemberData = $db->createCommand("select id,gai_number from gw_member where id=".$storeData['member_id'])->queryRow();
	if(empty($storeMemberData)) throw new Exception('商家会员不存在');
	$enterpriseArray = array('account_id' => $storeMemberData['id'], 'gai_number' => $storeMemberData['gai_number'], 'type' => AccountInfo::TYPE_MERCHANT);
	$enterpriseBalance = AccountBalance::findRecord($enterpriseArray);
	$credit = array(
			'account_id' => $enterpriseBalance['account_id'],
			'gai_number' => $enterpriseBalance['gai_number'],
			'card_no' => $enterpriseBalance['card_no'],
			'type' => $enterpriseBalance['type'],
			'credit_amount' => $gai_price,
			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
			'remark' => '线上订单签收，商家入供货价：￥' . $gai_price,
			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PAY_MERCHANT,
			'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
			'order_id' => $orderId,
			'order_code' => $orderCode,
	);
	$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
	AccountBalance::calculate(array('today_amount' => $gai_price), $enterpriseBalance['id']);
	//商家推荐人
	$businessReferMoney = 0;
	if($storeData['referrals_id']>0)
	{
		$businessRefer = Yii::app()->db->createCommand()
		->select(array('id' , 'gai_number', 'type_id'))
		->from('{{member}}')
		->where(array('and', 'id=:id', 'enterprise_id > 0'), array(':id' => $storeData['referrals_id']))->queryRow();
		if(!empty($businessRefer))
		{
			$businessReferMoney = bcmul(($ratio['ratio']['businessRefer'] / 100), $surplusAssign, OnlineCalculate::$median);
			if($businessReferMoney != 0)
			{
				$businessReferArray = array('account_id' => $businessRefer['id'], 'gai_number' => $businessRefer['gai_number'], 'type' => AccountInfo::TYPE_CONSUME);
				$businessReferBalance = AccountBalance::findRecord($businessReferArray);
				$credit = array(
						'account_id' => $businessReferBalance['account_id'],
						'gai_number' => $businessReferBalance['gai_number'],
						'card_no' => $businessReferBalance['card_no'],
						'type' => $businessReferBalance['type'],
						'credit_amount' => $businessReferMoney,
						'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
						'remark' => '线上订单签收，商家推荐入账：￥' . $businessReferMoney,
						'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION,
						'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
						'distribution_ratio' => 0 == $totalAssign ? 0 : bcdiv($businessReferMoney, $totalAssign, OnlineCalculate::$median),
						'ratio' => $businessRefer['type_id'] == 2 ? 0.9 : 0.45,
						'by_gai_number' => $member['gai_number'], // 被推荐人的GW
						'order_id' => $orderId,
						'order_code' => $orderCode,
				);
				$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
				AccountBalance::calculate(array('today_amount' => $businessReferMoney), $enterpriseBalance['id']);
			}
		}
	}
	
	//盖网收益
	$balanceGAI = CommonAccount::getAccount(CommonAccount::TYPE_GAI_INCOME, AccountInfo::TYPE_COMMON);
	$gaiTotal = $totalAssign - $returnMoney - $memberReferMoney - $businessReferMoney;
	$credit = array(
			'account_id' => $balanceGAI['account_id'],
			'gai_number' => $balanceGAI['gai_number'],
			'card_no' => $balanceGAI['card_no'],
			'type' => $balanceGAI['type'],
			'credit_amount' => $gaiTotal,
			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
			'remark' => '线上订单签收，盖网收益总账户入账' . $gaiTotal,
			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PROFIT,
			'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
			'distribution_ratio' => 0 == $totalAssign ? 0 : bcdiv($gaiTotal, $totalAssign, OnlineCalculate::$median),
			'order_id' => $orderId,
			'order_code' => $orderCode,
	);
	$db->createCommand()->insert($flowTableName, self::mergeField($credit,$time));
	AccountBalance::calculate(array('today_amount' => $gaiTotal), $balanceGAI['id']);
	/***2、产生流水***/
	
	$db->createCommand()->update('gw_order_import', array('is_import' => 1, 'import_time' => time()), "id=".$data['id']);
	//检测借贷平衡
	if (!DebitCredit::checkFlowByCode($flowTableName, $orderCode)) {
		throw new Exception('DebitCredit Error!', '009');
	}
			$tran->commit();
		}catch (Exception $e) {
            $tran->rollback();
            echo $e->getMessage();die;
            return false;
        }
		echo "Success! \n";
		return true;
	}
	
	public static function process($time,$newMonthTable, $oldMonthTable, Array $balance, Array $historyBalance, $money, $code, $orderId, $remark = '网银订单充值,支付订单') {
        if (bccomp($historyBalance['today_amount'], $money, 3) == -1) {
            return false;
        }
        //贷方(会员)
        $creditOld = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_ONE,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_ONE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );

        //贷方(会员)
        $creditNew = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_TWO,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_TWO,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );
        $db = Yii::app()->db;
        //转移金额
        $sql = 'update ' . ACCOUNT . '.gw_account_balance_history set today_amount=today_amount-' . $money . ' where id=' . $historyBalance['id'];
        $sql .= ';update ' . ACCOUNT . '.gw_account_balance set today_amount=today_amount+' . $money . ' where id=' . $balance['id'];
        $db->createCommand($sql)->execute();
        // 借贷流水1.按月
        $db->createCommand()->insert($newMonthTable, self::mergeField($creditNew,$time));
        $db->createCommand()->insert($oldMonthTable, self::mergeField($creditOld,$time));
        return true;
    }
    
    public static function mergeField(Array $field, $time) {
    	$publicArr = array(
    			'date' => date('Y-m-d', $time),
    			'create_time' => $time,
    			'week' => date('W', $time),
    			'week_day' => date('N', $time),
    			'hour' => date('G', $time),
    	);
    	return CMap::mergeArray($publicArr, $field);
    }
}