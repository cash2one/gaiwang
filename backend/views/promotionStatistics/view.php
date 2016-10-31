<?php

/* @var $this PromotionStatisticsController */
/* @var $model PromotionStatistics */
$this->breadcrumbs = array(
    Yii::t('promotionStatistics', '统计管理'),
    Yii::t('promotionStatistics', ' 推广渠道列表') => array('admin'),
    Yii::t('promotionStatistics', '推广渠道基本信息'),
);

$url=PromotionChannels::getRigisterType($model->register_type);
$tgUrl=$url."?ad=".$model->number;
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th style="width:120px" class="even">
            <?php echo Yii::t('promotionStatistics', '渠道名称'); ?>：
        </th>
        <td class="even">
             <?php echo $model->name;?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo Yii::t('promotionStatistics', '推广编号'); ?>：
        </th>
        <td class="even">
            <?php echo $model->number;?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo Yii::t('promotionStatistics', '注册页面类型'); ?>：
        </th>
        <td class="odd">
            <?php echo PromotionChannels::getLoginType($model->register_type);?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo Yii::t('promotionStatistics', '渠道网址备注'); ?>：
        </th>
        <td class="odd">
            <?php echo $model->remark;?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo Yii::t('promotionStatistics', '推广网址'); ?>：
        </th>
        <td class="odd">
            <input style="width:450px" class="text-input-bj middle" id="copyUrl" type="text" value="<?php echo $tgUrl?>" readOnly>
            <a href="javascirpt:void()" id="goCopyButton">复制网址</a>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo Yii::t('promotionStatistics', '推广二维码'); ?>：
        </th>
        <td class="odd">
             <?php  
                 $this->widget('comext.QRCodeGenerator',array(
                        'data' => $tgUrl,
                        'size'=>2.4,
                        'imageTagOptions' => array('width'=>'100','height'=>'100'),
              )) ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td class="odd">
          <a class='reg-sub' href="<?php echo Yii::app()->createUrl("PromotionStatistics/update",array("id"=>$model->id)) ?>"> 编辑</a>
        </td>
    </tr>
</table>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/zeroclipboard/ZeroClipboard.js'?>"></script>
<script type="text/javascript">
		var clip = null;
		function init() {
			clip = new ZeroClipboard.Client();
			clip.setHandCursor( true );
			clip.addEventListener( "onmousedown", function(client) {
				clip.setText(document.getElementById('copyUrl').value); 	
			});
			clip.addEventListener("onComplete",function( client){alert("链接复制成功",'提示信息')});
			clip.glue('goCopyButton');//父元素要是相对定位，而且是可见的元素
		}
		$(document).ready(function(){
			ZeroClipboard.setMoviePath("<?php echo Yii::app()->baseUrl.'/js/zeroclipboard/ZeroClipboard.swf'?>");
			init();
		})
</script>	
