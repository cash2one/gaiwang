<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','实体店联系方式编辑'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/blue.css">
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.unobtrusive.min.js"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">

        if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }

        var Cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose)
                p.doClose();
        };
        var doDeleteRow = function (pre, rowid) {
            $('#' + pre + rowid).hide(500, function () {
                $('#' + pre + rowid).remove();
            });
        };
        var contactRowCount = '2';
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
            $('#dataBody').append(html);
            contactRowCount++;
        };
        var emailCount = '0';
        var addEmailRow = function () {
            var html = '<tr id="Email_' + emailCount + '">';
            html += '<td>';
            html += '<input type="text" name="emailList[]" class="text-input-bj small" />';
            html += '</td>';
            html += '<td>';
            html += '<input type="button" value="<?php echo Yii::t('sellerDesign','删除'); ?>" onclick="doDeleteRow(\'Email_\',' + emailCount + ')" class="button_grays" />';
            html += '</td>';
            html += '</tr>';
            $('#emailBody').append(html);
            emailCount++;
        };
        var phoneCount = '0';
        var addPhoneRow = function () {
            var html = '<tr id="Phone_' + phoneCount + '">';
            html += '<td>';
            html += '<input type="text" name="phoneName[]" class="text-input-bj small" />';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" name="phoneNum[]" class="text-input-bj small" />';
            html += '</td>';
            html += '<td>';
            html += '<input type="button" value="<?php echo Yii::t('sellerDesign','删除'); ?>" onclick="doDeleteRow(\'Phone_\',' + phoneCount + ')" class="button_grays" />';
            html += '</td>';
            html += '</tr>';
            $('#phoneBody').append(html);
            phoneCount++;
        };
        var btnSubmit = function () {
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
            $("input[name='emailList[]']").each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    var htmlValue = $(this).parent().html() + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','邮箱不能为空'); ?></div>";
                    if ($(this).parent().html().indexOf('<?php echo Yii::t('sellerDesign','邮箱不能为空'); ?>') == -1) {
                        $(this).parent().html(htmlValue);
                    }
                    ret = false;
                }
            });
            $("input[name='phoneName[]']").each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    var htmlValue = $(this).parent().html() + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','联系人不能为空'); ?></div>";
                    if ($(this).parent().html().indexOf('<?php echo Yii::t('sellerDesign','联系人不能为空'); ?>') == -1) {
                        $(this).parent().html(htmlValue);
                    }
                    ret = false;
                }
            });
            $("input[name='phoneNum[]']").each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    var htmlValue = $(this).parent().html() + "<div class='field-validation-error'><?php echo Yii::t('sellerDesign','联系电话不能为空'); ?></div>";
                    if ($(this).parent().html().indexOf('<?php echo Yii::t('sellerDesign','联系电话不能为空'); ?>') == -1) {
                        $(this).parent().html(htmlValue);
                    }
                    ret = false;
                }
            });
            return ret;
        };
    </script>
</head>
<body>

<?php echo CHtml::form() ?>
<?php
$tmpStore = $design->tmpData[DesignFormat::TMP_STORE_CONTACT];
$tmpMain = $design->tmpData[DesignFormat::TMP_LEFT_CONTACT];
$provinceId = isset($tmpStore['ProvinceId']) ? $tmpStore['ProvinceId'] : '';
$cityId = isset($tmpStore['CityId']) ? $tmpStore['CityId'] : '';
$districtId = isset($tmpStore['DistrictId']) ? $tmpStore['DistrictId'] : '';
$street = isset($tmpStore['Street']) ? $tmpStore['Street'] : '';
$zipCode = isset($tmpStore['ZipCode']) ? $tmpStore['ZipCode'] : '';
$emailList = isset($tmpStore['CustomerEmail']) ? $tmpStore['CustomerEmail'] : array();
$customerPhone = isset($tmpStore['CustomerPhone']) ? $tmpStore['CustomerPhone'] : array();
?>
<div class="arbox">
    <table class="tb-blue tb-t2b2" cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
            <th class="row"><?php echo Yii::t('sellerDesign','地址'); ?></th>
            <td>
                <?php
                echo CHtml::hiddenField('CountryId', 1);
                echo CHtml::dropDownList('ProvinceId', $provinceId, Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('sellerDesign', '选择省份'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#CityId").html(data.dropDownCities);
                            $("#DistrictId").html(data.dropDownCounties);
                        }',
                    )));
                ?>
                <?php
                echo CHtml::dropDownList('CityId', $cityId, Region::getRegionByParentId($provinceId), array(
                    'prompt' => Yii::t('sellerDesign', '选择城市'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/seller/region/updateArea'),
                        'update' => '#DistrictId',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                    )));
                ?>
                <?php
                echo CHtml::dropDownList('DistrictId', $districtId, Region::getRegionByParentId($cityId), array(
                    'prompt' => Yii::t('sellerDesign', '选择区/县'),
                    'class' => 'selectTxt1',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'CityId' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                    )));
                ?>

            </td>
        </tr>
        <tr>
            <th class="row"><?php echo Yii::t('sellerDesign','街道'); ?></th>
            <td>
                <input id="Street" class="text-input-bj small" type="text" value="<?php echo $street ?>" name="Street">
            </td>
        </tr>
        <tr>
            <th class="row"><?php echo Yii::t('sellerDesign','邮编'); ?></th>
            <td>
                <input id="ZipCode" class="text-input-bj small" type="text" value="<?php echo $zipCode ?>"
                       name="ZipCode">
            </td>
        </tr>
        </tbody>
    </table>
    <h1 class="h1title"><?php echo Yii::t('sellerDesign','QQ方式'); ?></h1>

    <div class="c10"></div>
    <p><input class="button_gray" type="button" onclick="addContactRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>"></p>

    <div class="c10"></div>

    <div class="con" style="height: 110px">
        <?php
        $qqContact = $design->tmpData[DesignFormat::TMP_LEFT_CONTACT];
        $qqArray = isset($qqContact['CustomerData']) ? $qqContact['CustomerData'] : array();
        $title = isset($qqContact['CustomerTitle']) ? $qqContact['CustomerTitle'] : Yii::t('sellerDesign','在线咨询');
        ?>
        <input type="hidden" name="CustomerTitle" value="<?php echo $title ?>"/>
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','名称'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','QQ号码'); ?></th>
                <th style="width: 70px"> <?php echo Yii::t('sellerDesign','操作'); ?></th>
            </tr>
            </thead>
            <tbody id="dataBody">
            <?php if (isset($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'])):?>
            <?php foreach ($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'] as $k => $v): ?>
                <tr id="Contact_<?php echo $k ?>">

                    <td>
                        <input type="text" class="text-input-bj small" value="<?php echo $v['ContactPrefix'] ?>"
                               name="Prefix[]">
                    </td>
                    <td>
                        <input type="text" class="text-input-bj small" value="<?php echo $v['ContactNum'] ?>"
                               name="ContactNum[]">
                    </td>
                    <td>
                        <input type="button" class="button_grays" onclick="doDeleteRow('Contact_',<?php echo $k ?>)"
                               value="<?php echo Yii::t('sellerDesign','删除'); ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>
            </tbody>
        </table>
    </div>

    <h1 class="h1title"><?php echo Yii::t('sellerDesign','邮箱方式'); ?></h1>

    <div class="c10"></div>
    <p><input class="button_gray" type="button" onclick="addEmailRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>"></p>

    <div class="c10"></div>
    <div class="con" style="height: 110px">
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','邮箱地址'); ?></th>
                <th style="width: 70px"> <?php echo Yii::t('sellerDesign','操作'); ?></th>
            </tr>
            </thead>
            <tbody id="emailBody">
            <?php if (!empty($emailList)): ?>
                <?php foreach ($emailList as $k => $v): ?>
                    <tr id="Email_<?php echo $k ?>">
                        <td><input type="text" value="<?php echo $v ?>" class="text-input-bj small" name="emailList[]">
                        </td>
                        <td>
                            <input type="button" class="button_grays" onclick="doDeleteRow('Email_',<?php echo $k ?>)"
                                   value="<?php echo Yii::t('sellerDesign','删除'); ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h1 class="h1title"><?php echo Yii::t('sellerDesign','电话方式'); ?></h1>

    <div class="c10"></div>
    <p><input class="button_gray" type="button" onclick="addPhoneRow()" value="<?php echo Yii::t('sellerDesign','添加'); ?>"></p>

    <div class="c10"></div>
    <div class="con" style="height: 110px">
        <table class="table_ar" width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','联系人'); ?></th>
                <th style="width: 200px"> <?php echo Yii::t('sellerDesign','联系电话'); ?></th>
                <th style="width: 70px"> <?php echo Yii::t('sellerDesign','操作'); ?></th>
            </tr>
            </thead>
            <tbody id="phoneBody">
            <?php if(!empty($customerPhone)): ?>
            <?php foreach($customerPhone as $k => $v): ?>
            <tr id="Phone_0">
                <td><input type="text" class="text-input-bj small" name="phoneName[]" value="<?php echo $v['ContactName'] ?>"></td>
                <td><input type="text" class="text-input-bj small" name="phoneNum[]" value="<?php echo $v['ContactNum'] ?>"></td>
                <td><input type="button" class="button_grays" onclick="doDeleteRow('Phone_',0)" value="<?php echo Yii::t('sellerDesign','删除'); ?>"></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="editor">
        <input class="button_red1" type="submit" onclick="return btnSubmit()" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
        <input class="button_red1s" type="button" onclick="Cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
    </div>
</div>
<?php echo CHtml::endForm() ?>

</body>
</html>