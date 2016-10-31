<?php

/**
 * 帮助中心文章控制器
 * @author qinghao.ye
 */
class ArtController extends Controller {

    public function actionView($alias) {
        if (!$article = Article::fileCache($alias))
            echo Yii::t('helpArticle', '请求的页面不存在');
        echo $article['content'];
    }

}

?>
