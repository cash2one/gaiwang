<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember','账户管理')=>'',
    Yii::t('memberMember',' 我的推荐会员'),
);
?>
<div class="main-contain">
		      
  <div class="accounts-box">
      <p class="accounts-title cover-icon"><?php echo Yii::t('memberMember','我的推荐会员'); ?></p>
      <?php
//	  $form = $this->beginWidget('CActiveForm', array(
//		  'id' => 'message-form',
//		  'method' => 'post',
//		  'htmlOptions' => array(
//			  'onsubmit' => 'return getCheckbox()',
//		  ),
//	  ));
	  ?>
      <table class="member-table" border="0">
        <tr class="member-title">
          <td class="member-gw"><?php echo Yii::t('memberMember', '用户GW号'); ?></td>
          <td class="member-name"><?php echo Yii::t('memberMember', '用户名'); ?></td>
          <td class="member-time"><?php echo Yii::t('memberMember', '注册时间'); ?></td>
          <td class="member-timed"><?php echo Yii::t('memberMember', '推荐时间'); ?></td>
        </tr>
        <?php if ($user_lists = $dataProvider->getData()): ?>
        <?php foreach ($user_lists as $user): ?>
        <tr>
          <td><?php echo $user->gai_number; ?></td>
          <td><?php echo $user->username; ?></td>
          <td><?php echo $user->register_time?date("Y/m/d H:i:s", $user->register_time):''; ?></td>
          <td><?php echo $user->referrals_time?date("Y/m/d H:i:s", $user->referrals_time):''; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td class="last" colspan="4">
                <div class="pageList clearfix" >
                    <?php
                    $this->widget('SLinkPager', array(
                        'cssFile' => false,
                        'header' => '',
                        'firstPageLabel' => Yii::t('category', '首页'),
                        'lastPageLabel' => Yii::t('category', '末页'),
                        'prevPageLabel' => Yii::t('category', '上一页'),
                        'nextPageLabel' => Yii::t('category', '下一页'),
                        'pages' => $dataProvider->pagination,
                        'maxButtonCount' => 13,
                        'htmlOptions' => array(
                            'class' => 'yiiPageer',
                        )
                    ));
                    ?>
                </div>
            </td>
        </tr>
        <?php else: ?>
        <tr><td colspan="4" class="empty"><span><?php echo Yii::t('memberMember', '没有找到数据'); ?>.</span></td></tr>
        <?php endif; ?>
      </table>
      <?php //$this->endWidget(); ?>
  </div>

</div>

