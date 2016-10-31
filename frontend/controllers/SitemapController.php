<?php

/**
 * 网站地图控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class SitemapController extends Controller {

    public function actionIndex() {
        $category = Category::treeCategory();
        $site_config = $this->getConfig('site');
		$this->pageTitle = Yii::t('sitemap', '网站地图'). '_' .$site_config['name'];
        $this->render('index', array(
            'category' => $category
        ));
    }

}
