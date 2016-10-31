<?php
$title = Yii::t('gameStore', '查看评价');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('gameStoreItems', '游戏店铺') => array('view'),
    $title,
);
?>
<div class="main clearfix">
    <div class="workground">
        <div class="toolbar">
            <b><?php echo Yii::t('gameOrderDetail', '查看评价列表') ?></b>
        </div>

        <?php
        $this->renderPartial('_commentsearch',array('model'=>$model));
        ?>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
            <tbody>
            <tr>
                <th class="bgBlack" width="15%"><?php echo Yii::t('gameOrderDetail', '用户姓名') ?></th>
                <th class="bgBlack" width="15%"><?php echo Yii::t('gameOrderDetail', '联系方式') ?></th>
                <th class="bgBlack" width="30%"><?php echo Yii::t('gameOrderDetail', '所属店铺') ?></th>
                <th class="bgBlack" width="30%"><?php echo Yii::t('gameOrderDetail', '评价内容') ?></th>
            </tr>
            <?php foreach ($comment as $v): ?>
                <tr class="even">
                    <td class="ta_c"><?php echo $v->real_name; ?></td>
                    <td class="ta_c"><?php echo $v->mobile; ?></td>
                    <td class="ta_c"><?php echo $v->store_name; ?></td>
                    <td class="ta_c"><?php echo $v->comment; ?></td>
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
<script type="text/javascript">
    $(function(){
        $('.breadcrumbs').before('<a class="regm-sub" href="javascript:history.back()">返回列表</a>');
    });
</script>
