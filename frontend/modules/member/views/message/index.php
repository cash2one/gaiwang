<?php
/* @var $this MessageController */
/* @var $dataProvider CActiveDataProvider */
// 站内信列表页面视图
$this->breadcrumbs = array(
    Yii::t('memberMessage', '账户管理') => '',
    Yii::t('memberMessage', '站内信'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMessage', '站内信息'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="MessageTable">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'method' => 'post',
                        'htmlOptions' => array(
                            'onsubmit' => 'return getCheckbox()',
                        ),
                    ));
                    ?>
                    <table cellspacing="0" cellpadding="0" border="0" width="99%" class="t_Message">
                        <tbody>
                            <tr>  	
                                <th width="12%" class="first"><input type="checkbox" id="checkAll" class="checkbg" >&nbsp;<?php echo Yii::t('memberMessage', '全选'); ?></th>
                                <th width="9%"><?php echo Yii::t('memberMessage', '发件人'); ?></th>
                                <th width="9%"><?php echo Yii::t('memberMessage', '状态'); ?></th>
                                <th width="50%"><?php echo Yii::t('memberMessage', '主题'); ?></th>
                                <th width="20%" class="last"><?php echo Yii::t('memberMessage', '时间'); ?></th>
                            </tr>
                            <?php if ($mailboxs = $dataProvider->getData()): ?>
                                <?php foreach ($mailboxs as $mailbox): ?>
                                    <tr> 
                                        <td class="first"><input type="checkbox" name="ids[]" value="<?php echo $mailbox->id; ?>"></td>
                                        <td><?php echo $mailbox->message->sender; ?></td>
                                        <td><span <?php if ($mailbox->status == Mailbox::STATUS_UNRECEIVE): ?>class="red"<?php endif; ?>><?php echo Mailbox::showStatus($mailbox->status); ?></span></td>
                                        <td><?php echo CHtml::link($mailbox->message->title, $this->createAbsoluteUrl('/member/message/view', array('id' => $mailbox->id))); ?></td>
                                        <td class="last"><?php echo date("Y/m/d H:i:s", $mailbox->message->create_time); ?></td>
                                    </tr>	
                                <?php endforeach; ?>
                                <tr> 
                                    <td class="first" colspan="2">
                                        <?php
                                        echo CHtml::link(Yii::t('memberMessage', '批量删除'), 'javascript:;', array(
                                            'class' => 'btnBatchDelRea',
                                            'submit' => $this->createAbsoluteUrl("/member/message/delete"),
                                            'confirm' => Yii::t('memberMessage', '你确定要删除这些信息吗？')
                                        ));
                                        ?>
                                        <?php
                                        echo CHtml::link(Yii::t('memberMessage', '批量阅读'), 'javascript:;', array(
                                            'class' => 'btnBatchDelRea',
                                            'submit' => $this->createAbsoluteUrl("/member/message/update"),
                                            'confirm' => Yii::t('memberMessage', '你确定要批量阅读这些信息吗？')
                                        ));
                                        ?>
                                    </td>
                                    <td class="last" colspan="4">
                                        <div class="pagination">
                                            <?php
                                            $this->widget('CLinkPager', array(
                                                'header' => '',
                                                'cssFile' => false,
                                                'firstPageLabel' => Yii::t('page', '首页'),
                                                'lastPageLabel' => Yii::t('page', '末页'),
                                                'prevPageLabel' => Yii::t('page', '上一页'),
                                                'nextPageLabel' => Yii::t('page', '下一页'),
                                                'maxButtonCount' => 13,
                                                'pages' => $dataProvider->pagination
                                            ));
                                            ?>  
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="empty"><span><?php echo Yii::t('memberMessage', '没有找到数据'); ?>.</span></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#checkAll").click(function() {
            if (this.checked)
                $("input[name='ids[]']").attr("checked", true);
            else
                $("input[name='ids[]']").attr("checked", false);
        })
    })
    var getCheckbox = function() {
        var data = new Array();
        $(".first input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            return true;
        } else {
            alert('<?php echo Yii::t('memberMessage', '请选择要操作的数据!'); ?>');
            return false;
        }
    }
</script>