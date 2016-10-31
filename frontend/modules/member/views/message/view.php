<?php
/* @var $this MessageController */
/* @var $model Message */
// 站内信详情页面视图
$this->breadcrumbs = array(
    Yii::t('memberMessage', '站内信') => array('/member/message'),
    '详情'
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
                    <li class="curr"><a href="javascript:;" title="站内信息"><span><?php echo Yii::t('memberMessage','站内信息');?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="MessageTable">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="t_MessageDet">
                        <tbody>
                            <tr>  	
                                <th width="17%"><?php echo Yii::t('memberMessage','发件人');?>：</th>
                                <td width="83%"><?php echo $model->message->sender; ?></td>
                            </tr>
                            <tr> 
                                <th><?php echo Yii::t('memberMessage','时间');?>：</th>
                                <td><?php echo date("Y/m/d H:i:s", $model->message->create_time); ?></td>
                            </tr>	
                            <tr> 
                                <th><?php echo Yii::t('memberMessage','收件人');?>：</th>
                                <td><?php echo !empty($model->member->gai_number)?$model->member->gai_number:''; ?></td>
                            </tr>
                            <tr> 
                                <th colspan="2"><?php echo Yii::t('memberMessage','内容');?></th>
                            </tr>
                            <tr> 
                                <td colspan="2" style="text-align:left;">
                                    <?php echo $model->message->content; ?>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="2">
                                    <?php echo CHtml::htmlButton(Yii::t('memberMessage','返回列表'), array('class' => 'btnBack', 'onClick' => 'window.history.back()')); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>