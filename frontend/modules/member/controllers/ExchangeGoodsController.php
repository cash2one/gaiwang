<?php
/**
退换货类
*/

class ExchangeGoodsController extends MController
{
	public $layout = 'exchange';
    public $code;
    public $orderInfo;
	public $userId;
	public $exchangeId;
	public static $mime = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png', 'image/x-png');
	public $imagesCache = 'RETURN_IMAGES_';//退货图片凭证
    public $times = 3;//退换货申请次数限制
    public $percent = 0.05;//退款最低比率
	
	public function init()
    {
        $this->pageTitle = Yii::t('memberOrder', '用户中心_') . Yii::app()->name;
    }

	
	public function beforeAction($action){
		$this->layout = 'exchange';
        $this->code = $this->getParam('code',0);
		if($this->code > 0){
			$this->orderInfo = Order::getBackOrderInfo($this->code,$this->getUser()->id);
            if($this->orderInfo == false) $this->redirect(array('/member'));    //预防恶意修改其他用户订单
		}
        
		$this->userId = $this->getUser()->id;
        return parent::beforeAction($action);
	}
	
	/**
     * 退换货列表
     */
    public function actionAdmin()
    {
		$this->layout = 'member';
		$this->pageTitle = Yii::t('memberOrder', '退换货记录') . $this->pageTitle;
		$model = new Order('search');
        $model->unsetAttributes();
        
		$getOrder = $this->getParam('Order');
		if (isset($_GET['Order']) && isset($_GET['Order']['code']) && trim($_GET['Order']['code'])!=''){//由于2.0版本搜索合并,所以要处理提交数据
			if( preg_match('/^\d+$/', trim($_GET['Order']['code'])) ){//纯数字是是订单号,否则是商品名称
				$getOrder['code'] = trim($_GET['Order']['code']);
				$getOrder['goods_name'] = '';
			}else{
				$getOrder['code'] = '';
				$getOrder['goods_name'] = trim($_GET['Order']['code']);
			}
		}
		
		$time = isset($getOrder['exchange_apply_time']) ? $getOrder['exchange_apply_time'] : 0;
		$model->attributes = $getOrder;
		$c = $model->searchExchange($this->getUser()->id, $time);
        //分页
        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($c);
        $orders = $model->findAll($c);
		
		//$returnStatus = Order::returnStatus();//退货状态
		//$refundStatus = Order::refundStatus();//退款状态	
		$exchangeStatus = Order::exchangeStatus();//退换货状态
		
		
		//1465998  133612
		if(!empty($orders)){
		    foreach($orders as $k=>$v){
				if($v['exchange_status'] == Order::EXCHANGE_STATUS_RETURN){
				    $orders[$k]['return_time'] = self::DealTime($v['exchange_examine_time']);
				}else{
					$orders[$k]['return_time'] = self::DealTime($v['exchange_apply_time']);
				}
			}
		}
		$this->render('admin', array(
            'model' => $model,
            'orders' => $orders,
            'pages' => $pages,
			'exchangeStatus' => $exchangeStatus
        ));
	}

    /**
     * 退换货首页
     */
    public function actionBackGoods(){
        $code   = $this->getParam('code',0);
        if($code > 0 && $this->userId){
            $type = Yii::app()->db->createCommand()->select('source_type')->from('{{order}}')->where('code=:code',array(':code'=>$code))->queryScalar();
            $this->render('backgoods',array('orderType'=>$type));
        }else{
            $this->redirect(array('/member'));
        }
    }
	
	/**
	* 退货功能 第一步填写退货相关资料
	* 退货条件：新订单、已支付、已发货
	*/
	public function actionReturnGoods(){
		$model  = new Order();
		$code   = $this->getParam('code');

		$data   = array('code'=>$code);
		$time   = time();
		
		$model->scenario = 'exchangeGoods';
		$this->performAjaxValidation($model);
		$exchangeReason = Order::exchangeReason();//退换货原因
		
		if(!empty($_POST['Order'])){
			$post   = $this->getParam("Order");
			
			//获取order表的id/status/delivery_status/pay_status/pay_price/freight
			$order = Yii::app()->db->createCommand()->select('id,status,delivery_status,pay_status,pay_price,freight,is_comment')->from('{{order}}')
					   ->where('code=:code AND member_id=:userId', array(':code'=>$post['code'], ':userId'=>$this->userId))
					   ->queryRow();
			
			if(empty($order)){//订单号不正确
			    self::deleteUploadImages($post['exchange_images']);
				$this->setFlash('error',  Yii::t('memberOrder','错误的订单号!'));
                $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));
				exit;
			}else{
			    if($order['delivery_status'] != Order::DELIVERY_STATUS_SEND || $order['pay_status']!=Order::PAY_STATUS_YES || $order['status']!=Order::STATUS_NEW || $order['is_comment']!=Order::IS_COMMENT_NO){
				    self::deleteUploadImages($post['exchange_images']);
					$this->setFlash('error',  Yii::t('memberOrder','订单不满足退货条件!'));
					$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/BackGoods', array('code'=>$code)));
					exit;
				}
				
				$refund    = sprintf("%.2f",$order['pay_price'] - $order['freight']);
				$minRefund = sprintf("%.2f",$refund * $this->percent); 
				if($post['exchange_money'] < $minRefund || $post['exchange_money'] > $refund){//申请的退款比支付价格大或者小于支付金额的最低百分比,则不通过
				    //若有上传图片,则删除图片
					self::deleteUploadImages($post['exchange_images']);
					
					$this->setFlash('error', Yii::t('memberOrder', '退款金额必须在指定范围内'));
                    $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnGoods', array('code'=>$post['code'])));
					exit;
				}
			}
			
			//入退换货表
			$post['member_id']           = $this->userId;
			$post['order_id']            = $order['id'];
			$post['exchange_type']       = Order::EXCHANGE_TYPE_RETURN;
			$post['exchange_apply_time'] = $time;
            $post['exchange_code'] = Tool::buildOrderNo(20,'EX');
			
			unset($post['code']);
			Yii::app()->db->createCommand()->insert("{{order_exchange}}",$post);
			$exchangeId = Yii::app()->db->getLastInsertID();
			
			//修改订单表,为了兼容旧的流程
			Yii::app()->db->createCommand()->update("{{order}}",
			    array('return_reason'=>$post['exchange_description'], 'return_status'=>Order::REFUND_STATUS_PENDING, 'deduct_freight'=>$order['freight'] , 'apply_return_time'=>$time),
				'id=:id', array(':id' => $order['id']));
			
			//申请成功,等待卖家审核
			$this->setFlash('success', Yii::t('memberOrder', '已申请退货,商家审核中,请稍候'));
            $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnExamine', array('id'=>$exchangeId)));
		
		}else{
			
			//获取order表的id/status/delivery_status/pay_status/pay_price/freight
			$order = Yii::app()->db->createCommand()->select('id,status,delivery_status,pay_status,pay_price,freight')->from('{{order}}')
					   ->where('code=:code AND member_id=:userId', array(':code'=>$code, ':userId'=>$this->userId))
					   ->queryRow();
			
			if(empty($order)){
				$this->setFlash('error',  Yii::t('memberOrder','错误的订单号!'));
                $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/backGoods', array('code'=>$code)));
				exit;
			}else{
				
				//判断申请次数
				self::checkExchange($code, Order::EXCHANGE_TYPE_RETURN);
				
				//退货条件：新订单、已支付、已发货
			    if($order['delivery_status'] == Order::DELIVERY_STATUS_SEND && $order['pay_status']==Order::PAY_STATUS_YES && $order['status']==Order::STATUS_NEW){	
				    $this->render('returnGoods',array(
						'model' => $model,
						'data' => $data,
						'order' => $order,
						'exchangeReason' => $exchangeReason
						));
				}else{
					$this->setFlash('error',  Yii::t('memberOrder','订单不满足退货条件!'));
					$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/BackGoods', array('code'=>$code)));
					exit;
				}
			}		
		}	
	}
	
	/**
	* 退货功能 第二步卖家审核中等状态
	*/
	public function actionReturnExamine(){
		$model      = new Order();
		$exchangeId = $this->getParam('id');
		$data       = array( 'exchangeId'=>$exchangeId, 'code'=>'');
		
		$model->scenario = 'exchangeExamine';
		$this->performAjaxValidation($model);
		
		if(!empty($_POST['Order'])){//处理提交数据
		    $post = $this->getParam("Order");
			
			$post['exchange_status'] = Order::EXCHANGE_STATUS_REFUND;
			$post['exchange_examine_time'] = time();
			$update = Yii::app()->db->createCommand()->update('{{order_exchange}}', $post, 'exchange_id=:id', array(':id' => $post['exchange_id']));
			if(!$update){//保存不成功
				$this->setFlash('error',  Yii::t('memberOrder','保存信息失败,请重新填写信息!'));
				$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnExamine', array('id'=>$post['exchange_id'])));
				exit;
			}
			
			$this->setFlash('success',  Yii::t('memberOrder','保存信息成功,等待卖家退款!'));
			$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnExamine', array('id'=>$post['exchange_id'])));
			exit;
			
		}else{//列表页面
		    
			$result = Yii::app()->db->createCommand()->select('e.*,o.code,o.store_id')
						->from('{{order_exchange}} AS e')
						->join('{{order}} AS o', 'e.order_id = o.id')
						->where('e.exchange_id=:exchangeId AND e.member_id=:userId', array(':exchangeId'=>$exchangeId, ':userId'=>$this->userId))
						->queryRow();
			
			if(empty($result)){
				$this->setFlash('error',  Yii::t('memberOrder','错误的退换货编号!'));
				$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));
				exit;
			}
			
			$orderInfo = Order::getBackOrderInfo($result['code'],$this->userId);
			$data['code'] = $result['code'];
			
			//物流公司
			$express = Express::getExpressUrl();
			
			//获取店铺信息
			$store  = Yii::app()->db->createCommand()->select('*')->from('{{store}}')
					     ->where('id=:storeId', array(':storeId'=>$result['store_id']))
					     ->queryRow();
			
			if($result['exchange_status'] == Order::EXCHANGE_STATUS_WAITING ){
				$result['return_time'] = self::DealTime($result['exchange_apply_time'], 7);
			}else if($result['exchange_status'] == Order::EXCHANGE_STATUS_RETURN){
				$result['return_time'] = self::DealTime($result['exchange_examine_time'], 7);
			}
			if($result['exchange_status'] == Order::EXCHANGE_STATUS_REFUND){
				$result['return_time'] = self::DealTime($result['exchange_examine_time'], 10);
			}
			
			$this->render('returnExamine',array(
							'model' => $model,
							'data' => $data,
							'orderInfo' => $orderInfo,
							'result' => $result,
							'store' => $store,
							'express' => $express,
							'exchangeStatus' => Order::exchangeStatus()
							));
				
		}
		
	}

    /**
     * 我要退款无需退货
     */
    public function actionReturnNullGoods(){
        $code  = $this->getParam('code');
		$model = new Order();
		$model->scenario = 'exchangeRefund';
		$this->performAjaxValidation($model);
		
        if(!empty($_POST['Order'])){

            $post = $OrderData = $this->getParam("Order");
            $OrderData['member_id'] =   $this->getUser()->id;
            $OrderData['exchange_apply_time'] = time();
			$OrderData['exchange_type'] = Order::EXCHANGE_TYPE_REFUND;
            $OrderData['exchange_code'] = Tool::buildOrderNo(20,'EX');
			
			//获取order表的id/status/pay_status/pay_price/freight
			$order = Yii::app()->db->createCommand()->select('id,status,pay_status,pay_price,freight,is_comment')->from('{{order}}')
					   ->where('code=:code AND member_id=:userId', array(':code'=>$code, ':userId'=>$this->userId))
					   ->queryRow();
			
			if(empty($order)){//订单号不正确
				$this->setFlash('error',  Yii::t('memberOrder','错误的订单号!'));
                $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));
				exit;
			}else{

				if($order['pay_status']!=Order::PAY_STATUS_YES || $order['status']!=Order::STATUS_NEW || $order['is_comment']!=Order::IS_COMMENT_NO){
					$this->setFlash('error',  Yii::t('memberOrder','订单不满足退货条件!'));
					$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/BackGoods', array('code'=>$code)));
					exit;
				}
				$refund    = sprintf("%.2f",$order['pay_price']);
				$minRefund = sprintf("%.2f",$refund * $this->percent); 
				if($OrderData['exchange_money']<=0 || $OrderData['exchange_money'] > $refund){//申请的退款比支付价格大或者小于支付金额的最低比例,则不通过
				    //若有上传图片,则删除图片
					self::deleteUploadImages($post['exchange_images']);
					
					$this->setFlash('error', Yii::t('memberOrder', '退款金额必须在指定范围内'));
                    $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnNullGoods', array('code'=>$code)));
					exit;
				}
			}
			
            Yii::app()->db->createCommand()->insert("{{order_exchange}}",$OrderData);

            /**
             * 兼容旧系统数据
             */
            $oldOrderData = array('refund_status'=>Order::REFUND_STATUS_PENDING,'refund_reason'=>$OrderData['exchange_description'],'apply_refund_time'=>time());

            Yii::app()->db->createCommand()->update("{{order}}",$oldOrderData,'code='.$code);

            $id = Yii::app()->db->createCommand()->select('exchange_id')->from("{{order_exchange}}")->where("order_id=:order_id",array(':order_id'=>$OrderData['order_id']))->queryAll();

            $this->redirect($this->createAbsoluteUrl("/member/exchangeGoods/waitreturnnullgoods",array('id'=>$id[count($id)-1]['exchange_id'])));
        }else{
            
            $data = array('code'=>$code);

            $orderData = Yii::app()->db->createCommand()->select("pay_price,id,freight")->from("{{order}}")
                         ->where("code=:code",array(':code'=>$code))->queryRow();

            if(empty($orderData) || $orderData['pay_price'] == 0){
                $this->setFlash('error',  Yii::t('memberOrder','订单不满足退款条件!'));
                $this->redirect($this->createAbsoluteUrl('/member/order/admin'));
            }

            self::checkExchange($code,Order::EXCHANGE_TYPE_REFUND);

            //$imgModel = new GoodsPicture; //商品多图片模型
            //$model->scenario = 'exchangeGoods';
            //$orderData['pay_price'] =  $orderData['pay_price'] - $orderData['freight'];
            $exchangeReason = Order::exchangeReason();//退换货原因
            $this->render('returnnullgoods',array(
                'model' => $model,
                'data'=>$data,
                'exchangeReason' => $exchangeReason,
                //'imgModel'=>$imgModel,
                'orderData'=>$orderData
            ));
        }

    }

    /**
     * 等待退款中
     */
    public function actionWaitReturnNullGoods(){
        $result = array();
        $exchange_id = $this->getParam("id");

        if(empty($exchange_id) || $exchange_id == 0){
            $this->setFlash('error',  Yii::t('memberOrder','非法进入!'));
            $this->redirect($this->createAbsoluteUrl('/member/order/admin'));
        }

        $result = Yii::app()->db->createCommand()->select("exchange_examine_reason,exchange_code,exchange_reason,exchange_status,exchange_money,exchange_apply_time")->from("{{order_exchange}}")
                ->where("exchange_id=:exchange_id",array(':exchange_id'=>$exchange_id))->queryRow();

        if(empty($result)){
            $this->setFlash('error',  Yii::t('memberOrder','没有该单退款信息!'));
            $this->redirect($this->createAbsoluteUrl('/member/order/admin'));
        }

        $info['exchange_reason'] = Order::exchangeReason($result['exchange_reason']);
        $info['status'] = Order::exchangeStatus($result['exchange_status']);
        $info['exchange_status'] = $result['exchange_status'];
        $info['exchange_money'] = $result['exchange_money'];
        $info['exchange_apply_time'] = $result['exchange_apply_time'] + Order::EX_CHANGE_TIME - time();
        $info['exchange_examine_reason'] = $result['exchange_examine_reason'];
		$info['exchange_id'] = $exchange_id;
        $info['exchange_code'] = $result['exchange_code'];
        $code = Yii::app()->db->createCommand()->select('o.code')
            ->from('{{order_exchange}} AS e')
            ->join('{{order}} AS o', 'e.order_id = o.id')
            ->where('e.exchange_id=:exchangeId AND e.member_id=:userId', array(':exchangeId'=>$exchange_id, ':userId'=>$this->userId))
            ->queryScalar();
        $orderInfo = Order::getBackOrderInfo($code,$this->userId);

        $this->render('waitreturnnullgoods',array('orderInfo'=>$orderInfo,
                                                  'info'=>$info,
												  'code'=>$code,
												  'exchangeStatus' => Order::exchangeStatus()));
    }
    
	
	/**处理显示时间*/
	public static function DealTime($time, $day=7){
		$time = $time + Order::EX_CHANGE_TIME - time();
		if($time<1){
			return '0天0小时0分0秒';
		}else{
			$d = floor($time/86400);
			$h = floor($time/3600%24);
			$m = floor($time/60%60);
			$s = $time%60;
			return "{$d}天{$h}小时{$m}分{$s}秒";
		}
	}
	
	/**
	* 处理上传图片
	*/
	public function actionUploadImages(){
		$config = $this->getConfig('upload');
        $data   = array('success'=>false, 'message'=>Yii::t('member', '上传失败'), 'file'=>'', 'path'=>'');
		
		$errorCode = self::UploadCode();
        if($this->isAjax()){
            //判断图片是否符合上传
            $file = CUploadedFile::getInstanceByName('img_path');
            if($file->error){
				$data['message'] = $errorCode[$file->error];
				echo json_encode($data);
				exit();
			}
			
			if($file->size > 1024*1024*5){
				$data['message'] = Yii::t('member', '上传的图片超过5M');
				echo json_encode($data);
				exit();
			}
			
			if(!in_array($file->type, self::$mime)){
				$data['message'] = Yii::t('member', '只能上传bmp,gif,jpg,png,jpeg格式');
				echo json_encode($data);
				exit();
			}
            
            //图片上传
			$ext      = '.'.$file->getExtensionName();
			$filename = 'exchangeGoods/' . date('Y/m/d').'/'. Tool::generateSalt() . $ext;;
			
            $result = UploadedFile::upload_file($file->getTempName(),$filename);
            if(!$result){
				$data['message'] = Yii::t('member', '上传出错,请重新上传');
				echo json_encode($data);
				exit();
			}else{
				$data['success'] = true;
				$data['message'] = Yii::t('member', '上传成功');
				$data['file']    = $filename;
				$data['path']    = ATTR_DOMAIN . '/'. $filename;
				echo json_encode($data);
				exit();
			}
        }else{
			$this->setFlash('error',  Yii::t('member','错误的请求!'));
            $this->redirect($this->createAbsoluteUrl('/member/site/index'));
		}
        
	}
	
	/**删除已上传的图片*/
	public function actionDeleteImages(){
		$data = array('success'=>false, 'message'=>Yii::t('member', '删除失败'));
		
		if($this->isAjax()){
            $file   = Yii::app()->request->getPost('file');
			$file   = UPLOAD_REMOTE ? $file : Yii::getPathOfAlias('att').'/'.$file;
            $result = UploadedFile::delete($file);
            if($result){
                $data['success'] = true;
				$data['message'] = Yii::t('member', '删除成功');
            }
			echo json_encode($data);
			exit;
			
        }else{
			$this->setFlash('error',  Yii::t('member','错误的请求!'));
            $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));   
		}
	}
	
	/*上传成功或出错的代码*/
	public static function UploadCode(){
		return array(
				   0 => Yii::t('memberOrder', '文件上传成功'),
				   1 => Yii::t('memberOrder', '上传的文件大小超出了服务器的限制'),
				   2 => Yii::t('memberOrder', '上传的文件大小超出了表单的限制'),
				   3 => Yii::t('memberOrder', '上传的文件不完整'),
				   4 => Yii::t('memberOrder', '没找到上传文件')
			  );
	}
	
	/*提交保存时,若有图片则删除上传的图片*/
	public static function deleteUploadImages($images = ''){
	    $images = trim($images);
		
		$arr = $images!='' ? explode('|', $images) : array();
		if(!empty($arr)){
			foreach($arr as $v){
				$file   = UPLOAD_REMOTE ? $v : Yii::getPathOfAlias('att').'/'.$v;
				UploadedFile::delete($file);
			}
		}
		return true;
	}
	
	/*取消退货申请*/
	public function actionCancelReturnGoods(){
		$data = array('success'=>false, 'message'=>Yii::t('memberOrder', '非法操作'));
		$id   = $this->getParam('id');
		
		$result = Yii::app()->db->createCommand()->select('e.exchange_id,e.exchange_status,o.id,o.code,o.status,o.return_status')
		              ->from('{{order_exchange}} AS e')
					  ->join('{{order}} AS o', 'e.order_id=o.id')
					  ->where('e.exchange_id=:id AND e.member_id=:userId', array(':id'=>$id, ':userId'=>$this->userId))
					  ->limit('1')
					  ->queryRow();
	    if(empty($result)){
		    echo json_encode($data);
			exit;	
		}else{
		    if($result['exchange_status'] == Order::EXCHANGE_STATUS_DONE || $result['exchange_status'] == Order::EXCHANGE_STATUS_CANCEL){
				$data['message'] = Yii::t('memberOrder', '该订单已完成或已取消,不能再取消');
				echo json_encode($data);
			    exit;
			}
			
			//更新gw_order_exchange表数据, 为了兼容旧流程同时更新gw_order表的数据
			Yii::app()->db->createCommand()->update('{{order_exchange}}', array('exchange_status' => Order::EXCHANGE_STATUS_CANCEL), 'exchange_id=:id', array(':id' => $result['exchange_id']));
			Yii::app()->db->createCommand()->update('{{order}}', array('return_status' => Order::RETURN_STATUS_CANCEL,'status' => Order::STATUS_NEW), 'id=:id', array(':id' => $result['id']));	
		}
		
		$data['success'] = true;
		$data['message'] = Yii::t('memberOrder', '取消退货成功');
		echo json_encode($data);
		exit;
	}
	
	/*取消退款不退货申请*/
	public function actionCancelReturnNullGoods(){
		$data = array('success'=>false, 'message'=>Yii::t('memberOrder', '非法操作'));
		$id   = $this->getParam('id');
		
		$result = Yii::app()->db->createCommand()->select('e.exchange_id,e.exchange_status,o.id,o.code,o.status,o.refund_status')
		              ->from('{{order_exchange}} AS e')
					  ->join('{{order}} AS o', 'e.order_id=o.id')
					  ->where('e.exchange_id=:id AND e.member_id=:userId', array(':id'=>$id, ':userId'=>$this->userId))
					  ->limit('1')
					  ->queryRow();
	    if(empty($result)){
		    echo json_encode($data);
			exit;	
		}else{
		    if($result['exchange_status'] == Order::EXCHANGE_STATUS_DONE || $result['exchange_status'] == Order::EXCHANGE_STATUS_CANCEL){
				$data['message'] = Yii::t('memberOrder', '该订单已完成或已取消,不能再取消');
				echo json_encode($data);
			    exit;
			}
			
			//更新gw_order_exchange表数据, 为了兼容旧流程同时更新gw_order表的数据  原商城没有取消退款功能,故refund_status直接改为退款失败
			Yii::app()->db->createCommand()->update('{{order_exchange}}', array('exchange_status' => Order::EXCHANGE_STATUS_CANCEL), 'exchange_id=:id', array(':id' => $result['exchange_id']));
			Yii::app()->db->createCommand()->update('{{order}}', array('refund_status' => Order::REFUND_STATUS_FAILURE), 'id=:id', array(':id' => $result['id']));	
		}
		
		$data['success'] = true;
		$data['message'] = Yii::t('memberOrder', '取消退款不退货成功');
		echo json_encode($data);
		exit;
	}
	
	/**
	* 判断订单是否申请了三次
	* @param string $code 订单编号
	* @param integer $type 退换货类型 1为退货 2为退款不退货
	*/
	public function checkExchange($code = '', $type = 0){
		if(!$code) return true;

	    $result = Yii::app()->db->createCommand()->select('e.exchange_id,e.exchange_code,e.order_id,e.exchange_status,e.exchange_type')
					  ->from('{{order_exchange}} AS e')
					  ->join('{{order}} AS o', 'e.order_id = o.id')
					  ->where('o.code=:code AND o.member_id=:userId', array(':code'=>$code, ':userId'=>$this->userId))
					  ->order('e.exchange_id DESC')
					  ->queryAll();
		
		if( !empty($result) ){//还没有申请的,不做判断
			//最多只能申请三次退换货
            if (isset($this->times)) {
                if(count($result) >= $this->times){
                    $this->setFlash('error',  Yii::t('memberOrder','最多只能申请三次退换货!'));
                    $this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));
                    exit;
                }
            }
			
			foreach($result as $v){
				
				//已完成的,不能再申请
				if($v['exchange_status'] == Order::EXCHANGE_STATUS_DONE){
					$this->setFlash('error',  Yii::t('memberOrder','已完成退换货操作,不能再次申请!'));
					$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/admin'));
					exit;
				
				//还有未完成的退换货记录 直接跳转到对应的页面
				}else if($v['exchange_status'] != Order::EXCHANGE_STATUS_NO && $v['exchange_status'] != Order::EXCHANGE_STATUS_CANCEL){
					if($v['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){//退货
						$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/returnExamine', array('id'=>$v['exchange_id'])));
						exit;
					}else if($v['exchange_type'] == Order::EXCHANGE_TYPE_REFUND){//退款不退货
						$this->redirect($this->createAbsoluteUrl('/member/exchangeGoods/waitReturnNullGoods', array('id'=>$v['exchange_id'])));
						exit;
					}
				}
			}
			

		}
		
		return true;	
	}
	
	/**
	* 查看订单的物流信息
	* @param int $code 订单号
	*
	*/
	public function actionLookupExpress(){
		$code = $this->getParam('code');
		$type = $this->getParam('type');//1为查看订单的物流  2为查看退换货的物流		
		$model = new Order();

		$orderInfo = Order::getBackOrderInfo($code,$this->userId);
		if(empty($orderInfo)){
			$this->setFlash('error',  Yii::t('memberOrder','错误的订单号!'));
			$this->redirect($this->createAbsoluteUrl('/member/site/index'));
			exit;
		}
		
		if($type == 1){
			$express = array('express'=>$orderInfo['memberInfo']['express'], 'code'=>$orderInfo['memberInfo']['shipping_code']);
		}else{
			$result = Yii::app()->db->createCommand()->select('e.logistics_company, e.logistics_code')
					  ->from('{{order_exchange}} AS e')
					  ->join('{{order}} AS o', 'e.order_id = o.id')
					  ->where('o.code=:code AND e.member_id=:userId', array(':code'=>$code, ':userId'=>$this->userId))
					  ->queryRow();
			$express = array('express'=>$result['logistics_company'], 'code'=>$result['logistics_code']);
		}
		
		
		$this->render('lookupExpress',array(
					  'model' => $model,
					  'orderInfo' => $orderInfo,
					  'express' => $express,
					  'code' => $code,
					  'expressUrl' => Express::getExpressUrl()
					  ));
	}
}