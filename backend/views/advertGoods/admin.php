<?php $this->breadcrumbs = array(Yii::t('advertGoods', '广告位商品') => array('AdvertGoods/admin', 'advert_id' => $model->advert_id), Yii::t('AdvertGoods', '列表')); ?>

<div class="c10"></div>
<link href="/css/reg_advert_goods.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    var targetPro = function() {
        var Ids = [];
        $("#TabLst input:checked").each(function() {
            Ids.push($(this).val());
        });
        if (Ids.length == 0) {
            artDialog.alert("<?php echo Yii::t('advertGoods', '请选择投放商品'); ?>", null, "error");
        }
        else {
            var url = '<?php echo Yii::app()->createUrl('advertGoods/insertTargetPro'); ?>';
            $.post(url, {proIds: Ids.join(","), AdPosId: "<?php echo $model->advert_id; ?>", 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                if (data.result == "error") {
                    artDialog.alert(data.msg, null, data.result);
                }
                //刷新页面
                location.reload();
            }, "json");
        }
    };

    var TopIndex = function(proId) {
        var url = '<?php echo Yii::app()->createUrl('advertGoods/topIndex'); ?>';
        $.post(url, {proId: proId, AdPosId: "<?php echo $model->advert_id; ?>", 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
            if (data.result == "error") {
                artDialog.alert(data.msg, null, data.result);
            }
            //刷新页面
            location.reload();
        }, "json");
    };

    var ChangeIndex = function(proId, changeStep) {
        var url = '<?php echo Yii::app()->createUrl('advertGoods/changeIndex'); ?>';
        $.post(url, {proId: proId, AdPosId: "<?php echo $model->advert_id; ?>", changeStep: changeStep, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
            if (data.result == "error") {
                artDialog.alert(data.msg, null, data.result);
            }
            //刷新页面
            location.reload();
        }, "json");
    };


    var DeleteItems = function(proIds) {
        var url = '<?php echo Yii::app()->createUrl('advertGoods/deleteItems'); ?>';
        $.post(url, {proIds: proIds, AdPosId: "<?php echo $model->advert_id; ?>", 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
            if (data.result == "error") {
                artDialog.alert(data.msg, null, data.result);
            }
            //刷新页面
            location.reload();
            //$("#TargetCurrentDiv").load('/BackOffice/AdMana/PartialTargetCurrent', { AdPosId: "58" });
        }, "json");
    }


    var deleteAll = function() {
        DeleteItems("<?php
$goods_ids = array();
foreach ($advert_goods_data as $data) {
    $goods_ids[] = $data->goods_id;
} echo implode(',', $goods_ids);
?>");
    };


    var UpdateShowPage = function() {
        var url = '<?php echo Yii::app()->createUrl('advertGoods/updateShowPage'); ?>';
        $.post(url, {AdPosId: "<?php echo $model->advert_id; ?>", 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
            if (data) {
                artDialog.alert(data.msg);
            }
        }, "json");
    };

</script>



<div style="text-align: center">
<!--    <input name="" class="reg-sub-long" value="--><?php //echo Yii::t('advertGoods', '同步到前台显示'); ?><!--" title="--><?php //echo Yii::t('advertGoods', '同步到前台显示'); ?><!--" onclick="UpdateShowPage()" type="button">-->
</div>
<div class="c10">
</div>
<div class="pr_box clearfix">
    <!-- 开始 -->
    <div class="b1">
        <!-- 操作 -->
        <div class="tool">
            <input name="" class="reg-sub" value=">>" title="<?php echo Yii::t('advertGoods', '确认选择'); ?>" onclick="targetPro()" type="button">
            <input name="" class="reg-sub" value="<<" title="<?php echo Yii::t('advertGoods', '全部删除'); ?>" onclick="deleteAll()" type="button">
        </div>
        <!-- 操作 -->
        <div class="con" id="TargetSearchDiv">

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.tab-reg ').each(function() {
                        $(this).find('tr:even td').css("background", "#eee");
                        $(this).find('tr:odd td').css("background", "#fff");
                    });
                });

                var choseAll = function() {
                    var checkValue = $("#checkAll").is(':checked');
                    $("#TabLst input[type=checkbox]").each(function() {
                        if (checkValue) {
                            $(this).attr("checked", "checked");
                        }
                        else {
                            $(this).removeAttr("checked");
                        }
                    });
                };
            </script>

            <div class="search_box">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route, array('aid' => $model->advert_id)),
                    'method' => 'post',
                ));
                ?>
                <span><?php echo Yii::t('advertGoods', '商品搜索'); ?>:</span>
                <?php echo $form->textField($goods_model, 'name', array('class' => 'text-input-bj  long', 'id' => 'txtName')); ?>
                <?php echo CHtml::submitButton(Yii::t('advertGoods', '搜索'), array('class' => 'reg-sub')); ?>

                <?php $this->endWidget(); ?>

            </div>
            <div class="pr_list">
                <table class="tab-reg" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <tr class="tab-reg-title">
                            <th style="width:50%">
                                <?php echo Yii::t('advertGoods', '商品名称'); ?>
                            </th>
                            <th>
                                <?php echo Yii::t('advertGoods', '供货价'); ?>
                            </th>
                            <th>
                                <?php echo Yii::t('advertGoods', '零售价'); ?>
                            </th>
                            <th>
                                <?php echo Yii::t('advertGoods', '销量'); ?>
                            </th>
                            <th>
                                <?php echo Yii::t('advertGoods', '点击率'); ?>
                            </th>
                            <th>
                                <input id="checkAll" onclick="choseAll()" title="<?php echo Yii::t('advertGoods', '选择全部商品'); ?>" type="checkbox">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="TabLst">

                        <?php if (!empty($goods_data)): ?>
                            <?php foreach ($goods_data as $data): ?>
                                <tr>
                                    <td style="text-align: left; padding-left: 12px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <span style="float:left">
                                            <?php
                                            echo CHtml::image(IMG_DOMAIN . '/' . $data->thumbnail, '', array('width' => 50, 'height' => 50));
                                            ?>
                                        </span>
                                        <a href="<?php echo DOMAIN . '/goods/' . $data->id; ?>" target="_blank"><?php echo $data->name; ?></a>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <span class="jf"><?php echo Yii::t('goods', '¥'); ?><?php echo $data->gai_price; ?></span>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <span class="jf"><?php echo Yii::t('goods', '¥'); ?><?php echo $data->price; ?></span>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <?php echo $data->sales_volume; ?>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <?php echo $data->views; ?>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                        <input name="checkProId" value="<?php echo $data->id; ?>" type="checkbox">
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end -->
    <!-- 开始 -->
    <div class="b2">
        <div class="con" id="TargetCurrentDiv">
            <div class="pr_list">
                <table class="tab-reg" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody>
                        <tr class="tab-reg-title">
                            <th>
                                <?php echo Yii::t('advertGoods', '排序'); ?>
                            </th>
                            <th style="width: 50%">
                                <?php echo Yii::t('advertGoods', '商品名称'); ?>
                            </th>
                            <th>
                                <a class="all_delete" href="#"><?php echo Yii::t('advertGoods', '操作'); ?></a>
                            </th>
                        </tr>

                        <?php if (!empty($advert_goods_data)): ?>
                            <?php foreach ($advert_goods_data as $data): ?>
                                <tr>
                                    <td style="background: none repeat scroll 0% 0% rgb(238, 238, 238);">
                                        <?php echo $data->sort; ?>
                                    </td>
                                    <td style="text-align: left; padding-left: 12px; background: none repeat scroll 0% 0% rgb(238, 238, 238);">
                                        <span style="float: left">
                                            <?php echo CHtml::image(IMG_DOMAIN . '/' . $data->goods_thumbnail, '', array('width' => 50, 'height' => 50)); ?>
                                        </span>
                                        <a href="<?php echo DOMAIN . '/goods/' . $data->goods_id; ?>" target="_blank"><?php echo $data->goods_name; ?></a>
                                    </td>
                                    <td style="background: none repeat scroll 0% 0% rgb(238, 238, 238);">
                                        <a href="javascript:TopIndex('<?php echo $data->goods_id; ?>')"><?php echo Yii::t('advertGoods', '【置顶】'); ?></a> <a href="javascript:ChangeIndex('<?php echo $data->goods_id; ?>',-1)"><?php echo Yii::t('advertGoods', '【↑】'); ?></a> <a href="javascript:ChangeIndex('<?php echo $data->goods_id; ?>',1)"><?php echo Yii::t('advertGoods', '【↓】'); ?></a> <a href="javascript:DeleteItems('<?php echo $data->goods_id; ?>')"><?php echo Yii::t('advertGoods', '【删除】'); ?></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- 结束 -->
</div>


