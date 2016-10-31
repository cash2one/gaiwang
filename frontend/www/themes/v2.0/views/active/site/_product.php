<?php
if (!empty($productRelation) && is_array($productRelation)) {

    if (!empty($productRelation)) {
        foreach ($productRelation as $k => $v) {
            if ($k > ($pageSize - 1))
                break;

            $price = $v['price'];
            $setingId = $v['rules_seting_id'];
            $id = 'product_0_' . $v['product_id'];

            $string = '0天0时0分0秒';
            if (is_array($rules[$setingId]) && !empty($rules[$setingId])) {
                if ($nowTime > strtotime($rules[$setingId]['end_dateline'])) {
                    continue;
                }
                if ($setingId && $rules[$setingId]['category_id'] == 2 && ($nowTime >= strtotime($rules[$setingId]['start_dateline']) && $nowTime <= strtotime($rules[$setingId]['end_dateline']))) {//若商品有参加活动,则显示活动价
                    $price = $rules[$setingId]['discount_rate'] > 0 ? number_format($rules[$setingId]['discount_rate'] * $price / 100, 2, '.', '') : number_format($rules[$setingId]['discount_price'], 2, '.', '');
                }
                if ($rules[$setingId]['status'] == 2) {
                    $tx = strtotime($rules[$setingId]['start_dateline']) - $nowTime;
                    if ($tx < 0) {
                        $tx = 0;
                    }
                } else if ($rules[$setingId]['status'] == 3) {
                    $tx = strtotime($rules[$setingId]['end_dateline']) - $nowTime;
                    if ($tx < 0) {
                        $tx = 0;
                    }
                }

                if ($rules[$setingId]['status'] == 2 || $rules[$setingId]['status'] == 3)
                    $staing = SiteController::dealTimes($tx);
                if ($tx > 0) {
                    $times[$id] = $tx;
                }
            }
            $class = ($v['stock'] && $tx) ? '' : 'ending';
            ?>
            <li class="<?php echo $class; ?>">
                <a class="itemImg" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id'])); ?>" target="_blank">
                    <p class="grabEnd"></p><img width="380" height="300" class="lazy" alt="<?php echo $v['product_name']; ?>" data-url="<?php echo IMG_DOMAIN . '/' . $v['thumbnail']; ?>" /></a>
                <p class="name"><?php echo $v['product_name']; ?></p>
                <div class="pricebg">
                    <p class="price clearfix">
                        <span class="txtl"><i>￥</i><?php echo $price; ?></span>
                        <span class="txtr"></span>
                    </p>
                    <p class="time" id="<?php echo $id; ?>"><?php echo $string; ?></p>
                    <p class="buying"><a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id'])); ?>" target="_blank" >立即抢购</a></p>
                </div>
            </li>
        <?php } ?>
    <?php
    }
} else {
    echo '<div class="no_product">目前没有任何活动商品</div>';
}?>