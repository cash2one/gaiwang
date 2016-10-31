<?php
/** @var $design DesignFormat */
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','设置产品广告'); ?></title>
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
    <h2 class="f18px"> <?php echo Yii::t('sellerDesign','设置产品广告'); ?></h2>

    <div class="c10"></div>

    <div class="c10"></div>
    <?php echo CHtml::form() ?>
    <div class="con">
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <th style="width: 150px"> <?php echo Yii::t('sellerDesign','图片'); ?></th>
                <th style="width: 150px"> <?php echo Yii::t('sellerDesign','图片标题'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','图片链接地址'); ?></th>
            </tr>
            </tbody>
            <tbody id="dataBody">
            <?php 
                if (isset($design->tmpData[DesignFormat::TMP_V20_MAIN_PIC]['Imgs'])):  
                   $imgArr=$design->tmpData[DesignFormat::TMP_V20_MAIN_PIC]['Imgs'];
                ?>
                    <tr>
                        <td>
                            <?php
                            $this->widget('seller.widgets.CUploadPic', array(
                                'attribute' => 'ImgUrl',
                                'num' => 1,
                                'value' => $imgArr[0]['ImgUrl'],
                                'btn_value' => Yii::t('sellerDesign','设置图片'),
                                'render' => '_upload',
                                'folder_name' => 'files',
                            ));
                            ?> <br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','图片不能为空'); ?></span>
                        </td>
                        <td>
                            <input type="text" maxlength="20" name="Title" class="small"
                                   value="<?php echo @$imgArr[0]['Title'] ?>">
                        </td>
                        <td>
                            <input type="text" name="Link" id="Model_3_Link" class="small"
                                   value="<?php echo $imgArr[0]['Link'] ?>"><br>
                            <span style="display: none" class="field-validation-error"><?php echo Yii::t('sellerDesign','地址不能为空'); ?></span>
                        </td>
                        <!--  
                        <td><input type="button" class="button_grays" onclick="doDeleteRow('0')" value="<?php echo Yii::t('sellerDesign','删除'); ?>"></td>
                       -->
                    </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="msg msg-info" style="width: <?php echo Yii::t('sellerDesign','480')?>; float: left"> <?php echo Yii::t('sellerDesign','图片不能超过1张，第一张大图请上传"370*1090"'); ?>
        <br/><?php echo Yii::t('sellerDesign','删除所有后保存，即可清空全部,并还原'); ?></div>
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
        'attribute' => 'ImgUrl_x',
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