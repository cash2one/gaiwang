<?php

/**
 * 第三方登陆绑定member表
 * @author wyee
 * Date 2015-4-21
 */
class ThirdCommon
{

    public $type;//第三方用户类型



    /**
     * @param int $type 第三方登陆类型
     * @param string $thirdId 第三方登陆的唯一标识
     * @return mixed
     */
    public static function  getThirdUser($type, $thirdId)
    {
        $ThirdUser = ThirdLogin::model()->find(array(
            'condition' => 'third_id=:third_id AND type=:type',
            'params' => array(':third_id' => $thirdId, ':type' => $type)
        ));
        return $ThirdUser;
    }

    /**
     *
     * @param int $memId 用户ID
     * @throws CHttpException
     * @return
     */
    public static function getMemberLogin($memId)
    {
        if (!empty($memId)) {
            $loginForm = new ThirdLoginForm;
            $loginForm->id = $memId;
            $loginForm->thirdLogin();
        } else {
            throw new CHttpException(503, Yii::t('memberHome', '信息错误'));
        }
    }

    /**
     *
     * @param int $type 第三方类型
     * @param array $keys 入库数据
     */
    public static function insertThirdMem($type, $keys)
    {
        $trans = Yii::app()->db->beginTransaction();
        try {
            $codePass = Tool::buildOrderNo(19, 8);
            $member = new Member();
            $member->mobile = $keys['phone'];
            $member->register_type = $member::REG_TYPE_THIRD;//第三方注册
            $member->password = $codePass;//默认密码
            $mem = $member->save();
            if (!$mem) {
                throw new CHttpException(503, Yii::t('memberHome', '该手机号“'.$keys['phone'].'”已在商城存在,请直接登陆'));
            }
            $ThirdLogin = new ThirdLogin();
            $ThirdLogin->third_id = $keys['openid'];
            $ThirdLogin->member_id = $member->id;
            $ThirdLogin->type = $type;
            $ThirdLogin->create_time = time();
            if (!$ThirdLogin->save()) {
                throw new CHttpException(503, Yii::t('memberHome', ThirdLogin::ThirdType($type) . '第三方信息错误，无法授权登陆'));
            }
            $trans->commit();
            $loginForm = new LoginForm;
            $loginForm->username = $member->gai_number;
            $loginForm->password = $codePass;
            $loginForm->login();
        } catch (Exception $e) {
            $trans->rollback();
            throw new CHttpException(503, Yii::t('memberHome', $e->getMessage()));
        }

    }

}

?>