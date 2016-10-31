<?php
/**
 * @var $this RedEnvelopeController
 *
 */
$this->pageTitle = "领取清单_我的钱包_" . $this->pageTitle;
?>

<script type="text/javascript">
 $(function(){
		//分页居中
	 var yiiPageerW=parseInt($(".yiiPageer").css("width"));
	 var pageListInfoW=parseInt($(".pageList-info").css("width"));
	 var pageListW=parseInt($(".pageList").css("width"));
	 var num=(pageListW-(yiiPageerW+pageListInfoW))/2;
	 $(".pageList").css("padding-left",num);
	 })
</script>

<div class="main-contain">
    <div class="evaluate-hd">
        <span class="title">领取清单</span>
    </div>
    <table class="member-table" width="100%">
        <tr class="col-name">
            <th align="center" class="tdBg" >
                <b><?php echo Yii::t('Activity', '领取时间'); ?></b>
            </th>
            <th align="center" class="tdBg" >
                <b><?php echo Yii::t('Activity', '红包类型'); ?></b>
            </th>
            <th align="center" class="tdBg" >
                <b><?php echo Yii::t('Activity', '面值'); ?></b>
            </th>
        </tr>
        <?php
        $redList = $model->searchList($this->getUser()->id);
        $data = $redList->getData();
        /** @var $v Coupon */
        ?>
        <?php foreach($data as $k =>$v): ?>
            <tr>
                <td align="center" height="40"  class="bgF4"><?php echo  date('Y-m-d',$v->create_time); ?></td>
                <td align="center" class="bgF4"><?php echo Activity::getType($v->type) ?></td>
                <td align="center" class="bgF4"><?php echo $v->money; ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="6" style="text-align: center" class="empty">
                    <?php
                    echo CHtml::link('没有红包领取记录，马上去领红包>>',Yii::app()->createAbsoluteUrl('/member/site'));
                    ?>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td height="35" colspan="3" align="center" valign="middle" class="bgF4">
                <?php
                $this->widget('SLinkPager', array(
                    'pages' => $redList->pagination,
                    'jump' => false,
                    'htmlOptions'=>array(
                        'class'=>'yiiPageer',   //包含分页链接的div的class
                    )
                ))
                ?>
            </td>
        </tr>
    </table>

</div>