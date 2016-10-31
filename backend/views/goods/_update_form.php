<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goods-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

<div class="row" style="background: #eee;height: 30px;text-align: center; line-height: 30px; font-weight: 700;">商品基本信息</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>
        <?php
        $i = 0;
        foreach ($testArr as $v):
            ?>
	<div class="row goods-attribute">
            <dl class="spec-bg" nctype="spec_group_dl" nc_type="spec_group_dl_<?php echo $i;?>" <?php echo $v['spec_type']==2?'spec_img="t"':''; ?>>
                <dt><input type="hidden" value="<?php echo $v['spec_name']?>" name="sp_name[<?php echo $v['spec_id']?>]"><?php echo $v['spec_name']?>：</dt>
                    <dd <?php echo $v['spec_type']==2?'nctype="sp_group_val"':''; ?>>
                        <ul class="spec">
                            <?php foreach($v['spec_value'] as $spv):?>
                            <li><span class="checkbox" nctype="input_checkbox">
                                    <input type="checkbox" name="sp_val[<?php echo $v['spec_id']?>][<?php echo $spv['id']?>]" nc_type="<?php echo $spv['id']?>" value="<?php echo $spv['name']?>">
                                </span>
                                <span class="pvname" nctype="pv_name"><input type="text" value="<?php echo $spv['name']?>" maxlength="20"></span>
                            </li>
                            <?php
                                endforeach;
                                $i++;
                                ?>
                           
                        
                          <div class="clear"></div>
                               <?php if($v['spec_type']==2):?>
          <table border="0" cellpadding="0" cellspacing="0" class="spec_table" style="display:none;" nctype="col_img_table">
              <thead>
                <tr>
                  <th>颜色</th>
                  <th class="w250">图片（无图片可不填）</th>
                  <th>已有图片</th>
               </tr>
              </thead>
              <tbody>
              <?php $specValData= SpecValue::model()->findAll('spec_id='.$v['spec_id'])?>
              <?php foreach($specValData as $val):?>
                  
                 <tr style="display:none;" nctype="file_tr_<?php echo $val->id?>">
                  <td><span class="img"><img src="upload/spec/c53bca14dc85bb3af17d8fe91b34e4b2.png_small.png" onerror="this.src='http://shopnc.wanyun.cc/templates/default/images/transparent.gif'"></span><span class="pvname" nctype="pv_name"><?php echo $val->name?></span></td>
                  <td class="w300"><span class="pvname">
                    <input type="file" name="<?php echo $val->name?>" />
                    </span> <span><img class="spec-img" style="border:0;" src="http://shopnc.wanyun.cc/templates/default/images/transparent.gif" /></span></td>
                  <td> 
                     <?php 
                       $spec_picture=  unserialize($model->spec_picture);
                        if($spec_picture!=null){
                       if (array_key_exists($val['id'],$spec_picture )){?>
                      <input type="hidden" name="goods_col_img[<?php echo $val['id'];?>]" value="<?php echo $spec_picture[$val['id']]; ?>">
                       <img src="<?php echo IMG_DOMAIN .'/'.$spec_picture[$val['id']]; ?>" />
                       <?php }}else{
                            echo '';
                        }?>
                  </td>
           </tr>
                   <?php endforeach; ?>
                                
                    <tr>
                       <td colspan="15"><p class="hint" style="padding-left:10px;">支持jpg、jpeg、gif、png格式图片。<br />建议上传尺寸310x310、大小1.00M内的图片。<br />商品详细页选中颜色图片后，颜色图片将会在商品展示图区域展示。</p></td>
                   </tr>
              </tbody>
            </table>
          <?php endif;?>
</ul>
                    </dd>
                </dl>
        </div>
        <?php endforeach;?>
    
        <dl nc_type="spec_dl" class="spec-bg" style="display:none">
            <dt>库存配置：</dt>
            <dd class="spec-dd">
                <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
                    <thead>
                     <?php foreach($data as $v): ?> 
                        <th><?php echo $v['name'];?></th>
                    <?php endforeach; ?>
                    <th><span class="red">*</span>价格</th>
                    <th><span class="red">*</span>库存</th>
                    <th>商品货号</th>
                    </thead>
                    <tbody nc_type="spec_table">
                    </tbody>
                </table>
            </dd>
        </dl>
     
	<div class="row">
		<?php echo $form->labelEx($model,'scategory_id'); ?>
		<?php echo $form->dropDownList($model, 'scategory_id', Scategory::model()->showAllSelectCategory($this->getSession('storeId'),Scategory::SHOW_TOPCATGORY)); ?>
		<?php echo $form->error($model,'scategory_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id',$brand); ?>
		<?php echo $form->error($model,'brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sn'); ?>
		<?php echo $form->textField($model,'sn',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'sn'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'is_publish'); ?>
		<?php echo $form->radioButtonList($model,'is_publish',array(0=>'不发布',1=>'发布'),array('separator'=>'&nbsp;&nbsp;')); ?>
		<?php echo $form->error($model,'is_publish'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	
        <div class="row" style="background: #eee;height: 30px;text-align: center; line-height: 30px; font-weight: 700;">重要信息</div>
	<div class="row">
		<?php echo $form->labelEx($model,'market_price'); ?>
		<?php echo $form->textField($model,'market_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'market_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gai_price'); ?>
		<?php echo $form->textField($model,'gai_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'gai_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->textField($model,'stock',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'show'); ?>
		<?php echo $form->textField($model,'show'); ?>
		<?php echo $form->error($model,'show'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'is_score_exchange'); ?>
		<?php echo $form->textField($model,'is_score_exchange'); ?>
		<?php echo $form->error($model,'is_score_exchange'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'return_score'); ?>
		<?php echo $form->textField($model,'return_score',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'return_score'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'sign_integral'); ?>
		<?php echo $form->textField($model,'sign_integral',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sign_integral'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'fail_cause'); ?>
		<?php echo $form->textField($model,'fail_cause',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'fail_cause'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sales_volume'); ?>
		<?php echo $form->textField($model,'sales_volume',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sales_volume'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'freight_template_id'); ?>
		<?php echo $form->textField($model,'freight_template_id'); ?>
		<?php echo $form->error($model,'freight_template_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'freight_payment_type'); ?>
		<?php echo $form->textField($model,'freight_payment_type'); ?>
		<?php echo $form->error($model,'freight_payment_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gai_income'); ?>
		<?php echo $form->textField($model,'gai_income',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'gai_income'); ?>
	</div>
        <div class="row" style="background: #eee;height: 30px;text-align: center; line-height: 30px; font-weight: 700;">商品详情描述</div>
        <?php foreach($attArr as $v): ?>
	<div class="row">
                <label><?php echo $v['attr_name']?>:</label>
                <select id="Goods_attribute" name="attr[<?php echo $v['id']?>][0]">
                        <?php foreach ($v['attrValue'] as $v): ?>
                    <option value="<?php echo $v->id?>"><?php echo $v->name;?></option>
                        <?php endforeach; ?>
                </select>
		
	</div>
        <?php endforeach; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'thumbnail'); ?>
		<?php echo $form->fileField($model,'thumbnail'); ?>
		<?php echo $form->error($model,'thumbnail'); ?>
                <?php if(!$model->isNewRecord){
                      echo CHtml::image(IMG_DOMAIN.'/'.$model->thumbnail, '', array('width'=>60,'height'=>'60'));
                      echo CHtml::hiddenField('oldThumbnail', $model->thumbnail);
                }?>
                    
                
	</div>

	<div class="row">
		<label>图片列表:</label>
                <?php
                            
                $this->widget('ext.editor.WDueditor', array(
                    'model' => $imgModel,
                    'attribute' => 'path',
                    'base_url'=>'http://member.'.SHORT_DOMAIN,
                    'uploadValue' => '上传图片',
                    // 'uploadCallBack' =>'alert(123);' ,
                    'separate' => '|', //多张图片之间的分隔符
                    'maxNum' => 6, //最多选择的图片数
                    'htmlOptions' => array(
                    'style' => 'display:none',
                    ),
                    'save_path' => 'uploads', //默认是'attachments/UE_uploads'
                    'url' => IMG_DOMAIN   //默认是ATTR_DOMAIN.'/UE_uploads'
                ));
//                var_dump(get_included_files());
                
                ?>
		<?php if (!$model->isNewRecord): ?>
            <ul class="imgList">
                <?php
                     
                    foreach ($imgModelPic as $p):
                        ?>
                        <li id="img_<?php echo $p->id; ?>">
                            <img src="<?php echo IMG_DOMAIN.$p->path; ?>" width="80"/>
                            <a href='javascript:uploadifyRemove("<?php echo $p->id; ?>", "img_")'>删除</a>
                            <input name="imageList[fileId][]" type="hidden" value="<?php echo $p->id; ?>">
                            <input name="imageList[file][]" type="hidden" value="<?php echo $p->path; ?>">
                        </li>
                        <?php endforeach; ?>
            </ul>
            <?php endif;?>
	</div>
          <div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php
            $this->widget('ext.editor.WDueditor', array(
                'model' => $model,
                'base_url'=>'http://member.'.SHORT_DOMAIN,
                'attribute' => 'content',
            ));
            ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	
        <div class="row" style="background: #eee;height: 30px;text-align: center; line-height: 30px; font-weight: 700;">SEO优化信息</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	

	
        <input type="hidden" name="spec_id" value="<?php echo $model->spec_id;?>"/>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
function preventSelectDisabled(oSelect)
{
   //得到当前select选中项的disabled属性。
   var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
   //如果是有disabled属性的话
   if(isOptionDisabled)
   {
      //让他恢复上一次选择的状态，oSelect.defaultSelectedIndex属性是前一次选中的选项index
      //oSelect.selectedIndex = oSelect.defaultSelectedIndex;
	  //让他恢复未选择状态
	  oSelect.selectedIndex = '0';
      return false;
   }
  //如果没有disabled属性的话
   else
   {
	   var currentvalue = oSelect.value;
	   //为了实现下面的验证,先清空选择的项
       oSelect.value = '0';
	   if(checkselected(currentvalue)){
		 	//oSelect.defaultSelectedIndex属性，设置成当前选择的index
	        oSelect.value = currentvalue;
	   }else{
		   //alert("该分类已经选择,请选择其他分类");
		   alert('该分类已经选择,请选择其他分类');
	   }
       return true;
   }
}
function checkselected(currentvalue){
	var result = true;
	jQuery.each($(".sgcategory"),function(){
		if(currentvalue!=0 && currentvalue == $(this).val()){
			result = false;
		}
	});
	return result;
}
</script>
<script>

// 按规格存储规格值数据
var spec_group_checked = ['',''];
var str = '';
var V = new Array();

var spec_group_checked_0 = new Array();
var spec_group_checked_1 = new Array();

$(function(){
	$('tbody[nc_type="spec_table"]').find('input[type="text"]').live('change',function(){
		s = $(this).attr('nc_type');
		V[s] = $(this).val();
	});

	// 商品属性
	attr_selected();
	$('select[nc_type="attr_select"]').change(function(){
		id = $(this).find('option:selected').attr('nc_type');
		name = $(this).attr('attr').replace(/__NC__/g,id);
		$(this).attr('name',name);
	});
	
	
	$('span[nctype="input_checkbox"] > input[type="checkbox"]').click(function(){
		into_array();
	});
//	recursionSpec()方法生成的function形式参考 （ 2个规格）
//	$('input[type="checkbox"]').click(function(){
//		str = '';
//		for (var i=0; i<spec_group_checked[0].length; i++ ){
//			td_1 = spec_group_checked[0][i];
//			for (var j=0; j<spec_group_checked[1].length; j++){
//				td_2 = spec_group_checked[1][j];
//				str += '<tr><td>'+td_1[0]+'</td><td>'+td_2[0]+'</td><td><input type="text" /></td><td><input type="text" /></td><td><input type="text" /></td>';
//			}
//		}
//		$('table[class="spec_table"] > tbody').empty().html(str);
//	});


	// 生成tr
	$('span[nctype="input_checkbox"] > input[type="checkbox"]').click(function(){
//	$('input[type="checkbox"]').click(function(){
		goods_stock_set();
	});

	// 计算商品库存
	$('input[data_type="stock"]').live('change',function(){
		stock_sum();
	});

	// 计算商品价格区间
	$('input[data_type="price"]').live('change',function(){
		price_interval();
	});

	// 提交后不没有填写的价格或库存的库存配置设为默认价格和0
	// 库存配置隐藏式 里面的input加上disable属性
	$('input[type="submit"]').click(function(){
		$('input[data_type="price"]').each(function(){
			if($(this).val() == ''){
				$(this).val($('input[name="goods_store_price"]').val());
			}
		});
		$('input[data_type="stock"]').each(function(){
			if($(this).val() == ''){
				$(this).val('0');
			}
		});
		if($('dl[nc_type="spec_dl"]').css('display') == 'none'){
			$('dl[nc_type="spec_dl"]').find('input').attr('disabled','disabled');
		}
	});
	
});

// 将选中的规格放入数组
function into_array(){
                
                <?php
                    $i=0;
                    $t=  unserialize($model->spec_name);
                    foreach ($t as $k=>$v):
                    ?>
		spec_group_checked_<?php echo $i?> = new Array();
		
		$('dl[nc_type="spec_group_dl_<?php echo $i?>"]').find('input[type="checkbox"]:checked').each(function(){
			i = $(this).attr('nc_type');
			v = $(this).val();
			//alert(spec_group_checked_0.length);
			spec_group_checked_<?php echo $i?>[spec_group_checked_<?php echo $i?>.length] = [v,i];
		});
		spec_group_checked[<?php echo $i?>] = spec_group_checked_<?php echo $i?>;
		<?php 
                $i++;
                endforeach;
               // $i++;
                ?>
//		spec_group_checked_1 = new Array();
//		$('dl[nc_type="spec_group_dl_1"]').find('input[type="checkbox"]:checked').each(function(){
//			i = $(this).attr('nc_type');
//			v = $(this).val();
//			spec_group_checked_1[spec_group_checked_1.length] = [v,i];
//		});
//
//		spec_group_checked[1] = spec_group_checked_1;
//		//alert(spec_group_checked[1]);
//		
//		spec_group_checked_2 = new Array();
//		$('dl[nc_type="spec_group_dl_2"]').find('input[type="checkbox"]:checked').each(function(){
//			i = $(this).attr('nc_type');
//			v = $(this).val();
//			spec_group_checked_2[spec_group_checked_2.length] = [v,i];
//		});
//
//		spec_group_checked[2] = spec_group_checked_2;
}

// 生成库存配置
function goods_stock_set(){
	//  店铺价格 商品库存改为只读
	$('input[name="goods_store_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
	$('input[name="goods_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
	
	$('dl[nc_type="spec_dl"]').show();
	str = '<tr>';
        <?php 
        $i=0;
         $t=  unserialize($model->spec_name);
        foreach ($data as $k=>$v):?>
	for (var i_<?php echo $i;?>=0; i_<?php echo $i;?><spec_group_checked[<?php echo $i;?>].length; i_<?php echo $i;?>++){
		td_<?php echo $i;?> = spec_group_checked[<?php echo $i;?>][i_<?php echo $i;?>];
		
        <?php $i++; endforeach;?>      
			var spec_bunch = 'i_';
                        <?php 
                         $i=0;
                         $t=  unserialize($model->spec_name);
                        foreach ($data as $k=>$v):?>
                            spec_bunch += td_<?php echo $i;?>[1];
                        <?php $i++; endforeach;?> 
                        <?php 
                        $i=0;
                         $t=  unserialize($model->spec_name);
                        foreach ($data as $k=>$v):?>    
                            str +='<td><input type="hidden" name="spec['+spec_bunch+'][sp_value]['+td_<?php echo $i;?>[1]+']" value='+td_<?php echo $i;?>[0]+' />'+td_<?php echo $i;?>[0]+'</td>';
                        <?php $i++;endforeach;?> 
			str +='<td><input class="text" type="text" name="spec['+spec_bunch+'][price]" data_type="price" nc_type="'+spec_bunch+'|price" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][stock]" data_type="stock" nc_type="'+spec_bunch+'|stock" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][sku]" nc_type="'+spec_bunch+'|sku" value="" /></td></tr>';
<?php foreach ($data as $k=>$v):?>
}
<?php endforeach;?>

	if(str == '<tr>'){
		//  店铺价格 商品库存取消只读
		$('input[name="goods_store_price"]').attr('readonly','').css('background','');
		$('input[name="goods_storage"]').attr('readonly','').css('background','');
		$('dl[nc_type="spec_dl"]').hide();
	}
	$('tbody[nc_type="spec_table"]')
		.empty()
		.html(str)
		.find('input[type="text"]').each(function(){
			s = $(this).attr('nc_type');
			try{$(this).val(V[s])}catch(ex){$(this).val('')};
			if($(this).attr('data_type') == 'price' && $(this).val() == ''){
				$(this).val($('input[name="goods_store_price"]').val());
			}
		});
	stock_sum();		// 计算商品库存
	price_interval();	// 计算价格区间
}

// 计算商品库存
function stock_sum(){
	var stock = 0;
	$('input[data_type="stock"]').each(function(){
		if($(this).val() != ''){
			stock += parseInt($(this).val());
		}
	});
	$('input[name="goods_storage"]').val(stock);
}

// 计算价格区间
function price_interval(){
	var max = 0.01;
	var min = 10000000;
	$('input[data_type="price"]').each(function(){
		if($(this).val() != ''){
			max = Math.max(max,$(this).val());
			min = Math.min(min,$(this).val());
		}
	});
	if(max > min){
		$('input[name="goods_store_price_interval"]').val(number_format(min,2)+' - '+number_format(max,2));
	}else {
		$('input[name="goods_store_price_interval"]').val('');
	}
	if(min != 10000000){
		$('input[name="goods_store_price"]').val(number_format(min,2));
	}
}


function attr_selected(){
	$('select[nc_type="attr_select"] option:selected').each(function(){
		id = $(this).attr('nc_type');
		name = $(this).parents('select').attr('attr').replace(/__NC__/g,id);
		$(this).parents('select').attr('name',name);
	});
}

</script>
<script>
// 修改规格名称 上传颜色图片JS
$(function(){
	// 修改规格名称
	$('dl[nctype="spec_group_dl"]').find('input[type="checkbox"]').click(function(){
		pv = $(this).parents('li').find('span[nctype="pv_name"]');
		if(typeof(pv.find('input').val()) == 'undefined'){
			pv.html('<input type="text" maxlength="20" value="'+pv.html()+'" />');
		}else{
			pv.html(pv.find('input').val());
		}		
	});
	
	$('span[nctype="pv_name"] > input').live('change',function(){
		change_img_name($(this));	// 修改相关的颜色名称
		into_array();		// 将选中的规格放入数组
		goods_stock_set();	// 生成库存配置
	});
	

	// 上传颜色图片
	$('dd[nctype="sp_group_val"]').find('input[type="checkbox"]').click(function(){
		file_table_show($(this));
	});

	$('table[nctype="col_img_table"]').find('input[type="file"]').live('change',function(){
		src = getFullPath($(this)[0]);
		$(this).parents('tr').find('.spec-img').attr('src',src).show();
	});
	
});

// 修改相关的颜色名称
function change_img_name(Obj){
	var S = Obj.parents('li').find('input[type="checkbox"]');
	S.val(Obj.val());
	var V = $('tr[nctype="file_tr_'+S.attr('nc_type')+'"]');
	V.find('span[nctype="pv_name"]').html(Obj.val());
	V.find('input[type="file"]').attr('name', Obj.val());
}

// 选中意思后显示图片上传框js
function file_table_show(Obj){
	var V = $('dl[spec_img="t"]').find('input[type="checkbox"]:checked');
	if(V.length == 0){	// 长度为零table隐藏
		$('table[nctype="col_img_table"]').hide();
	}else{				// 否则显示table
		$('table[nctype="col_img_table"]').show();
	}
	var S = $('tr[nctype="file_tr_'+Obj.attr('nc_type')+'"]');
	if(S.css('display') == 'none'){
		S.show();
	}else{
		S.hide();
	}
}


</script>
<script>
//  编辑商品时处理JS
$(function(){
	var E_SP = new Array();
	var E_SPV = new Array();
        <?php foreach ($goods2Spec as $v):?>
              E_SP[<?php echo $v['spec_value_id']?>]='<?php echo $v['spec_value_name']?>';
         <?php endforeach;?>
//	E_SP[1] = '白色';E_SP[17] = '大码22';E_SP[18] = 'XL';E_SP[36] = '规格值1';E_SP[38] = '规格值3';
        <?php foreach($specJs as $v):?>
              E_SPV['i_<?php echo $v['sp_val']?>|price'] = '<?php echo $v['price']?>'; 
               E_SPV['i_<?php echo $v['sp_val']?>|stock'] = '<?php echo $v['stock']?>'; 
                E_SPV['i_<?php echo $v['sp_val']?>|sku'] = '<?php echo $v['code']?>'; 
        <?php endforeach;?>   
//E_SPV['i_36118|price'] = '500.00';E_SPV['i_36118|stock'] = '20';E_SPV['i_36118|sku'] = '';E_SPV['i_38118|price'] = '500.00';E_SPV['i_38118|stock'] = '10';E_SPV['i_38118|sku'] = '';E_SPV['i_36117|price'] = '500.00';E_SPV['i_36117|stock'] = '50';E_SPV['i_36117|sku'] = '';E_SPV['i_38117|price'] = '500.00';E_SPV['i_38117|stock'] = '10';E_SPV['i_38117|sku'] = '';	V = E_SPV;
	$('.goods-attribute').find('input[type="checkbox"]').each(function(){
		$('dl[nc_type="spec_dl"]').show();
		//  店铺价格 商品库存改为只读
		$('input[name="goods_store_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		$('input[name="goods_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		s = $(this).attr('nc_type');
		if (!(typeof(E_SP[s]) == 'undefined')){
			$(this).attr('checked',true);
			v = $(this).parents('li').find('span[nctype="pv_name"]');
			if(E_SP[s] != ''){
				$(this).val(E_SP[s]);
				v.html('<input type="text" maxlength="20" value="'+E_SP[s]+'" />');
			}else{
				v.html('<input type="text" maxlength="20" value="'+v.html()+'" />');
			}
			change_img_name($(this));			// 修改相关的颜色名称
		}
	});

	into_array();	// 将选中的规格放入数组

	str = '<tr>';
//	for (var i_0=0; i_0<spec_group_checked[0].length; i_0++){td_1 = spec_group_checked[0][i_0];
//        for (var i_1=0; i_1<spec_group_checked[1].length; i_1++){td_2 = spec_group_checked[1][i_1];
//        for (var i_2=0; i_2<spec_group_checked[2].length; i_2++){td_3 = spec_group_checked[2][i_2];
//        var spec_bunch = 'i_';
//        spec_bunch += td_1[1];
//        spec_bunch += td_2[1];
//        spec_bunch += td_3[1];
//        str +='<td><input type="hidden" name="spec['+spec_bunch+'][sp_value]['+td_1[1]+']" value='+td_1[0]+' />'+td_1[0]+'</td>';
//        str +='<td><input type="hidden" name="spec['+spec_bunch+'][sp_value]['+td_2[1]+']" value='+td_2[0]+' />'+td_2[0]+'</td>';
//        str +='<td><input type="hidden" name="spec['+spec_bunch+'][sp_value]['+td_3[1]+']" value='+td_3[0]+' />'+td_3[0]+'</td>';
//        str +='<td><input class="text" type="text" name="spec['+spec_bunch+'][price]" data_type="price" nc_type="'+spec_bunch+'|price" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][stock]" data_type="stock" nc_type="'+spec_bunch+'|stock" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][sku]" nc_type="'+spec_bunch+'|sku" value="" /></td></tr>';
//}
//}
//}
        <?php 
        $i=0;
         $t=  unserialize($model->spec_name);
        foreach ($data as $k=>$v):?>
	for (var i_<?php echo $i;?>=0; i_<?php echo $i;?><spec_group_checked[<?php echo $i;?>].length; i_<?php echo $i;?>++){
		td_<?php echo $i;?> = spec_group_checked[<?php echo $i;?>][i_<?php echo $i;?>];
		
        <?php $i++; endforeach;?>      
			var spec_bunch = 'i_';
                        <?php 
                         $i=0;
                         $t=  unserialize($model->spec_name);
                        foreach ($data as $k=>$v):?>
                            spec_bunch += td_<?php echo $i;?>[1];
                        <?php $i++; endforeach;?> 
                        <?php 
                        $i=0;
                         $t=  unserialize($model->spec_name);
                        foreach ($data as $k=>$v):?>    
                            str +='<td><input type="hidden" name="spec['+spec_bunch+'][sp_value]['+td_<?php echo $i;?>[1]+']" value='+td_<?php echo $i;?>[0]+' />'+td_<?php echo $i;?>[0]+'</td>';
                        <?php $i++;endforeach;?> 
			str +='<td><input class="text" type="text" name="spec['+spec_bunch+'][price]" data_type="price" nc_type="'+spec_bunch+'|price" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][stock]" data_type="stock" nc_type="'+spec_bunch+'|stock" value="" /></td><td><input class="text" type="text" name="spec['+spec_bunch+'][sku]" nc_type="'+spec_bunch+'|sku" value="" /></td></tr>';
<?php foreach ($data as $k=>$v):?>
}
<?php endforeach;?>
	if(str == '<tr>'){
		$('dl[nc_type="spec_dl"]').hide();
		$('input[name="goods_store_price"]').attr('readonly','').css('background','');
		$('input[name="goods_storage"]').attr('readonly','').css('background','');
	}

	$('tbody[nc_type="spec_table"]')
		.empty()
		.html(str)
		.find('input[type="text"]').each(function(){
			s = $(this).attr('nc_type');
			try{$(this).val(E_SPV[s])}catch(ex){$(this).val('')};
		});

	stock_sum();	// 计算商品库存
	$('dd[nctype="sp_group_val"]').find('input[type="checkbox"]:checked').each(function(){
		file_table_show($(this));
	});
});
</script>
<script>
       /* 火狐下取本地全路径 */
function getFullPath(obj)
{
    if(obj)
    {
        //ie
        if (window.navigator.userAgent.indexOf("MSIE")>=1)
        {
            obj.select();
            if(window.navigator.userAgent.indexOf("MSIE") == 25){
            	obj.blur();
            }
            return document.selection.createRange().text;
        }
        //firefox
        else if(window.navigator.userAgent.indexOf("Firefox")>=1)
        {
            if(obj.files)
            {
                //return obj.files.item(0).getAsDataURL();
            	return window.URL.createObjectURL(obj.files.item(0)); 
            }
            return obj.value;
        }
        return obj.value;
    }
}
</script>
<script type="text/javascript">
    function uploadifyRemove(fileId,attrName){
	if(confirm('本操作不可恢复，确定继续？')){
		$.post("<?php echo Yii::app()->createAbsoluteUrl('/Goods/remove')?>",{imageId:fileId,YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken; ?>"},function(res){
			$("#"+attrName+fileId).remove();
		},'json');
	}
}
function uploadifyRemove2(fileId,attrName){
     $("#"+attrName+fileId).remove();
}
</script>