<?php

/**
 * 帐户明细
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class WealthController extends SController {

    public function actionIndex() {
        $this->pageTitle = Yii::t('wealth', '账户明细') . $this->pageTitle;
        $model = new AccountFlow();
        $model->unsetAttributes();
    	if(isset($_GET['AccountFlow'])){
			$model->create_time = $_GET['AccountFlow']['create_time'];
			$model->endTime = $_GET['AccountFlow']['endTime'];
		}

        $accountFlow = $model->searchSeller();
        $this->render('index', array(
            'accountFlow' => $accountFlow,
            'model' => $model
        ));
    }

}
