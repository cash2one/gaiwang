<div class="main">
    <script>
        $(function() {
            $('#allProvince').click(function() {
                if ($('.allProvince').css('display') == 'none') {
                    $('.allProvince').css('display', 'block');
                } else {
                    $('.allProvince').css('display', 'none');
                }
            })

            $('#iconClose').click(function() {
                $('.allProvince').hide();
            })
            /*店铺动态*/
            $(".storeTrends").each(function() {
                $(this).hover(function() {
                    $(this).find('.evaluate').show();
                }, function() {
                    $(this).find('.evaluate').hide();
                })
            });
        });
    </script>
    <div class="wrapSearchStore">
        <div class="searchReslut">
            <div class="reslutCount">为您找到相关店铺 <?php echo $storeCount ?> 家</div>
        </div>
        <div class="rangeItem clearfix">
            <?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion1(), 'abg'); ?>
            <?php echo HtmlHelper::generateSortUrl('sales', $this->route, $params, $this->_uriParamsCriterion1(), '', array('class' => 'range')); ?>
            <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion1(), '', array('class' => 'range')); ?>
            <div class="iconAddress">
                <a href="javascript:;" id="allProvince"><i></i>
                    <span>
                        <?php echo $reg = $params['p'] == 0 ? '所在地' : Region::getName($params['p']); ?>
                    </span> 
                </a>
                <div class="allProvince" style="display:none;">
                    <div class="iconTriag"></div>
                    <div class="iconClose" id="iconClose"></div>
                    <div class="provinceTit">
                        <a href="<?php echo $this->createAbsoluteUrl('/search/view', array_merge($params, array('p' => 0))); ?>" title="所有省份">所有省份</a>   
                    </div>
                    <ul class="clearfix">
                        <?php foreach ($region as $val): ?>
                            <li>
                                <a href="<?php echo $this->createAbsoluteUrl('/search/view', array_merge($params, array('p' => $val['id']))); ?>" title="<?php echo $val['short_name'] ?>"><?php echo $val['short_name'] ?></a>   
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if (!empty($store)): ?>
            <?php foreach ($store as $value): ?>
                <div class="storeList">
                    <dl class="clearfix">
                        <dt class="storeInfo">
                        <div class="aboutStore clearfix">
                            <?php $img = $value['thumbnail'] ? Tool::showImg(ATTR_DOMAIN . '/' . $value['thumbnail'], 'c_fill,w_100,h_100') : DOMAIN.'/images/temp/no-store.jpg'; ?>
                            <?php echo CHtml::link(CHtml::image($img), $this->createAbsoluteUrl('/shop/view', array('id' => $value['id'])), array('title' => $value['name'], 'class' => 'logoStore')) ?>
                            <div class="company">
                                <?php echo CHtml::link($value['name'], $this->createAbsoluteUrl('/shop/view', array('id' => $value['id'])), array('title' => $value['name'], 'class' => 'companyNam')) ?>
                                <p class="point p_d<?php echo Store::getCompositeScore($value['description_match'], $value['serivice_attitude'], $value['speed_of_delivery'], $value['comments']) * 10; ?>"></p>
                                <p class="storeAddress">地址： <?php echo $value['street'] ?></p>
                            </div>
                        </div>
                        <div class="aboutSell clearfix">
                            <div class="storeTrends">
                                <div class="evaluate">
                                    <dl>
                                        <dt>店铺动态评分</dt>
                                        <dd class="clearfix"><span class="describe">描述相符:</span><span class="score"><?php echo $value['description_match'] ?></span></dd>
                                        <dd class="clearfix"><span class="describe">服务态度:</span><span class="score"><?php echo $value['serivice_attitude'] ?></span></dd>
                                        <dd class="bordernone clearfix"><span class="describe">发货速度:</span><span class="score"><?php echo $value['speed_of_delivery'] ?></span></dd>
                                    </dl>
                                </div>
                            </div>
                            <span class="prodTotal">共有 <?php echo count($value['goods']) ?> 件商品</span>
                            <span class="sellTotal">销量：<?php echo $value['sales'] ?></span>
                        </div>
                        </dt>
                        <dd>
                            <?php if(!$value['goods'] == NULL):?>
                            <ul class="clearfix">
                                <?php foreach ($value['goods'] as $key => $goods): ?>
                                    <?php if ($key > 4) continue; ?>
                                    <li>
                                        <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $goods['id'])) ?>" title="<?php echo $goods['name'] ?>">
                                            <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $goods['thumbnail'], 'c_fill,h_130,w_130'), '', array('width' => '130', 'height' => '130')) ?>
                                            <p class="integ">换购积分：<?php echo HtmlHelper::priceConvertIntegral($goods['price']); ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php else:?>
                            <ul class="clearfix" style="line-height:156px;color:red;margin-left:15px;font-size:16px;">该店铺商品还未上架</ul>
                            <?php endif;?>
                        </dd>
                    </dl>
                </div>
            <?php endforeach; ?>
            <div class="pageList clearfix">
                <ul class="yiiPageer">
                    <?php
                    echo $pager;
                    ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="noProTips clearfix">
                <span class="ico_nptips"><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="<?php echo Yii::t('search', '图标') ?>"></span>
                <div class="noProTxt">
                    <h2><?php echo Yii::t('trade', '很抱歉，没找到与{a}相关的商铺哦，要不您换个关键词我帮您再找找看。', array('{a}' => isset($_GET['q']) ? $_GET['q'] : "")); ?></h2>
                    <h3><?php echo Yii::t('search', '建议您'); ?>：</h3>
                    <p><?php echo Yii::t('search', '1.看看输入的文字是否有误。'); ?></p>
                    <p><?php echo Yii::t('search', '2.重新搜索。'); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>