<?php

/**
 *
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class PrivacyController extends Controller{

    public function actionIndex() {
		$site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('sitemap', '隐私权保护声明'). '_' .$site_config['name'];
        $this->render('index');
    }

}
