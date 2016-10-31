<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>网签</title>
        <link href="/css/global.css" rel="stylesheet" type="text/css">
            <link href="/css/style2.css" rel="stylesheet" type="text/css">    
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
                            <h1>积分分配确认函</h1>
                            <div class="partyA">
                                <div class="party">甲方：珠海横琴新区盖网科技发展有限公司</div>
                            </div>
                            <div class="partyA">
                                <div class="party">乙方：<?php echo $form->textField($model, 'creditor_tran', array('class' => 'storeName', 'readonly' => 'true')) ?>公司<?php echo $form->error($model, 'creditor_tran') ?></div>
                            </div>   
                            <div class="partyA">
                                <div class="party">丙方：珠海横琴新区盖网通传媒有限公司
                                </div>   
                                <div class="signContent">
                                    <p>甲方、乙方为健全"盖网"的旧系统，同时不影响乙方拥有在丙方的合法权益，使"盖网"新系统能顺利重新上线，经甲、乙、丙三方一致协商同意，依法达成如下积分分配事宜：</p>
                                    <p>1.乙方同意将其截止至2014年4月30(包含4月30日)日留存在丙方账户的
                                        <?php echo $form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true')) ?><?php echo $form->error($model, 'tranYuan') ?>元，转移至乙方在甲方开设的积分账户；</p>
                                    <p>2. 甲方同意受让乙方拥有的、留存在丙方、截止至2014年4月30日的留存的<?php echo $form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true')) ?><?php echo $form->error($model, 'tranYuan') ?>
                                        元；</p>
                                    <p>3. 丙方将乙方2014年4月30之前(包含4月30日)日的留存的<?php echo $form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true')) ?><?php echo $form->error($model, 'tranYuan') ?>
                                        元转移到乙方在甲方开设的积分账户后，截止至2014年4月30日，乙、丙双方不再存在任何的消费积分。</p>
                                    <p>4.本确认函自三方签字或盖章之日起生效</p>
                                </div> 

                                <div class="partyA">
                                    <div class="party">甲方：珠海横琴新区盖网科技发展有限公司</div>
                                </div>
                                <div class="partyA">
                                    <div class="party">乙方：<?php echo $form->textField($model, 'creditor_tran', array('class' => 'storeName', 'readonly' => 'true')) ?>公司<?php echo $form->error($model, 'creditor_tran') ?>
                                    </div>
                                </div>
                                <div class="partyA">
                                    <div class="party">丙方：珠海横琴新区盖网通传媒有限公司</div>
                                </div>
                                <div class="signDateCreditor">
                                    <?php
                                    if (isset($model->create_time)) {
                                        echo date("Y年m月d日", $model->create_time);
                                    } else {
                                        echo date("Y年m月d日", time());
                                    }
                                    ?>
                                </div>
                                <div class="clear"></div>
                                <?php
                                $this->endWidget();
                                ?>
                            </div>
                        </div>
                </body>
                </html>

