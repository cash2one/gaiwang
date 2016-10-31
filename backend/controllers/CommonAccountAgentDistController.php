<?php

class CommonAccountAgentDistController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 代理管理-代理列表
     */
    public function actionAgentList() {
        $model = new Region('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Region']))
            $model->attributes = $_GET['Region'];
        if (!empty($_GET['Region']))
            $model->agent_gai_number = $_GET['Region']['agent_gai_number'];
        $this->showExport = true;
        $this->exportAction = 'agentListExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'commonAccountAgentDist/agentListExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('agentList', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    /**
     * 代理管理-代理列表
     */
    public function actionAgentListExport() {
        $model = new Region('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Region'])) {
            $param = $this->getParam('Region');
            $model->agent_gai_number = $param['agent_gai_number'];
            $model->name = $param['name'];
        }
        @SystemLog::record(Yii::app()->user->name . "导出代理列表");

        $model->isExport = 1;
        $this->render('agentListExport', array(
            'model' => $model,
        ));
    }

    /**
     * 代理管理-代理列表-ajax更新代理
     */
    public function actionAjaxUpdateAgent() {
        if ($this->isAjax()) {
            $id = $this->getQuery('id');
            $gai_number = $this->getQuery('gai_number');
            $region = Region::model()->findByPk($id);
            $result = array(
                'error' => 1,
                'content' => Yii::t('commonAccountAgentDist', '绑定失败'),
            );
            $member = Member::model()->findByAttributes(array('gai_number' => $gai_number));
            //资金池余额
            $Account = CommonAccount::model()->find('city_id=:cid and type=:type', array(':cid' => $id, ':type' => CommonAccount::TYPE_OFF_CITY));
            $balanceRes = AccountBalance::findRecord(
                            array(
                                'account_id' => $Account['id'],
                                'type' => AccountBalance::TYPE_COMMON,
                                'gai_number' => $Account['gai_number']
                            )
            );
            $money = $balanceRes['today_amount'];
            $rs = true;
            if($money){ $rs = AccountFlow::CashPooling($balanceRes,$member);}
            if ($region && $member && $member->enterprise_id > 0 &&$rs) {
                $region->member_id = $member->id;
                if ($region->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "更新代理：" . $id . '|' . $gai_number);
                    $result['error'] = 0;
                    $result['content'] = $region->name . ' ' . Yii::t('commonAccountAgentDist', '绑定代理会员') . '：' . $gai_number . ' ' . Yii::t('commonAccountAgentDist', '成功！');
                    $result['username'] = $member->username;
                    $result['mobile'] = $member->mobile;               
                }
            } else {
                $result['error'] = 1;
                $result['content'] = Yii::t('commonAccountAgentDist', '找不到企业会员') . '：' . $gai_number;
            }
            echo CJSON::encode($result);
        }
        Yii::app()->end();
    }

    /**
     * 代理管理-代理账户列表
     */
    public function actionAgentAccountList() {
        die;
        $model = new CommonAccount();
        $model->unsetAttributes();
        if (isset($_GET['CommonAccount']))
            $model->attributes = $_GET['CommonAccount'];
        $model->type = CommonAccount::TYPE_AGENT;

        $this->showExport = true;
        $this->exportAction = 'agentAccountListExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'commonAccountAgentDist/agentAccountListExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('agentAccountList', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionAgentAccountListExport() {
        $model = new CommonAccount();
        $model->unsetAttributes();
        if (isset($_GET['CommonAccount']))
            $model->attributes = $_GET['CommonAccount'];
        $model->type = CommonAccount::TYPE_AGENT;

        @SystemLog::record(Yii::app()->user->name . "导出代理账户列表");

        $model->isExport = 1;
        $this->render('agentAccountListExport', array(
            'model' => $model,
        ));
    }

    /**
     * 代理金额分配
     */
    public function actionCreate() {
        $id = $this->getQuery('id');
        $model = CommonAccount::model()->findByPk($id);
        $distribute = CommonAccountAgentDist::distribute($model);
        if ($this->isAjax()) {
            $type = $this->getQuery('type');
            $money = $this->getQuery('money', 0);
            if ($type == 'ajax' && $money > 0 && $money <= $model->cash) {
                $rs = CommonAccountAgentDist::getAgentMoney($distribute, $money);
                $rt = array();
                foreach ($rs as $key => $value) {
                    $rt['td_money_' . $key] = $value;
                }
                $result['content'] = $rt;
                $result['error'] = 0;
            } else {
                $result['content'] = Yii::t('commonAccountAgentDist', '金额输入错误！');
                $result['error'] = 1;
            }
            @SystemLog::record(Yii::app()->user->name . "更新代理金额分配：" . $id);
            echo CJSON::encode($result);
            Yii::app()->end();
        }
        $moneyArr = CommonAccountAgentDist::getAgentMoney($distribute, $model->cash);

        $this->render('create', array(
            'model' => $model,
            'distribute' => $distribute,
            'moneyArr' => $moneyArr
        ));
    }

    /**
     * 代理金额分配--处理分配
     */
    public function actionDist() {
        if (isset($_POST['CommonAccount'])) {
            $commonAccount = $this->getPost('CommonAccount');
            $rs = CommonAccountAgentDist::distributeSure($commonAccount['id'], $commonAccount['cash']);
            if ($rs['error'] == 0) {
                @SystemLog::record(Yii::app()->user->name . "处理代理金额分配：" . $commonAccount['id'] . '|' . $commonAccount['cash']);
                $this->setFlash('succeed', $rs);
            } else {
                $this->setFlash('error', $rs['content']);
            }
        }

        $this->redirect(array('agentAccountList'));
    }

    /**
     * Manages all models.
     * 代理管理-代理账户分配金额记录
     */
    public function actionAdmin() {
        $model = new CommonAccountAgentDist('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CommonAccountAgentDist']))
            $model->attributes = $_GET['CommonAccountAgentDist'];

        //配置分页
        $criteria = $model->search();
        $totalCount = CommonAccountAgentDist::model()->count($criteria);
        $pages = new CPagination($totalCount);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $criteria->limit = $pages->pageSize;
        $datas = CommonAccountAgentDist::model()->findAll($criteria);


        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'commonAccountAgentDist/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', array(
            'model' => $model,
            'pages' => $pages,
            'datas' => $datas,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionAdminExport() {
        $model = new CommonAccountAgentDist('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CommonAccountAgentDist']))
            $model->attributes = $_GET['CommonAccountAgentDist'];

        @SystemLog::record(Yii::app()->user->name . "导出代理账户分配金额记录");

        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

    /**
     * 代理管理-代理统计
     */
    public function actionAgentStatistics() {
        die;
        $this->showExport = true;
        $this->exportAction = 'agentDayExcel';

        $this->breadcrumbs = array('代理管理', '代理统计');
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
//        $model = new AgentDay();

        if (isset($_GET['AgentDay'])) {
            $date = $_GET['AgentDay']['statistics_date'];
        } else {
            $date = date('Y-m-d');
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 1;    //当前第几页

        $query_time = strtotime($date);
//        $query_time = 1388937600;
        $agentDayTable = AgentDay::model()->tableName();   //查询对象数据表
        $regionTable = Region::model()->tableName();    //区域表
        $commonAccountTable = CommonAccount::model()->tableName(); //代理余额表
        $accountBalance = "account." . AccountBalance::model()->tableName();

        $sql = "select t.city_id,r.parent_id,r.name,ifnull(SUM(y.debit_today_amount),0) as cash,
        r.depth,r.tree,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money
		from gatewang_statistics.$agentDayTable t 
		left join $commonAccountTable a on a.city_id = t.city_id 
		left join $accountBalance y on (y.account_id = a.id and y.type = " . AccountBalance::TYPE_COMMON . ")
		left join $regionTable r on r.id = t.city_id 
		where t.statistics_date >= $query_time and t.statistics_date <= " . $query_time . "+86399 
		group by r.tree";
//		$sql ="	select q.city_id,r1.parent_id,r1.name,SUM(b.cash) as cash,r1.depth,r1.tree,SUM(q.gai_money) as gai_money,SUM(q.machine_money) as machine_money 
//		from gatewang_statistics.$agentDayTable q 		
//		left join $commonAccountTable b on b.city_id = q.city_id 
//		left join $regionTable r1 on r1.id = q.city_id 
//		where q.statistics_date >= $query_time and q.statistics_date <= ".$query_time."+86399
//	    UNION 
//	    select t.city_id,r.parent_id,r.name,a.cash,r.depth,r.tree,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money
//		from gatewang_statistics.$agentDayTable t 
//		left join $commonAccountTable a on a.city_id = t.city_id 
//		left join $regionTable r on r.id = t.city_id 
//		where t.statistics_date >= $query_time and t.statistics_date <= ".$query_time."+86399 
//		and r.depth <> 0
//		group by r.tree";

        $resultAgentDay = Yii::app()->db->createCommand($sql)->query();

        $criteria = new CDbCriteria();
        //配置分页
        $pages = new CPagination($resultAgentDay->rowCount);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);

        $resultAgentDay = Yii::app()->db->createCommand($sql . " LIMIT :offset ,:limit");
        $resultAgentDay->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $resultAgentDay->bindValue(':limit', $pages->pageSize);

        //得到分页全部数据
        $agentData = $resultAgentDay->queryAll();

        //如果是第一页就单独获取中国的数据(盖网通，盖网，余额)
        if ($agentData) {
            if ($page == 1) {
                $sqlChine = "select SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money,(select SUM(cash) from $commonAccountTable) as cash
							from gatewang_statistics.$agentDayTable  t
							where t.city_id <> 1 
							and t.statistics_date >= $query_time
							and t.statistics_date <= " . $query_time . "+86399;";

                $chineArr = Yii::app()->db->createCommand($sqlChine)->queryRow();
                $agentData['0']['gai_money']+= (double) $chineArr['gai_money'];
                $agentData['0']['machine_money']+= (double) $chineArr['machine_money'];
                $agentData['0']['cash']+= (double) $chineArr['cash'];
            }
        }

        $count = count($agentData);     //获取有本页多少条记录，一般情况下是有10条记录的，但是最后一页可能不是
        $lastProvince = "";      //本页最后一个省id
        $lastCity = "";        //本页最后一个市id
        $lastCityGaiMoney = 0;      //本页最后一个市的盖网金额
        $lastCityMachineMoney = 0;     //本页最后一个市的盖机金额
        $lastCityCash = 0;     //本页最后一个市的余额金额
        //本页最后一条数据的区域类型（省？市？区），如果是省，则需要获取该省下面全部金额数据，然后修改它，如果是市则需要获取市下全部数据然后修改它，同时修改市,是区也要改市和省
        $lastType = isset($agentData[$count - 1]) ? $agentData[$count - 1]['depth'] : "";

        //遍历一下数据
        $dataArr = array();
        foreach ($agentData as $key => $row) {
            $dataArr[$row['city_id']] = $row;
        }
//        echo "本来省有多少".$dataArr[12]['gai_money']."-----".$dataArr[12]['machine_money']."<br/>";
        //重新拼接数据
        foreach ($dataArr as $key => $row) {
            if ($row['depth'] == 0)
                continue;   //如果是全国就直接进行下一次循环

            if ($row['depth'] == 1)
                $lastProvince = $key;

            if ($row['depth'] == 2) {  //市
                $lastCity = $key;
                $lastCityMachineMoney = $row['machine_money'];
                $lastCityGaiMoney = $row['gai_money'];
                $lastCityCash = $row['cash'];
                if (isset($dataArr[$row['parent_id']])) {  //如果存在省上级
                    $provinceid = $row['parent_id'];
//        			echo "市对应省编号：".$provinceid."，金额为".$row['gai_money']."-----".$row['machine_money'];
//        			echo "。相加之前：".$provinceid."，金额为".$dataArr[$provinceid]['gai_money']."-----".$dataArr[$provinceid]['machine_money'];
                    $dataArr[$provinceid]['gai_money']+= (double) $row['gai_money'];
                    $dataArr[$provinceid]['machine_money']+= (double) $row['machine_money'];
                    $dataArr[$provinceid]['cash']+= (double) $row['cash'];
//        			echo "。相加之后变成：".$provinceid."，金额为".$dataArr[$provinceid]['gai_money']."-----".$dataArr[$provinceid]['machine_money']."<br/>";
                }
                continue;
            }

            if ($row['depth'] == 3) {  //区
                if (isset($dataArr[$row['parent_id']])) {
                    $cityid = $row['parent_id'];   //市编号
//        			echo "区对应市编号：".$cityid."，金额为".$row['gai_money']."-----".$row['machine_money'];
//        			echo "。相加之前：".$cityid."，金额为".$dataArr[$cityid]['gai_money']."-----".$dataArr[$cityid]['machine_money'];
                    $dataArr[$cityid]['gai_money']+= (double) $row['gai_money'];
                    $dataArr[$cityid]['machine_money']+= (double) $row['machine_money'];
                    $dataArr[$cityid]['cash']+= (double) $row['cash'];
//        			echo "。相加之后：".$cityid."，金额为".$dataArr[$cityid]['gai_money']."-----".$dataArr[$cityid]['machine_money']."<br/>";

                    $provinceid = $dataArr[$cityid]['parent_id'];   //省编号
                    if (isset($dataArr[$provinceid])) {
//        				echo "区对应市所对应的省编号：".$provinceid."，金额为".$dataArr[$provinceid]['gai_money']."-----".$dataArr[$provinceid]['machine_money'];
//        				echo "。相加之前：".$provinceid."，金额为".$dataArr[$provinceid]['gai_money']."-----".$dataArr[$provinceid]['machine_money'];
                        $dataArr[$provinceid]['gai_money']+= (double) $row['gai_money'];
                        $dataArr[$provinceid]['machine_money']+= (double) $row['machine_money'];
                        $dataArr[$provinceid]['cash']+= (double) $row['cash'];
//        				echo "。相加之后：".$provinceid."，金额为".$dataArr[$provinceid]['gai_money']."-----".$dataArr[$provinceid]['machine_money']."<br/>";
                    }
                }
            }
        }
//         echo "重新拼接数据后有".$dataArr[12]['gai_money']."-----".$dataArr[12]['machine_money']."<br/>";
        //根据最后一条数据的类型
        switch ($lastType) {
            case 1:    //省，获取省内所有金额总和
                if (isset($dataArr[$lastProvince])) {
                    $sqlProvince = "select t.city_id,ifnull(SUM(y.debit_today_amount),0) as cash,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money 
						from gatewang_statistics.gw_agent_day t 
						left join gw_common_account a on a.city_id = t.city_id 
						left join $accountBalance y on (y.account_id = a.id and y.type = " . AccountBalance::TYPE_COMMON . ")
						left join gw_region r on r.id = t.city_id 
						where t.statistics_date >= $query_time 
						and t.statistics_date <= " . $query_time . "+86399 
						and r.parent_id = $lastProvince
						group by t.city_id";
                    $provinceArr = Yii::app()->db->createCommand($sqlProvince)->queryAll();

                    $query_cityid = "";
                    foreach ($provinceArr as $key => $val) {   //将省下面市的金额加上去省
                        $query_cityid.= $query_cityid == "" ? $val['city_id'] : "," . $val['city_id'];
                        $dataArr[$lastProvince]['gai_money']+= (double) $val['gai_money'];
                        $dataArr[$lastProvince]['machine_money']+= (double) $val['machine_money'];
                        $dataArr[$lastProvince]['cash']+= (double) $val['cash'];
                    }

                    if ($query_cityid != "") {
                        $sqlCity = "select t.city_id,ifnull(SUM(y.debit_today_amount),0) as cash,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money 
							from gatewang_statistics.gw_agent_day t 
							left join gw_common_account a on a.city_id = t.city_id 
							left join $accountBalance y on (y.account_id = a.id and y.type = " . AccountBalance::TYPE_COMMON . ")
							left join gw_region r on r.id = t.city_id 
							where t.statistics_date >= $query_time 
							and t.statistics_date <= " . $query_time . "+86399 
							and r.parent_id in ($query_cityid)
							group by t.city_id";

                        $cityArr = Yii::app()->db->createCommand($sqlCity)->queryAll();

                        foreach ($cityArr as $key => $val) {
                            $dataArr[$lastProvince]['gai_money']+= (double) $val['gai_money'];
                            $dataArr[$lastProvince]['machine_money']+= (double) $val['machine_money'];
                            $dataArr[$lastProvince]['cash']+= (double) $val['cash'];
                        }
                    }
                }

                break;
            case 2:    //市
                if (isset($dataArr[$lastCity])) {
                    $sqlCity = "select t.city_id,ifnull(SUM(y.debit_today_amount),0) as cash,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money 
							from gatewang_statistics.gw_agent_day t 
							left join gw_common_account a on a.city_id = t.city_id 
							left join $accountBalance y on (y.account_id = a.id and y.type = " . AccountBalance::TYPE_COMMON . ")
							left join gw_region r on r.id = t.city_id 
							where t.statistics_date >= $query_time 
							and t.statistics_date <= " . $query_time . "+86399 
							and r.parent_id = $lastCity
							group by t.city_id";

                    $cityArr = Yii::app()->db->createCommand($sqlCity)->queryAll();

                    $cityGaiMoney = $dataArr[$lastCity]['gai_money'];
                    $cityMachineMoney = $dataArr[$lastCity]['machine_money'];
                    $cityCash = $dataArr[$lastCity]['cash'];

                    $dataArr[$lastCity]['gai_money'] = $lastCityGaiMoney;
                    $dataArr[$lastCity]['machine_money'] = $lastCityMachineMoney;
                    $dataArr[$lastCity]['cash'] = $lastCityCash;
                    $provinceid = $dataArr[$lastCity]['parent_id'];

                    foreach ($cityArr as $key => $val) {
                        $dataArr[$lastCity]['gai_money']+= (double) $val['gai_money'];
                        $dataArr[$lastCity]['machine_money']+= (double) $val['machine_money'];
                        $dataArr[$lastCity]['cash']+= (double) $val['cash'];
                    }

                    if (isset($dataArr[$provinceid])) {
                        $dataArr[$provinceid]['gai_money'] = $dataArr[$provinceid]['gai_money'] - $cityGaiMoney;
                        $dataArr[$provinceid]['machine_money'] = $dataArr[$provinceid]['machine_money'] - $cityMachineMoney;
                        $dataArr[$provinceid]['cash'] = $dataArr[$provinceid]['cash'] - $cityCash;

                        $dataArr[$provinceid]['gai_money'] += $dataArr[$lastCity]['gai_money'];
                        $dataArr[$provinceid]['machine_money'] += $dataArr[$lastCity]['machine_money'];
                        $dataArr[$provinceid]['cash'] += $dataArr[$lastCity]['cash'];
                    }
                }
                break;
            case 3:    //区
                if ($lastCity != "") {
                    if (isset($dataArr[$lastCity])) {   //判断单页显示数据中存不存在这个市
                        $sqlCity = "select t.city_id,ifnull(SUM(y.debit_today_amount),0) as cash,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money 
								from gatewang_statistics.gw_agent_day t 
								left join gw_common_account a on a.city_id = t.city_id 
								left join $accountBalance y on (y.account_id = a.id and y.type = " . AccountBalance::TYPE_COMMON . ")
								left join gw_region r on r.id = t.city_id 
								where t.statistics_date >= $query_time 
								and t.statistics_date <= " . $query_time . "+86399 
								and r.parent_id = $lastCity
								group by t.city_id";

                        $cityArr = Yii::app()->db->createCommand($sqlCity)->queryAll();   //获取该市的所有区的金额数据

                        $provinceid = $dataArr[$lastCity]['parent_id'];       //获取该市对应的省的编号
//	        			echo "重新赋值前市：".$dataArr[$lastCity]['gai_money']."----".$dataArr[$lastCity]['machine_money']."<br/>";
                        $cityGaiMoney = $dataArr[$lastCity]['gai_money'];
                        $cityMachineMoney = $dataArr[$lastCity]['machine_money'];
                        $cityCash = $dataArr[$lastCity]['cash'];

                        $dataArr[$lastCity]['gai_money'] = $lastCityGaiMoney;         //将该市盖网金额清0
                        $dataArr[$lastCity]['machine_money'] = $lastCityMachineMoney;        //将该市盖机金额清0
                        $dataArr[$lastCity]['cash'] = $lastCityCash;          //将该市余额金额清0

                        foreach ($cityArr as $key => $val) {          //循环对该市重新进行金额赋值
                            $dataArr[$lastCity]['gai_money']+= (double) $val['gai_money'];
                            $dataArr[$lastCity]['machine_money']+= (double) $val['machine_money'];
                            $dataArr[$lastCity]['cash']+= (double) $val['cash'];
                        }

//	        			echo "重新赋值后市：".$dataArr[$lastCity]['gai_money']."--------".$dataArr[$lastCity]['machine_money']."<br/>";

                        if (isset($dataArr[$provinceid])) {
//		        			echo "重新赋值前省：".$dataArr[$provinceid]['gai_money']."--------".$dataArr[$provinceid]['machine_money']."<br/>";
                            //先将省中之前保存的该市的金额减去
                            $dataArr[$provinceid]['gai_money'] = $dataArr[$provinceid]['gai_money'] - $cityGaiMoney;
                            $dataArr[$provinceid]['machine_money'] = $dataArr[$provinceid]['machine_money'] - $cityMachineMoney;
                            $dataArr[$provinceid]['cash'] = $dataArr[$provinceid]['cash'] - $cityCash;
//			        		echo "减去市金额后：".$dataArr[$provinceid]['gai_money']."--------".$dataArr[$provinceid]['machine_money']."<br/>";
                            //然后加上现在该市的金额
                            $dataArr[$provinceid]['gai_money'] += $dataArr[$lastCity]['gai_money'];
                            $dataArr[$provinceid]['machine_money'] += $dataArr[$lastCity]['machine_money'];
                            $dataArr[$provinceid]['cash'] += $dataArr[$lastCity]['cash'];
//		        			echo "重新赋值前省：".$dataArr[$provinceid]['gai_money']."--------".$dataArr[$provinceid]['machine_money']."<br/>";
                        }
                    }
                }
                break;
        }


//        $model->statistics_date = $date;
        $weekDay = $weekarray[date("w", strtotime($date))];

        $this->render('agentStatistics', array('data' => $dataArr, 'pages' => $pages, 'weekDay' => $weekDay, 'date' => $date,));

//        $this->render('agentStatistics', array(
//            'model' => $model,
//            'date' => $date,
//            'weekDay' => $weekDay,
//            )
//        );
    }

    /**
     * 代理管理->代理统计->导出exce
     */
    public function actionAgentDayExcel() {
        @SystemLog::record(Yii::app()->user->name . "导出代理统计记录");

        $query_time = strtotime($_GET['date']);
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        //Yii::$enableIncludePath = false;    
        Yii::import('comext.phpexcel.*');


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
                ->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

//        $commonAcountTabel = CommonAccount::model()->tableName();
//        $sql = "select t.gai_money,t.machine_money,a.name,a.cash 
//        from gatewang_statistics.gw_agent_day t 
//        left join $commonAcountTabel a on a.city_id = t.city_id
//        where t.statistics_date >= " . strtotime($_GET['date']) . " 
//        and t.statistics_date <= (" . strtotime($_GET['date']) . "+86399)";

        $agentDayTable = AgentDay::model()->tableName();   //查询对象数据表
        $regionTable = Region::model()->tableName();    //区域表
        $commonAccountTable = CommonAccount::model()->tableName(); //代理余额表
//        Tool::pr($query_time);
        $sql = "select t.city_id,r.parent_id,r.name,SUM(a.cash) as cash,r.depth,r.tree,SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money
		from gatewang_statistics.$agentDayTable t 
		left join $commonAccountTable a on a.city_id = t.city_id 
		left join $regionTable r on r.id = t.city_id 
		where t.statistics_date >= $query_time and t.statistics_date <= " . $query_time . "+86399 
		group by r.tree";
        $agentData = Yii::app()->db->createCommand($sql)->queryAll();

        if ($agentData) {
            $sqlChine = "select SUM(t.gai_money) as gai_money,SUM(t.machine_money) as machine_money,(select SUM(cash) from $commonAccountTable) as cash
							from gatewang_statistics.$agentDayTable  t
							where t.city_id <> 1 
							and t.statistics_date >= $query_time
							and t.statistics_date <= " . $query_time . "+86399;";

            $chineArr = Yii::app()->db->createCommand($sqlChine)->queryRow();
            $agentData['0']['gai_money']+= (double) $chineArr['gai_money'];
            $agentData['0']['machine_money']+= (double) $chineArr['machine_money'];
            $agentData['0']['cash']+= (double) $chineArr['cash'];
        }

        //遍历一下数据
        $data = array();
        foreach ($agentData as $row) {
            $data[$row['city_id']] = $row;
        }

        //重新拼接数据
        foreach ($data as $key => $row) {
            if ($row['depth'] == 0)
                continue;   //如果是全国就直接进行下一次循环
            if ($row['depth'] == 2) {  //市
                if (isset($data[$row['parent_id']])) {  //如果存在省上级
                    $provinceid = $row['parent_id'];
                    $data[$provinceid]['gai_money']+= (double) $row['gai_money'];
                    $data[$provinceid]['machine_money']+= (double) $row['machine_money'];
                    $data[$provinceid]['cash']+= (double) $row['cash'];
                }
                continue;
            }

            if ($row['depth'] == 3) {  //区
                if (isset($data[$row['parent_id']])) {
                    $cityid = $row['parent_id'];   //市编号
                    $data[$cityid]['gai_money']+= (double) $row['gai_money'];
                    $data[$cityid]['machine_money']+= (double) $row['machine_money'];
                    $data[$cityid]['cash']+= (double) $row['cash'];

                    $provinceid = $data[$cityid]['parent_id'];   //省编号
                    if (isset($data[$provinceid])) {
                        $data[$provinceid]['gai_money']+= (double) $row['gai_money'];
                        $data[$provinceid]['machine_money']+= (double) $row['machine_money'];
                        $data[$provinceid]['cash']+= (double) $row['cash'];
                    }
                }
            }
        }

//        $data = Yii::app()->db->createCommand($sql)->queryAll();
        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '账户')
                ->setCellValue('B1', '盖网通（元）')
                ->setCellValue('C1', '盖网（元）')
                ->setCellValue('D1', '合计（元）')
                ->setCellValue('E1', '余额（元）');

        $num = 1;
        foreach ($data as $key => $row) {
            $num++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $num, $row['name'])
                    ->setCellValue('B' . $num, $row['machine_money'])
                    ->setCellValue('C' . $num, $row['gai_money'])
                    ->setCellValue('D' . $num, $row['machine_money'] + $row['gai_money'])
                    ->setCellValue('E' . $num, $row['cash']);
        }


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle("代理进账明细");

        $name = date('YmdHis' . rand(0, 99999));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /*
     * 代理管理-代理列表-ajax移除代理
     */

    public function actionRemoveAgent() {
        if ($this->isAjax()) {
            $id = $this->getQuery('id');
            $region = Region::model()->tableName();
            $sqlMember = "select member_id from $region where id=$id";
            $member_id = Yii::app()->db->createCommand($sqlMember)->queryScalar();
            $result = array(
                'error' => 1,
                'content' => Yii::t('commonAccountAgentDist', ''),
            );
            if ($member_id) {
                $sql = "update $region set member_id = 0 where id=$id";
                $row = Yii::app()->db->createCommand($sql)->execute();
                if ($row) {
                    @SystemLog::record(Yii::app()->user->name . "移除代理：" . $id);
                    $result['error'] = 0;
                    $result['content'] = '移除成功';
                } else {
                    $result['error'] = 1;
                    $result['content'] = '移除失败';
                }
            } else {
                $result['error'] = 1;
                $result['content'] = '没有绑定代理数据';
            }
            echo CJSON::encode($result);
        }
        Yii::app()->end();
    }

}
