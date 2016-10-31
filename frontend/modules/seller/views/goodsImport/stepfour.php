<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
   $this->breadcrumbs = array(
        Yii::t('goods','宝贝管理') => array('goods/index'),
        Yii::t('goods','导入成功')
   )
?>
<!--提交审核成功 -->
<div class="importData step4" id="export-step4">
    <div class="importData_toCheck">提交审核成功！</div>
    <div class="btn_box">
        <input class="sellerBtn06" type="submit" value="审核详情" onclick="window.location.href='<?php echo $this->createUrl('goods/index')?>'">
        <input class="sellerBtn08" type="button" value="继续导入" onclick="window.location.href='<?php echo $this->createUrl('goodsImport/index')?>'">
    </div>
</div>
