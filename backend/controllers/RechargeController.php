<?php

/**
 * 积分充值控制器
 * 操作（列表）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class RechargeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {
    	$this->showExport = true;
    	$this->exportAction = 'adminExport';
        $model = new Recharge('search');
        $model->unsetAttributes();
        if (isset($_GET['Recharge']))
            $model->attributes = $_GET['Recharge'];
            
        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/recharge/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', compact('model', 'exportPage', 'totalCount'));
    }
    
    
	public function actionAdminExport() {
        $model = new Recharge('search');
        $model->unsetAttributes();
        if (isset($_GET['Recharge']))
            $model->attributes = $_GET['Recharge'];

            
        @SystemLog::record(Yii::app()->user->name . "导出积分充值列表");
            
        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

}
