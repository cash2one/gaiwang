<div class="sortbar">
    <div class="sortSearch">
        <?php echo Yii::t('goods','本店搜索');?>：<input type="text" class="name" value="<?php echo $box['params']['keyword']; ?>" name="input_txt3"  style="width:150px" />
        <?php echo Yii::t('goods','积分');?>：<input type="text" class="integ" value="<?php echo!empty($box['params']['minScore']) ? $box['params']['minScore'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" style="width:60px"/>—<input type="text" class="integ" value="<?php echo!empty($box['params']['maxScore']) ? $box['params']['maxScore'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" style="width:60px"/>
        <input type="button" class="searchBtn"  value="<?php echo Yii::t('goods','搜索');?>" name="btn1" id="gSearch" />
    </div>
</div>
<?php // 商品主体列表
if (!empty($box['goods'])): ?>
<div class="proArrange04 editor"  id="proList" >
    <div class="title clearfix">
        <h3><span class="en"></span><?php echo Yii::t('goods',$box['title']); ?></h3>
        <a href="<?php echo Yii::app()->createAbsoluteUrl('shop/product', array_merge($this->_uriProductParams(), array('id' => $this->storeId, 'order' => 1))) ?>" title="<?php echo Yii::t('goods','推荐');?>" class="icon_v more"><?php echo Yii::t('goods','推荐');?></a>
    </div>
    <ul class="content clearfix">
        <?php foreach ($box['goods'] as $g): ?>
            <li>
            <?php
            $url = Yii::app()->createAbsoluteUrl('goods/' . $g['id']);
            $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_170,w_170'),$g['name']);
            ?>
                <div class="libox">
                    <?php echo CHtml::link($img,$url,array('class'=>'img')); ?>
                    <div class="txt">
                        <?php echo CHtml::link(Tool::truncateUtf8String($g['name'], 12, '..'),$url,array('class'=>'name')) ?>
                        <p><?php echo Yii::t('shop','浏览量：{num}次',array('{num}'=>$g['views'])) ?></p>
                        <p><?php echo Yii::t('shop', '换购积分'); ?>:<span class="red"><?php echo HtmlHelper::priceConvertIntegral($g['price']); ?></span></p>

                        <p><?php echo Yii::t('shop', '价格'); ?>：<span class="red"><?php echo HtmlHelper::formatPrice($g['price']); ?></span></p>
                    </div>
                    <?php echo CHtml::link(Yii::t('shop', '加入购物车'), "javascript:addCart({$g['id']},{$g['goods_spec_id']});", array('title' => Yii::t('shop', '加入购物车'), 'class' => 'icon_v addCart Carfly')) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="pageList clearfix">
    <?php
    $this->widget('CLinkPager', array(
        'cssFile' => false,
        'header' => '',
        'firstPageLabel' => Yii::t('goods','首页'),
        'lastPageLabel' => Yii::t('goods','末页'),
        'prevPageLabel' => Yii::t('goods','上一页'),
        'nextPageLabel' => Yii::t('goods','下一页'),
        'pages' => $box['pager'],
        'maxButtonCount' => 5,
        'htmlOptions' => array(
            'class' => 'yiiPageer'
        )
        )
    );
    ?> 
</div>
<?php else: ?>
<div class="noProTips clearfix editor" id="proList">
    <span class="ico_nptips"><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="图标"></span>
    <div class="noProTxt">
        <h2><?php echo Yii::t('goods','很抱歉，没找到相关的商品哦，要不您换个方式搜索我帮您再找找看。');?></h2>
        <h3><?php echo Yii::t('goods','建议您');?>：</h3>
        <p><?php echo Yii::t('goods','1.看看输入的文字是否有误。');?></p>
        <p><?php echo Yii::t('goods','2.重新搜索。');?></p>
    </div>
</div>
<?php endif; ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$(function() {
    $(\"#gSearch\").click(function() {
        var key = $(this).siblings(\"input:first\").val();
        var min = $(this).siblings(\"input[name=input_txt1]\").val();
        var max = $(this).siblings(\"input:last\").val();
        min = min == '' ? 0 : min;
        max = max == '' ? 0 : max;
        location.assign('" . urldecode(Yii::app()->createAbsoluteUrl($this->route, array_merge($box['params'], array('keyword' => "'+key+'", 'minScore' => "'+min+'", 'maxScore' => "'+max+'")))) . "');
    });
});
");
?>