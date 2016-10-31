<?php

/**
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class SiteController extends MController {

    public $layout = 'member';

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction','method'=>'selectLanguage'),
        );
    }
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * 会员后台首页，显示用户基本资料
     */
    public function actionIndex() {
        $name = $this->getSession('enterpriseId') ?  Yii::t('member','企业') : Yii::t('member','用户') ;
        $this->pageTitle =  $name.Yii::t('member', '基本资料_用户中心_') . Yii::app()->name;
        $this->layout = 'member';
        $enterpriseId = $this->getSession('enterpriseId');
		$waitReceiveNum = $waitCommentNum = $waitPayNum = $waitSendNum = 0;
		$collects = $orders = array();
		
		//增加优品汇内容
		$time   = time();
		$active = ActivityData::getActivityRulesSeting();
		if(!empty($active)){
		    foreach($active as $k=>$v){
				if($v['category_id'] == ActivityData::ACTIVE_SECKILL || $time>strtotime($v['end_dateline']) ){//过滤秒杀活动和过期的活动
				    unset($active[$k]);
				}
			}
		}
		
		 //待收货
        $waitReceiveNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and status=:status and delivery_status=:dStatus and refund_status=:refund_status and return_status=:return_status', array(
                ':mid' => $this->getUser()->id,
                ':status' => Order::STATUS_NEW,
                ':dStatus' => Order::DELIVERY_STATUS_SEND,
                ':refund_status' => Order::REFUND_STATUS_NONE,
                ':return_status' => Order::RETURN_STATUS_NONE,
            ))->queryScalar();
			
	    //待评价
        $waitCommentNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and status=:status and is_comment=:isC', array(
                ':mid' => $this->getUser()->id,
                ':status' => Order::STATUS_COMPLETE,
                ':isC' => Order::IS_COMMENT_NO,
            ))->queryScalar();
		//待付款 2015-08-10
		$waitPayNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and pay_status=:pay_status and status=:status', array(
                ':mid' => $this->getUser()->id,
                ':pay_status' => Order::PAY_STATUS_NO,
				':status' => Order::STATUS_NEW
            ))->queryScalar();
		
		//待发货 2015-08-10	
		$waitSendNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and pay_status=:pay_status and status=:status and delivery_status IN(:dWait, :dNot)', array(
                ':mid' => $this->getUser()->id,
                ':pay_status' => Order::PAY_STATUS_YES,
				':status' => Order::STATUS_NEW,
				':dWait' => Order::DELIVERY_STATUS_WAIT,
                ':dNot' => Order::DELIVERY_STATUS_NOT
            ))->queryScalar();
		
		//收藏的商品
		$collects = Yii::app()->db->createCommand()
		            ->select('g.id,g.name,g.market_price,g.price,g.thumbnail')
					->from('{{goods}} g')
					->join('{{goods_collect}} AS gc', 'gc.good_id=g.id')
		            ->where('gc.member_id= '.$this->getUser()->id)
					->order('gc.create_time DESC')
					->limit(12)
					->queryAll();
		
		//我的订单，取三个数据
		$orders = Yii::app()->db->createCommand()
		            ->select('o.*,g.*,COUNT(g.order_id) AS goodsNum')
					->from('{{order}} o')
					->join('{{order_goods}} AS g', 'o.id=g.order_id')
		            ->where('o.member_id= '.$this->getUser()->id)
					->order('o.create_time DESC')
					->group('g.order_id')
					->limit(3)
					->queryAll();
        if($enterpriseId){
            $this->render('store',array(
                'model'=>$this->model,
				'active'=>$active,
                'modelInfo'=>Enterprise::model()->findByPk($enterpriseId),
                'waitReceiveNum' => $waitReceiveNum,
                'waitCommentNum' => $waitCommentNum,
                'waitPayNum' => $waitPayNum,
                'waitSendNum' => $waitSendNum,
                'collects' => $collects,
                'orders' => $orders,
            ));
        }else{
            $this->render($this->getSession('enterpriseId') ? 'store' :'index', array(
                'model' => $this->model,
				'active' => $active,
				'waitReceiveNum' => $waitReceiveNum,
				'waitCommentNum' => $waitCommentNum,
				'waitPayNum' => $waitPayNum,
				'waitSendNum' => $waitSendNum,
				'collects' => $collects,
				'orders' => $orders,
            ));
        }

    }

    public function actionGetweather(){
        //天气信息
        set_time_limit(0);
        $url = 'http://i.tianqi.com/index.php';
        $params = array('c'=>'code','id'=>35,'icon'=>1,'num'=>4);
        $http = new HttpClient($url);
        $url = $url .'?'. $http->buildQueryString($params);
        $sHttpContents = $http->quickGet($url);
        echo $sHttpContents;die;
    }
	
	/**
     * 会员后台，显示用户个人信息
     */
    public function actionInfo() {
        $name = $this->getSession('enterpriseId') ?  Yii::t('member','企业') : Yii::t('member','用户') ;
        $this->pageTitle =  $name.Yii::t('member', '基本资料_用户中心_') . Yii::app()->name;
        $this->layout = 'member';
        $enterpriseId = $this->getSession('enterpriseId');
		
		
		
        if($enterpriseId){
            $this->render('store',array(
                'model'=>$this->model,
                'modelInfo'=>Enterprise::model()->findByPk($enterpriseId),
            ));
        }else{
            $this->render('info', array(
                'model' => $this->model,
            ));
        }

    }
	
	/**
	* 获取消息的数量
	*/
	public function actionGetMemberMessage(){
	    $userId = $this->getUser()->id;	
		
		if(!$userId){
			$count = 0;
		}else{
			$count = Mailbox::model()->with(
                         array('message' => array('condition' => 'receipt_time < ' . time()))
                         )->count(' member_id = ' . $userId);
		}
		
		echo json_encode(array('count'=>$count));
	}
    
	/**
	* 获取未读消息的数量 V2.0版
	*/
	public function actionGetNewMessage(){
	    $userId = $this->getUser()->id;	
		
		if(!$userId){
			$count = 0;
		}else{
			$count = Mailbox::model()->count('status=:status AND member_id=:userid',array(':status'=>Mailbox::STATUS_UNRECEIVE, ':userid'=>$userId));
		}
		
		echo json_encode(array('count'=>$count));
	}
	
}
