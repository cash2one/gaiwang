<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $form CActiveForm */
?>
<div class="border-info search-form clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'username') ?></th>
            <td><?php echo $form->textField($model, 'username', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'gai_number') ?></th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'mobile') ?></th>
            <td><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'type_id') ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'type_id', CHtml::listData(MemberType:: model()->findAll(), 'id', 'name'), array('empty' => Yii::t('member', '全部'), 'class' => 'text-input-bj')); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii::t('member', '所在地区'); ?></th>
            <td>
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region:: PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('member', '选择省份'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Member_city_id").html(data.dropDownCities);
                            $("#Member_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php echo $form->error($model, 'province_id'); ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('member', '选择城市'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#Member_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($model, 'city_id'); ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('member', '选择地区'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'register_type') ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'register_type', $model::registerType(), array('empty' => '全部', 'separator' => '')); ?>
            </td>
            <th><?php echo $form->label($model, 'enterprise_id') ?></th>
            <td><?php echo $form->textField($model, 'enterprise_id', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii:: t('member', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>

<?php if (Yii::app()->user->checkAccess('Enterprise.Create')): ?>
    <?php echo CHtml::link('添加企业会员',array('enterprise/create'), array('class' => 'regm-sub', 'id' => 'enterpriseMemberCreate')); ?>
<?php endif; ?>
<div class="c10"></div>