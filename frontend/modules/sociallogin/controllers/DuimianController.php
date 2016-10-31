<?php
/**
 * 微博登录
 */
Yii::import('ext.duimian.Duimian', true);

class DuimianController extends Controller
{
    /**
     * 是否授权登陆第三方平台
     */
    public function actionIndex()
    {
        if (!$this->getUser()->isGuest) {
            $this->redirect(array('/member'));
        }
        $dmService = new Duimian(DM_AKEY, DM_SKEY);
        $code_url = $dmService->getAuthorizeURL(DM_CALLBACK_URL);
        $_SESSION['back_url'] = Yii::app()->user->returnUrl;
        $this->redirect($code_url);
    }

    /**
     * 授权登陆后回调函数
     */
    public function actionCallback()
    {
        $dmService = new Duimian(DM_AKEY, DM_SKEY);
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = DM_CALLBACK_URL;
            try {
                $token = $dmService->getAccessToken($keys, 'code');
            } catch (OAuthException $e) {
                throw new CHttpException(403, '登录失败');
            }
        }
        if ($token) {
            $user_info = $dmService->get_user_info($token['access_token']);
            if ($user_info['openid']) {
                //查找用户是否用第三方（对面）openid登陆过
                $ThirdUser = ThirdCommon::getThirdUser(ThirdLogin::TYPE_DUIMIAN, $user_info['openid']);

                if (!empty($ThirdUser)) {
                    ThirdCommon::getMemberLogin($ThirdUser->member_id);
                    $this->redirect(array('/'));
                } else {
                    $keys = array();
                    $keys['openid'] = $user_info['openid'];
                    $keys['phone'] = $user_info['phone'];
                    ThirdCommon::insertThirdMem(ThirdLogin::TYPE_DUIMIAN, $keys);
                    $this->redirect(array('/'));
                }
            } else {
                throw new CHttpException(503, Yii::t('memberHome', '很抱歉，您在对面平台不存在该账号信息'));
            }
        } else {
            throw new CHttpException(403, '认证错误');
        }

    }

}