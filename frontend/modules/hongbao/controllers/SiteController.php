<?php

/**
 * 红包控制器
 * @author huabin.hong <121826725@qq.com>
 */
class SiteController extends Controller {

    public function actions() {
        return array(
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
     * 调用单页文件
     * @param string $actionId
     */
    public function missingAction($actionId) {
        $this->layout = 'application.views.layouts.main';
        $actionId = substr($actionId, -5) == '.html' ? substr($actionId, 0, -5) : $actionId;
        $renderFile = 'application.modules.hongbao.views.site.pages.' . $actionId;
        if (file_exists(Yii::getPathOfAlias($renderFile) . '.php')) {
            $this->render($renderFile);
        } else {
            parent::missingAction($actionId);
        }
    }

    /**
     * 红包首页
     */
    public function actionIndex() {
        //获取头部广告信息(具体字段命名根据实际情况可修改)
        $ads = array('top' => '', 'right' => '');
        $advert = Advert::getHongBaoCache('hongbao-index-top');
        if (!empty($advert) && !empty($advert['pic']))
            foreach ($advert['pic'] as $val) {
                if (AdvertPicture::isValid($val['start_time'], $val['end_time']))
                    $ads['top'][] = array('imgurl' => $val['picture'], 'link' => $val['link']);
            }
        //获取右侧底部广告
        $advert = Advert::getHongBaoCache('hongbao-index-main-right');
        if (!empty($advert) && !empty($advert['pic'])) {
            if (AdvertPicture::isValid($advert['pic']['start_time'], $advert['pic']['end_time'])) {
                $ads['right'] = array('title' => $advert['pic']['title'], 'imgurl' => $advert['pic']['picture'], 'link' => $advert['pic']['link']);
            }
        }

        //获取红包首页精选的盖惠券(具体字段命名根据实际情况可修改)
//    	$coupons = CouponActivity::model()->searchForWebList(4)->getData();
        $coupons = array();

        //获取推荐商品
        $limit = 2;
        $recommands = Yii::app()->db->createCommand()
                ->select('t.id,s.name as stroe_name,t.thumbnail,t.price,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status')
                ->from('{{goods}} as t')
                ->leftJoin('{{store}} as s', 't.store_id = s.id')
                ->leftJoin('{{activity_tag}} as at','t.activity_tag_id=at.id')
                ->where('t.show=:show and t.is_publish=:is_publish and t.status=:status ', array(':show' => 1, ':is_publish' => Goods::PUBLISH_YES, ':status' => Goods::STATUS_PASS))
                ->order('t.sort desc')
                ->limit($limit)
                ->queryAll();
        foreach ($recommands as &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($g['activity_tag_id']) && $g['at_status'] == ActivityTag::STATUS_ON) {
                $g['price'] = $g['gai_sell_price'];
            }
        }
        $this->render('index', array(
            'ads' => $ads,
            'coupons' => $coupons,
            'recommands' => $recommands,
        ));
    }

    /**
     * 红包首页ajax异步获取推荐红包
     */
    public function actionAjaxGetCoupons() {
        if ($this->isAjax()) {
            $page = $this->getParam('page', '0');
            $pageSize = 4;
            $where = 't.valid_end >= :valid_end and t.status = ' . CouponActivity::COUPON_STATUS_PASS . ' limit ' . $page * $pageSize . ',' . $pageSize;
            $data = Yii::app()->db->createCommand()
                    ->select('t.id,t.price,t.condition,t.valid_start,t.valid_end,t.thumbnail,s.name,s.category_id')
                    ->from(CouponActivity::model()->tableName() . ' t')
                    ->leftJoin(Store::model()->tableName() . ' s', 's.id = t.store_id')
                    ->where($where, array(':valid_end' => time()))
                    ->queryAll();
            if (!empty($data)) {
                foreach ($data as $key => $val) {
                    $val['price'] = floor($val['price']);
                    $val['condition'] = floor($val['condition']);
                    $val['valid_start'] = date('m/d', $val['valid_start']);
                    $val['valid_end'] = date('m/d', $val['valid_end']);
                    $res['k' . $key] = $val;
                }
                echo json_encode(array('page' => $page, 'pageSize' => $pageSize, 'data' => $res));
            } else
                echo json_encode(array('page' => -1, 'pageSize' => $pageSize));
        }
    }

    /**
     * 红包汇
     */
    public function actionList() {
        //获取红包列表不同类型的盖惠券(具体字段命名根据实际情况可修改)
        $reNo1 = CouponActivity::model()->searchForWebList(5, 's.category_id = 1');
        $reNo2 = CouponActivity::model()->searchForWebList(5, 's.category_id = 2');
        $reNo3 = CouponActivity::model()->searchForWebList(5, 's.category_id = 3');
        $reNo4 = CouponActivity::model()->searchForWebList(5, 's.category_id = 4');
        $reNo5 = CouponActivity::model()->searchForWebList(5, 's.category_id = 5');
        $reNo6 = CouponActivity::model()->searchForWebList(5, 's.category_id = 6');
        $reNo7 = CouponActivity::model()->searchForWebList(5, 's.category_id = 7');
        $reNo8 = CouponActivity::model()->searchForWebList(5, 's.category_id = 8');
        $reNo9 = CouponActivity::model()->searchForWebList(5, 's.category_id = 9');
        $reNo10 = CouponActivity::model()->searchForWebList(5, 's.category_id = 10');
        $reNo11 = CouponActivity::model()->searchForWebList(5, 's.category_id = 11');
        $reNo12 = CouponActivity::model()->searchForWebList(5, 's.category_id = 12');

        $this->render('list', array(
            'reNo1' => $reNo1,
            'reNo2' => $reNo2,
            'reNo3' => $reNo3,
            'reNo4' => $reNo4,
            'reNo5' => $reNo5,
            'reNo6' => $reNo6,
            'reNo7' => $reNo7,
            'reNo8' => $reNo8,
            'reNo9' => $reNo9,
            'reNo10' => $reNo10,
            'reNo11' => $reNo11,
            'reNo12' => $reNo12,
        ));
    }

    /**
     * 红包故事
     * 根据不同的类型显示不同类型的红包（家电）
     */
    public function actionListSub($type) {
        if ((int) $type < 1 || (int) $type > 12) {
            $this->redirect(array('list'));
            Yii::app()->end();
        }

        $bgPic = DOMAIN . '/images/bgs/redEnv1920X620.jpg';  //背景图片，大小1920*590 如果没有会很难看
        //获取显示数据总记录数，并配置分页
        $dataCount = CouponActivity::model()->searchCouponList($type, true);
        $criteria = new CDbCriteria();
        $pages = new CPagination($dataCount);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        //获取显示数据
        $datas = CouponActivity::model()->searchCouponList($type, false, 'limit ' . $pages->currentPage * $pages->pageSize . ',' . $pages->pageSize);

        $this->render('listsub', array(
            'datas' => $datas,
            'pages' => $pages,
            'bgPic' => $bgPic,
            'type' => $type,
        ));
    }

    /**
     * 盖惠券详情
     */
    public function actionDetail($id) {

        //分开做查询原因：1.都是用主键查询快。2.联表查询可能会慢一些。
        $couponData = Yii::app()->db->createCommand()
                ->select('id,name,price,condition,valid_start,valid_end,sendout,excess,thumbnail,store_id,status,state')
                ->from(CouponActivity::model()->tableName())
                ->where('id = :id', array(':id' => $id))
                ->queryRow();
        if (empty($couponData)) {
            throw new CHttpException('404', Yii::t('sellerCouponActivity', '您查看的盖惠券不存在'));
        }

        //店铺信息
        $storeData = Yii::app()->db->createCommand()
                ->select('id,name,category_id,description_match,serivice_attitude,speed_of_delivery,comments,thumbnail')
                ->from(Store::model()->tableName())
                ->where('id = :id', array(':id' => $couponData['store_id']))
                ->queryRow();
        if (empty($storeData)) {
            throw new CHttpException('404', Yii::t('sellerCouponActivity', '您查看的盖惠券不存在'));
        }

        //获取商家其它盖惠券
        $otherCouponData = Yii::app()->db->createCommand()
                        ->select('id,price,condition')->from(CouponActivity::model()->tableName())
                        ->where('id <> :id and store_id = :store_id', array(':id' => $id, ':store_id' => $couponData['store_id']))
                        ->limit(2)->queryAll();

        //检查是否已经领取了
        $received = false;
        if ($memberId = $this->getUser()->id) {
            $received = Yii::app()->db->createCommand()
                    ->select('id')->from(Coupon::model()->tableName())
                    ->where('coupon_activity_id=:id and member_id=:mid and status=:status and valid_end>:end', array(':id' => $id, ':mid' => $memberId, ':status' => Coupon::STATE_FREE, ':end' => time()))
                    ->queryScalar();
        }
        //领取按钮
        $button = array('class' => 'btnGeted', 'href' => '', 'content' => '');
        if ($received) {
            $button['content'] = Yii::t('Public', '已领取');
        } elseif ($couponData['status'] != CouponActivity::COUPON_STATUS_PASS || $couponData['state'] == CouponActivity::CONPON_STATE_OVER) {
            $button['content'] = Yii::t('Public', '已结束');
        } elseif ($couponData['state'] == CouponActivity::COUPON_STATE_NO) {
            $button['content'] = Yii::t('Public', '暂停领取');
        } elseif ($couponData['excess'] < 1) {
            $button['content'] = Yii::t('Public', '已领完');
        } else {
            $button['class'] = 'btnGetFree';
            $button['href'] = '';
            $button['content'] = Yii::t('Public', '免费领取');
        }

        //获取右侧底部广告
        $ads = array();
        $advert = Advert::getHongBaoCache('hongbao-detail-main-right');
        if (!empty($advert) && !empty($advert['pic'])) {
            if (AdvertPicture::isValid($advert['pic']['start_time'], $advert['pic']['end_time'])) {
                $ads = array('title' => $advert['pic']['title'], 'imgurl' => $advert['pic']['picture'], 'link' => $advert['pic']['link']);
            }
        }

        $this->render('detail', array(
            'button' => $button,
            'couponData' => $couponData,
            'storeData' => $storeData,
            'otherCouponData' => $otherCouponData,
            'ads' => $ads
        ));
    }

    /**
     * 红包分享
     */
    public function actionShare() {
        $model = Member::model()->find(array('select' => 'gai_number', 'condition' => 'id = :id', 'params' => array(':id' => $this->getUser()->id)));
        $this->render('share', array('model' => $model));
    }

    /**
     * 注册红包
     */
    public function actionRegister() {
        $this->render('register');
    }

    /**
     * 注册送红包
     * @throws CDbException
     * @throws CException
     * @throws CHttpException
     */
    public function actionRegisterCoupon() {
        //检查是否是移动设备，是则跳转
        $ad = $this->getParam('ad');
        if (Tool::isMobileDevice()) {
            $code = $this->getParam('code');  
            $array=array();
            $code ? $array['code']= $code : $array;
            $ad ? $array['ad'] = $ad : $array;
            $url = Yii::app()->createAbsoluteUrl('m/home/receiveRedBag',$array);
            $this->redirect($url);
        }

        $model = new Member('register');
        $this->performAjaxValidation($model);
        if(!empty($ad))
        {
            $sql = "update {{promotion_channels}} set visits = visits + 1 where number = '{$ad}'";
            Yii::app()->db->createCommand($sql,array(':number'=>$ad))->execute();
        }
        if (isset($_POST['Member'])) {
            $attributes = $this->getPost('Member');
            $model->attributes = $attributes;
            //更新推荐时间
            if (!empty($_POST['Member']['tmp_referrals_id'])) {
                $model->referrals_time = time();
            }
            //如果没有显示验证码，则赋值验证码，用于规则检查
            if ($this->getSession('showCaptcha') != 3) {
                $captcha = Yii::app()->getController()->createAction("captcha2");
                $code = $captcha->verifyCode;
                $model->verifyCode = $code;
            }
            $trans = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save()) {
                    throw new Exception('create Member error');
                }
                //保存推荐记录
                if (!empty($model->referrals_id)) {
                    $recommend_log = new RecommendLog();
                    $recommend_log->member_id = $model->id;
                    $recommend_log->parent_id = $model->referrals_id;
                    $recommend_log->create_time = $model->referrals_time;
                    $recommend_log->save();
                    //给推荐者派发红包
                    RedEnvelopeTool::createRedisActivity($model->referrals_id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_SHARE);
                }
                //给新注册的会员派发红包
                RedEnvelopeTool::createRedisActivity($model->id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_REGISTER);
                if(isset($ad) && !empty($ad))
                    PromotionChannels::addMemberFromPromotion($model->id, $ad);
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback();
                throw new CHttpException(503, Yii::t('memberHome', '注册失败!' . $e->getMessage()));
            }
            //同步注册到盖讯通
            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                $nickname = !empty($model->nickname) ? $model->nickname : $model->gai_number;
                Member::getSynchronous($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
            }
            //注册后自动登录
            $loginForm = new LoginForm;
            $loginForm->username = $model->gai_number;
            $loginForm->password = $attributes['password'];
            $loginForm->login();
            $url = Yii::app()->createAbsoluteUrl('/member/redEnvelope/index');
            $this->redirect($url);
        }


        $this->render('registerCoupon', array('model' => $model));
    }

    /**
     * ajax 获取手机验证码
     */
    public function actionGetMobileVerifyCode() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['mobile']) && preg_match("/(^\d{11}$)|(^852\d{8}$)/", $_POST['mobile'])) {
            $verifyCodeCheck = $this->getSession($_POST['mobile']);
            if ($verifyCodeCheck) {
                $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
                if ($verifyArr && (time() - $verifyArr['time'] < 60)) {
                    echo Yii::t('memberHome', '验证码正在发送，请等待{time}秒后重试', array('{time}' => '60'));
                    Yii::app()->end();
                }
            }
            $smsConfig = $this->getConfig('smsmodel');
            $tmpId = $smsConfig['phoneVerifyContentId'];
            //$verifyCode = '000000';
            $verifyCode = mt_rand(10000, 99999);
            $msg = Yii::t('memberHome', $smsConfig['phoneVerifyContent'], array('{0}' => $verifyCode));
            $data = array('time' => time(), 'verifyCode' => $verifyCode);
            //验证码同时写cookie\session 防止丢失
            $this->setCookie($_POST['mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5), 60 * 5);
            $this->setSession($_POST['mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5));
            if (Yii::app()->request->cookies[$_POST['mobile']]) {
                SmsLog::addSmsLog($_POST['mobile'], $msg, 0,SmsLog::TYPE_CAPTCHA,null,true,array($verifyCode),  $tmpId);
                echo 'success';
            } else {
                echo Yii::t('memberHome', '发送失败,请重试');
            }

            Yii::app()->end();
        }
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionPage() {
        $this->layout = false;
        $this->render('page');
    }

    public function actionPrizeName(){
        $this->render('prizeName');
    }

}
