<?php

/**
 * 金蝶报表导出
 */
class KingdeeCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        @ini_set('memory_limit', '2048M');
        Yii::import('comext.PHPexcel.*');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('凭证');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '公司')
            ->setCellValue('B1', '记账日期')
            ->setCellValue('C1', '业务日期')
            ->setCellValue('D1', '会计期间')
            ->setCellValue('E1', '凭证类型')
            ->setCellValue('F1', '凭证号')
            ->setCellValue('G1', '分录号')
            ->setCellValue('H1', '摘要')
            ->setCellValue('I1', '科目')
            ->setCellValue('J1', '币种')
            ->setCellValue('K1', '汇率')
            ->setCellValue('L1', '方向')
            ->setCellValue('M1', '原币金额')
            ->setCellValue('N1', '数量')
            ->setCellValue('O1', '单价')
            ->setCellValue('P1', '借方金额')
            ->setCellValue('Q1', '贷方金额')
            ->setCellValue('R1', '制单人')
            ->setCellValue('S1', '过账人')
            ->setCellValue('T1', '审核人')
            ->setCellValue('U1', '附件数量')
            ->setCellValue('V1', '过账标记')
            ->setCellValue('W1', '机制凭证模块')
            ->setCellValue('X1', '删除标记')
            ->setCellValue('Y1', '凭证序号')
            ->setCellValue('Z1', '单位')
            ->setCellValue('AA1', '参考信息')
            ->setCellValue('AB1', '是否有现金流量')
            ->setCellValue('AC1', '现金流量标记')
            ->setCellValue('AD1', '业务编号')
            ->setCellValue('AE1', '结算方式')
            ->setCellValue('AF1', '结算号')
            ->setCellValue('AG1', '辅助账摘要')
            ->setCellValue('AH1', '核算项目1')
            ->setCellValue('AI1', '编码1')
            ->setCellValue('AJ1', '名称1')
            ->setCellValue('AK1', '核算项目2')
            ->setCellValue('AL1', '编码2')
            ->setCellValue('AM1', '名称2')
            ->setCellValue('AN1', '核算项目3')
            ->setCellValue('AO1', '编码3')
            ->setCellValue('AP1', '名称3')
            ->setCellValue('AQ1', '核算项目4')
            ->setCellValue('AR1', '编码4')
            ->setCellValue('AS1', '名称4')
            ->setCellValue('AT1', '核算项目5')
            ->setCellValue('AU1', '编码5')
            ->setCellValue('AV1', '名称5')
            ->setCellValue('AW1', '核算项目6')
            ->setCellValue('AX1', '编码6')
            ->setCellValue('AY1', '名称6')
            ->setCellValue('AZ1', '核算项目7')
            ->setCellValue('BA1', '编码7')
            ->setCellValue('BB1', '名称7')
            ->setCellValue('BC1', '核算项目8')
            ->setCellValue('BD1', '编码8')
            ->setCellValue('BE1', '名称8')
            ->setCellValue('BF1', '发票号')
            ->setCellValue('BG1', '换票证号')
            ->setCellValue('BH1', '客户')
            ->setCellValue('BI1', '费用类别')
            ->setCellValue('BJ1', '收款人')
            ->setCellValue('BK1', '物料')
            ->setCellValue('BL1', '财务组织')
            ->setCellValue('BM1', '供应商')
            ->setCellValue('BN1', '辅助账业务日期')
            ->setCellValue('BO1', '到期日');


        $sql = "select a.id,d.gai_number as f_gai_number,c.name as f_name,e.gai_number,e.username,a.spend_money,a.distribute_money,a.create_time,sum(b.credit_amount) as credit_amount from gw_franchisee_consumption_record a
	left join gw_account_flow b on (b.serial_number=a.serial_number and b.owner_type=1) 
	LEFT JOIN gw_franchisee c on c.id=a.franchisee_id 
	left join gw_member d on d.id=c.member_id 
	left join gw_member e on e.id=a.member_id 
	where a.is_distributed=1 and a.serial_number != '' and a.create_time>=1388505600 
	group by id,f_gai_number,f_name,gai_number,username,spend_money,distribute_money,create_time";
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        $key = 1;
        if (!empty($res)) foreach ($res as $val) {
            $date = date('Y-m-d', $val['create_time']);
            //供货价+利润
            $direction = '1';
            $data[$key]['date'] = $date;
            $data[$key]['class'] = '1221.03.02';
            $data[$key]['key'] = $key;
            $data[$key]['price'] = $val['spend_money'] - $val['credit_amount'];
            $data[$key]['debtor_price'] = $val['spend_money'] - $val['credit_amount']; //借方
            $data[$key]['credit_price'] = ''; //贷方
            $data[$key]['digest'] = '交易'; //辅助账摘要
            $data[$key]['d'] = '1'; //方向
            $data[$key]['item'] = '客户'; //项目
            $data[$key]['code'] = '007'; //编码
            $data[$key]['name'] = '珠海横琴新区盖网投资管理有限公司'; //名称
            //
            //利润
            $key++;
            $direction = '0';
            $data[$key]['date'] = $date;
            $data[$key]['class'] = '2241.04';
            $data[$key]['key'] = $key;
            $data[$key]['price'] = $val['distribute_money'] - $val['credit_amount'];
            $data[$key]['debtor_price'] = ''; //借方
            $data[$key]['credit_price'] = $val['distribute_money'] - $val['credit_amount']; //贷方
            $data[$key]['digest'] = ''; //辅助账摘要
            $data[$key]['d'] = '0'; //方向
            $data[$key]['item'] = ''; //项目
            $data[$key]['code'] = ''; //编码
            $data[$key]['name'] = ''; //名称

            //供货价
            $key++;
            $direction = '0';
            $data[$key]['date'] = $date;
            $data[$key]['class'] = '2241.03.02';
            $data[$key]['key'] = $key;
            $data[$key]['price'] = $val['spend_money'] - $val['distribute_money'];
            $data[$key]['debtor_price'] = ''; //借方
            $data[$key]['credit_price'] = $val['spend_money'] - $val['distribute_money']; //贷方
            $data[$key]['digest'] = '交易'; //辅助账摘要
            $data[$key]['d'] = '0'; //方向
            $data[$key]['item'] = '供应商'; //项目
            $data[$key]['code'] = $val['gai_number']; //编码
            $data[$key]['name'] = $val['username']; //名称
            $key++;
        }

        $i = 2;
        foreach ($data as $key => $v) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, '004')
                ->setCellValue('B' . $i, $v['date'])
                ->setCellValue('C' . $i, $v['date'])
                ->setCellValue('D' . $i, date('m', $val['create_time']))
                ->setCellValue('E' . $i, '记')
                ->setCellValue('F' . $i, '0001')
                ->setCellValue('G' . $i, $key)
                ->setCellValue('H' . $i, '交易')
                ->setCellValue('I' . $i, $v['class'])
                ->setCellValue('J' . $i, 'BB01')
                ->setCellValue('K' . $i, '1')
                ->setCellValue('L' . $i, $v['d'])
                ->setCellValue('M' . $i, $v['price'])
                ->setCellValue('N' . $i, 0)
                ->setCellValue('O' . $i, 0)
                ->setCellValue('P' . $i, $v['debtor_price'])
                ->setCellValue('Q' . $i, $v['credit_price'])
                ->setCellValue('R' . $i, 'user')
                ->setCellValue('S' . $i, '')
                ->setCellValue('T' . $i, '')
                ->setCellValue('U' . $i, 0) //附件数量
                ->setCellValue('V' . $i, 'FALSE')
                ->setCellValue('W' . $i, '')
                ->setCellValue('X' . $i, 'FALSE')
                ->setCellValue('Y' . $i, '')
                ->setCellValue('Z' . $i, '')
                ->setCellValue('AA' . $i, '')
                ->setCellValue('AB' . $i, '')
                ->setCellValue('AC' . $i, 5)
                ->setCellValue('AD' . $i, '')
                ->setCellValue('AE' . $i, '')
                ->setCellValue('AF' . $i, '')
                ->setCellValue('AG' . $i, $v['digest'])
                ->setCellValue('AH' . $i, $v['item'])
                ->setCellValue('AI' . $i, $v['code'])
                ->setCellValue('AJ' . $i, $v['name'])
                ->setCellValue('AK' . $i, '')
                ->setCellValue('AL' . $i, '')
                ->setCellValue('AM' . $i, '')
                ->setCellValue('AN' . $i, '')
                ->setCellValue('AO' . $i, '')
                ->setCellValue('AP' . $i, '')
                ->setCellValue('AQ' . $i, '')
                ->setCellValue('AR' . $i, '')
                ->setCellValue('AS' . $i, '')
                ->setCellValue('AT' . $i, '')
                ->setCellValue('AU' . $i, '')
                ->setCellValue('AV' . $i, '')
                ->setCellValue('AW' . $i, '')
                ->setCellValue('AX' . $i, '')
                ->setCellValue('AY' . $i, '')
                ->setCellValue('AZ' . $i, '')
                ->setCellValue('BA' . $i, '')
                ->setCellValue('BB' . $i, '')
                ->setCellValue('BC' . $i, '')
                ->setCellValue('BD' . $i, '')
                ->setCellValue('BE' . $i, '')
                ->setCellValue('BF' . $i, '')
                ->setCellValue('BG' . $i, '')
                ->setCellValue('BH' . $i, '')
                ->setCellValue('BI' . $i, '')
                ->setCellValue('BJ' . $i, '')
                ->setCellValue('Bk' . $i, '')
                ->setCellValue('BL' . $i, '')
                ->setCellValue('BM' . $i, '')
                ->setCellValue('BN' . $i, '')
                ->setCellValue('BO' . $i, $v['date']);
            $i++;
        }


        $objPHPExcel->createSheet();
        $objPHPExcel->setactivesheetindex(1);
        $objPHPExcel->getActiveSheet()->setTitle('现金流量');


        $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', '公司')
            ->setCellValue('B1', '记账日期')
            ->setCellValue('C1', '会计期间')
            ->setCellValue('D1', '凭证类型')
            ->setCellValue('E1', '凭证号')
            ->setCellValue('F1', '币种')
            ->setCellValue('G1', '分录号')
            ->setCellValue('H1', '对方分录号')
            ->setCellValue('I1', '主表信息')
            ->setCellValue('J1', '附表信息')
            ->setCellValue('K1', '原币')
            ->setCellValue('L1', '本位币')
            ->setCellValue('M1', '报告币')
            ->setCellValue('N1', '主表金额系数')
            ->setCellValue('O1', '附表金额系数')
            ->setCellValue('P1', '性质')
            ->setCellValue('Q1', '核算项目1')
            ->setCellValue('R1', '编码1')
            ->setCellValue('S1', '名称1')
            ->setCellValue('T1', '核算项目2')
            ->setCellValue('U1', '编码2')
            ->setCellValue('V1', '名称2')
            ->setCellValue('W1', '核算项目3')
            ->setCellValue('X1', '编码3')
            ->setCellValue('Y1', '名称3')
            ->setCellValue('Z1', '核算项目4')
            ->setCellValue('AA1', '编码4')
            ->setCellValue('AB1', '名称4')
            ->setCellValue('AC1', '核算项目5')
            ->setCellValue('AD1', '编码5')
            ->setCellValue('AE1', '名称5')
            ->setCellValue('AF1', '核算项目6')
            ->setCellValue('AG1', '编码6')
            ->setCellValue('AH1', '名称6')
            ->setCellValue('AI1', '核算项目7')
            ->setCellValue('AJ1', '编码7')
            ->setCellValue('AK1', '名称7')
            ->setCellValue('AL1', '核算项目8')
            ->setCellValue('AM1', '编码8')
            ->setCellValue('AN1', '名称8');


        $file = 'D:\excel\kingdeeExport.xls';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($file);
        unset($data, $objPHPExcel, $objWriter);
    }

    
    public function actionOnlineData() {
        // 2014-01-01以后的数据
        $sql = "SELECT y.gai_number AS gai_number, z.name AS storeName,z.member_id as storeMemberId,
                            t.id as orderId,t.code, t.status, t.real_price, t.freight, t.return_status,
                            t.refund_status, t.member_id, t.store_id, t.is_comment, t.create_time
                    FROM `gw_order` `t` 
                    LEFT JOIN gw_member AS y ON (t.member_id = y.id) 
                    LEFT JOIN gw_store AS z ON (t.store_id = z.id)
                    WHERE t.`create_time`>=1388505600 AND t.pay_status = 2 AND (t.status = 2 OR (t.refund_status = 3 OR t.return_status = 4))";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $orders = $command->query();
        $result = array();
        foreach ($orders as $order) {
            if ($order['member_id']) {//消费者id
                //总供货价
                $orderGoods = Yii::app()->db->createCommand()->select('SUM(gai_price * quantity) AS gaiPrice, order_id')
                                ->from('{{order_goods}}')->where('order_id=:order_id', array(':order_id' => $order['orderId']))
                                ->group('order_id')->queryRow();
                $gaiPrice = !empty($orderGoods) ? $orderGoods['gaiPrice'] : 0;
                $profit = bcsub(bcsub($order['real_price'], $order['freight'], 2), $gaiPrice, 2); //利润
                //商家会员
                $storeMember = Yii::app()->db->createCommand()->select()->from('{{member}}')->where('id=:id', array(':id' => $order['storeMemberId']))->queryRow();
                $storeGaiNumber = !empty($storeMember) ? $storeMember['gai_number'] : '';
                // 
                array_push($result, array(
                    'gaiNumber' => $storeGaiNumber,
                    'storeName' => $order['storeName'],
                    'date' => date('Y-m-d', $order['create_time']) . ' ',
                    'totalMoney' => $order['real_price'],
                    'gonghuo' => $gaiPrice + $order['freight'],
                    'lirun' => $profit,
                ));

                // 退款
                if ($order['refund_status'] == 3 || $order['return_status'] == 4) {
                    array_push($result, array(
                        'gaiNumber' => $storeGaiNumber,
                        'storeName' => $order['storeName'],
                        'date' => date('Y-m-d', $order['create_time']) . ' ',
                        'totalMoney' => '-' . $order['real_price'],
                        'gonghuo' => '-' . $gaiPrice + $order['freight'],
                        'lirun' => '-' . ($profit),
                    ));
                }
            }
        }
        $data = self::formartAry($result);
        unset($result);
        var_dump($data);
        exit;
        Tool::pr($data);
    }

    /**
     * 
     * @param array $result = array(
     *   'gaiNumber' => ,
     *   'storeName' => ,
     *   'date' => ,
     *   'totalMoney' => ,
     *   'gonghuo' => ,
     *   'lirun' => ,
     * )
     * @return array
     */
    public static function formartAry($result) {
        $step = 1;
        foreach ($result as $key => $val) {
            //供货价+利润
            $direction = '1';
            $data[$step]['date'] = $val['date'];
            $data[$step]['class'] = '1221.03.02';
            $data[$step]['key'] = $step;
            $data[$step]['price'] = $val['totalMoney'];
            $data[$step]['debtor_price'] = $val['totalMoney']; //借方
            $data[$step]['credit_price'] = ''; //贷方
            $data[$step]['digest'] = '交易'; //辅助账摘要
            $data[$step]['item'] = '客户'; //项目
            $data[$step]['code'] = '007'; //编码
            $data[$step]['name'] = '珠海横琴新区盖网投资管理有限公司'; //名称
            //利润
            $step++;
            $direction = '0';
            $data[$step]['date'] = $val['date'];
            $data[$step]['class'] = '2241.04';
            $data[$step]['key'] = $step;
            $data[$step]['price'] = $val['lirun'];
            $data[$step]['debtor_price'] = ''; //借方
            $data[$step]['credit_price'] = $val['lirun']; //贷方
            $data[$step]['digest'] = ''; //辅助账摘要
            $data[$step]['item'] = ''; //项目
            $data[$step]['code'] = ''; //编码
            $data[$step]['name'] = ''; //名称
            //供货价
            $step++;
            $direction = '0';
            $data[$step]['date'] = $val['date'];
            $data[$step]['class'] = '2241.03.02';
            $data[$step]['key'] = $step;
            $data[$step]['price'] = $val['gonghuo'];
            $data[$step]['debtor_price'] = ''; //借方
            $data[$step]['credit_price'] = $val['gonghuo']; //贷方
            $data[$step]['digest'] = '交易'; //辅助账摘要
            $data[$step]['item'] = '供应商'; //项目
            $data[$step]['code'] = $val['gaiNumber']; //编码
            $data[$step]['name'] = $val['storeName']; //名称a
            $step++;
        }
        return $data;
    }

    /**
     * 同步金蝶区域数据与服务器区域数据
     * 要求：系统现有数据不允许删除，相关数据必须和金蝶区域一样
     * 将现有数据全部查询出来保存到数组1，将金蝶数据保存在数组2，比较数组1和数组2的不同，分开进行修改或者插入
     * 数据量过大，耗内存等其它缺点
     * 仅限国内
     */
    public static function actionSyncRegion(){

        //查询所有oracle数据
        $sqlOracle = "select FNUMBER,FNAME_L2 from CT_CDB_CRMADDRESS";
        $oracleResult = Yii::app()->ea->createCommand($sqlOracle)->queryAll();

        $oracleData = array();
        foreach ($oracleResult as $key => $value) {
            if (substr($value['FNUMBER'], 0, 2) == 'GW') continue;
            
            $oracleData[$value['FNUMBER']] = $value['FNAME_L2'];
        }
        unset($oracleResult);

        //查询所有系统数据
        $regionTable = Region::model()->tableName();
        $sqlMysql = "select id,name,area_code from " . $regionTable;
        $mysqlResult = Yii::app()->db->createCommand($sqlMysql)->queryAll();

        $mysqlData = array();
        $mysqlKey = array();
        foreach ($mysqlResult as $key => $value) {
            $mysqlData[$value['area_code']] = $value['name'];
            $mysqlKey[$value['area_code']] = $value['id'];
        }
        unset($mysqlResult);

        //以oracle数据为基础，与现在系统数据进行比较，查看不同
        $diffArr = array_diff_assoc($oracleData, $mysqlData);

        if (empty($diffArr)) {
            echo "no diffrent!";
            die;
        };

        // var_dump($diffArr);die;
        $updateSql = "";
        $updateLen = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try{
            foreach ($diffArr as $key => $value) {
                if (isset($mysqlData[$key])) {
                    $updateSql.= "update " . $regionTable . " set name = '" . $value . "', area_code =  '" . $key . "' where id = " . $mysqlKey[$key] . ";";
                } else {
                    //获取父节点
                    $provinceId = substr($key, 0, 2);
                    $cityId = substr($key, 2, 2);
                    $districtId = substr($key, 4);

                    if ($districtId == "00") {
                        if ($cityId == "00") {      //添加的是省
                            $insertSql = "insert into " . $regionTable ."(parent_id,name,depth,tree,area_code,short_name,area) 
                            value( 1, '" . $value . "', 1, '1', " . $key . ", '" . $value . "', 2);";
                        } else { //添加是市
                            $sql = "select id from " . $regionTable . " where LEFT(area_code, 2) = " . $provinceId;
                            $pid = Yii::app()->db->createCommand($sql)->queryScalar();
                            $insertSql = "insert into " . $regionTable ."(parent_id,name,depth,tree,area_code,short_name,area) 
                            value(" . $pid . ", '" . $value . "', 2, '1|" . $pid . "', '" . $key . "', '" . $value . "', 2);";
                        }
                    } else { //添加的是区
                        $sql = "select id,tree from " . $regionTable . " where LEFT(area_code, 4) = " . $provinceId.$cityId;
                        $pData = Yii::app()->db->createCommand($sql)->queryRow();
                        $insertSql = "insert into " . $regionTable ."(parent_id,name,depth,tree,area_code,short_name,area) 
                        value(" . $pData['id'] . ", '" . $value . "', 3, '" . $pData['tree'] . "', '" . $key . "', '" . $value . "', 2);";
                    }
                    Yii::app()->db->createCommand($insertSql)->execute();
                    $lastInsertId = Yii::app()->db->getLastInsertID();
                    $updateSql.= "update " . $regionTable . " set tree = concat(tree, '|', " . $lastInsertId . "), sort = " . $lastInsertId . " where id = " . $lastInsertId . ";" ;
                }

                ++$updateLen;

                if ($updateLen >= 100) {
                    Yii::app()->db->createCommand($updateSql)->execute();
                    $updateSql = "";
                    $updateLen = 0;
                }
            }

            if ($updateLen) 
                Yii::app()->db->createCommand($updateSql)->execute();

            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollBack();
            echo $e->getMessage();
            echo "\r\n sync fail!";
            die;
        }
        echo "sync success!";
    }
}
