<?php

/**
 * 线上订单模型
 * @author binbin.liao
 */
class OrderForm extends CFormModel {

    public $password3;
    public $payType;
    public $code;
    public $totalPrice;
    /** @var  array 会员信息 */
    public $member;
    /** @var  float $accountPrice  会员账户余额*/
    public $accountMoney;
    /** @var  array 消费账户 */
    public $balance;
    /** @var  array 历史消费账户 */
    public $balanceHistory;
    /**
     * @var int 是否需要验证密码，0 不需要，1 需要
     */
    public $needPassword = 1;
    /*v2.0 积分支付金额*/
    public $jfPayCount;

    public $bankCode;

    public $bankType;
    public $token;


    public function rules() {
        return array(
            array('password3', 'length', 'min' => 6),
            array('password3', 'required', 'message' => Yii::t('orderForm', '支付密码不能为空'),),
            //array('payType','required','message' => Yii::t('orderForm', '请选择一种第三方支付方式')),
            array('bankType','required','message' => Yii::t('orderForm', '请选择支付方式')),
            array('payType','validateQequired'),
            array('bankCode','validateQequired2'),
            array('password3', 'validatePayPassword'),
            array('totalPrice', 'validateAccount'),
            array('needPassword','safe'),
            array('jfPayCount','numerical'),
            array('token','safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'payType' => Yii::t('orderForm', '支付类型'),
            'password3' => Yii::t('orderForm', '盖网支付密码'),
            'code' => Yii::t('orderForm', '支付单号'),
            'totalPrice' => Yii::t('orderForm', '支付总金额'),
            'jfPayCount' => Yii::t('orderForm','支付金额')
        );
    }

    //验证是否选择第三方支付
     public function validateQequired($attribute, $params) {
       if((float)bcsub($this->totalPrice,$this->jfPayCount,2) > 0){
         if($this->bankType==OnlineBankPay::PAY_BANK_NONE){
             if($this->payType=='' && !empty($this->bankCode)){
                 $this->addError($attribute, Yii::t('orderForm', '选择的支付方式错误'));
               }else if($this->payType=='' && empty($this->bankCode)){
                 $this->addError($attribute, Yii::t('orderForm', '请选择一种第三方进行支付'));
             }
         }
       }
     }
     
    //验证是否选择银行
     public function validateQequired2($attribute, $params){
          if((float)bcsub($this->totalPrice,$this->jfPayCount,2) > 0){
           if($this->bankType!=OnlineBankPay::PAY_BANK_NONE){
             if(empty($this->bankCode) && $this->payType!=''){
                 $this->addError($attribute, Yii::t('orderForm', '选择的支付方式错误'));
             }else if(empty($this->bankCode) && $this->payType==''){
                 $this->addError($attribute, Yii::t('orderForm', '请选择一种银行进行支付'));
             }
         }
       }
     }
     

    // 验证支付密码
    /**
     * @param unknown $attribute
     * @param unknown $params
     * @date 20160522 增加支付输入错误密码次数限制
     */
    public function validatePayPassword($attribute, $params) {
        if($this->needPassword==0) return; 
        $uid = Yii::app()->user->id;
        $model = Member::model()->findByPk($uid);
        $cacheKey=$uid.'_orderPay';
        $cacheKey_time=$uid.'_orderPayTime';
        $payLastTime=Tool::cache($cacheKey_time)->get($cacheKey_time);
        $payNum=(int)Tool::cache($cacheKey)->get($cacheKey);
        if($payNum > 3 && empty($payLastTime)){
        	  Tool::cache($cacheKey)->delete($cacheKey);
        	  $payNum=0;
          } 
        if($model && empty($model->password3)){
            $this->addError('password3', Yii::t('orderForm', '您还未设置支付密码！'));
        }
        //密码解密
        $RsaPassword = new RsaPassword();
        $attributes = $RsaPassword->decryptPassword(array('password3' => $this->password3, 'token' => $this->token),'password3');
        if(!$model || !$model->validatePassword3($attributes['password3'])){
        	 $payNum++;
        	Tool::cache($cacheKey)->set($cacheKey, $payNum);//连续输错后12小时才可以再次输入
            if($payNum == 3){ 
            	Tool::cache($cacheKey_time)->set($cacheKey_time, time() ,60*10);
             }
            if($payNum > 3) $this->addError('password3', Yii::t('orderForm', '支付密码错误超过4次！请于12小时后再支付'));
              else $this->addError('password3', Yii::t('orderForm', '支付密码错误！还有'.(4-$payNum).'次输入机会'));
        }else if($payNum > 3 && $payLastTime){
        	$this->addError('password3', Yii::t('orderForm', '支付密码错误超过4次！请于12小时后再支付'));
        }else{
        	Tool::cache($cacheKey)->delete($cacheKey);
        	Tool::cache($cacheKey_time)->delete($cacheKey_time);
        }
    }

    // 验证账户金额
    public function validateAccount($attribute, $params) {

        if ('JF' == $this->payType && $this->accountMoney < $this->totalPrice)
            $this->addError('password3', Yii::t('orderForm', '帐户积分不够支付！'));
    }

    /**
     *  计算 特殊商品在线支付金额
     * @param int $ratio 积分支付比例
     * @return array
     */
    public function singlePayDetail($ratio=null){
        /**
         * @var float $jfPay 积分支付金额
         * @var float $onlinePay 在线支付金额
         */
        if($ratio<=0 || $ratio >= 100){
            $jfPay = Tool::getConfig('order','payJfRatio')/100*$this->totalPrice;
        }else{
            $jfPay = $ratio/100*$this->totalPrice;
        }
        if($jfPay > $this->accountMoney){
            $jfPay = $this->accountMoney;
        }
        return array('onlinePay'=>sprintf('%.2f',$this->totalPrice - $jfPay),'jfPay'=>sprintf('%.2f',$jfPay));
    }

    /**
     * 计算积分+现金的每个支付方式支出金额
     * @param array $result
     * @return array
     * @author binbin.liao
     */
    public function jfxj(array $result){
        $onlinePay=0; //积分要支付的金额
        $orders = $result['orders'];
        foreach($orders as $v){
            foreach($v->orderGoods as $gv){
                $payJfRatio = bcdiv($gv['integral_ratio'],100,6);
                $jfPay = bcmul($v['pay_price'],$payJfRatio,2);
                $jfPay = $jfPay * 1;
                $onlinePay +=$jfPay;
            }
        }
        if($jfPay > $this->accountMoney){
            $onlinePay = $this->accountMoney;
        }

        return array('onlinePay'=>sprintf('%.2f',$this->totalPrice - $onlinePay),'jfPay'=>sprintf('%.2f',$onlinePay));
    }
    /**
     * v2.0 计算积分比例(和旧版不一样，旧版是整单积分比较，如果订单存在不同积分比例的产品，如何计算都是问题)
     * @param array $orders
     * @param object $model orderForm模型
     * @return array 
     */
    public function getDiscount(array $orders,$model,$flag=false)
    {
        $discount = 0;
        $freights = 0;
        $dayLimitMoney=0;
        $memberId=Yii::app()->user->id;
        $memMoneyArr=MemberPoint::getMemberPoint($memberId,$this->accountMoney);
        if(!empty($memMoneyArr))
            $dayLimitMoney=$memMoneyArr['dayLimitMoney'];
        //Tool::pr($dayLimitMoney);
        foreach ($orders as $o) {
            // 订单产品计算
            $goods = $o->orderGoods;
            foreach ($goods as $g) {
                if($g->integral_ratio > 100) return 0;
                if ((int) $g->integral_ratio > 0) {
                    //每款产品允许的积分支付的额度
                    $discount = bcadd(bcmul(bcmul($g->quantity,bcdiv($g->integral_ratio,100,2),2),$g->unit_price,2),$discount,2);
                } else {
                    //未设定积分支付额度，可允许全额积分支付
                    $discount = bcadd(bcmul($g->unit_price,$g->quantity,2),$discount,2);
                }
            }
            //运费额度
            $freights =  bcadd($o->freight,$freights,2);
        }
        // 整个订单允许积分支付的额度(加上运费)
        //if($discount > $dayLimitMoney) $discount = $dayLimitMoney;
        //$discoutTotal = bcadd($discount , $freights,2);
        
        $discoutTotal = bcadd($discount , $freights,2);
        if($discoutTotal > $dayLimitMoney) $discoutTotal = $dayLimitMoney;
        
//        if (!$discoutTotal)
//            $discoutTotal = $model->totalPrice;
        if($flag){
            return array('discoutTotal'=>$discoutTotal,'dayMoney'=>$dayLimitMoney);
        }else{
        	return $discoutTotal;
        }
    }        

}
