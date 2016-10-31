<style type ="text/css">
    .searchTables{ float: left; height: 20px; width: 160px; margin-right: 10px;}
</style>
<div class="border-info clearfix search-form">
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th>商品ID</th>
            <td><input type="text" name="goods_id" class="searchTables" value="<?php echo Yii::app()->request->getParam('goods_id')?>"> </td>
            <th>所属活动</th>
            <td><input type="text" name="rules_name" class="searchTables" value="<?php echo Yii::app()->request->getParam('rules_name')?>"></td>
            <td><input type="submit" value="搜索" class="reg-sub"></td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>

</div>