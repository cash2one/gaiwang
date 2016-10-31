<?php
/*
 * 每周统计控制器
 * @author ozj
 */

class WeeklyStatisticsController extends Controller{



    public function beforeAction($action){
        if(strpos(strtolower($this->action->id),'export') !== false){
            if(!isset($_POST['password']) || $_POST['password'] != DAILY_EXPORT_KEY)
                die('<script type="text/javascript">alert("Failure: Password error!");window.close();</script>');
        }
        return parent::beforeAction($action);
    }

    public function filters() {
        return array(
            'rights',
        );
    }

    /*
     * 盖机
     */
      public function actionMachine(){
        $this->render('machine');
    }

    /*
     * 加盟商
     */
      public function actionFranchisee(){
          $this->render('franchisee');
     }

    
    /*
     * 会员
     */
      public function actionMember(){
          $sqlWhere = 'register_time >='.strtotime('-8 days');
          $count = Yii::app()->dbr->createCommand(self::replaceSqlTalbeName("select count(id) from {gw}.gw_member where $sqlWhere"))->queryScalar();
          $limit = 100000;
          $pages = (int)$count/$limit + 1;
          $this->render('member',array('pages'=>$pages));
    }
    /*
     *盖机运行时间
     */
    public function actionMachineTime(){
        $count = Yii::app()->dbr->createCommand(self::replaceSqlTalbeName("select count(id) from {gt}.gt_machine"))->queryScalar();
        $limit = 100000;
        $pages = (int)$count/$limit + 1;
        $this->render('machineTime',array('pages'=>$pages));
    }

    /*
    *订单数据（商城）
    */
      public function actionOrder(){
          $count = Yii::app()->dbr->createCommand(self::replaceSqlTalbeName("select count(id) from {gw}.gw_order_goods"))->queryScalar();
          $limit = 5000;
          $pages = (int)$count/$limit + 1;
          $this->render('order',array('pages'=>$pages));
    }

    /*
    * 盖机最新运行时间
    */
    public function actionMachineDelay(){
        $count = Yii::app()->dbr->createCommand(self::replaceSqlTalbeName("select count(id) from {gt}.gt_machine"))->queryScalar();
        $limit = 5000;
        $pages = (int)$count/$limit + 1;
        $this->render('machineDelay',array('pages'=>$pages));
    }

   /*
    * 盖机导出数据
    */
    public function actionMachineExport(){
        error_reporting(0);
        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','7000M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');

        // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');
        $title = array(
            'id',                                //             machine_id
            '装机编码(主键)',						//?主键	  		machine_code
            '加盟商编号',							//gw_frachiseee.code
            '加盟商名称',							//gw_frachiseee.name
            '加盟商地址',							//关联查询         		gw_franchisee.street
            '加盟商会员编号',					    //关联查询         		gw_member.gai_number
            '加盟商会员是否为企业会员',				//关联查询         		gw_member.enterprise_id
            '加盟商分类',
            '盖机名称',
            '店面电话',								//加盟商电话   	 gw_franchisee.mobile
            '企业会员注册名称',                        //加盟商的对应企业会员的名称(企业会员里的名称)			gw_member_info.name
            '联系人',                     //gw_enterprise.line_man
            '盖网会员折扣价',				//gw_franchisee.gai_discount
            '盖网结算折扣价',				//gw_franchisee.member_discount
            '折扣差',						//gw_franchisee.member_discount - gw_franchisee.gai_discount
            '企业会员编号（加盟商绑定企业会员）',		//加盟商对应的企业会员的编号（GW号）	gw_member.gai_number
            '企业帐号开通人',						//加盟商对应的企业会员帐号真实名称	gw_member.real_name
            '企业帐号开通手机',				//加盟商的对应的额（会员表中手机号码）					gw_member.mobile
            '企业会员银行帐号',				//gw_member.identity_number
            '企业会员银行帐号开户行',			//gw_member.identity_type
            '企业会员银行帐号开户名',			//gw_bank_account.acount_name
            '银行所在省',
            '银行所在市',
            '银行所在区',
            '加盟商营业执照注册名称',			//没保存
            '加盟商营业执照注册号',			//gw_member_info.license
            '加盟商营业执照注册地址',			//没保存
            '分管代理商企业名称',				//对应盖机所属区域的代理商所对应的企业的名称  gw_member_info.name
            '铺机区域（大区）',				//目前定位为区域的南北
            '铺机区域（省）',				//gt_machine.province_id
            '铺机区域（市）',				//gt_machine.city_id
            '铺机区域（区县）',				//gt_machine.district_id
            '盖网通推荐者GW号',		//盖网通对应加盟商的推荐者的GW号，gw_member.gai_number
            '盖网通推荐者姓名',		//同上  gw_member.name
            '盖网通推荐者手机号',	//同上  gw_member.mobile
            '盖网通租赁者GW号',				//没保存
            '盖网通租赁者姓名',				//没保存
            '盖网通租赁者手机号',				//没保存
            '加盟商编号生成时间',				//加盟商创建时间  gw_franchisee.create_time
            '企业会员注册时间',				//gw_member.register_time
            '装机编号生成时间',				//gt_machine.create_time
            '盖网通状态',					//gt_machine.status
            '盖网通运行状态',					//gt_machine.run_status
            '盖机绑定会员数量',
            '盖机首次激活时间',//activat_time
            '最后激活时间',//setup_time
            '最后打开时间'
        );

        // PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
           $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
        // 写入列头
        fputcsv($fp, array_values($title));

        $sql = "SELECT
machine.id,
	machine.machine_code,
	f. code,
	f. name,
	f.street,
    fm.gai_number as '加盟商会员编号',
    IF(fm.enterprise_id, '是', '否') AS '加盟商会员是否为企业会员',
	f.id AS 'franchisee_category_id',
	machine. name AS '盖机名称',
	f.mobile AS f_mobile,
	fmi.`name` AS fmi_name,
	fmi.`link_man` AS '联系人',
	f.member_discount,
	f.gai_discount,
	(f.member_discount - f.gai_discount) AS discount,
	fm.gai_number AS fm_gai_number,
	fm.real_name AS fm_real_name,
	fm.mobile AS fm_mobile,
	fmb.account,
	fmb.bank_name,
	fmb.account_name,
	fmbr. name AS '银行所在省',
	fmbc. name AS '银行所在市',
	fmbd. name AS '银行所在区',
	'' AS '加盟商营业执照注册名称',
	fmia.license,
	'' AS '加盟商营业执照注册地址',
	rmi.`name` AS rmi_name,
	r.area,
	r.`name` AS pname,
	c.`name` AS cname,
	d.`name` AS dname,
	machiner.gai_number AS fmr_gai_number,
	machiner.username AS fmr_username,
	machiner.mobile AS fmr_mobile,
	'' AS '盖网通租赁者GW号',
	'' AS '盖网通租赁者姓名',
	'' AS '盖网通租赁者手机号',
	f.create_time AS f_create_time,
	fm.register_time,
	machine.create_time AS machine_create_time,
	machine.status,
	machine.run_status,
    0 AS count,
    machine.activat_time,
    machine.setup_time,
    IF(machine.last_open_time>0,FROM_UNIXTIME(machine.last_open_time),'') AS last_open_time
FROM
	{gt}.gt_machine machine
LEFT JOIN {gw}.gw_franchisee f ON f.id = machine.biz_info_id
LEFT JOIN {gw}.gw_member fm ON fm.id = f.member_id
LEFT JOIN {gw}.gw_enterprise fmi ON fmi.id = fm.enterprise_id
LEFT JOIN {gw}.gw_enterprise_data fmia ON fmia.enterprise_id=fmi.id
LEFT JOIN {gw}.gw_bank_account fmb ON fmb.member_id = fm.id
LEFT JOIN {gw}.gw_region r ON r.id = machine.province_id
LEFT JOIN {gw}.gw_region c ON c.id = machine.city_id
LEFT JOIN {gw}.gw_region d ON d.id = machine.district_id
LEFT JOIN {gw}.gw_member rm ON rm.id = d.member_id
LEFT JOIN {gw}.gw_enterprise rmi ON rmi.id = rm.enterprise_id
LEFT JOIN {gw}.gw_member fmr ON fmr.id = fm.referrals_id
LEFT JOIN {gw}.gw_region fmbr ON fmbr.id = fmb.province_id
LEFT JOIN {gw}.gw_region fmbc ON fmbc.id = fmb.city_id
LEFT JOIN {gw}.gw_region fmbd ON fmbd.id = fmb.district_id
LEFT JOIN {gw}.gw_member machiner ON machiner.id = machine.intro_member_id ";

        $sql = self::replaceSqlTalbeName($sql);
        $data = Yii::app()->dbr->createCommand($sql)->queryAll();

        $memberSql = "select machine_id,count(id) as count FROM {gt}.gt_machine_register GROUP BY machine_id";
        $memberSql = self::replaceSqlTalbeName($memberSql);
        $memberData = Yii::app()->dbr->createCommand($memberSql)->queryAll();
        $countData = array();
        foreach ($memberData as $row)
        {
            $countData[$row['machine_id']] = $row['count'];
        }
        $list = array();
      foreach($data as $key => $value){

              foreach($value as $k => $v) {
                  if ($k == 'f_create_time' || $k == 'register_time') {
                      $list[$key][$k] = Tool::stampToDate($v + 0);
                  } elseif ($k == 'machine_create_time') {
                      $list[$key][$k] = $value['machine_create_time'] ? date('Y-m-d H:i:s', $value['machine_create_time']) : '';
                  } elseif ($k == 'activat_time') {
                      $list[$key][$k] = $value['activat_time'] ? date('Y-m-d H:i:s', $value['activat_time']) : '';
                  } elseif ($k == 'setup_time') {
                      $list[$key][$k] = $value['setup_time'] ? date('Y-m-d H:i:s', $value['setup_time']) : '';
                  } elseif ($k == 'status') {
                      $list[$key][$k] = Machine::getMachineStatus($v);
                  } elseif ($k == 'run_status'){
                      $list[$key][$k] = Machine::getRunStatus($v);
                  } elseif($k =='area'){
                      if ($value['area'] == 0) {
                          $list[$key][$k] = '';
                      } elseif ($value['area'] == 1) {
                          $list[$key][$k] = '北盖网通';
                      } else {
                          $list[$key][$k] = '南盖网通';
                      }
                  } elseif($k == 'franchisee_category_id'){
                      $list[$key][$k] = FranchiseeCategory::getFanchiseeCategoryAllName($v);
                  } elseif($k == 'count'){
                      $list[$key][$k] = isset($countData[$value['id']]) ? $countData[$value['id']] : 0;
                  } elseif($k == 'machine_code'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'license'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'f_mobile'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'code'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'fm_mobile'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'fmr_mobile'){
                      $list[$key][$k] = "\t".$v;
                  }elseif($k == 'account'){
                      $list[$key][$k] = "\t".$v;
                  }else{
                      $list[$key][$k] = $v;
                  }
              }
              }
        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，节约资源
        $limit = 10000;
        foreach ($list as $key => $value) {
            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            foreach ($value as $k => $val) {
                $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
            }
            fputcsv($fp,$value);
            unset($value);
        }
        exit;
    }

    public function actionFranchiseeExport(){
        error_reporting(0);
        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','7000M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');

        // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');

        $title = array(
            'id',                                //             machine_id
            '装机编码(主键)',						//?主键	  		machine_code
            '加盟商编号',							//gw_frachiseee.code
            '加盟商名称',							//gw_frachiseee.name
            '加盟商地址',							//关联查询         		gw_franchisee.street
            '加盟商会员编号',					    //关联查询         		gw_member.gai_number
            '加盟商会员是否为企业会员',				//关联查询         		gw_member.enterprise_id
            '盖机名称',
            '店面电话',								//加盟商电话   	 gw_franchisee.mobile
            '企业会员注册名称',						//加盟商的对应企业会员的名称(企业会员里的名称)			gw_member_info.name
            '盖网会员折扣价',				//gw_franchisee.gai_discount
            '盖网结算折扣价',				//gw_franchisee.member_discount
            '折扣差',						//gw_franchisee.member_discount - gw_franchisee.gai_discount
            '企业会员编号（加盟商绑定企业会员）',		//加盟商对应的企业会员的编号（GW号）	gw_member.gai_number
            '企业帐号开通人',						//加盟商对应的企业会员帐号真实名称	gw_member.real_name
            '企业帐号开通手机',				//加盟商的对应的额（会员表中手机号码）					gw_member.mobile
            '企业会员银行帐号',				//gw_member.identity_number
            '企业会员银行帐号开户行',			//gw_member.identity_type
            '企业会员银行帐号开户名',			//gw_bank_account.acount_name
            '银行所在省',
            '银行所在市',
            '银行所在区',
            '加盟商营业执照注册名称',			//没保存
            '加盟商营业执照注册号',			//gw_member_info.license
            '加盟商营业执照注册地址',			//没保存
            '分管代理商企业名称',				//对应盖机所属区域的代理商所对应的企业的名称  gw_member_info.name
            '铺机区域（大区）',				//目前定位为区域的南北
            '铺机区域（省）',				//gt_machine.province_id
            '铺机区域（市）',				//gt_machine.city_id
            '铺机区域（区县）',				//gt_machine.district_id
            '盖网通推荐者GW号',		//盖网通对应加盟商的推荐者的GW号，gw_member.gai_number
            '盖网通推荐者姓名',		//同上  gw_member.name
            '盖网通推荐者手机号',	//同上  gw_member.mobile
            '盖网通租赁者GW号',				//没保存
            '盖网通租赁者姓名',				//没保存
            '盖网通租赁者手机号',				//没保存
            '加盟商编号生成时间',				//加盟商创建时间  gw_franchisee.create_time
            '企业会员注册时间',				//gw_member.register_time
            '装机编号生成时间',				//gt_machine.create_time
            '盖网通状态',					//gt_machine.status
            '盖网通运行状态',					//gt_machine.run_status
            '盖机绑定会员数量',
            '盖机首次激活时间',//activat_time
            '最后激活时间',//setup_time
            '最后打开时间'
        );

        // PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
           $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
        // 写入列头
       fputcsv($fp, array_values($title));

        $sql = "SELECT
    machine.id,
	machine.machine_code,
	f. code,
	f. name,
	f.street,
	fm.gai_number as '加盟商会员编号',
    IF(fm.enterprise_id, '是', '否') AS '加盟商会员是否为企业会员',
	machine. name AS machine_name,
	f.mobile AS f_mobile,
	fmi.`name` AS fmi_name,
	f.member_discount,
	f.gai_discount,
	0 AS discount,
	fm.gai_number AS fm_gai_number,
	fm.real_name AS fm_real_name,
	fm.mobile AS fm_mobile,
	fmb.account,
	fmb.bank_name,
	fmb.account_name,
	fmbr. name AS fmbr_name,
	fmbc. name AS fmbc_name,
	fmbd. name AS fmbd_name,
	'' AS aaaaa,
	fmia.license,
	'' AS bbbbb,
	rmi.`name` AS rmi_name,
	r.area,
	r.`name` AS pname,
	c.`name` AS cname,
	d.`name` AS dname,
	machiner.gai_number AS fmr_gai_number,
	machiner.username AS fmr_username,
	machiner.mobile AS fmr_mobile,
	'' AS ccccc,
	'' AS ddddd,
	'' AS eeeee,
	f.create_time AS f_create_time,
	fm.register_time,
	machine.create_time AS machine_create_time,
	machine.status,
	machine.run_status,
    0 AS count,
    machine.activat_time,
    machine.setup_time,
    IF(machine.last_open_time>0,FROM_UNIXTIME(machine.last_open_time),'') AS last_open_time
FROM
	{gw}.gw_franchisee f
LEFT JOIN {gt}.gt_machine machine ON f.id = machine.biz_info_id
LEFT JOIN {gw}.gw_member fmc ON fmc.id = f.member_id
LEFT JOIN {gw}.gw_member fm ON fm.id = f.member_id
LEFT JOIN {gw}.gw_enterprise fmi ON fmi.id = fm.enterprise_id
LEFT JOIN {gw}.gw_enterprise_data fmia ON fmia.enterprise_id=fmi.id
LEFT JOIN {gw}.gw_bank_account fmb ON fmb.member_id = fm.id
LEFT JOIN {gw}.gw_region r ON r.id = machine.province_id
LEFT JOIN {gw}.gw_region c ON c.id = machine.city_id
LEFT JOIN {gw}.gw_region d ON d.id = machine.district_id
LEFT JOIN {gw}.gw_member rm ON rm.id = d.member_id
LEFT JOIN {gw}.gw_enterprise rmi ON rmi.id = rm.enterprise_id
LEFT JOIN {gw}.gw_member fmr ON fmr.id = fm.referrals_id
LEFT JOIN {gw}.gw_region fmbr ON fmbr.id = fmb.province_id
LEFT JOIN {gw}.gw_region fmbc ON fmbc.id = fmb.city_id
LEFT JOIN {gw}.gw_region fmbd ON fmbd.id = fmb.district_id
LEFT JOIN {gw}.gw_member machiner ON machiner.id = machine.intro_member_id  ";
        $sql = self::replaceSqlTalbeName($sql);
        $data = Yii::app()->dbr->createCommand($sql)->queryAll();

        $memberSql = "select machine_id,count(id) as count FROM {gt}.gt_machine_register GROUP BY machine_id";
        $memberSql = self::replaceSqlTalbeName($memberSql);
        $memberData = Yii::app()->dbr->createCommand($memberSql)->queryAll();
        $countData = array();
        foreach ($memberData as $row)
        {
            $countData[$row['machine_id']] = $row['count'];
        }

        $list = array();
        foreach($data as $key =>$value) {

            foreach ($value as $k => $v) {
                if ($k == 'f_create_time') {
                    $list[$key][$k] =date('Y-m-d H:i:s',$value['f_create_time']);
                } elseif($k == 'register_time'){
                    $list[$key][$k] =date('Y-m-d H:i:s',$value['register_time']);
                }elseif ($k == 'machine_create_time') {
                    $list[$key][$k] = $value['machine_create_time'] ? date('Y-m-d H:i:s', $value['machine_create_time']) : '';
                } elseif ($k == 'activat_time') {
                    $list[$key][$k] = $value['activat_time'] ? date('Y-m-d H:i:s', $value['activat_time']) : '';
                } elseif ($k == 'setup_time') {
                    $list[$key][$k] = $value['setup_time'] ? date('Y-m-d H:i:s', $value['setup_time']) : '';
                } elseif ($k == 'status') {
                    $list[$key][$k] = Machine::getMachineStatus($v);
                } elseif ($k == 'discount') {
                    $list[$key][$k] = $value['member_discount'] - $value['gai_discount'];
                } elseif ($k == 'count') {
                    $list[$key][$k] = ($value['id'] != null && isset($countData[$value['id']])) ? $countData[$value['id']] : 0;
                } elseif ($k == 'run_status') {
                    $list[$key][$k] = Machine::getRunStatus($v);
                }elseif($k == 'machine_code'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'license'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'f_mobile'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'code'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'fm_mobile'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'fmr_mobile'){
                    $list[$key][$k] = "\t".$v;
                }elseif($k == 'account'){
                    $list[$key][$k] = "\t".$v;
                }elseif ($k == 'area') {
                    if ($value['area'] == 0) {
                        $list[$key][$k] = '';
                    } elseif ($value['area'] == 1) {
                        $list[$key][$k] = '北盖网通';
                    } else {
                        $list[$key][$k] = '南盖网通';
                    }
                } else{
                    $list[$key][$k] = $v;
                }
            }
        }
        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，节约资源
        $limit = 10000;
        foreach ($list as $key => $value) {
            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            foreach ($value as $k => $val) {
                $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
            }
            fputcsv($fp,$value);
            unset($value);
        }
        exit;
    }



    /*
     * 导出excel(会员数据）
     */
    public function actionMemberExport(){
        error_reporting(0);
        $page = $this->getPost('limit') - 1;
        $starts = $page * 100000;
        $limits =100000;

        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','7000M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');
                    // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');

        $sql = self::replaceSqlTalbeName("select id,`name` from {gw}.gw_member_type");
        $ary = Yii::app()->dbr->createCommand($sql)->queryAll();
        $memberType = array();
        if(!empty($ary))foreach($ary as $val){
            $memberType[$val['id']] = $val['name'];
        }
        $sqlWhere = 'register_time >='.strtotime('-8 days');
        $title = array(
                '盖网编号',
                '绑定手机号',
                '注册时间',
                '注册类型',
                '注册所在装机编号',
                '注册推荐人',
                '用户名',
                '状态',
                '是否为企业会员',
                '会员类型',
                '激活状态',
                '无主',
                '内部会员',
                '是否主账号',
                '所在省份',
                '所在城市',
                '所在地区',
                '居住地',//???
                '详细地址',
                '邮箱',
                '真实姓名',
                '证件类型',
                '证件号码',
                '性别',
                '出生日期',
                '消费账户余额'
            );


            // PHP文件句柄，php://output 表示直接输出到浏览器
       $fp = fopen('php://output', 'a');
       foreach ($title as $key => $value) {
            $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
            // 写入列头
        fputcsv($fp, array_values($title));

            $sql = "SELECT
    m.gai_number,
    mobile,
    FROM_UNIXTIME(m.register_time),
    CASE m.register_type
    WHEN 0 THEN '默认'
    WHEN 1 THEN '盖机'
    WHEN 2 THEN '盖网通'
    WHEN 3 THEN '手机短信'
    WHEN 4 THEN '手机APP'
    WHEN 5 THEN '路由'
    WHEN 6 THEN '第三方'
    WHEN 7 THEN '盖付通'
    WHEN 8 THEN '盖象APP'
    ELSE m.register_type END AS reg_type,
    m.gai_number as reg_machine_code,
    m.referrals_id,
    m.username,m.status,
    IF(m.enterprise_id, '是', '否') AS '是否为企业会员',
    m.type_id,
    IF(m.flag, '已激活', '未激活') AS '激活状态',
    IF(m.referrals_id, '否', '是') AS '无主',
    IF(m.is_internal, '是', '否') AS '内部会员',
    IF(m.is_master_account, '是', '否') AS '是否主账号',
    province.name as province_name,city.name as city_name,district.name as district_name,
    m.street as address,
    m.street,m.email,m.real_name,m.identity_type,m.identity_number,m.sex,
    if(m.birthday,FROM_UNIXTIME(m.birthday),''),
    ac.today_amount as '消费账户余额'
    FROM {gw}.gw_member as m
    LEFT JOIN {gw}.gw_region as province on m.province_id>0 and province.id=m.province_id
    LEFT JOIN {gw}.gw_region as city on m.city_id>0 and city.id=m.city_id
    LEFT JOIN {gw}.gw_region as district on m.district_id>0 and district.id=m.district_id
    LEFT JOIN {ac}.gw_account_balance as ac on ac.account_id=m.id and ac.type=3 and ac.gai_number=m.gai_number where $sqlWhere
    ORDER BY m.id DESC limit $starts,$limits";

            $sql = self::replaceSqlTalbeName($sql);
            $command = Yii::app()->dbr->createCommand($sql);
            $command->execute();
            $data = $command->query();

            $list = array();
            //处理数据
            foreach ($data as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($k == 'type_id') {
                        $list[$key][$k] = $memberType[$val['id']] ;
                    } elseif ($k == 'status') {
                        $list[$key][$k] = Member::status($v);
                    } elseif ($k == 'sex') {
                        $list[$key][$k] = Member::gender($v);
                    } elseif ($k == 'identity_type') {
                        $list[$key][$k] = Member::identityType($v);
                    }elseif($k == 'identity_number'){
                        $list[$key][$k] = "\t".$v;
                    }elseif($k =='reg_machine_code'){
                        // 注册所在装机编号
                        $sql_code = self::replaceSqlTalbeName(" select mrem.`machine_code`
from {gt}.gt_machine_register AS mre
LEFT JOIN {gt}.gt_machine AS mrem ON(mre.machine_id=mrem.id)
where mre.member_id='".$value['reg_machine_code']."'");
                        $list[$key][$k] = "\t".Yii::app()->dbr->createCommand($sql_code)->queryScalar();
                    }elseif($k == 'referrals_id'){
                        // 推荐人
                        $sql_re = self::replaceSqlTalbeName("select gai_number from {gw}.gw_member where id='".$value['referrals_id']."'");
                        $list[$key][$k] = Yii::app()->dbr->createCommand($sql_re)->queryScalar();
                    }else {
                        $list[$key][$k] = $v;
                    }
                }
            }
            // 计数器
            $cnt = 0;
            // 每隔$limit行，刷新一下输出buffer，节约资源
            $limit = 10000;
            foreach ($list as $key => $value) {
                $cnt ++;
                if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                    ob_flush();
                    flush();
                    $cnt = 0;
                }
                foreach ($value as $k => $val) {
                    $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
                }
                fputcsv($fp,$value);
                unset($value);
            }
            exit;
    }


    /**
     * 订单来源 （1网站、2ANDROID客户端、3IOS客户端，4WAP端）
     */
    const ORDER_SOURCE_WEB = 1;
    const ORDER_SOURCE_ANDROID = 2;
    const ORDER_SOURCE_IOS = 3;
    const ORDER_SOURCE_WAP = 4;

    public static function sourceType($k = null) {
        $arr = array(
            self::ORDER_SOURCE_WEB => Yii::t('order', '网站'),
            self::ORDER_SOURCE_ANDROID => Yii::t('order', 'ANDROID客户端'),
            self::ORDER_SOURCE_IOS => Yii::t('order', 'IOS客户端'),
            self::ORDER_SOURCE_WAP => Yii::t('order', 'WAP端'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }



        /*
         * 导出excel (订单数据（商城）)
         */
    public function actionOrderExport(){
        error_reporting(0);
        $page = $this->getPost('limit') - 1;
        $starts = $page * 5000;
        $limits =5000;

        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','7000M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');

        // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');

        $title = array(
                '父订单编号',
                '订单编号',
                '订单来源',
                '所属会员',
                '店铺名称',
                '所属商家',
                '所属商家GW号',
                '下单时间',
                '状态（1新订单，2交易完成，3交易关闭）',
                '支付状态（1未支付，2已支付）',
                '配送状态（1未发货，2等待发货，3已出货，4签收）',
                '退款状态（0无，1申请中，2失败，3成功）',
                '供货价',
                '总销售价',
                '收货地址',
                '总运费',
                '支付时间',
                '申请退款时间',
                '商品分类',
                '商品名称',
                '商品编号',
                '商品件数',
                '商品链接',
                '现金销售额',
                '红包销售额',
                '积分销售额',
                '高汇通积分+现金（积分部分）',
                '签收时间'
            );

        // PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
            $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
        // 写入列头
       fputcsv($fp, array_values($title));

        $sql = "SELECT
o.`parent_code` AS '父订单编号',
o.`code` AS '订单编号',
o.`source` AS '订单来源',
om.gai_number AS '所属会员',
s.`name` AS '店铺名称',
sm.username AS '所属商家',
sm.gai_number AS '所属商家GW号',
IF(o.create_time,FROM_UNIXTIME(o.create_time),'') AS '下单时间',
o.`status` AS '状态',
o.pay_status AS '支付状态',
o.delivery_status AS '配送状态',
o.refund_status AS '退款状态',
og.gai_price*og.quantity AS '供货价',
og.total_price AS '总销售价',
o.address AS '收货地址',
o.freight AS '总运费',
IF(o.pay_time,FROM_UNIXTIME(o.pay_time),'') AS '支付时间',
IF(o.apply_refund_time,FROM_UNIXTIME(o.apply_refund_time),'') AS '申请退款时间',
category.name AS '商品分类',
og.goods_name AS '商品名称',
og.goods_id AS '商品编号',
og.quantity AS '商品件数',
og.goods_id AS '商品链接',
IF((o.pay_type > 2) AND (o.pay_type <= 9),o.pay_price,0) AS '现金销售额',
 o.other_price AS '红包销售额',
IF(o.pay_type = 1,pay_price, 0) AS '积分销售额',
IF(o.pay_type = 11,jf_price,0) AS '高汇通积分+现金（积分部分）',
IF(o.sign_time,FROM_UNIXTIME(o.sign_time),'') AS '签收时间'
FROM {gw}.gw_order_goods AS og
INNER JOIN {gw}.gw_order AS o ON o.id=og.order_id
LEFT JOIN {gw}.gw_member AS om ON (o.member_id = om.id)
LEFT JOIN {gw}.gw_store AS s ON (o.store_id = s.id)
LEFT JOIN {gw}.gw_member AS sm ON (sm.id = s.member_id)
LEFT JOIN {gw}.gw_goods AS g ON (g.id = og.goods_id)
LEFT JOIN {gw}.gw_category AS category ON g.category_id = category.id
ORDER BY og.id DESC limit $starts,$limits ";
        $sql = self::replaceSqlTalbeName($sql);
        $data = Yii::app()->dbr->createCommand($sql)->queryAll();
        $list = array();
               //处理数据
        foreach($data as $key =>$value){
            foreach($value as $k =>$v){
                if($k == '订单来源') {
                    $list[$key][$k] = self::sourceType($v);
                }elseif($k == '父订单编号'){
                    $list[$key][$k] = "\t".$v;
                } elseif($k == '订单编号'){
                    $list[$key][$k] = "\t".$v;
                }elseif ($k == '状态'){
                    $list[$key][$k] = Order::Status($v);
                }elseif($k == '支付状态'){
                    $list[$key][$k] = Order::payStatus($v);
                }elseif($k == '配送状态'){
                    $list[$key][$k] = Order::deliveryStatus($v);
                }elseif($k == '退款状态'){
                    $list[$key][$k] = Order::refundStatus($v);
                }elseif($k == '商品链接'){
                    $list[$key][$k] = 'http://www.g-emall.com/goods/'.$value['商品链接'].'.html';
                }elseif($k == '店铺名称'){
                    $list[$key][$k] = str_replace($this->rep_s,$this->rep_r,$value['店铺名称']);
                }elseif($k == '所属商家'){
                    $list[$key][$k] = str_replace($this->rep_s,$this->rep_r,$value['所属商家']);
                }elseif($k == '商品名称'){
                    $list[$key][$k] = str_replace($this->rep_s,$this->rep_r,$value['商品名称']);
                }elseif($k == '收货地址'){
                    $list[$key][$k] = str_replace($this->rep_s,$this->rep_r,$value['收货地址']);
                }else{
                    $list[$key][$k] = $v;
                }
            }
        }
        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，节约资源
        $limit = 20000;
        foreach ($list as $key => $value) {
            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            foreach ($value as $k => $val) {
                $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
            }
            fputcsv($fp,$value);
            unset($value);
        }
        exit;
    }


    /*
     * 导出excel (盖机运行时间表)
     */
    public function actionMachineTimeExport(){
        error_reporting(0);
        $page = $this->getPost('limit') - 1;
        $starts = $page * 100000;
        $limits =100000;

        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','7000M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');
        // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');

        $title = array('记录日期', '装机编号', '加盟商名称', '盖机名称', '盖机状态', '盖机运行状态', '省', '市', '区', '最后激活时间', '最近开机时间');

        // PHP文件句柄，php://output 表示直接输出到浏览器
       $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
            $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
        // 写入列头
       fputcsv($fp, array_values($title));

        $sql =  "SELECT l.log_date,l.machine_code,f.name as fname,m.name as mname,l.status,l.run_status,rp.name as pname,rc.name as cname,rd.name as dname,l.setup_time,l.last_open_time
FROM {gt}.gt_machine_day_log as l
inner JOIN {gt}.gt_machine as m on m.machine_code=l.machine_code
inner JOIN {gw}.gw_franchisee f ON f.id=m.biz_info_id
inner JOIN {gw}.gw_region rp ON rp.id=m.province_id
inner JOIN {gw}.gw_region rc ON rc.id=m.city_id
inner JOIN {gw}.gw_region rd ON rd.id=m.district_id limit $starts,$limits";

        $sql = self::replaceSqlTalbeName($sql);
        $data = Yii::app()->dbr->createCommand($sql)->queryAll();
        $list = array();

        //处理数据
        foreach($data as $key =>$value){
            foreach($value as $k =>$v){
                if($k == 'setup_time') {
                    $list[$key][$k] =  $value['setup_time'] != 0 ? date('Y-m-d H:i:s',$value['setup_time']) : '';
                }elseif($k == 'last_open_time'){
                    $list[$key][$k] =  $value['last_open_time'] != 0 ? date('Y-m-d H:i:s',$value['last_open_time']) : '';
                }elseif($k == 'machine_code'){
                    $list[$key][$k] = "\t".$v;
                }elseif ($k == 'status'){
                    $list[$key][$k] = Machine::getMachineStatus($v);
                }elseif($k == 'run_status'){
                    $list[$key][$k] = Machine::getRunStatus($v);
                }elseif($k == 'fname'){
                    $list[$key][$k] = str_replace(',','，',$value['fname']);
                }elseif($k == 'mname'){
                    $list[$key][$k] = str_replace(',','，',$value['mname']);
                }else{
                    $list[$key][$k] = $v;
                }
            }
        }

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，节约资源
        $limit = 10000;
        foreach ($list as $key => $value) {
            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            foreach ($value as $k => $val) {
                $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
            }
            fputcsv($fp,$value);
            unset($value);
        }
        exit;
    }

/*
 * 导出excel （盖机最新运行时间表）
 */
     public function actionMachineDelayExport(){
         error_reporting(0);
         $page = $this->getPost('limit') - 1;
         $starts = $page * 5000;
         $limits =5000;

         date_default_timezone_set('PRC');
         set_time_limit(0);
         ini_set('memory_limit','7000M');
         ini_set('max_execution_time','0');
         $time =date('Ymd');
         // 输出Excel文件头
         header('Content-Type: application/vnd.ms-excel;charset=GBK');
         header("Content-Disposition: attachment;filename=".$time.".csv");
         header('Cache-Control: max-age=0');

         $title = array(
             '装机编号',
             '加盟商编号',
             '加盟商名称',
             '企业会员号',
             '企业会员名称',
             '盖机绑定会员数量',//gt_machine_register
             '盖机名称',
             '装机编号生成时间',//machine.create_time
             '盖网通状态',
             '盖机首次激活时间',//setup_time
             '最后激活时间',//setup_time
             '最后打开时间'//last_open_time
         );

         // PHP文件句柄，php://output 表示直接输出到浏览器
         $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
             $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
         }
         // 写入列头
         fputcsv($fp, array_values($title));

         $sql = self::replaceSqlTalbeName("select id,`name` from {gw}.gw_member_type");
         $ary = Yii::app()->dbr->createCommand($sql)->queryAll();
         $memberType = array();
         if(!empty($ary))foreach($ary as $val){
             $memberType[$val['id']] = $val['name'];
         }

         $sql = "SELECT
machine_code,
`name`,
id as enterprise_code,
id as enterprise_name,
biz_info_id as franchisee_code,
biz_info_id as franchisee_name,
FROM_UNIXTIME(create_time),
`status`,
id as member_counts,
FROM_UNIXTIME(activat_time) as first_time,
FROM_UNIXTIME(setup_time),
FROM_UNIXTIME(last_open_time)
FROM {gt}.gt_machine limit $starts,$limits";
         $sql = self::replaceSqlTalbeName($sql);
         $data = Yii::app()->dbr->createCommand($sql)->queryAll();

         $list = array();
         foreach($data as $key =>$value){
             foreach($value as $k =>$v){
                 if($k == 'status') {
                     $list[$key][$k] = Machine::getRunStatus($v);
                 }elseif($k == 'machine_code'){
                     $list[$key][$k] = "\t".$v;
                 }else{
                     $list[$key][$k] = $v;
                 }
                 //加盟商
                 $sql_fr = self::replaceSqlTalbeName("select `code`,`name`,member_id from {gw}.gw_franchisee where id=".$value['franchisee_code']);
                 $franchisee = Yii::app()->dbr->createCommand($sql_fr)->queryRow();
                 $list[$key]['franchisee_code'] = '';
                 $list[$key]['franchisee_name'] = '';
                 $list[$key]['enterprise_code'] = '';
                 $list[$key]['enterprise_name'] = '';
                 if(!empty($franchisee)){
                     $list[$key]['franchisee_code'] = "\t".$franchisee['code'];
                     $list[$key]['franchisee_name'] = $franchisee['name'];
                 }
                 // 企业
                 $sql_en = self::replaceSqlTalbeName("select m.gai_number,e.`name` from {gw}.gw_member as m
            left join {gw}.gw_enterprise as e on e.id=m.enterprise_id
            where m.id=".($franchisee['member_id'] ? $franchisee['member_id'] : 0 )." and m.enterprise_id>0");
                 $enterprise = Yii::app()->dbr->createCommand($sql_en)->queryRow();
                 if(!empty($enterprise)){
                     $list[$key]['enterprise_code'] = $enterprise['gai_number'];
                     $list[$key]['enterprise_name'] = $enterprise['name'];
                 }

                 $sql_fe = self::replaceSqlTalbeName("select count(id) from {gt}.gt_machine_register
            where machine_id=".$value['member_counts']);
                 $list[$key]['member_counts'] = Yii::app()->dbr->createCommand($sql_fe)->queryScalar();
             }
         }

         // 计数器
         $cnt = 0;
         // 每隔$limit行，刷新一下输出buffer，节约资源
         $limit = 10000;
         foreach ($list as $key => $value) {
             $cnt ++;
             if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                 ob_flush();
                 flush();
                 $cnt = 0;
             }
             foreach ($value as $k => $val) {
                 $value[$k]=@iconv("utf-8", "GBK//IGNORE", $val);
             }
             fputcsv($fp,$value);
             unset($value);
         }
         exit;
     }

    const DB_NAME_GAITONG = 'gaitong';
    const DB_NAME_GAIWANG = 'gaiwang';
    const DB_NAME_ACCOUNT = 'account';

    public static function replaceSqlTalbeName($sql){
      $day = '_'.date('ymd');
        return str_replace(array('{gw}','{gt}','{ac}'),
            array(self::DB_NAME_GAIWANG.$day,self::DB_NAME_GAITONG.$day,self::DB_NAME_ACCOUNT.$day),
       //     array(self::DB_NAME_GAIWANG,self::DB_NAME_GAITONG,self::DB_NAME_ACCOUNT),
            $sql);
    }

    public $rep_s = array(',','"',"'","\r\n","\r","\n");
    public $rep_r = array('，','“','‘','','','');


}