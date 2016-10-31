<?php

/**
 * 拍卖活动结束提醒
 * 拍卖活动代理出价
 */
class AuctionCommand extends CConsoleCommand
{

	public $endRemaind = '尊敬的{0}用户，您关注的盖象商城 （{1}） 竞拍活动将于 {2} 结束，请抓紧时间参与竞拍。';
	public $aboveRemaind = '尊敬的{0}用户，您在盖象商城 （{1}） 竞拍活动设置的代理价（{2}元）于 {3} 已被超越 ，避免竞拍品被其他用户中标，请及时竞拍。';
    public $balanceRemaind = '尊敬的{0}用户，较早前您在盖象商城 （{1}） 竞拍活动设置了代理价（{2} 元），由于 {3} 您账户余额已不足（{4}元 ），目前已停止出价，避免竞拍品被其他用户中标，请及时充值积分再参与竞拍。';
    public $unsoldRemaind = '尊敬的{0}用户，您在盖象商城（{1}）竞拍活动的最新出价于{2} 活动结束时仍未达到保留价，根据规则，本次竞拍不成立，已取消。后续拍卖活动请关注盖象商城！';
	public $min20 = 1200;//20分钟
	public $min2  = 120;//2分钟

	/**
	 * 活动结束时发手机短信和站内信提醒
	 * 每2分钟执行一次
	*/
	public function actionRemaind()
	{
        //获取还没发送的提醒
		$now = time();
		$endTime = $now + $this->min20;//结束前20分钟

		$sql  = "SELECT * FROM {{seckill_auction_remind}} WHERE all_is_send=0 AND rules_end_time<=$endTime";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		if ( !empty($result) ) {
			$title   = Yii::t('member','拍卖活动即将结束提醒');
			$content =  Tool::getConfig('smsmodel', 'auctionEndRemindContent');
			$content = $content == '' ? $this->endRemaind : $content;
			$smsConfig = Tool::getConfig('smsmodel');
			$tmpId = $smsConfig['auctionEndRemindContentId'];

			foreach ($result as $v){
				$mobileSend = $v['mobile_is_send'];
				$siteSend = $v['message_is_send'];
				$content2 = str_replace(array('{0}','{1}','{2}'), array($v['member_gw'],$v['goods_name'], date('Y-m-d H:i:s',$v['rules_end_time'])), $content);

				//要发送站内短信,但是未发送成功的
				if ( $v['send_message']==1 && $v['message_is_send']==0 ) {
					Yii::app()->db->createCommand()->insert('{{message}}', array(
						'title' => $title,
						'content' => $content2,
						'create_time' => $now,
						'sender_id' => $v['member_id'],
						'sender' => 'GW',
						'receipt_time' => $now
					));

					$lastId = Yii::app()->db->lastInsertID;
					Yii::app()->db->createCommand()->insert('{{mailbox}}', array(
						'status' => 0,
						'message_id' => $lastId,
						'member_id' => $v['member_id']
					));

					$siteSend = 1;
					$sql = "UPDATE {{seckill_auction_remind}} SET message_is_send=$siteSend WHERE id=:id";
					Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v['id']));
				}else{
					$siteSend = 1;
				}

				//要发送手机短信,但是未发送成功的
				if ( $v['send_mobile']!='' && $v['mobile_is_send']==0 ) {
					$arr = array( $v['member_gw'], $v['goods_name'],date('Y-m-d H:i:s',$v['rules_end_time']) );
					SmsLog::addSmsLog($v['send_mobile'],$content2,0,SmsLog::TYPE_AUCTION,null,true,$arr,$tmpId);

					$mobileSend = 1;
					$sql = "UPDATE {{seckill_auction_remind}} SET mobile_is_send=$mobileSend WHERE id=:id";
					Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v['id']));
				}else{
					$mobileSend = 1;
				}

				//设置全部更新完成
				$allSend = ($mobileSend==1 && $siteSend==1) ? 1 : 0;
				$sql = "UPDATE {{seckill_auction_remind}} SET all_is_send=$allSend WHERE id=:id";
				Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v['id']));
			}

		}

		exit('success');
	}

    /**
	 * 代理出价处理
	 * (极其复杂,如果有几万人设置了代理出价,有可能会崩,若出现此情况,请修改出价规则,没必要每个人都出一次价,直接出到最高价即可)
	 * 每2分钟执行一次
	 */
	public function actionAgent()
	{

		//获取还没完成出价的记录的活动规则id
		$sqlRules = "SELECT rules_setting_id FROM {{seckill_auction_agent_price}} FORCE INDEX (rules_setting_id) WHERE all_over=0 GROUP BY rules_setting_id";
		$rules    = Yii::app()->db->createCommand($sqlRules)->queryAll();

		//若没有要执行内容,则跳过
		$rules = array_filter($rules);
		if ( empty($rules) ) { exit('success'); }
		$rulesIds = join(',',self::returnArrayColomn($rules, 'rules_setting_id'));

		//获取没结束的拍卖活动
		$sql = "SELECT rm.date_end,rs.id,rs.end_time,a.goods_id
				FROM {{seckill_rules_main}} rm
				LEFT JOIN {{seckill_rules_seting}} rs ON rm.id=rs.rules_id
				LEFT JOIN {{seckill_auction}} a ON rs.id=a.rules_setting_id
				WHERE a.rules_setting_id IN ($rulesIds) AND rs.is_force=0 AND a.status=1";
		$active = Yii::app()->db->createCommand($sql)->queryAll();
		if ( empty($active) ) { exit('success'); }

		// 当月的流水表（旧）
		$monthTableHistory = AccountFlowHistory::monthTable();
		// 当月的流水表 (新)
		$monthTable = AccountFlow::monthTable();

		//代理出价标题
		$title = "拍卖商品代理出价消息提醒";
		$smsConfig = Tool::getConfig('smsmodel');

		//代理出价被超越信息
		$contentAbove = isset($smsConfig['auctionMorethanAgentPriceRemindContent']) ? $smsConfig['auctionMorethanAgentPriceRemindContent'] : $this->aboveRemaind;
		//代理出价积分不够信息
		$contentBalance = isset($smsConfig['auctionAgentPriceLackOfBalanceRemindContent']) ?  $smsConfig['auctionAgentPriceLackOfBalanceRemindContent'] : $this->balanceRemaind;
		//代理出价流拍
		$contentUnsold = isset($smsConfig['auctionUnsoldContent']) ? $smsConfig['auctionUnsoldContent'] : $this->unsoldRemaind;

		$nowTime = time();
		$tmpId = 0;
		$arr = array();
		$tmpIdAbove = $smsConfig['auctionMorethanAgentPriceRemindContentId'];//代理价被超越
		$tmpIdBalance = $smsConfig['auctionAgentPriceLackOfBalanceRemindContentId'];//代理价余额不足
		$tmpIdUnsold = $smsConfig['auctionUnsoldContentId'];//流拍
		foreach ($active as $v) {

			//取活动结束时间, 结束的则跳过
			$sqlOver = "SELECT auction_end_time FROM {{seckill_auction_price}} WHERE rules_setting_id=$v[id] AND goods_id=$v[goods_id]";
			$endTime = Yii::app()->db->createCommand($sqlOver)->queryScalar();

			$leave   = $endTime - $nowTime;
			if ( $nowTime >= $endTime ) {
                //更新代理价表中的发消息字段
				$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1 WHERE rules_setting_id=:rsid AND goods_id=:gid";
				Yii::app()->db->createCommand($sql)->execute(array(':rsid'=>$v['id'], ':gid'=>$v['goods_id']));

				continue;
			}

			//按活动取代理出价,按出价时间先后排序
			$historyMoney = $currentMoney = 0;
			$sql  = "SELECT * FROM {{seckill_auction_agent_price}} FORCE INDEX (dateline) WHERE all_over=0 AND rules_setting_id=$v[id] AND goods_id=$v[goods_id] ORDER BY dateline ASC";
			$result = Yii::app()->db->createCommand($sql)->queryAll();
			if ( empty($result) ) { continue; }

			//若距活动结束只有2分钟,则直接将价格出到保留价(若当前价格还没超保留价, 若超过则在当前价格基础上加1倍加幅)
			if ( $leave>0 && $leave<=$this->min2 ) {
				$stop = 0;
				$unsold = 0;//是否流拍

				//此时间段除非页面有人出价,否则脚本不会再执行,所以除最高代理价者,其它人全部不出价,只发送短信通知
				$dateline = self::returnArrayColomn($result, 'dateline');
				$price    = self::returnArrayColomn($result, 'agent_price');
				array_multisort($price, SORT_DESC, $dateline, SORT_ASC, $result);

				foreach ($result as $k2=>$v2){
					$now = time();
					$isAbove = 0;

					$contentAbove2 = str_replace(array('{0}','{1}','{2}','{3}'), array($v2['member_gw'], $v2['goods_name'],$v2['agent_price'], date('Y-m-d H:i:s')), $contentAbove);
					if ( $stop == 0 ) {
						//开启事务
						$trans = Yii::app()->db->beginTransaction();
						try {
							//取拍卖的最新价格
							$sql = "SELECT * FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid FOR UPDATE";
							$row = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid' => $v2['rules_setting_id'], ':gid' => $v2['goods_id']));
							//有保留价,直接出到保留价,否则直接出到代理最高价
							$nowPrice = $row['reserve_price'] > 0 && $row['reserve_price'] > $row['price'] ? $row['reserve_price'] : $v2['agent_price'];

							//若当前最高出价为自已, 若有设置保留价并且出价已大于等于保留价则不再出价 否则跳过
							if ( $row['member_id'] == $v2['member_id'] && $row['price'] >= $row['reserve_price']){
								//更新代理价表中的发消息字段
								$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=1 WHERE id=:id";
								Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));

								$trans->commit();//事务结束

								$stop = 1;
								continue;
							}

							$tmpId = $tmpIdAbove;
							$arr = array($v2['member_gw'], $v2['goods_name'],$v2['agent_price'], date('Y-m-d H:i:s'));
							if ( $k2 == 0 && $v2['agent_price'] < $row['reserve_price']) {//流拍要发送的信息
								$unsold = 1;
								$contentAbove2 = str_replace(array('{0}','{1}','{2}'), array($v2['member_gw'], $v2['goods_name'], date('Y-m-d H:i:s',$endTime) ), $contentUnsold);
							    $tmpId = $tmpIdUnsold;
								$arr =  array($v2['member_gw'], $v2['goods_name'], date('Y-m-d H:i:s',$endTime));
							}

							//如果设置的代理价不够出价,则停止出价
							if ( $v2['agent_price'] < $nowPrice  ) {

								if ($v2['send_message'] == 1 && $v2['message_is_send'] == 0) {
									self::sendSiteMessage($title, $contentAbove2, $now, $v2['member_id']);
								}

								if ($v2['send_mobile'] != '' && $v2['mobile_is_send'] == 0) {
									SmsLog::addSmsLog($v2['send_mobile'], $contentAbove2, 0, SmsLog::TYPE_AUCTION,null,true,$arr, $tmpId);
								}

								//更新代理价表中的发消息字段
								$isAbove = $unsold == 1 ? 3 : 1;
								$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=$isAbove WHERE id=:id";
								Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));

								$trans->commit();//事务结束
								continue;
							}

							//获取旧余额的(消费账户)金额
							$historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME, $v2['member_id'], $v2['member_gw']);
							$historyMoney = $historyMoney > 0 ? $historyMoney : 0;
							if ($historyMoney < $nowPrice) {
								//获取新余额的(消费账户)金额
								$currentMoney = Member::getCurrentPrice(AccountInfo::TYPE_CONSUME, $v2['member_id'], $v2['member_gw']);
								$currentMoney = $currentMoney > 0 ? $currentMoney : 0;
							}
							//计算总余额
							$totalMoney = bcadd($currentMoney, $historyMoney, 2);
							if ($totalMoney < $nowPrice) {
								$tmpId = $tmpIdBalance;
								$arr = array($v2['member_gw'],$v2['goods_name'], $v2['agent_price'],date('Y-m-d H:i:s'),$nowPrice);
								$contentBalance2 = str_replace(array('{0}','{1}','{2}','{3}','{4}'), array($v2['member_gw'],$v2['goods_name'], $v2['agent_price'],date('Y-m-d H:i:s'),$nowPrice), $contentBalance);
								if ($v2['send_mobile'] != '' && $v2['mobile_is_send'] == 0) {
									SmsLog::addSmsLog($v2['send_mobile'], $contentBalance2, 0, SmsLog::TYPE_AUCTION,null,true,$arr, $tmpId);
								}

								if ($v2['send_message'] == 1 && $v2['message_is_send'] == 0) {
									self::sendSiteMessage($title, $contentBalance, $now, $v2['member_id']);
								}

								//更新代理价表中的发消息字段
								$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=2 WHERE id=:id";
								Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));

								$trans->commit();//事务结束
							}else{//流水操作

								//若当前最高价为自已,则先改状态,返还积分,再加价
								if ( $row['member_id'] == $v2['member_id'] ) {
									$sqlRecord = "UPDATE {{seckill_auction_record}} SET status=2 WHERE rules_setting_id=:rsid AND goods_id=:gid AND member_id=:mid";
									Yii::app()->db->createCommand($sqlRecord)->execute(array(':rsid'=>$v2['rules_setting_id'], ':gid'=>$v2['goods_id'], ':mid'=>$v2['member_id']));

									SeckillAuctionRecord::returnAuctionBalance($v2['rules_setting_id'], $v2['goods_id'], false);
								}

								$return = self::dealAcution($v2['member_id'], $v2['member_gw'], $nowPrice, $now, $historyMoney, $v2['rules_setting_id'], $v2['goods_id']);
                                if ( $return == true ){
									$trans->commit();//事务结束

									$stop = 1;

									//还还出局者积分,并记录流水(若最后最高出价者为自已,则积分已返还,无需再次返还)
									if ( $row['member_id'] != $v2['member_id'] ) {
										SeckillAuctionRecord::returnAuctionBalance($v2['rules_setting_id'], $v2['goods_id']);
									}

									//更新拍卖记录缓存
									AuctionData::updateActivityAuction($v2['rules_setting_id'], AuctionData::CACHE_TYPE_TWO, $v2['goods_id']);
								}else{
									$trans->rollback();
									echo $return;
									continue;
								}

							}

						} catch (CException $e) {
							$trans->rollback();
							exit('fail:' . $e->getMessage());
						}

					}else{//直接发消息
						$tmpId = $tmpIdAbove;
						$isAbove = 1;
						$arr = array($v2['member_gw'], $v2['goods_name'],$v2['agent_price'], date('Y-m-d H:i:s'));

						if ( $unsold == 1 ) {//流拍
							$tmpId = $tmpIdUnsold;
							$isAbove = 3;
							$arr = array($v2['member_gw'], $v2['goods_name'], date('Y-m-d H:i:s',$endTime));
							$contentAbove2 = str_replace(array('{0}','{1}','{2}'), array($v2['member_gw'], $v2['goods_name'], date('Y-m-d H:i:s',$endTime)), $contentUnsold);
						}

						if ($v2['send_message'] == 1 && $v2['message_is_send'] == 0) {
							self::sendSiteMessage($title, $contentAbove2, $now, $v2['member_id']);
						}

						if ($v2['send_mobile'] != '' && $v2['mobile_is_send'] == 0) {
							SmsLog::addSmsLog($v2['send_mobile'], $contentAbove2, 0, SmsLog::TYPE_AUCTION,null,true,$arr, $tmpId);
						}

						//更新代理价表中的发消息字段
						$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=$isAbove WHERE id=:id";
						Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));
					}

				}

			} else {
				//大于2分钟 每人出一轮价
				foreach ($result as $v2){
					$now = time();
					//加价幅度
					$sqlUp = "SELECT price_markup FROM {{seckill_auction}} WHERE goods_id=$v2[goods_id] AND rules_setting_id=$v2[rules_setting_id]";
					$markUp = Yii::app()->db->createCommand($sqlUp)->queryScalar();

					//开启事务
					$contentAbove2 = str_replace(array('{0}','{1}','{2}','{3}'), array($v2['member_gw'], $v2['goods_name'],$v2['agent_price'], date('Y-m-d H:i:s')), $contentAbove);
					$tmpId = $tmpIdAbove;
					$arr = array($v2['member_gw'], $v2['goods_name'],$v2['agent_price'], date('Y-m-d H:i:s'));

					$trans = Yii::app()->db->beginTransaction();
					try{
						//按先后顺序出价,代理价低的,直接发短信,不出价
						$sql = "SELECT * FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid FOR UPDATE";
						$row = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid' => $v2['rules_setting_id'], ':gid' => $v2['goods_id']));
						//每次加价,只加一个幅度
						$nowPrice = bcadd($markUp, $row['price'], 2);

						//若当前最高价为自已,则停止出价
						if ( $row['member_id'] == $v2['member_id'] ) {
							$trans->commit();//事务结束
							continue;
						}

						//如果设置的代理价不够出价,则停止出价,发送被超越信息
						if ( $v2['agent_price'] < $nowPrice  ) {

							if ($v2['send_message'] == 1 && $v2['message_is_send'] == 0) {
								self::sendSiteMessage($title, $contentAbove2, $now, $v2['member_id']);
							}

							if ($v2['send_mobile'] != '' && $v2['mobile_is_send'] == 0) {
								SmsLog::addSmsLog($v2['send_mobile'], $contentAbove2, 0, SmsLog::TYPE_AUCTION,null,true,$arr, $tmpId);
							}

							//更新代理价表中的发消息字段
							$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=1 WHERE id=:id";
							Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));

							$trans->commit();//事务结束
							continue;
						}

						//获取旧余额的(消费账户)金额
						$historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME, $v2['member_id'], $v2['member_gw']);
						$historyMoney = $historyMoney > 0 ? $historyMoney : 0;
						if ($historyMoney < $nowPrice) {
							//获取新余额的(消费账户)金额
							$currentMoney = Member::getCurrentPrice(AccountInfo::TYPE_CONSUME, $v2['member_id'], $v2['member_gw']);
							$currentMoney = $currentMoney > 0 ? $currentMoney : 0;
						}
						//计算总余额
						$totalMoney = bcadd($currentMoney, $historyMoney, 2);

						//钱够扣,则出价,否则只发消息
						if ($totalMoney < $nowPrice) {
							$tmpId = $tmpIdBalance;
							$arr = array($v2['member_gw'],$v2['goods_name'], $v2['agent_price'],date('Y-m-d H:i:s'),$nowPrice);
							$contentBalance2 = str_replace(array('{0}','{1}','{2}','{3}','{4}'), array($v2['member_gw'],$v2['goods_name'], $v2['agent_price'],date('Y-m-d H:i:s'),$nowPrice), $contentBalance);

							if ($v2['send_message'] == 1 && $v2['message_is_send'] == 0) {
								self::sendSiteMessage($title, $contentBalance2, $now, $v2['member_id']);
							}

							if ($v2['send_mobile'] != '' && $v2['mobile_is_send'] == 0) {
								SmsLog::addSmsLog($v2['send_mobile'], $contentBalance2, 0, SmsLog::TYPE_AUCTION,null,true,$arr, $tmpId);
							}

							//更新代理价表中的发消息字段
							$sql = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=1,message_is_send=1,all_over=1,is_above=2 WHERE id=:id";
							Yii::app()->db->createCommand($sql)->execute(array(':id'=>$v2['id']));

							$trans->commit();//事务结束
						}else{
							$return = self::dealAcution($v2['member_id'], $v2['member_gw'], $nowPrice, $now, $historyMoney, $v2['rules_setting_id'], $v2['goods_id']);

							if ($return == true){
								//还还出局者积分,并记录流水
								SeckillAuctionRecord::returnAuctionBalance($v2['rules_setting_id'], $v2['goods_id'], false);

								//更新拍卖记录缓存
								AuctionData::updateActivityAuction($v2['rules_setting_id'], AuctionData::CACHE_TYPE_TWO, $v2['goods_id']);

								$trans->commit();//事务结束
							}else{
								$trans->rollback();
								echo $return;
							}

						}

					}catch (CException $e) {
						$trans->rollback();
						exit('fail:' . $e->getMessage());
					}

				}

			}

		}


		exit('success');
	}

	/*按列返回数组元素*/
	protected function returnArrayColomn($array = array(), $columnName = '')
	{
		if ( empty($array) || $columnName == '' ) return array();

		if (function_exists("array_column")) {
			return array_column($array, $columnName);
		} else {
			return array_map(function($element) use($columnName){return $element[$columnName];}, $array);
		}
	}

	/**
	 * 发送站内消息
	 * @param $title 标题
	 * @param $content 内容
	 * @param $time 时间
	 * @param $memberId 会员ID
	 */
	protected function sendSiteMessage($title, $content, $time, $memberId)
	{
		Yii::app()->db->createCommand()->insert('{{message}}', array(
			'title' => $title,
			'content' => $content,
			'create_time' => $time,
			'sender_id' => $memberId,
			'sender' => 'GW',
			'receipt_time' => $time
		));

		$lastId = Yii::app()->db->lastInsertID;
		Yii::app()->db->createCommand()->insert('{{mailbox}}', array(
			'status' => 0,
			'message_id' => $lastId,
			'member_id' => $memberId
		));
	}

	/**
	 * 系统自动出价
	 * @param $userId 会员ID
	 * @param $gw 会员GW号
	 * @param $markup 当前增加价格
	 * @param $now 处理时间
	 * @param $historyMoney 旧帐要扣的钱
	 * @param $rulesSettingId 活动规则表ID
	 * @param $goodsId 商品ID
	 */
	protected function dealAcution($userId, $gw, $markup, $now, $historyMoney, $rulesSettingId, $goodsId)
	{
        //生成流水订单
		$flowCode = 'PM'.Tool::buildOrderNo();
		$flowData = array(
			'code' => $flowCode,
			'member_id' => $userId,
			'gai_number' => $gw,
			'money' => $markup,
			'create_time' => $now,
			'remark' => '拍卖商品积分处理，金额为：￥' . $markup,
			'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_FREEZE
		);
		Yii::app()->db->createCommand()->insert('{{seckill_auction_flow}}', $flowData);
		$flowId = Yii::app()->db->lastInsertID;

		//写流水扣积分
		$balanceHistory = $historyMoney > 0 ? ($historyMoney >= $markup ? $markup : $historyMoney) : 0;
		$balance        = $balanceHistory < $markup ? ($markup - $balanceHistory) : 0;
		if ( $balanceHistory > 0 ){//扣历史表
			$historyReturn = SeckillAuctionRecord::updateBalanceHistory( array('account_id' => $userId, 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $gw, 'money'=>$balanceHistory, 'flow_id'=>$flowId, 'flow_code'=>$flowCode) );
			if ( !is_bool($historyReturn) || $historyReturn == false ){
				 return $historyReturn;
			}
		}


		if ( $balance > 0 ){//若历史表不够扣, 则扣新表
			$balanceReturn = SeckillAuctionRecord::updateBalance( array('account_id' => $userId, 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $gw, 'money'=>$balance, 'flow_id'=>$flowId, 'flow_code'=>$flowCode) );
			if ( !is_bool($balanceReturn) || $balanceReturn == false ){
				return $balanceReturn;
			}
		}

		//更新拍卖价格表
		$price = array('price' => $markup, 'dateline' => $now, 'member_id' => $userId);
		Yii::app()->db->createCommand()->update(
			'{{seckill_auction_price}}',
			$price,
			'rules_setting_id=:rsid AND goods_id=:gid',
			array(':rsid'=>$rulesSettingId, ':gid'=>$goodsId)
		);

		//插入拍卖记录表
		$insert = array(
			'rules_setting_id' => $rulesSettingId,
			'goods_id' => $goodsId,
			'member_id' => $userId,
			'member_gw' => $gw,
			'status' => SeckillAuctionRecord::STATUS_ONE,
			'auction_time' => $now,
			'is_return' => SeckillAuctionRecord::IS_RETURN_NO,
			'balance_history' => $balanceHistory,
			'balance' => $balance,
			'flow_id' => $flowId,
			'flow_code' => $flowCode
		);
		Yii::app()->db->createCommand()->insert('{{seckill_auction_record}}', $insert);
		//$lastID = Yii::app()->db->getLastInsertID();

		//更新拍卖记录表,让别人出局
		$sql = "UPDATE {{seckill_auction_record}} SET status=:status WHERE rules_setting_id=:rsid AND goods_id=:gid AND member_id!=:mid";
		Yii::app()->db->createCommand($sql)->execute(array(':status'=>SeckillAuctionRecord::STATUS_TWO, ':rsid'=>$rulesSettingId, ':gid'=>$goodsId, ':mid'=>$userId));

		return true;
	}
}
