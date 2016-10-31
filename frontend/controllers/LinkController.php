<?php

/**
 * 关于我们
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class LinkController extends Controller {

    public function actionIndex() {

        $links = Link::linkFileCache(false);
        $site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('link', '友情链接'). '_' .$site_config['name'];
        $this->render('index', array('links' => $links));
    }

}

