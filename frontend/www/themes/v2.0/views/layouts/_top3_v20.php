<?php
$store = $this->store;
$storeComment = StoreComment::getStoreComment($store['id']);
$des = isset($storeComment->description_match) ? sprintf('%.2f', $storeComment->description_match) : 0.00;
$ser = isset($storeComment->serivice_attitude) ? sprintf('%.2f', $storeComment->serivice_attitude) : 0.00;
$spe = isset($storeComment->speed_of_delivery) ? sprintf('%.2f', $storeComment->speed_of_delivery) : 0.00;

//$des=(!empty($store['description_match']) && !empty($store['comments'])) ? sprintf('%.2f', $store['description_match'] / $store['comments']) : 0.00;
//$ser=(!empty($store['serivice_attitude']) && !empty($store['comments'])) ? sprintf('%.2f', $store['serivice_attitude'] / $store['comments']) : 0.00;
//$spe=(!empty($store['speed_of_delivery']) && !empty($store['comments'])) ? sprintf('%.2f', $store['speed_of_delivery'] / $store['comments']) : 0.00;

//如果分类ID有限制
$storeCategory = Yii::t('goods', '所有类别');
$categoryArray = array();
if($store['category_id']>0){
	$categoryArray = Category::getCategoryNameByIds(array($store['category_id']));
	$storeCategory = !empty($categoryArray) ?  Yii::t('goods', $categoryArray[0]['name']) : '所有类别';
}
$design=array();
if(isset($this->design) && !empty($this->design)){
$design         = Tool::array_2get($this->design->TemplateList, 'Code', '_left_Contact_1');
}
$goodsCount     = Goods::CountSalesGoods($store['id']);
$qualifications = Store::getQualifications();
?>
<div class="clear"></div>
<div class="gx-topMain">
<div class="gx-top-logoSearch goodsDetails-logoSearch clearfix">
    <?php $img = CHtml::image(DOMAIN.Yii::app()->theme->baseUrl.'/images/bgs/top_logo.png', Yii::t('site', '盖象商城'), array('width' => '187', 'height' => '56')) ?>
        <?php echo CHtml::link($img, DOMAIN, array('title' => Yii::t('site', '盖象商城'), 'class' => 'gx-top-logo')) ?>
    <dl class="goods-shopInfo">
        <dd>
			<?php echo CHtml::link(Yii::t('site', $store['name']), $this->createAbsoluteUrl('/shop/' . $store['id']), array('title'=>$store['name'], 'class'=>'shopInfo-name')); ?>
            <span class="shopInfo-font1"><?php echo Yii::t('goods', '主营').'：'.$storeCategory;?></span>
        </dd>
        <dd id="contact">
            <div class="shopInfo-content">
                <ul class="shopInfo-score clearfix">
                    <li><?php echo Yii::t('goods', '描述');?></li>
                    <li><?php echo Yii::t('goods', '服务');?></li>
                    <li><?php echo Yii::t('goods', '物流');?></li>
                    <li><span class="shopInfo-font2 description_match" ></span></li>
                    <li><span class="shopInfo-font2 serivice_attitude" ></span></li>
                    <li><span class="shopInfo-font3 speed_of_delivery" ></span></li>
                </ul>
                <span class="shopInfo-ioc"></span>
                <div class="shopInfo-float">
                    <div class="shopInfo-float-title clearfix">
                        <span><?php echo Yii::t('site', $store['name']);?></span>
                        <a href="<?php echo $this->createAbsoluteUrl('/shop/' . $store['id']);?>"><?php echo Yii::t('goods', '进入店铺');?></a>
                    </div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="60"><span class="shopInfo-font4"><?php echo Yii::t('shop', '公司名'); ?></span></td>
                            <td width="190"><?php echo $store['name'];?></td>
                            <td><span class="shopInfo-font4"><?php echo Yii::t('shop', '动态评分'); ?></span></td>
                        </tr>
                        <tr>
                            <td><span class="shopInfo-font4"><?php echo Yii::t('shop', '地址'); ?></span></td>
                            <td colspan="2"><div class="shopInfo-address"><?php echo Region::getName($store['province_id'], $store['city_id'], $store['district_id']); ?>
                             </div></td>
                        </tr>
                        <tr>
                            <td><span class="shopInfo-font4"><?php echo Yii::t('shop', '商品数');?></span></td>
                            <td><?php echo $goodsCount; ?></td>
                            <td rowspan="3">
                                <?php echo Yii::t('goods', '描述相符');?>：<span class="shopInfo-font2 description_match"></span><br/>
                                <?php echo Yii::t('goods', '服务态度');?>：<span class="shopInfo-font2 serivice_attitude"></span><br/>
                                <?php echo Yii::t('goods', '发货速度');?>：<span class="shopInfo-font3 speed_of_delivery"></span><br/>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="shopInfo-font4"><?php echo Yii::t('shop', '客服'); ?></span></td>
                            <td>
                            <?php if (isset($design['JsonData']['CustomerData'])): ?>
                            <?php foreach ($design['JsonData']['CustomerData'] as $v): ?>
                                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes" class="qqon">
                                       <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                                </a><span class="shopInfo-font5"><?php echo $v['ContactPrefix'] ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo Yii::t('shop', '商家未提供在线客服'); ?>
                        <?php endif; ?>
                          </td>
                        </tr>
                        <tr class="shopInfo-tr">
                            <td><span class="shopInfo-font4"><?php echo Yii::t('shop', '工作时间'); ?></span></td>
                            <td colspan="2">
							<?php if (isset($design['JsonData']['CustomerWorkTime'])): ?>
                            <?php foreach ($design['JsonData']['CustomerWorkTime'] as $v): ?>
                                <?php echo $v['MinDate'] ?>-<?php echo $v['MaxDate'] ?>：
                                <?php echo $v['MinTime'] ?>-<?php echo $v['MaxTime'] ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo Yii::t('shop', '商家暂未提供工作时间'); ?>
                        <?php endif; ?>
                          </td>
                        </tr>
                        <tr>
                            <td><span class="shopInfo-font4"><?php echo Yii::t('goods', '资质');?></span></td>
                            <td colspan="2">
                            <?php if($store['qualifications'] != ''){
								$quaArray = explode(',', $store['qualifications']);
								foreach($quaArray as $v){
									echo Yii::t('goods', $qualifications[$v]).' ';
								}
							}else{
							    	echo Yii::t('goods', '注册商家');
							}?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </dd>
        <dd>
            <!--<div class="shopInfo-phone">
                <span class="shopInfo-font6"><?php /*echo Yii::t('goods', '手机逛店');*/?></span>
                <span class="shopInfo-phone-ico"></span>
                <span class="shopInfo-ioc shopInfo-ioc2"></span>
                <div class="shopInfo-phone-float">
                <?php /*$this->widget('comext.QRCodeGenerator', array(
                    'data' => Yii::app()->createAbsoluteUrl('m/store/index/'.$store['id']),
                    'size' => 3.0,
                ));*/?>
                    <br/><?php /*echo Yii::t('goods', '扫一扫，手机逛起来');*/?>
                </div>
            </div>-->
        </dd>
    </dl>
    <div class="gx-top-search goodsDetails-search">
        <div class="gx-top-search-inp clearfix">
            <div class="gx-top-search-inp-left">
                <?php
                echo CHtml::textField('keyword', $this->getParam('q'), array(
                    'id' => 'keyword',
                    'accesskey' => 's',
                    'autofocus' => 'true',
                    'autocomplete' => 'off',
                    'aria-haspopup' => 'true',
                    'aria-combobox' => 'list',
                    'class' => '',
					'placeholder' => Yii::t('site', '输入商品进行搜索'),
                    'maxlength'=>'50',
                    'x-webkit-speech' => '',
                    'x-webkit-grammar' => 'builtin:translate',
                    'lang' => 'zh-CN',
                ))
                ?>
                <?php echo CHtml::endForm(); ?>
                <!--<span title="语音" class="voice-ioc"></span>-->
            </div>
            <input type="button" id="search_all" class="goodsDetails-search-but" value="<?php echo Yii::t('site', '搜盖象'); ?>" />
            <input type="button" id="search_store" class="goodsDetails-search-but goodsDetails-search-but2" value="<?php echo Yii::t('site', '搜本店'); ?>" />
        </div>
        <script type="text/javascript">
            $(document).ready(function(e) {
                $('#keyword').bind('keyup', function(event) {
    				if (event.keyCode == "13") {
    					//回车执行查询
    					$('#search_all').click();
    				}
    			});
            });
            $("#search_all").click(function() {
                var keyword = $('#keyword').val();
                var url = '<?php echo urldecode($this->createAbsoluteUrl('/search/search', array('q' => "'+keyword+'"))); ?>';
                if(keyword != '') location.href = url;
            });
            $("#search_store").click(function() {
                var keyword = $('#keyword').val();
                var sid = <?php echo $store['id'];?>;
                var url = '<?php echo urldecode($this->createAbsoluteUrl('/search/search', array('o' => '宝贝', 'q' => "'+keyword+'",'s' => "'+sid+'"))); ?>';
                if(keyword != '') location.href = url;
            });
        </script>
        
        <div class="gx-top-search-tj">
            
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
/**获取店铺评价信息**/
$(function(){
    $('.description_match').prepend('<?php echo $des;?>');
    $('.serivice_attitude').prepend('<?php echo $ser;?>');
    $('.speed_of_delivery').prepend('<?php echo $spe;?>');
	$('#dis_match').html('<?php echo $des;?>');
});
</script>