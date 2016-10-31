<?php
$_class = get_class($model);
echo $form->dropDownList($model, 'depthZero', AppHotCategory::getChildCategory(), array(
    'prompt' => Yii::t('AppHotCategory','选择顶级分类'),
    'ajax' => array(
        'type' => 'POST',
        'url' => $this->createUrl('appHotCategory/depthCategory'),
        'dataType' => 'json',
        'data' => array(
            'pid' => 'js:this.value',
            'type' => 'depthOne',
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ),
        'success' => 'function(data) {
			$("#AppHotCategory_depthOne").html(data.dropDownCategory);
			$("#AppHotCategory_depthTwo").html(data.dropDownCounties);
		}',
    )));
?>
<?php
$depthOne_data = ($model->depthZero)?AppHotCategory::getChildCategory($model->depthZero):array();
echo $form->dropDownList($model, 'depthOne', $depthOne_data, array(
    'prompt' => Yii::t('AppHotCategory','选择二级分类'),
    'ajax' => array(
        'type' => 'POST',
        'url' => $this->createUrl('appHotCategory/depthCategory'),
        'dataType' => 'json',
        'data' => array(
            'pid' => 'js:this.value',
            'type' => 'depthTwo',
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ),
        'success' => 'function(data) {
			$("#AppHotCategory_depthTwo").html(data.dropDownCategory);
		}',
    )));
?>
<?php
$depthTwo_data = ($model->depthOne)?AppHotCategory::getChildCategory($model->depthOne):array();
echo $form->dropDownList($model, 'depthTwo', $depthTwo_data, array(
    'prompt' => Yii::t('AppHotCategory','选择三级分类'),
));
?>