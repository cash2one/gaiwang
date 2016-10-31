<?php
// 列表页面，左侧分类，最近浏览，热销
/* @var $this Controller */
?>
<div class="sliderWrap left">
    <?php
    $requestId = $id;
    $ci = Category::categoryIndexing();
    if (!$ci = $this->cache(Category::CACHEDIR)->get(Category::CK_CATEGORYINDEX))
        $ci = Category::categoryIndexing();
    if (isset($ci[$id]) && $ci[$id]['type'] != 1) {
        $category = $ci[$id];
        $id = $category['type'] == 2 ? $ci[$category['parentId']]['id'] : $category['grandpaId'];//by 2014/2/22 binbin.liao修改
    }
    if (!$treeCategory = $this->cache(Category::CACHEDIR)->get(Category::CK_TREECATEGORY))
        $treeCategory = Category::treeCategory();
    $leftCategorys = array();
    if (isset($treeCategory[$id]))
        $leftCategorys = $treeCategory[$id];
    ?>
    <?php if (!empty($leftCategorys)): ?>
        <div class="sliderBox">
            <div class="notbg">
                <i class="ico_cog"></i>
                <h1><?php echo Yii::t('site', '商品分类'); ?></h1>
                <b>classification of goods</b>
            </div>
            <div class="items">
                <?php if (isset($leftCategorys['childClass'])): foreach ($leftCategorys['childClass'] as $tk => $tv): ?>
                        <dl>
                            <dt><?php echo CHtml::link(Yii::t('category',$tv['name']), '', array('class' => 'on', 'onclick' => "showHide(this, 'items" . $tk . "')", 'encode' => false)); ?></dt>
                            <?php echo CHtml::tag('dd', array('class' => 'clearfix', 'id' => 'items' . $tk, 'style' => 'display: block;'), false, false); ?>
                            <?php if (!empty($tv['childClass'])): ?>
                                <?php
                                $subitems = array_values($tv['childClass']);
                                $c = count($subitems);
                                ?>
                                <?php for ($i = 0; $i < ceil($c / 2); $i++): ?>

                                    <?php
                                    $k1 = $i == 0 ? $i : $i * 2;
                                    $k2 = $k1 + 1;
                                    ?>
                                    <?php echo CHtml::link(Yii::t('category',$subitems[$k1]['name']), $this->createAbsoluteUrl('/category/view', array('id' => $subitems[$k1]['id'])), array('title' => Yii::t('category',$subitems[$k1]['name']), 'class' => $subitems[$k1]['id'] == $requestId ? 'curr' : '')); ?>
                                    <?php
                                    if (isset($subitems[$k2]))
                                        echo CHtml::link(Yii::t('category',$subitems[$k2]['name']), $this->createAbsoluteUrl('/category/view', array('id' => $subitems[$k2]['id'])), array('title' => Yii::t('category',$subitems[$k1]['name']), 'class' => $subitems[$k2]['id'] == $requestId ? 'curr' : ''));
                                    ?>
                                <?php endfor; ?>
                            <?php endif; ?>
                            <?php echo CHtml::closeTag('dd'); ?>
                        </dl>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    // 火热销量
    $category = Category::findChildCategoryElement($requestId);
    $ids = $this->_formatCategory($category);
    $this->widget('application.components.CommonWidget', array(
        'view' => 'categoryhots',
        'modelClass' => 'Goods',
        'criteriaOptions' => array(
            'select' => 'id, name, thumbnail, price',
            'condition' => 'status = :status And is_publish = :push and life=:life And category_id in (:ids)',
            'order' => 'sales_volume DESC',
            'limit' => 5,
            'params' => array(
                ':status' => Goods::STATUS_PASS,
                ':push' => Goods::PUBLISH_YES,
                ':ids' => addslashes(implode(',', $ids)),
                ':life'=>Goods::LIFE_NO
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