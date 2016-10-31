<?php
/** @var $this SearchController */
$this->description = '在盖象商城上找到了'.$storeCount.'个与'.$this->getParam('q').'相关的店铺';
?>
<script type="text/javascript">
 $(function(){
		//分页居中
	 var yiiPageerW=parseInt($(".yiiPageer").css("width"));
	 var pageListInfoW=parseInt($(".pageList-info").css("width"));
	 var pageListW=parseInt($(".pageList").css("width"));
	 var num=(pageListW-(yiiPageerW+pageListInfoW))/2;
	 $(".pageList").css("padding-left",num);
	 })
</script>
<div class="gx-content gx-content2">
    <!-- 面包屑start -->
    <div class="positionWrap goods-positionWrap pt10">
        <div class="position clearfix goods-position">
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'tagName' => 'span',
                'homeLink' => false,
                'separator' => ' > ',
                'links' => array_merge(array(Yii::t('search', '首页') =>DOMAIN, Yii::t('search', '店铺搜索') => 'javascript:;'), $this->breadcrumbs),
                'htmlOptions' => array('class' =>'position-a'),
            ));
            ?>
            <div class="goods-total"><b class="red"><?php echo  CHtml::encode($this->keyword); ?></b> 共<span><?php echo $storeCount ?></span>个相关的店铺</div>
        </div>
    </div>

    <!-- 列表start -->
    <div class="goods-list" style="margin-top:-20px;">
        <div class="goods-list-title">
            <dl class="gst-sort clearfix">
                <dt>排序</dt>
                <dd><?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion1(), 'curr'); ?></dd>
                <dd><?php echo HtmlHelper::generateSortUrl('sales', $this->route, $params, $this->_uriParamsCriterion1(), 'curr', array('class' => 'range')); ?></dd>
                <dd><?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion1(), 'curr', array('class' => 'range')); ?></dd>
            </dl>
            <dl class="gst-condition" style="margin-left:620px;">
                <dd><a href="<?php echo $this->createAbsoluteUrl('search/search',array('q'=>$this->getParam('q'))) ?>" class="goodsIco">商品</a></dd><!--选中调用goodsIcoSel-->
                <dd><a href="#" class="shopIco shopIcoSel">店铺</a></dd><!--选中调用shopIcoSel-->
            </dl>
            <div class="gst-title-paging">
                <div class="paging-num"><?php echo $this->getParam('page')>=1 ? $this->getParam('page'):1 ?>/<?php echo $totalPage>1 ? $totalPage:1; ?></div>
                <div class="paging-left"></div>
                <div class="paging-right"></div>
            </div>
        </div>
    </div>
    <?php if($store): ?>
        <?php foreach($store as $v): ?>
    <div class="goods-shopMess clearfix">
        <div class="gshop-left">
            <div class="gshop-logo">
                <?php
                if(!empty($v['thumbnail'])){
                    $img = Tool::showImg(ATTR_DOMAIN.'/'.$v['thumbnail'],'c_fill,h_45,w_135');
                }else{
                    $img = Yii::app()->theme->baseUrl.'/images/bgs/top_logo.png';
                }
                ?>
                <a target="_blank" href="<?php echo $this->createAbsoluteUrl('shop/view',array('id'=>$v['id'])) ?>">
                    <img src="<?php echo $img ?>" width="135" height="45" />
                </a>

            </div>
            <div class="gshop-name">
                　<?php echo CHtml::link(Tool::truncateUtf8String($v['name'],30),array('shop/view','id'=>$v['id'])); ?>
            </div>
        </div>
        <?php 
            $storeComment = StoreComment::getStoreComment($v['id']);
            $des = isset($storeComment->description_match) ? sprintf('%.2f', $storeComment->description_match) : 0.00;
            $ser = isset($storeComment->serivice_attitude) ? sprintf('%.2f', $storeComment->serivice_attitude) : 0.00;
            $spe = isset($storeComment->speed_of_delivery) ? sprintf('%.2f', $storeComment->speed_of_delivery) : 0.00;
           ?>
        <div class="gshop-right">
            <div class="evaluate">综合评分：<?php echo sprintf('%0.2f',($des+$ser+$spe)/3); ?></div>
            <div class="related-products">相关商品：<span><?php echo isset($v['count']) ? $v['count'] : 0 ?>件</span></div>
            <a class="gshop-link" target="_blank" href="<?php echo $this->createAbsoluteUrl('shop/view',array('id'=>$v['id'])) ?>">进入商铺</a>
        </div>
    </div>

    <ul class="goods-list-main clearfix">
        <?php foreach ($v['goods'] as $k=> $g):
             if($k>4) break;
            ?>
        <li>
            <?php
            $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_225,w_225'), CHtml::encode($g['name']), array('width' => 225, 'height' => 225,'class'=>'gs-list-bigImg'));
            echo CHtml::link($img, array('/goods/view', 'id' => $g['id']),array('target'=>'_blank'));
            ?>
            <div class="goods-list-info">
                <p class="gs-price"><?php echo HtmlHelper::formatPrice($g['price']) ?></p>
                <p class="gs-details" style="word-break: break-all;word-wrap: break-word;line-height:1.5;padding-top:8px;overflow: hidden;height: 33px;">
                    <?php echo CHtml::link(Tool::truncateUtf8String(CHtml::encode($g['name']), 35), $this->createAbsoluteUrl('/goods/view', array('id' => $g['id'])),array('target'=>'_blank','title'=>CHtml::encode($g['name']))); ?>
                </p>
            </div>
            <div class="goods-list-border"></div>
<!--            <div class="gx-goodsico gx-goodsico1"></div>-->
        </li>
        <?php endforeach; ?>
    </ul>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- 列表start -->
    <div class="pageList mb50 clearfix" >
            <?php
            /*$this->widget('SLinkPager', array(
                'pages' => $pages,
                'jump'=>false,
                'htmlOptions'=>array('class'=>'yiiPageer','style'=>'float:none;max-width:600px;')
            ));*/

            ?>
    <?php
	  $this->widget('SLinkPager', array(
		  'header' => '',
		  'cssFile' => false,
		  'firstPageLabel' => Yii::t('page', '首页'),
		  'lastPageLabel' => Yii::t('page', '末页'),
		  'prevPageLabel' => Yii::t('page', '上一页'),
		  'nextPageLabel' => Yii::t('page', '下一页'),
		  'maxButtonCount' => 5,
		  'pages' => $pages,
		  'htmlOptions' => array(
			  'class' => 'yiiPageer'
		  )
	  ));
  ?>  
    </div>
    <?php if(empty($store)): ?>
    <div class="goods-screening clearfix" style="padding:20px;">
        <span class="ico_nptips" style="float: left;" ><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" /></span>
        <div class="noProTxt" style="float: left;margin-left:20px;">
            <h2><?php echo Yii::t('trade', '很抱歉，没找到与{a}相关的店铺哦，要不您换个关键词我帮您再找找看。', array('{a}' => '<span style="color:red;">'.$this->getParam('q').'</span>')); ?></h2>
            <h3><?php echo Yii::t('search', '建议您'); ?>：</h3>
            <p><?php echo Yii::t('search', '1.看看输入的文字是否有误。'); ?></p>
            <p><?php echo Yii::t('search', '2.重新搜索。'); ?></p>
        </div>
    </div>
    <?php endif; ?>
    <!-- 猜你喜欢模块start -->
    <div class="gx-bot-module gx-bot-module-goods clearfix">
        <?php echo $this->renderPartial('//site/_doyoulike')?>
    </div>
    <!-- 猜你喜欢模块end -->
</div>

<script>
    //当前排序样式
    $(".gst-sort dd a").each(function(){
        if($(this).hasClass('curr')){
            $(this).parent().addClass('ddSel');
        }else{
            $(this).parent().removeClass('ddSel');
        }
    });
    //上一页、下一页
    var p = "<?php  echo$this->getParam('page'); ?>";
    if(p<=0 || p.length==0) p = 1;
    p = parseInt(p);
    $(".paging-left").click(function(){
        window.location.href = "<?php echo  $this->createAbsoluteUrl('search/search', array_merge($params, array('page' => $this->getParam('page')-1))) ?>";
    });
    $(".paging-right").click(function(){
        if(p < "<?php echo $totalPage ?>") {
            window.location.href = "<?php echo   $this->createAbsoluteUrl('search/search', array_merge($params, array('page' => $this->getParam('page')<=0 ? 2 : $this->getParam('page')+1))) ?>";
        }
    });
</script>
