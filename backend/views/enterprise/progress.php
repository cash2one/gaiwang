<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '列表'));

?>

<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>

<!--弹窗 begin-->
<div class="sellerWebSignProgress">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg4">
        <tbody>
        <tr>
            <th width="10%" class="bgOrange">时间</th>
            <th width="10%" class="bgOrange">操作人</th>
            <th width="90%" class="bgOrange">事件</th>
        </tr>

        <?php foreach ($enterpriseLog as $v): ?>
          <?php if($v->is_remarts){ ?>
            <tr>
                <td style='color: #007C00' class="ta_c"><?php echo $this->format()->formatDatetime($v->create_time); ?></td>
                <td style='color: #007C00'><?php echo $v->auditor ?></td>
                <td class="ta_l" style='color:#007C00'><?php echo $v->content; ?></td>
            </tr>
          <?php }else{ ?>
             <tr>
                <td class="ta_c"><?php echo $this->format()->formatDatetime($v->create_time); ?></td>
                <td ><?php echo $v->auditor ?></td>
                <td class="ta_l"><?php echo $v->content; ?></td>
            </tr>
          <?php }?>
            
        <?php endforeach; ?>


        </tbody>
    </table>
</div>
<!--弹窗 end-->
				   
