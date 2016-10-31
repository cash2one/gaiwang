<?php

/**
 * 拍卖订单管理
 * 操作(订单列表，支付，取消订单，申请退款)
 */
class AuctionController extends MController
{
    /*
     * status 状态，（1新订单,2交易成功,3交易关闭）
     * code 订单编号（商城内部使用）
     * pay_status 支付状态（1未支付，2已支付）
     * refund_status 退款状态（0无，1申请中，2失败，3成功）
     * return_status 退货状态（0无，1协商中，2失败，3同意，4，成功）
     * is_comment 评论状态（0未评论，1已评论）
     * */
    public function init()
    {
        $this->pageTitle = Yii::t('memberOrder', '_用户中心_') . Yii::app()->name;
    }

    /**
     * 竞拍记录列表
     * $data 我的竞拍记录
     * $rules 我的竞拍记录活动名称
     * 字段:auction_status 拍卖状态
     *      sum_price 我的出价
     *      high_member_id 最高出价者id
     *      goods_name 商品名称
     *      goods_code 商品编号
     *      active_status 活动状态
     *      order_code 订单编号
     */
    public function actionAdmin()
    {
        $member_id = Yii::app()->user->id;
        $goods_id = $this->getPost("goods_id");
        $data = Yii::app()->db->createCommand()
            ->select("sar.rules_setting_id,
            sar.goods_id,
            sar.status AS auction_status,
            sar.auction_time,
            SUM(sar.balance_history + sar.balance) AS sum_price,
            sap.price,
            sap.dateline,
            sap.create_order,
			sap.order_code AS auction_order_code,
			sap.reserve_price,
			sap.auction_end_time,
            sa.start_price,
            sa.price_markup,
            g.name AS goods_name,
            g.code AS goods_code,
            srs.id,
			sar.is_return,
            srs.status AS active_status,
            srm.name AS srm_name,
            m.gai_number,
            o.pay_status,
            o.code AS order_code,
            o.create_time AS order_time,
			o.status AS order_status,
			srs.is_force,
            concat(srm.date_start,' ',srs.start_time) start_time,
            concat(srm.date_end,' ',srs.end_time) end_time")
            ->from('{{goods}} g')
            ->leftjoin('{{seckill_auction}} sa','sa.goods_id = g.id')
			->leftjoin('{{seckill_auction_record}} sar','sar.rules_setting_id = sa.rules_setting_id AND sar.goods_id = sa.goods_id')
            ->leftjoin('{{seckill_auction_price}} sap','sap.rules_setting_id = sa.rules_setting_id AND sap.goods_id = sa.goods_id')
			->leftjoin('{{seckill_rules_seting}} srs','srs.id = sa.rules_setting_id')
			->leftjoin('{{seckill_rules_main}} srm','srm.id = srs.rules_id')
			->leftjoin('{{member}} m','m.id = sap.member_id')
            ->leftjoin('{{order}} o','o.code = sap.order_code')
            ->where("srm.category_id=:cid AND sar.member_id = ' ".$member_id."' ", array(':cid'=>SeckillRulesSeting::SECKILL_CATEGORY_FOUR))
            ->group("sar.id")
            ->order("sar.id desc")
            ->queryAll();
        $sql = "SELECT distinct sar.goods_id ,sar.rules_setting_id,srm.name AS srm_name, srs.is_force,srs.status AS active_status,  concat(srm.date_start,' ',srs.start_time) start_time,
                concat(srm.date_end,' ',srs.end_time) end_time,
				sap.auction_end_time
                FROM {{seckill_auction_record}} sar
				LEFT JOIN {{seckill_auction_price}} sap ON sap.rules_setting_id = sar.rules_setting_id AND sap.goods_id = sar.goods_id
                LEFT JOIN {{seckill_rules_seting}} srs ON srs.id = sar.rules_setting_id
                LEFT JOIN {{seckill_rules_main}} srm ON srs.rules_id = srm.id
                WHERE srm.category_id = 4 AND sar.member_id = ' ".$member_id."' ORDER BY sar.id desc";
        $rules = Yii::app()->db->createCommand($sql)->queryAll();
        $criteria = new CDbCriteria;  
        $pages = new CPagination(count($rules));                 
        $pages->pageSize = 10;  
        $pages->applylimit($criteria);  
  
        $rules=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");  
        $rules->bindValue(':offset', $pages->currentPage*$pages->pageSize);  
        $rules->bindValue(':limit', $pages->pageSize);  
        $rules=$rules->queryAll();  
        $this->render('admin', array(
           'data' => $data,
            'rules' => $rules,
            'pages' => $pages
        ));
    }
   
    /**
     * 竞拍订单列表
     */
    public function actionOrder(){
        $this->pageTitle = Yii::t('memberOrder', '我的订单') . $this->pageTitle;
        $model = new Order('search');
        $model->unsetAttributes();
        $getOrder = $this->getQuery('Order');
        if (isset($_GET['Order']) && isset($_GET['Order']['code']) && trim($_GET['Order']['code'])!=''){//由于2.0版本搜索合并,所以要处理提交数据
            if( preg_match('/^\d+$/', trim($_GET['Order']['code'])) ){//纯数字是是订单号,否则是商品名称
                $getOrder['code'] = trim($_GET['Order']['code']);
                $getOrder['goods_name'] = '';
            }else{
                $getOrder['code'] = '';
                $getOrder['goods_name'] = trim($_GET['Order']['code']);
            }
        }

        $model->attributes = $getOrder;
        $c = $model->searchAuctionOrder($this->getUser()->id);

        //分页
        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($c);

        $orders = $model->findAll($c);
        $recentDate = array('start' => (time() - $model::RECENT_TIME), 'end' => time());

        //近期订单数量
        $recentOrderNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and create_time>=:cTime and source_type=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':cTime' => $recentDate['start'],
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();

        //退款中
        $refundNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and refund_status=:refund_status and source_type=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':refund_status' => Order::REFUND_STATUS_PENDING,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();
           /* foreach ($orders as $k => $v) {
               echo "<pre>";
                print_r($v);
                die;
            }*/
        $this->render('order', array(
            'model' => $model,
            'orders' => $orders,
            'pages' => $pages,
            'recentOrderNum' => $recentOrderNum,
            'recentDate' => $recentDate,
            'refundNum' => $refundNum,
        ));
    }

}
