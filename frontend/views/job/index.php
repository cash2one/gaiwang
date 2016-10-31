<div class="main clearfix">
    <div class="aboutSlider fl">
        <ul class="clearfix">
            <li><?php echo CHtml::link('<p class="aTit">' . Yii::t('job', '关于盖网') . '</p><p>About</p>', $this->createAbsoluteUrl('/about'), array('class' => 'it01')); ?></li>
            <li><?php echo CHtml::link('<p class="aTit">' . Yii::t('job', '联系客服') . '</p><p>Contact</p>', $this->createAbsoluteUrl('/contact'), array('class' => 'it02')); ?></li>
            <li class="curr"><?php echo CHtml::link('<p class="aTit">' . Yii::t('job', '诚聘英才') . '</p><p>Job</p>', $this->createAbsoluteUrl('/job'), array('class' => 'it03')); ?></li>
            <li><?php echo CHtml::link('<p class="aTit">' . Yii::t('job', '免责申明') . '</p><p>Statement</p>', $this->createAbsoluteUrl('/statement'), array('class' => 'it04')); ?></li>
			<li><?php echo CHtml::link('<p class="aTit">'.Yii::t('privacy','隐私声明').'</p><p>Privacy</p>', $this->createAbsoluteUrl('/privacy'), array('class' => 'it05')); ?></li>
        </ul>
    </div>
    <div class="aboutMain fl">
        <div class="aTop clearfix">
            <span class="aH1"><?php echo Yii::t('job', '诚聘英才'); ?></span>
            <span class="aIco0 aI02"><?php echo Yii::t('job', '欢迎你的加入'); ?></span>
        </div>
        <div class="aboutContent clearfix" style="height:700px;">
            <img src="<?php echo DOMAIN; ?>/images/bg/aboutbg03.jpg" class="aboutimg" />
            <p class="">盖聚百业，网通天下！欢迎有识之士加入我们的团队，共创辉煌！
            </p>
			<br/>
            <p class="pli">相关福利描述：<br/>
				1、福利：五险一金（按入职开始缴纳、全员缴纳综合医疗、全员缴纳住房公积金）+节假日员工福利礼品<br/>
                2、依法享受国家法定节假日（元旦、五一、国庆、春节、中秋等）；劳动法规定的带薪假（如：晚婚婚假13天、产假至少3个月、陪产假10天等），劳动法规定带薪年假<br/>
                3、标准工作周时间：一周五天工作制 （双休：周六、日休息）<br/>
                4、标准工作日时间：9：30-12：00；13：00-18：30，中午休息1小时<br/>
            </p>
			<br/> 
            <p class="pli">公司地址为广州市中心：广州市东风东路767号东宝大厦28楼</p>
        </div>
    </div>  
</div>