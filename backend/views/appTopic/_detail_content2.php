<table id='imageData' width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come"  style='background-color:gray'>
<tbody id='goodimageInfo' style='background-color:gray'>
    <tr>
        <th colspan="2" class="title-th even">详情内容</th>
    </tr>
 
    <tr>
        <th colspan="2" style='text-align:center'>详情内容标题</th>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
               <?php echo '专题描述：'?><span class="required">*</span>
        </th>
        <td class="odd">
               <textarea  class="ajaxtitle" name="title" style='height:100px;width:200px'><?php if(isset($detail_content['profile'])) echo $detail_content['profile']?></textarea><span>(最多输入120个字)</span>
        </td>
    </tr>
</tbody>
</table>
<table id='goodsData' width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
<tbody>
<tr>
    <th colspan="2" style='text-align:center'>
        <?php echo CHtml::htmlButton(Yii::t('appTopic', '新增商品'),array('id'=>'addGoods','class'=>'reg-sub-01')); ?>
        
    </th>
</tr>
</tbody>
<?php if(isset($detail_content['goods']) && !empty($detail_content['goods']) && !$model->isNewRecord):?>
<?php foreach($detail_content['goods'] as $key=>$val):?>
    <tbody id='goodsInfo' class ="goodsInfoTable">
    <tr>
    
        <th colspan="2" style='text-align:center'>专题商品列表
         <?php echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?>
        </th>
       
    </tr>
    <tr class='goodsListId'>
        <th style="width: 220px" class="odd">
               <?php echo '商品id：'?>
        </th>
        <td class="odd">
            <input class="text-input-bj  middle ajaxgoodsids" onblur="checkGoodId(this)" name="goodsIds[<?php echo $key?>]" value='<?php echo $val['id']?>' id="goodsIds" type="text">
        </td>
       </tr>
       
      <tr>
        <th style="width: 220px" class="odd">排序：</th>  
      <td class="odd">
            <input class="text-input-bj  middle ajaxorders"  name="goodsorders[<?php echo $key?>]" value='<?php if(isset($val['orders']))echo $val['orders']?>' id="ordersId" type="text">
       </td>
    </tr>
    
    <tr class='goodsListInfo'>
         <th style="width: 220px" class="odd">
               <?php echo '商品介绍：'?>
        </th>
        <td class="odd">
            <textarea class="ajaxgoodsintro" name="goodsIntro[<?php echo $key?>]" style='height:100px;width:200px'><?php echo $val['profile']?></textarea>
        </td>
    </tr>
   <tr>
       <th colspan="2" style='text-align:center'>
<!--        --><?php echo CHtml::htmlButton(Yii::t('appTopic', '新增图片'),array('id'=>'addImage','class'=>'reg-sub-01')); ?>
<!--        -->
       </th>
   </tr>
    
    <tr id='imageInfo' params='<?php echo $key?>'>
        <th style="width: 220px" class="odd">
               <?php echo '商品图片：'?>
        </th>
        
        <td class="odd">
        <?php foreach($val['img'] as $k=>$v):?>
        <span ><?php ?>
            <input class="newgoodsimgs" type='file' name='goodsImgs[<?php echo $key?>][]' />
            <img width="220px" height="70px" src="<?php echo ATTR_DOMAIN.'/'.$v?>" alt="">
            <input class="oldgoodsimgs" type='hidden' name='goodsImageListVal[<?php echo $key?>][]' value='<?php echo $v?>'/><?php if($k!=0){echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delImage','class'=>'reg-sub')); }?>
            </br>
        </span>
        <?php endforeach;?>
        </td>
    </tr>
    </tbody>
<?php endforeach;?>
<?php else:?>
<tbody id="goodsInfo" class ="goodsInfoTable" >
    <tr>
    
        <th colspan="2" style="text-align:center">专题商品列表
         <?php echo CHtml::htmlButton(Yii::t('appTopic', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?>
         </th>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">商品id：<span class="required">*</span></th>
        <td class="odd">
            <input class="text-input-bj  middle ajaxgoodsids" onblur="checkGoodId(this)" name="goodsIds[0]"  id="goodsIds" type="text">
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">排序：<span class="required">*</span></th>
       <td class="odd">
            <input class="text-input-bj  middle ajaxorders"  name="goodsorders[0]" id="ordersId" type="text">
       </td>
    </tr>
    <tr class="goodsListInfo">
         <th style="width: 220px" class="odd">商品介绍：<span class="required">*</span></th>
        <td class="odd">
            <textarea class="ajaxgoodsintro" name="goodsIntro[0]" style="height:100px;width:200px"></textarea>
        </td>
    </tr>
   <tr>
       <th colspan="2" style="text-align:center">
<!--        --><?php echo CHtml::htmlButton(Yii::t("appTopic", "新增图片"),array("id"=>"addImage","class"=>"reg-sub-01")); ?>
       </th>
   </tr>
    <tr class="imageInfo" params='0'>
        <th style="width: 220px" class="odd">商品图片：<span class="required">*</span></th>        
        <td id='imagelist'>
            <span class='firstImg'>
                <input class="newgoodsimgs" type="file" name="goodsImgs[0][]" /></br>
            </span>
        </td>
    </tr>
</tbody>
<?php endif;?>
</table>
<script type='text/javascript' language="javascript">
var i = <?php echo isset($key)?$key:0?>;

function gettbody(k)
{
	var tbody = '<tbody id="goodsInfo" class ="goodsInfoTable">';
	tbody+='<tr>';
	tbody+= '<th colspan="2" style="text-align:center">专题商品列表<?php echo CHtml::htmlButton(Yii::t('appTopicCar', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?></th>';
	tbody+= '</tr>';
	tbody+= '<tr>';
	tbody+= '<th style="width: 220px" class="odd">商品id：</th>';
	tbody+= '<td class="odd">';
	tbody+= '<input class="text-input-bj  middle ajaxgoodsids" onblur="checkGoodId(this)" name="goodsIds['+k+']"  id="goodsIds" type="text">';
	tbody+= '</td>';
	tbody+= '</tr>';
	tbody+= '<tr>';
	tbody+= '   <th style="width: 220px" class="odd">排序：</th>';
	tbody+= '  <td class="odd">';
	tbody+= '        <input class="text-input-bj  middle ajaxorders" name="goodsorders['+k+']"  id="ordersId" type="text">';
	tbody+= '    </td>';
	tbody+= ' </tr>';
	tbody+= '<tr class="goodsListInfo">';
	tbody+= '<th style="width: 220px" class="odd">商品介绍：</th>';
	tbody+= '<td class="odd">';
	tbody+= '<textarea class="ajaxgoodsintro" name="goodsIntro['+k+']" style="height:100px;width:200px"></textarea>';
	tbody+= '</td>';
	tbody+= '</tr>';
	tbody+= '<tr>';
	tbody+= '<th colspan="2" style="text-align:center">';
	tbody+= '<?php echo CHtml::htmlButton(Yii::t("appTopic", "新增图片"),array("id"=>"addImage","class"=>"reg-sub-01")); ?>';
	//tbody+= '';
	tbody+= '</th>';
	tbody+= '</tr>';
	tbody+= '<tr id="imageInfo" params="'+k+'">';
	tbody+= '<th style="width: 220px" class="odd">商品图片：</th>';
	tbody+= '<td class="odd">';
	tbody+= '<span class="firstImg">';
	tbody+= '<input class="newgoodsimgs" type="file" name="goodsImgs['+k+'][]" /></br>';
	tbody+= '</span>';
	tbody+= '</td>';
	tbody+= '</tr>';
	tbody+= '</tbody>';
	return tbody;
}
function getImage(k)
{//var image = '<td>';
    var image = '<span>';
        image+= '<input class="newgoodsimgs" type="file" name="goodsImgs['+k+'][]" /><?php echo CHtml::htmlButton(Yii::t("appTopic", "删除"),array("id"=>"delImage","class"=>"reg-sub")); ?></br>';
        image+= '</span>';
        //image+= '</td>';
        return image;
}
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
$('#addImage').live('click',function(){
	var k = $(this).parent().parent().next().attr('params');
	image = getImage(k);
	$(this).parent().parent().next().children().next().append(image);
})


// $('#delImage').live('click',function(){
// 	var span = $(this).parent().parent().next().children().next().children().last();
//     if(confirm("确定要删除？")) {
//         if ($(span).attr('class') != 'firstImg')$(span).remove();
//     }
// })

$('#delImage').live('click',function(){
    if(confirm("确定要删除？")) {
        $(this).parents('span').remove();
    }
});
	
$('#addGoods').live('click',function(){
	i++;
	tbody = gettbody(i);
	$('#goodsData').append(tbody);
});

// $('#delGoods').live('click',function(){
//     if(confirm("确定要删除？")) {
//         if (i == 0)return;
//         i--;
//         $('#goodsData').children().last().remove();
//     }
// });

$('#delGoods').live('click',function(){
    if(confirm("确定要删除？")) {
        $(this).parents('tbody').remove();
    }
});
//    表单前端验证
$("form").submit( function () {
    var errorFlag = false;
//    $('.errorMessage').each(function(i){
//        $(this).remove();
//    })
    $('.newgoodsimgs').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if($(this).val() == ''){

            if($(this).siblings('.oldgoodsimgs').val() ==  undefined){
                $(this).siblings('.errorMessage').remove();
                $(this).next("#delImage").after('<div class= "errorMessage" >请上传图片</div>')
                errorFlag= true;
            }
        }
    })
    
    
    $('.ajaxgoodsids').each(function(i){
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
    
    
    $('.ajaxorders').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if(isNaN($(this).val())){
            $(this).after('<div class= "errorMessage" >商品排序只能填写数字</div>')
            errorFlag= true;
        }
        if($(this).val() == ''){
            $(this).siblings('.errorMessage').remove();
            $(this).after('<div class= "errorMessage" >请填写商品排序</div>')
            errorFlag= true;
        }
    })

    $('.ajaxtitle').each(function(i){
        $(this).siblings('.errorMessage').remove();

        if($(this).val() == ''){
            $(this).siblings('.errorMessage').remove();
            $(this).after('<div class= "errorMessage" >请填写专题标题</div>')
            errorFlag= true;
        }else if($(this).val().length > 120){
            $(this).siblings('.errorMessage').remove();
            $(this).after('<div class= "errorMessage" >专题标题内容不可超过120个字</div>')
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