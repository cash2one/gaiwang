<div class="mbRight">
    <div class="purseCont">
        <h3>
            我的钱包
            <a href="javascript:history.go(-1);" class="goBack">返回</a>
        </h3>
        <div class="detailList">

            <div class="purseDetail">
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank mgtop10">
                    <tr>
                       <th align="center" class="tdBg" height="40" width="200">
                           <b><?php echo Yii::t('Activity', '领取时间'); ?></b>
                       </th>
                        <th align="center" class="tdBg" width="200">
                            <b><?php echo Yii::t('Activity', '红包类型'); ?></b>
                        </th>
                        <th align="center" class="tdBg" width="200">
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
                            $this->widget('LinkPager', array(
                                'pages' => $redList->pagination,
                                'jump' => false,
                                'htmlOptions' => array('class' => 'pagination'),
                            ))
                            ?>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>