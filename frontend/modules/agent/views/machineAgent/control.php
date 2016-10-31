<link href="<?php echo AGENT_DOMAIN . '/agent'; ?>/css/agent.css" rel="stylesheet" type="text/css" />
<link href="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/timePicker/timePicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/timePicker/jquery.timePicker.min.js"></script>
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/common.js"></script>
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/artDialog.iframeTools.js" type="text/javascript"></script>

<!--<script src="<?php //echo AGENT_DOMAIN;      ?>/js/timePicker/jquery.timePicker.min.js"></script>
<script src="<?php //echo AGENT_DOMAIN;      ?>/js/common.js"></script>
<script src="<?php //echo AGENT_DOMAIN;      ?>/js/jquery.artDialog.js" type="text/javascript"></script>
<script src="<?php //echo AGENT_DOMAIN;      ?>/js/artDialog.iframeTools.js" type="text/javascript"></script>-->
<style>
    .sysvolume {
        height: 42px;
        position: relative;
        width: 150px;
    }
    .volume {
        background: url("agent/images/volume.png") no-repeat scroll 0 -50px rgba(0, 0, 0, 0);
        display: inline-block;
        height: 25px;
        margin-top: 20px;
        position: absolute;
        right: -5px;
        width: 25px;
    }
    .tooltip {
        -moz-box-sizing: border-box;
        background: -moz-linear-gradient(center top , rgba(69, 72, 77, 0.5) 0%, rgba(0, 0, 0, 0.5) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 1px solid #333333;
        border-radius: 3px 3px 3px 3px;
        box-shadow: 1px 1px 2px 0 rgba(0, 0, 0, 0.3);
        color: blueviolet;
        font-weight: bolder;
        font-size: 16px;
        display: block;
        font: 10pt Tahoma,Arial,sans-serif;
        height: 20px;
        position: absolute;
        text-align: center;
        width: 35px;
    }

    #slider {
        background: url("agent/images/bg-track.png") repeat scroll left top rgba(0, 0, 0, 0);
        border-color: #333333 #333333 #777777;
        border-radius: 25px 25px 25px 25px;
        border-style: solid;
        border-width: 1px;
        box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.5) inset, 0 1px 0 0 rgba(250, 250, 250, 0.5);
        height: 13px;
        margin: 25px 0 0 16px;
        position: absolute;
        width: 100px;
    }
    .ui-slider-range {
        background: -moz-linear-gradient(center top , #FFFFFF 0%, #EAEAEA 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 0 none;
        border-radius: 25px 25px 25px 25px;
        height: 100%;
        position: absolute;
        top: 0;
    }

</style>
<script language="javascript" type="text/javascript">
    function hideOrShow(id, a) {
        $(".Hidden").hide();
        $(".tabhover").removeAttr("class");
        $("." + id).show();
        $("#" + a).addClass("tabhover");
    }
    $(function() {
        $('.time').timePicker({step: 60});

        $("#MachineAgent_city_id").change(function() {
            $("#gt_machineagent_city_name").val($("#MachineAgent_city_id  option:selected").text());
        });
    });
    function fillCity(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('region/getRegionByParentId') ?>",
            data: {"<?php echo Yii::app()->request->csrfTokenName ?>": "<?php echo Yii::app()->request->csrfToken ?>", pid: id, type: 'province'},
            async: false,
            dataType: "json",
            success: function(data)
            {
                $("#MachineAgent_city_id").html(data.dropDownCities);
                $("#MachineAgent_district_id").html(data.dropDownCounties);
            }
        });
    }
    function fillDistrict(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('region/getRegionByParentId') ?>",
            data: {"<?php echo Yii::app()->request->csrfTokenName ?>": "<?php echo Yii::app()->request->csrfToken ?>", pid: id, type: 'city'},
            async: false,
            dataType: "html",
            success: function(data)
            {
                $("#MachineAgent_district_id").html(data);
            }
        });
    }
</script>

<div>
    <div class="optPanel">
        <div class="toolbar img01"><?php echo Yii::t('Machine', '编辑盖机') ?>(<?php echo $model->name ?>)
            <?php echo CHtml::link(Yii::t('Public', '返回'), array('machineAgent/index'), array('class' => 'button_05 floatRight')) ?>
        </div>
    </div>
    <div class="ctxTable">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'machine-agent-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
        ));
        ?>
        <table width="100%" cellspacing="1" cellpadding="0" border="0" class="inputTable">
            <tr class="caption allHidden">
                <td colspan="2">
                    <div class="tab1 fl">
                        <p></p>
                        <?php
                        if (Yii::app()->language == 'en') {
                            echo "<div class='tab1_01_en fl_en'>";
                        } else {
                            echo "<div class='tab1_01 fl'>";
                        }
                        ?>
                        <!--                            <div class="tab1_01_en fl_en">-->
                        <a class="tabhover" onclick="javascript:hideOrShow('oneHidden', 'tab0')" href="javascript:void(0);" id="tab0"><?php echo Yii::t('Machine', '基本信息') ?></a>
                        <a onclick="javascript:hideOrShow('threeHidden', 'tab2')" href="javascript:void(0);" id="tab2"><?php echo Yii::t('Machine', '位置信息') ?></a></div>
                    </div>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'machine_code') ?>：</td>
                <td>
                    <?php echo $model->machine_code ?>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'name') ?>：</td>
                <td>
                    <?php echo $form->textField($model, 'name', array('class' => 'inputbox width200')) ?><span style="color: Red">*</span>
                    <?php echo $form->error($model, 'name') ?>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo Yii::t('Machine', '所属线下服务商') ?>：</td>
                <td>
                    <?php echo $model->biz_name ?>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'setup_time') ?>：</td>
                <td>
                    <?php echo $model->setup_time ? date('Y-m-d H:i:s', $model->setup_time) : '' ?>
                </td>
            </tr>

            <tr class="oneHidden Hidden">
                <td class="c1 width200"> <?php echo $form->label($model, 'auto_open_time') ?>：</td>
                <td> 
                    <?php echo $form->textField($model, 'auto_open_time', array('class' => 'inputbox width80 time')); ?>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"> <?php echo Yii::t('Machine', '自动关机时间') ?>：</td>
                <td> 
                    <?php echo $form->textField($model, 'auto_shutdown_time', array('class' => 'inputbox width80 time')); ?>
                </td>
            </tr>

            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'run_status') ?>：</td>
                <td>
                    <?php
                    echo CHtml::link(MachineAgent::getRunStatus($model->run_status), 'javascript:void(0)', array(
                        'title' => Yii::t('Machine', '最后签到时间') . ($model->last_open_time ? date('Y-m-d H:i:s', $model->last_open_time) : Yii::t('Machine', '无')),
                        'class' => $model->run_status == MachineAgent::RUN_STATUS_OPERATION ? 'online' : 'offline',
                        'id' => 'machine_agent_run_status',
                        'style' => 'float:left'
                    ));
                    ?>
                    <?php
//                    echo CHtml::link($model->run_status == MachineAgent::RUN_STATUS_UNINSTALL ? Yii::t('Machine', '恢复') : Yii::t('Machine', '卸载'), '#', array(
//                        'class' => 'button_04',
//                        'id' => 'machine_agent_run_status_button',
//                        'ajax' => array(//暂时屏蔽
//                            'type' => 'POST',
//                            'url' => $this->createUrl('machineAgent/ajaxcontrol'),
//                            'dataType' => 'json',
//                            'data' => array(
//                                'id' => $model->id,
//                                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
//                            ),
//                            'success' => 'function(data) {
//			                            $("#machine_agent_run_status_button").text(data.run_button);
//			                            $("#machine_agent_run_status").text(data.run_text);
//			                            $("#machine_agent_run_status").attr("class","offline");
//			                        }',
//                        )
//                    ));
                    ?>
                </td>
            </tr>

            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'sys_volume') ?>：</td>
                <td>
                    <div class="sysvolume">
                        <span class="tooltip" style="left: 1px;"></span>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiSlider', array(
                            'id' => 'slider',
                            'value' => $model->sys_volume,
                            'skin' => false,
                            'options' => array(
                                'orientation' => 'horizontal',
                                'range' => 'min',
                                'min' => 0,
                                'animate' => true,
                                'create' => 'js:function(event,ui){
                        			var value = $("#slider").slider("value");
                        			$(".tooltip").css("left", value).text(value);
                        		}',
                                'slide' => 'js:function(event,ui){
                        			var value = $("#slider").slider("value");
									volume = $(".volume");
									$(".tooltip").css("left", value).text(ui.value);
									if(value <= 5) { 
										volume.css("background-position", "0 0");
									} 
									else if (value <= 25) {
										volume.css("background-position", "0 -25px");
									} 
									else if (value <= 75) {
										volume.css("background-position", "0 -50px");
									} 
									else {
										volume.css("background-position", "0 -75px");
									};
                        		}',
                                'stop' => 'js:function(event,ui){
                        			$("#MachineAgent_sys_volume").val(ui.value);
                        		}'
                            ),
                            'htmlOptions' => array(
                                'style' => 'height:10px;width:100px;',
                            ),
                        ));
                        ?>
                        <span class="volume" style="background-position: 0px -75px;"></span>
                    </div>
                    <?php echo $form->hiddenField($model, 'sys_volume') ?>
                </td>
            </tr>
            <tr>
                <td class="c1 width200"><?php echo $form->label($model, 'api') ?>：</td>
                <td>
                    <div class="radio machineActions">
                        <?php
                        $apiData = MachineForbbidenAgent::getApi();
                        echo $form->checkBoxList($model, 'api', $apiData, array('separator' => '', 'labelOptions' => array('style' => 'margin-right:5px;display:inline;')));
                        ?>
                    </div>
                </td>
            </tr>
            <tr class="oneHidden Hidden">
                <td class="c1 width200"><?php echo $form->label($model, 'last_open_time') ?>：</td>
                <td>
                    <?php
                    if ($model->last_open_time) {
                        if (Yii::app()->language == 'zh_cn') {
                            echo date('Y年m月d日  H:i:s', $model->last_open_time);
                        } else {
                            echo date('Y-m-d  H:i:s', $model->last_open_time);
                        }
                    } else {
                        echo '';
                    }
                    ?>
                </td>
            </tr>

            <tr class="threeHidden Hidden" style="display: none;">
                <td class="c1 width200">
                    <?php echo Yii::t('Public', '地区') ?>：
                </td>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
                        'prompt' => Yii::t('Public', '选择省份'),
                        'onchange' => 'fillCity(this.value)',
                    ));
                    echo $form->error($model, 'province_id');
                    ?>
                    <?php
                    echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                        'prompt' => Yii::t('Public', '选择城市'),
                        'onchange' => 'fillDistrict(this.value)',
                    ));
                    echo $form->error($model, 'city_id');
                    ?>
                    <?php
                    echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                        'prompt' => Yii::t('Public', '选择区/县'),
                    ));
                    echo $form->error($model, 'district_id');
                    ?>
                    <span style="color: Red">*</span>
                </td>
            </tr>
            <tr class="threeHidden Hidden" style="display: none;">
                <td class="c1 width200"><?php echo $form->label($model, 'address') ?>：</td>
                <td>
                    <?php echo $form->textArea($model, 'address', array('class' => 'inputarea width400', 'cols' => 2, 'rows' => 3)); ?>
                    <?php echo $form->error($model, 'address'); ?>
                    <span style="color: Red">*</span>
                </td>
            </tr>
            <tr class="threeHidden Hidden" style="display: none;">
                <td class="c1 width200"> <?php echo Yii::t('Machine', '地图类型') ?>：</td>
                <td id="tdMapType">
                    <?php //echo CHtml::hiddenField('gt_machine_city_name')?>
                    <?php
                    $this->widget('application.modules.agent.widgets.CBDMap', array(
                        'useClass' => 'inputbox width200',
                        'form' => $form,
                        'model' => $model,
                        'attr_lng' => 'loc_lng',
                        'attr_lat' => 'loc_lat',
                        'type' => 'use',
                    ))
                    ?>
                </td>
            </tr>

        </table>
        <div class="align-center">
            <?php echo CHtml::submitButton(Yii::t('Public', '保存'), array('class' => 'button_04')) ?>&nbsp;&nbsp;&nbsp;
            <?php echo CHtml::link(Yii::t('Public', '返回'), array('machineAgent/index'), array('class' => 'button_04')) ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="coypyright">
    </div>
</div>
<style>
    .tab1_01_en{width:100%; height:45px; font:18px "微软雅黑", "新宋体";  border-bottom:2px solid #7c7c7c; }
    .tab1_01_en span{width:150px; height:45px; background:url(<?php echo AGENT_DOMAIN . '/agent' ?>/images/tongji.png) no-repeat 5px 8px; padding-left:40px; line-height:45px; display:block; float:left; border:none; !important}
    .tab1_01_en a{width:155px; height:44px; color:#c2c2c2; font-size: 14px; font-weight: bold; line-height:44px; text-align:center; display:block; float:left; border:1px solid #c2c2c2;  border-bottom:2px solid #7c7c7c;}
    .tab1_01_en a:hover{width:152px; color:#222222; height:44px; background:#FFF; border:2px solid #7c7c7c; border-bottom:2px solid #FFF !important;}
    .tab1_01_en a.tabhover{width:152px; height:44px; color:#222222; background:#FFF; border:2px solid #7c7c7c; border-bottom:2px solid #FFF !important;}
    .fl_en{float:left;}
</style>