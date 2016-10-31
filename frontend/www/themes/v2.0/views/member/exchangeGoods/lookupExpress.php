<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('memberOrder', '您的位置');?>：</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>"><?php echo Yii::t('memberOrder', '首页');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/order/admin', array('code'=>$code));?>"><?php echo Yii::t('member', '订单中心');?></a>
        <span>&gt</span>
        <?php echo Yii::t('memberOrder', '物流信息');?>
    </div>
    <div class="logistics-details">
        <div class="log-header">
            <span class="title"><?php echo Yii::t('memberOrder', '物流信息');?></span>
        </div>
        
        <?php if($express['express']){?>
        <div class="log-content">
            <p class="log-info" id="express_p">
                <span><?php echo Yii::t('memberOrder', '快递公司');?>：<?php echo $express['express'];?></span>
                <span class="log-num"><?php echo Yii::t('memberOrder', '运单号');?>：<?php echo $express['code'];?></span>
                <a href="<?php echo $expressUrl[$express['express']]?>" class="ems-query"><?php echo Yii::t('memberOrder', '点击进入自助查询');?></a>
            </p>
        </div>
        
        
        <script language="javascript">
			<?php if($express['express']!='' && $express['code']!=''){?>
			$(document).ready(function(e) {
				var url = "<?php echo $this->createUrl('order/getExpressStatus', array('store_name'=>$express['express'], 'code'=>$express['code'], 'time'=>time())); ?>";
				
				$.getJSON(url, function(data) {
					if (data.status != 200) {
						/*layer.alert(data.message);*/
						$("#express_p").after('<p class="log-item"><i class="member-icon address"></i><span>'+data.message+'</span></p>');
					} else {
						var html = '';
						var icon = '';
						$.each(data.data, function(i, item) {
							icon = i<1 ? 'address-first' : '';
							html += '<p class="log-item">';
							html += '<i class="member-icon address '+icon+'"></i>';
							html += ' <span>'+item.time+'  '+item.context+'</span></p>';
						});
						
						html += '<p class="log-tip"><?php echo Yii::t('memberOrder', '注：以上部分信息来自第三方');?></p>';
						$("#express_p").after(html);
					}
				});	
			});
			<?php }?>
		</script>
        <?php }?>
    </div>
    
   <?php $this->renderPartial('_orderinfo',array('orderInfo'=>$this->orderInfo)); ?>  
</div>
