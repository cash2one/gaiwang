<?php
$title = Yii::t('middleAgent', '商城居间管理');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('middleAgent', '商家列表') => array('list'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo $title ?></b>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
    <tr>
        <td>
           <span style="font-size: 20px,color:red">还未完成居间商升级的相关流程，请联系客服！</span>
        </td>
    </tr>
    </tbody>
</table>