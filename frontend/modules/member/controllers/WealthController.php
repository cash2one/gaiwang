<?php

/**
 * 积分控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class WealthController extends MController {

    public function init() {
        $this->pageTitle = Yii::t('memberWealth', '_用户中心_') . Yii::app()->name;
    }

    /**
     * 积分明细
     */
    public function actionCashDetail() {
        $this->pageTitle = Yii::t('memberWealth', '积分明细') . $this->pageTitle;
        $model = new AccountFlow();
        $model->unsetAttributes();
        if (isset($_GET['AccountFlow']))
            $model->attributes = $this->getParam('AccountFlow');
        $this->render('cashdetail', array('model' => $model));
    }

    /**
     * 企业账户明细
     */
    public function actionEnterpriseCashDetail() {
        $this->pageTitle = Yii::t('memberWealth', '账户明细') . $this->pageTitle;
        $model = new AccountFlow();
        $model->unsetAttributes();
        if (isset($_GET['AccountFlow']))
            $model->attributes = $this->getParam('AccountFlow');
        $this->render('enterprisecashdetail', array('model' => $model));
    }

    /**
     * 线下交易详情
     * @author lc
     */
    public function actionOffline() {
        $this->pageTitle = Yii::t('memberWealth', '线下交易详情') . $this->pageTitle;
        $model = new FranchiseeConsumptionRecord();
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeConsumptionRecord']))
            $model->attributes = $this->getParam('FranchiseeConsumptionRecord');

        //查询该会员对应的加盟商id
        $sql = "select a.id from gw_franchisee a LEFT JOIN gw_member m on a.member_id=m.id 
        where m.id=" . $this->getUser()->getId();
        $franchiseeIds = Yii::app()->db->createCommand($sql)->queryAll();
        $franchiseeIdsArr = array();
        foreach ($franchiseeIds as $franchisee_id) {
            $franchiseeIdsArr[] = $franchisee_id['id'];
        }
        $model->franchisee_id = $franchiseeIdsArr;
        $wealths = $model->searchListOffline();
        $this->render('offline', array(
            'wealths' => $wealths,
            'model' => $model
        ));
    }

    /*
     * 线下交易明细导出
     */

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

        $model = new FranchiseeConsumptionRecord();
        $model->unsetAttributes();

        $this->getQuery('franchiseeName') ? $model->remark = $this->getQuery('franchiseeName') : "";
        $this->getQuery('starTime') ? $model->start_time = $this->getQuery('starTime') : "";
        $this->getQuery('endTime') ? $model->end_time = $this->getQuery('endTime') : "";
        $this->getQuery('status') != "" ? $model->status = $this->getQuery('status') : "";
        $syType=$this->getQuery('b');
        //查询该会员对应的加盟商id
        $sql = "select a.id from gw_franchisee a LEFT JOIN gw_member m on a.member_id=m.id 
        where m.id=" . $this->getUser()->getId();
        $franchiseeIds = Yii::app()->db->createCommand($sql)->queryAll();
        $franchiseeIdsArr = array();
        foreach ($franchiseeIds as $franchisee_id) {
            $franchiseeIdsArr[] = $franchisee_id['id'];
        }
        $franChiseeTb = Franchisee::model()->tableName();

        $criteria = new CDbCriteria;
//        $a=array(0=>1,1=>1299);
//        $criteria->addInCondition('t.franchisee_id', $a);
        $criteria->addInCondition('t.franchisee_id', $franchiseeIdsArr);
        $criteria->join = "LEFT JOIN " . $franChiseeTb . " f ON f.id = t.franchisee_id";

        $criteria->compare('t.status', $model->status);
        if ($model->start_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($model->start_time));
        }
        if ($model->end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($model->end_time) + 86400));
        }
        $criteria->compare('f.name', $model->remark, true);
        $criteria->order = 't.create_time desc';
        $data = new CActiveDataProvider('FranchiseeConsumptionRecord', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            ),
        ));
        
        $count = $data->getTotalItemCount();

        $newData = new CActiveDataProvider('FranchiseeConsumptionRecord', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $count,
            ),
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            ),
        ));

        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', Yii::t('memberWealth', '加盟商名称'))
                ->setCellValue('B1', Yii::t('memberWealth', '加盟商编号'))
                ->setCellValue('C1', Yii::t('memberWealth', '对账状态'))
                ->setCellValue('D1', Yii::t('memberWealth', '盖网折扣(百分比)'))
                ->setCellValue('E1', Yii::t('memberWealth', '会员折扣(百分比)'))
                ->setCellValue('F1', Yii::t('memberWealth', '账单时间'))
                ->setCellValue('G1', Yii::t('memberWealth', '消费金额'))
                ->setCellValue('H1', Yii::t('memberWealth', '分配金额'))
                ->setCellValue('I1', Yii::t('memberWealth', '应付金额'))
                ->setCellValue('J1', Yii::t('memberWealth', 'GW号'))
                ->setCellValue('K1', Yii::t('memberWealth', '手机号'));

        if ($weathsData = $newData->getData()) {
            $num = 1;
            foreach ($weathsData as $key => $wealth) {
                $gaiNubmer=substr_replace($wealth->member->gai_number, '****', 3, 4);
                $mobile=substr_replace($wealth->member->mobile, '****', 3, 4);
                  if($syType==Symbol::HONG_KONG_DOLLAR){
                        $distr_money=FranchiseeConsumptionRecord::convertHKD($wealth->distribute_money,$wealth->base_price, $wealth->symbol,Symbol::HONG_KONG_DOLLAR);
                        $spend_dis=FranchiseeConsumptionRecord::conversion($wealth->spend_money - $wealth->distribute_money, $wealth->base_price, $wealth->symbol,Symbol::HONG_KONG_DOLLAR);;
                    }else{
                        $distr_money=FranchiseeConsumptionRecord::convertHKD($wealth->distribute_money,$wealth->base_price, $wealth->symbol,Symbol::RENMINBI);
                        $spend_dis=FranchiseeConsumptionRecord::conversion($wealth->spend_money - $wealth->distribute_money, $wealth->base_price, $wealth->symbol,Symbol::RENMINBI);; 
                    }   
                $num++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $num, $wealth->franchisee->name)
                        ->setCellValue('B' . $num, $wealth->franchisee->code) 
                        ->setCellValue('C' . $num, FranchiseeConsumptionRecord::getCheckStatus($wealth->status))
                        ->setCellValue('D' . $num, $wealth->gai_discount)
                        ->setCellValue('E' . $num, $wealth->member_discount)
                        ->setCellValue('F' . $num, date('Y-m-d H:i:s', $wealth->create_time))
                        ->setCellValue('G' . $num, IntegralOfflineNew::formatPrice($wealth->entered_money, $wealth->symbol))
                        ->setCellValue('H' . $num, FranchiseeConsumptionRecord::conversion($wealth->distribute_money, $wealth->base_price, $syType))
                        ->setCellValue('I' . $num, FranchiseeConsumptionRecord::conversion($wealth->spend_money - $wealth->distribute_money, $wealth->base_price, $syType))
                        ->setCellValue('J' . $num, $gaiNubmer)
                        ->setCellValue('K' . $num, $mobile);
            }
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle(Yii::t('memberWealth','线下交易明细'));

        $name = '线下交易明细';
        $name = iconv('UTF-8', 'GB2312', $name);
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
