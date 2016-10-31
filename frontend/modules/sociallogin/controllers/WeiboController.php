<?php
/**
 * 微博登录
 */
Yii::import('ext.sinaWeibo.SinaWeibo', true);

class WeiboController extends Controller
{
    /**
     * 是否授权登陆第三方平台
     */
    public function actionIndex()
    {
        $weiboService = new SinaWeibo(WB_AKEY, WB_SKEY);
        $code_url = $weiboService->getAuthorizeURL(WB_CALLBACK_URL);
        $_SESSION['back_url'] = Yii::app()->user->returnUrl;
        $this->redirect($code_url);
    }

    /**
     * 授权登陆后回调函数
     */
    public function actionCallback()
    {
        $weiboService = new SinaWeibo(WB_AKEY, WB_SKEY);
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $weiboService->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
                throw new CHttpException(403, '登录失败');
            }
        }
        if ($token) {
            $_SESSION['token'] = $token;
            setcookie('weibojs_' . $weiboService->client_id, http_build_query($token));
            $c = new SaeTClientV2(WB_AKEY, WB_SKEY, $token['access_token']);
            $uid_get = $c->get_uid();
            $uid = $uid_get['uid'];
            $user_info = $c->show_user_by_id($uid);
            if ($user_info['id']) {
                //查找用户是否用第三方（微博）openid登陆过
                $ThirdUser = ThirdCommon::getThirdUser(ThirdLogin::TYPE_WEIBO, $user_info['id']);
                if (!empty($ThirdUser)) {
                    ThirdCommon::getMemberLogin($ThirdUser->member_id);
                    $this->redirect(array('/'));
                } else {
                    $keys = array();
                    $keys['openid'] = $user_info['id'];
                    $keys['phone'] = '';
                    ThirdCommon::insertThirdMem(ThirdLogin::TYPE_WEIBO, $keys);
                    $this->redirect(array('/'));
                }
            } else {
                throw new CHttpException(503, Yii::t('memberHome', '很抱歉，您在微博平台不存在该账号信息'));
            }
        } else {
            throw new CHttpException(403, '认证错误');
        }
    }
}