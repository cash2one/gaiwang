<?php
// 首页主导航部分
/* @var $this Controller */
$mainCategory = WebAdData::getMainCategoryData(); //调用接口
//Tool::pr($mainCategory[0]);
?>
<!-- 导航start -->
<div class="gx-nav clearfix">
    <div class="gx-nav-main">
        <div class="gx-nav-left">
            <?php echo Yii::t('site','全部商品分类'); ?>
            <div class="gx-nav-left-list">
                <ul>
                    <?php foreach($mainCategory as $v): ?>
                    <li>
                        <div class="gx-nav-class">
                            <?php
                                if($v['id']==Category::TOP_FOOD){
                                    $url = $this->createAbsoluteUrl('channel/food');
                                }else if($v['id']==Category::TOP_DIGITAL){
                                    $url = $this->createAbsoluteUrl('channel/digital');
                                }else if($v['id']==7){//家居家装
                                    $url=$this->createAbsoluteUrl('/zt/site/Museum-home');	
                                }else{
                                    $url = $this->createAbsoluteUrl('/category/list', array('id' => $v['id']));
                                }
                            ?>
                            <a href="<?php echo $url ?>" target="_blank" title="<?php echo Yii::t('category', $v['name']) ?>" >
                                <span><?php echo Yii::t('category', $v['name']) ?></span>
                            </a>
                        </div>
                        <!-- 隐藏当前商品分类start -->
                        <div class="gx-nav-item clearfix">
                            <div class="gx-nav-item-left">
                                <?php if(!empty($v['adverts_txt'])): ?>
                                <div class="gx-nav-item-recommend clearfix">
                                    <?php
                                    foreach($v['adverts_txt'] as $ka=> $vAd){
                                        if($ka>8) break;
                                        echo CHtml::link(Tool::truncateUtf8String($vAd['title'],5),$vAd['link'],array('target'=>'_blank'));
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <!-- 商品分类start -->
                                <div class="gx-nav-item-style clearfix">
                                    <?php if(isset($v['childClass'])): ?>
                                    <?php foreach($v['childClass'] as $v2): ?>
                                    <dl class="clearfix">
                                        <dt><?php echo CHtml::link(Yii::t('category',$v2['name']),array('/category/list','id'=>$v2['id'])); ?></dt>
                                        <dd>
                                            <?php
                                            if (!empty($v2['childClass'])) {
                                                $i = 1;
                                                foreach ($v2['childClass'] as $v3) {
                                                    echo CHtml::link(Yii::t('category', $v3['name']), array('/category/list', 'id' => $v3['id']));
                                                    echo count($v2['childClass']) == $i ? '' : '&nbsp;|&nbsp;';
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </dd>
                                    </dl>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <!-- 商品分类start -->
                            </div>
                            <div class="gx-nav-item-right">
                                <?php
                                if (!empty($v['adverts'])) {
                                    $i = 0;
                                    foreach ($v['adverts'] as $ak => $av) {
                                        if($av['group']==1) continue;
                                        $i++;
                                        if($i>4) break;
                                        $img = CHtml::image(ATTR_DOMAIN . '/' . $av['picture'], Yii::t('category', $av['title']), array('width' => '168', 'height' => '48'));
                                        echo CHtml::link($img, $av['link'], array('title' => Yii::t('category', $av['title']), 'target' => '_blank'));
                                    }
                                    $i = 0;
                                    foreach ($v['adverts'] as $ak => $av) {
                                        if($av['group']!=1) continue;
                                        $i++;
                                        if($i>1) break;
                                        $img = CHtml::image(ATTR_DOMAIN . '/' . $av['picture'], Yii::t('category', $av['title']), array('width' => '168', 'height' => '203'));
                                        echo CHtml::link($img, $av['link'], array('title' => Yii::t('category', $av['title']), 'target' => '_blank'));
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- 隐藏当前商品分类end -->
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
        <?php $mName = isset($this->getModule()->name) ? $this->getModule()->name : 'active';?>
        <div class="gx-nav-right clearfix">
            
            <?php
            $navigation = $this->getConfig('navigation');//首页顶部导航数据
            if(!empty($navigation)){
                foreach($navigation as $key => $v){
                   if(!empty($v['name']) && !empty($v['title']) && !empty($v['link'])){
                       $tmpStr = str_replace("http://", "", $v['link']);
                       $arrStr = explode(".", $tmpStr);
                       echo CHtml::link(Yii::t('site', $v['name']), $v['link'], array('title' => Yii::t('site', $v['title']),'target'=>'_blank','class' => $mName==$arrStr[0] ? 'gx-nav-sel':''));
                   }
                }
            }else{
                echo CHtml::link(Yii::t('site', '超级盖商'), array('/zt/site/game'), array('title' => Yii::t('site', '超级盖商'),'target'=>'_blank','class' => $mName=='zt'?'gx-nav-sel':''));
                echo CHtml::link(Yii::t('site', '优品汇'), array('/active'), array('title' => Yii::t('site', '优品汇'),'target'=>'_blank','class' => $mName=='active'?'gx-nav-sel':''));
                echo CHtml::link(Yii::t('site', '商旅酒店'), array('/hotel'), array('title' => Yii::t('site', '商旅酒店'),'target'=>'_blank','class' => $mName=='hotel'?'gx-nav-sel':''));
                echo CHtml::link(Yii::t('site', '线下服务'), array('/jms'), array('title' => Yii::t('site', '线下服务'),'target'=>'_blank'));
                echo CHtml::link(Yii::t('site', '盖网通'), array('/gatewangtong'), array('title' => Yii::t('site', '盖网通终端服务'),'target'=>'_blank','class' => $mName=='gatewangtong'?'gx-nav-sel':''));
                //echo CHtml::link(Yii::t('site', '游戏'), array('/yaopin/site/game'), array('title' => Yii::t('site', '游戏'),'target'=>'_blank'));
                //echo CHtml::link(Yii::t('site', '动漫'), array('/yaopin/site/gameComic'), array('title' => Yii::t('site', '动漫·艺术品'),'target'=>'_blank'));
                //echo CHtml::link(Yii::t('site', '药品'), array('/yaopin/site/productList'), array('title' => Yii::t('site', '药品'),'target'=>'_blank'));
            }
            ?>

        </div>
    </div>
</div>
<!-- 导航end -->