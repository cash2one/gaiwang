<div class="sign-reminder">
    <p><strong>温馨提示(<span>必看</span>)：</strong></p>
    <p>1、合同上传的文件格式：PDF，文件大小：3M以内；</p>
    <p>2、合同上传的文件务必在对应的项目框内进行上传，感谢配合。</p>
    <p>3、附件上传的文件格式：jpg、jpeg、gif、bmp，文件大小：3M以内；</p>
    <p>4、附件上传的文件务必在对应的项目框内进行上传；每个附件仅限包含10个加盟商信息，如新增加盟商数量大于10，请分批上传多个附件，感谢配合</p>
</div>

<div class="c30"></div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>
<div class="audit-bargain clearfix">
    <ul>
        <li>
            <p class="bargain-cho">
                《联盟商户合作合同》
                <input type="button" value="上传合同" class="btn-sign fr"
                       onclick="uploadContract(
                           this,
                           '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlinePdf',array('code'=>1141))?>',
                           'OfflineSignStore_upload_contract',
                       <?php echo isset($model->id) ? $model->id : '0' ?>,
                           traceChange)">
                <?php echo $form->hiddenField($model,'upload_contract')?>
                <?php echo $form->error($model,'upload_contract')?>
            </p>
            <p class="bargain-pdf"><label id="pdfName"></label>
                <a href="#" id="showPdf">未上传文件</a>
            </p>
        </li>
        <?php if($storeNum > 1):?>
            <?php for($i=1;$i <=$storeNum;$i+=10): $num = intval($i/10)+1;?>
        <li>
            <p class="bargain-cho">
                《盖网通铺设场所及优惠约定-附件 <?php echo $num;?>》
                <input type="button" value="上传附件" class="btn-sign fr"
                       onclick="uploadAnnexPicture(
                           this,
                           '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1133))?>',
                           'OfflineSignStore_upload_contract_img',
                       <?php echo isset($model->id) ? $model->id : '0' ?>,traceChange,<?php echo $num;?>)">
                <?php echo $form->hiddenField($model,"upload_contract_img[$num]".'upload_contract_img')?>
                <?php echo $form->error($model,'upload_contract_img')?>
            </p>
            <p class="bargain-pdf"><label id="imgName<?php echo $num;?>"></label>
                <a href="#" id="showImg<?php echo $num;?>">未上传文件</a>
            </p>
        </li>
                <?php endfor;?>
        <?php endif;?>
    </ul>
</div>
<div class="c10"></div>
<div class="sign-clear"></div>
<div class="c30"></div>
<div class="sign-btn">
    <input type="submit" value="提交" class="btn-sign-gray" id='sbumit-btn' disabled="true">
</div>
<?php $this->endWidget(); ?>

<div style="display: none;" id="confirmArea">
    <p>如果你的pdf没有正常显示<a href="" id="dowloandPdf">请点击这里下载预览</a></p>
    <div id="myPdfDiv"></div>
</div>
