<?php
// 充值卡视图
$this->breadcrumbs = array(
    Yii::t('sellerPrepaidCard', '充值卡') => array('/seller/prepaidCard')
);
?>
<style>
    #prepaidcard-form p{color: #313131;}
    #prepaidcard-form label {text-align: right;width:60px;display: inline-block}
    .cd-msg {padding-left: 10px; color: red;}
</style>
<div class="toolbar">
    <b><?php echo Yii::t('sellerPrepaidCard', '充值卡列表');?></b>
    <span><?php echo Yii::t('sellerPrepaidCard', '充值卡使用情况查询。');?></span>
</div>
<div class="seachToolbar">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createAbsoluteUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
                <th width="8%"><?php echo Yii::t('sellerPrepaidCard', '充值卡号：');?></th>
                <td width="10%"><?php echo $form->textField($model, 'number', array('class' => 'inputtxt1', 'style' => 'width:90%')); ?></td>
                <th width="5%"><?php echo Yii::t('sellerPrepaidCard', '创建时间：');?></th>
                <td width="12%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'style' => 'width:35%'
                        )
                    ));
                    ?>&nbsp;-
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'endTime',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'style' => 'width:35%'
                        )
                    ));
                    ?>
                </td>
                <th width="5%"><?php echo Yii::t('sellerPrepaidCard', '盖网积分：');?></th>
                <td width="12%">
                    <?php echo $form->textField($model, 'value', array('class' => 'inputtxt1', 'style' => 'width:35%')); ?>&nbsp;-
                    <?php echo $form->textField($model, 'maxValue', array('class' => 'inputtxt1', 'style' => 'width:35%')); ?>
                </td>
                <td width="16%"><?php echo CHtml::submitButton(Yii::t('sellerPrepaidCard', '搜索'), array('class' => 'sellerBtn06')); ?>&nbsp;&nbsp;
                <?php echo CHtml::button(Yii::t('sellerOrder', "导出EXCEL"),array('class'=>'sellerBtn07','onclick'=>'getExcel()'))?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerPrepaidCard', '状态：');?></th>
                <td><?php echo $form->radioButtonList($model, 'status', PrepaidCard::getStatus(), array('separator' => '')); ?></td>
                <th><?php echo Yii::t('sellerPrepaidCard', '对账状态：');?></th>
                <td colspan="4"><?php echo $form->radioButtonList($model, 'is_recon', PrepaidCard::getRecon(), array('separator' => '')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '充值卡号');?></th>
            <th width="9%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '盖网积分');?></th>
            <th width="9%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '实际金额');?></th>
            <th width="18%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '创建时间');?></th>
            <th width="12%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '使用状态');?></th>
            <th width="12%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '对账状态');?></th>
            <th width="10%" class="bgBlack"><?php echo Yii::t('sellerPrepaidCard', '操作');?></th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($cards->getData() as $card): ?>
            <tr <?php if ($i % 2 == 0): ?>class="even"<?php endif; ?>>
                <td class="ta_c"><?php echo $card->number; ?></td>
                <td class="ta_c"><b class="red"><?php echo $card->value; ?></b></td>
                <td class="ta_c"><b class="red">￥<?php echo $card->money; ?></b></td>
                <td class="ta_c"><?php echo date('Y-m-d H:i:s', $card->create_time); ?></td>
                <td class="ta_c">
                    <?php if ($card->status == PrepaidCard::STATUS_UNUSED): ?>
                        <span class="sellerRedBg"><?php echo Yii::t('sellerPrepaidCard', '未使用');?></span>
                    <?php elseif ($card->status == PrepaidCard::STATUS_USED): ?>
                        <span class="sellerGreenBg"><?php echo Yii::t('sellerPrepaidCard', '已使用');?></span>
                    <?php endif; ?>
                </td>
                <td class="ta_c">
                    <?php if ($card->is_recon == PrepaidCard::RECON_NO): ?>
                        <span class="sellerRedBg"><?php echo Yii::t('sellerPrepaidCard', '未对账');?></span>
                    <?php elseif ($card->is_recon == PrepaidCard::RECON_YES): ?>
                        <span class="sellerGreenBg"><?php echo Yii::t('sellerPrepaidCard', '已对账');?></span>
                    <?php endif; ?>
                </td>
                <td class="ta_c">
                    <?php echo CHtml::link(Yii::t('sellerPrepaidCard', '查看详情'), array('/seller/prepaidCard/view', 'id' => $card->id)); ?>&nbsp;&nbsp;
                    <?php if($card->status == PrepaidCard::STATUS_UNUSED):?>
                        <?php echo CHtml::link(Yii::t('sellerPrepaidCard', '充值'), '#',array('onclick'=>'getRechange('.$card->id.','.$card->number.','.$card->value.')')); ?>
                    <?php endif;?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="page_bottom clearfix">
    <div class="pagination">
        <?php
        $this->widget('CLinkPager', array(
            'header' => '',
            'cssFile' => false,
            'firstPageLabel' => Yii::t('page', '首页'),
            'lastPageLabel' => Yii::t('page', '末页'),
            'prevPageLabel' => Yii::t('page', '上一页'),
            'nextPageLabel' => Yii::t('page', '下一页'),
            'maxButtonCount' => 13,
            'pages' => $cards->pagination
        ));
        ?>  
    </div>
</div>
<!-- 导出execl表 -->
<div  id="export-all" class="pager" style="display:none;">
        <?php if ($exportPages->getItemCount() > 0): ?>
        <div class="pager">
            （每份<?php echo $exportPages->pageSize; ?>条记录）:
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $exportPages,
                'cssFile' => false,
                'maxButtonCount' => 10000,
                'header' => false,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                'firstPageLabel' => false,
                'lastPageLabel' => false,
            ))
            ?>  
            <?php if ($totalCounts <= $exportPages->pageSize): ?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/seller/'.$exportPages->route, $exportPages->params) ?>" ><?php echo Yii::t('main', '导出全部') ?></a>
            <?php endif; ?>
        </div>
        <?php else: ?>
            <?php echo Yii::t('main','没有数据') ?>
        <?php endif; ?>
    </div>

<!-- 弹窗充值 -->
<div id="rechange-all" class="rechange" style="display:none;">  
</div>

<script type="text/javascript" language="javascript" src="/js/iframeTools.source.js"></script>
<script>
    function getExcel() {
        art.dialog({
            content: $("#export-all").html(),
            title: '<?php echo Yii::t('main', '导出excel(该窗口在3秒后自动关闭)') ?>',
            time: 3
        }); 
    }  
            
    function getRechange(id,number,value) {
        var str = '';
        str += '<form id="prepaidcard-form" action="/prepaidCard/viewRechange/'+id+'.html" method="post" >';
        str += '<input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>" /> '
        str += '<p> <label>充值卡号：</label><b>'+number+'</b></p><br>';
        str += '<p> <label>积分：</label><b>'+value+'</b></p><br>';
        str += '<p> <label>手机号码：</label><input type="text" id="phone" class="inputtxt1" name="mobile" maxLength="11" onblur="findGW(this)"></p><br>';
        str += '<p> <label>GW号码：</label><input type="text" class="inputtxt1" readonly = "true" id="gaiNum" name="num" ></p><br>';
        str += '<p> <input class="sellerInputBtn01" id="sub" style="cursor:not-allowed" type="submit" value="确定" disabled><span class="cd-msg"></span></p>';
        str += '</form>';
        $("#rechange-all").html(str);
        art.dialog({
            content: $("#rechange-all").html(),
            title: '<?php echo Yii::t('main', '充值') ?>'
        });
    }
    
    $('#phone').live('keypress',function(e){
        if(e.which === 13) {
            var phone = $(this).val();  //获取元素的值
            var num = $("#gaiNum").val();
            if(phone === ''){     //判断值是否为空
                $('.cd-msg').text('手机号码不能为空！');
                return false;     
            } else if(num === '') {
                findGW(this);
                $("#sub").css('cursor','pointer').removeAttr('disabled');
                $('.cd-msg').text('');
                return false;
            }
        }
    }).live('blur',function(e){
        var phone = $(this).val();  //获取元素的值
        var num = $("#gaiNum").val();
        if(phone === ''){     //判断值是否为空
            $('.cd-msg').text('手机号码不能为空！');
            return false;     
        } else if(num === '') {
            findGW(this);
            $("#sub").css('cursor','pointer').removeAttr('disabled');
            $('.cd-msg').text('');
            return false;
        }
    }).live('keyup',function(){
        RepNumber(this);
        return false;
    }).live('change', function(e) {
        if('' === $(this).val()) {
            $("#sub").css('cursor','not-allowed').prop('disabled',true);
            $('.cd-msg').text('');
        }
    });
    
//    $("#sub").live('click',function(){
//        var phone = $("#phone").val();  //获取元素的值
//        var num = $("#gaiNum").val();
//        if(phone === ''){     //判断值是否为空
//            alert('手机号码不能为空！');
//            return false;     
//        } else if(num === '') {
//            alert('手机号码不存在');
//            return false;
//        }
//        
//    });   

    function findGW(obj) {
        var mobile = $(obj).val();
        if(mobile !== '') {
            var baseUrl = '/prepaidCard/findGW?mobile='+mobile+ '&YII_CSRF_TOKEN=' + '<?php echo Yii::app()->request->csrfToken ?>';
            $.ajax({
                cache: false,
                dataType: 'json',
                url: baseUrl,
                success: function (data) {
    //                console.log(data.length); 
                    if (data.length > 1) {
    //                        console.log(data);                        
                        var gnum = '';
                        gnum += '<select name="sel" id="gaiNum" >';
                        for (var v = 0; v < data.length; v++) {
                            gnum += '<option>' + data[v].gai_number + '</option>';
                        }
                        gnum += '</select>';
                        $('#gaiNum').replaceWith(gnum);                   
                    } else if (data.length === 1) {
                        $('#gaiNum').replaceWith('<input type="text" class="inputtxt1" readonly = "true" id="gaiNum" name="num" >');    
                        $("#gaiNum").val(data[0].gai_number);                 
                    } else if(data.length === 0) {
                        $('#gaiNum').replaceWith('<input type="text" class="inputtxt1" readonly = "true" id="gaiNum" name="num" >');
                        if ($('#gaiNum').val() === '') {
                            $('.cd-msg').text('手机号码不存在！');
                            $("#sub").css('cursor','not-allowed').prop('disabled',true);
                        }
                    }           
                }
            })      
        } else {
            $('#gaiNum').replaceWith('<input type="text" class="inputtxt1" readonly = "true" id="gaiNum" name="num" >');
        }
    }
    
    //表单禁止输入字母和其他字符，只能输入数字
    function RepNumber(obj) {
        var reg = /^[\d]+$/g;
         if (!reg.test(obj.value)) {
             var txt = obj.value;
             txt.replace(/[^0-9]+/, function (char, index, val) {//匹配第一次非数字字符
                obj.value = val.replace(/\D/g, "");//将非数字字符替换成""
                var rtextRange = null;
                if (obj.setSelectionRange) {
                    obj.setSelectionRange(index, index);
                } else {//支持ie
                    rtextRange = obj.createTextRange();
                    rtextRange.moveStart('character', index);
                    rtextRange.collapse(true);
                    rtextRange.select();
                }
            })
         }
     }
</script>