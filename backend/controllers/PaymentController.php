<?php

/**
 * 代付管理--代付申请表
 * 操作（代付，查询）
 * @date 2016-08-29
 * @author wyee <yanjie.wang@g-emall.com>
 */
class PaymentController extends Controller {
    
    public $defaultAction = '';
    public $showBack=false;
    
    public function filters() {
        return array(
                'rights',
        );
    }
    
    
    /**
     * 代收付批次列表
     */
    public function actionAdmin() { 
    	$this->showExport = true;
    	$this->showBack=true;
        $this->exportAction = 'adminExport';
        $model = new Payment('search');
        $bid=$this->getParam('bid');
        $model->unsetAttributes();
        if (isset($_GET['Payment'])){
            $model->attributes = $_GET['Payment']; 
        }
        if(!empty($bid)){
        	$model->batch_id=$bid;
        } 
        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/payment/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('admin', compact('model', 'exportPage', 'totalCount'));
    }
    
    // 代付导出excel
    public function actionAdminExport() {
    	$model = new Payment('search');
    	$model->unsetAttributes();
    	if (isset($_GET['Payment']))
    		$model->attributes = $_GET['Payment'];   
    	@SystemLog::record(Yii::app()->user->name . "导出企业提现代付列表");   
    	$model->isExport = 1;
    	$this->render('adminexport', array(
    			'model' => $model,
    	));
    }

    /**
     * 修改代付活动状态
     */
    public function actionChangeLock()
    {
        $id=$this->getParam('id');
        $model=Payment::model()->findByPk($id);
    	if ($model->lock_status == Payment::STATUS_LOCK_NO) {
    		$model->lock_status = Payment::STATUS_LOCK_YES;
    	} else {
    		$model->lock_status = Payment::STATUS_LOCK_NO;
    	}
    	$res=$model->save(false);
    	@SystemLog::record(Yii::app()->user->name . "修改企业提现信息状态" . $model->id);
    }
    
    /**
     * 删除代付表里的信息
     * 把体现表里的状态改为未审核
     */
    public function actionDelete()
    {
        $cid=$this->getParam('cid');//企业提现表ID
    	$id=$this->getParam('id');//企业代付表ID
    	$bid=$this->getParam('bid');//企业代付批次表ID
    	$res=CashHistory::model()->updateByPk($cid, array('is_check'=>CashHistory::CHECK_NO));
    	$msg='';
    	if($res){
    		$r=Payment::model()->deleteByPk($id);
    		if($r){
    			$msg='删除企业提现信息成功';
    		}else{
    			$msg='删除企业提现信息失败';
    		}
    	}
    	@SystemLog::record(Yii::app()->user->name . $msg . $id);
    	$this->redirect(array('admin','bid'=>$bid));
    }
    
    

    
}
