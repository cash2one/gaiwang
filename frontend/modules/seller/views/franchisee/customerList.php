<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchisee', '盖网机列表')
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('sellerFranchisee','客服管理');?></b>
    <span><?php echo $model->name; ?> <?php echo Yii::t('sellerFranchisee','的客服管理。');?></span>
</div>
<a href="<?php echo Yii::app()->createUrl('seller/franchisee/customerCreate'); ?>" class="mt15 btnSellerAdd"><?php echo Yii::t('sellerFranchisee','添加客服');?></a>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th class="bgBlack" width="40%"><?php echo Yii::t('sellerFranchisee','客服名称');?></th>
            <th class="bgBlack" width="60%"><?php echo Yii::t('sellerFranchisee','操作');?></th>
        </tr>
        <?php foreach ($customer_data as $data): ?>
            <tr class="even">
                <td class="ta_c"><?php echo $data->username; ?></td>
                <td class="ta_c"><a href="<?php echo Yii::app()->createUrl('seller/franchisee/customerUpdate', array('id' => $data->id)); ?>" class="sellerBtn03"><span><?php echo Yii::t('sellerFranchisee','修改客服');?></span></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('seller/franchisee/customerDel', array('id' => $data->id)); ?>" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','删除');?></span></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="page_bottom clearfix">
    <div class="pagination">
        <?php
        $this->widget('CLinkPager', array(//此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
            'header' => '',
            'prevPageLabel' => Yii::t('page','上一页'),
            'nextPageLabel' => Yii::t('page','下一页'),
            'pages' => $pager,
            'maxButtonCount' => 10, //分页数目
            'htmlOptions' => array(
                'class' => 'paging', //包含分页链接的div的class
            )
                )
        );
        ?>
    </div>
</div>