<?php
/**
 * 店铺的商品销量top,卖家可以自定义
 *  @author zhenjun_xu <412530435@qq.com>
 * @example
 * <?php $this->widget('application.components.HotWidget',array('storeId'=>$this->store->id)); ?>
 */

class HotWidget extends CWidget{

    public $storeId;

    public $tmpData; //自定义装修数据

    public function run(){
        $list = Design::getGoodsListByCondition($this->storeId,$this->tmpData);
        if(!empty($list)){
            $this->render('hot',array('model'=>$list));
        }
    }
} 