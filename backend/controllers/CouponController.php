<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/30
 * Time: 11:55
 */
class CouponController extends Controller
{

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin()
    {
        $model = new Coupon('search');
        $model->unsetAttributes();
        if (isset($_GET['Coupon']))
            $model->attributes = $this->getParam('Coupon');
//        var_dump($model);die;
        $this->render('admin', array('model' => $model));
    }
}