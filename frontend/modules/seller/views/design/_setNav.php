<?php
/** @var $this DesignController */
$design = new DesignFormat($model->data);
//Tool::pr($design->tmpData[DesignFormat::TMP_MAIN_NAV]);
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('design','导航模块'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css"/>
    <link type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/colorpicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/default.css"/>
    <?php echo $this->renderPartial('_navigateEditJs') ?>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/colorpicker.js"></script>
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }
        var diyLinkIdIndex = 0;
        $(function () {
            setHeadFoot();
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
            colorPick('colorNavigateBG', '#8f5757');
            colorPick('colorLinkText', '#fff');
            colorPick('colorLinkBGSelected', '#c22d2d');
            colorPick('colorLinkBGHover', '#b00101');
        });

        var displayClick = function (event, id) {
            if (event.checked) {
                $('#' + id).val(true);
            }
            else {
                $('#' + id).val(false);
            }
        }


    </script>
</head>
<body>
<?php
$linkList = $design->tmpData[DesignFormat::TMP_MAIN_NAV];
$linkList = isset($linkList['LinkList']) ? $linkList['LinkList'] : array();
//Tool::p($linkList);
?>
<div class="arbox">
    <div class="navEdit">
        <div class="navEditcolL">
            <div class="navEditcb navEditcb1">
                <h3> <?php echo Yii::t('design','添加自定义链接'); ?></h3>

                <div class="navEditinner">
                    <p><?php echo Yii::t('design','名称'); ?>：<input id="diyName" type="text">
                        <span class="field-validation-error" style="display: none"><?php echo Yii::t('design','名称不能为空'); ?></span></p>

                    <p><?php echo Yii::t('design','链接'); ?>：<input id="diyUrl" type="text">
                        <span class="field-validation-error" style="display: none"><?php echo Yii::t('design','链接不能为空'); ?></span>
                    </p>
                </div>
                <p>
                    <input class="button_gray" type="button" onclick="addDiyLink('DiyLink')" value="<?php echo Yii::t('design','添加新链接'); ?>">
                    <input id="btnSaveDiyLink" class="button_grays" type="button" style="display: none"
                           onclick="saveDiyLink()" value="<?php echo Yii::t('design','保存'); ?>">
                    <input id="hdLinkId" type="hidden" value="">
                </p>
            </div>
            <div class="navEditcb navEditcb2">
                <h3> <?php echo Yii::t('design','导入链接'); ?></h3>

                <div class="navEditinner">
                    <dl>
                        <dt><?php echo Yii::t('design','其他链接'); ?></dt>
                        <dd><label>-
                                <?php echo CHtml::checkBox('',$this->checkSelected(array(
                                    'IsEdit'=>true,
                                    'LinkUrl'=>'',
                                    'SourceId'=>2,
                                    'Title'=>Yii::t('design','实体店'),
                                    'Type'=>6,
                                ),$linkList),array(
                                    'id'=>'cbx_TheStore_2',
                                    'data-sourceid'=>'2',
                                    'data-type'=>'TheStore',
                                    'data-name'=>Yii::t('design','实体店'),
                                )) ?><?php echo Yii::t('design','实体店'); ?>
                            </label>
                        </dd>
                        <dt><?php echo Yii::t('design','分类'); ?></dt>
                        <?php if ($category): ?>
                            <?php foreach ($category as $v): ?>
                                <?php $selected = array(
                                    'IsEdit'=>true,
                                    'LinkUrl'=>'',
                                    'SourceId'=>$v->id,
                                    'Title'=>$v->name,
                                    'Type'=>1,
                                ) ?>
                                <dd><label>-
                                        <?php echo CHtml::checkBox($v->name, $this->checkSelected($selected,$linkList), array(
                                            'id' => 'cbx_CompCat_' . $v->id,
                                            'data-sourceid' => $v->id,
                                            'data-type' => 'CompCat',
                                            'data-name' => $v->name,
                                        )) ?>
                                        <?php echo $v->name ?>
                                    </label>
                                </dd>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <dt><?php echo Yii::t('design','文章'); ?></dt>
                        <?php foreach ($article as $v): ?>
                            <dd><label>-
                                    <?php echo CHtml::checkBox($v->title, $this->checkSelected(array(
                                        'IsEdit'=>true,
                                        'LinkUrl'=>'',
                                        'SourceId'=>$v->id,
                                        'Title'=>$v->title,
                                        'Type'=>2,
                                    ),$linkList), array(
                                        'id' => 'cbx_CompArticle_' . $v->id,
                                        'data-sourceid' => $v->id,
                                        'data-type' => 'CompArticle',
                                        'data-name' => $v->title,
                                    )) ?>
                                    <?php echo $v->title ?>
                                </label>
                            </dd>
                        <?php endforeach; ?>
                    </dl>
                </div>
            </div>
        </div>

        <div class="navEditcolR clearfix">
            <?php echo CHtml::form() ?>
            <div class="navEditcb navEditcb3">
                <div class="Tab_b clearfix" style="width: 100%">
                    <ul>
                        <li class="curr"><a href="javascript:void(0)"><?php echo Yii::t('design','导航设置'); ?></a></li>
                        <li><a href="javascript:void(0)"><?php echo Yii::t('design','显示设置'); ?></a></li>
                    </ul>
                </div>
                <div class="Set clearfix">
                    <table id="linkList" class="table-con3" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                        <tr>
                            <th><?php echo Yii::t('design','名称'); ?></th>
                            <th><?php echo Yii::t('design','排序'); ?></th>
                            <th><?php echo Yii::t('design','操作'); ?></th>
                        </tr>
                        <tr id="link_Index_0" data-url="#" data-sourceid="0" data-type="Index" data-name="<?php echo Yii::t('design','首页'); ?>">
                            <td class="navTitles"><?php echo Yii::t('design','首页'); ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr id="link_CompPresent_1" data-url="#" data-sourceid="1" data-type="CompPresent"
                            data-name="<?php echo Yii::t('design','商家简介'); ?>">
                            <td class="navTitles"><?php echo Yii::t('design','商家简介'); ?></td>
                            <td>&nbsp; </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr id="link_Index_0" data-url="#" data-sourceid="0" data-type="Index" data-name="<?php echo Yii::t('design','所有商品'); ?>">
                            <td class="navTitles"><?php echo Yii::t('design','所有商品'); ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <?php if(!empty($linkList)): ?>
                        <?php foreach ($linkList as $k => $v): ?>
                            <?php if ($k < 3) continue; ?>
                            <?php $navId = 'link_' . DesignFormat::navTypeName($v['Type']) . '_' . $v['SourceId']; ?>
                            <tr data-url="<?php echo $v['LinkUrl'] ?>" data-sourceid="<?php echo $v['SourceId'] ?>"
                                data-type="<?php echo DesignFormat::navTypeName($v['Type']) ?>"
                                data-name="<?php echo $v['Title'] ?>"
                                id="<?php echo $navId ?>">
                                <td class="navTitles"><?php echo $v['Title'] ?></td>
                                <input type="hidden" value="<?php echo $v['Title'] ?>" name="nav[title][]">
                                <input type="hidden" value="<?php echo DesignFormat::navTypeName($v['Type']) ?>"
                                       name="nav[type][]">
                                <input type="hidden" value="<?php echo $v['SourceId'] ?>" name="nav[sourceid][]">
                                <input type="hidden" value="<?php echo $v['LinkUrl'] ?>" name="nav[url][]">
                                <td>
                                    <a title="<?php echo Yii::t('design','向上'); ?>" href="javascript:moveUp('<?php echo $navId; ?>')"
                                       class="px upnot"></a>
                                    <a title="<?php echo Yii::t('design','向下'); ?>" href="javascript:moveDown('<?php echo $navId ?>')"
                                       class="px downot"></a>
                                </td>
                                <td><a href="javascript:opDele('<?php echo $navId ?>')"><?php echo Yii::t('design','删除'); ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="Set">
                    <?php if (isset($design->tmpData[1]['Color'])){
                        $navCss = $design->tmpData[1]['Color'];
                        $NavigateBG =  $navCss['NavigateBG'];
                        $LinkText =  $navCss['LinkText'];
                        $LinkBGHover =  $navCss['LinkBGHover'];
                        $LinkBGSelected =  $navCss['LinkBGSelected'];
                    }else{
                        $NavigateBG = '#C90000';
                        $LinkText = '#FFF';
                        $LinkBGHover = '#960000';
                        $LinkBGSelected = '#BB0000';
                    } ?>
                    <table class="tb-blue tb-t2b2" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                        <tr>
                            <th width="200px" scope="row"> <?php echo Yii::t('design','导航栏背景色'); ?>：</th>
                            <td>
                                <input type="hidden" value="<?php echo $NavigateBG  ?>" name="NavigateBG">

                                <div id="colorNavigateBG" class="colorSelector">
                                    <div style="background-color: <?php echo $NavigateBG  ?>;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="80px" scope="row"> <?php echo Yii::t('design','链接文字颜色'); ?>：</th>
                            <td>
                                <input type="hidden" value="<?php echo $LinkText ?>" name="LinkText">

                                <div id="colorLinkText" class="colorSelector">
                                    <div style="background-color: <?php echo $LinkText ?>;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="80px" scope="row"> <?php echo Yii::t('design','当前选中背景颜色'); ?>：</th>
                            <td>
                                <input type="hidden" value="<?php echo $LinkBGSelected ?>" name="LinkBGSelected">

                                <div id="colorLinkBGSelected" class="colorSelector">
                                    <div style="background-color: <?php echo $LinkBGSelected ?>;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="80px" scope="row"> <?php echo Yii::t('design','链接鼠标悬停背景颜色'); ?>：</th>
                            <td>
                                <input type="hidden" value="<?php echo $LinkBGHover  ?>" name="LinkBGHover">

                                <div id="colorLinkBGHover" class="colorSelector">
                                    <div style="background-color: <?php echo $LinkBGHover ?>;"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <p><input class="button_red1" type="submit" value="<?php echo Yii::t('design','保存'); ?>">
                <input class="button_red1s" type="button"  onclick="cancel()" value="<?php echo Yii::t('design','取消'); ?>"></p>
            <?php echo CHtml::endForm() ?>
        </div>
    </div>
</div>
<div id="collorpicker_112" class="colorpicker">
    <div class="colorpicker_color" style="background-color: rgb(255, 0, 0);">
        <div>
            <div style="left: 58px; top: 65px;"></div>
        </div>
    </div>
    <div class="colorpicker_hue">
        <div style="top: 150px;"></div>
    </div>
    <div class="colorpicker_new_color" style="background-color: rgb(143, 87, 87);"></div>
    <div class="colorpicker_current_color" style="background-color: rgb(143, 87, 87);"></div>
    <div class="colorpicker_hex"><input type="text" size="6" maxlength="6"></div>
    <div class="colorpicker_rgb_r colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_g colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_h colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_s colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_submit"></div>
</div>


<div id="collorpicker_812" class="colorpicker">
    <div class="colorpicker_color" style="background-color: rgb(0, 17, 255);">
        <div>
            <div style="left: 150px; top: 0px;"></div>
        </div>
    </div>
    <div class="colorpicker_hue">
        <div style="top: 51px;"></div>
    </div>
    <div class="colorpicker_new_color" style="background-color: rgb(0, 17, 255);"></div>
    <div class="colorpicker_current_color" style="background-color: rgb(0, 17, 255);"></div>
    <div class="colorpicker_hex"><input type="text" size="6" maxlength="6"></div>
    <div class="colorpicker_rgb_r colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_g colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_h colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_s colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_submit"></div>
</div>

<div id="collorpicker_835" class="colorpicker">
    <div class="colorpicker_color" style="background-color: rgb(255, 0, 0);">
        <div>
            <div style="left: 115px; top: 35px;"></div>
        </div>
    </div>
    <div class="colorpicker_hue">
        <div style="top: 150px;"></div>
    </div>
    <div class="colorpicker_new_color" style="background-color: rgb(194, 45, 45);"></div>
    <div class="colorpicker_current_color" style="background-color: rgb(194, 45, 45);"></div>
    <div class="colorpicker_hex"><input type="text" size="6" maxlength="6"></div>
    <div class="colorpicker_rgb_r colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_g colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_rgb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_h colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_s colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_hsb_b colorpicker_field"><input type="text" size="3" maxlength="3"><span></span></div>
    <div class="colorpicker_submit"></div>
</div>

<div id="collorpicker_746" class="colorpicker">
    <div class="colorpicker_color" style="background-color: rgb(255, 0, 0);">
        <div>
            <div style="left: 149px; top: 46px;"></div>
        </div>
    </div>
    <div class="colorpicker_hue">
        <div style="top: 150px;"></div>
    </div>
    <div class="colorpicker_new_color" style="background-color: rgb(176, 1, 1);"></div>
    <div class="colorpicker_current_color" style="background-color: rgb(176, 1, 1);"></div>
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