<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
if ($model->symbol == 'HKD'){
	$spend_money = "HK$".Tool::currency($model->spend_money);
	$distribute_money = "HK$".Tool::currency($model->distribute_money);
}else{
	$spend_money = "￥".$model->spend_money;
	$distribute_money = "￥".$model->distribute_money;
}
?>
<table  width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th scope="row" style="width:150px">
                    <?php echo Yii::t('sellerFranchisee','盖机名称：');?>
                </th>
                <td><?php echo !empty($m_info->name)?$m_info->name:'';?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                   <?php echo Yii::t('sellerFranchisee','线下商家名称：');?> 
                </th>
                <td><?php echo !empty($f_info->name)?$f_info->name:'';?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                   <?php echo Yii::t('sellerFranchisee','会员编号：');?> 
                </th>
                <td><?php echo !empty($model->member)?$model->member->gai_number:'';?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','记录类型：');?>
                </th>
                <td><?php echo FranchiseeConsumptionRecord::getRecordType($model->record_type);?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','对账状态：');?>
                </th>
                <td><?php echo FranchiseeConsumptionRecord::getCheckStatus($model->status);?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','消费金额：');?>
                </th>
                <td><?php echo $spend_money?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                   <?php echo Yii::t('sellerFranchisee','盖网折扣：');?>
                </th>
                <td><?php echo $model->gai_discount?>%
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','会员折扣：');?>
                </th>
                <td><?php echo $model->member_discount?>%
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','分配金额：');?>
                </th>
                <td><?php echo $distribute_money?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','创建时间：');?>
                </th>
                <td><?php echo date('Y-m-d G:i:s',$model->create_time)?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','备注说明：');?>
                </th>
                <td><?php echo AccountFlow::formatContent($model->remark)?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo Yii::t('sellerFranchisee','客服名称：');?>
                </th>
                <td>
                </td>
            </tr>
        </tbody>
    </table>