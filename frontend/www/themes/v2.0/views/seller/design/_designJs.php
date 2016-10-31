<?php
/** @var $this DesignController */
?>

<script type="text/javascript">
    //调用编辑框http://sellertest.gatewang.com/Design/
    var dialog = null;
    var doClose = function () {
        if (null != dialog) {
            dialog.close();
        }
    };


    var setHtml = function (typeId, html) {
        $('#shop' + typeId).html(html);
        doClose();
    };

    //设置背景
    function setBgImg() {
        var bgSrc = '<?php echo $this->createAbsoluteUrl('setBg',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(bgSrc, {
            'title': '<?php echo Yii::t('sellerDesign','设置背景'); ?>',
            'lock': true,
            'window': 'top',
            'width': 640,
            'height': 500,
            'border': true
        });
    }


    //设置导航

    $(document).ready(function () {
   	    bindHover($('#navList'), 'setNav()');
        bindHover($('#banner'), 'setMainSlide1()');
        bindHover($('#probanner'), 'setBanner()');
        bindHover($('#setAdv'), 'setAdv()');
        bindHover($('#contact'), 'setContact()');
        
        //新品上线
        <?php $setProUrl = $this->createAbsoluteUrl('goodsFilter',array('id'=>$this->currentDesign->id,'key'=>DesignFormat::TMP_RIGHT_PROLIST)) ?>
        bindHover($('#proNew'), 'SetPro("<?php echo $setProUrl ?>")');
        //热销推荐
        <?php $setProUrl = $this->createAbsoluteUrl('goodsFilter',array('id'=>$this->currentDesign->id,'key'=>DesignFormat::TMP_RIGHT_PROLIST_2)) ?>
        bindHover($('#proList'), 'SetPro("<?php echo $setProUrl ?>")');
        //左侧商品筛选，默认人气商品
        <?php $setProUrl = $this->createAbsoluteUrl('goodsFilter',array('id'=>$this->currentDesign->id,'key'=>DesignFormat::TMP_LEFT_PROLIST)) ?>
        bindHover($('#sliderList01'), 'SetPro("<?php echo $setProUrl ?>")');
    });
    //设置导航
    var setNav = function () {
        var url = '<?php echo $this->createAbsoluteUrl('setNav',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置导航'); ?>', width: '683px', height: '600.5px', lock: true });
    };
    //设置幻灯片
    var setMainSlide1 = function () {
        var url = '<?php echo $this->createAbsoluteUrl('setSlide',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置幻灯片'); ?>', width: '840px', height: '665px', lock: true });
    };
    //设置产品广告5张
    var setBanner = function () {
        var url = '<?php echo $this->createAbsoluteUrl('setV20AdPic',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置产品广告'); ?>', width: '800px', height: '465px', lock: true });
    };

    //设置产品广告一张
    var setAdv = function () {
        var url = '<?php echo $this->createAbsoluteUrl('setV20Adv',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置产品广告'); ?>', width: '800px', height: '465px', lock: true });
    };

    /*设置咨询*/
    var setContact = function () {
        var url = '<?php echo $this->createAbsoluteUrl('setContact',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置咨询'); ?>', width: '640px', height: '580px', lock: true });
    };
    
    //设置模板商品
    var SetPro = function (url) {
        dialog = art.dialog.open(url, { 'id': 'setPro', title: '<?php echo Yii::t('sellerDesign','设置模版商品'); ?>', width: '640px', height: '500px', lock: true });
    };

    $(function () {
        //第一次进入，使用帮助
        <?php if($this->createFirst): ?>
        ChannelOff();
        <?php endif; ?>
        //设置状态提醒
        <?php if($this->createNew): ?>
        statusNotice("<?php echo Yii::t('sellerDesign','店铺装修的状态修改为');echo Design::status(Design::STATUS_EDITING); echo Yii::t('sellerDesign','成功！'); ?>");
        <?php endif; ?>

    });

</script>