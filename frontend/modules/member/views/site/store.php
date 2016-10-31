<?php
/* @var $this  SiteController */
/** @var $model Member */
/** @var $modelInfo Enterprise */
/** @var $infoData EnterpriseData */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);

$this->breadcrumbs = array(
    Yii::t('member', '账户管理') => '',
    Yii::t('member', '企业基本资料'),
);
?>
<script>
    $(function () {
        $("#license_pic").fancybox();
    });
</script>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('member', '企业基本信息'); ?></span></a></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('member', '头像设置') . '</span>', $this->createAbsoluteUrl('/member/member/avatar')) ?></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('member', '兴趣爱好') . '</span>', $this->createAbsoluteUrl('/member/interest/index')) ?></li>
        </ul>
    </div>

    <div class="EntInfoTabCon">
        <div class="EntInfoShow">
            <?php $this->renderPartial('/layouts/_summary'); ?>
            <div class="EntInfoShow_t"></div>
            <div class="EntInfoShow_c">
                <div class="modules">
                    <h3 class="title"><?php echo Yii::t('member','帐号信息'); ?> </h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="t_EntInfo">
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('member','登录名'); ?>：</td>
                            <td><?php echo $this->getUser()->name; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','盖网编号'); ?>：</td>
                            <td><?php echo $this->getUser()->gw; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modules">
                    <h3 class="title"><?php echo Yii::t('member','时间信息'); ?> </h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="t_EntInfo">
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('member','开始服务时间'); ?>：</td>
                            <td><?php echo $this->format()->formatDatetime($modelInfo->service_start_time) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','结束服务时间'); ?>：</td>
                            <td><?php echo $this->format()->formatDatetime($modelInfo->service_end_time) ?> </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modules">
                    <h3 class="title"><?php echo Yii::t('member','公司信息'); ?> </h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="t_EntInfo">
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('member','公司名称'); ?>：</td>
                            <td><?php echo $modelInfo->name ?></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','公司简称'); ?></td>
                            <td><?php echo $modelInfo->short_name ?> </td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','公司地址'); ?>：</td>
                            <td>
                                <?php echo Region::getName($modelInfo->province_id, $modelInfo->city_id, $modelInfo->district_id) ?>
                                <?php echo $modelInfo->street ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modules">
                    <h3 class="title"><?php echo Yii::t('member','联系人资料'); ?> </h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="t_EntInfo">
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('member','联系人姓名'); ?>：</td>
                            <td><?php echo $modelInfo->link_man ?></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','电子邮箱'); ?>：</td>
                            <td><?php echo $modelInfo->email ?></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('member','所属部门'); ?>:</td>
                            <td><?php echo $modelInfo::departmentArr($modelInfo->department) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modules">
                    <h3 class="title"><?php echo Yii::t('member','手机绑定'); ?> </h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="t_EntInfo">
                        <tbody>
                        <tr>
                            <td><?php echo Yii::t('member','您已经绑定手机'); ?>：</td>
                            <td><?php echo $model->mobile ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="profileDo">
                    <?php echo CHtml::link(Yii::t('member','修改资料'), $this->createAbsoluteUrl('/member/member/update'), array('class' => 'btnModify')) ?>
                </div>
            </div>
            <div class="EntInfoShow_b"></div>
        </div>
    </div>

</div>
<?php if(time() < strtotime("2015-10-12")+3600*24*7):?>
    <script>
    //成功样式的dialog弹窗提示
    art.dialog({
        icon: '提示',
        content: '<div style="line-height:1.8;font-size:15px"><h1 style="text-align:center">关于网站调整部分产品暂时下架通知</h1><p style="text-align:justify; text-indent:2em;">因网站调整需要，我们将于2015年10月12日（周一）对部分商家产品进行暂时下架，</p><p>下架周期为5-7个工作日，调整完成后将进行恢复，给您带来的不便，敬请谅解！</p><p style="text-align:right;">盖象商城</p><p style="text-align:right;">2015年10月10日</p></div>',
        ok: true,
        okVal:'<?php echo Yii::t('member','确定') ?>',
        title:'<?php echo Yii::t('member','消息') ?>'
    });     
    </script>
<?php endif;?>