<?php

/**
 * Created by PhpStorm.
 * User: G-emall
 * Date: 2016/2/29
 * Time: 16:35
 */
class AuctionAgentPriceController extends Controller
{
    /**
     * 添加拍卖活动代理出价(拍卖活动)
     * @param integer category_id 活动的类型ID
     * @param integer status 活动的状态
     */

    public function actionPriceConvertIntegral()
    {
        $price = floatval($this->getParam('price'));
        $data = HtmlHelper::priceConvertIntegral($price);
        echo json_encode($data);
    }
    public function actionAjaxOutPrice(){
        $id      = intval($this->getParam('rsid'));
        $goodsId = intval($this->getParam('goods_id'));
        $userId  = intval(Yii::app()->user->id);//用户id
        $postPrice      = floatval($this->getParam('price'));//提交的当前拍卖价
        //取拍卖的最新价格
        $sql = "SELECT * FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid FOR UPDATE";
        $row = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid'=>$id, ':gid'=>$goodsId));
        /*if(!empty($ajaxPrice)){
             $postPrice=$ajaxPrice;
         }*/
        if ( $postPrice != $row['price'] ){//拍卖价已发生改变,则提示用户价格已发生改变
            $data['change']  = 1;
            $data['success'] = true;
            $data['price']   = $row['price'];
            $data['message'] = Yii::t('auction', '拍卖价格发生改变,是否重新出价');;
            echo json_encode($data);
            exit;
        }else{
            $data['success'] = false;
            echo json_encode($data);
            exit;
        }
    }

    public function actionAjaxNewPrice(){
        $id      = intval($this->getParam('rsid'));
        $goodsId = intval($this->getParam('goods_id'));
        $userId  = intval(Yii::app()->user->id);//用户id
        $data = array();
        //商品缓存
        $result = AuctionData::getAuctionSettingGoods($id);
        //商品当前价格
        $nowPrice = Yii::app()->db->createCommand()
            ->select('price')
            ->from('{{seckill_auction_price}}')
            ->where('rules_setting_id=:rsid AND goods_id=:gid', array(':rsid'=>$id, ':gid'=>$goodsId))
            ->queryScalar();

        //取出上一次的代理出价
        $agentData = Yii::app()->db->createCommand()
            ->select('id,agent_price,send_message,send_mobile')->from('{{seckill_auction_agent_price}}')
            ->where('rules_setting_id=:rules_setting_id AND goods_id=:goods_id AND member_id=:member_id',array(':rules_setting_id' => $id, ':goods_id' => $goodsId, ':member_id' => $userId))
            ->queryRow();

        $agentPriceId = $agentData['id'];

        if(!$agentPriceId){
            //如果是第一次
            $minimumPrice = bcadd($nowPrice, 2 * $result[$goodsId]['price_markup'], 2);
        }else{
            //上一次价加两个幅度
            $last_agent_price = $agentData['agent_price'];
            $minimumPrice = bcadd($last_agent_price, 2 * $result[$goodsId]['price_markup'], 2);
            if($minimumPrice<=$nowPrice){
                $minimumPrice = bcadd($nowPrice, 2 * $result[$goodsId]['price_markup'], 2);
            }
        }

        $auctionRecord = AuctionData::getAuctionRecord($id, $goodsId);

       // $data['now1']=$nowPrice;
        $data['now']=$nowPrice;
        $data['nowPrice']=HtmlHelper::formatPrice($nowPrice);
        $data['priceConvert']=HtmlHelper::priceConvertIntegral($nowPrice);
        $data['minimum']=HtmlHelper::formatPrice($minimumPrice);
        echo json_encode($data);
        exit;
    }

    public function actionSetAuctionAgentPrice()
    {

        $userId = Yii::app()->user->id;//用户id

        $data = array('success' => false, 'message' => array(), 'change' => 0, 'url' => '', 'price' => 0, 'row' => array());
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
        $agentPrice = floatval($this->getParam('agent_price'));//提交的当前拍卖价

        $sendMobile = $this->getParam('send_mobile');//设置是否设置发送站内短信
        $sendMobile = !empty($sendMobile) ? $sendMobile : '';//买家手机号

        $sendMessage = intval($this->getParam('send_message'));//设置是否设置发送站内短信

        $sql = "SELECT rm.date_end,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
        $return = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id' => $rulesSettingId));
        $rulesEndTime = strtotime($return['date_end'] . ' ' . $return['end_time']);//活动结束时间

        $goodsData = Goods::model()->findByPk($goodsId);
        $goodsName = $goodsData['name'];//商品名

        $dateline = time();//创建时间
        //echo json_encode( $goodsName.'-'.$rulesEndTime.'-'.$agentPrice.'-'.$userId.'-'.$gw.'-'.$rulesSettingId.'-'.$goodsId.'-'.$sendMobile.'-'.$sendMessage);
        // exit;
        $postPrice      = floatval($this->getParam('price'));//提交的当前拍卖价
        //$ajaxPrice      = floatval($this->getParam('ajaxPrice'));
        //活动是否在时间范围内
        if (!AuctionData::checkAuctionIsExpired($rulesSettingId, $goodsId)) {
            $data['message'] = Yii::t('auction', '活动还没开始或已经结束');
            echo json_encode($data);
            exit;
        }
        //活动在距结束两分钟内不接受代理价
        if (!AuctionData::checkAuctionIsTwoMinute($rulesSettingId, $goodsId)) {
            $data['message'] = Yii::t('auction', '距离活动结束时间小于2分钟,不允许设置代理价');
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
        //取拍卖的最新价格
        $sql = "SELECT * FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid FOR UPDATE";
        $row = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid'=>$rulesSettingId, ':gid'=>$goodsId));
        if ( $postPrice != $row['price'] ){//拍卖价已发生改变,则提示用户价格已发生改变
            $data['change']  = 1;
            $data['success'] = true;
            $data['price']   = $row['price'];
            $data['message'] = Yii::t('auction', '拍卖价格发生改变,是否重新出价');;
            echo json_encode($data);
            exit;
        }

        //取拍卖的最新价格
        //商品当前价格
        $nowPrice = Yii::app()->db->createCommand()
            ->select('price')
            ->from('{{seckill_auction_price}}')
            ->where('rules_setting_id=:rsid AND goods_id=:gid', array(':rsid' => $rulesSettingId, ':gid' => $goodsId))
            ->queryScalar();

        //取出上一次的代理出价
        $agentData = Yii::app()->db->createCommand()
            ->select('id,agent_price')->from('{{seckill_auction_agent_price}}')
            ->where('rules_setting_id=:rules_setting_id AND goods_id=:goods_id AND member_id=:member_id', array(':rules_setting_id' => $rulesSettingId, ':goods_id' => $goodsId, ':member_id' => $userId))
            ->queryRow();


        $id = $agentData['id'];
        //当前价加两个幅度
        $twoNowPrice = bcadd($nowPrice, 2 * $goodsCache[$goodsId]['price_markup'], 2);
        //上一次代理价加两个幅度
        $last_agent_price = $agentData['agent_price'];
        $twoLastPrice = bcadd($last_agent_price, 2 * $goodsCache[$goodsId]['price_markup'], 2);
        if (!$id) {
            //代理价不能低于当前价两个加价幅度
            if ($agentPrice < $twoNowPrice) {
                $data['message'] = Yii::t('auction', '代理价不能低于当前价两个加价幅度');
                echo json_encode($data);
                exit;
            }
        } else {
            //再次出代理价:如果上一次代理价的两个幅度还是小于当前价：不能低于当前价两个加价幅度
            if ($twoLastPrice <= $nowPrice ) {
                if($agentPrice < $twoNowPrice){
                    $data['message'] = Yii::t('auction', '代理价不能低于当前价两个加价幅度');
                    echo json_encode($data);
                    exit;
                }
            }else{ //不能低于上一次价加两个幅度
                if($agentPrice < $twoLastPrice) {
                    $data['message'] = Yii::t('auction', '代理价不能低于上一次代理价两个加价幅度');
                    echo json_encode($data);
                    exit;
                }
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


        if ($totalMoney < $agentPrice) {
            $data['change'] = 2;
            $data['message'] = Yii::t('auction', '积分余额不足,无法进行代理出价');
            echo json_encode($data);
            exit;
        }


        //插入代理出价表

        if (!$id) {
            $insert = array('rules_setting_id' => $rulesSettingId, 'rules_end_time' => $rulesEndTime, 'goods_id' => $goodsId, 'goods_name' => $goodsName, 'member_id' => $userId, 'member_gw' => $gw, 'agent_price' => $agentPrice, 'send_mobile' => $sendMobile, 'send_message' => $sendMessage, 'dateline' => $dateline);
            $lastId = Yii::app()->db->createCommand()->insert('{{seckill_auction_agent_price}}', $insert);
        } else {
                $update = array('mobile_is_send' => 0, 'message_is_send' => 0, 'all_over' => 0, 'is_above' => 0, 'agent_price' => $agentPrice, 'send_mobile' => $sendMobile, 'send_message' => $sendMessage, 'dateline' => $dateline);
                $count = Yii::app()->db->createCommand()->update('{{seckill_auction_agent_price}}', $update, "id=:id", array(':id' => $id));
        }

        if (isset($lastId) || isset($count)) {
            $success = true;
        }
        if ($success) {
            $data['change'] = 5;
            $data['success'] = true;
            $data['agent_price'] = $agentPrice;
            $data['integration'] = HtmlHelper::priceConvertIntegral($agentPrice);
        }
        echo json_encode($data);
        exit;

    }
}