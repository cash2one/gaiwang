<?php
// 公共主导航部分
/* @var $this Controller */
?>
<script type="text/javascript">
    $(function() {
        /*菜单*/
        $("#allMenu").hover(function() {
            $("#menuList02").css('display', 'block');
        }, function() {
            $("#menuList02").css('display', 'none');
        })
        $("#menuList02").hover(function() {
            $(this).css('display', 'block');
        }, function() {
            $(this).css('display', 'none');
        })
    })
</script>

<?php
$mName = isset($this->getModule()->name) ? $this->getModule()->name : 'jf';
if (!$productCategorys = $this->cache(Category::CACHEDIR)->get(Category::CK_TREECATEGORY))
    $productCategorys = Category::treeCategory();

//Tool::pr($productCategorys);
?>
<div class="navWrap">
    <div class="nav clearfix">
        <div class="menu">
            <span class="name" id="allMenu"><?php echo Yii::t('site', '首页/全部商品分类'); ?></span>
            <ul class="menuList02 clearfix" id="menuList02" style="display:none; ">
                <?php foreach ($productCategorys as $pk => $pv): ?>
                    <li>
                        <h3>
                            <?php echo CHtml::link(Yii::t('category', $pv['name']), $this->createAbsoluteUrl('/category/list', array('id' => $pv['id'])), array('target' => '_blank')); ?>
                        </h3>
                        <div class="subItem clearfix">
                            <?php if (!empty($pv['childClass'])): ?>    
                                <?php foreach ($pv['childClass'] as $sk => $sv): ?>
                                    <?php echo CHtml::link(Yii::t('category', $sv['name']), $this->createAbsoluteUrl('/category/view', array('id' => $sv['id'])), array('target' => '_blank', 'title' => Yii::t('category', $sv['name']))); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <ul class="navItems clearfix">
            <li><?php echo CHtml::link(Yii::t('site', '超级盖网'), $this->createAbsoluteUrl('/zt/site/game'), array('title' => Yii::t('site', '超级盖网'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '积分兑换'), $this->createAbsoluteUrl('/jf'), array('class' => $mName=='jf'?'current':'', 'title' => Yii::t('site', '积分兑换'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '线下服务'), $this->createAbsoluteUrl('/jms'), array('class' => $mName=='jms'?'current':'','title' => Yii::t('site', '线下服务'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '酒店预订'), $this->createAbsoluteUrl('/hotel'), array('class' => $mName=='hotel'?'current':'','title' => Yii::t('site', '酒店预订'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '优品汇'), $this->createAbsoluteUrl('/active'), array('class' => $mName=='active'?'current':'','title' => Yii::t('site', '优品汇'),'target'=>'_blank')); ?></li>
            <li><?php echo CHtml::link(Yii::t('site', '盖网通终端服务'), $this->createAbsoluteUrl('/gatewangtong'), array('class' => 'icon_v gwt'.($mName=='gatewangtong'?' current':''), 'title' => Yii::t('site', '盖网通终端服务'),'target'=>'_blank')); ?></li>
            <!--<li><?php //echo CHtml::link(Yii::t('site', '游戏'), $this->createAbsoluteUrl('/yaopin/site/game.html'), array('title' => Yii::t('site', '游戏'),'target'=>'_blank')); ?></li>-->
            <!--<li><?php //echo CHtml::link(Yii::t('site', '动漫·艺术品'), $this->createAbsoluteUrl('/yaopin/site/gameComic.html'), array('title' => Yii::t('site', '动漫·艺术品'),'target'=>'_blank')); ?></li>-->
            <!--<li><?php //echo CHtml::link(Yii::t('site', '药品'), $this->createAbsoluteUrl('/yaopin/site/productList.html'), array('title' => Yii::t('site', '药品'),'target'=>'_blank')); ?></li>-->
        </ul>
    </div>
</div>