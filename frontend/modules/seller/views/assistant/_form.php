<?php
/* @var $this AssistantController */
/* @var $model Assistant */
/* @var $form CActiveForm */
if ($model->isNewRecord) {
    $model->sex = $model::SEX_MALE;
    $model->status = $model::STATUS_NO;
}
?>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerAssistant', '基本信息'); ?></h3>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'username'); ?></th>
        <td width="90%">
            <?php echo $form->textField($model, 'username', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'password'); ?></th>
        <td>
            <?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt1', 'style' => 'width:300px', 'value' => '')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'confirmPassword'); ?></th>
        <td>
            <?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
            <?php echo $form->error($model, 'confirmPassword'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'avatar'); ?></th>
        <td>
            <p>
                <?php echo $form->fileField($model, 'avatar') ?>&nbsp;&nbsp;
                <span class="gray"><?php echo Yii::t('sellerAssistant', '请上传128*128像素的图片'); ?></span>
            </p>
            <?php echo $form->error($model, 'error') ?>
            <?php if (!empty($model->avatar)): ?>
                <p class="mt10">
                    <img src="<?php echo ATTR_DOMAIN . '/' . $model->avatar ?>" width="128" height="128"/>
                </p>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'real_name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'real_name', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
            <?php echo $form->error($model, 'real_name'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'sex'); ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'sex', $model::sex(), array('separator' => ' ')) ?>
            <?php echo $form->error($model, 'sex') ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
        <td>
            <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
            <?php echo $form->error($model, 'mobile'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'email'); ?></th>
        <td>
            <?php echo $form->textField($model, 'email', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'status'); ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'status', $model::status(), array('separator' => ' ')) ?>
            <?php echo $form->error($model, 'status') ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'description'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'description', array('class' => 'textareaTxt1', 'style' => 'width:80%; height:80px;')) ?>
            <?php echo $form->error($model, 'description') ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'sort'); ?></th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'inputtxt1', 'style' => 'width:160px')); ?>
            <?php echo $form->error($model, 'sort'); ?>

        </td>
    </tr>
    <?php if (!$model->isNewRecord): ?>
        <tr>
            <th><?php echo $form->labelEx($model, 'logins'); ?></th>
            <td>
                <?php echo $model->logins ?>
            </td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>

<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerAssistant', '权限设定'); ?></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
    <tr>
        <th width="10%"><?php echo Yii::t('sellerAssistant', '一级菜单'); ?></th>
        <td width="90%"><?php echo Yii::t('sellerAssistant', '二级菜单（页面）'); ?></td>
    </tr>
    <tr>
        <th><input type="checkbox" id="checkAll"/>&nbsp;<?php echo Yii::t('sellerAssistant', '基本信息'); ?><?php echo Yii::t('sellerAssistant', '全选'); ?></th>
        <td></td>
    </tr>
    <?php
    $menus = include(Yii::getPathOfAlias('application') . DS . 'config' . DS . 'sellerMenu.php');
    unset($menus['assistantInfo']);
    if (!$this->getSession('franchiseeId')) {
        unset($menus['bizManage']);
    }
    ?>
    <?php foreach ($menus as $k => $v): ?>
        <tr>
            <th>
                <input type="checkbox"
                       name="item[]" <?php echo $this->checkPermission($permissions, $k) ? 'checked' : '' ?>
                       class="item firstItem" value="<?php echo $k ?>"/>
                <?php echo $v['name'] ?>
            </th>
            <td>
                <?php if ($k == 'bizManage'):  //如果是加盟商，分别列出?>
                    <?php $this->renderPartial('_bizcheckbox', array(
                        'permissions'=>$permissions,
                        'franchisee'=>$franchisee,
                        'items'=>$v['children'],
                    )); ?>
                <?php else: ?>
                    <?php foreach ($v['children'] as $item => $val): ?>
                        <span>
                    <?php $valChild = is_array($val) ? $val['value'] : $val ?>
                            <input type="checkbox"
                                   name="item[]" <?php echo $this->checkPermission($permissions, $valChild) ? 'checked' : '' ?>
                                   class="item secondItem" value="<?php echo $valChild ?>">
                    <b><?php echo $item ?></b>
                            <?php if (isset($val['actions']) && is_array($val['actions'])): ?>
                                {
                                <?php foreach ($val['actions'] as $action => $name): ?>
                                    <input type="checkbox"
                                           name="item[]" <?php echo $this->checkPermission($permissions, $action) ? 'checked' : '' ?>
                                           class="item" value="<?php echo $action ?>"/>
                                    <?php echo $name ?>
                                <?php endforeach; ?>
                                }
                            <?php endif; ?>
                    </span>
                        <br/>
                    <?php endforeach; ?>
                <?php endif; ?>


            </td>
        </tr>

    <?php endforeach; ?>


    </tbody>
</table>
<div class="profileDo mt15">
    <a href="#" class="sellerBtn03 submitBt"><span><?php echo Yii::t('sellerAssistant', '保存'); ?></span></a>&nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('assistant/admin') ?>" class="sellerBtn01">
        <span><?php echo Yii::t('sellerAssistant', '返回'); ?></span>
    </a>
</div>
<?php $this->endWidget(); ?>

<script>
    $(".submitBt").click(function () {
        $("form").submit();
    });
    //全选
    $("#checkAll").click(function () {
        if (this.checked) {
            $(".item").attr("checked", "checked");
        } else {
            $(".item").removeAttr('checked');
        }
    });
    //一级菜单全选
    $(".firstItem").click(function () {
        var $childrenItem = $(this).parent().siblings().children().find('input');
        if (this.checked) {
            $childrenItem.attr('checked', 'checked');
        } else {
            $childrenItem.removeAttr('checked');
        }
    });
    //二级菜单全选
    $(".secondItem").click(function () {
        var $childrenItem = $(this).parent().children();
        if (this.checked) {
            $childrenItem.attr('checked', 'checked');
        } else {
            $childrenItem.removeAttr('checked');
        }
    });

    $(".franchisee_name").each(function(){
        if($(this).parent().siblings().children().find('input:checked').length>0){
            $(this).attr("checked","checked");
        }
    });

</script>