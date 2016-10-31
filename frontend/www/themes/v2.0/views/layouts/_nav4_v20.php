<?php
// 商店菜单导航
/* @var $this Controller */
/** @var $store Store */
$store = $this->store;
$nav = isset($design) ? $design->tmpData[DesignFormat::TMP_MAIN_NAV] : $this->design->tmpData[DesignFormat::TMP_MAIN_NAV];
$storeCollect = WebGoodsData::getCollects($store['id'], 1);
?>
<div class="shop-nav" style="background:<?php echo $store['bg_color'];?>;">
    <div class="shop-nav-main clearfix">
    <?php if($store['logo'] != ''){?>
        <a href="<?php echo $this->createAbsoluteUrl('shop/view',array('id'=>$store['id']));?>" class="shop-logo" title=""><img width="295" height="85" src="<?php echo ATTR_DOMAIN . '/' .$store['logo'];?>"/></a>
    <?php }
	if($store['slogan'] != ''){
	?>    
        <img class="shopBg-img" alt="" width="1200" height="90" src="<?php echo ATTR_DOMAIN . '/' .$store['slogan'];?>"/>
    <?php }?>    
        <div class="shop-collect <?php if($storeCollect>0){echo 'shop-collectSel';}?>" tag="<?php if($storeCollect>0){echo '1';}else{echo '0';}?>"><?php echo Yii::t("goods", "收藏本店"); ?></div>
    </div>
</div>
  	<!--提示框start-->
<div class="prompt-float">
    <div class="prompt-float-content">
        <div class="prompt-float-title">
            <?php echo Yii::t('goods', '提示'); ?>
            <span class="prompt-float-close"></span>
        </div>
        <span class="prompt-info2"></span>
        <input type="hidden" id="isjump" value="0" />
        <input type="button" onclick="goodsJump();" value="<?php echo Yii::t('goods', '确定'); ?>" class="prompt-float-but"/>
    </div>
</div>
<!--提示框end-->
<script language="javascript">
//收藏本店
$(".shop-collect").click(function(){
	var mid="<?php echo Yii::app()->user->id?>";
	if(!parseInt(mid)){
		$('#isjump').val('1');
		$('.prompt-info2').text('<?php echo Yii::t('goods', '请先登录,再进行操作!'); ?>');
	    $(".prompt-float,.pordShareBg").show();
		return;
	}
	$.ajax({
		type: 'GET',
		url: '<?php echo $this->createAbsoluteUrl('/member/StoreCollect/collect');?>',
		data: {'id': <?php echo $store['id'];?>},
		dataType: 'jsonp',
		jsonp:"jsoncallBack",
        jsonpCallback:"dealCollect",
		success: function (data){
		}
    });
});
/*收藏的时候,是否跳转*/
function goodsJump(){
	if($('#isjump').val() == 1){
		window.location.href = '<?php echo $this->createAbsoluteUrl("member/home/login");?>';
	}
	return true;
}
</script>