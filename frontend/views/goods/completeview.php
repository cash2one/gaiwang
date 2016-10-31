<li>
    <p class="rT01"><?php echo substr($data->gai_number, 0, 3) . '****' . substr($data->gai_number, -3); ?></p>
    <p class="rT02"><a href="javascript:;" ><?php echo CHtml::encode($data->goods_name); ?></a></p>
    <p class="rT03"><?php echo $data->total_price; ?></p>
    <p class="rT04"><?php echo $data->quantity; ?></p>
    <p class="rT05"><?php echo date('Y-m-d', $data->sign_time); ?><br/><?php echo date('H:i:s', $data->sign_time); ?></p>
    <p class="rT06"><?php echo Yii::t('goods', '完成') ?></p>
</li>