<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $bankModel BankAccount */
/* @var $form CActiveForm */
//会员推荐者
if(!empty($model->referrals_id)){
   $referral = Yii::app()->db->createCommand()
       ->select('gai_number,username')
       ->from('{{member}}')
       ->where('id=:id',array(':id'=>$model->referrals_id))
       ->queryRow();
}
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        
        <tr>
            <td colspan="2" class="title-th" align="center">
                <?php echo Yii::t('member','推荐人信息'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center">
                <?php echo Yii::t('member','推荐人'); ?>：
            </th>
            <td>
                <?php echo $form->hiddenField($model,'referrals_id') ?>
                <input class="text-input-bj  middle" id="RefMemberUsername" name="RefMemberUsername"
                       readonly="readonly" type="text" value="<?php echo  isset($referral) ? !empty($referral['username']) ? $referral['username']:$referral['gai_number'] : ''?>" />
                <input type="button" value="<?php echo Yii::t('member','搜索'); ?>" id="seachRefMem"  class="reg-sub" />
                <input type="button" value="<?php echo Yii::t('member','清空'); ?>" id="clearRefMem"  class="reg-sub" />
                <?php echo $form->error($model,'referrals_id') ?>
                
                <script type="text/javascript">
                	$("#clearRefMem").click(function(){
						$("#RefMemberUsername").val('');
						$("#Member_referrals_id").val('');
                        });
                </script>
                
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton('提交',array('class'=>'reg-sub')) ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    $('#seachRefMem').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser') . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})
 var doClose = function() {
                if (null != dialog) {
                    dialog.close();
                }
            };
 var onSelectBizPMember = function(pid) {};
var onSelectMemeber = function (uid) {
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/member/getUserName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Member_referrals_id').val(uid);
                $('#RefMemberUsername').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>