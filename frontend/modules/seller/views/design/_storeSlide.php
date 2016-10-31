<?php
/** @var $design DesignFormat */
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','设置幻灯片'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css"/>
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/red.css">
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>

    <script type="text/javascript">
        var dialog = null;
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        };
        if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }
        //图片上传控件 html
        var imgUpload = function (uid) {
            var html = '';
            html += '<div id="_imgshowImgUrl_' + uid + '" class="ImgList"></div>';
            html += '<input type="button" value="<?php echo Yii::t('sellerDesign','设置图片'); ?>"';
            html += 'onclick="_fileUpload(';
            html += '\'<?php echo Yii::app()->createUrl('/seller/upload/index', array('height' =>0, 'width' =>0, 'img_format' =>'')) ?>\',';
            html += '\'<?php echo Yii::app()->createUrl('/seller/upload/sure', array('imgarea' => 1, 'foldername' => 'files', 'isdate' => 1)) ?>\',';
            html += "1,'ImgUrl_" + uid + "',";
            html += "'<?php echo Yii::app()->request->csrfToken; ?>','<?php echo session_id() ?>')";
            html += '"  style="cursor:pointer">';
            html += '<input type="hidden" id="ImgUrl_' + uid + '" name="ImgUrl[]" value="">';
            return html;
        };

        // 限制图片状态
        var rowCount = '3';
        var addRow = function () {
            if ($('#dataBody').find('tr').length > 5) {
                artDialog.alert("<?php echo Yii::t('sellerDesign','最多只能添加六张图片'); ?>", null, "warning-red");
                return;
            }
            var rowId = 'row_' + rowCount;
            var html = '';
            html += '<tr id="' + rowId + '">';
            html += '<td>';
            html += imgUpload(String(Math.random()).substr(3)) + '<br/>';
            html += '<span class="field-validation-error" style="display: none"><?php echo Yii::t('sellerDesign','图片不能为空'); ?></span>';
            html += '</td>';
            html += '<td>';
            html += '<input value="" class="small" type="text" name="Title[]" maxlength="20" /> ';
            html += '</td>';
            html += '<td>';
            html += '<input value="" class="small" type="text" id="Model_' + rowCount + '_Link" name="Link[]" /><br/>';
            html += '<span class="field-validation-error" style="display: none"><?php echo Yii::t('sellerDesign','地址不能为空'); ?></span>';
            html += '</td>';
            html += '<td class="tdMove">';
            html += ' <a href="javascript:moveUp(\'' + rowId + '\')" class="px up" title="<?php echo Yii::t('sellerDesign','向上'); ?>"></a>';
            html += ' <a href="javascript:moveDown(\'' + rowId + '\')" class="px dow" title="<?php echo Yii::t('sellerDesign','向下'); ?>"></a>';
            html += '</td>';
            html += '<td>';
            html += '<input type="button" value="<?php echo Yii::t('sellerDesign','删除'); ?>" onclick="doDeleteRow(' + rowCount + ')" class="button_grays" />';
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
            $('#dataBody [name*="ImgUrl"]').each(function (i, ele) {
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
</head>
<body>
<div class="arbox">
    <h2 class="f18px"> <?php echo Yii::t('sellerDesign','设置幻灯片'); ?></h2>

    <div class="c10"></div>
    <input class="button_gray" type="button" onClick="addRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>">

    <div class="c10"></div>
    <?php echo CHtml::form() ?>
    <div class="con">
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <th style="width: 150px"> <?php echo Yii::t('sellerDesign','图片'); ?></th>
                <th style="width: 150px"> <?php echo Yii::t('sellerDesign','图片标题'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','图片链接地址'); ?></th>
                <th style="width: 30px"> <?php echo Yii::t('sellerDesign','排序'); ?></th>
                <th style="width: 30px"> <?php echo Yii::t('sellerDesign','操作'); ?></th>
            </tr>
            </tbody>
            <tbody id="dataBody">
            <?php if (isset($design->tmpData[DesignFormat::TMP_STORE_SLIDE]['Imgs'])): ?>
                <?php foreach ($design->tmpData[DesignFormat::TMP_STORE_SLIDE]['Imgs'] as $v): ?>
                    <?php $uid = 'row_' . md5($v['ImgUrl']) ?>
                    <tr id="<?php echo $uid ?>">
                        <td>
                            <?php
                            $this->widget('seller.widgets.CUploadPic', array(
                                'attribute' => 'ImgUrl[]',
                                'num' => 1,
                                'value' => $v['ImgUrl'],
                                'btn_value' => Yii::t('sellerDesign','设置图片'),
                                'render' => '_upload',
                                'folder_name' => 'files',
                            ));
                            ?> <br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','图片不能为空'); ?></span>
                        </td>
                        <td>
                            <input type="text" maxlength="20" name="Title[]" class="small"
                                   value="<?php echo @$v['Title'] ?>">
                        </td>
                        <td>
                            <input type="text" name="Link[]" id="Model_3_Link" class="small"
                                   value="<?php echo $v['Link'] ?>"><br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','地址不能为空'); ?></span>
                        </td>
                        <td class="tdMove">
                            <a title="<?php echo Yii::t('sellerDesign','向上'); ?>" class="px upnot" href="javascript:moveUp('<?php echo $uid ?>')"></a>
                            <a title="<?php echo Yii::t('sellerDesign','向下'); ?>" class="px dow" href="javascript:moveDown('<?php echo $uid ?>')"></a>
                        </td>
                        <td><input type="button" class="button_grays"
                                   onclick="doDeleteRow('<?php echo md5($v['ImgUrl']) ?>')" value="<?php echo Yii::t('sellerDesign','删除'); ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="msg msg-info" style="width: 320px; float: left"> <?php echo Yii::t('sellerDesign','图片不能超过6张，请上传 "1200x415" 大小的图片。'); ?></div>
    <div class="editor">
        <input class="button_red1" type="submit" onClick="return btnsubmit();" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
        <input class="button_red1s" type="button" onClick="cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
    </div>
    <?php echo CHtml::endForm() ?>
</div>

<span class="imgUp" style="display: none">
    <?php
    //加载上传图片js而已
    $this->widget('seller.widgets.CUploadPic', array(
        'attribute' => 'ImgUrl_xxx',
        'num' => 1,
        'btn_value' => Yii::t('sellerDesign','设置图片'),
        'render' => '_upload',
        'folder_name' => 'files',
    ));
    ?>
</span>

<div
    style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
</body>
</html>