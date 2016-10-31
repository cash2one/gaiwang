<?php

/**
 * 会员中心 我的钱包
 * User: binbin.liao
 * Date: 2014/12/1
 * Time: 10:37
 */
class RedEnvelopeController extends MController {

    public $memberId; //会员id

    public function beforeAction($action) {
        $this->memberId = $this->getUser()->id;
        return parent::beforeAction($action);
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
            'captcha2' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
        );
    }

    /**
     * 我的钱包首页
     * @author binbin.liao
     */
    public function actionIndex() {
        /**
         * 绑定手机号码
         */
        $codeModel = new ExchangeCodeForm();
        if (!$this->isMobile) {
            $this->model->scenario = 'bind';
            if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
                echo CActiveForm::validate($this->model);
                Yii::app()->end();
            }
            if (isset($_POST['Member'])) {
                $this->model->attributes = $this->getPost('Member');
                if ($this->model->save()) {
                    //给推荐者派发红包
                    if (!empty($this->model->referrals_id)) {
                        RedEnvelopeTool::createRedisActivity($this->model->referrals_id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_SHARE);
                    }
                    //给新注册的会员派发红包
                    RedEnvelopeTool::createRedisActivity($this->model->id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_REGISTER);
                    $this->redirect('index');
                }
            }
        }

        $this->render('index', array(
            'member' => $this->model,
            'codeModel' => $codeModel,
        ));
    }

//    使用兑换码为红包充值
    public function actionRechargeCodes() {
        if (isset($_POST['ExchangeCodeForm'])) {
            $member_id = $this->model->id;
            $data = $this->getParam('ExchangeCodeForm');
            $name = $data['name'];
            $exchangeInfo = ExchangeCode::model()->findByAttributes(array('name' => $name));
            if ($exchangeInfo) {
                $exchangeInfo->type = Activity::TYPE_RECHARGE;
                $status = $exchangeInfo['status'];
                if ($status == ExchangeCode::RECHARGE_NO) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $data = $exchangeInfo;
                        RedEnvelopeTool::createRedisActivity($member_id, Coupon::SOURCE_GAIWANG, Activity::TYPE_RECHARGE, Coupon::COMPENSATE_NO, $sms_content = NULL, $data);
                        $exchangeInfo->status = ExchangeCode::RECHARGE_YES;
                        $exchangeInfo->account = $this->model->gai_number;
                        $exchangeInfo->time = time();
                        $exchangeInfo->save(FALSE);
                        $transaction->commit();
                        $this->setFlash('success', Yii::t('Activity', "兑换成功，谢谢您的支持！"));
                    } catch (Exception $e) {
                        $transaction->rollback();
                        $this->setFlash('error', Yii::t('Activity', "红包充值失败！") . $e->getMessage());
                    }
                    $this->redirect(array('index'));
                } else {
                    $this->setFlash('error', '兑换失败，请认真核对后再输入！');
                    $this->redirect(array('index'));
                }
            } else {
                $this->setFlash('error', '兑换失败，请认真核对后再输入！');
                $this->redirect(array('index'));
            }
        }
    }

    /**
     * 红包充值
     * @author binbin.liao
     * @param $id 红包id
     */
    public function actionGetRed() {
        $msg = array(); //提示信息
        if ($this->isAjax()) {
            $id = $this->getPost('id'); //红包id
            if ($this->model->mobile) {
                //判断红包是否是未使用和未过期的
                $redData = RedEnvelope::checkRed($id, $this->memberId);
                if (!empty($redData)) {
                    $red = RedEnvelopeTool::getInstance();
                    $status = $red->rechargeRed($this->model, $redData);
                    $msg['tip'] = $status['tip'];
                    $msg['status'] = true;
                } else {
                    $msg['tip'] = '该红包已经充值过了';
                    $msg['status'] = false;
                }
            } else {
                $msg['tip'] = '请先完善您的资料';
                $msg['status'] = false;
            }
            exit(CJSON::encode($msg));
        }
    }

    /**
     * 红包领取清单
     * @author binbin.liao
     */
    public function actionRedList() {
        $model = new Coupon();

        $this->render('list', array('model' => $model));
    }

}

