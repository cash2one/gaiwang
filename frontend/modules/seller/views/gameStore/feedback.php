<?php
$title = Yii::t('gameStore', '游戏反馈');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('gameStoreItems', '游戏店铺') => array('view'),
    $title,
);
?>
<div class="main clearfix">
    <div class="workground">
        <div class="toolbar">
            <b><?php echo Yii::t('gameStoreItems', '游戏反馈列表') ?></b>
            <span><?php echo Yii::t('gameStoreItems', '游戏反馈列表页面展示。') ?></span>
        </div>

        <?php
        $this->renderPartial('_search',array('contact'=>$contact));
        ?>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
            <tbody>
            <tr>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '用户姓名') ?></th>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '联系方式') ?></th>
                <th class="bgBlack" width="60%"><?php echo Yii::t('gameStoreItems', '游戏反馈') ?></th>
            </tr>
            <?php foreach ($data as $v): ?>
                <tr class="even">
                    <td class="ta_c"><?php echo $v['name'] ?></td>
                    <td class="ta_c"><?php echo $v['contact'] ?></td>
                    <td class="ta_c"><?php echo $v['content']; ?></td>
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
