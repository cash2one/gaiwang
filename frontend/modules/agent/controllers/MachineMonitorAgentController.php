<?php

class MachineMonitorAgentController extends Controller
{
	/**
        * 设置当前所在的menu
        */
        protected function setCurMenu($name)
        {        
              $this->curMenu = Yii::t('main', '盖机管理');
        } 
	
	/**
	 * 远程监控.
	 */
	public function actionIndex()
	{
		$this->breadcrumbs = array(Yii::t('Machine','盖网代理管理'), Yii::t('Machine','远程监控'));

                $model = new MachineMonitorAgent();
                $agent_region = $this->getPowerAear(false);
                $model->agent_ss = $agent_region;//把代理商session传给model
                $model->status = MachineMonitorAgent::STATUS_UNUSUAL;
                if(isset($_GET['status']) && isset($_GET['machineNmae'])){
                    $model->machine_name = $this->getQuery('machineNmae');
                    $model->status = $this->getQuery('status');
                }
                if (isset($_GET['MachineMonitorAgent'])) {
                    $model->attributes = $this->getQuery('MachineMonitorAgent');
                }
                $this->render('index', array('model' => $model));
	}

        
        /**
	 * 远程监控.单个盖机
	 */
	public function actionMonitorList()
	{
		$this->breadcrumbs = array(Yii::t('Machine','盖网代理管理'), Yii::t('Machine','远程监控'));
                
                $machine_id = $this->getQuery('id');
                
                //检查是否有权限
               $data =  MachineAgent::model()->findByPk($machine_id);
               $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
                
                $machineName = $this->getQuery('machineName');
                $model = new MachineMonitorAgent();
                $model->machine_id = $machine_id;
                $model->status = MachineMonitorAgent::STATUS_UNUSUAL;
                if(isset($_GET['status']) && isset($_GET['machineNmae'])){
                    $model->machine_name = $this->getQuery('machineNmae');
                    $model->status = $this->getQuery('status');
                }
                if (isset($_GET['MachineMonitorAgent'])) {
                    $model->attributes = $this->getQuery('MachineMonitorAgent');
                }
                $this->render('monitorlist', array('model' => $model,'machineName'=>$machineName));
	}
	
}
