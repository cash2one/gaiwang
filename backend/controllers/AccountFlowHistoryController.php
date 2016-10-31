<?php

/**
 * 历史流水控制器 
 * 操作 (列表)
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class AccountFlowHistoryController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'admin, view, changeMonth';
    }

    public function actionAdmin() {
        $model = new AccountFlowHistory('search');
        $model->unsetAttributes();
        if (isset($_GET['AccountFlowHistory']))
            $model->attributes = $this->getParam('AccountFlowHistory');
        if (!$this->getSession('accountFlowHistoryMonth'))
            $model->month = date('Y-m', time());
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * 设置当前搜索月份
     */
    public function actionChangeMonth() {
        if ($this->isAjax())
            $this->setSession('accountFlowHistoryMonth', $this->getPost('month'));
    }
    
    /**
     * 盖粉转账查询
     */
    public function actionGfAdmin() {
    	$model = new AccountFlowHistory('search');
    	$model->unsetAttributes();
    	if (isset($_GET['AccountFlowHistory']))
    		$model->attributes = $this->getParam('AccountFlowHistory');
    	    $model->gai_number=AccountFlowHistory::GWNUM;
    	    $model->operate_type=AccountFlowHistory::OPERATE;
    	if (!$this->getSession('accountFlowHistoryMonth'))
    		$model->month = date('Y-m', time());
    	$this->render('gfAdmin', array(
    			'model' => $model,
    	));
    }

}
