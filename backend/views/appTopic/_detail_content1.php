<table id='imageData' width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come"  style='background-color:gray'>
<tbody id='imageInfo' style='background-color:gray'>
    <tr>
        <th colspan="2" class="title-th even">横拉图片信息</th>
    </tr>
    <tr>
        <th><?php echo CHtml::htmlButton(Yii::t('appTopic', '新增'),array('id'=>'addImage','class'=>'reg-sub')); ?></th>
        <th></th>
    </tr>
    <tr>
        <th colspan="2" style='text-align:center'>图片列</th>
    </tr>
    
    <?php if(isset($detail_content['image']) && !empty($detail_content['image']) && !$model->isNewRecord):?>
    <?php $key = 0;foreach($detail_content['image'] as $val):?>
    <tr>
        <th style="width: 220px" class="odd">
              横拉图片：
        </th>
        <td class="odd">
                <input class="newimagelist" type='file' name='imageList[]'/>
                <input class="oldimagelist" type='hidden' name='imageListVal[]' value='<?php echo $val ?>'/>
                <img width="220px" height="70px" src="<?php echo ATTR_DOMAIN.'/'.$val?>" alt="">
                <?php if($key>0) echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delImage','class'=>'reg-sub')); ?>
        </td>
        
    </tr>
    <?php $key++;endforeach;?>
    <?php else:?>
    <tr>
        <th style="width: 220px" class="odd">
               横拉图片：
        </th>
        <td class="odd">
                <input  class="newimagelist" type='file' name='imageList[]' />
        </td>
    </tr>
    <?php endif?>
</tbody>
</table>
<table id='goodsData' width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr><th colspan="2" class="title-th even">竖拉商品图片信息</th></tr>
    <tr>
        <th><?php echo CHtml::htmlButton(Yii::t('appTopic', '新增'),array('id'=>'addGoods','class'=>'reg-sub')); ?></th>
        <th></th>
    </tr>
    <?php if(isset($detail_content['imgGoods']) && !empty($detail_content['imgGoods']) && !$model->isNewRecord):?>
    <?php $key = 0;foreach($detail_content['imgGoods'] as $val):?>
    <tbody id='goodsInfo' style='background-color:gray'>
    <tr>
        <th colspan="2" style='text-align:center'>商品列<?php if($key>0) echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?></th>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
               商品id：
        </th>
        <td class="odd">
            <input class="text-input-bj  middle ajaxgoodsIds" onblur="checkGoodId(this)" name="goodsIds[]" id="goodsIds" type="text" value="<?php echo $val['id']?>">
        </td>
    </tr>
    <tr>
         <th style="width: 220px" class="odd">
              商品介绍：
        </th>
        <td class="odd">
            <textarea class="ajaxgoodsintro" name="goodsIntro[]" style='height:100px;width:200px'><?php echo $val['goodsIntro']?></textarea>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
              商品图片：
        </th>
        <td class="odd">
            <input class="newgoodsimg" type='file' name='goodsImgs[]' />
            <img width="220px" height="70px" src="<?php echo ATTR_DOMAIN.'/'.$val['image']?>" alt="">
            <input class="oldgoodsimg" type='hidden' name='goodsImgsVal[]' value='<?php echo $val['image']?>'/>
            <?php if(isset($val['width']) && isset($val['height'])){ ?>
                <p>宽度：<?php echo $val['width'] ?> ;高度：<?php echo $val['height'] ?></p>
                <?php } ?>
        </td>
    </tr>
    </tbody>
    <?php $key++;endforeach;?>
    <?php else:?>
    <tbody id='goodsInfo' style='background-color:gray'>
    <tr>
        <th colspan="2" style='text-align:center'>商品列</th>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
               商品id：
        </th>
        <td class="odd">
            <input class="text-input-bj  middle ajaxgoodsIds" onblur="checkGoodId(this)" name="goodsIds[]" id="goodsIds" type="text">
        </td>
    </tr>
    <tr>
         <th style="width: 220px" class="odd">
              商品介绍：
        </th>
        <td class="odd">
            <textarea class="ajaxgoodsintro" class="ajaxgoodsintro" name="goodsIntro[]" style='height:100px;width:200px'></textarea>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
             商品图片：
        </th>
        <td class="odd">
            <input class="newgoodsimg" type='file' name='goodsImgs[]' />
        </td>
    </tr>
    </tbody>
    <?php endif?>
</table>
<script type='text/javascript'>
var tbody = '<tbody id="goodsInfo">';
      tbody+='<tr>';
	 tbody+='<th colspan="2" style="text-align:center">商品列&nbsp;&nbsp;&nbsp;<?php echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?></th>';
	 tbody+='</tr>';
    tbody+='<tr>';
	tbody+='<th style="width: 220px" class="odd">';
    tbody+='商品id：';
    tbody+='</th>';
    tbody+='<td class="odd">';
    tbody+='<input class="text-input-bj  middle ajaxgoodsIds" onblur="checkGoodId(this)" name="goodsIds[]" id="goodsIds" type="text">';
    tbody+='</td>';
    tbody+='</tr>';
    tbody+='<tr>';
    tbody+='<th style="width: 220px" class="odd">';
    tbody+='商品介绍：';
    tbody+='</th>';
    tbody+='<td class="odd">';
    tbody+='<textarea class="ajaxgoodsintro" name="goodsIntro[]" style="height:100px;width:200px"></textarea>';
    tbody+='</td>';
    tbody+='</tr>';
    tbody+='<tr>';
    tbody+='<th style="width: 220px" class="odd">';
    tbody+='商品图片：';
    tbody+='</th>';
    tbody+='<td class="odd">';
    tbody+='<input class="newgoodsimg" type="file" name="goodsImgs[]"/>';
    tbody+='</td>';
    tbody+='</tr>';
    
    tbody+='</tbody>';
var image = '<tbody id="ImageInfo">';
    image+= '<tr>';
	image+= '<th style="width: 220px" class="odd">';
	image+= '横拉图片：';
	image+= '</th>';
	image+= '<td class="odd">';
	image+= '<input class="newimagelist" type="file" name="imageList[]" /><?php echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delImage','class'=>'reg-sub')); ?>';
	image+= '</td>';
	image+= '</tr>';
	image+= '</tbody>';
	
$('#addImage').click(function(){
	$('#imageData').append(image);
});

$('#delImage').live('click',function(){
    if(confirm("确定要删除？")){
	$(this).parent().parent().remove();
    }
})

	
$('#addGoods').click(function(){
	$('#goodsData').append(tbody);
});

$('#delGoods').live('click',function(){
    if(confirm("确定要删除？")) {
        $(this).parent().parent().parent().remove();
    }
})
//ajax异步检查商品id
function checkGoodId(obj){
    var code = $(this).attr("data-code");
    var url = '<?php echo Yii::app()->createAbsoluteUrl('/appTopic/chechkProductId') ?>';
    var id = $(obj).val();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {code: code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', id: id},
        success: function(data) {
            if (data.error) {
                // var dialog = art.dialog({icon: 'error', content: data.error});
                alert(data.error);
            }
        }
    });
}
//    表单前端验证
$("form").submit( function () {
    var errorFlag = false;
//    $('.errorMessage').each(function(i){
//        $(this).remove();
//    })
    $('.newimagelist').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if($(this).val() == ''){

            if($(this).siblings('.oldimagelist').val() ==  undefined){
                $(this).siblings('.errorMessage').remove();
                if($(this).siblings('#delImage').length > 0){
                    $(this).siblings('#delImage').after('<div class= "errorMessage" >请上传图片</div>')
                }else{
                    $(this).after('<div class= "errorMessage" >请上传图片</div>')
                }
                errorFlag= true;
            }
        }
    })
    $('.newgoodsimg').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if($(this).val() == ''){
            if($(this).siblings('.oldgoodsimg').val() ==  undefined){
                $(this).siblings('.errorMessage').remove();
                $(this).after('<div class= "errorMessage" >请上传商品图片</div>')
                errorFlag= true;
            }
        }
    })
    $('.ajaxgoodsIds').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if(isNaN($(this).val())){
            $(this).after('<div class= "errorMessage" >商品id只能填写数字</div>')
            errorFlag= true;
        }
        if($(this).val() == ''){
            $(this).siblings('.errorMessage').remove();
            $(this).after('<div class= "errorMessage" >请填写商品id</div>')
            errorFlag= true;
        }
    })
    $('.ajaxgoodsintro').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if($(this).val() == ''){
            $(this).siblings('.errorMessage').remove();
            $(this).after('<div class= "errorMessage" >请填写商品信息</div>')
            errorFlag= true;
        }
    })
    if(errorFlag){
        return false;
    }else{
        return true;
    }

} );
</script>