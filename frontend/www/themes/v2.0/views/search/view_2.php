<?php
/** @var $this Controller */
$this->description = '在盖象商城上找到了'.$goodsCount.'件与'.$this->getParam('q').'相关的商品';

if(!empty($brands)){
    $des = array_slice($brands,0,4,true);
    $name = array();
    foreach($des as $b){
        $name[] = $b['name'];
    }
    $description = implode(',', $name);
    $this->description = $this->description . '其中包括' . $description . '等品牌类型的' . $this->getParam('q') . '商品';
}

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
                'links' => array_merge(array(Yii::t('search', '首页') =>DOMAIN, Yii::t('search', '商品搜索') => 'javascript:;'), $this->breadcrumbs),
                'htmlOptions' => array('class' =>'position-a'),
            ));
            ?>
            <div class="goods-total"><b class="red"><?php echo  CHtml::encode($this->keyword); ?></b> 共<span><?php echo $goodsCount ?></span>件相关商品</div>
        </div>
    </div>
    <!-- 面包屑end -->
    <div class="goods-screening clearfix">
        <?php if ((isset($_GET['bid']) && $this->getParam('bid') >= 0) || $this->getParam('cid') > 0): ?>
        <dl class="clearfix">
            <dt>已选择</dt>
            <dd class="gs-ddmid">
                <ul class="gs-xz clearfix">
                    <?php if (isset($_GET['bid']) && $this->getParam('bid') >= 0) : ?>
                        <li>
                            <?php echo Yii::t('category',Brand::getBrandsName($this->getParam('bid'))); ?>
                            <span class="col" onclick="location.href='<?php echo Yii::app()->request->getUrl().'&bid=-1'; ?>'"></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->getParam('cid') > 0) : ?>
                        <li style="margin-left:10px;" >
                            <?php echo Yii::t('category',Category::getCategoryName($this->getParam('cid'))); ?>
                            <span class="col" onclick="location.href='<?php echo Yii::app()->request->getUrl().'&cid=0'; ?>'"></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </dd>
            <dd class="gs-ddright clearfix">
                <span class="gs-but gs-clearBut" onclick="location.href='<?php echo Yii::app()->request->getUrl().'&cid=0&bid=-1'; ?>'">清除全部</span>
            </dd>
        </dl>
        <?php endif; ?>
        <dl class="clearfix">
            <dt><?php echo Yii::t('search', '品牌'); ?></dt>
            <dd class="gs-ddmid">
                <ul class="gs-sizeList" style="height: 26px;">
                    <?php if (empty($brands)): ?>
                        <?php echo Yii::t('search', '没有相关品牌'); ?>!
                    <?php else: ?>
                        <?php foreach ($brands as $val): ?>
                            <li style="width:auto;margin:0 15px 0 5px;">
                                <a href="<?php echo $this->createAbsoluteUrl('/search/search', array_merge($params, array('bid' => $val['id']))); ?>">
                                    <?php echo Yii::t('category',$val['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </dd>
            <dd class="gs-ddright clearfix">
                <span class="gs-more gs-more2">更多</span>
            </dd>
        </dl>
        <div class="gs-line gs-line2"></div>
        <dl class="clearfix">
            <dt><?php echo Yii::t('search', '分类'); ?></dt>
            <dd class="gs-ddmid">
                <ul class="gs-sizeList" style="height: 26px;">
                    <?php if (empty($cates)): ?>
                        <?php echo Yii::t('search', '没有相关分类'); ?>!
                    <?php else: ?>
                        <?php foreach ($cates as $val): ?>
                            <li style="width:auto;margin:0 15px 0 5px;">
                                <a href="<?php echo $this->createAbsoluteUrl('/search/search', array_merge($params, array('cid' => $val['id']))); ?>"><?php echo Yii::t('category', $val['name']) ?></a></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </dd>
            <dd class="gs-ddright clearfix">
                <span class="gs-more gs-more2">更多</span>
            </dd>
        </dl>

    </div>
    <!-- 列表start -->
    <div class="goods-list">
        <div class="goods-list-title">
            <dl class="gst-sort clearfix">
                <dt>排序</dt>
                <dd><?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion(), 'curr'); ?></dd>
                <dd><?php echo HtmlHelper::generateSortUrl('sales_volume', $this->route, $params, $this->_uriParamsCriterion(), 'curr', array('class' => 'range')); ?></dd>
                <dd><?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriParamsCriterion(), 'curr', array('class' => 'pricerange')); ?></dd>
                <!--  
                <dd> <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion(), 'curr', array('class' => 'range')); ?></dd>
                    -->
            </dl>
            <dl class="gst-address">
                <dd>
                    <input type="checkbox" name="seckill_seting_id" <?php if(isset($_GET['seckill_seting_id'])) echo 'checked'?> class="gst-box" value="<?php echo Goods::JOIN_ACTIVITY_YES ?>"/><?php echo Yii::t('category','参与活动')?>
                </dd>
                <dd>
                    <input type="checkbox" name="freight_payment_type" <?php if(isset($_GET['freight_payment_type'])) echo 'checked'?> class="gst-box" value="<?php echo Goods::FREIGHT_TYPE_SELLER_BEAR ?>"/><?php echo Yii::t('category','包邮')?>
                </dd>
                <dd>
                    <div class="gst-range gst-range2">
                        ￥<input type="text" class="input_txt start_price" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" />
                    </div>
                    <div class="gst-line">-</div>
                    <div class="gst-range">￥<input type="text" class="input_txt end_price" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" /></div>
                    <input type="button" class="gst-range-but" value="确定" id="integralSearch">
                </dd>
            </dl>
            <dl class="gst-condition">
                <dd><a href="#" class="goodsIco goodsIcoSel">商品</a></dd><!--选中调用goodsIcoSel-->
                <dd><a href="<?php echo $this->createAbsoluteUrl('search/search',array('q'=>$this->getParam('q'),'o'=>'店铺')) ?>" class="shopIco">店铺</a></dd><!--选中调用shopIcoSel-->
            </dl>
            <div class="gst-title-paging">
                <div class="paging-num"><?php echo $this->getParam('page')>=1 ? $this->getParam('page'):1 ?>/<?php echo $totalPage>1 ? $totalPage :1 ?></div>
                <div class="paging-left"></div>
                <div class="paging-right"></div>
            </div>
        </div>
    </div>

    <ul class="goods-list-main clearfix">
        <?php foreach ($goods as $g): ?>
        <li>
            <?php
            $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_225,w_225'), CHtml::encode($g->name), array('width' => 225, 'height' => 225,'class'=>'gs-list-bigImg'));
            echo CHtml::link($img, array('/goods/view', 'id' => $g->id),array('target'=>'_blank'));
            ?>
            <div class="goods-list-info">
                <p class="gs-price"><?php echo HtmlHelper::formatPrice($g['price']) ?></p>
                <p class="gs-details" style="overflow: hidden;text-overflow:ellipsis;height: 1.5em"><?php echo CHtml::link(Tool::truncateUtf8String(CHtml::encode($g->name), 16, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)),array('target'=>'_blank','title'=>CHtml::encode($g->name))); ?> </p>
                    <?php echo CHtml::link(Tool::truncateUtf8String($g['store_name'], 8, '...').'&nbsp;&gt;',$this->createAbsoluteUrl('shop/'.$g['store_id']),array('title'=>$g['store_name']))?> 
            </div>
            <div class="goods-list-border"></div>
            <?php if(isset($g['seckill_category_id'])): ?>
                <?php
                //活动类型
                    if($g['seckill_category_id']==SeckillCategory::SECKILL_CATEGORY_ONE){
                        $sid = 1;
                    }else if($g['seckill_category_id']==SeckillCategory::SECKILL_CATEGORY_THREE){
                        $sid = 3;
                    }else{
                        $sid = 2;
                    }
                ?>
                <div class="gx-goodsico gx-goodsico<?php echo $sid ?>"></div>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <!-- 列表start -->
    <div class="pageList mb50 clearfix" >
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
    <?php if(empty($goods)): ?>
    <div class="goods-screening clearfix" style="padding:20px;">
        <span class="ico_nptips" style="float: left;" ><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" /></span>
        <div class="noProTxt" style="float: left;margin-left:20px;" >
            <h2><?php echo Yii::t('trade', '很抱歉，没找到与{a}相关的商品哦，要不您换个关键词我帮您再找找看。', array('{a}' => '<span style="color:red;">'.$this->getParam('q').'</span>')); ?></h2>
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
    //是否包邮
    $("input[name='freight_payment_type']").click(function(){
        if(this.checked){
            window.location.href = "<?php echo   $this->createAbsoluteUrl('search/search', array_merge($params, array('freight_payment_type' =>Goods::FREIGHT_TYPE_SELLER_BEAR ))) ?>";
        }else{
            window.location.href = "<?php $tmp = $params;unset($tmp['freight_payment_type']); echo  $this->createAbsoluteUrl('search/search', $tmp) ?>";
        }
    });
    //是否参加活动 seckill_seting_id
    $("input[name='seckill_seting_id']").click(function(){
        if(this.checked){
            window.location.href = "<?php echo   $this->createAbsoluteUrl('search/search', array_merge($params, array('seckill_seting_id' =>Goods::JOIN_ACTIVITY_YES ))) ?>";
        }else{
            window.location.href = "<?php $tmp = $params;unset($tmp['seckill_seting_id']); echo  $this->createAbsoluteUrl('search/search', $tmp) ?>";
        }
    });
</script>
<?php
//点击按照价格区间搜索
Yii::app()->clientScript->registerScript('integralSearch', "
        $(function() {
            $(\"#integralSearch\").click(function() {
                var min = $(this).parent().find(\".start_price\").val();
                var max = $(this).parent().find(\".end_price\").val();
                min = min == '' ? 0 : min;
                max = max == '' ? 0 : max;
                location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('min' => "'+min+'", 'max' => "'+max+'")))) . "');
            });
        });
    ",CClientScript::POS_END);
?>