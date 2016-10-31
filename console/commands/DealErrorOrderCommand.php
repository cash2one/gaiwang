<?php

/**
 * 盖付通  扫码支付盖网通 ：
 * 相关数据表    
 * gw_franchisee_consumption_pre_record  预处理订单表
 * gw_account_balance              余额表
 * gw_account_balance_history      历史余额表
 * gw_recharge                     充值记录表
 * gw_flow_201603                  流水表
 * gw_flow_history_201603          历史流水表
 * 相关流程逻辑
 * 1. gw_flow表中没有记录
 *    原因 ： gw_account_balance_history.id 不存在gw_account_balance_history表中
 *    充值回滚，数据不用处理
 *    用户银行卡扣钱 信息列出
 * 2. gw_flow表中有相关记录  如果account_balance.id 拉取account_balance_history时，改账户是自己的，暂时不处理
 *    充值到别人账户 --》 |  用户积分余额存在，且够支付订单  --> 自己GW积分被扣除，钱被充值到别人账户，订单状态修改为已支付
 *                        |
 *    充值到自己账户 --》 |  用户积分未零或者不够支付订单    --> 钱被充值到别人账户，订单状态未支付
 **/

class DealErrorOrderCommand extends CConsoleCommand 
{

    protected $db;
    protected $rootDir;
    protected $sourcePath;
    protected $targetPath;

    public function __construct()
    {
        $this->db = Yii::app()->db;
        $this->rootDir = realpath(Yii::getPathOfAlias('root.console.data')).DS;
        $this->sourcePath = $this->rootDir.'ouptu.deal.data.json';
        $this->targetPath = $this->rootDir.'deal_amount_infos.txt';

    }

    public function actionIndex()
    {
        set_time_limit(0);
        ini_set('memory_limit','128M');

        if(file_exists($this->targetPath)){
            die("scripy run over ,no repeaty");
        }

        $data = file_get_contents($this->sourcePath);
        $data = json_decode($data,true);
        $this->deal($data);
        Yii::app()->end();
    }


    protected function deal($data)
    {
        date_default_timezone_set('PRC');
        $time =date('Ymd');
        $okNum = $errorNum = 0;

        foreach ($data as $key => $value) {

            $logInfos = json_encode($value).PHP_EOL;
            $id = $value['accountId'];
            $condition = array('today_amount' =>(0- $value['deductMoney']));    
            try {
                $account = $this->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance where id='.$id)->queryRow();
                if(empty($account)){
                    throw new Exception("不存在该账户", 1);
                }

                if($account['today_amount']<$value['deductMoney']){
                    throw new Exception("金额不够---失败", 1);
                }

                $logInfos .= "更新前账户数据:".PHP_EOL.json_encode($account);
                if(!AccountBalance::calculate($condition, $id)){
                    throw new Exception("失败", 1);
                }   
                $logInfos .= PHP_EOL."数据变动简述：更新前账户余额{$account['today_amount']}". PHP_EOL."更新数据如下：".PHP_EOL.json_encode(array('condition'=>$condition,'id'=>$id));
                $okNum +=1;
            } catch (Exception $e) {
                $logInfos .= '失败--'.$e->getMessage().PHP_EOL. json_encode(array('condition'=>$condition,'id'=>$id));
                $errorNum += 1;
            }
            $this->logDealAmountInfos($logInfos);
        }

        $totalNum = count($data);
        $tips = "总共处理{$totalNum}条数据,成功处理{$okNum},处理失败{$errorNum}条";
        $this->logDealAmountInfos($tips,'---------------------统计----------------------');
        echo $tips;
    }

    /**
     * [log description]
     */
    protected function logDealAmountInfos($logInfos,$separator='',$subfix='')
    {
        //记录日志，便于后期分析
        $path = $this->targetPath;

        $defaultSeparator = PHP_EOL."------------------------------------------" .PHP_EOL;
        $separator = $separator ? $separator.PHP_EOL : $defaultSeparator;
        $separator = PHP_EOL."--------------------------".date("m-d H:i:s")."--------------------------".PHP_EOL . $separator;

        $resLog = '';
        if(is_string($logInfos)){
            $resLog = $logInfos;
        }else{
            $resLog = json_encode($logInfos);
        }
        $resLog = $separator.$resLog .PHP_EOL. $subfix.PHP_EOL;
        @file_put_contents($path, $resLog, FILE_APPEND);
        return true;
    }
}