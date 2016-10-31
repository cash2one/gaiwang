<?php
$this->breadcrumbs = array(
    Yii::t('commonAccountAgentDist', '代理管理'),
    Yii::t('commonAccountAgentDist', '代理公共账户列表'),
);
?>
<div class="border-info clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'common-account-agent-dist-form',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td>
                <?php echo $form->label($model, 'name'); ?>：
            </td>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('home', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'common-account-agent-dist-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('commonAccount', '账户名称'),
            'value' => '$data->name'
        ),
        array(
            'name' => 'city_id',
            'value' => '$data->dis->name'
        ),
        array(
            'name' => 'cash',
            'value' => 'CommonAccount::showMoney($data)',
            'type' => 'raw'
        ),
        array(
            'name' => Yii::t('home', '操作'),
            'type' => 'raw',
            'value' => 'CommonAccount::createButton($data->id)',
        ),
    ),
));
?>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>
