<style>
    #agentmember-grid table{width:100%;cellspacing:0;cellpadding:0;}
    a {color: #666666; }
</style>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<div class="line table_white" style="margin: 10px;">
    <?php $this->renderPartial('_search',array('model'=>$model));?>
    <?php 
        $this->widget('application.modules.agent.widgets.grid.GridView',array(
                'id'=>'agentMaintenance-grid',
                'itemsCssClass' => 'table1',
                'dataProvider' => $model->search(),
                'pagerCssClass' => 'line pagebox',
                'template' => '{items}{pager}',
                'columns' => array(
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'GWnumber',
                    'value' => '$data->GWnumber',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'username',
                    'value' => '$data->username',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'mobile',
                    'value' => '$data->mobile',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'create_time',
                    'value' => 'date("Y-m-d H:i:s",$data->create_time)',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('AgentMaintenance', '操作'),
                    'type' => 'raw',
                    'value' => 'AgentMaintenance::createButtons($data->id)',
                ),
//                array(
//                    'class'=>'CButtonColumn',
//                    'header' => Yii::t('AgentMaintenance','操作'),
//                    'updateButtonImageUrl' => true,
//                    'deleteButtonImageUrl' => false,
//                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
//                    'htmlOptions' => array('class' => 'tc'),
//                	'template' => '{update} {delete}',
//                    'buttons'=>array(
//                        'update' => array(
//                            'label' => Yii::t('AgentMaintenance','【编辑】'),
//                            'url' => 'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey))',
//                            'imageUrl' => false,
//                        ),
//                        'delete' => array(
//                        	'label' => Yii::t('AgentMaintenance','【删除】'),
//                        	'url' => 'Yii::app()->controller->createUrl("delete", array("id"=>$data->primaryKey))',
//                            'imageUrl' => false,
//                        ),
//                    ),
//                ),
            )
        ));
    ?>
</div>

<div style="display: none" id="resetPwdDiv">
    <lab>请输入新密码：</lab>
    <input type="password" id="resetPwd" />
</div>

<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
    </style>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
        <tr class="confirmTR" >
            <th class="even">商城GW号：</th>
            <td class="even" >
                <input id="GWNo" style="float: left;margin-left: 5px;width:200px;height: 20px;" type="text" name="GWNo" value=""/>
                <input id="GWNoSearch" type="button" value="搜索" onclick="GWNoSearch();" style="float: left;margin-left: 5px;" />
            </td>
        </tr>
        <tr class="confirmTR" style="background:#FFF;">
            <th class="even"  style=" float:left;">设置密码：</th>
            <td class="even" >
                <input id="password" style="float: left;margin-left: 5px;width:200px;height: 20px;" type="password" name="password" value=""/>
            </td>
        </tr>
        <tr class="confirmTR" >
            <th class="even">用户名：</th>
            <td class="even" ><p id="showUsername"  style="width:250px; word-break:break-all;"></p></td>
        </tr>
        <tr class="confirmTR" >
            <th class="even">电话：</th>
            <td class="even" ><p id="showMobile"  style="width:250px; word-break:break-all;"></p></td>
        </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    //绑定会员
    $("#bindMember").click(function() {
        var url = '<?php echo $this->createUrl('bindMember') ?>';
        art.dialog({
                title: '<?php echo Yii::t('AgentMaintenance', '绑定运维人员') ?>',
                okVal: '<?php echo Yii::t('AgentMaintenance', '确定') ?>',
                cancelVal: '<?php echo Yii::t('AgentMaintenance', '取消') ?>',
                content: $("#confirmArea").html(),
                lock: true,
                cancel: true,
                ok:function(){
                    var GWNo = $('#GWNo').val();
                    var password = $('#password').val();
                    var showUsername = $("#showUsername").html();
                    var showMobile = $("#showMobile").html();
                    if (GWNo.length == 0 && status != 'transfering') {
                        art.dialog({
                            icon: 'warning',
                            content: '<?php echo Yii::t('AppHotGoods', '请输入要绑定的GW号')?>',
                            lock:true,
                            ok:function(){
                                $('#GWNo').focus();
                            }
                        });
                        return false;
                    }
                    if (!showUsername && !showMobile) {
                        art.dialog({
                            icon: 'warning',
                            content: '<?php echo Yii::t('AppHotGoods', '请点击搜索后再进行添加！')?>',
                            lock:true,
                            ok:function(){
                                $('#GWNo').focus();
                            }
                        });
                        return false;
                    }
                    if(checkGWNo(GWNo) && checkPassword(password)){
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: url,
                            data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', GWNo: GWNo,password:password},
                            success: function(data) {
                                if (data.success) {
                                    art.dialog({icon: 'succeed', content: data.success});
                                    location.reload();
                                } else {
                                    art.dialog({
                                        icon: 'warning',
                                        content: data.error,
                                        lock:true,
                                        ok:function(){
                                            $("#GWNo").empty();
                                            $('#GWNo').focus();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            }
        );
    });

    /**
     * 后端检测GW号
     * @returns {boolean}
     * @constructor
     */
    function GWNoSearch(){
        var GWNo = $('#GWNo').val();
        if(checkGWNo(GWNo)){
            var url = '<?php echo $this->createUrl('checkGWNo') ?>';
            $('#GWNoSearch').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: url,
                data: {'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', GWNo: GWNo},
                success: function(data) {
                    if (data.success) {
                        $("#showUsername").html(data.username);
                        $("#showMobile").html(data.mobile);
                    } else {
                        art.dialog({
                            icon: 'warning',
                            content: data.error,
                            lock:true,
                            ok:function(){
                                $("#showUsername").empty();
                                $("#showMobile").empty();
                                $("#GWNo").attr('value','');
                                $('#GWNo').focus();
                            }
                        });
                    }
                    $('#GWNoSearch').removeAttr('disabled');
                }
            });
        }
    }

    /**
     * 前端检测盖网号
     */
    function checkGWNo(GWNo){
        var re = /^(GW|gw|Gw|gW)[0-9]{7,15}$/;
        if (!re.test(GWNo)) {
            art.dialog({
                icon: 'warning',
                content: '请输入正确的GW号',
                lock:true,
                ok:function(){
                    $('#GWNo').attr('value','');
                    $('#GWNo').focus();
                }
            });
            return false;
        }
        else return true;
    }

    /**
     * 前端验证密码
     */
    function checkPassword(password){
        if( password.trim() == '' ){
            art.dialog({
                icon: 'warning',
                content: '无效密码',
                lock:true,
                ok:function(){
                    $('#password').attr('value','');
                    $('#password').focus();
                }
            });
            return false;
        }
        else return true;
    }

    /**
     * 重设密码
     */
    function resetPwd(id){
        var url = '<?php echo $this->createUrl('resetPwd') ?>';
        art.dialog({
                title: '<?php echo Yii::t('AgentMaintenance', '重置密码') ?>',
                okVal: '<?php echo Yii::t('AgentMaintenance', '确定') ?>',
                cancelVal: '<?php echo Yii::t('AgentMaintenance', '取消') ?>',
                content: $("#resetPwdDiv").html(),
                lock: true,
                cancel: true,
                ok:function(){
                    var resetPwd = $('#resetPwd').val();
                    if(checkPassword(resetPwd)){
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: url,
                            data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,password:resetPwd},
                            success: function(data) {
                                if (data.success) {
                                    art.dialog({icon: 'succeed', content: '重设密码成功'});
                                    location.reload();
                                } else {
                                    art.dialog({
                                        icon: 'warning',
                                        content: data.error,
                                        lock:true,
                                        ok:function(){
                                            $("#GWNo").empty();
                                            $('#GWNo').focus();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            }
        );
    }

    /**
     * 接触绑定
     */
    function resetBind(){

    }
</script>
