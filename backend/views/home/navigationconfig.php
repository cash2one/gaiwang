<?php
/** @var $design DesignFormat */
?>
    <script type="text/javascript">
        // 限制数量
        var rowCount = '3';
        var addRow = function () {
            if ($('#dataBody').find('tr').length > 10) {
                alert("<?php echo Yii::t('home','最多只能添加十个链接'); ?>", null, "warning-red");
                return;
            }
            var rowId = 'row_' + rowCount;
            var html = '';
            html += '<tr id="' + rowId + '">';
            html += '<td>';
            html += '<input value="" class="small" type="text" name="Name[]" maxlength="20" /><br> ';
            html += '<span class="field-validation-error" style="display: none"><?php echo Yii::t('home','名称不能为空'); ?></span>';
            html += '</td>';
            html += '<td>';
            html += '<input value="" class="small" type="text" name="Title[]" maxlength="20" /><br> ';
            html += '<span class="field-validation-error" style="display: none"><?php echo Yii::t('home','标题不能为空'); ?></span>';
            html += '</td>';
            html += '<td>';
            html += '<input value="" class="small" type="text" id="Model_' + rowCount + '_Link" name="Link[]" /><br/>';
            html += '<span class="field-validation-error" style="display: none"><?php echo Yii::t('home','链接地址不能为空'); ?></span>';
            html += '</td>';
            html += '<td class="tdMove">';
            html += ' <a href="javascript:moveUp(\'' + rowId + '\')" class="px up" title="<?php echo Yii::t('home','向上')?>"></a>';
            html += ' <a href="javascript:moveDown(\'' + rowId + '\')" class="px dow" title="<?php echo Yii::t('home','向下')?>"></a>';
            html += '</td>';
            html += '<td>';
            html += '<input type="button" value="<?php echo Yii::t('home','删除'); ?>" onclick="doDeleteRow(' + rowCount + ')" class="reg-sub" />';
            html += '</td>';
            html += '</tr>';
            $('#dataBody').append(html);
            rowCount++;
            setHeadFoot();
        };
        var doDeleteRow = function (rowid) {
            $('#row_' + rowid).hide(500, function () {
                $('#row_' + rowid).remove();
                setHeadFoot();
            });
        };
    </script>
    <script type="text/javascript">
        var validateForm = function () {
            var valid = true;
            $('#dataBody [name*="Name"]').each(function (i, ele) {
                if (!$(ele).val()) {
                    $(ele).siblings('.field-validation-error').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).siblings('.field-validation-error').css('display', 'none');
                }
            });
            $('#dataBody [name*="Title"]').each(function (i, ele) {
                if (!$(ele).val()) {
                    $(ele).siblings('.field-validation-error').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).siblings('.field-validation-error').css('display', 'none');
                }
            });
            $('#dataBody [name*="Link"]').each(function (i, ele) {
                if (!$(ele).val()) {
                    $(ele).siblings('.field-validation-error').css('display', 'inline');
                    valid = false;
                }
                else {
                    $(ele).siblings('.field-validation-error').css('display', 'none');
                }
            });
            return valid;
        };
        var btnsubmit = function () {
            if (!validateForm()) {
                return false;
            }
            return true;
        };
        var cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose) p.doClose();
        };
    </script>
    <script type="text/javascript">
        var moveUp = function (pId) {
            if ($('#' + pId).find('.upnot').length > 0) {
                return;
            }
            $('#' + pId).prev().before($('#' + pId));
            setHeadFoot();
        };
        var setHeadFoot = function () {
            $('#dataBody .tdMove .upnot').removeClass('upnot').addClass('up');
            $('#dataBody .tdMove .downot').removeClass('downot').addClass('dow');
            var data = $('#dataBody .tdMove');
            if (data.length > 0) {
                var upData = data.find('.up');
                $(upData[0]).removeClass('up').addClass('upnot');
                var dowData = data.find('.dow');
                $(dowData[dowData.length - 1]).removeClass('dow').addClass('downot');
            }
        };
        var moveDown = function (pId) {
            if ($('#' + pId).find('.downot').length > 0) {
                return;
            }
            $('#' + pId).next().after($('#' + pId));
            setHeadFoot();
        };


    </script>

<body>
<div class="arbox">

    <div class="c10"></div>
    <input class="regm-sub" type="button" onClick="addRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>">

    <div class="c10"></div>
    <?php echo CHtml::form() ?>
    <div class="con">
        <table class="tab-reg" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <th style="width: 150px"> <?php echo Yii::t('home','名称'); ?></th>
                <th style="width: 150px"> <?php echo Yii::t('home','标题'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('home','链接地址'); ?></th>
                <th style="width: 30px"> <?php echo Yii::t('home','排序'); ?></th>
                <th style="width: 30px"> <?php echo Yii::t('home','操作'); ?></th>
            </tr>
            </tbody>
            <tbody id="dataBody">
            <?php if (!empty($allData)): ?>
                <?php foreach ($allData as $v): ?>
                    <?php $uid = 'row_' . md5($v['link']) ?>
                    <tr id="<?php echo $uid ?>">
                        <td>
                            <input value="<?php echo @$v['name'] ?>" class="small" type="text" name="Name[]" maxlength="20" /><br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','名称不能为空'); ?></span>
                        </td>
                        <td>
                            <input type="text" maxlength="20" name="Title[]" class="small"
                                   value="<?php echo @$v['title'] ?>"><br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','标题不能为空'); ?></span>
                        </td>
                        <td>
                            <input type="text" name="Link[]" id="Model_3_Link" class="small" maxlength="50"
                                   value="<?php echo $v['link'] ?>"><br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','地址不能为空'); ?></span>
                        </td>
                        <td class="tdMove">
                            <a title="向上" class="px upnot" href="javascript:moveUp('<?php echo $uid ?>')"></a>
                            <a title="向下" class="px dow" href="javascript:moveDown('<?php echo $uid ?>')"></a>
                        </td>
                        <td><input type="button" class="reg-sub"
                                   onclick="doDeleteRow('<?php echo md5($v['link']) ?>')" value="<?php echo Yii::t('sellerDesign','删除'); ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="">
        <input type="hidden" name="val" value="v"/>
        <input class="reg-sub"  type="submit" onClick="return btnsubmit();" value="<?php echo Yii::t('home','保存'); ?>">
    </div>
    <?php echo CHtml::endForm() ?>
</div>

<div
    style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
<style type="text/css">
    .arbox .con{ height:auto; clear:both; padding:5px; overflow:auto;}
</style>

