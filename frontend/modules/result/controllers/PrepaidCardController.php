<?php

/**
 * 生成充值卡
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class PrepaidCardController extends Controller {

//    public function beforeAction($action) {
//        if (!$this->isPost())
//            exit(0);
//        return parent::beforeAction($action);
//    }

    public function actionCreate() {
        echo CJSON::encode(array('status' => 'success'));
    }

}
