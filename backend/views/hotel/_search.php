<?php
/**
 *  @var HotelController $this
 *  @var Hotel $model
 *  @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'name'); ?>：</th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'brand_id'); ?>：</th>
                <?php $brands = CHtml::listData(HotelBrand::model()->findAll(), 'id', 'name'); ?>
                <td><?php echo $form->dropDownList($model, 'brand_id', $brands, array('empty' => '全部', 'class' => 'text-input-bj  middle')); ?></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'level_id'); ?>：</th>
                <td><?php echo $form->dropDownList($model, 'level_id', CHtml::listData(HotelLevel::model()->findAll(), 'id', 'name'), array('empty' => '全部', 'class' => 'text-input-bj  middle')); ?></td>
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
                        'prompt' => Yii::t('hotel', '国家'),
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/region/updateProvince'),
                            'dataType' => 'json',
                            'data' => array(
                                'countries_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
                            $("#Hotel_province_id").html(data.dropDownProvinces);
                            $("#Hotel_city_id").html(data.dropDownCities);
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
                                $("#Hotel_city_id").html(data.dropDownCities);
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
    <div class="c10"></div>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'status'); ?>：</th>
                <td><?php echo $form->radioButtonList($model, 'status', Hotel::getStatus(), array('empty' => '全部', 'separator' => '')); ?></td>
                <td><?php echo CHtml::submitButton(Yii::t('hotel', '搜索'), array('class' => 'regm-sub')); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>