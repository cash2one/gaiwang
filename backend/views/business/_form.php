<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>网签</title>
        <link href="/css/global.css" rel="stylesheet" type="text/css">
            <link href="/css/style2.css" rel="stylesheet" type="text/css">
<!--                <script type="text/javascript" src="/js/jquery-1.5.1.min.js"></script>-->
<!--                <script type="text/javascript" src="/js/artDialog/jquery.artDialog.js?skin=aero"></script> -->
                </head>

                <body>
                    <div class="wrapperSign">
                        <div class="sign">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'business-form',
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => true,
//	'htmlOptions' => array(
//		'autocomplete'=>'off'
//	),
                            ));
                            ?>
                            <h1>联盟商户结算关系确认函</h1>
                            <div class="partyA">
                                <div class="party">母公司/总公司：
                                    <?php echo $form->textField($model, 'store', array('class' => 'storeName', 'onblur' => 'check(this)')); ?>
                                    <span class="color83">（以下简称“甲方”）</span><?php echo $form->error($model, 'store') ?></div>
                            </div>
                            <div class="partyA" id="childParty">
                                <?php
                                $i = 1;
                                if (!empty($data)) {
//                                    $i = 1;
                                    foreach ($data as $value) {
                                        if ($i == 1) {
                                            echo '<div class="replace">子公司/分公司：
                                                         <input type="text" maxlength="20" id="branch_1" name="branch[]" class="storeName" onblur="check2(this)" value="' . $value . '" /><a href="#" class="plus" onclick="add()"></a><span class="color83">（以下简称"乙方"）</span>
                                                         <div style="display:none" id="Business_branch_em_" class="errorMessage"></div></div>';
                                        } else {
                                            echo '<div class="replace" id="storeChild_' . $i . '">子公司/分公司：
                                                         <input type="text" maxlength="20" id="branch_' . $i . '" name="branch[]" class="storeName" onblur="check2(this)" value="' . $value . '" /><a href="#" class="plusDel" onclick="re(' . $i . ')"></a>
                                                         <div style="display:none" id="Business_branch_em_" class="errorMessage"></div></div>';
                                        }
                                        $i++;
                                    }
                                } else {
                                    $i++;
                                    echo '<div class="replace">子公司/分公司：
                                                         <input type="text" maxlength="20" id="branch_1" name="branch[]" onblur="check2(this)" class="storeName"><a href="#" class="plus" onclick="add()"></a><span class="color83">（以下简称"乙方"）</span>
                                                         <div style="display:none" id="Business_branch_em_" class="errorMessage"></div></div>';
                                }
                                ?>
                            </div>   
                            <div class="signContent">
                                <p>甲乙双方与珠海横琴新区盖网通传媒有限公司签订积分消费服务协议，为健全珠海横琴新区盖网通传媒有限公司财务核算要求，甲乙双方对如下事项协商一致,作如下事项：</p>
                                <p>1、甲方为乙方的母公司/总公司，乙方同意将其所有的消费积分交由甲方收回，并视甲方为消费积分汇总主体。</p>
                                <p>2、本确认函自甲乙方签字或盖章之日起生效。</p>
                            </div> 

                            <div class="signName">甲方：
                                <?php echo $form->textField($model, 'store', array('class' => 'nameB', 'id' => 'storeNew', 'readonly' => 'true')); ?>
                            </div>
                            <div c class="signName clearfix">
                                <div class="left">乙方：</div>
                                <div  class="floatLeft2">
                                    <?php
                                    $a = 1;
                                    if (!empty($data)) {
                                        foreach ($data as $value) {
                                            echo '<input type="text" id="store_branch_' . $a . '" name="branch_[]" value="' . $value . '" class="nameB" readonly="true"/>';
                                            $a++;
                                        }
                                    } else {
                                        echo '<input type="text" id="store_branch_' . $a . '" name="branch_[]" class="nameB" readonly="true"/>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="signDate">
                                <?php
                                if (isset($model->create_time)) {
                                    echo date("Y年m月d日", $model->create_time);
                                } else {
                                    echo date("Y年m月d日", time());
                                }
                                ?>
                            </div>
                            <?php
                               if($check){
                                   echo '<div class="signDate">该公司已签约！</div>';
                               }
                            ?>
                            <div class="submit">
                                <?php
                                echo CHtml::submitButton('点击提交', array('class' => 'btn'));
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
                    var i = <?php echo $i ?>;
                    function add() {
                        var html = "<div class='replace' id='storeChild_" + i + "'>子公司/分公司：";
                        html += "<input type='text' maxlength='20' id='branch_" + i + "' name='branch[]' onblur='check2(this)' class='storeName'/><a href='#' class='plusDel' onclick='re(" + i + ")'></a>";
                        html += "<div style='display:none' id='Business_branch_em_' class='errorMessage'></div></div>";
                        $('#childParty').append(html);

                        var html2 = "<input type='text' id='store_branch_" + i + "' name='branch_[]' class='nameB' readonly='true'/>";
                        $('.floatLeft2').append(html2);
                        i++;
                    }

                    function re(id) {
                        $('#storeChild_' + id).remove();
                        $('#store_branch_' + id).remove();
                    }

                    function check(obj) {
                        $('#storeNew').val(obj.value);
                    }

                    function check2(obj) {
                        $('#store_' + obj.id).val(obj.value);
                    }
                </script>

