<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
    '臻致生活'=>array('admin'),
    '列表',
);

$this->menu=array(
    array('label'=>'List AppTopicLife', 'url'=>array('index')),
    array('label'=>'Create AppTopicLife', 'url'=>array('create')),
);
?>
<div class="com-box">
    <div class="clearfix search-form">
        <?php $this->renderPartial('_lifesearch',array('model'=>$model,'lifeId'=>$lifeId)); ?>
    </div>
    <!-- com-box -->
    <div class="sign-contract">
        <div class="c10"></div>
        <?php if(!empty($lifeData)):?>
        <div class="sign-conten">
            <div class="sign-tableTitle">专题：<?php echo $lifeData[0]['title']?></div>
            <div class="sign-list">
                <?php foreach($lifeData as $k=>$v):?>
                <span  class="sign-tableTitle"><?php echo $k+1;?></span>
                <ul>
                   <li>
                       <span style="width: 90px"><img style="width:50px" src="<?php if(!empty($v['head_portrait'])) echo ATTR_DOMAIN . DS .$v['head_portrait'];?>" /></span>
                       <span style="width: 90px"><?php $Name = $v['nickname'] !=''? $v['nickname'] : $v['gai_number'];echo $Name;?></span>
                       <span><?php echo date("Y-m-d H:i:s",$v['create_time'])?></span>
                    </li>
                    <li>
                        <span   style="text-align:left;width:100%">问题：<?php echo rawurldecode($v['problem'])?></span>
                    </li>
                    <li>
                        <span  style="text-align:left;width:100%">-------------------------------------------------------</span>
                    </li>
                    <li id="context<?php echo $v['id'];?>">
                        <?php echo $getLifeAgen[$v['id']];?>
                    </li>
                    <li style="line-height:20px">
                        <span style="color: #999999"><a class="btn-sign" onclick="addRemark(<?php echo $v['id'];?>)"><?php $Check = empty($getLifeAgen[$v['id']])?'回复':'修改';echo $Check;?></a></span>
                    </li>
                    <li>
                        <span  style="text-align:left;width:100%">-------------------------------------------------------</span>
                    </li>
                    <?php foreach($ChildList[$v['id']] as $ke=>$va):?>
                        <?php if(!empty($va)):?>
                    <li>
                        <span><?php $ChildName = $va['nickname'] !=''? $va['nickname'] : $va['gai_number'];echo $ChildName;?>：</span>
                        <span style="width: 900px;text-align:left;"><?php echo rawurldecode($va['problem']);?></span>
                    </li>
                            <li>
                                <span  style="text-align:left;width:100%">-------------------------------------------------------</span>
                            </li>
                            <?php endif;?>
                        <?php endforeach;?>
                </ul>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
        <tr class="confirmTR" style="background:#FFF;">
            <td>
                <textarea id="remark" cols="70" rows="25"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    function addRemark(id){
        //发送ajax验证
        var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/agentReply')?>';
        $.ajax({
            type: "post", async: false, dataType: "json", timeout: 5000,
            url: url,
            data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,remark:'data'},
            success:function(data){
                $("#remark").html(data);
            }
        });
        art.dialog({
            title: '<?php echo '添加回复内容' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
                //数据检验
                var remarkContent = $('#remark').val();
                if (remarkContent == '') {
                    art.dialog({
                        icon: 'warning',
                        content: '请输入回复内容',
                        lock: true,
                        ok: function () {
                            $('#remark').focus();
                        }
                    });
                    return false;
                }
                //发送ajax验证
                var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/agentReply') ?>';
                $.ajax({
                    type: "post", async: false, dataType: "json", timeout: 5000,
                    url: url,
                    data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,remark:remarkContent},
                    success:function(data){
                        if(data.success) {
                            $("#context"+id).html(remarkContent);
                            art.dialog({icon: 'success', content: data.success, ok: true});
                        }
                        else
                            art.dialog({icon: 'warning', content: data.error, ok:true});
                    }
                });

            }
        })
    }
</script>