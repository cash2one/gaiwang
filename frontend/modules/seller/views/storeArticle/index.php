<?php
    $title = Yii::t('storeArticle', '店铺文章');
    $this->pageTitle = $title . '-' . $this->pageTitle;
    $this->breadcrumbs = array(
        Yii::t('sellerStore', '店铺管理') => array('index'),
        $title,
    );
?>
<div class="main clearfix">
    <div class="workground">
        <!--<div class="workground_wrap">-->
        <!--            <div class="position">当前位置：<a href="#">文章列表</a> &gt; <b>文章列表</b></div>-->
        <!--<div class="mainContent">-->
        <div class="toolbar">
            <b><?php echo Yii::t('storeArticle', '文章列表') ?></b>
            <span><?php echo Yii::t('storeArticle', '店铺文章页面的列表展示。') ?></span>
        </div>

        <?php
        $this->renderPartial('_search', array(
            'model' => $model,
        ));
        ?>
        <a href="/storeArticle/create" class="mt15 btnSellerAdd"><?php echo Yii::t('storeArticle', '添加文章') ?></a>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
            <tbody>
                <tr>
                    <th class="bgBlack" width="40%"><?php echo Yii::t('storeArticle', '文章标题') ?></th>
                    <th class="bgBlack" width="20%"><?php echo Yii::t('storeArticle', '创建时间') ?></th>
                    <th class="bgBlack" width="10%"><?php echo Yii::t('storeArticle', '发布状态') ?></th>
                    <th class="bgBlack" width="10%"><?php echo Yii::t('storeArticle', '审核状态') ?></th>
                    <th class="bgBlack" width="20%"><?php echo Yii::t('storeArticle', '操作') ?></th>
                </tr>
                <?php foreach ($articleInfo as $v): ?>
                    <tr class="even">
                        <td class="ta_c"><?php echo $v['title'] ?></td>
                        <td class="ta_c"><?php echo date('Y-m-d H:i:s', $v['create_time']) ?></td>
                        <td class="ta_c"><?php echo StoreArticle::gender($v['is_publish']); ?></td>
                        <td class="ta_c"><?php echo StoreArticle::status($v['status']); ?></td>
                        <td class="ta_c">
                            <!--<a href="#" class="sellerBtn03"><span>编辑</span></a>-->
                            <?php echo CHtml::link('<span>' . Yii::t('storeArticle', '编辑') . '</span>', $this->createAbsoluteUrl('/seller/storeArticle/update', array('id' => $v->id)), array('class' => 'sellerBtn03')) ?>
                            &nbsp;&nbsp;
                            <!--<a href="#" class="sellerBtn01"><span>删除</span></a></td>-->
                            <?php echo CHtml::link('<span>' . Yii::t('storeArticle', '删除') . '</span>', $this->createAbsoluteUrl('/seller/storeArticle/delete', array('id' => $v->id)), array('class' => 'sellerBtn01')) ?>
                    </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="page_bottom clearfix">
            <div class="pagination">
                <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'cssFile' => false,
                    'firstPageLabel' => Yii::t('page', '首页'),
                    'lastPageLabel' => Yii::t('page', '末页'),
                    'prevPageLabel' => Yii::t('page', '上一页'),
                    'nextPageLabel' => Yii::t('page', '下一页'),
                    'pages' => $pages,
                    'maxButtonCount' => 13
                        )
                );
                ?>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!--</div>-->
</div>