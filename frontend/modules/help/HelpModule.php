<?php

/**
 * 帮助中心模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class HelpModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        parent::init();
    }

    public function beforeControllerAction($controller, $action) {
        //处理上传图片的session问题，写在controler里面无效
        if (isset($_POST["PHPSESSID"])) {
            session_id($_POST["PHPSESSID"]);
        } else if (isset($_GET["PHPSESSID"])) {
            session_id($_GET["PHPSESSID"]);
        }
        //$controller->layout = '//layouts/column1';
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
