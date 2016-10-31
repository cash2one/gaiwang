<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'chn_name'); ?>：</th>
                <td><?php echo $form->textField($model, 'chn_name', array('class' => 'text-input-bj  middle')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'sale_state'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'sale_state', Hotel::getSaleState(), array('empty' => '全部', 'class' => 'text-input-bj')); ?></td>
            </tr>
        </tbody>
    </table>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th>
                    <th><?php echo $form->label($model, 'nation_id'); ?>：</th>
                </th>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'nation_id', CHtml::listData(Nation::model()->findAll(), 'id', 'name'), array(
                        'class' => 'text-input-bj',
                        'prompt' => Yii::t('hotel', '选择国家'),
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('province/ajaxGetProvince'),
                            'dataType' => 'json',
                            'data' => array(
                                'nation_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
                            $("#Hotel_province_code").html(data.dropDownProvinces);
                        }'
                        )
                    ));
                    ?>
                </td>
            </tr>  
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'province_code'); ?>：</th>
                <td><?php
                    echo $form->dropDownList($model, 'province_code', array(), array(
                        'empty' => '全部', 'separator' => '', 'class' => 'text-input-bj',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('city/ajaxGetCity'),
                            'dataType' => 'json',
                            'data' => array(
                                'province_code' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
                                $("#Hotel_city_code").html(data.dropDownCities);
                            }',
                    )));
                    ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'city_code'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'city_code', array(), array('empty' => '全部', 'separator' => '', 'class' => 'text-input-bj')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'source'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'source', Hotel::getSource(), array('empty' => '全部', 'separator' => '', 'class' => 'text-input-bj')); ?></td>
        </tr>
        </tbody>
    </table>


    <div class="row buttons">
        <td><?php echo CHtml::submitButton(Yii::t('hotel', '搜索'), array('class' => 'regm-sub')); ?></td>
    </div>
    <div class="c10"></div>
</div>
<?php $this->endWidget(); ?>