<?php if (isset($data)): ?>
    <?php
    // 判断是否开启特定活动， 如果是，则使用活动价格
    if (HotelRoom::isActivity($data->activities_start, $data->activities_end))
        $data->unit_price = $data->activities_start;
    ?>
        <li class="items clearfix">
            <span class="wfl w210"><i class="ico_img"></i><a href="javascript:void(0);" title="<?php echo $data->name ?>"><?php echo $data->name ?></a></span>
            <span class="wfl w60"><?php echo HotelRoom::getBed($data->bed) ?></span>
            <span class="wfl w60"><?php echo HotelRoom::getBreakFast($data->breadfast) ?></span>
            <span class="wfl w60"><?php echo HotelRoom::getNetwork($data->network) ?></span>
            <span class="wfl w85"><em><?php echo HtmlHelper::formatPrice($data->unit_price) ?></em></span>
            <span class="wfl w85"><b><?php echo Common::convert($data->unit_price) ?></b></span>
            <span class="wfl w100"><span class="ico_fan"><i><?php echo $data->estimate_back_credits ?><?php echo Yii::t('hotelSite', '分'); ?></i></span></span>
            <span class="wfl w140">
                <?php echo CHtml::link(Yii::t('hotelSite', '预订'), $this->createAbsoluteUrl('/hotel/order/create', array('id' => $data->id)), array('class' => 'hbtnSubmit')) ?>
            </span>
        </li>
        <div class="hotelIntroTxt clearfix">
            <?php if (!empty($data->pictures)): ?>
                <div class="Himglist">
                    <?php foreach ($data->pictures as $v): ?>
                        <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->path, "c_fill,h_100,w_120"), $data->name, array('width' => 120, 'height' => 100)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="HserCon">
                <?php echo $data->content ?>
            </div>
        </div>
<?php endif; ?>