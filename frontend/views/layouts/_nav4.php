<?php
// 商店菜单导航
/* @var $this Controller */
/** @var $store Store */
$store = $this->store;
$nav = isset($design) ? $design->tmpData[DesignFormat::TMP_MAIN_NAV] : $this->design->tmpData[DesignFormat::TMP_MAIN_NAV];
?>
<div class="navWrap" id="diyNavWrap">
    <ul class="navItems02 clearfix editor" id="navList">
        <?php
        if (isset($nav['LinkList'])):
            foreach ($nav['LinkList'] as $val):
                ?>
                <li>
                    <?php
                    $url = Design::getNavUrl($val, $store['id']);
                    if ($this->id == 'shop' && ($this->action->id == 'view' || $this->action->id =='preview') && $val['Type'] == DesignFormat::NAV_TYPE_INDEX) {
                        $class = 'current';
                    } else {
                        $class = stripos($url, $this->id . '/' . $this->action->id) !== false ? 'current' : 'no';
                    }
                    //再次判断 所有商品与店铺分类
                    if (($val['Type'] == DesignFormat::NAV_TYPE_CAT || $val['Type'] == DesignFormat::NAV_TYPE_LIST) && $class == 'current') {
                        $class = $this->getParam('cid') == $val['SourceId'] ? 'current' : 'no';
                    }
                    /** 判断文章 */
                    if ($val['Type'] == DesignFormat::NAV_TYPE_ARTICLE) {
                        $class = $this->getParam('aid') == $val['SourceId'] ? 'current' : 'no';
                    }
                    echo CHtml::link(Yii::t('shop', $val['Title']), $url, array('title' => Yii::t('shop', $val['Title']), 'class' => $class,'target'=>'_blank'));
                    ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>
                <?php echo CHtml::link(Yii::t('shop', '店铺首页'), $this->createAbsoluteUrl('/shop/view', array('id' => $store['id'])), array(
                    'title' => Yii::t('shop', '店铺首页'),
                    'class' =>$this->action->id =='view'? 'current' : '',
                    'target'=>'_blank',
                )); ?>
            </li>
            <li>
                <?php echo CHtml::link(Yii::t('shop', '商家介绍'), $this->createAbsoluteUrl('/shop/info', array('id' => $store['id'])), array(
                    'title' => Yii::t('shop', '商家介绍'),
                    'class' =>$this->action->id =='info'? 'current' : '',
                    'target'=>'_blank',
                )); ?>
            </li>
            <li>
                <?php echo CHtml::link(Yii::t('shop', '所有商品'), $this->createAbsoluteUrl('/shop/product', array('id' => $store['id'])), array(
                    'title' => Yii::t('shop', '所有商品'),
                    'class' =>$this->action->id =='product'? 'current' : '',
                    'target'=>'_blank',
                )); ?>
            </li>
        <?php endif; ?>
    </ul>
</div>