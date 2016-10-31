<?php
// 搜索列表
/* @var $this Controller */
?>
<div class="main clearfix">
    <div class="sliderWrap left">
        <?php
        // 火热销量
        $this->widget('application.components.CommonWidget', array(
            'view' => 'categoryhots',
            'modelClass' => 'Goods',
            'criteriaOptions' => array(
                'select' => 'id, name, thumbnail, price',
                'condition' => 'status = :status And is_publish = :push and life=:life and  UNIX_TIMESTAMP()-create_time < 604800',
                'order' => 'sales_volume DESC',
                'limit' => 5,
                'params' => array(
                    ':status' => Goods::STATUS_PASS,
                    ':push' => Goods::PUBLISH_YES,
                    ':life'=>Goods::LIFE_NO,
                )
            ),
        ));
        ?> 

        <?php
        // 历史浏览
        $this->widget('application.components.CommonWidget', array(
            'view' => 'historybrowse',
            'method' => 'getHistoryBrowse',
        ));
        ?> 
    </div>
    <div class="mainWrap right">
        <div class="filterMark clearfix">
            <span class="label">
                <?php echo Yii::t('search', '积分'); ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'tagName' => 'span',
                    'homeLink' => false,
                    'separator' => ' > ',
                    'links' => array_merge(array(Yii::t('search', '盖象商城') => 'javascript:;', Yii::t('search', '商品搜索') => 'javascript:;'), $this->breadcrumbs),
                    'htmlOptions' => array('class' => false),
                ));
                ?>

                <?php if ($this->getParam('bid') > 0 || $this->getParam('cid') > 0) : ?>
                    >
                <?php endif; ?>

            </span>
            <!--产品特征筛选条件展示位置-->
            <?php if ($this->getParam('bid') > 0) : ?>
                <div id="condition"><a class="inbtn pzbtn" rel="<?php echo Brand::getBrandsName($this->getParam('bid')); ?>" href="<?php echo Yii::app()->request->getUrl(); ?>&bid=0" ><span onclick="deleteC('<?php echo Brand::getBrandsName($this->getParam('bid')); ?>')"><?php echo Yii::t('category',Brand::getBrandsName($this->getParam('bid'))); ?></span></a></div>
            <?php endif; ?>

            <?php if ($this->getParam('cid') > 0) : ?>
                <div id="condition"><a class="inbtn pzbtn" rel="<?php echo Brand::getBrandsName($this->getParam('cid')); ?>"  href="<?php echo Yii::app()->request->getUrl(); ?>&cid=0" ><span onclick="deleteC('<?php echo Category::getCategoryName($this->getParam('cid')); ?>')"><?php echo Yii::t('category',Category::getCategoryName($this->getParam('cid'))); ?></span></a></div>
            <?php endif; ?>



            <span class="totalNum"><?php echo '<b class="red">“' . CHtml::encode($this->keyword) . '”</b> - ' . HtmlHelper::langsTextConvert('找到 {value} 件相关商品', $goodsCount) ?></span>
        </div>


        <!--产品特征筛选卡 begin-->
        <div id="filter" class="filterBox clearfix">

            <?php if (!$this->getParam('bid') > 0) : ?>

                <div class="filterItem clearfix">
                    <div class="filterTit"><?php echo Yii::t('search', '品牌'); ?>：</div>
                    <div class="filterCon">
                        <dl class="filterDl" id="filterDl">
                            <?php if (empty($brands)): ?>
                                <?php echo Yii::t('search', '没有相关品牌'); ?>!
                            <?php else: ?>
                                <?php foreach ($brands as $val): ?>
                                    <dd><a href="<?php echo $this->createAbsoluteUrl('/search/search', array_merge($params, array('bid' => $val['id']))); ?>"><?php echo Yii::t('category',$val['name']) ?><span class="gray">(<?php echo $val['total'].' '.Yii::t('site', '件') ?>)</span></a></dd>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </dl>
                    </div>
                    <div class="filterAdd">
                        <a onclick="document.getElementById('filterDl').style.height = 'auto';
                            document.getElementById('show').style.display = 'none';
                            document.getElementById('hide').style.display = 'block';" href="javascript:void(0)" id="show" class="show" style="display: block;"><?php echo Yii::t('search', '更多'); ?></a>
                        <a onclick="document.getElementById('filterDl').style.height = '25px';
                            document.getElementById('show').style.display = 'block';
                            document.getElementById('hide').style.display = 'none';" href="javascript:void(0)" id="hide" class="hide" style="display: none;"><?php echo Yii::t('search', '收起'); ?></a>
                    </div>
                </div>

            <?php endif; ?>

            <?php if (!$this->getParam('cid') > 0) : ?>
                <div class="filterItem clearfix">
                    <div class="filterTit"><?php echo Yii::t('search', '分类'); ?>：</div>
                    <div class="filterCon">
                        <dl class="filterDl" id="filterD2">
                            <?php if (empty($cates)): ?>
                                <?php echo Yii::t('search', '没有相关分类'); ?>!
                            <?php else: ?>
                                <?php foreach ($cates as $val): ?>
                                    <dd><a href="<?php echo $this->createAbsoluteUrl('/search/search', array_merge($params, array('cid' => $val['id']))); ?>"><?php echo Yii::t('category', $val['name']) ?></a><span class="gray">(<?php echo $val['total'].' '.Yii::t('site', '件') ?>)</span></a></dd>
                                <?php endforeach; ?>
                            <?php endif; ?>


                        </dl>
                    </div>
                    <div class="filterAdd">
                        <a onclick="document.getElementById('filterD2').style.height = 'auto';
                            document.getElementById('show2').style.display = 'none';
                            document.getElementById('hide2').style.display = 'block';" href="javascript:void(0)" id="show2" class="show" style="display: block;"><?php echo Yii::t('search', '更多'); ?></a>
                        <a onclick="document.getElementById('filterD2').style.height = '25px';
                            document.getElementById('show2').style.display = 'block';
                            document.getElementById('hide2').style.display = 'none';" href="javascript:void(0)" id="hide2" class="hide" style="display: none;"><?php echo Yii::t('search', '收起'); ?></a>
                    </div>
                </div>
            <?php endif; ?>

        </div><!--产品特征筛选卡 End-->

        <!--产品排序条件 -->
        <div class="rangeItem clearfix">
            <?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion(), 'abg'); ?>
            <?php echo HtmlHelper::generateSortUrl('sales_volume', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'pricerange')); ?>
            <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <p>
                <?php echo Yii::t('search', '积分'); ?>：<input type="text" class="input_txt" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" /> —
                <input type="text" class="input_txt" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" />
                <input type="button" class="input_btn"  value="<?php echo Yii::t('search', '搜索'); ?>" name="btn1" id="integralSearch" />
            </p>
        </div>
        <!--产品排序条件 End-->



        <?php if (!empty($goods)): ?>
            <!--产品列表栏begin-->	
            <div class="productList clearfix">
                <ul>
                    <?php foreach ($goods as $g): ?>
                        <li>
                            <div class="libox">
                                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_170,w_170'), CHtml::encode($g->name), array('width' => 170, 'height' => 170)), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)), array('class' => 'imgbox img_m','target'=>'_blank')); ?>
                                <p class="price"><?php echo HtmlHelper::formatPrice($g->price); ?></p>
                                <p class="name"><?php echo CHtml::link(Tool::truncateUtf8String(CHtml::encode($g->name), 26, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)),array('target'=>'_blank')); ?></p>



                                <p class="integral"><?php echo Yii::t('contact', '售价'); ?>:<span class="jf"><?php echo $g['price']; ?></span></p>
                            </div>
                            <?php echo CHtml::link(Yii::t('search', '加入购物车'), "javascript:addCart({$g['id']},{$g['goods_spec_id']});", array('title' => Yii::t('search', '加入购物车'), 'class' => 'add_cart Carfly')); ?>    
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!--产品列表栏End-->
            <div class="pageList clearfix">
                <ul class="yiiPageer">
                <?php
                    echo $pager;
                ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="noProTips clearfix">
                <span class="ico_nptips"><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="Yii::t('search','图标')"></span>
                <div class="noProTxt">
                    <h2><?php echo Yii::t('trade', '很抱歉，没找到与{a}相关的商品哦，要不您换个关键词我帮您再找找看。', array('{a}' => isset($_GET['q']) ? $_GET['q'] : "")); ?></h2>
                    <h3><?php echo Yii::t('search', '建议您'); ?>：</h3>
                    <p><?php echo Yii::t('search', '1.看看输入的文字是否有误。'); ?></p>
                    <p><?php echo Yii::t('search', '2.重新搜索。'); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('integralSearch', "
        $(function() {
            $(\"#integralSearch\").click(function() {
                var min = $(this).siblings(\"input:first\").val();
                var max = $(this).siblings(\"input:last\").val();
                min = min == '' ? 0 : min;
                max = max == '' ? 0 : max;
                location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('min' => "'+min+'", 'max' => "'+max+'")))) . "');
            });
        });
    ");
?>