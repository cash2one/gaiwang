<?php 

 /**
  * 商城商家绑定控制器
  * @author wyee <yanjie.wang@g-emall.com>
  */

class PartnerAgentController extends SController {

    /**
     * 商家列表
     */
    public function ActionList(){
        $memberId=$this->getUser()->id;
        $store=new Store();
        $store->unsetAttributes();
        $store->referrals_id=$memberId;
        //$store->under_id=Store::STORE_UNDER_YES;
        $dataProvider=$store->getMiddleAgent();
        $agentList=$dataProvider->getData();
        $pager=$dataProvider->pagination;
        $datetime=strtotime(date('Y-m'));
        $dateEnd =strtotime('-1 days',strtotime(date('Y-m-d 23:59:59')));
        $acount=array();
        foreach ($agentList as $k =>$v){
            $acount[$v->id]=Store::getAcount($v->id,$datetime,$dateEnd);
        }
        $exportPages = new CPagination(count($agentList));
        $exportPages->route = '/middleAgent/agentExport';
        $exportPages->params = array_merge(array('id'=>$memberId,'exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPages->pageSize = 1000; 
        $this->Render('index',array(
                'agentList'=>$agentList,
                'exportPages' => $exportPages,
                'account'=>$acount,
                'pager'=>$pager
        ));
    }
    
    
    /**
     * 商家详情
     */
    public function ActionDetail(){   
        $sid=$this->getParam('id');
        $criteria = new CDbCriteria(array(
                'select' => 't.id,t.create_time,cat.name as category_id,t.mobile,t.name,t.status,t.mode,m.gai_number AS username',
                'join' => 'LEFT JOIN {{member}} AS m ON m.id=t.member_id  LEFT JOIN {{category}} AS cat ON t.category_id=cat.id',
                'condition' => 't.id = :id',
                'params' => array(':id' => $sid)
        ));
        $store=Store::model()->find($criteria);
        if (empty($store))
            throw new CHttpException(404,'商家信息页面不存在');
        $this->Render('view',array(
                'model'=>$store,
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
     * 每个月内每天的销售额
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
    
   
}
?>