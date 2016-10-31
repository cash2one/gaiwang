<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <caption class=" title-th">
        <?php echo $model->isNewRecord ? Yii::t('franchisee', '新增加盟商') : Yii::t('franchisee', '加盟商编辑'); ?>
    </caption>
    <tbody>
    
        
       <tr>
            <th class="even"><?php echo $form->labelEx($model, 'logo'); ?></th>
            <td class="even">
            
                <?php echo CHtml::activeFileField($model, 'logo'); ?> 
                <?php // echo CHtml::button('重置', array('class' => 'reg-sub'));  ?>
                <span>请上传340X170像素的图片</span>
                <?php echo $form->error($model, 'logo'); ?>
                <?php
                if (!$model->isNewRecord) {
                    echo CHtml::hiddenField('oldLogo', $model->logo);
                    echo "<br>";
                    echo CHtml::image(ATTR_DOMAIN . '/' . $model->logo, $model->name, array('width' => '160px', 'height' => '80px'));
                }
                ?>
            </td>
        </tr>
        
         <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'logo2'); ?></th>
            <td class="odd">
            
                <?php echo CHtml::activeFileField($model, 'logo2'); ?> 
                <?php // echo CHtml::button('重置', array('class' => 'reg-sub'));  ?>
                <span>请上传170X170像素的图片</span>
                <?php echo $form->error($model, 'logo2'); ?>
                <?php
                if (!$model->isNewRecord) {
                    echo CHtml::hiddenField('oldLogo2', $model->logo2);
                    echo "<br>";
                    echo CHtml::image(ATTR_DOMAIN . '/' . $model->logo2, $model->name, array('width' => '85px', 'height' => '85px'));
                }
                ?>
            </td>
        </tr>
        
        
        <tr>
            <th class="even">
                图片列表：
            </th>
            <td class="even">
            <span>请上传200X200像素的图片，最多可上传20张</span>
            	<?php 
            		$this->widget('common.widgets.CUploadPic',array(
            			'form' => $form,
            			'model' => $model,
            			'attribute' => 'path',
            			'num' => 30,
            			'upload_height' => 200,
            			'upload_width' => 200,
            			'folder_name' => 'files',
            		));
            	?>
            	
            	
            </td>
        </tr>
        
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'thumbnail'); ?></th>
            <td class="odd">
            
                <?php echo CHtml::activeFileField($model, 'thumbnail'); ?> 
                <?php // echo CHtml::button('重置', array('class' => 'reg-sub'));  ?>
                <span>请上传1200X400像素的图片</span>
                <?php echo $form->error($model, 'thumbnail'); ?>
                <?php
                if (!$model->isNewRecord) {
                    echo CHtml::hiddenField('oldThumbnail', $model->thumbnail);
                    echo "<br>";
                    echo CHtml::image(ATTR_DOMAIN . '/' . $model->thumbnail, $model->name, array('width' => '300px', 'height' => '100px'));
                }
                ?>
            </td>
        </tr>
        
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'status'); ?></th>
            <td class="odd">
                <?php echo $form->dropDownList($model, 'status',Franchisee::getStatus(), array('class' => 'text-input-bj', 'prompt' => '请选择')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        
        <tr>
            <th class="even"></th>
            <td id="gilid" class="even"></td>
        </tr>
        
        <tr>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchisee', '新增') : Yii::t('franchisee', '保存'), array('class' => 'reg-sub')); ?>
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
    //搜索父加盟商
    $('#SetBizPMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchisee/getParentFranchisee') . "', {'id': 'selectmember', title: '搜索父加盟商', width: '800px', height: '620px', lock: true});
    })
    $('#SetRefMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser',array('isc'=>Member::ENTERPRISE_YES)) . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})

var onSelectBizPMember = function(pid) {
    if (pid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/franchisee/getParentName') . "&id='+pid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Franchisee_parent_id').val(pid);
                $('#parentName').val(name);
            }
        })
    }
};
var onSelectMemeber = function (uid) {  
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/member/getUserName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Franchisee_member_id').val(uid);
                $('#memberName').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>

