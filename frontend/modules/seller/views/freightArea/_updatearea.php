<span id="FreightArea_location_id">
            <?php $province = Region::getRegionByParentId(1) ?>
    <?php foreach ($province as $k => $v): ?>
        <div class="location">
            <input type="checkbox" name="FreightArea[location_id][]" value="<?php echo $k ?>"
                   id="FreightArea_location_id_<?php echo $k ?>"
                <?php if (FreightArea::checkAreaUse($typeModel->id, $k) && !in_array($k,$areaArray)) echo 'disabled' ?>
                <?php if(in_array($k,$areaArray)) echo "checked" ?>
                >
            <label for="FreightArea_location_id_<?php echo $k ?>"><?php echo $v ?></label>
        </div>
    <?php endforeach; ?>
</span>
<?php foreach ($province as $k => $v): ?>
    <?php $city = Region::getRegionByParentId($k) ?>
    <div class="city" id="city_<?php echo $k ?>">
        <?php foreach ($city as $k2 => $v2): ?>

            <div class="location">
                <input type="checkbox" name="FreightArea[location_id][]" value="<?php echo $k2 ?>"
                       id="FreightArea_location_id_<?php echo $k2 ?>"
                    <?php if (FreightArea::checkAreaUse($typeModel->id, $k2) && !in_array($k2,$areaArray)) echo 'disabled' ?>
                    <?php if(in_array($k2,$areaArray)) echo "checked" ?>
                    >
                <label for="FreightArea_location_id_<?php echo $k2 ?>"><?php echo $v2 ?></label>
            </div>

        <?php endforeach; ?>
        <a class="close"><?php echo Yii::t('sellerFreightTemplate', '关闭'); ?></a>
    </div>

<?php endforeach ?>

<script>
    $(function(){
        var findCheck = $(".city input[checked]");
        if(findCheck.length>0){
            findCheck.parent().parent().show();
        }
    });
</script>