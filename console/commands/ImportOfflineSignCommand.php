<?php

/**
 * 电子化签约  数据导入脚本
 * 
 * @author xuegang.liu@g-mall.com
 * @since  2016-02-02
 */
class ImportOfflineSignCommand extends CConsoleCommand {

    protected $fileName;  //待导入文件路径全名
    protected $beginColumn;  //开始列
    protected $offset;       //偏移量
    protected $headMap;
    protected $head;
    protected $fieldDesc;
    protected $beginTime;
    protected $logsPath;
    protected $isHeadTitle = true;


    public function __construct()
    {
        $this->beginTime   =  time();
        $this->offset    =  2;
        $this->beginColumn =  0;
        $this->fieldDesc = array_flip(self::getImportColumn());
        $this->logsPath    =  strtoupper(substr(PHP_OS,0,3))==='WIN' ? 
                                realpath(Yii::getPathOfAlias('root').DS.'..').DS.'gw_fail_nw_'.time().'.bak' :
                                '/tmp'.DS.'import_contract_fail_'.time().'.bak';   
    }

    /**
     * 设置导入文件路径
     */
    public function setPath($path)
    {
        $this->fileName = $path;
        return $this;
    }

    /**
     * 解析导入数据，并入库
     */
    public function actionIndex()
    {    
        error_reporting(E_ERROR);
        ini_set('memory_limit', '1000M'); 
        set_time_limit(0); 
        $successNum = $errorNum = 0;
        $errorInfos = "----------------------------------------- 导入出错数据如下 ------------------------------------------";
        $this->_writeLogs($errorInfos);

        try {
            $times = 1;
            $resDatas = $errorArr = array();
            $this->_readExcel($this->fileName,$resDatas,$this->offset,$this->beginColumn);

            //入库
            foreach ($resDatas as $key => $record) {
                $times += 1;
                $errorInfos = $this->_writeDB($record,$successNum,$errorNum);
                $errorInfos && $this->_writeLogs($errorInfos,"第{$key}行数据有问题 :: ");
                unset($record);
                if($times>500){
                    $times = 1;
                    gc_collect_cycles();
                }
            }
            unset($resDatas,$errorInfos); 
        } catch (Exception $e) {
            $errorInfos =  $e->getMessage();
             $this->_writeLogs($errorInfos);
        }

        //记录统计数据
        $endTime = time();
        $runTime = $endTime - $this->beginTime;
        $tips = "running is ok, lose time ".floor($runTime/60)."分 ".($runTime%60)."秒. ): ";
        $this->_writeLogs($tips);
        $tips = "共导入成功{$successNum}条，导入失败{$errorNum}条，可以在{$this->logsPath}文件，查看详细信息！！\n";
        $this->_writeLogs($tips);
        return $this->logsPath;
    }

    /**
     * 数据入库操作
     * 
     * @param  array     &$record     待入库数据
     * @param  integer   &$successNum 追踪成功入库数据总条数
     * @param  integer   &$errorNum   追踪入库失败数据总条数
     * @return array     错误信息          
     */
    private function _writeDB(&$record,&$successNum,&$errorNum)
    {
        $errorInfos = array();
        $trans = Yii::app()->db->beginTransaction();  //事务处理

        try{
            $contractId = $this->_insertOfflineSignContract($record);
            $enterpriseId = $this->_insertOfflineSignEnterprise($record,$contractId);
            $this->_insertOfflineSignStroe($record,$enterpriseId);
            $successNum += 1;    
            $trans->commit();
        }catch(Exception $e){
            $trans->rollback(); //回滚
            $errorNum += 1;
            $errorInfos =  $e->getMessage();
        }
        return $errorInfos;
    }

    /**
     * 写入合同相关信息
     * 
     * @param  array  &$data 待处理数据)
     */
    private function _insertOfflineSignContract(&$data)
    {   
        // `operation_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '合作方式（1方式一 2方式二 3方式三）',
            // `ad_begin_time_hour` tinyint(2) unsigned NOT NULL COMMENT '广告时间段 开始时',
            // `ad_begin_time_minute` tinyint(2) unsigned NOT NULL COMMENT '广告时间段 开始分',
            // `ad_end_time_hour` tinyint(2) unsigned NOT NULL COMMENT '广告时间段 结束时',
            // `ad_end_time_minute` tinyint(2) unsigned NOT NULL COMMENT '广告时间段 结束分',

            // `bank_name` varchar(128) NOT NULL COMMENT '开户银行',
            
            // `franchisee_name` varchar(128) NOT NULL COMMENT '联盟商户名称',
            // `p_province_id` int(11) unsigned NOT NULL COMMENT '推广地区所在省份',
            // `p_city_id` int(11) NOT NULL COMMENT '推广地区所在城市',
            // `p_district_id` int(11) NOT NULL COMMENT '推广地区所在区域',
        
            // `machine_administrator` varchar(32) NOT NULL COMMENT '盖网通管理人',
            // `machine_administrator_mobile` varchar(32) NOT NULL COMMENT '盖网通管理人移动电话',
            // `franchisee_phone` varchar(32) NOT NULL COMMENT '店面固定电话',
            // `franchisee_mobile` varchar(32) NOT NULL COMMENT '店面移动电话',
            // `machine_number` int(11) unsigned NOT NULL COMMENT '盖网通数量',
        $allowFields = array(
            'operation_type','province_id','city_id','district_id','address','enterprise_proposer',
            'mobile','account_name','account','install_province_id','install_city_id','install_district_id','install_street',
            'discount','gai_discount','member_discount','machine_style','a_name','b_name','contract_term',
            'begin_time','end_time','number','ad_begin_time_hour','ad_begin_time_minute','ad_end_time_hour','ad_end_time_minute',
            'p_province_id','p_city_id','p_district_id','exclude_goods','bank_name','franchisee_name',
            'machine_administrator','machine_administrator_mobile','franchisee_phone','franchisee_mobile','machine_number',
        );

        $model = new OfflineSignContract();
        $model->attributes = array_intersect_key($data, array_flip($allowFields));

        $model->number = empty($model->number) ? OfflineSignContract::createContractNumber() : $model->number;
        $model->attributes = $this->_getRegionIds($data,'province_id','city_id','district_id');
        $model->attributes = $this->_getRegionIds($data,'install_province_id','install_city_id','install_district_id');

        $model->machine_style = array_search($model->machine_style, OfflineSignContract::getMachineStyle());
        $model->machine_style===false && $this->_error('machine_style',$model->machine_style);

        //操作类型及广告开始结束时间设置
        $model->operation_type = array_search($model->operation_type,OfflineSignContract::getOperationType());
        $model->operation_type===false && $this->_error('operation_type',$model->operation_type);

        $adBeginTimeArr = explode(':', $data['ad_begin_time']);
        if(count($adBeginTimeArr)!=2){
            $this->_error('ad_begin_time',$data['ad_begin_time']);
        }

        $model->ad_begin_time_hour = $adBeginTimeArr[0];
        $model->ad_begin_time_minute = $adBeginTimeArr[1];
        $temp = $model->ad_begin_time_hour + 3 ;
        $model->ad_end_time_hour = $temp >= 24 ? $temp -3 : $temp;
        $model->ad_end_time_minute = $model->ad_begin_time_minute;

        $noValidateFields = array(
            'bank_name','franchisee_name','franchisee_phone','franchisee_mobile',
            'machine_administrator','machine_administrator_mobile','machine_number',
        );
        $validateFields = array_diff($model->attributes,$noValidateFields);

        if(!$model->validate($validateFields) || !$model->save(false)){
            throw new Exception('OfflineSignContract:'.json_encode($model->getErrors()), 1);
        }

        $id = $model->id;
        unset($model);
        return $id;
    }

    /**
     * 写入合同相关信息
     * 
     * @param  array  &$data 待处理数据)
     */
    private function _insertOfflineSignEnterprise(&$data,$contractId)
    {
        $allowFields = array(
            'license_is_long_time','name','is_chain','chain_type','chain_number','linkman_name','linkman_position',
            'linkman_webchat','linkman_qq','enterprise_type','enterprise_license_number','registration_time','license_begin_time',
            'license_end_time','legal_man','legal_man_identity','account_pay_type','payee_identity_number','bank_province_id',
            'bank_city_id','bank_district_id','offline_sign_contract_id','tax_id',
        );
        $model = new OfflineSignEnterprise();
        $model->attributes = array_intersect_key($data, array_flip($allowFields));
        $model->offline_sign_contract_id = $contractId;

        //是否连锁，连锁类型
        $model->is_chain = array_search($model->is_chain, OfflineSignEnterprise::getIsChain());
        $model->is_chain===false && $this->_error('is_chain',$model->is_chain);
        
        $model->chain_type = array_search($model->chain_type,OfflineSignEnterprise::getChainType());
        $model->chain_type===false && $this->_error('chain_type',$model->chain_type);
        
        $model->enterprise_type = array_search($model->enterprise_type,OfflineSignEnterprise::getEnterType());
        $model->enterprise_type===false && $this->_error('enterprise_type',$model->enterprise_type);

        $model->account_pay_type = array_search($model->account_pay_type,OfflineSignEnterprise::getAccountPayType());
        $model->account_pay_type===false && $this->_error('account_pay_type',$model->account_pay_type);

        $model->license_is_long_time = array_search($model->license_is_long_time,OfflineSignEnterprise::getLongTime());
        $model->license_is_long_time===false && $this->_error('license_is_long_time',$model->license_is_long_time);
        
        $model->create_time = time();
        $model->update_time = time();
        
        // `tax_id` varchar(128) NOT NULL COMMENT '税务登记证号',
        $model->attributes = $this->_getRegionIds($data,'bank_province_id','bank_city_id','bank_district_id');
        $noValidateFields = array(
            'bank_permit_image',
        );
        $validateFields = array_diff($model->attributes,$noValidateFields);

        if(!$model->validate($validateFields) || !$model->save(false)){
            throw new Exception("OfflineSignEnterprise:".json_encode($model->getErrors()), 1);
        }

        $id = $model->id;
        unset($model);
        return $id;
    }

    /**
     * 写入合同相关信息
     * 
     * @param  array  &$data 待处理数据)
     */
    private function _insertOfflineSignStroe(&$data,$enterpriseId)
    {   
        $allowFields = array (
            'apply_type','is_import','install_area_id','member_discount_type','machine_install_type','machine_install_style',
            'franchisee_developer','machine_belong_to','franchisee_id',
            //原有会员需要字段，导入时屏蔽
            // 'install_province_id','install_city_id','install_district_id','install_street','discount','gai_discount','member_discount','franchisee_name',
            'store_location','store_linkman','store_linkman_position','store_linkman_webchat','store_linkman_qq',
            'store_linkman_email','store_mobile','open_begin_time','open_end_time','exists_membership','store_disconunt','recommender_name',
            'recommender_member_id','recommender_mobile','machine_developer','clearing_remark','sign_type','contract_linkman',
            'offline_sign_enterprise_id','status','audit_status','franchisee_category_id','enterprise_id','machine_id','old_member_franchisee_id',
            'recommender_linkman','recommender_apply_image','store_phone','sign_time',
        );
        $model = new OfflineSignStore();
        $model->attributes = array_intersect_key($data, array_flip($allowFields));
        $model->offline_sign_enterprise_id = $enterpriseId;
        $model->apply_type = OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE;
        $model->is_import = OfflineSignStore::IS_IMPORT_YES;

        $model->status = OfflineSignStore::STATUS_PEND_AUDIT;
        $model->audit_status = OfflineSignStore::AUDIT_STATUS_PRI_UPLOAD;

        // `franchisee_name` varchar(128) NOT NULL COMMENT '联盟商户名称',
        // `recommender_linkman` varchar(128) NOT NULL COMMENT '联系人',

        $categoryA = $this->_getCategoryIds($data,'depthZero','depthOne');
        $model->franchisee_category_id = !empty($categoryA['depthZero']) ? $categoryA['depthZero'] : $categoryA['depthOne'];

        $model->exists_membership = array_search($model->exists_membership, OfflineSignStore::getExistsMembership());
        $model->exists_membership===false && $this->_error('exists_membership',$model->exists_membership);

        $model->member_discount_type = array_search($model->member_discount_type, OfflineSignStore::getDiscountType());
        $model->member_discount_type===false && $this->_error('member_discount_type',$model->member_discount_type);

        $model->machine_install_type = array_search($model->machine_install_type, OfflineSignStore::getInstallType());
        $model->machine_install_type===false && $this->_error('machine_install_type',$model->machine_install_type);

        $model->machine_install_style = array_search($model->machine_install_style, OfflineSignStore::getInstallStyle());
        $model->machine_install_style===false && $this->_error('machine_install_style',$model->machine_install_style);
        
        $model->sign_type = array_search($model->sign_type, OfflineSignStore::getSignType());
        $model->sign_type===false && $this->_error('sign_type',$model->sign_type);
        $model->install_area_id = $this->_getInstallAreaId($data['install_area_id']);

        if(!$model->validate() || !$model->save(false)){
            throw new Exception("OfflineSignStore:".json_encode($model->getErrors()), 1);
        }
        
        $id = $model->id;
        unset($model);
        return $id;
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
     * @since  2016-02-02
     */
    private function _readExcel($fileName,&$resDatas,$beginRow,$beginColumn,$endRow=-1){

        date_default_timezone_set('Asia/ShangHai'); 
        $path = realpath(Yii::getPathOfAlias('root.common.extensions.PHPExcel.PHPExcel'));
        include_once $path.DS.'IOFactory.php';

        if (!file_exists($fileName)) exit("not found {$fileName}.\n");
        $reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel2007格式(Excel2007)
        $PHPExcel = $reader->load($fileName); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $endRow = $endRow==-1 ? $highestRow+1 : min($highestRow,$endRow);
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        if($endRow>8000) throw new Exception("导入数据不能多于8000条", 1);
        
        $highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
        
        $times = 1;
        $tmpData = array();
        //循环读取每个单元格的数据 
        for ($row = $beginRow; $row < $endRow; $row++){//行数是以第1行开始
            for ($column = $beginColumn; $column < $highestColumm; $column++) {//列数是以第0列开始
                $times += 1;
                $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
                $cell  = $sheet->getCellByColumnAndRow($column, $row);
                $value = $cell->getValue();
                
                if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){  
                    $formatVal=$cell->getParent()->getCacheData( $cell->getCoordinate() )->getStyle();  
                    $formatVal_v=$formatVal->getNumberFormat()->getFormatCode();  
                    if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatVal_v)) {  
                       $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));  
                    }else{  
                        $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatVal_v);
                    }  
                }  

                if($this->isHeadTitle){
                    $this->head[$columnName] = trim((string)$value);
                }else if(array_key_exists($columnName, $this->headMap)){
                    $tmpKey = $this->headMap[$columnName];
                    $tmpData[$tmpKey] = (string)$value;
                } 
                unset($cell,$formatVal,$formatVal_v,$value);
            }

            if($this->isHeadTitle){
                $this->head = array_filter($this->head);
                $desc2Fied = self::getImportColumn();
                foreach ($this->head as $mKey => $mVal) {
                    if(!isset($desc2Fied[$mVal])){
                        die("表头有误::".$mVal." 不存在");
                    }
                    $this->headMap[$mKey] = $desc2Fied[$mVal];
                }
                $this->isHeadTitle = false;
            }
            
            $tmpData = array_filter($tmpData);
            if(!empty($tmpData)){
                $resDatas[$row] = $tmpData;
                unset($tmpData);  
            } 

            if($times>100){
                $times = 1;
                gc_collect_cycles();
            }
        }
        unset($sheet);
        gc_collect_cycles();
    }  

    /**
     * 根据相应字段，获取省市县id
     * 
     * @param  array    &$data         源数据
     * @param  string   $provinceField 要获取省id，对应的字段
     * @param  string   $cityField     要获取市id，对应的字段
     * @param  string   $districtField 要获取县区id，对应的字段
     * @return array
     */
    private function _getRegionIds(&$data,$provinceField,$cityField,$districtField)
    {
        static $regionTree = null;
        if($regionTree===null){
            $regionTree = Region::treeregion();
            $regionTree = $regionTree[1]['childClass'];
            // $this->_writeLogs(json_encode($regionTree),'获取省市县');
        }

        $province_id = $this->_search($data[$provinceField], $regionTree);
        !$province_id && $this->_error($provinceField,$data[$provinceField]);

        $city_id = $this->_search($data[$cityField], $regionTree[$province_id]['childClass']);
        !$city_id && $this->_error($cityField,$data[$cityField]);

        $district_id = $this->_search($data[$districtField], $regionTree[$province_id]['childClass'][$city_id]['childClass']);
        !$district_id && $this->_error($districtField,$data[$districtField]);
        
        return array(
            $provinceField  =>  $province_id,
            $cityField      =>  $city_id,
            $districtField  =>  $district_id
        );
    }

    private function _search($searchStr,&$data,$field='name')
    {
        foreach ($data as $key => $value) {
            if($value[$field]==$searchStr) return $key;
        }
        return false;
    }

    /**
     * 读取经营类别
     * 
     * @param  array   &$data        excel一行记录
     * @param  string  $categoryOne  'deepthZero'
     * @param  string  $categoryTwo  'deepthOne'
     * @return array 
     */
    private function _getCategoryIds(&$data,$categoryOne,$categoryTwo)
    {
        static $categoryArr = null;
        if($categoryArr===null){
            $categoryArr = FranchiseeCategory::getFranchiseeCategory();
            $categoryArr = $this->_formatFranchiseeCategory($categoryArr);
            $this->_writeLogs(json_encode($categoryArr),'读取经营类别');
        }

        $category_one = $this->_search($data[$categoryOne], $categoryArr,'name');
        !$category_one && $this->_error($categoryOne,$data[$categoryOne]);

        $category_two = $this->_search($data[$categoryTwo], $categoryArr[$category_one]['child'],'name');
        !$category_two && $category_two='';
        
        return array(
            $categoryOne  =>  $category_one,
            $categoryTwo  => $category_two,
        );
    }

    /**
     * 格式化，分类
     * 
     * @param  array   $categoryArr
     * @return array                
     */
    private function _formatFranchiseeCategory($categoryArr)
    {
        $result = array();
        foreach ((array)$categoryArr as $key => $value) {
            if(empty($value)){
                continue;
            }
            $result[$value['typeId']]['name'] = $value['typeName'];
            $result[$value['typeId']]['child'] = array();
            foreach ((array)$value['secondTypeList'] as $k => $v) {
                if(empty($v)){
                    continue;
                }
                $result[$value['typeId']]['child'][$v['secondTypeId']]['name'] = $v['secondTypeName'];
            }
        }
        return $result;
    }

    /**
     * 获取大区id
     * 
     * @param  string  $installAreaName 大区名称
     * @return integer 大区id
     */
    private function _getInstallAreaId($installAreaName)
    {
        static $areaArr = null;
        if($areaArr===null){
            $areaArr = Region::getArea();
            $areaArr = array_flip($areaArr);
            $this->_writeLogs(json_encode($areaArr),'获取大区');
        }
        if(!isset($areaArr[$installAreaName])){
            throw new Exception("指定所在大区不正确", 1);
        }

        return  $areaArr[$installAreaName];
    }


    /**
     * 导入表头
     */
    public static function getImportColumn()
    {
        return
            array (

                //归属方信息及新增类型
                '新增类型'                     =>    'apply_type',            //申请类型
                '大区'                         =>    'install_area_id',                  //大区
                '加盟商开发方'                 =>    'franchisee_developer',     //加盟商开发方
                '机器归属方'                   =>    'machine_belong_to',     //机器归属方


                //企业信息
                '企业名称'                     =>    'name',                  //企业名称
                '是否连锁'                     =>    'is_chain',              //是否连锁
                '企业连锁形态'                 =>    'chain_type',            //企业连锁形态
                '连锁数量'                     =>    'chain_number',          //连锁数量        
                '企业联系人姓名'               =>    'linkman_name',          //企业联系人姓名
                '企业联系人职位'               =>    'linkman_position',      //企业联系人职位
                '企业联系人微信'               =>    'linkman_webchat',       //企业联系人微信
                '企业联系人QQ'                 =>    'linkman_qq',            //企业联系人QQ
                '企业类型'                     =>    'enterprise_type',       //企业类型
                '营业执照注册名称'             =>    'name1',                 //营业执照注册名称
                '营业执照注册号'               =>    'enterprise_license_number',//营业执照注册号

                '营业执照注册地区（大区）'     =>    'bbbb',                   //营业执照注册地区（大区）
                '营业执照注册地区（省）'       =>    'province_id',            //营业执照注册地区（省）
                '营业执照注册地区（市）'       =>    'city_id',                //营业执照注册地区（市）
                '营业执照注册地区（区）'       =>    'district_id',            //营业执照注册地区（区）
                '营业执照注册地址'             =>    'address',                //营业执照注册地址
                '成立日期'                     =>    'registration_time',       //成立日期
                '营业期限开始日期'             =>    'license_begin_time',     //营业期限开始日期
                '营业期限结束日期'             =>    'license_end_time',       //营业期限结束日期
                '是否长期'                     =>    'license_is_long_time',   //是否长期
                '法人代表'                     =>    'legal_man',              //法人代表
                '法人身份证号'                 =>    'legal_man_identity',    //法人身份证号


                //会员与账号信息
                '会员GW号'                     =>    'cccc',                  //会员GW号
                '会员名称'                     =>    'dddd',                  //会员名称
                'GW号生成日期'                 =>    'eeee',                  //GW号生成日期
                'GW号开通人'                   =>    'enterprise_proposer',   //GW号开通人
                'GW号开通手机'                 =>    'mobile',                //GW号开通手机
                '结算账户类型'                 =>    'account_pay_type',      //结算账户类型
                '账户名称'                     =>    'account_name',          //账户名称
                '银行账号'                     =>    'account',               //银行账号
                '收款人身份证号'               =>    'payee_identity_number', //收款人身份证号
                '开户许可证区域（省）'         =>    'bank_province_id',      //开户许可证区域（省)
                '开户许可证区域（市）'         =>    'bank_city_id',          //开户许可证区域（市）
                '开户许可证区域（区）'         =>    'bank_district_id',      //开户许可证区域（区）


                //店铺信息
                '加盟商名称'                   =>    'franchisee_id',         //加盟商名称
                '加盟商编号'                   =>    'ffff',                  //加盟商编号
                '加盟商编号生成日期'           =>    'gggg',                  //加盟商编号生成日期
                '加盟商区域（大区）'           =>    'hhhh',                  //加盟商区域（大区）
                '加盟商区域（省）'             =>    'install_province_id',   //加盟商区域（省）
                '加盟商区域（市）'             =>    'install_city_id',       //加盟商区域（市）
                '加盟商区域（区）'             =>    'install_district_id',   //加盟商区域（区）
                '加盟商详细地址'               =>    'install_street',        //加盟商详细地址
                '所在商圈'                     =>    'store_location',        //所在商圈
                '商家联系人'                   =>    'store_linkman',         //商家联系人
                '商家联系人职位'               =>    'store_linkman_position',//商家联系人职位
                '商家联系人微信'               =>    'store_linkman_webchat', //商家联系人微信
                '商家联系人QQ'                 =>    'store_linkman_qq',      //商家联系人QQ
                '商家联系人邮箱'               =>    'store_linkman_email',   //商家联系人邮箱
                '店面固定电话'                 =>    'store_phone',           //店面固定电话
                '店面移动电话'                 =>    'store_mobile',          //店面移动电话
                '经营类别（级别一）'           =>    'depthZero',              //经营级别(级别一)
                '经营类别（级别二）'           =>    'depthOne',              //经营级别(级别二)
                '营业开始时间'                 =>    'open_begin_time',       //营业开始时间
                '营业结束时间'                 =>    'open_end_time',         //营业结束时间
                '商家有否存在会员制'           =>    'exists_membership',     //是否存在会员制
                '会员折扣方式'                 =>    'member_discount_type',  //会员折扣方式
                '会员折扣'                     =>    'store_disconunt',       //会员折扣
                

                //推荐者信息
                '推荐者姓名'                   =>    'recommender_name',      //推荐者名称
                '推荐者GW会员号'               =>    'recommender_member_id', //推荐者GW会员号
                '推荐者手机号码'               =>    'recommender_mobile',    //推荐者手机号码
                

                //折扣与管理费信息
                '装机编码'                     =>    'jjjj',                  //装机编号
                '装机编码生成日期'             =>    'kkkk',                  //装机编码生成日期
                '激活码'                       =>    'llll',                  //激活码
                '销售开发人'                   =>    'machine_developer',     //销售开发人
                '销售跟进人'                   =>    'seller_linkman',        //销售跟进人
                '大区分管销售'                 =>    'd_branch_seller',       //大区分管销售
                '大区分管督导'                 =>    'd_branch_supervisor',   //大区分管督导
                '折扣差'                       =>    'discount',              //折扣差
                '盖网公司结算折扣(%)'          =>    'gai_discount',          //盖网公司结算折扣
                '盖网会员结算折扣(%)'          =>    'member_discount',       //盖网会员结算折扣
                '盖网会员结算折扣备注'         =>    'clearing_remark',       //会员结算备注
                '收费方式'                     =>    'operation_type',        //收费方式
                '每次缴纳金额'                 =>    'mmmm',                  //每次缴纳金额
                '缴纳总额'                     =>    'nnnn',                  //缴纳总额
                '广告分成比例(%)'              =>    'oooo',                  //广告分成比例(%)
                
                '广告时间段（开始）'           =>    'ad_begin_time',                  //广告时间段（开始）(%)
                '广告时间段（结束）'           =>    'ad_end_time',                  //广告时间段（结束）(%)

                //机器信息
                '铺设类型'                     =>    'machine_install_type',  //铺设机型
                '样式'                         =>    'machine_install_style', //样式
                '尺寸'                         =>    'machine_style',          //尺寸


                //合同信息
                '合同编号'                     =>    'number',                //合同编号
                '甲方'                         =>    'a_name',                //甲方
                '乙方'                         =>    'b_name',                //乙方
                '签约类型'                     =>    'sign_type',             //签约类型
                '合同签订日期'                 =>    'sign_time',             //合同签订日期
                '合同合作期限'                 =>    'contract_term',         //合同合作期限
                '合作期限起始日期'             =>    'begin_time',            //合同期限起始日期
                '合作期限结束日期'             =>    'end_time',              //合同期限结束日期
                '合同跟进人'                   =>    'contract_linkman',      //合同跟进人
            );
    }

    /**
     * 抛出异常信息
     * 
     * @param  string   $fieldName 字段名
     */
    private function _error($fieldName,$extends=null)
    {
        
        throw new Exception($this->fieldDesc[$fieldName].":{$fieldName}:{$extends}有误", 1);
    }

    /**
     * 写处理失败日志信息
     *
     * @param string $logsPath   日志文件路径
     * @param array  $errorInfos 脚本处理错误信息
     * @param int    $beginTime  脚本开始运行时间
     * @author xuegang.liu@g-email.com
     * @since  2016-02-02
     */
    private function _writeLogs($errorArr,$extends='')
    {
        $info = is_array($errorArr) ? implode(PHP_EOL, $errorArr) : (string)$errorArr;
        $info .= PHP_EOL;
        file_put_contents($this->logsPath, $extends.$info,FILE_APPEND);
        return true;
    }
}
