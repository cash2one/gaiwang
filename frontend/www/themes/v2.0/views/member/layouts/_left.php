<?php
$curr = $this->id . '/' . $this->action->id;
?>
<div class="member-sidebar">
        <div class="decoration"></div>
        <ul class="sidebar-main">
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','订单中心');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('center') as $v): 
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','售后服务');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('afterSales') as $v): 
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','资产中心');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('assets') as $v):
					    if($v['url']=='giveCash/index' && substr($this->getUser()->gw,0,4)!='GW03'){
                            continue; //只有gw03 的用户，可以使用派发红包的功能
                        }
                        if($v['url']=='memberCash/cashList' &&  (int)AccountBalance::getMemberBalance($this->getUser()->id) == 0){
                            continue; //存在提现账户时显示
                        }
                          if($v['url']=='memberCash/applyCash' &&  (int)AccountBalance::getMemberBalance($this->getUser()->id) == 0){
                            continue; //存在提现账户时显示
                        }
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','特色服务');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('specialised') as $v): 
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','设置');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('setup') as $v): 
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <li>
                <i class="member-icon listmark"></i><?php echo Yii::t('member','安全中心');?>
                <div class="sublist">
                    <?php foreach ($this->getMenu('security') as $v): 
					    $class = in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'active' : '';
					    echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']), array('class'=>$class));
                   endforeach; ?>
                </div>
            </li>
            <?php if ($this->getSession('enterpriseId')):?>
            <?php if($this->getSession('enterpriseFlag')!=Enterprise::FLAG_OFFLINE  ):?>
            <li id="toEnterprise">
              <a href="<?php echo $this->createAbsoluteUrl('/member/enterpriseLog/process');?>" class="go-enterprise-manage"><?php echo Yii::t('member','进入企业管理');?></a>
            </li>
            <?php else:?>
            <li>
              <a href="<?php echo $this->createAbsoluteUrl('/member/enterprise/index');?>" class="go-enterprise-manage"><?php echo Yii::t('member','进入企业管理');?></a>
            </li id="toEnterprise">
            <?php endif;?>
            <?php endif; ?>
        </ul>
    </div>
<?php
/** @var $this Controller */
$tips = $this->getCookie('toTips');
$tips = $tips ? $tips : 0;
if($this->getUser()->getState('enterpriseId') && $tips<=0 && time() < 1450540800):
    $this->setCookie('toTips',1+$tips,3600*24*10);
?>
    <!--操作提示start-->
    <div id="guide-tip" class="mask-bg" >
        <div class="guide-tip" style="top:680px;">
            <a href="javascript:void(0)" class="operation-btn">知道了</a>
        </div>
    </div>
    <!--操作提示end-->
    <script>
        //操作提示随着滚动条滚动
        var scrollTop=0;
        var originalTop=$(".guide-tip").position().top;
        window.onscroll=function(){
            if(document.documentElement&&document.documentElement.scrollTop){                    scrollTop=document.documentElement.scrollTop;
            }else if(document.body){
                scrollTop=document.body.scrollTop;
            }
            $(".guide-tip").css("top",originalTop-scrollTop);
        };
        //关闭操作提示
        $(".guide-tip .operation-btn").click(function(){
            $("#guide-tip").hide();
        });
    </script>
<?php endif; ?>