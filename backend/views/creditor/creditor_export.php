<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>网签</title>
        <style>
            @charset "utf-8";
            /* 样式重置 盖网 */
            /*去掉了td的背景透明*/
            /*html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{margin:0;padding:0;border:0;outline:0;font-size:100%;background:transparent}*/
            html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend{margin:0;padding:0;border:0;outline:0;font-size:100%;background:transparent}
            table,caption,tbody,tfoot,thead,tr,th{margin:0;padding:0;border:0;outline:0;font-size:100%;}
            body{line-height:1;}
            ol,ul,li{list-style:none}
            blockquote,q{quotes:none}
            blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}:focus{outline:0}
            ins{text-decoration:none}
            del{text-decoration:line-through}
            table{border-collapse:collapse;border-spacing:0}
            a{cursor:pointer;}
            /* 单独的清除元素*/
            .clear {clear: both;display: block;overflow: hidden;visibility: hidden;width: 0;height: 0;}

            /* 当一个外部元素内部有浮动元素时，外部元素如需清除浮动，用如下的清除样式 */
            .clearfix:after {clear: both; content: '.';display: block;visibility: hidden;height: 0;}
            .clearfix {display: inline-block;}
            * html .clearfix {height: 1%;}
            .clearfix {display: block;}
            *+html .clearfix{min-height:1%;}

            /*控制元素的浮动状态*/
            .left{ float:left;}
            .right{ float:right;}

            /*补白*/
            .k5{ width:1200px; height:5px;}
            .k10{width:100%; height:10px; _height:10px;clear: both;}
            .k15{width:100%; height:15px; _height:15px;clear: both;}
            .k25{width:100%; height:25px; _height:20px;clear: both;}
            .mgtop20{margin-top:20px;}

            /* text */
            body,input,select,textarea{ color:#666; font-family:'宋体',arial; font-size:12px; margin:0; padding:0;}
            input,textarea{vertical-align:middle; border:0 none;}
            a:focus{outline:1px dotted invert}
            hr{border:0 #ccc solid;border-top-width:1px;clear:both;height:0}
            h1{font-size:20px}
            h2{font-size:16px}
            h3{font-size:14px}
            h4,h5,h6{font-size:12px}
            a{color:#000; text-decoration:none;}
            a:hover{color:#f60; text-decoration:none;}
            .red{color:#f00;}
            p.red{color:#f00;}
            .gray{color:#999;}
            a.org{ color:#FF8000}
            /* 图片垂直居中 --*/
            a.img_m:link ,a.img_m:visited{ display:table-cell;vertical-align:middle;*display: block;	*font-family:Arial, Helvetica, sans-serif;	overflow:hidden;clear:both;}
            a.img_m img{text-align:center;display:inline-block;	margin:0 auto; }
            /*定义图片的尺寸*/
            a.w160x190{width:160px;height:190px;_font-size:190px;*+font-size:190px;margin:0 auto;}
            a.w170x170{width:170px;height:170px;_font-size:170px;*+font-size:160px;margin:0 auto;}
            a.w160x160{ display:inline-block;width:160px;height:160px;_font-size:160px;*+font-size:150px;text-align:center;margin:0 auto;}
            a.w60x60{  width:60px; height:60px;	_font-size:40px; *+font-size:40px; margin:0 auto;}
            a.w135x135{width:135px;height:135px;_font-size:135px;*+font-size:120px;margin:0 auto;}
            a.w90x90{display:block;width:90px;height:90px;_font-size:90px;*+font-size:75px;margin:0 auto;text-align:center;}
            a.w135x90{display:block;width:135px;height:90px;_font-size:90px;*+font-size:75px;margin:0 auto; text-align:center; overflow:hidden}

            a.w95x30{  width:95px; height:30px; _font-size:20px; *+font-size:30px; margin:0 auto;}
            /* 商品标题 按钮
            .add-sub{ background:url(../images/add-sub.gif) no-repeat; width:100px; height:31px; display:block; border:0; font:12px/24px "宋体"; color:#FFF; padding-left:33px;}
            .add-sub:hover{ color:#FFF} */
            p.names{ height:23px; line-height:23px; padding-top:5px; overflow:hidden;}
            p.names a{ color:#000}
            p.namestl{ height:42px; line-height:21px; overflow:hidden;}
            p.namestl a{color:#333}
            p.integral{height:22px; line-height:22px;  overflow:hidden;}
            p.integral .jf{ color:#f40000; font: bold 13px/20px Arial, Helvetica, sans-serif}
            p.returnIntegral {height:22px; color: #999;}
            p.price{ height: 20px; color: #8F8F8F; }
            p.price .del{color:#f40000; font: bold 13px/20px Arial, Helvetica, sans-serif; margin-right:5px; text-decoration:line-through;}
            p.ico_j{ width:500px; margin:15px auto; display:none;}

            input.button_red1{ background:#c90000;border-radius:3px; color:#fff;padding:5px; text-align:center;}

            /* CSS Document */
            .wrapperSign{ width:100%;  background:#910000; margin:0 auto; font-family:"微软雅黑" }
            .sign{ width:1000px; background:#FFF; padding:38px 50px;margin:0 auto; }
            .sign h1{ margin:0 auto; text-align:center; width:450px; font-size:28px; line-height:35px;}
            .sign .storeName{ width:300px; border-bottom:1px solid #bfbfbf;font-size:20px; color:#000;text-overflow:ellipsis; overflow:hidden; white-space:nowrap}
            .sign .partyA{ margin-top:35px;}
            .sign .partyA .party{ font-size:20px; color:#000;}
            .sign .partyA .color83{ color:#838383; font-size:16px;}
            .sign .partyA .replace{ font-size:20px; color:#000; padding-top:5px;}
            .sign .partyA .plus{ background:url(/images/plus.jpg) no-repeat; width:16px; height:16px; display:inline-block; vertical-align:bottom;}
            .sign .partyA .plusDel{ background:url(/images/error.gif) no-repeat; width:16px; height:16px; display:inline-block; vertical-align:bottom;}
            .sign .signContent{ margin-top:40px; font-size:18px; line-height:28px}
            .sign .signContent p{ text-indent:2em}
            .sign .submit{ margin-top:30px; text-align:center;}
            .sign .submit .btn{ background:url(/images/btnsub.jpg) no-repeat; display:inline-block; width:106px; height:34px; line-height:34px; text-align:center; color:#FFF; font-size:20px; cursor:pointer;}
            .sign .signContent .integ{ width:80px; font-size:18px; border-bottom:2px solid #8e0001; text-align:center; overflow:hidden; text-overflow:ellipsis;white-space:nowrap;}
            .sign .signName{font-size:20px; margin-top:30px; padding-left:50px; }
            .sign .signName .nameA{font-size:20px;  border:none;color:#000;}
            .sign .signName .nameB{font-size:20px;  border:none;color:#000;width:400px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap}
            .sign .signDate{font-size:20px; margin-top:30px; padding-left:30px; }
            .sign .signDate .nameA{font-size:20px;  border:none; width:50px; text-align:center;color:#000;}
            .sign .floatLeft2{float:left;width:400px}
            .sign .signDateCreditor{font-size:20px;  border:none;  text-align:center;color:#000; float:right;margin-right: 30px;}
            .sign .agree{ font-size: 18px; margin-top: 10px; text-align: center}
        </style>
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
                    <div class="party">乙方：<u><?php echo $model->creditor_tran; ?></u><?php //echo $form->textField($model, 'creditor_tran', array('class' => 'storeName', 'readonly' => 'true'))  ?>公司<?php //echo $form->error($model, 'creditor_tran')  ?></div>
                </div>   
                <div class="partyA">
                    <div class="party">丙方：珠海横琴新区盖网通传媒有限公司
                    </div>   
                    <div class="signContent">
                        <p>甲方、乙方为健全"盖网"的旧系统，同时不影响乙方拥有在丙方的合法权益，使"盖网"新系统能顺利重新上线，经甲、乙、丙三方一致协商同意，依法达成如下积分分配事宜：</p>
                        <p>1.乙方同意将其截止至2014年4月30(包含4月30日)日留存在丙方账户的
                            <u><?php echo $model->tranYuan ?></u>
                            <?php //echo $form->textField($model, 'tranYuan', array('class' => 'integ', 'readonly' => 'true')) ?><?php //echo $form->error($model, 'tranYuan') ?>元，转移至乙方在甲方开设的积分账户；</p>
                        <p>2. 甲方同意受让乙方拥有的、留存在丙方、截止至2014年4月30日的留存的 <u><?php echo $model->tranYuan ?></u>
                            元；</p>
                        <p>3. 丙方将乙方2014年4月30之前(包含4月30日)日的留存的 <u><?php echo $model->tranYuan ?></u>
                            元转移到乙方在甲方开设的积分账户后，截止至2014年4月30日，乙、丙双方不再存在任何的消费积分。</p>
                        <p>4.本确认函自三方签字或盖章之日起生效</p>
                    </div> 

                    <div class="partyA">
                        <div class="party">甲方：珠海横琴新区盖网科技发展有限公司</div>
                    </div>
                    <div class="partyA">
                        <div class="party">乙方：<u><?php echo $model->creditor_tran; ?></u>公司
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

