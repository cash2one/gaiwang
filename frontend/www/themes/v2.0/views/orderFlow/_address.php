<?php
//收货地址
/** @var Controller $this  */
/** @var $select_address array 会员当前选择的收货地址  */
$select_address = $this->getSession('select_address');
?>
<script type="text/javascript">document.domain = '<?php echo SHORT_DOMAIN ?>';</script>
<div class="orders-address-box">
    <div class="orders-address-top clearfix">
        <div class="left">选择收货地址</div>
        <div class="right icon-cart">使用新地址</div>
    </div>
    <div class="orders-address-only first" style="display: block;">
        <?php if(!empty($address)):
            //查找已选择的收货地址显示在第一个
            $Add = array();
            foreach($address as $v){
                if($select_address['id'] == $v['id']){
                    $Add = $v;
                    break;
                }
            }
            if(empty($Add)) $Add = $address[0];
             $addressLong = implode(' ', array($Add['province_name'], $Add['city_name'], $Add['district_name'], $Add['street'], '(' . $Add['real_name'] . ')', $Add['mobile']));
            ?>
        <ul>
            <li class="on"  id="addressLi_<?php echo $Add['id'] ?>">
                <?php
                echo CHtml::radioButton('address', $select_address['id'] == $Add['id'] || count($address)==1 ? true : false, array(
                    'value' => $Add['id'],
                    'data-city_id' => $Add['city_id'],
                    'data-address' => $addressLong,
                    'data-consignee' => $Add['real_name'],
                    'style'=>'display:none;'
                ))
                ?>
                <label for="<?php echo 'address_' . $Add['id'] ?>">
                    <span class="select icon-cart" ><?php  echo $v['default']==Address::DEFAULT_YES ? Yii::t('orderFlow','默认地址'): $v['real_name'] ?></span>
                </label>
                <span class="name"><?php echo $Add['real_name'] ?></span>
                <span class="address" style="height: 32px;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?php echo $Add['province_name'],' ', $Add['city_name'],' ', $Add['district_name'],' ', $Add['street'] ?>
                </span>
                <span class="tel"> <?php echo substr($Add['mobile'], 0, 3) . '*****' . substr($Add['mobile'], -3); ?></span>
                

                <?php echo CHtml::link('删除','javascript:;',array('class'=>'deleted','data-id'=>$Add['id'])); ?>
                <?php echo CHtml::link('编辑','javascript:;',array('class'=>'editor','data-url'=>$this->createAbsoluteUrl('/member/address/edit',array('id'=>$Add['id']))));?>
                <?php
                    if($Add['default']==Address::DEFAULT_NO){
                        echo CHtml::link('设为默认地址','javascript:;',array('class'=>'seton','data-id'=>$Add['id']));
                    }
                ?>
            </li>
        </ul>
        <?php else: ?>
            <ul>
                <li class="on">
                    <span class="address">您还没设置收货地址，请尽快设置</span>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <div class="orders-address-more" style="display: none;">
        <div class="picScroll-top">
            <div class="hd">
                <a class="next icon-cart"></a>
                <a class="prev icon-cart prevStop"></a>
            </div>
            <div class="bd orders-address-only">
                <!-- <div class="tempWrap" style="overflow:hidden; position:relative; max-height:188px"> -->
                    <ul style="top: 0px; position: relative; padding: 0px; margin: 0px;" class="picList">
                        <?php foreach($address as $v):
                            $addressLong = implode(' ', array($v['province_name'], $v['city_name'], $v['district_name'], $v['street'], '(' . $v['real_name'] . ')', $v['mobile']));
                            ?>
                        <li style="height: 32px;" class="<?php echo $select_address['id'] == $v['id'] ? 'on':'' ?>" id="addressLi_<?php echo $v['id'] ?>">
                            <?php
                            echo CHtml::radioButton('address', $select_address['id'] == $v['id'] ? true : false, array(
                                'value' => $v['id'],
                                'data-city_id' => $v['city_id'],
                                'data-address' => $addressLong,
                                'data-consignee' => $v['real_name'],
//                                'id' => 'address_' . $v['id'],
                                'style'=>'display:none;'
                            ))
                            ?>
                            <label for="<?php echo 'address_' . $v['id'] ?>">
                                <span class="select icon-cart" data-city-id="<?php echo $v['city_id']?>" data-address-id="<?php echo $v['id']?>"><?php  echo $v['default']==Address::DEFAULT_YES ? Yii::t('orderFlow','默认地址'): $v['real_name'] ?></span>
                            </label>
                            <span class="name"><?php echo $v['real_name'] ?></span>
                            <span class="address" style="height: 32px;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo $v['province_name'],' ', $v['city_name'],' ', $v['district_name'],' ', $v['street'] ?>
                            </span>
                            <span class="tel"> <?php echo substr($v['mobile'], 0, 3) . '*****' . substr($v['mobile'], -3); ?></span>
                            <?php echo CHtml::link('删除','javascript:;',array('class'=>'deleted','data-id'=>$v['id'])); ?>
                            <?php echo CHtml::link('编辑','javascript:;',array('class'=>'editor','data-url'=>$this->createAbsoluteUrl('/member/address/edit',array('id'=>$v['id'])))); ?>

                            <?php
                            if($v['default']==Address::DEFAULT_NO){
                                echo CHtml::link('设为默认地址','javascript:;',array('class'=>'seton','data-id'=>$v['id']));
                            }
                            ?>

                        </li>
                        <?php endforeach; ?>
                    </ul>
                <!-- </div> -->
            </div>
        </div>

        <script type="text/javascript">
            $(function(){
                if($(".picList li").length>4){
                    jQuery(".picScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",scroll:4,vis:4,pnLoop:false,trigger:"click"});
                }else{
                    $(".picScroll-top .hd").hide();
                }
            })
        </script>
    </div>

    <?php if(count($address)>0): ?>
    <p class="address-box">
        <a class="address-up icon-cart" href="javascript:void(0)" style="display: none;">收起地址</a>
        <?php if(count($address)>1): ?>
        <a class="address-more icon-cart" href="javascript:void(0)" style="display: block;">更多地址</a>
        <?php endif; ?>
    </p>
    <?php endif; ?>

</div>


<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/layer/layer.js"></script>
<script>
    //新增收货地址
    $(".orders-address-top .right").click(function(){
        layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.8,
            area: ['650px','540px'],
            content: '<?php echo $this->createAbsoluteUrl('/member/address/add') ?>' //iframe的url
        });
    });

    //编辑收货地址
    $(".orders-address-box .editor").click(function(){
        var url = $(this).attr('data-url');
        layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.8,
            area: ['650px', '540px'],
            content: url //iframe的url
        });
    });
    //删除收货地址
    $(".orders-address-box .deleted").click(function(){
        var id = $(this).attr('data-id');
        var data = $("#addressLi_"+id+' input').attr('data-address');
        layer.confirm(data+'<br/>是否要删除该地址？', {
            btn: ['是','否'], //按钮
            shade: false //不显示遮罩
        }, function(){
            layer.load();
            $.ajax({
                url:"<?php echo $this->createAbsoluteUrl('/member/address/delete') ?>",
                dataType:'jsonp',
                jsonp:"callBack",
                jsonpCallback:"jsonpCallback",
                data:{id:id},
                success:function(result){
                    if(result.msg=='ok'){
                        layer.alert("删除成功");
                        $("form.changeAddress").submit();
                    }else{
                        layer.alert("删除失败");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        }, function(){
            layer.closeAll();
        });
    });

    //设为默认收货地址
    $(".orders-address-box .seton").click(function(){
        var id = $(this).attr('data-id');
        var data = $("#addressLi_"+id+' input').attr('data-address');
        layer.confirm(data+'<br/>是否设为默认收货地址？', {
            btn: ['是','否'], //按钮
            shade: false //不显示遮罩
        }, function(){
            layer.load();
            $.ajax({
                url:"<?php echo $this->createAbsoluteUrl('/member/address/set') ?>",
                dataType:'jsonp',
                jsonp:"callBack",
                jsonpCallback:"jsonpCallback",
                data:{id:id},
                success:function(result){
                    if(result.msg=='ok'){
                        layer.alert("设置成功");
                        $("form.changeAddress").submit();
                    }else{
                        layer.alert("设置失败");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        }, function(){
            layer.closeAll();
        });
    });

    $('.orders-address-only ul li .select').click(function(){
        var t = $(this);
        if(t.parents('li').hasClass('on')) return false;
        layer.confirm('<?php echo Yii::t('address','更换地址后，需要您重新确认订单信息')?>',{
            btn:['是','否'],
            shade:false,
        },function(index){
            $.ajax({
                url: '<?php echo $this->createAbsoluteUrl('/orderFlow/changeAddress') ?>',
                data: {city_id: t.attr('data-city-id'), id:t.attr('data-address-id'), YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"},
                dataType: 'json',
                type: 'POST',
                success: function() {
                    $("form.changeAddress").submit();
                },
                error: function() {
                    $("form.changeAddress").submit();
                }
            });
        })
    })
    $(":input[name=address]").change(function() {
        if (confirm("<?php echo Yii::t('address','更换地址后，需要您重新确认订单信息')?>")) {
            $.ajax({
                url: '<?php echo $this->createAbsoluteUrl('/orderFlow/changeAddress') ?>',
                data: {city_id: $(this).attr('data-city_id'), id: $(this).val(), YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"},
                dataType: 'json',
                type: 'POST',
                success: function() {
                    $("form.changeAddress").submit();
                },
                error: function() {
                    $("form.changeAddress").submit();
                }
            });
        }
    });

</script>
