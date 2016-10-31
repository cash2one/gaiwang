<?php $this->breadcrumbs = array('充值兑换管理', '充值记录');?>
<div style="width:65%">
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th>批号：</th>
            <td><input class="text-input-bj" type="text" value="" name="bnum" id="bnum" onkeyup="javascript:RepNumber(this)"></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><input class="reg-sub" type="submit" value="搜索" name="yt0"></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
    
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
    <tbody>
    <tr>
        <th width="142" height="40" align="center" class="tdBg">批号</th>
        <th width="142" height="40" align="center" class="tdBg">时间</th>
        <th width="50" height="40" align="center" class="tdBg">操作</th>
    </tr>
    <?php if(!empty($data)):?>
        <?php foreach ($data as $k => $v): ?>
            <tr>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <?php echo $v['batch_number']; ?>
                </td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <?php echo date('Y-m-d H:i:s',$v['create_time']); ?>
                </td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <?php echo CHtml::form(Yii::app()->createAbsoluteUrl('ImportRecharge/HistoryDownLoad',array('num'=>$v['batch_number']))) ?>
                     <?php echo CHtml::submitButton('下载',array('class' => 'regm-sub')) ?>
                    <?php echo CHtml::endForm() ?>
                </td>
            </tr>
        <?php endforeach; ?>    
    <?php else:?>
            <tr>
                <td></td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    没有找到数据.
                </td>
                <td></td>
            </tr>
    <?php endif;?>
        <tr>
            充值记录：
        </tr>

    </tbody>
</table>
<style>
    .pager {width:100%}
</style>
<div class="pager">
    <?php
    $this->widget('LinkPager', array(
        'header' => '',
        'cssFile' => false,
        'firstPageLabel' => Yii::t('history', '首页'),
        'lastPageLabel' => Yii::t('history', '末页'),
        'prevPageLabel' => Yii::t('history', '上一页'),
        'nextPageLabel' => Yii::t('history', '下一页'),
        'maxButtonCount' => 10,
        'pages' => $pages,
        'ajax' => false
    ));
    ?> 
</div>
</div>
<script>
    //表单禁止输入字母和其他字符，只能输入数字
    function RepNumber(obj) {
        var reg = /^[\d]+$/g;
         if (!reg.test(obj.value)) {
             var txt = obj.value;
             txt.replace(/[^0-9]+/, function (char, index, val) {//匹配第一次非数字字符
                obj.value = val.replace(/\D/g, "");//将非数字字符替换成""
                var rtextRange = null;
                if (obj.setSelectionRange) {
                    obj.setSelectionRange(index, index);
                } else {//支持ie
                    rtextRange = obj.createTextRange();
                    rtextRange.moveStart('character', index);
                    rtextRange.collapse(true);
                    rtextRange.select();
                }
            })
         }
     }
</script>