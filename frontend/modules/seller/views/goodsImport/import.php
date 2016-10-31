<?php
$this->breadcrumbs = array(
    Yii::t('goods', '宝贝管理') => array('goods/index'),
    Yii::t('goods', '导入数据包')
);
?>
<script>
    var id = '#'+'<?php echo $this->id . '-form' ?>';
    setTimeout('$(id).submit()',1000);
</script>
<?php $form = $this->beginWidget('CActiveForm',array(
    'id'=>$this->id . '-form',
    'action'=>$this->createUrl("goodsImport/importFile"),
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
))?>
<div id="export-step2">
    <div class="importProgressBar">
        <div class="importProgress_step2"></div>
    </div>
<div style="margin:0 auto; margin-top:35px; margin-bottom:0; padding: 8px; padding-bottom:0; border: 1px solid #313131; background: #f3f3f3; width:1000px">   
    <div><font color="#313131"><span style="font-size:12px;"><?php echo Yii::t('goods','数据正在导入中，请您耐心等待')?></span></font></div>   
   <div style="padding: 0; background-color: white; border: 1px solid #F0332F; width:1000px;margin:5px 0;">   
       <div id="progress" style="padding: 0; background-color:#F0332F; border: 0; width: <?php echo number_format(($key-1)/$count*100,2) . "%"; ?>; text-align: center;  height: 16px"></div>   
   </div>   
   <div id="msg" style="font-size:12px;color:#313131;"><?php echo ($count >= $key) ? sprintf(Yii::t('goods','共%d条商品，正在导入第%d条,有%d条导入失败!请耐心等候!'), $count,$key,$fail) : Yii::t('goods','正在提交数据');?></div>
   <div id="percent" style="position: relative; top: -33px; text-align: center; font-weight: bold; font-size: 8pt;"><?php echo number_format(($key-1)/$count*100,2) . "%"; ?></div>  
</div>
</div>
<?php 
//    echo CHtml::hiddenField('sheet',$sheet);
    echo CHtml::hiddenField('count',$count);
    echo CHtml::hiddenField('key',$key);
    echo CHtml::hiddenField('post',$post);
    echo CHtml::hiddenField('fail',$fail);
//    echo CHtml::submitButton('submit');
?>
<?php $this->endWidget();?>

