    <script src="<?php echo DOMAIN . Yii::app()->theme->baseUrl?>/js/jquery.raty.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN . Yii::app()->theme->baseUrl?>/js/jquery.form.js" type="text/javascript"></script>
    <script type="text/javascript">$.fn.raty.defaults.path = '<?php echo DOMAIN . Yii::app()->theme->baseUrl?>/images/bgs';</script>
    <div class="main-contain">
        <div class="crumbs">
            <span>
                <?php echo Yii::t('membercomment','您的位置:');?>
            </span>
            <?php echo CHtml::link(Yii::t('memberComment','首页'),Yii::app()->homeUrl); ?>
            <span>&gt;</span>
            <?php echo CHtml::link(Yii::t('memberComment','订单中心'),$this->createUrl('/member/order/admin')) ?>
            <span>&gt;</span>
            <?php echo CHtml::link(Yii::t('memberComment','订单评价'),$this->createUrl('/member/comment/index')); ?>
        </div>
        <?php 
            $form = $this->beginWidget('CActiveForm',array(
                'id' => $this->id . '-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                    'enctype'=> "multipart/form-data"
                )
            ));
        
        ?>
            <div class="history-comment">
                <div class="hc-header"><?php echo Yii::t('membercomment','历史评论')?></div>
                <div class="hc-contain clearfix">
                    <div class="degree">
                        <p><?php echo Yii::t('membercomment','与描述相符')?></p>
                        <p class="score"><?php echo $des_match ? number_format($des_match,1) : 0;?></p>
                        <p class="degree-star"></p>
                    </div>
                    <div class="impression">
                        <ul id="impress-tag" class="clearfix">
                            <?php echo $form->radioButtonList($model,'impress_id',Comment::getImpress(array(1,2,3,4,5,6,7,8)), array('class'=>'gs-brandBut','uncheckValue'=>null,'separator'=>'', 'container' =>'','template'=>'<li class="good-tag">{label}{input}</li>','labelOptions'=>array('other'=>'impress-zero','style'=>'width:100%;display:inline-block;cursor: pointer;')));?>
                            <?php echo $form->radioButton($model,'impress_id',array('class'=>'gs-brandBut', 'id'=>'impress-zero','value'=>0,'uncheckValue'=>null))?>
                            <script type="text/javascript">
                                $('#Comment_impress_id_6').parent('li').removeClass('good-tag').addClass('bad-tag');
                                $('#Comment_impress_id_7').parent('li').removeClass('good-tag').addClass('bad-tag');
                            </script>
                        </ul>
                    </div>
                </div>
            </div>
        <div class="order-evaluate">
            <div class="oe-header">
                <span class="title"><?php echo Yii::t('membercomment','订单评价')?></span>
                <span class="order-num"><?php echo Yii::t('membercomment','订单编号')?>：<?php echo $orderModel->code;?></span>
                <a class="shop link"><?php echo Store::model()->findByPk($orderModel->store_id)->name; ?></a>
                <span class="quantity"><b class="num"><?php echo OrderGoods::getGoodNumberByOrderId($orderModel->id)->quantity?></b><?php echo Yii::t('membercomment','件')?></span>
            </div>
            <!--店铺评论列表-->
            <div class="shop-evaluate">
                <p class="title"><?php echo Yii::t('membercomment','店铺评价')?></p>
                <ul class="eval-items">
                    <li>
                        <span class="item-name"><?php echo Yii::t('membercomment','描述相符')?>：</span>
                        <span class="des-star"></span>
                        <span class="des-hint"></span>
                        <?php echo $form->error($storeComment,'description_match');?>
                    </li>
                    <li>
                        <span class="item-name"><?php echo Yii::t('membercomment','服务态度')?>：</span>
                        <span class="attitude-star"></span>
                        <span class="attitude-hint"></span>
                        <?php echo $form->error($storeComment,'serivice_attitude');?>
                    </li>
                    <li>
                        <span class="item-name"><?php echo Yii::t('membercomment','发货速度')?>：</span>
                        <span class="speed-star"></span>
                        <span class="speed-hint"></span>
                        <?php echo $form->error($storeComment,'speed_of_delivery');?>
                    </li>
                </ul>
            </div>
            <!--评论产品列表-->
            <?php $this->renderPartial('_goodslist',array('orderModel'=>$orderModel,'model'=>$model,'form'=>$form))?>
            <div class="evaluate-submit clearfix">
                <div class="anonymous"><?php echo CHtml::checkBox('Comment[is_anonymity]','',array('class'=>'checkbox'))?><span class="checkbox-label"><?php echo Yii::t('membercoment','匿名')?></span></div>
                <?php echo CHtml::submitButton(Yii::t('memberComment', '提交评价'), array('class' => 'submit-btn')) ?>
            </div>
        </div>
    <?php $this->endWidget()?>
    </div>
    <script>
        var csrfToken = "<?php echo Yii::app()->request->csrfToken;?>"; 
        $(function () {
            //与描述符合度星级
            $(".degree-star").raty({
                readOnly: true,
                score:<?php echo $des_match ? number_format($des_match,1) : 0;?>,
                starHalf: 's-star-half.png',
                starOff: 's-star-off.png',
                starOn: 's-star-on.png'
            });
            //买家印象
            $("#impress-tag label").click(function () {
                var t = $(this).parent('li');
                if (t.hasClass("active")) {
                    t.removeClass("active");
                    f = $(this).attr('for');
                    o = $(this).attr('other');
                    $(this).attr('for',o).attr('other',f);
                } else {
                    t.addClass("active");
                    t.siblings().removeClass("active");
                    f = $(this).attr('for');
                    if(f == 'impress-zero'){
                        o = $(this).attr('other');
                        $(this).attr('for',o).attr('other',f);
                    }
                }
            })
            //描述相符星级
            $(".des-star").raty({
                scoreName: 'StoreComment[description_match]',
                score: 5,
                target: ".des-hint",
                targetText: "<b class='score'>3分</b>(合作物流不错，运费合理，总体感觉不错)",
                targetKeep: true,
                hints: [
                    "<b class='score'>1分</b>(卖家承诺没有实现，商品包装很马虎，总体印象很差)",
                    "<b class='score'>2分</b>(商品性价比较低，运费偏贵，感觉一般)",
                    "<b class='score'>3分</b>(合作物流不错，运费合理，总体感觉不错)",
                    "<b class='score'>4分</b>(商品性价比高，卖家包装很贴心严实，还会再光顾)",
                    "<b class='score'>5分</b>(商品物美价廉，卖家还送小礼物，会介绍给身边的亲朋好友)"
                ]
            });
            //服务态度星级
            $(".attitude-star").raty({
                scoreName:'StoreComment[serivice_attitude]',
                score: 5,
                target: ".attitude-hint",
                targetText: "<b class='score'>3分</b>(咨询能够得到回复，但响应速度一般，服务态度也一般)",
                targetKeep: true,
                hints: [
                    "<b class='score'>1分</b>(卖家不理人，态度恶劣，骂人，沟通体验极差)",
                    "<b class='score'>2分</b>(卖家回应缓慢，爱答不理，沟通效果差)",
                    "<b class='score'>3分</b>(咨询能够得到回复，但响应速度一般，服务态度也一般)",
                    "<b class='score'>4分</b>(响应速度好，咨询回复细心耐心，服务态度好，沟通效果满意)",
                    "<b class='score'>5分</b>(响应快速高效，处理大方得体，用语礼貌亲切，对沟通结果很满意)"
                ]
            });
            //发货速度星级
            $(".speed-star").raty({
                scoreName:'StoreComment[speed_of_delivery]',
                score: 5,
                target: ".speed-hint",
                targetText: "<b class='score'>3分</b>(能在合理或者规定的时间内发货)",
                targetKeep: true,
                hints: [
                    "<b class='score'>1分</b>(延时发货或者一直没有发货)",
                    "<b class='score'>2分</b>(发货不及时，经过多次催促才发货)",
                    "<b class='score'>3分</b>(能在合理或者规定的时间内发货)",
                    "<b class='score'>4分</b>(发货及时，商品包装好)",
                    "<b class='score'>5分</b>(发货快速，商品包装保护性好，包裹严实)"
                ]
            });

            //删除评论图片
            $(".upload-list").delegate('.delete-img','click',function(){
                var t = $(this),
                   src = t.siblings('img').attr('src'),
                   p = t.parent(),
                   ps = p.parent(),
                   span = ps.next().children('span'),
                   l = ps.children('li').length;
                if('<?php  echo $this->action->id;?>' == 'edit')
                {
                     p.remove();//删除文件
                     return false;
                }
                $.post('<?php echo $this->createAbsoluteurl('/member/comment/deleteImg')?>',{src:src,YII_CSRF_TOKEN:csrfToken},function(data){
                    if(data.error){
                        alert('删除失败');
                    } else {
                        l = parseInt(l) - 1;
                        p.remove();//删除文件
                        span.html(l+"/4图片")
                    }
                },'json');
            });
            //文件上传按钮
            $(".add-btn").click(function(){
                $(this).next(".input-file").click();
            });
        });
        
        function submitImg(obj,k){ 
           	 var o = $(obj),
             ul = o.siblings('.upload-list'),
             l = ul.children('li').length,
             n = o.siblings('.tip-area').children('.img-num');
            if(l >= 4){
             alert('不能再上传了');
                  return false;
                }
            var imgUrl = '<?php echo $this->createAbsoluteUrl('/member/comment/upload')?>';
            $('#comment-form').ajaxSubmit({
                url:imgUrl,
                type:'POST',
                dataType:'json',
                async: false,
                data:{filename:name,YII_CSRF_TOKEN:csrfToken},
//              beforeSend:function(data){
//               
//               },
//                uploadProgress: function(event, position, total, percentComplete) {
//                    console.log(event, position, total, percentComplete);
//                },
                success:function(data){
                    if(!data.error){  
                        '<input type="hidden" name="Comment[imp_path][]" value="">';
                        var li =  '<li><img src="'+ data.path +'" alt="'+ data.path +'" width="54px" height="54px" />\n\
                                    <i class="delete-img"></i>\n\
                                    <input type="hidden" name="Comment['+k+'][img_path][]" value="'+data.ajaxfile+'"></li>',liObj = $(li);
                        ul.append(liObj);
                        num = l+1;
                        n.text(num+'/4图片');
                    } else {
                        alert('上传失败');
                    }
                }
            });
            return false;
        }
        
        function sleep(numberMillis) {
            var now = new Date();
            var exitTime = now.getTime() + numberMillis;
            while (true) {
                now = new Date();
                if (now.getTime() > exitTime)
                    return;
            }
        }
    </script>