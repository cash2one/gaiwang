<?php

/**
 * 代理概况
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class GwdetailController extends Controller {

    /**
     * 和页面显示有关
     * Enter description here ...
     * @param unknown_type $name
     */
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '代理概况');
    }

    /**
     * 盖网机概况
     */
    public function actionMachineDetail() {
        //地区，加盟商名称，盖机数量
        //根据登陆人的编号，去商城里面的地区表里面查询出来对应的区域，然后根据区域查询出出对应的盖机数量和盖机加盟商
        //地图级别depth  目前有0,1,2,3这个几个级别
        //如果是0表示最高级别，1表示省级，2表示市级，3表示区级
        //1.得到代理员所能够得到的权限区域,可能一个，可能多个，可能只是上下从级，可能幷级
        $areaTableName = Region::model()->tableName();
        $areaArr = $this->getSession('agent_region');
        $districtId = "";
        $treeSql = "(";
        foreach ($areaArr as $key => $row) {
            if ($row['depth'] == '3') { //区
                $districtId.= $districtId == "" ? $row['id'] : "," . $row['id'];
            } else {
                $treeSql .= $treeSql == "(" ? "tree like '" . $row['tree'] . "|%'" : " or tree like '" . $row['tree'] . "|%'";
            }

            switch ($row['depth']) {
                case '1':  //省
                    $name[] = $row['name'];
                    break;
                case '2':  //市
                    $tmpArr = explode("|", $row['tree']);
                    $provinceName = Yii::app()->db->createCommand()
                            ->select('name')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[1])
                            ->queryRow();
                    $name[] = $provinceName['name'] . " " . $row['name'];
                    break;
                case '3':  //区
                    $tmpArr = explode("|", $row['tree']);
                    $cityName = Yii::app()->db->createCommand()
                            ->select('name,parent_id')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[2])
                            ->queryRow();
                    $provinceName = Yii::app()->db->createCommand()
                            ->select('name')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[1])
                            ->queryRow();
                    $name[] = $provinceName['name'] . " " . $cityName['name'] . " " . $row['name'];
                    break;
            }
        }
        $treeSql.= ")";

        if ($treeSql != "()") {
            $sqlDistrict = "select id from $areaTableName where $treeSql and depth = 3";
            $districtIdArr = Yii::app()->db->createCommand($sqlDistrict)->queryAll();
            $districtIdStr = "";

            foreach ($districtIdArr as $row) {
                $districtIdStr.= $districtIdStr == "" ? $row['id'] : "," . $row['id'];
            }

            $districtId.= $districtId == "" ? $districtIdStr : "," . $districtIdStr;
        }

        if ($districtId != "") {
            $tmpArr = explode(",", $districtId);
            $tmpDis = array_unique($tmpArr);
            $districtId = implode(",", $tmpDis);
        } else {
            $districtId = "''";
        }

        //2.得到权限区域所对应的加盟商和盖机数据
        $bizTableName = Franchisee::model()->tableName();
        $sqlData = "select t.id,t.name,t.province_id,t.city_id,t.district_id,count(m.id) as num from " . $bizTableName . " t 
		left join $areaTableName a on a.id = t.province_id 
		LEFT JOIN gaitong.gt_machine m on m.biz_info_id = t.id and m.status = " . MachineAgent::STATUS_ENABLE . " 
		where  t.district_id in (" . $districtId . ")
		group by t.id";

        $resultBiz = Yii::app()->db->createCommand($sqlData)->query();

        $criteria = new CDbCriteria();
        //配置分页
        $pages = new CPagination($resultBiz->rowCount);
        $pages->pageSize = 8;
        $pages->applyLimit($criteria);

        $resultBiz = Yii::app()->db->createCommand($sqlData . " LIMIT :offset ,:limit");
        $resultBiz->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $resultBiz->bindValue(':limit', $pages->pageSize);

        $areares = Yii::app()->db->createCommand()->select('id,name')->from($areaTableName)->queryAll();
        $refArr = array();
        foreach ($areares as $row) {
            $refArr[$row['id']] = $row['name'];
        }

        $bizData = $resultBiz->queryAll();
        $this->render('machine', array('pages' => $pages, 'addressName' => $name, 'data' => $bizData, 'refArr' => $refArr));
    }

    /**
     * 会员数量概况
     */
    public function actionMemberCountDetail() {
        //1.得到登陆人所拥有的全部的区域数据
        $areaTableName = Region::model()->tableName();
        $areaArr = $this->getSession('agent_region');
        $districtId = "";
        $treeSql = "(";
        foreach ($areaArr as $key => $row) {
            if ($row['depth'] == '3') { //区
                $districtId.= $districtId == "" ? $row['id'] : "," . $row['id'];
            } else {
                $treeSql .= $treeSql == "(" ? "tree like '" . $row['tree'] . "|%'" : " or tree like '" . $row['tree'] . "|%'";
            }

            switch ($row['depth']) {
                case '1':  //省
                    $name[] = $row['name'];
                    break;
                case '2':  //市
                    $tmpArr = explode("|", $row['tree']);
                    $provinceName = Yii::app()->db->createCommand()
                            ->select('name')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[1])
                            ->queryRow();
                    $name[] = $provinceName['name'] . " " . $row['name'];
                    break;
                case '3':  //区
                    $tmpArr = explode("|", $row['tree']);
                    $cityName = Yii::app()->db->createCommand()
                            ->select('name,parent_id')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[2])
                            ->queryRow();
                    $provinceName = Yii::app()->db->createCommand()
                            ->select('name')
                            ->from($areaTableName)
                            ->where('id = :id')
                            ->bindValue(':id', $tmpArr[1])
                            ->queryRow();
                    $name[] = $provinceName['name'] . " " . $cityName['name'] . " " . $row['name'];
                    break;
            }
        }
        $treeSql.= ")";

        if ($treeSql != "()") {
            $sqlDistrict = "select id from $areaTableName where $treeSql and depth = 3";
            $districtIdArr = Yii::app()->db->createCommand($sqlDistrict)->queryAll();
            $districtIdStr = "";
            foreach ($districtIdArr as $row) {
                $districtIdStr.= $districtIdStr == "" ? $row['id'] : "," . $row['id'];
            }
            $districtId.= $districtId == "" ? $districtIdStr : "," . $districtIdStr;
        }

        if ($districtId != "") {
            $tmpArr = explode(",", $districtId);
            $tmpDis = array_unique($tmpArr);
            $districtId = implode(",", $tmpDis);
        } else {
            $districtId = "''";
        }

        $param = MemberType::fileCache();
        $officialType = $param['officialType'];      //正式会员
        $defaultType = $param['defaultType'];      //消费会员
        //3.得到权限区域所对应的会员数据信息
        $memberTableName = MemberAgent::model()->tableName();

        //企业会员和非企业会员
        $isstore = Member::ENTERPRISE_YES;
        $nostore = Member::ENTERPRISE_NO;

        $sqlData = "select t.id,t.tree
		from $areaTableName t 
		where t.id in ($districtId)";
        $resultMember = Yii::app()->db->createCommand($sqlData)->query();

        $criteria = new CDbCriteria();
        //配置分页
        $pages = new CPagination($resultMember->rowCount);
        $pages->pageSize = 8;
        $pages->applyLimit($criteria);

        $resultMember = Yii::app()->db->createCommand($sqlData . " LIMIT :offset ,:limit");
        $resultMember->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $resultMember->bindValue(':limit', $pages->pageSize);

        $memberData = $resultMember->queryAll();

        $tmpid = "";
        foreach ($memberData as $rowMember) {
            $tmpid.= $tmpid == "" ? $rowMember['id'] : "," . $rowMember['id'];
        }

        //中转
        $sqlTmp = "select count(1) as num,enterprise_id,type_id,district_id from $memberTableName where district_id in ($tmpid) group by enterprise_id,type_id,district_id";
        $tmpData = Yii::app()->db->createCommand($sqlTmp)->queryAll();

        $rowData = array();
        foreach ($tmpData as $rowTmp) {
            if (isset($rowData[$rowTmp['district_id']])) {  //如果已经存在改区的数据了
                $tmp = $rowData[$rowTmp['district_id']];
                $tmp['defaultNum']+= $rowTmp['type_id'] == $defaultType && $rowTmp['enterprise_id'] == $nostore ? $rowTmp['num'] : 0;
                $tmp['defaultComNum']+= $rowTmp['type_id'] == $officialType && $rowTmp['enterprise_id'] == $nostore ? $rowTmp['num'] : 0;
                $tmp['officialNum']+= $rowTmp['type_id'] == $defaultType && $rowTmp['enterprise_id'] == $isstore ? $rowTmp['num'] : 0;
                $tmp['officialComNum']+= $rowTmp['type_id'] == $officialType && $rowTmp['enterprise_id'] == $isstore ? $rowTmp['num'] : 0;
            } else {
                $rowData[$rowTmp['district_id']] = array(
                    'defaultNum' => $rowTmp['type_id'] == $defaultType && $rowTmp['enterprise_id'] == $nostore ? $rowTmp['num'] : 0,
                    'defaultComNum' => $rowTmp['type_id'] == $officialType && $rowTmp['enterprise_id'] == $nostore ? $rowTmp['num'] : 0,
                    'officialNum' => $rowTmp['type_id'] == $defaultType && $rowTmp['enterprise_id'] == $isstore ? $rowTmp['num'] : 0,
                    'officialComNum' => $rowTmp['type_id'] == $officialType && $rowTmp['enterprise_id'] == $isstore ? $rowTmp['num'] : 0,
                );
            }
        }

        $areares = Yii::app()->db->createCommand()->select('id,name')->from($areaTableName)->queryAll();
        $refArr = array();
        foreach ($areares as $row) {
            $refArr[$row['id']] = $row['name'];
        }

        $this->render('member', array('pages' => $pages, 'addressName' => $name, 'data' => $memberData, 'refArr' => $refArr, 'tmpArr' => $rowData));
    }

    /**
     * 代理进账明细
     */
    public function actionAccountDetail() {
        $model = new AccountFlow();
        if (isset($_GET['AccountFlow'])) {
            $dataArray = $this->getQuery('AccountFlow');
            $model->create_time = $dataArray['create_time'];
            $model->endTime = $dataArray['endTime'];
        }

        $this->render('account', array(
            'model' => $model,
        ));
    }

    public function actionExportExcel() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        // date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        Yii::import('comext.PHPExcel.*');


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
                ->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $create_time = $this->getQuery('createtime');
        $end_time = $this->getQuery('endtime');

        $timeSql = "";
        if ($create_time != "" || $end_time != "") {
            $end_time = $end_time == "" ? time() : strtotime($end_time)+86399;
            $create_time = $create_time == "" ? 0 : strtotime($create_time);
            $timeSql = " and create_time between :create_time and :end_time ";
        } else {
            $create_time = strtotime(date('Y-m-d'));
            $timeSql = " and create_time >= :create_time";
        }

        $userid = $this->getUser()->getId();
        $now = strtotime(date('Y-m-d'));      //当前时间
        $monthTable = AccountFlow::monthTable();      //当月表
        $memberTable = AccountFlow::hashTable(Yii::app()->user->gw); //会员流水表

        $sql = 'SELECT * FROM (
            SELECT
                *
            FROM
                ' . $monthTable . '
            WHERE
                account_id = :account_id ' . $timeSql . ' 
            AND type = :type1  
            UNION ALL
                SELECT
                    *
                FROM
                    ' . $memberTable . '
                WHERE
                    account_id = :account_id ' . $timeSql . ' 
                AND type = :type2) a ORDER BY create_time DESC';


        if ($create_time != "" || $end_time != "") {
            $data = Yii::app()->db->createCommand($sql)->bindValues(array(
                        ':account_id' => $userid,
                        ':create_time' => $create_time,
                        ':end_time' => $end_time,
                        ':type1' => AccountFlow::TYPE_AGENT,
                        ':account_id' => $userid,
                        ':type2' => AccountFlow::TYPE_AGENT,
                    ))->queryAll();
        } else {
            $data = Yii::app()->db->createCommand($sql)->bindValues(array(
                        ':account_id' => $userid,
                        ':create_time' => $create_time,
                        ':type1' => AccountFlow::TYPE_AGENT,
                        ':account_id' => $userid,
                        ':type2' => AccountFlow::TYPE_AGENT,
                    ))->queryAll();
        }
        
        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '账单时间')
                ->setCellValue('B1', '金额')
                ->setCellValue('C1', '积分')
                ->setCellValue('D1', '备注');

        $num = 1;
        foreach ($data as $key => $row) {
            $num++;
            $score = $row['ratio'] == 0 ? 0 : IntegralOfflineNew::getNumberFormat($row['credit_amount'] / $row['ratio']);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $num, date('Y-m-d H:i:s', $row['create_time']))
                    ->setCellValue('B' . $num, $row['credit_amount'])
                    ->setCellValue('C' . $num, $score)
                    ->setCellValue('D' . $num, $row['remark']);
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

}
