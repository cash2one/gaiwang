<?php
$this->breadcrumbs = array(
    Yii::t('goods', '宝贝管理') => array('goods/index'),
    Yii::t('goods', '导入商品数据包')
);
$this->beginWidget('CActiveForm',array(
    'id'=> $this->id . '-form',
    'action'=>'/goodsImport/stepReview'
));
?>
<div id="export-step3">
    <div style="width:1002px;margin: 25px 0;height: 26px;padding-top: 6px" class="tips">
        <?php echo sprintf(Yii::t('goods','提示：您每日最多可以提交审核<span class="red">%d</span>条产品，今天已经提交审核<span class="red">%d</span>条，还可以提交审核<span class="red">%d</span>条'),$total,$store->upload_total,($total-$store->upload_total));?>
    </div> 
    <div class="importProgressBar">
        <div class="importProgress_step3"></div>
    </div>
    <div class="importData step3">
        <div class="importTips">
            <span><?php echo Yii::t('goods','成功导入')?><b><?php echo count($data)?></b><?php echo Yii::t('goods','条商品信息')?>，
                <b id="re-1"></b></span>
            导入时间:<?php echo date('Y-m-d H:i:s',$data[0]['create_time'])?>
            <input class="sellerBtn08" type="button" value="放弃提交">
            <input class="sellerBtn06" type="submit" value="提交审核">
            <!--<input class="sellerBtn06 disabled" type="submit" value="提交审核" disabled="disabled"> 灰色状态-->
        </div>
        <table class="mt15 sellerT3 ta_c" width="100%" cellspacing="0" cellpadding="0" border="0" >
            <tr>
                <th  width="8%"  class="bgBlack">
                    <input class="checkAll" type="checkbox" checked="checked">
                    全选
                </th>
                <th  width="22%" class="bgBlack"><?php echo Yii::t('goods','商品名称')?></th>
                <th  width="10%" class="bgBlack"><?php echo Yii::t('goods','商城分类')?></th>
                <th  width="10%" class="bgBlack"><?php echo Yii::t('goods','店铺分类')?></th>
                <th  width="10%" class="bgBlack"><?php echo Yii::t('goods','库存')?></th>
                <th  width="10%" class="bgBlack"><?php echo Yii::t('goods','零售价')?></th>
                <th  width="10%" class="bgBlack"><?php echo Yii::t('goods','运输方式')?></th>
                <th  width="20%" class="bgBlack"><?php echo Yii::t('goods','操作')?></th>
            </tr>
            <?php foreach($data as $k=>$d):?>
            <tr <?php if(in_array($d['name'], $different)){ echo 'class="nameRepeat"';}?>><!-- class="nameRepeat"-->
               
                <td>
                    <input class="checkAll_sub" type="checkbox" name="goods_id[]" checked="checked" value="<?php echo $d['id']?>">
                </td>
                <td class="product_name">
                    <?php echo htmlspecialchars($d['name'])?>
                </td>
                <td><?php echo $d['gname']?></td>
                <td><?php echo $d['sname']?></td>
                <td><?php echo $d['stock']?></td>
                <td>¥<?php echo number_format($d['price'],2)?></td>
                <td>
                    <?php if($d['freight_payment_type'] == Goods::FREIGHT_TYPE_SELLER_BEAR):?>
                    <?php echo Yii::t('goods','包邮')?>
                    <?php elseif($d['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE):?>
                        <span class="transport"><?php echo Yii::t('goods','运输模板:')?></span>
                        <?php echo FreightTemplate::model()->findByPk($d['freight_template_id'])->name;?>
                    <?php endif;?>
                </td>
                <td>
                    <?php if(in_array($d['name'], $different)):?><a href="javascript:;" onclick="rename(<?php echo $d['id']?>,this)"><?php echo Yii::t('goods','重命名')?></a><?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <div class="btn_box">
            <input class="sellerBtn06" type="submit" value="提交审核">
            <!-- <input class="sellerBtn06 disabled" type="submit" value="提交审核" disabled="disabled">-->
            <input class="sellerBtn08" type="button" value="放弃提交">
        </div>
    </div>
</div>
<?php $this->endWidget();?>
<script type="text/javascript" src="<?php echo DOMAIN;?>/js/iframeTools.source.js"></script>
<script type="text/javascript">
    /*重命名提示框*/
    function rename(id,obj){
        var csrfToken = "<?php echo Yii::app()->request->csrfToken;?>";
        var url = "<?php echo $this->createUrl('goodsImport/rename');?>"
        art.dialog.prompt("<?php echo Yii::t('goods','商品名称：') ?>", function(name){
            if(jQuery.trim(name) == "" || name.length>80){
                jQuery('#rename-goods').html('多于80字或者为空，请重新输入').show();
                return false;
            }
            jQuery.ajax({
                type:'POST',
                data:{id:id,YII_CSRF_TOKEN:csrfToken,name:name},
                dataType:'json',
                url:url,
                success:function(data){
                    if(data.error){
                        alert(data.msg);
                    } else {
                        var td = jQuery(obj);
                        td.parent('td').siblings('.product_name').text(name);
                        td.parent('td').children('a').css('display','none');
                        jQuery(obj).parents('tr').removeClass('nameRepeat');
                    }
                }
            })
        }, "");
        $(".aui_icon").css('display','none');
        $(".aui_title").text("<?php echo Yii::t('goods','重命名') ?>");
        var html = '<div class="errorMessage" id="rename-goods" style="display: none"></div>';
        $('.aui_content').append(html);
        $(".aui_content input").css({border:'1px solid #ccc',width:'265'}).after("<span>（限80字）</span>").focus(function(){
            $('#rename-goods').html('').hide();
        }).attr('max','80');
    }
    /*商品信息列表全选*/
    $(".checkAll").click(function(){ 
        if(this.checked){
            $(".checkAll_sub").each(function(){
                this.checked = true;
            }); 
        }else{ 
            $(".checkAll_sub").each(function(){
                this.checked = false;
            }); 
        } 
    });
    jQuery(':button').on('click',function(){
        if(confirm("<?php echo Yii::t('goods','确定放弃提交本次商品信息的审核？放弃后，数据包内商品信息将被删除，不再保存。') ?>")){
            jQuery('form').attr('action',"/goodsImport/stepCancel");
            jQuery('form').submit();
        }
    });
    jQuery(function(){
        var txt = '<?php echo Yii::t('goods','其中有') ?>'+ jQuery('.nameRepeat').length + '<?php echo Yii::t('goods','条信息存在名称相同') ?>';
        jQuery('#re-1').text(txt);
    })
    
    /*实际字符长度*/
    String.prototype.gblen = function() {  
        var len = 0;  
        for (var i=0; i<this.length; i++) {  
            if (this.charCodeAt(i)>127 || this.charCodeAt(i)==94) {  
                 len += 3;  
             } else {  
                 len ++;  
             }  
         }  
        return len;  
    }  
</script>