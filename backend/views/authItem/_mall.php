<tr>
    <td rowspan="10">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.MallManagement', $rights)): ?>checked="checked"<?php endif; ?> value="Main.MallManagement" id="MainMallManagement"><label for="MainMallManagement">商城管理</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Advert', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Advert" id="SubAdvert"><label for="SubAdvert">广告管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_advertconfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Article', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Article" id="SubArticle"><label for="SubArticle">文章管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_articleconfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Brand', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Brand" id="SubBrand"><label for="SubBrand">品牌类别管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_brandconfig', array('rights' => $rights)); ?>
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Integral', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Integral" id="SubIntegral"><label for="SubIntegral">积分兑换管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_convertconfig', array('rights' => $rights)); ?>
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Order', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Order" id="SubOrder"><label for="SubOrder">订单管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_orderconfig', array('rights' => $rights)); ?>
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Link', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Link" id="SubLink"><label for="SubLink">友情链接管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_link', array('rights' => $rights)); ?>
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Activity', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Activity" id="SubLink"><label for="SubActivity">活动管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_activity', array('rights' => $rights)); ?>
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Coupon', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Coupon" id="SubLink"><label for="SubCoupon">优惠券管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_coupon', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Seckill', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Seckill" id="SubLink"><label for="SubCoupon">活动专题管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_seckill', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Cityshow', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Cityshow" id="SubLink"><label for="SubCityshow">城市频道管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_cityshow', array('rights' => $rights)); ?>
    </td>
</tr>