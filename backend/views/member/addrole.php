<?php
/**
 * @var $this MemberController
 * @var $v MemberRole
 * @var $member Member
 */
$this->breadcrumbs = array(
    Yii::t('member', '会员管理 '),
    Yii::t('member', '添加角色')
);
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
$form = $this->beginWidget('CActiveForm');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-reg" id="tab1">
    <thead>
    <tr class="tab-reg-title">
        <th>
            <input type="checkbox" id="checkAll"/>
            <label for="cbx_all"><?php echo Yii::t('member','全选'); ?></label>
        </th>
        <th>
            <?php echo Yii::t('member','角色编码'); ?>
        </th>
        <th>
            <?php echo Yii::t('member','角色名称'); ?>
        </th>
        <th><?php echo Yii::t('member','角色头像'); ?></th>
        <th>
            <?php echo Yii::t('member','期限（天）'); ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($memberRoles as $v): ?>
    <tr>
        <td>
            <input type="checkbox" name="roleIds[]"   value="<?php echo $v->id ?>"/>
        </td>
        <td>
        <?php echo $v->code ?>
        </td>
        <td>
            <?php echo $v->name ?>
        </td>
        <td>
            <?php echo CHtml::image(ATTR_DOMAIN.'/'.$v->thumbnail) ?>
        </td>
        <td>
            <?php echo $v->deadline ?>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<div class="c10">
</div>
<?php echo CHtml::submitButton(Yii::t('member','确定'),array('class'=>'reg-sub','id'=>'btnOK')) ?>
<?php echo CHtml::button(Yii::t('member','取消'),array('class'=>'reg-sub','onclick'=>'art.dialog.close();')) ?>
<?php $this->endWidget(); ?>


<script>
    $("#checkAll").click(function(){
        if(this.checked){
            $(":input[name='roleIds[]']").attr("checked","checked");
        }else{
            $(":input[name='roleIds[]']").removeAttr("checked");
        }
    });
    if (typeof success!='undefined'){
        art.dialog.opener.location.reload();
        art.dialog.close();
    }
</script>
