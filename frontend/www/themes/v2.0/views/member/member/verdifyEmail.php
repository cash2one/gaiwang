<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseurl . '/js/jquery-1.9.1.js')?>
<script src="<?php echo $this->theme->baseUrl; ?>/js/ShoppingCart.js"></script>
<div class="accounts-box accounts-box2">
    <div class="accounts-revise">
        <div class="revise-progress">
            <div class="revise-item on">
                <p class="number">1</p>
                <p class="title"><?php echo Yii::t('memberMember','验证身份')?></p>
                <span class="on"></span>
            </div>
            <div class="revise-item on ">
                <p class="number">2</p>
                <p class="title"><?php echo Yii::t('memberMember','验证邮箱')?></p>
                <span class="on"></span>
            </div>
            <div class="revise-item on">
                <p class="number">3</p>
                <p class="title"><?php echo Yii::t('memberMember','完成')?></p>
            </div>
        </div>
        <div class="revise-box bind-success">
            <p class="revise-result">
                <i class="cover-icon cover-icon2"></i>
                <span><?php echo $this->getParam('flag')? Yii::t('memberMember','恭喜您，修改完成') : Yii::t('memberMember','恭喜您，绑定完成')?>！</span>
            </p>                    
            <p>          
                <?php echo CHtml::link(Yii::t('memberMember','确定'),$this->createAbsoluteUrl('/member'),array('class'=>'varify-btn'))?>
            </p>
        </div>
    </div>
</div>