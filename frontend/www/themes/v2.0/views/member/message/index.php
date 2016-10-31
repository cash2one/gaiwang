<!--主体start-->

<div class="member-contain clearfix">

    <div class="main-contain">


        <div class="information-box">
            <div class="information-item">
                <ul>
                    <?php if ($mailboxs = $dataProvider->getData()): ?>
                    <?php foreach ($mailboxs as $mailbox): ?>
                    <a href="<?php echo $this->createAbsoluteUrl('/member/message/views',array('id'=>$mailbox['id'])) ?>" target="_blank">
                    <li <?php if ($mailbox->status == Mailbox::STATUS_RECEIVED): ?>class="on"<?php endif; ?> >
                        <p class="item-icon cover-icon"></p>
                        <p class="item-time"><?php echo date("Y/m/d H:i:s", $mailbox->message->create_time); ?></p>
                        <p class="item-txtle"><?php echo Tool::truncateUtf8String($mailbox->message->content,100) ?></p>
                    </li>
                    </a>
                    <?php endforeach; ?>
                    <?php else: ?>

                            <p class="information-not">您还没有收到消息哦~~</p>

                    <?php endif; ?>
                </ul>
            </div>

            <div class="pageList clearfix">
                <?php
                $this->widget('SLinkPager', array(
                    'header' => '',
                    'cssFile' => false,
                    'firstPageLabel' => Yii::t('page', '首页'),
                    'lastPageLabel' => Yii::t('page', '末页'),
                    'prevPageLabel' => Yii::t('page', '上一页'),
                    'nextPageLabel' => Yii::t('page', '下一页'),
                    'maxButtonCount' => 13,
                    'pages' => $dataProvider->pagination,
                    'htmlOptions'=>array(
                    'class'=>'yiiPageer',   //包含分页链接的div的class
                    'id' => 'yw0'
                )
                ));
                ?>
            </div>

        </div>


    </div>
</div>
<!-- 主体end -->