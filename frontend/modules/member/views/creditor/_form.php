<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo Yii::t('memberCreditor','网签')?> </title>
        <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<!--                <script type="text/javascript" src="/js/artDialog/jquery.artDialog.js?skin=aero"></script>-->
        <link href="/css/global.css" rel="stylesheet" type="text/css">
            <link href="/css/style2.css" rel="stylesheet" type="text/css">
                <?php //Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/jquery.artDialog.js?skin=aero') ?>      
                <?php if (Yii::app()->user->hasFlash('success')): ?>
                    <script>
                        //成功样式的dialog弹窗提示
                        art.dialog({
                            icon: 'succeed',
                            content: '<?php echo Yii::app()->user->getFlash('success'); ?>',
                            ok: true
                        });
                    </script>
                <?php endif; ?>
                </head>
                <body>
                    <div class="wrapperSign">
                        <div class="sign">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => $this->id . '-form',
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => true,
                            ));
                            ?>
                            <h1><?php echo Yii::t('memberCreditor','积分分配确认函');?></h1>
                            <div class="partyA">
                                <div class="party"><?php echo Yii::t('memberCreditor','甲方：珠海横琴新区盖网科技发展有限公司')?></div>
                            </div>
                            <div class="partyA">
                                <div class="party"><?php echo Yii::t('memberCreditor','乙方：')?><?php echo $form->textField($model, 'creditor_tran', array('class' => 'storeName', 'readonly' => 'true')) ?><?php echo Yii::t('memberCreditor','公司')?></div>
                            </div>   
                            <div class="partyA">
                                <div class="party"><?php echo Yii::t('memberCreditor','丙方：珠海横琴新区盖网通传媒有限公司')?>
                                </div>   
                                <div class="signContent">
                                    <p><?php echo Yii::t('memberCreditor','甲方、乙方为健全"盖网"的旧系统，同时不影响乙方拥有在丙方的合法权益，使"盖网"新系统能顺利重新上线，经甲、乙、丙三方一致协商同意，依法达成如下积分分配事宜：')?></p>
                                    <p><?php echo Yii::t('memberCreditor',"1.乙方同意将其截止至2014年4月30(包含4月30日)日留存在丙方账户的{var}元，转移至乙方在甲方开设的积分账户；",array('{var}'=>$form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true'))))?>
                                    </p>
                                    <p><?php echo Yii::t('memberCreditor','2. 甲方同意受让乙方拥有的、留存在丙方、截止至2014年4月30日的留存的{var}元；',array('{var}'=>$form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true'))))?>
                                    </p>
                                    <p><?php echo Yii::t('memberCreditor','3. 丙方将乙方2014年4月30之前(包含4月30日)日的留存的{var}元转移到乙方在甲方开设的积分账户后，截止至2014年4月30日，乙、丙双方不再存在任何的消费积分。',array('{var}'=>$form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true'))))?>
                                        </p>
                                    <p><?php echo Yii::t('memberCreditor','4.本确认函自三方签字或盖章之日起生效')?></p>
                                     <p> <?php echo CHtml::link(Yii::t('memberCreditor','详细账户明细请点击'), Yii::app()->createUrl('/seller/franchisee/change'),  array('target'=>'_blank')); ?></p>
                                </div> 

                                <div class="partyA">
                                    <div class="party"><?php echo Yii::t('memberCreditor','甲方：珠海横琴新区盖网科技发展有限公司')?></div>
                                </div>
                                <div class="partyA">
                                    <div class="party"><?php echo Yii::t('memberCreditor','乙方：')?><?php echo $form->textField($model, 'creditor_tran', array('class' => 'storeName', 'readonly' => 'true')) ?><?php echo Yii::t('memberCreditor','公司')?>
                                    </div>
                                </div>
                                <div class="partyA">
                                    <div class="party"><?php echo Yii::t('memberCreditor','丙方：珠海横琴新区盖网通传媒有限公司')?></div>
                                </div>
                                <div class="signDateCreditor">
                                    <?php
                                    if (isset($model->create_time)) {
                                        echo date(Yii::t('memberCreditor','Y年m月d日'), $model->create_time);
                                    } else {
                                        echo date(Yii::t('memberCreditor','Y年m月d日'), time());
                                    }
                                    ?>
                                </div>
                                <div class="clear"></div>

                                <?php
                                if ($check) {
                                    echo '<div class="agree">你已成功签约！</div>';
                                }

                                if ($submit) {
                                    echo '<div class="agree"><input type="checkbox" onclick="check(this)"/> '.Yii::t('memberCreditor','我已阅读并同意以上协议').'</div>';
                                }
                                ?>

                                <div class="submit">
                                    <?php
                                    if ($submit) {
                                        echo CHtml::submitButton(Yii::t('memberCreditor', '点击提交'), array('class' => 'btn'));
                                    }
                                    ?>
                                </div>
                                <?php
                                $this->endWidget();
                                ?>
                            </div>
                        </div>
                </body>
                </html>
                <script>
                    $(function() {
                        $('.submit').hide();
                    });

                    function check(obj) {
                        if (obj.checked) {
                            $('.submit').show();
                        } else {
                            $('.submit').hide();
                        }
                    }
                </script>
