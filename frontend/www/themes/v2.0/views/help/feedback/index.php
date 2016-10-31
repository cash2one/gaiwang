<?php
//Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/plugins/iframeTools.js', CClientScript::POS_END);
$this->pageTitle = "用户反馈_" . $this->pageTitle;
?>

<?php $this->renderPartial('//layouts/_msg'); ?>
<?php Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . "/styles/global.css");?>
<?php Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . "/styles/module.css");?>
<?php Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . "/styles/register.css");?>
<!-- 头部start -->
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo"><a href="<?php echo DOMAIN ?>"><img
                    src="<?php echo $this->theme->baseUrl . '/'; ?>/images/temp/register_logo.jpg" width="213"
                    height="86"/></a></div>
        <div class="pages-title icon-cart"><?php echo Yii::t('feedback', '用户反馈')?></div>
    </div>
</div>
<!-- 头部end -->

<!--主体start-->
<div class="feedback">
    <div class="feedback-title"><?php echo Yii::t('feedback', '用户反馈')?></div>
    <div class="feedback-txtle"><?php echo Yii::t('feedback', '亲爱的盖象商城用户')?>：<br/>
        <?php echo Yii::t('feedback', '请在下面填写您遇到的问题或意见建议，并留下您的联系方式，感谢您对盖象商城的支持！')?>
    </div>
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="feedback-conter">
        <div class="feedback-opinion">
            <div class="left"><span>*</span><?php echo $form->label($model, 'content') ?> ：</div>
            <div class="right keyTips"><?php echo Yii::t('feedback', '你还可以再输入')?> <span>500</span> <?php echo Yii::t('feedback', '字')?></div>
        </div>
        <div class="feedback-box">

            <?php echo $form->textArea($model, 'content', array('class' => 'input-problem', 'maxlength' => '500', 'placeholder' => Yii::t('feedback', '请具体说明您的问题或建议'),'onkeyup'=>'keyPressCheck(this)')) ?>
            <?php echo $form->error($model, 'content',array('style'=>'margin-top:-35px')) ?>

        </div>
        <div class="feedback-upload clearfix">
            <div class="left" style="margin-top:23px;"><?php echo $form->label($model, 'picture') ?>：</div>
            <div class="feedback-box">
                <?php
                $this->widget('common.widgets.CUploadPic', array(
                    'attribute' => 'picture',
                    'model' => $model,
                    'form' => $form,
                    'num' => 4,
                    'img_area' => 2,
                    'btn_value' => Yii::t('sellerGoods', '上传图片'),
                    'btn_class'=>'btn-send',
                    'render' => '_upload',
                    'folder_name' => 'feedback',
                    'include_artDialog' => true,
                    'uploadUrl' => 'help/upload/index',
                    'uploadSureUrl' => 'help/upload/sure',
                ));
                ?>
                <?php echo $form->error($model, 'picture') ?>
            </div>

            <div class="right" style="margin-top:23px;">
                <p><?php echo Yii::t('help', '1.文件需小于3MB')?> <span><?php echo Yii::t('help', '(最多上传4张图)')?></span></p>

                <p><?php echo Yii::t('help', '2.支持格式:jpg,jpeg,png')?></p>
            </div>
        </div>
        <div class="feedback-picture clearfix">

        </div>
        <div class="feedback-link clearfix">
            <p><span><i>*</i><?php echo $form->label($model, 'username') ?>：</span>
                <?php echo $form->textField($model, 'username', array('class' => 'input-name input-shadow', 'placeholder' => Yii::t('feedback', '联系人名称'))) ?>
            </p>

            <p><span><i>*</i><?php echo $form->label($model, 'mobile') ?>：</span>
                <?php echo $form->textField($model, 'mobile', array('class' => 'input-tel input-shadow', 'placeholder' => Yii::t('feedback', '电话/邮箱/QQ'))) ?>
            </p>
        </div>
        <div style="width:850px;height: 50px;margin:-90px 0 0 0;">
            <div style="width:200px;margin:0 0 0 100px;display:inline-block">
            <?php echo $form->error($model, 'username',array('style'=>'margin-left:-5px')) ?>
            </div>
            <div style="width:200px;margin:0 0 0 190px;display:inline-block">
                <?php echo $form->error($model, 'mobile',array('style'=>'margin-left:-17px')) ?>
            </div>
        </div>
        <div class="feedback-box">
            <?php echo CHtml::submitButton(Yii::t('feedback', '提交反馈'), array('class' => 'btn-dete', 'name' => 'feedback')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <div></div>

</div>
<!-- 主体end -->
<script>
    function keyPressCheck(that) //textarea输入长度处理
    {
        var text1 = $(that).val();
        var len;//记录剩余字符串的长度
        var maxLength = 500;
        if (text1.length >= maxLength)//textarea控件不能用maxlength属性，就通过这样显示输入字符数了
        {
            $(that).val(text1.substr(0, maxLength));
            len = 0;
        }
        else
        {
            len = maxLength - text1.length;
        }
        var show = "<?php echo Yii::t('feedback', '你还可以输入')?>" + len + "<?php echo Yii::t('feedback', '个字')?>";
        $(".keyTips").html(show);
    }
</script>
