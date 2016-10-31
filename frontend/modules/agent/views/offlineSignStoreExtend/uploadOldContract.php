<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<div class="sign-reminder">
    <p><strong>温馨提示(<span>必看</span>)：</strong></p>
    <p>1、附件上传的文件格式：jpg、jpeg、gif、bmp，文件大小：3M以内；</p>
    <p>2、附件上传的文件务必在对应的项目框内进行上传；每个附件仅限包含10个加盟商信息，如新增加盟商数量大于10，请分批上传多个附件，感谢配合</p>
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
    </ul>
</div>
<div class="c10"></div>
<div class="sign-clear"></div>
<div class="c30"></div>
<div class="sign-btn">
    <input type="submit" value="提交" class="btn-sign-gray" id='sbumit-btn' disabled="true">
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function upload(obj,url,hiddenId,modelId,callbackfun) {
        art.dialog.open(url, {
            title: "上传图片",
            lock: true,
            width: 400,
            height: 200,
            init: function () {},
            ok: function () {
                var iframe = this.iframe.contentWindow;
                if (!iframe.document.body) {
                    alert("iframe还没有加载完毕!");
                    return false;
                }
                var errorInfo = $(iframe.document.getElementById('errorInfo')).val();
                if (errorInfo == 0) {
                    //删除取消的图片
                    var deleteVal = $('#'+hiddenId).val();			//要删除的图片的id
                    var indexOf = hiddenId.indexOf('_');
                    var length = hiddenId.length;
                    var model = hiddenId.substr(0,indexOf);
                    var field = hiddenId.substr(indexOf+1,length);

                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: createUrl('/offlineUpload/deleteFile'),
                        data: {id: deleteVal,model:model,field:field,modelId:modelId},
                        success: function(data) {}
                    });
                    var imgUrl = $(iframe.document.getElementById('urlInfo')).val();
                    var newFileName = $(iframe.document.getElementById('newFileName')).val();
                    var oldFileName = $(iframe.document.getElementById('oldFileName')).val();
                    var nextArr = $('.bargain-pdf').children();//取得子节点
                    for (i = 0; i < nextArr.length; i++) {
                        nextArr[i] = $(nextArr[i]);
                        //隐藏域表单，用于入库
                        if (nextArr[i].attr('type') == 'hidden') {
                            nextArr[i].attr('value', newFileName);
                        }
                        //用于显示上传的文件
                        if (nextArr[i].attr('class') == 'prc-line') {
                            nextArr[i].html(oldFileName);
                        }
                        //用于预览
                        if (nextArr[i].attr('class') == 'fl') {
                            nextArr[i].click(function () {
                                return _showBigPic(this);
                            });
                            nextArr[i].attr('href', imgUrl);
                        }
                    }
                }

                if (callbackfun) {
                    callbackfun();
                }
            },
            cancel: function () {}
        });
    }
</script>
