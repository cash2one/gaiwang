<?php

/**
 * @var ViewSpotController $this
 * @var ViewSpot $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0" id="tab">
       <tr><th class="title-th even" colspan="2" style="text-align: left;">景点</th></tr>
    <tr>
        <th width="120px">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj ','Placeholder'=>'请输入中文名称')); ?>
            <?php echo $form->textField($model,'name_en',array('class'=>'text-input-bj ','Placeholder'=>'请输入英文名称'));?>
            <?php echo $form->error($model, 'name'); ?>
            <?php echo $form->error($model, 'name_en'); ?>
        </td>
    </tr>
   <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'description'); ?>：</th>
        <td class="odd">
            <?php $this->widget('comext.wdueditor.WDueditor', array('model' => $model, 'attribute' => 'description')); ?>
            <?php echo $form->error($model, 'description'); ?><br/>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'picture'); ?>：</th>
        <td>
            <?php
            $this->widget('common.widgets.CUploadPic', array(
                'form' => $form,
                'model' => $model,
                'attribute' => 'picture',
                'num' => 5,
                'folder_name' => 'travel/hotelPicture',       
                'btn_value'=>'上传图片',
            ));
            ?>
            <?php echo $form->error($model, 'picture', array('style' => 'position: relative; display: inline-block'), false, false); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo Yii::t('viewspot','周边商家'); ?>：</th>
        <td>
            <input class="regm-sub" type="button"onclick="clickEvent()" value="添加商家"></input>
        </td>
    </tr>
   
    <?php foreach($business as $k=>$m):  ?>
   
    <tr id='sort'>
        <td width="120px" align="right" ></td>      
        
        <td id="input">
            <?php echo $form->hiddenField($m, "[$k]id"); ?>
            <?php echo $form->textField($m, "[$k]name", array('class' => 'text-input-bj ','Placeholder'=>'商家名称')); ?>
            <?php echo $form->textField($m,"[$k]url",array('class'=>'text-input-bj ','Placeholder'=>'链接,请以http://开头'));?>
            <?php if($k > 0): ?>    
            <input type='button'  onclick="deleteBtn(<?php echo 5+$k?>)"  value='删除'> </input>               
            <?php endif ?>
            <?php echo $form->error($m, "[$k]name"); ?>
            <?php echo $form->error($m, "[$k]url"); ?>
        </td>
     
    </tr>
       <?php  endforeach;  ?>
<tr>
    <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('viewspot', '发布') : Yii::t('viewspot', '更新'), array('class' => 'reg-sub')); ?>
    </td>
</tr> 
</table>
<?php $this->endWidget(); ?>
<script>
    var i=1;
    function clickEvent(){
        var obj=document.getElementById("tab"); 
        var tr= obj.rows["sort"]; 
//        alert(tr.rowIndex);
        var tr =obj.insertRow(tr.rowIndex+1); 
        var trId="sort"+tr.rowIndex; 
        tr.setAttribute("id",trId);
        var td0 = tr.insertCell(0);
        td0.setAttribute("class","odd","width","120px");      
//        alert(html);
        
        var delbutton = "<input type='button'  onclick='deleteBtn("+tr.rowIndex+")' value='删除'></input>";
        var td1 = tr.insertCell(1); 
        td1.setAttribute("class","odd");
        td1.innerHTML =  "<input class='text-input-bj' placeholder='商家名称' name='SurroundingBusinesses["+i+"][name]' id='SurroundingBusinesses_"+i+"_name' maxlength='128' type='text'><input class='text-input-bj' placeholder='商家链接' name='SurroundingBusinesses["+i+"][url]' id='SurroundingBusinesses_"+i+"_url' maxlength='128' type='text'> "+delbutton; 
        i++;
    }
    
    function deleteBtn(rowIndex){
        var obj=document.getElementById("tab");     
        obj.deleteRow(rowIndex); 
    }
</script>