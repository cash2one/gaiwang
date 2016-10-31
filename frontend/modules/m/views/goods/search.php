<div class="main">
    <div class="container">
        <div class="gxNavTab">
            <div class="navTab clearfix">
                <div class="tabPages fl clearfix">
                    <?php
                    $product = $this->getParam('p');
                    $order = $this->getParam('order') ? $this->getParam('order') : '0';
                    $tid = $this->getParam('tid') ? $this->getParam('tid') : '0';
                    if (!empty($model)):?>
                        <?php
                        $page = '';
                        $page = $this->getParam('page');
                        $pageCount = $pages->getPageCount();
                        if ($page <= 1):
                            $page = 1;
                            ?>
                            <a href="#" class="page disabled">上一页</a>
                        <?php else: ?>
                            <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => $order, 'tid' => $tid, 'page' => ($page - 1))); ?>"
                               class="page">上一页</a>
                        <?php endif; ?>
                        <?php if ($page >= ($pageCount)): ?>
                            <a href="" class="page disabled">下一页</a>
                        <?php else: ?>
                            <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => $order, 'tid' => $tid, 'page' => ($page + 1))); ?>"
                               class="page">下一页</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="" class="page disabled">上一页</a>
                        <a href="" class="page disabled">下一页</a>
                    <?php endif; ?>
                </div>
                <div class="tabFilter fr clearfix">
                    <a class="icoModel iM01 <?php if ($tid == 1): ?> selected <?php endif; ?>" id="showProImg"
                       href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => $order, 'tid' => 1)); ?>"></a>
                    <a class="icoModel iM02 <?php if (empty($tid)): ?> selected <?php endif; ?>" id="showProList"
                       href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => $order, 'tid' => 0)); ?>"></a>
                    <a class="icoCon" href="#"><i class="icoTriangle"></i></a>
                </div>
            </div>
            <?php $order = $this->getParam('order'); ?>
            <div class="filter clearfix" id="filter">
                <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => 0, 'tid' => $tid)); ?>" <?php if (empty($order)): ?> class="item selected" <?php else: ?> class="item" <?php endif; ?>>综合</a>
                <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => 1, 'tid' => $tid)); ?>" <?php if ($order == 1): ?> class="item selected" <?php else: ?> class="item" <?php endif; ?>>销量</a>
                <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => 3, 'tid' => $tid)); ?>" <?php if ($order == 3): ?> class="item selected" <?php else: ?>
                   class="item" <?php endif; ?>class="item">价格</a>
                <a href="<?php echo $this->createAbsoluteUrl('goods/search', array('p' => $product, 'order' => 4, 'tid' => $tid)); ?>" <?php if ($order == 4): ?> class="item selected" <?php else: ?>
                   class="item" <?php endif; ?>class="item">评价</a>
            </div>
        </div>

        <div class="column">
            <div class="columnContent nobg">
                <ul class="products04 clearfix <?php if ($tid == 1): ?> proImg <?php endif; ?>" id="goodlist">
                    <?php if (!empty($model)): ?>
                        <?php foreach ($model as $value): ?>
                            <li>
                                <a class="item"
                                   href="<?php echo $this->createUrl('goods/index', array('id' => $value->id)); ?>">
                                    <div class="fl pImg">
                                        <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $value->thumbnail, 'c_fill,h_150,w_150'), $value->name) ?>
                                    </div>
                                    <div class="fr pCom">
                                        <p class="pTxt"><?php echo $value->name; ?></p>

                                        <p class="pPrice">
                                            <b class="red"><?php echo HtmlHelper::formatPrice($value->price); ?></b>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        很抱歉，没找到与<?php echo $product; ?>相关的商品哦，要不您换个关键词我帮您再找找看。
                    <?php endif; ?>
                </ul>
            </div>
            <?php

            $this->widget('WLinkPager', array(
                'pages' => $pages,
                'jump' => true,
                'prevPageLabel' => Yii::t('page', '上一页'),
                'nextPageLabel' => Yii::t('page', '下一页'),
            ))

            ?>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery.touchslider.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/template.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/com.js', CClientScript::POS_HEAD);
?>
