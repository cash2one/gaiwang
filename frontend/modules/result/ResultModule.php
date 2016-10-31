<?php

/**
 * 对账模板，接收支付平台推送的 对账消息
 *
 *  @author zhenjun_xu <412530435@qq.com>
 */
class ResultModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'result.components.*',
            'm.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
