<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'name'); ?></th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th>
                <th><?php echo $form->label($model, 'countries_id'); ?>：</th>
                </th>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'countries_id', CHtml::listData(Region::model()->findAll("parent_id = :pid", array(':pid' => 0)), 'id', 'name'), array(
                        'class' => 'text-input-bj',
                        'prompt' => Yii::t('hotelAddress', '国家'),
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/region/updateProvince'),
                            'dataType' => 'json',
                            'data' => array(
                                'countries_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
                            $("#HotelAddress_province_id").html(data.dropDownProvinces);
                            $("#HotelAddress_city_id").html(data.dropDownCities);
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
                <th><?php echo $form->label($model, 'province_id'); ?>：</th>
                <td><?php
                    echo $form->dropDownList($model, 'province_id', array(), array(
                        'empty' => '全部', 'separator' => '', 'class' => 'text-input-bj  middle',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/region/updateCity'),
                            'dataType' => 'json',
                            'data' => array(
                                'province_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
                                $("#HotelAddress_city_id").html(data.dropDownCities);
                            }',
                    )));
                    ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'city_id'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'city_id', array(), array('empty' => '全部', 'separator' => '', 'class' => 'text-input-bj  middle')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th></th>
                <td><?php echo CHtml::submitButton('搜索', array('class' => 'regm-sub')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>