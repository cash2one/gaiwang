<?php
/**
 * @var $this MemberController
 * @var $v MemberToRole
 * @var $member Member
 */
$this->breadcrumbs = array(
    Yii::t('member', '会员管理 '),
    $member->gai_number . Yii::t('member', '的角色列表'));
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<input type="button" value="<?php echo Yii::t('member','添加角色'); ?>" class="regm-sub" onclick="addRole()"/>
<div class="c10">
</div>
<?php
$form = $this->beginWidget('CActiveForm',array())
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-reg" id="tab1">
    <tr class="tab-reg-title">
        <th>
            <input type="checkbox" id="checkAll" />
            <label for="cbx_all"><?php echo Yii::t('member','全选'); ?></label>
        </th>
        <th>
            <?php echo Yii::t('member','角色编码'); ?>
        </th>
        <th>
            <?php echo Yii::t('member','角色名称'); ?>
        </th>
        <th>
            <?php echo Yii::t('member','角色头像'); ?>
        </th>
        <th>
            <?php echo Yii::t('member','服务开始时间'); ?>
        </th>
        <th>
            <?php echo Yii::t('member','服务结束时间'); ?>
        </th>
    </tr>
    <?php foreach($roles as $v): ?>
    <tr>
        <td>
            <input type="checkbox" name="ids[]" value="<?php echo $v->id ?>" />
        </td>
        <td>
            <?php echo $v->MemberRole->code ?>
        </td>
        <td>
           <?php echo $v->MemberRole->name ?>
        </td>
        <td>
            <?php echo CHtml::image(ATTR_DOMAIN.'/'.$v->MemberRole->thumbnail) ?>
        </td>
        <td>
            <?php echo $this->format()->formatDatetime($v->service_start_time) ?>
        </td>
        <td>
            <span style="color:Green"><?php echo $this->format()->formatDatetime($v->service_end_time) ?></span>
        </td>
    </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="6">
            <input type="submit" class="regm-sub" value="<?php echo Yii::t('member','批量删除'); ?>"
                   onclick="return confirm('<?php echo Yii::t('member','确定批量删除吗？'); ?>')"/>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script>
    var addRole = function(){
       dialog =  art.dialog.open('<?php echo $this->createUrl('member/addRole',array('id'=>$member->id)) ?>',
           {width: '800px', height: '620px',lock:true});
    }
    $("#checkAll").click(function(){
        if(this.checked){
            $(":input[name='ids[]']").attr("checked","checked");
        }else{
            $(":input[name='ids[]']").removeAttr("checked");
        }
    });
</script>