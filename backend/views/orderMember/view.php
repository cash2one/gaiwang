<?php
$this->breadcrumbs = array(
	Yii::t('OrderMember', '订单用户管理'),
    Yii::t('OrderMember', '订单用户查看')
);
?>
<div class="com-box">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('OrderMember', '订单用户信息'); ?></td>
            </tr>
            <tr>
                <th width="150px" class="odd"><?php echo Yii::t('OrderMember', '订单号'); ?>：</th>
                <td class="odd"><?php echo $model->code; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('OrderMember', '用户GW号'); ?>：</th>
                <td class="even"><?php echo $model->member->gai_number; ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('OrderMember', '姓名'); ?>：</th>
                <td class="odd"><?php echo $model->real_name;?></td>
            </tr>
             <tr>
                <th class="even"><?php echo Yii::t('OrderMember', '性别'); ?>：</th>
                <td class="even"><?php echo OrderMember::getMemberSex($model->sex);?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('OrderMember', '身份证号'); ?>：</th>
                <td class="odd"><?php echo $model->identity_number; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('OrderMember', '身份证图片'); ?>：</th>
                <td class="even">
                  <?php echo CHtml::image(ATTR_DOMAIN . DS . $model->identity_front_img, '', array('width' => '100px', 'height' => '100px')); ?>
                  <?php echo CHtml::image(ATTR_DOMAIN . DS . $model->identity_back_img, '', array('width' => '100px', 'height' => '100px')); ?>
                </td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('OrderMember', '联系方式'); ?>：</th>
                <td class="odd"><?php echo $model->mobile; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('OrderMember', '联系地址'); ?>：</th>
                <td class="even"><?php echo $model->street; ?></td>
            </tr>  
            <tr>
                <th class="odd"><?php echo Yii::t('OrderMember', '创建时间'); ?>：</th>
                <td class="odd"><?php echo date('Y-m-d H:i:s', $model->create_time); ?></td>
            </tr>
        </tbody>
    </table>
</div>
