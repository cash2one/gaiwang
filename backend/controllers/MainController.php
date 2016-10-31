<?php

/**
 * 后台默认控制器
 * 管理主导航栏
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MainController extends Controller {

    public $layout = false;

    public function filters() {
        return array(
            'rights',
        );
    }

    public function allowedActions() {
        return 'index, userInfo';
    }

    /**
     * 默认
     */
    public function actionIndex() {
        $menus = $this->getMenu('administrators');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 用户信息
     */
    public function actionUserInfo() {
        $menus = $this->getMenu('userInfo');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 网站配置管理
     */
    public function actionSiteConfigurationManagement() {
        $menus = $this->getMenu('webConfig');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 管理员管理
     */
    public function actionAdministrators() {
        $menus = $this->getMenu('administrators');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 会员管理
     */
    public function actionMemberManagement() {
        $menus = $this->getMenu('memberManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 充值兑现管理
     */
    public function actionRechargeCashManagement() {
        $menus = $this->getMenu('rechargeCashManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 统计管理
     */
    public function actionStatisticsManagement() {
        $menus = $this->getMenu('statisticsManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 酒店管理
     */
    public function actionHotelManagement() {
        $meuns = $this->getMenu('hotelManagement');
        $this->render('index', array('menus' => $meuns));
    }
    /**
     * 新版酒店管理
     */
    public function actionTravelManagement() {
        $meuns = $this->getMenu('travelManagement');
        $this->render('index', array('menus' => $meuns));
    }

    /**
     * 商城管理
     */
    public function actionMallManagement() {
        $meuns = $this->getMenu('mallManagement');
        $this->render('index', array('menus' => $meuns));
    }
    
    /**
     * 微商城管理
     */
    public function actionMshopManagement() {
        $meuns = $this->getMenu('mshopManagement');
        $this->render('index', array('menus' => $meuns));
    }

    /**
     * APP管理
     */
    public function actionAppManagement() {
        $meuns = $this->getMenu('appManagement');
        $this->render('index', array('menus' => $meuns));
    }

    /**
     * 交易管理
     */
    public function actionTradeManagement() {
        $meuns = $this->getMenu('tradeManagement');
        $this->render('index', array('menus' => $meuns));
    }

    /**
     * 团购管理
     */
    public function actionGroupbuyManagement() {
        $menus = $this->getMenu('groupbuyManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 客服管理
     */
    public function actionServiceManagement() {
        $menus = $this->getMenu('serviceManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 补充协议管理
     */
    public function actionSideAgreementManagement() {
        $menus = $this->getMenu('sideAgreementManagement');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 盖象APP管理
     */
    public function actionGateApp() {
        $menus = $this->getMenu('gateApp');
        $this->render('index', array('menus' => $menus));
    }

    /**
     * 游戏配置管理
     */
    public function actionGameConfig() {
        $menus = $this->getMenu('gameConfig');
        $this->render('index', array('menus' => $menus));
    }
    
}
