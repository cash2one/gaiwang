<?php 

 /**
  * 商城居间管理控制器 
  * @author wyee <yanjie.wang@g-emall.com>
  * @date 2016-04-05
  */

class MiddleAgentController extends SController {
    
    
    public function beforeAction($action) {
        $route = $this->id . '/' . $action->id;
        $midPages=array(
                'middleAgent/list',
                'middleAgent/partner',
        );
        if($this->getCookie('isMidAgent')==Store::STORE_ISMIDDLEMAN_NO || $this->getCookie('levelNum') == MiddleAgent::LEVEL_PARTNER){
            if(in_array($route,$midPages)){
                $this->redirect(array('/seller/middleAgent/error'));
            }
        }
        return parent::beforeAction($action);
    }
 
    /**
     * 居间商-商家列表
     */
    public function ActionList(){
        $middleAgent=new MiddleAgent();
        $level=$this->getParam('l');
        $level=!empty($level) ? $level : 0;
        $dataProvider=$middleAgent->getSellerTreeData($this->midLevId,$level);
        $agentList=$dataProvider->getData();
        $exportPages = new CPagination(count($agentList));
        $exportPages->route = '/middleAgent/agentExport';
        $exportPages->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export','lid'=>$this->midLevId,'l'=>$level));
        $exportPages->pageSize = 1000; 
        $this->Render('index',array(
                'agentList'=>$agentList,
                'pager'=>$dataProvider->pagination,
                'exportPages' => $exportPages,
        ));
    }
    
    /**
     * 居间推荐列表
     */  
    public function ActionPartner(){
        $middleAgent=new MiddleAgent();
        $midLevId=$this->getParam('lid');
        $level=$this->getParam('l');
        $midLevId=!empty($midLevId) ? $midLevId : $this->midLevId;
        $level=!empty($level) ? $level : 0;
        $dataProvider=$middleAgent->getSellerTreeData($midLevId);
        $agentList=$dataProvider->getData(); 
        $exportPages = new CPagination(count($agentList));
        $exportPages->route = '/middleAgent/agentExport';
        $exportPages->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export','lid'=>$midLevId,'l'=>$level));
        $exportPages->pageSize = 1000;
        $this->Render('partner',array(
                'agentList'=>$agentList,
                'pager'=>$dataProvider->pagination,
                'exportPages' => $exportPages,
        ));
    }
    
    /**
     * 错误页面
     */
    
    public function actionError(){
        $this->render('error');
    }
    
    /**
     * 居间推荐列表
     */
    public function ActionOther(){
        $this->Render('other');
    }
    
    /**
     * 获取表格分类树数据
     */
    public function actionGetTreeGridData(){
        $id = $this->getParam('lid');
        $data = array();
        if (is_numeric($id)) {
            $model = new MiddleAgent();
            $data = $model->getTreeData($id,1);
        }
        echo CJSON::encode($data);
    }
    
    // 居间商属下商家导出excel
    public function actionAgentExport(){
        $middleAgent=new MiddleAgent();
        $midLevId=$this->getParam('lid');
        $level=$this->getParam('l');
        $dataProvider=$middleAgent->getSellerTreeData($midLevId,$level);
        $pager=$dataProvider->pagination;
        $pager->pageSize=10000;
        $this->render('agentexport', array(
              'model' => $dataProvider,
              'exType'=>$level
        ));
    }
 
    /**
     * 商家月销售额列表
     */
    public function ActionMouthAccount(){
        $sid=$this->getParam('id');
        if(empty($sid)){
             throw new CHttpException(404,'商家信息错误');
         }
          $resArr=MiddleCommon::getAccountMouth($sid);
          $exportPage = new CPagination(count($resArr['accountList']));
          $exportPage->route = 'middleAgent/accountExport';
          $exportPage->params = array_merge(array('id'=>$sid));
          $exportPage->pageSize = '100';
          $this->Render('account',array(
                'accounList'=>$resArr['accountList'],
                'count'=>$resArr['months'],
                'allAcount'=>$resArr['allAcount'],
                'exportPages' => $exportPage,
        ));
    }
   
    /**
     * 居间商商家每个月内每天的销售额
     */
    public function ActionAccountDay(){
        $sid=$this->getParam('id');
        $mouth=$this->getParam('m');
        if(empty($sid)){
            throw new CHttpException(404,'商家信息错误');
        }  
          $resArr=MiddleCommon::getAccountDay($sid, $mouth);
          $exportPage = new CPagination(count($resArr['dayData']));
          $exportPage->route = 'middleAgent/accountExport';
          $exportPage->params = array_merge(array('id'=>$sid,'m'=>$mouth));
          $exportPage->pageSize = '100';
          $this->Render('accountday',array(
                 'accounDayList'=>$resArr['dayData'],
                 'total_price'=>$resArr['total_price'],
                 'exportPages' => $exportPage,
        ));  
    }
    
   /**
     * 导出日销售额记录或者日销售额
     */
    public function actionAccountExport(){
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
        Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
        $sid=$this->getParam('id');
        $mouth=$this->getParam('m');
        if(empty($sid)){
            throw new CHttpException(404,'商家信息错误');
        }
        $dataArr=array();
        if(!empty($mouth)){
            $excelData=MiddleCommon::getAccountDay($sid,$mouth);
            $dataArr=$excelData['dayData'];
        }else{
            $mouthArr=MiddleCommon::getAccountMouth($sid);
            foreach ($mouthArr['accountList'] as $k => $v){
                $dataArr[$k]['date']=$v->months;
                $dataArr[$k]['num']=$v->orderCount;
                $dataArr[$k]['total_price']=$v->account;
             }
          }
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', '日期')
        ->setCellValue('B1', '订单数')
        ->setCellValue('C1', '销售额（元）');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $i = 2;
        foreach ($dataArr as $k => $v) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $v['date'])
            ->setCellValue('B' . $i, $v['num']) 
            ->setCellValue('C' . $i, $v['total_price']);
            $i++;
        }    
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.date('YmdHis').iconv('utf-8','gb2312','商家销售额记录').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//避免乱码
        $objWriter->save('php://output'); 
        unset($excelData, $objPHPExcel, $objWriter);
        Yii::app()->end();
    }

    
  
   
    
   
    
   
}
?>