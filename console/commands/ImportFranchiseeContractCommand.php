<?php

/**
 * 补充协议  数据导入脚本
 * @author xuegang.liu@g-mall.com
 * @since  2015-06-24
 */
class ImportFranchiseeContractCommand extends CConsoleCommand {

    protected $fileName;
    protected $a_address;
    protected $beginRow;
    protected $beginColumn;
    protected $resDatas;
    protected $errorArr;
    protected $headMap;
    protected $map;
    protected $convert;
    protected $beginTime;
    protected $logsPath;


    public function __construct(){

        $this->beginRow    =  2;
        $this->beginColumn =  0;
        $this->resDatas    =  $this->errorArr = array();
        $this->a_address   =  '广州市东风东路767号东宝大厦21楼'; 

        $sourcePath        =  realpath(Yii::getPathOfAlias('root.console.data'));
        $this->fileName    =  $sourcePath.DS."contract_source.xlsx";
        
        $this->headMap     =  array('合同编号'=>'A','补充协议编号'=>'B','合同版本'=>'C','甲方'=>'D','乙方会员名称'=>'E','乙方地址'=>'G',
                                    'GW编号'=>'F','合同签订日期'=>'I');

        $this->convert     =  array('gw'=>'F','number'=>'A','protocol_no'=>'B','version'=>'C','a_name'=>'D',
                                    'b_name'=>'E','b_address'=>'G','original_contract_time'=>'I');

        $this->map         =  array('F'=>'GW编号','A'=>'合同编号','C'=>'合同版本','I'=>'合同签订日期');
        $this->beginTime   =  time();
        $this->logsPath    =  strtoupper(substr(PHP_OS,0,3))==='WIN' ? 
                                realpath(Yii::getPathOfAlias('root').DS.'..').DS.'fail_nw_'.time().'.bak' :
                                '/tmp'.DS.'import_contract_fail_'.time().'.bak';   
    }

    public function actionTest($id){

        if($id!=='liuxuegang123') die("please enter safety code!!!\n");
        error_reporting(E_ERROR);
        ini_set('memory_limit', '150M'); 
        set_time_limit(1200); 
        
        $this->_readExcel($this->fileName,$this->headMap,$this->resDatas,$this->beginRow,$this->beginColumn);
        // $lenght = count($this->resDatas);
        // $tmpArr1 = ArrayHelper::array_column_Ex($this->resDatas,'F');
        // $tmp = array_count_values($tmpArr1);
        // $res = array();
        // foreach ($tmp as $key => $value) {
        //     if($value>1) $res[$key] = $value;
        // }

        // foreach ($this->resDatas as $row => $value) {
        //     if(array_key_exists($value['F'], $res)){
        //         array_walk($value, function(&$v,$k,$map){
        //                 $v = isset($map[$k]) ?  $map[$k]." : ".$v : "";
        //             },$this->map);
				    // $tmp = array_filter((array)$value);
        //             $this->errorArr[] = "第{$row}行 \t\t详细信息如下:".implode("\t\t" ,$tmp);
        //     } 
        // }
        // echo " lenght : ".$lenght." \t\t length : ".count($tmpArr1)." \t\t length : ".count($tmp)."\t\t lenght : ".count($res)."\n";
        // $this->errorArr && $this->_writeLogs();
        // if(!$this->errorArr) echo " no reply data \n";
        $this->resDatas = $this->_uniqueByGw($this->resDatas);
        $this->_writeLogs();
    }

    public function actionIndex(){
        
        error_reporting(E_ERROR);
        ini_set('memory_limit', '150M'); 
        set_time_limit(1200); 
        
        $this->_readExcel($this->fileName,$this->headMap,$this->resDatas,$this->beginRow,$this->beginColumn);
        $this->resDatas = $this->_uniqueByGw($this->resDatas); //过滤，除去gw重复数据，重复数据写入日志
        $this->errorArr[] = "\n\n ----------------------------------------- 其他导入出错 ------------------------------------------";
        try{
            //读取 代理版和直营版 当前使用的模板id
            $agencyTemplateId = Contract::getCurrentByType(Contract::CONTRACT_TYPE_AGENCY);
            $regularChairTemplateId = Contract::getCurrentByType(Contract::CONTRACT_TYPE_REGULAR_CHAIN);
            if(!$agencyTemplateId || !$regularChairTemplateId) throw new Exception("代理模板 和 直营模板 都必须至少有一个可使用", 1);
            if(count($this->resDatas) < 1) throw new Exception("读取excel数据失败", 1);
            $db = Yii::app()->db;

            foreach((array)$this->resDatas as $row => $value){
                $mark = false;
                $andWhere = isset($value[$this->convert['gw']]) ? " where gai_number = '".$value[$this->convert['gw']]."'" : " where 1=2 ";
                $findSql = " select id from gw_member ".$andWhere;
                $tmpQueryRes = $db->createCommand($findSql)->queryRow();
                if(!empty($tmpQueryRes)){
                    $franchiseeContractModel = new FranchiseeContract();
                    $franchiseeContractModel->member_id       =    $tmpQueryRes['id'];
                    $franchiseeContractModel->contract_id     =    $value[$this->convert['version']]=='直营' ? $regularChairTemplateId : $agencyTemplateId;
                    $franchiseeContractModel->number          =    $value[$this->convert['number']];
                    $franchiseeContractModel->a_name          =    $value[$this->convert['a_name']];
                    $franchiseeContractModel->a_address       =    $value[$this->convert['version']]=='直营' ?  $this->a_address : '';
                    $franchiseeContractModel->b_name          =    isset($value[$this->convert['b_name']]) ? $value[$this->convert['b_name']] : '';
                    $franchiseeContractModel->b_address       =    $value[$this->convert['b_address']];
                    $franchiseeContractModel->protocol_no     =    $value[$this->convert['protocol_no']];
                    $franchiseeContractModel->original_contract_time  =  $value[$this->convert['original_contract_time']];
                    if(!$franchiseeContractModel->save())  
                        $mark = "插入失败，\t\t".implode(',',ArrayHelper::array_column_Ex(($franchiseeContractModel->getErrors()),'0'));
                }else{
                    $mark = "\t\t不存在于member表中";
                }
                unset($tmpQueryRes,$franchiseeContractModel);

                if($mark) {
                    array_walk($value, function(&$value,$key,$map){
                        $value = isset($map[$key]) ?  $map[$key]." : ".$value : "";
                    },$this->map);
				    $tmp = array_filter((array)$value);
                    $this->errorArr[] = "第{$row}行 ".$mark.",\t\t详细信息如下:".implode("\t\t" ,$tmp);
                }
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $this->_writeLogs();
    }

    /**
     * 写处理失败日志信息
     *
     * @param string $logsPath   日志文件路径
     * @param array  $errorInfos 脚本处理错误信息
     * @param int    $beginTime  脚本开始运行时间
     * @author xuegang.liu@g-email.com
     * @since  2015-06-23
     */
    private function _writeLogs(){

        file_put_contents($this->logsPath, implode("\n", $this->errorArr));
        $endTime = time();
        $runTime = $endTime - $this->beginTime;
        echo "running is ok, lose time ".floor($runTime/60)."分 ".($runTime%60)."秒. ): ";
        echo "共有".count($this->errorArr)."条数据处理失败，可以在{$this->logsPath}文件，查看详细信息！！\n";
    }

    private function _uniqueByGw($data){

        $this->errorArr[] = "\n ----------------------------------------- gw_number重复 ------------------------------------------";
        $result = $sortArr = array();
        $gw = $this->convert['gw'];
        foreach ((array)$data as $key => $value) {
            $sortArr[$key] = $value[$gw];
        }

        asort($sortArr);
        $mark = false;
        $lenght = count($sortArr) -1;
        $keyArr = array_keys($sortArr);
        $valArr = array_values($sortArr);
        unset($sortArr);

        $i = 0;
        for(;$i<$lenght;$i++){
            if($valArr[$i] == $valArr[$i+1]){
                $mark = true;
                $result[$keyArr[$i]] = $valArr[$i];
            }else if($mark){
                $mark = false;
                $result[$keyArr[$i]] = $valArr[$i];
            }
        }
        if($mark) $result[$keyArr[$i]] = $valArr[$i];
        unset($keyArr,$valArr);

        //写日志
        $repeatNum = count($result);
        foreach ($result as $key => $value) {
            $tmpInfo = $data[$key];
            array_walk($tmpInfo, function(&$v,$k,$map){
                $v = isset($map[$k]) ?  $map[$k]." : ".$v : "";
            },$this->map);
            $tmp = array_filter((array)$tmpInfo);
            $this->errorArr[] = "第{$key}行 \t\t详细信息如下:".implode("\t\t" ,$tmp);
        }

        $tips = "\n总共记录:".($lenght+1)."条，\tGW号重复 : ".$repeatNum."条, \n";
        $this->errorArr[] = $tips;
        echo $tips;
        
        $return = array_diff_key($data, $result);
        unset($data,$result);
        return $return;
    }

    /**
     * 读取excel，写入数据
     *
     * @param string $fileName    excel文件路径
     * @param array  $headMap     要读取的字段 
     *               eg : array('合同编号'=>'A','合同版本'=>'B','甲方'=>'C','乙方会员名称'=>'D','乙方地址'=>'E','合同签订日期'=>'G');
     * @param array  $resDatas    保存读取数据
     * @param int    $beginRow    行开始读取位置，偏移量，结合$endRow可以分部读取大文件
     * @param int    $beginColumn 列开始读取位置，偏移量
     * @param int    $endRow       行读取的结束位置
     * 
     * @author xuegang.liu@g-email.com
     * @since  2015-06-23  
     */
    private function _readExcel($fileName,$headMap,&$resDatas,$beginRow,$beginColumn,$endRow=-1){

        date_default_timezone_set('Asia/ShangHai'); 
        $path = realpath(Yii::getPathOfAlias('root.common.extensions.PHPExcel.PHPExcel'));
        include_once $path.DS.'IOFactory.php';
        
        if (!file_exists($fileName)) exit("not found {$fileName}.\n");
        $reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel2007格式(Excel2007)
        $PHPExcel = $reader->load($fileName); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $endRow = $endRow==-1 ? $highestRow : $endRow;
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
         
        $tmpData = array();
        //循环读取每个单元格的数据 
        for ($row = $beginRow; $row <= $endRow; $row++){//行数是以第1行开始
            for ($column = $beginColumn; $column < $highestColumm; $column++) {//列数是以第0列开始
                $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
                $cell  = $sheet->getCellByColumnAndRow($column, $row);
                $value = $cell->getValue();
                if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){  
                    $formatVal=$cell->getParent()->getCacheData( $cell->getCoordinate() )->getStyle();  
                    $formatVal=$formatVal->getNumberFormat()->getFormatCode();  
                    if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatVal)) {  
                       $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));  
                    }else{  
                        $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatVal);  
                    }  
                }  
                in_array($columnName, $headMap) && $tmpData[$columnName] = $value;
            }
            $tmpData = array_filter($tmpData);
            if(!empty($tmpData)) $resDatas[$row] = $tmpData;
        }
    }  
}
