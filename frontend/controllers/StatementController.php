<?php

/**
 * 免则声明
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class StatementController extends Controller {

    public function actionIndex() {
    	$site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('sitemap', '免责申明'). '_' .$site_config['name'];
        $this->render('index');
    }

}
