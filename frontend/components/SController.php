<?php

/**
 * 商家父控制器
 * @access wanyun.liu <wanyun_liu@163.com>
 */
class SController extends Controller {

    public $storeId;
    public $gameStoreId;//游戏店铺ID
    public $midLevId;//居间商表ID
    /**
     * @var 店小二id
     */
    public $assistantId;

    public function beforeAction($action) {
        $route = $this->id . '/' . $action->id;
        $this->storeId = $this->getSession('storeId');
        $this->assistantId = $this->getSession('assistantId');
        $memberId=$this->getUser()->id;
        $midLevRow=MiddleAgent::getMidId($memberId);
        $this->midLevId=$midLevRow['id'];
        $res=Store::model()->exists('is_middleman=:rid AND member_id=:mid',array(':rid'=>Store::STORE_ISMIDDLEMAN_YES,':mid'=>$memberId)); 
        $retArr=CityshowRights::model()->exists('member_id=:mid',array(':mid'=>$memberId)); 
        //$retArr=true;
        $this->setSession('isMidAgent',Store::STORE_ISMIDDLEMAN_NO);
        $this->setCookie('levelNum',MiddleAgent::LEVEL_PARTNER);
        $this->setSession('isCityshow',false);
        if($res){
                $this->setSession('isMidAgent',Store::STORE_ISMIDDLEMAN_YES); 
                $this->setCookie('levelNum',$midLevRow['level']);
          }
         if($retArr){
               $this->setSession('isCityshow',true);
           }else{
               if($this->id == 'cityshow' || $this->id == 'cityshowStore' || $this->id == 'cityshowTheme')
                 throw new CHttpException(403,'你没有权限访问此模块！');
          }
        /*
        if($this->getSession('enterpriseAuditing')!=Enterprise::AUDITING_YES){
            throw new CHttpException(403,'您的企业账户未审核，不能登录卖家平台');
        }
        */
          
        //没有申请店铺也可以访问的页面地址
        $publicPages = array(
            'store/apply',
            'store/view',
            'wealth/index',
        	'assistant/admin',
        	'sellerLog/index',
        	'assistant/create',
        	'assistant/update',
        	'assistant/delete',
        	'prepaidCard/index',
        );
        if(in_array($route,$publicPages)) return parent::beforeAction($action);

        //加盟商可以访问的控制器
        $franchiseeAccess = array(
            'store','prepaidCard','franchisee','assistant','sellerLog','assistantManage','region','home','slide',
            'ueditor','upload','wealth'
        );
        //是加盟商，不在可访问 contoller,跳转到店铺申请
        if(!in_array($this->id,$franchiseeAccess) && $this->getSession('franchiseeId') && !$this->getSession('storeId')){
            $this->redirect(array('/seller/store/apply'));
        }
        //非店铺，不是加盟商，跳到店铺申请
        if(!$this->storeId && !Yii::app()->user->isGuest && !$this->getSession('franchiseeId') && !in_array($route,$publicPages)){
            $this->redirect(array('/seller/store/apply'));
        }
        $status = $this->getSession('storeStatus');
        //不是申请通过，或者试用中，则跳转到店铺查看
        if($status != Store::STATUS_PASS  && $status != Store::STATUS_ON_TRIAL && !$this->getSession('franchiseeId') && !in_array($route,$publicPages)){
            $this->redirect(array('/seller/store/view'));
        }

        //是否有游戏店铺的设置
        $store = Store::model()->findByPk($this->getSession('storeId'));
        if($store){
            $model = GameStore::model()->findByAttributes(array('gai_number' => $store->member->gai_number));
            if($model){
                $this->setSession('gameStoreId',$model->id);
                $this->gameStoreId = $this->getSession('gameStoreId');
            }
        }
        return parent::beforeAction($action);
    }


    /**
     * 权限检查，用于操作删改数据的时候，检查是否属于该会员的数据
     * @param $storeId
     * @throws CHttpException
     */
    public function checkAccess($storeId) {
        if ($storeId !== $this->storeId) {
            throw new CHttpException(403,'你没有权限修改别人的数据！');
        }
    }

    /*
     * 游戏店铺权限检查
     */
    public function gameStoreCheck($storeId){
        $model = GameStore::model()->findByPk($this->gameStoreId);
        if(!$model){
            throw new CHttpException(403,'您还没有创建游戏店铺！');
        }
        if($storeId != $this->gameStoreId){
            throw new CHttpException(403, '非法操作!');
        }
    }

}
