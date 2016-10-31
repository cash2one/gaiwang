<link href="<?php echo AGENT_DOMAIN . '/agent'; ?>/css/agent.css" rel="stylesheet" type="text/css" />
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/common.js"></script>
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN . '/agent'; ?>/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script type="text/javascript">
    /**
     * 页面动画效果
     */
    $(document).ready(function() {
        $("#overlayer").ajaxStart(function(a) {
            $(this).show();
        });
        $("#overlayer").ajaxStop(function() {
            $(this).hide();
        });

        $('.tab').click(function() {
            $('.adClassList .tab').removeClass('selected');
            $(this).addClass('selected');
        });
    });

    /**
     * 解除指定广告的绑定
     */
    function removeAdvert(obj, title) {
        art.dialog({
            icon: 'question',
            content: "<?php echo Yii::t('Machine', '确认解除') ?><" + title + "><?php echo Yii::t('Machine', '这个广告的绑定') ?>?",
            lock: true,
            okVal: '<?php echo Yii::t('Public', '确定') ?>',
            ok: function() {
                location.href = obj.href;
            },
            cancelVal: '<?php echo Yii::t('Public', '取消') ?>',
            cancel: function() {
            }
        });
        return false;
    }

    /**
     * 解除选中广告的绑定
     */
    function removeChoose() {
        var hasChecked = false;
        var idData = [];		//定义保存id变量
        $('.adListItem').find('input[type=checkbox]').each(function() {
            if (this.checked) {
                idData.push(this.value);
                hasChecked = true;
            }
        });

        if (!hasChecked) {
            art.dialog({
                icon: 'warning',
                content: "<?php echo Yii::t('Public', '没有数据被选中') ?>",
                lock: true,
                okVal: '<?php echo Yii::t('Public', '确定') ?>',
                ok: true
            });
            return;
        }

        var myUrl = createUrl("<?php echo $this->createUrl('machineAgent/advertRemove') ?>", {"id":<?php echo $model->id ?>, "advert_id": idData, "adtype":<?php echo $adtype ?>});
        art.dialog({
            title: "<?php echo Yii::t('Public', '解除绑定') ?>",
            icon: 'question',
            content: "<?php echo Yii::t('Public', '确认解除选中广告在本盖机的绑定') ?>?",
            lock: true,
            okVal: '<?php echo Yii::t('Public', '确定') ?>',
            ok: function() {
                location.href = myUrl;
//        	jQuery.ajax({
//        		type:'GET',async:false,cache:false,dataType:'html',
//        		url:myUrl,
//        		error:function(request,status,errorcontent){
//        			alert(request.responseText);
//        		},
//        		success:function(data){
//        			$.fn.yiiListView.update("machine-advert-agent-list");
//        			$('.headerBar').find('input[type=checkbox]')[0].checked = false;
//        			var num = idData.length;
//        			var choose_id = $('.tab1_01').find('.tabhover')[0].id;
//        			if(choose_id=='ad_coupon'){
//        				coupon_num = coupon_num - num;
//						var tab_html = "优惠劵（"+coupon_num+"）";
//            		}else if(choose_id=='ad_sign'){
//        				sign_num = sign_num - num;
//						var tab_html = "首页轮播（"+sign_num+"）";
//                	}else if(choose_id=='ad_video'){
//        				video_num = video_num - num;
//						var tab_html = "视频（"+video_num+"）";
//                    }
//        			$('.tab1_01').find('.tabhover').html(tab_html);
//        			showMsg('succeed','解除绑定成功!');
//        		}
//        	});
            },
            cancelVal: '<?php echo Yii::t('Public', '取消') ?>',
            cancel: function() {
            }
        });
    }

    /**
     * 分类查询
     */
    function doQuery(categorypid, categoryid) {
        $('#MachineAdvertAgent_category_pid').val(categorypid);		//改变广告大类的值
        $('#MachineAdvertAgent_category_id').val(categoryid);		//改变广告子类的值

        if (categorypid == '' && categoryid == '') {
            $('.adClassListItem').find("ul").html('');
        }

        if (categorypid != '' && categoryid == '') {//如果有父节点但是没有子节点，表示点击的是父节点
            var myUrl = createUrl("<?php echo $this->createUrl('machineAdvertAgent/getChildType') ?>", {"pid": categorypid});
            jQuery.ajax({
                type: "get", dataType: "json", cache: false, async: false,
                url: myUrl,
                error: function(request, status, error) {
                    alert(request.responseText);
                },
                success: function(data) {
                    var childHtml = '';
                    for (var i = 0; i < data.length; i++) {
                        childHtml += '<li class="tab" onclick="checkLi(this)"><a href="javascript:doQuery(' + data[i].pid + ',' + data[i].id + ');"><span class="name">' + data[i].name + '</span></a></li>';
                    }
                    $('.adClassListItem').find("ul").html('').append(childHtml);
                }
            });
        }

        $('#machine_advert_agent_search').submit();
    }

    /**
     * 给选中子类型添加一个样式
     */
    function checkLi(obj) {
        $('.adClassListItem').find("li").removeClass('selected');
        $(obj).addClass('selected');
    }

    /**
     * 给盖机添加广告
     */
    function addAdvert() {
        var url = createUrl("<?php echo $this->createUrl('machineAgent/advertAdd') ?>", {"adtype":<?php echo $adtype ?>, "id":<?php echo $model->id ?>});
        art.dialog.open(url, {
            title: "<?php echo Yii::t('Public', '添加广告') ?>",
            lock: true,
            height: 630,
            width: 880,
            init: function() {//可以再这个地方写窗体加载之后的事件
                var iframe = this.iframe.contentWindow;		//获取iframe窗体
            },
            okVal: '<?php echo Yii::t('Public', '确定') ?>',
            ok: function() {
                var iframe = this.iframe.contentWindow;
                if (!iframe.document.body) {
                    alert("窗体还没有加载完毕!");
                    return false;
                }

                var id = '';
                var num = 0;
                $(iframe.document.getElementById('addAdvertList')).find("input[type=checkbox]").each(function() {
                    if ($(this)[0].checked) {
                        id += $(this).val() + ",";
                        num++;
                    }
                });

                id = id.substring(0, id.length - 1);
                var addAdvertListUrl = createUrl("<?php echo $this->createUrl('machineAgent/advertCreate') ?>", {"advertid": id, "id":<?php echo $model->id ?>, "adtype":<?php echo $adtype ?>});

                location.href = addAdvertListUrl;
                return;

                jQuery.ajax({
                    type: 'get', cache: false, async: false, dataType: 'html',
                    url: addAdvertListUrl,
                    error: function(request, error, status) {
                        alert(request.responseText + "--" + error + "--" + status);
                    },
                    success: function(data) {
                        $.fn.yiiListView.update("machine-advert-agent-list");

                        var choose_id = $('.tab1_01').find('.tabhover')[0].id;
                        if (choose_id == 'ad_coupon') {
                            coupon_num = coupon_num + num;
                            var tab_html = "优惠劵（" + coupon_num + "）";
                        } else if (choose_id == 'ad_sign') {
                            sign_num = sign_num + num;
                            var tab_html = "首页轮播（" + sign_num + "）";
                        } else if (choose_id == 'ad_video') {
                            video_num = video_num + num;
                            var tab_html = "视频（" + video_num + "）";
                        }
                        $('.tab1_01').find('.tabhover').html(tab_html);

                        showMsg('succeed', '添加成功!');
                    }
                });
            },
            cancelVal: '<?php echo Yii::t('Public', '取消') ?>',
            cancel: true
        });
        return false;
    }

    artDialog.notice = function(options) {
        var opt = options || {},
                api, aConfig, hide, wrap, top,
                duration = 800;

        var config = {
            id: 'Notice',
            left: '99%',
            top: '99%',
            fixed: true,
            drag: false,
            resize: false,
            follow: null,
            lock: false,
            init: function(here) {
                api = this;
                aConfig = api.config;
                wrap = api.DOM.wrap;
                top = parseInt(wrap[0].style.top);
                hide = top + wrap[0].offsetHeight;

                wrap.css('top', hide + 'px')
                        .animate({top: top + 'px'}, duration, function() {
                            opt.init && opt.init.call(api, here);
                        });
            },
            close: function(here) {
                wrap.animate({top: hide + 'px'}, duration, function() {
                    opt.close && opt.close.call(this, here);
                    aConfig.close = $.noop;
                    api.close();
                });

                return false;
            }
        };

        for (var i in opt) {
            if (config[i] === undefined)
                config[i] = opt[i];
        }
        ;

        return artDialog(config);
    };

    function showMsg(img, myContent) {
        art.dialog.notice({
            tlock: false, //不锁屏
            title: "提示", //标题
            icon: img, //图标
            content: myContent, //提示信息
            time: 3, //显示时间
            fixed: true, //定位不动
            width: 225, //宽度
            height: 105, //高度
            drag: false, //和resize合并起来表示禁止拖动
            resize: false,
            left: '99%', //显示位置
            top: '99%'
        });
    }
</script>

<div class="ctx advertMana">
    <div class="optPanel">
        <div class="toolbar img01">
            <?php echo $model->name ?> ->  <?php echo Yii::t('Machine', '资源管理') ?>
            <?php echo CHtml::link(Yii::t('Public', '返回'), $this->createUrl('machineAgent/index'), array('class' => 'button_04 floatRight')) ?>
        </div>
    </div>
    <?php
    //处理每个广告的个数
    $coupon = $listCounts['Coupon'] == '' ? 0 : $listCounts['Coupon'];
    $sign = $listCounts['Sign'] == '' ? 0 : $listCounts['Sign'];
    $video = $listCounts['Vedio'] == '' ? 0 : $listCounts['Vedio'];
    $product = $listCounts['Product'] == '' ? 0 : $listCounts['Product'];


    //确定显示广告类型
    $classCoupon = $adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON ? "tabhover" : "";
    $classSign = $adtype == MachineAdvertAgent::ADVERT_TYPE_SIGN ? "tabhover" : "";
    $classVideo = $adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO ? "tabhover" : "";
    $classProduct = $adtype == MachineAdvertAgent::ADVERT_TYPE_PRODUCT ? "tabhover" : "";
    ?>

    <script type="text/javascript">
        var coupon_num = <?php echo $coupon ?>;
        var sign_num = <?php echo $sign ?>;
        var video_num = <?php echo $video ?>;
        var product_num = <?php echo $product; ?>;
    </script>
    <div id="dListTable" class="ctxTable">
        <table width="100%" border="0" cellspacing="1" cellpadding="0" class="inputTable">
            <tbody>
                <tr class="caption">
                    <td colspan="2">
                        <div class="tab1 fl">
                            <p></p>
                            <?php
                            if (Yii::app()->language == 'en') {
                                echo "<div class='tab1_01_en fl_en'>";
                            } else {
                                echo "<div class='tab1_01 fl'>";
                            }
                            ?>
                            <?php echo CHtml::link(Yii::t('Machine', '格子铺') . "（" . $coupon . "）", $this->createUrl('machineAgent/AdvertList', array('id' => $model->id, 'adtype' => MachineAdvertAgent::ADVERT_TYPE_COUPON)), array('class' => $classCoupon, 'id' => 'ad_coupon')) ?>
                            <?php echo CHtml::link(Yii::t('Machine', '首页轮播') . "（" . $sign . "）", $this->createUrl('machineAgent/AdvertList', array('id' => $model->id, 'adtype' => MachineAdvertAgent::ADVERT_TYPE_SIGN)), array('class' => $classSign, 'id' => 'ad_sign')) ?>
                            <?php echo CHtml::link(Yii::t('Machine', '视频') . "（" . $video . "）", $this->createUrl('machineAgent/AdvertList', array('id' => $model->id, 'adtype' => MachineAdvertAgent::ADVERT_TYPE_VEDIO)), array('class' => $classVideo, 'id' => 'ad_video')) ?>
                            <?php //echo CHtml::link(Yii::t('Machine','商品管理')."（".$product."）",$this->createUrl('machineAgent/productList',array('id'=>$model->id,'adtype'=>  MachineAdvertAgent::ADVERT_TYPE_PRODUCT)),array('class'=>$classProduct,'id'=>'ad_product'))?>
                        </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php if ($adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON) {//只有优惠劵才使用到这个广告类型查询?>
                            <div class="panel">
                                <div class="adClassList">
                                    <ul>
                                        <?php
                                        $allClass = $adModel->category_pid == '' ? 'selected' : '';
                                        $allStyle = $adModel->category_pid == '' ? '' : 'background:url(/images/home.gif) no-repeat;';
                                        ?>
                                        <li>
                                            <?php echo CHtml::link(Yii::t('Public', '所有分类'), $this->createUrl('machineAgent/advertList', array('id' => $model->id, 'adtype' => $adtype, 'category_pid' => '', 'category_id' => '')), array('class' => "tab $allClass", 'style' => "$allStyle")); ?>
                                        </li>
                                        <?php
                                        $pclass = '';
                                        $pstyle = 'background:url(/images/home.gif) no-repeat;';
                                        foreach ($typeData as $key => $val):
                                            if ($adModel->category_pid != "") {
                                                if ($val['id'] == $adModel->category_pid) {
                                                    $pclass = "selected";
                                                    $pstyle = "";
                                                } else {
                                                    $pclass = "";
                                                    $pstyle = "background:url(/images/home.gif) no-repeat;";
                                                }
                                            }
                                            ?>
                                            <li>
                                                <?php echo $val['id'] == 2 ? CHtml::link($val['name'], $this->createUrl('machineAgent/advertList', array('id' => $model->id, 'adtype' => $adtype, 'category_pid' => $val['id'])), array('class' => "tab $pclass", 'style' => "$pstyle")) : "" ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="adClassListItem">
                                    <ul>
                                        <?php
                                        $cclass = "";
                                        foreach ($typeChild as $keyChile => $valChile):
                                            if ($adModel->category_id != "") {
                                                if ($valChile['id'] == $adModel->category_id) {
                                                    $cclass = "selected";
                                                } else {
                                                    $cclass = "";
                                                }
                                            }
                                            ?>
                                            <li class="tab <?php echo $cclass ?>" onclick="checkLi(this)">
                                                <a href="<?php echo $this->createUrl('machineAgent/advertList', array('id' => $model->id, 'adtype' => $adtype, 'category_pid' => $valChile['pid'], 'category_id' => $valChile['id'])) ?>">
                                                    <span class="name"><?php echo $valChile['name'] ?></span>
                                                </a>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="headerBar">
                            &nbsp;&nbsp;&nbsp;<label><?php echo CHtml::checkBox("", false, array('onclick' => 'doChooseAll(this,"adListItem")')) ?><?php echo Yii::t('Public', '全选') ?></label>&nbsp;&nbsp;
                            <?php echo CHtml::link(Yii::t('Public', '解除绑定'), 'javascript:removeChoose()', array('class' => 'button_04')) ?>
                            <?php echo CHtml::link(Yii::t('Public', '添加'), 'javascript:;', array('class' => 'button_04', 'onclick' => 'addAdvert()')) ?>
                            <?php if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {//视频没有排序?>
                                <?php echo CHtml::link(Yii::t('Public', '排序'), $this->createUrl('machineAgent/advertSort', array('id' => $model->id, 'adtype' => $adtype, 'category_pid' => 2)), array('class' => 'button_04')) ?>
                            <?php } ?>
                        </div>

                        <div class="adListItem">
                            <ul class="ad-list">
                                <?php
                                $this->widget('application.modules.agent.widgets.ListView', array(
                                    'dataProvider' => $adModel->searBingAdvert(),
                                    'itemView' => 'advertview',
                                    'id' => 'machine-advert-agent-list'
                                ));
                                ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="footerBar"></div>
    </div>
</div>

<style>
    .tab1_01_en{width:100%; height:45px; font:18px "微软雅黑", "新宋体";  border-bottom:2px solid #7c7c7c; }
    .tab1_01_en span{width:150px; height:45px; background:url(<?php echo AGENT_DOMAIN . '/agent' ?>/images/tongji.png) no-repeat 5px 8px; padding-left:40px; line-height:45px; display:block; float:left; border:none; !important}
    .tab1_01_en a{width:173px; height:44px; color:#c2c2c2; font-size: 14px; font-weight: bold; line-height:44px; text-align:center; display:block; float:left; border:1px solid #c2c2c2;  border-bottom:2px solid #7c7c7c;}
    .tab1_01_en a:hover{width:171px; color:#222222; height:44px; background:#FFF; border:2px solid #7c7c7c; border-bottom:2px solid #FFF !important;}
    .tab1_01_en a.tabhover{width:171px; height:44px; color:#222222; background:#FFF; border:2px solid #7c7c7c; border-bottom:2px solid #FFF !important;}

    .fl_en{float:left;}
</style>