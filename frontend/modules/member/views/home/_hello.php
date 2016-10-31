<script>
    var helloTxt="";day = new Date();time = day.getHours();
    if(time >=0 && time <7 ){
        helloTxt = "<?php echo Yii::t('memberHome','夜猫子，要注意身体哦！'); ?>";
    }
    if(time >=7 && time <12 ){
        helloTxt = "<?php echo Yii::t('memberHome','上午好！'); ?>";
    }
    if(time >=12 && time <14 ){
        helloTxt = "<?php echo Yii::t('memberHome','午休时间哦！'); ?>";
    }
    if(time >=14 && time <18 ){
        helloTxt = "<?php echo Yii::t('memberHome','下午茶的时间到了，休息一下吧！'); ?>";
    }
    if(time >=18 && time <22 ){
        helloTxt = "<?php echo Yii::t('memberHome','您又来了，可别和MM聊太久哦！'); ?>";
    }
    if(time >=22 && time <24 ){
        helloTxt = "<?php echo Yii::t('memberHome','很晚了哦，注意休息呀！'); ?>";
    }
    document.write(helloTxt);
</script>