<script>
    var commonVar = {
        reloadTips: '<div class="loading reload"></div>',
        addCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/addCart') ?>',
        loadCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/loadCart') ?>',
        deleteCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/del') ?>'
    }
</script>

<li class="myCart" id="myCart">
    <i class="icon_v"></i>
    <?php echo Yii::t('cart', '购物车'); ?><em id="cartNum">0</em><?php echo Yii::t('cart', '件'); ?>
    <div id="cartList" class="cartList" style="display:none;">
        <div class="loading"></div>
    </div>
</li>
