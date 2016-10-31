<?php

/**
 * 订单流程控制器(显示订单信息,核对订单,支付订单,支付成功后的操作)
 * @author binbin.liao  <277250538@qq.com>
 */
class OrderFlowController extends Controller
{

    public $layout = 'main';
    public $defaultAction = 'view';
    public $freightInfo = array(); //运费模板信息
    public $freight = array(); //每种运费模板对应城市的运费
    public $storeFreight = array(); //店铺运费，v2.0

    public function actions()
    {
        return array(
            'validatePassword3' => array('class' => 'CommonAction', 'method' => 'validatePassword3'), //ajax检查支付密码
        );
    }

    public function filters()
    {
        return array(
            'postRequest + order',
        );
    }

    public function beforeAction($action)
    {
        //如果使用主题，则用不同的layout
        if(Yii::app()->theme){
            $this->layout = 'miniMain';
        }
        $user_id = $this->getUser()->id;
        $url = '/' . $this->id . '/' . $this->action->id;
        if (empty($user_id)) {
            if($this->action->id == 'single'){
                $queryString = Yii::app()->getRequest()->queryString;
                Yii::app()->user->setReturnUrl($this->createAbsoluteUrl($url).'?'.$queryString);
            }else{
                Yii::app()->user->setReturnUrl($this->createAbsoluteUrl($url));
            }
            $this->redirect(array('/member/home/login'));
        }else{
            $mobile = Yii::app()->db->createCommand('select mobile from gw_member where id=:id')->bindValue(':id',$user_id)->queryScalar();
            if(!$mobile){
                $this->setFlash('error','您需要绑定手机号码才能支付订单');
                $this->redirect(array('/member/member/mobile'));
            }
        }

        $site_config = $this->getConfig('site');
        $this->pageTitle = $site_config['name'];

        return parent::beforeAction($action);
    }

    /**
     * 显示我的购物车信息
     */
    public function actionView()
    {

        $this->pageTitle = '我的购物车_' . $this->pageTitle;
        //删除合约机商品、自身店铺的商品
        $gid = implode(',', ShopCart::checkHyjGoods());
        if ($gid) {
            Cart::model()->deleteAll("(member_id=:mid and goods_id in($gid)) or (member_id=:mid and store_id=:sid)",
                array(':mid' => $this->getUser()->id, ':sid' => $this->getSession('storeId')));
        }
        $cart = Cart::getCartInfo();

        //删除特殊商品，特殊专题商品，这些商品只能单独提交
        if(!$this->theme){
            foreach($cart['cartInfo'] as $k => $v){
                foreach($v['goods'] as $k2 => $v2){
                    if($v2['special_goods'] || $v2['jf_pay_ratio'] > 0 || isset($v2['integral_ratio'])){
                        Cart::model()->deleteByPk($v2['id']);
                    }
                }
            }
        }

        $shopCart = new ShopCart();
        $cartHistory = $shopCart->getCartHistory();
        $this->render('view', array('cart' => $cart,'cartHistory'=>$cartHistory));
    }

    /**
     * 结算流程第二步,核对订单信息
     */
    public function actionVerify()
    {
        header("Cache-control: private");
        $this->pageTitle = '核对订单信息_' . $this->pageTitle;
        $goods_select = $this->getParam('goods_select'); // goods_id + spec_id
        $this->_verify($goods_select);
    }

    /**
     * 特殊商品支付，一部分积分，部分在线
     * @param $goods_id
     * @param $spec_id
     */
    public function actionSingle($goods_id, $spec_id)
    {
        $this->pageTitle = '核对订单信息_' . $this->pageTitle;
        $goods_select = array($goods_id . '-' . $spec_id); // goods_id + spec_id
        $this->_verify($goods_select, array('goods/view', 'id' => $goods_id));
    }

    /**
     * 核对订单信息公共部分
     * @param array $goods_select
     * @param string|bool $returnUrl 如果获取商品为空，需要跳转的地址
     */
    private function _verify($goods_select, $returnUrl = false)
    {
        if (empty($goods_select[0])) {
            $this->redirect(array('/orderFlow'));
        }
        $address = Address::getMemberAddress($this->getUser()->id);
        //判断地址  否则跳转到地址页面
        if (empty($address) && !Yii::app()->theme) {
            $this->setFlash('error', Yii::t('member', '请先设置收货地址'));
            $this->turnbackRedirect('/member/address/index');
        }
        //默认收货地址
        if (!$this->getSession('select_address')) {
            foreach ($address as $k => $v) {
                if ($v['default']) {
                    $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
                } else if ($k == 0) {
                    $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
                }
            }
        }
        $cartInfo = Cart::getCartInfo($goods_select);
        if (empty($cartInfo['cartInfo']) && !empty($returnUrl)) {
            $this->redirect($returnUrl);
        } else if (empty($cartInfo['cartInfo'])) {
            $this->redirect(array('/orderFlow'));
        }
        $this->freightInfo = $cartInfo['freightInfo'];//运费相关信息
        $select_address = $this->getSession('select_address');
        $this->_computeFreight($select_address['city_id']); //运费计算
        $redAccount = $this->_getRedAccount($cartInfo); //红包账户余额

        $this->render('verify', array(
            'address' => $address,
            'cartInfo' => $cartInfo,
            'goods_select' => $goods_select,
            'redAccount' => $redAccount,
        ));
    }

    /**
     * ajax 标记当前的选择的收货地址信息
     */
    public function actionChangeAddress()
    {
        if ($this->isAjax()) {
            $this->setSession('select_address', array('id' => $this->getPost('id'), 'city_id' => $this->getPost('city_id')));
        }
    }

    /**
     * 计算运费
     * @param int $city_id
     */
    private function _computeFreight($city_id)
    {
        if (!empty($this->freightInfo)) {
            $tmpFreight = array(); //按照店铺id，运费模板id，分类保存商品重量、数量等信息
            foreach ($this->freightInfo as $v) {
                $tmpFreight[$v['store_id']][$v['freight_template_id']][] = $v;
                $freight = ComputeFreight::compute($v['freight_template_id'], $v['size'], $v['weight'], $city_id, $v['valuation_type'], $v['quantity']);
                foreach ($freight as $k2 => $v2) {
                    $fid = $v['goods_id'] . '-' . $v['spec_id'];
                    $this->freight[$fid][$k2 . '|' . $v2['fee'] . '|' . Common::rateConvert($v2['fee'])] = $v2['name'];
                }
            }
            // v2.0 使用合并计算相同运费模板的商品的运费
            if(Yii::app()->theme && !empty($tmpFreight)){
                $tmpF = array();//合并计算同一个店铺，相同运费模板商品的重量、数量、尺寸等信息
                foreach($tmpFreight as $k1=>$v1){
                    foreach($v1 as $k2=>$v2){
                        $tmpG = array('size'=>0,'weight'=>0,'quantity'=>0);
                        foreach($v2 as $k3=>$v3){
                            $tmpG['size'] += $v3['size']*$v3['quantity'];
                            $tmpG['weight'] += $v3['weight']*$v3['quantity'];
                            $tmpG['valuation_type'] = $v3['valuation_type'];
                            //按照件数计算运费的，数量要一直累加，反之，打包成一件，按照重量、或者体积计算
                            if($v3['valuation_type']==FreightTemplate::VALUATION_TYPE_NUM){
                                $tmpG['quantity'] += $v3['quantity'];
                            }else{
                                $tmpG['quantity'] = 1;
                            }
                        }
                        $tmpF[$k1][$k2] = $tmpG;
                    }
                }
                foreach($tmpF as $k=>$v){
                    $freight = 0.00; //运费
                    foreach($v as $k2=>$v2){
                        //获取第一条作为运费计算
                        $freightArray = current(ComputeFreight::compute($k2, $v2['size'], $v2['weight'], $city_id, $v2['valuation_type'], $v2['quantity']));
                        $freight += $freightArray['fee'];
                    }
                    /**
                     * 运费结构 array(店铺id=>总运费)
                     */
                    $this->storeFreight[$k] = $freight;
                }
            }
        }

    }

    /**
     * 生成订单
     */
    public function actionOrder()
    {
        //订单商品数组 goods_id - spec_id
        $goods_select = unserialize(Tool::authcode($this->getPost('goods_select'), 'DECODE'));
        if (empty($goods_select)) throw new CHttpException(503, Yii::t('orderFlow', '请重新提交购物车'));
        //收货地址
        $address = Address::getAddressById($this->getPost('address'));
        if (empty($address)) throw new CHttpException(503, Yii::t('orderFlow', '收货地址为空'));
        //所有结算商品的运费方式
        $freight_array = unserialize(Tool::authcode($this->getPost('freight_array'), 'DECODE'));
        //会员所选的运费方式
        $freight = $this->getPost('freight');
        //v2.0合并计算的运费
        if(isset($_POST['store_freight'])){
            $storeFreight = unserialize(Tool::authcode($this->getPost('store_freight'), 'DECODE'));
        }else{
            $storeFreight = array();
        }
        //购物车所选商品
        $cartInfo = Cart::getCartInfo($goods_select, ' for update');

        $redMoney = $this->_getRedAccount($cartInfo); //检查红包账户余额是否够支付订单

        //获取用户选择支付的红包金额
        $useRedMoneyInfo = $this->_getUseRedMoney($cartInfo,$this->getPost('is_use_red'));

        if(!(array_sum($redMoney['use_red_money']) == array_sum($useRedMoneyInfo))){
            throw new CHttpException(503, Yii::t('orderFlow','您够买的商品，必须使用红包支付，请勾选使用红包！'));
        }
        $countGoods = 0;
        $sckillGoods = false;
        $jfxjGoods=false;
        $jfGoods=false;
        $storeCount=0;
        foreach($cartInfo['cartInfo'] as $corder) {
            foreach ($corder['goods'] as $g){      
              //不同类型的商品不可以同时下单
                if (isset($g['seckill_seting_id']) && $g['seckill_seting_id']>0){
                    $sckillGoods = true;
                }else if(isset($g['jf_pay_ratio']) && $g['jf_pay_ratio'] <100 && $g['jf_pay_ratio']>0){
                    $jfxjGoods=true;
                 }else{
                    $jfGoods=true;
                 }
                $countGoods ++;
            }
            $storeCount ++;
           }
        if($countGoods>1){
              if($sckillGoods && ($jfxjGoods || $jfGoods)){
                  throw new CHttpException(503, Yii::t('orderFlow','商品类型不同，不可同时购买，请单独下单'));
               }
              /* if($jfGoods && $jfxjGoods && $storeCount>1){
                  throw new CHttpException(503, Yii::t('orderFlow','不同的商家，商品类型不同，不可同时购买，请单独下单'));
               } */
        }
        //生成订单操作
        $orderFlow = new OrderFlow();
        $info = array(
            'freight_array' => $freight_array,
            'freight' => $freight,
            'storeFreight'=>$storeFreight,
            'message' => $this->getPost('message'),
            'useRedMoneyInfo'=>$useRedMoneyInfo,
            'jfxjGoods'=>$jfxjGoods
        );
         
        $orderCode = $orderFlow->createOrder($cartInfo, $address, $info);
        if (!empty($orderCode)) {
            Cart::delCart($this->getUser()->id, $goods_select); //提交订单成功后删除购物车里的数据
            if(Yii::app()->theme)
                $this->redirect(array('/order/payv2', 'code' => implode(',', $orderCode)));
            else
                $this->redirect(array('/order/pay', 'code' => implode(',', $orderCode)));
        } else {
            throw new CHttpException(503, '生成订单失败');
        }
    }

    /**
     * 计算用户选择支付的红包金额
     * @param $cartInfo
     * @param $select 用户选择支付的订单
     * @return array
     */
    private  function _getUseRedMoney($cartInfo,$select){
        $redAccount = $this->_getRedAccount($cartInfo);
        $memberRedAccount = $redAccount['memberRedAccount'];
        $orderUseRedMoney = array();
        foreach ($redAccount['use_red_money'] as $k=>$v) {
            if(isset($select[$k])){
                if($memberRedAccount > $v )
                    $orderUseRedMoney[$k] = $v;
                else
                    $orderUseRedMoney[$k] = $memberRedAccount;
                $memberRedAccount -= $orderUseRedMoney[$k] ;
            }else{
                if($memberRedAccount > $v )
                    $memberRedAccount -= $v;
                else
                    $memberRedAccount -= $memberRedAccount;
            }
        }
        return $orderUseRedMoney;
    }

    /**
     *获取用户可用的红包金额
     * @param $cartInfo 购物车信息
     * @author binbin.liao
     */
    private function _getRedAccount($cartInfo)
    {
        $arr =array();//每个订单能使用的红包金额
        //获取会员红包金额
        $redAccount = RedEnvelopeTool::getRedAccount($this->getUser()->id);
        $totalUseRed = 0;
        $redType = false;
		
		$nowTime = time();
        foreach ($cartInfo['cartInfo'] as $k => $v) {
            $useRed = 0;//能使用的红包上限
            foreach ($v['goods'] as $k2 => $v2) {
		        $seting = ActivityData::getActivityRulesSeting($v2['seckill_seting_id']);
				$relation = ActivityData::getRelationInfo($v2['seckill_seting_id'], $v2['goods_id']);
                if( $v2['seckill_seting_id'] > 0 && isset($seting) && $seting['category_id']==1 && $relation['status']==1 &&  strtotime($seting['end_dateline'])>=$nowTime){
                	//$rs     = ActivityTag::checkCreateRedOrder($this->getUser()->id, $v2['goods_id'], $v2['seckill_seting_id']);
                	//if($rs['status'] !== 1)
                	//{
                	//	throw new CHttpException(504, $rs['msg']);  //如果验证不通过说明重复购买
                	//}
                    $ratio = bcdiv($seting['discount_rate'], 100, 5);
                    $useRed += bcmul(bcmul($v2['price'],$v2['quantity'],2), $ratio, 2);
                    $redType = true;
                }
            }
            $totalUseRed += $useRed;
            $arr[$k] = $useRed;
        }
        if($redAccount < $totalUseRed) {
            if ($redType) {
                throw new CHttpException(503, Yii::t('orderFlow', '您的红包：{0}元，订单所需红包：{1}元，不足以支付订单，请您修改购物车中的商品！', array('{0}' => $redAccount, '{1}' => $totalUseRed)));
            }
        }
        $newArr['memberRedAccount'] = $redAccount;
        $newArr['use_red_money'] = $arr;

        return $newArr;
    }
}
