<?php
/**
 * qqSdk第三方登录
 */
Yii::import('ext.qqSdk.Qq', true);

class QqController extends Controller
{
    /**
     * 是否授权登陆第三方平台
     */
    public function actionIndex()
    {
        $keys = array();
        $keys['state'] = md5(uniqid(rand(), TRUE)); //生成唯一随机串防CSRF攻击
        $keys['display'] = NULL;
        $keys['response_type'] = 'code';
        $qqService = new Qq(QQ_AKEY, QQ_SKEY);
        $code_url = $qqService->getAuthorizeURL(QQ_CALLBACK_URL, $keys);
        $_SESSION['back_url'] = Yii::app()->user->returnUrl;
        $this->setSession("state", $keys['state']);
        $this->redirect($code_url);
    }

    /**
     * 授权登陆后回调函数
     */
    public function actionCallback()
    {
        $qqService = new Qq(QQ_AKEY, QQ_SKEY);
        $state = $this->getSession("state");
        //--------验证state防止CSRF攻击
        if ($_REQUEST['state'] != $state) {
            throw new CHttpException(403, 'The state does not match. You may be a victim of CSRF');
        }
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = QQ_CALLBACK_URL;
            try {
                $token = $qqService->getAccessToken($keys);
            } catch (OAuthException $e) {
                throw new CHttpException(401, '授权失败');
            }
        }
        if ($token) {
            $_SESSION['token'] = $token;
            //根据token_access获取用户的openid
            $userArr = $qqService->get_open_id($token['access_token']);
            //查找用户是否用QQ openidID登陆过
            if ($userArr['openid']) {

                $ThirdUser = ThirdCommon::getThirdUser(ThirdLogin::TYPE_QQ, $userArr['openid']);

                if (!empty($ThirdUser)) {
                    ThirdCommon::getMemberLogin($ThirdUser->member_id);
                    $this->redirect(array('/'));
                } else {
                    $keys = array();
                    $keys['openid'] = $userArr['openid'];
                    $keys['phone'] = '';
                    ThirdCommon::insertThirdMem(ThirdLogin::TYPE_QQ, $keys);
                    $this->redirect(array('/'));
                }
            } else {
                throw new CHttpException(503, Yii::t('memberHome', '很抱歉，您在QQ平台不存在该账号信息'));
            }
        } else {
            throw new CHttpException(401, '认证错误');
        }
    }


}