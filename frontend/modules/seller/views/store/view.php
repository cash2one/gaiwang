<?php
/** @var $this StoreController */
/** @var $model Store */
$title = Yii::t('sellerStore', '查看店铺');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerStore', '店铺管理') => array('view'),
    $title,
);
?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<div class="toolbar">
    <b><?php echo $title ?></b>
    <span><?php echo Yii::t('sellerStore', '查看店铺基本信息资料。'); ?></span>
</div>
<?php echo CHtml::link(Yii::t('sellerStore', '编辑店铺资料'), $this->createAbsoluteUrl('/seller/store/update'), array('class' => 'mt15 btnSellerEditor')); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $model->getAttributeLabel('name') ?></th>
            <td>
                <?php if ($model->status == $model::STATUS_PASS): ?>
                    <?php echo CHtml::link($model->name, array('/shop/view', 'id' => $model->id), array('target' => '_blank')); ?>
                <?php else: ?>
                    <?php echo $model->name; ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $model->getAttributeLabel('thumbnail') ?>：
            </th>
            <td>
              <?php if(!empty($model->thumbnail)):?>
                <a href='<?php echo ATTR_DOMAIN . '/' . $model->thumbnail ?>' onclick='return _showBigPic(this)' target="_blank">
                    <img src="<?php echo ATTR_DOMAIN . '/' . $model->thumbnail ?>" width="60" height="60"/>
                </a>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $model->getAttributeLabel('logo') ?>：
            </th>
            <td>
               <?php if(!empty($model->logo)):?>
                <a href='<?php echo ATTR_DOMAIN . '/' . $model->logo ?>' onclick='return _showBigPic(this)' target="_blank">
                    <img src="<?php echo ATTR_DOMAIN . '/' . $model->logo ?>" width="60" height="60"/>
                </a>
               <?php endif;?> 
            </td>
        </tr>
        <tr>
            <th width="120px">
                <?php echo $model->getAttributeLabel('slogan') ?>：
            </th>
            <td>
               <?php if(!empty($model->slogan)):?>
                 <a href='<?php echo ATTR_DOMAIN . '/' . $model->slogan ?>' onclick='return _showBigPic(this)' target="_blank">
                    <img src="<?php echo ATTR_DOMAIN . '/' . $model->slogan ?>" width="60" height="60"/>
                 </a>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('referrals_id') ?></th>
            <td><?php echo $model->referrals_id ? $model->referrals->gai_number : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerStore', '所在地区'); ?></th>
            <td><?php echo Region::getName($model->province_id, $model->city_id, $model->district_id) ?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('street') ?></th>
            <td><?php echo CHtml::encode($model->street) ?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('mobile') ?></th>
            <td><?php echo $model->mobile ?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('order_reminder') ?></th>
            <td><b class="red"><?php echo $model->order_reminder ?> <?php echo Yii::t('sellerStore', '小时'); ?></b></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('email') ?></th>
            <td><?php echo $model->email ?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('keywords') ?></th>
            <td><?php echo CHtml::encode($model->keywords) ?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('description') ?></th>
            <td>
                <?php echo CHtml::encode($model->description) ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('status') ?></th>
            <td>
                <?php echo $model::status($model->status); ?>
            </td>
        </tr>
    </tbody>
</table>
<script>
    //成功样式的dialog弹窗提示
    var contentStr ='<div style="line-height:1.8;font-size:15px">';
    contentStr += '<p style="text-align:center;"><b>盖象运营公告</b></p>';
    contentStr += '<p>尊敬的商家们：</p>';
    contentStr += '<p>为保护各商户的权益，近期商城将对合作商户的签约情况进行核排查，排查对象为合同签约</p>';
    contentStr += '<p>有效期截止至2016年10月31日的商户。对于合同已过期且表示不续签或无法取得联系的</p>';
    contentStr += '<p>店铺，商城方面将逐步作出关店处理。如有意向续签的商户，请在<span style="font-weight:bolder;font-size:16px;color:red">2016年10月31</span>日前致</p>';
    contentStr += '<p>电<span style="font-weight:bolder;font-size:16px;color:red">020 29106888-8151</span>或联系<span style="font-weight:bolder;font-size:16px;color:red">QQ：800152048</span>商定续签事宜，谢谢配合！</p>';
    contentStr += '</div>';
    art.dialog({
        icon: '提示',
        content: contentStr,
        ok: true,
        okVal:'<?php echo Yii::t('member','确定') ?>',
        title:'<?php echo Yii::t('member','消息') ?>'
    });     
    </script>