<?php
/** @var $this EnterpriseLogController */
$status = 1;
switch ($lastOne->progress) {
    case EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG:
        $status = 1;
        break;
    case EnterpriseLog::PROCESS_CHECK_INFO_FAWU:
        $status = 1;
        break;
    case EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG:
        $status = 2;
        break;
    case EnterpriseLog::PROCESS_CHECK_PAPER_FAWU:
        $status = 3;
        break;
    case EnterpriseLog::PROCESS_LAST_OK:
        $status = 4;
        break;
    default:
        $status = 4;
}
?>
        <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/member_v20.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/custom_v20.css" rel="stylesheet" type="text/css"/>
<style>
    .ta_l hr{
        border:1px dashed #ccc;
    }
</style>
<div class="main-contain">
<div class="withdraw-contents">
    <div class="crumbs crumbs-en">
              <span><?php echo Yii::t('memberEnterpriseLog', '您的位置：')?></span>
                  <a href="#"><?php echo Yii::t('memberEnterpriseLog', '企业管理')?></a>
                  <span>&gt</span>
                  <a href="#"><?php echo Yii::t('memberEnterpriseLog', '网络店铺签约')?></a>
            </div>
    <div class="mbRcontent sellerWebSign sellerWebSignIcon">
        <div class="toolbarSign">
            <?php if ($lastOne->progress < EnterpriseLog::PROCESS_LAST_OK): ?>
                <h3>
                    <?php echo Yii::t('enterpriseLog', '贵公司的在线入驻申请'); ?>
                    <span class="red"><?php echo Yii::t('enterpriseLog', '正在审核中……'); ?></span>，
                    <?php echo Yii::t('enterpriseLog', '请耐心等待。审核详情请查看以下审核进度。'); ?>
                </h3>

            <?php endif; ?>

            <div>

                <?php
                if ($lastOne->progress == EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG) {
                    echo CHtml::link('[打印合同]', array('enterpriseLog/print'), array('class' => 'red', 'target' => '_blank'));
                }
                ?>&nbsp;&nbsp;
                <?php
                if ($lastOne->progress < EnterpriseLog::PROCESS_LAST_OK) {
                    //echo CHtml::link('[修改]', array('enterpriseLog/enterprise'), array('class' => 'red'));
                } else {
                    echo '<h3>', Yii::t('memberEnterprise', '恭喜！所有资质已审核通过，您可在卖家平台创建商品或装修店铺等操作。'), '</h3>';
                }
                ?>
                <?php echo CHtml::link(Yii::t('enterpriseLog', '[您已上传的网络店铺签约资质]'), array('enterpriseLog/view'), array('class' => 'red', 'target' => '_blank')) ?>
                &nbsp;&nbsp;
            </div>
            <div>
               <?php echo Yii::t('memberEnterprise', ' 若有疑问，请联系商城招商经理：（固话）020-29106888-8363')?>。
                <?php if ($enterprise->service_id): ?>
                   <?php echo Yii::t('memberEnterprise', '您的招商人员服务编号')?>：<?php echo $enterprise->service_id ?>
                <?php endif; ?>
            </div>

        </div>
        <div class="signProgress">
            <h3 class="mt10 tableTitle"><?php echo Yii::t('enterpriseLog', '审核进度'); ?>：</h3>
            <ul class="signProgressBar no<?php echo $status ?>">
                <li><?php echo Yii::t('enterpriseLog', '1、提交资质电子档'); ?></li>
                <li><?php echo Yii::t('enterpriseLog', '2、审核资质电子档'); ?> </li>
                <li><?php echo Yii::t('enterpriseLog', '3、审核纸质合同资质'); ?></li>
                <li><?php echo Yii::t('enterpriseLog', '4、资质审核成功'); ?> </li>
            </ul>
        </div>
        <h3 class="mt10 tableTitle"><?php echo Yii::t('enterpriseLog', '进度详情'); ?>：</h3>

        <table class="mt10 memberT1" width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <th class="bgOrange" width="15%"><?php echo Yii::t('enterpriseLog', '时间'); ?></th>
                    <th class="bgOrange" width="90%"><?php echo Yii::t('enterpriseLog', '事件'); ?></th>
                </tr>
                <?php
                /** @var $v EnterpriseLog */
                $log = $enterpriseLog;
                $logNum = count($log);
                ?>
                <?php foreach ($log as $k => $v): ?>
                    <tr>
                        <td class="ta_c">
                            <?php echo $this->format()->formatDatetime($v->create_time); ?>
                        </td>
                        <td class="ta_l">
                            <?php
                            if ($keyreturn) {
                                if ($v->create_time > $keyreturn->create_time) {
                                    $content = str_replace('卖家平台', CHtml::link('卖家平台', array('/seller'), array('style' => 'color:red;', 'target' => '_blank')), $v->content);
                                    $content = str_replace('打印资质', CHtml::link('打印资质', array('enterpriseLog/print'), array('style' => 'color:red;', 'target' => '_blank')), $content);

                                    echo $content;
                                } else {
                                    echo $v->content;
                                }
                            } else {
                                $content = str_replace('卖家平台', CHtml::link('卖家平台', array('/seller'), array('style' => 'color:red;', 'target' => '_blank')), $v->content);
                                $content = str_replace('打印资质', CHtml::link('打印资质', array('enterpriseLog/print'), array('style' => 'color:red;', 'target' => '_blank')), $content);
                                echo $content;
                            }
                            ?>
                            <?php
                            if ($lastOne->status == EnterpriseLog::STATUS_NOT_PASS && $k + 1 == $logNum && $lastOne->progress != EnterpriseLog::PROCESS_CLOSE_STORE) {
                                if ($enterprise->enterprise_type == Enterprise::TYPE_INDIVIDUAL) {
                                    echo CHtml::link(Yii::t('enterpriseLog', '[修改资质]'), array('enterpriseLog/enterprise2'), array('class' => 'red'));
                                } else {
                                    echo CHtml::link(Yii::t('enterpriseLog', '[修改资质]'), array('enterpriseLog/enterprise'), array('class' => 'red'));
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>