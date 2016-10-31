<?php
// 首页主导航部分
/* @var $this Controller */
?>
<?php $mainCategorys = WebAdData::getMainCategoryData(); //调用接口?>
<div class="navWrap">
    <div class="nav clearfix">
        <div class="menu">
            <span class="name current"><?php echo Yii::t('site', '首页/全部商品分类'); ?></span>
            <?php if (!empty($mainCategorys)): ?>
                <div class="menuList">
                    <?php $i = 1; ?>
                    <?php foreach ($mainCategorys as $ck => $cv) : ?>
                        <div class="menuItem">
                            <h3 class="firMenu">
                                <?php echo CHtml::link(Yii::t('category', $cv['name']), $this->createAbsoluteUrl('/category/list', array('id' => $cv['id'])), array('title' => Yii::t('category', $cv['name']), 'target' => '_blank', 'class' => 'icon_v iconMenu' . $i)); ?>
                                <i class="icon_v arrowLeft"></i>
                            </h3>
                            <div class="subMenu clearfix" style="display:none;">
                                <div class="subMenuList">
                                    <?php if (!empty($cv['childClass'])): ?>
                                        <?php foreach ($cv['childClass'] as $twock => $twocv): ?>
                                            <dl class="secMenu clearfix">
                                                <dt>
                                                <?php echo CHtml::link(Yii::t('category', $twocv['name']), $this->createAbsoluteUrl('/category/view', array('id' => $twocv['id'])), array('title' => Yii::t('category', $twocv['name']), 'target' => '_blank')); ?>
                                                <?php echo CHtml::link(Yii::t('category', '更多'), $this->createAbsoluteUrl('/category/view', array('id' => $twocv['id'])), array('class' => 'more', 'title' => Yii::t('category', '更多'), 'target' => '_blank')); ?>
                                                </dt>
                                                <dd>
                                                    <?php if (!empty($twocv['childClass'])): ?>
                                                        <?php foreach ($twocv['childClass'] as $subck => $subcv): ?>
                                                            <?php echo CHtml::link(Yii::t('category', $subcv['name']), $this->createAbsoluteUrl('/category/view', array('id' => $subcv['id'])), array('title' => Yii::t('category', $subcv['name']), 'target' => '_blank')); ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </dd>
                                            </dl>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="recomBrand">
                                    <div class="title">
                                        <h3><?php echo Yii::t('site', '推荐品牌'); ?></h3>
                                        <p class="en">RECOMMEND</p>
                                    </div>
                                    <div class="recomBrand_t mt10">

                                            <?php if (!empty($cv['brands'])): ?>
                                                <?php foreach ($cv['brands'] as $bk => $bv): ?>

                                                        <?php
                                                        $bk++;
                                                        $id = 'brand' . Tool::shiftWork($bk);
                                                        $img = Tool::showImg(IMG_DOMAIN . '/' . $bv['logo'], "c_fill,h_30,w_90");
                                                        echo CHtml::link(CHtml::image($img, '', array('width' => '90', 'height' => '30')), '', array('title' => Yii::t('category', $bv['name']), 'target' => '_blank','class' => 'items'));
                                                        ?>

                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                    </div>
                                    <div class="adbox">
                                        <?php if (!empty($cv['adverts'])): ?>
                                            <?php //$img = CHtml::image(ATTR_DOMAIN . '/' . $cv['adverts']['picture'], Yii::t('category', $cv['adverts']['title']), array('width' => '195', 'height' => '325')) ?>
                                            <?php //echo CHtml::link($img, $cv['adverts']['link'], array('title' => Yii::t('category', $cv['adverts']['title']))); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div><!--subMenu end-->
                        </div>
                        <?php $i++ ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <ul class="navItems clearfix">
            <li><?php echo CHtml::link(Yii::t('site', '超级盖网'), $this->createAbsoluteUrl('/zt/site/game'), array('title' => Yii::t('site', '超级盖网'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '积分兑换'), $this->createAbsoluteUrl('/jf'), array('title' => Yii::t('site', '积分兑换'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '线下服务'), $this->createAbsoluteUrl('/jms'), array('title' => Yii::t('site', '线下服务'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '酒店预订'), $this->createAbsoluteUrl('/hotel'), array('title' => Yii::t('site', '酒店预订'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '优品汇'), $this->createAbsoluteUrl('/active'), array('title' => Yii::t('site', '优品汇'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '盖网通终端服务'), $this->createAbsoluteUrl('/gatewangtong'), array('class' => 'icon_v gwt', 'title' => Yii::t('site', '盖网通终端服务'),'target'=>'_blank')); ?></li>
            <!--<li><?php //echo CHtml::link(Yii::t('site', '游戏'), $this->createAbsoluteUrl('/yaopin/site/game.html'), array('title' => Yii::t('site', '游戏'),'target'=>'_blank')); ?></li>-->
            <!--<li><?php //echo CHtml::link(Yii::t('site', '动漫·艺术品'), $this->createAbsoluteUrl('/yaopin/site/gameComic.html'), array('title' => Yii::t('site', '动漫·艺术品'),'target'=>'_blank')); ?></li>-->
            <!--<li><?php //echo CHtml::link(Yii::t('site', '药品'), $this->createAbsoluteUrl('/yaopin/site/productList.html'), array('title' => Yii::t('site', '药品'),'target'=>'_blank')); ?></li>-->
        </ul>
    </div>
</div>