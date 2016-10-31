<?php

/**
 * 流水导出脚本
 * @author qinghao.ye <qinghao.ye@g-emall.com>
 * yiic exportFlow exportCsv
 * yiic exportFlow exportBatchCsv 20150302206
 */
class ExportFlowCommand extends CConsoleCommand {

    const FTP_PATH = '/attachments/export_data';

    const EXPORT_DAIKOU = 1;

    public $flow_export_daikou_str = '';
    public $flow_export_str = '';
    public $flow_export_ids = array();

    public function getFileRootPath(){
        $path = Yii::getPathOfAlias('root') . DS . '..' . DS . 'source' . DS . 'attachments' . DS . 'export_data';
        if(!is_dir($path)) @mkdir($path);
        return $path.DS;
    }

    public function getFilePath(){
        $path = $this->getFileRootPath();
        if(!is_dir($path.'flow')) @mkdir($path.'flow');
        return $path.'flow'.DS;
    }
    public function deleteDir()
    {
        //先删除目录下的文件
        $dir = $this->getFileRootPath().'flow';
	if (!is_dir($dir)) {
            return true;
        }
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullPath = $dir . DS . $file;
                if (!is_dir($fullPath)) {
                    unlink($fullPath);
                } else {
                    $this->deleteDir($fullPath);
                }
            }
        }
        closedir($dh);
        //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
    public function getFileName($export_batch){
        return 'flow-'.$export_batch.'.csv'; //设置文件名
    }
    public function getFileNameDk($export_batch){
        return 'daikou-'.$export_batch.'.csv'; //设置文件名
    }

    /**
     * 导出新流水csv
     */
    public function actionExportCsv() {
        @ini_set('memory_limit', '7000M');
        @ini_set("max_execution_time", "0");
        $month = date('Ym', time());
//        $lastMonth = date("Ym", strtotime(date('Y-m-01')) - 86400);
        $month_result = self::getMonth($month);
        $lastMonth = $month_result['lastMonth'];

        // 存放目录
        self::ftpCreateDir();
        $this->deleteDir();
        $path = $this->getFilePath();
        $export_log = dirname($path).'/';
        exec('rm -f '.$export_log.'export*');
        // 导出批次
        $export_batch = date('Ymd', time()).str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);//导出批次
        $filename = $this->getFileName($export_batch); //设置文件名

        $cols = array(
            'export_batch' => '批次',
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '卡号',
            'create_time' => '创建时间',
            'type' => '类型',
            'debit_amount' => '借方发生额',
            'credit_amount' => '贷方发生额',
            'operate_type' => '交易类型',
            'trade_spec' => '地点',
            'trade_terminal_id' => '所属终端',
            'ratio' => '比率',
            'order_code' => '订单编号',
            'area_id' => '区域类型',
            'remark' => '备注',
            'moved' => '是否搬送',
            'node' => '业务节点',
            'franchisee_id' => '加盟商',
            'recharge_type' => '充值类型',
            'distribution_ratio' => '分配比率',
            'transaction_type' => '事务类型',
            'parent_id' => 'Parent',
            'prepaid_card_no' => '充值卡编号',
            'current_balance' => '当前余额',
            'flag' => '标识',
            'by_gai_number' => '被推荐人GW',
        );
        $export_field = array_keys($cols);//导出字段
        $export_title = array_values($cols);//导出标题
        $selectFeilds = implode(',',$export_field);//查询字段

        unset($cols,$export_field);

        // 查询
        if($lastMonth != $month) $this->getCsvData($lastMonth,$export_batch,$selectFeilds,false);
        $this->getCsvData($month,$export_batch,$selectFeilds,false,'B');
        if($this->flow_export_str == false) die('none');

        $this->exportDaikouCsv($export_batch);

        // 生成文件
        $fp = fopen($path.$filename,'w');
        if(!$fp){
            die('The file could not be opened');
        }
        if (fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF).implode(',',$export_title)."\n".$this->flow_export_str) === FALSE) {
            die('The file could not be written');
        }
        fclose($fp);
        $this->flow_export_str = null;
        self::ftpSend(self::FTP_PATH.'/flow/'.$filename, $path.$filename);
        echo "\r\nupload end\n";

        // 更新批次
        foreach($this->flow_export_ids as $table_month => $flowIds){
            $sql = "UPDATE {{account_flow_".$table_month."}} SET export_batch='".$export_batch."' WHERE id IN (".implode(',',$flowIds).")";
            echo $sql."\r\n";
            Yii::app()->ac->createCommand($sql)->execute();
        }
//        @file_put_contents($export_log.'export-'.$export_batch.'-finished-'.date('Y-m-d-H-i').'.txt', date('Ymd-H:i:s'));
        exec('chown -R www:www '.dirname($path).'/*');
        self::createLog($export_batch,'export_data/flow/'.$filename,filesize($path.$filename));
        echo "\r\nend\n";
    }

    /**
     * 查找流水数据
     * @param $month
     * @param $export_batch
     * @param $selectFeilds
     * @param bool $exported 是否已被导出过的流水
     * @param string $batch_pre
     */
    public function getCsvData($month,$export_batch,$selectFeilds,$exported=false,$batch_pre='A'){
        // 查询
        if($exported === true){
            $sql = "SELECT {$selectFeilds} FROM {{account_flow_".$month."}} WHERE export_batch='".$export_batch."' ORDER BY id ASC";
        }else{
            $today = strtotime(date('Y-m-d'));
            $sql = "SELECT {$selectFeilds} FROM {{account_flow_".$month."}} WHERE export_batch=0 and create_time<'".$today."' ORDER BY id ASC";
        }
        $command = Yii::app()->ac->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        // 数据处理
        foreach($reader as $key => $row){
            $is_daikou = false;
            if(self::EXPORT_DAIKOU && $row['operate_type'] == AccountFlow::OPERATE_TYPE_ASSIGN_TWO && $row['node'] == AccountFlow::BUSINESS_NODE_ASSIGN_TWO && strpos($row['remark'], '翼支付,支付订单') === false){
                $is_daikou = true;
            }
            if(!$exported) $row['export_batch'] = $export_batch;
            $row['type'] = AccountFlow::showType($row['type']);
            $row['operate_type'] = AccountFlow::showOperateType($row['operate_type']);

            if($row['trade_terminal_id']){
                $sql_count = "select name from {{machine}} where id=".$row['trade_terminal_id'];
                $terminal = Yii::app()->gt->createCommand($sql_count)->queryScalar();
                if($terminal)$row['trade_terminal_id'] = $terminal;
            }

            if($row['franchisee_id']){
                $sql_count = "select name from {{franchisee}} where id=".$row['franchisee_id'];
                $franchisee = Yii::app()->db->createCommand($sql_count)->queryScalar();
                if($franchisee)$row['franchisee_id'] = $franchisee;
            }

            $row['moved'] = $row['moved'] == 1 ? '是' : '否';
            $row['flag'] = $row['flag'] == 1 ? '特殊' : '无';
            $row['node'] = @AccountFlow::showBusinessNode($row['node']);
            $row['transaction_type'] = AccountFlow::showTransactinnType($row['transaction_type']);
            $row['recharge_type'] = $row['recharge_type'] == AccountFlow::RECHARGE_TYPE_BANK ? '直充': ($row['recharge_type'] == AccountFlow::RECHARGE_TYPE_CARD ? '卡充':'');

            if ($row['area_id'] == 0) {
                $row['area_id'] = '';
            } elseif ($row['area_id'] == 1) {
                $row['area_id'] = '北盖网通';
            } else {
                $row['area_id'] = '南盖网通';
            }

            $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
            $row['remark'] = str_replace(',','，',$row['remark']);
            $row['trade_spec'] = str_replace(',','，',$row['trade_spec']);

            //处理数字显示问题
            $row['export_batch'] = "\t".$row['export_batch'];
            $row['id'] = "\t".$row['id'];
            $row['account_id'] = "\t".$row['account_id'];
            $row['card_no'] = "\t".$row['card_no'];
            $row['order_code'] = "\t".$row['order_code'];
            $this->flow_export_str .= implode(',',$row)."\n"; //用引文逗号分开

            /*SELECT * FROM `gw_account_flow_201502` WHERE `operate_type` = '23' AND `node` = '2311' and remark not LIKE '%翼支付,支付订单%'*/
            if(self::EXPORT_DAIKOU && $is_daikou){
                $this->flow_export_daikou_str .= $batch_pre.substr($row['export_batch'],1,6).str_pad($row['id'],8,'0',STR_PAD_LEFT).',';
                $this->flow_export_daikou_str .= "\t308581002021,\t6214850203156051,郑永雄,";//固定值
                $this->flow_export_daikou_str .= $row['credit_amount']."\n";
            }

            $this->flow_export_ids[$month][] = $row['id'];

            echo $key.PHP_EOL;
        }
    }


    /**
     * 按批号导出流水csv
     */
    public function actionExportBatchCsv($args) {
        if(!isset($args) || empty($args) || !$args[0])exit;

        @ini_set('memory_limit', '7000M');
        @ini_set("max_execution_time", "0");

        self::ftpCreateDir();
	    $this->deleteDir();
        $export_batch = $args[0];
        $filename = $this->getFileName($export_batch); //设置文件名
        $path = $this->getFilePath();
        $export_log = dirname($path).'/';
        exec('rm -f '.$export_log.'export*');
//        if(file_exists($path.$filename)){
//            echo 'file_exists';exit;
//        }

//        $month = substr($export_batch,0,6);
//        $lastMonth = date("Ym", strtotime("-1 month",strtotime($month)));
//        $lastMonth = date("Ym", (strtotime($month.'01')- 86400));
//        $nextMonth = date("Ym", strtotime("+1 month",strtotime($month)));
        $month_result = self::getMonth($export_batch);
        $month = $month_result['thisMonth'];
        $lastMonth = $month_result['lastMonth'];
        $nextMonth = $month_result['nextMonth'];

        $cols = array(
            'export_batch' => '批次',
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '卡号',
            'create_time' => '创建时间',
            'type' => '类型',
            'debit_amount' => '借方发生额',
            'credit_amount' => '贷方发生额',
            'operate_type' => '交易类型',
            'trade_spec' => '地点',
            'trade_terminal_id' => '所属终端',
            'ratio' => '比率',
            'order_code' => '订单编号',
            'area_id' => '区域类型',
            'remark' => '备注',
            'moved' => '是否搬送',
            'node' => '业务节点',
            'franchisee_id' => '加盟商',
            'recharge_type' => '充值类型',
            'distribution_ratio' => '分配比率',
            'transaction_type' => '事务类型',
            'parent_id' => 'Parent',
            'prepaid_card_no' => '充值卡编号',
            'current_balance' => '当前余额',
            'flag' => '标识',
            'by_gai_number' => '被推荐人GW',
        );
        $export_field = array_keys($cols);//导出字段
        $export_title = array_values($cols);//导出标题
        $selectFeilds = implode(',',$export_field);//查询字段

        unset($cols,$export_field);

        // 查询
        $this->getCsvData($lastMonth,$export_batch,$selectFeilds,true);
        $this->getCsvData($month,$export_batch,$selectFeilds,true,'B');
        if(strtotime($nextMonth.'01') < time()) $this->getCsvData($nextMonth,$export_batch,$selectFeilds,true,'C');
        if($this->flow_export_str == false) exit;

        $this->exportDaikouCsv($export_batch);

        // 生成文件
        $fp = fopen($path.$filename,'w');
        if(!$fp){
            echo "不能打开文件 $filename";exit;
        }
        if (fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF).implode(',',$export_title)."\n".$this->flow_export_str) === FALSE) {
            echo "不能写入到文件 $filename";exit;
        }
        fclose($fp);
//        @file_put_contents($export_log.'export-'.$export_batch.'-finished-'.date('Y-m-d-H-i').'.txt', date('Ymd-H:i:s'));
        exec('chown -R www:www '.dirname($path).'/*');
        echo "\r\nsaved\n";

        self::ftpSend(self::FTP_PATH.'/flow/'.$filename, $path.$filename);
        self::createLog($export_batch,'export_data/flow/'.$filename,filesize($path.$filename));
        echo "\r\nupload end\n";
    }


    public function exportDaikouCsv($export_batch){
        $filename = $this->getFileNameDk($export_batch); //设置文件名
        $path = $this->getFileRootPath();
//        if(file_exists($path.$filename)){
//            echo 'file_exists';exit;
//        }
        $export_title = implode(',',array(
            '交易流水号',
            '付款开户银行行号',
            '付款账户',
            '付款名称',
            '付款金额'
        ));

        if($this->flow_export_daikou_str == false) exit;

        // 生成文件
        $fp = fopen($path.$filename,'w');
        if(!$fp){
            echo "不能打开文件 $filename";exit;
        }
        if (fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF).$export_title."\n".$this->flow_export_daikou_str) === FALSE) {
            echo "不能写入到文件 $filename";exit;
        }
        fclose($fp);
        $this->flow_export_daikou_str = '';

        self::ftpSend(self::FTP_PATH.'/'.$filename, $path.$filename);
        self::createLog($export_batch,'export_data/'.$filename,filesize($path.$filename),'1');
    }

    public static function getMonth($export_batch){
        $thisMonth = substr($export_batch,0,6);
        $year = substr($export_batch,0,4);

        $month = substr($export_batch,4,2);

        if($month-1 < 1){
            $lastMonth = ($year-1) . '12';
        }else{
            $lastMonth = $year . str_pad(($month-1),2,0,STR_PAD_LEFT);
        }

        if(($month+1) > 12){
            $nextMonth = ($year+1) . '01';
        }else{
            $nextMonth = $year . str_pad(($month+1),2,0,STR_PAD_LEFT);
        }

        return compact('thisMonth','lastMonth','nextMonth');
    }

    public static function ftpSend($remoteFile, $localFile){
        $ftp = Yii::app()->ftp;
        @$ftp->delete($remoteFile); // 删除旧文件
        echo $remoteFile."\r\n";
        echo $localFile."\r\n";
        $ftp->put($remoteFile, $localFile);
    }

    public static function ftpCreateDir(){
        @Yii::app()->ftp->createDir(self::FTP_PATH);
        @Yii::app()->ftp->rmdir(self::FTP_PATH.'/flow');
        @Yii::app()->ftp->createDir(self::FTP_PATH.'/flow');
    }

    public static function createLog($export_batch,$file_name,$size,$is_daikou='0'){
        $time = time();
        $sql = "SELECT export_batch FROM {{flow_export_batch}} WHERE export_batch='{$export_batch}' AND is_daikou='{$is_daikou}'";
        $exported = Yii::app()->ac->createCommand($sql)->queryScalar();
        if(!$exported){
            $date = array(
                'export_batch'=> $export_batch,
                'create_time'=> $time,
                'last_time'=> $time,
                'file_name'=> $file_name,
                'file_size'=> $size,
                'is_daikou'=> $is_daikou,
            );
            Yii::app()->ac->createCommand()->insert('{{flow_export_batch}}',$date);
        }else{
            $sql = "UPDATE {{flow_export_batch}} SET export_times=export_times+1,last_time='{$time}',file_name='{$file_name}',file_size='{$size}' WHERE export_batch='{$export_batch}' AND is_daikou='{$is_daikou}'";
            Yii::app()->ac->createCommand($sql)->execute();
        }
    }

}
