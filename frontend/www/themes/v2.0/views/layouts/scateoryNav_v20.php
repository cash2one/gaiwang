<?php
// 商店菜单导航
/* @var $this Controller */
/** @var $store Store */
$store = $this->store;
$nav = isset($design) ? $design->tmpData[DesignFormat::TMP_MAIN_NAV] : $this->design->tmpData[DesignFormat::TMP_MAIN_NAV];
?>
 <div class="shop-nav2" id="navList">
     <ul class="clearfix"> 
       <?php
        if (isset($nav['LinkList'])):
            unset($nav['LinkList'][1]);
            foreach ($nav['LinkList'] as $k => $val):
                ?>
                    <?php
                    $url = Design::getNavUrl($val, $store['id']);
                    if ($this->id == 'shop' && ($this->action->id == 'view' || $this->action->id =='preview') && $val['Type'] == DesignFormat::NAV_TYPE_INDEX) {
                        $class = 'shop-nav2-selLi';
                    } else {
                        $class = stripos($url, $this->id . '/' . $this->action->id) !== false ? 'shop-nav2-selLi' : 'no';
                    }
                    //再次判断 所有商品与店铺分类
                    if (($val['Type'] == DesignFormat::NAV_TYPE_CAT || $val['Type'] == DesignFormat::NAV_TYPE_LIST) && $class == 'shop-nav2-selLi') {
                        $class = $this->getParam('cid') == $val['SourceId'] ? 'shop-nav2-selLi' : 'no';
                    }
                    /** 判断文章 */
                    if ($val['Type'] == DesignFormat::NAV_TYPE_ARTICLE) {
                        $class = $this->getParam('aid') == $val['SourceId'] ? 'shop-nav2-selLi' : 'no';
                    }
                    ?>
                    <?php 
                    echo '<li class="'.$class.'">'.CHtml::link(Yii::t('shop', $val['Title']), $url, array('title' => Yii::t('shop', $val['Title']),'target'=>'_blank')).'</li>';
                    ?>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="<?php echo $this->action->id =='view'? 'shop-nav2-selLi' : '' ?>">
                <?php echo CHtml::link(Yii::t('shop', '店铺首页'), $this->createAbsoluteUrl('/shop/view', array('id' => $store['id'])), array(
                    'title' => Yii::t('shop', '店铺首页'),
                    'target'=>'_blank',
                )); ?>
            </li>
            <li class="<?php echo $this->action->id =='product' ? 'shop-nav2-selLi' : ''?>">
                <?php echo CHtml::link(Yii::t('shop', '所有商品'), $this->createAbsoluteUrl('/shop/product', array('id' => $store['id'])), array(
                    'title' => Yii::t('shop', '所有商品'),
                    'target'=>'_blank',
                )); ?>
            </li>
        <?php endif; ?>
  	 </ul>
 </div>
