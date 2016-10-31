<?php
$this->breadcrumbs = array(
    Yii::t('franchiseegroupbuycategory', '请选择类目'),
);

?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id.'-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table class="tab-reg">
    <thead>
        <tr>
            <!--<th id="franchiseeBrand-grid_c0" class="button-column">&nbsp;</th>-->
            <th id="franchiseeBrand-grid_c1">
                <a href="/?r=franchiseegroupbuycategory/get-franchisee-groupbuy-category&amp;FranchiseeGroupbuyCategory_sort=name" class="sort-link">一级类目</a>
            </th>
            <th id="franchiseeBrand-grid_c2"><a href="/?r=franchiseegroupbuycategory/get-franchisee-groupbuy-category&amp;FranchiseeGroupbuyCategory_sort=parent_id" class="sort-link">二级类目</a>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
            <?php
            echo $form->dropDownList($model, 'id', FranchiseeGroupbuyCategory::getFranchiseeGroupbuyCategoryByParentId(FranchiseeGroupbuyCategory::ONE_PARENT_ID), array(
                'prompt' => Yii::t('franchiseeGroupbuyCategory', '选择一级类目'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/franchiseeGroupbuyCategory/UpdateGroupbuyCate'),
                    'dataType' => 'json',
                    'data' => array(
                        'parent_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#FranchiseeGroupbuyCategory_parent_id").html(data.dropDownCities);
                        }',
                ),
                'class' => 'text-input-bj long',
                )
            );
            ?>
            </td>
            <td style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
            <?php
            if ($model->isNewRecord) :
                echo $form->dropDownList($model, 'parent_id', array(), array('prompt' => Yii::t('franchiseeGroupbuyCategory', '选择二级类目'),'class' => 'text-input-bj long','onchange'=>"func(this)"));
            else :
                echo $form->dropDownList($model, 'parent_id', CHtml::listData(FranchiseeGroupbuyCategory::model()->findAll("parent_id=:pid", array(':pid' => $model->parent_id)), 'id', 'name'));
            endif;
            ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<div style="position: relative;top:270px;font-size: 20px;" >选好的类目：
    <span id="pCate"></span>/<span id="sCate"></span>
</div>

<a style="position: relative;top:270px;" class="reg-sub" onclick="btnOKClick()" title="选择" id="sid" data="">选择</a>
<script type="text/javascript">
    var btnOKClick = function() {
        var id=$("#sid").attr('data');
        if (!id) {
            alert(<?php echo Yii::t('franchiseegroupbuycategory', "请选择所属类目"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectCategory) {
            p.onSelectCategory(id);
        }
        art.dialog.close();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<script>
    $(document).ready(function(){
        $('#FranchiseeGroupbuyCategory_id').change(function(){
            var pid=$(this).children('option:selected').val();//一级类目的id
            var parentText=$(this).children('option:selected').text();//选中的一级类目名称
            $("#pCate").html(parentText);
        });
        $('#FranchiseeGroupbuyCategory_parent_id').change(function(){
            var sid=$(this).children('option:selected').val();//二级类目的id
            var text=$(this).children('option:selected').text();//二级类目的名称
            $("#sCate").html(text);
            $("#sid").attr('data',sid);
        });
    })
</script>





