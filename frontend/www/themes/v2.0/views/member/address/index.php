<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberAddress', '买入管理') => '',
    Yii::t('memberAddress', '收货地址'),
);
$countAddress = $this->params('maxAddress')-count($address);
?>
<div class="main-contain">
     
  <div class="accounts-box">
      <p class="accounts-title cover-icon"><?php echo Yii::t('memberAddress', '收货地址'); ?></p>
      <div class="address-receiving">
          <div class="address-title"><span class="address-btn"><i class="cover-icon"></i><?php echo Yii::t('memberAddress', '新增收货地址'); ?></span><?php echo Yii::t('memberAddress', '您还可保存').$countAddress.Yii::t('memberAddress', '个收货地址'); ?></div>
          <div class="address-box clearfix">
              <?php foreach ($address as $as): ?>
              <div class="address-item <?php if($as->default == 1){echo 'on';}?>">
                  <div class="item-top clearfix">
                      <span class="item-name"><?php echo $as->real_name; ?></span>
                      <span class="item-default"><?php echo Yii::t('memberAddress', '默认地址'); ?></span>
                      <span class="item-delete"><input type="button" class="btn-delete" value="<?php echo Yii::t('memberAddress', '删除'); ?>" onclick="setId(<?php echo $as->id;?>);"  /></span>
                      <span class="item-editor"><input type="button" class="btn-editor" value="<?php echo Yii::t('memberAddress', '编辑'); ?>" id="editor<?php echo $as->id;?>" onclick="editAddress(<?php echo $as->id;?>);" /></span>
                      <span class="item-set"><input type="button" class="btn-set" value="<?php echo Yii::t('memberAddress', '设置默认'); ?>" onclick="setDefault(<?php echo $as->id;?>);" /></span>
                  </div>
                  <div class="item-content">
                      <p><span><?php echo Yii::t('memberAddress', '所在地区'); ?>：</span><?php echo isset($as->province) ? $as->province->name : ""; ?>-<?php echo isset($as->city) ? $as->city->name : ""; ?>-<?php echo isset($as->district) ? $as->district->name : ""; ?></p>
                      <p><span><?php echo Yii::t('memberAddress', '详细地址'); ?>：</span><?php echo $as->street; ?></p>
                      <p><span><?php echo Yii::t('memberAddress', '邮政编码'); ?>：</span><?php echo $as->zip_code; ?></p>
                      <p><span><?php echo Yii::t('memberAddress', '手机号码'); ?>：</span><?php echo $as->mobile; ?></p>
                      <p><span><?php echo Yii::t('memberAddress', '固定电话'); ?>：</span><?php echo $as->telephone; ?></p>
                  </div>
              </div>
           <?php endforeach; ?>  
              
          </div>
                    
          <!--删除收货地址-->
          <div class="delete-pop">
              <div class="address-bg"></div>
              <div class="delete-pop-bg">
                  <p class="pop-title">您确定删除该收货地址？</p><input type="hidden" id="addressId" value="" />
                  <p class="pop-btn">
                      <input id="submit" class="btn-deter" type="button" value="确定" />
                      <input id="cancel" type="button" class="btn-delete" onclick="hideDiv('delete-pop');" value="取消" />
                  </p>
              </div>
          </div>
          <!--删除收货地址结束-->
          
      </div>
  </div>
   
</div>
<?php if (Yii::app()->user->hasFlash('maxAddress')): ?>
<script language="javascript">
	layer.alert('<?php echo Yii::t('memberAddress', '最多只能添加'.$this->params('maxAddress').'个收货地址!'); ?>');
</script>
<?php endif; ?>

<script language="javascript">
 var load;
$(function(){
    //添加收货地址弹框
    $('.address-title .address-btn').on('click',function(){
        if($('.address-box .address-item').length >= <?php echo $this->params('maxAddress')?>){
            layer.alert('<?php echo Yii::t('memberAddress', '最多只能添加'.$this->params('maxAddress').'个收货地址!'); ?>');
            return;
        }
        load = layer.load(2);
        $.get('<?php echo $this->createAbsoluteUrl('address/add');?>',function(data){
            $('.main-contain .address-receiving').append(data.add);
            $('.address-pop').show();
            layer.close(load);
        },'json')
    })
})    

function setDefault(v){
	window.location.href = '<?php echo $this->createAbsoluteUrl('address/set');?>'+'?id='+v;
}

function setId(v){
	$('#addressId').val(v);
}
//编辑地址
function editAddress(v){
   load = layer.load(2);
    $.get('<?php echo $this->createAbsoluteUrl('address/update');?>',{id:v},function(data){
        $('.main-contain .address-receiving').append(data.address);
        $('.editor-pop').show();
        layer.close(load);
    },'json')
    //window.location.href = '<?php echo $this->createAbsoluteUrl('address/update');?>'+'?id='+v;
}

function hideDiv(v){
	$('.'+v).css('display', 'none');
}

$(document).ready(function(e) {
    $('#submit').click(function (){
	     window.location.href = '<?php echo $this->createAbsoluteUrl('address/delete');?>'+'?id='+$('#addressId').val(); 
    }); 
	
	<?php if(intval($this->getParam('id')) > 0 && $this->action->id == 'update'){?>
	$('.editor-pop').css('display','block');
	<?php }?>
});

$(function(){
    var address_items_height=0;
    $(".address-box .address-item").each(function(){
        if($(this).height()>address_items_height){
            address_items_height=$(this).height();
        }
    })
    $(".address-box .address-item").css("height",address_items_height);
})
</script>
