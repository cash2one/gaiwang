<?php

/**
 * 联系我们
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class ContactController extends Controller
{

    public function actionIndex()
    {
        $site_config = $this->getConfig('site');
        $this->pageTitle = Yii::t('contact', '联系客服') . '_' . $site_config['name'];
        $article = Article::fileCache('contact');
        $this->render('index', array('config' => $site_config, 'article' => $article));
    }

}
