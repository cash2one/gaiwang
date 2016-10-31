<?php

/*
 * 统计管理控制器
 * @author LC
 */

class StatisticsController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionIndex() {
        $beforeDate = strtotime(date('Y-m-d', strtotime('-30 day')));
        $endDate = strtotime(date('Y-m-d', time()));

        //盖网会员统计(没加入会员状态的判断)
        //1.企业会员人数，普通会员人数，正式会员人数，消费会员人数，总人数
        $userDataArr = array(
            'store' => 0, //企业会员人数
            'normal' => 0, //普通会员人数
            'member' => 0, //正式会员人数
            'use' => 0, //消费会员人数
            'total' => 0, //总人数
            'register' => 0, //近30天注册人数
            'load' => 0, //近30天登陆次数
            'avtive' => 0, //近30天活跃用户数
        );

        $memberTable = Member::model()->tableName();
        $userData = Yii::app()->db->createCommand()
                ->select("is_enterprise,type_id,count(1) as num")
                ->from($memberTable)
                ->group("is_enterprise,type_id")
                ->queryAll();

        $memberType = MemberType::fileCache();  //会员类型
        foreach ($userData as $rowUser) {
            if ($rowUser['is_enterprise'] == Member::ENTERPRISE_NO)
                $userDataArr['normal']+=$rowUser['num'];  //普通会员人数
            if ($rowUser['is_enterprise'] == Member::ENTERPRISE_YES)
                $userDataArr['store']+=$rowUser['num'];  //企业会员人数
            if ($rowUser['type_id'] == $memberType['defaultType'])
                $userDataArr['use']+=$rowUser['num'];  //消费会员人数
            if ($rowUser['type_id'] == $memberType['officialType'])
                $userDataArr['member']+=$rowUser['num']; //正式会员人数
            $userDataArr['total']+=$rowUser['num'];
        }

        //2.获取近30天注册人数，登陆人次，活跃用户数(不包含今天)
        $thirtyReg = Yii::app()->db->createCommand()
                ->select("count(1) as num")
                ->from($memberTable)
                ->where("register_time between $beforeDate and $endDate")
                ->queryRow();

        $thirtyLoad = Yii::app()->db->createCommand()
                ->select("count(1) as num")
                ->from($memberTable)
                ->where("last_login_time between $beforeDate and $endDate")
                ->queryRow();

        $userDataArr['register'] = $thirtyReg['num'];
        $userDataArr['load'] = $thirtyLoad['num'];

        //盖网商铺统计(没加入商铺状态的判断)
        //1.商铺总数，近30日新增/审核中/经营中数量
        $storeDataArr = array(
            'total' => 0, //商品总数
            'addcount' => 0, //近30日新增
            'confirmcount' => 0, //近30日审核
            'shopping' => 0, //近30日经营中
            'beforethree' => array(), //近30日前三排行
            'NO1' => "", //销售总冠军
        );
        $storeTable = Store::model()->tableName();
        $storeCount = Yii::app()->db->createCommand()
                ->select("status,count(1) as num")
                ->from($storeTable)
                ->group("status")
                ->queryAll();

        foreach ($storeCount as $rowStore) {
            switch ($rowStore['status']) {
                case Store::STATUS_APPLYING:   //新增（申请中）
                    $storeDataArr['addcount']+=$rowStore['num'];
                    break;
                case Store::STATUS_ON_TRIAL:   //审核（试用中）
                    $storeDataArr['confirmcount']+=$rowStore['num'];
                    break;
                case Store::STATUS_PASS:    //经营（审核通过）
                    $storeDataArr['shopping']+=$rowStore['num'];
                    break;
            }
            $storeDataArr['total']+=$rowStore['num'];
        }

        //2.销量总冠军，近30日销量排行榜前3名
        $orderMainTable = Order::model()->tableName();     //订单主表
        $orderDetailTable = OrderGoods::model()->tableName();   //订单明细表

        $NO1 = Yii::app()->db->createCommand()
                ->select("b.name,count(1) as num")
                ->from($orderMainTable . " a")
                ->leftJoin($storeTable . " b", "b.id = a.store_id")
                ->where("a.status = " . Order::STATUS_COMPLETE)
                ->group("b.name")
                ->order("num desc")
                ->limit(1)
                ->queryRow();

        $storeDataArr['NO1'] = isset($NO1['name']) ? $NO1['name'] : "";

        $storeDataArr['beforethree'] = Yii::app()->db->createCommand()
                ->select("b.name,count(1) as num")
                ->from($orderMainTable . " a")
                ->leftJoin($storeTable . " b", "b.id = a.store_id")
                ->where("a.status = " . Order::STATUS_COMPLETE . " and sign_time between $beforeDate and $endDate")
                ->group("b.name")
                ->order("num desc")
                ->limit(3)
                ->queryAll();

        //盖网商品统计
        //1.盖网商品统计
        $goodsDataArr = array(
            'goodsnum' => 0, //商品总数
            'addnum' => 0, //近30日新增
            'completenum' => 0, //成交数量
            'allnum' => 0, //累计成交
            'rate' => 0, //商品平均转化率
            'hottype' => array(), //热门分类排行
        );
        $goodsTable = Goods::model()->tableName();
        //商品总数
        $goodsCount = Yii::app()->db->createCommand()
                ->select("count(1) as num")
                ->from($goodsTable)
                ->queryRow();
        $goodsDataArr['goodsnum'] = $goodsCount['num'];

        //近30日新增
        $addCount = Yii::app()->db->createCommand()
                ->select("count(1) as num")
                ->from($goodsTable)
                ->where("create_time between $beforeDate and $endDate")
                ->queryRow();

        $goodsDataArr['addnum'] = $addCount['num'];

        //近30日成交
        $complateCount = Yii::app()->db->createCommand()
                ->select("sum(b.quantity) as num")
                ->from($orderMainTable . " a")
                ->leftJoin($orderDetailTable . " b", "b.order_id = a.id")
                ->where("a.create_time between $beforeDate and $endDate")
                ->queryRow();

        $goodsDataArr['completenum'] = $complateCount['num'];

        //累计成交
        $allCount = Yii::app()->db->createCommand()
                ->select("sum(b.quantity) as num")
                ->from($orderMainTable . " a")
                ->leftJoin($orderDetailTable . " b", "b.order_id = a.id")
                ->queryRow();

        $goodsDataArr['allnum'] = $allCount['num'];



        //盖网订单统计（按月计算）
        //订单：新单，支付，签收
        $orderDataArr = array('Chart' => array());
        $beginMonth = strtotime(date('Y-m'));
        $endMonth = strtotime(date('Y-m', strtotime('+1 month')));
        //新单
        $newOrderData = Yii::app()->db->createCommand()
                ->select("count(1) as num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date")
                ->from($orderMainTable)
                ->where("create_time between $beginMonth and $endMonth and status = " . Order::STATUS_NEW)
                ->group("date")
                ->queryAll();
        $newOrder = array();
        foreach ($newOrderData as $rowNew) {
            $newOrder[$rowNew['date']] = $rowNew['num'];
        }


        //支付				
        $payOrderData = Yii::app()->db->createCommand()
                ->select("count(1) as num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date")
                ->from($orderMainTable)
                ->where("create_time between $beginMonth and $endMonth and pay_status = " . Order::PAY_STATUS_YES)
                ->group("date")
                ->queryAll();
        $payOrder = array();
        foreach ($payOrderData as $rowPay) {
            $payOrder[$rowPay['date']] = $rowPay['num'];
        }

        //签收
        $receiveOrderData = Yii::app()->db->createCommand()
                ->select("count(1) as num,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date")
                ->from($orderMainTable)
                ->where("create_time between $beginMonth and $endMonth and status = " . Order::STATUS_COMPLETE)
                ->group("date")
                ->queryAll();
        $receiveOrder = array();
        foreach ($receiveOrderData as $rowReceive) {
            $receiveOrder[$rowReceive['date']] = $rowReceive['num'];
        }

        $month = date('Y-m');        //当前月
        $nextMonth = date('Y-m', strtotime('+1 month'));  //下一个月
        $monthTime = strtotime($month);      //当前月时间戳
        $nextMonthTime = strtotime($nextMonth);    //下一个月时间戳
        $difftime = 60 * 60 * 24;        //一天的时间
        for ($i = $monthTime; $i < $nextMonthTime; $i = $i + $difftime) {
            $date = date('Y-m-d', $i);
            $orderDataArr['Chart'][] = array(
                'CreateOrderCount' => isset($newOrder[$date]) ? (int) $newOrder[$date] : 0,
                'PayOrderCount' => isset($payOrderData[$date]) ? (int) $payOrderData[$date] : 0,
                'SignOrderCount' => isset($receiveOrder[$date]) ? (int) $receiveOrder[$date] : 0,
                'Time' => (double) (strtotime($date) . "000"),
            );
        }
        
        $this->render("index", array(
            'userData' => $userDataArr,
            'storeData' => $storeDataArr,
            'goodsData' => $goodsDataArr,
            'orderData' => $orderDataArr,
        ));
    }
    
    /*
     * 热门分类 近30天销量最好的商品分类 ajax取数据
     */
    public function actionGetHotCat(){
        $now = time();
        $otherTime = $now - 86400*30;
        //先查出近30天销量最好的商品
        $sql = "select distinct IFNULL(g.category_id,1) from {{order_goods}} og left join {{order}} o on o.id=og.order_id left join {{goods}} g on g.id=og.goods_id".
                " where o.pay_time between $otherTime and $now group by og.goods_id order by og.quantity desc limit 10";
        $res3 = Yii::app()->db->createCommand($sql)->queryColumn();
       // Tool::pr($res3);
        $catArr = array();
//        foreach ($res3 as $v){
//            $sql2 = "select c.name from {{category}} c left join {{goods}} g on c.id=g.category_id where g.id=".$v;
//            $arr = Yii::app()->db->createCommand($sql2)->queryScalar();
//            array_push($catArr, $arr);
//        }
        
        foreach ($res3 as $v){
            if($v){
                $sql2 = "select name from {{category}} where id=$v";
                $arr = Yii::app()->db->createCommand($sql2)->queryScalar();
                array_push($catArr, $arr);
            }
           
        }
        //Tool::pr($catArr);
        $arr2 = array_reverse($catArr);
        
        echo CJSON::encode($arr2);
        
    }
    
    
    
    
    /*
     * 会员统计-会员人数统计
     */

    public function actionMemberCount() {
        //获取盖网总用户
        $beforeDate = strtotime(date('Y-m-d', strtotime('-30 day')));
        $endDate = strtotime(date('Y-m-d', time()));
        $data = self::getMemberCountDatas($beforeDate, $endDate);

        $this->breadcrumbs = array('统计管理', '会员统计', '会员人数统计');
        $this->render('membercount', array('data' => $data));
    }

    /*
     * ajax获取会员人数统计的数据（好像没有使用）
     */

    public function actionAjaxMemberCount() {
        $minTime = $this->getParam('minTime');
        $data = Statistics::getEnterpriseByMonth($minTime);
        echo CJSON::encode($data);
    }

    /*
     * 商铺统计 显示页面
     */

    public function actionStoreCount() {
        //获取截止到目前为止最新的统计数据。盖网商铺总量，审核中的商铺数量，经营中的商铺数量，关闭的商铺数量。
        $storeData = array(
            'totalCount' => 0, //商铺总量
            'confirmCount' => 0, //审核中商品数量
            'shoppingCount' => 0, //经营中商铺数量
            'closeCount' => 0, //关闭商品数量
        );
        $storeTable = Store::model()->tableName();
        $storeArr = Yii::app()->db->createCommand()
                ->select("count(1) as num,status")
                ->from($storeTable)
                ->group("status")
                ->queryAll();
        foreach ($storeArr as $row) {
            if ($row['status'] == Store::STATUS_APPLYING)
                $storeData['confirmCount']+=$row['num'];
            if ($row['status'] == Store::STATUS_PASS)
                $storeData['shoppingCount']+=$row['num'];
            if ($row['status'] == Store::STATUS_CLOSE)
                $storeData['closeCount']+=$row['num'];
            $storeData['totalCount']+=$row['num'];
        };

        $this->render('storecount',array('storeData'=>$storeData));
    }
    
    /*
     * 商铺统计取数据
     */
    public function actionGetStoreCount(){
        $storeDataArr = array('Chart' => array());
        $beginMonth = isset($_GET['minTime']) ? strtotime($_GET['minTime']) : strtotime(date('Y-m'));//月开始时间戳
        $endMonth = strtotime('1 month',$beginMonth);//月结束
        
        $storeData = Yii::app()->st->createCommand()
                ->select("new_store_count,total_store_count,applying_store_count,ontrial_store_count,pass_store_count,closed_store_count,FROM_UNIXTIME(statistics_date,'%Y-%m-%d') as date")
                ->from('{{store_day}}')
                ->where("statistics_date between $beginMonth and $endMonth")
                ->group('date')
                ->queryAll();
        
        $new = array();
        $total = array();
        $applyIng = array();
        $passed = array();
        $ontrial = array();
        $colsed = array();
        $InfoData = array();
        
        foreach($storeData as $row){
            $new[$row['date']] = $row['new_store_count'];
            $total[$row['date']] = $row['total_store_count'];
            $applyIng[$row['date']] = $row['applying_store_count'];
            $ontrial[$row['date']] = $row['ontrial_store_count'];
            $passed[$row['date']] = $row['pass_store_count'];
            $colsed[$row['date']] = $row['closed_store_count'];
        }
        
        $difftime = 60 * 60 * 24;        //一天的时间
        for($i = $beginMonth;$i < $endMonth;$i = $i + $difftime){
            $date = date('Y-m-d',$i);
            $storeDataArr['Chart'][] = array(
                'NewStoreCount' => isset($new[$date]) ? (int) $new[$date] : 0,
                'TotalStoreCount'=> isset($total[$date]) ? (int) $total[$date] : 0,
                'ApplyingStoreCount' => isset($applyIng[$date]) ? (int) $applyIng[$date] : 0,
                'OnTrialStoreCount' => isset($ontrial[$date]) ? (int) $ontrial[$date] : 0,
                'PassStoreCount' => isset($passed[$date]) ? (int) $passed[$date] : 0,
                'ClosedStoreCount' => isset($colsed[$date]) ? (int) $colsed[$date] : 0,
                'Time' => (double) (strtotime($date) . "000"),
                'StatisticsDate'=>$date,
            );
        }
        
        echo json_encode($storeDataArr);
    }
    
    
    

    /*
     * 商铺统计-商铺排行
     */

    public function actionStoreList() {
        //获取商品访问量前20的商家
        $storeTable = Store::model()->tableName();
        Yii::app()->db->createCommand()
                ->select("name,views")
                ->from($storeTable)
                ->order("views desc")
                ->limit(20);

        $this->render('storelist', array());
    }

    /*
     * 商品统计 显示页面
     */

    public function actionProduct() {
        $this->render('product');
    }
    
    /*
     * 取商品统计数据
     */
    public function actionAjaxProduct(){
        $productDataArr = array('Chart' => array());
        $beginMonth = isset($_GET['minTime']) ? strtotime($_GET['minTime']) : strtotime(date('Y-m'));//月开始时间戳
        $endMonth = strtotime('1 month',$beginMonth);//月结束
        
        /*
         * new_product_count 新录入的商品数量
         * publish_product_count 新上架的商品总数量
         * sign_product_count 签收的的商品数量
         * ordered_product_count 下单商品数量
         * payed_product_count 支付商品数量
         * conversionrate_avg 平均转化率
         * 
         */
        
        $productDatas = Yii::app()->st->createCommand()
                ->select("new_product_count,publish_product_count,sign_product_count,ordered_product_count,payed_product_count,conversionrate_avg,FROM_UNIXTIME(statistics_date,'%Y-%m-%d') as date")
                ->from('{{product_day}}')
                ->where("statistics_date between $beginMonth and $endMonth")
                ->group('date')
                ->queryAll();
        
        $new = array();//新录入的商品数量
        $publish = array();//新上架的商品总数量
        $sign = array();//签收的的商品数量
        $ordered = array();//下单商品数量
        $payed = array();//支付商品数量
        $conversionRateAvg = array();//平均转化率
        
        foreach ($productDatas as $row){
            $new[$row['date']] = $row['new_product_count'];
            $publish[$row['date']] = $row['publish_product_count'];
            $sign[$row['date']] = $row['sign_product_count'];
            $ordered[$row['date']] = $row['ordered_product_count'];
            $payed[$row['date']] = $row['payed_product_count'];
            $conversionRateAvg[$row['date']] = $row['conversionrate_avg'];
        }
        
        $difftime = 60 * 60 * 24;        //一天的时间
        for($i = $beginMonth;$i < $endMonth;$i = $i + $difftime){
            $date = date('Y-m-d',$i);
            $productDataArr['Chart'][] = array(
                'NewProductCount'=> isset($new[$date]) ? (int) $new[$date] : 0,
                'PublishProductCount'=> isset($publish[$date]) ? (int) $publish[$date] : 0,
                'SignProductCount'=> isset($sign[$date]) ? (int) $sign[$date] : 0,
                'OrderedProductCount'=> isset($ordered[$date]) ? (int) $ordered[$date] : 0,
                'PayedProductCount'=> isset($payed[$date]) ? (int) $payed[$date] : 0,
                'ConversionrateAvg'=> isset($conversionRateAvg[$date]) ? (double) $conversionRateAvg[$date] : 0,
                'Time' => (double) (strtotime($date) . "000"),
                'StatisticsDate'=>$date,
            );
        }
        echo json_encode($productDataArr);
    }
    
    
    
    /*
     * 商品统计-商品分类统计 显示页面
     */

    public function actionCatProCount() {
        //取出所有分类ID为0的 id,分类名称，分类缩略图，商品数
        $sql = "select c.id,c.name,c.thumbnail,count(g.id) as num from {{category}} c left join {{goods}} g on c.id=g.category_id where c.parent_id=0".
                " group by c.id";
        $catData = Yii::app()->db->createCommand($sql)->queryAll();

        $this->render('catprocount',array('catData'=>$catData));
    }
    
    /*
     * 商品分类统计ajax
     */
    public function actionGetCatAjax(){
        $catID = !empty($_GET['CatId']) ? $_GET['CatId'] : 1;
        $sql = "select c.id,c.name,count(g.id) as num from {{category}} c left join {{goods}} g on c.id=g.category_id where c.parent_id=$catID".
                " group by c.id";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $DataArr = array();
        foreach($data as $v){
            $dataArr[] = array(
                'ProCount'=> (int) $v['num'],
                'CatName'=> $v['name'],
            );
        }
        echo json_encode($dataArr);
    }
    
    

    /*
     * 商品统计-商品排行
     */

    public function actionProductList() {
        $beginMonth = isset($_GET['minTime']) ? strtotime($_GET['minTime']) : strtotime(date('Y-m'));//月开始时间戳
        $endMonth = strtotime('1 month',$beginMonth);//月结束
        
        $sql = "select product_name,page_view,user_view from {{product_item}} where statistics_date between $beginMonth and $endMonth order by page_view desc,user_view desc limit 20";
        $dataRes = Yii::app()->st->createCommand($sql)->queryAll();
        $this->render('productlist',array('dataRes'=>$dataRes));
    }

    /*
     * 订单统计
     */

    public function actionOrderCount(){
        $this->render('ordercount');
    }
    
    //ajax取订单数据
    public function actionOrderCount2() {
        //盖网订单统计（按月计算）
        //订单：新单，支付，签收
        $orderDataArr = array('Chart' => array());
        //$beginMonth = strtotime(date('Y-m'));
        $beginMonth = isset($_GET['minTime']) ? strtotime($_GET['minTime']) : strtotime(date('Y-m'));

        //$endMonth = strtotime(date('Y-m', strtotime('+1 month')));
        $endMonth = strtotime('1 month',$beginMonth);
        
        /*
         * create_order_gai_price 新订单总供货价
         * create_order_price 新订单总价
         * pay_order_gai_price 支付订单总供货价
         * pay_order_price 支付订单总价
         * sign_order_gai_price 签收订单总供货价
         * sign_order_price 签收订单总价
         */
        
        
        $OrderDatas = Yii::app()->st->createCommand()
                ->select("create_order_count,pay_order_count,sign_order_count,create_order_gai_price,create_order_price,pay_order_gai_price,pay_order_price,sign_order_gai_price,sign_order_price,FROM_UNIXTIME(statistics_date,'%Y-%m-%d') as date")
                ->from('{{gai_order_day}}')
                ->where("statistics_date between $beginMonth and $endMonth")
                ->group('date')
                ->queryAll();
        
        $new = array();//新单
        $pay = array();//支付
        $sign = array();//签收
        $CreateOrderGaiPrice = array();//新订单总供货价
        $CreateOrderPrice = array();//新订单总价
        $PayOrderGaiPrice = array();//支付订单总供货价
        $PayOrderPrice = array();//支付订单总价
        $SignOrderGaiPrice = array();//签收订单总供货价
        $SignOrderPrice = array();//签收订单总价
        foreach ($OrderDatas as $row){
            $new[$row['date']] = $row['create_order_count'];
            $pay[$row['date']] = $row['pay_order_count'];
            $sign[$row['date']] = $row['sign_order_count'];
            $CreateOrderGaiPrice[$row['date']] = $row['create_order_gai_price'];
            $CreateOrderPrice[$row['date']] = $row['create_order_price'];
            $PayOrderGaiPrice[$row['date']] = $row['pay_order_gai_price'];
            $PayOrderPrice[$row['date']] = $row['pay_order_price'];
            $SignOrderGaiPrice[$row['date']] = $row['sign_order_gai_price'];
            $SignOrderPrice[$row['date']] = $row['sign_order_price'];
        }
        
//        $month = date('Y-m');        //当前月
//        $nextMonth = date('Y-m', strtotime('+1 month'));  //下一个月
//        $monthTime = strtotime($month);      //当前月时间戳
//        $nextMonthTime = strtotime($nextMonth);    //下一个月时间戳
        $difftime = 60 * 60 * 24;        //一天的时间
        
        for($i = $beginMonth;$i < $endMonth;$i = $i + $difftime){
            $date = date('Y-m-d',$i);
            $orderDataArr['Chart'][] = array(
                'CreateOrderCount'=>isset($new[$date]) ? (int) $new[$date] : 0,
                'PayOrderCount'=>isset($pay[$date]) ? (int) $pay[$date] : 0,
                'SignOrderCount'=>isset($sign[$date]) ? (int) $sign[$date] : 0,
                'CreateOrderGaiPrice'=>isset($CreateOrderGaiPrice[$date]) ? (double) $CreateOrderGaiPrice[$date] : 0,
                'CreateOrderPrice'=>isset($CreateOrderPrice[$date]) ? (double) $CreateOrderPrice[$date] : 0,
                'PayOrderGaiPrice'=>isset($PayOrderGaiPrice[$date]) ? (double) $PayOrderGaiPrice[$date] : 0,
                'PayOrderPrice'=>isset($PayOrderPrice[$date]) ? (double) $PayOrderPrice[$date] : 0,
                'SignOrderGaiPrice'=>isset($SignOrderGaiPrice[$date]) ? (double) $SignOrderGaiPrice[$date] : 0,
                'SignOrderPrice'=>isset($SignOrderPrice[$date]) ? (double) $SignOrderPrice[$date] : 0,
                'Time' => (double) (strtotime($date) . "000"),
                'StatisticsDate'=>$date,
                //'StatisticsDate'=>$date
            );
        }

        echo json_encode($orderDataArr); 
    }
    
    /*
     * 短信统计
     */

    public function actionSmsCount() {
        
    }

    /**
     * 盖网总用户扇形统计图数据
     * @param $begintime	开始时间
     * @param $endtime		结束时间
     * return array
     */
    public static function getMemberCountDatas($begintime = 0, $endtime = 0) {
//        if ($begintime == 0 && $endtime == 0) {
//            $where = "1=1";
//        } else {
//            //$where = "register_time between $begintime and $endtime";
//        }
        $arr = array(
            'store' => 0, //企业会员人数
            'normal' => 0, //普通会员人数
            'member' => 0, //正式会员人数
            'use' => 0, //消费会员人数
            'total' => 0, //总人数
        );
        $memberTable = Member::model()->tableName();
        $userData = Yii::app()->db->createCommand()
                ->select("enterprise_id,type_id,count(1) as num")
                ->from($memberTable)
               // ->where($where)
                ->group("enterprise_id,type_id")
                ->queryAll();

        $memberType = MemberType::fileCache();  //会员类型
        foreach ($userData as $rowUser) {
            if ($rowUser['enterprise_id'] == 0)
                $arr['normal']+=$rowUser['num'];  //普通会员人数
            if ($rowUser['enterprise_id'] != 0)
                $arr['store']+=$rowUser['num'];  //企业会员人数
            if ($rowUser['type_id'] == $memberType['defaultType'])
                $arr['use']+=$rowUser['num'];  //消费会员人数
            if ($rowUser['type_id'] == $memberType['officialType'])
                $arr['member']+=$rowUser['num']; //正式会员人数
            $arr['total']+=$rowUser['num'];
        }

        return $arr;
    }

    /**
     * 获取会员人数统计下除图片外的其他数据(指定某一个月的)
     * return json
     */
    public function actionGetMemberCountOther() {
        $searchDate = $_GET['minTime'];     //要查询的月份
        $begintime = strtotime($searchDate);   //查询开始时间
        $endtime = strtotime('1 month', $begintime);  //查询结束时间

        $resArr = Yii::app()->st->createCommand()
                ->select("t.*,FROM_UNIXTIME(t.statistics_date,'%Y-%m-%d') as date")
                ->from("{{member_day}} t")
                ->where("statistics_date between $begintime and $endtime")
                ->group('date')
                ->queryAll();

        $dataArr = array();
//        foreach ($resArr as $row) {
//            $dataArr[] = array(
//                'AddCount' => (int) $row['add_count'],
//                'AddStoreInfoCount' => (int) $row['add_store_count'],
//                'AddCountByMachine' => (int) $row['add_count_machine'],
//                'AddCountByPhone' => (int) $row['add_count_phone'],
//                'AddCountByWebSite' => (int) $row['add_count_website'],
//                'ConsumeCount' => (int) $row['consume_count'],
//                'TotalStoreInfoCount' => (int) $row['total_store_count'],
//                'TotalCount' => (int) $row['total_count'],
//                'RegularCount' => (int) $row['regular_count'],
//                'LoginCount' => (int) $row['login_count'],
//                'LoginMemberCount' => (int) $row['login_member_count'],
//                'StatisticsDate' => date('Y-m-d', $row['statistics_date']),
//                'Time' => (double) ($row['create_time'] . "000"),
//            );
//        }
        
        $addCount = array();
        $AddStoreInfoCount = array();
        $AddCountByMachine = array();
        $AddCountByPhone = array();
        $AddCountByWebSite = array();
        $ConsumeCount = array();
        $TotalStoreInfoCount = array();
        $TotalCount = array();
        $RegularCount = array();
        $LoginCount = array();
        $LoginMemberCount = array();
        
        foreach ($resArr as $v){
            $addCount[$v['date']] = $v['add_count'];
            $AddStoreInfoCount[$v['date']] = $v['add_store_count'];
            $AddCountByMachine[$v['date']] = $v['add_count_machine'];
            $AddCountByPhone[$v['date']] = $v['add_count_phone'];
            $AddCountByWebSite[$v['date']] = $v['add_count_website'];
            $ConsumeCount[$v['date']] = $v['consume_count'];
            $TotalStoreInfoCount[$v['date']] = $v['total_store_count'];
            $TotalCount[$v['date']] = $v['total_count'];
            $RegularCount[$v['date']] = $v['regular_count'];
            $LoginCount[$v['date']] = $v['login_count'];
            $LoginMemberCount[$v['date']] = $v['login_member_count'];
        }
        
        $difftime = 60 * 60 * 24;        //一天的时间
        for($i = $begintime;$i < $endtime;$i = $i + $difftime){
            $date = date('Y-m-d',$i);
            $dataArr[] = array(
                'AddCount'=>isset($addCount[$date]) ? (int) $addCount[$date] : 0,
                'AddStoreInfoCount' => isset($AddStoreInfoCount[$date]) ? (int) $AddStoreInfoCount[$date] : 0,
                'AddCountByMachine' => isset($AddCountByMachine[$date]) ? (int) $AddCountByMachine[$date] : 0,
                'AddCountByPhone' => isset($AddCountByPhone[$date]) ? (int) $AddCountByPhone[$date] : 0,
                'AddCountByWebSite' => isset($AddCountByWebSite[$date]) ? (int) $AddCountByWebSite[$date] : 0,
                'ConsumeCount' => isset($ConsumeCount[$date]) ? (int) $ConsumeCount[$date] : 0,
                'TotalStoreInfoCount' => isset($TotalStoreInfoCount[$date]) ? (int) $TotalStoreInfoCount[$date] : 0,
                'TotalCount' => isset($TotalCount[$date]) ? (int) $TotalCount[$date] : 0,
                'RegularCount' => isset($RegularCount[$date]) ? (int) $RegularCount[$date] : 0,
                'LoginCount' => isset($LoginCount[$date]) ? (int) $LoginCount[$date] : 0,
                'LoginMemberCount' => isset($LoginMemberCount[$date]) ? (int) $LoginMemberCount[$date] : 0,
                'Time' => (double) (strtotime($date) . "000"),
                'StatisticsDate'=>$date,
                //'StatisticsDate'=>$date
            );
        }
        
        
        echo json_encode($dataArr);
        /**
          $difftime = 24*60*60;							//日期时间差

          $dataArr = array(
          'AddStoreInfoCount'=>0,					//企业注册
          'AddCount'=>0,								//总注册
          'AddCountByMachine'=>0,						//盖机注册
          'AddCountByPhone'=>0,						//手机注册
          'AddCountByWebSite'=>0,						//网站注册

          'ConsumeCount'=>585,						//消费会员总数
          'TotalStoreInfoCount'=>97,				//企业会员总数
          'TotalCount'=>625,							//会员总数
          'RegularCount'=>40,							//正式会员总数

          'LoginCount'=>0,							//登陆总次数
          'LoginMemberCount'=>0,						//登陆总会员数

          'StatisticsDate'=>'2013-12-01',				//日期
          'StatisticsTime'=>"/Date(1385827200000)/",	//好像没使用
          'Time'=>1385856000000,						//时间戳
          );

          //1.注册人数统计（总注册人，通过手机注册的人数，企业会员注册人数，通过网站注册人数，通过盖机注册人数）
          //'注册类型（0默认，1盖网机，2盖网，3手机短信，4手机APP）',
          $memberTable = Member::model()->tableName();
          $regResArr = Yii::app()->db->createCommand()
          ->select("count(1) as num,register_type,is_enterprise,FROM_UNIXTIME(register_time,'%Y-%m-%d') as date")
          ->from($memberTable)
          ->where("register_time between $begintime and $endtime")
          ->group("register_type,is_enterprise,date")
          ->queryAll();

          $regData = array();
          foreach ($regResArr as $rowMember){
          $regData[$rowMember['date']] = array(
          'num' => $rowMember['num'],
          'register_type' => $rowMember['register_type'],
          'is_enterprise' => $rowMember['is_enterprise'],
          );
          }

          //2.获取登录人次统计
          $loginResArr = Yii::app()->db->createCommand()
          ->select("member_id,count(1),FROM_UNIXTIME(create_time,'%Y-%m-%d') as date")
          ->from("{{login_history}}")
          ->where("create_time between $begintime and $endtime")
          ->group("member_id,date")
          ->queryAll();

          $loginData = array();
          foreach ($loginResArr as $rowLogin){
          if (isset($loginData[$rowLogin['date']])){

          }else{
          $loginData[$rowLogin['date']] = array(
          'num' => $rowLogin['num'],
          ''
          );
          }
          }



          for ($i=$begintime;$i<$endtime;$i+=$difftime){
          $date = date('Y-m-d',$i);
          $tmpData = array(
          'AddCountByPhone' => 0,						//手机注册
          'AddCountByMachine' => 0,					//盖机注册
          'AddCountByWebSite' => 0,					//网站注册
          'AddCount' => 0,							//总共注册
          'AddStoreInfoCount' => 0,					//企业注册
          'Time' => (double)(strtotime($date)."000"),	//时间戳（包含毫秒）
          'StatisticsDate'=>$date,					//时间
          );
          if (isset($regData[$date])){
          $tmpArr = $regData[$date];
          if($tmpArr['register_type']==Member::REG_TYPE_APP)(int)$tmpData['AddCountByPhone']+=$tmpArr['num'];				//手机APP
          if($tmpArr['register_type']==Member::REG_TYPE_MESSAGE)(int)$tmpData['AddCountByPhone']+=$tmpArr['num'];			//手机短信
          if($tmpArr['register_type']==Member::REG_TYPE_DEFAULT)(int)$tmpData['AddCountByWebSite']+=$tmpArr['num'];		//默认
          if($tmpArr['register_type']==Member::REG_TYPE_WEBSITE)(int)$tmpData['AddCountByWebSite']+=$tmpArr['num'];		//网站
          if($tmpArr['register_type']==Member::REG_TYPE_MACHINE)(int)$tmpData['AddCountByMachine']+=$tmpArr['num'];		//盖机
          if($tmpArr['is_enterprise']==Member::ENTERPRISE_YES)(int)$tmpData['AddStoreInfoCount']+=$tmpArr['num'];				//企业
          $tmpData['AddCount']+=(int)$tmpArr['num'];

          }
          $dataArr[] = $tmpData;
          }

          $sql = "desc table {{member_day}}";
          $resutl = Yii::app()->st->createCommand($sql)->queryAll();
          Tool::pr($resutl);
          echo json_encode($dataArr);
         * */
    }

    /**
     * 获取指定日期注册记录
     */
    public function actionDayReg() {
        $time = substr($_GET['time'], 0, -3);
        $model = new Member('search');

        $model->register_time = $time;

        $this->breadcrumbs = array('查看注册记录', date('Y-m-d', $time));
        $this->render('dayreg', array(
            'model' => $model,
        ));
    }

    /**
     * 获取指定日期登陆记录
     */
    public function actionDayLogin() {
        $time = substr($_GET['time'], 0, -3);
        $model = new LoginHistory('search');

        $model->create_time = $time;

        $this->breadcrumbs = array('查看登陆记录', date('Y-m-d', $time));
        $this->render('daylogin', array(
            'model' => $model,
        ));
    }

    /**
     * 商铺统计查询获取数据
     */
    public function actionGetStoreData() {
        $date = $_GET['minTime'];

        //初始化结果值
        $data = array('Chart' => array());
        $storeData = Yii::app()->st->createCommand()
                ->select("new_store_count,total_store_count,applying_store_count,ontrial_store_count,pass_store_count,closed_store_count,statistics_date,create_time")
                ->from("{{store_day}}")
                ->where("FROM_UNIXTIME(create_time,'%Y-%m') = '$date'")
                ->queryAll();

        foreach ($storeData as $row) {
            $data['Chart'][] = array(
                'TotalStoreCount' => (int) $row['total_store_count'], //总共的商铺数量
                'ApplyingStoreCount' => (int) $row['applying_store_count'], //申请中的商铺数量
                'ClosedStoreCount' => (int) $row['closed_store_count'], //关闭中的商铺数量
                'NewStoreCount' => (int) $row['new_store_count'], //新增的商铺数量
                'OnTrialStoreCount' => (int) $row['ontrial_store_count'], //试用中的商铺数量
                'PassStoreCount' => (int) $row['pass_store_count'], //审核通过的商铺数量
                'StatisticsDate' => (int) $row['statistics_date'], //日期
                'Time' => (double) ($row['create_time'] . "000"), //时间戳
            );
        }

        echo json_encode($data);
    }

    /**
     * 商铺排行查询显示数据
     */
    public function actionGetStoreListData() {
        $beginMonth = isset($_GET['minTime']) ? strtotime($_GET['minTime']) : strtotime(date('Y-m'));//月开始时间戳
        $endMonth = strtotime('1 month',$beginMonth);//月结束
        
//        $storeTable = Store::model()->tableName();
//        //获取访问量前20的商家。排行，商铺，PV，UV
//        $visitArr = Yii::app()->db->createCommand()
//                ->select("name,views")
//                ->from($storeTable)
//                ->order("views desc")
//                ->limit(20)
//                ->queryAll();
//
//        //获取订单量前20的商家。排行，商铺，成交订单总量，成交订单总金额，成交订单总供货价
//        Yii::app()->db->createCommand()
//                ->select("")
//                ->from()
//                ->group()
//                ->limit(20)
//                ->queryAll();
        $dataArr = array('OrderLists'=>array());
        
        $sql = "select store_id,store_name,sum(pay_order_count) as counts,sum(pay_order_gai_price) as gai,sum(pay_order_price) as price from {{shop_order_day}} where statistics_date between $beginMonth and $endMonth".
                " group by store_id order by counts desc,gai desc,price desc limit 20";
        $data = Yii::app()->st->createCommand($sql)->queryAll();

        foreach($data as $row){
            $dataArr['OrderLists'][] = array(
                'StoreId'=>$row['store_id'],
                'StoreName'=>$row['store_name'],
                'SuccessOrderCount'=>$row['counts'],
                'SuccessOrderPrice'=>$row['price'],
                'SuccessGaiPrice'=>$row['gai']
            );
        }
        echo CJSON::encode($dataArr);
        
    }
    
    
    /*
     * 订单统计页点击数据点弹出页
     */
    
    public function actionDayGaiOrderStatics(){
        //$this->layout = '_msg';
        $datetime = substr($_GET['time'], 0, -3);
        //$datetime = strtotime(date('2012-09-29'));
        $date = date('Y-m-d',$datetime);
        $dateEnd = $datetime+86400;
        $type = $_GET['type'];
        
        $sql = "select t.code,m.gai_number,c.name,sum(g.gai_price) as gai_price,sum(g.total_price) as total_price,sum(g.freight) as freight";
        $sql.= " from {{order}} t";
        $sql.= " left join {{member}} m on m.id = t.member_id";
        $sql.= " left join {{order_goods}} g on t.id = g.order_id";
        $sql .= " left join {{store}} c on c.id = t.store_id";
        switch ($type) {
            case 1:
                $sql.= " where t.status=".Order::STATUS_NEW ." and t.create_time between $datetime and $dateEnd group by t.store_id";
                $text = '新订单';
                break;
            case 2:
                $sql .= " where t.pay_status=".Order::PAY_STATUS_YES ." and t.pay_time between $datetime and $dateEnd group by c.name";
                $text = '支付';
                break;
            case 3:
                $sql .= " where t.delivery_status=".Order::DELIVERY_STATUS_RECEIVE ." and t.sign_time between $datetime and $dateEnd group by c.name";
                $text = '签收';
            default:
                break;
        }

        $resDatas = Yii::app()->db->createCommand($sql)->query();
        $criteria=new CDbCriteria();
        //配置分页
        $pages = new CPagination($resDatas->rowCount);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $resDatas = Yii::app()->db->createCommand($sql." LIMIT :offset ,:limit");
        $resDatas->bindValue(':offset',$pages->currentPage*$pages->pageSize);
        $resDatas->bindValue(':limit',$pages->pageSize);
        $resData = $resDatas->queryAll();
        $this->render('dayorder',array('dateTime'=>$date,'text'=>$text,'resData'=>$resData,'pages'=>$pages));
    }
    
    
    /*
     * 商家总销售额排名  取数据
     * 
     */
    protected function _getStoresRankData($export = false){
    	$model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;
        
        if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$criteria->compare('t.create_time', ">=" . $datetime);
        	$criteria->compare('t.create_time', "<=" . $dateEnd);
        }

        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        
       
        //连表查询
        $criteria->select = 't.*, z.name as store_name,sum(t.real_price) as sum_price';
//        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';

        //店铺信息
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.store_id';
        $criteria->order = 'sum_price DESC';

        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        
        $dataRes = $model->findAll($criteria);
        
        //总销售额
        $total_order = new Order();
        $total_criteria = new CDbCriteria;
        $total_criteria->compare('t.status', Order::STATUS_COMPLETE);
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$total_criteria->compare('t.create_time', ">=" . $datetime);
        	$total_criteria->compare('t.create_time', "<=" . $dateEnd);
        }
        $total_criteria->select = 'sum(t.real_price) as sum_price';
        $total_info = $total_order->find($total_criteria);
        
        
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$total_info->sum_price);
    	
    }
    
	/*
     * 商家总销售额排名
     * 
     */
    public function actionStoresRank() {
    	$data_rs = $this->_getStoresRankData();
        $this->render('storesRank', $data_rs);
    }
    
    
	/*
     * 商家总销售额排名  导出excel
     * 
     */
    public function actionStoresRankExport() {
    	@ini_set('memory_limit', '2048M');
    	@set_time_limit(3600);
        Yii::import('comext.PHPExcel.*');
        
    	$data_rs = $this->_getStoresRankData(true);
    	
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '排名')
                ->setCellValue('B1', '商家')
                ->setCellValue('C1', '销售额')
                ->setCellValue('D1', '销售占比');
        $i = 2;
        
        if(is_array($data_rs['dataRes'])) {
            foreach ($data_rs['dataRes'] as $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $i-1)
                        ->setCellValue('B' . $i, $v['store_name'])
                        ->setCellValue('C' . $i, $v['sum_price'])
                        ->setCellValue('D' . $i, round(($v['sum_price']/$data_rs['totalPrice']*100),4).'%');
                $i++;
            }
        }
        // Rename worksheet
		@$objPHPExcel->getActiveSheet()->setTitle("商家总销售额排名".$_GET['time']);
		
		$name = date('YmdHis'.rand(0, 99999));
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$name.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
    	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		@SystemLog::record(Yii::app()->user->name . "导出商家总销售额排名 ");
		exit;
    	
    }
    
    
	/*
     * 商家-消费者排名  取数据
     * 
     */
    protected function _getStoreCustomerRankData($store_id,$export = false){
    	$model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;
        
        
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$criteria->compare('t.create_time', ">=" . $datetime);
        	$criteria->compare('t.create_time', "<=" . $dateEnd);
        }

        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        $criteria->compare('t.store_id', $store_id);
        
        //连表查询
        $criteria->select = 't.*, y.username as member_name ,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';

        //店铺信息
//        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.member_id';
        $criteria->order = 'sum_price DESC';

        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        
        $dataRes = $model->findAll($criteria);
        
        
        //取当前商家总营业额
        $store_order = new Order();
        $store_criteria = new CDbCriteria;
        $store_criteria->compare('t.status', Order::STATUS_COMPLETE);
        $store_criteria->compare('t.store_id', $store_id);
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$store_criteria->compare('t.create_time', ">=" . $datetime);
        	$store_criteria->compare('t.create_time', "<=" . $dateEnd);
        }
        $store_criteria->select = 'z.name as store_name,sum(t.real_price) as sum_price';
        $store_criteria->join .= ' left join {{store}} as z on(t.store_id=z.id) ';
        $store_criteria->group = 't.store_id';
        $storeInfo = $store_order->find($store_criteria);
        
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$storeInfo->sum_price,'storeInfo'=>$storeInfo);
    	
    }
    
	/*
     * 商家-消费者排名
     * 
     * 商家为纬度，所对应的消费者的排名（占比）
     * 
     */
    public function actionStoreCustomerRank($store_id) {
    	$data_rs = $this->_getStoreCustomerRankData($store_id);
        $this->render('companyCustomerRank', $data_rs);
    }
    
    
    
/*
     * 商家-消费者排名  导出excel
     * 
     */
    public function actionStoreCustomerRankExport($store_id) {
    	@ini_set('memory_limit', '2048M');
    	@set_time_limit(3600);
        Yii::import('comext.PHPExcel.*');
        
    	$data_rs = $this->_getStoreCustomerRankData($store_id,true);
    	$storeInfo = $data_rs['storeInfo'];
    	
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '排名')
                ->setCellValue('B1', '消费者用户名')
                ->setCellValue('C1', '消费金额')
                ->setCellValue('D1', '占比');
        $i = 2;

        if(is_array($data_rs['dataRes'])) {
            foreach ($data_rs['dataRes'] as $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $i-1)
                        ->setCellValue('B' . $i, $v['member_name'])
                        ->setCellValue('C' . $i, $v['sum_price'])
                        ->setCellValue('D' . $i, round(($v['sum_price']/$data_rs['totalPrice']*100),4)."%");
                $i++;
            }
        }
        // Rename worksheet
		@$objPHPExcel->getActiveSheet()->setTitle("商家（{$storeInfo->store_name}）下的消费者消费金额排名".$_GET['time']);
		
		$name = date('YmdHis'.rand(0, 99999));
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$name.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
    	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		@SystemLog::record(Yii::app()->user->name . "导出商家-消费者排名 ");
		exit;
    	
    }
    
    
    
    
	/*
     * 消费者消费额排名  取数据
     * 
     */
    protected function _getCustomerRankData($export = false){
    	$model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;

        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$criteria->compare('t.create_time', ">=" . $datetime);
        	$criteria->compare('t.create_time', "<=" . $dateEnd);
        }

        //连表查询
        $criteria->select = 't.*, y.username as member_name ,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';

        //店铺信息
//        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.member_id';
        $criteria->order = 'sum_price DESC';

        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        
        $dataRes = $model->findAll($criteria);
        
        
        //总销售额
        $total_order = new Order();
        $total_criteria = new CDbCriteria;
        $total_criteria->compare('t.status', Order::STATUS_COMPLETE);
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$total_criteria->compare('t.create_time', ">=" . $datetime);
        	$total_criteria->compare('t.create_time', "<=" . $dateEnd);
        }
        $total_criteria->select = 'sum(t.real_price) as sum_price';
        $total_info = $total_order->find($total_criteria);
        
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$total_info->sum_price);
    	
    }
    
	/*
     * 消费者消费额排名
     * 
     * 
     */
    public function actionCustomerRank() {
        $data_rs = $this->_getCustomerRankData();
        $this->render('customerRank', $data_rs);
    }
    
    
    
	/*
     * 消费者消费额排名  导出excel
     * 
     */
    public function actionCustomerRankExport() {
    	@ini_set('memory_limit', '2048M');
    	@set_time_limit(3600);
        Yii::import('comext.PHPExcel.*');
        
    	$data_rs = $this->_getCustomerRankData(true);
    	
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '排名')
                ->setCellValue('B1', '消费者用户名')
                ->setCellValue('C1', '消费金额')
                ->setCellValue('D1', '消费占比');
        $i = 2;

        foreach ($data_rs['dataRes'] as $v) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $i-1)
                    ->setCellValue('B' . $i, $v['member_name'])
                    ->setCellValue('C' . $i, $v['sum_price'])
                    ->setCellValue('D' . $i, round(($v['sum_price']/$data_rs['totalPrice']*100),4).'%');
            $i++;
        }

        // Rename worksheet
		@$objPHPExcel->getActiveSheet()->setTitle("消费者消费额排名".$_GET['time']);
		
		$name = date('YmdHis'.rand(0, 99999));
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$name.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
    	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		@SystemLog::record(Yii::app()->user->name . "导出消费者消费额排名 ");
		exit;
    	
    }
    
    
	/*
     * 消费者-商家排名  取数据
     * 
     */
    protected function _getCustomerStoreRankData($member_id,$export = false){
    	$model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;

        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        $criteria->compare('t.member_id', $member_id);
        
        
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$criteria->compare('t.create_time', ">=" . $datetime);
        	$criteria->compare('t.create_time', "<=" . $dateEnd);
        }
        
        //连表查询
        $criteria->select = 't.*, z.name as store_name ,sum(t.real_price) as sum_price';
//        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';

        //店铺信息
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.store_id';
        $criteria->order = 'sum_price DESC';

        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        
        $dataRes = $model->findAll($criteria);
        
        
        //取当前消费者总消费额
        $member_order = new Order();
        $member_criteria = new CDbCriteria;
        $member_criteria->compare('t.status', Order::STATUS_COMPLETE);
        $member_criteria->compare('t.member_id', $member_id);
    	if (!empty($_GET['time'])){
        	$datetime = strtotime($_GET['time']);
        	$dateEnd = strtotime ( '+1 month', $datetime);
        	$member_criteria->compare('t.create_time', ">=" . $datetime);
        	$member_criteria->compare('t.create_time', "<=" . $dateEnd);
        }
        $member_criteria->select = 'y.username as member_name,sum(t.real_price) as sum_price';
        $member_criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';
        $member_criteria->group = 't.member_id';
        $enterprise = $member_order->find($member_criteria);
        
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$enterprise->sum_price,'enterprise'=>$enterprise);
    	
    }
    
    
	/*
     * 消费者-商家排名
     * 
     * 消费者为纬度、所对应的商家的排名（占比）
     * 
     */
    public function actionCustomerStoreRank($member_id) {
        $data_rs = $this->_getCustomerStoreRankData($member_id);
        $this->render('customerCompanyRank', $data_rs);
    }
    
    
/*
     * 消费者-商家排名  导出excel
     * 
     */
    public function actionCustomerStoreRankExport($member_id) {
    	@ini_set('memory_limit', '2048M');
    	@set_time_limit(3600);
        Yii::import('comext.PHPExcel.*');
        
    	$data_rs = $this->_getCustomerStoreRankData($member_id,true);
    	$enterprise = $data_rs['enterprise'];
    	
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '排名')
                ->setCellValue('B1', '商家')
                ->setCellValue('C1', '销售金额')
                ->setCellValue('D1', '占比');
        $i = 2;

        foreach ($data_rs['dataRes'] as $v) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $i-1)
                    ->setCellValue('B' . $i, $v['store_name'])
                    ->setCellValue('C' . $i, $v['sum_price'])
                    ->setCellValue('D' . $i, round(($v['sum_price']/$data_rs['totalPrice']*100),4).'%');
            $i++;
        }

        // Rename worksheet
		@$objPHPExcel->getActiveSheet()->setTitle("消费者（{$enterprise->member_name}）下的商家销售金额排名".$_GET['time']);
		
		$name = date('YmdHis'.rand(0, 99999));
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$name.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
    	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		@SystemLog::record(Yii::app()->user->name . "消费者-商家排名 ");
		exit;
    	
    }
    

    /*
     * 商家总销售额排名
     * 
     */
    public function actionStoresRankExtend() {
        $this->render('storesRankExtend', $this->_getStoresRankDataExtend());
    }
    
    /*
     * 商家总销售额排名  取数据
     * 
     */
    protected function _getStoresRankDataExtend($export = false) {
        $pager = $dataRes = $pagesize = $totalPrice = array();
        $today = strtotime(date("Y-m-d"));
        // 今天有完成状态的订单(非退货)
        $storeIdArr = Yii::app()->db->createCommand()
                ->select(array('distinct(store_id)'))->from('{{order}}')
                ->where('status=:stu and sign_time>=:st and sign_time<=:et',
                        array(':stu'=>Order::STATUS_COMPLETE,':st'=>$today,':et'=>$today+86400))
                ->queryColumn();
        if(empty($storeIdArr)){
            $this->setFlash('error', '今天未有销售的商家!');
            return;
        }
        $storeIds = implode(',', $storeIdArr);
        
        $finishTimeRange = '';
        $startTime = isset($_GET['startTime']) && $_GET['startTime'] ? strtotime($_GET['startTime']) : 0;
        $endTime = isset($_GET['endTime']) && $_GET['endTime'] ? strtotime($_GET['endTime']) : 0;
        if($startTime == false){
            if($endTime){
                $this->setFlash('error', '请选择开始日期!');
                return;
            }
            $startTime = $today - 3*86400;
        }
        if($endTime == false){
            $endTime = $today;
        }
        $endTime += 86400;
        if($endTime - $startTime > 30*86400){
            $this->setFlash('error', '日期范围请不要超过30天!');
            return;
        }
        $finishTimeRange = "t.sign_time>='{$startTime}' and t.sign_time<='{$endTime}'";
        
        // 今天有完成单的商家,前3天的所有完成订单
        $where = 't.store_id in('.$storeIds.') and t.status="'.Order::STATUS_COMPLETE.'" and '.$finishTimeRange;
        // 总金额
        $totalPrice = Yii::app()->db->createCommand()
                ->select(array('sum(real_price)'))->from('{{order}} t')->where($where)
                ->queryScalar();
        
        // 店铺信息
        $model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export) ? $pagesize = 500000 : 20;
        $criteria->addCondition($where);  
        $criteria->select = 't.*, z.name as store_name,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.store_id';
        $criteria->order = 'sum_price DESC';
        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = $pagesize;
        $pager->applyLimit($criteria);
        $dataRes = $model->findAll($criteria);
        return array('pages' => $pager, 'dataRes' => $dataRes, 'pagesize' => $pagesize, 'totalPrice' => $totalPrice,
            'startTime'=>date('Y-m-d',$startTime),'endTime'=>date('Y-m-d',$endTime-86400));
    }
    
    /*
     * 商家-消费者排名
     * 
     * 商家为纬度，所对应的消费者的排名（占比）
     * 
     */
    public function actionStoreCustomerRankExtend($store_id) {
        $this->render('companyCustomerRankExtend', $this->_getStoreCustomerRankDataExtend($store_id));
    }
    
    /*
     * 商家-消费者排名  取数据
     * 
     */
    protected function _getStoreCustomerRankDataExtend($store_id,$export = false){
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;
        
        $store = Store::model()->findByPk($store_id);
        $storeName = $store->name;
        
        $today = strtotime(date("Y-m-d"));
        $criteria->compare('t.store_id', $store_id);
        $criteria->compare('t.pay_status', Order::PAY_STATUS_YES);
        $criteria->compare('t.refund_status', Order::REFUND_STATUS_NONE);
        $criteria->compare('t.return_status', Order::RETURN_STATUS_NONE);
//        $criteria->addBetweenCondition('t.pay_time', strtotime(date("Y-m").'-01'), $today+86400);//支付时间,按每月1号开始
        $criteria->addBetweenCondition('t.pay_time', $today-30*86400, $today+86400);//支付时间,一个月按30天
        
        //取当前商家总营业额
        $criteria->select = 'sum(t.real_price) as sum_price';
        $total_info = Order::model()->find($criteria);
        $totalPrice = $total_info->sum_price;
        
        //消费者数据
        $criteria->select = 't.*, y.username as member_name ,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';
        $criteria->group = 't.member_id';
        $criteria->order = 'sum_price DESC';
        $model = new Order();
        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        $dataRes = $model->findAll($criteria);
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$totalPrice,'storeName'=>$storeName);
    }
    
    /*
     * 消费者消费额排名
     */
    public function actionCustomerRankExtend() {
        $this->render('customerRankExtend', $this->_getCustomerRankDataExtend());
    }
    /*
     * 消费者消费额排名  取数据
     */
    protected function _getCustomerRankDataExtend($export = false){
        $today = strtotime(date("Y-m-d"));
        // 今天有消费的会员
        $memberIdArr = Yii::app()->db->createCommand()
                ->select(array('distinct(member_id)'))->from('{{order}}')
                ->where('pay_status=:stu and refund_status=:rfs and return_status=:rts and pay_time>=:st and pay_time<=:et',
                        array(':stu'=>Order::PAY_STATUS_YES,':rfs'=>Order::REFUND_STATUS_NONE,':rts'=>Order::RETURN_STATUS_NONE,':st'=>$today,':et'=>$today+86400))
                ->queryColumn();
        if(empty($memberIdArr)){
            $this->setFlash('error', '今天未有消费的会员!');
            return;
        }
        $memberIds = implode(',', $memberIdArr);
        
        $payTimeRange = '';
//        $startTime = isset($_GET['startTime']) && $_GET['startTime'] ? strtotime($_GET['startTime']) : strtotime(date("Y-m").'-01');
        $startTime = isset($_GET['startTime']) && $_GET['startTime'] ? strtotime($_GET['startTime']) : ($today-30*86400);
        $endTime = isset($_GET['endTime']) && $_GET['endTime'] ? strtotime($_GET['endTime'])+86400 : $today+86400;
        $startTimeDate = getdate($startTime);
        $endTimeDate = getdate($endTime);
        if($endTimeDate['mon'] - $startTimeDate['mon'] > 1 && $endTimeDate['mday'] > $startTimeDate['mday']){
            $this->setFlash('error', '日期范围请不要超过2个月!');
            return;
        }
        $payTimeRange = "t.pay_time>='{$startTime}' and t.pay_time<='{$endTime}'";
        
        // 今天有消费的会员,近一个月的消费
        $where = 't.member_id in('.$memberIds.') and t.pay_status="'.Order::PAY_STATUS_YES.'" and refund_status="'.Order::REFUND_STATUS_NONE.'" and return_status="'.Order::RETURN_STATUS_NONE.'" and '.$payTimeRange;
        // 总金额
        $totalPrice = Yii::app()->db->createCommand()
                ->select(array('sum(real_price)'))->from('{{order}} t')->where($where)
                ->queryScalar();
        
        $model = new Order();
        $criteria = new CDbCriteria;
        $pagesize = !empty($export)?$pagesize=500000:20;
        $criteria->addCondition($where);  
        $criteria->select = 't.*, y.username as member_name ,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id) ';
        $criteria->group = 't.member_id';
        $criteria->order = 'sum_price DESC';
        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = $pagesize;
        $pager->applyLimit($criteria);
        $dataRes = $model->findAll($criteria);
        
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$totalPrice,
            'startTime'=>date('Y-m-d',$startTime),'endTime'=>date('Y-m-d',$endTime-86400));
    }
    
    /*
     * 消费者-商家排名
     * 消费者为纬度、所对应的商家的排名（占比）
     */
    public function actionCustomerStoreRankExtend($member_id) {
        $this->render('customerCompanyRankExtend', $this->_getCustomerStoreRankDataExtend($member_id));
    }
    /*
     * 消费者-商家排名  取数据
     * 消费者3天内的消费情况
     */
    protected function _getCustomerStoreRankDataExtend($member_id,$export = false){
        $member = member::model()->findByPk($member_id);
        $memberName = $member->username;
        $today = strtotime(date("Y-m-d"));
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        $criteria->compare('t.member_id', $member_id);
        $criteria->addBetweenCondition('t.sign_time', $today-3*86400, $today+86400);
        //消费总金额
        $criteria->select = 'sum(t.real_price) as sum_price';
        $enterprise = Order::model()->find($criteria);
        //消费者消费情况
    	$model = new Order();
        $pagesize = !empty($export)?$pagesize=500000:20;
        $criteria->select = 't.*, z.name as store_name ,sum(t.real_price) as sum_price';
        $criteria->join = ' left join {{store}} as z on(t.store_id=z.id) ';
        $criteria->group = 't.store_id';
        $criteria->order = 'sum_price DESC';
        $count = $model->count($criteria);  
        $pager = new CPagination($count);    
        $pager->pageSize = $pagesize;             
        $pager->applyLimit($criteria);
        $dataRes = $model->findAll($criteria);
        return array('pages'=>$pager,'dataRes'=>$dataRes,'pagesize'=>$pagesize,'totalPrice'=>$enterprise->sum_price,'memberName'=>$memberName);
    }
    
    /*
     * 消费者消费额排名  导出excel
     * 
     */
    public function actionRankExport($type,$findId=false) {
    	@ini_set('memory_limit', '2048M');
    	@set_time_limit(3600);
        Yii::import('comext.PHPExcel.*');
        
        $i = 2;
        $objPHPExcel = new PHPExcel();
        if ($type == 1) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '排名')->setCellValue('B1', '商家')->setCellValue('C1', '销售额')->setCellValue('D1', '销售占比');
            $data = $this->_getStoresRankDataExtend(true);
            if(is_array($data['dataRes'])) {
                foreach ($data['dataRes'] as $v) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $i - 1)->setCellValue('B' . $i, $v['store_name'])->setCellValue('C' . $i, $v['sum_price'])->setCellValue('D' . $i, round(($v['sum_price'] / $data['totalPrice'] * 100), 4) . '%');
                    $i++;
                }
            }
            $title = "商家总销售额排名".$data['startTime'].'-'.$data['endTime'];
        } elseif ($type == 2 && $findId) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '排名')->setCellValue('B1', '消费者用户名')->setCellValue('C1', '消费金额')->setCellValue('D1', '占比');
            $data = $this->_getStoreCustomerRankDataExtend($findId, true);
            foreach ($data['dataRes'] as $v) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $i - 1)->setCellValue('B' . $i, $v['member_name'])->setCellValue('C' . $i, $v['sum_price'])->setCellValue('D' . $i, round(($v['sum_price'] / $data['totalPrice'] * 100), 4) . "%");
                $i++;
            }
            $title = "商家（{$data['storeName']}）下的消费者消费金额排名";
        } elseif ($type == 3) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '排名')->setCellValue('B1', '消费者用户名')->setCellValue('C1', '消费金额')->setCellValue('D1', '消费占比');
            $data = $this->_getCustomerRankDataExtend(true);
            if(is_array($data['dataRes'])) {
                foreach ($data['dataRes'] as $v) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $i - 1)->setCellValue('B' . $i, $v['member_name'])->setCellValue('C' . $i, $v['sum_price'])->setCellValue('D' . $i, round(($v['sum_price'] / $data['totalPrice'] * 100), 4) . '%');
                    $i++;
                }
            }
            $title = "消费者消费额排名".$data['startTime'].'-'.$data['endTime'];
        } elseif ($type == 4 && $findId) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '排名')->setCellValue('B1', '商家')->setCellValue('C1', '销售金额')->setCellValue('D1', '占比');
            $data = $this->_getCustomerStoreRankDataExtend($findId, true);
            foreach ($data['dataRes'] as $v) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $i - 1)->setCellValue('B' . $i, $v['store_name'])->setCellValue('C' . $i, $v['sum_price'])->setCellValue('D' . $i, round(($v['sum_price'] / $data['totalPrice'] * 100), 4) . '%');
                $i++;
            }
            $title = "消费者（{$data['memberName']}）下的商家销售金额排名";
        }else{
            exit;
        }

        // Rename worksheet
        @$objPHPExcel->getActiveSheet()->setTitle($title);

        $name = date('YmdHis'.rand(0, 99999));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        @SystemLog::record(Yii::app()->user->name . "导出消费者消费额排名");
        exit;
    }
}
