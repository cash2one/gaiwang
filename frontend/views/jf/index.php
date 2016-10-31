<div class="main clearfix">
    <div class="sliderWrap left">
        <?php if ($cid == 0): ?>
            <div class="sliderBox">
                <div class="items addbg">
                    <?php $i = 1; ?>
                    <?php foreach ($category as $c): ?>
                        <span><?php echo CHtml::link('<i class="ico_good' . (($i > 9) ? $i : '0' . $i) . '"></i>' . Yii::t('jf',$c['name']), $this->createAbsoluteUrl('/jf/list', array('cid' => $c['id']))); ?></span>  
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <?php if (!empty($category)): ?>
                <div class="sliderBox">
                    <div class="notbg">
                        <i class="ico_cog"></i>
                        <h1><?php echo Yii::t('jf',$category['name']); ?></h1>
                        <b>classification of goods</b>
                    </div>
                    <div class="items">
                        <?php if (!empty($category['childClass'])): $i = 0; ?>
                            <?php foreach ($category['childClass'] as $value): ?>
                                <dl>
                                    <dt><a onclick="showHide(this, 'items<?php echo $i; ?>');" class="on"><?php echo Yii::t('jf',$value['name']); ?></a></dt>
                                    <dd id="items<?php echo $i; ?>" style="display: block;" class="clearfix">
                                        <?php if (isset($value['childClass'])): ?>
                                            <?php foreach ($value['childClass'] as $child): ?>
                                                <?php echo CHtml::link(Yii::t('jf',$child['name']), $this->createAbsoluteUrl('/jf/list', array('cid' => $child['id'])), array('class' => $cid == $child['id'] ? 'curr' : '')); ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </dd>
                                </dl>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php
        $this->widget('application.components.CommonWidget', array(
            'view' => 'integralleft',
            'data' => $hotRecom,
            'htmlOptions' => array(
                'id' => 'hotRecom01',
                'title' => Yii::t('jf', '热门推荐')
            )
        ));
        ?>
        <?php
        $this->widget('application.components.CommonWidget', array(
            'view' => 'integralleft',
            'data' => $sells,
            'htmlOptions' => array(
                'id' => 'hotRecom02',
                'title' => Yii::t('jf', '最近出售')
            )
        ));
        ?>
    </div>
    <div class="mainWrap right">	
        <?php $slides = Advert::getConventionalAdCache('jf-index-slide');  //积分兑换首页幻灯片广告?>
        <?php if (!empty($slides)): ?>
            <div class="adverSlider" id="adverSlider" >
                <ul>
                    <?php foreach ($slides as $ad): ?>
                        <?php if (!AdvertPicture::isValid($ad['start_time'], $ad['end_time'])): ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo $ad['link']; ?>" title="<?php echo $ad['title']; ?>" target="<?php echo $ad['target']; ?>">
                                <img width="980" height="300" alt="<?php echo $ad['title']; ?>" src="<?php echo ATTR_DOMAIN . '/' . $ad['picture']; ?>" />
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="num">
                    <?php $i = 0; ?>
                    <?php foreach ($slides as $adk => $adv): ?>
                        <?php if (!AdvertPicture::isValid($adv['start_time'], $adv['end_time'])): ?>
                            <?php continue; ?>
                        <?php endif ?>
                        <?php $i++; ?>
                        <?php echo CHtml::tag('i', array(), $i); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(e) {
                    $('#adverSlider li').imgChange({thumbObj: '#adverSlider .num i', curClass: 'curr', effect: 'fade', speed: 1000, changeTime: 4000})
                    $('#hotRecom01 ul li').imgChange({thumbObj: '#hotRecom01 .thumb', botPrev: '#hotRecom01 .prev', botNext: "#hotRecom01 .next", curClass: 'curr', effect: 'fade', speed: 500, changeTime: 4000})
                    $('#hotRecom02 ul li').imgChange({thumbObj: '#hotRecom02 .thumb', botPrev: '#hotRecom02 .prev', botNext: "#hotRecom02 .next", curClass: 'curr', effect: 'fade', speed: 500, changeTime: 4000})
                });
            </script>
        <?php endif; ?>
        <div class="rangeItem clearfix">
            <?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion(), 'abg'); ?>
            <?php echo HtmlHelper::generateSortUrl('sales_volume', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'pricerange')); ?>
            <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <p>
                <?php echo Yii::t('jf','积分');?>：<input type="text" class="input_txt" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" /> —
                <input type="text" class="input_txt" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" />
                <input type="button" class="input_btn"  value="<?php echo Yii::t('jf','搜索');?>" name="btn1" id="integralSearch" />
            </p>
            <!--<span><a href="#" title="图片" class="picshow"><i></i>图片</a><a href="#" title="列表" class="listshow"><i></i>列表</a></span>-->
        </div>
        <?php if ($goods): ?>
            <div class="productList clearfix">
                <ul>
                    <?php foreach ($goods as $g): ?>
                        <li>
                            <div class="libox">
                                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_170,w_170'), $g->name, array('width' => 170, 'height' => 170)), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)), array('class' => 'imgbox img_m', 'title' => $g->name)); ?>
                                <p class="price"><?php echo HtmlHelper::formatPrice($g->price); ?></p>
                                <p class="name"><?php echo CHtml::link(Tool::truncateUtf8String($g->name, 26, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id))); ?></p>
                                <p><?php echo  Yii::t('jf', '销量：{a}件', array('{a}' => $g->sales_volume)); ?></p>
                                <p class="integral"><?php echo Yii::t('jf','换购积分');?>:<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($g['price']); ?></span></p>
                            </div>
                            <?php echo CHtml::link(Yii::t('jf','加入购物车'), "javascript:addCart({$g['id']},{$g['goods_spec_id']});", array('title' => Yii::t('jf','加入购物车'), 'class' => 'add_cart Carfly')); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="pageList">
                <?php
                $this->widget('CLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('jf','首页'),
                    'lastPageLabel' => Yii::t('jf','末页'),
                    'prevPageLabel' => Yii::t('jf','上一页'),
                    'nextPageLabel' => Yii::t('jf','下一页'),
                    'pages' => $pager,
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer'
                    )
                        )
                );
                ?> 
            </div>
        <?php else: ?>
            <div class="noProTips clearfix">
                <span class="ico_nptips"><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="Yii::t('jf','图标')"></span>
                <div class="noProTxt">
                    <h2><?php echo Yii::t('jf','很抱歉，没找到相关分类的商品哦，要不您换个分类我帮您再找找看。');?></h2>
                    <h3><?php echo Yii::t('jf','建议您');?>：</h3>
                    <p><?php echo Yii::t('jf','1.看看输入的文字是否有误。');?></p>
                    <p><?php echo Yii::t('jf','2.重新搜索。');?></p>
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