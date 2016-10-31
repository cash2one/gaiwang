<?php
//ps mysql varchar 字符查询大小写 是一样的  fid 全部加入 binary 属性
//当函数出现嵌套超过100错误 表示oracle的某些主键字段fid为空造成错误;`
class KingdeeImportCommand extends CConsoleCommand 
{
    private $ea;
    private $db;
    private $gt;
    private $log;
    private $root ='/www/web/source/attachments/';
    
    public function __construct($name,$runner)
    {
        parent::__construct($name,$runner);
        $this->ea =  Yii::app()->ea;
        $this->db = Yii::app()->db;
        $this->gt = Yii::app()->gt;
        
    }
    
    public function actionImport()
    {
        //header("Content-Type: text/html; charset=UTF-8");
        set_time_limit(0);
        //以下更新顺序不能改变;
        $this->UpdateEnterprice();
        $this->UpdateTaglib();
        $this->UpdateGwMember();
        $this->UpdateStore();
        $this->UpdateGwService();
        $this->UpdateAttachment();
        
    }
    
    /**
     * 单独执行某个处理
     * @param str $table
     */
    public function actionImportTable($table)
    {
        if(!in_array($table, array('Enterprice','Attachment','Taglib','GwMember','Store','GwService')))return false;
        $function = 'Update'.$table;
        $this->$function();
    }
    
    
    /**
     * 导入企业
     */
    private function UpdateEnterprice()
    {
        $ea = $this->ea;
        $db = $this->db;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足 
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'ENTERPRICE' ;
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $enterpriseMod = Enterprise::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $enterprices = $ea->createCommand($sql)->queryAll();
            foreach($enterprices as $val)
            {
                
                if(empty($val['FNAME_L2']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $enterpriseMod->findAll("kingdee_id=:kingdee_id",array(":kingdee_id"=>$val['FID']));
                $attributes = array();
                $attributes['name'] = $val['FNAME_L2'];
                $attributes['short_name'] = $val['FNAME_L2'];
                if(!empty($val['FEMAIL']))$attributes['email'] = $val['FEMAIL'];
                if(!empty($val['FADDRESS']))$attributes['street']=$val['FADDRESS'];
                if($val['FDISTRICTNUMBER'])
                {
                    $region = $this->getRegionData($val['FDISTRICTNUMBER']);
                    if(!empty($region['province_id']))$attributes['province_id']=$region['province_id'];
                    if(!empty($region['city_id']))$attributes['city_id']=$region['city_id'];
                    if(!empty($region['district_id']))$attributes['district_id']=$region['district_id'];
                    
                }
                if(!empty($res))
                {
                    $result = $enterpriseMod->updateAll($attributes,'kingdee_id=:kingdee_id',array(':kingdee_id'=>$val['FID']));
                    //$content = "更新了{$val['FID']}数据\r\n";    
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }else{
                    $attributes['kingdee_id'] = $val['FID'];
                    $attributes['create_time'] = time();
                    $result = $db->createCommand()->insert('gw_enterprise',$attributes);
                    //$content = "插入{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }
                if($result>=0)$this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)
        {
            $this->UpdateEnterprice();
        }else
            echo 'import Enterprice success!';
        
    }
    
    /**
     * 附近导出，要生成文件
     * 由于存在oracle blob过大字段问题，所以查询改成单条查询 否则发送致命错误；
     */
    private function UpdateAttachment()
    {
        $ea = $this->ea;
        $db = $this->db;
        $row = 1;//一次查询多少条;分页查询 避免都塞入变量导致内存不足 
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'ATTACHMENT' ;
        $sql = 'select count(*) from ATTACHMENT A INNER JOIN ENTERPRICE E on E.FATTACHMENTID = A.FID  where (A.FEASLASTUPDATETIME>A.FGWLASTREADTIME or A.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $enterpriseMod = Enterprise::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select e.FID,a.FID AFID,a.FFILE,a.FFILETYPE from ATTACHMENT A INNER JOIN ENTERPRICE E on E.FATTACHMENTID = A.FID where (A.FEASLASTUPDATETIME>A.FGWLASTREADTIME or A.FGWLASTREADTIME is null) ) e ) where r between {$start} and {$to}";
            $attachment = $ea->createCommand($sql)->queryRow();
            $enterprise = $enterpriseMod->find("kingdee_id=:kingdee_id",array(":kingdee_id"=>$attachment['FID']));
            if(empty($enterprise)||empty($attachment)||empty($attachment['FFILETYPE'])||empty($attachment['AFID'])||empty($attachment['FID'])||empty($attachment['FFILE']))
            {
                $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$attachment['AFID']));
                continue;
            }else
                $enterprise=$enterprise->attributes;
            if($enterprise['license_photo']!='') @unlink($this->root.$enterprise['license_photo']);
            $suffix = $this->dealsuffix($attachment['FFILETYPE']);
            $file_path = $this->dealBlob('license_photo',$attachment['FFILE'],$suffix);
            $attributes = array();
            $attributes['license_photo'] = $file_path;
            $enterpriseMod->updateAll($attributes,'kingdee_id=:kingdee_id',array(':kingdee_id'=>$attachment['FID']));
            $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$attachment['AFID']));
        }
        $sql = 'select count(*) from ATTACHMENT A INNER JOIN ENTERPRICE E on E.FATTACHMENTID = A.FID  where (A.FEASLASTUPDATETIME>A.FGWLASTREADTIME or A.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateAttachment();
        else echo 'import Attachment success!';
    }
    
    /**
     * 导入标签
     */
    private function UpdateTaglib()
    {
        $ea = $this->ea;
        $db = $this->db;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'TAGLIB';
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $franchiseeCategoryMod = FranchiseeCategory::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $results = $ea->createCommand($sql)->queryAll();
            foreach($results as $val)
            {
                if(empty($val['FNAME_L2'])||empty($val['FID']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $franchiseeCategoryMod->findAll("kingdee_id=:kingdee_id",array(":kingdee_id"=>$val['FID']));
                $attributes = array();
                $attributes['name'] = $val['FNAME_L2'];
                if(!empty($res))
                {
                    $attributes['update_time'] = time();
                    $result = $franchiseeCategoryMod->updateAll($attributes,'kingdee_id=:kingdee_id',array(':kingdee_id'=>$val['FID']));
                    //$content = "更新了{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }else{
                    $attributes['kingdee_id'] = $val['FID'];
                    $attributes['create_time'] = time();
                    $result = $db->createCommand()->insert('gw_franchisee_category',$attributes);
                    //$content = "插入{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }
                if($result>=0)$this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateTaglib();
        else echo 'import Taglib success!';
    }
    
    /**
     * 导入会员
     */
    private function UpdateGwMember()
    {
        $ea = $this->ea;
        $db = $this->db;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'GWMEMBER';
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $memberMod = Member::model();
        $enterpriseMod = Enterprise::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $results = $ea->createCommand($sql)->queryAll();
            foreach($results as $val)
            {
                if(empty($val['FGWNUMBER']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $memberMod->find("gai_number=:gai_number",array(":gai_number"=>$val['FGWNUMBER']));
                if($res)$member = $res->attributes;
                $attributes = array();
                if($val['FGWNAME'])
                {    
                    $attributes['real_name'] = $val['FGWNAME'];
                    if(!isset($member)||!$member['username'])$attributes['username'] = $val['FGWNAME'];
                }
               
                if($val['FREFERRALSNUMBER'])
                {
                    $referrals = $memberMod->find("gai_number=:gai_number",array(":gai_number"=>$val['FREFERRALSNUMBER']));
                    if(!empty($referrals))$attributes['referrals_id'] =$referrals->attributes['id'];
                }
                if($val['FMOBILE'])$attributes['mobile'] = $val['FMOBILE'];
                if($val['FSTATUS'])$attributes['status'] = $val['FSTATUS'];
                if($val['FENTERPRICEID'])
                {
                    $enterprise =$enterpriseMod->find("kingdee_id=:kingdee_id",array(":kingdee_id"=>$val['FENTERPRICEID']));
                    if(!empty($enterprise))$attributes['enterprise_id'] = $enterprise->attributes['id'];
                }
                if(!empty($res))
                {
                    $attributes['update_time'] = time();
                    $result = $memberMod->updateAll($attributes,'gai_number=:gai_number',array(':gai_number'=>$val['FGWNUMBER']));
                }else{
                    $attributes['gai_number'] = $val['FGWNUMBER'];
                    $result = $db->createCommand()->insert('gw_member',$attributes);
                }
                if($result>=0)$this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateGwMember();
        else echo 'import GwMember success!';
    }
    
    /**
     * 导入标签
     */
    private function UpdateStore()
    {
        $ea = $this->ea;
        $db = $this->db;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'STORE';
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $memberMod = Member::model();
        $franchiseeMod = Franchisee::model();
        $franchiseeCategoryMod = FranchiseeCategory::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $results = $ea->createCommand($sql)->queryAll();
            foreach($results as $val)
            {
                if(empty($val['FNUMBER'])||empty($val['FGWNUMBER']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $franchiseeMod->find("code=:code",array(":code"=>$val['FNUMBER']));
                if($res)$franchiseeId=$res->attributes['id'];
                $attributes=array();
                if($val['FNAME_L2'])$attributes['name'] = $val['FNAME_L2'];
                if($val['FQQ'])$attributes['qq'] = $val['FQQ'];
                if($val['FSUMMARY'])$attributes['summary'] = $val['FSUMMARY'];
                if($val['FMAINCOURSE'])$attributes['description'] = $val['FMAINCOURSE'];
                if(($val['FADDRESS']))$attributes['street']=$val['FADDRESS'];
                if($val['FDISTRICTNUMBER'])
                {
                    $region = $this->getRegionData($val['FDISTRICTNUMBER']);
                    if(!empty($region['province_id']))$attributes['province_id']=$region['province_id'];
                    if(!empty($region['city_id']))$attributes['city_id']=$region['city_id'];
                    if(!empty($region['district_id']))$attributes['district_id']=$region['district_id'];
                }
                if($val['FGWNUMBER'])
                {
                    $member = $memberMod->find("gai_number=:gai_number",array(":gai_number"=>$val['FGWNUMBER']));
                    if($member)$attributes['member_id']=$member->attributes['id'];
                }
                
                if(!empty($res))
                {
                    $attributes['update_time'] = time();
                    $result = $franchiseeMod->updateAll($attributes,'code=:code',array(':code'=>$val['FNUMBER']));
                    //$content = "更新了{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }else{
                    $attributes['code'] = $val['FNUMBER'];
                    $attributes['create_time'] = time();
                    $result = $db->createCommand()->insert('gw_franchisee',$attributes);
                    $franchiseeId = Yii::app()->db->getLastInsertID();
                    //$content = "插入{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }
                if($val['FTAGLIBID'] && $franchiseeId)
                {
                    Yii::app()->db->createCommand('delete from gw_franchisee_to_category where franchisee_id = '.$franchiseeId)->execute();
                    $CDB = new CDbCriteria();
                    $CDB->addInCondition('kingdee_id', explode(',', $val['FTAGLIBID']));
                    $franchiseeCategory =$franchiseeCategoryMod->findAll($CDB);
                    if(!empty($franchiseeCategory))
                    {
                        $franchiseeCategoryids = array();
                        $franchiseeCategory = array_map(create_function('$franchiseeCategory','return $franchiseeCategory->attributes;'),$franchiseeCategory);
                        foreach($franchiseeCategory as $category)
                        {
                            $att = array();
                            $att['franchisee_category_id'] = $category['id'];
                            $att['franchisee_id'] = $franchiseeId;
                            $db->createCommand()->insert('gw_franchisee_to_category',$att);
                        }
                    }
                }
                if($result>=0)$this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateStore();
        else echo 'import Store success!';
    }
    
    
    
    /**
     * 导入盖机 （只更新 ，不插入）
     */
    private function UpdateGwService()
    {
        $ea = $this->ea;
        $db = $this->db;
        $gt = $this->gt;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'GWSERVICE';
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $machineMod = Machine::model();
        $memberMod = Member::model();
        $franchiseeMod = Franchisee::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $results = $ea->createCommand($sql)->queryAll();
            foreach($results as $val)
            {
                if(empty($val['FMACHINECODE']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $machineMod->findAll("machine_code=:machine_code",array(":machine_code"=>$val['FMACHINECODE']));
                if(empty($res))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $attributes = array();
                
                if($val['FNAME_L2'])$attributes['name'] = $val['FNAME_L2'];
                if($val['FMACHINENUMBER'])$attributes['hardware_number'] = $val['FMACHINENUMBER'];
                if($val['FGWDISCOUNT'])$attributes['gai_discount'] = $val['FGWDISCOUNT'];
                if($val['FMEMBERDISCOUNT'])$attributes['member_discount'] = $val['FMEMBERDISCOUNT'];
                if(($val['FADDRESS']))$attributes['address']=$val['FADDRESS'];
                if($val['FDISTRICTNUMBER'])
                {
                    $region = $this->getRegionData($val['FDISTRICTNUMBER']);
                    if(!empty($region['province_id']))$attributes['province_id']=$region['province_id'];
                    if(!empty($region['city_id']))$attributes['city_id']=$region['city_id'];
                    if(!empty($region['district_id']))$attributes['district_id']=$region['district_id'];
                    if(!empty($region['country_id']))$attributes['country_id']=$region['country_id'];
                }
                if($val['FREFERRALSNUMBER'])
                {
                    $referrals = $memberMod->find("gai_number=:gai_number",array(":gai_number"=>$val['FREFERRALSNUMBER']));
                    if(!empty($referrals))$attributes['intro_member_id'] =$referrals->attributes['id'];
                }
                if($val['FSTOREID'])
                {
                    $sql = "SELECT FNUMBER FROM STORE WHERE FID = '{$val['FSTOREID']}'";
                    $code = $ea->createCommand($sql)->queryScalar();
                    $franchisee = $franchiseeMod->find("code=:code",array(":code"=>$code));
                    if(!empty($franchisee))$attributes['biz_info_id'] =$franchisee->attributes['id'];
                }
                if(!empty($res))
                {
                    $attributes['update_time'] = time();
                    $result = $machineMod->updateAll($attributes,'machine_code=:machine_code',array(':machine_code'=>$val['FMACHINECODE']));
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                }
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateGwService();
        else echo 'update GwService success!';
    }
    
    
    /**
     * 
     * 备用的oracle 连接
     */
    protected function db_oci()
    {
        $db = '(DESCRIPTION=(ADDRESS=(PROTOCOL =TCP)(HOST=172.16.4.61)(PORT = 1521))(CONNECT_DATA =(SID=EASDB)))';
        $oci = oci_connect('mdi', 'masterdatainterface',$db);
        $res = oci_parse($oci,'select * from taglib');
        oci_execute($res, OCI_DEFAULT);
        var_dump(oci_fetch_array($res,OCI_ASSOC));
        return false;
    }
    
    /**
     * 查找时候要获取的data类型函数
     * @param str $field
     * @param str $format
     * @return string
     * 
     * 例子 $sql = "select taglib.*,".$this->sqlToChar('feaslastupdatetime')." as feaslastupdatetime from taglib";
     */
    protected function sqlToChar($field,$format='YYYY-MM-DD HH24:MI:SS')
    {
        return 'to_char('.$field.',\''.$format.'\')';
    }
    
    /**
     * 插入或更新DATA类型等转换成ORACLE函数
     * @param str $field
     * @param str $format
     * @return string
     * 例子$sql = "update taglib set FGWLASTREADTIME=".$this->sqlToDate(date('Y-m-d H:i:s'))." where FID = 'I/QAAAAJV8ItwJFy'";
     */
    protected function sqlToDate($timestr,$format='YYYY-MM-DD HH24:MI:SS')
    {
        return 'to_date(\''.$timestr.'\',\''.$format.'\')';
    }
    
    /**
     * blob 文件流转换成文件
     * @param str $field
     * @param 二进制流  $blob
     * @param str  $suffix
     * @return string
     */
    protected function dealBlob($field,$blob,$suffix)
    { 
        $path = $field.'/'.date('Y/n/j').'/'.Tool::generateSalt().$suffix;
        $file_path = $this->root.$path;
        if(!file_exists(dirname($file_path)))
        {
            $this->mkdirs(dirname($file_path));
        }
        file_put_contents($file_path, stream_get_contents($blob));
        return $path;
    }
    
    /**
     * 处理oracle 文件类型 而获取后缀名
     * @param oracle field $str
     * @return string jpeg|png|text|pdf
     */
    protected function dealsuffix($str)
    {
        $str = strtolower($str);
        $patterns = '/jpeg|png|text|pdf/';
        preg_match($patterns,$str,$matches);
        return '.'.$matches[0];
    }
    
    /**
     * 处理邮编获取出来的 地区id
     * @param  $code
     * return array();
     */    
    protected function getRegionData($code)
    {
        if(!is_numeric($code)) return false;
        $region = $this->db->createCommand('SELECT * FROM gw_region where area_code='.$code)->queryRow();
        $tree = explode('|', $region['tree']); 
        if($tree[0]=='1' && count($tree)==4)
        {
            $res=array();
            $res['country_id'] = 1;
            $res['province_id']=$tree[1];
            $res['city_id']=$tree[2];
            $res['district_id']=$tree[3];
            $res['region_id'] = $region['id'];
            $sql="SELECT name FROM gw_region where id in ({$res['province_id']},{$res['city_id']},{$res['region_id']})";
            $street = $this->db->createCommand($sql)->queryAll();
            //$res['street'] = $street[0]['name'].$street[1]['name'].$street[2]['name'];
            return $res;    
        }else{
            return false;
        }
    }
    
    /**
     * 更新oracle 盖网读取时间 注意 本函数没测试oracle int字段作为条件来更新
     * @param str $table
     * @param str $field
     */
    protected function updateTime($table,$field,$conditions=array())
    {
        if(!empty($conditions))
        {
            $conditon = ' WHERE ';
            $i = 0 ;
            foreach($conditions as $key=>$val)
            {
                if($i===0)
                    $conditon.=" {$key} = '{$val}' ";
                else
                    $conditon.="and {$key} = '{$val}' ";
            }
        }
        $sql = !isset($conditon)?'update '.$table.' set '.$field.' = '.$this->sqlToDate(date('Y-m-d H:i:s')):'update '.$table.' set '.$field.' = '.$this->sqlToDate(date('Y-m-d H:i:s')).' '.$conditon;
        return $this->ea->createCommand($sql)->execute();
    }
    
    protected function mkdirs($dir) 
    { 
        if(!is_dir($dir)) 
        {
            if(!$this->mkdirs(dirname($dir))){ return false; }
            if(!mkdir($dir,0777)){ return false; }
        }
        return true; 
    }
    
    /**
     * 导入盖机（备用）（有插入的）
     */
    private function _UpdateGwService()
    {
        return;
        $ea = $this->ea;
        $db = $this->db;
        $gt = $this->gt;
        $row = 100;//一次查询多少条;分页查询 避免都塞入变量导致内存不足
        $start = 0;//开始
        $to = 0;//结束
        $exportTable = 'GWSERVICE';
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $end = $ea->createCommand($sql)->queryScalar();
        $machineMod = Machine::model();
        $memberMod = Member::model();
        $franchiseeMod = Franchisee::model();
        while($to<$end)
        {
            $start = $to;
            if($start+$row>$end)
            {
                $to=$end;
            }else{
                $to = $start+$row;
            }
            $sql = "select * from( select e.*,ROWNUM r from( select * from {$exportTable} where (FEASLASTUPDATETIME>FGWLASTREADTIME or FGWLASTREADTIME is null)) e ) where r between {$start} and {$to}";
            $results = $ea->createCommand($sql)->queryAll();
            foreach($results as $val)
            {
                if(empty($val['FMACHINECODE']))
                {
                    $this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
                    continue;
                }
                $res = $machineMod->findAll("machine_code=:machine_code",array(":machine_code"=>$val['FMACHINECODE']));
                $attributes = array();
    
                if($val['FNAME_L2'])$attributes['name'] = $val['FNAME_L2'];
                if($val['FMACHINENUMBER'])$attributes['hardware_number'] = $val['FMACHINENUMBER'];
                if($val['FGWDISCOUNT'])$attributes['gai_discount'] = $val['FGWDISCOUNT'];
                if($val['FMEMBERDISCOUNT'])$attributes['member_discount'] = $val['FMEMBERDISCOUNT'];
                if(($val['FADDRESS']))$attributes['address']=$val['FADDRESS'];
                if($val['FDISTRICTNUMBER'])
                {
                    $region = $this->getRegionData($val['FDISTRICTNUMBER']);
                    if(!empty($region['province_id']))$attributes['province_id']=$region['province_id'];
                    if(!empty($region['city_id']))$attributes['city_id']=$region['city_id'];
                    if(!empty($region['district_id']))$attributes['district_id']=$region['district_id'];
                    if(!empty($region['country_id']))$attributes['country_id']=$region['country_id'];
                }
                if($val['FREFERRALSNUMBER'])
                {
                    $referrals = $memberMod->find("gai_number=:gai_number",array(":gai_number"=>$val['FREFERRALSNUMBER']));
                    if(!empty($referrals))$attributes['intro_member_id'] =$referrals->attributes['id'];
                }
                if($val['FSTOREID'])
                {
                    $sql = "SELECT FNUMBER FROM STORE WHERE FID = '{$val['FSTOREID']}'";
                    $code = $ea->createCommand($sql)->queryScalar();
                    $franchisee = $franchiseeMod->find("code=:code",array(":code"=>$code));
                    if(!empty($franchisee))$attributes['biz_info_id'] =$franchisee->attributes['id'];
                }
                if(!empty($res))
                {
                    $attributes['update_time'] = time();
                    $result = $machineMod->updateAll($attributes,'machine_code=:machine_code',array(':machine_code'=>$val['FMACHINECODE']));
                    //$content = "更新了{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }else{
                    $attributes['machine_code'] = $val['FMACHINECODE'];
                    $attributes['create_time'] = time();
                    $result = $gt->createCommand()->insert('gt_machine',$attributes);
                    //$content = "插入{$val['FID']}数据\r\n";
                    //if($result)file_put_contents(date('Y/m/d').'.log', $content);
                }
                if($result>=0)$this->updateTime($exportTable, 'fgwlastReadtime',array('FID'=>$val['FID']));
            }
        }
        $sql = 'select count(*) from '.$exportTable.' e where (e.FEASLASTUPDATETIME>e.FGWLASTREADTIME or e.FGWLASTREADTIME is null)';
        $count = $ea->createCommand($sql)->queryScalar();
        if($count>0)$this->UpdateGwService();
        else echo 'import GwService success';
    }
}
