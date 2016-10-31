<?php

/**
 * 帮助中心文章控制器
 * @author wencong.lin <183482670@qq.com>
 */
class ArticleController extends Controller {

    //public $layout = '//layouts/main';

    public function actionView($alias) {
        if (!$article = Article::fileCache($alias))
            throw new CHttpException(404, Yii::t('helpArticle', '请求的页面不存在'));
        $this->render('view', array(
            'article' => $article
        ));
    }

}

?>
