<?php
$title = Yii::t('gameStore', '游戏店铺');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('gameStoreMember', '游戏店铺用户管理') => array('index'),
    $title,
);
?>
<div class="main clearfix">
    <div class="workground">
        <div class="toolbar">
            <b><?php echo Yii::t('gameStoreMember', '用户列表') ?></b>
            <span><?php echo Yii::t('gameStoreMember', '游戏用户页面列表展示。') ?></span>
        </div>

        <?php
        $this->renderPartial('_search', array(
            'model' => $model,
        ));
        ?>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
            <tbody>
            <tr>
                <th class="bgBlack" width="10%"><?php echo Yii::t('gameStoreMember', '用户姓名') ?></th>
                <th class="bgBlack" width="10%"><?php echo Yii::t('gameStoreItems', '手机号') ?></th>
                <th class="bgBlack" width="30%"><?php echo Yii::t('gameStoreItems', '用户地址') ?></th>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '商品信息') ?></th>
                <th class="bgBlack" width="10%"><?php echo Yii::t('gameStoreItems', '发货状态') ?></th>
                <th class="bgBlack" width="20%"><?php echo Yii::t('gameStoreItems', '操作') ?></th>
            </tr>
            <?php foreach ($items as $v): ?>
                <tr class="even">
                    <td class="ta_c"><?php echo $v['real_name'] ?></td>
                    <td class="ta_c"><?php echo $v['mobile'] ?></td>
                    <td class="ta_c"><?php echo $v['member_address'] ?></td>
                    <td class="ta_c"><?php echo $v['items_info'] ?></td>
                    <td class="ta_c">
                        <?php
                        echo GameStoreMember::status($v['status']);
                        if($v['status'] == GameStoreMember::STATUS_DELIVERY && !empty($v->delivery_time)){
                            echo '<br>';
                            echo date('Y-m-d H:i:s',$v->delivery_time);
                        }
                        ?>
                    </td>
                    <td class="ta_c">
                        <?php //echo CHtml::link('<span>' . Yii::t('gameStoreMember', '编辑') . '</span>', $this->createAbsoluteUrl('/seller/gameStoreMember/update', array('id' => $v->id)), array('class' => 'sellerBtn03')) ?>
                        &nbsp;&nbsp;
                        <?php //echo CHtml::link('<span>' . Yii::t('gameStoreMember', '删除') . '</span>', $this->createAbsoluteUrl('/seller/gameStoreMember/delete', array('id' => $v->id)), array('class' => 'sellerBtn01')) ?>
                        &nbsp;&nbsp;
                        <?php
                        if($v['status'] == GameStoreMember::STATUS_NOT_DELIVERY) {
                            echo CHtml::link('<span>' . Yii::t('gameStoreMember', '发货') . '</span>', $this->createAbsoluteUrl('/seller/gameStoreDelivery/create', array('id' => $v->id)), array('class' => 'sellerBtn03'));
                        }
                        ?>
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
        $('.breadcrumbs').before('<a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/seller/gameStore/view/')?>">返回列表</a>');
    });
</script>
