<?php
$this->breadcrumbs = array(Yii::t('commonAccountAgentDist', '代理管理'), $model->name, Yii::t('commonAccountAgentDist', '分配金额'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('commonAccountAgentDist/dist'),
    'method' => 'post',
    'id' => 'common-account-agent-dist-form',
        ));
?>
<table width="100%" cellspacing="1" cellpadding="0" border="0"
       class="tab-come">
    <tr>
        <th class="title-th even" colspan="2"><?php echo Yii::t('commonAccountAgentDist', '代理公共账户信息'); ?></th>
    </tr>
    <tr>
        <th width="120px" class="odd"><?php echo Yii::t('commonAccountAgentDist', '帐号名称') ?>：</th>
        <td class="odd">
            <?php echo $model->name ?>
        </td>
    </tr>
    <tr>
        <th class="even"><?php echo Yii::t('commonAccountAgentDist', '地区') ?>：</th>
        <td class="even">
            <?php echo $model->dis->name ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo Yii::t('commonAccountAgentDist', '帐号余额') ?>：</th>
        <td class="odd">¥
            <?php echo $model->cash ?>
        </td>
    </tr>
    <tr>
        <th class="title-th even" colspan="2"><?php echo Yii::t('commonAccountAgentDist', '分配信息') ?></th>
    </tr>
    <tr>
        <th class="odd"><?php echo Yii::t('commonAccountAgentDist', '分配金额') ?>：</th>
        <td class="odd">￥ 
            <?php echo $form->textField($model, 'cash', array('onchange' => 'distMoneyChange()')); ?> 
            <?php echo CHtml::hiddenField('source_dist_money', $model->cash); ?>
            <strong class="orange">*</strong>(分配金额不能大于 ¥<?php echo Tool::showMoney($model->cash) ?>) </td>
    </tr>
    <tr>
        <th class="even"><?php echo Yii::t('commonAccountAgentDist', '剩余金额') ?>：</th>
        <td class="even">¥<span id="td_money_remainder"><?php echo $moneyArr['remainder'] ?></span></td>
    </tr>
    <tr>
        <th class="title-th even odd" colspan="2"><?php echo Yii::t('commonAccountAgentDist', '代理信息') ?></th>
    </tr>
</table>
<div class="c10"></div>
<table width="100%" cellspacing="1" cellpadding="0" border="0"
       class="tab-reg">
    <tr class="tab-reg-title">
        <th><b><?php echo Yii::t('commonAccountAgentDist', '地区名称') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '地区级别') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '代理会员编码') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '代理用户名') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '代理手机号') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '实占比率') ?></b></th>
        <th><b><?php echo Yii::t('commonAccountAgentDist', '获得金额') ?></b></th>
    </tr>
    <?php foreach ($distribute as $item): ?>
        <tr>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $item['name'] ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo Region::getAgentLevel($item['depth']) ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $item['gai_number'] ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $item['username'] ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo $item['mobile'] ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                <?php echo isset($item['ratio']) ? $item['ratio'] : 0 ?>
                %</td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">¥
                <span id="td_money_<?php echo $item['depth'] ?>"><?php echo $moneyArr[$item['depth']] ?></span>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="c10"></div>
<?php if (Yii::app()->user->checkAccess('CommonAccountAgentDist.Dist')): ?>
    <input type="submit" class="regm-sub" onclick="return confirmDist();" value="确认分配" id="btn_save">
<?php endif; ?>
<?php echo $form->hiddenField($model, 'id'); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function distMoneyChange()
    {
        var source_dist_money = $("#source_dist_money").val();
        var CommonAccount_cash = $("#CommonAccount_cash").val();
        if (parseFloat(CommonAccount_cash) >= parseFloat(source_dist_money))
        {
            $("#CommonAccount_cash").val(source_dist_money);
            CommonAccount_cash = source_dist_money;
        }
        var data = {"type": "ajax", "money": CommonAccount_cash};
        jQuery.ajax({
            type: "GET", async: false, cache: false, timeout: 10000, dataType: "json", processData: true,
            url: window.location.href,
            data: data,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(data)
            {
                if (data.error == 0)
                {
                    for (var key in data.content)
                    {
                        $("#" + key).html(data.content[key]);
                    }
                }

            }
        });
    }
    function confirmDist()
    {
        art.dialog({
            icon: 'question-red',
            content: '<?php echo Yii::t('commonAccountAgentDist', '分配后无法还原，确认分配吗'); ?>？',
            ok: function() {
                $("#common-account-agent-dist-form").submit();
            },
            cancel: true,
        });
        return false;
    }
</script>