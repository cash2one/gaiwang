<?php

class MachineInventoryController extends Controller
{
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '运维人员');
    }
    /**
     * 盖机盘点情况
     */
    public function actionIndex(){
        $model = new MachineAgent();
        $model->unsetAttributes();  // clear any default values
        $agent_region = $this->getPowerAear(false);
        $model->agent_ss = $agent_region;
        if (isset($_GET['MachineAgent'])) {
            $dataArray = $this->getQuery('MachineAgent');
            $model->attributes = $dataArray;
            $model->i_begin_time = $dataArray['i_begin_time'];
            $model->i_end_time = $dataArray['i_end_time'];
            $model->inventoryState = $dataArray['inventoryState'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }
}