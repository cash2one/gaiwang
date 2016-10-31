<?php
/** @var $this DesignController */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','在线咨询编辑'); ?></title>

    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/red.css">
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }
        var timeStr = ['00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'];
        var dateStr = ['<?php echo Yii::t('sellerDesign','周一'); ?>', '<?php echo Yii::t('sellerDesign','周二'); ?>', '<?php echo Yii::t('sellerDesign','周三'); ?>', '<?php echo Yii::t('sellerDesign','周四'); ?>', '<?php echo Yii::t('sellerDesign','周五'); ?>', '<?php echo Yii::t('sellerDesign','周六'); ?>', '<?php echo Yii::t('sellerDesign','周日'); ?>'];

        var timeRowCount = '1';
        var Cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose)
                p.doClose();
        };
        var CreateTimeSelect = function (selectName, selectedValue) {
            var ret = '';
            ret += '<select name="' + selectName + '" style="width:90px">';
            for (var i = 0; i < timeStr.length; i++) {
                var selected = selectedValue == timeStr[i] ? 'selected' : '';
                ret += '<option value="' + timeStr[i] + '"  ' + selected + ' >' + timeStr[i] + '</option>';
            }
            ret += '</select>';
            return ret;
        };
        var CreateDateSelect = function (selectName, selectedValue) {
            var ret = '';
            ret += '<select name="' + selectName + '" style="width:90px">';
            for (var i = 0; i < dateStr.length; i++) {
                var selected = selectedValue == dateStr[i] ? 'selected="selected"' : '';
                ret += '<option value="' + dateStr[i] + '" ' + selected + ' >' + dateStr[i] + '</option>';
            }
            ret += '</select>';
            return ret;
        };
        var addWorkTimeRow = function () {
            var strhtml = '';
            strhtml += '<tr id="workTime_' + timeRowCount + '">';
            strhtml += '<td>';
            strhtml += CreateDateSelect('MinDate[]') + ' <?php echo Yii::t('sellerDesign','至'); ?> ';
            strhtml += CreateDateSelect('MaxDate[]');
            strhtml += '</td>';
            strhtml += '<td>';
            strhtml += CreateTimeSelect('MinTime[]') + ' <?php echo Yii::t('sellerDesign','至'); ?> ';
            strhtml += CreateTimeSelect('MaxTime[]');
            strhtml += '</td>';
            strhtml += '<td>';
            strhtml += '<input type="button" value="<?php echo Yii::t('sellerDesign','删除'); ?>" onclick="doDeleteRow(\'workTime_\',' + timeRowCount + ')" class="button_grays" />';
            strhtml += '</td>';
            strhtml += '</tr>';
            $('#timeBody').append(strhtml);
            timeRowCount++;
        };
        var contactRowCount = '1';
        var addContactRow = function () {
            var html = '<tr id="Contact_' + contactRowCount + '">';
            html += '<td>';
            html += '<input type="text" name="Prefix[]" class="text-input-bj small" />';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" name="ContactNum[]" class="text-input-bj small" />';
            html += '</td>';
            html += '<td>';
            html += '<input type="button" value="<?php echo Yii::t('sellerDesign','删除'); ?>" onclick="doDeleteRow(\'Contact_\',' + contactRowCount + ')" class="button_grays" />';
            html += '</td>';
            html += '</tr>';
            $('#contactBody').append(html);
            contactRowCount++;
        };
        var doDeleteRow = function (pre, rowid) {
            $('#' + pre + rowid).hide(500, function () {
                $('#' + pre + rowid).remove();
            });
        };
        var btnSubmit = function (e) {
            var ret = true;
            $("input[name='Prefix[]']").each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    var htmlValue = $(this).parent().html() + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','咨询名称不能为空'); ?></div>";
                    if ($(this).parent().html().indexOf('<?php echo Yii::t('sellerDesign','咨询名称不能为空'); ?>') == -1) {
                        $(this).parent().html(htmlValue);
                    }
                    ret = false;
                }
            });

            $("input[name='ContactNum[]']").each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    var htmlValue = $(this).parent().html() + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','QQ号码不能为空'); ?></div>";
                    if ($(this).parent().html().indexOf('<?php echo Yii::t('sellerDesign','QQ号码不能为空'); ?>') == -1) {
                        $(this).parent().html(htmlValue);
                    }
                    ret = false;
                }
            });
            for (var i = 0; i < $("select[name='MinDate[]']").size(); i++) {
                var selectMinDate = $("select[name='MinDate[]'] option:selected")[i].value;
                var selectMaxDate = $("select[name='MaxDate[]'] option:selected")[i].value;
                var selectMinTime = $("select[name='MinTime[]'] option:selected")[i].value;
                var selectMaxTime = $("select[name='MaxTime[]'] option:selected")[i].value;
                if (selectMinDate >= selectMaxDate) {
                    var htmlValue = $("select[name='MinDate[]']").parent()[i].innerHTML + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','日期格式不正确'); ?></div>";
                    if ($("select[name='MinDate[]']").parent()[i].innerHTML.indexOf('<?php echo Yii::t('sellerDesign','日期格式不正确'); ?>') == -1) {
                        $("select[name='MinDate[]']").parent()[i].innerHTML = htmlValue;
                    }
                    ret = false;
                }
                if (selectMinTime >= selectMaxTime) {
                    var htmlValue = $("select[name='MinTime[]']").parent()[i].innerHTML + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','时间格式不正确'); ?></div>";
                    if ($("select[name='MinTime[]']").parent()[i].innerHTML.indexOf('<?php echo Yii::t('sellerDesign','日期格式不正确'); ?>') == -1) {
                        $("select[name='MinTime[]']").parent()[i].innerHTML = htmlValue;
                    }
                    ret = false;
                }
            }
            return ret;
        };


    </script>
</head>
<body>
<div class="arbox">
    <div class="c10"></div>
    <?php echo CHtml::form(); ?>
    <h1 class="h1title"> <?php echo Yii::t('sellerDesign','工作时间'); ?></h1>

    <div class="c10"></div>
    <p><input class="button_gray" type="button" onclick="addWorkTimeRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>"></p>

    <div class="c10"></div>
    <div class="con" style="height: 110px">
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','日期'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','时间'); ?></th>
                <th style="width: 70px"> <?php echo Yii::t('sellerDesign','操作'); ?></th>
            </tr>
            </thead>
            <tbody id="timeBody">
            <?php if (isset($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerWorkTime'])): ?>
                <?php foreach ($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerWorkTime'] as $k => $v): ?>
                    <tr id="workTime_<?php echo $k ?>">
                        <td>
                            <script type="text/javascript">
                                document.write(CreateDateSelect('MinDate[]', '<?php echo $v['MinDate'] ?>'));
                            </script>
                            <?php echo Yii::t('sellerDesign','至'); ?>
                            <script type="text/javascript">
                                document.write(CreateDateSelect('MaxDate[]', '<?php echo $v['MaxDate'] ?>'));
                            </script>
                        </td>
                        <td>
                            <script type="text/javascript">
                                document.write(CreateTimeSelect('MinTime[]', '<?php echo $v['MinTime'] ?>'));
                            </script>
                            <?php echo Yii::t('sellerDesign','至'); ?>
                            <script type="text/javascript">
                                document.write(CreateTimeSelect('MaxTime[]', '<?php echo $v['MaxTime'] ?>'));
                            </script>
                        </td>
                        <td><input type="button" class="button_grays"
                                   onclick="doDeleteRow('workTime_',<?php echo $k ?>)" value="<?php echo Yii::t('sellerDesign','删除'); ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
    <div class="c10"></div>
    <div class="c10"></div>
    <div class="editor">
        <input class="button_red1" type="submit" onclick="return btnSubmit();" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
        <input class="button_red1s" type="button" onclick="Cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
    </div>
    <?php echo CHtml::endForm() ?>
</div>
<div
    style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
</body>
</html>