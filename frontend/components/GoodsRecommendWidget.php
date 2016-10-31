<?php
/**
 * 店铺商品列表显示
 */

class GoodsRecommendWidget extends CWidget {
    /** @var  object 店铺数据 */
    public $design;
    public $storeId;
    public function run(){
        if(!empty($this->design)){
            $box = Design::getGoodsListByCondition($this->storeId, $this->design, '', 4);
            $this->render('goodsrecommend',array('box'=>$box));
        }
    }
} 