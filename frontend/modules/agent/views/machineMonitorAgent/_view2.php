<li class="monitor_list">
    <div class="gm_info">
        <div class="gm_exception">
            <?php
            if ($data->status == 1) {
                echo "";
            } else {
                echo CHtml::image(AGENT_DOMAIN."/images/exception.png","",array('title'=>Yii::t('Machine','异常')));
            }
            ?>
        </div>
        <span class="gm_name"><?php echo $data->machine_name; ?></span>
        <span class="gm_time"><?php echo date("Y-m-d H:i:s", $data->create_time); ?></span>

        <?php
        if($data->level != 2){
             echo CHtml::link(Yii::t('Machine','更多...'), '', array('class' => 'btn_more', 'onclick' => 'return doViewMachineMonitor("' . $data->machine_name . '")'));
        } 
                ?>
    </div>
    <div class="gm_capture">
        <a href='<?php echo $data->path ? Tool::showGtImg($data->path) : ""?>' onclick="return _showBigPic(this)">
         	<?php echo $data->path ? CHtml::image(Tool::showGtImg($data->path, 50, 89),'',array('width'=>'50px','height'=>'89px')) : "";?>
         </a>
    </div>
</li>

