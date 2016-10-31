<?php
// 底部
/* @var $this Controller */

$links = WebAdData::getLinkData(); //调用接口
$helpInfo = WebAdData::getHelpData(); //调用接口
?>
<!-- 底部start -->
<div class="gx-bottom">
    <div class="gx-bottom-slogan">
        <dl class="gx-bottom-dl clearfix">
            <dt><?php echo Yii::t('site','多'); ?></dt>
            <dd>
                <span><?php echo Yii::t('site','更多'); ?></span><?php echo Yii::t('site','品质齐全'); ?>
            </dd>
            <dt><?php echo Yii::t('site','快'); ?></dt>
            <dd>
                <span><?php echo Yii::t('site','更快'); ?></span><?php echo Yii::t('site','快速配送'); ?>
            </dd>
            <dt><?php echo Yii::t('site','好'); ?></dt>
            <dd>
                <span><?php echo Yii::t('site','更好'); ?></span><?php echo Yii::t('site','汇聚品牌'); ?>
            </dd>
            <dt><?php echo Yii::t('site','省'); ?></dt>
            <dd>
                <span><?php echo Yii::t('site','更省'); ?></span><?php echo Yii::t('site','天天优惠'); ?>
            </dd>
            <dt class="last-dt">24</dt>
            <dd>
                <span class="gx-bot-font1"><?php echo Tool::getConfig('site', 'phone') ?></span>
                <span class="gx-bot-font2"><?php echo Yii::t('site','24小时服务'); ?></span>
            </dd>
        </dl>
        <div class="gx-bottom-info clearfix">
            <?php foreach($helpInfo as $k=>$v): ?>
              <?php if($k<5):?>
            <dl>
                <dt><?php echo $v['name'] ?></dt>
                <?php
                   foreach($v['child'] as $k2=>$v2){
                       echo  '<dd>',CHtml::link(Yii::t('help',$v2['title']),array('/help/article/view','alias'=>$v2['alias'])),'</dd>';
                       if($k2>1) break;
                   }
                ?>
            </dl>
            <?php endif;?>
            <?php endforeach; ?>
            <div class="gateWeixin2">
                <img width="90" height="90" src="http://att.e-gatenet.cn/QRCode/62558ea6853f53e1ba4d5e8b33ba2efd.png" alt="http://weixin.qq.com/r/j0gpMaHEfvwBreVS9x2d">
                <?php
//                $this->widget('comext.QRCodeGenerator', array(
//                    'data' => 'http://weixin.qq.com/r/j0gpMaHEfvwBreVS9x2d',
//                    'size' => 3.6,
//                    'imageTagOptions'=>array('width'=>90,'height'=>90),
//                ));
                ?>
                <p><?php echo Yii::t('site','关注微信公众号'); ?></p>
            </div>

        </div>
    </div>
    <div class="gx-bottom-link">
        <div class="gx-bottom-link-main">           
            <div class="gx-bottom-link-item">
                <?php echo CHtml::link(Yii::t('site', 'app下载'), $this->createAbsoluteUrl('/gwkey')); ?> |
                <?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about')); ?> |
                <?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help')); ?>  |
                <?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap')); ?>  |
                <?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job')); ?>  |
                <?php echo CHtml::link(Yii::t('site', '友情链接'), $this->createAbsoluteUrl('/link')); ?> |
                <?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact')); ?>  |
                <?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement')); ?> |
                <?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy')); ?> |
                <?php //echo CHtml::link(Yii::t('site', '家长监护'), $this->createAbsoluteUrl('/yaopin/site/gameSupervise.html')),'|'; ?>
                <?php
                //访问统计脚本
                echo  Tool::getConfig('site', 'statisticsScript');
                ?>
            <div class="bottom-link">
			<?php
					$flag = false;
					$https = Controller::getHttpsModule();
					foreach($https as $key => $value){
						if($key != 'noModule'){
							if (isset($this->module->id) && $this->module->id != $key ){
								$flag = true;
								break;
							}
						}
					}
			?>
            </div>
                <?php if($flag || (!isset($this->module->id) && $_SERVER['REQUEST_URI']=='/')): ?>
                    <div class="bottom-link">
                        <?php echo Tool::getConfig('site', 'copyright'); ?>
                    </div>
                <?php else: ?>
                    <div class="bottom-link">
                        Copyright©g-emall.com &nbsp;&nbsp;
                        珠海横琴新区盖网通传媒有限公司 &nbsp;&nbsp;
                        增值电信业务经营许可证：<a>粤B2-20140364 </a>
                        <a href="http://www.miitbeian.gov.cn/state/outPortal/loginPortal.action" target="_blank"> 粤ICP备14049968号-2</a>
                        <a href="http://att.e-gatenet.cn/UE_uploads/2015/04/28/14301999255090.jpg" target="_blank"> 互联网药品信息服务资格证</a>
                        <a href="http://att.e-gatenet.cn/UE_uploads/2015/04/28/14301999306973.jpg" target="_blank"> 网络文化经营许可证</a>
                        <a href='http://www.gzjd.gov.cn/wlaqjc/open/validateSite.do' target="_blank">穗公网监备案证第44070050010060号</a>
                    </div>

                <?php endif; ?>
        </div>
    </div>
</div>
