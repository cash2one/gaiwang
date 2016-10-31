<?php

class AuctionController extends Controller
{
    public $over = 300;//距活动结束时间(秒)

    /**
     * 拍卖首页
     */
    public function actionIndex($id)
    {
        //获取拍卖活动商品        
        $sql = "SELECT `a`.`goods_id`, `a`.`start_price`, `a`.`price_markup`, `a`.`status`, `a`.`rules_setting_id`, `a`.`store_id`, `g`.`name`, `g`.`thumbnail`
                FROM `gw_seckill_auction` `a`
                LEFT JOIN `gw_goods` `g` ON a.goods_id = g.id 
                WHERE rules_setting_id='" . $id . "' AND a.status=" . SeckillAuction::STATUS_YES . "";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        //分页
        $criteria = new CDbCriteria;
        $pages = new CPagination(count($result));
        $pages->pageSize = 20;
        $pages->applylimit($criteria);

        $pageResult = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $pageResult->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $pageResult->bindValue(':limit', $pages->pageSize);
        $result = $pageResult->queryAll();

        //获取活动时间
        $auction_time = AuctionData::getActivityAuction($id);

        // 获取广告位图片，过滤过期图片并最多4张图片
        $advert = Advert::getConventionalAdCache('seckill-auction-banner');
        $picAdvert = array();

        if (!empty($advert)) {
            foreach ($advert as $k => $v) {
                if (AdvertPicture::isValid($v['start_time'], $v['end_time'])) {
                    $picAdvert[] = $v;
                }
            }
        }

        $this->render('index', array(
            'picAdvert' => array_slice($picAdvert, 0, 4),
            'some_product' => $result,
            'time' => $auction_time,
            'pages' => $pages
        ));
    }

    /**
     * 拍卖商品详情页
     */
    public function actionDetail()
    {
        $id = intval($this->getParam('setting_id'));
        $goodsId = intval($this->getParam('goods_id'));
        $userId = intval(Yii::app()->user->id);//用户id

        if ($id < 1 || $goodsId < 1) {
            throw new CHttpException(404, Yii::t('auction', '参数不正确！'));
        }

        //商品缓存
        $result = AuctionData::getAuctionSettingGoods($id);
        if (empty($result) || !isset($result[$goodsId])) {
            throw new CHttpException(404, Yii::t('auction', '没有找到相关商品！'));
        } else {
            if ($result[$goodsId]['status'] == SeckillAuction::STATUS_NO) {
                throw new CHttpException(404, Yii::t('auction', '商品已停止拍卖！'));
            }
        }

        //取单个商品的拍卖结束时间
        $endTime = AuctionData::getAuctionEndTime($id, $goodsId);
        if (time() >= $endTime) {
            throw new CHttpException(404, Yii::t('auction', '该商品的拍卖时间已结束, 请查继续参与该活动的其它商品拍卖,谢谢！'));
        }

        //商品的运费信息
        $address = $fee = '';//用户默认收货地址/运费信息
        $quantity = 1;
        $sqlFreight = "SELECT g.freight_template_id,g.freight_payment_type,g.`size`,g.`weight`,f.valuation_type FROM {{goods}} g LEFT JOIN {{freight_template}} f ON g.freight_template_id = f.id WHERE g.id=:id";
        $freight = Yii::app()->db->createCommand($sqlFreight)->bindValue(':id', $goodsId)->queryRow();

        if ($userId > 0) {//登录状态,根据默认地址显示邮费
            //$address    = Address::getDefault($userId);
            $sqlAddress = "SELECT a.id, a.real_name, a.mobile, a.street, a.zip_code,a.city_id,
                r1.`name` AS province_name, r2.`name` AS city_name,
                r3.`name` AS district_name FROM {{address}} AS a
                LEFT JOIN {{region}} AS r1 ON a.province_id = r1.id
                LEFT JOIN {{region}} AS r2 ON a.city_id = r2.id
                LEFT JOIN {{region}} AS r3 ON a.district_id = r3.id
                WHERE a.member_id = :memberId AND a.`default`=:default ORDER BY a.`default` DESC LIMIT 1";
            $address = Yii::app()->db->createCommand($sqlAddress)->bindValue(':memberId', $userId)->bindValue(':default', Address::DEFAULT_YES)->queryRow();
            $address = $address == false ? '' : $address;

            if ($freight['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE) {//不包邮
                if (!empty($address)) {//有默认地址则显示对应邮费
                    $fee = ComputeFreight::compute($freight['freight_template_id'], $freight['size'], $freight['weight'], $address['city_id'], $freight['valuation_type'], $quantity);
                    foreach ($fee as $k => &$v) {
                        if ($k > 1) unset($fee[$k]);
                        $v['fee'] = Common::rateConvert($v['fee']);
                    }
                } else {//若没有默认地址只显示是否包邮
                    $fee = 'NO';//Yii::t('auction', '不包邮');
                }

            } else {
                $fee = Yii::t('auction', '包邮');
            }
        } else {//若没有登录则只登录是否包邮
            $fee = $freight['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE ? 'NO' : Yii::t('auction', '包邮');
        }

        //获取对应的商品
        $goods = WebGoodsData::checkGoodsStatus($goodsId);//调用接口

        //商品当前价格
        $nowData = Yii::app()->db->createCommand()
            ->select('price,reserve_price,auction_end_time')
            ->from('{{seckill_auction_price}}')
            ->where('rules_setting_id=:rsid AND goods_id=:gid', array(':rsid' => $id, ':gid' => $goodsId))
            ->queryRow();
        $nowPrice=$nowData['price'];
        // 商品组图数据
        $gallery = Yii::app()->db->createCommand()->from('{{goods_picture}}')->where('goods_id = :gid', array(':gid' => $goodsId))->queryAll();

        //拍卖记录缓存
        $auctionMens = $isFirst = $count = 0;
        $auctionRecord = AuctionData::getAuctionRecord($id, $goodsId);
        if (!empty($auctionRecord)) {//若数组过大导致服务器抽风,请改用数据库来计算拍卖出价人数
            $count = count($auctionRecord);
            $mensArray = array_unique($this->returnArrayColomn($auctionRecord, 'member_id'));
            $auctionMens = count($mensArray);
            if (intval($userId) > 0) {//是否首次参加该活动的拍卖
                if (!in_array($userId, $mensArray)) {
                    $isFirst = !empty($address) ? 1 : 0;
                }
            }
        } else {
            $isFirst = intval($userId) > 0 && !empty($address) ? 1 : 0;
        }

        //处理活动缓存
        $active = AuctionData::dealActiveTimes($id, $goodsId);

        $sqlMobile = "SELECT mobile FROM {{member}} WHERE id = '" . $userId . "'";
        $mobile = Yii::app()->db->createCommand($sqlMobile)->queryRow(); //获取到手机号码

        $activeResult = AuctionData::getAuctionGoodsRemind($id);
        $activeRemind = $activeResult[$id];//处理活动缓存
        $goodsRemind = $activeResult[$goodsId]; //处理商品缓存
        $goodsId = $goodsRemind['goods_id'];//商品缓存ID
        $rulesId = $activeRemind['rules_setting_id'];//活动缓存ID

        $sqlRemain = "SELECT
			skar.send_mobile,
			skar.send_message,
			skar.rules_setting_id,
			skar.goods_id,
			skar.member_id
			FROM {{seckill_auction}} sa 
			LEFT JOIN {{seckill_auction_remind}} skar
			ON skar.rules_setting_id = sa.rules_setting_id AND skar.goods_id = sa.goods_id
			LEFT JOIN {{seckill_rules_seting}} srs
			ON srs.id = sa.rules_setting_id
			LEFT JOIN {{seckill_rules_main}} srm
			ON srm.id = srs.rules_id
			LEFT JOIN {{goods}} g
			ON g.id = sa.goods_id
			WHERE sa.rules_setting_id ='" . $rulesId . "' AND sa.goods_id ='" . $goodsId . "' AND sa.status='" . SeckillAuction::STATUS_YES . "' AND skar.member_id = '" . $userId . "'";

        $auctionRemain = Yii::app()->db->createCommand($sqlRemain)->queryRow();//获取到是否有设置提醒（手机短信、站内信）

        $sqlE = "SELECT
		    concat(srm.date_start,' ',srs.start_time) AS start_time,
            concat(srm.date_end,' ',srs.end_time) AS end_time
			FROM {{seckill_auction}} sa 
			LEFT JOIN {{seckill_rules_seting}} srs
			ON srs.id = sa.rules_setting_id
			LEFT JOIN {{seckill_rules_main}} srm
			ON srm.id = srs.rules_id
			WHERE sa.rules_setting_id ='" . $rulesId . "' AND sa.goods_id ='" . $goodsId . "' AND sa.status='" . SeckillAuction::STATUS_YES . "'";

        $auctionEvery = Yii::app()->db->createCommand($sqlE)->queryRow();//获取到活动结束时间


        //刷新时查看是否已经被超越了
        $aboveData = array();
        if ($userId > 0) {
            $aboveData = Yii::app()->db->createCommand()
                ->select('is_above,agent_price')
                ->from('{{seckill_auction_agent_price}}')
                ->where('rules_setting_id=:rules_setting_id AND goods_id=:goods_id AND member_id=:member_id', array(':rules_setting_id' => $id, ':goods_id' => $goodsId, ':member_id' => $userId))
                ->queryRow();
            $aboveData['integral'] = HtmlHelper::priceConvertIntegral($aboveData['agent_price']);

            $reservePrice = $nowData['reserve_price'];
            $auctionEndTime = $nowData['auction_end_time'];
            $nowTime = time();
        }


        $sendMobile = !empty($mobile['mobile']) ? $mobile['mobile'] : '';


        //取出上一次的代理出价
        $agentData = Yii::app()->db->createCommand()
            ->select('id,agent_price,send_message,send_mobile')->from('{{seckill_auction_agent_price}}')
            ->where('rules_setting_id=:rules_setting_id AND goods_id=:goods_id AND member_id=:member_id', array(':rules_setting_id' => $id, ':goods_id' => $goodsId, ':member_id' => $userId))
            ->queryRow();

        $agent_price_id = $agentData['id'];

        if (!$agent_price_id) {
            //如果是第一次
            $minimumPrice = bcadd($nowPrice, 2 * $result[$goodsId]['price_markup'], 2);
        } else {
            //上一次价加两个幅度
            $last_agent_price = $agentData['agent_price'];
            $minimumPrice = bcadd($last_agent_price, 2 * $result[$goodsId]['price_markup'], 2);
            if ($minimumPrice <= $nowPrice) {
                $minimumPrice = bcadd($nowPrice, 2 * $result[$goodsId]['price_markup'], 2);
            }
        }

        $this->render('detail', array(
            'cache' => $result[$goodsId],
            'nowPrice' => $nowPrice,
            'gallery' => $gallery,
            'goods' => $goods,
            'active' => $active,
            'isFirst' => $isFirst,
            'address' => $address,
            'count' => $count,
            'mobile' => $mobile,
            'activeRemind' => $activeRemind,
            'auctionRemain' => $auctionRemain,
            'auctionEvery' => $auctionEvery,
            'userId' => $userId,
            'fee' => is_array($fee) ? array_slice($fee, 0, 1) : $fee,
            'auctionMens' => $auctionMens,
            'limit' => intval(AuctionData::MULTIPLES_LIMIT),
            'auctionRecord' => array_slice($auctionRecord, 0, 15),
            'aboveData' => $aboveData,
            'sendMobile' => $sendMobile,
            'minimumPrice' => $minimumPrice,
            'agentData' => $agentData
        ));
    }

    /**
     * 格式化出价,改成积分显示
     * @param $price 要格式化的价格
     * @return int|string
     */
    public function actionFormatPrice()
    {
        $price = $this->getParam('price');
        $data = array('price' => 0.00, 'credit' => 0.00);

        if ($price > 0) {
            $data['price'] = HtmlHelper::formatPrice($price);
            $data['credit'] = HtmlHelper::priceConvertIntegral($price);
        }

        echo json_encode($data);
        exit;
    }

    /**
     * 拍卖商品的出价记录列表
     * @throws CException
     */
    public function actionRecordList()
    {
        $id = intval($this->getParam('setting_id'));
        $goodsId = intval($this->getParam('goods_id'));

        $record = Goods::ArrDataProvider(AuctionData::getAuctionRecord($id, $goodsId), 15);
        $this->renderPartial('_recordList', array('dataProvider' => $record), false, true);
    }

    /**
     * 获取拍卖记录,用于右边栏
     * @param integer $rsId 活动规则表id
     * @param integer $id 拍卖记录表id
     * @param integer $goodsId 产品的id
     */
    public function actionGetAuctionRecord()
    {
        $rulesSettingId = intval($this->getParam('rsid'));
        $goodsId = intval($this->getParam('goods_id'));
        $id = intval($this->getParam('id'));

        $data = AuctionData::getAuctionRecord($rulesSettingId, $goodsId, $id);

        echo json_encode($data);
        exit;
    }

    /**
     * 处理拍卖加价请求,记录拍卖历史,积分处理
     */
    public function actionSetAuctionRecord()
    {

        $userId = Yii::app()->user->id;//用户id
        $data = array('success' => false, 'message' => Yii::t('auction', '非法操作'), 'change' => 0, 'url' => '', 'price' => 0, 'row' => array());
        if (empty($userId)) {//检查是否登录
            $data['url'] = $this->createAbsoluteUrl('/member/home/login');
            $data['message'] = Yii::t('auction', '请先登录再进行操作');
            echo json_encode($data);
            exit;
        }

        //查看是否有填写默认地址,如果没有则要求填写一个
        $address = Yii::app()->db->createCommand()
            ->select('COUNT(*) AS num')
            ->from('{{address}}')
            ->where('member_id=:mid AND `default`=:default', array(':mid' => $userId, ':default' => Address::DEFAULT_YES))
            ->queryScalar();
        if (intval($address) < 1) {
            $data['change'] = 4;
            $data['url'] = $this->createAbsoluteUrl('/member/address/index');
            $data['message'] = Yii::t('auction', '请先添加/设置默认收货地址再进行拍卖');
            echo json_encode($data);
            exit;
        }

        $gw = Yii::app()->user->gw;//用户GW号
        $rulesSettingId = intval($this->getParam('rsid'));//活动规则表id
        $goodsId = intval($this->getParam('goods_id'));//商品id
        $multiple = intval($this->getParam('multiple'));//加价倍数
        $postPrice = floatval($this->getParam('price'));//提交的当前拍卖价

        //活动是否在时间范围内
        if (!AuctionData::checkAuctionIsExpired($rulesSettingId, $goodsId)) {
            $data['message'] = Yii::t('auction', '活动还没开始或已经结束');
            echo json_encode($data);
            exit;
        }

        //活动商品是否关闭状态
        $goodsCache = AuctionData::getAuctionSettingGoods($rulesSettingId);
        if (empty($goodsCache) || !isset($goodsCache[$goodsId])) {
            $data['message'] = Yii::t('auction', '不存在该商品');
            echo json_encode($data);
            exit;
        } else {
            if ($goodsCache[$goodsId]['status'] == 0) {
                $data['message'] = Yii::t('auction', '该商品已停止拍卖');
                echo json_encode($data);
                exit;
            }
        }

        //限制不能购买自已店铺的商品
        $storeId = $goodsCache[$goodsId]['store_id'];
        if (!empty($storeId) && $storeId == $this->getSession('storeId')) {
            $data['message'] = Yii::t('auction', '不能购买自己店铺的商品');
            echo json_encode($data);
            exit;
        }

        //加价倍数不能超过限制,若加价倍数设置为0则不限制
        $multiple = $multiple < 1 ? 1 : $multiple;
        if ($multiple > AuctionData::MULTIPLES_LIMIT && AuctionData::MULTIPLES_LIMIT > 0) {
            $data['message'] = Yii::t('auction', '加价幅度不能超过:') . HtmlHelper::formatPrice($multiple * $goodsCache[$goodsId]['price_markup']);
            echo json_encode($data);
            exit;
        }

        //入拍卖记录 扣当前用户积分
        $now = time();
        $flag = 0;
        $trans = Yii::app()->db->beginTransaction(); // 事务执行
        try {
            //取拍卖的最新价格
            $sql = "SELECT * FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid FOR UPDATE";
            $row = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid' => $rulesSettingId, ':gid' => $goodsId));

            if (empty($row)) {//添加拍卖商品是会插入一条记录,如果不存在,则添加商品时肯定出错了
                $data['change'] = 1;
                $data['success'] = true;
                $data['message'] = Yii::t('auction', '服务器繁忙');
                echo json_encode($data);
                exit;
            }

            if ($row['price'] <= $goodsCache[$goodsId]['start_price']) {//没有人出价拍卖
                $newPrice = $goodsCache[$goodsId]['start_price'];

            } else {//已有人出价拍卖
                $newPrice = $row['price'];

                if ($userId == $row['member_id']) {//如果是自已出的价,则不能再加价
                    $data['change'] = 3;
                    $data['message'] = Yii::t('auction', '当前您已是最高价,无须继续出价');
                    echo json_encode($data);
                    exit;
                }

                if ($postPrice != $row['price']) {//拍卖价已发生改变,则提示用户价格已发生改变
                    $data['change'] = 1;
                    $data['success'] = true;
                    $data['price'] = $row['price'];
                    $data['message'] = Yii::t('auction', '拍卖价格发生改变,是否重新出价');;
                    echo json_encode($data);
                    exit;
                }
            }

            //检查积分是否足够扣除
            //$totalMoney = AccountBalance::getAccountAllBalance($gw, AccountInfo::TYPE_CONSUME);
            //获取新余额的(消费账户)金额
            $currentMoney = Member::getCurrentPrice(AccountInfo::TYPE_CONSUME, $userId, $gw);
            $currentMoney = $currentMoney > 0 ? $currentMoney : 0;
            //获取旧余额的(消费账户)金额
            $historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME, $userId, $gw);
            $historyMoney = $historyMoney > 0 ? $historyMoney : 0;
            //计算总余额
            $totalMoney = bcadd($currentMoney, $historyMoney, 2);

            //$markup = number_format($newPrice + $multiple * $goodsCache[$goodsId]['price_markup'], 2, '.', '');
            $markup = bcadd($newPrice, $multiple * $goodsCache[$goodsId]['price_markup'], 2);
            if ($totalMoney < $markup) {
                $data['change'] = 2;
                $data['message'] = Yii::t('auction', '积分余额不足,无法进行加价');
                echo json_encode($data);
                exit;
            }

            //生成流水订单
            $flowCode = 'PM' . Tool::buildOrderNo();
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
            $balance = $balanceHistory < $markup ? ($markup - $balanceHistory) : 0;
            if ($balanceHistory > 0) {//扣历史表
                $historyReturn = SeckillAuctionRecord::updateBalanceHistory(array('account_id' => $userId, 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $gw, 'money' => $balanceHistory, 'flow_id' => $flowId, 'flow_code' => $flowCode));
                if (!is_bool($historyReturn) || $historyReturn == false) {
                    $data['message'] = $historyReturn;
                    echo json_encode($data);
                    exit;
                }
            }


            if ($balance > 0) {//若历史表不够扣, 则扣新表
                $balanceReturn = SeckillAuctionRecord::updateBalance(array('account_id' => $userId, 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $gw, 'money' => $balance, 'flow_id' => $flowId, 'flow_code' => $flowCode));
                if (!is_bool($balanceReturn) || $balanceReturn == false) {
                    $data['message'] = $balanceReturn;
                    echo json_encode($data);
                    exit;
                }
            }

            //更新拍卖价格表
            $price = array('price' => $markup, 'dateline' => $now, 'member_id' => $userId);
            Yii::app()->db->createCommand()->update(
                '{{seckill_auction_price}}',
                $price,
                'rules_setting_id=:rsid AND goods_id=:gid',
                array(':rsid' => $rulesSettingId, ':gid' => $goodsId)
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
            $lastId = Yii::app()->db->getLastInsertID();

            //更新拍卖记录表,让别人出局
            $sql = "UPDATE {{seckill_auction_record}} SET status=:status WHERE rules_setting_id=:rsid AND goods_id=:gid AND member_id!=:mid";
            Yii::app()->db->createCommand($sql)->execute(array(':status' => SeckillAuctionRecord::STATUS_TWO, ':rsid' => $rulesSettingId, ':gid' => $goodsId, ':mid' => $userId));

            $trans->commit();//事务结束

            $flag = 1;
        } catch (Exception $e) {//抛出异常处理
            $trans->rollback();

            $data['message'] = $e->getMessage();
            echo json_encode($data);
            exit;
        }

        if ($flag == 1) {//所有操作完成
            //还还出局者积分,并记录流水
            SeckillAuctionRecord::returnAuctionBalance($rulesSettingId, $goodsId);

            //更新拍卖记录缓存
            AuctionData::updateActivityAuction($rulesSettingId, AuctionData::CACHE_TYPE_TWO, $goodsId);

            //如果加价时间在活动结束的五分钟内,则延迟五分钟结束活动
            $auctionCache = AuctionData::getActivityAuction($rulesSettingId);//活动缓存
            $endTime = $row['auction_end_time'];//单个活动商品的结束时间
            $remainTime = $endTime - $now;
            if ($remainTime <= $this->over && $remainTime > 0) {//五分钟内
                $newGoodsTime = $endTime + $this->over;

                //取拍卖活动的最长时间
                $timeMax = Yii::app()->db->createCommand()
                    ->select('MAX(auction_end_time)')
                    ->from('{{seckill_auction_price}}')
                    ->where('rules_setting_id=:rsid', array(':rsid' => $rulesSettingId))
                    ->queryScalar();
                $timeMax = $timeMax > $newGoodsTime ? $timeMax : $newGoodsTime;

                //更新gw_seckill_rules_main表的结束日期(为了保留入口)
                $newEndDate = date('Y-m-d', $timeMax);
                if ($newEndDate != $auctionCache['date_end']) {
                    $sql = "UPDATE {{seckill_rules_main}} SET date_end=:end WHERE id=:id";
                    Yii::app()->db->createCommand($sql)->execute(array(':end' => $newEndDate, ':id' => $auctionCache['rules_id']));
                }

                //更新gw_seckill_rules_seting表的结束时间
                $newEndTime = date('H:i:s', $timeMax);
                $sql = "UPDATE {{seckill_rules_seting}} SET end_time=:end WHERE id=:id";
                Yii::app()->db->createCommand($sql)->execute(array(':end' => $newEndTime, ':id' => $auctionCache['id']));

                //更新单个商品的活动结束时间
                $sql = "UPDATE {{seckill_auction_price}} SET auction_end_time=:end WHERE rules_setting_id=:rid AND goods_id=:gid";
                Yii::app()->db->createCommand($sql)->execute(array(':end' => $newGoodsTime, ':rid' => $rulesSettingId, ':gid' => $goodsId));

                //更新活动缓存
                AuctionData::updateActivityAuction($rulesSettingId);
                $key = ActivityData::CACHE_FESTIVE_ACTIVITY_OVER_ALL;
                Tool::cache($key)->delete($key);//活动列表页缓存
                $siteKey = ActivityData::CACHE_ACTIVITY_CONFIG;
                Tool::cache($siteKey)->delete($siteKey);//活动首页缓存

                //更新最高出价者的记录,让系统可以继续代理出价
                /*$sqlAgent = "SELECT id FROM {{seckill_auction_agent_price}} WHERE agent_price =
                    (SELECT MAX(agent_price) FROM {{seckill_auction_agent_price}}
                    WHERE rules_setting_id=$rulesSettingId AND goods_id=$goodsId)
                    ORDER BY dateline ASC";
                $agentId = Yii::app()->db->createCommand($sqlAgent)->queryScalar();
                Yii::app()->db->createCommand("UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=0,message_is_send=0,all_over=0 WHERE id=$agentId")->execute();*/

                //更新代理价,由于最高那个出价者不一定够钱扣,所以将所有高于当前价的出价者全部放开
                $sqlAgent = "UPDATE {{seckill_auction_agent_price}} SET mobile_is_send=0,message_is_send=0,all_over=0,is_above=0 WHERE rules_setting_id=$rulesSettingId AND goods_id=$goodsId AND agent_price>=$markup";
                Yii::app()->db->createCommand($sqlAgent)->execute();

            }

            $sql = "SELECT is_above FROM {{seckill_auction_agent_price}} WHERE rules_setting_id=$rulesSettingId AND goods_id=$goodsId AND member_id=$userId";
            $isAbove = Yii::app()->db->createCommand($sql)->queryScalar();
            if ( $isAbove == 1 || $isAbove == 2 ){
                //更新已被超越字段,终止出价被超越弹窗
                $sqlAbove = "UPDATE {{seckill_auction_agent_price}} SET is_above=0 WHERE rules_setting_id=$rulesSettingId AND goods_id=$goodsId AND member_id=$userId";
                Yii::app()->db->createCommand($sqlAbove)->execute();
            }

            $data['row'] = array(
                'id' => $lastId,
                'member_id' => $userId,
                'member_gw' => $gw,
                'status' => SeckillAuctionRecord::STATUS_ONE,
                'auction_time' => $now,
                'balance_history' => $balanceHistory,
                'balance' => $balance
            );

            $data['change'] = 1;
            $data['success'] = true;
            $data['message'] = '加价成功';

        }

        echo json_encode($data);
        exit;
    }

    /*返回数组元素*/
    protected function returnArrayColomn($array = array(), $column_name = '')
    {
        if (empty($array) || $column_name == '') return array();

        if (function_exists("array_column")) {
            return array_column($array, $column_name);
        } else {
            return array_map(function ($element) use ($column_name) {
                return $element[$column_name];
            }, $array);
        }
    }

    //增加提醒设置
    public function actionRemainAdd()
    {
        $member_id = Yii::app()->user->id;//用户id
        $addRemain1 = array();
        $addRemain2 = array();
        $mobileVerifyCode = array();
        $cookie = array();
        $cookieResult = array();

        if ($this->isAjax() && $this->isPost()) {

            $goods_id = $this->getPost('goods_id');
            $rules_setting_id = $this->getPost('rules_setting_id');
            $send_mobile = $this->getPost('send_mobile');//会员手机号码
            $send_message = $this->getPost('send_message');
            $new_mobile = $this->getPost('new_mobile');//新的手机号码
            $gw = Yii::app()->user->gw;//用户GW号
            $mobileVerifyCode = $this->getPost('mobileVerifyCode');

            $activeResult = AuctionData::getAuctionGoodsRemind($rules_setting_id);//处理商品缓存
            $gds = $activeResult[$goods_id];
            $goodsId = $gds['goods_id'];//商品缓存ID
            $rds = $activeResult[$rules_setting_id];
            $rulesId = $rds['rules_setting_id'];//活动缓存ID


            if (!empty($new_mobile) && !empty($mobileVerifyCode)) {

                $cookie = Yii::app()->request->cookies[$new_mobile];
                if (empty($cookie)) {
                    $tip = array();
                    $tip['is_error3'] = '手机验证码未发送或已失效，请点击获取！';
                    exit(json_encode($tip));
                    return false;
                }
                $cookieResult = unserialize(Tool::authcode($cookie->value, 'DECODE'));
                $verifyCode = $cookieResult['verifyCode'];//手机验证码 cookie

                if ($verifyCode != $mobileVerifyCode) {
                    $tip = array();
                    $tip['is_error1'] = '手机验证码有误,请重新获取！';
                    exit(json_encode($tip));
                }
            }

            $sqlRemain = "SELECT
			sa.rules_setting_id,
			sa.goods_id, 
			g.name AS goods_name,
			concat(srm.date_end,' ',srs.end_time) AS end_time
			FROM {{seckill_auction}} sa 
			LEFT JOIN {{seckill_rules_seting}} srs
			ON srs.id = sa.rules_setting_id
			LEFT JOIN {{seckill_rules_main}} srm
			ON srm.id = srs.rules_id
			LEFT JOIN {{goods}} g
			ON g.id = sa.goods_id
			WHERE sa.rules_setting_id ='" . $rulesId . "' AND sa.goods_id ='" . $goodsId . "' AND sa.status='" . SeckillAuction::STATUS_YES . "'";

            $auctionRemain = Yii::app()->db->createCommand($sqlRemain)->queryRow();

            $rules_end_time = strtotime($auctionRemain['end_time']);//活动结束时间


            $dataRemain1 = array(
                'goods_id' => $auctionRemain["goods_id"],
                'rules_setting_id' => $auctionRemain["rules_setting_id"],
                'rules_end_time' => $rules_end_time,
                'goods_name' => $auctionRemain["goods_name"],
                'member_id' => $member_id,
                'member_gw' => $gw,
                'send_mobile' => $send_mobile,
                'send_message' => $send_message,
                'dateline' => date('Y-m-d H:i:s'),
            );

            $dataRemain2 = array(
                'goods_id' => $auctionRemain["goods_id"],
                'rules_setting_id' => $auctionRemain["rules_setting_id"],
                'rules_end_time' => $rules_end_time,
                'goods_name' => $auctionRemain["goods_name"],
                'member_id' => $member_id,
                'member_gw' => $gw,
                'send_mobile' => $new_mobile,
                'send_message' => $send_message,
                'dateline' => date('Y-m-d H:i:s'),
            );


            if (empty($new_mobile)) {
                $addRemain1 = Yii::app()->db->createCommand()->insert('{{seckill_auction_remind}}', $dataRemain1);
            } else {
                $addRemain2 = Yii::app()->db->createCommand()->insert('{{seckill_auction_remind}}', $dataRemain2);
            }

            if ($addRemain1 || $addRemain2) {
                $tip = array();
                $tip['success'] = '设置提醒成功！';
                exit(json_encode($tip));
            } else {
                $tip = array();
                $tip['error'] = '设置提醒失败！';
                exit(json_encode($tip));
            }

        }

    }


    //修改提醒设置
    public function actionRemainUpdate()
    {
        $member_id = Yii::app()->user->id;//用户id
        $updateRemain1 = array();
        $updateRemain2 = array();
        $mobileVerifyCode = array();


        if ($this->isAjax() && $this->isPost()) {

            $goods_id = $this->getPost('goods_id');
            $rules_setting_id = $this->getPost('rules_setting_id');
            $send_mobile = $this->getPost('send_mobile');
            $send_message = $this->getPost('send_message');
            $new_mobile = $this->getPost('new_mobile');//新的手机号码

            $activeResult = AuctionData::getAuctionGoodsRemind($rules_setting_id);//处理商品缓存
            $gds = $activeResult[$goods_id];
            $goodsId = $gds['goods_id'];//商品缓存ID
            $rds = $activeResult[$rules_setting_id];
            $rulesId = $rds['rules_setting_id'];//活动缓存ID
            $mobileVerifyCode = $this->getPost('mobileVerifyCode');


            if (!empty($new_mobile) && !empty($mobileVerifyCode)) {

                $cookie = Yii::app()->request->cookies[$new_mobile];
                if (empty($cookie)) {
                    $tip = array();
                    $tip['is_error3'] = '手机验证码未发送或已失效，请点击获取！';
                    exit(json_encode($tip));
                    return false;
                }
                $cookieResult = unserialize(Tool::authcode($cookie->value, 'DECODE'));
                $verifyCode = $cookieResult['verifyCode'];//手机验证码 cookie

                if ($verifyCode != $mobileVerifyCode) {
                    $tip = array();
                    $tip['is_error1'] = '手机验证码有误,请重新获取！';
                    exit(json_encode($tip));
                }
            }

            $sqlRemain = "SELECT
			sa.rules_setting_id,
			sa.goods_id, 
			g.name AS goods_name,
			concat(srm.date_end,' ',srs.end_time) AS end_time
			FROM {{seckill_auction}} sa 
			LEFT JOIN {{seckill_rules_seting}} srs
			ON srs.id = sa.rules_setting_id
			LEFT JOIN {{seckill_rules_main}} srm
			ON srm.id = srs.rules_id
			LEFT JOIN {{goods}} g
			ON g.id = sa.goods_id
			WHERE sa.rules_setting_id ='" . $rulesId . "' AND sa.goods_id ='" . $goodsId . "' AND sa.status='" . SeckillAuction::STATUS_YES . "'";

            $auctionRemain = Yii::app()->db->createCommand($sqlRemain)->queryRow();


            if (empty($new_mobile)) {
                $updateRemain1 = Yii::app()->db->createCommand()->update('{{seckill_auction_remind}}', array('send_mobile' => $send_mobile, 'send_message' => $send_message), 'goods_id=:gid AND rules_setting_id=:rid AND member_id=:mid', array(':gid' => $auctionRemain["goods_id"], ':rid' => $auctionRemain["rules_setting_id"], ':mid' => $member_id));//更新设置提醒
            } else {
                $updateRemain2 = Yii::app()->db->createCommand()->update('{{seckill_auction_remind}}', array('send_mobile' => $new_mobile, 'send_message' => $send_message), 'goods_id=:gid AND rules_setting_id=:rid AND member_id=:mid', array(':gid' => $auctionRemain["goods_id"], ':rid' => $auctionRemain["rules_setting_id"], ':mid' => $member_id));//更新设置提醒
            }
            if ($updateRemain1 || $updateRemain2) {
                $tip = array();
                $tip['success'] = '设置提醒成功！';
                exit(json_encode($tip));
            } else {
                $tip = array();
                $tip['error'] = '设置提醒失败！';
                exit(json_encode($tip));
            }

        }


    }

    //删除提醒设置
    public function actionRemainDelete()
    {
        $member_id = Yii::app()->user->id;//用户id

        if ($this->isAjax() && $this->isPost()) {

            $goods_id = $this->getPost('goods_id');
            $rules_setting_id = $this->getPost('rules_setting_id');
            $send_mobile = $this->getPost('send_mobile');
            $send_message = $this->getPost('send_message');

            $activeResult = AuctionData::getAuctionGoodsRemind($rules_setting_id);//处理商品缓存
            $gds = $activeResult[$goods_id];
            $goodsId = $gds['goods_id'];//商品缓存ID
            $rds = $activeResult[$rules_setting_id];
            $rulesId = $rds['rules_setting_id'];//活动缓存ID

            $sqlRemain = "SELECT
			sa.rules_setting_id,
			sa.goods_id, 
			g.name AS goods_name,
			concat(srm.date_end,' ',srs.end_time) AS end_time
			FROM {{seckill_auction}} sa 
			LEFT JOIN {{seckill_rules_seting}} srs
			ON srs.id = sa.rules_setting_id
			LEFT JOIN {{seckill_rules_main}} srm
			ON srm.id = srs.rules_id
			LEFT JOIN {{goods}} g
			ON g.id = sa.goods_id
			WHERE sa.rules_setting_id ='" . $rulesId . "' AND sa.goods_id ='" . $goodsId . "' AND sa.status='" . SeckillAuction::STATUS_YES . "'";

            $auctionRemain = Yii::app()->db->createCommand($sqlRemain)->queryRow();

            $deleteRemain = Yii::app()->db->createCommand()->delete('{{seckill_auction_remind}}', 'goods_id=:gid AND rules_setting_id=:rid AND member_id=:mid', array(':gid' => $auctionRemain["goods_id"], ':rid' => $auctionRemain["rules_setting_id"], ':mid' => $member_id));//删除提醒设置

            if ($deleteRemain) {
                $tip = array();
                $tip['success'] = '设置提醒成功！';
                exit(json_encode($tip));
            } else {
                $tip = array();
                $tip['error'] = '设置提醒失败！';
                exit(json_encode($tip));
            }
        }


    }


    /**
     * ajax 获取手机验证码
     */
    public function actionGetMobileVerifyCode()
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['new_mobile']) && preg_match("/(^\d{11}$)|(^852\d{8}$)/", $_POST['new_mobile'])) {
            $verifyCodeCheck = $this->getSession($_POST['new_mobile']);
            if ($verifyCodeCheck) {
                $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
                if ($verifyArr && (time() - $verifyArr['time'] < 60)) {
                    echo Yii::t('memberHome', '验证码正在发送，请等待{time}秒后重试', array('{time}' => '60'));
                    Yii::app()->end();
                }
            }
            $smsConfig = $this->getConfig('smsmodel');
            $tmpId = $smsConfig['phoneVerifyContentId'];
            //$verifyCode = '000000';
            $verifyCode = mt_rand(10000, 99999);
            $msg = Yii::t('memberHome', $smsConfig['phoneVerifyContent'], array('{0}' => $verifyCode));
            $data = array('time' => time(), 'verifyCode' => $verifyCode);
            //验证码同时写cookie\session 防止丢失
            $this->setCookie($_POST['new_mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5), 60 * 5);
            // $this->setCookie($this->getPost('new_mobile'), $verifyCode, 60 * 5);

            $this->setSession($_POST['new_mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5));
            //$this->setSession($_POST['new_mobile'], $verifyCode, 60 * 5);

            if (Yii::app()->request->cookies[$_POST['new_mobile']]) {
                SmsLog::addSmsLog($_POST['new_mobile'], $msg, 0, SmsLog::TYPE_CAPTCHA, null, true, array($verifyCode), $tmpId);
//                SmsLog::addSmsLog($_POST['new_mobile'], $msg);
                echo 'success';
            } else {
                echo Yii::t('memberHome', '发送失败,请点此重试');
            }

            Yii::app()->end();
        }
    }


    /**
     * 获取语音验证码
     */
    public function actionGetMobileVerifyCall()
    {

        if (!Yii::app()->request->isAjaxRequest) {
            exit;
        }
        /**
         * 如果是登录状态没有传递手机号码，则查询手机号
         */
        if (isset($_POST['new_mobile']) && !empty($_POST['new_mobile'])) {
            $new_mobile = $_POST['new_mobile'];
        }
        if (!preg_match("/(^\d{11}$)/", $new_mobile)) exit($new_mobile);;
        $verifyCodeCheck = $this->getSession($new_mobile);
        if ($verifyCodeCheck) {
            $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
            if ($verifyArr && (time() - $verifyArr['time'] < 60)) {
                echo Yii::t('memberHome', '请等待{time}秒后重试', array('{time}' => '60'));
                Yii::app()->end();
            }
        }
        //$verifyCode = '000000';
        $verifyCode = mt_rand(10000, 99999);
        $data = array('time' => time(), 'verifyCode' => $verifyCode);
        //验证码同时写cookie\session 防止丢失
        $this->setCookie($new_mobile, Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5), 60 * 5);
        $this->setSession($new_mobile, Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5));

        if (Yii::app()->request->cookies[$new_mobile]) {
            Sms::voiceVerify($verifyCode, $new_mobile);
            echo 'success';
        } else {
            echo Yii::t('memberHome', '操作失败,请重试');
        }
        Yii::app()->end();
    }


}
