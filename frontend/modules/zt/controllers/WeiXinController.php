<?php

/**
 * 微信专题控制器
 * 操作 (专题列表,查看专题)
 * @author  jianlin.lin <hayeslam@163.com>
 */
class WeiXinController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction', 'method' => 'selectLanguage'),
        );
    }

    public $layout = false;
    public $theme; //主题对象
    public function init() {
        $this->theme = Yii::app()->getTheme();
        // 加载专题css样式
//        Yii::app()->clientScript->registerCssFile(DOMAIN . '/css/zt.css');
    }

    /**
     * 调用单页文件
     * @param string $actionId
     */
    public function missingAction($actionId) {
        $actionId = substr($actionId, -5) == '.html' ? substr($actionId, 0, -5) : $actionId;
        $renderFile = 'application.modules.zt.views.site.weixin.' . $actionId;
        if (file_exists(Yii::getPathOfAlias($renderFile) . '.php')) {
            $this->render($renderFile);
        } else {
            parent::missingAction($actionId);
        }
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}