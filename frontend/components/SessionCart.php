<?php
/**
 * 未登录情况下，购物车的session操作
 */
class SessionCart {

    public static  $model;
    /**
     * @var array 购物车商品数组，相当于 ShopCart中的goodsList
     */
    public $cart = array();

    public static  function model(){
        if(!empty(self::$model)){
            return self::$model;
        }else{
            self::$model = new SessionCart();
            return self::$model;
        }
    }

    /**
     * 获取购物车数据
     * @return array|mixed
     */
    public function goodsList(){
        $this->cart = Yii::app()->user->getState('cart');
        return $this->cart ? $this->cart : array();
    }

    /**
     * 添加商品
     * @param $goodsData
     * @param $k
     * @return bool
     */
    public function add($goodsData,$k){
        $this->cart[$k] = $goodsData;
        Yii::app()->user->setState('cart',$this->cart);
        return true;
    }

    /**
     * 更新购物车
     * @param $goodsData
     * @param $k
     * @return bool
     */
    public function update($goodsData,$k){
        $this->cart[$k] = $goodsData;
        Yii::app()->user->setState('cart',$this->cart);
        return true;
    }

    public function del($goodsData,$k){
        unset($this->cart[$k]);
        Yii::app()->user->setState('cart',$this->cart);
        return true;
    }




} 