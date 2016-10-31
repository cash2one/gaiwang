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
        <tr> <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('franchisee', '添加加盟商'); ?></th></tr>
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
                <?php echo CHtml::textField('memberName', $model->memberName ? $model->memberName : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '选择'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'SetRefMember')); ?>
                <?php echo $form->error($model, 'member_id'); ?>
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
            <th><?php echo $form->labelEx($model, 'summary'); ?></th>
            <td>
                <?php echo $form->textField($model, 'summary', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'summary'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'franchisee_brand_id'); ?></th>
            <td>
                <?php echo $form->hiddenField($model, 'franchisee_brand_id', array('value' => $model->franchisee_brand_id ? $model->franchisee_brand_id : '')); ?>
                <?php echo CHtml::textField('name', $model->franchisee_brand_id ? FranchiseeBrand::getFranchiseeBrandName($model->franchisee_brand_id) : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
                <?php echo $form->error($model, 'franchisee_brand_id'); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '选择'), array('class' => 'reg-sub', 'id' => 'SetBizBrand')); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '清除'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'ReSetBizBrand')); ?>
                <script>
                    $("#ReSetBizBrand").click(function() {
                        $("#Franchisee_franchisee_brand_id").val('');
                        $("#name").val('');
                    });
                </script>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'main_course'); ?></th>
            <td>
                <?php echo $form->textField($model, 'main_course', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'main_course'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'categoryId'); ?></th>
            <td>
                <?php $categoryData = FranchiseeCategory::model()->findAll(); ?>
                <?php foreach ($categoryData as $v): ?>
                    <input type="checkbox" name="Franchisee[categoryId][]" value="<?php echo $v->id; ?>" <?php if (in_array($v->id, Franchisee::findCategoryId($model->id))): ?> checked="true" <?php endif; ?>/> <?php echo $v->name; ?>
                <?php endforeach; ?>
                <?php echo $form->error($model, 'categoryId'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'status'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'status', Franchisee::getStatus(), array('class' => 'text-input-bj', 'prompt' => '请选择')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
            <td>
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'qq'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'qq', array('class' => 'text-input-bj long valid')); ?>
                <span>以逗号分隔，如30994,349850,93802385 </span>
                <?php echo $form->error($model, 'qq'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'url'); ?></th>
            <td>
                <?php echo $form->textField($model, 'url', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'url'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'fax'); ?></th>
            <td>
                <?php echo $form->textField($model, 'fax', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'fax'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'zip_code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'zip_code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'zip_code'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'tags'); ?></th>
            <td>
                <?php echo $form->textField($model, 'tags', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'tags'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'notice'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'notice', array('class' => 'text-input-bj  text-area')); ?>
                <?php echo $form->error($model, 'notice'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'featured_content'); ?></th>
            <td  id="featured_contend_td"> 
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'featured_content',
                ));
                ?>
                <?php echo $form->error($model, 'featured_content'); ?>
                <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#featured_contend_td").mouseout(function() {
                        //var str = $(window.frames["baidu_editor_0"].document).find('body').find('p').html();
                        var str = $("#baidu_editor_0").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#Franchisee_featured_content").html(str);
                        $("#Franchisee_featured_content").blur();

                    });
                </script>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'description'); ?></th>
            <td  id="contend_td"> 
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'description',
                ));
                ?>
                <?php echo $form->error($model, 'description'); ?>
                <div style="padding:15px"></div>
                <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#contend_td").mouseout(function() {
                        //var str = $(window.frames["baidu_editor_0"].document).find('body').find('p').html();
                        var str = $("#baidu_editor_1").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#Franchisee_description").html(str);
                        $("#Franchisee_description").blur();

                    });
                </script>
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('franchisee', '创建'), array('class' => 'reg-sub')); ?></td>
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

