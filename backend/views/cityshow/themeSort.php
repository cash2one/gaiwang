<?php
/* @var $this CityshowController */
/* @var $model CityshowTheme */
/** @var $form  CActiveForm */
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<!doctype html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8">
</head>
<style type="text/css">
    .reg-sub {
        background-image: url("/images/sub.gif");
        border: 0 none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: "微软雅黑";
        font-size: 14px;
        height: 27px;
        line-height: 27px;
        text-align: center;
        width: 55px;
    }
    table td{
        padding:10px;
    }
</style>
<body>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cityshow-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table>
    <tr>
        <td>
            主题名称:
        </td>
        <td><?php echo $model->name ?></td>
    </tr>
    <tr>
        <td>
            请选择排序号<br/>
            （正序排列）
        </td>
        <td >
            <?php
            $array = range(0,CityshowTheme::model()->countByAttributes(array("cityshow_id"=>$model->cityshow_id)));
            echo $form->dropDownList($model,'sort',array_combine($array,$array));
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::submitButton('确定',array('class'=>'reg-sub')) ?></td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<script type="text/javascript" src="/js/swf/js/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/js/iframeTools.js"></script>
<script>
    if (typeof success != 'undefined') {
        parent.jQuery.fn.yiiGridView.update('cityshowTheme-grid');
        art.dialog.close();
    }
</script>
</body>
</html>

