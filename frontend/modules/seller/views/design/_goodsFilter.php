<?php
/** @var $this DesignController */
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo Yii::t('sellerDesign','商铺装修编辑'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/blue.css">
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery-1.5.1.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.unobtrusive.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/artdialog/artDialog.js?skin=blue"></script>
    <script type="text/javascript"
            src="<?php echo $this->module->assetsUrl ?>/js/artdialog/iframeTools.source.js"></script>
    <script type="text/javascript">
        if (typeof success != 'undefined') {            parent.location.reload();
            art.dialog.close();
        }
        var Cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose)
                p.doClose();
        };

        var SearchResult = function () {
            var url = '<?php echo $this->createAbsoluteUrl('/shop/view',array('id'=>$this->storeId)) ?>';
            var keyword = $('#Keywords').val();
            var catId = $('#CatId').val();
            var maxMoney = $('#MaxMoney').val();
            var minMoney = $('#MinMoney').val();
            var order = $('#OrderMode').val();
            url += '?';
            if (keyword != '') {
                url += 'q=' + encodeURIComponent(keyword);
            }
            if (catId != '') {
                url += '&catId=' + catId;
            }
            if (minMoney != '') {
                url += '&minScore=' + minMoney;
            }
            if (maxMoney != '') {
                url += '&maxScore=' + maxMoney;
            }
            if (order != '') {
                url += '&order=' + order;
            }
            window.open(url);
        };
    </script>
    <style type="text/css">
        body {
            font-size: 12px;
        }
    </style>
</head>
<body style="background: #fff">
<div class="arbox">
    <?php echo CHtml::form() ?>
    <h1 class="h1title"><?php echo Yii::t('sellerDesign','标题设置'); ?></h1>

    <div class="c10">
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" class="tb-blue tb-t2b2">
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','标题'); ?>：
            </th>
            <td>
                <?php echo CHtml::textField('TypeTitle',$tmpData['TypeTitle'],array(
                    'class'=>'text-input-bj small',
                    'data-val'=>'true',
                    'data-val-required'=>Yii::t('sellerDesign','标题不能为空'),
                    'id'=>'TypeTitle',
                	'style'=>'width:75%',
                )); ?>
                <?php echo Yii::t('sellerDesign','注：中文'); ?>
                <span class="field-validation-valid" data-valmsg-for="TypeTitle" data-valmsg-replace="true"></span>
            </td>
        </tr>
        <tr>
            <th style="width: 100px">
                <?php echo Yii::t('sellerDesign','副标题'); ?>：
            </th>
            <td>
                <input class="text-input-bj small" id="TypeChildTitle" style='width:75%' name="TypeChildTitle" type="text" value="<?php echo $tmpData['TypeChildTitle'] ?>"/>
                <?php echo Yii::t('sellerDesign','注：英文'); ?>
            </td>
        </tr>
    </table>
    <div class="c10">
    </div>
    <h1 class="h1title"><?php echo Yii::t('sellerDesign','宝贝筛选'); ?></h1>

    <div class="c10"></div>
    <table width="100%" cellpadding="0" cellspacing="0" class="tb-blue tb-t2b2">
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','关键词筛选'); ?>：
            </th>
            <td>
                <input class="text-input-bj small" id="Keywords" name="Keywords" type="text" value="<?php echo $tmpData['Keywords'] ?>"/>
            </td>
        </tr>
        <tr>
            <th style="width: 90px;">
                <?php echo Yii::t('sellerDesign','所属分类'); ?>：
            </th>
            <td>
                    <?php echo CHtml::dropDownList('CatId',$tmpData['CatId'],CHtml::listData($category,'id','name'),array(
                        'id'=>'CatId',
                        'class'=>'text-input-bj',
                        'data-val'=>'true',
                        'data-val-number'=>'The field CatId must be a number.',
                        'empty'=>'',
                    )) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 90px;">
                <?php echo Yii::t('sellerDesign','积分范围'); ?>：
            </th>
            <td>
                <input class="xsmall" data-val="true" data-val-number="<?php echo Yii::t('sellerDesign','必须为正整数'); ?>"
                       id="MinMoney" name="MinMoney" type="text" value="<?php echo $tmpData['MinMoney'] ?>"/> <?php echo Yii::t('sellerDesign','积分'); ?>-
                <input class="xsmall" data-val="true" data-val-number="<?php echo Yii::t('sellerDesign','必须为正整数'); ?>"
                       id="MaxMoney" name="MaxMoney" type="text" value="<?php echo $tmpData['MinMoney'] ?>"/> <?php echo Yii::t('sellerDesign','积分'); ?>
                <a href="javascript:SearchResult();"> <?php echo Yii::t('sellerDesign','查看筛选结果'); ?></a>
                <span class="field-validation-valid" data-valmsg-for="MinMoney"  data-valmsg-replace="true"></span>
                <span class="field-validation-valid" data-valmsg-for="MaxMoney"  data-valmsg-replace="true"></span>
            </td>
        </tr>
    </table>
    <div class="c10">
    </div>
    <h1 class="h1title"><?php echo Yii::t('sellerDesign','显示方式'); ?></h1>
    <div class="c10">
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" class="tb-blue tb-t2b2">
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','宝贝数量'); ?>：
            </th>
            <td>
                <?php echo CHtml::textField('ProCount',$tmpData['ProCount'],array(
                    'class'=>'text-input-bj small',
                    'data-val'=>'true',
                    'data-val-number'=>Yii::t('sellerDesign','宝贝数量 必须是数字'),
                    'data-val-range'=>Yii::t('sellerDesign','宝贝数量必须在1--50之内'),
                    'data-val-range-max'=>'50',
                    'data-val-range-min'=>'1',
                    'data-val-regex'=>Yii::t('sellerDesign','宝贝数量必须为正整数'),
                    'data-val-regex-pattern'=>'^[0-9]*[1-9][0-9]*$',
                    'data-val-required'=>Yii::t('sellerDesign','宝贝数量 必填'),
                    'id'=>'ProCount',
                )) ?>
                <span class="field-validation-valid" data-valmsg-for="ProCount"  data-valmsg-replace="true"></span>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','排序方式'); ?>：
            </th>
            <td>
                <?php echo CHtml::dropDownList('OrderMode',$tmpData['OrderMode'],
                    Design::orderMode(),array('id'=>'OrderMode','class'=>'text-input-bj')) ?>
            </td>
        </tr>
    </table>
    <div class="editor">
        <input id="shopSubmit" type="submit" value="<?php echo Yii::t('sellerDesign','保存'); ?>" class="button_red1"/>
        <input type="button" value="<?php echo Yii::t('sellerDesign','取消'); ?>" class="button_red1s" onclick="Cancel()"/>
    </div>
    <?php echo CHtml::endForm() ?>
</div>
</body>
</html>
