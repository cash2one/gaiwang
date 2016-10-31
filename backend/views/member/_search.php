<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="border-info clearfix">
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
<!--    现在会员余额已经是放到gw_account_balance、gw_account_balance_history-->
<!--    <table cellpadding="0" cellspacing="0" class="searchTable">-->
<!--        <tr>-->
<!--            <th>--><?php //echo Yii::t('member', '消费金额') ?><!--</th>-->
<!--            <td>-->
<!--                --><?php //echo CHtml::textField('Member[min_cash]', isset($_GET['Member']['min_cash'])?$_GET['Member']['min_cash']:'', array('class' => 'text-input-bj  least')); ?>
<!--                --><?php //echo Yii::t('member', '到'); ?>
<!--                --><?php //echo CHtml::textField('Member[max_cash]', isset($_GET['Member']['max_cash'])?$_GET['Member']['max_cash']:'', array('class' => 'text-input-bj  least')); ?>
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'type_id') ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'type_id', CHtml::listData(MemberType::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('member', '全部'), 'class' => 'text-input-bj')); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th> <?php echo Yii::t('member', '是否无主'); ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'hasReferrals', array('true' => Yii::t('member', '是'), 'false' => Yii::t('member', '否')), array('empty' => Yii::t('member', '全部'), 'separator' => '')) ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th> <?php echo $form->label($model, 'is_internal') ?></th>
            <td> <?php echo $form->radioButtonList($model, 'is_internal', $model::internal(), array('empty' => Yii::t('member', '全部'), 'separator' => '')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th> <?php echo Yii::t('member', '所在地区'); ?></th>
            <td>
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
            <td><?php echo $form->radioButtonList($model, 'register_type', $model::registerType(), array('empty' => '全部', 'separator' => '')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::hiddenField('auditing', Yii::app()->request->getParam('auditing')); ?>
    <?php echo CHtml::submitButton(Yii::t('member', '搜索'), array('class' => 'reg-sub')); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php if (Yii::app()->user->checkAccess('Member.Create')): ?>
    <?php echo CHtml::button('添加普通会员', array('class' => 'regm-sub', 'onclick' => 'location.href = \'' . Yii::app()->createUrl('member/create') . "'")); ?>
<?php endif; ?>

<?php if (Yii::app()->user->checkAccess('Member.EnterpriseMemberCreate')): ?>
    <?php echo CHtml::button('生成企业会员', array('class' => 'regm-sub', 'style' => '', 'id' => 'enterpriseMemberCreate')); ?>
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('Member.BatchCreateList')): ?>
    <?php echo CHtml::button('生成普通会员', array('class' => 'regm-sub', 'style' => 'width：100', 'id' => 'BatchCreateList')); ?>
<?php endif; ?>
<script type="text/javascript" >
    var dialog = null;
    $('#enterpriseMemberCreate').click(function() {
        dialog = art.dialog.open('<?php echo $this->createUrl("/member/createEnterpriseMember") ?>', {'id': 'createEnterpriseMember', title: '生成企业会员', width: '800px', height: '620px', lock: true});
    })
    var doClose = function() {
        if (null != dialog) {
            dialog.close();
        }
    };
</script>
<script type="text/javascript" >
    var dialog = null;
    $('#BatchCreateList').click(function() {
        dialog = art.dialog.open('<?php echo $this->createUrl("/member/BatchCreateList") ?>', {'id': 'BatchCreateList', title: '生成普通会员', width: '1000px', height: '620px', lock: true});
    })
    var doClose = function() {
        if (null != dialog) {
            dialog.close();
        }
    };
</script>
<div class="c10"></div>