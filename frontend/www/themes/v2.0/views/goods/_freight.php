<dl class="pd-info4 pd-info9 clearfix">
    <dt><?php echo Yii::t('goods', '运费'); ?></dt>
    
    <dd>
        <?php
		if($goods['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE){
			$position = Tool::getPosition(); 
			$region      = Region::getRegion2();
			$regionCount = count($region);
		?>
        <span class="pd-info9-font1"><?php echo str_replace('省', '', $goods['province']).$goods['city']; ?>&nbsp;<?php echo Yii::t('goods', '至'); ?>&nbsp;</span>
        <div class="gst-address-info pord-address-info">
            <span id="store-selector"><?php echo str_replace('省', '', $position['province_name']).$position['city_name']; ?></span><ioc></ioc>
            <ul class="gst-address-list clearfix">
            <?php foreach ($region as $k => $v): ?>
                <li><a class="province" id="<?php echo $v['province_id'] ?>" data-value="<?php echo $v['province_id'] ?>" onclick="addAddress(this);return false;" href="#none"><?php echo $v['province_name'] ?></a></li>
                <?php if($k>0 && ($k+1)%5==0){?>
                <li class="gst-address-lower"><ul class="clearfix"></ul></li>
                <?php }?>
            <?php endforeach; ?>
                <?php if($regionCount%5 > 0){?><li class="gst-address-lower"><ul class="clearfix"></ul></li><?php }?>
            </ul>
        </div>
        <?php }?>
        
        <span class="pd-info9-font1" id="freight_text">
		<?php if ($goods['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE): ?>
			  <?php echo Goods::freightPayType($goods['freight_payment_type']); ?>
          <?php else: ?>
              <?php $fee = ComputeFreight::compute($goods['freight_template_id'], $goods['size'], $goods['weight'], $position['city_id'], $goods['valuation_type']) ?>
              <?php foreach ($fee as $f): ?>
                  <?php echo $f['name'], ' ', HtmlHelper::formatPrice($f['fee']), '&nbsp;';break; //新版只显示第一个运送方式 ?>
              <?php endforeach; ?>
          <?php endif; ?>
       </span>
    </dd>
</dl>

<script language="javascript">
var allCity = [];

<?php 
if($goods['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE){//有运费模板
    foreach ($region as $k => $v){ ?>
    allCity[<?php echo $v['province_id'];?>] = '';
<?php foreach ($v['cities'] as $k2 => $v2){?>
    allCity[<?php echo $v['province_id'];?>] += '<li><?php echo CHtml::link($v2, 'javascript:void(0)', array('data-province' => $v['province_id'], 'data-city' => $k2)); ?></li>';
<?php }}?>

/*点击城市计算运费*/
$(document).on('click', '.gst-address-lower a', function() {
    var province_id = $(this).attr('data-province');
	var city_id = $(this).attr('data-city');
	var city_name = $(this).text();
	var province_name = $(".gst-address-list .province[data-value=" + province_id + "]").text();
	$("#store-selector").html(province_name + city_name);

	//ajax 计算运费
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo $this->createAbsoluteUrl('/goods/computeFreight', array('id' => $goods['id'])) ?>",
		data: {
			province_id: province_id,
			city_id: city_id,
			city_name: city_name,
			province_name: $.trim(province_name),
			goods_id: '<?php echo $goods['id']; ?>',
			YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken; ?>",
			quantity: $("#quantity").val()},
		success: function(data) {
			if (data) {
				var html = '';
				for (f in data) {
					html += data[f].name + ' <?php echo HtmlHelper::formatPrice('') ?>' + data[f].fee + '&nbsp;'
				}
				$("#freight_text").html(html);
			}
		}
	});	
});
<?php }?>
</script>