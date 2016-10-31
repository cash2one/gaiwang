<div class="main-contain">   
  
  <div class="accounts-box">
      <p class="accounts-title cover-icon"><?php echo Yii::t('OrderMember', '订单用户信息'); ?></p>
      <div class="address-receiving">
          <div class="address-title"><span class="address-btn"><i class="cover-icon"></i><?php echo Yii::t('OrderMember', '新增订单用户'); ?></span></div>
          <div class="address-box clearfix">
               <table class="consume-table" border="0" >
                <tr class="consume-title">
                    <td class="table-time"><?php echo Yii::t('wealth', '订单号'); ?></td>
                    <td class="table-time"><?php echo Yii::t('wealth', '姓名'); ?></td>
                    <td class="table-money"><?php echo Yii::t('wealth', '联系方式'); ?></td>
                    <td class="table-types"><?php echo Yii::t('wealth', '身份证号'); ?></td>
                    <td class="table-source"><?php echo Yii::t('wealth', '录入时间'); ?></td>
                </tr>
                
                <?php if ($orderMember): ?>
                <?php foreach ($orderMember as $v): ?>
                <tr>
                    <td valign="top"><?php echo $v->code;?></td>
                    <td valign="top"><?php echo $v->real_name;?></td>
                    <td valign="top"><?php echo $v->mobile; ?></td>
                    <td valign="top"><?php echo $v->identity_number; ?></td>
                    <td valign="top"><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td valign="top" colspan="6"><?php echo Yii::t('wealth','暂无数据') ?></td></tr>
                <?php  endif; ?>

            </table>   
            
              <div class="pageList clearfix">

                <?php
                $this->widget('SLinkPager', array(
                    'header' => '',
                    'cssFile' => false,
                    'firstPageLabel' => Yii::t('page', '首页'),
                    'lastPageLabel' => Yii::t('page', '末页'),
                    'prevPageLabel' => Yii::t('page', '上一页'),
                    'nextPageLabel' => Yii::t('page', '下一页'),
                    'maxButtonCount' => 13,
                    'pages' => $pager,
                    'htmlOptions'=>array(
                        'class'=>'yiiPageer',   //包含分页链接的div的class
                        'id' => 'yw0'
                    )
                ));
                ?>
            </div>
                    
          </div>
      </div>
  </div>
   
</div>

<script type="text/javascript">
 var load;
$(function(){
    //添加收货地址弹框
    $('.address-title .address-btn').on('click',function(){
        
        load = layer.load(2);
        $.get('<?php echo $this->createAbsoluteUrl('orderMember/add');?>',function(data){
            $('.main-contain .address-receiving').append(data.add);
            $('.address-pop').show();
            layer.close(load);
        },'json')
    })
})    
function setId(v){
	$('#addressId').val(v);
}
function hideDiv(v){
	$('.'+v).css('display', 'none');
}
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
