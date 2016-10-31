    <img width="296" height="48" src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/gx_recommendIoc2.png"/>
    <span class="gx-bot-sx randRecord">换一批</span>

    <ul class="gx-bot-list">
        <?php
        foreach (Goods::getRandRecord(6) as $v):
            ?>
            <li>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view', array('id' => $v['id'])) ?>" target="_blank">
                    <img width="199" height="199" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_199,w_199') ?>"/>
                    <span class="gx-bot-info">
                        <span><?php echo Tool::truncateUtf8String($v['name'], 12) ?></span>
                        <p><?php echo HtmlHelper::formatPrice($v['price']) ?></p>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <script type="text/javascript">
        //猜你喜欢，换一批
        $(".randRecord").click(function () {
            $.getJSON("<?php echo Yii::app()->createAbsoluteUrl('site/ajaxRandGoods') ?>?t="+Math.random(), [], function (data) {
                var html = '';
                if (data.length > 0) {
                    for (var x in data) {
                        html += '<li>';
                        html += '<a href="' + data[x].url + '" target="_blank">';
                        html += '<img width="199" height="199" src="' + data[x].src + '" />';
                        html += '<span class="gx-bot-info">';
                        html += '<span>'+data[x].name+"</span>";
                        html += '<p>' + data[x].price + '</p>';
                        html += '</span>';
                        html += '</a>';
                        html += '</li>';
                    }
                    $("ul.gx-bot-list").html(html);
                }
            });
        });
    </script>