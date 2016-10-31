<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
$countAddress = $this->params('maxAddress') - count($address);

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script type="text/javascript">document.domain = '<?php echo SHORT_DOMAIN ?>';</script>
    </head>
    <body>
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => 'address-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true, //客户端验证
        ),
    ));
    ?>
    <!--主体start-->
    <div class="shopping-pay">
        <div class="orders-confirm">

            <div class="address-pop" style="display:block">
                <div class="address-box" style="margin-top:0;height: 540px;">
                    <div class="address-title clearfix">
                        <div class="left"><?php echo $model->isNewRecord ? '新增':'修改'; ?>收货地址</div>
                    </div>
                    <div class="address-center">
                        <div class="address-item clearfix"><span class="address-div"><i>*</i>所在地区</span>

                            <div class="address-item-input">
                                <?php
                                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                    'prompt' => Yii::t('memberAddress', '选择省份'),
                                    'class' => 'btn-provinces',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createAbsoluteUrl('/member/region/updateCity'),
                                        'dataType' => 'json',
                                        'data' => array(
                                            'province_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                        'success' => 'function(data) {
                                        $("#Address_city_id").html(data.dropDownCities);
                                        $("#Address_district_id").html(data.dropDownCounties);
                                    }',
                                    )));
                                ?>
                                <?php
                                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                    'prompt' => Yii::t('memberAddress', '选择城市'),
                                    'class' => 'btn-provinces',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createAbsoluteUrl('/member/region/updateArea'),
                                        'update' => '#Address_district_id',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                    )));
                                ?>
                                <?php
                                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                    'prompt' => Yii::t('memberAddress', '选择区/县'),
                                    'class' => 'btn-provinces',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                    )));
                                ?>
                            <!--</div>-->
                            <div class="hint-area">
                                <?php echo $form->error($model, 'province_id'); ?>
                                <?php echo $form->error($model, 'city_id'); ?>
                                <?php echo $form->error($model, 'district_id'); ?>
                            </div>
                            </div>
                        </div>
                        <div class="address-item clearfix"><span class="address-div"><i>*</i><?php echo $form->label($model, 'street'); ?></span>

                            <div class="address-item-input">
                                <?php echo $form->textArea($model, 'street', array(
                                    'class' => 'input-address',
                                    'maxlength'=>'100',
                                    'placeholder'=>'无需重复填写省市区，小于100字'
                                )); ?>
                                <?php echo $form->error($model, 'street'); ?>
                            </div>
                        </div>
                        <div class="address-item clearfix"><span class="address-div"><?php echo $form->label($model, 'zip_code'); ?></span>

                            <div class="address-item-input">
                                <?php echo $form->textField($model, 'zip_code', array('class' => 'input-postal')); ?>
                                <?php echo $form->error($model, 'zip_code'); ?>
                            </div>
                        </div>
                        <div class="address-item clearfix">
                            <span class="address-div"><i>*</i><?php echo $form->label($model, 'real_name'); ?></span>

                            <div class="address-item-input">
                                <?php echo $form->textField($model, 'real_name', array('class' => 'input-name')); ?>
                                <?php echo $form->error($model, 'real_name'); ?>
                            </div>
                        </div>
                        <div class="address-item clearfix">
                            <span class="address-div"><i>*</i><?php echo $form->label($model, 'mobile'); ?></span>

                            <div class="address-item-input">
                                <?php echo $form->textField($model, 'mobile', array('class' => 'input-phone')); ?>
                                <?php echo $form->error($model, 'mobile'); ?>
                            </div>
                        </div>
                        <div class="address-item clearfix">
                            <span class="address-div"><?php echo $form->label($model, 'telephone'); ?></span>

                            <div class="address-item-input">
                                <?php echo $form->textField($model, 'telephone', array('class' => 'input-phone')); ?>
                                <?php echo $form->error($model, 'telephone'); ?>
                            </div>
                        </div>
                        <div class="address-item clearfix">
                            <span class="address-div">&nbsp;</span>
                            <?php echo $form->checkBox($model, 'default',array('class'=>'btn-check')); ?>设为默认地址
                        </div>
                        <div class="address-item clearfix">
                            <span class="address-div">&nbsp;</span>
                            <input name="" type="submit" value="保存<?php echo $model->isNewRecord?'新':'' ?>地址" class="btn-dete"/>
                            <input name="" type="button" value="取消" class="btn-delete"/></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- 主体end -->
    <?php $this->endWidget(); ?>
    <script type="text/javascript">
     $(".btn-delete").click(function(){
         var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
         parent.layer.close(index); //再执行关闭
     });
     if(typeof  success != 'undefined'){
         var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
         parent.layer.alert(success);
         $(parent.document).find("form.changeAddress").submit();
         parent.layer.close(index); //再执行关闭
     }
    <?php if (Yii::app()->user->hasFlash('maxAddress')): ?>
            layer.alert('<?php echo Yii::t('memberAddress', '最多只能添加'.$this->params('maxAddress').'个收货地址!'); ?>');
    <?php endif; ?>
    </script>

    </body>
    </html>
