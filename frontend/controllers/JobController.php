<?php

/**
 * 诚聘英才
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class JobController extends Controller {

    public $layout = 'main';

    public function actionIndex() {
    	$site_config = $this->getConfig('site');
    	$this->pageTitle = Yii::t('job', '诚聘英才'). '_' .$site_config['name'];
        $this->render('index');
    }

}
