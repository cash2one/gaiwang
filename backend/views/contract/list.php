<?php
    $action = $this->action->id == 'agency' ? 'create-agency' : 'create-regular-chain';
    $checkAction = $this->action->id == 'agency' ? 'createAgency' : 'createRegularChain';
    $updateAction = $this->action->id == 'agency' ? 'update-agency' : 'update-regular-chain';
    $checkUpdateAction = $this->action->id == 'agency' ? 'updateAgency' : 'updateRegularChain';
    $delAction = $this->action->id == 'agency' ? 'del-agency' : 'del-regular-chain';
    $checkDelAction = $this->action->id == 'agency' ? 'delAgency' : 'delRegularChain';
    if (Yii::app()->user->checkAccess('Contract.'.$checkAction)): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/contract/'.$action) ?>"><?php echo Yii::t('contract', '添加模板') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'contract-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'type',
            'value' => 'Contract::showType($data->type)',
        ),
        'version',
         array(
            'name' => 'is_current',
            'value' => 'Contract::getCurrent($data->is_current)',
        ),
         array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('contract', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('contract', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Contract.".$checkUpdateAction."')",
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    // 'url' => Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey));
                    'url' => 'Yii::app()->createUrl("Contract/'.$updateAction.'", array("id"=>$data->id))',
                ),
                'delete' => array(
                    'label' => Yii::t('contract', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Contract.".$checkDelAction."')",
                    'url' => 'Yii::app()->createUrl("Contract/'.$delAction.'", array("id"=>$data->id))',
                ),
            )
        )
    ),
));
?>

