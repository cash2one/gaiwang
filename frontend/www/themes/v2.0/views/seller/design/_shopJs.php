<script type="text/javascript">
    function bindHover(o,event) {
        o.hover(function () {
                var w = $(this).innerWidth();
                var h = $(this).innerHeight();
                $(this).css('position','relative').append('<div class="enitwar"></div><a class="editor_a" href=javascript:'+event+'><?php echo Yii::t('sellerDesign','编辑'); ?></a>');
                $(this).find('.enitwar').width(w).height(h);
                $(this).find('.enitwar').css({ "position": 'absolute', "z-index":99, "opacity": 0.5, "background-color": 'black', "left": 0, "top": 0 });
            },
            function () {
                $(this).find('.enitwar,.editor_a').remove();
            });
    }

    // JavaScript Document
    function getObject(objectId) {
        if(document.getElementById  &&  document.getElementById(objectId)) {
            return document.getElementById(objectId);
        }
        else if (document.all  &&  document.all(objectId)) {
            return document.all(objectId);
        }
        else if (document.layers  &&  document.layers[objectId]) {
            return document.layers[objectId];
        }
        else {
            return false;
        }
    }

    function showHide(e,objname){
        var obj = getObject(objname);
        if(obj.style.display == "none"){
            obj.style.display = "block";
            e.className="on";
        }else{
            obj.style.display = "none";
            e.className="bk";
        }
    }

    //店铺状态提醒
    var statusNotice = function (status) {
        $("#navcon li", window.parent.document).removeClass();
        $("#navcon li:first", window.parent.document).addClass("hover");
        art.dialog({
            title: '<?php echo Yii::t('design','消息') ?>',
            width: 220,// 必须指定一个像素宽度值或者百分比，否则浏览器窗口改变可能导致artDialog收缩
            content: status,
            time: 5,
            left: '100%',
            top: '100%',
            fixed: true,
            drag: false,
            resize: false
        });
    };
    /*盖网商铺引导*/
    var ChannelOff = function () {
        var url = '<?php echo $this->createAbsoluteUrl('help') ?>';
        dialog = art.dialog.open(url, {
            'title': '<?php echo Yii::t('sellerDesign', '盖网商铺引导'); ?>',
            'lock': true,
            'window': 'top',
            'width': 800,
            'height': 450,
            'border': true
        });
    };
    <?php if(isset($this->currentDesign) && $this->currentDesign->status==Design::STATUS_NOT_PASS && !empty($this->currentDesign->remark)): ?>
    var showRemark = function(){
        statusNotice("<?php echo Yii::t('sellerDesign', '审核不通过意见：'); ?><?php echo $this->currentDesign->remark ?>");
    };
    $(function(){
        showRemark();
    });

    <?php endif; ?>

    $(function(){
        //状态提示
        <?php if(Yii::app()->user->hasFlash('design_status')): ?>
        setTimeout(function () {
            statusNotice("<?php echo Yii::t('sellerDesign', '店铺装修的状态修改为 {a} 成功！',array('{a}'=>Design::status($this->getFlash('design_status')))); ?>");
        }, 1000);
        <?php endif ?>
        //店铺还原
        <?php if(Yii::app()->user->hasFlash('design_back')): ?>
        setTimeout(function () {
            statusNotice("<?php echo $this->getFlash('design_back') ?> ");
        }, 1000);
        <?php endif; ?>
    });

</script>