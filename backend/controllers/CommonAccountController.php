<?php

/**
 * 共有账户控制器
 * 操作（列表）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class CommonAccountController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {
        $model = new CommonAccount('search');
        $model->unsetAttributes();
        if (isset($_GET['CommonAccount']))
            $model->attributes = $_GET['CommonAccount'];

        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'commonAccount/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'),$_GET);
        $exportPage->pageSize = $model->exportLimit;
        
        $this->render('admin', array(
            'model' => $model,
            'exportPage' => $exportPage,
        	'totalCount'=>$totalCount,
        ));
    }
    
	public function actionAdminExport() {
        $model = new CommonAccount('search');
        $model->unsetAttributes();
        if (isset($_GET['CommonAccount']))
            $model->attributes = $_GET['CommonAccount'];

        @SystemLog::record(Yii::app()->user->name."导出 共有账户列表");

        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }
    
    public function actionBalance(){
    	$model = new CommonAccount();
    	if(isset($_GET['CommonAccount'])){
    		$model->attributes = $_GET['CommonAccount'];
    	}else{
    		$model->type = CommonAccount::TYPE_OFF_MANEUVER;
    	}
    	$this->render('balance',array(
    		'model'=>$model,	
    	));
    } 
}
