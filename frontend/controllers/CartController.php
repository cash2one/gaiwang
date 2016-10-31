<?php

/**
 * 购物车控制器
 * @author binbin.liao  <277250538@qq.com>
 */
class CartController extends Controller {


    public function actionSeckill()
    {
        if ($this->isAjax()) {
            $goods_id = $this->getParam('goods_id'); //商品id
            $spec_id = $this->getParam('spec_id'); //规格id
//            $quantity = $this->getParam('quantity', 1); //数量
            $goods = Goods::getCartGoodsDetail($goods_id);
            $setting = ActivityData::getGoodsRunnigSetting($goods_id,$goods['seckill_seting_id']);





        }
    }
    /**
     * ajax 添加到购物车
     */
    public function actionAddCart() {
        if ($this->isAjax()) {
            $goods_id = $this->getParam('goods_id'); //商品id
            /* 商品价格是不取规格表的价格因为那里面是不存价格的了,所以要取商品表的数据 */
            $goodsData = Goods::getCartGoodsDetail($goods_id);
			
			//如果商品参加了活动,则直接跳转到商品详情页(2015-06-09 李文豪)
			$url     = '';
			$referer = $_SERVER['HTTP_REFERER'];
			if($goodsData['seckill_seting_id']>0 && !preg_match('/\/(JF|goods)\/(\d+)\.html/i',$referer)){
				$data = array('url'=>$this->createAbsoluteUrl('/goods/view', array('id' => $goodsData['id'])));
				$cb   = $this->getParam('jsoncallBack');
				exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
			}
	    
            //如果还没登录,直接跳到登录页  2015-06-26测试部又要求不跳转登录页
            $userId =  Yii::app()->user->id;
            /*if(!isset($userId)){
                $data = array('login'=>$this->createAbsoluteUrl('/member/home/login'));
		        $cb   = $this->getParam('jsoncallBack');
		        exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
            }*/

            //如果没有绑定手机，就直接跳转绑定手机页面 (2015-10-22 廖佳伟)
            if(isset($userId)){
                $phone = Member::checkUserPhoneById($userId);
                if($phone['mobile'] == ''){
                    $msg = array('success'=>'2','error'=>'尊敬的用户，请您绑定手机号码。','url'=>$this->createAbsoluteUrl('member/mobile'));
                    exit(CJSON::encode($msg));
                }
            }

            
            if ($goodsData['life'] == Goods::LIFE_YES) {
                $msg['error'] = Yii::t('cart', '当前商品已经被删除');
            }
            if ($goodsData['is_publish'] == Goods::PUBLISH_NO) {
                $msg['error'] = Yii::t('cart', '当前商品已经下架');
            }
            if ($goodsData['status'] != Goods::STATUS_PASS) {
                $msg['error'] = Yii::t('cart', '当前商品审核未通过');
            }
            $storeId   = $goodsData['store_id']; //商品所属商家id
            $spec_id   = $this->getParam('spec_id'); //规格id
            $quantity  = $this->getParam('quantity', 1); //数量
			$special   = intval($this->getParam('special')); //特殊商品或者直接购买
            $goodsSpec = GoodsSpec::getSpecData($spec_id, array('price', 'stock'));
            $msg = array();
            $shopCart = new ShopCart();
            //获取购物车数组数量，如果购物车数组为空，购物车数组数量为0
            $cartNum = !empty($shopCart->goodsList[$goods_id . '-' . $spec_id]) ? $shopCart->goodsList[$goods_id . '-' . $spec_id]['quantity'] : 0;
            //产品库存不计算购物产品数量 qiuye.xu
            //判断是否购买数量是否超越库存
            //if (($quantity + $cartNum) > $goodsSpec['stock']) {
            if ($quantity > $goodsSpec['stock']) {
                $msg['error'] = Yii::t('cart', '购买数量超过当前库存');
            }
            //判断是否商家自己购买自家店的商品
            if (!empty($storeId) && $storeId == $this->getSession('storeId')) {
                $msg['error'] = Yii::t('cart', '不能购买自己店铺的商品');
            }
            //判断购物车的数量不能超过20种
            if (count($shopCart->goodsList) >= $shopCart::MAX_NUM_LIMIT) {
                $msg['error'] = Yii::t('cart', '购物车的数量不能超过20种商品');
            }
            //如果是特殊商品，或者合约机，只能添加购物车一次
            if ((ShopCart::checkHyjGoods($goods_id) || ShopCart::checkSpecialGoods($goods_id)) && $cartNum >= 1) {
                $msg['success'] = 1;
                $msg['num'] = 1;
                $msg['price'] = 1;
            }
            
			//由于新的专题活动替换了原来的红包活动,这部分改掉(2015-06-10 李文豪)
            /*if($goodsData['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($goodsData['activity_tag_id']) && $goodsData['at_status'] == Activity::STATUS_ON && $cartNum >=1){
                $msg['success'] = 1;
                $msg['num'] = 1;
                $msg['price'] = 1;
            }*/
            
            //判断有没有该商品的未支付定单
			$nowTime  = time();
			$quantity = abs(intval($quantity));//确保数量不为负数
			$relation = ActivityData::getRelationInfo($goodsData['seckill_seting_id'], $goods_id);
			$seting   = ActivityData::getActivityRulesSeting($goodsData['seckill_seting_id']);
			$rs       = ActivityTag::checkCreateRedOrder($this->getUser()->id, $goods_id,$goodsData['seckill_seting_id']);
			
			//若是活动商品，活动时间还没开始，不能购买
			if(!empty($seting) && !empty($relation) && strtotime($seting['start_dateline'])>$nowTime && $seting['status']>1 && $relation['status']==1){
				$url = '';
				$msg['error'] = Yii::t('seckill', '抱歉,活动还没开始！');
			}
			
			
			if($rs['status'] !== 1){
				$allNum = $rs['quantity']+$cartNum+$quantity;//订单,购物车,当前加入购物车三者的数量加起来不能超过活动的限制
				if($rs['status']==3){
					if(intval($userId) > 0 && $allNum>$seting['buy_limit'] && $seting['buy_limit']>0){
						$url = '';
						$msg['error'] = Yii::t('orderFlow', '已达活动购买数量限制,请查看订单和购物车内容');
					}else{
						$url = $rs['url'];
					    $msg['error'] = Yii::t('orderFlow', $rs['msg']);
					}
					
				}else{
					if($rs['status'] == 2 || ($allNum>$seting['buy_limit'] && $seting['buy_limit']>0)){
						$url = $rs['url'];
						$msg['error'] = $rs['status']==2 ? Yii::t('orderFlow', $rs['msg']) : Yii::t('orderFlow','已达活动购买数量限制,请查看订单和购物车内容');
					}
				}
            }else{
				//红包和应节性活动处理 (2015-06-10 李文豪)
				if(!empty($relation) && !empty($seting) && $relation['status']==1){//两个缓存都存在,才进行下一步操作 
					if($goodsData['seckill_seting_id']>0 && ($seting['buy_limit']>0 && $cartNum>=$seting['buy_limit']) && strtotime($seting['end_dateline'])>=$nowTime){//超过限制数
						$url = '';
						$msg['error'] = Yii::t('orderFlow', '商品的购买数量不能超过活动的限制');
					}else{
						/*if($relation['status']==1 && $relation['category_id']==1 && strtotime($seting['end_dateline'])>=$nowTime){//红包活动
							if($seting['discount_rate'] > 0){//打折
								$goodsData['price'] = number_format($goodsData['price']*(100-$seting['discount_rate'])/100, 2, '.', '');
							}else{//固定价格
								$goodsData['price'] = number_format($seting['discount_price'], 2, '.', '');
							}
						}else */if($relation['status']==1 && $relation['category_id']==2 && strtotime($seting['end_dateline'])>=$nowTime){//应节性活动
						    $fastive = ActivityTag::checkFestiveActivity($this->getUser()->id, $goods_id,$goodsData['seckill_seting_id']);
							if(!empty($fastive) && $fastive['status']==3){
							    $url = $fastive['url'];
								$msg['error'] = $fastive['msg'];	
							}else if(!empty($fastive) && $fastive['status']==2){
							    $fastiveNum = $fastive['quantity']+$cartNum+$quantity;//订单,购物车,当前加入购物车三者的数量加起来不能超过活动的限制
								if($fastiveNum>$seting['buy_limit'] && $seting['buy_limit']>0){
									$url = '';
									$msg['error'] = Yii::t('orderFlow', '已达活动购买数量限制,请查看订单和购物车内容');
								}
							}
						    
							if($seting['discount_rate'] > 0){//打折
								$goodsData['price'] = number_format($goodsData['price']*$seting['discount_rate']/100, 2, '.', '');
							}else{//固定价格
								$goodsData['price'] = number_format($seting['discount_price'], 2, '.', '');
							}
						}
					}
					
				}
			}
			
            /**
             * +++++++++++++++++++++++++++++++++++++
             * 购物车信息
             * +++++++++++++++++++++++++++++++++++++
             */
            $data = array(
                'goods_id' => $goods_id,
                'spec_id' => $spec_id,
                'store_id' => $storeId,
                'quantity' => $quantity,
                'price' => !empty($goodsData['price']) ? $goodsData['price'] : 0.00,
//                'setting_id' => $setting_id,
            );
            if (empty($msg)) {
                $goods_all_price = 0.00;
                $goods_all_num = 0.00; // //商品种数,不是个数
                $msg['success'] = 0;
                //单个用户添加购物车时，购物车产品数量不能大于库存
                if ($shopCart->add($data,$goodsSpec['stock'])) {
                    $goods_all_num = count($shopCart->goodsList);
                    $goods_all_price = $shopCart->totalPrice();
                    $msg['success'] = 1;
                } else {
                    $msg['error'] = Yii::t('cart', '添加购物车失败');
                }
                $msg['num'] = $goods_all_num;
                $msg['price'] = HtmlHelper::formatPrice($goods_all_price);
				$msg['goods_id'] = $goods_id;
				$msg['spec_id'] = $spec_id;
				$msg['special'] = $special;
                $msg['stock'] = $goodsSpec['stock'];
            }else{
			    $msg['url'] = $url;	
			}
            exit(CJSON::encode($msg));
        }
    }

    /**
     * jsonp 请求显示购物车详细信息
     */
    public function actionLoadCart() {
        $shopCart = new ShopCart();
        $cart = $shopCart->getGoodsDetails();
//        Tool::pr($cart);
        $result = array();
        $result['num'] = 0;

        if (!empty($cart)) {
            $totalPrice = 0;
            $result['num'] = count($cart);
            $string = '<div class="cartTit">' . Yii::t('cart', '最新加入的宝贝') . '</div>';
            $string .= '<div class="selectAll clearfix">'.Yii::t('cart', '共' . $result['num'] . '件商品 ').'</div>';
            $string .= '<table class="cartList_t">';
            $string .='<tbody>';
            // 循环开始
            foreach ($cart as $k => $v) {
                $string .='<tr class="last">';
                $string .='<td class="sel"></td>';
                $string .='<td class="img"><a title="' . Yii::t('cart', $v['name']) . '" href="' . $this->createAbsoluteUrl('/goods/view', array('id' => $v['goods_id'])) . '"><img src="' . Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_58,w_58') . '" alt="" /></a></td>';
                $string .='<td class="info">';
                $string .='<a title="' . Yii::t('cart', $v['name']) . '" href="' . $this->createAbsoluteUrl('/goods/view', array('id' => $v['goods_id'])) . '" class="name">' . Yii::t('cart', $v['name']) . '</a>';
                $string .='<p class="price">' . HtmlHelper::formatPrice($v['price']) . '*' . $v['quantity'] . ' </p>';
                $string .='</td>';
                $string .='<td class="do"><a class="icon_v doDel" title="' . Yii::t('cart', '删除此商品') . '" href="javascript:deleteCart(' . $v['store_id'] . ',' . $v['spec_id'] . ',' . $v['goods_id'] . ')"></a></td>';
                $string .='</tr>';
                $totalPrice += $v['price'] * $v['quantity'];
            }
            // 循环结束
            $string .='</tbody>';
            $string .='</table>';
            $string .='<div class="goPay">';
            $string .='<div class="clearfix">';
            $string .='<span class="totalPrice">' . HtmlHelper::formatPrice($totalPrice) . '</span><span class="prodTot">' . Yii::t('cart', '共' . $result['num'] . '件商品总计 ') . '：</span>';
            $string .='</div>';
            $string .='<a class="goPayBtn" title="' . Yii::t('cart', '去购物车结算') . '" href="' . $this->createAbsoluteUrl('/orderFlow') . '">&gt;' . Yii::t('cart', '去购物车结算') . '</a>';
            $string .='</div>';

            $result['cart'] = $string;
        } else {
            $result['cart'] = '<div class="cartEmpty"><div class="icon_v iconCartEmpty ">' . Yii::t('cart', '您的购物车是空的，赶紧去选购吧！') . '</div></div>';
        }
		
		$cb   = $this->getParam('jsonpCallback');
		if($cb){
			exit( $cb.'('.CJSON::encode($result).')');
		}else{
			exit( 'jsonpCallback'.CJSON::encode($result) );
		}
        
    }

    /**
     * jsonp 请求删除购物车
     */
    public function actionDel() {
        $spec_id = $this->getParam('spec_id'); //规格id
        $goods_id = $this->getParam('goods_id');
        $store_id = $this->getParam('store_id'); //商家id
        $collectIds = $this->getParam('collectIds');//用户移入收藏的商品，不加入删除历史列表
        $msg = array();
        $shopCart = new ShopCart();
        $goods = array(
            'goods_id' => $goods_id,
            'spec_id' => $spec_id,
            'store_id' => $store_id,
        );
        $shopCart->delete($goods,$collectIds);
        $msg['quantity'] = count($shopCart->goodsList);
        $msg['done'] = 1;
        $msg['amount'] = $shopCart->totalPrice();
        if(Yii::app()->theme){
            $del = $shopCart->getCartHistory();
            if(!empty($del)){
                foreach($del as &$v){
                    $v['url'] = CHtml::link(Tool::truncateUtf8String($v['name'],20),array('goods/view','id'=>$v['goods_id']),array('target'=>'_blank'));
                    $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_48,w_44'), '', array('width' => '44', 'height' => '48'));
                    $v['img'] = CHtml::link($img, array('goods/view', 'id' => $v['goods_id']), array('target' => 'blank'));
                    $v['price'] = HtmlHelper::formatPrice($v['price']);
                    $v['again'] = CHtml::link(Yii::t('cart','重新购买'),'javascript:void(0);',array('onclick'=>'reBuy('.$v['goods_id'].','.$v['spec_id'].','.$v['store_id'].')'));
                    $v['keep'] = CHtml::link(Yii::t('cart','移入收藏夹'),'javascript:void(0);',array(
                        'data-id'=>$v['goods_id'],
                        'data-spec_id'=>$v['spec_id'],
                        'data-store_id'=>$v['store_id'],
                    ));
                }
            }
            $msg['del'] = $del;
        }
        exit('jsonpCallback(' . CJSON::encode($msg) . ')');
    }

    /**
     * jsonp 删除选中商品
     */
    public function actionDeleteSelected(){
        $goodsData = $this->getParam('goodsData');
        $collectIds = $this->getParam('collectIds');//用户移入收藏的商品，不加入删除历史列表
        $msg = array();
        $shopCart = new ShopCart();
        $shopCart->deleteSelected($goodsData,$collectIds);
        $msg['quantity'] = count($shopCart->goodsList);
        $msg['done'] = 1;
        $msg['amount'] = $shopCart->totalPrice();
        if(Yii::app()->theme){
            $del = $shopCart->getCartHistory();
            if(!empty($del)){
                foreach($del as &$v){
                    $v['url'] = CHtml::link(Tool::truncateUtf8String($v['name'],20),array('goods/view','id'=>$v['goods_id']),array('target'=>'_blank'));
                    $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_48,w_44'), '', array('width' => '44', 'height' => '48'));
                    $v['img'] = CHtml::link($img, array('goods/view', 'id' => $v['goods_id']), array('target' => 'blank'));
                    $v['price'] = HtmlHelper::formatPrice($v['price']);
                    $v['again'] = CHtml::link(Yii::t('cart','重新购买'),'javascript:void(0);',array('onclick'=>'reBuy('.$v['goods_id'].','.$v['spec_id'].','.$v['store_id'].')'));;
                    $v['keep'] = CHtml::link(Yii::t('cart','移入收藏夹'),'javascript:void(0);',array(
                        'data-id'=>$v['goods_id'],
                        'data-spec_id'=>$v['spec_id'],
                        'data-store_id'=>$v['store_id'],
                    ));
                }
            }
            $msg['del'] = $del;
        }
        exit('jsonpCallback(' . CJSON::encode($msg) . ')');
    }

    /**
     * AJAX 更新购物车的数量
     */
    public function actionUpdateCart() {
        $shopCart = new ShopCart();
        $f = $shopCart->update(array(
            'goods_id' => $this->getParam('goods_id'),
            'spec_id' => $this->getParam('spec_id'),
            'quantity' => $this->getParam('quantity'),
        ));
        if ($f) {
            $msg['done'] = 1;
            $msg['allprice'] = $shopCart->totalPrice();
        } else {
            $msg['fail'] = 0;
        }
        exit(CJSON::encode($msg));
    }


    /**
     * ajax 重新购买
     * @param $goods_id
     * @param $spec_id
     * @param $store_id
     * @param $quantity
     */
   public function actionReBuy($goods_id,$spec_id,$store_id,$quantity){
       if ($this->isAjax()) {

           /* 商品价格是不取规格表的价格因为那里面是不存价格的了,所以要取商品表的数据 */
           $goodsData = Goods::getCartGoodsDetail($goods_id);

           //如果还没登录,直接跳到登录页  2015-06-26测试部又要求不跳转登录页
           $userId =  Yii::app()->user->id;

           if ($goodsData['life'] == Goods::LIFE_YES) {
               $msg['error'] = Yii::t('cart', '当前商品已经被删除');
           }
           if ($goodsData['is_publish'] == Goods::PUBLISH_NO) {
               $msg['error'] = Yii::t('cart', '当前商品已经下架');
           }
           if ($goodsData['status'] != Goods::STATUS_PASS) {
               $msg['error'] = Yii::t('cart', '当前商品审核未通过');
           }
           $goodsSpec = GoodsSpec::getSpecData($spec_id, array('price', 'stock'));
           $msg = array();
           $shopCart = new ShopCart();
           //获取购物车数组数量，如果购物车数组为空，购物车数组数量为0
           $cartNum = !empty($shopCart->goodsList[$goods_id . '-' . $spec_id]) ? $shopCart->goodsList[$goods_id . '-' . $spec_id]['quantity'] : 0;
           //判断是否购买数量是否超越库存
           //if (($quantity + $cartNum) > $goodsSpec['stock']) {
           if ($quantity > $goodsSpec['stock']) {
               $msg['error'] = Yii::t('cart', '购买数量超过当前库存');
           }
           //判断是否商家自己购买自家店的商品
           if (!empty($storeId) && $storeId == $this->getSession('storeId')) {
               $msg['error'] = Yii::t('cart', '不能购买自己店铺的商品');
           }
           //判断购物车的数量不能超过20种
           if (count($shopCart->goodsList) >= $shopCart::MAX_NUM_LIMIT) {
               $msg['error'] = Yii::t('cart', '购物车的数量不能超过20种商品');
           }
           //如果是特殊商品，或者合约机，只能添加购物车一次
           if ((ShopCart::checkHyjGoods($goods_id) || ShopCart::checkSpecialGoods($goods_id)) && $cartNum >= 1) {
               $msg['success'] = 1;
               $msg['num'] = 1;
               $msg['price'] = 1;
           }

           //判断有没有该商品的未支付定单
           $nowTime  = time();
           $quantity = abs(intval($quantity));//确保数量不为负数
           $relation = ActivityData::getRelationInfo($goodsData['seckill_seting_id'], $goods_id);
           $seting   = ActivityData::getActivityRulesSeting($goodsData['seckill_seting_id']);
           $rs       = ActivityTag::checkCreateRedOrder($this->getUser()->id, $goods_id,$goodsData['seckill_seting_id']);

           //若是活动商品，活动时间还没开始，不能购买
           if(!empty($seting) && !empty($relation) && strtotime($seting['start_dateline'])>$nowTime && $seting['status']>1 && $relation['status']==1){
               $url = '';
               $msg['error'] = Yii::t('seckill', '抱歉,活动还没开始！');
           }


           if($rs['status'] !== 1){
               $allNum = $rs['quantity']+$cartNum+$quantity;//订单,购物车,当前加入购物车三者的数量加起来不能超过活动的限制
               if($rs['status']==3){
                   if(intval($userId) > 0 && $allNum>$seting['buy_limit'] && $seting['buy_limit']>0){
                       $url = '';
                       $msg['error'] = Yii::t('orderFlow', '已达活动购买数量限制,请查看订单和购物车内容');
                   }else{
                       $url = $rs['url'];
                       $msg['error'] = Yii::t('orderFlow', $rs['msg']);
                   }

               }else{
                   if($rs['status'] == 2 || ($allNum>$seting['buy_limit'] && $seting['buy_limit']>0)){
                       $url = $rs['url'];
                       $msg['error'] = $rs['status']==2 ? Yii::t('orderFlow', $rs['msg']) : Yii::t('orderFlow','已达活动购买数量限制,请查看订单和购物车内容');
                   }
               }
           }else{
               //红包和应节性活动处理 (2015-06-10 李文豪)
               if(!empty($relation) && !empty($seting) && $relation['status']==1){//两个缓存都存在,才进行下一步操作
                   if($goodsData['seckill_seting_id']>0 && ($seting['buy_limit']>0 && $cartNum>=$seting['buy_limit']) && strtotime($seting['end_dateline'])>=$nowTime){//超过限制数
                       $url = '';
                       $msg['error'] = Yii::t('orderFlow', '商品的购买数量不能超过活动的限制');
                   }else{
                       if($relation['status']==1 && $relation['category_id']==2 && strtotime($seting['end_dateline'])>=$nowTime){//应节性活动
                           $fastive = ActivityTag::checkFestiveActivity($this->getUser()->id, $goods_id,$goodsData['seckill_seting_id']);
                           if(!empty($fastive) && $fastive['status']==3){
                               $url = $fastive['url'];
                               $msg['error'] = $fastive['msg'];
                           }else if(!empty($fastive) && $fastive['status']==2){
                               $fastiveNum = $fastive['quantity']+$cartNum+$quantity;//订单,购物车,当前加入购物车三者的数量加起来不能超过活动的限制
                               if($fastiveNum>$seting['buy_limit'] && $seting['buy_limit']>0){
                                   $url = '';
                                   $msg['error'] = Yii::t('orderFlow', '已达活动购买数量限制,请查看订单和购物车内容');
                               }
                           }

                           if($seting['discount_rate'] > 0){//打折
                               $goodsData['price'] = number_format($goodsData['price']*$seting['discount_rate']/100, 2, '.', '');
                           }else{//固定价格
                               $goodsData['price'] = number_format($seting['discount_price'], 2, '.', '');
                           }
                       }
                   }

               }
           }

           /**
            * +++++++++++++++++++++++++++++++++++++
            * 购物车信息
            * +++++++++++++++++++++++++++++++++++++
            */
           $data = array(
               'goods_id' => $goods_id,
               'spec_id' => $spec_id,
               'store_id' => $store_id,
               'quantity' => $quantity,
               'price' => !empty($goodsData['price']) ? $goodsData['price'] : 0.00,
           );
           if (empty($msg)) {
               $msg['success'] = 0;
               if ($shopCart->add($data,$goodsSpec['stock'])) {
                   $msg['success'] = 1;
               } else {
                   $msg['error'] = Yii::t('cart', '添加购物车失败');
               }
           }
           exit(CJSON::encode($msg));
       }
   }

}

