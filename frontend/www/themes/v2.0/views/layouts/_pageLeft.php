<?php
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl.'/styles/help.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl.'/styles/global.css');
?>
<div id="about-sidebar" class="about-sidebar">
    <a href="<?php echo ($this->id != 'about')? DOMAIN . '/about.html' : 'javascript:void(0)'?>" class="<?php echo ($this->id == 'about')? 'active' : ''?>">
        <p class="title-zh"><?php echo Yii::t('','关于我们')?></p>
        <p class="title-eg"><?php echo Yii::t('','ABOUT US')?></p>
    </a>
    <a href="<?php echo ($this->id != 'contact')? DOMAIN . '/contact.html' : 'javascript:void(0)'?>" class="<?php echo ($this->id == 'contact')? 'active' : ''?>">
        <p class="title-zh"><?php echo Yii::t('','联系客服')?></p>
        <p class="title-eg"><?php echo Yii::t('','CONTACT')?></p>
    </a>
    <a href="<?php echo ($this->id != 'job')? DOMAIN . '/job.html' : 'javascript:void(0)'?>" class="<?php echo ($this->id == 'job')? 'active' : ''?>">
        <p class="title-zh"><?php echo Yii::t('','诚聘英才')?></p>
        <p class="title-eg"><?php echo Yii::t('','JOB')?></p>
    </a>
    <a href="<?php echo ($this->id != 'statement')? DOMAIN . '/statement.html' : 'javascript:void(0)'?>" class="<?php echo ($this->id == 'statement')? 'active' : ''?>">
        <p class="title-zh"><?php echo Yii::t('','免责声明')?></p>
        <p class="title-eg"><?php echo Yii::t('','STATEMENT')?></p>
    </a>
    <a href="<?php echo ($this->id != 'privacy')? DOMAIN . '/privacy.html' : 'javascript:void(0)'?>" class="<?php echo ($this->id == 'privacy')? 'active' : ''?>">
        <p class="title-zh"><?php echo Yii::t('','隐私声明')?></p>
        <p class="title-eg"><?php echo Yii::t('','PRIVACY')?></p>
    </a>
</div>