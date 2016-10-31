<?php

/**
 * 工商执照
 */
class GongShangController extends Controller {

    public function actionLicense() {
    	$site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('site', '工商执照'). '_' .$site_config['name'];
        $this->layout = 'null';
        $this->render('license');
    }

}
