<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table width="100%" cellpadding="0" cellspacing="0" class="searchT01">
        <tr>
            <th width="8%"><?php echo $form->label($model, 'code'); ?>：</th>
            <td width="25%"><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle', 'style' => 'width:50%')); ?></td>
            <th width="8%"><?php echo $form->label($model, 'phone'); ?>：</th>
            <td width="25%"><?php echo $form->textField($model, 'phone', array('class' => 'text-input-bj  middle', 'style' => 'width:50%')); ?></td>
            
        </tr>
        
        <tr>
            <th width="8%">买家会员编号</th><td width="25%"><?php echo $form->textField($model,'gai_numbers',array('class' => 'text-input-bj  middle', 'style' => 'width:50%'))?></td>
            <th width="8%">加盟商名称</th><td width="25%"><?php echo $form->textField($model,'fname',array('class' => 'text-input-bj  middle', 'style' => 'width:50%'))?></td>
        </tr>
        <tr>
            <th width="10%">加盟商所在地区</th>
            <td width="30%">
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('machineProductOrder', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#MachineProductOrder_city_id").html(data.dropDownCities);
                            //$("#MachineProductOrder_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php echo $form->error($model, 'province_id'); ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('machineProductOrder', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#MachineProductOrder_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($model, 'city_id'); ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('machineProductOrder', '选择地区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($model, 'district_id'); ?> 
            </td>
            <th>加盟商编号</th>
            <td>
                <?php echo $form->textField($model, 'fnum', array('class' => 'text-input-bj  middle', 'style' => 'width:150px')); ?>
            </td>
        </tr>
        <tr>
            
            <th><?php echo $form->label($model, 'consume_status')?>：</th>
            <td style="text-align: left;">
                    <?php 
                            echo $form->radioButtonList($model, 'consume_status', CMap::mergeArray(array(''=>Yii::t('machineProductOrder','全部')), MachineProductOrder::consumeStatus()), array('separator'=>''));
                    ?>
            </td>
            
            <th width="8%"><?php echo $form->label($model, 'consume_time'); ?>：</th>
            <td>
                <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'consume_time',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'text-input-bj  middle',
                                'style' => 'width:150px;'
                            )
                        ));
                    ?>
					&nbsp;-&nbsp;
					<?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'consume_end_time',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'text-input-bj  middle',
                                'style' => 'width:150px;'
                            )
                        ));
                    ?>
            </td>
        </tr>
        <tr>
            <th>订单状态</th>
            <td style="text-align: left;">
                    <?php 
                            echo $form->radioButtonList($model, 'status', CMap::mergeArray(array(''=>Yii::t('machineProductOrder','全部')), MachineProductOrder::status()), array('separator'=>''));
                    ?>
            </td>
            <th>订单价格 :</th>
            <td>
                <?php echo $form->textField($model, 'min_price', array('class' => 'text-input-bj  middle', 'style' => 'width:150px')); ?> -
                 <?php echo $form->textField($model, 'max_price', array('class' => 'text-input-bj  middle', 'style' => 'width:150px')); ?>
            </td>
        </tr>
        <tr>
            <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?></th>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>