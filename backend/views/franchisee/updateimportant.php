<?php
/* @var $this FranchiseeController */
/* @var $model Franchisee */
/* @var $form CActiveForm */
$this->breadcrumbs = array(Yii::t('franchisee', '加盟商') => array('admin'), Yii::t('franchisee', '重要信息编辑'));
?>
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
    <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('franchisee', '重要信息编辑'); ?></th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'parent_id'); ?></th>
            <td>
                <?php echo $form->hiddenField($model, 'parent_id', array('value' => $model->parent_id ? $model->parent_id : '')); ?>
                <?php echo CHtml::textField('parentName', $model->parentName ? $model->parentName : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '选择'), array('class' => 'reg-sub', 'id' => 'SetBizPMember')); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '清除'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'ReSetBizPMember')); ?>
                <script>
                    $("#ReSetBizPMember").click(function() {
                        $("#Franchisee_parent_id").val('');
                        $("#parentName").val('');
                    });
                </script>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'password'); ?></th>
            <td>
                <?php echo $form->passwordField($model, 'password', array('class' => 'text-input-bj  middle')); ?>
                <?php
                if (!$model->isNewRecord) :
                    echo "<font color = 'red'>密码为空则不修改原有密码!</font>";
                endif;
                ?>
                <?php echo $form->error($model, 'password'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'confirmPassword'); ?></th>
            <td>
                <?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'confirmPassword'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'alias_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'alias_name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'alias_name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'member_id'); ?></th>
            <td>
                <?php echo $form->hiddenField($model, 'member_id', array('value' => $model->member_id ? $model->member_id : '')); ?>
                <?php echo CHtml::textField('memberName', $model->member->username ? $model->member->username : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
                <?php echo $form->error($model, 'member_id'); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '选择'), array('class' => 'reg-sub','id' => 'SetRefMember')); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '清除'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'ReSetRefMember')); ?>
                <script>
                    $("#ReSetRefMember").click(function() {
                        $("#Franchisee_member_id").val('');
                        $("#memberName").val('');
                    });
                </script>                
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'gai_discount'); ?></th>
            <td>
                <?php echo $form->textField($model, 'gai_discount', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'gai_discount'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'member_discount'); ?></th>
            <td>
                <?php echo $form->textField($model, 'member_discount', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'member_discount'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'is_recommend'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'is_recommend', Franchisee::getRecommend(), array('class' => 'text-input-bj')); ?>
                <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'is_recommend'); ?> 
                </div>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'max_machine'); ?></th>
            <td>
                <?php echo $form->textField($model, 'max_machine', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'max_machine'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><label class="required"><?php echo Yii::t('franchisee', '地区'); ?> <span class="required">*</span></label></th>
          <td>
           <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'district_id'); ?> 
                    <?php echo $form->error($model, 'city_id'); ?>
                    <?php echo $form->error($model, 'province_id'); ?>
                </div>
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('franchisee', '选择省份'),
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
                            $("#Franchisee_city_id").html(data.dropDownCities);
                            $("#Franchisee_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('franchisee', '选择城市'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#Franchisee_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('franchisee', '选择地区'),
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
        <tr>
            <th><?php echo $form->labelEx($model, 'street'); ?></th>
            <td>
                <?php echo $form->textField($model, 'street', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'street'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('franchisee', '经纬度'); ?></th>
            <td>
                <?php echo $form->labelEx($model, 'lat'); ?>
                <?php echo $form->textField($model, 'lat', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'lat'); ?>
                <?php echo $form->labelEx($model, 'lng'); ?>
                <?php echo $form->textField($model, 'lng', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'lng'); ?>
                <?php echo CHtml::button('选择经纬度', array('class' => 'regm-sub', 'onclick' => 'markClick()')); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'auto_check'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'auto_check', Franchisee::getAutoCheck(), array('class' => 'text-input-bj')); ?>
                <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'auto_check'); ?> 
                </div>
            </td>
        </tr>
        
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('franchisee', '编辑'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
                    var markClick = function() {
                        var url = '<?php echo $this->createAbsoluteUrl('/map/show') ?>';
                        url += '&lng=' + $('#Franchisee_lng').val() + '&lat=' + $('#Franchisee_lat').val();
                        dialog = art.dialog.open(url, {
                            'title': '设定经纬度',
                            'lock': true,
                            'window': 'top',
                            'width': 740,
                            'height': 670,
                            'border': true
                        });
                    };
                    var onSelected = function(lat, lng) {
                        $('#Franchisee_lng').val(lng);
                        $('#Franchisee_lat').val(lat);
                    };
                    var doClose = function() {
                        if (null != dialog) {
                            dialog.close();
                        }
                    };
</script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    //搜索父加盟商
    $('#SetBizPMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchisee/getParentFranchisee') . "', {'id': 'selectmember', title: '搜索父加盟商', width: '800px', height: '620px', lock: true});
    })
    $('#SetRefMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser', array('isc' => Member::ENTERPRISE_YES)) . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
    $('#SetBizBrand').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchiseeBrand/getFranchiseeBrandAll') . "', {'id': 'selectmember', title: '搜索加盟商品牌', width: '800px', height: '620px', lock: true});
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
var onSelectBizBrand = function(id,name) {
    if (id) {
        $('#Franchisee_franchisee_brand_id').val(id);
                $('#name').val(name);
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

