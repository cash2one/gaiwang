<?php

/**
 * 手机模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class WrapModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/zt/site/error',
            )
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

    /**
     * 添加新会员
     * @param string $mobile 手机号
     * @return type
     */
    public static function addMember($mobile){
        $result = Member::model()->find('mobile=:mb', array(':mb'=>$mobile));
        if(empty($result)){
            $salt = Tool::generateSalt();
            $defaultVal = MemberType::fileCache();
            $memberModel = new Member();
            $password = mt_rand(100000,999999);
            $data = array(
                'password'=>$password,
                'mobile'=>$mobile,
                'is_master_account'=>'0',//主账号
                'is_enterprise'=>'0'
            );
            $memberModel = new Member();
            $memberModel->attributes = $data;
            $memberModel->save();
            return array('id'=>$memberModel->id,'password'=>$password);
        }
    }
}
