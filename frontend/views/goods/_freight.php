<?php if ($goods['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE): ?>
    <?php $position = Tool::getPosition(); ?>
    <tr>
        <td><?php echo Yii::t('goods', '配送地址') ?>：</td>
        <td>
            <div class="sendAddr">
                <div>
                    <div class="currAdr"><?php echo str_replace('省', '', $goods['province']) . $goods['city'] ?> <?php echo Yii::t('goods', '至') ?></div>
                    <div id="store-selector" class="">
                        <div class="text">
                            <div><?php echo $position['province_name'] . ' ' . $position['city_name'] ?><b></b></div>
                        </div>
                        <div class="content">
                            <div>
                                <div id="JD-stock" class="m JD-stock">
                                    <div class="mt">
                                        <ul class="tab">
                                            <li class="curr">
                                                <?php echo Yii::t('goods', '选择你的收货城市') ?> (<?php echo Yii::t('goods', '你当前所在地') ?>:
                                                <span class="red"><?php echo $position['province_name'] . $position['city_name'] ?></span>)
                                            </li>
                                        </ul>
                                        <div class="stock-line"></div>
                                    </div>
                                    <div id="stock_province_item" class="mc" data-widget="tab-content" data-area="0"
                                         style="display: block;">
                                        <ul class="area-list">
                                            <?php foreach (Region::getRegion2() as $k => $v): ?>
                                                <li class="provinceLi"><a class="province" data-value="<?php echo $v['province_id'] ?>" href="#none"><?php echo $v['province_name'] ?></a></li>
                                                <div id="province_<?php echo $v['province_id'] ?>" class="cities">
                                                    <ul>
                                                        <?php foreach ($v['cities'] as $k2 => $v2): ?>
                                                            <li><?php echo CHtml::link($v2, 'javascript:void(0)', array('data-province' => $v['province_id'], 'data-city' => $k2)); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <span class="clr"></span>
                        </div>
                        <div class="close" onclick="$('#store-selector').removeClass('hover')"></div>
                    </div>
                </div>
            </div>
            <div id="store-prompt"></div>
        </td>
    </tr>
    <script>
        $("#store-selector").mouseover(function() {
            $(this).attr('class', 'hover');
        }).mouseleave(function() {
            $(this).removeClass('hover');
        });
        //点击省份，显示相应的城市
        $(".area-list .province").click(function() {
            $(".area-list .cities").hide();
            $("#province_" + $(this).attr("data-value")).show();
        });
        //鼠标离开省份，隐藏城市
        $("#stock_province_item").mouseleave(function() {
            $(".area-list .cities").hide();
        });
        //点击城市
        $(".area-list .cities a").click(function() {
            var province_id = $(this).attr('data-province');
            var city_id = $(this).attr('data-city');
            var city_name = $(this).text();
            var province_name = $(".area-list .province[data-value=" + province_id + "]").text();
            $("#store-selector .curr span").html(province_name + city_name);
            $("#store-selector .text div").html(province_name + city_name + '<b></b>');
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
                        $(".productTable .freight").html(html);
                        $("#store-selector").removeClass('hover');
                    }
                }
            });

        });
    </script>
<?php endif; ?>
<tr>
    <td><?php echo Yii::t('goods', '运费'); ?>：</td>
    <td>
        <span class="pr freight">
            <?php if ($goods['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE): ?>
                <?php echo Goods::freightPayType($goods['freight_payment_type']); ?>
            <?php else: ?>
                <?php $fee = ComputeFreight::compute($goods['freight_template_id'], $goods['size'], $goods['weight'], $position['city_id'], $goods['valuation_type']) ?>
                <?php foreach ($fee as $f): ?>
                    <?php echo $f['name'], ' ', HtmlHelper::formatPrice($f['fee']), '&nbsp;' ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>
    </td>
</tr>