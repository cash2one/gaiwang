<?php 
    $form = $this->beginWidget('CActiveForm',array(
//            'id' => 'agentMaintenance-search-form',
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
        )
    );
?>
<style>
    .search_button3{float:'';display:inline;}
</style>
<table width="100%" cellspacing="0" cellpadding="0" class="table1">
        <tr class="table1_title">
            <td colspan="11">
                <?php echo Yii::t('AgentMaintenance','盘点情况')?>(<?php echo $model->search()->totalItemCount?>)
            </td>
        </tr>
        <tr>
            <td colspan="8" class="table_search">
                <div class="form_search">
                    <label for="textfield"></label>
                    <p><?php echo $form->label($model,'盖机名或装机编码')?>：</p>
                    <?php echo $form->textField($model,'name',array('class'=>'search_box3 selecd'));?>
                    <p><?php echo Yii::t('Public','所在地区')?></p>
                    <p>
                        <?php
                        echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
                            'prompt' => Yii::t('Public','选择省份'),
                            'class'=>'search_box3 selecd',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('region/getRegionByParentId'),
                                'dataType' => 'json',
                                'data' => array(
                                    'pid' => 'js:this.value',
                                    'type' => 'province',
                                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                                ),
                                'success' => 'function(data) {
                                                $("#MachineAgent_city_id").html(data.dropDownCities);
                                                $("#MachineAgent_district_id").html(data.dropDownCounties);
                                            }',
                            )));
                        ?>
                        <?php
                        echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                            'prompt' => Yii::t('Public','选择城市'),
                            'class'=>'search_box3 selecd',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('region/getRegionByParentId'),
                                'update' => '#MachineAgent_district_id',
                                'data' => array(
                                    'pid' => 'js:this.value',
                                    'type' => 'city',
                                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>
                        <?php
                        echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                            'prompt' => Yii::t('Public','选择区/县'),
                            'class'=>'search_box3 selecd'
                        ));
                        ?>
                    </p>
                    <p><?php echo $form->label($model, '盘点时间段')?></p>
                    <p>
                        <?php echo $form->textField($model, 'i_begin_time', array('class'=>'search_box3 selecd' ,'onclick'=>'WdatePicker({skin:"whyGreen",dateFmt:"yyyy-MM-dd"})'))?>
                    </p>
                    <p>
                        <?php echo $form->textField($model, 'i_end_time', array('class'=>'search_box3 selecd','onclick'=>'WdatePicker({skin:"whyGreen",dateFmt:"yyyy-MM-dd"})'))?>
                    </p>
                    <p><?php echo $form->label($model,'盘点状态')?></p>
                    <p><?php echo $form->dropDownList($model,'inventoryState',MachineAgent::getInventory(),array('prompt' => '请选择','class'=>'search_box3 selecd'))?></p>
                  <?php echo CHtml::submitButton(Yii::t('Public', '搜索'), array('id'=>'submit','class'=>'button_04','style'=>'margin-left: 40px;')); ?>
                </div>
            </td>
        </tr>
    </table>
<?php $this->endWidget();?>

<style>
    .selecd{
        width: 100px;
    }
</style>
<script type="text/javascript">
    function checkTime(){
        var beginTime = $('#MachineAgent_i_begin_time');
        var endTime = $('#MachineAgent_i_end_time');
        if (beginTime.val().length>0 && endTime.val().length>0 && beginTime.val() > endTime.val()) {
            art.dialog({
                icon: 'warning',
                content: '开始时间段不能大于结束时间段',
                lock: true,
                ok: function () {
                    beginTime.val('');
                    endTime.val('');
                }
            });
            return false;
        } else return true;
    }
    $(document).ready(function() {
        $("#submit").click(function () {
            return checkTime();
        });
    });
</script>