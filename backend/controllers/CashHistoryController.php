<?php

/**
 * 积分兑现、企业提现申请列表
 *
 * 操作(兑现、提现的审核,批量操作)
 * @author zhenjun_xu <412530435@qq.com>
 */
class CashHistoryController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'franchiseeApplyCashExport,setReview';
    }

    public $showBack = false; //右上角 是否显示 “返回列表”

    /**
     * 积分兑现申请列表
     */
    public function actionApplyCash()
    {
        $this->showExport = true;
        $this->exportAction = 'applyCashExport';
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '积分兑现申请表'));
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory'])){
            $model->attributes = $_GET['CashHistory'];  
        }

        $c = $model->search($model::TYPE_CASH);
        $count = CashHistory::model()->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);


        $exportPage = new CPagination($count);
        $exportPage->route = '/cashHistory/applyCashExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;


        $log = CashHistory::model()->findAll($c);
        $this->render('applycash', array('model' => $model, 'pages' => $pages, 'log' => $log, 'exportPage' => $exportPage, 'totalCount' => $count));
    }

    /**
     * 积分兑现申请列表导出
     */
    public function actionApplyCashExport()
    {
        @ini_set('memory_limit', '2048M');
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory']))
            $model->attributes = $_GET['CashHistory'];

        @SystemLog::record(Yii::app()->user->name . "导出积分兑现申请列表");

        $model->isExport = 1;
        $this->render('applycashExport', array('model' => $model));
    }


    /**
     * 申请兑现编辑
     * @param $id
     */
    public function actionApplyCashDetail($id)
    {
        $this->showBack = true;
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '积分申请兑现编辑'));
        /** @var $model CashHistory */
        $model = $this->loadModel($id);
        /** @var $memberModel Member */
        $memberModel = Member::model()->findByPk($model->member_id);
        if (isset($_POST['CashHistory'])) {
            $this->checkPostRequest();
            $model->attributes = $_POST['CashHistory'];
            //当前控制器不可以修改到审核状态
            if($model->status==$model::STATUS_CHECKED){
                $this->setFlash('error', Yii::t('cashHistory', '请选择其他状态'));
                $this->refresh();
            }
            $flag = false;
            //其他状态
            if($model->status != $model::STATUS_TRANSFERED && $model->status != $model::STATUS_FAIL){
                $flag = Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
            }
            //成功
            if ($model->status == $model::STATUS_TRANSFERED) {
                $flag = CashHistoryProcess::memberCashEnd($model->attributes, $memberModel->attributes);
            }
            //失败，发送短信提醒，积分回滚
            if ($model->status == $model::STATUS_FAIL) {
                $flag = CashHistoryProcess::memberCashFailed($model->attributes, $memberModel->attributes);
            }
            if (!$flag) {
                $this->setFlash('error', Yii::t('cashHistory', '操作失败'));
                $this->refresh();
            }else{
                $this->setFlash('success', Yii::t('cashHistory', '操作成功'));
            }
            SystemLog::record(Yii::app()->user->name . "积分申请兑现编辑：{$memberModel->gai_number}|{$model->reason}|{$model::status($model->status)}");
            $this->refresh();
        }
        if($memberModel->role==$memberModel::ROLE_AGENT){
            $memberModel = Member::model()->findByAttributes(array('id'=>$memberModel->pid));
        }

        $this->render('applycashdetail', array('model' => $model, 'memberModel' => $memberModel));
    }

    /**
     * 企业会员提现申请 列表
     */
    public function actionEnterpriseApplyCash()
    {
        $this->showExport = true;
        $this->exportAction = 'enterpriseApplyCashExport';
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '企业会员提现申请单'));
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory'])){
        	$model->attributes = $_GET['CashHistory'];
        	$model->moneyType=$_GET['CashHistory']['moneyType'];
        }
        
        $c = $model->search($model::TYPE_COMPANY_CASH);
        $count = CashHistory::model()->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);
        $log = CashHistory::model()->findAll($c);


        $exportPage = new CPagination($count);
        $exportPage->route = '/cashHistory/enterpriseApplyCashExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;


        $this->render('enterpriseapplycash', array('model' => $model, 'pages' => $pages, 'c' => $c, 'log' => $log, 'exportPage' => $exportPage, 'totalCount' => $count));
    }


    /**
     * 企业会员提现申请 列表导出
     */
    public function actionEnterpriseApplyCashExport()
    {
        set_time_limit(3600);
        @ini_set('memory_limit', '2048M');
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory'])){
            $model->attributes = $_GET['CashHistory'];
            $model->moneyType=$_GET['CashHistory']['moneyType'];
        }

        @SystemLog::record(Yii::app()->user->name . "导出企业会员提现申请列表");

        $model->isExport = 1;
        $this->render('enterpriseapplycashExport', array('model' => $model));
    }


    /**
     * 加盟商提现申请 列表导出
     */
    public function actionFranchiseeApplyCashExport()
    {
        set_time_limit(3600);
        @ini_set('memory_limit', '2048M');
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory']))
            $model->attributes = $_GET['CashHistory'];

        @SystemLog::record(Yii::app()->user->name . "导出加盟商提现申请列表");

        $model->isExport = 1;
        $this->render('franchiseeapplycashExport', array('model' => $model));
    }

  /**
     * 普通会员提现申请 列表导出
     */
    public function actionMemberApplyCashExport()
    {
        set_time_limit(3600);
        @ini_set('memory_limit', '2048M');
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory']))
            $model->attributes = $_GET['CashHistory'];

        @SystemLog::record(Yii::app()->user->name . "导出普通会员提现申请列表");

        $model->isExport = 1;
        $this->render('memberapplycashExport', array('model' => $model));
    }
    
    /**
     * 企业会员申请提现编辑
     * @param $id
     */
    public function actionEnterpriseApplyCashDetail($id)
    {
        $this->showBack = true;
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '企业会员提现申请单'));
        /** @var $model CashHistory */
        $model = $this->loadModel($id);
        /** @var $member Member */
        $member = Member::model()->findByPk($model->member_id);
        /** @var $infoModel Enterprise */
        $infoModel = Enterprise::model()->findByPk($member->enterprise_id);

        if (isset($_POST['CashHistory'])) {
            $this->checkPostRequest();
            $model->attributes = $_POST['CashHistory'];
            //当前控制器不可以修改到审核状态
            if($model->status==$model::STATUS_CHECKED){
                $this->setFlash('error', Yii::t('cashHistory', '请选择其他状态'));
                $this->refresh();
            }
            $flag = false;
            //不是失败与已转账，直接修改状态
            if($model->status != $model::STATUS_FAIL && $model->status != $model::STATUS_TRANSFERED){
                $flag = Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
            }
            //成功
            if ($model->status == $model::STATUS_TRANSFERED) {
                $flag = CashHistoryProcess::enterpriseCashEnd($model->attributes, $member->attributes);
            }
            //失败，发送短信提醒，积分回滚
            if ($model->status == $model::STATUS_FAIL) {
                $flag = CashHistoryProcess::enterpriseCashFailed($model->attributes, $member->attributes);
            }
            if (!$flag) {
                $this->setFlash('error', Yii::t('cashHistory', '操作失败'));
                $this->refresh();
            }else{
                $this->setFlash('success', Yii::t('cashHistory', '操作成功'));
            }
            @SystemLog::record(Yii::app()->user->name . "企业会员提现申请单编辑：{$member->gai_number}|{$model->money}|{$model::status($model->status)}");
            $this->refresh();
        }
        $this->render('enterprisecashdetail', array('model' => $model, 'infoModel' => $infoModel));
    }

    /**
     * ajax 批量操作 积分兑换
     */
    public function actionCashBatchUpdate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->checkPostRequest();
            $idArr = explode(',', $this->getPost('idArr'));
            $reason = $this->getPost('reason');
            $status = $this->getPost('status');
            if (empty($idArr))
                return false;
            foreach ($idArr as $id) {
                /** @var $model  CashHistory */
                $model = CashHistory::model()->findByPk($id);
                /** @var $memberModel Member */
                $memberModel = Member::model()->findByPk($model->member_id);
                if (!$model)
                    continue;
                $model->reason = $reason;
                $flag = true;
                //批量转账中
                if ($status == 'transfering') {
                    $model->status = $model::STATUS_TRANSFERING;
                }
                //批量转账成功
                if ($status == 'transfered') {
                    $model->status = $model::STATUS_TRANSFERED;
                }
                //批量转账失败
                if ($status == 'fail') {
                    $model->status = $model::STATUS_FAIL;
                }
                //其他状态
                if ($model->status != $model::STATUS_FAIL && $model->status != $model::STATUS_TRANSFERED) {
                    Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
                }
                //成功
                if ($model->status == $model::STATUS_TRANSFERED) {
                    $flag = CashHistoryProcess::memberCashEnd($model->attributes, $memberModel->attributes);
                }
                //失败，发送短信提醒，积分回滚
                if ($model->status == $model::STATUS_FAIL) {
                    $flag = CashHistoryProcess::memberCashFailed($model->attributes, $memberModel->attributes);
                }
                if (!$flag) {
                    $msg =  Yii::t('cashHistory', '操作失败');
                }else{
                    $msg =  Yii::t('cashHistory', '操作成功');
                }
                echo $msg;
                @SystemLog::record(Yii::app()->user->name . "批量操作 积分兑换：" . $this->getPost('idArr'));
            }
        }
    }

    /**
     * ajax 批量操作 企业会员提现
     */
    public function actionEnterpriseCashBatchUpdate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->checkPostRequest();
            $idArr = explode(',', $this->getPost('idArr'));
            $reason = $this->getPost('reason');
            $status = $this->getPost('status');
            if (empty($idArr))
                return false;
            foreach ($idArr as $id) {
                /** @var $model  CashHistory */
                $model = CashHistory::model()->findByPk($id);
                if (!$model)
                    continue;
                $model->reason = $reason;
                $flag = true;
                //批量转账中
                if ($status == 'transfering') {
                    $model->status = $model::STATUS_TRANSFERING;
                }
                //批量转账成功
                if ($status == 'transfered') {
                    $model->status = $model::STATUS_TRANSFERED;
                }
                //批量转账失败
                if ($status == 'fail') {
                    $model->status = $model::STATUS_FAIL;
                }
                /** @var $member Member */
                $member = Member::model()->findByPk($model->member_id);
                //其他状态
                if ($model->status != $model::STATUS_FAIL && $model->status != $model::STATUS_TRANSFERED) {
                    Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
                }
                //成功
                if ($model->status == $model::STATUS_TRANSFERED) {
                    $flag = CashHistoryProcess::enterpriseCashEnd($model->attributes, $member->attributes);
                }
                //失败，发送短信提醒，积分回滚
                if ($model->status == $model::STATUS_FAIL) {
                    $flag = CashHistoryProcess::enterpriseCashFailed($model->attributes, $member->attributes);
                }
                if (!$flag) {
                    $msg =  Yii::t('cashHistory', '操作失败');
                }else{
                    $msg =  Yii::t('cashHistory', '操作成功');
                }
                echo $msg;
                @SystemLog::record(Yii::app()->user->name . "批量操作 企业会员提现：" . $this->getPost('idArr'));
            }
        }
    }

    /**
     * ajax 修改审阅状态
     */
    public function actionSetReview(){
        $this->_setReview();
    }

    /**
     * ajax 修改审阅状态
     */
    public function actionEnterpriseSetReview(){
        $this->_setReview();
    }
    
     /**
     * ajax 修改审阅状态
     */
    public function actionMemberSetReview(){
        $this->_setReview();
    }

    private function _setReview(){
        $id = $this->getPost('id');
        $type = $this->getPost('status');
        if ($type == CashHistory::REVIEW_NO){
            CashHistory::model()->updateByPk($id, array('is_review' => CashHistory::REVIEW_YES));
        }
        elseif ($type == CashHistory::REVIEW_YES){
//            CashHistory::model()->updateByPk($id, array('is_review' => CashHistory::REVIEW_NO));
        }
        @SystemLog::record(Yii::app()->user->name . "修改审阅状态：" . $id . '|' . CashHistory::reviewStatus($type));
        echo CJSON::encode(array('status' => 1));
        Yii::app()->end();
    }

    /**
     * ajax 批量修改兑现审核状态
     */
    public function actionCheckedBatch(){
        $this->_checkedBatch();
    }

    /**
     * ajax 批量修改提现审核状态
     */
    public function actionEnterpriseCheckedBatch(){
        $this->_checkedBatch();
    }
    
      /**
     * ajax 批量修改普通会员提现审核状态
     */
    public function actionMemberCheckedBatch(){
        $this->_checkedBatch();
    }

    /**
     * 批量操作审核
     */
    private function _checkedBatch(){
        if (Yii::app()->request->isAjaxRequest) {
            $ids = $this->getPost('idArr');
            $check = (int)$this->getPost('check');
            if($check===CashHistory::CHECK_YES){
                $flag = Yii::app()->db->createCommand()->update('{{cash_history}}',array('is_check'=>$check),'id in('.$ids.')');
            }else{
                $flag = false;
            }
            if (!$flag) {
                $msg =  Yii::t('cashHistory', '操作失败');
            }else{
                $msg =  Yii::t('cashHistory', '操作成功');
            }
            echo $msg;
            @SystemLog::record(Yii::app()->user->name . "批量操作兑现审核：" . $this->getPost('idArr'));
        }
    }
    
      public function actionMemberApplyCash()
    {
        $this->showExport = true;
        $this->exportAction = 'memberApplyCashExport';
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '普通会员提现申请单'));
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory']))
            $model->attributes = $_GET['CashHistory'];

        $c = $model->search($model::TYPE_MEMBER_CASH);
        $count = CashHistory::model()->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);
        $log = CashHistory::model()->findAll($c);


        $exportPage = new CPagination($count);
        $exportPage->route = '/cashHistory/memberApplyCashExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;


        $this->render('memberapplycash', array('model' => $model, 'pages' => $pages, 'c' => $c, 'log' => $log, 'exportPage' => $exportPage, 'totalCount' => $count));
    }
    
    public function actionMemberApplyCashDetail($id)
    {
        $this->showBack = true;
        $this->breadcrumbs = array(Yii::t('member', '兑现管理 '), Yii::t('member', '普通会员提现申请单'));
        /** @var $model CashHistory */
        $model = $this->loadModel($id);
        /** @var $member Member */
        $member = Member::model()->findByPk($model->member_id);
        $data = array();
        foreach ($member as $k=>$v){
            $data[$k] = $v;
        }
        if (isset($_POST['CashHistory'])) {
            $this->checkPostRequest();
            $model->attributes = $_POST['CashHistory'];
            //当前控制器不可以修改到审核状态
            if($model->status==$model::STATUS_CHECKED){
                $this->setFlash('error', Yii::t('cashHistory', '请选择其他状态'));
                $this->refresh();
            }
            $flag = false;
            //不是失败与已转账，直接修改状态
            if($model->status != $model::STATUS_FAIL && $model->status != $model::STATUS_TRANSFERED){
                $flag = Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
            }
            //成功
            if ($model->status == $model::STATUS_TRANSFERED) {
                $flag = CashHistoryProcess::ordinaryMemberCashEnd($model->attributes, $member->attributes);
            }
            //失败，发送短信提醒，积分回滚
            if ($model->status == $model::STATUS_FAIL) {
                $flag = CashHistoryProcess::ordinaryMemberCashFailed($model->attributes, $member->attributes);
            }
            if (!$flag) {
                $this->setFlash('error', Yii::t('cashHistory', '操作失败'));
                $this->refresh();
            }else{
                $this->setFlash('success', Yii::t('cashHistory', '操作成功'));
            }
            @SystemLog::record(Yii::app()->user->name . "普通会员提现申请单编辑：{$member->gai_number}|{$model->money}|{$model::status($model->status)}");
            $this->refresh();
        }
        $this->render('membercashdetail', array('model' => $model, 'data' => $data));
    }
    
      /**
     * ajax 批量操作 普通会员提现
     */
    public function actionMemberCashBatchUpdate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->checkPostRequest();
            $idArr = explode(',', $this->getPost('idArr'));
            $reason = $this->getPost('reason');
            $status = $this->getPost('status');
            if (empty($idArr))
                return false;
            foreach ($idArr as $id) {
                /** @var $model  CashHistory */
                $model = CashHistory::model()->findByPk($id);
                if (!$model)
                    continue;
                $model->reason = $reason;
                $flag = true;
                //批量转账中
                if ($status == 'transfering') {
                    $model->status = $model::STATUS_TRANSFERING;
                }
                //批量转账成功
                if ($status == 'transfered') {
                    $model->status = $model::STATUS_TRANSFERED;
                }
                //批量转账失败
                if ($status == 'fail') {
                    $model->status = $model::STATUS_FAIL;
                }
                /** @var $member Member */
                $member = Member::model()->findByPk($model->member_id);
                //其他状态
                if ($model->status != $model::STATUS_FAIL && $model->status != $model::STATUS_TRANSFERED) {
                    Yii::app()->db->createCommand()->update('{{cash_history}}', array('update_time'=>time(),'reason' => $model->reason, 'status' => $model->status), "id='{$model->id}'");
                }
                //成功
                if ($model->status == $model::STATUS_TRANSFERED) {
                    $flag = CashHistoryProcess::ordinaryMemberCashEnd($model->attributes, $member->attributes);
                }
                //失败，发送短信提醒，积分回滚
                if ($model->status == $model::STATUS_FAIL) {             
                    $flag = CashHistoryProcess::ordinaryMemberCashFailed($model->attributes, $member->attributes);
                }
                if (!$flag) {
                    $msg =  Yii::t('cashHistory', '操作失败');
                }else{
                    $msg =  Yii::t('cashHistory', '操作成功');
                }
                echo $msg;
                @SystemLog::record(Yii::app()->user->name . "批量操作 普通会员提现：" . $this->getPost('idArr'));
            }
        }
    }

}
