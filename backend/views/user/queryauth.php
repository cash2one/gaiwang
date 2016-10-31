<?php $this->breadcrumbs = array(Yii::t('user', '管理员') => array('admin'), Yii::t('user', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#user-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>


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
                <th><label for="AuthItem_name">权限</label></th>
                <td><input class="text-input-bj  least" name="authName" id="AuthItem_name" type="text" maxlength="64"></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('user', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>


<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->authSearch(),
    // 'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('user', '用户名'),
            'value' => '$data->username'
        ),
        array(
            'name' => Yii::t('user', '权限'),
            'value' => '$data->assigments->role->authItemChild->child'
        ),
        array(
            'name' => Yii::t('user', '角色'),
            'value' => 'showRole($data->assigments->userid)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('user', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'url' => 'Yii::app()->createUrl("auth-item/update-role",array("name"=>$data->assigments->role->authItemChild->parent))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                )
            )
        )
    ),
));

function showRole($uid){
    static $roleArr;
    if(!$roleArr){
         $roleArr = AuthAssignment::model()->getAllGroupUid();
     }
    return isset($roleArr[$uid."_"]) ? str_replace(',', ' | ', $roleArr[$uid."_"]) : ""; 
}
?>