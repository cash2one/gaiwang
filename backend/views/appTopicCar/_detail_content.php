<table id='goodsData' width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr><th colspan="2" class="title-th even">专题商品</th></tr>
    <?php if(isset($subcontent) && !empty($subcontent)):?>
    <?php foreach($subcontent as $val):?>
   
    <tbody id="goodsInfo">
    <tr>
        <th colspan="2" style='text-align:center;background-color:gray'>商品信息 <?php echo CHtml::htmlButton(Yii::t('appTopicCar', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?></th>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
               商品id：
        </th>
        <td class="odd">
            <input class="text-input-bj  middle ajaxgoodsIds"  name="goodsIds[]" id="goodsIds" readonly="true"  type="text" value="<?php echo $val['goodsIds'];?>"/>
            <input class="reg-sub"  type="button" value="确定" onclick="CheckGoods(this)" />
        </td>
    </tr>
    
     <tr>
        <th style="width: 220px" class="odd">
             排序：
        </th>
        <td class="odd">
            <select name="goodOrder[]">
            <?php $arr = array(1,2,3,4,5,6,7,8,9,10,11,12);
            $option = '';
            foreach ($arr as $arrval){
            	if($arrval == $val['goodOrder']){
            		$option .= '<option value ="'.$arrval.'" selected = "selected">'.$arrval.'</option>';
            	}else{
            		$option .= '<option value ="'.$arrval.'">'.$arrval.'</option>';
            	}
            }
            echo $option;
            ?>

            </select>
        </td>
    </tr>
    <tr>
       <th style="width: 220px" class="odd">
              商品分类：
        </th>
        <td>
            <input id="goodCategoryName" name="goodCategoryName[]" readonly="true" type="text" value="<?php echo $val['goodCategoryName'];?>"/>
        </td>
    </tr>
    
     <tr>
       <th style="width: 220px" class="odd">
              商品型号：
        </th>
        <td>
           <input id="goodCode" name="goodCode[]" readonly="true" type="text" value="<?php echo $val['goodCode'];?>"/>
        </td>
    </tr>
    
     <tr>
       <th style="width: 220px" class="odd">
              价格：
        </th>
        <td>
            <input id="goodPrice" name="goodPrice[]" readonly="true" type="text" value="<?php echo $val['goodPrice'];?>"/>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
             图片：
        </th>
        <td class="odd">
         <input class="newgoodsimg" type="file" name="goodsImgs[]"/><span>请上传560*560的图片</span>
         <?php if(isset($error))$val['goodsImgs']="";?>
            <img width="220px" height="70px" src="<?php echo $val['goodsImgs'] == "" ? "" : ATTR_DOMAIN.'/'.$val['goodsImgs']?>" alt="">
            <?php if(isset($val['error'])){?>
            <div class= "errorMessage" >请上传560*560的图片</div></br>
            <?php }?>
            <input class="oldgoodsimg" type='hidden' name='goodsImgsold[]' value='<?php echo $val['goodsImgs']?>'/>
        </td>
<!--             <input class="newgoodsimg" type='file' name='goodsImgs[]' /> -->
        </td>
    </tr>
    </tbody>
 <?php endforeach;?>
    <?php endif?>
   
   <tfoot>
       <tr>
        <th colspan="2" style="text-align:left"><?php echo CHtml::htmlButton(Yii::t('appTopicCar', '新增'),array('id'=>'addGoods','class'=>'reg-sub')); ?></th>
    </tr>
   </tfoot>
</table>

<script type='text/javascript'>
var  tbody = '<tbody  style="background-color:gray">';
tbody+='<tr>';
tbody+='<th colspan="2" style="text-align:center">商品信息&nbsp;&nbsp;&nbsp;<?php echo CHtml::htmlButton(Yii::t('appTopicCar', '删除'),array('id'=>'delGoods','class'=>'reg-sub')); ?></th>';
tbody+='</tr>';

tbody+='<tr>';
tbody+='<th style="width: 220px" class="odd">';
tbody+='商品id：';
tbody+='</th>';
tbody+='<td class="odd">';
tbody+='  <input class="text-input-bj  middle ajaxgoodsIds"  name="goodsIds[]" id="goodsIds"  type="text" />';
tbody+= ' <input class="reg-sub"  type="button" value="确定" onclick="CheckGoods(this)" />';
tbody+='</td>';
tbody+='</tr>';

tbody+= '<tr>'
tbody+= '  <th style="width: 220px" class="odd">'
tbody+= '       排序：'
tbody+= '  </th>'
tbody+= '  <td class="odd">'
tbody+= '  <select name="goodOrder[]">'
tbody+= '    <option value ="1">1</option>'
tbody+= '    <option value ="2">2</option>'
tbody+= '    <option value="3">3</option>'
tbody+= '    <option value="4">4</option>'
tbody+= '    <option value ="5">5</option>'
tbody+= '    <option value ="6">6</option>'
tbody+= '    <option value="7">7</option>'
tbody+= '    <option value="8">8</option>'
tbody+= '    <option value ="9">9</option>'
tbody+= '    <option value ="10">10</option>'
tbody+= '    <option value="11">11</option>'
tbody+= '    <option value="12">12</option>'
tbody+= '  </select>'
tbody+= '  </td>'
tbody+= '</tr>'

tbody+='<tr>';
tbody+='<th style="width: 220px" class="odd">';
tbody+='商品分类：';
tbody+='</th>';
tbody+='<td class="odd">';
tbody+='<input id="goodCategoryName" name="goodCategoryName[]" type="text"/>';
tbody+='</td>';
tbody+='</tr>';

tbody+='<tr>';
tbody+='<th style="width: 220px" class="odd">';
tbody+='商品型号：';
tbody+='</th>';
tbody+='<td class="odd">';
tbody+='<input id="goodCode" name="goodCode[]" type="text"/>';
tbody+='</td>';
tbody+='</tr>';

tbody+='<tr>';
tbody+='<th style="width: 220px" class="odd">';
tbody+='价格：';
tbody+='</th>';
tbody+='<td class="odd">';
tbody+='<input id="goodPrice" name="goodPrice[]" type="text"/>';
tbody+='</td>';
tbody+='</tr>';

tbody+='<tr>';
tbody+='<th style="width: 220px" class="odd">';
tbody+='图片：';
tbody+='</th>';
tbody+='<td class="odd">';
tbody+='<input class="newgoodsimg" type="file" name="goodsImgs[]"/><span>请上传560*560的图片</span>';
tbody+='</td>';
tbody+='</tr>';

tbody+='</tbody>';
	

//ajax异步检查商品id
function CheckGoods(obj){
	var id = $(obj).prev('#goodsIds').val();
// 	alert($("[class='text-input-bj  middle ajaxgoodsIds']").length);
// 	return false;
    var temp = true;
	if(isNaN(id) || $.trim(id).length == 0){
		temp = false;
		alert("商品ID不能为空且商品ID只能填写数字");
		}
	else{
		if($("[class='text-input-bj  middle ajaxgoodsIds']").length > 1){
			$("[class='text-input-bj  middle ajaxgoodsIds']").each(function(){
				if(typeof($(this).attr("readonly"))!= "undefined"){
					if($(this).val() == id){
						alert("你已添加此商品ID,商品ID不能为重复");
							temp = false;
							return false;
						}
					}   
				});
			}
		}
	if(temp){
	var url = '<?php echo Yii::app()->createAbsoluteUrl('/appTopicCar/chechkGoods') ?>';
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', id: id},
        success: function(data) {
            if (data.error) {
                alert(data.error);
            }else{
            	$(obj).parents('tbody').find('#goodCategoryName').val(data.name);
            	$(obj).parents('tbody').find('#goodCode').val(data.code);
            	$(obj).parents('tbody').find('#goodPrice').val(data.price);
            	$(obj).prev('#goodsIds').attr("readonly",true);
            	$(obj).parents('tbody').find('#goodCategoryName').attr("readonly",true);
            	$(obj).parents('tbody').find('#goodCode').attr("readonly",true);
            	$(obj).parents('tbody').find('#goodPrice').attr("readonly",true);
                }
        }
    });
	}

}


$('#addGoods').click(function(){
	if($("#goodsData").children('tbody').length >= 13){
 		alert("最多只能添加12个商品");
 		}else{
 			 $('#goodsData').append(tbody);
 			}	
});

// $('#delGoods').on('click',function(){
//     if(confirm("确定要删除？")) {
//         $(this).parents('tbody').remove();
//     }
// });

$('#delGoods').live('click',function(){
    if(confirm("确定要删除？")) {
        $(this).parents('tbody').remove();
    }
});

//表单提交前验证
$("form").submit(function(){
	 var errorFlag = false;
	 //商品信息
	 $('.ajaxgoodsIds').each(function(i){
	        $(this).siblings('.errorMessage').remove();
	        if(typeof($(this).attr("readonly"))== "undefined"){
	        	 $(this).siblings('input').after('<div class= "errorMessage" >请先确定商品</div>')
	        	 $(this).focus();
		         errorFlag= true;
		    }
	    })
	    //商品图片
	  $('.newgoodsimg').each(function(i){
        $(this).siblings('.errorMessage').remove();
        if($(this).val() == ''){
            if($(this).siblings('.oldgoodsimg').val() ==  undefined || $(this).siblings('.oldgoodsimg').val()==""){
                $(this).siblings('.errorMessage').remove();
                $(this).after('<div class= "errorMessage" >请上传商品图片</div>')
                errorFlag= true;
            }
        }
    });
	    if(errorFlag){
	    	return false;
		}else{
			return true;
		}
	
});
</script>




