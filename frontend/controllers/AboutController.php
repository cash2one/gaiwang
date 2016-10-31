<?php

/**
 * 关于我们
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class AboutController extends Controller {

    public function actionIndex() {
    	$site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('about', '关于我们'). '_' .$site_config['name'];
        $this->render('index');
    }

}
