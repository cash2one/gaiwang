<?php

/**
 * 捐款控制器
 * 操作（列表）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class CharityController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {
        $model = new Charity('search');
        $model->unsetAttributes();
        if (isset($_GET['Charity']))
            $model->attributes = $_GET['Charity'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
