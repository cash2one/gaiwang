<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <link href="/css/reg.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
        <script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
        <script type="text/javascript">
            function deduct(orderid, deduct) {
                var ad = artDialog;
                var p = artDialog.open.origin;
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo urldecode(Yii::app()->createAbsoluteUrl("hotelOrder/cancelVerifyOrder", array("id" => '\'+orderid+\'', 'deduct' => '\'+deduct+\''))); ?>',
                    data: {'YII_CSRF_TOKEN' : '<?php echo Yii::app()->request->csrfToken; ?>'},
                    success: function(data) {
                        var data = $.parseJSON(data);
                        p.dialog.close();
                        if (data.status == true) {
                            p.jump(data.msg);
                            return;
                        }
                        ad.alert(data.msg, null, 'error');
                    },
                    cache: false
                });
            };
        </script>
    </head>
    <body>
        <div class="main">
            <div style="margin-left: 30px;margin-top: 30px;">
                <a href="javascript:deduct(<?php echo $id; ?>,true)" class="regm-sub">确定扣除</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:deduct(<?php echo $id; ?>,false)" class="regm-sub">不扣除</a>
            </div>
        </div>
    </body>
</html>
