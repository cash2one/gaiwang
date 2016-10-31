<?php

/**
 * 积分日志
 * 操作(积分日志查询)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class WealthController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {

        $this->breadcrumbs = array(Yii::t('wealth', '积分兑换管理 '), Yii::t('wealth', '积分日志查询'));
        $model = new Wealth('search');
        $model->unsetAttributes();
        if (isset($_GET['Wealth'])) {
            $model->attributes = $_GET['Wealth'];
        }
        $wealth = $model->search();
        
        
        
        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'wealth/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'),$_GET);
        $exportPage->pageSize = $model->exportLimit;
        
        $this->render('admin', array(
            'model' => $model,
         	'wealth' => $wealth,
            'exportPage' => $exportPage,
        	'totalCount'=>$totalCount,
        ));
    }
    
	public function actionAdminExport() {
        $model = new Wealth('search');
        $model->unsetAttributes();
        if (isset($_GET['Wealth'])) {
            $model->attributes = $_GET['Wealth'];
        }
        
        @SystemLog::record(Yii::app()->user->name . "导出积分日志列表");
        
        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

}
