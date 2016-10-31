<?php
/**
 * 购物车类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
//$goods = array(
//    'goods_id' => $goods_id,
//    'spec_id' => $spec_id,
//    'store_id' => $storeId,
//    'quantity' => $quantity,
//    'price' => $price,
//);
class ShopCart
{
//    public static $hyjGoodsId = array(49282,1); 合约机商品id,已经放到盖网后台配置
    
    const MAX_NUM_LIMIT = 20;
    /**
     * @var array 购物车商品列表
     */
    public $goodsList = array();
    private $_oldGoodsList = array(); //刚获得的购物车数据，中间变量不做修改
    /**
     * @var int 会员id
     */
    private $_member_id;
    /** @var  SessionCart or Cart $cart */
    public $cart;
    /**
     * @var array 被删除的历史数据，存放在 fileCache
     */
    public $historyData = array();

    const HISTORY_NUM = 3;
    /** 删除历史商品缓存时间 86400 一天*/
    const HISTORY_TIME = 180;

    const CART_HISTORY_PATH = 'cart_history';


    public function __construct()
    {
        $this->_member_id = Yii::app()->user->id;
        if ($this->_member_id) {
            $this->cart = Cart::model();
        } else {
            $this->cart = SessionCart::model();
        }
        $this->goodsList = $this->_oldGoodsList = $this->cart->goodsList($this->_member_id);
        $cookie = Yii::app()->request->cookies[self::CART_HISTORY_PATH.$this->_member_id];
        $this->historyData = $cookie ? $cookie->value : array();
        if(count($this->historyData)>self::HISTORY_NUM){
            $this->historyData = array_slice($this->historyData,0,self::HISTORY_NUM);
            $cookie = new CHttpCookie(self::CART_HISTORY_PATH.$this->_member_id,$this->historyData,array('domain'=>SHORT_DOMAIN));
            $cookie->expire = time()+self::HISTORY_TIME;
            Yii::app()->request->cookies[self::CART_HISTORY_PATH.$this->_member_id]=$cookie;
        }
    }

    /**
     * 购物车检查
     * @param array $goods 传进来的商品
     * @return false|string   false购物车里面没有该商品,string goods_id+spec_id
     */
    public function checkProduct($goods)
    {
        if(!empty($this->goodsList)){
            foreach($this->goodsList as $k=>$v){
                if($k==$goods['goods_id'].'-'.$goods['spec_id']){
                    return $k;
                }
            }
        }
        return false;
    }

    /**
     * 添加到购物车 qiuye.xu edit at 2015.11.13
     * @param array $goods
     * @param  int $stock 产品库存数量
     * @return boolean 
     */
    public function add($goods,$stock)
    {
        $k  = $this->checkProduct($goods);
        if($k){
            //update
            if($this->goodsList[$k]['quantity'] == $stock) {
                return true;
            }
            else if($this->goodsList[$k]['quantity']+$goods['quantity'] > $stock){
                $this->goodsList[$k]['quantity'] = $stock;
            } else {
                $this->goodsList[$k]['quantity'] += $goods['quantity'];
            }
        }else{
            //insert
            $k = $goods['goods_id'].'-'.$goods['spec_id'];
            $this->goodsList[$k] = $goods;
        }
        //删除相应的历史记录
        if(!empty($this->historyData)){
            $flag = false;
            foreach($this->historyData as $kh=>$v){
                if($goods['spec_id']==$v['spec_id'] && $goods['goods_id']==$v['goods_id']){
                    $flag = true;
                    unset($this->historyData[$kh]);
                }
            }
            if($flag){
                $cookie = new CHttpCookie(self::CART_HISTORY_PATH.$this->_member_id,$this->historyData,array('domain'=>SHORT_DOMAIN));
                $cookie->expire = time()+self::HISTORY_TIME;
                Yii::app()->request->cookies[self::CART_HISTORY_PATH.$this->_member_id]=$cookie;
            }
        }

        return $this->_updateOrInsert($k);

    }
    /**
     * 更新或者添加购物车
     * @param $k
     * @return int|false
     */
    private  function _updateOrInsert($k){
        if(array_key_exists($k,$this->_oldGoodsList)){
            //update
            return $this->cart->update($this->goodsList[$k],$k);
        }else{
            //insert
            return $this->cart->add($this->goodsList[$k],$k);
        }
    }

    //更新购物车
    public function update($goods)
    {
        $k = $this->checkProduct($goods);
        if($k){
            $this->goodsList[$k]['quantity'] = $goods['quantity'];
            return $this->cart->update($this->goodsList[$k],$k);
        }
        return false;
    }

    //删除
    public function delete($goods,$collectId='')
    {
        $k = $this->checkProduct($goods);
        if($k){
            $this->cart->del($goods,$k);
            //如果传入的商品是移入收藏，则不做记录
            if($goods['goods_id']!=$collectId){
                if (count($this->historyData) > self::HISTORY_NUM)
                    unset($this->historyData[0]);
                if(!empty($this->historyData)){
                    array_unshift($this->historyData,$goods);
                }else{
                    $this->historyData[] = $goods;
                }
                $cookie = new CHttpCookie(self::CART_HISTORY_PATH.$this->_member_id,$this->historyData,array('domain'=>SHORT_DOMAIN));
                $cookie->expire = time()+self::HISTORY_TIME;
                Yii::app()->request->cookies[self::CART_HISTORY_PATH.$this->_member_id]=$cookie;
            }
            unset($this->goodsList[$k]);
        }
    }

    //批量删除
    public function deleteSelected($goods,$collectIds='')
    {
        if(!empty($collectIds)){
            $collectIds = explode(',',$collectIds);
        }else{
            $collectIds = array();
        }
        foreach ($goods as $v) {
            if(in_array($v['goods_id'],$collectIds)){
                $this->delete($v,$v['goods_id']);
            }else{
                $this->delete($v);
            }

        }
    }

    /**
     * 同步购物车,将session中的数据合并到数据库
     */
    public function sync()
    {
        $sessionGoods = Yii::app()->user->getState('cart');
        if($sessionGoods){
            $goodsList = CMap::mergeArray($this->goodsList,$sessionGoods);
            $this->cart->sync($this->goodsList,$goodsList);
            Yii::app()->user->setState('cart',null);
        }
    }

    /**
     * 计算商品的总价
     */
    public function totalPrice(){
        $total_price = 0;
        foreach($this->goodsList as $v){
            $total_price += $v['price']*$v['quantity'];
        }
        return sprintf('%0.2f',$total_price);
    }

    /**
     * 查询购物车内的商品详情
     * @param array $goodsList
     * @return array
     */
    public function getGoodsDetails($goodsList=array()){
        if(empty($goodsList)) $goodsList = $this->goodsList;
        $uniqueGoods =  Goods::getGoodsDetails(implode(',',$this->getGoodsIds($goodsList)));
        $goodsArrDetail = array();
        foreach($goodsList as $k => $v){
            foreach($uniqueGoods as $v2){
                if($v['goods_id']==$v2['goods_id']){
                    $goodsArrDetail[$k] = CMap::mergeArray($v2,$v);
                }
            }
        }
        return $goodsArrDetail;
    }

    /**
     * 获取购物车内的商品id、或者指定数据的id集合
     * @param array $goodsList
     * @return array 商品id集合
     */
    public function getGoodsIds($goodsList=array()){
        $ids = array(); //购物车所有的商品id
        if(empty($goodsList)) $goodsList = $this->goodsList;
        if(empty($goodsList)) return $ids;
        foreach($goodsList as $v){
            if(!in_array($v['goods_id'],$ids)){
                $ids[] = $v['goods_id'];
            }
        }
        return $ids;
    }

    /**
     * 检查是否特殊商品，或者获取特殊商品的id集合
     * @param null|int| array  $goods
     * @return bool|array
     */
    public static function checkSpecialGoods($goods=null){
        if(is_array($goods)){
            //积分支付比例
            if($goods['jf_pay_ratio']>0 && $goods['jf_pay_ratio']<100){
                return true;
            }else if($goods['integral_ratio'] < 100 && $goods['integral_ratio'] > 0){
                return true;
            }else{
                return false;
            }
        }
        $goodsArr = explode(',',Tool::getConfig('order','specialGoods'));
        if($goods){
            return in_array($goods,$goodsArr) ? true : false;
        }else{
            return $goodsArr;
        }
    }
    /**
     * 检查是否合约机，或者获取合约机商品的id集合
     * @param null $goodsId
     * @return bool|array
     */
    public static function checkHyjGoods($goodsId=null){
        $goodsArr = Heyue::getHeyueList();
        if($goodsId){
            return in_array($goodsId,$goodsArr) ? true : false;
        }else{
            return $goodsArr;
        }
    }

    /**
     * 根据商品id，判断订单的 sourceType
     * @param $goodsId
     * @return int
     */
    public static function checkSourceType($goodsId){
        $sourceType = Order::SOURCE_TYPE_DEFAULT;
        if(self::checkHyjGoods($goodsId)){
            $sourceType = Order::SOURCE_TYPE_HYJ;
        }else if(self::checkSpecialGoods($goodsId)){
            $sourceType = Order::SOURCE_TYPE_SINGLE;
        }
        return $sourceType;
    }

    /**
     * 获取购物车已删除的历史数据
     * @return array
     */
    public function getCartHistory(){
        return !empty($this->historyData) ? $this->getGoodsDetails($this->historyData):array();
    }


}