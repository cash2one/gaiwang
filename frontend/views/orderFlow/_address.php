<?php
/** @var $this OrderFlowController */
?>
<div id="addresslist">
    <?php foreach ($address as $k => $v): ?>
        <?php
        /** @var $select_address array 会员当前选择的收货地址  */
        $select_address = $this->getSession('select_address');
        ?>
        <?php $address = implode(' ', array($v['province_name'], $v['city_name'], $v['district_name'], $v['street'], '(' . $v['real_name'] . ')', $v['mobile'])); ?>
        <label for="address_<?php echo $v['id'] ?>"  class="address_item <?php echo $select_address['id'] == $v['id'] ? 'shopFlBox_address' : 'shopFlBox_address_1'; ?>" >
            <span class="shopFlBox_dtaddress" >
                <?php
                echo CHtml::radioButton('address', $select_address['id'] == $v['id'] ? true : false, array(
                    'value' => $v['id'],
                    'data-city_id' => $v['city_id'],
                    'data-address' => $address,
                    'data-consignee' => $v['real_name'],
                    'id' => 'address_' . $v['id'],
                ))
                ?>
                <font><?php echo Yii::t('address', '寄送至'); ?>： <?php echo $address; ?>  </font>
            </span>
            <span class="fr">
                <?php echo CHtml::link(Yii::t('address', '修改地址'), array('/member/address/update/', 'id' => $v['id'], 'turnback' => 1, 'croute' => urlencode('/' . $this->getRoute()))); ?>
                <?php
                echo CHtml::link(Yii::t('address', '删除'), array('/member/address/delete/',
                    'id' => $v['id'], 'turnbackByUrl' => 1,
                    'turnbackUrl' => urlencode($this->createUrl('/' . $this->getRoute(), array('goods_select' => $id)))), array('onclick' => 'return confirm(' . Yii::t('address', '确定要删除吗？') . ')'));
                ?>
            </span>
        </label>
    <?php endforeach; ?>
</div>

<script>

    $(function() {
        $("#addresslist .address_item").hover(function() {
            $(this).addClass('shopFlBox_address_1Hover');
        }, function() {
            $(this).removeClass('shopFlBox_address_1Hover');
        })
    })
    $(":input[name=address]").change(function() {
        if (confirm("<?php echo Yii::t('address','更换地址后，需要您重新确认订单信息')?>")) {
            $.ajax({
                url: '<?php echo $this->createAbsoluteUrl('/orderFlow/changeAddress') ?>',
                data: {city_id: $(this).attr('data-city_id'), id: $(this).val(), YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"},
                dataType: 'json',
                type: 'POST',
                success: function() {
                    $("form.changeAddress").submit();
                },
                error: function() {
                    location.reload();
                }
            });
        }
    });

</script>


