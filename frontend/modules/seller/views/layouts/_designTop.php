<?php
//店铺装修头部
?>
<div class="top_con">
    <div class="left_con">
        <span class="title"><?php echo Yii::t('sellerDesign', '店铺装修'); ?></span> <span><?php echo Yii::t('sellerDesign', '欢迎'); ?> <strong><?php echo $this->getUser()->name; ?>！</strong></span>
    </div>
    <div class="right_con">
        <span>
            <?php echo CHtml::link(Yii::t('sellerDesign', '查看店铺'),
                array('/shop/view', 'id' => $this->getSession('storeId')), array('target' => '_blank')); ?>
        </span> |&nbsp;<?php echo Yii::t('sellerDesign', '当前状态'); ?>：
        <?php echo Design::status($this->currentDesign->status); ?>|&nbsp;

        <?php if ($this->currentDesign->status == Design::STATUS_NOT_PASS && !empty($this->currentDesign->remark)): ?>
            <span><a href="javascript:showRemark()" class="bt_w71"><?php echo Yii::t('sellerDesign', '审核意见'); ?></a></span>
            <span>
                <?php echo CHtml::link(Yii::t('sellerDesign', '编辑'),array('changeStatus',
                    'id'=>$this->currentDesign->id,
                    'status'=>$this->currentDesign->status),array('class'=>'bt_h20')
                ); ?>
            </span>
        <?php endif; ?>

        <?php if ($this->currentDesign->status == Design::STATUS_EDITING): ?>
            <span>
           <?php echo CHtml::link(Yii::t('sellerDesign', '还原'), array('reBack', 'id' => $this->currentDesign->id)); ?>
        </span> |&nbsp;
        <?php endif; ?>

        <?php if ($this->currentDesign->status == Design::STATUS_EDITING): ?>
            <span>
            <a class="bt_w71" href="javascript:setBgImg()"><?php echo Yii::t('sellerDesign', '设置背景'); ?></a>
        </span>
            |&nbsp;
        <?php endif; ?>

        <span>
            <?php
            if($this->action->id=='index'){
                echo CHtml::link(Yii::t('sellerDesign', '预览'),array('/shop/preview','id'=>$this->storeId,'tmpId'=>$this->currentDesign->id),
                    array('class'=>'bt_h20','target'=>'_blank')
                );
            }else{
                echo CHtml::link(Yii::t('sellerDesign', '预览'),array('/shop/storePreview','id'=>$this->storeId,'tmpId'=>$this->currentDesign->id),
                    array('class'=>'bt_h20','target'=>'_blank')
                );
            }
            ?>
        </span>
        |&nbsp;

        <span>
            <?php
            switch ($this->currentDesign->status) {
                case Design::STATUS_EDITING:
                    echo CHtml::link(Yii::t('sellerDesign', '申请'), array('changeStatus', 'id' => $this->currentDesign->id,
                        'status' => Design::STATUS_EDITING), array('class' => 'bt_h20'));
                    break;
                case Design::STATUS_AUDITING:
                    echo CHtml::link(Yii::t('sellerDesign', '取消申请'), array('changeStatus', 'id' => $this->currentDesign->id,
                        'status' => Design::STATUS_AUDITING), array('class' => 'bt_w71'));
                    break;
                case Design::STATUS_NOT_PASS:
                    echo CHtml::link(Yii::t('sellerDesign', '申请'), array('changeStatus', 'id' => $this->currentDesign->id,
                        'status' => Design::STATUS_EDITING), array('class' => 'bt_h20'));
                    break;
            }
            ?>
        </span>
        <span class="help_info">
            <a href="javascript:ChannelOff()"><?php echo Yii::t('sellerDesign', '帮助'); ?></a>
        </span>
        <span>
            <?php echo CHtml::link(Yii::t('sellerDesign', '退出'), array('/seller/home/logout')); ?>
        </span>
    </div>
</div>
<!-- top end -->