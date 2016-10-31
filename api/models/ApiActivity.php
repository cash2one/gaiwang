<?php

/**
 * 盖网通临时活动
 * Class ApiActivity
 */
class ApiActivity extends ApiModel {

    const start_time = '2016-7-29 00:00:00';//活动开启时间
    const end_time = '2016-7-30 23:59:59';//活动结束时间
    const register_start_time = '2015-11-27 17:00:00';//活动规则会员注册开始时间
    const start_hour = '113000';//开启时段
    const end_hour = '193000';//开启时段
    public static $machineIds = array("6110");//201503262124

    public static $inter_time = 86400;
    public static $prizeLottery = array("1"=>"现金券礼包","2"=>"精美纸巾");
    public static $cart = 100;
    public static $Tissue = 100;
/***********测试**********/
/*
    const start_time = '2015-11-24 00:00:00';//活动开启时间
    const end_time = '2015-11-26 23:59:59';//活动结束时间
    const register_start_time = '2015-11-24 11:00:00';//活动规则会员注册开始时间
    const start_hour = '113000';//开启时段
    const end_hour = '193000';//开启时段
    public static $machineIds = array("6110","6486","6483");//"201511055323"
*/
/***********测试**********/

    public static $s_time = '';
    public static $prize = array("1"=>"谢谢参与","2"=>"数据线","3"=>"Q版公仔");
/*
    public static function addPrize(){
        $a = array_fill(0, 100, '1');
        $b = array_fill(0, 25, '2');
        $c = array_fill(0, 100, '3');
        $ary = array_merge($a,$b,$c);
        $prize_all = json_encode($ary);
        $sql = "INSERT INTO {{config}} SET code = 'ACTIVITY_PRIZE_20151127',`value`='{$prize_all}'";
//        $sql = "INSERT INTO {{config}} SET code = 'ACTIVITY_PRIZE_20151125',`value`='{$prize_all}'";
        Yii::app()->gt->CreateCommand($sql)->execute();
        $sql = "INSERT INTO {{config}} SET code = 'ACTIVITY_PRIZE_20151128',`value`='{$prize_all}'";
//        $sql = "INSERT INTO {{config}} SET code = 'ACTIVITY_PRIZE_20151126',`value`='{$prize_all}'";
        Yii::app()->gt->CreateCommand($sql)->execute();
    }*/

    public static function errLog($msg){
        Yii::log($msg,CLogger::LEVEL_ERROR,'activity');
    }

    /**
     * 按日期设定缓存key
     * @var string
     */
    public static $day = '';
    public static $member_winning_cache_key = "";//会员的中奖缓存
    public static $prize_all = "";//全部奖品集合
    public static function getConfig($machineid = 0){
        self::$day = date('Ymd');
        self::$member_winning_cache_key = str_replace('{day}',self::$day,'activity-member-winning-{day}').$machineid;
        self::$prize_all = str_replace('{day}',self::$day,"activity-prize-all-{day}").$machineid;
    }


    /**
     * 检查活动时间
     * @param $machineId
     * @return bool
     */
    public static function checkRunning($machineId){
        $now = time();
        if($now < strtotime(self::start_time) || $now > strtotime(self::end_time)){
            self::errLog('day err');
            return false;
        }
        //每天10:30-20:30
        $day = date('His');
        if($day < self::start_hour || $day > self::end_hour){
            self::errLog('time err');
            return false;
        }
        //检查机器
        if(!in_array($machineId, self::$machineIds)){
            self::errLog('machine err');
            return false;
        }
        return true;
    }

    /**
     * 抽奖业务
     * @param $machineId
     * @param $memberId
     * @return bool
     */
    public static function getResult($machineId,$memberId){
        if(self::$s_time == false) self::$s_time =time();
        self::getConfig();
        //检查时间
        if(!self::checkRunning($machineId)){
            return false;
        }
        //检查奖品
        if(!self::getPrizeAll()){
            self::errLog('no prize');
            return false;
        }

        //检查会员获奖情况
        self::checkMemberTempLuckyData($memberId);
        //抽奖
        $LuckyItem = self::drawPrize();
        if($LuckyItem == false){
            return false;
        }

        //记录获奖日志
        $insertData = array('machine_id' => $machineId, 'member_id' => $memberId, 'lucky' => $LuckyItem, 'create_time' => time(),'batch'=>self::$day);
        Yii::app()->gt->createcommand()->insert('{{machine_temp_lucky_data}}',$insertData);
        //结果返回
        $LuckyExample = self::$prize;

        $xml='<LuckItems>';
        foreach($LuckyExample as $key=>$val)
        {
            $xml.= '<LuckItem>';
            $xml.= '<LuckItemID>'.$key.'</LuckItemID>';
            $xml.= '<ItemName>'.$val.'</ItemName>';
            $xml.= '</LuckItem>';
        }
        $xml.='</LuckItems>';
        $xml.= '<Reward>1</Reward>';

        //中奖项
        $xml.='<LuckItemID>'.$LuckyItem.'</LuckItemID>';
        self::exportXml($xml);
    }
    /**
     * 抽奖业务2016/7/23
     * @param $machineId
     * @param $memberId
     * @return bool
     */
    public static function getLotteryResult($machineId,$memberId){
        $now = time();

        //检查时间
        if($now < strtotime(self::start_time) || $now > strtotime(self::end_time)){
            self::errLog('day err');
            $re = $now.'//'.strtotime(self::start_time);
            self::errorEndXml($re);
        }

        self::getConfig($machineId);
        //Yii::app()->redis->set(self::$prize_all,false,2);exit;
        //检查奖品
        if(!self::getLotteryPrizeAll()){
            self::errLog('no prize');
            self::errorEndXml('没有奖品!');
        }
        //检查会员获奖情况
        self::checkMemberTempLuckyData($memberId);

        //抽奖
        $LuckyItem = self::drawLotteryPrize($machineId);
        $Reward = 1;
        if($LuckyItem == false){
            $Reward = 0;
        }
        $file_array = self::getLotteryPrizeAll();
        $file_array = json_decode($file_array,true);
        $file_array['time'] = date("Y-m-d H:i:s");
        $file_array['machineid'] = $machineId;
        $file_array['LuckyItem'] = $LuckyItem;
        //记录获奖日志
        $insertData = array('machine_id' => $machineId, 'member_id' => $memberId, 'lucky' => json_encode($file_array), 'create_time' => time(),'batch'=>self::$day);
       Yii::app()->gt->createcommand()->insert('{{machine_temp_lucky_data}}',$insertData);
        //结果返回
        $LuckyExample = self::$prizeLottery;
        $LuckItemID = array_keys($LuckyItem);

        $xml='<LuckItems>';
        foreach($LuckyExample as $key=>$val)
        {
            $xml.= '<LuckItem>';
            $xml.= '<LuckItemID>'.$key.'</LuckItemID>';
            $xml.= '<ItemName>'.$val.'</ItemName>';
            $xml.= '</LuckItem>';
        }
        $xml.='</LuckItems>';
        $xml.= '<Reward>'.$Reward.'</Reward>';

        //中奖项
        $xml.='<LuckItemID>'.($Reward == 1?$LuckItemID[0]:'').'</LuckItemID>';
        self::exportXml($xml);
    }
    public static function getLotteryPrizeAll(){
        $prize_all = Yii::app()->redis->get(self::$prize_all);
        if(empty($prize_all)){
            $prize_all =array('1'=>self::$cart,'2'=>self::$Tissue,'0'=>1);
            $expire = 3600*24*3;
            Yii::app()->redis->set(self::$prize_all,json_encode($prize_all),$expire);
        }
        return $prize_all;
    }
    /**
     * 抽奖
     * 时间  2016/7/19
     * @return bool|mixed
     */
    public static function drawLotteryPrize($machineId = 0){
        $number = 0;
        $num = 0;
        $prize = array();
        $end_time = strtotime(self::end_time);
        $now_time = time();
        //奖品库存缓存
        $prize_all_bug = self::getLotteryPrizeAll();
        $prize_all = json_decode($prize_all_bug,true);
        if($prize_all == false || empty($prize_all)){
            return false;
        }
        if(($end_time - $now_time < self::$inter_time) && $prize_all[0] == 1){
            $is_exist = Yii::app()->gt->createcommand()
                ->select("lucky")
                ->from("{{machine_temp_lucky_data}}")
                ->where("machine_id= :machine_id",array(":machine_id"=>$machineId))
                ->order('create_time DESC')
                ->queryScalar();
            if(!empty($is_exist)) {
                $first = json_decode($is_exist, true);
                $prize_all[1] = $first[1] + self::$cart;
                $prize_all[2] = $first[2] + self::$Tissue;
            }else{
                $prize_all[1] = $prize_all[1] + self::$cart;
                $prize_all[2] = $prize_all[2] + self::$Tissue;
            }
            $prize_all[0] = 2;
        }
        while($number != 1 || $number != 2){
            $number = rand(1,2);
            $num ++;
            if($num > 10) break;
        }
        if($number != 1 && $number != 2){
            return false;
        }
        if(($prize_all[$number] > 0 )){
            $prize[$number] = $prize_all[$number];
            $prize_all[$number] = $prize_all[$number] - 1;
        }elseif(($number == 1) && ($prize_all[2] > 0)){
            $prize[2] = $prize_all[2];
            $prize_all[2] = $prize_all[2] - 1;
        }elseif(($number == 2) && ($prize_all[1] > 0)){
            $prize[1] = $prize_all[1];
            $prize_all[1] = $prize_all[1] - 1;
        }
        self::updateLotteryPrizeAll($prize_all);
        return $prize;
    }
    public static function updateLotteryPrizeAll(array $prize_all){
        $prize_all = json_encode($prize_all);
        $expire = 3600*24*3;
        Yii::app()->redis->set(self::$prize_all,$prize_all,$expire);
    }

    public static function updatePrizeAll(array $prize_all,$setCache=false){
        $date = date('Ymd');
        $prize_all = json_encode($prize_all);
        $sql = "UPDATE {{config}} SET `value`='{$prize_all}' WHERE code = 'ACTIVITY_PRIZE_{$date}'";
        Yii::app()->gt->CreateCommand($sql)->execute();
        $expire = (self::end_time - self::start_time) + 3600*24;
        if($setCache)Yii::app()->redis->set(self::$prize_all,$prize_all,$expire);
    }

    public static function getPrizeAll(){
        $date = date('Ymd');
        $prize_all = Yii::app()->redis->get(self::$prize_all);
        if($prize_all === false){
            $sql = "SELECT `value` FROM {{config}} where code = 'ACTIVITY_PRIZE_{$date}'";
            $prize_all = Yii::app()->gt->CreateCommand($sql)->queryScalar();
            if($prize_all === false){
                $prize_all = json_encode(false);
            }
            $expire = (self::end_time - self::start_time) + 3600*24;
            Yii::app()->redis->set(self::$prize_all,$prize_all,$expire);
        }
        return json_decode($prize_all);
    }

    public static function addSurplusPrize(){
        $startDate = date('Ymd',strtotime(self::start_time));
        $endDate = date('Ymd',strtotime(self::end_time));
        $date = date('Ymd');
        if($startDate < $date && $date <= $endDate){
            $yesterday = $date - 1;
            $sql = "SELECT `value` FROM {{config}} where code = 'ACTIVITY_PRIZE_{$yesterday}'";
            $prize = Yii::app()->gt->CreateCommand($sql)->queryScalar();
            var_dump('surplus '.$prize);
            $prize && $prize = json_decode($prize);
            if(!empty($prize)){
                $sql = "SELECT `value` FROM {{config}} where code = 'ACTIVITY_PRIZE_{$date}'";
                $prize_today = Yii::app()->gt->CreateCommand($sql)->queryScalar();
                var_dump('today '.$prize_today);

                $prize_today && $prize_today = json_decode($prize_today);
                $prize_all = array_merge($prize,$prize_today);
                $prize_all = json_encode($prize_all);
                var_dump('all '.$prize_all);
                Yii::app()->gt->CreateCommand("UPDATE {{config}} SET `value`='{$prize_all}' where code = 'ACTIVITY_PRIZE_{$date}'")->execute();
                Yii::app()->gt->CreateCommand("UPDATE {{config}} SET `value`='[]' where code = 'ACTIVITY_PRIZE_{$yesterday}'")->execute();
            }
        }
    }

    public static function look(){
        $startDate = date('Ymd',strtotime(self::start_time));
        $endDate = date('Ymd',strtotime(self::end_time));
        $date = date('Ymd');
        if($startDate <= $date && $date <= $endDate){
            $sql = "SELECT `value` FROM {{config}} where `code` = 'ACTIVITY_PRIZE_{$date}'";
            $prize_all = Yii::app()->gt->CreateCommand($sql)->queryScalar();
            var_dump($date,$prize_all,count(json_decode($prize_all)));

            $sql = "SELECT `lucky` as prize,count(1) as num FROM {{machine_temp_lucky_data}} where `batch` = '{$date}' group by `lucky`";
            var_dump(Yii::app()->gt->CreateCommand($sql)->queryAll());
        }
    }

    public static function clearCache($machineId = 0){
        self::getConfig($machineId);
        Yii::app()->redis->set(self::$prize_all,false,2);
    }
    public static function setCache($machineId = 0){
        self::getConfig($machineId);
        $prize_all_bug = self::getLotteryPrizeAll();
        $prize_all = json_decode($prize_all_bug,true);
        $prize_all = json_encode($prize_all);
        var_dump($prize_all);
    }
    public static function getCache(){
        self::getConfig();
        return Yii::app()->redis->get(self::$prize_all);
    }


    /**
     * 抽奖
     * @return bool|mixed
     */
    public static function drawPrize(){
        //奖品库存缓存
        $prize_all = self::getPrizeAll();
        if($prize_all == false || empty($prize_all)){
            return false;
        }
        /*
        shuffle($prize_all);
        shuffle($prize_all);
        $prize = array_shift($prize_all);
        */
        $prize = self::pause($prize_all);//优化出奖间隔
        self::updatePrizeAll($prize_all,true);

        return $prize;
    }

    /**
     * 控制出奖间隔
     * @param $prize_all
     * @return mixed
     */
    public static function pause(&$prize_all){
        shuffle($prize_all);
        $prize = $prize_all['0'];
        $prize_counts = array_count_values($prize_all);
        if(count($prize_all) <= (173-((4-$prize_counts[$prize])*40))){
            return array_shift($prize_all);
        }else{
//            shuffle($prize_all);
            return self::pause($prize_all);
        }
    }


    /**
     * 检查会员抽奖记录
     * @param $memberId
     */
    public static  function checkMemberTempLuckyData($memberId){
        $GaiNumbercachekey = self::$member_winning_cache_key;
        $batch = self::$day;
        Yii::app()->redis->set($GaiNumbercachekey,false,1);
        //获奖者缓存
        $result = unserialize(Yii::app()->redis->get($GaiNumbercachekey));
        if(!$result || !in_array($memberId,$result)){
            $is_exist = Yii::app()->gt->createcommand()
                ->select("member_id")->from("{{machine_temp_lucky_data}}")
                ->where("batch='{$batch}' AND member_id = {$memberId}")
                ->queryScalar();
            if($is_exist){
                if(!$result){
                    $result = array();
                }
                array_push($result, $memberId);
                $expire = (self::end_time - self::start_time) + 3600*24;
                Yii::app()->redis->set($GaiNumbercachekey,serialize($result),$expire);
                self::errorEndXml('抱歉,您已参加过此次活动!');
            }
        }else{
            self::errorEndXml('抱歉,您已参加过此次活动!');
        }
    }

    /*
     * 查找注册人数
     */
    public static function checkMachineRegisterCount($machineId){
        return 1;
        $time = strtotime(self::register_start_time);
        //08-15开始新注册用户数
        return Yii::app()->gt->createcommand()
            ->select("count(id) as count")
            ->from("{{machine_register}}")
            ->where("machine_id = {$machineId} and register_time >= '{$time}'")
            ->queryScalar();
    }

    public static function exportXml($data) {
        header("Content-type:text/html;charset=utf-8");
        $xmlString = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Response ActionType="">
$data
<ResultCode>1</ResultCode>
</Response>
XML;
        echo $xmlString;
        Yii::app()->end();
    }

    public static function errorEndXml($message, $node = '') {
        $message = str_replace("<", "&lt;", str_replace("&", "&amp;", $message));   //处理xml非法字符
        $message = Yii::t('appApi', $message);
        header("Content-type:text/html;charset=utf-8");
        $xmlString = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Response ActionType="">
<ResultCode>0</ResultCode>
<ResultDesc>$message</ResultDesc>$node
</Response>
XML;
        echo $xmlString;
        Yii::app()->end();
    }
}

?>