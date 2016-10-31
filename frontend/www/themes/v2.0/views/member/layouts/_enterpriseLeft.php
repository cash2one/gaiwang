<div class="member-sidebar">          
        <div class="decoration"></div>
        <ul class="sidebar-main">
          <li>
            <i class="member-icon listmark"></i><?php echo Yii::t('memberWealth', '企业管理') ?>
            <div class="sublist">
            
              <?php if(($this->getSession('enterpriseId') && $this->getSession('enterpriseFlag')!=Enterprise::FLAG_OFFLINE  )):?>
                  <?php $cla='';if($this->id=='enterpriseLog'):$cla='active';endif;?>
                  <?php echo CHtml::link('网络店铺签约', $this->createAbsoluteUrl('enterpriseLog/process'),array('class'=>$cla)) ?> 
              <?php endif;?>
              
              <?php foreach ($this->getMenu('qyv20') as $v): 
                       $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					   echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
               endforeach; ?>
            </div>
          </li>   
          <li>
            <i class="member-icon listmark"></i><?php echo Yii::t('memberWealth', '企业信息') ?>
            <div class="sublist">
              <a href="<?php echo $this->createAbsoluteUrl('enterprise/index');?>" <?php if($this->action->id=='index'):?>class="active"<?php endif;?>><?php echo Yii::t('memberWealth', '企业基本信息') ?></a>
            </div>
          </li>
                   
          <li>
            <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>" class="go-enterprise-manage"><?php echo Yii::t('memberWealth', '返回我的盖网') ?></a>
          </li>
        </ul>
      </div> 