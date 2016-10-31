<?php

/**
 * 购物车控制器
 * @author xiaoyan.luo<xiaoyan.luo@gatewang.com>
 */
class CartController extends WController
{

    public $layout = false;
    public $freightInfo = array(); //运费模板信息
    public $freight = array(); //每种运费模板对应城市的运费


    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect('/home/login');
        }
        return parent::beforeAction($action);
    }

    /**
     * 购物车列表
     */
    public function actionIndex()
    {
        //删除特殊商品、合约机商品、自身店铺的商品
        $gid = implode(',', array_merge(ShopCart::checkSpecialGoods(), ShopCart::checkHyjGoods()));
        /*if ($gid) {
            Cart::model()->deleteAll("(member_id=:mid and goods_id in($gid)) or (member_id=:mid and store_id=:sid)",
                array(':mid' => $this->getUser()->id, ':sid' => $this->getSession('storeId')));
        }*/
        $cart = Cart::getCartInfo();
        $unVliadGoods=array();
        foreach($cart['cartInfo'] as $key => $val){
             foreach($val['goods'] as $k => &$v){
                 if($v['stock']<=0){
                      $unVliadGoods[]=$v;
                      unset($cart['cartInfo'][$key]);
                    }
             } 
        }
        $this->render('index', array('cart' => $cart,'unVliadGoods'=>$unVliadGoods));
    }

    /**
     * 结算流程,核对订单信息
     * array $cart_goods
     * $cart_goods=goods_id + spec_id
     */
    public function actionConfirm()
    {
        $cart_goods = $this->getParam('cart_goods');
        //确认订单时，重新确认收货地址时设置session，跳转时购物车商品数组 
        $cart = isset($_GET['cart']) ? $this->getQuery('cart') : '';
        if (empty($cart)) {
           if(empty($cart_goods[0])) {
                Yii::app()->user->setFlash('tips',Yii::t('cart', '请先选择要购买的商品！'));
                $this->redirect(array('cart/index'));
            }else{
                $this->setSession('cart_goods', array('cart_good' => $cart_goods));
            }
        }
        $cartSession = $this->getSession("cart_goods");
        if ($cart == 1 && empty($cart_goods)) {
            $cart_goods = $cartSession['cart_good'];
        }
        if (empty($cart_goods)) {
            $this->redirect(array('cart/confirm'));
        }
        $address = Address::getMemberAddress($this->getUser()->id);
        //判断地址  否则跳转到地址页面
        if (empty($address)) {
            $this->setFlash('message', Yii::t('member', '请先设置收货地址'));
            $this->redirect(array('address/create', 'cart' => '1'));
            //$this->turnbackRedirect('address/create','cart/con');
        }
        //设置收货地址session
        foreach ($address as $k => $v) {
            if ($v['default']) {
                $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
            } else if ($k == 0) {
                $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
            }
        }
        $cartInfo = Cart::getCartInfo($cart_goods);
        if (empty($cartInfo['cartInfo'])) {
            $this->redirect(array('cart/index'));
        }
        $this->freightInfo = $cartInfo['freightInfo']; //运费相关信息
        $select_address = $this->getSession('select_address');
        $this->_computeFreight($select_address['city_id']); //运费计算
        $redAccount = $this->_getRedAccount($cartInfo); //红包账户余额
        $allPrice = 0;
        foreach ($cartInfo['cartInfo'] as $key => $val) {
            $totalPrice = 0;
            foreach ($val['storeAllPrice'] as $k) {
                $totalPrice += $k;
                $allPrice += $k;
            }
            $cartInfo['cartInfo'][$key]['totalprice'] = $totalPrice;
        }
        $this->render('orderConfirm', array(
            'address' => $address[0],
            'cart' => $cartInfo,
            'cart_goods' => $cart_goods,
            'allTotalPrice' => $allPrice,
            'redAccount' => $redAccount,
        ));
    }

    /**
     * 生成订单
     */
    public function actionOrder()
    {
        //订单商品数组 goods_id - spec_id
        $cart_goods = unserialize(Tool::authcode($this->getPost('cart_goods'), 'DECODE'));
        $orderCartGoods=$cart_goods;
        if (empty($cart_goods)) throw new CHttpException(503, Yii::t('cart', '请重新提交购物车'));
        //收货地址
        $address = Address::getAddressById($this->getPost('address'));
        if (empty($address)) throw new CHttpException(503, Yii::t('cart', '收货地址为空'));
        //所有结算商品的运费方式
        $freight_array = unserialize(Tool::authcode($this->getPost('freight_array'), 'DECODE'));
        //会员所选的运费方式
        $freight = $this->getPost('freight');
        //购物车所选商品
        $cartInfo = Cart::getCartInfo($cart_goods, ' for update');
        //获取用户选择支付的红包金额
        $redAccount = $this->_getRedAccount($cartInfo);
        $useRedMoneyInfo = array_filter($redAccount['use_red_money']);
        //生成订单操作
        $orderWapFlow = new OrderWapFlow();
        $info = array('freight_array' => $freight_array, 'freight' => $freight, 'useRedMoneyInfo' => $useRedMoneyInfo);
        $orderCode = $orderWapFlow->createOrder($cartInfo, $address, $info);
        if (!empty($orderCode)) {
            Cart::delCart($this->getUser()->id, $orderCartGoods); //提交订单成功后删除购物车里的数据
            $this->redirect(array('orderConfirm/pay', 'code' => implode(',', $orderCode)));
        } else {
            throw new CHttpException(503, '生成订单失败');
        }
    }

    /**
     * 购物车编辑属性,弹框
     * @author wyee
     */   
    public function actionEditSpec(){
        if ($this->isAjax()) {
            $ajaxData=$_POST;
            $specData = $data = array();
            if(empty($ajaxData['goodId'])){
                $data['errorMsg'] = "该商品暂无法编辑属性，请稍后重试！";
            }else{
            $ori_spec = explode('|', $ajaxData['specData']);
            array_pop($ori_spec);
            $sql = "SELECT g.name,g.thumbnail,g.price,g.gai_sell_price,g.market_price,g.spec_name,g.goods_spec,g.join_activity,g.activity_tag_id,at.status AS at_status  FROM `gw_goods` AS g
                LEFT JOIN `gw_activity_tag` AS at ON g.activity_tag_id = at.id
                WHERE  g.id=:id";
            $goods = Yii::app()->db->createCommand($sql)->bindValues(array(':id' => $ajaxData['goodId']))->queryRow();
            $goods['spec_name'] = empty($goods['spec_name']) ? array() : unserialize($goods['spec_name']);
            $goods['goods_spec'] = empty($goods['goods_spec']) ? array() : unserialize($goods['goods_spec']);
            //该商品是否有参加红包活动,如果有参加,则使用盖网提供的售价
            if ($goods['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id']) && $goods['at_status'] == ActivityTag::STATUS_ON) {
                $goods['price'] = $goods['gai_sell_price'];
                $data['flag'] = 'hb_goods';
            } else {
                $data['flag'] = 'default_goods';
            }
            if (!empty($goods['spec_name']) && !empty($goods['goods_spec'])) {
                $specData = array_combine($goods['spec_name'], $goods['goods_spec']);
            }
            $data['spec_id'] = $ajaxData['specId'];
            $data['goods_id'] = $ajaxData['goodId'];
            $data['name'] = $goods['name'];
            $data['thumbnail'] = $goods['thumbnail'];
            $data['price'] = $goods['price'];
            $data['market_price'] = $goods['market_price'];
            $new['ori_spec'] = $ori_spec;
            $data['spec'] = array_merge($specData, $new);
            }
            echo CJSON::encode($data);
        }
    }
    
  /**
    * ajax更新购物车数据（数量和属性）
    * @param int $actionType 更新的是数量则为1，属性为2
    * @author wyee
    */
    public function actionUpdateCart(){
        if ($this->isAjax()){      
            $specId = $this->getParam('specId'); //原来的商品属性值
            $goodsId = $this->getParam('goodId'); //商品id
            $specValue = $this->getParam('specValue'); //选择的商品属性值
            $actionType=$this->getParam('actionType'); //选择的商品属性值
            $number = $this->getParam('num'); //商品数量
            $memberId = Yii::app()->user->id; //用户id
            $res=array();
            $msg="";
            if(empty($goodsId)){
                $res['msgCode']="1";
                $res['msg']="暂时无法编辑商品，请稍后刷新重试！";
                echo CJSON::encode($res);
                exit;
            }else{ 
            if($actionType==1){
                if(empty($number)){
                    $res['msgCode']="1";
                    $res['msg']="暂时无法编辑商品数量，请稍后刷新重试！";
                    echo CJSON::encode($res);
                    exit;
                }else{
                 $typeArr=array('quantity' => $number);
                 }
            }else{
                $specArr = explode('|', $specValue);
                array_pop($specArr);
                $specModel = GoodsSpec::model()->findAll(array(
                        'condition' => 'goods_id = :id',
                        'params' => array(':id' => $goodsId),
                ));
                if (!empty($specModel) && !empty($specArr)) {
                    foreach ($specModel as $value) {
                        if (!array_diff($specArr, $value->spec_value)) {
                            $specNewId = $value->id;
                            $msgArr=array_combine($value->spec_name,$value->spec_value);
                            foreach($msgArr as $k => $v){
                                $msg.='<p>'.$k.'<span class="d32f2f selectItem">'.$v.'<span></p>';
                            } 
                            $res['msgCode']="2" ;
                            $res['msg']=$msg ;
                            $res['specNewId']=$value->id;          
                        }
                    }
                }else{
                       $res['msgCode']="1";
                       $res['msg']="暂时无法修改商品属性，请稍后刷新重试！";
                        echo CJSON::encode($msg);
                        exit;
                  }     
                $typeArr=array('spec_id' => $specNewId);
             }            
            $resCode=Cart::model()->updateAll($typeArr,
                    'goods_id = :g_id and member_id = :m_id and spec_id = :s_id',
                    array(':g_id' => $goodsId, ':m_id' => $memberId, ':s_id' => $specId)); 
            }
            if($resCode==0){
                $res['msgCode']="1";
                $res['msg']="暂时无法修改商品属性，请稍后刷新重试！";
                echo CJSON::encode($res['msg']);
                exit;
            }    
            echo CJSON::encode($res);
        } 
    }

    /**
     * ajax购物车商品删除
     */
    public function actionDelete()
    {
        if ($this->isAjax()) {
            $goodsId = $this->getPost('goods_id');
            $error = $message = '';
            foreach ($goodsId as $id) {
                $goodSpec = explode("-", $id);
                $goods_id = $goodSpec[0];
                $spec_id = $goodSpec[1];
                $result = Cart::model()->deleteAll('member_id = :m_id and goods_id = :goodsid and spec_id= :specid', array(':m_id' => $this->getUser()->id, ':goodsid' => $goods_id, ':specid' => $spec_id));
                if (!$result) {
                    $error .= '删除商品编号为' . $id . '数据失败';
                }
            }
            if ($error) {
                $message = '抱歉，商品暂时无法移除，请刷新重试';
            } else {
                $message = '您已经成功删除所选商品';
            }
            echo $message;
        }
    }
    
    /**
     * ajax购物车删除失效产品
     */
    public function actionDeleteUnValiad()
    {
        if ($this->isAjax()) {
            $goodStr = $this->getPost('goods_id');
            $goodsId=explode("||", $goodStr);
            array_pop($goodsId);
            $error = $message = '';
            foreach ($goodsId as $id) {
                $goodSpec = explode("-", $id);
                $goods_id = $goodSpec[0];
                $spec_id = $goodSpec[1];
                $result = Cart::model()->deleteAll('member_id = :m_id and goods_id = :goodsid and spec_id= :specid', array(':m_id' => $this->getUser()->id, ':goodsid' => $goods_id, ':specid' => $spec_id));
                if (!$result) {
                    $error .= '删除商品编号为' . $id . '数据失败';
                }
            }
            if ($error) {
                $message = '抱歉，商品暂时无法移除，请刷新重试';
            } else {
                $message = '您已经成功清空失效商品';
            }
            echo $message;
        }
    }

    /**
     * 计算运费
     * @param int $city_id
     */
    private function _computeFreight($city_id)
    {
        if (!empty($this->freightInfo)) {
            foreach ($this->freightInfo as $v) {
                $freight = ComputeFreight::compute($v['freight_template_id'], $v['size'], $v['weight'], $city_id, $v['valuation_type'], $v['quantity']);
                foreach ($freight as $k2 => $v2) {
                    $fid = $v['goods_id'] . '-' . $v['spec_id'];
                    $this->freight[$fid][$k2 . '|' . $v2['fee'] . '|' . Common::rateConvert($v2['fee'])] = $v2['name'];
                }
            }
        }
    }

    /**
     * 获取用户可用的红包金额
     * @param $cartInfo array 购物车信息
     * @return mixed 红包信息
     * @throws CHttpException 异常信息
     */
    private function _getRedAccount($cartInfo)
    {
        $arr = array(); //每个订单能使用的红包金额
        $useRedInfo = array(); //所有红包信息数组
        $totalUseRed = 0;
        $redType = false;
        //获取会员红包金额
        $redAccount = RedEnvelopeTool::getRedAccount($this->getUser()->id);
        foreach ($cartInfo['cartInfo'] as $k => $v) {
            $useRed = 0; //能使用的红包上限
            foreach ($v['goods'] as $k2 => $v2) {
                if ($v2['join_activity'] == Goods::JOIN_ACTIVITY_YES && $v2['at_status'] == ActivityTag::STATUS_ON) {
                    $ratio = bcdiv($v2['activity_ratio'], 100, 5);
                    $useRed += bcmul(bcmul($v2['gai_sell_price'], $v2['quantity'], 2), $ratio, 2);
                    $useRedInfo[$k2]['money'] = bcmul(bcmul($v2['gai_sell_price'], $v2['quantity'], 2), $ratio, 2);
                    $useRedInfo[$k2]['name'] = $v2['at_name'];
                    $redType = true;
                }
            }
            $totalUseRed += $useRed;
            $arr[$k] = $useRed;
        }
        if ($redAccount < $totalUseRed) {
            if ($redType) {
                throw new CHttpException(503, Yii::t('orderFlow', '您的红包：￥{0}元，订单所需红包：￥{1}元，不足以支付订单，请您修改购物车中的商品！', array('{0}' => $redAccount, '{1}' => $totalUseRed)));
            }
        }
        $newArr['memberRedAccount'] = $redAccount;
        $newArr['use_red_money'] = $arr;
        $newArr['use_red_info'] = $useRedInfo;
        return $newArr;
    }

}

?>
