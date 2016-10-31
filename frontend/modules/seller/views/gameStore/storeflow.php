<?php
$title = Yii::t('gameStore', '店铺流水列表');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('gameStoreItems', '游戏店铺') => array('view'),
    $title,
);
?>
<div class="main clearfix">
    <div class="workground">
        <div class="toolbar">
            <b><?php echo Yii::t('gameStoreItems', '店铺流水列表') ?></b>
<!--            <span>--><?php //echo Yii::t('gameStoreItems', '游戏反馈列表页面展示。') ?><!--</span>-->
        </div>

        <?php
        $this->renderPartial('_searchflow',array(
            'time'=>$time,
            'todayFlow' => $todayFlow,
            'monthFlow' => $monthFlow,
            'searchTime' => $searchTime,
        ));
        ?>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
            <tbody>
            <tr>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '用户GW号') ?></th>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '消费时间') ?></th>
                <th class="bgBlack" width="60%"><?php echo Yii::t('gameStoreItems', '消费金币') ?></th>
            </tr>
            <?php foreach ($data as $v): ?>
                <tr class="even">
                    <td class="ta_c"><?php echo $v['gai_number'] ?></td>
                    <td class="ta_c"><?php echo date('Y-m-d H:i:s',$v['create_time']);?></td>
                    <td class="ta_c"><?php echo $v['expenditure']; ?></td>
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
