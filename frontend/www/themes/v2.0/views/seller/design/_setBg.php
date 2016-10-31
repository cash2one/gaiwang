<?php
/**
 * @var $model Design
 * @var $this DesignController
 */
$design = new DesignFormat($model->data);
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','修改背景'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css"/>
    <link type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/colorpicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/default.css"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/colorpicker.js"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        };
        if(typeof success != 'undefined'){
            parent.location.reload();
            art.dialog.close();
        }
        //颜色设置
        var colorPick = function (id, color) {
            $('#' + id).ColorPicker({
                color: color,
                onShow: function (colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb, el) {
                    $('#' + id + ' div').css('backgroundColor', '#' + hex);
                    $('#' + id).siblings('input').val('#' + hex);
                }
            });
        };
        $(function () {
            colorPick('colorBackground', '<?php echo $design->BGColor ?>');
        });
        function childCall(methodName, filepath) {
            switch (methodName) {
                case 'setBgImage':
                    var img = document.getElementById('BgImage');
                    img.src = MakeImageUrl(filepath, '120x120', 'box');
                    img.style.display = '';
                    var h = document.getElementById('BGImg');
                    h.value = filepath;
                    break;
            }
        }
        ;
        function MakeImageUrl(refFileName, itsize, itmode) {
            var imgUrl = '/Atta/GetFileForJS.html';
            return imgUrl + '?f=' + encodeURIComponent(refFileName) + '&size=' + itsize + '&mode=' + itmode;
        }
        var cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose)
                p.doClose();
        };
        var btnsubmit = function () {
            var radio = $("input[name='bg[DisplayBgImage]']:checked").val();
            if (radio == 'true') {
                var img = $("#bg_BGImg").val();
                if (img == null || img == "") {
                    var htmlValue = $("#bg_BGImg").parent().html() + "<div class='field-validation-error' style='display: inline; position:static'><?php echo Yii::t('sellerDesign','请选择背景图片'); ?></div>";
                    if ($("#bg_BGImg").parent().html().indexOf('<?php echo Yii::t('sellerDesign','请选择背景图片'); ?>') == -1) {
                        $("#bg_BGImg").parent().html(htmlValue);
                    }
                    $("#IsBGImage").attr("checked", "checked");
                    return false;
                }
                return true;
            }
        };
    </script>
</head>
<style>
    #_imgshowbg_BGImg{
        display: inline-block;
    }
</style>

<body>
    <?php echo CHtml::form() ?>
    <div class="arbox">
        <table class="table-con5" cellspacing="0" cellpadding="0" border="0" style="width: 100%">
            <tbody>
            <tr>
                <th width="150px"> <?php echo Yii::t('sellerDesign','背景色'); ?>：</th>
                <td>
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="border-width: 0">
                                <input type="hidden" value="<?php echo $design->BGColor ?>" name="bg[BGColor]">
                                <div id="colorBackground" class="colorSelector">
                                    <div style="background-color: <?php echo $design->BGColor ?>;"></div>
                                </div>
                            </td>
                            <td style="border-width: 0; text-align: left; width: 50px">
                                <?php echo CHtml::radioButton('bg[DisplayBgImage]',!$design->DisplayBgImage,
                                    array('id'=>'IsColor','value'=>'false')) ?>
                                <label style="font-size: 12px" for="IsColor">
                                    <?php echo Yii::t('sellerDesign','显示'); ?>
                                </label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th> <?php echo Yii::t('sellerDesign','背景图片'); ?>：</th>
                <td>
                    <?php
                    $this->widget('seller.widgets.CUploadPic',array(
                        'attribute' => 'bg[BGImg]',
                        'value'=>$design->BGImg,
                        'num' => 1,
                        'btn_value' => Yii::t('sellerDesign','设置背景图片'),
                        'render'=>'_upload',
                        'folder_name' => 'files',
                    ));
                    ?>
                    <?php echo CHtml::radioButton('bg[DisplayBgImage]',$design->DisplayBgImage,
                        array('id'=>'IsBGImage','value'=>'true')) ?>
                    <label style="font-size: 12px" for="IsBGImage">
                        <?php echo Yii::t('sellerDesign','显示'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th> <?php echo Yii::t('sellerDesign','平铺方式'); ?>：</th>
                <td>
                    <?php echo CHtml::dropDownList('bg[BGRepeat]',$design->BGRepeat,DesignFormat::bgRepeat(),
                        array('class'=>'small')) ?>
                </td>
            </tr>
            <tr>
                <th> <?php echo Yii::t('sellerDesign','相对位置'); ?>：</th>
                <td>
                    <?php echo CHtml::dropDownList('bg[BGPosition]',$design->BGPosition,DesignFormat::bgPosition(),
                        array('class'=>'small')) ?>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="editor">
            <input class="button_red1" type="submit" onclick="return btnsubmit()" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
            <input class="button_red1s" type="button" onclick="cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
        </div>
    </div>
    <?php echo CHtml::endForm();?>

<div id="collorpicker_62" class="colorpicker">
    <div class="colorpicker_color" style="background-color: rgb(255, 0, 0);">
        <div>
            <div style="left: 124px; top: 38px;"></div>
        </div>
    </div>
    <div class="colorpicker_hue">
        <div style="top: 150px;"></div>
    </div>
    <div class="colorpicker_new_color" style="background-color: rgb(189, 32, 32);"></div>
    <div class="colorpicker_current_color" style="background-color: rgb(189, 32, 32);"></div>
    <div class="colorpicker_hex"><input type="text" size="6" maxlength="6"></div>
    <div class="colorpicker_rgb_r colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_g colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_h colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_s colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_submit"></div>
</div>

<div
    style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
</body>
</html>